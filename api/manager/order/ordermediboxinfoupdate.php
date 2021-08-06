<?php //로젠 
	$apicode=$_GET["apiCode"];
	$language=$_GET["language"];
	$odkeycode=$_GET["odkeycode"];
	$pb_volume=$_GET["pb_volume"];
	$pb_maxcnt=$_GET["pb_maxcnt"];
	
	if($apicode!="ordermediboxinfoupdate"){$json["resultMessage"]="API(apiCode) ERROR2";$apicode="ordermediboxinfoupdate";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="API(language) ERROR";}
	else if($odkeycode==""){$json["resultMessage"]="API(odkeycode) ERROR";}
	else if($pb_volume==""){$json["resultMessage"]="API(pb_volume) ERROR";}
	else if($pb_maxcnt==""){$json["resultMessage"]="API(pb_maxcnt) ERROR";}
	else
	{
		$returnData=$_GET["returnData"];

		$rbsql=" update ".$dbH."_release ";
		$rbsql.=" set re_boxmedivol='".$pb_volume."', re_boxmedipack='".$pb_maxcnt."', RE_BOXMEDIBOX='".$pb_maxcnt."' where re_keycode='".$odkeycode."' ";
		dbcommit($rbsql);


		$sql=" select re_boxmedi, re_boxmedivol, re_boxmedipack from ".$dbH."_release where re_keycode='".$odkeycode."' ";
		$dt=dbone($sql);
		$re_boxmedi=$dt["RE_BOXMEDI"];
		$re_boxmedivol=$dt["RE_BOXMEDIVOL"];
		$re_boxmedipack=$dt["RE_BOXMEDIPACK"];

		$bm=getBoxMediinfo($odkeycode, $re_boxmedi, $re_boxmedivol, $re_boxmedipack);
		$json["pb_medichk"]=$bm["pb_medichk"];
		$json["pb_code"]=$bm["pb_code"];
		$json["pb_title"]=$bm["pb_title"];
		$json["pb_volume"]=$bm["pb_volume"];
		$json["pb_maxcnt"]=$bm["pb_maxcnt"];


		$json["apiCode"]=$apicode;
		$json["resultCode"]="200";
		$json["resultMessage"]="OK";
	}
?>