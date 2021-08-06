<?php  //약재함 중복체크
	//GET
	$apiCode=$_GET["apiCode"];
	$language=$_GET["language"];
	$mb_medicine=$_GET["mb_medicine"];
	$mb_table=$_GET["mb_table"];

	if($apicode!="mediboxchk"){$json["resultMessage"]="API(apiCode) ERROR";$apicode="mediboxchk";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="API(language) ERROR";}
	{
		$returnData=$_GET["returnData"];
		$json=array("apiCode"=>$apiCode,"returnData"=>$returnData);

		//해당약재코드와 조제대로 등록된 것이 있는 체크
		$sql=" select mb_seq, mb_code, mb_table from ".$dbH."_medibox where mb_medicine = '".$mb_medicine."' and mb_use = 'Y'  and mb_table = '".$mb_table."'";
		$dt=dbone($sql);

		$json=array("apiCode"=>$apiCode,"seq"=>$dt["mb_seq"],"sql"=>$sql);

		if($dt["mb_seq"]){
			$json["resultCode"]="200";
		}else{
			$json["resultCode"]="204";
		}
		$json["resultMessage"]="OK";
	}
?>


