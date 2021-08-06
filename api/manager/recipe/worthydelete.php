<?php
	$apicode=$_GET["apiCode"];
	$language=$_GET["language"];
	$rc_seq=$_GET["seq"];

	if($apicode!="worthydelete"){$json["resultMessage"]="API(apiCode) ERROR";$apicode="worthydelete";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="API(language) ERROR";}
	else if($rc_seq==""){$json["resultMessage"]="API(seq) ERROR";}
	else
	{
		$sql=" update ".$dbH."_recipemedical set rc_use='D' where rc_seq='".$rc_seq."'";
		dbcommit($sql);
		$returnData=$_GET["returnData"];
		$json=array("apiCode"=>$apicode,"returnData"=>$returnData);
		$json["resultCode"]="200";
		$json["resultMessage"]="OK";
	}
?>