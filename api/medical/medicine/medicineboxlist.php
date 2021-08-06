<?php  
	///약재 리스트
	$apiCode=$_GET["apiCode"];
	$language=$_GET["language"];
	$page=$_GET["page"];

	if($apiCode!="medicineboxlist"){$json["resultMessage"]="API(apiCode) ERROR";$apiCode="medicineboxlist";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="API(language) ERROR";}
	else
	{
		$searchtxt=urldecode(trim($_GET["searchTxt"])); //검색단어
		$json=array("apiCode"=>$apiCode,"returnData"=>$returnData,"searchTxt"=>$searchtxt,"reData"=>$reData);

		$jsql=" a left join ".$dbH."_medicine_".$refer." b on b.md_code=a.md_code and b.mm_use = 'Y' ";

		///-----------------------------------------------------------------------------------------------------
		///검색부분
		$wsql=" where a.md_use <> 'D' "; 

		if($searchtxt)
		{
			$wsql.=" and ( ";
			$wsql.=" b.mm_title_".$language." like '".$searchtxt."%' ";///약재명
			$wsql.=" ) ";
		}

		$sql=" select ";
		$sql.=" a.md_type, a.md_code, a.md_origin_".$language." origin, a.md_priceA, a.md_priceB, a.md_priceC, a.md_priceD, a.md_priceE, a.md_water ";
		$sql.=" , b.mm_title_".$language." mmTitle, b.mm_title_chn ";
		$sql.=" from ".$dbH."_medicine ";
		$sql.=" $jsql $wsql order by a.md_date desc ";

		$res=dbqry($sql);
		$json["sql"]=$sql;
		$json["list"]=array();

/*
select  a.md_type, a.md_code, a.md_origin_kor origin, a.md_priceA, a.md_priceB, a.md_priceC, a.md_priceD, a.md_priceE, a.md_water 
 , b.mm_title_kor mmTitle, b.mm_title_chn 
  from han_medicine   a 
  left join han_medicine_djmedi b on b.md_code=a.md_code and b.mm_use = 'Y' 
   where a.md_use <> 'D'  and (  b.mm_title_kor like '가%'  ) 
 order by a.md_date desc 

*/


		while($dt=dbarr($res))
		{
			$addarray=array(
				"mdType"=>$dt["MD_TYPE"],
				"mdCode"=>$dt["MD_CODE"], ///약재코드 	
				"origin"=>$dt["ORIGIN"],///원산지 
				"mdPriceA"=>$dt["MD_PRICEA"],///가격A
				"mdPriceB"=>$dt["MD_PRICEB"],///가격B
				"mdPriceC"=>$dt["MD_PRICEC"],///가격C
				"mdPriceD"=>$dt["MD_PRICED"],///가격D
				"mdPriceE"=>$dt["MD_PRICEE"],///가격E
				"mdWater"=>$dt["MD_WATER"],///흡수율
				"mmTitle"=>$dt["MMTITLE"],///약재명 
				"mm_title_chn"=>$dt["MM_TITLE_CHN"]///약재한자명 
				);
			array_push($json["list"], $addarray);
		}

		$json["sql"]=$sql;
		$json["apiCode"]=$apiCode;
		$json["resultCode"]="200";
		$json["resultMessage"]="OK";
	}
?>