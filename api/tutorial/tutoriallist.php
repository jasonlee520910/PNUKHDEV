<?php
	$apicode=$_GET["apiCode"];
	$language=$_GET["language"];
	$page=$_GET["page"];
	if($apicode!="tutoriallist"){$json["resultMessage"]="API코드오류";$apiCode="tutoriallist";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="언어코드오류";}
	else{
		$seq=$_GET["seq"];
		$returnData=$_GET["returnData"];
		$json=array("apiCode"=>$apicode,"returnData"=>$returnData);
		$searperiodtype=$_GET["searPeriodType"];
		$searchperiod=$_GET["searchPeriod"];
		//$searchstatus=$_GET["searchStatus"];
		$searchtype=$_GET["searchType"];
		$searchtxt=$_GET["searchTxt"];

		$jsql=" a left join ".$dbH."_file f on a.tu_seq=f.af_afseq and f.af_code='tutorial' and f.af_use = 'Y' ";
		$wsql="  where a.tu_use = 'Y' ";

		$ssql=" a.*, f.af_url ";
		$ssql.=", (select tu_seq from ".$dbH."_tutorial where tu_use='Y' order by tu_no asc limit 0, 1) tuNo ";
		$ssql.=", (select count(tu_seq) from ".$dbH."_tutorial where tu_use='Y') total ";
		$sql=" select $ssql from ".$dbH."_tutorial $jsql $wsql order by a.tu_no asc ";
//echo $sql;
		$res=dbqry($sql);
		//var_dump($pg); 
		$json["list"]=array();
		$topSeq="";
		while($dt=dbarr($res)){
			$tuNo=$dt["tuNo"];
			if($dt["tu_seq"]==$seq){
				$topNo=$dt["tu_no"];
				$topSeq=$seq;
			}
			$total=$dt["total"];
			$files=array("seq"=>$dt["af_seq"],"src"=>$dtdom.$dt["af_url"]);
			$addarray=array("seq"=>$dt["tu_seq"], "tuNo"=>$dt["tu_no"], "afFile"=>$files, "tuDate"=>$dt["tu_date"]);
			array_push($json["list"], $addarray);
		}
		if(!$topNo){$topNo=$tuNo;}
		$json["topNo"]=$topNo;
		$json["topSeq"]=$topSeq;
		$json["total"]=$total;
		$json["sql"]=$sql;
		$json["resultCode"]="200";
		$json["resultMessage"]="OK";
	}
?>