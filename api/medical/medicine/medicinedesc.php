<?php  
	///약재목록상세
	$apiCode=$_GET["apiCode"];
	$language=$_GET["language"];
	$md_seq=$_GET["seq"];
	$miGrade=($_GET["miGrade"])?$_GET["miGrade"]:"E";

	if($apiCode!="medicinedesc"){$json["resultMessage"]="API코드오류";$apiCode="medicinedesc";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="언어코드오류";}
	///else if($md_seq==""){$json["resultMessage"]="seq 없음";}
	else
	{
		if($md_seq)
		{
			/*
			$jsql=" a inner join ".$dbH."_medihub b on a.md_hub=b.mh_code ";
			$jsql.=" inner join ".$dbH."_code c on c.cd_code = a.md_status  ";
			$jsql.=" inner join ".$dbH."_medicine_djmedi d on d.md_code=a.md_code and d.mm_use='Y'  ";
			$jsql.=" left join han_file f on b.mh_code=f.af_fcode and f.af_code='medihub' and f.af_use='Y' ";
			 
			$sql1=" select f.af_url as AFURL";
			//$sql1.=" ,c.cd_name_kor as CDNAME, a.md_code ";
			$sql1.=" ,d.mm_title_kor as MDTITLE ";
			$sql1.=" ,b.mh_title_kor as MHTITLE,b.mh_stitle_kor as MHSTITLE,b.mh_dtitle_kor as MHDTITLE ";
			$sql1.=" ,b.mh_ctitle_kor as MHCTITLE ";
			$sql1.=" ,b.mh_desc_kor as MHDESC,b.mh_usage_kor as MHUSAGE ";
			$sql1.=" ,b.mh_caution_kor as MHCAUTION ";
			$sql1.=" ,b.mh_state,b.mh_taste,b.mh_object,b.mh_poison,b.mh_code ";
			$sql1.=" ,a.md_code MDCODE,a.md_origin_kor as MDORIGIN,a.md_maker_kor as MDMAKER, a.md_price as MDPRICE , a.md_status as MDSTATUS";
			$sql1.=" from ".$dbH."_medicine ";
			$sql1.=" $jsql where  c.cd_type='mdStatus' and a.md_seq='".$md_seq."' ";
			*/

			//쿼리 수정한거
			$sql1=" select ";
			$sql1.=" a.md_code MDCODE,a.md_origin_kor as MDORIGIN,a.md_maker_kor as MDMAKER, a.MD_PRICEA, a.MD_PRICEB, a.MD_PRICEC, a.MD_PRICED, a.MD_PRICEE , a.md_status as MDSTATUS,a.md_seq ";
			$sql1.=" ,b.mh_title_kor as MHTITLE";
			$sql1.=" ,to_char(b.mh_stitle_kor) as MHSTITLE "; 
			$sql1.=" ,to_char(b.mh_dtitle_kor) as MHDTITLE "; 
			$sql1.=" ,to_char(b.mh_ctitle_kor) as MHCTITLE "; 
			$sql1.=" ,to_char(b.mh_desc_kor) as MHDESC ";
			$sql1.=" ,to_char(b.mh_usage_kor) as MHUSAGE ";
			$sql1.=" ,to_char(b.mh_caution_kor) as MHCAUTION ";
			$sql1.=" ,b.mh_state,b.mh_taste,b.mh_object,b.mh_poison,b.mh_code";	
			$sql1.=" ,d.mm_title_kor as MDTITLE  "; 
			$sql1.=" from ".$dbH."_medicine a ";
			$sql1.=" inner join ".$dbH."_medihub b on a.md_hub=b.mh_code ";
			$sql1.=" inner join ".$dbH."_medicine_djmedi d on d.md_code=a.md_code and d.mm_use='Y' where a.md_seq='".$md_seq."' ";

			$json["sql"]=$sql1;

			$dt=dbone($sql1);
			$mdPrice=$dt["MD_PRICE".$miGrade];

			$json = array(
				"seq"=>$dt["MD_SEQ"],
				"mdTitle"=>$dt["MDTITLE"],
				"mdCode"=>$dt["MDCODE"],
				"mdOrigin"=>$dt["MDORIGIN"],
				"mdPrice"=>$mdPrice

				//mediCapa는 안보내면 받는쪽에서 0으로 처리함


			);


		}

		$json["apiCode"]=$apiCode;
		$json["resultCode"]="200";
		$json["resultMessage"]="OK";
	}
?>