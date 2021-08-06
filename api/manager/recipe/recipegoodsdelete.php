<?php  
	///처방관리 > 약속처방 > 약속처방 삭제
	$apicode=$_GET["apiCode"];
	$language=$_GET["language"];
	$rc_seq=$_GET["seq"];
	if($apicode!="recipegoodsdelete"){$json["resultMessage"]="API(apiCode) ERROR";$apicode="recipegoodsdelete";}
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