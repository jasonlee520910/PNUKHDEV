<?php //본초코드 중복 체크
	//GET
	$apiCode=$_GET["apiCode"];
	$language=$_GET["language"];
	$code=$_GET["mhCode"];

	if($apiCode!="chkhubcode"){$json["resultMessage"]="API(apiCode) ERROR";$apiCode="chkhubcode";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="API(language) ERROR";}
	else if($code==""){$json["resultMessage"]="API(code) ERROR";}
	else
	{
		$sql="select mh_code from han_medihub where mh_code = '".$code."';";
		$dt=dbone($sql);

		$json["sql"]=$sql;
		if($dt["mh_code"])
		{
			$json["apiCode"]=$apiCode;
			$json["resultCode"]="999";
			$json["resultMessage"]="OK";
		}
		else
		{
			$json["apiCode"]=$apiCode;
			$json["resultCode"]="200";
			$json["resultMessage"]="OK";
		}

	}
?>