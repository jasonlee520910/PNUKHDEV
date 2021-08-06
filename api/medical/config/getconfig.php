<?php
	$apiCode=$_GET["apiCode"];
	$language=$_GET["language"];

	if($apiCode!="getconfig"){$json["resultMessage"]="API(apiCode) ERROR";$apiCode="getconfig";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="API(language) ERROR";}
	else
	{

		$returnData=$_GET["returnData"];

		$config=getConfigInfo();///공통으로 쓰이는 데이터들 (가격)
		$json["data"]=$config;
		$json["sql"]=$sql;
		$json["apiCode"]=$apiCode;
		$json["returnData"]=$returnData;
		$json["resultCode"]="200";
		$json["resultMessage"]="OK";
	}
?>
