<?php
	//GET
	$apicode=$_GET["apiCode"];
	$language=$_GET["language"];
	$rc_seq=$_GET["seq"];


	if($apicode!="uniquescdesc"){$json["resultMessage"]="API(apiCode) ERROR_uniquescdesc";$apicode="uniquescdesc";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="API(language) ERROR";}
	//else if($rc_seq==""){$json["resultMessage"]="API(seq) ERROR";}
	else
	{
		//------------------------------------------------------------
		// DOO :: Code 테이블 목록 보여주기 위한 쿼리 추가 
		//------------------------------------------------------------
		$hCodeList = getNewCodeTitle("rcTingue,rcPulse,rcStatus");
		//------------------------------------------------------------
		$tingueList = getCodeList($hCodeList, 'rcTingue');//설진단리스트 
		$pulseList = getCodeList($hCodeList, 'rcPulse');//맥상리스트 
		$rcStatusList = getCodeList($hCodeList, 'rcStatus');//승인  
		$dcTypeList = getDecoCodeTitle();//탕전타입   

		if($rc_seq)
		{
			$sql=" select a.rc_seq rcSeq, a.rc_code rcCode, a.rc_source rcSource, a.rc_sourcetit rcSourcetit, a.rc_title_".$language." rcTitle,  a.rc_detail_".$language." rcDetail, a.rc_medicine rcMedicine, a.rc_sweet rcSweet, a.rc_chub rcChub, a.rc_efficacy_".$language." rcEfficacy, a.rc_maincure_".$language." rcMaincure, a.rc_tingue_".$language." rcTingue, a.rc_pulse_".$language." rcPulse, a.rc_usage_".$language." rcUsage, a.rc_base_".$language." rcBase, a.rc_desc_".$language." rcDesc, a.rc_status rcStatus, a.rc_date rcDate, b.rb_title_".$language." rbSourcetxt, b.rb_index_".$language." rbIndex, b.rb_bookno_".$language." rbBookno from ".$dbH."_recipemember a left join ".$dbH."_recipebook b on a.rc_source=b.rb_code where a.rc_seq='".$rc_seq."'";
			$dt=dbone($sql);

			if($dt["rb_seq"]){
				$sourceTxt=$dt["rbSourcetxt"];
				$sourceIndex=$dt["rbIndex"];
			}else{
				$sourceTxt=$dt["rcSource"];
				$sourceIndex=$dt["rcSourcetit"];
			}

			//------------------------------------------------------------
			// DOO :: 약재정보 이름으로 보여지기 위한 쿼리 추가 
			//------------------------------------------------------------
			$rcMedicine = $dt["rcMedicine"];//substr($dt["rcMedicine"], 1); //한자리만 자르기 
			$rcMedicine = str_replace(" ", "", $rcMedicine);//빈공간있으면 일단은 삭제
			$rcMedicineList = getMedicine($rcMedicine);
			//------------------------------------------------------------

			$json = array(
				"seq"=>$dt["rcSeq"], 
				"rcCode"=>$dt["rcCode"], 
				"rcSource"=>$dt["rcSource"], 
				"rcTitle"=>$dt["rcTitle"], 
				"rcDetail"=>$dt["rcDetail"], 
				"rcSweet"=>$dt["rcSweet"], 
				"rcChub"=>$dt["rcChub"], 
				"rcMedicine"=>$rcMedicine,  
				"rcMedicineList"=>$rcMedicineList,
				//"rbSourcetxt"=>$sourceTxt, //
				"rbIndex"=>$sourceIndex, //
				"tingueList"=>$tingueList,
				"pulseList"=>$pulseList,
				"rcStatusList"=>$rcStatusList,
				"dcTypeList"=>$dcTypeList,
				"rcEfficacy"=>$dt["rcEfficacy"], 
				"rcMaincure"=>$dt["rcMaincure"], 
				"rcTingue"=>$dt["rcTingue"], 
				"rcPulse"=>$dt["rcPulse"], 
				"rcUsage"=>$dt["rcUsage"], 
				"rcBase"=>$dt["rcBase"], 
				"rcDesc"=>$dt["rcDesc"], 
				"rcStatus"=>$dt["rcStatus"], 
				"rbSourcetxt"=>$dt["rbSourcetxt"],  //출처/처방서적
				//"rbIndex"=>$dt["rbIndex"], 
				"rbBookno"=>$dt["rbBookno"], 
				"rcDate"=>$dt["rcDate"]
				);
		}
		else
		{

			$json = array(
				"rbSourcetxt"=>$sourceTxt, 
				"rbIndex"=>$sourceIndex, 
				"tingueList"=>$tingueList,
				"pulseList"=>$pulseList,
				"rcStatusList"=>$rcStatusList,
				"dcTypeList"=>$dcTypeList
				);
		}


		$json["apiCode"]=$apicode;
		$json["sql"]=$sql;
		$json["resultCode"]="200";
		$json["resultMessage"]="OK";
	}
?>
