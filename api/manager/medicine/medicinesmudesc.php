<?php 
	///약재관리 > 약재목록 왼쪽 상세
	$apiCode=$_GET["apiCode"];
	$language=$_GET["language"];
	$mm_seq=$_GET["seq"];

	if($apiCode!="medicinesmudesc"){$json["resultMessage"]="API(apiCode) ERROR";$apiCode="medicinesmudesc";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="API(language) ERROR";}
	///else if($mm_seq==""){$json["resultMessage"]="API(seq) ERROR";}
	else
	{		
		$returnData=$_GET["returnData"];

		$hCodeList = getNewCodeTitle("mdWaterchk");
		$UseList = getCodeList($hCodeList, 'mdWaterchk');  ///약재 사용여부 리스트

		$sql=" select ";
		$sql.=" a.md_code, a.md_title_kor, a.md_title_chn, a.md_title_eng,a.md_price,a.md_priceA,a.md_priceB,a.md_priceC ";
		$sql.=" ,a.md_priceD,a.md_priceE,a.md_stable, a.md_maker_".$language." as MDMAKER ,a.md_origin_".$language." as MDORIGIN";
		$sql.=", b.mm_seq, b.mm_code, b.mm_title_kor, b.mm_title_chn, b.mm_title_eng ,b.mm_use ";
		$sql.=" from ".$dbH."_medicine ";
		$sql.=" a inner join ".$dbH."_medicine_".$refer." b on a.md_code=b.md_code";
		$sql.=" where b.mm_seq='".$mm_seq."'";

		$dt=dbone($sql);

		$json = array(
			"md_code"=>$dt["MD_CODE"],

			"md_price"=>$dt["MD_PRICE"], ///금액
			"md_priceA"=>$dt["MD_PRICEA"], ///금액
			"md_priceB"=>$dt["MD_PRICEB"], ///금액
			"md_priceC"=>$dt["MD_PRICEC"], ///금액
			"md_priceD"=>$dt["MD_PRICED"], ///금액
			"md_priceE"=>$dt["MD_PRICEE"], ///금액

			"md_maker"=>$dt["MDMAKER"], ///제조사
			"md_origin"=>$dt["MDORIGIN"], ///원산지

			"md_stable"=>$dt["MD_STABLE"], ///적정수량		

			"md_title_kor"=>$dt["MD_TITLE_KOR"],
			"md_title_chn"=>$dt["MD_TITLE_CHN"],
			"md_title_eng"=>$dt["MD_TITLE_ENG"],

			"UseList"=>$UseList,///사용여부리스트
			"mm_use"=>trim($dt["MM_USE"]),///약재사용여부	

			"mm_seq"=>$dt["MM_SEQ"],
			"mm_code"=>$dt["MM_CODE"],
			"mm_title_kor"=>$dt["MM_TITLE_KOR"],
			"mm_title_chn"=>$dt["MM_TITLE_CHN"],
			"mm_title_eng"=>$dt["MM_TITLE_ENG"]
		);
		
		$json["sql"]=$sql;
		$json["apiCode"]=$apiCode;
		$json["resultCode"]="200";
		$json["resultMessage"]="OK";
	}
?>