<?php  
	/// 자재코드관리 > 탕전기관리 > 삭제
	$apicode=$_GET["apiCode"];
	$language=$_GET["language"];
	$bo_seq=$_GET["seq"];

	if($apicode!="potdelete"){$_GET["resultMessage"]="API(apiCode) ERROR";$apicode="potdelete";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="API(language) ERROR";}
	else if($bo_seq==""){$_GET["resultMessage"]="API(seq) ERROR";}
	else
	{
		$sql=" update ".$dbH."_boiler set bo_use='D' where bo_seq='".$bo_seq."'";
		dbcommit($sql);
		$returnData=$_GET["returnData"];
		$json=array("apiCode"=>$apicode,"returnData"=>$returnData);
		$json["resultCode"]="200";
		$json["resultMessage"]="OK";
	}
?>