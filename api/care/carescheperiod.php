<?php
	//GET
	$apicode=$_GET["apiCode"];
	$language=$_GET["language"];
	$uc_userid=$_GET["meUserid"];
	if($apicode!="carescheperiod"){$json["resultMessage"]="API코드오류";$apicode="carescheperiod";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="언어코드오류";}
	else if($uc_userid==""){$json["resultMessage"]="userid 없음";}
	else{
		$jsql=" a inner join ".$dbH."_order o on a.uc_odcode=o.od_code ";
		$wsql=" where a.uc_use <>'D' and a.uc_schedule is not null and a.uc_userid = '".$uc_userid."' ";
		$osql=" order by a.uc_date desc";
		$lsql=" limit 0, 1 ";
		$sql=" select a.uc_seq, a.uc_schedule, a.uc_start, a.uc_finish, o.od_title odTitle from ".$dbH."_usercare $jsql $wsql $osql $lsql";
		$dt=dbone($sql);
		$json=array("seq"=>$dt["uc_seq"],"odTitle"=>$dt["odTitle"],"ucPeriod"=>$dt["uc_start"]." ~ ".$dt["uc_finish"]);
		$json["sql"]=$sql;
		$uarr=explode("|",$dt["uc_schedule"]);
		$json["list"]=array();
		foreach($uarr as $val){
			$varr=explode(",",$val);
			if($varr[0]==date("Y-m-d")){
				$ctarr=explode("/",$varr[3]);
				$ccarr=explode("/",$varr[4]);
				$etarr=explode("/",$varr[5]);
				for($m=0;$m<count($ctarr);$m++){
					$addarray=array("careTime"=>$varr[1], "careHour"=>$ctarr[$m], "careChk"=>$ccarr[$m], "eatTime"=>$etarr[$m]);
					array_push($json["list"], $addarray);
				}

			}
		}
		$json["apiCode"]=$apicode;
		$json["returnData"]=$returnData;
		$json["resultCode"]="200";
		$json["resultMessage"]="OK";
	}
?>
