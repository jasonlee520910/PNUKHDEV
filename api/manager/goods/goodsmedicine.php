<?php  
	/// 제품재고관리 > 제품원재료관리 > 리스트
	$apiCode=$_GET["apiCode"];
	$language=$_GET["language"];
	$page=$_GET["page"];
	if($apiCode!="goodsmedicine"){$json["resultMessage"]="API(apiCode) ERROR";$apiCode="goodsmedicine";}
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

		$jsql=" a left join ".$dbH."_medihub b on a.md_hub=b.mh_code ";

		if($reData == "medicinesmu")
		{
			$refer="";
		}

		$jsql=" a inner join ".$dbH."_medihub b on a.md_hub=b.mh_code ";
		$jsql.=" inner join ".$dbH."_medicine_djmedi d on a.md_code=d.md_code ";
		$jsql.=" inner join ".$dbH."_medibox c on a.md_code=c.mb_medicine ";
		$wsql=" where a.md_use <> 'D' and c.mb_table='99999' "; 

		//검색부분
		if($searchtxt)
		{
			$wsql.=" and ( ";
			$wsql.=" b.mh_title_".$language." like '%".$searchtxt."%' ";//본초명
			$wsql.=" or ";
			$wsql.=" b.mh_code like '%".$searchtxt."%' ";//본초코드
			$wsql.=" or ";
			$wsql.=" a.md_title_".$language." like '%".$searchtxt."%' ";//약재명
			$wsql.=" or ";
			$wsql.=" a.md_code like '%".$searchtxt."%' ";//약재코드
			$wsql.=" ) ";
		}

		if($searchpop)  //layer-medicine에서 검색했을때
		{
			//$searchtype=$searchtype="";
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
		$sql.=" select ROW_NUMBER() OVER (ORDER BY a.md_date) NUM ";
		$sql.=" ,(select * from ( select to_char(aa.wh_indate,'yyyy-mm-dd') from han_warehouse aa inner join ".$dbH."_medibox bb on aa.wh_code=bb.mb_stock and bb.mb_table='99999' where aa.wh_type='outgoing' and aa.wh_code=c.mb_stock order by aa.wh_date desc) where rownum <= 1) as incomingDate ";
		$sql.=" ,(select * from (select to_char(mu_date,'yyyy-mm-dd') from ".$dbH."_medicine_use where mu_medibox=c.mb_code order by mu_date desc) where rownum <= 1) as usingDate ";
		$sql.=" ,b.mh_code ,b.mh_title_kor";
		$sql.=", a.md_code ,a.md_origin_kor ,a.md_maker_kor , a.md_loss , a.md_losscapa , a.md_price ,a.md_title_kor ,to_char(a.md_date,'yyyy-mm-dd') as md_date  "; 
		$sql.=" ,c.mb_capacity, c.mb_code, c.mb_stock, d.mm_code, d.mm_title_".$language." mmTitle";
		$sql.=" from ".$dbH."_medicine $jsql $wsql  ";		
		$sql.=" order by usingDate desc, incomingDate desc  ";
		$sql.=" ) where NUM>".$pg["snum"]." and NUM<=".$pg["tlast"];   


//echo $sql;
		$res=dbqry($sql);
		//var_dump($pg); 
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
			if($dt["MD_ORIGIN_KOR"]){$mdOrigin=$dt["MD_ORIGIN_KOR"];}else{$mdOrigin="-";}
			if($dt["MD_MAKER_KOR"]){$mdMaker=$dt["MD_MAKER_KOR"];}else{$mdMaker="-";}
			$mdTypeName=($dt["MD_TYPE"]=="medicine") ? "약재" : "별전";
			if($dt["INCOMINGDATE"]){$incomingDate=$dt["INCOMINGDATE"];}else{$incomingDate="-";}
			if($dt["USINGDATE"]){$usingDate=$dt["USINGDATE"];}else{$usingDate="-";}

				$addarray=array(
					"seq"=>$dt["MD_SEQ"], 
					"mmCode"=>$dt["MM_CODE"], 
					"mmTitle"=>$dt["MMTITLE"], // medicine_djmedi 테이블의 약재명
					"mdCode"=>$dt["MD_CODE"], 
					"mdType"=>$dt["MD_TYPE"], //별전 or 약재
					"mdTypeName"=>$mdTypeName,
					"mhCode"=>$dt["MH_CODE"], //본초코드
					"mhTitle"=>$dt["MH_TITLE_KOR"], //본초명
					"mdCode"=>$dt["MD_CODE"], //약재코드
					"mdTitle"=>$dt["MD_TITLE_KOR"], //약재명_디제이메디
					"mdOrigin"=>$mdOrigin, //원산지
					"mdMaker"=>$mdMaker, //제조사
					"mdLoss"=>$dt["MD_LOSS"], //로스율	
					"mdLosscapa"=>$dt["MD_LOSSCAPA"], //로스량	
					"mdPrice"=>$dt["MD_PRICE"], //판매가격	
					"mdPriceA"=>$dt["MD_PRICEA"], //판매가격A	
					"mdPriceB"=>$dt["MD_PRICEB"], //판매가격B	
					"mdPriceC"=>$dt["MD_PRICEC"], //판매가격C	
					"mdPriceD"=>$dt["MD_PRICED"], //판매가격D	
					"mdPriceE"=>$dt["MD_PRICEE"], //판매가격E	
					"mdCapacity"=>$dt["MB_CAPACITY"], //재고량 
					"incomingDate"=>$incomingDate, //재고량 
					"usingDate"=>$usingDate, //재고량 
					"mdDate"=>$dt["MD_DATE"]
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