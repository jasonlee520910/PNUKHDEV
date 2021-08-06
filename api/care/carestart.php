<?php
	//GET
	$apicode=$_GET["apiCode"];
	$language=$_GET["language"];
	$uc_seq=$_GET["seq"];
	if($apicode!="carestart"){$json["resultMessage"]="API코드오류";$apicode="carestart";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="언어코드오류";}
	else if($uc_seq==""){$json["resultMessage"]="seq 없음";}
	else{
		if($uc_seq){
			$jsql=" a left join ".$dbH."_order c on a.uc_odcode=c.od_code ";
			$wsql=" where a.uc_use <>'D' and a.uc_seq = '".$uc_seq."' ";

			$sql=" select a.uc_seq ucSeq, c.od_packcnt odPackcnt, c.od_care odCare from ".$dbH."_usercare $jsql $wsql ";
			$dt=dbone($sql);
			$oarr=explode("_",$dt["odCare"]);
			$timeforday=$oarr[0];
			if(!$timeforday)$timeforday="care02";
			$cntforday=$oarr[1];
			if(!$cntforday)$cntforday=2;
			$odCareday= intval($dt["odPackcnt"] / $cntforday);
			$sday=explode("-",date("Y-m-d"));
			$careDate="";
			for($i=0;$i<$odCareday;$i++){
				$careDate.="|".date("Y-m-d",mktime(0,0,0,$sday[1],$sday[2] + $i,$sday[0]));
				switch($timeforday){
					case "care01": $caretime="before";break;
					case "care02": $caretime="after";break;
				}
				$careDate.=",".$caretime;
				$careDate.=",".$cntforday;
				switch($cntforday){
					case 2: $carehour="08:00/18:00";break;
					case 3: $carehour="08:00/12:00/18:00";break;
					case 4: $carehour="08:00/12:00/18:00/22:00";break;
					default: $carehour="12:00";
				}
				$careDate.=",".$carehour;
				$careDate.=",";
				for($m=0;$m<$cntforday;$m++){
					$careDate.="N";
				}
				$careDate.=",";
				for($m=0;$m<$cntforday;$m++){
					if($m>0)$careDate.="/";
					$careDate.="00:00";
				}
			}
			$sql2=" update ".$dbH."_usercare set uc_schedule='".$careDate."' where uc_seq='".$dt["ucSeq"]."' ";
			dbqry($sql2);

			$json=array("seq"=>$dt["ucSeq"]);
			$json["sql"]=$sql.$sql2;
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
