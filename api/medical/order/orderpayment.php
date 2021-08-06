<?php //장바구니에서 결재하기 버튼을 클릭시에 seq값들이 넘어온다.. 그 아이들만 업데이트 하면서 주문에 넣자!!!
	
	//카드인지, 무통장인지 넘겨주자 무통장이면 입금자명과 은행, 계좌번호를 넘겨준다 
	$apicode=$_POST["apiCode"];
	$language=$_POST["language"];
	$cartseq=$_POST["cartseq"];
	if($apicode!="orderpayment"){$json["resultMessage"]="API(apiCode) ERROR2";$apicode="orderpayment";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="API(language) ERROR";}
	else
	{
		if(isEmpty($cartseq)==false)
		{
			$carttype=$_POST["carttype"];
			$carr=explode(",",$cartseq);
			$json["carr"]=$carr;
			$cseq="";
			for($i=1;$i<count($carr);$i++)
			{
				if($i>1)$cseq.=",";
				$cseq.="'".$carr[$i]."'";
			}

			$sql=" select SEQ, JSONDATA from han_order_medical where SEQ in (".$cseq.") ";
			$res=dbqry($sql);

			
			while($dt=dbarr($res))
			{
				$seq=$dt["SEQ"];
				$jsondata=getClob($dt["JSONDATA"]);
				$jdata=json_decode($jsondata,true);


				$json["jdata".$seq]=$jdata;
				//======
				//orderInfo : 주문정보 
				$keyCode=$jdata["orderInfo"][0]["keycode"];//주문코드, 부산대주문코드
				$orderCode=$jdata["orderInfo"][0]["orderCode"];//주문코드, 부산대주문코드
				$orderDate=$jdata["orderInfo"][0]["orderDate"];//주문일
				$deliveryDate=$jdata["orderInfo"][0]["deliveryDate"];//배송희망일

				$medicalCode=$jdata["orderInfo"][0]["medicalCode"];//한의원코드

				$medicalName=$jdata["orderInfo"][0]["medicalName"];//한의원

				$doctorCode=$jdata["orderInfo"][0]["doctorCode"];//처방자코드

				$doctorName=$jdata["orderInfo"][0]["doctorName"];//처방자

				$orderTitle=$jdata["orderInfo"][0]["orderTitle"];//처방명

				$orderTypeCode=$jdata["orderInfo"][0]["orderTypeCode"];//조제타입코드

				$orderType=$jdata["orderInfo"][0]["orderType"];//조제타입명

				$orderCount=$jdata["orderInfo"][0]["orderCount"];//주문갯수

				$productCode=$jdata["orderInfo"][0]["productCode"];//처방코드

				$productCodeName=$jdata["orderInfo"][0]["productCodeName"];//처방코드명

				$orderComment=addslashes($jdata["orderInfo"][0]["orderComment"]);//조제지시

				$orderAdvice=addslashes($jdata["orderInfo"][0]["orderAdvice"]);//복약지도서

				$orderCommentContents=addslashes($jdata["orderInfo"][0]["orderCommentContents"]);//조제지시내용 

				
				$orderCommentKey=(isEmpty($jdata["orderInfo"][0]["orderCommentKey"])==false)?$jdata["orderInfo"][0]["orderCommentKey"]:0;//조제지시seq
				$orderAdviceKey=(isEmpty($jdata["orderInfo"][0]["orderAdviceKey"])==false)?$jdata["orderInfo"][0]["orderAdviceKey"]:0;//복약지도서seq


				$orderStatus=$jdata["orderInfo"][0]["orderStatus"];//주문상태 cart(장바구니),paid(결재완료),done(등록완료)
					
				//patientInfo : 환자정보 
				$patientCode=$jdata["patientInfo"][0]["patientCode"];//환자코드
				$patientName=$jdata["patientInfo"][0]["patientName"];//환자명
				$patientGender=$jdata["patientInfo"][0]["patientGender"];//성별 male:남, female:여
				$patientBirth=$jdata["patientInfo"][0]["patientBirth"];//생년월일
				$patientPhone=$jdata["patientInfo"][0]["patientPhone"];//전화번호 

			
				//recipeInfo : 처방정보
				$chubCnt=$jdata["recipeInfo"][0]["chubCnt"];//첩수
				$packCnt=$jdata["recipeInfo"][0]["packCnt"];//팩수
				$packCapa=$jdata["recipeInfo"][0]["packCapa"];//팩용량

				//약재
				$totalMedicine="";
				$arr=$jdata["recipeInfo"][0]["totalMedicine"];  //총약재량
				foreach($arr as $val) 
				{
					if($val["mediCode"])
					{
						$mediType=$val["mediType"];//처방타입
						$mediCode=$val["mediCode"]; //약재코드
						$mediName=$val["mediName"];//약재명
						$mediPoison=$val["mediPoison"];//독성 ( 0 , 1)
						$mediDismatch=$val["mediDismatch"]; //상극 ( 0 , 1)
						$mediOrigin=$val["mediOrigin"];//원산지코드
						$mediOriginTxt=$val["mediOriginTxt"];//원산지명 
						$mediCapa=$val["mediCapa"];//첩당약재량
						$mediAmount=$val["mediAmount"];//첩당약재비

						$totalMedicine.="|".$mediType.",".$mediCode.",".$mediName.",".$mediPoison.",".$mediDismatch.",".$mediOrigin.",".$mediOriginTxt.",".$mediCapa.",".$mediAmount;
					}
				}

				//별전
				$arr2=$jdata["recipeInfo"][0]["sweetMedi"];
				$sweetMedi="";
				foreach($arr2 as $val) 
				{
					if($val["sweetCode"])
					{
						$sweetCode=$val["sweetCode"];//감미제코드
						$sweetName=$val["sweetName"];//감미제명
						$sweetCapa=$val["sweetCapa"];//감미제량
						$sweetPrice=$val["sweetPrice"];//감미제가격 

						$sweetMedi.="|".$sweetCode.",".$sweetName.",".$sweetCapa.",".$sweetPrice;
					}
				}

				//감미제 
				$arr3=$jdata["recipeInfo"][0]["sugarMedi"];
				$sugarMedi="";
				foreach($arr3 as $val) 
				{
					if($val["sugarCode"])
					{
						$sugarCode=$val["sugarCode"];//감미제코드
						$sugarName=$val["sugarName"];//감미제명
						$sugarCapa=$val["sugarCapa"];//감미제량
						$sugarPrice=$val["sugarPrice"];//감미제가격 
						$sugarTotalCapa=$val["sugarTotalCapa"];//감미제들어갈양  

						$sugarMedi=$sugarCode.",".$sugarName.",".$sugarCapa.",".$sugarTotalCapa.",".$sugarPrice;
					}
				}
				
				//decoctionInfo : 탕전정보
				$specialDecoc=$jdata["decoctionInfo"][0]["specialDecoc"];//특수탕전코드
				$specialDecoctxt=$jdata["decoctionInfo"][0]["specialDecoctxt"];//특수탕전명 예)주수상반
				$specialDecocprice=$jdata["decoctionInfo"][0]["specialDecocprice"];//특수탕전명 예)주수상반
				

				//markingInfo : 마킹정보
				$markType=$jdata["markingInfo"][0]["markType"];//마킹형태
				$markText=$jdata["markingInfo"][0]["markText"];//마킹내용


				//packageInfo : 포장재정보
				$packinglist="";
				$arr3=$jdata["packageInfo"];  //총포장재
				foreach($arr3 as $val)
				{
					if($val["packCode"])
					{
						$packType=$val["packType"]; //포장재종류 pouch(파우치),medibox(한약박스),delibox(배송박스)
						$packCode=$val["packCode"]; //포장재코드
						$packName=$val["packName"]; //포장재명
						$packImage=$val["packImage"]; //포장재이미지 URL
						$packAmount=$val["packAmount"]; //개별포장재비
						$packMaxCapa=$val["packCapa"]; //

						$packinglist.="|".$packType.",".$packCode.",".$packName.",".$packImage.",".$packAmount.",".$packMaxCapa;
					}
				}

				//deliveryInfo : 배송정보
				$deliType=$jdata["deliveryInfo"][0]["deliType"]; //배송종류 direct(직배), post(택배)
				$sendName=$jdata["deliveryInfo"][0]["sendName"]; //보내는사람
				$sendPhone=$jdata["deliveryInfo"][0]["sendPhone"]; //보내는사람 전화번호
				$sendMobile=$jdata["deliveryInfo"][0]["sendMobile"]; //보내는사람 휴대폰번호
				$sendZipcode=$jdata["deliveryInfo"][0]["sendZipcode"]; //보내는사람 우편번호
				$sendAddress=$jdata["deliveryInfo"][0]["sendAddress"]; //보내는사람 주소
				$sendAddressDesc=$jdata["deliveryInfo"][0]["sendAddressDesc"]; //보내는사람 상세주소
				$receiveName=$jdata["deliveryInfo"][0]["receiveName"]; //받는사람
				$receivePhone=$jdata["deliveryInfo"][0]["receivePhone"]; //받는사람 전화번호
				$receiveMobile=$jdata["deliveryInfo"][0]["receiveMobile"]; //받는사람 휴대폰번호
				$receiveZipcode=$jdata["deliveryInfo"][0]["receiveZipcode"]; //받는사람 우편번호
				$receiveAddress=$jdata["deliveryInfo"][0]["receiveAddress"]; //받는사람 주소
				$receiveAddressDesc=$jdata["deliveryInfo"][0]["receiveAddressDesc"]; //받는사람 상세주소
				$receiveComment=addslashes($jdata["deliveryInfo"][0]["receiveComment"]); //배송요구사항
				$receiveTied=$jdata["deliveryInfo"][0]["receiveTied"]; //묶음배송마스터주문코드 (부산대주문코드)

		
				//paymentInfo : 결제정보
				$amountTotal=str_replace(",","",$jdata["paymentInfo"][0]["amountTotal"]); //총주문금액
				$amountMedicine=str_replace(",","",$jdata["paymentInfo"][0]["amountMedicine"]); //약재
				$amountAddmedi=str_replace(",","",$jdata["paymentInfo"][0]["amountAddmedi"]); //별전
				$amountSugar=str_replace(",","",$jdata["paymentInfo"][0]["amountSugar"]); //감미제
				$amountSpecial=str_replace(",","",$jdata["paymentInfo"][0]["amountSpecial"]); //특수탕전비 
				$amountPharmacy=str_replace(",","",$jdata["paymentInfo"][0]["amountPharmacy"]); //조제비
				$amountDecoction=str_replace(",","",$jdata["paymentInfo"][0]["amountDecoction"]); //탕전비
				$amountPackaging=str_replace(",","",$jdata["paymentInfo"][0]["amountPackaging"]); //포장비
				$amountDelivery=str_replace(",","",$jdata["paymentInfo"][0]["amountDelivery"]); //배송비

				$amountTotal=str_replace("원","",$amountTotal); //총주문금액
				$amountMedicine=str_replace("원","",$amountMedicine); //약재
				$amountAddmedi=str_replace("원","",$amountAddmedi); //별전
				$amountSugar=str_replace("원","",$amountSugar); //감미제
				$amountSpecial=str_replace("원","",$amountSpecial); //특수탕전비 
				$amountPharmacy=str_replace("원","",$amountPharmacy); //조제비
				$amountDecoction=str_replace("원","",$amountDecoction); //탕전비
				$amountPackaging=str_replace("원","",$amountPackaging); //포장비
				$amountDelivery=str_replace("원","",$amountDelivery); //배송비


				$amountTotal=!isEmpty($amountTotal)?$amountTotal:"0";
				$amountMedicine=!isEmpty($amountMedicine)?$amountMedicine:"0";
				$amountAddmedi=!isEmpty($amountAddmedi)?$amountAddmedi:"0";
				$amountSugar=!isEmpty($amountSugar)?$amountSugar:"0";
				$amountSpecial=!isEmpty($amountSpecial)?$amountSpecial:"0";
				$amountPharmacy=!isEmpty($amountPharmacy)?$amountPharmacy:"0";
				$amountDecoction=!isEmpty($amountDecoction)?$amountDecoction:"0";
				$amountPackaging=!isEmpty($amountPackaging)?$amountPackaging:"0";
				$amountDelivery=!isEmpty($amountDelivery)?$amountDelivery:"0";
				

				//adviceInfo : 복약지도정보
				$foodAdvice=$jdata["adviceInfo"][0]["foodAdvice"]; //주의음식
				$cautionAdvice=$jdata["adviceInfo"][0]["cautionAdvice"]; //기타주의사항
				$foodAdvicFree=$jdata["adviceInfo"][0]["foodAdvicFree"]; //주의음식(FREETEXT)
				$cautionAdviceFree=$jdata["adviceInfo"][0]["cautionAdviceFree"]; //기타주의사항(FREETEXT)

		
				//labelInfo : 입원환자용라벨
				$wardNo=$jdata["labelInfo"][0]["wardNo"]; //병동코드
				$roomNo=$jdata["labelInfo"][0]["roomNo"]; //병실코드
				$bedNo=$jdata["labelInfo"][0]["bedNo"]; //베드코드
				$mediDays=$jdata["labelInfo"][0]["mediDays"]; //첩약기간
				$mediType=$jdata["labelInfo"][0]["mediType"]; //첩약종류
				$mediCapa=$jdata["labelInfo"][0]["mediCapa"]; //첩약용량
				$mediName=$jdata["labelInfo"][0]["mediName"]; //첩약명
				$mediAdvice=$jdata["labelInfo"][0]["mediAdvice"]; //복약지도
				//======
				
				include $root.$folder."/order/medicaltodjmedi.php";
				
			}
		

			$json["sql"]=$sql;
			$json["resultCode"]="200";
			$json["resultMessage"]="OK";
		}
		else
		{
			$json["resultCode"]="199";
			$json["resultMessage"]="결재할 데이터가 없습니다. 다시 확인해 주시기 바랍니다.";
		}
		$json["_POST"]=$_POST;
		$json["cartseq"]=$cartseq;
		$json["apiCode"]=$apicode;
		$json["returnData"]=$returnData;		

	}
?>
<?php
function getMedicalDoctorInfo($docode, $mdname, $doname)
{
	global $language;
	global $dbH;

	$msql=" select ";
	$msql.=" a.me_company, a.me_userid, a.me_name, b.mi_name, b.mi_grade, b.mi_phone, b.mi_zipcode, b.mi_address ";
	$msql.=" from ".$dbH."_member ";
	$msql.=" a inner join ".$dbH."_medical b on a.me_company=b.mi_userid ";
	$msql.=" where a.ME_USERID='".$docode."' and a.me_use='Y' ";
	$mdt=dbone($msql);
	
	if($mdt["ME_COMPANY"]) //검색해서 한의원이 있다면..
	{
		$data=array(
			"meCompany"=>$mdt["ME_COMPANY"],//한의원ID
			"meUserid"=>$mdt["ME_USERID"],
			"miGrade"=>$mdt["MI_GRADE"],//한의원등급
			"miName"=>$mdt["MI_NAME"]//한의원이름
		);
	}
	else //한의원이 없다면 
	{
		$data=array(
			"meCompany"=>"*".$mdname,//한의원ID
			"meUserid"=>$doname,
			"miGrade"=>"E",//한의원등급
			"miName"=>$mdname//한의원이름
		);
	}
	
	return $data;
}
?>