<?php  
	/// 자재코드관리 > 장비관리 > 삭제
	$apicode=$_GET["apiCode"];
	$language=$_GET["language"];
	$mc_seq=$_GET["seq"];

	if($apicode!="equipmentdelete"){$_GET["resultMessage"]="API(apiCode) ERROR";$apicode="equipmentdelete";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="API(language) ERROR";}
	else if($mc_seq==""){$_GET["resultMessage"]="API(seq) ERROR";}
	else
	{
		$sql=" update ".$dbH."_MACHINE set MC_USE='D' where mc_seq='".$mc_seq."'";
		dbcommit($sql);

		$returnData=$_GET["returnData"];
		$json=array("apiCode"=>$apicode,"returnData"=>$returnData);
		$json["resultCode"]="200";
		$json["resultMessage"]="OK";
		$json["sql"]=$sql;
	}
?>