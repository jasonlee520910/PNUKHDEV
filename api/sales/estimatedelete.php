<?php
	$apicode=$_GET["apiCode"];
	$language=$_GET["language"];
	$sc_code=$_GET["esCode"];
	if($apicode!="estimatedelete"){$json["resultMessage"]="API코드오류";$apicode="estimatedelete";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="언어코드오류";}
	else if($sc_code==""){$json["resultMessage"]="code 코드없음";}
	else{
		$sql=" update ".$dbH."_estimate set es_use='D' where es_code='".$sc_code."'";
		dbqry($sql);
		$returnData=$_GET["returnData"];
		$json=array("apiCode"=>$apicode,"returnData"=>$returnData);
		$json["resultCode"]="200";
		$json["resultMessage"]="OK";
	}
?>