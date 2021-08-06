<?php 
	///약재관리 > 약재목록 왼쪽 팝업
	$apiCode=$_GET["apiCode"];
	$language=$_GET["language"];
	$page=$_GET["page"];
	if($apiCode!="smumedicinelist"){$json["resultMessage"]="API(apiCode) ERROR";$apiCode="smumedicinelist";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="API(language) ERROR";}
	else
	{
		$searchpop=urldecode($_GET["searchPop"]);
		$reData=$_GET["reData"];
		$searchtxt=urldecode($_GET["searchTxt"]);

		$json=array("apiCode"=>$apiCode,"returnData"=>$returnData,"searchType"=>$searchtype,"searchTxt"=>$searchtxt,"searchPop"=>$searchpop,"reData"=>$reData);

		$jsql=" a inner join ".$dbH."_medihub b on a.md_hub=b.mh_code";
		$wsql=" where a. md_use <>'D' and a.md_code not in  (select c.md_code from han_medicine_djmedi c where c.mm_use <> 'D')  ";

		if($reData == "medicinesmu")  ///약재목록 > 약재관리 > 팝업
		{
			$refer="";
		}

		if($searchtxt)
		{
			$wsql.=" and ( ";
			$wsql.=" b.mh_title_".$language." like '%".$searchtxt."%' ";///본초명
			$wsql.=" or ";
			$wsql.=" b.mh_code like '%".$searchtxt."%' ";///본초코드(약재코드)
			$wsql.=" or ";
			$wsql.=" a.md_title_".$language." like '%".$searchtxt."%' ";///약재명
			$wsql.=" or ";
			$wsql.=" a.md_alias_".$language." like '%".$searchtxt."%' ";///별칭
			$wsql.=" or ";
			$wsql.=" b.mh_dtitle_".$language." like '%".$searchtxt."%' ";///이명
			$wsql.=" or ";
			$wsql.=" a.md_origin_".$language." like '%".$searchtxt."%' ";///원산지
			$wsql.=" or ";
			$wsql.=" a.md_maker_".$language." like '%".$searchtxt."%' ";///제조사
			$wsql.=" ) ";
		}

		if($searchpop)
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

		if($reData=="order"){
			$wsql.=" and a.md_code in (select md_code from ".$dbH."_medicine where md_use='Y' and md_type='medicine') ";
		}

		$pg=apipaging("a.md_code","medicine",$jsql,$wsql);
		
		$sql=" select * from (";
		$sql.=" select ROW_NUMBER() OVER (ORDER BY a.md_date) NUM ";
		$sql.=" , a.md_code,a.md_title_kor, to_char(b.mh_title_chn) as MHTITLECHN ,a.md_date";
		$sql.=" , a.md_origin_kor,a.md_maker_kor ";
		$sql.=" , b.mh_code,b.mh_title_kor   ";

		///----------------------------------------------------------------------
		if($refer)
			$sql.=" , r.mm_title_".$language." as mmTitle, r.mm_code ";
		///----------------------------------------------------------------------
		$sql.=" from ".$dbH."_medicine  $jsql $wsql order by a.md_date desc ";
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
			if($dt["MD_TITLE_KOR"]){$mdTitle=$dt["MD_TITLE_KOR"];}else{$mdTitle="-";}

			///----------------------------------------------------------------------
			$mdTitle = ($refer) ? $dt["MMTITLE"] : $mdTitle;///약재명
			$mbMedicine = ($refer) ? $dt["MM_CODE"] : $dt["MD_CODE"];///약재코드 
			///----------------------------------------------------------------------
			
			if($reData == "medicinesmu")  ///약재목록 > 약재관리 > 팝업
			{
				$addarray=array(

					"mdOriginKor"=>$dt["MD_ORIGIN_KOR"], 
					"mdMakerKor"=>$dt["MD_MAKER_KOR"], 

					"seq"=>$dt["MD_SEQ"], 
					"mhCode"=>$dt["MH_CODE"], ///본초코드
					"mhTitle"=>trim($dt["MH_TITLE_KOR"]), ///본초명
					"mdCode"=>$mbMedicine, ///약재코드
					"mdTitleKor"=>$mdTitle, ///약재명
					"mdTitleChn"=>$dt["MHTITLECHN"], ///약재먕
					"mdDate"=>$dt["MD_DATE"]
					);
				array_push($json["list"], $addarray);
			}			
		}

		$json["reData"]=$reData;
		$json["sql"]=$sql;
		$json["apiCode"]=$apiCode;
		$json["resultCode"]="200";
		$json["resultMessage"]="OK";
	}
?>