<?php //나의 처방 삭제
	$apiCode=$_GET["apiCode"];
	$language=$_GET["language"];
	$rc_seq=$_GET["seq"];

	if($apiCode!="mediuniqscdelete"){$json["resultMessage"]="API(apiCode) ERROR2";$apiCode="mediuniqscdelete";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="API(language) ERROR";}
	else
	{
		$sql=" update ".$dbH."_recipemember set rc_use='D', rc_modify =now() where rc_seq='".$rc_seq."'";
		dbqry($sql);
		//echo $sql;

		$json=array("apiCode"=>$apiCode,"returnData"=>$returnData);
		//$json["sql"]=$sql;
		$json["apiCode"]=$apiCode;
		$json["resultCode"]="200";
		$json["resultMessage"]="OK";
	}
?>