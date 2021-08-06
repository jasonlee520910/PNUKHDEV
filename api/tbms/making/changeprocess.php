<?php
	$apiCode=$_GET["apiCode"];
	$language=$_GET["language"];
	
	$stat=$_GET["stat"];
	$proc=$_GET["proc"];
	$code=$_GET["code"];
	$returnData=$_GET["returnData"];
	$medi=$_GET["medi"];
	
	if($apiCode!="changeprocess"){$json["resultMessage"]="API(apiCode) ERROR";$apiCode="changeprocess";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="API(language) ERROR";}
	else if($code==""){$json["resultMessage"]="API(code) ERROR";}
	else
	{
		$chkstat=explode("_",$stat);

		$sql=" update ".$dbH."_making set ma_status='".$stat."' where ma_odcode='".$code."' ";
		$json["making"] = $sql;
		dbcommit($sql);

		$sql=" update ".$dbH."_order set od_status='".$stat."' where od_code='".$code."' ";		
		$json["order"] = $sql;
		dbcommit($sql);
		
		$json["apiCode"] = $apiCode;
		$json["returnData"] = $returnData;
		$json["resultCode"]="200";
		$json["resultMessage"]="OK";
	}
?>