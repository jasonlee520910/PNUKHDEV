<?php //상극알람 삭제
	//GET
	$apicode=$_GET["apiCode"];
	$language=$_GET["language"];
	$dm_seq=$_GET["seq"];

	if($apicode!="dismedidelete"){$json["resultMessage"]="API(apiCode) ERROR";$apicode="dismedidelete";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="API(language) ERROR";}
	else if($dm_seq==""){$json["resultMessage"]="API(seq) ERROR";}
	else{
		$sql=" update ".$dbH."_medi_dismatch set dm_use='D' where dm_seq='".$dm_seq."'";
		dbcommit($sql);	
		$returnData=$_GET["returnData"];
		$json=array("apiCode"=>$apicode,"returnData"=>$returnData,"seq"=>$dm_seq);
		$json["resultCode"]="200";
		$json["resultMessage"]="OK";
	}
?>