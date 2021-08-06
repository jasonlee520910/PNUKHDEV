<?php  
	///약재관리 > 본초관리 > 본초관리 등록&수정
	$apiCode=$_POST["apiCode"];
	$language=$_POST["language"];
	if($apiCode!="hubupdate"){$json["resultMessage"]="API(apiCode) ERROR";$apiCode="hubupdate";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="API(language) ERROR";}
	else
	{
		$mh_seq=$_POST["seq"];
		$mh_code=$_POST["mhCode"];

		$mh_poison=$_POST["mhPoison"];
		$mh_title_kor=$_POST["mhTitlekor"];
		$mh_title_chn=$_POST["mhTitlechn"];
		$mh_dtitle_kor=$_POST["mhDtitlekor"];
		$mh_dtitle_chn=$_POST["mhDtitlechn"];
		$mh_category1=$_POST["mhCategory1"];
		$mh_category2=$_POST["mhCategory2"];
		$mh_state=$_POST["mhState"]; //성
		$mh_taste=$_POST["mhTaste"];  //미
		$mh_object=$_POST["mhObject"]; //귀경

		$mh_desc_kor=$_POST["mhDesckor"];
		$mh_desc_chn=$_POST["mhDescchn"];
		$mh_caution_kor=$_POST["mhCautionkor"];
		$mh_caution_chn=$_POST["mhCautionchn"];
		$mh_usage_kor=$_POST["mhUsagekor"];
		$mh_usage_chn=$_POST["mhUsagechn"];
		$mh_efficacy_kor=$_POST["mhEfficacykor"];
		$mh_efficacy_chn=$_POST["mhEfficacychn"];
	
		$mh_stitle_kor=$_POST["mhStitlekor"];//학명
		$mh_stitle_chn=$_POST["mhStitlechn"];//학명
		$mh_ctitle_kor=$_POST["mhCtitlekor"];//과명
		$mh_ctitle_chn=$_POST["mhCtitlechn"];//과명

		///카테고리 1,2 insert update할때 한글이랑 중문 같이 수정됨
		///성미귀경중독 사상 kor chn 모두 같이 insert update  하기 
		if($mh_seq)
		{
			$sql=" update ".$dbH."_medihub set mh_title_kor ='".$mh_title_kor."' , mh_title_chn ='".$mh_title_chn."' , mh_dtitle_kor ='".$mh_dtitle_kor."' , mh_dtitle_chn ='".$mh_dtitle_chn."' ,mh_category1 ='".$mh_category1."' ,mh_category2 ='".$mh_category1.$mh_category2."' ,mh_state='".$mh_state."' ,mh_taste='".$mh_taste."' ,mh_object ='".$mh_object."' ,mh_poison ='".$mh_poison."', mh_desc_kor ='".$mh_desc_kor."' ,mh_desc_chn ='".$mh_desc_chn."'  ,mh_caution_kor ='".$mh_caution_kor."' ,mh_caution_chn ='".$mh_caution_chn."' ,mh_usage_kor ='".$mh_usage_kor."' ,mh_usage_chn ='".$mh_usage_chn."' ,mh_efficacy_kor ='".$mh_efficacy_kor."' ,mh_efficacy_chn ='".$mh_efficacy_chn."' ,mh_stitle_kor ='".$mh_stitle_kor."',mh_stitle_chn ='".$mh_stitle_chn."',mh_ctitle_kor ='".$mh_ctitle_kor."' ,mh_ctitle_chn ='".$mh_ctitle_chn."' , mh_modify=SYSDATE where mh_seq='".$mh_seq."'";
			dbcommit($sql);		

			$sql=" update ".$dbH."_medi_poison set po_code='".$mh_poison."', po_use='Y'  where  po_medicine='".$mh_code."' ";
			dbcommit($sql);

		}
		else  ///신규입력
		{
			///본초코드 조회
			$sql3="  select MAX(substr(mh_code, 3))+1 as NEWCODE from han_medihub order by mh_seq desc  ";
			$dt=dbone($sql3);

			$newcode=$dt["NEWCODE"];
			$newcodelen=strlen($newcode);
			
			if($newcodelen=="3")
			{
				$newcode=str_pad($newcode, 4, "0", STR_PAD_LEFT);  //3자리일경우 천의자리수 0으로 채우기
			}

			$mh_code="HB".$newcode;	

			$sql4=" insert into ".$dbH."_medihub (mh_seq,mh_type, mh_code, mh_title_kor, mh_title_chn, mh_category1, mh_category2,mh_dtitle_kor,mh_dtitle_chn,mh_state, mh_taste, mh_object,mh_poison,mh_desc_kor, mh_desc_chn,mh_caution_kor,mh_caution_chn,mh_usage_kor,mh_usage_chn,mh_efficacy_kor,mh_efficacy_chn, mh_stitle_kor, mh_stitle_chn,mh_ctitle_kor, mh_ctitle_chn, mh_date) 
			values ((SELECT NVL(MAX(mh_seq),0)+1 FROM ".$dbH."_medihub), 'medicine','".$mh_code."', '".$mh_title_kor."', '".$mh_title_chn."', '".$mh_category1."','".$mh_category1.$mh_category2."','".$mh_dtitle_kor."','".$mh_dtitle_chn."','".$mh_state."','".$mh_taste."','".$mh_object."'
			,'".$mh_poison."','".$mh_desc_kor."','".$mh_desc_chn."','".$mh_caution_kor."','".$mh_caution_chn."','".$mh_usage_kor."','".$mh_usage_chn."','".$mh_efficacy_kor."','".$mh_efficacy_chn."','".$mh_stitle_kor."','".$mh_stitle_chn."','".$mh_ctitle_kor."','".$mh_ctitle_chn."',SYSDATE) ";
			dbcommit($sql4);

			$sql5=" insert into ".$dbH."_medi_poison (po_seq, po_code, po_medicine, po_date, po_use) values ((SELECT NVL(MAX(po_seq),0)+1 FROM ".$dbH."_medi_poison),'".$mh_poison."', '".$mh_code."',SYSDATE,'Y') ";
			dbcommit($sql5);	

		}
			$returnData=$_POST["returnData"];
			$json=array("apiCode"=>$apiCode,"seq"=>$seq,"returnData"=>$returnData);
			$json["sql"]=$sql;
			$json["sql3"]=$sql3;
			$json["sql4"]=$sql4;
			$json["sql5"]=$sql5;
			$json["resultCode"]="200";
			$json["resultMessage"]="OK";
			
	}

?>
