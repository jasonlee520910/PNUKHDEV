<?php  //release orderlist
	$apiCode=$_GET["apiCode"];
	$language=$_GET["language"];
	$wktype=$_GET["wktype"];
	$page=$_GET["page"];
	$depart=$_GET["depart"];
	$process=$_GET["process"];
	$period=$_GET["period"];
	$staffid=$_GET["staffid"];
	$pillType=$_GET["pillType"];

	if($apiCode!="orderlist"){$json["resultMessage"]="API(apiCode) ERROR";$apiCode="orderlist";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="API(language) ERROR";}
	else
	{
		$jsql=" a inner join han_pill b on b.PL_KEYCODE=a.OD_KEYCODE ";
		$jsql.=" inner join han_medical c on c.mi_userid=a.od_userid ";
		$jsql.=" inner join han_release d on d.RE_KEYCODE=a.OD_KEYCODE ";

		$wsql="  where a.od_use in ('Y','C') ";
		$wsql.=" and (b.PL_STAFFID='' or b.PL_STAFFID is null or b.PL_STAFFID='".$staffid."') ";
		$wsql.=" and b.PL_MACHINESTAT like '".$pillType."%' ";

		$pg=apipaging("a.od_seq","order",$jsql,$wsql);

		$json["page"]=$pg["page"];
		$json["tcnt"]=$pg["tcnt"];
		$json["tpage"]=$pg["tpage"];
		$json["psize"]=$pg["psize"];
		$json["block"]=$pg["block"];
		$json["list"]=array();

		$sql=" select * from ( ";
		$sql.=" select ROW_NUMBER() OVER (order by decode(a.od_status,'order','paid','pill_processing','pill_start','pill_apply','pill_stop','pill_cancel','done'), to_char(a.od_date, 'yyyy-mm-dd hh24:mi:ss') desc) NUM ,  to_char(a.od_date, 'yyyy-mm-dd hh24:mi:ss') as odDate, a.od_code, a.od_title,c.MI_NAME,d.RE_NAME,b.PL_MACHINESTAT  ";
		$sql.=" from ".$dbH."_order $jsql $wsql $osql $lsql";
		$sql.=" ) where NUM>".$pg["snum"]." and NUM<=".$pg["tlast"];


		$res=dbqry($sql);

		//------------------------------------------------------------
		// DOO :: Code 테이블 목록 보여주기 위한 쿼리 추가 
		//------------------------------------------------------------
		$hCodeList=getCodeTitle('pillOrder,odStatus');
		$pillOrderList=$hCodeList["pillOrder"];
		$odStatusList=$hCodeList["odStatus"];
		//------------------------------------------------------------

		//$json["list"]=$res;
		while($dt=dbarr($res))
		{
			//------------------------------------------------------------
			// DOO :: 주문상태 보여주기 위한 쿼리 추가 
			//------------------------------------------------------------
			$odStatus = getmachineStatus($odStatusList, $pillOrderList, $dt["PL_MACHINESTAT"], 'true');
			//------------------------------------------------------------
			$addarray=array(
					"odDate"=>$dt["ODDATE"], //작업지시일
					"odCode"=>$dt["OD_CODE"], //주문코드
					"company"=>$dt["MI_NAME"],  //한의원
					"reName"=>$dt["RE_NAME"],  //주문자
					"odTitle"=>$dt["OD_TITLE"], //처방명			
					"odStatusName"=>$odStatus //주문상태	
			);
			array_push($json["list"], $addarray);
		}

		
		$json["sql"] = $sql;
		$json["hCodeList"] = $hCodeList;
		$json["apiCode"] = $apiCode;
		$json["resultCode"]="200";
		$json["resultMessage"]="OK";


	}

	function getmachineStatus($odlist, $polist, $status, $color='false')
	{
		$chkstat=explode("_",$status);
		$substat=$chkstat[0];
		$substat2=$chkstat[1];

		for($i=0;$i<count($polist);$i++)
		{
			if($polist[$i]["cdCode"] == $substat)
			{
				$statName = $polist[$i]["cdName"];
			}
		}

		for($i=0;$i<count($odlist);$i++)
		{
			if($odlist[$i]["cdCode"] == $substat2)
			{
				if($substat2 == 'stop')
				{
					$statName2="<span style=color:purple;'>".$odlist[$i]["cdName"]."</span>";
				}
				else if($substat2 == 'cancel')
				{
					$statName2="<span style=color:red;'>".$odlist[$i]["cdName"]."</span>";
				}
				else
				{
					$statName2 = $odlist[$i]["cdName"];
				}
			}
		}
		return $statName." ".$statName2;

	}
?>