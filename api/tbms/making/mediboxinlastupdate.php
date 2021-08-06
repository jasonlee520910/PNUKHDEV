<?php //스텝 등록/수정
	$apiCode=$_POST["apiCode"];
	$language=$_POST["language"];
	$odcode=$_POST["odcode"];

	if($apiCode!="mediboxinlastupdate"){$json["resultMessage"]="API(apiCode) ERROR";$apiCode="mediboxinlastupdate";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="API(language) ERROR";}
	//else if($odcode==""){$json["resultMessage"]="odcode없음";}
	else
	{
		$sql=" update ".$dbH."_making set ma_medibox_inlast='MDT0000000004', ma_modify=sysdate where ma_odcode='".$odcode."'";
		dbcommit($sql);

		$json["sql"]=$sql;
		$json["resultCode"]="200";
		$json["resultMessage"]="OK";
	}
?>