<?php
	$apiCode=$_POST["apiCode"];
	$language=$_POST["language"];
	$maBarcode=$_POST["maBarcode"];

	if($apiCode!="makingtableupdate"){$json["resultMessage"]="API(apiCode) ERROR";$apiCode="makingtableupdate";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="API(language) ERROR";}
	else if($maBarcode==""){$json["resultMessage"]="API(maBarcode) ERROR";}
	else
	{
		$sql ="update ".$dbH."_making set ma_modify=sysdate, ma_table=NULL, ma_tablestat=NULL  where ma_barcode = '".$maBarcode."'";
		dbcommit($sql);

		//$json["sql"]=$sql;
		$json["apiCode"]=$apiCode;
		$json["resultCode"]="200";
		$json["resultMessage"]="OK";
	}
?>