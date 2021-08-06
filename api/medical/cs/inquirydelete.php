<?php  
	///환자관리 > 삭제
	$apiCode=$_GET["apiCode"];
	$language=$_GET["language"];
	$seq=$_GET["seq"]; ///

	if($apiCode!="inquirydelete"){$json["resultMessage"]="API(apiCode) ERROR2";$apiCode="inquirydelete";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="API(language) ERROR";}
	else if(!$seq){$json["resultMessage"]="API(seq) ERROR";}
	else
	{
		$returnData=$_GET["returnData"];
		$searchtxt=$_GET["searchTxt"]; //검색단어

		$json=array("apiCode"=>$apiCode,"returnData"=>$returnData);

		$sql=" update ".$dbH."_board set bb_use='D', bb_modify=sysdate where bb_seq='".$seq."'";
		dbcommit($sql);
//echo $sql;

		$json["sql"]=$sql;
		$json["apiCode"]=$apiCode;
		$json["resultCode"]="200";
		$json["resultMessage"]="OK";

	}
?>