<?php  
	///인증확인하기
	$apiCode=$_POST["apiCode"];
	$language=$_POST["language"];
	//$me_loginid=$_POST["me_loginid"];
	$key=$_POST["postdata"];

	if($apiCode!="sendchk"){$json["resultMessage"]="API(apiCode) ERROR";$apiCode="sendchk";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="API(language) ERROR";}
	//else if($dm_seq==""){$json["resultMessage"]="API(seq) ERROR";}
	else
	{

		$key=explode("_",$key);  //0SXWMJH5H6BWC6L5WTQC_djmedi123
		//$key[0];  //0SXWMJH5H6BWC6L5WTQC
		//$key[1];  //djmedi123

		$returnData=$_POST["returnData"];
		

		include_once $root.$folder."/mailer/oracleDB.php";

		$sql=" select me_confirm from han_member where me_loginid = '".$key[1]."' ";
		$dt=dbone($sql);

		$json=array("apiCode"=>$apiCode,"meLoginid"=>$key[1],"me_confirm"=>$key[0],"sql"=>$sql);

		//$endata = djDecrypt($dt["ME_CONFIRM"], $authkey);

		if($dt["ME_CONFIRM"]==$key[0])
		{
			$json["resultCode"]="200";
			$json["key"]=$key;
			$json["sql"]=$sql;
		}
		else
		{
			$json["resultCode"]="204";
		}
		$json["resultMessage"]="OK";


		$json["POST"]=$_POST;

	}
?>

