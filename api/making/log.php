<?php
	$apicode=$resjson["apiCode"];
	$language=$resjson["language"];
	$mg_command=$resjson["command"];
	$mg_tableno=$resjson["tableno"];
	$mg_status=$resjson["status"];

	if($apicode!="log"){$json["resultMessage"]="API(apiCode) ERROR";$apicode="log";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="API(language) ERROR";}
	else if($mg_command==""){$json["resultMessage"]="API(command) ERROR";}
	else if($mg_tableno==""){$json["resultMessage"]="API(tableno) ERROR";}
	else if($mg_status==""){$json["resultMessage"]="API(status) ERROR";}
	else{
		$returnData=$resjson["returnData"];
		$mg_statustext=$resjson["text"];
		
		//han_code에서 maTableLog 데이터 가져온후 언어별로 저장 
		if($mg_command == '999') //에러일경우 
			$code = $mg_command;
		else
			$code = sprintf("%03d",$mg_command).$mg_status; //001start

		$sql=" select cd_name_".$language." as cd_name from ".$dbH."_code where cd_type = 'maTableLog' and cd_code='".$code."' ";
		$dt=dbone($sql);
		$mt_logstatus=$dt["CD_NAME"];


		$jsonclob=json_encode($mg_statustext);
		$mt_logstaustext=insertClob($jsonclob);

		if($mt_logstatus)
		{
			 if($mg_command=="004" &&  $mg_status=="end"){
				// end 로그 인서트 전 업데이트   004 일때 이전 텍스트 로그사용안함으로
				$sql=" update ".$dbH."_makinglog set mg_use = 'N' where mg_command='004' and mg_use='Y' and mg_status='end' and mg_tableno = '".$mg_tableno."'";
				dbcommit($sql);
			 }

			if(($mg_command=="004" &&  $mg_status=="start") || ($mg_command=="004" &&  $mg_status=="end"))
			{
				$sql=" update ".$dbH."_makingtable set mt_making='Y',  mt_makingtable = null where mt_code = '".$mg_tableno."' ";
				dbcommit($sql);
			}

			$sql=" insert into ".$dbH."_makinglog (MG_SEQ, mg_command,mg_tableno,mg_status,mg_statustext,mg_date) values ((SELECT NVL(MAX(MG_SEQ),0)+1 FROM ".$dbH."_makinglog),'".$mg_command."','".$mg_tableno."','".$mg_status."', ".$mt_logstaustext.", sysdate) ";
			dbcommit($sql);
			$isql=$sql;

			//기존소스 
			$sql="update ".$dbH."_makingtable set mt_logstatus = '".$mt_logstatus."', mt_logstaustext = ".$mt_logstaustext." where mt_code = '".$mg_tableno."' ";
			//20191105 : scan.php에서 log.php로 이동 mt_making='Y',  mt_makingtable = null, 추가 
			//$sql="update ".$dbH."_makingtable set mt_making='Y',  mt_makingtable = null, mt_logstatus = '".$mt_logstatus."', mt_logstaustext = '".json_encode($mg_statustext)."' where mt_code = '".$mg_tableno."' ";
			dbcommit($sql);

		}

		$json=array("apiCode"=>$apicode,"returnData"=>$returnData,"command"=>$mg_command,"tableno"=>$mg_tableno,"status"=>$mg_status,"text"=>json_encode($mg_statustext),"logstatus"=>$mt_logstatus);
		$json["resultCode"]="200";
		$json["resultMessage"]="OK";
		$json["isql"]=$isql;

	}
?>
