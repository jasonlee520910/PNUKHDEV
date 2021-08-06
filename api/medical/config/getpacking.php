<?php
	$apiCode=$_GET["apiCode"];
	$language=$_GET["language"];
	$medicalId=$_GET["medicalId"];

	if($apiCode!="getpacking"){$json["resultMessage"]="API(apiCode) ERROR";$apiCode="getpacking";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="API(language) ERROR";}
	else
	{

		$returnData=$_GET["returnData"];
		$json["apiCode"]=$apiCode;
		$json["medicalId"]=$medicalId;

		$hPackCodeList = getPackCodeTitle($medicalId, "odPacktype,reBoxdeli,reBoxmedi");
		$reBoxmediList = getCodeList($hPackCodeList, 'reBoxmedi');///한약박스
		$reBoxdeliList = getCodeList($hPackCodeList, 'reBoxdeli');///배송포장재종류 
		$odPacktypeList = getCodeList($hPackCodeList, 'odPacktype');///파우치
		$json["data"]=array("boxmedi"=>$reBoxmediList,"boxdeli"=>$reBoxdeliList,"packtype"=>$odPacktypeList);
		$json["hPackCodeList"]=$hPackCodeList;
		$json["returnData"]=$returnData;
		$json["resultCode"]="200";
		$json["resultMessage"]="OK";
	}
?>
