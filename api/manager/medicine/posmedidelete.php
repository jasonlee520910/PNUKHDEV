<?php //독성알람 삭제
	//GET
	$apicode=$_GET["apiCode"];
	$language=$_GET["language"];
	$po_seq=$_GET["seq"];

	if($apicode!="posmedidelete"){$json["resultMessage"]="API(apiCode) ERROR";$apicode="posmedidelete";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="API(language) ERROR";}
	else if($po_seq==""){$json["resultMessage"]="API(seq) ERROR";}
	else{
		$sql=" update ".$dbH."_medi_poison set po_use='D' where po_seq='".$po_seq."'";
		dbqry($sql);
		$returnData=$_GET["returnData"];
		$json=array("apiCode"=>$apicode,"returnData"=>$returnData);
		$json["resultCode"]="200";
		$json["resultMessage"]="OK";
	}
?>