<?php ///회원가입 
	$apiCode=$_POST["apiCode"];
	$language=$_POST["language"];
	$medicalId=$_POST["medicalid"]; ///mi_userid &  me_company

	if($apiCode!="addmemberupdate"){$json["resultMessage"]="API코드오류2";$apiCode="addmemberupdate";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="언어코드오류";}
	else
	{
		/* 한의사 정보 */

		
		$me_userId=$_POST["meUserId"]; ///한의사 아이디(개인)

		$me_name=$_POST["stName"]; ///한의사 이름
		$me_mobile=$_POST["stMobile0"]."-".$_POST["stMobile1"]."-".$_POST["stMobile2"]; ///한의사 폰번호
		$me_email=$_POST["stEmail0"]."@".$_POST["stEmail1"]; ///한의사 email
		$me_registno=$_POST["licenseno"]; ///한의사 면허번호
		$meIsemail=$_POST["meIsemail"]; ///한의사 이메일수신여부



		///내정보수정
		$sql=" update ".$dbH."_member set me_name='".$me_name."' ";
		$sql.=" ,me_registno='".$me_registno."' ";
		$sql.=" ,me_mobile='".$me_mobile."' ";
		$sql.=" ,me_isemail='".$meIsemail."' ";	
		$sql.=" ,me_email='".$me_email."', me_modify=sysdate ";
		$sql.=" where me_userId='".$me_userId."' ";
		//echo $sql;
		dbcommit($sql);
		
		

		$json["sql"]=$sql;
		$json["resultCode"]="200";
		$json["resultMessage"]="OK";		
	}
?>