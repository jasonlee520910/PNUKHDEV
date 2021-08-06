<?php
	$apicode=$_POST["apiCode"];
	$language=$_POST["language"];
	$mg_command=$_POST["command"];
	$mg_tableno=$_POST["tableno"];
	$mg_status=$_POST["status"];

	if($apicode!="logtest"){$json["resultMessage"]="API(apiCode) ERROR";$apicode="logtest";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="API(language) ERROR";}
	else if($mg_command==""){$json["resultMessage"]="API(command) ERROR";}
	else if($mg_tableno==""){$json["resultMessage"]="API(tableno) ERROR";}
	else if($mg_status==""){$json["resultMessage"]="API(status) ERROR";}
	else{
		$returnData=$_POST["returnData"];
		$mg_statustext=$_POST["text"];
		
		//han_code에서 maTableLog 데이터 가져온후 언어별로 저장 
		if($mg_command == '999') //에러일경우 
			$code = $mg_command;
		else
			$code = sprintf("%03d",$mg_command).$mg_status; //001start

		$sql=" select cd_name_".$language." as cd_name from ".$dbH."_code where cd_type = 'maTableLog' and cd_code='".$code."' ";
		$dt=dbone($sql);
		$mt_logstatus=$dt["CD_NAME"];

		if($mt_logstatus)
		{
			$sql=" insert into ".$dbH."_makinglog (mg_command,mg_tableno,mg_status,mg_statustext,mg_date) values ('".$mg_command."','".$mg_tableno."','".$mg_status."', '".json_encode($mg_statustext)."', sysdate); ";
			dbcommit($sql);

			$sql="update ".$dbH."_makingtable set mt_logstatus = '".$mt_logstatus."', mt_logstaustext = '".json_encode($mg_statustext)."' where mt_code = '".$mg_tableno."' ";
			dbcommit($sql);
		}

		//개발서버에 이중저장
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, "http://api.djmedi.kr/making/");
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
		//makejson
		//$jsondata=json_encode($_POST);
		$_POST["apiCode"]="log";
		$jsondata=$_POST;
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
		curl_setopt($ch, CURLOPT_POSTFIELDS, $jsondata);
		curl_setopt($ch, CURLOPT_HEADER, false);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array(
			//'Content-Type:application/json','Accept:application/json'
		));
		$result = curl_exec($ch);							
		curl_close($ch);
		//개발서버에 이중저장

		$json=array("apiCode"=>$apicode,"returnData"=>$returnData,"command"=>$mg_command,"tableno"=>$mg_tableno,"status"=>$mg_status,"text"=>json_encode($mg_statustext),"logstatus"=>$mt_logstatus);
		$json["curl"]=$result;
		$json["resultCode"]="200";
		$json["resultMessage"]="OK";

	}
?>