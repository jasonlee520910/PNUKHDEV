<?php 
	///약재관리 > 약재목록 오른쪽 리스트
	$apiCode=$_GET["apiCode"];
	$language=$_GET["language"];
	$page=$_GET["page"];
	if($apiCode!="medicinesmulist"){$json["resultMessage"]="API(apiCode) ERROR";$apiCode="medicinesmulist";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="API(language) ERROR";}
	else
	{
		$json=array("apiCode"=>$apiCode,"returnData"=>$returnData);
		$returnData=$_GET["returnData"];
		$searchtxt=$_GET["searchTxt"];  ///검색단어

		$jsql=" a inner join ".$dbH."_medicine_".$refer." b on a.md_code=b.md_code and b.mm_use <> 'D' ";
		$wsql=" where a.md_use <> 'D' ";
		if($searchtxt)  ///검색단어가 있을때
		{

			$wsql.=" and ( ";
			$wsql.=" a.md_title_".$language." like '%".$searchtxt."%' ";///디제이메디 약재명
			$wsql.=" or ";
			$wsql.=" b.mm_title_".$language." like '%".$searchtxt."%' "; ///세명대 약재명
			$wsql.=" or ";
			$wsql.=" a.md_code like '%".$searchtxt."%' ";///디제이메디 약재코드
			$wsql.=" or ";
			$wsql.=" b.mm_code like '%".$searchtxt."%' ";///세명대 약재코드
			$wsql.=" ) ";
		}

		$pg=apipaging("a.md_code","medicine",$jsql,$wsql);

		$sql=" select * from (";
		$sql.=" select ROW_NUMBER() OVER (ORDER BY b.mm_date desc) NUM ";
		$sql.=" ,a.md_code,a.md_type, a.md_title_kor, a.md_title_chn, a.md_title_eng,a.md_price ";
		$sql.=" ,a.md_maker_".$language." as MDMAKER ,a.md_origin_".$language." as MDORIGIN ";		
		$sql.=" , b.mm_seq, b.mm_code, b.mm_title_kor, b.mm_title_chn, b.mm_title_eng ,b.mm_use ";	
		$sql.=" from ".$dbH."_medicine $jsql $wsql  ";		
		$sql.="  order by b.mm_date desc  ";
		$sql.=" ) where NUM>".$pg["snum"]." and NUM<=".$pg["tlast"];   

		$res=dbqry($sql);
		$json["pg"]=$pg;
		$json["page"]=$pg["page"];
		$json["tcnt"]=$pg["tcnt"];
		$json["tpage"]=$pg["tpage"];
		$json["psize"]=$pg["psize"];
		$json["block"]=$pg["block"];
		$json["list"]=array();

		while($dt=dbarr($res))
		{	
			$addarray=array(
				"mm_seq"=>$dt["MM_SEQ"], 

				"md_price"=>$dt["MD_PRICE"], ///금액
				"md_maker"=>$dt["MDMAKER"], ///제조사
				"md_origin"=>$dt["MDORIGIN"], ///원산지

				"md_code"=>$dt["MD_CODE"], 
				"md_title_kor"=>$dt["MD_TITLE_KOR"],
				"md_title_chn"=>$dt["MD_TITLE_CHN"],
				"md_title_eng"=>$dt["MD_TITLE_ENG"],

				"mm_code"=>$dt["MM_CODE"],
				"mm_title_kor"=>$dt["MM_TITLE_KOR"],
				"mm_title_chn"=>$dt["MM_TITLE_CHN"],
				"mm_title_eng"=>$dt["MM_TITLE_ENG"],

				"md_type"=>$dt["MD_TYPE"],///약재 or 별전
				"mm_use"=>$dt["MM_USE"]
				);

			array_push($json["list"], $addarray);
		}
		
		$json["searchtxt"] =$searchtxt;
		$json["sql"]=$sql;
		$json["apiCode"]=$apiCode;
		$json["resultCode"]="200";
		$json["resultMessage"]="OK";
	}
?>