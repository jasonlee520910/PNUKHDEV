<?php //스텝 등록/수정
	$apiCode=$_POST["apiCode"];
	$language=$_POST["language"];
	$code=$_POST["code"];

	if($apiCode!="markingprocessing"){$json["resultMessage"]="API(apiCode) ERROR";$apiCode="markingprocessing";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="API(language) ERROR";}
	else
	{
		$sql=" update ".$dbH."_order set od_status='marking_processing' where od_code='".$code."'";
		dbcommit($sql);

		$sql1=" update ".$dbH."_marking set mr_status='marking_processing' where mr_odcode='".$code."'";
		dbcommit($sql1);

		$json["sql"]=$sql;
		$json["sql1"]=$sql1;
		$json["apiCode"]=$apiCode;
		$json["resultCode"]="200";
		$json["resultMessage"]="OK";
	}
?>