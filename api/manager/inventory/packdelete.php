<?php  
	/// 자재코드관리 > 포장기관리 > 삭제
	$apicode=$_GET["apiCode"];
	$language=$_GET["language"];
	$pa_seq=$_GET["seq"];

	if($apicode!="packdelete"){$_GET["resultMessage"]="API(apiCode) ERROR";$apicode="packdelete";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="API(language) ERROR";}
	else if($pa_seq==""){$_GET["resultMessage"]="API(seq) ERROR";}
	else
	{
		$sql=" update ".$dbH."_packing set pa_use='D' where pa_seq='".$pa_seq."'";
		dbcommit($sql);

		$returnData=$_GET["returnData"];
		$json=array("apiCode"=>$apicode,"returnData"=>$returnData);
		$json["resultCode"]="200";
		$json["resultMessage"]="OK";
	}
?>