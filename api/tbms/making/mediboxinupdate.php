<?php //스텝 등록/수정
	$apiCode=$_GET["apiCode"];
	$language=$_GET["language"];
	$odcode=$_GET["odcode"];
	$proinfirst=$_GET["proinfirst"];
	$proinmain=$_GET["proinmain"];
	$proinafter=$_GET["proinafter"];
	$proinlast=$_GET["proinlast"];

	if($apiCode!="mediboxinupdate"){$json["resultMessage"]="API(apiCode) ERROR";$apiCode="mediboxinupdate";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="API(language) ERROR";}
	else
	{
		$procheck="";
		$promsg="";

		$sql="select ma_medibox_infirst, ma_medibox_inmain, ma_medibox_inafter, ma_medibox_inlast from ".$dbH."_making where ma_odcode='".$odcode."' ";
		$dt=dbone($sql);

		$ma_medibox_infirst=$dt["MA_MEDIBOX_INFIRST"];
		$ma_medibox_inmain=$dt["MA_MEDIBOX_INMAIN"];
		$ma_medibox_inafter=$dt["MA_MEDIBOX_INAFTER"];
		$ma_medibox_inlast=$dt["MA_MEDIBOX_INLAST"];

		$json["ma_medibox_infirst"]=$ma_medibox_infirst;
		$json["ma_medibox_inmain"]=$ma_medibox_inmain;
		$json["ma_medibox_inafter"]=$ma_medibox_inafter;
		$json["ma_medibox_inlast"]=$ma_medibox_inlast;

		$json["kind"]="";
		$procheck="";

		$json["updateinfirst"]="";
		$json["updateinmain"]="";
		$json["updateinafter"]="";

		if($proinfirst)
		{
			$sql="select pt_code, pt_group, pt_name1 from ".$dbH."_pouchtag where pt_code='".$proinfirst."' and pt_group='infirst' and pt_use ='Y'  ";
			$dt=dbone($sql);

			if($dt["PT_CODE"])
			{
				if($ma_medibox_infirst=="")
				{
					$sql=" update ".$dbH."_making set ma_medibox_infirst='".$proinfirst."', ma_modify=sysdate where ma_odcode='".$odcode."'";
					dbcommit($sql);
					$procheck="ok";
					$json["kind"]="infirst";
					$json["infirst"]=$proinfirst;
					$json["infirstsql"]=$sql;
				}
				else
				{
					$json["updateinfirst"]="infirst";
				}
			}
			else
			{
				$promsg.=",infirst";
			}
		}


		if($proinmain)
		{
			$sql="select pt_code, pt_group, pt_name1 from ".$dbH."_pouchtag where pt_code='".$proinmain."' and pt_group='inmain' and pt_use ='Y'  ";
			$dt=dbone($sql);
			
			if($dt["PT_CODE"])
			{				
				if($ma_medibox_inmain=="")
				{
					$sql=" update ".$dbH."_making set ma_medibox_inmain='".$proinmain."', ma_modify=sysdate where ma_odcode='".$odcode."'";
					dbcommit($sql);
					$procheck="ok";
					$json["kind"]="inmain";
					$json["inmain"]=$proinmain;
					$json["inmainsql"]=$sql;
				}
				else
				{
					$json["updateinmain"]="inmain";
				}
			}
			else
			{
				$promsg.=",inmain";
			}
		}


		if($proinafter)
		{
			$sql="select pt_code, pt_group, pt_name1 from ".$dbH."_pouchtag where pt_code='".$proinafter."' and pt_group='inafter' and pt_use ='Y'  ";
			$dt=dbone($sql);

			if($dt["PT_CODE"])
			{
				if($ma_medibox_inafter=="")
				{
					$sql=" update ".$dbH."_making set ma_medibox_inafter='".$proinafter."', ma_modify=sysdate where ma_odcode='".$odcode."'";
					dbcommit($sql);
					$procheck="ok";
					$json["kind"]="inafter";
					$json["inafter"]=$proinafter;
					$json["inaftersql"]=$sql;
				}
				else
				{
					$json["updateinafter"]="inafter";
				}
			}
			else
			{
				$promsg.=",inafter";
			}
		}



		if($procheck=="ok" && $ma_medibox_inlast=="" && $proinlast)
		{
			$sql=" update ".$dbH."_making set ma_medibox_inlast='MDT0000000004', ma_modify=sysdate where ma_odcode='".$odcode."'";
			dbcommit($sql);
			$procheck="ok";
			$json["inlastsql"]=$sql;
			$json["inlastkind"]="inlast";
		}

		$json["sql"]=$sql;
		$json["apiCode"] = $apiCode;

		if($json["updateinfirst"]=="" && $json["updateinmain"]=="" && $json["updateinafter"]=="")
		{
			if($procheck == "ok")
			{
				$json["resultCode"]="200";
				$json["resultMessage"]="OK";
			}
			else
			{
				$json["resultCode"]="599";
				$json["resultMessage"]=$promsg;
			}
		}
		else
		{
			$json["resultCode"]="589";
			$json["resultMessage"]="";
		}

	}
?>