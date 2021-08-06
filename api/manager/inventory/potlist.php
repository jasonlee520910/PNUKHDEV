<?php  
	/// 자재코드관리 > 탕전기관리 > 리스트
	$apiCode=$_GET["apiCode"];
	$language=$_GET["language"];
	$page=$_GET["page"];

	if($apiCode!="potlist"){$json["resultMessage"]="API(apiCode) ERROR";$apiCode="potlist";}
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

		$jsql=" a left join ".$dbH."_staff b on a.bo_staff=b.st_staffid ";
		$wsql=" where a.bo_use='Y' ";

		if($searchstatus){
			$arr=explode(",",$searchstatus);
			if(count($arr)>1){
				$wsql.=" and ( ";
				for($i=1;$i<count($arr);$i++){
					if($i>1)$wsql.=" or ";
					$wsql.=" bo_status = '".$arr[$i]."' ";
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
			$wsql.=" a.bo_code like '%".$searchtxt."%' ";//탕전바코드
			$wsql.=" or ";
			$wsql.=" a.bo_model like '%".$searchtxt."%' ";//모델명
			$wsql.=" or ";
			$wsql.=" a.bo_locate like '%".$searchtxt."%' ";//위치
			$wsql.=" or ";
			$wsql.=" b.st_name like '%".$searchtxt."%' ";//탕전사
			$wsql.=" ) ";
		}

		$pg=apipaging("a.bo_code","boiler",$jsql,$wsql);

		$sql=" select * from (";
		$sql.=" select ROW_NUMBER() OVER (ORDER BY a.bo_seq desc) NUM ";		
		$sql.=" ,a.bo_seq,a.bo_code,a.bo_odcode,a.bo_title,a.bo_model,a.bo_locate,a.bo_staff,to_char(a.bo_date,'yyyy-mm-dd') as BODATE";
		$sql.=" ,a.bo_status,a.bo_top,a.bo_left ";
		$sql.=" ,b.st_name "; 
		$sql.=" from ".$dbH."_boiler  $jsql $wsql  ";
		$sql.=" order by a.bo_code desc ";
		$sql.=" ) where NUM>".$pg["snum"]." and NUM<=".$pg["tlast"];
		$res=dbqry($sql);

		$json["page"]=$pg["page"];
		$json["tcnt"]=$pg["tcnt"];
		$json["tpage"]=$pg["tpage"];
		$json["psize"]=$pg["psize"];
		$json["block"]=$pg["block"];
		$json["list"]=array();

		while($dt=dbarr($res))
		{

			$bostaff = ($dt["BO_STAFF"]) ? $dt["BO_STAFF"] : "-";
			$stName = ($dt["ST_NAME"]) ? $dt["ST_NAME"] : "-";

			$str=potstat($dt["BO_STATUS"]);
			$addarray=array(
				"seq"=>$dt["BO_SEQ"], 
				"boCode"=>$dt["BO_CODE"], 
				"boModel"=>$dt["BO_MODEL"], 
				"boTitle"=>$dt["BO_TITLE"], 
				"boLocate"=>$dt["BO_LOCATE"], 
				"boTop"=>$dt["BO_TOP"], 
				"boLeft"=>$dt["BO_LEFT"], 
				"boStatus"=>$dt["BO_STATUS"], 
				"boStatusName"=>$str, 
				"boStaff"=>$bostaff, 
				"stName"=>$stName, 
				"boDate"=>$dt["BODATE"]
				);
			array_push($json["list"], $addarray);
		}

		$hCodeList = getNewCodeTitle('boStatus');
		$boStatusList = getCodeList($hCodeList, 'boStatus');//탕전기상태 
		$json["boStatusList"]=$boStatusList;

		//----------------------------------------------------------------------
		/// 탕전사 뽑아오기 
		$jsql=" a  ";
		$wsql="  where st_use <>'D' and a.st_depart = 'decoction' ";
		$ssql=" a.st_staffid, a.st_name, a.st_depart ";
		$sql2=" select * from ".$dbH."_staff $jsql $wsql order by st_seq ";
		$res=dbqry($sql2);

		$json["decolist"]=array();
		while($dt=dbarr($res))
		{
			$addarray=array(
				"stStaffid"=>$dt["ST_STAFFID"], 
				"stUserid"=>$dt["ST_USERID"],
				"stName"=>$dt["ST_NAME"],  
				"stDepart"=>$dt["ST_DEPART"]
				);
			array_push($json["decolist"], $addarray);
		}
		//----------------------------------------------------------------------

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