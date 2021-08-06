<?php  
	/// 자재코드관리 > 조제대관리 > 리스트
	$apiCode=$_GET["apiCode"];
	$language=$_GET["language"];
	$page=$_GET["page"];
	$mt_seq=$_GET["seq"];

	if($apiCode!="makingtablelist"){$json["resultMessage"]="API(apiCode) ERROR";$apiCode="makingtablelist";}
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

		$jsql=" a left join ".$dbH."_staff b on a.mt_staff=b.st_staffid ";
		$wsql=" where mt_use='Y' ";

		if($searchstatus){
			$arr=explode(",",$searchstatus);
			if(count($arr)>1){
				$wsql.=" and ( ";
				for($i=1;$i<count($arr);$i++){
					if($i>1)$wsql.=" or ";
					$wsql.=" mt_status = '".$arr[$i]."' ";
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
			$wsql.=" a.mt_code like '%".$searchtxt."%' ";///바코드
			$wsql.=" or ";
			$wsql.=" a.mt_title like '%".$searchtxt."%' ";///조제대명
			$wsql.=" or ";
			$wsql.=" a.mt_model like '%".$searchtxt."%' ";///모델명
			$wsql.=" or ";
			$wsql.=" a.mt_locate like '%".$searchtxt."%' ";///위치
			$wsql.=" or ";
			$wsql.=" b.st_name like '%".$searchtxt."%' ";///조제사
			$wsql.=" ) ";
		}


		$pg=apipaging("mt_code","makingtable",$jsql,$wsql);

		$sql=" select * from (";
		$sql.=" select ROW_NUMBER() OVER (ORDER BY a.mt_code desc) NUM ";
		$sql.=" ,a.mt_seq,a.mt_code,a.mt_model,a.mt_title,a.mt_locate,a.mt_status,a.mt_intime,a.mt_outtime,to_char(a.mt_date,'yyyy-mm-dd') as MTDATE ";
		$sql.=" ,b.st_name  ";
		$sql.=", (select cd_name_".$language." from ".$dbH."_code where cd_type='mtStatus' and cd_code = a.mt_status) as MTSTATUSNAME ";
		$sql.=" from ".$dbH."_makingtable  $jsql $wsql  ";
		$sql.=" order by a.mt_code desc ";
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
			$inTime = ($dt["MT_INTIME"]) ? $dt["MT_INTIME"] : "-";
			$outTime = ($dt["MT_OUTTIME"]) ? $dt["MT_OUTTIME"] : "-";
			$staff = ($dt["ST_NAME"]) ? $dt["ST_NAME"] : "-";

			$addarray=array(

				"seq"=>$dt["MT_SEQ"], 
				"mtCode"=>$dt["MT_CODE"], 
				"mtModel"=>$dt["MT_MODEL"], 
				"mtTitle"=>$dt["MT_TITLE"], 
				"mtLocate"=>$dt["MT_LOCATE"], 
				"mtStatus"=>$dt["MT_STATUS"], 
				"mtStatusName"=>$dt["MTSTATUSNAME"], 
				"mtStaff"=>$dt["MT_STAFF"], 
				"stName"=>$staff, 
				"mtIntime"=>$inTime, 
				"mtOuttime"=>$outTime, 
				"mtDate"=>$dt["MTDATE"]
				);
			array_push($json["list"], $addarray);
		}

		$json["sql"]=$sql;
		$json["apiCode"]=$apiCode;
		$json["resultCode"]="200";
		$json["resultMessage"]="OK";
	}
?>