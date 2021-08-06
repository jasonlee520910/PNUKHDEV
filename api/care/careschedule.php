<?php
	//GET
	$apicode=$_GET["apiCode"];
	$language=$_GET["language"];
	$meUserid=$_GET["meUserid"];
	if($apicode!="careschedule"){$json["resultMessage"]="API코드오류";$apicode="careschedule";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="언어코드오류";}
	else if($meUserid==""){$json["resultMessage"]="userid 없음";}
	else{
		$uc_seq=$_GET["seq"];
		$today=$_GET["today"];
		if($today==""){
			$sday=date("Y-m-01");
			$eday=date("Y-m-31");
		}else{
			$sday=substr($today,0,7)."-01";
			$eday=substr($today,0,7)."-31";
		}
		$jsql=" a ";
		$wsql=" where a.uc_use <>'D' and a.uc_schedule <>'' and a.uc_userid ='".$meUserid."' ";
		if($uc_seq){
			$wsql.=" and a.uc_seq = '".$uc_seq."' ";
		}else{
			$wsql.=" order by uc_seq desc limit 0, 1 ";
		}
		$sql=" select a.uc_seq, a.uc_schedule from ".$dbH."_usercare $jsql $wsql ";
		$dt=dbone($sql);
		$uarr=explode("|",$dt["uc_schedule"]);
		$json["seq"]=$dt["uc_seq"];
		$json["list"]=array();
		foreach($uarr as $val){
			$varr=explode(",",$val);
			if($varr[0]>=$sday && $varr[0]<=$eday){
				$addarray=array("day"=>$varr[0], "care"=>array("cnt"=>$varr[2],"time"=>$varr[3],"chk"=>$varr[4]));
				array_push($json["list"], $addarray);
			}
		}
		//$json["schedule"]=$dt["uc_schedule"];
		$json["sql"]=$sql;
		$json["apiCode"]=$apicode;
		$json["returnData"]=$returnData;
		$json["resultCode"]="200";
		$json["resultMessage"]="OK";
	}
?>
