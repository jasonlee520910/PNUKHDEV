<?php
	//GET
	$apiCode=$_GET["apiCode"];
	$language=$_GET["language"];
	$seq=$_GET["seq"];
	$odkeycode=$_GET["odkeycode"];

	if($apiCode!="noneworthy"){$json["resultMessage"]="API(apiCode) ERROR";$apiCode="noneworthy";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="API(language) ERROR";}
	else
	{

		$sql=" select rc_code from ".$dbH."_recipemedical where rc_seq='".$seq."' ";
		$dt=dbone($sql);
		$rmCode=$dt["RC_CODE"];
		
		$sql=" select ";
		$sql.=" b.rc_code, b.rc_source ";
		$sql.=" from ".$dbH."_order ";
		$sql.=" a inner join ".$dbH."_recipeuser b on b.rc_code=a.od_scription ";
		$sql.=" where a.od_keycode='".$odkeycode."' ";
		$dt=dbone($sql);
		$ruCode=$dt["RC_CODE"];


		$usql=" update ".$dbH."_recipeuser ";
		$usql.=" set rc_source='".$rmCode."' ";
		$usql.=" where rc_code='".$ruCode."' ";
		$json["cy_usql"]=$usql;
		dbcommit($usql);

		
		$sql=" select rc_code from ".$dbH."_recipeuser where rc_source='".$rmCode."' ";
		$dt=dbone($sql);
		if($dt["RC_CODE"])
		{
			$json["rc_code"]=$dt["RC_CODE"];
			$json["resultCode"]="200";
			$json["resultMessage"]="OK";
		}
		else
		{
			$json["resultCode"]="199";
			$json["resultMessage"]="ERR_NOT_MATCHING";//매칭실패 
		}

		$json["apiCode"]=$apiCode;


	}
?>
