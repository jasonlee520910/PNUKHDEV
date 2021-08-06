<?php  
	/// 자재코드관리 > 마킹프린터관리 > 삭제
	$apicode=$_GET["apiCode"];
	$language=$_GET["language"];
	$mp_seq=$_GET["seq"];

	if($apicode!="markingprinterdelete"){$_GET["resultMessage"]="API(apiCode) ERROR";$apicode="markingprinterdelete";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="API(language) ERROR";}
	else if($mp_seq==""){$_GET["resultMessage"]="API(seq) ERROR";}
	else
	{
		$sql=" update ".$dbH."_markingprinter set mp_use='D' where mp_seq='".$mp_seq."'";
		dbcommit($sql);

		$returnData=$_GET["returnData"];
		$json=array("apiCode"=>$apicode,"returnData"=>$returnData);
		$json["resultCode"]="200";
		$json["resultMessage"]="OK";
		$json["sql"]=$sql;
	}
?>