<?php  
	/// 재고관리 > 약재출고 > 상세보기
	$apicode=$_GET["apiCode"];
	$language=$_GET["language"];
	$wh_seq=$_GET["seq"];

	if($apicode!="outstockdesc"){$json["resultMessage"]="API(apiCode) ERROR";$apicode="outstockdesc";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="API(language) ERROR";}
	//else if($wh_seq==""){$json["resultMessage"]="API(seq) ERROR";}
	else
	{
		$returnData=$_GET["returnData"];

		$hCodeList = getNewCodeTitle("whCategoryInStock,whEtcOutStock,whStatusOutStock");
		$whCategoryOutStockList = getCodeList($hCodeList, 'whCategoryInStock');//약재분류 
		$whEtcOutStockList = getCodeList($hCodeList, 'whEtcOutStock');//출고지 
		$whStatusOutStockList = getCodeList($hCodeList, 'whStatusOutStock');//약재출고상태 
		$mbTableList = getmaTableList();//조제테이블리스트
		
		
		if($wh_seq)
		{
			$jsql=" a left join ".$dbH."_medicine b on a.wh_stock=b.md_code ";
			$jsql.=" left join ".$dbH."_medihub c on b.md_hub=c.mh_code ";
			//----------------------------------------------------------------------
			//세명대 약재명을 가져오기 위함
			if($refer)
				$jsql.=" inner join ".$dbH."_medicine_".$refer." r on b.md_code=r.md_code  ";
			//----------------------------------------------------------------------

			$wsql=" where wh_seq = '".$wh_seq."' and wh_type='outgoing' ";

			$ssql=" a.WH_SEQ,a.WH_CODE,a.WH_CATEGORY,a.WH_STOCK,a.WH_TITLE,a.WH_MAKER,a.WH_QTY,a.WH_PRICE,a.WH_STAFF,a.WH_STATUS,a.WH_TABLE";
			$ssql.=" ,a.WH_EXPIRED,a.WH_ETC,a.WH_ORIGIN,a.WH_ETCCODE,a.WH_ETCSTAFF,a.WH_ETCZIPCODE,a.WH_ETCADDRESS,a.WH_ETCPHONE";
			$ssql.=" ,to_char(a.WH_DATE,'yyyy-mm-dd') as WH_DATE ";
			//$ssql.=" ,DBMS_LOB.SUBSTR(a.WH_MEMO, DBMS_LOB.GETLENGTH(a.WH_MEMO)) as WH_MEMO";
			$ssql.=" ,a.WH_MEMO as WH_MEMO";
			$ssql.=" ,b.md_title_".$language." as md_title, b.md_origin_".$language." as MD_ORIGIN, b.md_maker_".$language." as MD_MAKER ,b.MD_QTY";
			//----------------------------------------------------------------------
			if($refer)
				$ssql.=" , r.mm_title_".$language." mmTitle, r.mm_code ";
			//----------------------------------------------------------------------

			$sql=" select $ssql from ".$dbH."_warehouse $jsql $wsql ";

			$dt=dbone($sql);

			$sql1=" select count(wh_seq) cnt from ".$dbH."_warehouse where wh_type='outgoing' and wh_memo like '%".$dt["WH_CODE"]."%' and wh_status='cancel' and wh_qty='".($dt["MD_QTY"]*-1)."' ";
			$dt1=dbone($sql1);
			
			if($dt1["CNT"] > 0)
			{
				$cancelStatus = "true";
			}
			else
			{
				$cancelStatus="false";
			}

			//입고일, 유통기한 
			$sql2=" select wh_seq, to_char(wh_date,'yyyy-mm-dd') as WH_DATE,to_char(wh_expired,'yyyy-mm-dd') as WH_EXPIRED from ".$dbH."_warehouse where wh_type = 'incoming' and wh_code = '".$dt["WH_CODE"]."' ";
			
			$dt2=dbone($sql2);

			if($dt2["WH_SEQ"])
			{
				$whInDate = $dt2["WH_DATE"];
				$whInExpired = $dt2["WH_EXPIRED"];
			}
			else
			{
				$whInDate = "";
				$whInExpired = "";
			}

			//----------------------------------------------------------------------
			$mdTitle = ($refer) ? $dt["MMTITLE"] : $dt["MD_TITLE"];//약재명
			//----------------------------------------------------------------------

			$json=array(
				"seq"=>$dt["WH_SEQ"], 
				"whCode"=>$dt["WH_CODE"],
				"whInDate"=>$whInDate,//입고일
				"whInExpired"=>$whInExpired,//유통기한 
				"whCategory"=>$dt["WH_CATEGORY"], 
				"whStock"=>$dt["WH_STOCK"],
				"whTable"=>$dt["WH_TABLE"], 
				"whTitle"=>$dt["WH_TITLE"], 
				"mdTitle"=>$mdTitle,
				"mdQty"=>$dt["MD_QTY"],
				"mdOrigin"=>$dt["MD_ORIGIN"], 
				"mdMaker"=>$dt["MD_MAKER"],  
				"whQty"=>$dt["WH_QTY"], 
				"whStaff"=>$dt["WH_STAFF"],
				"whStatus"=>$dt["WH_STATUS"],
				"whExpired"=>$dt["WH_EXPIRED"], 
				"whMemo"=>getClob($dt["WH_MEMO"]),
				"whEtc"=>$dt["WH_ETC"],
				"whEtccode"=>$dt["WH_ETCCODE"],
				"whEtcstaff"=>$dt["WH_ETCSTAFF"],
				"whEtcphone"=>$dt["WH_ETCPHONE"],
				"whEtczipcode"=>$dt["WH_ETCZIPCODE"],
				"whEtcaddress"=>$dt["WH_ETCADDRESS"],
				"whDate"=>$dt["WH_DATE"],
				"cancelStatus"=>$cancelStatus,

				"whStatusOutStockList"=>$whStatusOutStockList,//출고상태 
				"whCategoryOutStockList"=>$whCategoryOutStockList,//약재분류
				"whEtcOutStockList"=>$whEtcOutStockList,//출고지 
				"mbTableList"=>$mbTableList //조제대
				);
		}
		else
		{
			$json=array(
				"whStatusOutStockList"=>$whStatusOutStockList,//출고상태 
				"whCategoryOutStockList"=>$whCategoryOutStockList,//약재분류
				"whEtcOutStockList"=>$whEtcOutStockList,//출고지 
				"mbTableList"=>$mbTableList //조제대
				);
		}

		$json["sql"]=$sql;
		$json["returnData"]=$returnData;
		$json["apiCode"]=$apicode;
		$json["resultCode"]="200";
		$json["resultMessage"]="OK";
	}

?>
