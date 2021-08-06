<?php
	//GET
	$apiCode=$_GET["apiCode"];
	$language=$_GET["language"];

	if($apiCode!="ordercanceltype"){$json["resultMessage"]="API(apiCode) ERROR";$apiCode="ordercanceltype";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="API(language) ERROR";}
	else
	{

		$returnData=$_GET["returnData"];

		//------------------------------------------------------------
		// DOO :: Code 테이블 목록 보여주기 위한 쿼리 추가 
		//------------------------------------------------------------
		$hCodeList = getNewCodeTitle("cancelType");
		//------------------------------------------------------------
		$cancelTypeList = getCodeList($hCodeList, 'cancelType');//취소사유리스트 

		$json=array(
				"cancelTypeList"=>$cancelTypeList //취소사유리스트 
			);
		

		$json["apiCode"]=$apiCode;
		$json["returnData"]=$returnData;
		$json["resultCode"]="200";
		$json["resultMessage"]="OK";
	}
?>
