<?php  
	/// 재고관리 > 약재출고 > 등록 & 수정
	$apicode=$_POST["apiCode"];
	$language=$_POST["language"];
	$wh_code=$_POST["whCode"];

	if($apicode!="outstockupdate"){$json["resultMessage"]="API(apiCode) ERROR";$apicode="outstockupdate";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="API(language) ERROR";}
	else if($wh_code==""){$json["resultMessage"]="API(whCode) ERROR";}
	else
	{
		$sql9=" select wh_code from ".$dbH."_warehouse where wh_code='".$wh_code."' and wh_type='incoming' ";
		//   select wh_code from han_warehouse where wh_code='STO20200427154441' and wh_type='incoming'

		$dt=dbone($sql9);
		$json["sql9"]=$sql9;
		
		if($dt["WH_CODE"])
		{
			$wh_category=$_POST["whCategory"];
			$wh_stock=$_POST["whStock"];
			$wh_title=$_POST["whTitle"];
			$wh_qty=$_POST["whQty"];
			$wh_staff=$_POST["whStaff"];
			$wh_status=$_POST["whStatus"];
			$wh_expired=$_POST["whExpired"]; ///유통기한
			//if(!$wh_expired) {$wh_expired='0000-00-00';} ///입고에서는 유통기한이 있지만 출고에서는 유통기한이 없으므로 0000-00-00으로 셋팅하여 데이터를 입력한다. 
			if(!$wh_expired) {$wh_expired=null;} ///입고에서는 유통기한이 있지만 출고에서는 유통기한이 없으므로 null으로 셋팅하여 데이터를 입력한다. 
			$wh_memo=$_POST["whMemo"];
			$wh_etc=$_POST["whEtc"];
			$wh_etccode=$_POST["whEtccode"];
			$wh_etcstaff=$_POST["whEtcstaff"];
			$wh_etcphone=$_POST["whEtcphone"];
			$wh_etczipcode=$_POST["whEtczipcode"];
			$wh_etcaddress=$_POST["whEtcaddress"];
			$wh_date=$_POST["whDate"];
			$wh_table=$_POST["mbTalbe"];  ///조제대구별			
			$incomingCode=$_POST["incomingCode"];
			$returnData=$_POST["returnData"];
			$hdcode=$_POST["whStock"];  ///디제이메디 약재코드

			$json=array("apiCode"=>$apicode,"returnData"=>$returnData);

			///약재함이 있는지 여부 체크  
			$sql=" select mb_code,mb_capacity,mb_use  from ".$dbH."_medibox where mb_table = '".$wh_table."' and mb_medicine = '".$wh_stock."'  and  mb_use<>'D' ";
			//"" select mb_code,mb_capacity,mb_use  from han_medibox where mb_table = '99999' and mb_medicine = 'HD000101KR0002J'  and  mb_use<>'D' "
	
			$dt=dbone($sql);

			if($dt["MB_CODE"] || $wh_etc=="medipill")///약재함이 있다면, 191003.green 있거나제환실출고일경우
			{
				if($dt["MB_USE"] == 'Y' || $wh_etc=="medipill") ///사용가능, 191003.green 이거나제환실출고일경우 (medipill -> 제환실출고)
				{

					///-----------------------------------------------------------------------------
					///0427 약재출고시 해당 STO  remain 양이 최대치로 출고될수 있게 변경 (han_medicine 창고량이 아니라)
					///-----------------------------------------------------------------------------

					///약재량이 가능한지 체크 
					//$sql1=" select md_qty from han_medicine where md_code = '".$wh_stock."' and md_use<>'D' ";
					$sql1 =" select * from  ( select wh_remain,wh_seq from han_warehouse where wh_use<>'D' and wh_code ='".$wh_code."' and wh_status<>'cancel' order by wh_seq desc ) where rownum <= 1 ";
					// select * from  ( select wh_remain,wh_seq from han_warehouse where wh_use<>'D' and wh_code ='STO20200427154441'  and wh_status<>'cancel'  order by wh_seq desc ) where rownum <= 1 

					$dt1=dbone($sql1);
				
					if($dt1["WH_REMAIN"] >= $wh_qty)
					{
						///약재재고차감
						$sql3=" update ".$dbH."_medicine set md_stock='Y', md_qty = md_qty - ".$wh_qty.", md_modify=SYSDATE where md_code='".$wh_stock."'";
						// " update han_medicine set md_stock='Y', md_qty = md_qty - 200, md_modify=SYSDATE where md_code='HD000101KR0002J'"
						dbcommit($sql3);

						if($wh_table=="99999") ///191003.green 약재함 출고일 경우 기존재고량체크 아래 약재함 업데이트 이전
						{
							$sql4=" select mb_capacity from ".$dbH."_medibox where mb_medicine='".$wh_stock."' and mb_table='99999' ";
							//" select mb_capacity from han_medibox where mb_medicine='HD000101KR0002J' and mb_table='99999' "
							$dt=dbone($sql4);
							$mb_oldcapacity=$dt["MB_CAPACITY"];
						}
						
						///약재함재고추가 
						$sql5=" update ".$dbH."_medibox set mb_stock='".$wh_code."', mb_capacity = mb_capacity + ".$wh_qty.", mb_modify=SYSDATE where mb_table = '".$wh_table."' and mb_medicine = '".$wh_stock."'  ";
						//" update han_medibox set mb_stock='STO20200423121555', mb_capacity = mb_capacity + 200, mb_modify=SYSDATE where mb_table = '99999' and mb_medicine = 'HD000101KR0002J'  "
						dbcommit($sql5);

						//출고한게 먼저 있는지 체크 
						//$bsql =" select * from  ( select wh_remain,wh_seq from han_warehouse where wh_use<>'D' and wh_code ='".$wh_code."' and wh_remain<>'0' and wh_type='outgoing' order by wh_seq desc ) where rownum <= 1 ";
						$bsql =" select * from  ( select wh_remain,wh_seq from han_warehouse where wh_use<>'D' and wh_code ='".$wh_code."' and wh_type='outgoing' order by wh_seq desc ) where rownum <= 1 ";
						$dt5=dbone($bsql);

						$json["bsql"]=$bsql;

						//출고한게 없을때 입고한거에서 찾는다.
						if(!$dt5["WH_REMAIN"])
						{
							//$asql =" select * from  ( select wh_remain,wh_seq from han_warehouse where wh_use<>'D' and wh_code ='".$wh_code."' and wh_remain<>'0' order by wh_seq desc) where rownum <= 1 ";
							$asql =" select * from  ( select wh_remain,wh_seq from han_warehouse where wh_use<>'D' and wh_code ='".$wh_code."' and wh_type='incoming' order by wh_seq desc) where rownum <= 1 ";
							$dt3=dbone($asql);
							$json["asql"]=$asql;
							$new_wh_remain = $dt3["WH_REMAIN"]-$wh_qty;
						}
						else
						{
						
							$new_wh_remain = $dt5["WH_REMAIN"]-$wh_qty;					
						}


						$sql6=" insert into ".$dbH."_warehouse (wh_seq,wh_type ,wh_code ,wh_stock ,wh_category ,wh_table, wh_title ,wh_qty,wh_remain ,wh_staff ,wh_status ,wh_expired ,wh_memo ,wh_etc ,wh_etccode, wh_etcstaff, wh_etcphone, wh_etczipcode, wh_etcaddress ,wh_date ,wh_use ,wh_indate)";
						$sql6.=" values ((SELECT NVL(MAX(wh_seq),0)+1 FROM ".$dbH."_warehouse),'outgoing','".$wh_code."','".$wh_stock."','".$wh_category."','".$wh_table."', '".$wh_title."','".$wh_qty."','".$new_wh_remain."','".$wh_staff."','outgoing','".$wh_expired."','".$wh_memo."','".$wh_etc."','".$wh_etccode."','".$wh_etcstaff."','".$wh_etcphone."','".$wh_etczipcode."','".$wh_etcaddress."',SYSDATE,'Y',SYSDATE) ";

						//" insert into han_warehouse (wh_seq,wh_type ,wh_code ,wh_stock ,wh_category ,wh_table, wh_title ,wh_qty,wh_remain ,wh_staff ,wh_status ,wh_expired ,wh_memo ,wh_etc ,wh_etccode, wh_etcstaff, wh_etcphone, wh_etczipcode, wh_etcaddress ,wh_date ,wh_use ,wh_indate) values ((SELECT NVL(MAX(wh_seq),0)+1 FROM han_warehouse),'outgoing','STO20200423121555','HD000101KR0002J','basic','99999', '조제(아교주)','200','500','djmediyou','outgoing','','','medibox','','','','','',SYSDATE,'Y',SYSDATE) "

						dbcommit($sql6);

						if($wh_table=="99999") ///191003.green 제환실로 출고일 경우
						{
							
							$gh_qty=$mb_oldcapacity + $wh_qty;
							$sql7=" insert into ".$dbH."_goodshouse (gh_seq,gh_odcode, gh_type, gh_code, gh_oldqty, gh_addqty, gh_qty, gh_workcode, gh_use, gh_date) values ";
							$sql7.=" ((SELECT NVL(MAX(gh_seq),0)+1 FROM ".$dbH."_goodshouse),'','incoming','".$wh_stock."','".$mb_oldcapacity."', '".$wh_qty."','".$gh_qty."','','Y',SYSDATE); ";
							//insert into han_goodshouse (gh_seq,gh_odcode, gh_type, gh_code, gh_oldqty, gh_addqty, gh_qty, gh_workcode, gh_use, gh_date) values  ((SELECT NVL(MAX(gh_seq),0)+1 FROM han_goodshouse),'','incoming','HD000101KR0002J','0', '200','200','','Y',SYSDATE);

							dbcommit($sql7);
						}
						$json["resultCode"]="200";
						$json["resultMessage"]="OK";


						$json["sql7"]=$sql7;
						$json["sql6"]=$sql6;
						$json["sql5"]=$sql5;
						$json["sql4"]=$sql4;
						$json["sql3"]=$sql3;
						$json["sql2"]=$sql2;
						$json["sql1"]=$sql1;
						$json["sql"]=$sql;
						

					}
					else
					{
						$json["resultCode"]="209";
						$json["resultMessage"]="1723"; ///약재가 부족합니다.
					}
				}
				else
				{
					$json["resultCode"]="209";
					$json["resultMessage"]="1708"; ///약재함이 존재하지 않거나 사용할수 없습니다.
				}
			}
			else
			{
				$json["resultCode"]="209";
				$json["resultMessage"]="1708"; ///약재함이 존재하지 않거나 사용할수 없습니다.
			}
		}
	}
?>