<?php
	$root="../../..";
	$folder="/pnuh";
	include_once $root.$folder."/head.php";

	$json["resultCode"]="404";
	$json["resultMessage"]="regist API(apiCode) ERROR";
	$jdata=json_decode($_POST["data"],true);
	$jsonData=$_POST["data"];
	

	//------------------------------------------
	// 테스트 
	//------------------------------------------
/*	
$jsonString = '{"apiCode":"orderregist","language":"kor","orderInfo":[{"orderCode":"516808073202006230015","orderDate":"2020-11-10","deliveryDate":"2020-11-10","medicalCode":"PNUKH","medicalName":"부산대학교한방병원","doctorCode":"TESTDOO",
"doctorName":"한방의1","orderTitle":"HT013당귀육황탕(창방)_DJMEDI2","orderTypeCode":"decoction","orderType":"탕전","orderCount":"1","productCode":"KD99999","productCodeName":"HT013당귀육황탕(창방)","orderComment":"용법 확인하세요TEST_DJMEDI2"
,"orderAdvice":"","orderStatus":"paid"}],"patientInfo":[{"patientCode":"116808073","patientName":"김현주_DJMEDI2","patientGender":"F","patientBirth":"19630414","patientPhone":"010-21111"}],"recipeInfo":[{"chubCnt":"3","packCnt":"3","packCapa":"200",
"totalMedicine":[{"mediType":"inmain","mediCode":"KHBC","mediName":"백출","mediPoison":"0","mediDismatch":"0","mediOrigin":"","mediOriginTxt":"","mediCapa":"4"},{"mediType":"inmain","mediCode":"KHBR","mediName":"복령","mediPoison":"0",
"mediDismatch":"0","mediOrigin":"","mediOriginTxt":"","mediCapa":"4"},{"mediType":"inmain","mediCode":"KHSIH","mediName":"시호","mediPoison":"0","mediDismatch":"0","mediOrigin":"","mediOriginTxt":"","mediCapa":"4"},{"mediType":"inmain",
"mediCode":"KHCJC","mediName":"치자(초)","mediPoison":"0","mediDismatch":"0","mediOrigin":"","mediOriginTxt":"","mediCapa":"4"},{"mediType":"inmain","mediCode":"KHHR","mediName":"황련","mediPoison":"0","mediDismatch":"0","mediOrigin":
"","mediOriginTxt":"","mediCapa":"2"},{"mediType":"inmain","mediCode":"KHHGM","mediName":"황금","mediPoison":"0","mediDismatch":"0","mediOrigin":"","mediOriginTxt":"","mediCapa":"2"},{"mediType":"inmain","mediCode":"KHHB","mediName":"황백","mediPoison":"0","mediDismatch":"0","mediOrigin":"","mediOriginTxt":"","mediCapa":"2"},{"mediType":"inmain","mediCode":"KHVHA","mediName":"박하","mediPoison":"0","mediDismatch":"0","mediOrigin":"","mediOriginTxt":"","mediCapa":"2"},{
"mediType":"inmain","mediCode":"KHGC","mediName":"감초","mediPoison":"0","mediDismatch":"0","mediOrigin":"","mediOriginTxt":"","mediCapa":"2"},{"mediType":"inmain","mediCode":"KHSG","mediName":"생강","mediPoison":"0","mediDismatch":"0"
,"mediOrigin":"","mediOriginTxt":"","mediCapa":"6"},{"mediType":"inmain","mediCode":"KHDGI","mediName":"당귀(일)","mediPoison":"0","mediDismatch":"0","mediOrigin":"","mediOriginTxt":"","mediCapa":"4"},{"mediType":"inmain","mediCode":"KHSGJH","mediName":"생지황","mediPoison":"0","mediDismatch":"0","mediOrigin":"","mediOriginTxt":"","mediCapa":"4"},{"mediType":"inmain","mediCode":"KHSJH","mediName":"숙지황","mediPoison":"0","mediDismatch":"0","mediOrigin":"","mediOriginTxt":"","mediCapa":"4"},{"mediType":"inmain","mediCode":"KHHG","mediName":"황기","mediPoison":"0","mediDismatch":"0","mediOrigin":"","mediOriginTxt":"","mediCapa":"8"},{"mediType":"inmain","mediCode":"KHBJYAC","mediName":"백작약(초)","mediPoison"
:"0","mediDismatch":"0","mediOrigin":"","mediOriginTxt":"","mediCapa":"4"}],"sweetMedi":[{"sweetCode":"","sweetName":"","sweetCapa":""}]}],"decoctionInfo":[{"specialDecoc":"spdeco01","specialDecoctxt":"주수상반"}],"markingInfo":[{"markType":"type01","markText":"김현주/20/06/23/부산대한방병원"}],"packageInfo":[{"packType":"","packCode":"","packName":"","packImage":"","packAmount":""}],"deliveryInfo":[{"deliType":"direct","sendName":"김현주","sendPhone":"010-21111","sendMobile":"010-211-1221","sendZipcode":"49416","sendAddress":"부산광역시 사하구 괴정로101111 ","sendAddressDesc":"523-31111","receiveName":"김현주","receivePhone":"010-21111","receiveMobile":"010-21111","receiveZipcode":"49416","receiveAddress":"부산광역시 사하구 괴정로101111 ","receiveAddressDesc":"523-31111","receiveComment":"빠른배송 부탁드립니다.","receiveTied":"N"}],"paymentInfo":[{"amountTotal":"100","amountMedicine":"100","amountAddmedi":"100","amountSweet":"100","amountPharmacy":"100","amountDecoction":"100","amountPackaging":"100","amountDelivery":"100"}],"adviceInfo":[{"foodAdvice":"계란,짠 음식,밀가루,라면","cautionAdvice":"약을 복용하고 있을 시에는 의사의 지시사항에 따라 주시기 바랍니다.불특정한 증상이 생기면 전문의와 상의하시기 바랍니다.몸이 차고 기운이 약한 상태입니다.","foodAdvicFree":"기타주의해야 할 음식","cautionAdviceFree":"기타 주의사항 프리텍스트"}],"labelInfo":[{"wardNo":"4K","roomNo":"06","bedNo":"03","mediDays":"1일분","mediType":"첩제"
,"mediCapa":"200cc*3포","mediName":"HT013당귀육황탕(창방)","mediAdvice":"1일 3회 식후2시간에 1포씩 복용"}]}';
*/
//부산대에서 테스
/*
$jsonString='{"apiCode":"orderregist","language":"kor","orderInfo":[{"orderCode":"116614380202011110012","orderDate":"2020-11-11","deliveryDate":"2020-11-11","medicalCode":"PNUKH","medicalName":"부산대학교한방병원","doctorCode":"TESTDOO","doctorName":"한방의1","orderTitle":"가감삼기음","orderTypeCode":"medicine","orderType":"첩제","orderCount":"1","productCode":"KD99999","productCodeName":"가감삼기음","orderComment":"TEST","orderAdvice":"","orderStatus":"paid"}],"patientInfo":[{"patientCode":"116614380","patientName":"최우서개발","patientGender":"F","patientBirth":"19700803","patientPhone":"010-91111"}],"recipeInfo":[{"chubCnt":"1","packCnt":"3","packCapa":"200","totalMedicine":[[{"mediType":"inmain","mediCode":"KHDGI","mediName":"당귀(일)","mediPoison":"0","mediDismatch":"0","mediOrigin":"","mediOriginTxt":"","mediCapa":"6"},{"mediType":"inmain","mediCode":"KHGGJ","mediName":"구기자","mediPoison":"0","mediDismatch":"0","mediOrigin":"","mediOriginTxt":"","mediCapa":"6"},{"mediType":"inmain","mediCode":"KHOGP","mediName":"오가피","mediPoison":"0","mediDismatch":"0","mediOrigin":"","mediOriginTxt":"","mediCapa":"6"},{"mediType":"inmain","mediCode":"KHDJ","mediName":"대조","mediPoison":"0","mediDismatch":"0","mediOrigin":"","mediOriginTxt":"","mediCapa":"4"},{"mediType":"inmain","mediCode":"KHBJYA","mediName":"백작약","mediPoison":"0","mediDismatch":"0","mediOrigin":"","mediOriginTxt":"","mediCapa":"4"},{"mediType":"inmain","mediCode":"KHCGI","mediName":"천궁(거유,일)","mediPoison":"0","mediDismatch":"0","mediOrigin":"","mediOriginTxt":"","mediCapa":"4"},{"mediType":"inmain","mediCode":"KHBR","mediName":"복령","mediPoison":"0","mediDismatch":"0","mediOrigin":"","mediOriginTxt":"","mediCapa":"4"},{"mediType":"inmain","mediCode":"KHSD","mediName":"속단","mediPoison":"0","mediDismatch":"0","mediOrigin":"","mediOriginTxt":"","mediCapa":"4"},{"mediType":"inmain","mediCode":"KHMG","mediName":"목과","mediPoison":"0","mediDismatch":"0","mediOrigin":"","mediOriginTxt":"","mediCapa":"4"},{"mediType":"inmain","mediCode":"KHMMD","mediName":"맥문동","mediPoison":"0","mediDismatch":"0","mediOrigin":"","mediOriginTxt":"","mediCapa":"4"},{"mediType":"inmain","mediCode":"KHBP","mediName":"방풍","mediPoison":"0","mediDismatch":"0","mediOrigin":"","mediOriginTxt":"","mediCapa":"4"},{"mediType":"inmain","mediCode":"KHWRS","mediName":"위령선","mediPoison":"0","mediDismatch":"0","mediOrigin":"","mediOriginTxt":"","mediCapa":"4"},{"mediType":"inmain","mediCode":"KHDH","mediName":"독활","mediPoison":"0","mediDismatch":"0","mediOrigin":"","mediOriginTxt":"","mediCapa":"3"},{"mediType":"inmain","mediCode":"KHBJI","mediName":"백지","mediPoison":"0","mediDismatch":"0","mediOrigin":"","mediOriginTxt":"","mediCapa":"3"},{"mediType":"inmain","mediCode":"KHGCJ","mediName":"감초(밀자)","mediPoison":"0","mediDismatch":"0","mediOrigin":"","mediOriginTxt":"","mediCapa":"2"},{"mediType":"inmain","mediCode":"KHSG","mediName":"생강","mediPoison":"0","mediDismatch":"0","mediOrigin":"","mediOriginTxt":"","mediCapa":"6"},{"mediType":"inmain","mediCode":"KHWS","mediName":"우슬","mediPoison":"0","mediDismatch":"0","mediOrigin":"","mediOriginTxt":"","mediCapa":"6"},{"mediType":"inmain","mediCode":"KHDCY","mediName":"두충(염자)","mediPoison":"0","mediDismatch":"0","mediOrigin":"","mediOriginTxt":"","mediCapa":"6"},{"mediType":"inmain","mediCode":"KHBC","mediName":"백출","mediPoison":"0","mediDismatch":"0","mediOrigin":"","mediOriginTxt":"","mediCapa":"8"},{"mediType":"inmain","mediCode":"KHGPNC","mediName":"귀판(초)","mediPoison":"0","mediDismatch":"0","mediOrigin":"","mediOriginTxt":"","mediCapa":"8"},{"mediType":"inmain","mediCode":"KHSJH","mediName":"숙지황","mediPoison":"0","mediDismatch":"0","mediOrigin":"","mediOriginTxt":"","mediCapa":"12"},{"mediType":"inmain","mediCode":"KHSSY","mediName":"산수유","mediPoison":"0","mediDismatch":"0","mediOrigin":"","mediOriginTxt":"","mediCapa":"6"}]],"sweetMedi":[{"sweetCode":"","sweetName":"","sweetCapa":""}]}],"decoctionInfo":[{"specialDecoc":"spdeco01","specialDecoctxt":"주수상반"}],"markingInfo":[{"markType":"type01","markText":"최우서개발/20/11/11/부산대한방병원"}],"packageInfo":[{"packType":"","packCode":"","packName":"","packImage":"","packAmount":""}],"deliveryInfo":[{"deliType":"post","sendName":"최우서개발","sendPhone":"010-51111","sendMobile":"010-91111","sendZipcode":"50633","sendAddress":"경상남도 양산시 양주로 91111 ","sendAddressDesc":"601-11111","receiveName":"최우서개발","receivePhone":"010-51111","receiveMobile":"010-91111","receiveZipcode":"50633","receiveAddress":"경상남도 양산시 양주로 91111 ","receiveAddressDesc":"12344","receiveComment":"함께 보내주세요","receiveTied":"Y"}],"paymentInfo":[{"amountTotal":"100","amountMedicine":"100","amountAddmedi":"100","amountSweet":"100","amountPharmacy":"100","amountDecoction":"100","amountPackaging":"100","amountDelivery":"100"}],"adviceInfo":[{"foodAdvice":"계란,짠 음식,밀가루,라면","cautionAdvice":"약을 복용하고 있을 시에는 의사의 지시사항에 따라 주시기 바랍니다.\r\n불특정한 증상이 생기면 전문의와 상의하시기 바랍니다.\r\n몸이 차고 기운이 약한 상태입니다.","foodAdvicFree":"기타주의해야 할 음식","cautionAdviceFree":"기타 주의사항 프리텍스트"}],"labelInfo":[{"wardNo":"(한) 척추관절센터","roomNo":"","bedNo":"-","mediDays":"1일분","mediType":"첩제","mediCapa":"200cc*3포","mediName":"가감삼기음","mediAdvice":"1일 3회 의사지시대로 1포씩 복용"}]} ';
	$jdata = json_decode($jsonString, true);
	$jsonData=$jsonString;
*/
	//------------------------------------------

	$apicode=$jdata["apiCode"];	

	if($apicode!="orderregist"){$json["resultMessage"]="API(apiCode) ERROR";$apicode="orderregist";}
	else
	{
		$chkPostData=true;
		$chkPostKey="";
		$chkFieldList=array();

		$jsdata=insertClob($jsonData);

		//======
		//orderInfo : 주문정보 
		$orderCode=$jdata["orderInfo"][0]["orderCode"];//주문코드, 부산대주문코드
		$chkFieldList["orderCode"]=$jdata["orderInfo"][0]["orderCode"];

		$orderDate=$jdata["orderInfo"][0]["orderDate"];//주문일
		$chkFieldList["orderDate"]=$jdata["orderInfo"][0]["orderDate"];

		$deliveryDate=$jdata["orderInfo"][0]["deliveryDate"];//배송희망일
		$chkFieldList["deliveryDate"]=$jdata["orderInfo"][0]["deliveryDate"];

		$medicalCode=$jdata["orderInfo"][0]["medicalCode"];//한의원코드
		$chkFieldList["medicalCode"]=$jdata["orderInfo"][0]["medicalCode"];

		$medicalName=$jdata["orderInfo"][0]["medicalName"];//한의원
		$chkFieldList["medicalName"]=$jdata["orderInfo"][0]["medicalName"];

		$doctorCode=$jdata["orderInfo"][0]["doctorCode"];//처방자코드
		$chkFieldList["doctorCode"]=$jdata["orderInfo"][0]["doctorCode"];

		$doctorName=$jdata["orderInfo"][0]["doctorName"];//처방자
		$chkFieldList["doctorName"]=$jdata["orderInfo"][0]["doctorName"];

		$orderTitle=$jdata["orderInfo"][0]["orderTitle"];//처방명
		$chkFieldList["orderTitle"]=$jdata["orderInfo"][0]["orderTitle"];

		$orderTypeCode=$jdata["orderInfo"][0]["orderTypeCode"];//조제타입코드
		$chkFieldList["orderTypeCode"]=$jdata["orderInfo"][0]["orderTypeCode"];

		$orderType=$jdata["orderInfo"][0]["orderType"];//조제타입명
		$chkFieldList["orderType"]=$jdata["orderInfo"][0]["orderType"];

		$orderCount=$jdata["orderInfo"][0]["orderCount"];//주문갯수
		$chkFieldList["orderCount"]=$jdata["orderInfo"][0]["orderCount"];

		$productCode=$jdata["orderInfo"][0]["productCode"];//처방코드
		$chkFieldList["productCode"]=$jdata["orderInfo"][0]["productCode"];

		$productCodeName=$jdata["orderInfo"][0]["productCodeName"];//처방코드명
		$chkFieldList["productCodeName"]=$jdata["orderInfo"][0]["productCodeName"];

		$orderComment=addslashes($jdata["orderInfo"][0]["orderComment"]);//조제지시
		$chkFieldList["orderComment"]=$jdata["orderInfo"][0]["orderComment"];

		$orderAdvice=addslashes($jdata["orderInfo"][0]["orderAdvice"]);//복약지도서
		$chkFieldList["orderAdvice"]=$jdata["orderInfo"][0]["orderAdvice"];

		$orderStatus=$jdata["orderInfo"][0]["orderStatus"];//주문상태 cart(장바구니),paid(결재완료),done(등록완료)
		$chkFieldList["orderStatus"]=$jdata["orderInfo"][0]["orderStatus"];
			
		//patientInfo : 환자정보 
		$patientCode=$jdata["patientInfo"][0]["patientCode"];//환자코드
		$patientName=$jdata["patientInfo"][0]["patientName"];//환자명
		$patientGender=$jdata["patientInfo"][0]["patientGender"];//성별 male:남, female:여
		$patientBirth=$jdata["patientInfo"][0]["patientBirth"];//생년월일
		$patientPhone=$jdata["patientInfo"][0]["patientPhone"];//전화번호 

		$chkFieldList["patientCode"]=$jdata["patientInfo"][0]["patientCode"];
		$chkFieldList["patientName"]=$jdata["patientInfo"][0]["patientName"];
		$chkFieldList["patientGender"]=$jdata["patientInfo"][0]["patientGender"];
		$chkFieldList["patientBirth"]=$jdata["patientInfo"][0]["patientBirth"];
		$chkFieldList["patientPhone"]=$jdata["patientInfo"][0]["patientPhone"];

		//recipeInfo : 처방정보
		$chubCnt=$jdata["recipeInfo"][0]["chubCnt"];//첩수
		$packCnt=$jdata["recipeInfo"][0]["packCnt"];//팩수
		$packCapa=$jdata["recipeInfo"][0]["packCapa"];//팩용량

		$chkFieldList["chubCnt"]=$jdata["recipeInfo"][0]["chubCnt"];
		$chkFieldList["packCnt"]=$jdata["recipeInfo"][0]["packCnt"];
		$chkFieldList["packCapa"]=$jdata["recipeInfo"][0]["packCapa"];

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
		if($totalMedicine)
		{
			$chkFieldList["totalMedicine"]=$jdata["recipeInfo"][0]["totalMedicine"];
		}
		else
		{
			$chkFieldList["totalMedicine"]="";
		}

		//감미제
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

				if($sweetPrice)
				{
					$sweetMedi.="|".$sweetCode.",".$sweetName.",".$sweetCapa.",".$sweetPrice;
				}
				else
				{
					$sweetMedi.="|".$sweetCode.",".$sweetName.",".$sweetCapa;
				}
			}
		}
		if($sweetMedi)
		{
			$chkFieldList["sweetMedi"]=$jdata["recipeInfo"][0]["sweetMedi"];
		}
		else
		{
			$chkFieldList["sweetMedi"]="";
		}
		
		//decoctionInfo : 탕전정보
		$specialDecoc=$jdata["decoctionInfo"][0]["specialDecoc"];//특수탕전코드
		$specialDecoctxt=$jdata["decoctionInfo"][0]["specialDecoctxt"];//특수탕전명 예)주수상반
		$chkFieldList["specialDecoc"]=$jdata["decoctionInfo"][0]["specialDecoc"];
		$chkFieldList["specialDecoctxt"]=$jdata["decoctionInfo"][0]["specialDecoctxt"];

		//markingInfo : 마킹정보
		$markType=$jdata["markingInfo"][0]["markType"];//마킹형태
		$markText=$jdata["markingInfo"][0]["markText"];//마킹내용

		$chkFieldList["markType"]=$jdata["markingInfo"][0]["markType"];
		$chkFieldList["markText"]=$jdata["markingInfo"][0]["markText"];

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
				$packinglist.="|".$packType.",".$packCode.",".$packName.",".$packImage.",".$packAmount;
			}
			
		}
		if($packinglist)
		{
			$chkFieldList["packageInfo"]=$jdata["packageInfo"];
		}
		else
		{
			$chkFieldList["packageInfo"]="";
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

		$chkFieldList["deliType"]=$jdata["deliveryInfo"][0]["deliType"];
		$chkFieldList["sendName"]=$jdata["deliveryInfo"][0]["sendName"];
		$chkFieldList["sendPhone"]=$jdata["deliveryInfo"][0]["sendPhone"];
		$chkFieldList["sendMobile"]=$jdata["deliveryInfo"][0]["sendMobile"];
		$chkFieldList["sendZipcode"]=$jdata["deliveryInfo"][0]["sendZipcode"];
		$chkFieldList["sendAddress"]=$jdata["deliveryInfo"][0]["sendAddress"];
		$chkFieldList["sendAddressDesc"]=$jdata["deliveryInfo"][0]["sendAddressDesc"];
		$chkFieldList["receiveName"]=$jdata["deliveryInfo"][0]["receiveName"];
		$chkFieldList["receivePhone"]=$jdata["deliveryInfo"][0]["receivePhone"];
		$chkFieldList["receiveMobile"]=$jdata["deliveryInfo"][0]["receiveMobile"];
		$chkFieldList["receiveZipcode"]=$jdata["deliveryInfo"][0]["receiveZipcode"];
		$chkFieldList["receiveAddress"]=$jdata["deliveryInfo"][0]["receiveAddress"];
		$chkFieldList["receiveAddressDesc"]=$jdata["deliveryInfo"][0]["receiveAddressDesc"];
		$chkFieldList["receiveComment"]=$jdata["deliveryInfo"][0]["receiveComment"];
		$chkFieldList["receiveTied"]=$jdata["deliveryInfo"][0]["receiveTied"];
		

		//paymentInfo : 결제정보
		$amountTotal=$jdata["paymentInfo"][0]["amountTotal"]; //총주문금액
		$amountMedicine=$jdata["paymentInfo"][0]["amountMedicine"]; //약재
		$amountAddmedi=$jdata["paymentInfo"][0]["amountAddmedi"]; //별전
		$amountSweet=$jdata["paymentInfo"][0]["amountSweet"]; //감미제
		$amountPharmacy=$jdata["paymentInfo"][0]["amountPharmacy"]; //조제비
		$amountDecoction=$jdata["paymentInfo"][0]["amountDecoction"]; //탕전비
		$amountPackaging=$jdata["paymentInfo"][0]["amountPackaging"]; //포장비
		$amountDelivery=$jdata["paymentInfo"][0]["amountDelivery"]; //배송비
//		$amountSpecial=$jdata["paymentInfo"][0]["amountSpecial"]; //특수탕전비 
		

		$amountTotal=str_replace("원","",$amountTotal); //총주문금액
		$amountMedicine=str_replace("원","",$amountMedicine); //약재
		$amountAddmedi=str_replace("원","",$amountAddmedi); //별전
		$amountSweet=str_replace("원","",$amountSweet); //감미제
		$amountSpecial=str_replace("원","",$amountSpecial); //특수탕전비 
		$amountPharmacy=str_replace("원","",$amountPharmacy); //조제비
		$amountDecoction=str_replace("원","",$amountDecoction); //탕전비
		$amountPackaging=str_replace("원","",$amountPackaging); //포장비
		$amountDelivery=str_replace("원","",$amountDelivery); //배송비


		$amountTotal=!isEmpty($amountTotal)?$amountTotal:"0";
		$amountMedicine=!isEmpty($amountMedicine)?$amountMedicine:"0";
		$amountAddmedi=!isEmpty($amountAddmedi)?$amountAddmedi:"0";
		$amountSweet=!isEmpty($amountSweet)?$amountSweet:"0";
		$amountSpecial=!isEmpty($amountSpecial)?$amountSpecial:"0";
		$amountPharmacy=!isEmpty($amountPharmacy)?$amountPharmacy:"0";
		$amountDecoction=!isEmpty($amountDecoction)?$amountDecoction:"0";
		$amountPackaging=!isEmpty($amountPackaging)?$amountPackaging:"0";
		$amountDelivery=!isEmpty($amountDelivery)?$amountDelivery:"0";
		

		$chkFieldList["amountTotal"]=$amountTotal;
		$chkFieldList["amountMedicine"]=$amountMedicine;
		$chkFieldList["amountAddmedi"]=$amountAddmedi;
		$chkFieldList["amountSweet"]=$amountSweet;
		$chkFieldList["amountSpecial"]=$amountSpecial;
		$chkFieldList["amountPharmacy"]=$amountPharmacy;
		$chkFieldList["amountDecoction"]=$amountDecoction;
		$chkFieldList["amountPackaging"]=$amountPackaging;
		$chkFieldList["amountDelivery"]=$amountDelivery;


		//adviceInfo : 복약지도정보
		$foodAdvice=$jdata["adviceInfo"][0]["foodAdvice"]; //주의음식
		$cautionAdvice=$jdata["adviceInfo"][0]["cautionAdvice"]; //기타주의사항
		$foodAdvicFree=$jdata["adviceInfo"][0]["foodAdvicFree"]; //주의음식(FREETEXT)
		$cautionAdviceFree=$jdata["adviceInfo"][0]["cautionAdviceFree"]; //기타주의사항(FREETEXT)

		$chkFieldList["foodAdvice"]=$jdata["adviceInfo"][0]["foodAdvice"];
		$chkFieldList["cautionAdvice"]=$jdata["adviceInfo"][0]["cautionAdvice"];
		$chkFieldList["foodAdvicFree"]=$jdata["adviceInfo"][0]["foodAdvicFree"];
		$chkFieldList["cautionAdviceFree"]=$jdata["adviceInfo"][0]["cautionAdviceFree"];

		//labelInfo : 입원환자용라벨
		$wardNo=$jdata["labelInfo"][0]["wardNo"]; //병동코드
		$roomNo=$jdata["labelInfo"][0]["roomNo"]; //병실코드
		$bedNo=$jdata["labelInfo"][0]["bedNo"]; //베드코드
		$mediDays=$jdata["labelInfo"][0]["mediDays"]; //첩약기간
		$mediType=$jdata["labelInfo"][0]["mediType"]; //첩약종류
		$mediCapa=$jdata["labelInfo"][0]["mediCapa"]; //첩약용량
		$mediName=$jdata["labelInfo"][0]["mediName"]; //첩약명
		$mediAdvice=$jdata["labelInfo"][0]["mediAdvice"]; //복약지도

		$chkFieldList["wardNo"]=$jdata["labelInfo"][0]["wardNo"];
		$chkFieldList["roomNo"]=$jdata["labelInfo"][0]["roomNo"];
		$chkFieldList["bedNo"]=$jdata["labelInfo"][0]["bedNo"];
		$chkFieldList["mediDays"]=$jdata["labelInfo"][0]["mediDays"];
		$chkFieldList["mediType"]=$jdata["labelInfo"][0]["mediType"];
		$chkFieldList["mediCapa"]=$jdata["labelInfo"][0]["mediCapa"];
		$chkFieldList["mediName"]=$jdata["labelInfo"][0]["mediName"];
		$chkFieldList["mediAdvice"]=$jdata["labelInfo"][0]["mediAdvice"];
		//======

		//꼭 필요하지 않는 변수 
		$exfield=array("sweetMedi","orderComment","orderAdvice","cautionAdviceFree","foodAdvicFree","deliType",	"sendName",	"sendPhone","sendMobile","sendZipcode","sendAddress","sendAddressDesc","receiveName","receivePhone","receiveMobile","receiveZipcode","receiveAddress","receiveAddressDesc","receiveComment","receiveTied","markType","markText","specialDecoc","specialDecoctxt","amountTotal","amountMedicine","amountAddmedi","amountSweet","amountPharmacy","amountDecoction","amountPackaging","amountDelivery","packageInfo","amountSpecial","roomNo");
		foreach($chkFieldList as $key=>$value)
		{
			if(!$value)
			{
				if(in_array($key,$exfield))//예외처리
				{
				}
				else
				{
					$chkPostData=false;
					$chkPostKey=$key;
					break;
				}
			}
		}

		if($chkPostData==true)
		{
			$orderStatus="paid";
			
			$orderCode=$jdata["orderInfo"][0]["orderCode"];  //주문코드, CY주문코드

			$newODD=date("YmdHis");
			$keyCodeLast=getkeyCodeLast($newODD);
			$keyCode=$newODD.$keyCodeLast;
			
		
			if($orderCode)
			{
				$sql=" select orderCode from ".$dbH."_order_client a where ORDERCODE='".$orderCode."' ";
				$dt=dbone($sql);

				if($dt["ORDERCODE"])
				{
					$json["resultCode"]="205";
					$json["resultMessage"]="작업등록된 주문입니다.";
				}
				else
				{
					//$sql=" insert into han_order_client (SEQ, keyCode, ORDERCODE, jsonData, inDate) values ((SELECT NVL(MAX(SEQ),0)+1 FROM han_order_client), '".$keyCode."','".$orderCode."', ".$jsdata.", sysdate) ";
					//dbcommit($sql);
					$sql=" insert into han_order_client  (SEQ,KEYCODE,ORDERCODE,ORDERDATE,DELIVERYDATE,MEDICALCODE,MEDICALNAME,DOCTORCODE,DOCTORNAME,ORDERTITLE,ORDERTYPECODE,ORDERTYPE,ORDERCOUNT,PRODUCTCODE,PRODUCTCODENAME,ORDERCOMMENT,ORDERADVICE,ORDERSTATUS,PATIENTCODE,PATIENTNAME,PATIENTGENDER,PATIENTBIRTH,PATIENTPHONE,CHUBCNT,PACKCNT,PACKCAPA,TOTALMEDICINE,SWEETMEDI,SPECIALDECOC,SPECIALDECOCTXT,MARKTYPE,MARKTEXT,PACKAGEINFO,DELITYPE,SENDNAME,SENDPHONE,SENDMOBILE,SENDZIPCODE,SENDADDRESS,SENDADDRESSDESC,RECEIVENAME,RECEIVEPHONE,RECEIVEMOBILE,RECEIVEZIPCODE,RECEIVEADDRESS,RECEIVEADDRESSDESC,RECEIVECOMMENT,RECEIVETIED,AMOUNTTOTAL,AMOUNTMEDICINE,AMOUNTADDMEDI,AMOUNTSWEET,AMOUNTPHARMACY,AMOUNTDECOCTION,AMOUNTPACKAGING,AMOUNTDELIVERY,FOODADVICE,CAUTIONADVICE,FOODADVICFREE,CAUTIONADVICEFREE,WARDNO,ROOMNO,BEDNO,MEDIDAYS,MEDITYPE,MEDICAPA,MEDINAME,MEDIADVICE,JSONDATA,INDATE) values ((SELECT NVL(MAX(SEQ),0)+1 FROM han_order_client), '".$keyCode."','".$orderCode."','".$orderDate."','".$deliveryDate."','".$medicalCode."','".$medicalName."','".$doctorCode."','".$doctorName."','".$orderTitle."','".$orderTypeCode."','".$orderType."','".$orderCount."','".$productCode."','".$productCodeName."',".insertClob($orderComment).",".insertClob($orderAdvice).",'".$orderStatus."','".$patientCode."','".$patientName."','".$patientGender."','".$patientBirth."','".$patientPhone."','".$chubCnt."','".$packCnt."','".$packCapa."',".insertClob($totalMedicine).",'".$sweetMedi."','".$specialDecoc."','".$specialDecoctxt."','".$markType."','".$markText."',".insertClob($packinglist).",'".$deliType."','".$sendName."','".$sendPhone."','".$sendMobile."','".$sendZipcode."','".$sendAddress."','".$sendAddressDesc."','".$receiveName."','".$receivePhone."','".$receiveMobile."','".$receiveZipcode."','".$receiveAddress."','".$receiveAddressDesc."',".insertClob($receiveComment).",'".$receiveTied."','".$amountTotal."','".$amountMedicine."','".$amountAddmedi."','".$amountSweet."','".$amountPharmacy."','".$amountDecoction."','".$amountPackaging."','".$amountDelivery."',".insertClob($foodAdvice).",".insertClob($cautionAdvice).",".insertClob($foodAdvicFree).",".insertClob($cautionAdviceFree).",'".$wardNo."','".$roomNo."','".$bedNo."','".$mediDays."','".$mediType."','".$mediCapa."','".$mediName."','".$mediAdvice."', ".$jsdata.", sysdate) ";
					dbcommit($sql);


					include_once $root.$folder."/order/regist/ehdtodjmedi.php";


					$ssql=" select SEQ from han_order_client where KEYCODE='".$keyCode."' ";
					$sdt=dbone($ssql);
					if($sdt["SEQ"])
					{
						$json["keyCode"]=$keyCode;
						$json["resultCode"]="201";
						$json["resultMessage"]="OKOK";
					}
					else
					{
						$json["keyCode"]="";
						$json["resultCode"]="207";
						$json["resultMessage"]="주문 등록에 실패하였습니다.";
					}


				} 
			}
			else
			{
				$json["resultCode"]="202";
				$json["resultMessage"]="주문번호가 없습니다. 다시 확인해 주세요.";
			}
		}
		else
		{
			$json["resultCode"]="204";
			$json["resultMessage"]=$chkPostKey."값이 누락되었습니다.";
		}


		$json["apiCode"]=$apicode;
		$json["keyCode"]=$keyCode;
		$json["orderCode"]=$orderCode;



		$sjson=json_encode($json);

		$unescaped = preg_replace_callback('/\\\\u(\w{4})/', function ($matches) {
			return html_entity_decode('&#x' . $matches[1] . ';', ENT_COMPAT, 'UTF-8');
		}, $sjson);

		$sendjson=insertClob($unescaped);

		//ip
		$plip=$_SERVER["REMOTE_ADDR"];

		//LOG남기기
		$lsql=" insert into HAN_PNUHLOG  (PL_SEQ, PL_GETJSON, PL_SENDJSON, PL_IP, PL_DATE) values ((SELECT NVL(MAX(PL_SEQ),0)+1 FROM HAN_PNUHLOG), ".$jsdata.", ".$sendjson.", '".$plip."',sysdate) ";
		dbcommit($lsql);
		$json["lsql"]=$lsql;

	}
	
	include_once $root.$folder."/tail.php";
?>
