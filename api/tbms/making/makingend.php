<?php
	$apiCode=$_GET["apiCode"];
	$language=$_GET["language"];
	$odCode=$_GET["odCode"];

	if($apiCode!="makingend"){$json["resultMessage"]="API(apiCode) ERROR";$apiCode="makingend";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="API(language) ERROR";}
	else if($odCode==""){$json["resultMessage"]="API(odCode) ERROR";}
	else
	{	
		$json["apiCode"] = $apiCode;

		//조제 시작할때 시간  update
		$sql ="update ".$dbH."_making set ma_end=sysdate where ma_odcode = '".$odCode."'";
		dbcommit($sql);

		$json["sql"]=$sql;
		$json["apiCode"]=$apiCode;
		$json["resultCode"]="200";
		$json["resultMessage"]="OK";

	}
?>