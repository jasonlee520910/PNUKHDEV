<?php ///한의원 탈퇴(medical) && 한의사탈퇴(member)
	$apiCode=$_GET["apiCode"];
	$language=$_GET["language"];
	$medicalId=$_GET["medicalid"]; ///mi_userid &  me_company

	if($apiCode!="dowithdraw"){$json["resultMessage"]="API(apiCode) ERROR2";$apiCode="dowithdraw";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="API(language) ERROR";}
	else
	{
		$metype=$_GET["metype"];
		$meuserid=$_GET["meuserid"];
		
		if($metype=="medical")
		{
			$sql=" update ".$dbH."_medical set mi_status='delete',mi_use='D', mi_secession=sysdate ";
			$sql.=" where mi_userid='".$medicalId."' ";		
		}
		else if($metype=="member")
		{	
			$sql=" update ".$dbH."_member set me_status='delete',me_use='D', me_secession=sysdate ";
			$sql.=" where me_company='".$medicalId."' and me_loginid ='".$meuserid."' ";		
		}

		 dbcommit($sql);

		$json=array("apiCode"=>$apiCode);
		$json["sql"]=$sql;
		$json["resultCode"]="200";
		$json["resultMessage"]="OK";		
	}
?>
