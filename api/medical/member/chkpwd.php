<?php ///내정보 수정시 비밀번호 확인
	$apiCode=$_GET["apiCode"];
	$language=$_GET["language"];
	$medicalid=$_GET["medicalid"];
	$meUserId=$_GET["meUserId"];
	$addpasswordDiv=$_GET["addpasswordDiv"];

	$passtype=$_GET["passtype"];

	if($apiCode!="chkpwd"){$json["resultMessage"]="API(apiCode) ERROR2";$apiCode="chkpwd";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="API(language) ERROR";}
	else
	{

		$returnData=$_GET["returnData"];
		$json=array("apiCode"=>$apiCode,"returnData"=>$returnData);
		
		$wsql=" where me_userid = '".$meUserId."' ";
		$sql=" select me_seq, me_passwd from ".$dbH."_member  $wsql ";
		
		$dt=dbone($sql);

		$json=array("apiCode"=>$apiCode,"seq"=>$dt["ME_SEQ"],"ME_PASSWD"=>$dt["ME_PASSWD"],"addpasswordDiv"=>$addpasswordDiv);
		if($dt["ME_PASSWD"]==$addpasswordDiv)
		{
			$json["resultCode"]="204"; ///사용가능함
		}
		else
		{
			
			$json["resultCode"]="200"; ///사용불가능
		}

		$json["sql"]=$sql;
		$json["apiCode"]=$apiCode;
		$json["passtype"]=$passtype;
	}
?>