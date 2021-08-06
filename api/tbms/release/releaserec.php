<?php  //release orderlist
	$apiCode=$_GET["apiCode"];
	$language=$_GET["language"];
	$ordercode=$_GET["ordercode"];
	$code=$_GET["code"];

	if($apiCode!="releaserec"){$json["resultMessage"]="API(apiCode) ERROR";$apiCode="releaserec";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="API(language) ERROR";}
	else
	{
		if($barcode=="REC0000001000")////침전물체크바코드
		{
			$sql=" update ".$dbH."_release set re_precipitate=sysdate where re_odcode='".$code."'";
			dbcommit($sql);
		}
		if($barcode=="REC0000002000")//누수체크바코드
		{
			$sql=" update ".$dbH."_release set re_leak=sysdate where re_odcode='".$code."'";
			dbcommit($sql);
		}

		$sql="select re_precipitate, re_leak from ".$dbH."_release where re_odcode='".$code."'";
		$dt=dbone($sql);

		$json["re_precipitate"] = $dt["RE_PRECIPITATE"];
		$json["re_leak"] = $dt["RE_LEAK"];
		$json["code"] = $code;

		$json["apiCode"] = $apiCode;
		$json["resultCode"]="200";
		$json["resultMessage"]="OK";


	}
?>