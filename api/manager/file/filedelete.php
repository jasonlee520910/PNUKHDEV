<?php
	/// 파일삭제 
	$apicode=$_GET["apiCode"];
	$language=$_GET["language"];
	$af_seq=$_GET["seq"];
	if($apicode!="filedelete"){$json["resultMessage"]="API(apiCode) ERROR";$apicode="filedelete";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="API(language) ERROR";}
	else if($af_seq==""){$json["resultMessage"]="API(seq) ERROR";}
	else{
		$returndata=$resjson["returnData"];
		$sql=" update ".$dbH."_file set af_use='D', af_date=sysdate where af_seq='".$af_seq."'";
		dbcommit($sql);
		$returnData=$resjson["returnData"];
		$json=array("apiCode"=>$apicode,"seq"=>$af_seq,"returnData"=>$returnData);
		$json["sql"]=$sql;
		$json["apiCode"]=$apicode;
		$json["resultCode"]="200";
		$json["resultMessage"]="OK";
	}
?>
