<?php
	$apiCode=$_GET["apiCode"];
	$language=$_GET["language"];
	$odCode=$_GET["odCode"];

	if($apiCode!="makingcancel"){$json["resultMessage"]="API(apiCode) ERROR";$apiCode="makingcancel";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="API(language) ERROR";}
	else if($odCode==""){$json["resultMessage"]="API(odCode) ERROR";}
	else
	{
		//20190415 od_status='making_apply' 추가 
		$sql=" update ".$dbH."_order set od_status = 'making_apply' where od_code='".$odCode."' ";
		dbcommit($sql);

		//20190158 ma_status='making_apply' 추가 
		$sql=" update ".$dbH."_making set ma_table = null, ma_tablestat = null, ma_status='making_apply' where ma_odcode='".$odCode."' ";
		dbcommit($sql);

		$json["sql"]=$sql;
		$json["apiCode"]=$apiCode;
		$json["resultCode"]="200";
		$json["resultMessage"]="OK";
	}
?>