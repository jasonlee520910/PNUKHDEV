<?php
	$apiCode=$_GET["apiCode"];
	$language=$_GET["language"];
	$depart=$_GET["depart"];
	if($apiCode!="pilllist"){$json["resultMessage"]="API(apiCode) ERROR";$apiCode="pilllist";}
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


		$hCodeList=getCodeTitle('pillOrder');
		$pillOrderList=$hCodeList["pillOrder"];
		
		$pilllist=array();
		for($i=0;$i<count($pillOrderList);$i++)
		{
			$pilllist[$i]=array("type"=>$pillOrderList[$i]["cdCode"],"name"=>$pillOrderList[$i]["cdName"]);
		}


		$json["pilllist"] = $pilllist;
		$json["apiCode"] = $apiCode;
		$json["resultCode"]="200";
		$json["resultMessage"]="OK";

	}
?>