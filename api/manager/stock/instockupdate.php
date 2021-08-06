<?php  
	/// 재고관리 > 약재입고 > 등록 & 수정
	$apicode=$_POST["apiCode"];
	$language=$_POST["language"];
	$wh_code=$_POST["whCode"];

	if($apicode!="instockupdate"){$json["resultMessage"]="API(apiCode) ERROR";$apicode="instockupdate";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="API(language) ERROR";}
	else if($wh_code==""){$json["resultMessage"]="API(whCode) ERROR";}
	else
	{
		$chkval="Y";
		$wh_seq=$_POST["seq"];

		if($wh_seq=="add"){$wh_seq="";}
		$sql=" select wh_code from ".$dbH."_warehouse where wh_code='".$wh_code."' and wh_type='incoming' ";
		if($wh_seq){
			$sql.=" and wh_seq <> '".$wh_seq."'";
		}
		$dt=dbone($sql);
		if($dt["wh_code"]){
			$chkval="N";
			$json["resultCode"]="209";
			$json["resultMessage"]="1526";
		}
		if($chkval=="Y"){
			$wh_category=$_POST["whCategory"];
			$wh_stock=$_POST["whStock"];
			$wh_title=$_POST["whTitle"];
			$wh_qty=$_POST["whQty"];
			if($wh_qty=="")$wh_qty=0;
			$wh_remain=$_POST["whQty"];///남은용량은 동일하게
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
			$old_qty=0;

			$wh_serialno=$_POST["whSerialno"];
			$wh_trialno=$_POST["whTrialno"];
			$wh_standard=$_POST["whStandard"];

			if($wh_seq)
			{
				///업데이트일경우 기존 약재재고차감
				$sql=" select wh_qty from ".$dbH."_warehouse where wh_seq='".$wh_seq."' ";
				$dt=dbone($sql);

				$old_qty=$dt["WH_QTY"];

				$sql=" update ".$dbH."_warehouse set wh_code='".$wh_code."'";
				$sql.=" ,wh_serialno='".$wh_serialno."',wh_trialno='".$wh_trialno."',wh_stock='".$wh_stock."'";
				$sql.=" ,wh_stock='".$wh_stock."',wh_category='".$wh_category."',wh_standard='".$wh_standard."'";
				$sql.=" ,wh_title='".$wh_title."',wh_qty='".$wh_qty."',wh_remain='".$wh_qty."'";
				$sql.=" ,wh_price='".$wh_price."',wh_status='".$wh_status."',wh_expired='".$wh_expired."'";
				$sql.=" ,wh_staff='".$wh_staff."',wh_memo='".$wh_memo."',wh_etc='".$wh_etc."'";
				$sql.=" ,wh_etccode='".$wh_etccode."',wh_etcstaff='".$wh_etcstaff."',wh_etcphone='".$wh_etcphone."'";
				$sql.=" ,wh_etczipcode='".$wh_etczipcode."',wh_etcaddress='".$wh_etcaddress."',wh_date='".$wh_date."' ";
				$sql.=" where wh_seq='".$wh_seq."' ";
			}
			else
			{
				$sql=" insert into ".$dbH."_warehouse (wh_seq,wh_serialno,wh_trialno,wh_standard,wh_type ,wh_code ,wh_stock ,wh_category ,wh_title ,wh_qty ,wh_remain ,wh_price ,wh_status ,wh_expired ,wh_staff, wh_memo ,wh_etc ,wh_etccode, wh_etcstaff, wh_etcphone, wh_etczipcode, wh_etcaddress ,wh_date ,wh_use ,wh_indate) ";
				$sql.=" values ((SELECT NVL(MAX(wh_seq),0)+1 FROM ".$dbH."_warehouse)";
				$sql.=" ,'".$wh_serialno."','".$wh_trialno."','".$wh_standard."'";
				$sql.=" ,'incoming','".$wh_code."','".$wh_stock."','".$wh_category."' ";
				$sql.=" ,'".$wh_title."','".$wh_qty."','".$wh_remain."','".$wh_price."','".$wh_status."','".$wh_expired."','".$wh_staff."'";
				$sql.=" ,'".$wh_memo."','".$wh_etc."','".$wh_etccode."','".$wh_etcstaff."','".$wh_etcphone."'";
				$sql.=" ,'".$wh_etczipcode."','".$wh_etcaddress."','".$wh_date."','Y',SYSDATE) ";
			}

			dbcommit($sql);

			///약재(창고)에 재고 추가 
			$sql2=" update ".$dbH."_medicine set md_stock='Y', md_status='use', md_qty = md_qty + ".($wh_qty-$old_qty).", md_indate=SYSDATE where md_code='".$wh_stock."'";
			dbcommit($sql2);

			$returnData=$_POST["returnData"];
			$json=array("apiCode"=>$apicode,"returnData"=>$returnData);
			$json["sql"]=$sql;
			$json["sql2"]=$sql2;
			$json["resultCode"]="200";
			$json["resultMessage"]="OK";
		}
	}
?>