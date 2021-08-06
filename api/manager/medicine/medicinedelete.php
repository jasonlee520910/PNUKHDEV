<?php  
	///약재관리 > 약재목록_디제이메디 > 약재 삭제
	$apiCode=$_GET["apiCode"];
	$language=$_GET["language"];
	$md_seq=$_GET["seq"];

	if($apiCode!="medicinedelete"){$json["resultMessage"]="API(apiCode) ERROR";$apiCode="medicinedelete";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="API(language) ERROR";}
	else if($md_seq==""){$json["resultMessage"]="API(seq) ERROR";}
	else
	{
		$sql=" update ".$dbH."_medicine set md_use='D' where md_seq='".$md_seq."'";
		dbcommit($sql);

		$returnData=urldecode($_GET["returnData"]);
		$json=array("apiCode"=>$apiCode,"returnData"=>$returnData);
		$json["sql"]=$sql;
		$json["resultCode"]="200";
		$json["resultMessage"]="OK";
	}
?>