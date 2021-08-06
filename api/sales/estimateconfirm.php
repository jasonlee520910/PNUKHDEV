<?php
	$apicode=$_GET["apiCode"];
	$language=$_GET["language"];
	$esCode=$_GET["esCode"];
	if($apicode!="estimateconfirm"){$json["resultMessage"]="API코드오류";$apicode="estimateconfirm";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="언어코드오류";}
	else if($esCode==""){$json["resultMessage"]="code 없음";}
	else{
		$returnData=$_GET["returnData"];
		$json=array("apiCode"=>$apicode,"returnData"=>$returnData,"esCode"=>$esCode);
		$esStaffid=$_GET["esStaffid"];
		$sql=" update ".$dbH."_estimate set es_confirm=now() where es_code='".$esCode."' ";
		dbqry($sql);

		$json["sql"]=$sql;
		$json["resultCode"]="200";
		$json["resultMessage"]="OK";
	}
?>