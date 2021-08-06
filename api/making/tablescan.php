<?php
	$apicode=$_GET["apiCode"];
	$language=$_GET["language"];
	$page=$_GET["page"];
	$od_code=$_GET["odCode"];
	$ma_table=$_GET["maTable"];

	if($apicode!="tablescan"){$json["resultMessage"]="API(apiCode) ERROR";$apicode="tablescan";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="API(language) ERROR";}
	else if($od_code==""){$json["resultMessage"]="API(odCode) ERROR";}
	else if($ma_table==""){$json["resultMessage"]="API(TableNo) ERROR";}
	else{
		$returnData=$_GET["returnData"];
		$json=array("apiCode"=>$apicode,"returnData"=>$returnData);

		$sql=" select ma_tablestat from ".$dbH."_making where ma_odcode='".$od_code."' ";
		$dt=dbone($sql);
		$tablestat=$dt["MA_TABLESTAT"];
		$json["tableStat"]=$tablestat;
		$json["sql"]=$sql;

		$json["resultCode"]="200";
		$json["resultMessage"]="OK";
	}

?>