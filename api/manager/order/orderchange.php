<?php
	//// 주문현황>주문리스트>작업지시서출력>작업지시 
	$apicode=$_GET["apiCode"];
	$language=$_GET["language"];
	$od_seq=$_GET["seq"];
	$process=$_GET["process"];
	$status=$_GET["status"];
	///취소사유선택과 입력 
	$canceltype=$_GET["canceltype"];
	$cancelText=$_GET["cancelText"];

	$goods=$_GET["goods"];
	$wcMarking=$_GET["wcMarking"];
	$outermakingchk=$_GET["outermakingchk"];
	
	

	if($apicode!="orderchange"){$json["resultMessage"]="API(apiCode) ERROR";$apicode="orderchange";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="API(language) ERROR";}
	else if($od_seq==""){$json["resultMessage"]="API(seq) ERROR";}
	else if($process==""){$json["resultMessage"]="API(process) ERROR";}
	else if($status==""){$json["resultMessage"]="API(status) ERROR";}
	else{		
		$sql=" select ";
		$sql.=" a.od_code, a.od_matype , a.od_goods, a.OD_SITECATEGORY, b.productCode, c.RC_PILLORDER ";
		$sql.=" from ".$dbH."_order ";
		$sql.=" a left join ".$dbH."_order_client b on b.keycode=a.od_keycode ";
		$sql.=" inner join ".$dbH."_recipeuser c on c.rc_code=a.od_scription ";
		$sql.=" where a.od_seq='".$od_seq."' ";
		$dt=dbone($sql);

		///20200302:[기획] 옥병풍산 + 곽향정기산 각45팩 상품을 예외처리 하기 위함 
		$od_matype=$dt["OD_MATYPE"];
		$od_sitecategory=$dt["OD_SITECATEGORY"];

		$rc_pillorder=getClob($dt["RC_PILLORDER"]);
		if($goods=="goods")///gd_cypk 알아오기 
		{
			$productCode=$dt["PRODUCTCODE"];			
			$od_goods=$dt["OD_GOODS"];
			if(chkGoodsTie($productCode, $od_matype, $od_goods)==true)///code가 427이거나 type이 goodsetc 일 경우에 마킹으로 가기 
			{
				$wcMarking="marking";
				$status="marking_apply";
			}
		}

		if($od_matype=="pill"&&$rc_pillorder)
		{
			//rc_pillorder
			$gdPillorder=json_decode($rc_pillorder, true);
			$gdPilllist=$gdPillorder["pilllist"];
			$pl_machinestat="";

			$i=0;
			foreach($gdPilllist as $key => $val)
			{
				$plkey=$gdPilllist[$key]["key"];
				$plorder=$gdPilllist[$key]["order"];
				$ptype=$plorder["type"];
				if($i==0)//제일첫번째것으로 apply하자 
				{
					$pl_machinestat=$ptype."_apply";
					break;
				}
				$i++;
			}
		}

		/*if($od_sitecategory=="PNUH")//EMR에서 넘어온 데이터라면 
		{
			$status="decoction_apply";
		}*/

		if($outermakingchk=="Y")
		{
			$status="decoction_apply";
		}

		if($process=="order"){
			if($status == "cancel")
			{
				$sql=" update ".$dbH."_order set od_status='".$status."',od_modify=sysdate, od_canceltype='".$canceltype."', od_canceltext='".$cancelText."'  where od_code='".$dt["OD_CODE"]."' ";
			}
			else
			{
				$sql=" update ".$dbH."_order set od_status='".$status."',od_modify=sysdate where od_code='".$dt["OD_CODE"]."' ";
			}
			dbcommit($sql);

			if($wcMarking=="marking")
			{
				$sql=" update ".$dbH."_making set ma_status='making_done' where ma_odcode='".$dt["OD_CODE"]."' ";
				dbcommit($sql);
				$sql=" update ".$dbH."_decoction set dc_status='decoction_done' where dc_odcode='".$dt["OD_CODE"]."' ";
				dbcommit($sql);
			}
			else
			{
				$sql=" update ".$dbH."_making set ma_status='".$status."' where ma_odcode='".$dt["OD_CODE"]."' ";
				dbcommit($sql);
				$sql=" update ".$dbH."_decoction set dc_status='".$status."' where dc_odcode='".$dt["OD_CODE"]."' ";
				dbcommit($sql);
			}

			$sql=" update ".$dbH."_marking set mr_status='".$status."' where mr_odcode='".$dt["OD_CODE"]."' ";
			dbcommit($sql);
			$sql=" update ".$dbH."_release set re_status='".$status."' where re_odcode='".$dt["OD_CODE"]."' ";
			dbcommit($sql);

			if($goods=="goods")
			{
				$sql=" update ".$dbH."_package set gp_status='".$status."' where gp_odcode='".$dt["OD_CODE"]."' ";
				dbcommit($sql);
			}

			if($od_matype=="pill")
			{
				$sql=" update ".$dbH."_pill set PL_STATUS='".$status."',PL_MACHINESTAT='".$pl_machinestat."' where PL_ODCODE='".$dt["OD_CODE"]."' ";
				dbcommit($sql);
			}

			if($od_sitecategory=="PNUH")//EMR에서 넘어온 데이터라면 
			{
				$sql=" update ".$dbH."_making set MA_MEDIBOX_INMAIN='MDT0000000000' where ma_odcode='".$dt["OD_CODE"]."' ";
				dbcommit($sql);
			}

		}else if($process=="done"){
			$sql=" update ".$dbH."_order set od_status='".$status."',od_modify=sysdate, od_canceltype='".$canceltype."', od_canceltext='".$cancelText."'  where od_code='".$dt["OD_CODE"]."' ";
			dbcommit($sql);

			$jsonsql=$sql;

			/*
			20200402:팀장님과 확인결과 완료된것을 취소할때 관련된 작업인데 일단은 주석하자
			///출고정보등록
			$sql=" insert into ".$dbH."_release_log (re_odcode, re_keycode, re_userid, re_barcode, re_sendtype, re_sendname, re_sendphone, re_sendmobile, re_sendzipcode, re_sendaddress, re_name, re_phone, re_delitype, re_mobile, re_zipcode, re_address, re_delidate, re_request, re_boxmedi, re_boxdeli, re_boxmediprice, re_boxmedibox, re_boxdeliprice, re_price, re_box, re_staffid, re_status, re_use, re_date, re_modify) ";
			$sql.=" SELECT re_odcode, re_keycode, re_userid, re_barcode, re_sendtype, re_sendname, re_sendphone, re_sendmobile, re_sendzipcode, re_sendaddress, re_name, re_phone, re_delitype, re_mobile, re_zipcode, re_address, re_delidate, re_request, re_boxmedi, re_boxdeli, re_boxmediprice, re_boxmedibox, re_boxdeliprice, re_price, re_box, re_staffid, re_status, re_use, re_date, sysdate ";
			$sql.=" from ".$dbH."_release ";
			$sql.=" WHERE re_odcode ='".$dt["OD_CODE"]."' ";
			dbcommit($sql);
			$jsonsql.=$sql;
			*/

			$sql=" update ".$dbH."_release set re_staffid=NULL, re_status='".$status."', re_modify=sysdate where re_odcode='".$dt["OD_CODE"]."' ";
			dbcommit($sql);
			$jsonsql.=$sql;

		}else{
			if($status == "cancel")
			{
				$sql=" update ".$dbH."_order set od_status='".$process."_".$status."',od_modify=sysdate, od_canceltype='".$canceltype."', od_canceltext='".$cancelText."' where od_code='".$dt["OD_CODE"]."' ";
			}
			else
			{
				$sql=" update ".$dbH."_order set od_status='".$process."_".$status."',od_modify=sysdate where od_code='".$dt["OD_CODE"]."' ";
			}
			
			dbcommit($sql);
			if($process=="making"){
				$sql=" update ".$dbH."_making set ma_status='".$process."_".$status."' where ma_odcode='".$dt["OD_CODE"]."' ";
				dbcommit($sql);
			}
			if($process=="making"||$process=="decoction"){
				$sql=" update ".$dbH."_decoction set dc_status='".$process."_".$status."' where dc_odcode='".$dt["OD_CODE"]."' ";
				dbcommit($sql);
			}
			if($process=="making"||$process=="decoction"||$process=="marking"){
				$sql=" update ".$dbH."_marking set mr_status='".$process."_".$status."' where mr_odcode='".$dt["OD_CODE"]."' ";
				dbcommit($sql);
			}
			if($process=="making"||$process=="decoction"||$process=="marking"||$process=="release"){
				$sql=" update ".$dbH."_release set re_status='".$process."_".$status."' where re_odcode='".$dt["OD_CODE"]."' ";
				dbcommit($sql);
			}

			if($od_matype=="pill")
			{
				if($process=="making"||$process=="decoction"||$process=="marking"||$process=="release"||$process=="pill"){
					$sql=" update ".$dbH."_pill set PL_STATUS='".$process."_".$status."',PL_MACHINESTAT='".$pl_machinestat."' where PL_ODCODE='".$dt["OD_CODE"]."' ";
					
					dbcommit($sql);
				}
			}

			if($od_sitecategory=="PNUH")//EMR에서 넘어온 데이터라면 
			{
				$sql=" update ".$dbH."_making set MA_MEDIBOX_INMAIN='MDT0000000000' where ma_odcode='".$dt["OD_CODE"]."' ";
				dbcommit($sql);
			}
		}

		$returnData=$_GET["returnData"];
		$statustxt=$_GET["statustxt"];		
		$json=array("apiCode"=>$apicode,"returnData"=>$returnData,"statustxt"=>$statustxt,"process"=>$process,"odCode"=>$dt["OD_CODE"]);
		$json["plMachinestat"]=$pl_machinestat;
		$json["sql"]=$sql;
		$json["odMatype"]=$od_matype;
		$json["jsonsql"]=$jsonsql;
		$json["resultCode"]="200";
		$json["resultMessage"]="OK";
	}
?>
