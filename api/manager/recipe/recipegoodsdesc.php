<?php  
	///처방관리 > 약속처방 > 약속처방 상세보기
	$apicode=$_GET["apiCode"];
	$language=$_GET["language"];
	$rc_seq=$_GET["seq"];

	if($apicode!="recipegoodsdesc"){$json["resultMessage"]="API(apiCode) ERROR_uniquescdesc";$apicode="recipegoodsdesc";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="API(language) ERROR";}
	else
	{
		$hCodeList = getNewCodeTitle("rcStatus");
		$rcStatusList = getCodeList($hCodeList, 'rcStatus');///승인 
		
		///파우치, 한약박스만 가져오기 
		$hPackCodeList = getPackCodeTitle('', "odPacktype,reBoxmedi");
		$reBoxmediList = getCodeList($hPackCodeList, 'reBoxmedi');///한약박스
		$odPacktypeList = getCodeList($hPackCodeList, 'odPacktype');///파우치

		if($rc_seq)
		{
			$sql=" select ";
			$sql.=" a.rc_seq, a.rc_code, a.rc_title_".$language." as rcTitle ";
			//$sql.=", DBMS_LOB.SUBSTR(a.rc_medicine, DBMS_LOB.GETLENGTH(a.rc_medicine)) as RCMEDICINE ";
			//$sql.=", DBMS_LOB.SUBSTR(a.rc_sweet, DBMS_LOB.GETLENGTH(a.rc_sweet)) as RCSWEET ";
			$sql.=", a.rc_medicine  ";
			$sql.=", a.rc_sweet";
			$sql.=" ,a.rc_chub, a.rc_packcnt, a.rc_packtype, a.rc_packcapa, a.rc_medibox ";
			$sql.=" ,a.rc_status, a.rc_date ";
			$sql.=" from ".$dbH."_recipemedical a ";
			$sql.=" where a.rc_seq='".$rc_seq."' ";
			$dt=dbone($sql);

			$rcMedicine = getClob($dt["RC_MEDICINE"]);///빈공간있으면 일단은 삭제
			$rcMedicine = trim($rcMedicine);///빈공간있으면 일단은 삭제
			$rcMedicineList = getMedicine($rcMedicine);

			$json = array(
				"seq"=>$dt["RC_SEQ"], 
				"rcCode"=>$dt["RC_CODE"], 
				"rcTitle"=>$dt["RCTITLE"], 
				"rcSweet"=>getClob($dt["RC_SWEET"]), 
				"rcChub"=>$dt["RC_CHUB"], 

				///팩수, 팩용량, 파우치, 한약박스 
				"rcPackcnt"=>$dt["RC_PACKCNT"], 
				"rcPacktype"=>$dt["RC_PACKTYPE"], 
				"rcPackcapa"=>$dt["RC_PACKCAPA"], 
				"rcMedibox"=>$dt["RC_MEDIBOX"],

				"RCMEDICINE"=>$dt["RCMEDICINE"],

				///파우치리스트, 한약박스 리스트 
				"odPacktypeList"=>$odPacktypeList,  
				"reBoxmediList"=>$reBoxmediList,  

				"rcMedicine"=>$rcMedicine,  
				"rcMedicineList"=>$rcMedicineList,
				"rcStatusList"=>$rcStatusList,///승인,미승인 

				"rcStatus"=>$dt["RC_STATUS"], 
				"rcDate"=>$dt["RC_DATE"]
				);				
		}
		else
		{
			$json = array(
				/// 파우치리스트, 한약박스 리스트 
				"odPacktypeList"=>$odPacktypeList,  
				"reBoxmediList"=>$reBoxmediList,  
				"rcStatusList"=>$rcStatusList
				);
		}

		$json["apiCode"]=$apicode;
		$json["sql"]=$sql;
		$json["resultCode"]="200";
		$json["resultMessage"]="OK";
	}
?>
