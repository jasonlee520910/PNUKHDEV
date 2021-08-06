<?php  
	/// 주문현황 > 주문리스트 > 약재 리스트 약재등록시 매칭할 약재 리스트 (약재등록버튼)
	$apiCode=$_GET["apiCode"];
	$language=$_GET["language"];
	$page=$_GET["page"];
	//20190930 CY 부분 추가 
	$site=$_GET["site"];

	if($apiCode!="medicinehanpurelist"){$json["resultMessage"]="API(apiCode) ERROR";$apiCode="medicinehanpurelist";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="API(language) ERROR";}
	else
	{
		$searchpop=$_GET["searchPop"];

		$wsql=" where b.mm_use <> 'D' ";

		if($searchpop)  //layer-medicine에서 검색했을때
		{
			$arr=explode("|",$searchpop);
			foreach($arr as $val)
			{
				$arr2=explode(",",$val);
				if($arr2[0] == 'searpoptxt')//관리자에서 약재 검색시 
				{
					$wsql.=" and (";
					$wsql.=" b.mm_title_".$language." like '%".$arr2[1]."%' ";//약재명
					$wsql.=") ";
				}
			}
		}

		//20190930 CY 부분 추가 
		if($site=="CLIENT")
		{
			$wsql.=" and b.mm_code_pk is null";
		}

		$ssql=" c.mh_title_kor as mhTitle, b.md_code, b.mm_title_kor as mmTitle,  a.md_origin_kor as mdOrigin, a.md_maker_kor as mdMaker, a.md_type,a.md_seq ";

		//20190930 CY 부분 추가 
		if($site=="CLIENT")
		{
			$ssql.=" ,b.mm_code_pk ";
		}


		$jsql=" a inner join ".$dbH."_medicine_djmedi b on a.md_code=b.md_code ";
		$jsql.=" inner join ".$dbH."_medihub c on c.mh_code=a.md_hub ";
	
		$pg=apipaging("a.md_seq","medicine",$jsql,$wsql);


		//$sql=" select $ssql from ".$dbH."_medicine $jsql $wsql order by b.mm_seq desc limit ".$pg["snum"].", ".$pg["psize"];	
		$sql=" select * from (";
		$sql.=" select ROW_NUMBER() OVER (ORDER BY a.md_seq desc) NUM ";
		$sql.=" ,$ssql ";		
		$sql.=" from ".$dbH."_medicine $jsql $wsql ";
		$sql.=" order by a.md_seq desc ";
		$sql.=" ) where NUM>".$pg["snum"]." and NUM<=".$pg["tlast"];

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
				"mdType"=>$dt["MD_TYPE"],
				"mhTitle"=>$dt["MHTITLE"], //본초명 
				"mdCode"=>$dt["MD_CODE"], //약재코드
				"mmTitle"=>$dt["MMTITLE"],//약재명
				//"mdPrice"=>$dt["md_price"], //약재가격
				"mdOrigin"=>$dt["MDORIGIN"],//약재원산지
				"mdMaker"=>$dt["MDMAKER"]//약재조제사
				);
			array_push($json["list"], $addarray);
		}

		$json["sql"]=$sql;
		$json["apiCode"]=$apiCode;
		$json["resultCode"]="200";
		$json["resultMessage"]="OK";
	}
?>