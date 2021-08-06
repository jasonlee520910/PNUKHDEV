<?php //스텝 등록/수정
	$apiCode=$_POST["apiCode"];
	$language=$_POST["language"];
	$code=$_POST["code"];
	$staffid=$_POST["staffid"];

	if($apiCode!="staffupdate"){$json["resultMessage"]="API(apiCode) ERROR";$apiCode="staffupdate";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="API(language) ERROR";}
	else
	{
		$sql=" update ".$dbH."_marking set mr_staffid='".$staffid."' where mr_barcode='".$code."' ";
		dbcommit($sql);

		$json["sql"]=$sql;
		$json["apiCode"]=$apiCode;
		$json["resultCode"]="200";
		$json["resultMessage"]="OK";
	}
?>