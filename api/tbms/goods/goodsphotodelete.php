<?php  //goodsphotodelete
	$apiCode=$_GET["apiCode"];
	$language=$_GET["language"];
	$seq=$_GET["seq"];

	if($apiCode!="goodsphotodelete"){$json["resultMessage"]="API(apiCode) ERROR";$apiCode="goodsphotodelete";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="API(language) ERROR";}
	else
	{

		$sql=" update ".$dbH."_file set af_use='D' where af_seq='".$seq."' ";
		dbcommit($sql);
		
		$json["apiCode"] = $apiCode;
		$json["resultCode"]="200";
		$json["resultMessage"]="OK";
	}
?>