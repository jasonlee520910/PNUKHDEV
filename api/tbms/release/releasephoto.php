<?php //스텝 등록/수정
	$apiCode=$_POST["apiCode"];
	$language=$_POST["language"];
	$barcode=$_POST["barcode"];
	$code=$_POST["code"];

	if($apiCode!="releasephoto"){$json["resultMessage"]="API(apiCode) ERROR";$apiCode="releasephoto";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="API(language) ERROR";}
	else
	{
		//20191025 : 스캔받은 송장과 DB에 저장된 송장을 비교하자 !!!!
		$sql=" select re_delino from ".$dbH."_release where re_odcode='".$code."' ";
		$dt=dbone($sql);
		$re_delino=$dt["RE_DELINO"];
		if($re_delino==$barcode)
		{
			$randtime=date("Y-m-d H:i:s");
			$qmcode="QMC".$randtime;

			$sql=" select mr_staffid from ".$dbH."_marking where mr_odcode='".$code."' ";
			$dt=dbone($sql);
			$qmstaff=$dt["MR_STAFFID"];

			$sql=" update ".$dbH."_release set re_quality='".$qmcode."', re_qmstaff='".$qmstaff."' where re_odcode='".$code."'";
			dbcommit($sql);

			$json["resultCode"]="200";
			$json["resultMessage"]="OK";

		}
		else
		{
			$json["resultCode"]="999";
			$json["resultMessage"]="ERR_DELINO_DIFFERENT";
		}

		$json["code"]=$code;
		$json["barcode"]=$barcode;
		$json["qmcode"]=$qmcode;
		$json["apiCode"]=$apiCode;
	}
?>