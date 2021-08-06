<?php
	$apiCode=$_GET["apiCode"];
	$language=$_GET["language"];
	$depart=$_GET["depart"];
	if($apiCode!="decoctionlist"){$json["resultMessage"]="API(apiCode) ERROR";$apiCode="decoctionlist";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="API(language) ERROR";}
	else
	{
		
		//------------------------------------------------------------
		// DOO :: StepStat 
		//------------------------------------------------------------
		$step = getStepStat($depart);
		//------------------------------------------------------------

		$json["step"] = $step;

		//------------------------------------------------------------
		// DOO :: txtdt - 처음 한번만 부름.. 
		//------------------------------------------------------------
		$json["txtdt"]=getStepTxt($depart);
		//------------------------------------------------------------

		$json["apiCode"] = $apiCode;
		$json["resultCode"]="200";
		$json["resultMessage"]="OK";

	}
?>