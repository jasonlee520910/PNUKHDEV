<?php
	
	$apiCode=$_GET["apiCode"];
	$language=$_GET["language"];


	if($apiCode!="dashboard"){$json["resultMessage"]="API(apiCode) ERROR";$apiCode="dashboard";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="API(language) ERROR";}
	else{
		$notsql=" and od_status <> 'preorder' ";
		$dashtype=$_GET["dashType"];
		if($dashtype=="today"){
			$today=" and to_char(od_date, 'yyyy-mm-dd') = '".date("Y-m-d")."' ";  //
			$todaytxt=date("Y-m-d");
		}else{
			$today=" and to_char(od_date, 'yyyy-mm-dd') >= '".date("Y-m-d", strtotime("-1 week"))."' and to_char(od_date, 'yyyy-mm-dd') <= '".date("Y-m-d")."' ";  //일주일전부터 현재까지 조회
			$todaytxt=date("Y-m-d", strtotime("-1 week"))." ~ ".date("Y-m-d");
		}

		$etime=date("Y-m-d");  
		$stime=date("Y-m-d ", strtotime("-1 week"));

		//작업현황 상단은 일주일 기간만 조회, 하단 그래프 4개는 전체기간으로 검색

		$sql="select ";
		//총주문
		$sql.="(select count(od_seq) from ".$dbH."_order where od_use in ('Y','C') ".$notsql.$today." ) tcnt ";
		//입금전
		$sql.=",(select count(od_seq) from ".$dbH."_order where od_use='Y' and od_status='order' ".$notsql.$today." ) pcnt ";
		//완료
		$sql.=",(select count(od_seq) from ".$dbH."_order where od_use='Y' and od_status='done' ".$notsql.$today." ) dcnt ";
		//작업대기
		$sql.=",(select count(od_seq) from ".$dbH."_order where od_use='Y' and (od_status='paid') ".$notsql.$today." ) wcnt ";
		//취소
		$sql.=",(select count(od_seq) from ".$dbH."_order where od_use='Y' and substr(od_status,7)='_cancel' ".$notsql.$today." ) ccnt ";
		
		//금일조제완료
		$sql.=",(select count(ma_odcode) from ".$dbH."_making where ma_use='Y' and ma_status='making_done' and to_char(ma_modify,'yyyy-mm-dd') = '".date("Y-m-d")."' ) matcnt ";
		//금일탕전완료
		$sql.=",(select count(dc_odcode) from ".$dbH."_decoction where dc_use='Y' and dc_status='decoction_done' and to_char(dc_modify,'yyyy-mm-dd') = '".date("Y-m-d")."' ) dctcnt ";
		//금일마킹완료
		$sql.=",(select count(mr_odcode) from ".$dbH."_marking where mr_use='Y' and mr_status='marking_done' and to_char(mr_modify,'yyyy-mm-dd') = '".date("Y-m-d")."' ) mrtcnt ";
		//금일포장완료
		$sql.=",(select count(re_odcode) from ".$dbH."_release where re_use='Y' and re_status='release_done' and to_char(re_modify,'yyyy-mm-dd') = '".date("Y-m-d")."' ) retcnt ";

		//조제 
		$sql.=",(select count(od_seq) from ".$dbH."_order where od_use='Y' and od_status='making_apply' ".$notsql.") ma_apply ";
		$sql.=",(select count(od_seq) from ".$dbH."_order where od_use='Y' and od_status in ('making_start','making_processing')  ".$notsql.") ma_processing ";

		$sql.=",(select count(a.od_seq) from ".$dbH."_order a inner join ".$dbH."_making b on b.ma_odcode=a.od_code where a.od_use='Y' and b.ma_status='making_stop' ".$notsql." ) ma_stop ";
		
		//탕전
		$sql.=",(select count(od_seq) from ".$dbH."_order where od_use='Y' and od_status='decoction_apply' ".$notsql.") de_apply ";
		$sql.=",(select count(od_seq) from ".$dbH."_order where od_use='Y' and od_status in ('decoction_start','decoction_processing')  ".$notsql.") de_processing ";

		$sql.=",(select count(a.od_seq) from ".$dbH."_order a inner join ".$dbH."_decoction b on b.dc_odcode=a.od_code where a.od_use='Y' and b.dc_status='decoction_stop' ".$notsql." ) de_stop ";

		
		//마킹
		$sql.=",(select count(od_seq) from ".$dbH."_order where od_use='Y' and od_status='marking_apply' ".$notsql.") mr_apply ";
		$sql.=",(select count(od_seq) from ".$dbH."_order where od_use='Y' and od_status in ('marking_start','marking_processing')  ".$notsql.") mr_processing ";

		$sql.=",(select count(a.od_seq) from ".$dbH."_order a inner join ".$dbH."_marking b on b.mr_odcode=a.od_code where a.od_use='Y' and b.mr_status='marking_stop' ".$notsql." ) mr_stop ";

		//배송
		$sql.=",(select count(od_seq) from ".$dbH."_order where od_use='Y' and od_status='release_apply' ".$notsql.") re_apply ";
		$sql.=",(select count(od_seq) from ".$dbH."_order where od_use='Y' and od_status in ('release_start','release_processing')  ".$notsql.") re_processing ";

		$sql.=",(select count(a.od_seq) from ".$dbH."_order a inner join ".$dbH."_release b on b.re_odcode=a.od_code where a.od_use='Y' and b.re_status='release_stop' ".$notsql." ) re_stop ";
		$sql.=" from dual  ";


		$dt=dbone($sql);
		$json["sql"]=$sql;
		$json["today"]=date('Y-m-d')." ".${"weeks_".$language}[date('w')];
		$json["todaytxt"]=$todaytxt;
		$json["order"]=$dt["TCNT"];
		$json["prepaid"]=$dt["PCNT"];
		$json["done"]=$dt["DCNT"];
		$json["process"]=$dt["RCNT"];
		$json["wait"]=$dt["WCNT"];
		$json["stop"]=$dt["SCNT"];
		$json["cancel"]=$dt["CCNT"];

		$json["dashType"]=$dashtype;

		$json["time"]=$today;   ////일주일전부터 현재까지 
		$json["stime"]=$stime;
		$json["etime"]=$etime;

		$json["maDoneTotal"]=$dt["MATCNT"];
		$json["dcDoneTotal"]=$dt["DCTCNT"];
		$json["mrDoneTotal"]=$dt["MRTCNT"];
		$json["reDoneTotal"]=$dt["RETCNT"];

		$processcnt=0;
		//조제
		$json["ma_apply"]=$dt["MA_APPLY"];
		$json["ma_processing"]=$dt["MA_PROCESSING"];
		$json["ma_stop"]=$dt["MA_STOP"];

		$processcnt+=$json["ma_apply"] + $json["ma_processing"] + $json["ma_stop"];

		//탕전
		$json["de_apply"]=$dt["DE_APPLY"];
		$json["de_processing"]=$dt["DE_PROCESSING"];
		$json["de_stop"]=$dt["DE_STOP"];
		$processcnt+=$json["de_apply"] + $json["de_processing"] + $json["de_stop"];

		//마킹
		$json["mr_apply"]=$dt["MR_APPLY"];
		$json["mr_processing"]=$dt["MR_PROCESSING"];
		$json["mr_stop"]=$dt["MR_STOP"];
		$processcnt+=$json["mr_apply"] + $json["mr_processing"] + $json["mr_stop"];

		//배송
		$json["re_apply"]=$dt["RE_APPLY"];
		$json["re_processing"]=$dt["RE_PROCESSING"];
		$json["re_stop"]=$dt["RE_STOP"];
		$processcnt+=$json["re_apply"] + $json["re_processing"] + $json["re_stop"];
		$json["proccessing"]=$processcnt;

		$sql = " select a.bo_code, a.bo_locate, a.bo_status, (select cd_name_".$language." from ".$dbH."_code where cd_type='boStatus' and cd_code=a.bo_status) as statTxt from ".$dbH."_boiler a where bo_use='Y' order by bo_locate ";
		$res=dbqry($sql);
		$json["boiler"]=array();
		$boIng=$boReady=$boRepair=$boStandby=0;
		for($i=0;$dt=dbarr($res);$i++){
			if($dt["BO_STATUS"]=="ing"){$boIng++;}
			if($dt["BO_STATUS"]=="ready"){$boReady++;}
			if($dt["BO_STATUS"]=="repair"){$boRepair++;}
			if($dt["BO_STATUS"]=="standby"){$boStandby++;}
			//$statTxt=potstat($dt["bo_status"]);
			$addarray=array("boCode"=>$dt["BO_CODE"], "boLocate"=>$dt["BO_LOCATE"], "boStatus"=>$dt["BO_STATUS"], "boStattxt"=>$dt["STATTXT"]);
			array_push($json["boiler"], $addarray);
		}
		$json["boTcnt"]=$i;
		$json["boIng"]=intval($boIng);
		$json["boReady"]=$boReady;
		$json["boStandby"]=$boStandby;
		$json["boRepair"]=$boRepair;

	}
	$json["apiCode"]=$apiCode;
	$json["resultCode"]="200";
	$json["resultMessage"]="OK";
?>