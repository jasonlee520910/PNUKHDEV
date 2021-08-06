<?php
	$apiCode=$_GET["apiCode"];
	$language=$_GET["language"];

	$code=$_GET["code"];
	$maTable=$_GET["maTable"];

	if($apiCode!="makingmain"){$json["resultMessage"]="API(apiCode) ERROR";$apiCode="makingmain";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="API(language) ERROR";}
	else if($maTable==""){$json["resultMessage"]="API(maTable) ERROR";}
	else
	{
		$sql="  select a.ma_tablestat, a.ma_medibox_infirst, a.ma_medibox_inmain, a.ma_medibox_inafter, a.ma_medibox_inlast, a.ma_medicine, a.MA_SCALEMODE 
				, b.od_code, b.od_scription, b.od_chubcnt, b.od_request as odRequest
				, c.mt_code, mt_title 
				from ".$dbH."_making a 
				inner join ".$dbH."_order b on a.ma_odcode=b.od_code 
				inner join ".$dbH."_makingtable c on a.ma_table=c.mt_code 
				where ma_barcode='".$code."' ";

		$dt=dbone($sql);


		$medi=getmedilist_process($dt["OD_SCRIPTION"], $maTable, $dt["OD_CHUBCNT"]);
		$decolist=getDecoCodeTitle("all");


		$ma_medibox=$dt["MA_MEDICINE"];
		$mb_medicine="";
		if($ma_medibox)
		{
			$msql=" select mb_medicine from ".$dbH."_medibox where mb_code='".$ma_medibox."' ";
			$mdt=dbone($msql);
			$mb_medicine=$mdt["MB_MEDICINE"];
		}

		$json=array(
				"medibox_infirst"=>$dt["MA_MEDIBOX_INFIRST"],//부직포바코드 
				"medibox_inmain"=>$dt["MA_MEDIBOX_INMAIN"],
				"medibox_inafter"=>$dt["MA_MEDIBOX_INAFTER"],
				"medibox_inlast"=>$dt["MA_MEDIBOX_INLAST"],
				"maScalemode"=>$dt["MA_SCALEMODE"],
				"ma_medibox"=>$ma_medibox,//현재시점에 한 약재함 
				"mb_medicine"=>$mb_medicine,

				"od_request"=>getClob($dt["ODREQUEST"]),
				"od_chubcnt"=>$dt["OD_CHUBCNT"],
				"mt_code"=>$dt["MT_CODE"],
				"mt_title"=>$dt["MT_TITLE"],
				"od_scription"=>$dt["OD_SCRIPTION"]
				);

		$json["decolist"]=$decolist;
		$json["medi"]=$medi;
		$json["sql"]=$sql;
		$json["msql"]=$msql;
		
		

		$json["apiCode"] = $apiCode;

		if($medi["mediboxnone"]=="")
		{
			if($medi["medishortage"]=="")
			{
				//processing으로 업데이트 
				//정상일때에는 ma_table=조제대번호와 ma_tablestat은 null 로 바꿔야함 
				$sql=" update ".$dbH."_making set ma_status='making_processing', ma_modify=sysdate where ma_barcode='".$code."' and  ma_table='".$maTable."' ";
				dbcommit($sql);
				$sql=" update ".$dbH."_order set od_status='making_processing', od_modify=sysdate where od_code='".$dt["od_code"]."' ";
				dbcommit($sql);

				$json["sql2"]=$sql;
				$json["resultCode"]="200";
				$json["resultMessage"]="OK";
			}
			else
			{
				//창고재고와 약재함재고보다 적을시 약재상태를 약재부족이라고 바꾼다.
				if($medi["shortagecode"]!="")
				{
					$shortagecode=substr($medi["shortagecode"], 1);
					$shortagecode=str_replace(",","','",$shortagecode);
					$sql=" update ".$dbH."_medicine set md_status='shortage', md_modify=sysdate where md_code in ('".$shortagecode."') ";
					dbcommit($sql);
					//약재부족할때에는 ma_table과 ma_tablestat 은 둘다 null로 바꿔줘야 함. 
					//20190822 : ma_staffid도 null 
					//20191113:ma_pharmacist=null,
					$sql=" update ".$dbH."_making set ma_table=null, ma_tablestat = null, ma_staffid=null, ma_pharmacist=null, ma_status='making_apply', ma_modify=sysdate where ma_barcode='".$code."' ";
					dbcommit($sql);
					$json["sql2"]=$sql;
					$sql=" update ".$dbH."_order set od_status='making_apply', od_modify=sysdate where od_code='".$dt["od_code"]."' ";
					dbcommit($sql);
					$json["sql3"]=$sql;
				}
				
				$json["resultCode"]="999";
				$json["resultMessage"]="MEDISHORTAGE";//약재가 부족합니다.
			}

			//최종적으로 업데이트한 stat으로 가져오기 위함 
			$tsql=" select ma_tablestat from ".$dbH."_making where ma_barcode='".$code."'";
			$tdt=dbone($tsql);
			$json["maTablestat"]=$tdt["MA_TABLESTAT"];
		}
		else
		{
			$json["resultCode"]="999";
			$json["resultMessage"]="MEDIBOXNONE";//약재함이 존재하지 않거나 사용할수 없습니다.
		}

	}

?>