<?php
	$apicode=$_GET["apiCode"];
	$language=$_GET["language"];
	if($apicode!="estimatebasic"){$json["resultMessage"]="API코드오류";$apicode="estimatebasic";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="언어코드오류";}
	else{
		$returnData=$_GET["returnData"];
		$json=array("apiCode"=>$apicode,"returnData"=>$returnData);

		$esStaffid=$_GET["esStaffid"];
		$sql=" select a.* from ".$dbH."_estimate a where es_use in('Y') and es_type='basic'";
		$res=dbqry($sql);
		$json["list"]=array();
		while($dt=dbarr($res)){
			if($dt["es_modify"]){$esDate=$dt["es_modify"];}else{$esDate=$dt["es_date"];}
			$addarray=array("esCode"=>$dt["es_code"], "esType"=>$dt["es_type"], "esStaffid"=>$dt["es_staffid"], "esTitle"=>$dt["es_title"], "esAmount"=>$dt["es_amount"], "esUse"=>$dt["es_use"], "esDate"=>$esDate);
			array_push($json["list"], $addarray);
		}
		$json["sql"]=$sql;
		$json["apiCode"]=$apicode;
		$json["returnData"]=$returnData;
		$json["resultCode"]="200";
		$json["resultMessage"]="OK";
	}
?>