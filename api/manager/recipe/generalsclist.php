<?php  
	///처방관리 > 처방관리 > 처방관리 리스트
	$apiCode=$_GET["apiCode"];
	$language=$_GET["language"];
	$page=$_GET["page"];

	if($apiCode!="generalsclist"){$json["resultMessage"]="API(apiCode) ERROR";$apiCode="generalsclist";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="API(language) ERROR";}
	else
	{
		$returnData=$_GET["returnData"];
		$json=array("apiCode"=>$apiCode,"search"=>$search,"returnData"=>$returnData);
		$searperiodtype=$_GET["searPeriodType"];
		$searchperiod=$_GET["searchPeriod"];
		$searchstatus=$_GET["searchStatus"];
		$searchtype=$_GET["searchType"];
		$searchtxt=$_GET["searchTxt"];
		$searchpop=$_GET["searchPop"];
		$sdate=$_GET["sdate"];
		$edate=$_GET["edate"];

		$jsql=" a left join ".$dbH."_order c on a.rc_code=c.od_scription ";
		$jsql.=" inner join ".$dbH."_medical m on c.od_userid=m.mi_userid ";
		$jsql.=" left join ".$dbH."_release d on c.od_code=d.re_odcode ";
		$wsql=" where a.rc_use <>'D' ";

		if($search){
			$wsql.=" and mh_title_".$language." like '%".$search."%'  ";
		}

		if($searperiodtype&&$searchperiod){
			$arr=explode(",",$searchperiod);
			if(count($arr)>1){
				$wsql.=" and left(rc_date,10) > '".$arr[0]."' and left(rc_date,10) < '".$arr[1]."' ";
			}
		}

		if($searchpop)
		{
			$arr=explode("|",$searchpop);
			foreach($arr as $val)
			{
				$arr2=explode(",",$val);
				if($arr2[0]=="searchType")
				{
					if($arr2[1]=="reName")
					{
						$field=" d.re_name ";
					}
				}
				if($arr2[0]=="searchTxt")
				{
					$seardata=$arr2[1];
				}
			}
			if($seardata && $field)
				$wsql.=" and ".$field." like '%".$seardata."%' ";
		}

		///기간선택 : 타입과 날짜 
		if($sdate&&$edate)
		{
			$sdate=str_replace(".","-",$sdate);///시작 날짜
			$edate=str_replace(".","-",$edate);///끝 날짜 

			///처방일  
			$wsql.=" and ( ";
			$wsql.=" to_char(a.rc_date, 'yyyy-mm-dd') >= '".$sdate."' and to_char(a.rc_date, 'yyyy-mm-dd') <= '".$edate."' ";
			$wsql.=" ) ";
		}


		if($searchtxt)
		{
			$wsql.=" and ( ";
			$wsql.=" d.re_name like '%".$searchtxt."%' ";///환자명
			$wsql.=" or ";
			$wsql.=" m.mi_name like '%".$searchtxt."%' ";///한의원
			$wsql.=" or ";
			$wsql.=" a.rc_title_".$language." like '%".$searchtxt."%' ";///처방명 
			$wsql.=" ) ";
		}

		$pg=apipaging("a.rc_code","recipeuser",$jsql,$wsql);

		$sql=" select * from (";
		$sql.=" select ROW_NUMBER() OVER (ORDER BY a.rc_date desc) NUM ";
		$sql.=" ,a.rc_seq, a.rc_code as rcCode, a.rc_source, a.rc_sourcetit, a.rc_title_kor as rcTitle,to_char(a.rc_medicine) as RCMEDICINE";
		$sql.=" ,to_char(a.rc_date,'yyyy-mm-dd') as RCDATE ";
		$sql.=" ,m.mi_name miName ";
		$sql.=" ,d.re_name RE_NAME ,c.od_chubcnt ODCHUBCNT";
		$sql.=" from ".$dbH."_recipeuser $jsql $wsql order by a.rc_date desc ";
		$sql.=" ) where NUM>".$pg["snum"]." and NUM<=".$pg["tlast"]; 

		$res=dbqry($sql);

		$json["sql"]=$sql;
		$json["page"]=$pg["page"];
		$json["tcnt"]=$pg["tcnt"];
		$json["tpage"]=$pg["tpage"];
		$json["psize"]=$pg["psize"];
		$json["block"]=$pg["block"];
		$json["list"]=array();
		while($dt=dbarr($res))
		{
			$rcMedicine = substr($dt["RCMEDICINE"], 1); //한자리만 자르기 
			$rcMedicineTxt = getmmtitle($rcMedicine, 'list');
			$arr=explode("|",$rcMedicine);///약재갯수(약미)

			$addarray=array(
				"seq"=>$dt["RC_SEQ"], 
				"rcCode"=>$dt["RCCODE"],
				"rcSource"=>$dt["RCSOURCE"],
				"rcTitle"=>$dt["RCTITLE"], 
				//"rcDetail"=>$dt["RCDETAIL"], 
				"rcSweet"=>$dt["RCSWEET"], 
				"rcMedicine"=>$rcMedicine, 
				"rcMedicineTxt"=>$rcMedicineTxt,  ///방제정보
				"rcMedicineCnt"=>count($arr), 
				//"rcEfficacy"=>$dt["RCEFFICACY"], 
				//"rcMaincure"=>$dt["RCMAINCURE"],
				//"rcTingue"=>$dt["RCTINGUE"], 
				//"rcPulse"=>$dt["RCPULSE"], 
				//"rcUsage"=>$dt["RCUSAGE"],
				"odStatus"=>$dt["ODSTATUS"],
				"odChubcnt"=>$dt["ODCHUBCNT"],
				"miName"=>$dt["MINAME"], 
				"reName"=>$dt["RE_NAME"], ///환자명
				"rcDate"=>$dt["RCDATE"]
				);

			array_push($json["list"], $addarray);
		}
		$json["searchtxt"] =$searchtxt;
		$json["apiCode"]=$apiCode;
		$json["returnData"]=$returnData;
		$json["resultCode"]="200";
		$json["resultMessage"]="OK";
	}

?>