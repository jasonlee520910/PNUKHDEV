<?php 
	$apiCode=$_GET["apiCode"];
	$language=$_GET["language"];
	$ordercode=$_GET["ordercode"];
	$type=$_GET["type"];

	if($apiCode!="scalemodeupdate"){$json["resultMessage"]="API(apiCode) ERROR";$apiCode="scalemodeupdate";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="API(language) ERROR";}
	else
	{
		
		$sql=" update ".$dbH."_making set MA_SCALEMODE='".$type."' where ma_odcode='".$ordercode."' ";
		dbcommit($sql);

		$json["mode"]=$type;
		$json["sql"]=$sql;
		$json["apiCode"]=$apiCode;
		$json["resultCode"]="200";
		$json["resultMessage"]="OK";
	}
?>