<?php
	//GET
	$apicode=$_GET["apiCode"];
	$language=$_GET["language"];
	$qc_code=$_GET["qcCode"];
	if($apicode!="recipedesc"){$json["resultMessage"]="API코드오류";$apicode="recipedesc";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="언어코드오류";}
	else if($qc_code==""){$json["resultMessage"]="Code 없음";}
	else{
		if($qc_code){
			$jsql=" a left join ".$dbH."_order c on a.rc_code=c.od_scription ";
			$jsql.=" inner join ".$dbH."_member m on c.od_userid=m.me_userid ";
			$jsql.=" left join ".$dbH."_release d on c.od_code=d.re_odcode ";

			$sql=" select a.rc_seq rcSeq, a.rc_code rcCode, a.rc_source rcSource, a.rc_title_".$language." rcTitle,  a.rc_detail_".$language." rcDetail, a.rc_medicine rcMedicine, a.rc_sweet rcSweet, a.rc_efficacy_".$language." rcEfficacy, a.rc_maincure_".$language." rcMaincure, a.rc_tingue_".$language." rcTingue, a.rc_pulse_".$language." rcPulse, a.rc_usage_".$language." rcUsage, a.rc_status rcStatus, a.rc_date rcDate, m.me_name meName, d.re_name `reName`, c.od_code odCode, c.od_chubcnt odChubcnt from ".$dbH."_recipeuser $jsql where d.re_quality='".$qc_code."'";
			$dt=dbone($sql);
		}

		$json=array("seq"=>$dt["rcSeq"], "rcCode"=>$dt["rcCode"], "odCode"=>$dt["odCode"], "rcTitle"=>$dt["rcTitle"], "rcDetail"=>$dt["rcDetail"], "rcMedicine"=>$dt["rcMedicine"], "rcSweet"=>$dt["rcSweet"], "rcEfficacy"=>$dt["rcEfficacy"], "rcMaincure"=>$dt["rcMaincure"], "rcTingue"=>$dt["rcTingue"], "rcPulse"=>$dt["rcPulse"], "rcUsage"=>$dt["rcUsage"], "rcStatus"=>$dt["rcStatus"], "rcDate"=>$dt["rcDate"], "meName"=>$dt["meName"], "reName"=>$dt["reName"], "odChubcnt"=>$dt["odChubcnt"]);

		$json["sql"]=$sql;
		$json["resultCode"]="200";
		$json["resultMessage"]="OK";
	}
?>
