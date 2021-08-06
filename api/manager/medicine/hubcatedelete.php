<?php  
	///약재관리 > 본초분류관리 > 본초분류목록 상세보기 후 삭제
	$apiCode=$_GET["apiCode"];
	$language=$_GET["language"];
	$mc_seq=$_GET["seq"];

	if($apiCode!="hubcatedelete"){$json["resultMessage"]="API(apiCode) ERROR";$apiCode="hubcatedelete";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="API(language) ERROR";}
	else if($mc_seq==""){$json["resultMessage"]="API(seq) ERROR";}
	else
	{
		$sql=" update ".$dbH."_medicate set mc_use='D' where mc_seq='".$mc_seq."'";
		dbcommit($sql);

		$returnData=$_GET["returnData"];
		$json=array("apiCode"=>$apiCode,"returnData"=>$returnData,"seq"=>$mc_seq);
		$json["resultCode"]="200";
		$json["resultMessage"]="OK";
	}
?>