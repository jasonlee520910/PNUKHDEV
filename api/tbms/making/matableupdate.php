<?php //스텝 등록/수정
	$apiCode=$_POST["apiCode"];
	$language=$_POST["language"];
	$maTable=$_POST["maTable"];

	if($apiCode!="matableupdate"){$json["resultMessage"]="API(apiCode) ERROR";$apiCode="matableupdate";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="API(language) ERROR";}
	else
	{
		$sql ="update ".$dbH."_makingtable set mt_outtime=sysdate, mt_status='ready' where mt_code = '".$maTable."'";
		dbcommit($sql);

		$json["sql"]=$sql;
		$json["apiCode"]=$apiCode;
		$json["resultCode"]="200";
		$json["resultMessage"]="OK";
	}
?>