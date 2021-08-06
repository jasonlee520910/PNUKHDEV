<?php
	/// 환경설정 > 개인정보처리
	$json["resultCode"]="204";
	$apicode=$_GET["apiCode"];
	$language=$_GET["language"];
	$seq=$_GET["seq"];
	$poGroup=$_GET["poGroup"];

	if($apicode!="policydelete"){$json["resultMessage"]="API(apiCode) ERROR";$apicode="policydelete";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="API(language) ERROR";}
	else if($seq==""){$json["resultMessage"]="API(seq) ERROR";}
	else{
		$returnData=$_GET["returnData"];
		$json=array("apiCode"=>$apicode,"returnData"=>$returnData);
		$sql=" update ".$dbH."_policy set PO_USE='D' where PO_SEQ='".$seq."'";
		dbcommit($sql);
		$json["sql"]=$sql;
		$json["poGroup"]=$poGroup;
		
		$json["resultCode"]="200";
		$json["resultMessage"]="OK";
	}
?>