<?php  
	/// 재고관리 > 약재입고 > 상세보기 입고취소 처리
	$apicode=$_POST["apiCode"];
	$language=$_POST["language"];
	$wh_seq=$_POST["seq"];

	if($apicode!="instockcancelupdate"){$json["resultMessage"]="API(apiCode) ERROR";$apicode="instockcancelupdate";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="API(language) ERROR";}
	else if($wh_seq==""){$json["resultMessage"]="API(seq) ERROR";}
	else
	{

		$sql=" select wh_code, wh_qty, wh_stock, wh_memo from ".$dbH."_warehouse where wh_seq='".$wh_seq."' ";
		$dt=dbone($sql);

		$owh_code=$dt["WH_CODE"];
		$wh_qty=intval($dt["WH_QTY"]);
		$wh_qty=$wh_qty*-1;
		$wh_stock=$dt["WH_STOCK"];
		$whCode="STO".date("YmdHis");  ///입고취소할때는 입고코드 자체로 insert 한다. 
		$whDate=date("Y-m-d");
		$wh_memo=$wh_memo."\n".$owh_code;
		$sql1="";

		//입고가 취소 되므로 remain은 0
		$sql1=" INSERT INTO ".$dbH."_warehouse (wh_seq,wh_type ,wh_code ,wh_stock ,wh_category ,wh_title ,wh_qty ,wh_remain ,wh_price ,wh_staff,wh_status ,wh_expired ,wh_memo ,wh_etc ,wh_etccode, wh_etcstaff, wh_etcphone, wh_etczipcode, wh_etcaddress ,wh_date ,wh_use ,wh_indate) ";
		$sql1.=" SELECT (SELECT NVL(MAX(wh_seq),0)+1 FROM ".$dbH."_warehouse), wh_type ,'".$owh_code."' ,wh_stock ,wh_category ,wh_title ,'".$wh_qty."','0' ,wh_price ,wh_staff,'cancel' ,wh_expired ,wh_memo ,wh_etc ,wh_etccode, wh_etcstaff, wh_etcphone, wh_etczipcode, wh_etcaddress ,'".$whDate."' ,'Y',SYSDATE";
		$sql1.=" FROM ".$dbH."_warehouse ";
		$sql1.=" WHERE wh_seq ='".$wh_seq."' ";

		dbcommit($sql1);
		

		//$sql2=" update ".$dbH."_warehouse set wh_status='cancel' , wh_remain='0' where wh_seq='".$wh_seq."' ";
		$sql2=" update ".$dbH."_warehouse set wh_status='cancel'  where wh_seq='".$wh_seq."' ";
		//update han_warehouse set wh_status='cancel'  where wh_seq='17'  and wh_remain='0'  
		dbcommit($sql2);
		

		$sql3=" update ".$dbH."_medicine set md_stock='Y', md_qty = md_qty + ".($wh_qty).", md_indate=SYSDATE where md_code='".$wh_stock."'";
		//update han_medicine set md_stock='Y', md_qty = md_qty + -2000, md_indate=SYSDATE where md_code='HD10476_01'
		dbcommit($sql3);
		

		$returnData=$_POST["returnData"];
		$json=array("apiCode"=>$apicode,"returnData"=>$returnData);
		$json["sql"]=$sql;
		$json["sql1"]=$sql1;
		$json["sql2"]=$sql2;
		$json["sql3"]=$sql3;

		$json["resultCode"]="200";
		$json["resultMessage"]="OK";		
	}
?>