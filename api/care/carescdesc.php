<?php
	//GET
	$apicode=$_GET["apiCode"];
	$language=$_GET["language"];
	$uc_seq=$_GET["seq"];
	if($apicode!="carescdesc"){$json["resultMessage"]="API코드오류";$apicode="carescdesc";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="언어코드오류";}
	else if($uc_seq==""){$json["resultMessage"]="seq 없음";}
	else{
		if($uc_seq){
			$jsql=" a left join ".$dbH."_order c on a.uc_odcode=c.od_code ";
			$jsql.=" inner join ".$dbH."_member m on c.od_userid=m.me_userid ";
			$jsql.=" inner join ".$dbH."_recipeuser r on c.od_scription=r.rc_code ";
			$wsql=" where a.uc_use <>'D' and a.uc_seq = '".$uc_seq."' ";

			$sql=" select a.uc_seq ucSeq, a.uc_rccode rcCode, if(length(uc_schedule) > 1,'Y','N') ucSchedule, c.od_code odCode, c.od_title odTitle, c.od_packcnt odPackcnt, c.od_chubcnt odChubcnt, c.od_staff odStaff, c.od_care odCare, m.me_name meName, r.rc_medicine rcMedicine, r.rc_sweet rcSweet, r.rc_date rcDate from ".$dbH."_usercare $jsql $wsql ";
			$dt=dbone($sql);
			$oarr=explode("_",$dt["odCare"]);
			$cntforday=$oarr[1];
			if(!$cntforday)$cntforday=2;
			$odCare= intval($dt["odPackcnt"] / $cntforday);
			if($odCare<30){$odCare=intval($odCare)."일";}else{$odCare=round(($odCare/30),1)."개월";}
			$json=array("seq"=>$dt["ucSeq"], "rcCode"=>$dt["rcCode"], "ucSchedule"=>$dt["ucSchedule"], "odCode"=>$dt["odCode"], "odTitle"=>$dt["odTitle"], "odPackcnt"=>$dt["odPackcnt"], "odChubcnt"=>$dt["odChubcnt"], "odStaff"=>$dt["odStaff"], "odCare"=>$odCare, "meName"=>$dt["meName"], "rcMedicine"=>$dt["rcMedicine"], "rcSweet"=>$dt["rcSweet"], "rcDate"=>$dt["rcDate"]);
			$json["apiCode"]=$apicode;
			$json["returnData"]=$returnData;
			$json["resultCode"]="200";
			$json["resultMessage"]="OK";
		}else{
			$json["resultCode"]="204";
			$json["resultMessage"]="처방정보가 없습니다";
		}
	}
?>
