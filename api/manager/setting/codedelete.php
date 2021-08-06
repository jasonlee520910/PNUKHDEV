<?php
	/// 환경설정 > 코드관리 > 상세 > 삭제 
	$json["resultCode"]="204";
	$apicode=$_GET["apiCode"];
	$language=$_GET["language"];
	$cd_type=$_GET["seq"];
	if($apicode!="codedelete"){$json["resultMessage"]="API(apiCode) ERROR";$apicode="codedelete";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="API(language) ERROR";}
	else if($cd_type==""){$json["resultMessage"]="API(seq) ERROR";}
	else{
		$returnData=$_GET["returnData"];
		$json=array("apiCode"=>$apicode,"returnData"=>$returnData);
		$sql=" update ".$dbH."_code set cd_use='D' where cd_type='".$cd_type."'";
		dbcommit($sql);
		$json["resultCode"]="200";
		$json["resultMessage"]="OK";
	}
?>