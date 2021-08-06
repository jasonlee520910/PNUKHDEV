<?php
	/// 환경설정 > 개인정보처리 > 순서변경 
	$json["resultCode"]="204";
	$apicode=$_POST["apiCode"];
	$language=$_POST["language"];
	$poGroup=$_POST["poGroup"];
	

	if($apicode!="policyorderchange"){$json["resultMessage"]="API(apiCode) ERROR";$apicode="policyorderchange";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="API(language) ERROR";}
	else
	{
		
		$returnData=$_POST["returnData"];

		$json=array("apiCode"=>$apicode,"returnData"=>$returnData);
		$sql="";

		$arr = array();
		$poOrderData=urldecode($_POST["poOrderData"]);
		parse_str($poOrderData, $arr);

		$json["policyTbl"]=$arr["policyTbl"];

		foreach ($arr["policyTbl"] as $key=>$value) 
		{
			$sql="UPDATE ".$dbH."_POLICY SET PO_SORT = ".($key+1)." WHERE PO_SEQ = ".$value;
			dbcommit($sql);
			$json["sql".($key)]=$sql;
		}

		
		$json["resultCode"]="200";
		$json["resultMessage"]="OK";
	}

?>