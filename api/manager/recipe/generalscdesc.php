<?php  
	///처방관리 > 처방관리 > 처방관리 상세보기 
	$apicode=$_GET["apiCode"];
	$language=$_GET["language"];

	if($apicode!="generalscdesc"){$json["resultMessage"]="API(apiCode) ERROR";$apicode="generalscdesc";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="API(language) ERROR";}
	else
	{
		$rc_seq=$_GET["seq"];

		if($rc_seq)
		{
			$jsql=" a left join ".$dbH."_order c on a.rc_code=c.od_scription ";
			$jsql.=" inner join ".$dbH."_medical m on c.od_userid=m.mi_userid ";
			$jsql.=" left join ".$dbH."_release r on c.od_code=r.re_odcode ";
			$jsql.=" left join ".$dbH."_decoction d on c.od_code=d.dc_odcode ";

			$sql=" select a.rc_seq rcSeq, a.rc_code rcCode, a.rc_source rcSource, a.rc_title_kor rcTitle";
			$sql.=" , a.rc_medicine  as RCMEDICINE,a.rc_sweet as RCSWEET "; 
			$sql.=" , to_char(a.rc_date,'yyyy-mm-dd') as rcDate";
			$sql.=" , c.od_status odStatus, c.od_chubcnt odChubcnt , c.od_amount, c.od_staff, c.od_packcnt, c.od_packcapa";
			//$sql.=" , DBMS_LOB.SUBSTR(c.od_advice, DBMS_LOB.GETLENGTH(c.od_advice)) as OD_ADVICE ";
			$sql.=" , c.od_advice as OD_ADVICE ";
			$sql.=" , m.mi_name miName , d.dc_title, d.dc_time, d.dc_special, d.dc_water , r.re_name";
			$sql.=" from ".$dbH."_recipeuser $jsql where a.rc_seq='".$rc_seq."' ";
			$dt=dbone($sql);
		}

		$hCodeList = getNewCodeTitle("dcTitle,dcSpecial");
		$dcTitleList = getCodeList($hCodeList, 'dcTitle');///탕전법리스트
		$dcSpecialList = getCodeList($hCodeList, 'dcSpecial');///특수탕전리스트 

		$rcMedicine = getClob($dt["RCMEDICINE"]);

		$rcMedicine = substr($rcMedicine, 1); ///한자리만 자르기 
		$rcMedicineList = getMedicine($rcMedicine);   /// 라이브러리에 있는 이 함수 보기.  getMedicine  // HD10470_01,4.0,inmain,88|HD10468_01,6,inmain,222

		//감미제 구성 
		if($dt["RCSWEET"])
		{
			$rcSweet = getClob($dt["RCSWEET"]); ///한자리만 자르기 
			$rcSweet = substr($rcSweet, 1); ///한자리만 자르기 
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
			"rcDetail"=>$dt["RCDETAIL"], 
			"rcMedicine"=>$rcMedicine, 
			"rcMedicineList"=>$rcMedicineList,  ///약재구성

			//"rcSweet"=>$dt["rcSweet"], 
			//"rcEfficacy"=>$dt["RCEFFICACY"],
			//"rcMaincure"=>$dt["RCMAINCURE"],
			//"rcTingue"=>$dt["RCTINGUE"],
			//"rcPulse"=>$dt["RCPULSE"], 
			//"rcUsage"=>$dt["RCUSAGE"], 
			//"rcStatus"=>$dt["RCSTATUS"],

			"rcDate"=>$dt["RCDATE"], 
			"miName"=>$dt["MINAME"],
			"reName"=>$dt["RE_NAME"],

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

		$json["apiCode"]=$apicode;
		$json["sql"]=$sql;
		$json["resultCode"]="200";
		$json["resultMessage"]="OK";
	}

	///처방자이름 가져오기 
	function getname($od_staff)
	{
		global $dbH;
		global $language;
		$odStaffname="";
		if($od_staff)
		{	
			$sql=" select me_name meName  from ".$dbH."_member where me_userid ='".$od_staff."' ";
			$res=dbqry($sql);

			while($hub=dbarr($res))
			{					
				$odStaffname=$hub["MENAME"];
			}						
		}
		return $odStaffname;
	}

?>
