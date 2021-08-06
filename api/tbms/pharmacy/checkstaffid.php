<?php
	$apiCode=$_GET["apiCode"];
	$language=$_GET["language"];
	
	$code=$_GET["code"];
	$st_staffid=$_GET["staffID"];
	$returnData=$_GET["returnData"];
	
	if($apiCode!="checkstaffid"){$json["resultMessage"]="API(apiCode) ERROR";$apiCode="checkstaffid";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="API(language) ERROR";}
	else if($code==""){$json["resultMessage"]="API(code) ERROR";}
	else if($st_staffid==""){$json["resultMessage"]="API(staffID) ERROR";}
	else
	{
		$sql=" select st_depart from ".$dbH."_staff where st_staffid='".$st_staffid."'";
		$dt=dbone($sql);

		$json["apiCode"] = $apiCode;
		$json["staffID"] = $st_staffid;
		$json["staffDepart"] = $dt["ST_DEPART"];
		$json["sql"] = $sql;
		$json["returnData"] = $returnData;

		if($dt["ST_DEPART"]=="making")
		{
			$json["resultCode"]="200";
			$json["resultMessage"]="OK";
		}
		else{
			$json["resultCode"]="204";
			$json["resultMessage"]="조제사만 가능합니다. ";
		}
	}
?>