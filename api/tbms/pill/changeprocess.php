<?php
	$apiCode=$_GET["apiCode"];
	$language=$_GET["language"];
	
	$stat=$_GET["stat"];
	$proc=$_GET["proc"];
	$code=$_GET["code"];
	$returnData=$_GET["returnData"];
	
	if($apiCode!="changeprocess"){$json["resultMessage"]="API(apiCode) ERROR";$apiCode="changeprocess";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="API(language) ERROR";}
	else
	{
		$chkstat=explode("_",$stat);

		$sql=" select PL_START, PL_STATUS from ".$dbH."_pill where PL_ODCODE='".$code."' ";
		$dt=dbone($sql);

		$json["PL_START"] = $dt["PL_START"];
		$json["PL_STATUS"] = $dt["PL_STATUS"];

		$sql=" update ".$dbH."_order set od_status='".$stat."' where od_code='".$code."' ";		
		dbcommit($sql);
		$json["sql1"] = $sql;

		if($stat=="pill_start"&&!$dt["PL_START"])
		{
			$sql=" update ".$dbH."_pill set PL_START=sysdate,  PL_STATUS='".$stat."' where PL_ODCODE='".$code."' ";
		}
		else
		{
			$sql=" update ".$dbH."_pill set PL_STATUS='".$stat."' where PL_ODCODE='".$code."' ";
		}
		
		dbcommit($sql);
		$json["sql2"] = $sql;

		$json["apiCode"] = $apiCode;
		$json["returnData"] = $returnData;
		$json["resultCode"]="200";
		$json["resultMessage"]="OK";
	}
?>