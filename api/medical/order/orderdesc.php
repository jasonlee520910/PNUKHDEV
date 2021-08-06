<?php  ///주문상세  
	$apiCode=$_GET["apiCode"];
	$language=$_GET["language"];
	$seq=$_GET["seq"];

	if($apiCode!="orderdesc"){$json["resultMessage"]="API(apiCode) ERROR";$apiCode="orderdesc";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="API(language) ERROR";}
	else
	{
		$medicalId=$_GET["medicalId"];
		$doctorId=$_GET["doctorId"];

		//orderdesc
		if($seq)
		{
			$sql=" select SEQ, KEYCODE, JSONDATA 
					from han_order_medical 
					where seq ='".$seq."' ";

			$dt=dbone($sql);

			if($dt["SEQ"])
			{
				$jsondata=getClob($dt["JSONDATA"]);
				$jsondatadjmedi=json_decode($jsondata, true);

				//환자정보 
				$patientInfo=$jsondatadjmedi["patientInfo"];

				$patientChartno=$patientInfo[0]["patientChartno"];
				$patientCode=$patientInfo[0]["patientCode"];
				$patientName=$patientInfo[0]["patientName"];
				$patientGender=$patientInfo[0]["patientGender"];
				$patientBirth=$patientInfo[0]["patientBirth"];
				$patientPhone=$patientInfo[0]["patientPhone"];
				$patientMobile=$patientInfo[0]["patientMobile"];
				$patientZipcode=$patientInfo[0]["patientZipcode"];
				$patientAddr=explode("||",$patientInfo[0]["patientAddr"]);
				$patientmemo=$patientInfo[0]["patientmemo"];

				//주문정보  
				$orderInfo=$jsondatadjmedi["orderInfo"];

				$keycode=$dt["KEYCODE"];//주문코드, 부산대주문코드
				$orderCode=$orderInfo[0]["orderCode"];//주문코드, 부산대주문코드
				//$orderDate=$orderInfo[0]["orderDate"];//주문일
				//$deliveryDate=$orderInfo[0]["deliveryDate"];//배송희망일
				$medicalCode=$orderInfo[0]["medicalCode"];//한의원코드
				$medicalName=$orderInfo[0]["medicalName"];//한의원
				$doctorCode=$orderInfo[0]["doctorCode"];//처방자코드
				$doctorName=$orderInfo[0]["doctorName"];//처방자
				$orderTitle=$orderInfo[0]["orderTitle"];//처방명
				//$orderTypeCode=$orderInfo[0]["orderTypeCode"];//조제타입코드
				//$orderType=$orderInfo[0]["orderType"];//조제타입명
				//$orderCount=$orderInfo[0]["orderCount"];//주문갯수
				//$productCode=$orderInfo[0]["productCode"];//처방코드
				//$productCodeName=$orderInfo[0]["productCodeName"];//처방코드명
				$orderComment=$orderInfo[0]["orderComment"];//조제지시
				$orderAdvice=$orderInfo[0]["orderAdvice"];//복약지도서

				$orderCommentKey=$orderInfo[0]["orderCommentKey"];//조제지시
				$orderAdviceKey=$orderInfo[0]["orderAdviceKey"];//복약지도서
				$orderCommentName=$orderInfo[0]["orderCommentName"];//조제지시
				$orderAdviceName=$orderInfo[0]["orderAdviceName"];//복약지도서
				$orderCommentContents=$orderInfo[0]["orderCommentContents"];//조제지시

				//처방정보 
				$recipeInfo=$jsondatadjmedi["recipeInfo"];

				$chubCnt=$recipeInfo[0]["chubCnt"];
				$packCnt=$recipeInfo[0]["packCnt"];
				$packCapa=$recipeInfo[0]["packCapa"];
				$totalMedicine=$recipeInfo[0]["totalMedicine"];
				$sweetMedi=$recipeInfo[0]["sweetMedi"];
				$sugarMedi=$recipeInfo[0]["sugarMedi"];

				//포장정보 
				$packageInfo=$jsondatadjmedi["packageInfo"];
				$odpacktype=$odpacktypetitle=$odpacktypeprice=$odpacktypeimg;
				$odmedibox=$odmediboxtitle=$odmediboxprice=$odmediboximg;
				for($i=0;$i<count($packageInfo);$i++)
				{
					if($packageInfo[$i]["packType"]=="pouch")
					{
						$odpacktype=$packageInfo[$i]["packCode"];
						$odpacktypetitle=$packageInfo[$i]["packName"];
						$odpacktypeprice=$packageInfo[$i]["packAmount"];
						$odpacktypeimg=$packageInfo[$i]["packImage"];
					}
					else if($packageInfo[$i]["packType"]=="medibox")
					{
						$odmedibox=$packageInfo[$i]["packCode"];
						$odmediboxtitle=$packageInfo[$i]["packName"];
						$odmediboxprice=$packageInfo[$i]["packAmount"];
						$odmediboximg=$packageInfo[$i]["packImage"];
						$odmediboxcapa=$packageInfo[$i]["packCapa"];
						
					}
				}

				//탕전정보
				$decoctionInfo=$jsondatadjmedi["decoctionInfo"];
				$specialDecoc=($decoctionInfo[0]["specialDecoc"])?$decoctionInfo[0]["specialDecoc"]:"spdecoc01";

				//감미제 
				$sugarCode="";
				$sugardata="";
				foreach($sugarMedi as $val) 
				{
					if($val["sugarCode"])
					{
						$sugarCode=$val["sugarCode"];//감미제코드
						$sugarName=$val["sugarName"];//감미제명
						$sugarCapa=$val["sugarCapa"];//감미제량
						$sugarPrice=$val["sugarPrice"];//감미제가격 
						$sugarTotalCapa=$val["sugarTotalCapa"];//감미제들어갈양  

						$sugardata.="|".$sugarCode.",".$sugarName.",".$sugarCapa.",".$sugarTotalCapa.",".$sugarPrice;
					}
				}


				$json=array(
					"seq"=>$dt["SEQ"], 

					//주문정보 
					"keycode"=>$keycode, 
					"ordercode"=>$orderCode,
					"medicalCode"=>$medicalCode,
					"medicalName"=>$medicalName,
					"doctorCode"=>$doctorCode,
					"doctorName"=>$doctorName,
					"orderTitle"=>$orderTitle,
					"orderComment"=>$orderComment,
					"orderAdvice"=>$orderAdvice,

					"orderCommentKey"=>$orderCommentKey,
					"orderAdviceKey"=>$orderAdviceKey,
					"orderCommentName"=>$orderCommentName,
					"orderAdviceName"=>$orderAdviceName,
					"orderCommentContents"=>$orderCommentContents,
					


					//환자정보 
					"patientChartno"=>$patientChartno,
					"patientCode"=>$patientCode,
					"patientName"=>$patientName,
					"patientGender"=>$patientGender,
					"patientBirth"=>$patientBirth,
					"patientPhone"=>$patientPhone,
					"patientMobile"=>$patientMobile,
					"patientZipcode"=>$patientZipcode,
					"patientAddr"=>$patientAddr[0]." ".$patientAddr[1], 
					"patientAddr0"=>$patientAddr[0],
					"patientAddr1"=>$patientAddr[1],
					"patientmemo"=>$patientmemo,
						

					//처방정보
					"chubCnt"=>$chubCnt,
					"packCnt"=>$packCnt,
					"packCapa"=>$packCapa,
					"totalMedicine"=>$totalMedicine,
					"sweetMedi"=>$sweetMedi,
					"sugarMedi"=>$sugarMedi,
					//감미제정보
					"sugarCode"=>$sugarCode,
					"sugardata"=>$sugardata,
					
					//탕전정보
					"specialDecoc"=>$specialDecoc,
					


					//포장재정보
					"odpacktype"=>$odpacktype,
					"odpacktypetitle"=>$odpacktypetitle,
					"odpacktypeprice"=>$odpacktypeprice,
					"odpacktypeimg"=>$odpacktypeimg,
					"odmedibox"=>$odmedibox,
					"odmediboxtitle"=>$odmediboxtitle,
					"odmediboxprice"=>$odmediboxprice,
					"odmediboximg"=>$odmediboximg,
					"odmediboxcapa"=>$odmediboxcapa,
					
					"jsondata"=>$jsondata

					
					);


				$json["resultCode"]="200";
				$json["resultMessage"]="OK";
			}
			else
			{
				$json["resultCode"]="199";
				$json["resultMessage"]="없는 주문이거나 삭제된 주문입니다.";
			}
		}
		else
		{
			$json["resultCode"]="200";
			$json["resultMessage"]="OK";
		}

		$json["sql"]=$sql;	
		$json["apiCode"]=$apiCode;

		//getsugar
		$sugar=getSugar(); //감미제 리스트 
		$json["sugar"]=$sugar;

		//getconfig
		$config=getConfigInfo();///공통으로 쓰이는 데이터들 (가격)
		$json["config"]=$config;

		//getpacking 
		$hPackCodeList = getPackCodeTitle($medicalId, "odPacktype,reBoxdeli,reBoxmedi");
		$reBoxmediList = getCodeList($hPackCodeList, 'reBoxmedi');///한약박스
		$reBoxdeliList = getCodeList($hPackCodeList, 'reBoxdeli');///배송포장재종류 
		$odPacktypeList = getCodeList($hPackCodeList, 'odPacktype');///파우치
		$json["packing"]=array("boxmedi"=>$reBoxmediList,"boxdeli"=>$reBoxdeliList,"packtype"=>$odPacktypeList);

		$json["hPackCodeList"]=$hPackCodeList;

		$dcSpecialList=getSpecial(); //특수탕전리스트
		$json["dcSpecialList"]=$dcSpecialList;

		if(isEmpty($doctorId)==false)
		{
			//복용지시 
			$advicelist=getMemberDocx("ADVICE",$doctorId, $medicalId);
			//조제지시 
			$commentlist=getMemberDocx("COMMENT",$doctorId, $medicalId);
		}


		$json["doctorId"]=$doctorId;
		$json["advicelist"]=$advicelist;
		$json["commentlist"]=$commentlist;


	}
?>