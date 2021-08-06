<?php //스텝 등록/수정
	$apiCode=$_POST["apiCode"];
	$language=$_POST["language"];
	$code=$_POST["code"];
	$staffid=$_POST["staffid"];

	if($apiCode!="staffupdate"){$json["resultMessage"]="API(apiCode) ERROR";$apiCode="staffupdate";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="API(language) ERROR";}
	else
	{
		$dsql=" select dc_status from ".$dbH."_decoction where dc_barcode='".$code."'";
		$ddt=dbone($dsql);
		$dc_status=$ddt["DC_STATUS"];
		$json["dc_status"]=$dc_status;

		if($dc_status=="decoction_apply" || $dc_status=="decoction_start")
		{
			$sql=" update ".$dbH."_decoction set dc_staffid='".$staffid."', dc_modify=sysdate where dc_barcode='".$code."' ";
			dbcommit($sql);
		}
		else if($dc_status=="decoction_processing")
		{
			$sql=" update ".$dbH."_decoction set dc_packingid='".$staffid."', dc_modify=sysdate where dc_barcode='".$code."' ";
			dbcommit($sql);
		}

		$json["sql"]=$sql;
		$json["apiCode"]=$apiCode;
		$json["resultCode"]="200";
		$json["resultMessage"]="OK";
	}
?>