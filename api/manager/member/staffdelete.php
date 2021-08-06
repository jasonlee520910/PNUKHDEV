<?php  
	///사용자관리 > 스탭관리 > 삭제
	$apiCode=$_GET["apiCode"];
	$language=$_GET["language"];
	$st_seq=$_GET["seq"];

	if($apiCode!="staffdelete"){$json["resultMessage"]="API(apiCode) ERROR";$apiCode="staffdelete";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="API(language) ERROR";}
	else if($st_seq==""){$json["resultMessage"]="API(seq) ERROR";}
	else
	{
		$sql=" update ".$dbH."_staff set st_status='delete',  st_use='D' where st_seq='".$st_seq."'";
		dbcommit($sql);

		$returnData=$_GET["returnData"];
		$json=array("apiCode"=>$apiCode,"returnData"=>$returnData);
		$json["resultCode"]="200";
		$json["resultMessage"]="OK";
	}
?>