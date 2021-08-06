<?php  
	///사용자관리 > 한의원관리 > 상세 보기 > 한의원 삭제
	$apiCode=$_GET["apiCode"];
	$language=$_GET["language"];
	$mi_seq=$_GET["seq"];

	if($apiCode!="medicaldelete"){$json["resultMessage"]="API(apiCode) ERROR";$apiCode="medicaldelete";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="API(language) ERROR";}
	else if($mi_seq==""){$json["resultMessage"]="miAPI(seq) ERROR";}
	else
	{
		$sql=" update ".$dbH."_medical set mi_use='D' where mi_seq='".$mi_seq."'";
		dbcommit($sql);
		$returnData=$_GET["returnData"];
		$json=array("apiCode"=>$apiCode,"returnData"=>$returnData);
		$json["resultCode"]="200";
		$json["resultMessage"]="OK";
	}
?>