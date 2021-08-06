<?php
	//GET
	$apicode=$_GET["apiCode"];
	$language=$_GET["language"];
	$uc_seq=$_GET["seq"];
	$today=$_GET["today"];
	$no=$_GET["today"];
	if($apicode!="carechkschedule"){$json["resultMessage"]="API코드오류";$apicode="carechkschedule";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="언어코드오류";}
	else if($uc_seq==""){$json["resultMessage"]="seq 없음";}
	else if($today==""){$json["resultMessage"]="today 없음";}
	else if($no==""){$json["resultMessage"]="no 없음";}
	else{
		$uc_seq=$_GET["seq"];
		$today=$_GET["today"];
		$jsql=" a inner join ".$dbH."_order c on a.uc_odcode=c.od_code ";
		$jsql.=" inner join ".$dbH."_member m on c.od_userid=m.me_userid ";
		$jsql.=" inner join ".$dbH."_recipeuser r on c.od_scription=r.rc_code ";
		$wsql=" where a.uc_use <>'D' and a.uc_seq = '".$uc_seq."' ";
		$sql=" select a.uc_seq ucSeq, a.uc_schedule, c.od_title odTitle, c.od_packcnt odPackcnt, c.od_chubcnt odChubcnt, c.od_staff odStaff, c.od_care odCare, m.me_name meName from ".$dbH."_usercare $jsql $wsql ";
		$dt=dbone($sql);
		$json["sql"]=$sql;
		$arr=explode("|",$dt["uc_schedule"]);
		$sday=explode(",",$arr[1]);
		$eday=explode(",",$arr[count($arr)-1]);
		$ucSchedule=viewdate($sday[0])." ~ ".viewdate($eday[0]);
		$json=array("seq"=>$dt["ucSeq"], "odCode"=>$dt["odCode"], "odTitle"=>$dt["odTitle"], "odPackcnt"=>$dt["odPackcnt"], "odChubcnt"=>$dt["odChubcnt"], "odStaff"=>$dt["odStaff"], "odCare"=>$odCare, "meName"=>$dt["meName"], "rcDate"=>$dt["rcDate"], "ucSchedule"=>$ucSchedule);
		$json["apiCode"]=$apicode;
		$json["returnData"]=$returnData;
		$json["resultCode"]="200";
		$json["resultMessage"]="OK";
	}
?>
