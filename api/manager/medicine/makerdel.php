<?php  
/*
	///약재관리 > 제조사관리 > 삭제
	$apiCode=$_GET["apiCode"];
	$language=$_GET["language"];
	$cd_seq=$_GET["seq"];

	if($apiCode!="makerdel"){$json["resultMessage"]="API(apiCode) ERROR";$apiCode="makerdel";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="API(language) ERROR";}
	else if($me_seq==""){$json["resultMessage"]="API(seq) ERROR";}
	else
	{
		$sql=" update ".$dbH."_maker set cd_use='D' where cd_seq='".$cd_seq."'";
		dbcommit($sql);

		$returnData=$_GET["returnData"];
		$json=array("apiCode"=>$apiCode,"returnData"=>$returnData);
		$json["resultCode"]="200";
		$json["resultMessage"]=$sql;
	}
	*/
?>