<?php
	$apicode=$_GET["apiCode"];
	$language=$_GET["language"];
	$esType=$_GET["esType"];
	if($apicode!="estimatelist"){$json["resultMessage"]="API코드오류";$apicode="estimatelist";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="언어코드오류";}
	//else if($esStaffid==""){$json["resultMessage"]="userid 없음";}
	else{
		$returnData=$_GET["returnData"];
		$json=array("apiCode"=>$apicode,"returnData"=>$returnData);

		$esStaffid=$_GET["esStaffid"];
		$sql=" select a.*, b.cs_name csName, if(es_modify,es_modify,es_date) indate from ".$dbH."_estimate a left join ".$dbH."_customer b on a.es_customer=b.cs_seq where es_use in('Y','U') and es_type='".$esType."'";
		if($esType!="basic"){
			$sql.=" and es_staffid='".$esStaffid."'";
		}
		$sql.=" order by indate desc ";
		$res=dbqry($sql);
		$json["list"]=array();
		while($dt=dbarr($res)){
			$addarray=array("esCode"=>$dt["es_code"], "esType"=>$dt["es_type"], "csName"=>$dt["csName"], "esStaffid"=>$dt["es_staffid"], "esTitle"=>$dt["es_title"], "esAmount"=>$dt["es_amount"], "esConfirm"=>$dt["es_confirm"], "esUse"=>$dt["es_use"], "esDate"=>$dt["indate"]);
			array_push($json["list"], $addarray);
		}
		$json["sql"]=$sql;
		$json["apiCode"]=$apicode;
		$json["returnData"]=$returnData;
		$json["resultCode"]="200";
		$json["resultMessage"]="OK";
	}
?>