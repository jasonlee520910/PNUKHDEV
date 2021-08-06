<?php  
	/// 제품재고관리 > 제품원재료관리 > 원재료입고 버튼 저장하기
	$apicode=$_POST["apiCode"];
	$language=$_POST["language"];
	$gd_seq=$_POST["seq"];

	if($apicode!="goodsstockupdate"){$json["resultMessage"]="API(apiCode) ERROR";$apicode="goodsstockupdate";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="API(language) ERROR";}
	else if($gd_seq==""){$json["resultMessage"]="API(seq) ERROR";}
	else
	{
		$wh_category=$_POST["whCategory"];
		$wh_stock=$_POST["whStock"];  //HD10154_06
		$wh_title=$_POST["whTitle"];
		$wh_qty=$_POST["whQty"];  //입고량
		if($wh_qty=="")$wh_qty=0;
		
		$wh_price=$_POST["whPrice"];
		$wh_status=$_POST["whStatus"];
		$wh_expired=$_POST["whExpired"];
		$wh_staff=$_POST["whStaff"];
		$wh_memo=$_POST["whMemo"];
		$wh_etc=$_POST["whEtc"];
		$wh_etccode=$_POST["whEtccode"];
		$wh_etcstaff=$_POST["whEtcstaff"];
		$wh_etcphone=$_POST["whEtcphone"];
		$wh_etczipcode=$_POST["whEtczipcode"];
		$wh_etcaddress=$_POST["whEtcaddress"];
		$wh_date=$_POST["whDate"];
		$whCode=$_POST["whCode"];
				
		//------------------------------------------------------------------------------------------------------------
		//입고 >>> 
		//약재(창고)에 재고 추가 
		$sql2=" update ".$dbH."_medicine set md_stock='Y', md_status='use', md_qty = md_qty + ".$wh_qty.", md_indate=sysdate, md_modify=sysdate ";
		$sql2.=" where md_code='".$wh_stock."'";
		dbcommit($sql2);

		$sql3=" insert into ".$dbH."_warehouse (wh_seq,wh_type ,wh_code ,wh_stock ";
		$sql3.=" ,wh_category ,wh_title ,wh_qty ,wh_remain ,wh_price ,wh_status ,wh_expired ,wh_staff ";
		$sql3.=" , wh_memo ,wh_etc ,wh_etccode, wh_etcstaff, wh_etcphone, wh_etczipcode, wh_etcaddress ,wh_date ,wh_use ,wh_indate)";
		$sql3.=" values ((SELECT NVL(MAX(wh_seq),0)+1 FROM ".$dbH."_warehouse),'incoming','".$whCode."','".$wh_stock."' ";
		$sql3.=" ,'".$wh_category."','".$wh_title."','".$wh_qty."','".$wh_qty."','".$wh_price."','".$wh_status."','".$wh_expired."','".$wh_staff."'";
		$sql3.=" ,'".$wh_memo."','".$wh_etc."','".$wh_etccode."','".$wh_etcstaff."','".$wh_etcphone."','".$wh_etczipcode."' ";
		$sql3.=" ,'".$wh_etcaddress."','".$wh_date."','Y',sysdate) ";
		dbcommit($sql3);
	
		//------------------------------------------------------------------------------------------------------------
		//출고 >>> 
		//약재재고차감
		$sql4=" update ".$dbH."_medicine set md_stock='Y', md_qty = md_qty - ".$wh_qty.", md_modify=sysdate where md_code='".$wh_stock."'";
		dbcommit($sql4);

		$sql5=" insert into ".$dbH."_warehouse (wh_seq,wh_type ,wh_code ,wh_stock ,wh_category ,wh_table ";
		$sql5.=" , wh_title ,wh_qty ,wh_remain,wh_staff ,wh_status ,wh_expired ,wh_memo ,wh_etc ,wh_etccode, wh_etcstaff ";
		$sql5.=" , wh_etcphone, wh_etczipcode, wh_etcaddress ,wh_date ,wh_use ,wh_indate) ";
		$sql5.="  values ((SELECT NVL(MAX(wh_seq),0)+1 FROM ".$dbH."_warehouse),'outgoing','".$whCode."','".$wh_stock."','".$wh_category."','99999' ";
		$sql5.=" , '".$wh_title."','".$wh_qty."','0','".$wh_staff."','outgoing','".$wh_expired."','".$wh_memo."','".$wh_etc."','".$wh_etccode."','".$wh_etcstaff."' ";
		$sql5.=" ,'".$wh_etcphone."','".$wh_etczipcode."','".$wh_etcaddress."',sysdate,'Y',sysdate) ";
		dbcommit($sql5);


		//약재함재고확인
		$sql8=" select mb_capacity from ".$dbH."_medibox where mb_medicine ='".$wh_stock."' and mb_table= '99999' ";
		$dt8=dbone($sql8);
		$oldcapacity=$dt8["MB_CAPACITY"];
 		$newcapacity=$oldcapacity+$wh_qty;

		//약재함재고추가 ( mb_table = '99999')
		$sql6=" update ".$dbH."_medibox set  mb_capacity ='".$newcapacity."', mb_modify=sysdate where mb_table = '99999' and mb_medicine = '".$wh_stock."'  ";
		dbcommit($sql6);

		//제환실 로그 남기기
		$sql7=" insert into ".$dbH."_goodshouse (gh_seq,gh_odcode ";
		$sql7.=" , gh_type, gh_code, gh_oldqty, gh_addqty, gh_qty, gh_desc, gh_use, gh_date)";
		$sql7.=" values ((SELECT NVL(MAX(gh_seq),0)+1 FROM ".$dbH."_goodshouse),'','incoming' ";
		$sql7.=" ,'".$wh_stock."','".$oldcapacity."','".$wh_qty."','".$newcapacity."','','Y',sysdate) ";
		dbcommit($sql7);
	
		$returnData=$_POST["returnData"];
		$json=array("apiCode"=>$apicode,"returnData"=>$returnData);
		$json["resultCode"]="200";
		$json["resultMessage"]="OK";
		$json["sql2"]=$sql2;
		$json["sql3"]=$sql3;
		$json["sql4"]=$sql4;
		$json["sql5"]=$sql5;
		$json["sql6"]=$sql6;	
		$json["sql7"]=$sql7;	
		$json["sql8"]=$sql8;		
	}
?>