<?php  
	///사용자관리 > 한의원관리 > 소속 한의사 삭제
	$apiCode=$_GET["apiCode"];
	$language=$_GET["language"];
	$me_seq=$_GET["seq"];

	if($apiCode!="memberdelete"){$json["resultMessage"]="API(apiCode) ERROR";$apiCode="memberdelete";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="API(language) ERROR";}
	else if($me_seq==""){$json["resultMessage"]="API(seq) ERROR";}
	else
	{
		$sql=" update ".$dbH."_member set me_status='delete',  me_use='D' where me_seq='".$me_seq."'";
		dbcommit($sql);
		$returnData=$_GET["returnData"];
		$json=array("apiCode"=>$apiCode,"returnData"=>$returnData);
		$json["resultCode"]="200";
		$json["resultMessage"]=$sql;
	}
?>