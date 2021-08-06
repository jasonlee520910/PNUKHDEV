<?php  
	/// 자재코드관리 > 장비관리 > 삭제
	$apicode=$_GET["apiCode"];
	$language=$_GET["language"];
	$mc_code=strtoupper(trim($_GET["mcCode"]));

	if($apicode!="equipmentcheckcode"){$_GET["resultMessage"]="API(apiCode) ERROR";$apicode="equipmentcheckcode";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="API(language) ERROR";}
	else if($mc_code==""){$_GET["resultMessage"]="API(seq) ERROR";}
	else
	{
		$returnData=$_GET["returnData"];
		$json=array("apiCode"=>$apicode,"returnData"=>$returnData);

		$sql=" select MC_CODE from ".$dbH."_MACHINE where MC_CODE='".$mc_code."'";
		$dt=dbone($sql);

		$json["mc_code"]=$mc_code;
		if($dt["MC_CODE"])
		{			
			$json["resultCode"]="199";
			$json["resultMessage"]="등록된 장비코드 입니다.";
		}
		else
		{
			$json["resultCode"]="200";
			$json["resultMessage"]="OK";
		}



		$json["sql"]=$sql;
	}
?>