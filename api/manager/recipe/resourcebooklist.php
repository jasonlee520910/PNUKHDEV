<?php  
	///처방관리 > 처방서적 > 처방서적 리스트
	$apiCode=$_GET["apiCode"];
	$language=$_GET["language"];
	$page=$_GET["page"];
	if($apiCode!="resourcebooklist"){$json["resultMessage"]="API(apiCode) ERROR";$apiCode="resourcebooklist";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="API(language) ERROR";}
	else
	{
		$returnData=$_GET["returnData"];
		$json=array("apiCode"=>$apiCode,"returnData"=>$returnData);
		$searperiodtype=$_GET["searPeriodType"];
		$searchperiod=$_GET["searchPeriod"];
		$searchstatus=$_GET["searchStatus"];
		$searchtype=$_GET["searchType"];
		$searchtxt=$_GET["searchTxt"];  ///검색단어
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
			$wsql.=" and ".$field." like '%".$seardata."%' ";
		}

		if($searchtxt)  ///검색단어가 있을때
		{
			$wsql.=" and ( ";
			$wsql.=" a.rb_title_".$language." like '%".$searchtxt."%' ";///방제집명
			$wsql.=" or ";
			$wsql.=" a.rb_desc_".$language." like '%".$searchtxt."%' "; ///책설명
			$wsql.=" ) ";
		}

		$pg=apipaging("rb_seq","recipebook",$jsql,$wsql);

		$sql=" select * from (";
		$sql.=" select ROW_NUMBER() OVER (ORDER BY a.rb_date desc) NUM ";
		$sql.=" ,a.rb_seq,a.rb_title_kor ,to_char(a.rb_desc_kor) as RB_DESC_KOR ,a.rb_index ,a.rb_bookno ";
		$sql.=" from ".$dbH."_recipebook $jsql $wsql order by a.rb_date desc ";
		$sql.=" ) where NUM>".$pg["snum"]." and NUM<=".$pg["tlast"]; 

		$res=dbqry($sql);
		$json["sql"]=$sql;
		$json["page"]=$pg["page"];
		$json["tcnt"]=$pg["tcnt"];
		$json["tpage"]=$pg["tpage"];
		$json["psize"]=$pg["psize"];
		$json["block"]=$pg["block"];
		$json["list"]=array();

		while($dt=dbarr($res))
		{
			$addarray=array(
				"seq"=>$dt["RB_SEQ"], 
				"rbTitle"=>$dt["RB_TITLE_KOR"], 
				"rbDesc"=>$dt["RB_DESC_KOR"], 
				"rbIndex"=>$dt["RB_INDEX"],
				"rbBookno"=>$dt["RB_BOOKNO"] 
				///"rbDate"=>$dt["RB_DATE"]
				);
			array_push($json["list"], $addarray);
		}
		$json["sql"]=$sql;
		$json["apiCode"]=$apiCode;
		$json["resultCode"]="200";
		$json["resultMessage"]="OK";
	}
?>