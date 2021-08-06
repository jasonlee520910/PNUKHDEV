<?php  
	/// 재고관리 > 자재입출고 > 등록 & 수정
	$apicode=$_POST["apiCode"];
	$language=$_POST["language"];
	$wh_code=$_POST["whCode"];

	if($apicode!="genstockupdate"){$json["resultMessage"]="API(apiCode) ERROR";$apicode="genstockupdate";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="API(language) ERROR";}
	else if($wh_code==""){$json["resultMessage"]="API(whCode) ERROR";}
	else
	{
		$chkval="Y";
		$wh_seq=$_POST["seq"];
		
		$sql=" select wh_code, wh_category from ".$dbH."_warehouse where wh_code='".$wh_code."' and wh_type='general' ";

		if($wh_seq)
		{
			$sql.=" and wh_seq <> '".$wh_seq."'";
		}
		$dt=dbone($sql);

		if($chkval=="Y")
		{
			///출고일경우 조회한 카테고리 값으로 입력
			if($_POST["whStatus"]=="outgoing")
			{
				$wh_category = $dt["wh_category"];
			}
			else
			{
				$wh_category=$_POST["whCategory"]; 
			}
			
			$wh_stock=$_POST["whStock"];
			$wh_title=$_POST["whTitle"];
			$wh_qty=$_POST["whQty"];
			$wh_price=$_POST["whPrice"];  ///가격
			$wh_staff=$_POST["whStaff"]; ///담당자
			$wh_origin=$_POST["whOrigin"];  ///원산지
			$wh_maker=$_POST["whMaker"];
			$wh_status=$_POST["whStatus"];///상태값
			$wh_memo=$_POST["whMemo"];
			$wh_etc=$_POST["whEtc"]; ///납품처
			$wh_etccode=$_POST["whEtccode"]; ///납품코드
			$wh_etcstaff=$_POST["whEtcstaff"]; 
			$wh_etcphone=$_POST["whEtcphone1"]."-".$_POST["whEtcphone2"]."-".$_POST["whEtcphone3"]; ///연락처
			$wh_etczipcode=$_POST["whEtczipcode"]; ///우편번호
			$wh_etcaddress=$_POST["whEtcaddress1"]."||".$_POST["whEtcaddress2"]; ///주소
			$wh_date=$_POST["whDate"];

			if($wh_seq && $wh_status=="incoming") ///입고수정
			{
				$sql=" update ".$dbH."_warehouse set wh_code='".$wh_code."', wh_category='".$wh_category."', wh_title='".$wh_title."'";
				$sql.=" , wh_qty='".$wh_qty."', wh_price='".$wh_price."', wh_staff='".$wh_staff."', wh_maker='".$wh_maker."',wh_origin='".$wh_origin."'";
				$sql.=" , wh_status='".$wh_status."', wh_memo='".$wh_memo."', wh_etc='".$wh_etc."', wh_etccode='".$wh_etccode."'";
				$sql.=" , wh_etcstaff='".$wh_etcstaff."', wh_etcphone='".$wh_etcphone."', wh_etczipcode='".$wh_etczipcode."'";
				$sql.=" , wh_etcaddress='".$wh_etcaddress."', wh_date='".$wh_date."' where wh_seq='".$wh_seq."' ";
			}
			else  ///입고 등록이거나 출고할때
			{
				$sql=" insert into ".$dbH."_warehouse (wh_seq,wh_type ,wh_code ,wh_category ,wh_title ,wh_qty ,wh_price ,wh_staff ,wh_origin ,wh_maker, wh_status ,wh_memo ,wh_etc ,wh_etccode, wh_etcstaff, wh_etcphone, wh_etczipcode, wh_etcaddress ,wh_date ,wh_use ,wh_indate) values ((SELECT NVL(MAX(wh_seq),0)+1 FROM ".$dbH."_warehouse),'general','".$wh_code."','".$wh_category."','".$wh_title."','".$wh_qty."','".$wh_price."','".$wh_staff."','".$wh_origin."','".$wh_maker."','".$wh_status."','".$wh_memo."','".$wh_etc."','".$wh_etccode."','".$wh_etcstaff."','".$wh_etcphone."','".$wh_etczipcode."','".$wh_etcaddress."','".$wh_date."','Y',SYSDATE) ";
			}

			dbcommit($sql);
			$returnData=$_POST["returnData"];
			$json=array("apiCode"=>$apicode,"returnData"=>$returnData);
			$json["sql"]=$sql;
			$json["resultCode"]="200";
			$json["resultMessage"]="OK";
		}
	}
?>