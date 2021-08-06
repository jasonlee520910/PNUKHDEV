<?php  
	/// 재고관리 > 자재입출고 > 상세보기
	$apicode=$_GET["apiCode"];
	$language=$_GET["language"];
	$wh_seq=$_GET["seq"];

	if($apicode!="genstockdesc"){$json["resultMessage"]="API(apiCode) ERROR";$apicode="genstockdesc";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="API(language) ERROR";}
	///else if($wh_seq==""){$json["resultMessage"]="API(seq) ERROR";}
	else
	{
		$returnData=$_GET["returnData"];
		
		$hCodeList = getNewCodeTitle("whStatusGeStock,whCategoryGeStock");
		$whStatusGeStockList = getCodeList($hCodeList, 'whStatusGeStock');//입출고구분 
		$whCategoryGeStockList = getCodeList($hCodeList, 'whCategoryGeStock');//자재분류  
		
		if($wh_seq)
		{
			$jsql=" a left join ".$dbH."_medicine b on a.wh_stock=b.md_code ";
			$jsql.=" left join ".$dbH."_medihub c on b.md_hub=c.mh_code ";
			$wsql=" where wh_seq = '".$wh_seq."' and wh_type='general' ";

			$ssql=" a.WH_SEQ,a.WH_CODE,a.WH_CATEGORY,a.WH_STOCK,a.WH_TITLE,a.WH_MAKER,a.WH_QTY,a.WH_PRICE,a.WH_STAFF,a.WH_STATUS";
			$ssql.=" ,a.WH_EXPIRED,a.WH_ETC,a.WH_ORIGIN,a.WH_ETCCODE,a.WH_ETCSTAFF,a.WH_ETCZIPCODE,a.WH_ETCADDRESS,a.WH_ETCPHONE";
			$ssql.=" ,to_char(a.WH_DATE,'yyyy-mm-dd') as WH_DATE ";
			$ssql.=" ,DBMS_LOB.SUBSTR(a.WH_MEMO, DBMS_LOB.GETLENGTH(a.WH_MEMO)) as WH_MEMO";
			///$ssql.=", b.md_title_".$language." md_title, b.md_origin_".$language." md_origin, b.md_maker_".$language." md_maker ";
			///$ssql=" ,c.mh_title_".$language." mh_title";

			$sql=" select $ssql from ".$dbH."_warehouse $jsql $wsql ";
			$dt=dbone($sql);

			$addinfo = explode ("||", $dt["WH_ETCADDRESS"]);
			$phone=explode("-", $dt["WH_ETCPHONE"]);

			$json=array(
				"seq"=>$dt["WH_SEQ"], 
				"whCode"=>$dt["WH_CODE"], 
				"barcode"=>$dt["WH_CODE"],
				"whCategory"=>$dt["WH_CATEGORY"], 
				"whStock"=>$dt["WH_STOCK"], 
				"whTitle"=>$dt["WH_TITLE"], 
				"whMaker"=>$dt["WH_MAKER"], 
				"whQty"=>$dt["WH_QTY"], 
				"whPrice"=>$dt["WH_PRICE"], ///가격
				"whStaff"=>$dt["WH_STAFF"],
				"whStatus"=>$dt["WH_STATUS"], 
				"whExpired"=>$dt["WH_EXPIRED"], 
				"whMemo"=>$dt["WH_MEMO"],
				"whEtc"=>$dt["WH_ETC"],
				"whOrigin"=>$dt["WH_ORIGIN"],///원산지
				
				"whEtccode"=>$dt["WH_ETCCODE"],
				"whEtcstaff"=>$dt["WH_ETCSTAFF"],
							
				"whEtcphone1"=>$phone[0], ///전화번호
				"whEtcphone2"=>$phone[1], ///전화번호
				"whEtcphone3"=>$phone[2], ///전화번호

				"whEtczipcode"=>$dt["WH_ETCZIPCODE"],
				"whEtcaddress1"=>$addinfo[0], 
				"whEtcaddress2"=>$addinfo[1], 
				"whDate"=>$dt["WH_DATE"],

				"whStatusGeStockList"=>$whStatusGeStockList,
				"whCategoryGeStockList"=>$whCategoryGeStockList				
				);
		}
		else
		{
			$json=array(
				"whStatusGeStockList"=>$whStatusGeStockList,
				"whCategoryGeStockList"=>$whCategoryGeStockList
				);
		}

		$json["apiCode"]=$apicode;
		$json["returnData"]=$returnData;
		$json["sql"]=$sql;
		$json["resultCode"]="200";
		$json["resultMessage"]="OK";
	}
?>
