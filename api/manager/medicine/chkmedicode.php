<?php //약재코드 중복 체크
	//GET
	$apiCode=$_GET["apiCode"];
	$language=$_GET["language"];
	$code=$_GET["mdCode"];

	if($apiCode!="chkmedicode"){$json["resultMessage"]="API(apiCode) ERROR";$apiCode="chkmedicode";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="API(language) ERROR";}
	else if($code==""){$json["resultMessage"]="API(code) ERROR";}
	else
	{
		$sql="select md_code from han_medicine where md_code = '".$code."';";
		$dt=dbone($sql);

		$json["sql"]=$sql;
		if($dt["md_code"])
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