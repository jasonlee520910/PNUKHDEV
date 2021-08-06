<?php
	$json["resultCode"]="204";
	$apicode=$_GET["apiCode"];
	$language=$_GET["language"];
	$cd_seq=$_GET["seq"];
	if($apicode!="subcodedelete"){$json["resultMessage"]="API(apiCode) ERROR";$apicode="subcodedelete";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="API(language) ERROR";}
	else if($cd_seq==""){$json["resultMessage"]="API(seq) ERROR";}
	else{
		$returnData=$_GET["returnData"];
		$json=array("apiCode"=>$apicode,"returnData"=>$returnData);
		$sql=" update ".$dbH."_code set cd_use='D' where cd_seq='".$cd_seq."' ";
		dbcommit($sql);
		$json["sql"]=$sql;
		$json["resultCode"]="200";
		$json["resultMessage"]="OK";
	}
?>