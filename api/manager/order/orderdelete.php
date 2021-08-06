<?php
	$apicode=$_GET["apiCode"];
	$language=$_GET["language"];
	$od_seq=$_GET["seq"];
	if($apicode!="orderdelete"){$json["resultMessage"]="API(apiCode) ERROR";$apicode="orderdelete";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="API(language) ERROR";}
	else if($od_seq==""){$json["resultMessage"]="API(seq) ERROR";}
	else{
		$sql=" update ".$dbH."_order set od_use='D' where od_seq='".$od_seq."'";
		dbcommit($sql);
		$returnData=$_GET["returnData"];
		$json=array("apiCode"=>$apicode,"returnData"=>$returnData,"seq"=>$od_seq); //delete에서는 seq를 보내줘야 page의 값이 1이 아닌 해당하는 page로 나온다.
		$json["sql"]=$sql;
		$json["resultCode"]="200";
		$json["resultMessage"]="OK";
	}
?>