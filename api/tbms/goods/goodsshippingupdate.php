<?php
	$apiCode=$_GET["apiCode"];
	$language=$_GET["language"];
	$odcode=$_GET["odcode"];
	$delicode=$_GET["delicode"];

	if($apiCode!="goodsshippingupdate"){$json["resultMessage"]="API(apiCode) ERROR";$apiCode="goodsshippingupdate";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="API(language) ERROR";}
	else
	{
		$sql="select re_deliexception from ".$dbH."_release where re_odcode='".$odcode."' ";
		$dt=dbone($sql);
		$re_deliexception=$dt["RE_DELIEXCEPTION"];

		if($re_deliexception=="N")
		{
			$usql=" update ".$dbH."_release set re_deliexception=',T', re_delino='".$delicode."' where re_odcode='".$odcode."' ";
			dbcommit($usql);
		}
		else
		{
			if(strpos($re_deliexception, ",T") !== false)
			{

			}
			else
			{
				$re_deliexception.=',T';
			}

			
			$usql=" update ".$dbH."_release set re_deliexception='".$re_deliexception."', re_delino='".$delicode."' where re_odcode='".$odcode."' ";
			dbcommit($usql);
		}

		$json["re_deliexception"] = $re_deliexception;
		$json["sql"] = $sql;
		$json["usql"] = $usql;
		$json["apiCode"] = $apiCode;
		$json["resultCode"]="200";
		$json["resultMessage"]="OK";

	}
?>