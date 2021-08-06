<?php
	//GET
	$apicode=$_GET["apiCode"];
	$language=$_GET["language"];
	$page=$_GET["page"];
	if($apicode!="forsclist"){$json["resultMessage"]="API(apiCode) ERROR";$apicode="forsclist";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="API(language) ERROR";}
	else{
		$returnData=$_GET["returnData"];
		$json=array("apiCode"=>$apicode,"returnData"=>$returnData);
		$searperiodtype=$_GET["searPeriodType"];
		$searchperiod=$_GET["searchPeriod"];
		$searchstatus=$_GET["searchStatus"];
		$searchtype=$_GET["searchType"];
		$searchtxt=$_GET["searchTxt"];
		$searchpop=$_GET["searchPop"];

		$jsql=" a ";
		$wsql=" where rb_use <>'D' ";

		if($searchpop){
			$arr=explode("|",$searchpop);
			foreach($arr as $val){
				$arr2=explode(",",$val);
				if($arr2[0]=="searchType"){
					$field="a.".substr($arr2[1],0,2)."_".strtolower(substr($arr2[1],2,20));
					if($arr2[1]!="rbCode"){
						$field=$field."_".$language." ";
					}
				}
				if($arr2[0]=="searchTxt"){
					$seardata=$arr2[1];
				}
			}

			if($seardata && $field)
				$wsql.=" and ".$field." like '%".$seardata."%' ";
		}

		$pg=apipaging("rb_code","recipebook",$jsql,$wsql);
		$sql=" select * from ".$dbH."_recipebook $jsql $wsql order by rb_date desc limit ".$pg["snum"].", ".$pg["psize"];
		$res=dbqry($sql);
		$json["sql"]=$sql;
		$json["page"]=$pg["page"];
		$json["tcnt"]=$pg["tcnt"];
		$json["tpage"]=$pg["tpage"];
		$json["psize"]=$pg["psize"];
		$json["block"]=$pg["block"];
		$json["list"]=array();
		while($dt=dbarr($res)){
			$addarray=array("seq"=>$dt["rb_seq"], "rbCode"=>$dt["rb_code"], "rbTitle"=>$dt["rb_title_".$language], "rbIndex"=>$dt["rb_index_".$language], "rbBookno"=>$dt["rb_bookno_".$language], "rbDesc"=>$dt["rb_desc_".$language], "rbDate"=>$dt["rb_date"]);
			array_push($json["list"], $addarray);
		}
		$json["resultCode"]="200";
		$json["resultMessage"]="OK";
	}
?>