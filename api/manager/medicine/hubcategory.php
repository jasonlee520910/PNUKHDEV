<?php  
	///약재관리 > 본초관리 > 본초관리 분류 옵션
	$apiCode=$_GET["apiCode"];
	$language=$_GET["language"];
	$page=$_GET["page"];

	if($apiCode!="hubcategory"){$json["resultMessage"]="API(apiCode) ERROR";$apiCode="hubcategory";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="API(language) ERROR";}
	else
	{
		$returnData=$_GET["returnData"];
		$json=array("apiCode"=>$apiCode,"returnData"=>$returnData);
		$mc_code01=$_GET["mcCode"];

		$mCate2List = getMediCate($mc_code01);///분류2 리스트를 뽑아오기 위해 분류 1값을 보낸다 

		$json["mCate2List"]=$mCate2List;
		$json["sql"]=$sql;
		$json["resultCode"]="200";
		$json["resultMessage"]="OK";
	}
?>
