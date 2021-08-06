<?php  
	/// 자재코드관리 > 약재함관리 > 리스트
	$apiCode=$_GET["apiCode"];
	$language=$_GET["language"];
	$page=$_GET["page"];
	$mb_seq=$_GET["seq"];
	$type=$_GET["type"];

	$makingtable="";
	$tarr=explode("_",$type);
	if($tarr[0]=="barcode"){
		$makingtable=$tarr[1];
	}

	if($apiCode!="mediboxlist"){$json["resultMessage"]="API(apiCode) ERROR";$apiCode="mediboxlist";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="API(language) ERROR";}
	else
	{
		$mbTableList = notgetmaTableList();///기타 출고 제외한 조제테이블리스트

		$returnData=$_GET["returnData"];
		$json=array("apiCode"=>$apiCode,"returnData"=>$returnData);
		$searperiodtype=$_GET["searPeriodType"];
		$searchperiod=$_GET["searchPeriod"];
		$searchstatus=$_GET["searchStatus"];
		$searchtype=$_GET["searchType"];
		$searchtxt=$_GET["searchTxt"];

		$json["makingtable"]=$makingtable;	
		$json["type"]=$type;		

		$jsql=" a inner join ".$dbH."_medicine b on a.mb_medicine=b.md_code";
		$jsql.=" inner join ".$dbH."_medihub c on b.md_hub=c.mh_code";
		$jsql.=" inner join ".$dbH."_makingtable t on t.mt_code=a.mb_table ";

		///----------------------------------------------------------------------
		///medicie_djmedi 약재명을 가져옴
		if($refer)
			$jsql.=" inner join ".$dbH."_medicine_".$refer." r on b.md_code=r.md_code  ";
		///----------------------------------------------------------------------
		$wsql=" where a.mb_use <>'D'";

		if($searchtype&&$searchtype!="all"&&$searchtxt){
			$field=substr($searchtype,0,2)."_".strtolower(substr($searchtype,2,20));
			if($searchtype!="mbCode")$field.="_".$language;
			$wsql.=" and ".$field." like '%".$searchtxt."%' ";
		}

		if($searchtxt)
		{
			$wsql.=" and ( ";
			$wsql.=" b.md_code = '".$searchtxt."' ";///약재코드
			$wsql.=" or ";
			$wsql.=" b.md_title_".$language." like '%".$searchtxt."%' ";///약재명
			$wsql.=" or ";
			$wsql.=" c.mh_title_".$language." like '%".$searchtxt."%' ";///본초명
			$wsql.=" or ";
			$wsql.=" a.mb_code like '%".$searchtxt."%' ";///바코드
			$wsql.=" or ";
			$wsql.=" r.mm_title_kor like '%".$searchtxt."%' ";///medicine_djmedi title_kor 검색
			$wsql.=" ) ";
		}

		if($searchstatus)
		{
			$arr=explode(",",$searchstatus);
			if(count($arr)>1)
			{
				$wsql.=" and ( ";
				for($i=1;$i<count($arr);$i++){
					if($i>1)$wsql.=" or ";
					$wsql.=" mb_table = '".$arr[$i]."' ";
				}
				$wsql.=" ) ";
			}
		}


		$pg=apipaging("mb_seq","medibox",$jsql,$wsql);
		$ssql=" a.mb_seq,a.mb_code,a.mb_stock,a.mb_capacity,a.mb_table,a.mb_medicine" ;
		$ssql.=" ,to_char(a.mb_date,'yyyy-mm-dd') as MB_DATE ";
		$ssql.=" ,to_char(a.mb_modify,'yyyy-mm-dd') as MB_MODIFY ";
		$ssql.=" ,b.md_title_".$language." as MDTITLE , b.md_origin_".$language." as mdOrigin , b.md_maker_".$language." as mdMaker ";
		$ssql.=" ,c.mh_title_kor as MHTITLE ";
		$ssql.=" ,t.mt_title ";
		///----------------------------------------------------------------------
		if($refer)
			$ssql.=" ,r.mm_title_".$language." as mmTitle, r.mm_code ";
		///----------------------------------------------------------------------

		///barcode print
		if($makingtable)
		{
			foreach($mbTableList as $val)
			{
				if($val["cdCode"]==$makingtable)
				{
					$json["tableName"]=$val["cdName"];
				}
			}

			$wsql=" where a.mb_use <> 'D' and t.mt_code='".$makingtable."' ";
			$sql=" select $ssql from ".$dbH."_medibox $jsql $wsql  order by mdTitle  ";
		}
		else
		{
			//$sql=" select $ssql from ".$dbH."_medibox $jsql $wsql group by a.mb_code order by a.mb_modify desc limit ".$pg["snum"].", ".$pg["psize"];
			$sql=" select * from (";
			$sql.=" select ROW_NUMBER() OVER (ORDER BY a.mb_seq) NUM ";	
			$sql.=" ,$ssql"; 
			$sql.=" from ".$dbH."_medibox $jsql $wsql  ";
			//$sql.=" group by a.mb_code";	
			$sql.=" order by a.mb_modify desc  ";
			$sql.=" ) where NUM>".$pg["snum"]." and NUM<=".$pg["tlast"];   
			
		}
		$res=dbqry($sql);
		$json["page"]=$pg["page"];
		$json["tcnt"]=$pg["tcnt"];
		$json["tpage"]=$pg["tpage"];
		$json["psize"]=$pg["psize"];
		$json["block"]=$pg["block"];
		$json["list"]=array();

		while($dt=dbarr($res))
		{
			if($dt["MB_MODIFY"]>0){$str_date = $dt["MB_MODIFY"];}else{$str_date = $dt["MB_DATE"];}
			if($dt["MB_CAPACITY"]){$mbCapacity=$dt["MB_CAPACITY"];}else{$mbCapacity="0";}
			if($dt["MB_STOCK"]){$MB_STOCK=$dt["MB_STOCK"];}else{$MB_STOCK=" - ";}	

			///----------------------------------------------------------------------
			$mdTitle = ($refer) ? $dt["MMTITLE"] : $dt["MDTITLE"];///약재명
			$mbMedicine = ($refer) ? $dt["MM_CODE"] : $dt["MB_MEDICINE"];///약재코드 
			///----------------------------------------------------------------------

			$addarray=array(
				
				"seq"=>$dt["MB_SEQ"], 
				"mbCode"=>$dt["MB_CODE"], 
				"mbStock"=>$MB_STOCK, ///입고코드
				"mbTable"=>$dt["MB_TABLE"],					
				"mbCapacity"=>$mbCapacity,
				"mbTypeName"=>$dt["CD_NAME"],
				"mbTableName"=>$dt["MT_TITLE"],				
				"mdTitle"=>$mdTitle, ///약재명
				"mdCode"=>$dt["MB_MEDICINE"], ///디제이약재코드	
				"mbMedicine"=>$mbMedicine, ///약재코드	
				"mdOrigin"=>$dt["MDORIGIN"], 
				"mdMaker"=>$dt["MDMAKER"], 
				"mhTitle"=>$dt["MHTITLE"], 
				"mbDate"=>$str_date		
				);

			array_push($json["list"], $addarray);
		}

		$json["searchstatus"]=$searchstatus;			
		$json["mbTableList"]=$mbTableList;
		$json["sql"]=$sql;
		$json["apiCode"]=$apiCode;
		$json["resultCode"]="200";
		$json["resultMessage"]="OK";
		$json["refer"]=$refer;	
	}
?>