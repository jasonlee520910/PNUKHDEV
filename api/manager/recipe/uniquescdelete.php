<?php
	$apicode=$_GET["apiCode"];
	$language=$_GET["language"];
	$rc_seq=$_GET["seq"];
	if($apicode!="uniquescdelete"){$json["resultMessage"]="API(apiCode) ERROR";$apicode="uniquescdelete";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="API(language) ERROR";}
	else if($rc_seq==""){$json["resultMessage"]="API(seq) ERROR";}
	else{
		$sql=" update ".$dbH."_recipemember set rc_use='D' where rc_seq='".$rc_seq."'";
		dbqry($sql);
		$returnData=$_GET["returnData"];
		$json=array("apiCode"=>$apicode,"returnData"=>$returnData);
		$json["resultCode"]="200";
		$json["resultMessage"]="OK";
	}
?>