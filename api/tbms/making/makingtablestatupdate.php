<?php
	$apiCode=$_GET["apiCode"];
	$language=$_GET["language"];
	$odCode=$_GET["odCode"];

	if($apiCode!="makingtablestatupdate"){$json["resultMessage"]="API(apiCode) ERROR";$apiCode="makingtablestatupdate";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="API(language) ERROR";}
	else if($odCode==""){$json["resultMessage"]="API(odCode) ERROR";}
	else
	{
		$sql ="update ".$dbH."_making set ma_modify=sysdate, ma_tablestat=NULL  where ma_odcode = '".$odCode."'";
		dbcommit($sql);

		$json["sql"]=$sql;
		$json["apiCode"]=$apiCode;
		$json["resultCode"]="200";
		$json["resultMessage"]="OK";
	}
?>