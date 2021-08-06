<?php
	$apicode=$_GET["apiCode"];
	$language=$_GET["language"];
	$rb_seq=$_GET["seq"];
	if($apicode!="resourcebookdelete"){$json["resultMessage"]="API(apiCode) ERROR";$apicode="resourcebookdelete";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="API(language) ERROR";}
	else if($rb_seq==""){$json["resultMessage"]="API(seq) ERROR";}
	else{
		$sql=" update ".$dbH."_recipebook set rb_use='D' where rb_seq='".$rb_seq."'";
		dbqry($sql);
		$returnData=$_GET["returnData"];
		$json=array("apiCode"=>$apicode,"returnData"=>$returnData);
		$json["resultCode"]="200";
		$json["resultMessage"]="OK";
	}
?>