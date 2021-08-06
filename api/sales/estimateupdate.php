<?php
	$apicode=$resjson["apiCode"];
	$language=$resjson["language"];
	$esStaffid=$resjson["esStaffid"];
	if($apicode!="estimateupdate"){$json["resultMessage"]="API코드오류";$apicode="estimateupdate";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="언어코드오류";}
	else if($esStaffid==""){$json["resultMessage"]="userid 없음";}
	else{
		$esType=$resjson["esType"];
		$esCode=$resjson["esCode"];
		$esStaffid=$resjson["esStaffid"];
		$esCustomer=$resjson["esCustomer"];
		$esTitle=$resjson["esTitle"];
		$esAmount=$resjson["esAmount"];
		$jsonData=$resjson["jsonData"];
		$returnData=$resjson["returnData"];
		$json=array("apiCode"=>$apicode,"returnData"=>$returnData);
		if(!$esCode || $esCode=="add")$esCode="ES".date("YmdHis");
		$sql=" insert into ".$dbH."_estimate (es_type, es_code, es_customer, es_staffid, es_title, es_amount, es_data, es_use, es_date) values('".$esType."', '".$esCode."', '".$esCustomer."', '".$esStaffid."', '".$esTitle."', '".$esAmount."', '".$jsonData."', 'Y', now()) on duplicate key update es_title='".$esTitle."', es_customer='".$esCustomer."', es_amount='".$esAmount."', es_data='".$jsonData."', es_use='Y', es_modify=now()  ";
		$sqlall.=$sql;
		dbqry($sql);
		$json["sql"]=$sqlall;
		$json["resultCode"]="200";
		$json["resultMessage"]="OK";
	}
?>