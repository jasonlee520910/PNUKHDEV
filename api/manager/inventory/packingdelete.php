<?php  
	/// 자재코드관리 > 포장재관리 > 삭제
	$apicode=$_GET["apiCode"];
	$language=$_GET["language"];
	$pb_seq=$_GET["seq"];

	if($apicode!="packingdelete"){$json["resultMessage"]="API(apiCode) ERROR";$apicode="packingdelete";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="API(language) ERROR";}
	else if($pb_seq==""){$json["resultMessage"]="API(seq) ERROR";}
	else
	{
		$sql=" update ".$dbH."_packingbox set pb_use='D' where pb_seq='".$pb_seq."'";
		dbcommit($sql);

		$returnData=$_GET["returnData"];
		$json=array("apiCode"=>$apicode,"returnData"=>$returnData);
		$json["resultCode"]="200";
		$json["resultMessage"]="OK";
	}
?>