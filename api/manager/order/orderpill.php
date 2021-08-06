<?php
	//// 주문현황>주문리스트>상세 
	$apiCode=$_GET["apiCode"];
	$language=$_GET["language"];
	$seq=$_GET["seq"];//order seq
	$medical=$_GET["medical"];//medical code 
	$rc_seq=$_GET["rc_seq"];//rc_seq
	$rc_type=$_GET["rc_type"];//rc_type

	$pilltotalcapa=($_GET["pilltotalcapa"])?$_GET["pilltotalcapa"]:0;//처방량 10g*100개=1000

	if($apiCode!="orderpill"){$json["resultMessage"]="API(apiCode) ERROR1";$apiCode="orderpill";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="API(language) ERROR";}
	else if($seq==""){$json["resultMessage"]="API(seq) ERROR";}
	else
	{
		$hCodeList = getNewCodeTitle("pillShape,pillBinders,pillFineness,pillRipen,pillRatio,pillTime,pillTemperature,dcTitle,dcSpecial,pillJuice");

		//pillRatio 농축비율 
		//pillTime 농축시간 
		//pillTemperature 중탕온도 


		///제형
		$pillShapeList = getCodeList($hCodeList, 'pillShape');
		///결합제 dcBinders
		$pillBindersList = getCodeList($hCodeList, 'pillBinders');///결합제
		///분말도 dcFineness
		$pillFinenessList = getCodeList($hCodeList, 'pillFineness');///분말도
		///숙성시간 
		$pillRipenList=getCodeList($hCodeList, 'pillRipen');///숙성시간 

		///농축비율 
		$pillRatioList=getCodeList($hCodeList, 'pillRatio');///숙성시간 
		///농축시간 
		$pillTimeList=getCodeList($hCodeList, 'pillTime');///숙성시간 
		///중탕온도 
		$pillTemperatureList=getCodeList($hCodeList, 'pillTemperature');///숙성시간 
		///착즙유무 
		$pillJuiceList=getCodeList($hCodeList, 'pillJuice');///착즙유무  
		


		//탕전법
		$dcTitleList = getCodeList($hCodeList, 'dcTitle');///탕전법리스트
		//특수탕전
		$dcSpecialList = getSpecial();///특수탕전리스트 
		//탕전타입 
		$decoctypeList = getDecoCodeTitle();///탕전타입

		$dcTime=240;//제환에서 탕전시간을 4시간이 기본




		//한의원검색
		if($medical)
		{
			$msql="select MI_GRADE from ".$dbH."_medical where MI_USERID='".$medical."' ";
			$mdt=dbone($msql);
			$mi_grade=($mdt["MI_GRADE"])?$mdt["MI_GRADE"]:"E";
		}

		if($seq == 'write')
		{
			$mrlist=getmedicinerecipe($rc_seq, $rc_type);
			$dcWater=$mrlist["dcWater"];

			$json=array(
				"miGrade"=>$mi_grade,
			
				//탕전
				"plDctitle"=>$mrlist["pilllist"]["decoction"][0]["plDctitle"],//탕전법
				"plDcspecial"=>$mrlist["pilllist"]["decoction"][0]["plDcspecial"],//특수탕전
				"plDctime"=>$mrlist["pilllist"]["decoction"][0]["plDctime"],//탕제시간
				"plDcwater"=>$mrlist["pilllist"]["decoction"][0]["plDcwater"],//탕전물량
				"plDcalcohol"=>$dt["PL_DCALCOHOL"],//알콜

				//분쇄
				"plFineness"=>$mrlist["pilllist"]["smash"][0]["plFineness"],//분말도
				"plMillingloss"=>$mrlist["pilllist"]["smash"][0]["plMillingloss"],//제분손실

				//농축
				"plConcentratio"=>$mrlist["pilllist"]["concent"][0]["plConcentratio"],//농축비율
				"plConcenttime"=>$mrlist["pilllist"]["concent"][0]["plConcenttime"],//농축시간

				//혼합
				"plBinders"=>$mrlist["pilllist"]["mixed"][0]["plBinders"],//결합제
				"plBindersliang"=>$mrlist["pilllist"]["mixed"][0]["plBindersliang"],//결합제량

				//중탕
				"plWarmuptemperature"=>$mrlist["pilllist"]["warmup"][0]["plWarmuptemperature"],//중탕온도
				"plWarmuptime"=>$mrlist["pilllist"]["warmup"][0]["plWarmuptime"],//중탕시간

				//숙성
				"plFermenttemperature"=>$mrlist["pilllist"]["ferment"][0]["plFermenttemperature"],//숙성온도
				"plFermenttime"=>$mrlist["pilllist"]["ferment"][0]["plFermenttime"],//숙성시간

				//제형
				"plShape"=>$mrlist["pilllist"]["plasty"][0]["plShape"],//제형
				"plLosspill"=>$mrlist["pilllist"]["plasty"][0]["plLosspill"],//제환손실

				//건조 
				"plDrytemperature"=>$mrlist["pilllist"]["dry"][0]["plDrytemperature"],//건조온도
				"plDrytime"=>$mrlist["pilllist"]["dry"][0]["plDrytime"],//건조시간

				//착즙 
				"plJuice"=>$mrlist["pilllist"]["juice"][0]["plJuice"],//착즙유무 


				"pillRatioList"=>$pillRatioList,///농축비율
				"pillTimeList"=>$pillTimeList,///농축시간
				"pillJuiceList"=>$pillJuiceList,//착즙유무
				"pillTemperatureList"=>$pillTemperatureList,///중탕온도
				"decoctypeList"=>$decoctypeList,///탕전타입 (선전,일반,후하 )
				"dcTitleList"=>$dcTitleList,///탕전법리스트
				"dcSpecialList"=>$dcSpecialList,///특수탕전리스트
				"pillShapeList"=>$pillShapeList,///제형
				"pillBindersList"=>$pillBindersList,///결합제
				"pillFinenessList"=>$pillFinenessList,///분말도
				"pillRipenList"=>$pillRipenList///숙성리스트 
			);	

			$json["resultCode"]="200";
			$json["resultMessage"]="OK";
		}
		else
		{
			$ssql=" a.OD_SEQ, a.OD_USERID, a.OD_PILLCAPA, a.OD_QTY  ";
			$ssql.=" ,c.DC_TITLE, c.DC_SPECIAL, c.DC_WATER, c.DC_TIME, c.DC_ALCOHOL  ";
			$ssql.=" ,m.MI_GRADE";
			$ssql.=" ,r.RC_SOURCE, r.RC_MEDICINE,  r.RC_SWEET, r.RC_PILLORDER ";
			$ssql.=" ,p.PL_DCTITLE,p.PL_DCSPECIAL,p.PL_DCTIME,p.PL_DCWATER,p.PL_FINENESS,p.PL_MILLINGLOSS,p.PL_CONCENTRATIO,p.PL_CONCENTTIME,p.PL_BINDERS ";
			$ssql.=" ,p.PL_BINDERSLIANG,p.PL_WARMUPTEMPERATURE,p.PL_WARMUPTIME,p.PL_FERMENTTEMPERATURE,p.PL_FERMENTTIME,p.PL_SHAPE,p.PL_DRYTEMPERATURE ";
			$ssql.=" ,p.PL_DRYTIME,p.PL_LOSSPILL,p.PL_DCALCOHOL, p.PL_JUICE ";
			$wsql=" where a.od_seq = '".$seq."' ";
			
			$jsql.=" a inner join ".$dbH."_decoction c on a.od_code=c.dc_odcode ";
			$jsql.=" inner join ".$dbH."_medical m on a.od_userid=m.mi_userid ";
			$jsql.=" inner join ".$dbH."_recipeuser r on a.od_scription=r.rc_code ";
			$jsql.=" inner join ".$dbH."_pill p on p.PL_ODCODE=a.OD_CODE ";

			$sql=" select ".$ssql." from ".$dbH."_order $jsql $wsql ";
			$dt=dbone($sql);

			$mrlist=getPillorderData(getClob($dt["RC_PILLORDER"]));
			$dcWater=$mrlist["dcWater"];

			if($medical==$dt["OD_USERID"])
			{
				$json=array(
					//order
					"odPillcapa"=>$dt["OD_PILLCAPA"], 
					"odQty"=>$dt["OD_QTY"], 

					//medical
					"miGrade"=>$mi_grade,

					//decoction
					"dcAlcohol"=>$dt["DC_ALCOHOL"],

					//recipeuser
					"rcSource"=>$dt["RC_SOURCE"],
					"rcMedicine"=>getClob($dt["RC_MEDICINE"]), 
					"rcSweet"=>getClob($dt["RC_SWEET"]),

					//탕전
					"plDctitle"=>$mrlist["pilllist"]["decoction"][0]["plDctitle"],//탕전법
					"plDcspecial"=>$mrlist["pilllist"]["decoction"][0]["plDcspecial"],//특수탕전
					"plDctime"=>$mrlist["pilllist"]["decoction"][0]["plDctime"],//탕제시간
					"plDcwater"=>$mrlist["pilllist"]["decoction"][0]["plDcwater"],//탕전물량
					"plDcalcohol"=>$dt["PL_DCALCOHOL"],//알콜

					//분쇄
					"plFineness"=>$mrlist["pilllist"]["smash"][0]["plFineness"],//분말도
					"plMillingloss"=>$mrlist["pilllist"]["smash"][0]["plMillingloss"],//제분손실

					//농축
					"plConcentratio"=>$mrlist["pilllist"]["concent"][0]["plConcentratio"],//농축비율
					"plConcenttime"=>$mrlist["pilllist"]["concent"][0]["plConcenttime"],//농축시간

					//혼합
					"plBinders"=>$mrlist["pilllist"]["mixed"][0]["plBinders"],//결합제
					"plBindersliang"=>$mrlist["pilllist"]["mixed"][0]["plBindersliang"],//결합제량

					//중탕
					"plWarmuptemperature"=>$mrlist["pilllist"]["warmup"][0]["plWarmuptemperature"],//중탕온도
					"plWarmuptime"=>$mrlist["pilllist"]["warmup"][0]["plWarmuptime"],//중탕시간

					//숙성
					"plFermenttemperature"=>$mrlist["pilllist"]["ferment"][0]["plFermenttemperature"],//숙성온도
					"plFermenttime"=>$mrlist["pilllist"]["ferment"][0]["plFermenttime"],//숙성시간

					//제형
					"plShape"=>$mrlist["pilllist"]["plasty"][0]["plShape"],//제형
					"plLosspill"=>$mrlist["pilllist"]["plasty"][0]["plLosspill"],//제환손실

					//건조 
					"plDrytemperature"=>$mrlist["pilllist"]["dry"][0]["plDrytemperature"],//건조온도
					"plDrytime"=>$mrlist["pilllist"]["dry"][0]["plDrytime"],//건조시간

					//착즙 
					"plJuice"=>$mrlist["pilllist"]["juice"][0]["plJuice"],//착즙유무 

					"pillRatioList"=>$pillRatioList,///농축비율
					"pillTimeList"=>$pillTimeList,///농축시간
					"pillJuiceList"=>$pillJuiceList,//착즙유무
					"pillTemperatureList"=>$pillTemperatureList,///중탕온도
					"decoctypeList"=>$decoctypeList,///탕전타입 (선전,일반,후하 )
					"dcTitleList"=>$dcTitleList,///탕전법리스트
					"dcSpecialList"=>$dcSpecialList,///특수탕전리스트
					"pillShapeList"=>$pillShapeList,///제형
					"pillBindersList"=>$pillBindersList,///결합제
					"pillFinenessList"=>$pillFinenessList,///분말도
					"pillRipenList"=>$pillRipenList///숙성리스트 
					
				);	
				$json["resultCode"]="200";
				$json["resultMessage"]="OK";
			}
			else
			{
				$mrlist=getmedicinerecipe($rc_seq, $rc_type);
				$dcWater=$mrlist["dcWater"];

				$json=array(
					"miGrade"=>$mi_grade,
					"dcTime"=>$dcTime,
					"dcWater"=>$dcWater,
					"pillRatioList"=>$pillRatioList,///농축비율
					"pillTimeList"=>$pillTimeList,///농축시간
					"pillJuiceList"=>$pillJuiceList,//착즙유무
					"pillTemperatureList"=>$pillTemperatureList,///중탕온도
					"decoctypeList"=>$decoctypeList,///탕전타입 (선전,일반,후하 )
					"dcTitleList"=>$dcTitleList,///탕전법리스트
					"dcSpecialList"=>$dcSpecialList,///특수탕전리스트
					"pillShapeList"=>$pillShapeList,///제형
					"pillBindersList"=>$pillBindersList,///결합제
					"pillFinenessList"=>$pillFinenessList,///분말도
					"pillRipenList"=>$pillRipenList///숙성리스트 
					
				);	
				$json["resultCode"]="199";
				$json["resultMessage"]="처방한 한의원이 아닙니다.";
			}


		}

		$json["mrlist"]=$mrlist;

		$json["pilltotalcapa"]=$pilltotalcapa;

		$json["sql"]=$sql;
		$json["apiCode"]=$apiCode;
		$json["returnData"]=$returnData;

	}
?>
