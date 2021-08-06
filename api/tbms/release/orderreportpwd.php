<?php
	///orderreport 품질보고서 
	//GET
	$apicode=$_GET["apiCode"];
	$language=$_GET["language"];
	$lblpwd=$_GET["pwd"];
	$od_code=$_GET["code"];
	$od_code=str_replace("ODD","",$od_code);

	if($apicode!="orderreportpwd"){$json["resultMessage"]="API(apicode) ERROR";$apicode="orderreportpwd";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="API(language) ERROR";}
	else
	{
		$returnData=$_GET["returnData"];
	
		$sql="select
			b.ME_REPORTPWD, c.RE_MOBILE
			from han_order a 
			left join han_member b on a.OD_STAFF=b.ME_USERID
			left join han_release c on c.RE_KEYCODE=a.OD_KEYCODE
			where a.OD_CODE='ODD".$od_code."'  ";

		$dt=dbone($sql);
		$json["dt"]=$dt;

		$me_reportpwd=$dt["ME_REPORTPWD"];
		$re_mobile=($dt["RE_MOBILE"])?substr($dt["RE_MOBILE"], -4):"";

		$json["me_reportpwd"]=$me_reportpwd;
		$json["re_mobile"]=$re_mobile;
		$json["sql"]=$sql;

		if($me_reportpwd==$lblpwd || $re_mobile==$lblpwd)
		{
			$json["resultCode"]="200";
			$json["resultMessage"]="OK";
		}
		else
		{
			$json["resultCode"]="199";
			$json["resultMessage"]="비밀번호가 다르거나 없습니다.";
		}

		$json["apiCode"]=$apicode;

	}		

?>
