<?php
	$apiCode=$_GET["apiCode"];
	$language=$_GET["language"];

	$depart=$_GET["depart"];
	$medigroup=$_GET["medigroup"];
	$code=$_GET["code"];
	$odcode=$_GET["odcode"];
	$nextmedigroup=$_GET["nextmedigroup"];
	
			
	if($apiCode!="checkmedipocket"){$json["resultMessage"]="API(apiCode) ERROR";$apiCode="checkmedipocket";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="API(language) ERROR";}
	else
	{
		$sql=" select pt_group, pt_name1 from ".$dbH."_pouchtag where pt_code='".$code."' ";
		$dt=dbone($sql);

		$json["data"]["pt_group"] = $dt["PT_GROUP"];
		$json["data"]["pt_name"] = $dt["PT_NAME1"];

		if($dt["PT_GROUP"]==$medigroup)
		{
			$sql=" update ".$dbH."_making set ma_medibox_".$medigroup."='".$code."', ma_medicine=null where ma_odcode='".$odcode."'";
			dbcommit($sql);
		}

		$json["data"]["depart"] = $depart;
		$json["data"]["medigroup"] = $medigroup;
		$json["data"]["code"] = $code;
		$json["data"]["odcode"] = $odcode;
		$json["data"]["nextmedigroup"] = $nextmedigroup;		

		$json["apiCode"] = $apiCode;
		$json["resultCode"]="200";
		$json["resultMessage"]="OK";
	}
?>