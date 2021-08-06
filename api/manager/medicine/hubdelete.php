<?php  
	///약재관리 > 본초관리 > 본초 삭제
	$apiCode=$_GET["apiCode"];
	$language=$_GET["language"];
	$mh_seq=$_GET["seq"];

	if($apiCode!="hubdelete"){$json["resultMessage"]="API(apiCode) ERROR";$apiCode="hubdelete";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="API(language) ERROR";}
	else if($mh_seq==""){$json["resultMessage"]="API(seq) ERROR";}
	else
	{
		$sql=" update ".$dbH."_medihub set mh_use='D' where mh_seq='".$mh_seq."'";
		dbcommit($sql);
		$returnData=urldecode($_GET["returnData"]);
		$json=array("apiCode"=>$apiCode,"returnData"=>$returnData, "sql"=>$sql);
		$json["resultCode"]="200";
		$json["resultMessage"]="OK";
	}
?>