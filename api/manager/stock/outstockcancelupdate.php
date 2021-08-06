<?php  
	/// 재고관리 > 약재입고 > 상세보기 출고취소 처리
	$apicode=$_POST["apiCode"];
	$language=$_POST["language"];
	$wh_seq=$_POST["seq"];

	if($apicode!="outstockcancelupdate"){$json["resultMessage"]="API(apiCode) ERROR";$apicode="outstockcancelupdate";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="API(language) ERROR";}
	else if($wh_seq==""){$json["resultMessage"]="API(seq) ERROR";}
	else
	{
		
		$sql6=" select wh_code,wh_qty,wh_remain,wh_stock,wh_memo,wh_table from ".$dbH."_warehouse where wh_seq='".$wh_seq."' and wh_type='outgoing' ";
		//  select wh_code,wh_qty,wh_remain,wh_stock,wh_memo from han_warehouse where wh_seq='21' and wh_type='outgoing'
		$dt=dbone($sql6);
		
		$wh_code=$dt["WH_CODE"];
		$wh_qty=$dt["WH_QTY"];
		$whQty=($dt["WH_QTY"]*-1);
		$wh_stock=$dt["WH_STOCK"];
		
		$wh_remain=$dt["WH_REMAIN"];
		$whRemain = $wh_remain+$wh_qty;
		$wh_memo=$wh_memo."\n".$wh_code;


		$new_remain = $wh_remain + $dt["WH_QTY"];
		

		$sql1="";

		if($wh_code)
		{
			$sql=" INSERT INTO ".$dbH."_warehouse (wh_seq,wh_type ,wh_code ,wh_stock ,wh_category, wh_table ,wh_title ,wh_qty,wh_remain ,wh_price, wh_staff ,wh_origin,wh_maker,wh_status ,wh_expired ,wh_memo ,wh_etc ,wh_etccode, wh_etcstaff, wh_etcphone, wh_etczipcode, wh_etcaddress ,wh_date ,wh_use ,wh_indate) ";
			$sql.=" SELECT (SELECT NVL(MAX(wh_seq),0)+1 FROM ".$dbH."_warehouse),wh_type ,wh_code ,wh_stock ,wh_category, wh_table ,wh_title ,'".$whQty."','".$new_remain."',wh_price, wh_staff ,wh_origin,wh_maker,'cancel' ,wh_expired ,'".$wh_memo."' ,wh_etc ,wh_etccode, wh_etcstaff, wh_etcphone, wh_etczipcode, wh_etcaddress ,SYSDATE,'Y' ,SYSDATE  ";
			$sql.=" FROM ".$dbH."_warehouse ";
			$sql.=" WHERE wh_seq='".$wh_seq."' ";
			//echo $sql;
			dbcommit($sql);
			

			

			//incoming 은 건드리지 말고 outgoing 에서 insert remain 을 수정하기로 함.
			//$sql2=" update ".$dbH."_warehouse set wh_remain=wh_remain+".$wh_qty." where wh_code='".$wh_code."' and wh_type='incoming' ";
			//$sql2=" update ".$dbH."_warehouse set wh_remain='".$whRemain."',wh_status='cancel'  where wh_code='".$wh_code."' and wh_type='outgoing' and wh_seq='".$wh_seq."' ";
			// update han_warehouse set wh_remain=wh_remain+1000 where wh_code='STO20200413160832' and wh_type='outcoming' 
			//echo $sql2;
			dbcommit($sql2);

			

			$sql3=" update ".$dbH."_warehouse set wh_status='cancel'  where wh_seq='".$wh_seq."' ";
			//  update han_warehouse set wh_status='cancel'  where wh_seq='21'
			dbcommit($sql3);
			

			//약재재고
			$sql4=" update ".$dbH."_medicine set md_stock='Y', md_qty = md_qty + ".$wh_qty." where md_code='".$wh_stock."'";
			dbcommit($sql4);


			//medibox 에서 재고 빼기
			$sql5=" update ".$dbH."_medibox set mb_capacity = mb_capacity - ".$wh_qty." where mb_medicine='".$wh_stock."' and mb_table='".$dt["WH_TABLE"]."' and mb_stock = '".$dt["WH_CODE"]."' ";
			dbcommit($sql5);
			

			
		}


		$returnData=$_POST["returnData"];
		$json=array("apiCode"=>$apicode,"returnData"=>$returnData);
		$json["sql"]=$sql;
		$json["sql2"]=$sql2;
		$json["sql3"]=$sql3;
		$json["sql4"]=$sql4;
		$json["sql5"]=$sql5;
		$json["sql6"]=$sql6;
		
		
		$json["resultCode"]="200";
		$json["resultMessage"]="OK";

	}
?>