<?php  
	/// 자재코드관리 > 탕전기관리 > 리스트
	$apiCode=$_GET["apiCode"];
	$language=$_GET["language"];
	$page=$_GET["page"];

	if($apiCode!="equipmentlist"){$json["resultMessage"]="API(apiCode) ERROR";$apiCode="equipmentlist";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="API(language) ERROR";}
	else
	{
		$returnData=$_GET["returnData"];
		$json=array("apiCode"=>$apiCode,"returnData"=>$returnData);
		$searperiodtype=$_GET["searPeriodType"];
		$searchperiod=$_GET["searchPeriod"];
		$searchstatus=$_GET["searchStatus"];
		$searchtype=$_GET["searchType"];
		$searchtxt=$_GET["searchTxt"];

		$jsql=" a left join ".$dbH."_staff b on a.MC_STAFF=b.st_staffid ";
		$jsql.=" left join han_code c on c.cd_type='eqGroup' and c.cd_code=a.MC_GROUP ";
		$jsql.=" left join han_code d on d.cd_type='eqType' and d.cd_code=a.MC_TYPE " ;
		$wsql=" where a.MC_USE='Y' ";

		if($searchstatus){
			$arr=explode(",",$searchstatus);
			if(count($arr)>1){
				$wsql.=" and ( ";
				for($i=1;$i<count($arr);$i++){
					if($i>1)$wsql.=" or ";
					$wsql.=" a.MC_STATUS = '".$arr[$i]."' ";
				}
				$wsql.=" ) ";
			}
		}

		if($searchtype&&$searchtype!="all"&&$searchtxt){
			$field=substr($searchtype,0,2)."_".strtolower(substr($searchtype,2,20));
			$wsql.=" and ".$field." like '%".$searchtxt."%' ";
		}

		if($searchtxt)
		{
			$wsql.=" and ( ";
			$wsql.=" a.MC_CODE like '%".$searchtxt."%' ";//탕전바코드
			$wsql.=" or ";
			$wsql.=" a.MC_MODEL like '%".$searchtxt."%' ";//모델명
			$wsql.=" or ";
			$wsql.=" a.MC_LOCATE like '%".$searchtxt."%' ";//위치
			$wsql.=" or ";
			$wsql.=" b.st_name like '%".$searchtxt."%' ";//
			$wsql.=" ) ";
		}

		$pg=apipaging("a.MC_CODE","MACHINE",$jsql,$wsql);

		$sql=" select * from (";
		$sql.=" select ROW_NUMBER() OVER (ORDER BY a.mc_seq desc) NUM ";		
		$sql.=" ,a.MC_SEQ,a.MC_CODE,a.MC_GROUP, a.MC_TYPE, a.MC_ODCODE,a.MC_TITLE,a.MC_MODEL,a.MC_LOCATE,a.MC_STAFF,to_char(a.MC_DATE,'yyyy-mm-dd') as MCDATE";
		$sql.=" ,a.MC_STATUS,a.MC_TOP,a.MC_LEFT ";
		$sql.=" ,b.st_name , c.cd_name_kor as mcGroupName, d.cd_name_kor as mcTypeName "; 
		$sql.=" from ".$dbH."_MACHINE  $jsql $wsql  ";
		$sql.=" order by a.mc_seq desc ";
		$sql.=" ) where NUM>".$pg["snum"]." and NUM<=".$pg["tlast"];
		$res=dbqry($sql);

		$json["page"]=$pg["page"];
		$json["tcnt"]=($pg["tcnt"])?$pg["tcnt"]:0;
		$json["tpage"]=$pg["tpage"];
		$json["psize"]=$pg["psize"];
		$json["block"]=$pg["block"];
		$json["list"]=array();

		while($dt=dbarr($res))
		{

			$mcstaff = ($dt["MC_STAFF"]) ? $dt["MC_STAFF"] : "-";
			$stName = ($dt["ST_NAME"]) ? $dt["ST_NAME"] : "-";

			$str=potstat($dt["MC_STATUS"]);
			$addarray=array(
				"seq"=>$dt["MC_SEQ"], 
				"mcGroupName"=>$dt["MCGROUPNAME"], 
				"mcTypeName"=>$dt["MCTYPENAME"], 
				"mcGroup"=>$dt["MC_GROUP"], 
				"mcType"=>$dt["MC_TYPE"], 
				"mcCode"=>trim($dt["MC_CODE"]), 
				"mcModel"=>$dt["MC_MODEL"], 
				"mcTitle"=>$dt["MC_TITLE"], 
				"mcLocate"=>$dt["MC_LOCATE"], 
				"mcTop"=>$dt["MC_TOP"], 
				"mcLeft"=>$dt["MC_LEFT"], 
				"mcStatus"=>$dt["MC_STATUS"], 
				"mcStatusName"=>$str, 
				"mcStaff"=>$mcstaff, 
				"stName"=>$stName, 
				"mcDate"=>$dt["MCDATE"]
				);
			array_push($json["list"], $addarray);
		}

		$hCodeList = getNewCodeTitle('eqType,eqGroup,boStatus');
		$eqGroupList = getCodeList($hCodeList, 'eqGroup');//장비그룹
		$eqTypeList = getCodeList($hCodeList, 'eqType');//장비종류
		$mcStatusList = getCodeList($hCodeList, 'boStatus');//상태  
		

		$json["eqTypeList"]=$eqTypeList;//장비그룹
		$json["eqGroupList"]=$eqGroupList;//장비코드 
		$json["mcStatusList"]=$mcStatusList;//장비코드 

		$json["sql"]=$sql;
		$json["sql2"]=$sql2;
		$json["apiCode"]=$apiCode;
		$json["resultCode"]="200";
		$json["resultMessage"]="OK";
	}

	///탕전기관리 상태 한글 변환
	function potstat($code)
	{
		$str = $code;
		switch($code){
			case "standby":$str="대기";break;
			case "ready":$str="준비중";break;
			case "ing":$str="사용중";break;
			case "end":$str="완료";break;
			case "repair":$str="고장수리중";break;
			case "disposal":$str="폐기";break;
			default:
		}
		return $str;
	}
?>