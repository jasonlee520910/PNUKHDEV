<?php 
	$apiCode=$_GET["apiCode"];
	$language=$_GET["language"];
	$seq=$_GET["seq"];
	
	if($apiCode!="boarddelete"){$json["resultMessage"]="API(apiCode) ERROR";$apiCode="boarddelete";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="API(language) ERROR";}
	else
	{
		
		$bb_type=$_GET["bb_type"];
		//echo $bb_type;
		$sql=" update ".$dbH."_board set bb_use='D' where bb_seq='".$seq."'";
		//echo $sql;
		dbcommit($sql);	

		$returnData=$_GET["returnData"];
		$json=array("apiCode"=>$apicode,"returnData"=>$returnData,"seq"=>$seq,"bb_type"=>$bb_type);
		$json["resultCode"]="200";
		$json["resultMessage"]="OK";
		
	}
?>