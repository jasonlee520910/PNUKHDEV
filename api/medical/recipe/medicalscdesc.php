<?php  
	///이전처방 상세보기
	$apiCode=$_GET["apiCode"];
	$language=$_GET["language"];
	$page=$_GET["page"];
	$rc_seq=$_GET["seq"];

	if($apiCode!="medicalscdesc"){$json["resultMessage"]="API(apiCode) ERROR2";$apiCode="medicalscdesc";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="API(language) ERROR";}
	else
	{
		$hCodeList = getNewCodeTitle("dcTitle,dcSpecial");

		$dcTitleList = getCodeList($hCodeList, 'dcTitle');//탕전법리스트
		$dcSpecialList = getCodeList($hCodeList, 'dcSpecial');//특수탕전리스트 

		if($rc_seq)
		{
			$jsql=" a left join ".$dbH."_order c on a.rc_code=c.od_scription ";
			$jsql.=" inner join ".$dbH."_medical m on c.od_userid=m.mi_userid ";
			$jsql.=" left join ".$dbH."_release r on c.od_code=r.re_odcode ";
			$jsql.=" left join ".$dbH."_decoction d on c.od_code=d.dc_odcode ";

			$sql=" select a.rc_seq as RCSEQ, a.rc_code as RCCODE, a.rc_source as RCSOURCE, a.rc_title_kor as RCTITLE,a.rc_detail_kor as RCDETAIL ";
			$sql.=" ,a.rc_medicine as RCMEDICINE, a.rc_sweet as RCSWEET, a.rc_efficacy_kor as RCEFFICACY, a.rc_maincure_kor as RCMAINCURE ";
			$sql.=" ,a.rc_tingue_kor as RCTINGUE, a.rc_pulse_kor as RCPULSE, a.rc_usage_kor as RCUSAGE, a.rc_status as RCSTATUS ";
			$sql.=" ,to_char(a.rc_date,'yyyy-mm-dd') as RCDATE ";
			$sql.=" ,m.mi_name as MINAME, r.re_name as RE_NAME ";
			$sql.=" ,c.od_chubcnt as ODCHUBCNT, c.od_amount, c.od_staff, c.od_packcnt, c.od_packcapa, c.od_advice ";
			$sql.=" ,d.dc_title, d.dc_time, d.dc_special, d.dc_water  ";
			$sql.=" from ".$dbH."_recipeuser $jsql ";
			$sql.=" where a.rc_seq='".$rc_seq."'";
			$dt=dbone($sql);

			//echo $sql;
		

			$rcMedicine=getClob($dt["RCMEDICINE"]);
			$rcSweet = getClob($dt["RCSWEET"]); ///한자리만 자르기 

			$rcMedicine = substr($rcMedicine,1); //한자리만 자르기 
			$rcMedicineList = getMedicine($rcMedicine);
			
			///감미제 구성 
			if($rcSweet)
			{
				$rcSweetList = getMedicine($rcSweet);
			}	
			else
			{
				$rcSweet="";
				$rcSweetList=null;
			}

			$json=array(
				"seq"=>$dt["RCSEQ"], 
				"rcCode"=>$dt["RCCODE"], 
				"rcSource"=>$dt["RCSOURCE"], 
				"rcTitle"=>$dt["RCTITLE"], 
				"rcDetail"=>getClob($dt["RCDETAIL"]), 
				"rcMedicine"=>$rcMedicine, 
				"rcMedicineList"=>$rcMedicineList,
				"rcEfficacy"=>getClob($dt["RCEFFICACY"]),
				"rcMaincure"=>getClob($dt["RCMAINCURE"]),
				"rcTingue"=>$dt["RCTINGUE"],
				"rcPulse"=>$dt["RCPULSE"], 
				"rcUsage"=>$dt["RCUSAGE"], 
				"rcStatus"=>$dt["RCSTATUS"],
				"rcDate"=>$dt["RCDATE"],  ///처방일
				"miName"=>$dt["MINAME"],  ///한의원
				"reName"=>$dt["RE_NAME"], ///환자명

				"rcSweet"=>$rcSweet,

				"dcTitle"=>$dt["DC_TITLE"],///탕전법 
				"dcTime"=>$dt["DC_TIME"],///탕전시간 
				"dcSpecial"=>$dt["DC_SPECIAL"],///특수탕전 
				"dcWater"=>$dt["DC_WATER"],///탕전물량

				"odAmount"=>$dt["OD_AMOUNT"],///주문금액  
				"odAdvice"=>getClob($dt["OD_ADVICE"]),///복약지도 
				"odStaff"=>$dt["OD_STAFF"],///처방자의  me_userid
				"odStaffname"=>getname($dt["OD_STAFF"]),///처방자의  me_name
				"odPackcnt"=>$dt["OD_PACKCNT"],///팩수
				"odPackcapa"=>$dt["OD_PACKCAPA"],///팩용량 

				"odChubcnt"=>$dt["ODCHUBCNT"],///첩수 
				"dcTitleList"=>$dcTitleList,///탕전법리스트
				"dcSpecialList"=>$dcSpecialList,///특수탕전리스트
				"rcSweetList"=>$rcSweetList
				);

				$json["apiCode"]=$apiCode;
				$json["sql"]=$sql;
				$json["resultCode"]="200";
				$json["resultMessage"]="OK";
		}
		else
		{
			$json["resultCode"]="199";
			$json["resultMessage"]="데이터가 없습니다.";
		}
	
	}

	///처방자이름 가져오기 
	function getname($od_staff)
	{
		global $dbH;
		global $language;
		$odStaffname="";
		if($od_staff)
		{	
			$sql=" select me_name as MENAME from ".$dbH."_member where me_userid ='".$od_staff."' ";
			$res=dbqry($sql);

			while($hub=dbarr($res))
			{					
				$odStaffname=$hub["MENAME"];
			}						
		}
		return $odStaffname;
	}
?>
