<?php
	$apiCode=$_GET["apiCode"];
	$language=$_GET["language"];
	$depart=$_GET["depart"];
	if($apiCode!="markinglist"){$json["resultMessage"]="API(apiCode) ERROR";$apiCode="markinglist";}
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

		$json["markingPrinterList"] = getMarkingPrinter();
		$json["step"] = $step;

		$json["apiCode"] = $apiCode;
		$json["resultCode"]="200";
		$json["resultMessage"]="OK";

	}
	//=========================================================================
	//  함수 명     : getMarkingPrinter()
	//  함수 설명   : 마킹프린터 
	//=========================================================================
	function getMarkingPrinter()
	{
		global $language;
		global $dbH;

		$list = array();
		
		$sql=" select a.mp_code, a.mp_title, a.mp_ip, a.mp_port, a.mp_status, a.mp_staff, b.cd_name_".$language." mpStateName from ".$dbH."_markingprinter a left join han_code b on b.cd_type='mpStatus' and b.cd_code=a.mp_status  ";
		$sql.=" where a.mp_use ='Y' order by a.MP_CODE ASC ";
		$res=dbqry($sql);
		while($dt=dbarr($res))
		{
			$addarray = array(
				"mpCode"=>$dt["MP_CODE"],
				"mpTitle"=>$dt["MP_TITLE"], 
				"mpStatus"=>$dt["MP_STATUS"], 
				"mpStaff"=>$dt["MP_STAFF"],
				"mpIp"=>$dt["MP_IP"],
				"mpPort"=>$dt["MP_PORT"],
				"mpStateName"=>$dt["MPSTATENAME"]
				);

			array_push($list, $addarray);
		}

		return $list;
	}
?>