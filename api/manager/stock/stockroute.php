<?php  
	/// 재고관리 > 약재이력추적 > 약재함으로 검색할때 
	$apicode=$_GET["apiCode"];
	$language=$_GET["language"];
	$code=$_GET["code"];

	if($apicode!="stockroute"){$json["resultMessage"]="API(apiCode) ERROR";$apicode="stockroute";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="API(language) ERROR";}
	else
	{
		$returnData=$_GET["returnData"];
		$json=array("apiCode"=>$apicode,"returnData"=>$returnData);

		$jsql=" a inner join han_medicine b on a.mb_medicine=b.md_code ";
		$jsql.=" inner join han_medicine_djmedi c on b.md_code=c.md_code ";
		$jsql.=" left join han_warehouse d on d.wh_code = a.mb_stock and d.wh_type='outgoing' ";

		$wsql=" where mb_code ='".$code."' ";

		$ssql=" a.mb_capacity, a.mb_code, a.mb_stock, a.mb_medicine ";
		$ssql.=" ,b.md_origin_".$language." MD_ORIGIN, b.md_maker_".$language." MD_MAKER, b.md_qty ";
		$ssql.=" ,c.mm_title_".$language." MM_TITLE ";
		$ssql.=" ,to_char(d.wh_date,'yyyy-mm-dd') as WH_DATE";
		

		//$ssql.=" ,( select concat(wh_expired,',',wh_date) from han_warehouse where wh_type='incoming' and wh_code= a.mb_stock group by wh_type order by wh_indate desc) as INCOMING ";
		//$ssql.=" ,( select concat(wh_date) from han_warehouse where wh_type='outgoing' and wh_code= a.mb_stock group by wh_type order by wh_indate desc) as OUTGOING ";

		$ssql.=" ,( select to_char(wh_expired,'yyyy-mm-dd')||','||to_char(wh_date,'yyyy-mm-dd') from han_warehouse where wh_type='incoming' and wh_code= a.mb_stock ) as INCOMING ";

		$sql=" select $ssql from ".$dbH."_medibox $jsql $wsql ";

		$dt=dbone($sql);
		$incoming=explode(",",$dt["INCOMING"]);

		$outgoing=$dt["WH_DATE"];

		$datetime11 = date("Y-m-d");
		$datetime22 = date($incoming[0]);

		$datetime1 = date_create($datetime11);
		$datetime2 = date_create($datetime22);
		
		$interval = date_diff($datetime1, $datetime2);

		$json["data"]=array(	
			"mbCapacity"=>$dt["MB_CAPACITY"], //약재함잔량 추가

			"mbCode"=>$dt["MB_CODE"], 
			"mbStock"=>$dt["MB_STOCK"], 
			"mbMedicine"=>$dt["MB_MEDICINE"],
			"mdOrigin"=>$dt["MD_ORIGIN"],
			"mdMaker"=>$dt["MD_MAKER"], 
			"mdQty"=>$dt["MD_QTY"], 
			"mmTitle"=>$dt["MM_TITLE"], 
			"whExpired"=>$incoming[0], 
			"whIndate"=>$incoming[1], 
			"whOutdate"=>$outgoing,
			"whExpiredDay"=>$interval
		);
		$json["sql"]=$sql;
		$json["resultCode"]="200";
		$json["resultMessage"]="OK";
	}

?>