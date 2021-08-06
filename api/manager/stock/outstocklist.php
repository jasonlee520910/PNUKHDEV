<?php //약재출고 리스트
	//GET
	$apiCode=$_GET["apiCode"];
	$language=$_GET["language"];
	$page=$_GET["page"];

	if($apiCode!="outstocklist"){$json["resultMessage"]="API(apiCode) ERROR";$apiCode="outstocklist";}
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
		//기간선택 
		$sdate = $_GET["sdate"];
		$edate = $_GET["edate"];


		$jsql=" a left join ".$dbH."_medicine b on a.wh_stock=b.md_code  and b.md_use<>'D' ";
		$jsql.=" left join ".$dbH."_makingtable c on a.wh_table=c.mt_code and c.mt_use<>'D' ";
		$jsql.=" left join ".$dbH."_code d on d.cd_type='whStatusOutStock' and d.cd_code=a.wh_status";
		//----------------------------------------------------------------------
		//세명대 약재명을 가져오기 위함
		if($refer)
			$jsql.=" inner join ".$dbH."_medicine_".$refer." r on b.md_code=r.md_code and r.mm_use<>'D' ";
		//----------------------------------------------------------------------

		$wsql="  where wh_use = 'Y' and wh_type='outgoing' ";

		if($search){
			$wsql.=" and mh_title_".$language." like '%".$search."%'  ";
		}

		if($searperiodtype&&$searchperiod){
			$arr=explode(",",$searchperiod);
			if(count($arr)>1){
				$wsql.=" and left(wh_date,10) > '".$arr[0]."' and left(wh_date,10) < '".$arr[1]."' ";
			}
		}

		//기간선택 : 타입과 날짜 
		if($sdate&&$edate)
		{
			$sdate=str_replace(".","-",$sdate);//시작 날짜
			$edate=str_replace(".","-",$edate);//끝 날짜 

			//입고일 
			$wsql.=" and left(wh_date,10) >= '".$sdate."' and left(wh_date,10) <= '".$edate."' ";			

			//$search.="&sdate=".$sdate."&edate=".$edate;
		}

		/*
		//예전소스
		if($searchtype&&$searchtype!="all"&&$searchtxt){
			$field=substr($searchtype,0,2)."_".strtolower(substr($searchtype,2,20));
			if(substr($searchtype,0,2)=="md")$field.="_".$language;
			$wsql.=" and ".$field." like '%".$searchtxt."%' ";
		}
		*/

		if($searchtxt)
		{
			$wsql.=" and ( ";
			$wsql.=" b.md_title_".$language." like '%".$searchtxt."%' ";//약재명
			$wsql.=" or ";
			$wsql.=" a.wh_title like '%".$searchtxt."%' ";//출고제목
			$wsql.=" or ";
			$wsql.=" a.wh_staff like '%".$searchtxt."%' ";//출고자
			$wsql.=" ) ";
		}

		$pg=apipaging("wh_seq","warehouse",$jsql,$wsql);
		$ssql="a.wh_seq, a.wh_code, a.wh_table, a.wh_title, a.wh_etc, a.wh_qty, a.wh_staff, a.wh_expired, a.wh_date,to_char(a.wh_memo) as WH_MEMO";
		$ssql.=", b.md_title_".$language." md_title, b.md_origin_".$language." md_origin, b.md_maker_".$language." md_maker, c.mt_title  ";
		//----------------------------------------------------------------------
		$ssql.=", d.cd_name_".$language." mdStateName ";
		if($refer)
			$ssql.=" , r.mm_title_".$language." mmTitle, r.mm_code ";
		//----------------------------------------------------------------------

		//$sql=" select $ssql from ".$dbH."_warehouse $jsql $wsql order by wh_seq desc limit ".$pg["snum"].", ".$pg["psize"];


		$sql=" select * from (";
		$sql.=" select ROW_NUMBER() OVER (ORDER BY wh_seq ) NUM ,$ssql ";	
		$sql.=" from ".$dbH."_warehouse $jsql $wsql  ";
		$sql.=" order by wh_seq desc";
		$sql.=" ) where NUM>".$pg["snum"]." and NUM<=".$pg["tlast"];

//echo $sql;

		$res=dbqry($sql);
		$json["sql"]=$sql;
		$json["page"]=$pg["page"];
		$json["tcnt"]=$pg["tcnt"];
		$json["tpage"]=$pg["tpage"];
		$json["psize"]=$pg["psize"];
		$json["block"]=$pg["block"];
		$json["list"]=array();

		while($dt=dbarr($res)){

			$whTable = ($dt["MT_TITLE"]) ? $dt["MT_TITLE"] : "";
			//----------------------------------------------------------------------
			$mdTitle = ($refer) ? $dt["MMTITLE"] : $dt["MD_TITLE"];//약재명
			//----------------------------------------------------------------------

			$addarray=array(
				"seq"=>$dt["WH_SEQ"], 
				"whCode"=>$dt["WH_CODE"], 				
				"whTable"=>$whTable,
				"whTitle"=>$dt["WH_TITLE"], 
				"mdTitle"=>$mdTitle, 
				"whTitle"=>$dt["WH_TITLE"], 
				"mdOrigin"=>$dt["MD_ORIGIN"], 
				"mdMaker"=>$dt["MD_MAKER"],
				"whEtc"=>$dt["WH_ETC"],  
				"whQty"=>$dt["WH_QTY"], 
				"whStaff"=>$dt["WH_STAFF"], 
				"whMemo"=>$dt["WH_MEMO"], 
				"whExpired"=>$dt["WH_EXPIRED"], 
				"mdStateName"=>$dt["MDSTATENAME"],
				"whDate"=>$dt["WH_DATE"]
				);
			array_push($json["list"], $addarray);
		}
		$json["sql"]=$sql;
		$json["apiCode"]=$apiCode;
		$json["resultCode"]="200";
		$json["resultMessage"]="OK";
	}
?>