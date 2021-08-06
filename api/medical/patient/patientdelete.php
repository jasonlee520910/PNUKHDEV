<?php  
	///환자관리 > 삭제
	$apiCode=$_GET["apiCode"];
	$language=$_GET["language"];
	$seq=$_GET["seq"]; ///

	if($apiCode!="patientdelete"){$json["resultMessage"]="API(apiCode) ERROR2";$apiCode="patientdelete";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="API(language) ERROR";}
	else if(!$seq){$json["resultMessage"]="API(seq) ERROR";}
	else
	{
		$returnData=$_GET["returnData"];
		$searchtxt=$_GET["searchTxt"]; //검색단어

		$json=array("apiCode"=>$apiCode,"returnData"=>$returnData);

		$sql=" update ".$dbH."_user set me_use='D' where me_seq='".$seq."'";
		dbcommit($sql);

		$json["sql"]=$sql;
		$json["apiCode"]=$apiCode;
		$json["resultCode"]="200";
		$json["resultMessage"]="OK";

	}
?>