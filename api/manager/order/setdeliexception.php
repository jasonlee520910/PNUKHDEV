<?php
	$apicode=$_GET["apiCode"];
	$language=$_GET["language"];
	$od_code=$_GET["odcode"];
	if($apicode!="setdeliexception"){$json["resultMessage"]="API(apiCode) ERROR";$apicode="setdeliexception";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="API(language) ERROR";}
	else if($od_code==""){$json["resultMessage"]="API(odcode) ERROR";}
	else{
		$delitype=$_GET["delitype"];
		if($delitype=="")$delitype="N";
		$sql=" update ".$dbH."_release set re_deliexception='".$delitype."' where re_odcode='".$od_code."'";
		dbcommit($sql);
		$returnData=$_GET["returnData"];

		$sql="select re_deliexception from ".$dbH."_release where re_odcode='".$od_code."' ";
		$dt=dbone($sql);
		$re_deliexception=$dt["RE_DELIEXCEPTION"];


		$json=array("apiCode"=>$apicode,"returnData"=>$returnData,"seq"=>$od_seq); //delete에서는 seq를 보내줘야 page의 값이 1이 아닌 해당하는 page로 나온다.
		$json["sql"]=$sql;
		$json["re_deliexception"]=$re_deliexception;
		$json["resultCode"]="200";
		$json["resultMessage"]="OK";
	}
?>