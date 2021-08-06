<?php
	$apiCode=$_GET["apiCode"];
	$language=$_GET["language"];
	$depart=$_GET["depart"];
	if($apiCode!="goodslist"){$json["resultMessage"]="API(apiCode) ERROR";$apiCode="goodslist";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="API(language) ERROR";}
	else
	{
		
		//------------------------------------------------------------
		// DOO :: StepStat 
		//------------------------------------------------------------
		$step = getStepStat($depart);
		//------------------------------------------------------------

		//------------------------------------------------------------
		// DOO :: txtdt - 처음 한번만 부름.. 
		//------------------------------------------------------------
		$json["txtdt"]=getStepTxt($depart);
		//------------------------------------------------------------

		$json["step"] = $step;

		$json["apiCode"] = $apiCode;
		$json["resultCode"]="200";
		$json["resultMessage"]="OK";

	}
?>