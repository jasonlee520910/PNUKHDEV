<?php  
	/// 제품재고관리 > 제품원재료관리 > 원재료 입고 버튼 
	$apiCode=$_GET["apiCode"];
	$language=$_GET["language"];
	$wh_seq=$_GET["seq"];

	if($apiCode!="goodsmedicinedesc"){$json["resultMessage"]="API(apiCode) ERROR";$apiCode="goodsmedicinedesc";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="API(language) ERROR";}
	///else if($wh_seq==""){$json["resultMessage"]="API(seq) ERROR";}
	else
	{
		$returnData=$_GET["returnData"];
		$json=array("apiCode"=>$apiCode,"returnData"=>$returnData);
		$wh_code=$_GET["code"];

		///------------------------------------------------------------
		/// DOO :: Code 테이블 목록 보여주기 위한 쿼리 추가 
		///------------------------------------------------------------
		$hCodeList = getNewCodeTitle("whStatusInStock");
		///------------------------------------------------------------
		$whStatusInStockList = getCodeList($hCodeList, 'whStatusInStock');///약재입고상태 

/*   상세보기는 하지 않음

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

			$ssql="a.*, b.md_title_".$language." md_title, b.md_origin_".$language." md_origin, b.md_maker_".$language." md_maker , c.mh_title_".$language." mh_title, s.st_userid, s.st_staffid, s.st_name ";
			///----------------------------------------------------------------------
			if($refer)
				$ssql.=" , r.mm_title_".$language." mmTitle, r.mm_code ";
			///----------------------------------------------------------------------
			$sql=" select $ssql from ".$dbH."_warehouse $jsql $wsql ";

			$dt=dbone($sql);

			$sql=" select count(wh_seq) cnt from han_warehouse where wh_type='incoming' and wh_memo like '%".$dt["wh_code"]."%'";
			$dt1=dbone($sql);

			if($dt1["cnt"] > 0)
			{
				$cancelStatus = "true";
			}
			else
			{
				$cancelStatus = "false";
			}

			///----------------------------------------------------------------------
			$mdTitle = ($refer) ? $dt["mmTitle"] : $dt["md_title"];///약재명
			$mbMedicine = ($refer) ? $dt["mm_code"] : $dt["mb_medicine"];///약재코드 
			///----------------------------------------------------------------------

			$json=array(
				"seq"=>$dt["wh_seq"], 
				"stUserid"=>$dt["st_userid"], 
				"stStaffid"=>$dt["st_staffid"], 
				"stName"=>$dt["st_name"], 
				"whCode"=>$dt["wh_code"], 
				"whCategory"=>$dt["wh_category"], 
				"whStock"=>$dt["wh_stock"], 
				"whTitle"=>$dt["wh_title"], 
				"mdTitle"=>$mdTitle, 
				"mdOrigin"=>$dt["md_origin"], 
				"mdMaker"=>$dt["md_maker"],  
				"whQty"=>$dt["wh_qty"], 
				"whPrice"=>$dt["wh_price"],
				"whStatus"=>$dt["wh_status"], 
				"whStaff"=>$dt["wh_staff"], 
				"whExpired"=>$dt["wh_expired"], 
				"whMemo"=>$dt["wh_memo"],
				"whEtc"=>$dt["wh_etc"],
				"whEtccode"=>$dt["wh_etccode"],
				"whEtcstaff"=>$dt["wh_etcstaff"],
				"whEtcphone"=>$dt["wh_etcphone"],
				"whEtczipcode"=>$dt["wh_etczipcode"],
				"whEtcaddress"=>$dt["wh_etcaddress"], 
				"whDate"=>$dt["wh_date"],
				"cancelStatus"=>$cancelStatus,

				
				"whStatusInStockList"=>$whStatusInStockList///약재입고상태
				);
		}
		else
		{
*/
			$json=array(
				
				"whStatusInStockList"=>$whStatusInStockList///약재입고상태
				);
		//}

		$json["sql"]=$sql;
		$json["apiCode"]=$apiCode;
		$json["resultCode"]="200";
		$json["resultMessage"]="OK";
	}
?>
