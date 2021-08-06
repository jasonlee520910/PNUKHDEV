<?php /// 방제사전 
	$apiCode=$_GET["apiCode"];
	$language=$_GET["language"];
	$page=$_GET["page"];

	if($apiCode!="resourcelist"){$json["resultMessage"]="API(apiCode) ERROR2";$apiCode="resourcelist";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="API(language) ERROR";}
	else
	{
		$returnData=$_GET["returnData"];
		$json=array("apiCode"=>$apiCode,"returnData"=>$returnData);
		$search=$_GET["searchTxt"]; ///검색단어

		$jsql="";
	
		$wsql=" where rb_use <>'D' ";

		if($search)  ///검색단어
		{
			$wsql.=" and ( ";
			$wsql.=" rb_title_".$language." like '%".$search."%' ";///방제집명
			$wsql.=" or ";
			$wsql.=" rb_desc_".$language." like '%".$search."%' "; ///책설명
			$wsql.=" ) ";
		}

		$pg=apipaging("rb_seq","recipebook",$jsql,$wsql);

		///$sql=" select rb_seq,rb_title_".$language.", rb_index, rb_bookno, rb_desc_".$language."  from ".$dbH."_recipebook $jsql $wsql order by rb_date desc limit ".$pg["snum"].", ".$pg["psize"];

		$sql=" select * from (";
		$sql.=" select ROW_NUMBER() OVER (order by rb_date) NUM ";
		$sql.=" ,rb_seq,rb_title_".$language." as RBTITLEKOR, rb_index, rb_bookno, rb_desc_".$language." as RBDESCKOR ";
		$sql.=" from ".$dbH."_recipebook $jsql $wsql  ";
		$sql.=" order by rb_date desc ";
		$sql.=" ) where NUM>".$pg["snum"]." and NUM<=".$pg["tlast"];
/*

select * from ( 
select ROW_NUMBER() OVER (order by rb_date) NUM  
,rb_seq,rb_title_kor, rb_index, rb_bookno, rb_desc_kor  
from han_recipebook 
where rb_use <>'D' 
order by rb_date desc  
) where NUM>0 and NUM<=10

*/

		$res=dbqry($sql);
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
				"rbTitle"=>$dt["RBTITLEKOR"], ///방제집명
				"rbDesc"=>$dt["RBDESCKOR"],  ///설명
				"rbIndex"=>$dt["RB_INDEX"], ///편수
				"rbBookno"=>$dt["RB_BOOKNO"] ///권수
				);
			array_push($json["list"], $addarray);
		}

		$json["search"]=$search;
		$json["sql"]=$sql;
		$json["apiCode"]=$apiCode;
		$json["resultCode"]="200";
		$json["resultMessage"]="OK";
	}
?>