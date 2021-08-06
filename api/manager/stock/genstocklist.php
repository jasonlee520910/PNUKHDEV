<?php  
	/// 재고관리 > 자재입출고 > 리스트
	$apiCode=$_GET["apiCode"];
	$language=$_GET["language"];
	$page=$_GET["page"];

	if($apiCode!="genstocklist"){$json["resultMessage"]="API(apiCode) ERROR";$apiCode="genstocklist";}
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
		$sdate=$_GET["sdate"];
		$edate=$_GET["edate"];

		$jsql=" a  ";
		$wsql="  where a.wh_use = 'Y' and a.wh_type='general' ";

		if($search){
			$wsql.=" and mh_title_".$language." like '%".$search."%'  ";
		}

		if($searperiodtype&&$searchperiod){
			$arr=explode(",",$searchperiod);
			if(count($arr)>1){
				$wsql.=" and left(wh_date,10) > '".$arr[0]."' and left(wh_date,10) < '".$arr[1]."' ";
			}
		}

		///기간선택 : 타입과 날짜 
		if($sdate&&$edate)
		{
			$sdate=str_replace(".","-",$sdate);//시작 날짜
			$edate=str_replace(".","-",$edate);//끝 날짜 

			///입출고일 	
			$wsql.=" and to_char(a.wh_date, 'yyyy-mm-dd') >= '".$sdate."' and to_char(a.wh_date, 'yyyy-mm-dd') <= '".$edate."' ";
		}

		if($searchtxt)
		{
			$wsql.=" and ( ";
			$wsql.=" a.wh_category like '%".$searchtxt."%' ";///분류
			$wsql.=" or ";
			$wsql.=" a.wh_title like '%".$searchtxt."%' ";///자재품명
			$wsql.=" or ";
			$wsql.=" a.wh_code like '%".$searchtxt."%' ";///자재코드
			$wsql.=" or ";
			$wsql.=" a.wh_staff like '%".$searchtxt."%' ";///담당자
			$wsql.=" or ";
			$wsql.=" a.wh_maker like '%".$searchtxt."%' ";///제조사
			$wsql.=" ) ";
		}

		$pg=apipaging("wh_seq","warehouse",$jsql,$wsql);

		$sql=" select * from (";
		$sql.=" select ROW_NUMBER() OVER (ORDER BY a.wh_indate desc) NUM ";
		$sql.=" ,a.wh_seq, a.wh_code, a.wh_category, a.wh_title, a.wh_maker, a.wh_status, a.wh_qty, a.wh_staff ";		
		$sql.=" ,to_char(a.wh_memo) as WH_MEMO ";
		$sql.=" ,to_char(a.wh_date,'yyyy-mm-dd') as WH_DATE ";	
		$sql.=" from ".$dbH."_warehouse $jsql $wsql ";
		$sql.=" order by a.wh_indate desc ";
		$sql.=" ) where NUM>".$pg["snum"]." and NUM<=".$pg["tlast"];

		$res=dbqry($sql);
		
		$json["page"]=$pg["page"];
		$json["tcnt"]=$pg["tcnt"];
		$json["tpage"]=$pg["tpage"];
		$json["psize"]=$pg["psize"];
		$json["block"]=$pg["block"];
		$json["list"]=array();

		while($dt=dbarr($res)){

			if($dt["WH_TITLE"]){$WH_TITLE=$dt["WH_TITLE"];}else{$WH_TITLE="-";}
			if($dt["WH_MAKER"]){$WH_MAKER=$dt["WH_MAKER"];}else{$WH_MAKER="-";}
			if($dt["WH_STAFF"]){$WH_STAFF=$dt["WH_STAFF"];}else{$WH_STAFF="-";}
	
			$str=whcatetxt($dt["WH_CATEGORY"]);
			$addarray=array(
				"seq"=>$dt["WH_SEQ"], 
				"whCode"=>$dt["WH_CODE"], ///입출고코드
				"whCategory"=>$str,  ///상품분류,자재분류
				"whTitle"=>$WH_TITLE,  ///입출고제목, 자재품명
				"whMaker"=>$WH_MAKER, ///자재제조사
				"whStatus"=>$dt["WH_STATUS"],  ///상태, 반송, 승인, 폐기,자재입출고구분
				"whQty"=>$dt["WH_QTY"],  ///입출고수량
				"whPrice"=>$dt["WH_PRICE"], 
				"whStaff"=>$WH_STAFF, ///입출고담당자
				"whMemo"=>$dt["WH_MEMO"], ///관리자메모,입출고사유
				"whDate"=>$dt["WH_DATE"]
				);
			array_push($json["list"], $addarray);
		}

		$json["sql"]=$sql;
		$json["apiCode"]=$apiCode;
		$json["resultCode"]="200";
		$json["resultMessage"]="OK";
	}

	///자재입출고 한글로 변환
	function whcatetxt($code){
		
		switch($code){
			case "pot":$str="탕전기";break;
			case "odPacktype":$str="파우치";break;
			case "reBoxmedi":$str="포장박스";break;
			case "reBoxdeli":$str="배송박스";break;
			case "tag":$str="부직포태그";break;
			default:
		}
		return $str;
	}

?>
