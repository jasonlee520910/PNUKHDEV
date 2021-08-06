<?php
	/// 20200403 : 조제에 관련된 리스트 
	$apiCode=$_GET["apiCode"];
	$language=$_GET["language"];
	$depart=$_GET["depart"];
	if($apiCode!="makinglist"){$json["resultMessage"]="API(apiCode) ERROR";$apiCode="makinglist";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="API(language) ERROR";}
	else
	{
		
		///------------------------------------------------------------
		/// DOO :: StepStat 
		///------------------------------------------------------------
		$step = getStepStat($depart);
		///------------------------------------------------------------

		///------------------------------------------------------------
		/// DOO :: 조제대  
		///------------------------------------------------------------
		$makingTableList = getMakingTable();
		///------------------------------------------------------------

		///------------------------------------------------------------
		/// DOO :: txtdt - 처음 한번만 부름.. 
		///------------------------------------------------------------
		$json["txtdt"]=getStepTxt($depart);
		///------------------------------------------------------------

		$json["makingTableList"] = $makingTableList;
		$json["step"] = $step;

		$json["apiCode"] = $apiCode;
		$json["resultCode"]="200";
		$json["resultMessage"]="OK";

	}

	///=========================================================================
	///  함수 명     : getMakingTable()
	///  함수 설명   : 조제대  
	///=========================================================================
	function getMakingTable()
	{
		global $language;
		global $dbH;

		$list = array();
		$wsql=" where mt_use <> 'D' ";
		$sql=" select mt_code,mt_title,mt_status,mt_staff from ".$dbH."_makingtable $wsql  order by mt_code asc ";

		$res=dbqry($sql);
		while($dt=dbarr($res))
		{
			$addarray = array(
				"mtCode"=>$dt["MT_CODE"],
				"mtTitle"=>$dt["MT_TITLE"], 
				"mtStatus"=>$dt["MT_STATUS"], 
				"mtStaff"=>$dt["MT_STAFF"]
				);

			array_push($list, $addarray);
		}

		return $list;
	}


?>