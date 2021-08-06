<?php  
	/// 자재코드관리 > 조제대관리 > 삭제
	$apicode=$_GET["apiCode"];
	$language=$_GET["language"];
	$mt_seq=$_GET["seq"];
	if($apicode!="makingtabledelete"){$_GET["resultMessage"]="API(apiCode) ERROR";$apicode="makingtabledelete";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="API(language) ERROR";}
	else if($mt_seq==""){$_GET["resultMessage"]="API(seq) ERROR";}
	else
	{
		$sql=" update ".$dbH."_makingtable set mt_use='D' where mt_seq='".$mt_seq."'";
		dbcommit($sql);
		$returnData=$_GET["returnData"];
		$json=array("apiCode"=>$apicode,"returnData"=>$returnData);
		$json["resultCode"]="200";
		$json["resultMessage"]="OK";
	}
?>