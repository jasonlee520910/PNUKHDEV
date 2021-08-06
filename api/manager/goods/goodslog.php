<?php /// 제품관리 로그 (나중에 주문코드는 수정해야함 일단은 이대로 진행)
	//GET
	$apiCode=$_GET["apiCode"];
	$language=$_GET["language"];
	$page=$_GET["page"];
	$mt_seq=$_GET["seq"];

	if($apiCode!="goodslog"){$json["resultMessage"]="API(apiCode) ERROR";$apiCode="goodslog";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="API(language) ERROR";}
	else{
		$returnData=$_GET["returnData"];
		$json=array("apiCode"=>$apiCode,"returnData"=>$returnData);
		$searperiodtype=$_GET["searPeriodType"];
		$searchperiod=$_GET["searchPeriod"];
		$searchstatus=$_GET["searchStatus"];  //검색조건("제품","반제품","원재료","부자재")
		$searchMatype=$_GET["searchMatype"];  //검색조건("제분","혼합제분","제형")
		$searchProgress=$_GET["searchProgress"];  //검색조건("생산","폐기")
	
		//기간선택 
		$sdate = $_GET["sdate"];
		$edate = $_GET["edate"];	

		$searchtype=$_GET["searchType"];
		$searchtxt=$_GET["searchTxt"];

		$search=""; //검색조건들
		$jsql=" a  left join ".$dbH."_goods b on a.gh_code=b.gd_code ";
		$jsql.=" left join ".$dbH."_order o on a.gh_odcode=o.od_code ";
		$jsql.=" left join ".$dbH."_order_client cy on o.od_keycode=cy.keycode ";
		$jsql.=" left join ".$dbH."_medicine_djmedi c on a.gh_code=c.md_code ";
		$wsql=" where a.gh_use='Y' ";

		//검색조건("제품","반제품","원재료","부자재")
		if($searchstatus){
			$arr=explode(",",$searchstatus);
			if(count($arr)>1){
				$wsql.=" and ( ";
				for($i=1;$i<count($arr);$i++){
					if($i>1)$wsql.=" or ";
					$wsql.=" b.gd_type = '".$arr[$i]."' "; 
				}
				$wsql.=" ) ";
			}
		}

		//검색조건("제분","혼합제분","제형")
		if($searchMatype){
			$arr=explode(",",$searchMatype);
			if(count($arr)>1){
				$wsql.=" and ( ";
				for($i=1;$i<count($arr);$i++){
					if($i>1)$wsql.=" or ";
					$wsql.=" b.gd_category = '".$arr[$i]."' "; 
				}
				$wsql.=" ) ";
			}
		}

		//검색조건("생산","폐기")
		if($searchProgress){
			$arr=explode(",",$searchProgress);
			if(count($arr)>1){
				$wsql.=" and ( ";
				for($i=1;$i<count($arr);$i++){
					if($i>1)$wsql.=" or ";
					$wsql.=" a.gh_type = '".$arr[$i]."' "; 
				}
				$wsql.=" ) ";
			}
		}

		//기간선택
		if($sdate&&$edate)
		{
			$sdate=str_replace(".","-",$sdate);//시작 날짜
			$edate=str_replace(".","-",$edate);//끝 날짜 

			//주문일과 배송요청일 둘다 검색하여 보여주자 
			$wsql.=" and ( ";
			$wsql.=" to_char(a.gh_date, 'yyyy-mm-dd') >= '".$sdate."' and to_char(a.gh_date, 'yyyy-mm-dd') <= '".$edate."' ";
			$wsql.=" ) ";

			$search.="&sdate=".$sdate."&edate=".$edate;
		}

		if($searchtype&&$searchtype!="all"&&$searchtxt){
			$field=substr($searchtype,0,2)."_".strtolower(substr($searchtype,2,20));
			$wsql.=" and ".$field." like '%".$searchtxt."%' ";
		}

		if($searchtxt)
		{
			$wsql.=" and ( ";
			$wsql.=" a.gh_code like '%".$searchtxt."%' ";//품목코드
			$wsql.=" or ";
			$wsql.=" b.gd_name_kor like '%".$searchtxt."%' ";//제품명
			$wsql.=" or ";
			$wsql.=" b.gd_name_chn like '%".$searchtxt."%' ";//제품명
			$wsql.=" or ";
			$wsql.=" b.gd_name_eng like '%".$searchtxt."%' ";//제품명
			$wsql.=" ) ";
		}


		$pg=apipaging("a.gh_seq","goodshouse",$jsql,$wsql);
		$ssql=",case when c.md_code<>'' then 'origin' else b.gd_type end GDTYPE ,case when c.md_code<>'' then c.mm_title_".$language." else b.gd_name_".$language." end  GDNAME ";
		$sql="select * from (";
		$sql.=" select ROW_NUMBER() OVER (ORDER BY a.gh_seq desc) NUM, a.GH_SEQ, a.GH_TYPE, a.GH_CODE,  a.GH_ODCODE, a.GH_OLDQTY, a.GH_ADDQTY,a.GH_QTY,to_char(a.GH_DATE, 'yyyy-mm-dd hh24:mi:ss') as GHDATE ,b.gd_category, cy.orderCode cyodcode, o.od_seq, o.od_goods ".$ssql." from ".$dbH."_goodshouse $jsql $wsql order by a.gh_seq desc ";
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
			switch($dt["GDTYPE"])
			{
				case "goods":$gd_type="제품";break;
				case "pregoods":$gd_type="반제품";break;
				case "material":$gd_type="부자재";break;
				case "origin":$gd_type="원재료";break;
				default:$gd_type=" - ";
			}
			switch($dt["GH_TYPE"])
			{
				case "incoming":$gh_type="입고";break;
				case "produce":$gh_type="생산";break;
				case "disposal":$gh_type="폐기";break;
				case "use":$gh_type="사용";break;
				case "sales":$gh_type="판매";break;
				case "return":$gh_type="반품";break;
				default:$gh_type=" - ";
			}
			switch($dt["GD_CATEGORY"])
			{
				case "milling":$gd_category="제분";break;
				case "mixedmilling":$gd_category="혼합제분";break;
				case "shape":$gd_category="제형";break;
				default:$gd_category=" - ";
			}
			$od_chartpk="-";
			if($dt["GH_ODCODE"])
			{
				//$od_chartpk=($dt["OD_CHARTPK"]) ? $dt["OD_CHARTPK"] : "";
				//if($dt["OD_CHARTPK"]){$od_chartpk="<span style='padding:2px 5px;border-radius:2px;background:#CC66CC;color:#fff;'>OK ".$dt["OD_CHARTPK"]."</span>";}else{$od_chartpk="";}
				//if($dt["CYODCODE"]){$cyodcode="<span style='padding:2px 5px;border-radius:2px;background:#6699FF;color:#fff;'>BK ".($dt["CYODCODE"]+10000)."</span>";}else{$cyodcode="";}
				//if($cyodcode){$od_chartpk=$cyodcode;}
				if($dt["OD_GOODS"]=="G"){$gGoods=" 사전";}else{$gGoods="";}
			}

			//if(!$od_chartpk) {$od_chartpk="<span style='padding:2px 5px;border-radius:2px;background:#549E08;color:#fff;'>CY ".($dt["OD_SEQ"]+50000)."</span>";}
			if($gGoods) {$od_chartpk="<span style='padding:2px 5px;border-radius:2px;background:#FF0000;color:#fff;'>".$gGoods."</span>";}

			if($dt["GDNAME"]){$gdName=$dt["GDNAME"];}else{$gdName="-";}
			$addarray=array(
				"seq"=>$dt["GH_SEQ"], 
				"odCode"=>$dt["GH_ODCODE"], 
				"odCodePk"=>$od_chartpk, 
				"gdCode"=>$dt["GH_CODE"], 
				"gdName"=>$gdName, 
				"gdCategory"=>$gd_category,  //제품분류
				"gdType"=>$gd_type, //종류
				"ghType"=>$gh_type,  //분류
				"ghOldqty"=>number_format($dt["GH_OLDQTY"]), 
				"ghAddqty"=>number_format($dt["GH_ADDQTY"]), 
				"ghQty"=>number_format($dt["GH_QTY"]), 
				"ghWorkcode"=>$dt["GH_WORKCODE"], 
				"ghDate"=>$dt["GHDATE"]);
			array_push($json["list"], $addarray);
		}

		$json["sql"]=$sql;
		$json["apiCode"]=$apiCode;
		$json["resultCode"]="200";
		$json["resultMessage"]="OK";

		$json["search"]=$search;
		$json["searchstatus"]=$searchstatus;		
		$json["searchMatype"]=$searchMatype;
		$json["searchProgress"]=$searchProgress;
				
		
	}
?>