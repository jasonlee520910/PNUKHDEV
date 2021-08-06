<?php  
	/// 나의처방 상세 
	$apiCode=$_GET["apiCode"];
	$language=$_GET["language"];
	$rc_seq=$_GET["seq"];

	if($apiCode!="mediuniqscdesc"){$json["resultMessage"]="API(apiCode) ERROR2";$apiCode="mediuniqscdesc";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="API(language) ERROR";}
	else
	{
		$hCodeList = getNewCodeTitle("rcTingue,rcPulse");

		$tingueList = getCodeList($hCodeList, 'rcTingue');///설진단리스트 
		$pulseList = getCodeList($hCodeList, 'rcPulse');///맥상리스트 
		///$rcStatusList = getCodeList($hCodeList, 'rcStatus');///승인  
		$decoctypeList = getDecoCodeTitle();///탕전타입   

		if($rc_seq)
		{
			$sql=" select a.rc_seq rcSeq, a.rc_sourcetit, a.rc_code rcCode, a.rc_source rcSource, a.rc_nevel_chn rcSourcetit ";
			$sql.=" ,a.rc_title_kor rcTitle,  a.rc_detail_kor rcDetail, a.rc_medicine rcMedicine, a.rc_sweet rcSweet, a.rc_chub rcChub ";
			$sql.=" ,a.rc_efficacy_kor rcEfficacy, a.rc_maincure_kor rcMaincure, a.rc_tingue_kor rcTingue, a.rc_pulse_kor rcPulse ";
			$sql.=" ,a.rc_usage_kor rcUsage, a.rc_base_kor rcBase, a.rc_desc_kor rcDesc, a.rc_status rcStatus ";
			$sql.=" ,to_char(a.rc_date,'yyyy-mm-dd') as RCDATE ";
			$sql.=" from ".$dbH."_recipemember a ";
			$sql.=" where a.rc_seq='".$rc_seq."' ";
/*
select a.rc_seq rcSeq, a.rc_sourcetit, a.rc_code rcCode, a.rc_source rcSource, a.rc_nevel_chn rcSourcetit, a.rc_title_kor rcTitle
,  a.rc_detail_kor rcDetail, a.rc_medicine rcMedicine, a.rc_sweet rcSweet, a.rc_chub rcChub, a.rc_efficacy_kor rcEfficacy
, a.rc_maincure_kor rcMaincure, a.rc_tingue_kor rcTingue, a.rc_pulse_kor rcPulse, a.rc_usage_kor rcUsage, a.rc_base_kor rcBase, a.rc_desc_kor rcDesc
, a.rc_status rcStatus, a.rc_date rcDate 
from han_recipemember a  
where a.rc_seq='3655' 

*/



			$dt=dbone($sql);

			$rcMedicine = getClob($dt["RCMEDICINE"]);///substr($dt["rcMedicine"], 1); ///한자리만 자르기 
			$rcMedicine = str_replace(" ", "", $rcMedicine);///빈공간있으면 일단은 삭제
			$rcMedicineList = getMedicine($rcMedicine);

			if($dt["RCCHUB"]) {$rcChub = $dt["RCCHUB"];}else{$rcChub="";}
			$index= explode(",",$dt["RC_SOURCETIT"]);
			$json = array(
				"seq"=>$dt["RCSEQ"],
				"rbSourcetxt"=>$index[0], ///출처/처방서적
				"rcSourcetit"=>$index[1], ///목차번호			
				"rcCode"=>$dt["RCCODE"], ///rccode			
				"rcTitle"=>$dt["RCTITLE"],  ///처방명
				"rcChub"=>$rcChub, ///첩수
				"rcEfficacy"=>getClob($dt["RCEFFICACY"]),  ///효능/주치
				"rcMaincure"=>getClob($dt["RCMAINCURE"]), ///주치
				"rcUsage"=>getClob($dt["RCUSAGE"]),  ///복용법/효과
				"rcDetail"=>getClob($dt["RCDETAIL"]), ///상세
				///"rcTingue"=>$dt["rcTingue"],///설진단 
				///"rcPulse"=>$dt["rcPulse"], ///맥상

				"tingueList"=>$tingueList, ///설진단리스트
				"pulseList"=>$pulseList,///맥상리스트
				"selDecoctype"=>$decoctypeList, ///탕전타입   
			
				"rcSource"=>$dt["RCSOURCE"], 
				"rcSweet"=>$dt["RCSWEET"], 
				
				"rcMedicine"=>$rcMedicine,  
				"rcMedicineList"=>$rcMedicineList, ///약재리스트
				///"rbSourcetxt"=>$sourceTxt, 
				///"rbIndex"=>$sourceIndex, 
				///"rbIndex"=>$dt["rbIndex"], 
				"rcDate"=>$dt["RCDATE"]
				);
		}

		$json["search"]=$search;
		$json["sql"]=$sql;
		$json["apiCode"]=$apiCode;
		$json["resultCode"]="200";
		$json["resultMessage"]="OK";
	}
?>