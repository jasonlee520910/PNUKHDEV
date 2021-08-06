<?php  
	/// 재고관리 > 약재입고 > 상세보기
	$apiCode=$_GET["apiCode"];
	$language=$_GET["language"];
	$wh_seq=$_GET["seq"];

	if($apiCode!="instockdesc"){$json["resultMessage"]="API(apiCode) ERROR";$apiCode="instockdesc";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="API(language) ERROR";}
	///else if($wh_seq==""){$json["resultMessage"]="API(seq) ERROR";}
	else
	{
		$returnData=$_GET["returnData"];
		$json=array("apiCode"=>$apiCode,"returnData"=>$returnData);
		$wh_code=$_GET["code"];

		$hCodeList = getNewCodeTitle("whCategoryInStock,whStatusInStock");
		$whCategoryInStockList = getCodeList($hCodeList, 'whCategoryInStock');//약재분류 
		$whStatusInStockList = getCodeList($hCodeList, 'whStatusInStock');//약재입고상태 

		if($wh_seq)
		{

			$jsql=" a left join ".$dbH."_medicine b on a.wh_stock=b.md_code ";
			$jsql.=" left join ".$dbH."_medihub c on b.md_hub=c.mh_code ";
			$jsql.=" left join ".$dbH."_staff s on a.wh_staff=s.st_userid ";
			///----------------------------------------------------------------------
			///세명대 약재명을 가져오기 위함
			if($refer)
				$jsql.=" inner join ".$dbH."_medicine_".$refer." r on b.md_code=r.md_code  ";
			///----------------------------------------------------------------------
			$wsql=" where wh_type='incoming' ";

			if($wh_code){
				$wsql.=" and wh_code = '".$wh_code."' ";
			}else{
				$wsql.=" and wh_seq = '".$wh_seq."' ";
			}


			$ssql=" a.WH_SEQ,a.WH_CODE,a.WH_CATEGORY,a.WH_STOCK,a.WH_TITLE,a.WH_MAKER,a.WH_QTY,a.WH_PRICE,a.WH_STAFF,a.WH_STATUS";
			$ssql.=" ,a.wh_serialno,a.wh_trialno,a.wh_standard ";
			$ssql.=" ,a.WH_ETC,a.WH_ORIGIN,a.WH_ETCCODE,a.WH_ETCSTAFF,a.WH_ETCZIPCODE,a.WH_ETCADDRESS,a.WH_ETCPHONE";
			$ssql.=" ,to_char(a.WH_DATE,'yyyy-mm-dd') as WH_DATE ";
			$ssql.=" ,to_char(a.WH_EXPIRED,'yyyy-mm-dd') as WH_EXPIRED ";
			//$ssql.=" ,DBMS_LOB.SUBSTR(a.WH_MEMO, DBMS_LOB.GETLENGTH(a.WH_MEMO)) as WH_MEMO";
			$ssql.=" ,a.WH_MEMO as WH_MEMO";
			$ssql.=" ,b.md_title_".$language." as md_title, b.md_origin_".$language." as MD_ORIGIN, b.md_maker_".$language." as MD_MAKER ";
			$ssql.=" ,c.mh_title_".$language." as mh_title";
			$ssql.=" ,s.st_userid, s.st_staffid, s.st_name ";

			///----------------------------------------------------------------------
			if($refer)
				$ssql.=" , r.mm_title_".$language." as MMTITLE, r.mm_code ";
			///----------------------------------------------------------------------
			$sql=" select $ssql from ".$dbH."_warehouse $jsql $wsql ";

			$dt=dbone($sql);

			$sql2=" select count(wh_seq) cnt from han_warehouse where wh_type='incoming' and wh_memo like '%".$dt["WH_CODE"]."%'";
			$dt1=dbone($sql2);

			if($dt1["CNT"] > 0)
			{
				$cancelStatus = "true";
			}
			else
			{
				$cancelStatus = "false";
			}

			///----------------------------------------------------------------------
			$mdTitle = ($refer) ? $dt["MMTITLE"] : $dt["MD_TITLE"];///약재명
			$mbMedicine = ($refer) ? $dt["MM_CODE"] : $dt["MB_MEDICINE"];///약재코드 
			///----------------------------------------------------------------------

			$json=array(
				"seq"=>$dt["WH_SEQ"], 

				"whSerialno"=>$dt["WH_SERIALNO"], 
				"whTrialno"=>$dt["WH_TRIALNO"], 
				"whStandard"=>$dt["WH_STANDARD"], 

				"stUserid"=>$dt["ST_USERID"], 
				"stStaffid"=>$dt["ST_STAFFID"], 
				"stName"=>$dt["ST_NAME"], 
				"whCode"=>$dt["WH_CODE"], 
				"whCategory"=>$dt["WH_CATEGORY"], 
				"whStock"=>$dt["WH_STOCK"], 
				"whTitle"=>$dt["WH_TITLE"], 
				"mdTitle"=>$mdTitle, 
				"mdOrigin"=>$dt["MD_ORIGIN"], 
				"mdMaker"=>$dt["MD_MAKER"],  
				"whQty"=>$dt["WH_QTY"], 
				"whPrice"=>$dt["WH_PRICE"],
				"whStatus"=>$dt["WH_STATUS"], 
				"whStaff"=>$dt["WH_STAFF"], 
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

				"whCategoryInStockList"=>$whCategoryInStockList,///약재분류
				"whStatusInStockList"=>$whStatusInStockList///약재입고상태
				);

			///약재목록 api 추가 리스트 -약재명, 원산지/제조사

			$sql2=" select af_seq, af_name, af_url as AFURL from ".$dbH."_file where af_use='Y' and af_code='instock' and af_fcode='".$dt["WH_CODE"]."' order by af_no desc ";
			//echo $sql2;
			$res=dbqry($sql2);

			$json["afFiles"]=array();
			for($i=0;$dt=dbarr($res);$i++)
			{
				$afFile=getafFile($dt["AFURL"]);
				$afThumbUrl=getafThumbUrl($dt["AFURL"]);

				$addarray=array(
					"afseq"=>$dt["AF_SEQ"], 
					"afCode"=>$dt["AF_CODE"], 
					"afThumbUrl"=>$afThumbUrl, 
					"afUrl"=>$afFile, 
					"afName"=>$dt["AF_NAME"], 
					"afSize"=>$dt["AF_SIZE"]
					);
				array_push($json["afFiles"], $addarray);
			}


		}
		else
		{
			$json=array(
				"whCategoryInStockList"=>$whCategoryInStockList,///약재분류
				"whStatusInStockList"=>$whStatusInStockList///약재입고상태
				);
		}

		$json["sql"]=$sql;
		$json["sql2"]=$sql2;
		
		$json["apiCode"]=$apiCode;
		$json["resultCode"]="200";
		$json["resultMessage"]="OK";
	}
?>
