<?php //MANAGER(layer-medical)
	$apicode=$_GET["apiCode"];
	$language=$_GET["language"];
	$medicalID=$_GET["medicalID"];

	if($apicode!="medicalimg"){$json["resultMessage"]="API(apiCode) ERROR";$apicode="medicalimg";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="API(language) ERROR";}
	else
	{
		//------------------------------------------------------------
		// DOO :: PackCode 테이블 목록 보여주기 위한 쿼리 추가 
		//------------------------------------------------------------
		$hPackCodeList = getPackCodeTitle($medicalID, "odPacktype,reBoxdeli,reBoxmedi");
		$reBoxmediList = getCodeList($hPackCodeList, 'reBoxmedi');//한약박스
		$reBoxdeliList = getCodeList($hPackCodeList, 'reBoxdeli');//배송포장재종류 
		$odPacktypeList = getCodeList($hPackCodeList, 'odPacktype');//파우치

		$json["reBoxmediList"]=$reBoxmediList;
		$json["reBoxdeliList"]=$reBoxdeliList;
		$json["odPacktypeList"]=$odPacktypeList;

		$json["apiCode"]=$apicode;
		$json["resultCode"]="200";
		$json["resultMessage"]="OK";
	}
?>