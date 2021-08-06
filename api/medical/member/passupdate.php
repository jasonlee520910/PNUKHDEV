<?php ///비번변경
	$apiCode=$_POST["apiCode"];
	$language=$_POST["language"];

	if($apiCode!="passupdate"){$json["resultMessage"]="API코드오류2";$apiCode="passupdate";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="언어코드오류";}
	else
	{
		$newpass=$_POST["newpass"];
		$medicalId=$_POST["medicalId"];  //회사
		$meUserId=$_POST["meUserId"]; //한의사

		///의료기관정보수정			
		$sql=" update ".$dbH."_member set  me_passwd='".$newpass."' ,me_modify=sysdate ";
		$sql.=" where me_userid='".$meUserId."' and me_company='".$medicalId."' ";
		dbcommit($sql);


///&newpass=!!uu123123&renewpass=!!uu123123&medicalId=0583054228&doctorId=6220187474&medicalid=0583054228&meUserId=6220187474

		$json["sql"]=$sql;	
		$json["apiCode"]=$apiCode;
		$json["resultCode"]="200";
		$json["resultMessage"]="OK";		
	}
?>