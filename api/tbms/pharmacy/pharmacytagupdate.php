<?php
	$apiCode=$_GET["apiCode"];
	$language=$_GET["language"];
	$tag_code=$_GET["tagCode"];
	$od_code=$_GET["odCode"];
	
	if($apiCode!="pharmacytagupdate"){$json["resultMessage"]="API(apiCode) ERROR";$apiCode="pharmacytagupdate";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="API(language) ERROR";}
	else if($od_code==""){$json["resultMessage"]="API(odCode) ERROR";}
	else
	{
		//부직포태그 검사 
		$sql=" select pt_name1, pt_group from ".$dbH."_pouchtag where pt_code='".$tag_code."' "; 
		$json["sql1"]=$sql;
		$dt=dbone($sql);

		$ptcode=$dt["PT_GROUP"];
		$ptname=$dt["PT_NAME1"];

		//주문태그검사
		$sql=" select a.od_matype, c.rc_medicine as RCMEDICINE
					from ".$dbH."_order a 
					inner join ".$dbH."_recipeuser c on a.od_scription=c.rc_code 
					where a.od_code='".$od_code."'";
		$dt=dbone($sql);
		$json["sql"]=$sql;
		$json["ptcode"]=$ptcode;
		$od_matype=$dt["OD_MATYPE"];
		$rc_medicine=getClob($dt["RCMEDICINE"]);
		$json["rc_medicine"]=$rc_medicine;
		if($od_matype=="goods" || $od_matype=="commercial" || $od_matype=="worthy")
		{
			$sql=" update han_making set ma_medibox_".$ptcode."='".$tag_code."', ma_modify=sysdate where ma_odcode='".$od_code."' ";
			dbcommit($sql);
			$json["sql"]=$sql;
		}
		else
		{
			if(strpos($rc_medicine,$ptcode)){
				$sql=" update han_making set ma_medibox_".$ptcode."='".$tag_code."', ma_modify=sysdate where ma_odcode='".$od_code."' ";
				dbcommit($sql);
				$json["sql"]=$sql;
			}
		}

		$json["ptCode"]=$ptcode;
		$json["ptName"]=$ptname;
		$json["tagCode"] = $tag_code;
		$json["apiCode"] = $apiCode;
		$json["returnData"] = $returnData;
		$json["resultCode"]="200";
		$json["resultMessage"]="OK";
	}
?>