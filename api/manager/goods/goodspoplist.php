<?php  
	/// 제품재고관리 > 제품목록 > 상세보기 > 구성요소 등록/수정 (팝업 왼쪽 리스트)
	$apiCode=$_GET["apiCode"];
	$language=$_GET["language"];
	$page=$_GET["page"];
	$mt_seq=$_GET["seq"];

	if($apiCode!="goodspoplist"){$json["resultMessage"]="API(apiCode) ERROR";$apiCode="goodspoplist";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="API(language) ERROR";}
	else{
		$returnData=$_GET["returnData"];
		$json=array("apiCode"=>$apiCode,"returnData"=>$returnData);
		$searchtype=$_GET["searpoptype"]; //
		$searchtxt=$_GET["searpoptxt"];
		$searchpop=$_GET["searchPop"];

		if($searchtype=="origin")
		{
			//약재정보는 medibox : 9999 참조 goods 구성요소코드 - medicine_djmedi - medibox - medicine
			$jsql=" a  inner join ".$dbH."_medicine_djmedi b on a.mb_medicine=b.md_code ";
			$jsql.=" inner join ".$dbH."_medicine c on b.md_code=c.md_code ";
			$wsql=" where a.mb_use='Y' and a.mb_table='99999' ";

			if($searchtxt)
			{
				$wsql.=" and ( ";
				$wsql.=" c.md_code like '%".$searchtxt."%' ";//제품명
				$wsql.=" or ";
				$wsql.=" c.md_title_".$language." like '%".$searchtxt."%' ";//제품명
				//$wsql.=" or ";
				$wsql.=" ) ";
			}
			$pg=apipaging("mb_seq","medibox",$jsql,$wsql);
			
			//$sql=" select a.mb_seq gd_seq, b.mm_code gd_code, c.md_origin_".$language." gd_origin, c.md_maker_".$language." gd_maker, b.mm_title_".$language." gd_name from ".$dbH."_medibox $jsql $wsql limit ".$pg["snum"].", ".$pg["psize"];

			$sql=" select * from (";
			$sql.=" select ROW_NUMBER() OVER (ORDER BY a.mb_seq) NUM ";
			$sql.=" ,a.mb_seq gd_seq, b.mm_code gd_code, c.md_origin_".$language." gd_origin, c.md_maker_".$language." gd_maker, b.mm_title_".$language." gd_name ";
			$sql.=" from ".$dbH."_medibox  $jsql $wsql  ";	
			$sql.=" order by a.mb_seq ";
			$sql.=" ) where NUM>".$pg["snum"]." and NUM<=".$pg["tlast"];

			//echo $sql;
			$res=dbqry($sql);
		}
		else
		{
			$jsql=" a  ";
			$wsql=" where a.gd_use  <> 'D' ";

			$wsql.=" and a.gd_type = '".$searchtype."' and gd_seq<> '".$mt_seq."'  ";	 //해당 제품은 리스트에 나오지 않게 처리함(구성요소)

			if($searchtxt)
			{
				$wsql.=" and ( ";
				$wsql.=" a.gd_code like '%".$searchtxt."%' ";//품목코드
				$wsql.=" or ";
				$wsql.=" a.gd_name_kor like '%".$searchtxt."%' ";//제품명
				$wsql.=" or ";
				$wsql.=" a.gd_name_chn like '%".$searchtxt."%' ";//제품명
				$wsql.=" or ";
				$wsql.=" a.gd_name_eng like '%".$searchtxt."%' ";//제품명
				$wsql.=" ) ";
			}
			else if($searchpop)
			{
				$sarr=explode(",",substr($searchpop,1,200));
				if($sarr[1])
				{
					$wsql.=" and ( ";
					$wsql.=" a.gd_code like '%".$sarr[1]."%' ";//품목코드
					$wsql.=" or ";
					$wsql.=" a.gd_name_kor like '%".$sarr[1]."%' ";//제품명
					$wsql.=" or ";
					$wsql.=" a.gd_name_chn like '%".$sarr[1]."%' ";//제품명
					$wsql.=" or ";
					$wsql.=" a.gd_name_eng like '%".$sarr[1]."%' ";//제품명
					$wsql.=" ) ";
				}
			}
			$pg=apipaging("gd_seq","goods",$jsql,$wsql);
			
			//$sql=" select a.* , gd_name_".$language." gd_name from ".$dbH."_goods $jsql $wsql order by a.gd_seq desc limit ".$pg["snum"].", ".$pg["psize"];

			$sql=" select * from (";
			$sql.=" select ROW_NUMBER() OVER (ORDER BY a.gd_seq) NUM ";
			$sql.=" ,a.* ";
			$sql.=" ,gd_name_".$language." gd_name ";
			$sql.=" from ".$dbH."_goods  $jsql $wsql  ";	
			$sql.=" order by a.gd_seq ";
			$sql.=" ) where NUM>".$pg["snum"]." and NUM<=".$pg["tlast"];
			//echo $sql;
			$res=dbqry($sql);
		}

		$json["page"]=$pg["page"];
		$json["tcnt"]=$pg["tcnt"];
		$json["tpage"]=$pg["tpage"];
		$json["psize"]=$pg["psize"];
		$json["block"]=$pg["block"];
		$json["list"]=array();

		while($dt=dbarr($res))
		{
			switch($dt["GD_TYPE"])
			{
				case "goods":$gd_type="제품";break;
				case "pregoods":$gd_type="반제품";break;
				case "material":$gd_type="부재료";break;
				case "goodsdecoction":$gd_type="약속탕전";break;
				case "worthy":$gd_type="실속";break;
				//case "origin":$gd_type="원재료";break;
				default:$gd_type="원재료";
			}
			if($dt["INCOMINGDATE"]==""){$incomingdate=" - ";}else{$incomingdate=substr($dt["INCOMINGDATE"],0,16);}
			if($dt["OUTGOINGDATE"]==""){$outgoingdate=" - ";}else{$outgoingdate=substr($dt["OUTGOINGDATE"],0,16);}
			if($dt["GD_ORIGIN"]){$gdOrigin="(".$dt["GD_ORIGIN"].")";}else{$gdOrigin="";}
			if($dt["GD_MAKER"]){$gdMaker=" - ".$dt["GD_MAKER"];}else{$gdMaker="";}

			$addarray=array(
				"seq"=>$dt["GD_SEQ"], 
				"gdCode"=>$dt["GD_CODE"], 
				"gdType"=>$gd_type, 
				"gdName"=>$dt["GD_NAME"].$gdOrigin.$gdMaker, 
				"gdSpec"=>$dt["GD_SPEC"], 
				"gdSales"=>number_format($dt["GD_SALES"]), 
				"gdQty"=>number_format($dt["GD_QTY"]), 
				"incomingDate"=>$incomingdate, 
				"outgoingDate"=>$outgoingdate 
				//"gdDate"=>substr($dt["GD_MODIFY"],0,16)
				);
			array_push($json["list"], $addarray);
		}

		$json["sql"]=$sql;
		$json["apiCode"]=$apiCode;
		$json["resultCode"]="200";
		$json["resultMessage"]="OK";
	}
?>