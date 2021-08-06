<?php  
	///처방하기> 처방추가 버튼 클릭시 
	$apiCode=$_GET["apiCode"];
	$language=$_GET["language"];
	$page=$_GET["page"];
	$medicalId=$_GET["medicalId"]; ///한의원
	$doctorId=$_GET["doctorId"]; ///한의사 
	$meGrade=$_GET["meGrade"]; ///한의사등급 (소속한의사인지)
	

	if($apiCode!="medicalrecipelist"){$json["resultMessage"]="API(apiCode) ERROR2";$apiCode="medicalrecipelist";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="API(language) ERROR";}
	else
	{
		$returnData=$_GET["returnData"];
		$json=array("apiCode"=>$apiCode,"returnData"=>$returnData);
		$search=$_GET["searchTxt"]; ///검색단어

		if($meGrade=="30")
		{
			$wsql=" and c.od_userid='".$medicalId."' "; ///해당 한의원의 이전처방만 보이게 작업함
		}
		else
		{
			$wsql=" and c.od_userid='".$medicalId."' and c.od_staff='".$doctorId."' "; ///해당 한의원의 소속한의사 처방만 
		}


		//최대20개까지 보여준다 
		//처방명으로 가나다순 
		$sql=" select * from (
				select ROW_NUMBER() OVER (ORDER BY rcTitle asc) NUM1  ,rcSeq , rcCode , rcTitle, rcMedicine from (
					select ROW_NUMBER() OVER (ORDER BY a.rc_title_kor asc) NUM, a.rc_seq as rcSeq, a.rc_code as rcCode, a.rc_title_kor as rcTitle, a.rc_medicine as rcMedicine 
					from han_recipeuser  a 
					inner join han_order c on a.rc_code=c.od_scription 
					where a.rc_use <>'D' and ".$wsql." 
					
					union all
					
					select ROW_NUMBER() OVER (ORDER BY a.rc_title_kor asc) NUM, a.rc_seq as rcSeq , a.rc_code as rcCode, a.rc_title_kor as rcTitle, a.rc_medicine as rcMedicine 
					from HAN_RECIPEMEDICAL  a 
					where a.rc_use <>'D' and a.RC_MEDICAL='recommend'
					
					union all
					
					select ROW_NUMBER() OVER (ORDER BY a.rc_title_kor asc) NUM, a.rc_seq as rcSeq , a.rc_code as rcCode, a.rc_title_kor as rcTitle, a.rc_medicine as rcMedicine 
					from HAN_RECIPEMEDICAL  a 
					where a.rc_use <>'D' and a.RC_MEDICAL='myrecipe' and a.RC_USERID='".$doctorId."' 
				) 
			)where NUM1>0 and NUM1<20 ";

		$res=dbqry($sql);
		$json["sql"]=$sql;
		$json["list"]=array();

		while($dt=dbarr($res))
		{
			$odMedicine=getClob($dt["RCMEDICINE"]);
			$arr=explode("|",$odMedicine);///약재갯수(약미)

			$addarray=array(
				"seq"=>$dt["RCSEQ"],
				"rcCode"=>$dt["RCCODE"],
				"rcTitle"=>$dt["RCTITLE"],///방제명 
				"odMedicineCnt"=>count($arr)-1//약미 
			);
			array_push($json["list"], $addarray);
		}
		
		$json["search"]=$search;
		$json["sql"]=$sql;
		$json["apiCode"]=$apiCode;
		$json["resultCode"]="200";
		$json["resultMessage"]="OK";
	}
?>