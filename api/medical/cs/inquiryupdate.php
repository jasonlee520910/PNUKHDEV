<?php  
	///환자관리> 환자등록
	$apiCode=$_POST["apiCode"];
	$language=$_POST["language"];
	$seq=$_POST["seq"];

	if($apiCode!="inquiryupdate"){$json["resultMessage"]="API(apiCode) ERROR";$apiCode="inquiryupdate";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="API(language) ERROR";}
	else
	{

		$medicalid=$_POST["medicalId"]; 
		$cstitle=$_POST["cstitle"]; //제목
		$cscontent=insertClob($_POST["cscontent"]); //내용
		$bb_type=$_POST["bbtype"]; //문의유형
	
		
		if($seq)
		{		
			$sql=" update ".$dbH."_board set bb_title ='".$cstitle."',bb_desc =".$cscontent.",bb_type ='".$bb_type."', bb_modify=SYSDATE where bb_seq='".$seq."'";
			//echo $sql;
			dbcommit($sql);		
			

		}
		else  ///신규입력
		{
			$sql2=" insert into ".$dbH."_board (bb_seq,bb_code,bb_userid,bb_title,bb_desc,bb_type,bb_indate,bb_modify) ";
			$sql2.=" values ((SELECT NVL(MAX(bb_seq),0)+1 FROM ".$dbH."_board) ";
			$sql2.=",'QNA','".$medicalid."','".$cstitle."',".$cscontent.",'".$bb_type."',SYSDATE, SYSDATE) ";
			dbcommit($sql2);
			//echo $sql2;
		}
			$returnData=$_POST["returnData"];
			$json=array("apiCode"=>$apiCode,"seq"=>$seq,"returnData"=>$returnData);
			$json["sql"]=$sql;			
			$json["sql2"]=$sql2;
			$json["resultCode"]="200";
			$json["resultMessage"]="OK";
	}

?>
