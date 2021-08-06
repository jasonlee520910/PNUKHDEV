<?php //대표한의사가 소속한의사 요청
	$apiCode=$_POST["apiCode"];
	$language=$_POST["language"];
	$medicalId=$_POST["medicalid"]; ///mi_userid &  me_company

	if($apiCode!="invitedoctorupdate"){$json["resultMessage"]="API코드오류2";$apiCode="invitedoctorupdate";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="언어코드오류";}
	else
	{
		$me_registno=$_POST["meRegistno"];
		$me_name=trim($_POST["meName"]);
		$medicalId=$_POST["medicalid"];

		$sql3=" select me_seq from ".$dbH."_member where me_company='".$medicalId."' and me_registno='".$me_registno."'  and me_name='".$me_name."'  and me_use='Y' and me_status='approve' ";
		$dt3=dbone($sql3);

		if(isEmpty($dt3["ME_SEQ"])==true)
		{
		
			///내정보수정
			$sql=" update ".$dbH."_member set me_company='".$medicalId."'";
			$sql.=",me_status='request' ,me_modify=sysdate ";
			$sql.=" where me_registno='".$me_registno."' and me_name='".$me_name."' and me_use='Y' ";
			dbcommit($sql);		
			$json["resultCode"]="200"; ///사용가능함
		}
		else
		{		
			$json["resultCode"]="204"; ///사용불가능
		}


		$sql2=" select me_seq from ".$dbH."_member where me_company='".$medicalId."' and me_registno='".$me_registno."'  and me_name='".$me_name."'  and me_use='Y' and me_status='request' ";
		$dt=dbone($sql2);

		if($dt["ME_SEQ"])
		{
			$json["resultCode"]="200"; ///사용가능함
		}
		else
		{		
			$json["resultCode"]="204"; ///사용불가능
		}

		$json["sql"]=$sql;
		$json["sql2"]=$sql2;
		$json["sql3"]=$sql3;
		
		$json["resultMessage"]="OK";
		$json["apiCode"]=$apiCode;
	}
?>