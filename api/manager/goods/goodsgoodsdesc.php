<?php  
	/// 제품재고관리 > 제품목록 > 상세보기
	$apiCode=$_GET["apiCode"];
	$language=$_GET["language"];
	$gd_seq=$_GET["seq"];

	if($apiCode!="goodsgoodsdesc"){$json["resultMessage"]="API(apiCode) ERROR";$apiCode="goodsgoodsdesc";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="API(language) ERROR";}
	//else if($gd_seq==""){$json["resultMessage"]="API(seq) ERROR";}
	else
	{
		$returnData=$_GET["returnData"];

		$hCodeList = getNewCodeTitle("gdType,gdCategory,approvalUse,pillShape,pillBinders,pillFineness,pillRipen,pillRatio,pillTime,pillTemperature,pillJuice,dcTitle,pillOrder,gdLossType");
		///------------------------------------------------------------
		$gdTypeList = getCodeList($hCodeList, 'gdType');//제품등록
		$UseList = getCodeList($hCodeList, 'approvalUse');  //YN 리스트
		$gdCategoryList = getCodeList($hCodeList, 'gdCategory');  //반제품의 상세분류


		///로스타입 
		$gdLossTypeList = getCodeList($hCodeList, 'gdLossType');
		///제환순서 
		$pillOrderList = getCodeList($hCodeList, 'pillOrder');

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
		$plMillingloss=200;//제분손실
		$pillLosspill=200;//제형손실




		if($gd_seq)
		{
			$sql3=" select GD_SEQ,GD_BOMCODE,GD_RECIPE,GD_USE,GD_TYPE,GD_CATEGORY,GD_STABLE,GD_LOSS ,GD_LOSSCAPA,GD_CAPA,GD_CODE,GD_UNIT,GD_NAME_KOR,GD_SPEC, GD_DESC, GD_PILLORDER 
					from ".$dbH."_goods where gd_seq='".$gd_seq."'  and gd_use in ('Y','A') ";  ///사용전과 사용중인것만 보임
			$dt=dbone($sql3);

			$gdBomcode=$dt["GD_BOMCODE"];
			$json=array(

				"seq"=>$dt["GD_SEQ"],
				"gdBomcode"=>$gdBomcode,		
				"gdRecipe"=>$dt["GD_RECIPE"],  ///RC20200508135456	
				"gdUse"=>$dt["GD_USE"],

				"gdType"=>$dt["GD_TYPE"],
				"gdCategory"=>$dt["GD_CATEGORY"],///반제품의 상세분류

				"gdStable"=>$dt["GD_STABLE"],  ///적정수량
				"gdLoss"=>$dt["GD_LOSS"],  ///로스율
				"gdLossCapa"=>$dt["GD_LOSSCAPA"],  ///로스율
				"gdCapa"=>$dt["GD_CAPA"],  ///제품용량
				"gdCode"=>$dt["GD_CODE"], ///MA200508135457
				"gdUnit"=>$dt["GD_UNIT"],
				"gdNameKor"=>$dt["GD_NAME_KOR"],
				"gdSpec"=>$dt["GD_SPEC"],
				"gdDesc"=>$dt["GD_DESC"],
				"gdPillorder"=>getClob($dt["GD_PILLORDER"])
				);

			
			if($gdBomcode==null || $gdBomcode=="")
			{
				$json["bomcodeList"] = null;
			}
			else
			{
				$bomcode = substr($gdBomcode, 1); ///한자리만 자르기 
				$bomcodeList=getpillparentlist($bomcode);  ///ETGDSH|5,FTSP004|1,FTGD001|1,ETSJHZ|2,ETSJHW|0,ETSJHZ|0
				$json["bomcodeList"] = $bomcodeList;

				//"MA200515160826"
				//,KHBML|1,MA200515160940|1,MA200515160958|1,MA200515160951|1

				$childbomcodeList=getpillchildlist($bomcode);
				
				$json["childbomcodealllist"] = $childbomcodeList;


				$childlist = $childbomcodeList["list"];
				//$parentlist = $childbomcodeList["parent"];

				//$plist=array_merge($parentlist, $childlist);

				$json["childbomcodeList"] = $childlist;

				//childbomcodelist

			}

			///이미지
			$sql=" select af_seq, af_name, af_url as afUrl from ".$dbH."_file where af_use='Y' and af_code='goods' and af_fcode='".$dt["GD_CODE"]."' order by af_no desc ";
			$res=dbqry($sql);
			$json["afFiles"]=array();
			for($i=0;$dt=dbarr($res);$i++)
			{
				$afFile=getafFile($dt["AFURL"]);
				$afThumbUrl=getafThumbUrl($dt["AFURL"]);

				$addarray=array(
					"afseq"=>$dt["AF_SEQ"], 
					"afCode"=>$dt["AF_CODE"], 
					"afThumbUrl"=>$afThumbUrl, 
					"afUrl"=>$afFile, 
					"afName"=>$dt["AF_NAME"], 
					"afSize"=>$dt["AF_SIZE"]);
				array_push($json["afFiles"], $addarray);
			}
		}
		else  ///seq가 없을때 기본값으로 보내준다.
		{
			$newcode="MA".date("ymdHis"); ///14자리
			$json["gdCode"] = $newcode; 
			$json["gdUse"] = "A"; 

			$json["gdUnit"] = 1; ///재고기준량   1 
			$json["gdStable"] = 1000; ///적정수량  1000
			$json["gdLossCapa"] = 0; ///로스율 0
			$json["gdLoss"] = 0; ///로스량 0
			$json["gdCapa"] = 1; ///제품용량 1
			$json["gdPillorder"]="";
		}

		$json["plDctime"]=$dcTime;///탕전시간
		$json["plMillingloss"]=$plMillingloss;///제분손실
		$json["plLosspill"]=$plLosspill;///제형손실

		$json["gdTypeList"]=$gdTypeList;///제품등록
		$json["UseList"]=$UseList;///YN 리스트
		$json["gdCategoryList"]=$gdCategoryList;///반제품의 상세분류
		
		$json["pillRatioList"]=$pillRatioList;///농축비율
		$json["pillTimeList"]=$pillTimeList;///농축시간
		$json["pillJuiceList"]=$pillJuiceList;//착즙유무
		$json["pillTemperatureList"]=$pillTemperatureList;///중탕온도
		$json["decoctypeList"]=$decoctypeList;///탕전타입 (선전,일반,후하 )
		$json["dcTitleList"]=$dcTitleList;///탕전법리스트
		$json["dcSpecialList"]=$dcSpecialList;///특수탕전리스트
		$json["pillShapeList"]=$pillShapeList;///제형
		$json["pillBindersList"]=$pillBindersList;///결합제
		$json["pillFinenessList"]=$pillFinenessList;///분말도
		$json["pillRipenList"]=$pillRipenList;///숙성리스트 

		$json["pillOrderList"]=$pillOrderList;///제환순서  
		$json["gdLossTypeList"]=$gdLossTypeList;///로스타입
		

		

		$json["dcTime"]=$dcTime;///제환에서 탕전시간을 4시간이 기본 
		$json["plMillingloss"]=$plMillingloss;///제분손실
		$json["pillLosspill"]=$pillLosspill;///제형손실


		$json["gd_seq"]=$gd_seq;
		$json["apiCode"]=$apiCode;
		$json["returnData"]=$returnData;
		$json["resultCode"]="200";
		$json["resultMessage"]="OK";
		$json["sql"]=$sql;
		$json["sql3"]=$sql3;

		$json["bomcode"]=$bomcode;
	
	}

?>
