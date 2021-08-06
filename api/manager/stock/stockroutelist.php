<?php  
	/// 재고관리 > 약재이력추적 > 리스트
	$apicode=$_GET["apiCode"];
	$language=$_GET["language"];
	$mbStock=$_GET["mbStock"];
	$mbTitle=$_GET["mbTitle"];

	if($apicode!="stockroutelist"){$json["resultMessage"]="API(apiCode) ERROR";$apicode="stockroutelist";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="API(language) ERROR";}
	else
	{
		$returnData=$_GET["returnData"];
		$json=array("apiCode"=>$apicode,"returnData"=>$returnData);

		if($mbTitle) ///약재명이 있을때
		{
			$ssql=" w1.cd_name_".$language." as stockType";
			$ssql.=" ,a.wh_code, a.wh_stock , a.wh_title, a.wh_qty ,a.wh_remain, a.wh_price ,a.wh_staff";		
			$ssql.=" ,to_char(a.wh_indate,'yyyy-mm-dd') as WH_INDATE ";
			$ssql.=" ,to_char(a.wh_date,'yyyy-mm-dd') as WH_DATE ";
			$ssql.=" ,s.st_name";
			$ssql.=" ,b.mb_code "; 
			$ssql.=" ,mt.mt_title ";

			$jsql=" a inner join han_code w1 on w1.cd_type='whStatusGeStock' and w1.cd_code=a.wh_type ";
			$jsql.=" left join han_makingtable mt on mt.mt_code=a.wh_table ";
			$jsql.=" left join han_staff s on s.st_userid=a.wh_staff ";
			$jsql.=" inner join han_medicine_djmedi d on d.md_code=a.wh_stock ";
			$jsql.=" left join han_medibox b on b.mb_medicine=a.wh_stock and b.mb_table=a.wh_table ";

			//약재명으로 검색
			$wsql=" where d.mm_title_kor='".$mbTitle."' ";
			$osql=" order by a.wh_seq DESC ";

			$sql=" select $ssql from ".$dbH."_warehouse $jsql $wsql $osql";
		}
		else  ///$mbStock 이있을때(mdcode)
		{
			$ssql=" w1.cd_name_".$language." as stockType ";
			$ssql.=" ,a.wh_code, a.wh_stock, a.wh_title, a.wh_qty, a.wh_remain, a.wh_price , a.wh_staff";		
			$ssql.=" ,to_char(a.wh_indate,'yyyy-mm-dd') as WH_INDATE ";
			$ssql.=" ,to_char(a.wh_date,'yyyy-mm-dd') as WH_DATE ";
			$ssql.=" ,s.st_name ";
			$ssql.=" ,b.mb_code "; 
			$ssql.=" ,mt.mt_title ";

			$jsql=" a inner join han_code w1 on w1.cd_type='whStatusGeStock' and w1.cd_code=a.wh_type ";
			$jsql.=" left join han_makingtable mt on mt.mt_code=a.wh_table ";
			$jsql.=" left join han_staff s on s.st_userid=a.wh_staff ";
			$jsql.=" left join han_medibox b on b.mb_medicine=a.wh_stock and b.mb_table=a.wh_table ";

			//$wsql=" where wh_code='".$mbStock."' ";
			//20190820 :: 약재입고코드가 아닌 약재코드로 검색하자 
			$wsql=" where a.wh_stock='".$mbStock."' ";
			$osql=" order by a.wh_seq DESC ";

			$sql=" select $ssql from ".$dbH."_warehouse $jsql $wsql $osql";
		}


		$res=dbqry($sql);
		$json["list"]=array();

		while($dt=dbarr($res))
		{
			$addarray=array(
				"stockType"=>$dt["STOCKTYPE"], 
				"wh_code"=>$dt["WH_CODE"], 
				"wh_stock"=>$dt["WH_STOCK"], 
				"stockCategory"=>$dt["STOCKCATEGORY"], 
				"mb_code"=>$dt["MB_CODE"],
				"mt_title"=>$dt["MT_TITLE"], 
				"wh_title"=>$dt["WH_TITLE"],
				"wh_qty"=>$dt["WH_QTY"],  
				"wh_remain"=>$dt["WH_REMAIN"], 
				"wh_price"=>$dt["WH_PRICE"], 
				"st_name"=>$dt["ST_NAME"], 
				"wh_staff"=>$dt["WH_STAFF"],
				"wh_date"=>$dt["WH_DATE"],
				"wh_indate"=>$dt["WH_INDATE"]
				);
			array_push($json["list"], $addarray);
		}
		$json["sql"]=$sql;
		$json["resultCode"]="200";
		$json["resultMessage"]="OK";
	}
?>