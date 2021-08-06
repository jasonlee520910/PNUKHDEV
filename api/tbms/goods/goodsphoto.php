<?php //스텝 등록/수정
	$apiCode=$_POST["apiCode"];
	$language=$_POST["language"];
	$barcode=$_POST["barcode"];
	$code=$_POST["code"];

	if($apiCode!="goodsphoto"){$json["resultMessage"]="API(apiCode) ERROR";$apiCode="goodsphoto";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="API(language) ERROR";}
	else
	{
		$sql=" update ".$dbH."_release set re_delino='".$barcode."' where re_odcode='".$code."'";
		dbcommit($sql);

		//m-d-Y H : i : s.u from milliseconds
		//20190513173646136631 요렇게 뽑아오기 
		$t = microtime(true);
		$micro = sprintf("%06d",($t - floor($t)) * 1000000);
		$d = new DateTime( date('Y-m-d H:i:s.'.$micro, $t) );
		$qmcode="QMC".$d->format("YmdHisu");

		$sql=" select gp_staffid from ".$dbH."_package where gp_odcode='".$code."' ";
		$dt=dbone($sql);
		$qmstaff=$dt["GP_STAFFID"];

		$sql=" update ".$dbH."_release set re_quality='".$qmcode."', re_qmstaff='".$qmstaff."' where re_odcode='".$code."'";
		dbcommit($sql);

		//$json["sql"]=$sql;
		$json["code"]=$code;
		$json["barcode"]=$barcode;
		$json["qmcode"]=$qmcode;
		$json["apiCode"]=$apiCode;
		$json["resultCode"]="200";
		$json["resultMessage"]="OK";
	}
?>