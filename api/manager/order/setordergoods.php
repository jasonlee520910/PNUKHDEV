<?php
	$apicode=$_GET["apiCode"];
	$language=$_GET["language"];
	$od_code=$_GET["odcode"];
	if($apicode!="setordergoods"){$json["resultMessage"]="API(apiCode) ERROR";$apicode="setordergoods";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="API(language) ERROR";}
	else if($od_code==""){$json["resultMessage"]="API(odcode) ERROR";}
	else{
		$odGoods=$_GET["odGoods"];
		$returnData=$_GET["returnData"];

		$json=array("apiCode"=>$apicode,"returnData"=>$returnData); 

		if($odGoods=="true")
		{
			$sql=" update ".$dbH."_order set od_goods='M' where od_code='".$od_code."'"; //약재추가 
			$json["odGoods"]="M";
		}
		else
		{
			$sql=" update ".$dbH."_order set od_goods='N' where od_code='".$od_code."'"; //약재추가 
			$json["odGoods"]="N";
		}
		dbcommit($sql);
		
		$json["sql"]=$sql;
		$json["resultCode"]="200";
		$json["resultMessage"]="OK";
	}
?>