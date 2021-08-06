<?php  
	///약재관리 > 약재목록_디제이메디 > 약재관리 리스트(layer-medicine와 약재목록_디제이메디에서 사용)   약재관리_디제이메디에서는 불러와짐(다른값들은 확인해야함)
	$apiCode=$_GET["apiCode"];
	$language=$_GET["language"];
	$page=$_GET["page"];
	if($apiCode!="medicinelist"){$json["resultMessage"]="API(apiCode) ERROR";$apiCode="medicinelist";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="API(language) ERROR";}
	else
	{
		$searchpop=urldecode($_GET["searchPop"]);
		$reData=$_GET["reData"];
		$searchselecttype=$_GET["searchSelectType"];
		$searchselect=$_GET["searchSelect"];
		$searchtype=$_GET["searchType"];
		$searchtxt=urldecode(trim($_GET["searchTxt"])); //검색단어
		$json=array("apiCode"=>$apiCode,"returnData"=>$returnData,"searchTxt"=>$searchtxt,"reData"=>$reData);

		$qsql=" ";
		$gsql=" ";
		$jsql=" a left join ".$dbH."_medihub b on a.md_hub=b.mh_code ";

		if($reData == "medicinesmu")
		{
			$refer="";
		}

		$jsql=" a inner join ".$dbH."_medihub b on a.md_hub=b.mh_code inner join han_code c on c.cd_type='mdWater'   and c.cd_code=a.md_watercode";
		$wsql=" where a.md_use <> 'D' and b.mh_use <> 'D' "; 


		if($reData == "order" & $refer == "djmedi") ///주문리스트에 약재추가 리스트
		{
			$jsql.=" inner join ".$dbH."_medicine_".$refer." r on a.md_code=r.md_code  and r.mm_use<>'D' ";  ///0909  and r.mm_use<>'D' 조건추가
		}
		else if($reData == "stock" & $refer == "djmedi")///재고관리 >약재입고 약재명  (0409 OK)
		{
			$jsql.=" inner join ".$dbH."_medicine_".$refer." r on a.md_code=r.md_code  ";   
		}
		else if($reData == "Unique" & $refer == "djmedi")///고유처방 >약재검색 약재명
		{
			$jsql.=" left join ".$dbH."_medicine_".$refer." r on a.md_code=r.md_code";///0802 고유처방에서 약재검색은medicine 테이블의 약재명이 나와야하므로 left
		}
		/* 실속처방은 패스
		else if($reData == "worthy" & $refer == "djmedi")///실속처방 >약재검색 약재명
		{
			$jsql.=" inner join ".$dbH."_medicine_".$refer." r on a.md_code=r.md_code and r.mm_use<>'D' ";///실속처방
			//$jsql.=" inner join ".$dbH."_medibox d on d.mb_medicine=r.md_code and d.mb_use<>'D' "; 
			//$qsql.=" ,group_concat(d.mb_table) ";
			//$gsql.=" group by d.mb_medicine";
		}
		*/
		else if($reData == "commercial" & $refer == "djmedi")///상비처방 >약재검색 약재명
		{
			$jsql.=" inner join ".$dbH."_medicine_".$refer." r on a.md_code=r.md_code and r.mm_use<>'D' ";/// 상비
			$jsql.=" inner join ".$dbH."_medibox d on d.mb_medicine=r.md_code and d.mb_use<>'D' "; ///약재함이 있는 약재만 리스트 검색
			//$qsql.=" ,group_concat(d.mb_table) ";
			$gsql.=" group by r.mm_title_kor ,c.cd_name_kor, b.mh_code ,b.mh_title_kor ,a.md_seq,a.md_code,a.md_title_kor  ";
			$gsql.=" ,a.md_origin_kor ,a.md_maker_kor,a.md_qty,a.md_waterchk ,a.md_water,a.md_price,a.md_type,a.md_PriceE,a.md_date ";
		}
		else if($reData == "recipegoods" & $refer == "djmedi")///약속처방 >약재검색 약재명
		{
			$jsql.=" inner join ".$dbH."_medicine_".$refer." r on a.md_code=r.md_code and r.mm_use<>'D' ";///약속
			$jsql.=" inner join ".$dbH."_medibox d on d.mb_medicine=r.md_code and d.mb_use<>'D' "; ///약재함이 있는 약재만 리스트 검색
			//$qsql.=" ,group_concat(d.mb_table) ";
			$gsql.=" group by r.mm_title_kor ,c.cd_name_kor, b.mh_code ,b.mh_title_kor ,a.md_seq,a.md_code,a.md_title_kor  ";
			$gsql.=" ,a.md_origin_kor ,a.md_maker_kor,a.md_qty,a.md_waterchk ,a.md_water,a.md_price,a.md_type,a.md_PriceE,a.md_date ";
		}
		else if($reData == "GoodsMedicine" & $refer == "djmedi")///제품관리 > 제품원재료관리 > 약재명 버튼
		{
			$jsql.=" inner join ".$dbH."_medicine_".$refer." r on a.md_code=r.md_code and r.mm_use<>'D' ";
			$jsql.=" inner join ".$dbH."_medibox d on d.mb_medicine=r.md_code and d.mb_table not in ('99999','44444') and d.mb_use<>'D' "; ///약재함이 있는 약재만 리스트 검색
			//$qsql.=" ,group_concat(d.mb_table) ";
			$gsql.=" group by a.md_seq,a.md_code,a.md_title_kor,a.md_origin_kor ,a.md_maker_kor,a.md_qty,a.md_waterchk,a.md_water,a.md_price,a.md_date  ";
			$gsql.=" ,a.md_type,a.md_PriceE,r.mm_title_kor ,c.cd_name_kor, b.mh_code ,b.mh_title_kor ";
		}
		else if($reData == "medibox" & $refer == "djmedi") ///약재함>>약재검색 
		{
			$jsql.=" inner join ".$dbH."_medicine_".$refer." r on a.md_code=r.md_code  and r.mm_use <> 'D' ";    ///약재함에서 등록되지 않는 약재만 보여주기 
		}
		else if($reData == "goods"  & $refer == "djmedi")///goods (1115)
		{
			$jsql.=" inner join ".$dbH."_medicine_".$refer." r on a.md_code=r.md_code and r.mm_use<>'D' ";   
		}
		else if($refer == "djmedi")///약재목록_디제이메디
		{
			$jsql.=" left join ".$dbH."_medicine_".$refer." r on a.md_code=r.md_code and r.mm_use<>'D' ";   ///inner 조인에서 admin은 모두 봐야하므로 left 조인으로 변경함 
		}

		if($reData == "order")
		{
			$wsql.=" and (a.md_type='medicine' or a.md_type='sweet') ";   ///주문리스트 약재추가에서는 별전이 검색이 안되게 함.
		}


		///검색부분
		if($searchtxt)
		{
			$wsql.=" and ( ";
			$wsql.=" b.mh_title_".$language." like '%".$searchtxt."%' ";///본초명
			$wsql.=" or ";
			$wsql.=" b.mh_code like '%".$searchtxt."%' ";///본초코드
			$wsql.=" or ";
			$wsql.=" a.md_title_".$language." like '%".$searchtxt."%' ";///약재명
			$wsql.=" or ";
			$wsql.=" a.md_code like '%".$searchtxt."%' ";///약재코드
			$wsql.=" ) ";
		}

		if($searchpop)  ///layer-medicine에서 검색했을때
		{
			$arr=explode("|",$searchpop);
			foreach($arr as $val)
			{
				$arr2=explode(",",$val);
				if($arr2[0]=="searchType")
				{
					if($arr2[1]=="mhTitle")
					{
						$field=" b.mh_title_".$language." ";
					}
					else if($arr2[1]=="mdTitle")
					{
						$field=" a.md_title_".$language." ";
					}
				}
				if($arr2[0]=="searchTxt")
				{
					$seardata=$arr2[1];
				}
			}
			if($seardata)
			{
				$wsql.=" and ".$field." like '%".$seardata."%' ";
			}
		}


		$pg=apipaging("a.md_seq","medicine",$jsql,$wsql);

		$sql=" select * from (";
		$sql.=" select ROW_NUMBER() OVER (ORDER BY a.md_seq) NUM ";
		$sql.=" ,r.mm_title_kor";
		$sql.=" ,c.cd_name_".$language. " as MDWATERNAME, b.mh_code ,b.mh_title_kor";
		$sql.=" ,a.md_seq,a.md_code,a.md_title_kor ,a.md_origin_kor ,a.md_maker_kor,a.md_qty,a.md_waterchk,a.md_water,a.md_price,a.md_type,a.md_PriceA,a.md_PriceB,a.md_PriceC,a.md_PriceD,a.md_PriceE,a.md_date $qsql ";
		$sql.=" from ".$dbH."_medicine $jsql $wsql $gsql ";
		$sql.=" order by a.md_date ";
		$sql.=" ) where NUM>".$pg["snum"]." and NUM<=".$pg["tlast"];

		$res=dbqry($sql);
		$json["sql"]=$sql;
		$json["pg"]=$pg;
		$json["page"]=$pg["page"];
		$json["tcnt"]=$pg["tcnt"];
		$json["tpage"]=$pg["tpage"];
		$json["psize"]=$pg["psize"];
		$json["block"]=$pg["block"];
		$json["list"]=array();

		
		

		while($dt=dbarr($res))
		{
			if($dt["MD_WATERCODE"]){$mdwatercode=$dt["MD_WATERCODE"];}else{$mdwatercode="-";}

			$mdTypeName=($dt["MD_TYPE"]=="medicine") ? "약재" : "별전";

				$addarray=array(
					"seq"=>$dt["MD_SEQ"], 
					"mhCode"=>$dt["MH_CODE"], ///본초코드
					"mhTitle"=>$dt["MH_TITLE_KOR"], ///본초명
					"mdCode"=>$dt["MD_CODE"], ///약재코드

					"mdType"=>$dt["MD_TYPE"], //별전 or 약재
					"mdTypeName"=>$mdTypeName, //약재타입 text

					"mdPrice"=>$dt["MD_PRICE"], //판매가격	
					"mdPriceA"=>$dt["MD_PRICEA"], //판매가격A	
					"mdPriceB"=>$dt["MD_PRICEB"], //판매가격B	
					"mdPriceC"=>$dt["MD_PRICEC"], //판매가격C	
					"mdPriceD"=>$dt["MD_PRICED"], //판매가격D	
					"mdPriceE"=>$dt["MD_PRICEE"], //판매가격E				

					"mdTitle"=>$dt["MD_TITLE_KOR"], ///약재명_디제이메디
					"mmtitle"=>$dt["MM_TITLE_KOR"], /// medicine_djmedi 테이블의 약재명

					"mdOrigin"=>$dt["MD_ORIGIN_KOR"], /// 원산지
					"mdMaker"=>$dt["MD_MAKER_KOR"], /// 제조사 
					"mdQty"=>$dt["MD_QTY"], ///재고수량 
					"mdWaterchk"=>$dt["MD_WATERCHK"], ///약재흡수율예외처리
						
					"mdwatername"=>$dt["MDWATERNAME"], ///흡수율코드
					"mdWater"=>$dt["MD_WATER"], ///흡수율	
					"mdPrice"=>$dt["MD_PRICE"] ///판매가격
					);
					array_push($json["list"], $addarray);
		}

		$json["refer"]=$refer;
		$json["sql"]=$sql;
		$json["apiCode"]=$apiCode;
		$json["resultCode"]="200";
		$json["resultMessage"]="OK";
	}
?>