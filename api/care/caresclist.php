<?php
	//GET
	$apiCode=$_GET["apiCode"];
	$language=$_GET["language"];
	$page=$_GET["page"];
	$uc_userid=$_GET["meUserid"];
	if($apiCode!="caresclist"){$json["resultMessage"]="API코드오류";$apiCode="caresclist";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="언어코드오류";}
	else if($uc_userid==""){$json["resultMessage"]="아이디없음";}
	else{
		$returnData=$_GET["returnData"];
		$json=array("apiCode"=>$apicode,"returnData"=>$returnData);
		$searchperiod=$_GET["searchPeriod"];

		$jsql=" a left join ".$dbH."_order c on a.uc_odcode=c.od_code ";
		$jsql.=" inner join ".$dbH."_member m on c.od_userid=m.me_userid ";
		$jsql.=" inner join ".$dbH."_recipeuser r on c.od_scription=r.rc_code ";
		$wsql=" where a.uc_use <>'D' and a.uc_userid = '".$uc_userid."' ";

		if($searchperiod){
			$arr=explode(",",$searchperiod);
			if(count($arr)>1 && $arr[0]!="" && $arr[1]!=""){
				$wsql.=" and a.uc_rcdate > '".$arr[0]."' and a.uc_rcdate < '".$arr[1]."' ";
			}
		}

		$pg=apipaging("a.uc_seq","usercare",$jsql,$wsql);
		$sql=" select a.uc_seq ucSeq, a.uc_rccode ucRccode, a.uc_odcode ucOdcode, c.od_title odTitle, c.od_packcnt odPackcnt, m.me_name meName, r.rc_date rcDate from ".$dbH."_usercare $jsql $wsql order by a.uc_rcdate desc limit ".$pg["snum"].", ".$pg["psize"];
		$res=dbqry($sql);
		$json["sql"]=$sql;
		$json["page"]=$pg["page"];
		$json["tcnt"]=$pg["tcnt"];
		$json["tpage"]=$pg["tpage"];
		$json["psize"]=$pg["psize"];
		$json["block"]=$pg["block"];
		$json["list"]=array();
		while($dt=dbarr($res)){
			$addarray=array("seq"=>$dt["ucSeq"], "rcCode"=>$dt["ucRccode"], "odCode"=>$dt["ucOdcode"], "odTitle"=>$dt["odTitle"], "odPackcnt"=>$dt["odPackcnt"], "meName"=>$dt["meName"], "rcDate"=>$dt["rcDate"]);
			array_push($json["list"], $addarray);
		}
		$json["resultCode"]="200";
		$json["resultMessage"]="OK";
	}
?>