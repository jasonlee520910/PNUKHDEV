<?php  
	/// 재고관리 > 약재재고목록 > 리스트
	$apicode=$_GET["apiCode"];
	$language=$_GET["language"];
	$page=$_GET["page"];
	if($apicode!="medistocklist"){$json["resultMessage"]="API(apiCode) ERROR";$apicode="medistocklist";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="API(language) ERROR";}
	else
	{
		$returnData=$_GET["returnData"];
		$json=array("apiCode"=>$apicode,"search"=>$search,"returnData"=>$returnData);
		$searchselecttype=$_GET["searchSelectType"];
		$searchselect=$_GET["searchSelect"];
		$searchtype=$_GET["searchType"];
		$searchtxt=$_GET["searchTxt"];
		$searchpop=$_GET["searchPop"];

		///기간선택 
		$sdate = $_GET["sdate"];
		$edate = $_GET["edate"];

		$jsql=" a inner join ".$dbH."_medibox c on a.md_code=c.mb_medicine  and c.mb_use<>'D' ";
		$jsql.=" inner join ".$dbH."_code d on d.cd_type='mdStatus' and a.md_status=d.cd_code  and d.cd_use<>'D' ";
		
		///client 약재명을 가져오기 위함
		if($refer)
			$jsql.=" inner join ".$dbH."_medicine_".$refer." r on a.md_code=r.md_code and r.mm_use<>'D' ";
		///----------------------------------------------------------------------
		$wsql="  where a.md_use <> 'D' and a.md_stock='Y' ";

		if($search){
			$wsql.=" and mh_title_".$language." like '%".$search."%'  ";
		}

		///기간선택 : 타입과 날짜 
		if($sdate&&$edate)
		{
			$sdate=str_replace(".","-",$sdate);//시작 날짜
			$edate=str_replace(".","-",$edate);//끝 날짜 

			
			$wsql.=" and ( ";
			//$wsql.="left( if(a.md_modify,a.md_modify,a.md_date),10) >= '".$sdate."' and left( if(a.md_modify,a.md_modify,a.md_date) ,10) <= '".$edate."' ";
			$wsql.=" to_char(a.md_modify, 'yyyy-mm-dd') >= '".$sdate."' and to_char(a.md_modify, 'yyyy-mm-dd') <= '".$edate."' ";  
			//(medicienupdate 할때 md_date,md_modify 둘다 등록함)
			$wsql.=" ) ";
		}

		if($searchtxt)
		{
			$wsql.=" and ( ";
			$wsql.=" a.md_title_".$language." like '%".$searchtxt."%' ";///약재명
			$wsql.=" or ";
			$wsql.=" a.md_code like '%".$searchtxt."%' ";///약재코드
			$wsql.=" or ";
			$wsql.=" a.md_origin_".$language." like '%".$searchtxt."%' ";///원산지
			$wsql.=" or ";
			$wsql.=" a.md_maker_".$language." like '%".$searchtxt."%' ";///제조사
			$wsql.=" or ";
			$wsql.=" c.mb_code = '".$searchtxt."' ";///약재함바코드 
			$wsql.=" ) ";
		}

		if($searchselect){
			$arr=explode("|",$searchselect);
			if(count($arr)>1){
				$wsql.=" and ( ";
				for($i=1;$i<count($arr);$i++){
					$arr1=explode(",",$arr[$i]);
					if($i>1)$wsql.=" or ";
					$field=substr($arr1[0],0,2)."_".strtolower(substr($arr1[0],2,20));
					$wsql.=$field."_".$language." like '%".$arr1[1]."%' ";

				}
				$wsql.=" ) ";
			}
		}

		$pg=apipaging("a.md_code","medicine",$jsql,$wsql);

/* 예전소스
		$sql=" select ";
		$sql.=" group_concat(c.mb_table) as mbTable, ";
		$sql.=" (sum(c.mb_capacity) + a.md_qty - a.md_stable) mbCapa, ";
		$sql.=" sum(c.mb_capacity) as mbCapacity, a.md_qty,  a.md_stable, d.cd_name_kor cdName , ";
		$sql.=" if(a.md_modify,a.md_modify,a.md_date) indate,  ";
		$sql.=" a.md_seq, a.md_hub, a.md_code, a.md_price, a.md_title_".$language.", a.md_origin_".$language.", a.md_maker_".$language.", a.md_status, a.md_use  ";
		//----------------------------------------------------------------------
		if($refer)
			$sql.=" , r.mm_title_".$language." mmTitle, r.mm_code ";
		//----------------------------------------------------------------------
		$sql.=" from ".$dbH."_medicine $jsql $wsql group by a.md_code ";
		$sql.=" order by field (a.md_status,'shortage','complete','use','soldout','discon','hold') asc, if(a.md_modify,a.md_modify,a.md_date) desc,  mbCapa limit ".$pg["snum"].", ".$pg["psize"];
*/

		$sql=" select * from ( "; 
		$sql.=" select ROW_NUMBER() OVER (ORDER BY a.md_seq desc) NUM  ";			
		$sql.=" ,a.md_seq, a.md_hub, a.md_code, a.md_price";
		$sql.=" ,a.md_title_".$language." as MD_TITLE ";
		$sql.=" ,a.md_origin_".$language." as MD_ORIGIN ";
		$sql.=" ,a.md_maker_".$language." as  MD_MAKER ";
		$sql.=" ,to_char(a.md_modify,'yyyy-mm-dd') as md_modify";
		$sql.=" ,to_char(a.md_date,'yyyy-mm-dd') as md_date";
		$sql.=" ,a.md_status, a.md_use, a.md_qty ,a.md_stable ";
		$sql.=" ,sum(c.mb_capacity) as MBCAPACITY ";
		$sql.=" ,d.cd_name_kor cdName ";

		///----------------------------------------------------------------------
		if($refer)
			$sql.=" , r.mm_title_".$language." mmTitle, r.mm_code ";
		///----------------------------------------------------------------------
		$sql.=" from han_medicine $jsql $wsql  ";
		$sql.=" group by a.md_seq, a.md_hub, a.md_code, a.md_price, a.md_title_kor, a.md_origin_kor, a.md_maker_kor ";
		$sql.=" ,to_char(a.md_modify,'yyyy-mm-dd') ";
		$sql.=" ,to_char(a.md_date,'yyyy-mm-dd') ";
		$sql.=" ,a.md_status, a.md_use ,a.md_qty ,a.md_stable ";
		$sql.=" ,d.cd_name_kor  ";
		///----------------------------------------------------------------------
		if($refer)
			$sql.=" , r.mm_title_kor, r.mm_code ";
		///----------------------------------------------------------------------

		//$sql.=" ORDER BY a.md_status, CASE WHEN a.md_status IN ('shortage') THEN 0 ELSE 1 END, a.md_status ";  ///shortage 먼저보이게 처리		
		$sql.=" ORDER BY decode (a.md_status, 'shortage',1,'complete',2,'use',3,'soldout',4,'discon',5,'hold',6) ";  ///shortage 먼저보이게 처리
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
			///----------------------------------------------------------------------
			$mdTitle = ($refer) ? $dt["MMTITLE"] : $dt["MD_TITLE"];///약재명
			$mbMedicine = ($refer) ? $dt["MM_CODE"] : $dt["MD_CODE"];///약재코드 
			///----------------------------------------------------------------------

			$mbCapa = $dt["MB_CAPACITY"] + $dt["MD_QTY"] - $dt["MD_STABLE"];
			$indate = $dt["MD_MODIFY"] ? $dt["MD_MODIFY"] : $dt["MD_DATE"] ; ////최종입고일
			
			$addarray=array(
				"seq"=>$dt["MD_SEQ"], 
				"mbCapa"=>$mbCapa, 
				"mdCode"=>$dt["MD_CODE"], 
				"mdPrice"=>$dt["MD_PRICE"],
				"mdTitle"=>$mdTitle, 
				"mdOrigin"=>$dt["MD_ORIGIN"],
				"mdMaker"=>$dt["MD_MAKER"],
				"mdUse"=>$dt["MD_USE"],
				"mdStatus"=>$dt["MD_STATUS"],
				"mdStatusName"=>$dt["CDNAME"],
				"mbCapacity"=>$dt["MBCAPACITY"],
				"mdQty"=>$dt["MD_QTY"], 
				"mdStable"=>$dt["MD_STABLE"], 
				"inDate"=>$indate
				);
			array_push($json["list"], $addarray);
		}
		$json["resultCode"]="200";
		$json["resultMessage"]="OK";
	}
?>