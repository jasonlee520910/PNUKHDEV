<?php
	$apicode=$_GET["apiCode"];
	$language=$_GET["language"];
	$sc_code=$_GET["code"];
	if($apicode!="categorydelete"){$json["resultMessage"]="API코드오류";$apicode="categorydelete";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="언어코드오류";}
	else if($sc_code==""){$json["resultMessage"]="seq 코드없음";}
	else{
		$sql=" update ".$dbH."_salescategory set sc_use='D' where sc_code='".$sc_code."'";
		dbqry($sql);
		$returnData=$_GET["returnData"];
		$json=array("apiCode"=>$apicode,"returnData"=>$returnData);
		$json["resultCode"]="200";
		$json["resultMessage"]="OK";
	}
?>