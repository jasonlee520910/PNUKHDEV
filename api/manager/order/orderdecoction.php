<?php
	//// 주문현황>사전조제,수기처방시탕제 관련 
	$apiCode=$_GET["apiCode"];
	$language=$_GET["language"];
	$seq=$_GET["seq"];//order seq
	$medical=$_GET["medical"];//medical code 
	$rc_seq=$_GET["rc_seq"];//rc_seq
	$rc_type=$_GET["rc_type"];//rc_type

	if($apiCode!="orderdecoction"){$json["resultMessage"]="API(apiCode) ERROR";$apiCode="orderdecoction";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="API(language) ERROR";}
	else if($seq==""){$json["resultMessage"]="API(seq) ERROR";}
	else
	{

		$hCodeList = getNewCodeTitle("dcTitle,mrDesc");
		//탕전법
		$dcTitleList = getCodeList($hCodeList, 'dcTitle');///탕전법리스트
		//특수탕전
		$dcSpecialList = getSpecial();//특수탕전리스트 
		//마킹정보ㅠ 
		$mrDescList = getCodeList($hCodeList, 'mrDesc');///마킹정보리스트 
		//탕전타입 
		$decoctypeList = getDecoCodeTitle();///탕전타입
		//감미제 리스트 
		$dcSugarList=getSugar(); //

		$mrlist=getmedicinerecipe($rc_seq, $rc_type);

		$config=getConfigInfo();///공통으로 쓰이는 데이터들 (가격)

		$dcTime=80;//기본시간 

		//한의원검색
		if($medical)
		{
			$msql="select MI_GRADE from ".$dbH."_medical where MI_USERID='".$medical."' ";
			$mdt=dbone($msql);
			$mi_grade=($mdt["MI_GRADE"])?$mdt["MI_GRADE"]:"E";
		}

		if($seq == 'write')
		{
			///------------------------------------------------------------
			/// DOO :: PackCode 테이블 목록 보여주기 위한 쿼리 추가 
			///------------------------------------------------------------
			$hPackCodeList = getPackCodeTitle($medical, "odPacktype,reBoxdeli,reBoxmedi");
			$reBoxmediList = getCodeList($hPackCodeList, 'reBoxmedi');///한약박스
			$reBoxdeliList = getCodeList($hPackCodeList, 'reBoxdeli');///배송포장재종류 
			$odPacktypeList = getCodeList($hPackCodeList, 'odPacktype');///파우치

			$json=array(
				"miGrade"=>$mi_grade,
				"dcTime"=>$dcTime,

				"decoctypeList"=>$decoctypeList,///탕전타입 (선전,일반,후하 )
				"dcTitleList"=>$dcTitleList,///탕전법리스트
				"dcSpecialList"=>$dcSpecialList,///특수탕전리스트
				"dcSugarList"=>$dcSugarList,//감미제
				"mrDescList"=>$mrDescList,///마킹정보리스트
				"reBoxmediList"=>$reBoxmediList,///한약박스
				"reBoxdeliList"=>$reBoxdeliList,///배송포장재종류
				"odPacktypeList"=>$odPacktypeList///파우치
				
			);	
			$json["resultCode"]="200";
			$json["resultMessage"]="OK";

		}
		else
		{
			$ssql=" a.OD_SEQ, a.OD_CHUBCNT, a.OD_PACKCNT, a.OD_PACKCAPA, a.OD_PACKTYPE, a.OD_PACKPRICE, a.OD_USERID  ";
			$ssql.=" ,c.DC_TITLE, c.DC_SPECIAL, c.DC_WATER, c.DC_TIME, c.DC_ALCOHOL, c.DC_SUGAR, c.DC_SPECIALPRICE  ";
			$ssql.=" ,e.RE_BOXMEDI,e.RE_BOXDELI, e.RE_BOXMEDIPRICE, e.RE_BOXDELIPRICE ";
			$ssql.=" ,d.MR_DESC ";
			$ssql.=" ,m.MI_GRADE";
			$ssql.=" ,r.RC_SOURCE, r.RC_MEDICINE,  r.RC_SWEET";

			$wsql=" where a.od_seq = '".$seq."' ";
			
			$jsql.=" a inner join ".$dbH."_decoction c on a.od_code=c.dc_odcode ";
			$jsql.=" inner join ".$dbH."_release e on a.od_code=e.re_odcode ";
			$jsql.=" inner join ".$dbH."_marking d on a.od_code=d.mr_odcode ";
			$jsql.=" inner join ".$dbH."_medical m on a.od_userid=m.mi_userid ";
			$jsql.=" inner join ".$dbH."_recipeuser r on a.od_scription=r.rc_code ";

			$sql=" select ".$ssql." from ".$dbH."_order $jsql $wsql ";
			$dt=dbone($sql);

			if($medical==$dt["OD_USERID"])
			{
				$hPackCodeList = getPackCodeTitle($dt["OD_USERID"], "odPacktype,reBoxdeli,reBoxmedi");
				$reBoxmediList = getCodeList($hPackCodeList, 'reBoxmedi');///한약박스
				$reBoxdeliList = getCodeList($hPackCodeList, 'reBoxdeli');///배송포장재종류 
				$odPacktypeList = getCodeList($hPackCodeList, 'odPacktype');///파우치

				

				$sugararr=explode(",",$dt["DC_SUGAR"]);
				$dcSugarCode=$sugararr[0];
				$dcSugarName=$sugararr[1];
				$dcSugarCapa=$sugararr[2];
				$dcSugarTotalCapa=$sugararr[3];
				$dcSugarPrice=$sugararr[4];

				$dcSpecialprice=($dt["DC_SPECIALPRICE"])?$dt["DC_SPECIALPRICE"]:"";


				$json=array(
					//order
					"odChubcnt"=>$dt["OD_CHUBCNT"], 
					"odPackcnt"=>$dt["OD_PACKCNT"],
					"odPackcapa"=>$dt["OD_PACKCAPA"],
					"odPacktype"=>$dt["OD_PACKTYPE"], 
					"odPackprice"=>$dt["OD_PACKPRICE"], ///파우치가격 

					//decoction
					"dcTitle"=>$dt["DC_TITLE"],
					"dcTime"=>$dt["DC_TIME"], 
					"dcSpecial"=>$dt["DC_SPECIAL"], 
					"dcSpecialPrice"=>$dcSpecialprice,
					"dcWater"=>$dt["DC_WATER"], 
					"dcAlcohol"=>$dt["DC_ALCOHOL"],
					"dcSugarCode"=>$dcSugarCode,
					"dcSugarName"=>$dcSugarName,
					"dcSugarCapa"=>$dcSugarCapa,
					"dcSugarTotalCapa"=>$dcSugarTotalCapa,
					"dcSugarPrice"=>$dcSugarPrice,
					//release
					"reBoxmedi"=>$dt["RE_BOXMEDI"],
					"reBoxdeli"=>$dt["RE_BOXDELI"],
					"reBoxmediprice"=>$dt["RE_BOXMEDIPRICE"], ///한약박스비 
					"reBoxdeliprice"=>$dt["RE_BOXDELIPRICE"], ///배송박스비 
					//marking
					"mrDesc"=>$dt["MR_DESC"],
					//medical
					"miGrade"=>$dt["MI_GRADE"],

					//recipeuser
					"rcSource"=>$dt["RC_SOURCE"],
					"rcMedicine"=>getClob($dt["RC_MEDICINE"]), 
					"rcSweet"=>getClob($dt["RC_SWEET"]),

					"decoctypeList"=>$decoctypeList,///탕전타입 (선전,일반,후하 )
					"dcTitleList"=>$dcTitleList,///탕전법리스트
					"dcSpecialList"=>$dcSpecialList,///특수탕전리스트
					"dcSugarList"=>$dcSugarList,//감미제
					"mrDescList"=>$mrDescList,///마킹정보리스트
					"reBoxmediList"=>$reBoxmediList,///한약박스
					"reBoxdeliList"=>$reBoxdeliList,///배송포장재종류
					"odPacktypeList"=>$odPacktypeList///파우치
				);

				$json["resultCode"]="200";
				$json["resultMessage"]="OK";
			}
			else
			{

				$json=array(
					"miGrade"=>$mi_grade,
					"dcTime"=>$dcTime,
					"decoctypeList"=>$decoctypeList,///탕전타입 (선전,일반,후하 )
					"dcTitleList"=>$dcTitleList,///탕전법리스트
					"dcSpecialList"=>$dcSpecialList,///특수탕전리스트
					"dcSugarList"=>$dcSugarList,//감미제
					"mrDescList"=>$mrDescList,///마킹정보리스트
					"reBoxmediList"=>$reBoxmediList,///한약박스
					"reBoxdeliList"=>$reBoxdeliList,///배송포장재종류
					"odPacktypeList"=>$odPacktypeList///파우치
					
				);	
				$json["resultCode"]="199";
				$json["resultMessage"]="처방한 한의원이 아닙니다.";
			}
		}

		$json["config"]=$config;

		//$json["mrlist"]=$mrlist;

		if($mrlist["rcMedicine"])
		{
			$json["rcMedicine"]=$mrlist["rcMedicine"];
			$json["rcSweet"]=$mrlist["rcSweet"];
			$json["odChubcnt"]=$mrlist["rcChub"];
			$json["odPackcnt"]=$mrlist["rcPackcnt"];
			$json["odPacktype"]=$mrlist["rcPacktype"];
			$json["odPackcapa"]=$mrlist["rcPackcapa"];
			$json["reBoxmedi"]=$mrlist["rcMedibox"];
		}

		$json["sql"]=$sql;
		$json["apiCode"]=$apiCode;
		$json["returnData"]=$returnData;

	}
?>
