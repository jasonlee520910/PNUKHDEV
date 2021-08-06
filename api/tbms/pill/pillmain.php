<?php
	$apiCode=$_GET["apiCode"];
	$language=$_GET["language"];
	$code=$_GET["code"];
	$pilltype=$_GET["plType"];
	if($apiCode!="pillmain"){$json["resultMessage"]="API(apiCode) ERROR";$apiCode="pillmain";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="API(language) ERROR";}
	else if($code==""){$json["resultMessage"]="API(code) ERROR";}
	else if($pilltype==""){$json["resultMessage"]="API(pilltype) ERROR";}
	else
	{
		$sql=" select 
			a.PL_MACHINESTAT , a.PL_MACHINE , a.PL_STATUS 
			, b.OD_TITLE, b.OD_MEDITYPE, b.OD_GOODS, b.OD_QTY, b.OD_PILLCAPA, b.OD_REQUEST 
			, c.RC_PILLORDER, c.RC_MEDICINE
			from han_pill 
			a inner join han_order b on b.OD_KEYCODE=a.PL_KEYCODE
			inner join han_recipeuser c on c.RC_CODE=b.OD_SCRIPTION 
			where a.PL_BARCODE='".$code."' ";

		$dt=dbone($sql);

		$hCodeList=getCodeTitle('pillOrder');
		$pillOrderList=$hCodeList["pillOrder"];

		//장비리스트
		$machineList=getMachineList($pilltype);
		$pilltypeName=getPillTypeName($pillOrderList, $pilltype);

		$od_request=getClob($dt["OD_REQUEST"]);

		
		$plMachinestat=$dt["PL_MACHINESTAT"];

		//pillorder 데이터 		
		$rcPillorder=getClob($dt["RC_PILLORDER"]);
		$gdPillorder=json_decode($rcPillorder, true);
		$gdPilllist=$gdPillorder["pilllist"];


		

		//나중에 정리좀 하자 
		if($pilltype=="making")
		{
			$medicineList=$gdPillorder["pillmedicine"];
		}
		else
		{

			$medicineList=array();
			$pkey=$gdPilllist[$pilltype]["key"];
			$porder=$gdPilllist[$pilltype]["order"];
			if(strpos($plMachinestat, "_processing") !== false) 
			{
				$pname=$porder["name"];
				$poutcapa=$porder["outcapa"];
				$medicine=array("code"=>$pkey, "name"=>$pname, "capa"=>$poutcapa);
				$medilist[$pkey]=$medicine;
			}
			else
			{
				$pmedicine=$porder["order"]["medicine"];
				for($j=0;$j<count($pmedicine);$j++)
				{
					$type=$pmedicine[$j]["type"];
					if($type!="material")
					{
						$code=$pmedicine[$j]["code"];
						$medicine=$pmedicine[$j];
						if (in_array($code, $medilist)==false) 
						{
							$medicapa=$medilist[$code]["capa"];
							$medicine["capa"]+=$medicapa;
						}

						$medilist[$code]=$medicine;
					}
				}
			}
			
			foreach($medilist as $key => $value)
			{
				array_push($medicineList,$medilist[$key]);
			}
		}
		
		$rcMedicineCnt=count($medicineList);

		

		//work
		$packinglist=array();
		$incapa=$outcapa=0;
		$worktxt="";
				
		$porder=$gdPilllist[$pilltype]["order"];
		$ptype=$gdPilllist[$pilltype]["order"]["type"];
		$pwork=$gdPilllist[$pilltype]["order"]["order"]["work"];

		$incapa=$gdPilllist[$pilltype]["order"]["incapa"];
		$outcapa=$gdPilllist[$pilltype]["order"]["outcapa"];
		foreach($pwork as $key => $valwork)
		{
			$pwcode=$valwork["code"];
			$pwcodetxt=$valwork["codetxt"];
			$pwvalue=$valwork["value"];
			$pwvaluetxt=$valwork["valuetxt"];
			
			switch($pwcode)
			{
			case "plPacking"://포장
				$plist=getPackingData($pwvalue);
				array_push($packinglist,$plist);
				break;
			default:
				$worktxt.="|".$pwcodetxt.",".$pwvaluetxt;
				break;
			}
		}

			



		$json=array(
			"plStatus"=>$dt["PL_STATUS"], 
			"plMachinestat"=>$plMachinestat, 
			"plMachine"=>$dt["PL_MACHINE"],
			"pilltypeName"=>$pilltypeName,

			"pilltype"=>$pilltype,

			//투입량
			"incapa"=>$incapa, 
			//산출량 
			"outcapa"=>$outcapa, 

			//오리지널투입량
			"originincapa"=>$incapa, 
			//오리지널착출량 
			"originoutcapa"=>$outcapa, 

			//장비리스트
			"machineList"=>$machineList,
			//약재리스트 
			"medicineList"=>$medicineList,
			
			"odTitle"=>$dt["OD_TITLE"], 
			"odMeditype"=>$dt["OD_MEDITYPE"], 
			"odGoods"=>$dt["OD_GOODS"], 
			"odQty"=>$dt["OD_QTY"], 
			"odPillcapa"=>$dt["OD_PILLCAPA"], 
			"odRequest"=>$od_request,
			"rcPillorder"=>$rcPillorder, 
			"gdPilllist"=>$gdPilllist,

			"worktxt"=>$worktxt,


			"rcMedicine"=>getClob($dt["RC_MEDICINE"]),




			"packingList"=>$packinglist

			);

	
		$json["apiCode"] = $apiCode;
		$json["sql"] = $sql;
		$json["resultCode"]="200";
		$json["resultMessage"]="OK";

	}





?>
<?php
	function getMachineList($pilltype)
	{
		if($pilltype=="stir") //교반이면 혼합장비리스트 가져온다
		{
			$pilltype="mixed";
		}
		$sql=" select 
				a.MC_GROUP, a.MC_TYPE, a.MC_SEQ, a.MC_CODE, a.MC_ODCODE, a.MC_TITLE, a.MC_TOP, a.MC_LEFT, a.MC_STATUS, b.cd_name_kor as mcStatusName
				from HAN_MACHINE 
				a left join han_code b on b.cd_type='boStatus' and b.cd_code=a.mc_status 
				where a.mc_use<>'D' and a.MC_GROUP='".$pilltype."'
				order by a.mc_group desc, a.mc_seq asc  ";
		$res=dbqry($sql);
		$list=array();
		$blist=array();
		while($dt=dbarr($res))
		{
			$addarray=array(
				"mcGroup"=>$dt["MC_GROUP"],
				"mcType"=>$dt["MC_TYPE"],
				"mcSeq"=>$dt["MC_SEQ"],
				"mcCode"=>$dt["MC_CODE"],
				"mcOdcode"=>$dt["MC_ODCODE"],
				"mcTitle"=>$dt["MC_TITLE"],
				"mcTop"=>$dt["MC_TOP"],
				"mcLeft"=>$dt["MC_LEFT"],
				"mcStatus"=>$dt["MC_STATUS"],
				"mcStatusName"=>$dt["MCSTATUSNAME"]
				);
			array_push($blist[$dt["MC_TYPE"]]=$addarray);
			$list[$dt["MC_TYPE"]][]=$blist[$dt["MC_TYPE"]];
		}
		return $list;

	}
	
	/*function getCodeData($type, $code)
	{
		$csql=" select CD_TYPE, CD_NAME_KOR as cdName from han_code where CD_TYPE='".$type."' and CD_CODE='".$code."' ";
		$cdt=dbone($csql);
		$name=($cdt["CDNAME"])?$cdt["CDNAME"]:"";
		return $name;
	}*/
	function getPackingData($code)
	{
		$csql=" select
				a.GD_NAME_KOR as GDNAME, b.AF_URL 
				from han_goods a
				left join han_file b on b.AF_FCODE=a.GD_CODE and b.AF_CODE='goods'
				where a.GD_CODE='".$code."' ";
		$cdt=dbone($csql);

		$name=($cdt["GDNAME"])?$cdt["GDNAME"]:"";
		$file=getafThumbUrl($cdt["AF_URL"]);
		$addarry=array(
			"name"=>$name,
			"file"=>$file
			);

		return $addarry;
	}
?>
