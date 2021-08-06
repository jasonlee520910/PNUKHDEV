<?php  
	///약재관리 > 상극알람 > 상극알람 등록시 경고코드 중복체크
	$apiCode=$_GET["apiCode"];
	$language=$_GET["language"];
	$dm_code=$_GET["dmCode"];

	if($apiCode!="dismatchchk"){$json["resultMessage"]="API(apiCode) ERROR";$apiCode="dismatchchk";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="API(language) ERROR";}
	else if($dm_code==""){$json["resultMessage"]="API(dm_code) ERROR";}
	else
	{
		$returnData=$_GET["returnData"];
		$json=array("apiCode"=>$apiCode,"returnData"=>$returnData);
		
		$wsql=" where dm_code = '".$dm_code."' and dm_use<>'D' ";
		$sql=" select dm_seq, dm_code from ".$dbH."_medi_dismatch $wsql ";
		$dt=dbone($sql);
	

		$json=array(
			"seq"=>$dt["DM_SEQ"],
			"dmCode"=>$dt["DM_CODE"]
			);

		if($dt["DM_SEQ"]){
			$json["resultCode"]="200";
		}else{
			$json["resultCode"]="204";
		}

		$json["apiCode"]=$apiCode;
		$json["resultMessage"]="OK";
		$json["sql"]=$sql;
	}
?>