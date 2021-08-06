<?php  
	///약재 리스트//$reData  & $refer  TMPS에서 안쓰는건 삭제해서 소스 정리하기 
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


		///-----------------------------------------------------------------------------------------------------
		///0425 본초약재코드 영문명으로 수정하면서 쿼리 수정함

		///$jsql=" a left join ".$dbH."_medihub b on a.md_hub=b.mh_code ";

		if($reData == "medicinesmu")
		{
			$refer="";
		}

		$jsql=" a inner join ".$dbH."_medihub b on a.md_hub=b.mh_code inner join han_code c on c.cd_type='mdWater'   and c.cd_code=a.md_watercode";

		$wsql=" where a.md_use = 'Y' "; 
/*
		if($reData == "order" & $refer == "djmedi") ///주문리스트에 약재추가 리스트
		{
			$jsql.=" inner join ".$dbH."_medicine_".$refer." r on a.md_code=r.md_code  ";
		}
		else if($reData == "stock" & $refer == "djmedi")///재고관리 >약재입고 약재명
		{
			$jsql.=" inner join ".$dbH."_medicine_".$refer." r on a.md_code=r.md_code  ";   
		}
		else if($reData == "Unique" & $refer == "djmedi")///고유처방 >약재검색 약재명
		{
			$jsql.=" inner join ".$dbH."_medicine_".$refer." r on a.md_code=r.md_code  ";   
		}
		else
		*/
		if($refer == "djmedi")///약재목록_디제이메디
		{

			$jsql.=" left join ".$dbH."_medicine_".$refer." r on a.md_code=r.md_code ";   ///inner 조인에서 admin은 모두 봐야하므로 left 조인으로 변경함  
			$wsql.=" and r.mm_use='Y' "; 
		}

		
/*
		if($reData == "order")
		{
			$wsql.=" and a.md_type='medicine' ";   ///주문리스트 약재추가에서는 별전이 검색이 안되게 함.
		}

		if($reData == "Unique" & $refer == "djmedi")
		{
			$wsql.=" and a.md_type='medicine' ";   ///0618고유처방에 나오는 리스트는 조건추가
		}
*/

		///검색부분
		if($searchtxt)
		{
			$wsql.=" and ( ";
			$wsql.=" b.mh_title_".$language." like '%".$searchtxt."%' ";///본초명
			$wsql.=" or ";
			$wsql.=" b.mh_code = '".$searchtxt."' ";///본초코드
			$wsql.=" or ";
			$wsql.=" a.md_title_".$language." like '%".$searchtxt."%' ";///약재명
			$wsql.=" or ";
			$wsql.=" a.md_code like '%".$searchtxt."%' ";///약재코드
			$wsql.=" ) ";
		}

		if($searchpop)  ///layer-medicine에서 검색했을때
		{
			///$searchtype=$searchtype="";
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


/*
		$sql=" select ";
		$sql.=" a.md_seq, a.md_code, a.md_type, a.md_origin_".$language." origin, a.md_title_".$language." mediname, a.md_property_kor property,  a.md_priceA, a.md_priceB, a.md_priceC, a.md_priceD, a.md_priceE, a.md_water ";
		$sql.=", r.mm_title_kor mmTitle ";
		$sql.=", c.cd_name_".$language. " mdwatername ";
		$sql.=", b.mh_code ,b.mh_title_".$language." hubname , b.mh_dtitle_".$language." mh_dtitle, b.mh_ctitle_".$language." mh_ctitle, b.mh_state mh_state, b.mh_taste mh_taste, b.mh_object mh_object ";
		$sql.=" from ".$dbH."_medicine ";
		$sql.=" $jsql $wsql order by md_date desc limit ".$pg["snum"].",".$pg["psize"]." ";
*/

		$sql=" select * from (";
		$sql.=" select ROW_NUMBER() OVER (ORDER BY a.md_seq) NUM ";
		$sql.=" ,a.md_seq, a.md_code, a.md_type, a.md_origin_kor origin, a.md_title_kor as MEDINAME, a.md_property_kor property,  a.md_priceA, a.md_priceB, a.md_priceC, a.md_priceD, a.md_priceE, a.md_water  ";
		$sql.=" ,r.mm_title_kor mmTitle "; 
		$sql.=" , c.cd_name_".$language. " mdwatername "; 
		$sql.=" , b.mh_code ,b.mh_title_".$language." as HUBNAME , b.mh_dtitle_".$language." mh_dtitle, b.mh_ctitle_".$language." mh_ctitle, b.mh_state mh_state, b.mh_taste mh_taste, b.mh_object mh_object "; 
		$sql.=" from ".$dbH."_medicine $jsql $wsql ";
		$sql.=" order by a.md_date desc ";
		$sql.=" ) where NUM>".$pg["snum"]." and NUM<=".$pg["tlast"];


/*
쿼리 
select * from ( 
select ROW_NUMBER() OVER (ORDER BY a.md_seq) NUM  
,a.md_seq, a.md_code, a.md_type, a.md_origin_kor origin, a.md_title_kor mediname, a.md_property_kor property,  a.md_priceA, a.md_priceB, a.md_priceC, a.md_priceD, a.md_priceE, a.md_water   
,r.mm_title_kor mmTitle   
, c.cd_name_kor mdwatername   
, b.mh_code ,b.mh_title_kor hubname , b.mh_dtitle_kor mh_dtitle, b.mh_ctitle_kor mh_ctitle, b.mh_state mh_state, b.mh_taste mh_taste, b.mh_object mh_object  
from han_medicine	  
a inner join han_medihub b on a.md_hub=b.mh_code 
inner join han_code c on c.cd_type='mdWater'   and c.cd_code=a.md_watercode
left join han_medicine_djmedi r on a.md_code=r.md_code  
where a.md_use = 'Y'
order by a.md_date desc  
)where NUM>0 and NUM<=10


*/


		$res=dbqry($sql);
		///var_dump($pg); 
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
			///--------------------------------------------
			///성미귀경 한글 텍스트 가져오기 
			$tsql="";
			$tmh_state=substr(trim($dt["MH_STATE"]),1);
			$tmh_taste=substr(trim($dt["MH_TASTE"]),1);
			$tmh_object=substr(trim($dt["MH_OBJECT"]),1);

//hancodetext오류
			if($tmh_state)
			{
				//$mhStatetext = hancodetext($tmh_state,"mhState");
			}
			if($tmh_taste)
			{
				//$mhTastetext = hancodetext($tmh_taste,"mhTaste");
			}
			if($tmh_object)
			{
				//$mhObjecttext = hancodetext($tmh_object,"mhObject");
			}

			$mhObjecttext=$mhTastetext=$mhStatetext="";

			//if($dt["MH_DTITLE"]){$mhdtitle=$dt["MH_DTITLE"];}else{$mhdtitle="-";}
			if($dt["MH_EFFICACY"]){$mhefficacy=$dt["MH_EFFICACY"];}else{$mhefficacy="-";}
			if($dt["MH_STITLE"]){$mhstitle=$dt["MH_STITLE"];}else{$mhstitle="-";}
			if($dt["MH_CTITLE"]){$mhctitle=$dt["MH_CTITLE"];}else{$mhctitle="-";}

				$addarray=array(
					"seq"=>$dt["MD_SEQ"], 
					"mdType"=>$dt["MD_TYPE"],
					"mdCode"=>$dt["MD_CODE"], ///약재코드 	
					"origin"=>$dt["ORIGIN"],///원산지 
					"property"=>$dt["PROPERTY"],///법제 
					"mdPriceA"=>$dt["MD_PRICEA"],///가격A
					"mdPriceB"=>$dt["MD_PRICEB"],///가격B
					"mdPriceC"=>$dt["MD_PRICEC"],///가격C
					"mdPriceD"=>$dt["MD_PRICED"],///가격D
					"mdPriceE"=>$dt["MD_PRICEE"],///가격E
					"mdWater"=>$dt["MD_WATER"],///흡수율 
					"mmtitle"=>$dt["MMTITLE"], /// medicine_djmedi 테이블의 약재명 일단 안씀 

					"mediname"=>$dt["MMTITLE"], ///약재명
					"hubname"=>$dt["HUBNAME"], ///허브명

					//"mhStatetext"=>$mhStatetext, ///성  
					//"mhTastetext"=>$mhTastetext, ///미
					//"mhObjecttext"=>$mhObjecttext, ///귀경

					//"mhdtitle"=>$mhdtitle, ///별칭 이명

					"mdDate"=>$dt["MD_DATE"]
					);
					array_push($json["list"], $addarray);
		}


		$json["reData"]=$reData;
		$json["refer"]=$refer;
		$json["sql"]=$sql;
		$json["apiCode"]=$apiCode;
		$json["resultCode"]="200";
		$json["resultMessage"]="OK";
	}

?>