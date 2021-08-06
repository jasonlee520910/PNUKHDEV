<?php  
	/// 재고관리 > 자재입출고 > 삭제
	$apicode=$_GET["apiCode"];
	$language=$_GET["language"];
	$wh_seq=$_GET["seq"];
	if($apicode!="genstockdelete"){$json["resultMessage"]="API(apiCode) ERROR";$apicode="genstockdelete";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="API(language) ERROR";}
	else if($wh_seq==""){$json["resultMessage"]="API(seq) ERROR";}
	else
	{
		$sql=" update ".$dbH."_warehouse set wh_use='D' where wh_seq='".$wh_seq."' and wh_type='general' ";
		dbcommit($sql);
		$returnData=$_GET["returnData"];
		$json=array("apiCode"=>$apicode,"returnData"=>$returnData);
		$json["resultCode"]="200";
		$json["resultMessage"]="OK";
	}
?>