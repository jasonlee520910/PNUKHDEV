<?php
	//MEDICAL 주문등록 
	$json["resultCode"]="404";
	$json["resultMessage"]="regist API(apiCode) ERROR";
	$jdata=json_decode($_POST["data"],true);
	$jsonData=$_POST["data"];

	$apicode=$jdata["apiCode"];	

	if($apicode!="orderregist"){$json["resultMessage"]="API(apiCode) ERROR";$apicode="orderregist";}
	else
	{
		$chkPostData=true;
		$chkPostKey="";
		$chkFieldList=array();
		//MEDICAL에서 넘어온 주문 저장 

		//======
		//orderInfo : 주문정보 
		$odkeycode=$jdata["orderInfo"][0]["keycode"];//주문코드, 부산대주문코드

		if($odkeycode)
		{
			$keyCode=$odkeycode;
		}
		else
		{
			$newODD=date("YmdHis");
			$keyCodeLast=getkeyCodeLast($newODD);
			$keyCode=$newODD.$keyCodeLast;

			//keycode가 있는지 체크 여부 
			$chkkey=chkkeyCode($keyCode);
			if($chkkey==false)
			{
				$newODD=date("YmdHis");
				$keyCodeLast=getkeyCodeLast($newODD);
				$keyCode=$newODD.$keyCodeLast;
			}


			$jdata["orderInfo"][0]["keycode"]=$keyCode;
			$jsonData=json_encode($jdata);
		}

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

		$orderCommentKey=(isEmpty($jdata["orderInfo"][0]["orderCommentKey"])==false)?$jdata["orderInfo"][0]["orderCommentKey"]:0;//조제지시seq
		$orderAdviceKey=(isEmpty($jdata["orderInfo"][0]["orderAdviceKey"])==false)?$jdata["orderInfo"][0]["orderAdviceKey"]:0;//복약지도서seq


		$orderStatus=$jdata["orderInfo"][0]["orderStatus"];//주문상태 cart(장바구니),paid(결재완료),done(등록완료)
		$chkFieldList["orderStatus"]=$jdata["orderInfo"][0]["orderStatus"];
			
		//patientInfo : 환자정보 
		$patientCode=$jdata["patientInfo"][0]["patientCode"];//환자코드
		$patientName=$jdata["patientInfo"][0]["patientName"];//환자명
		$patientGender=$jdata["patientInfo"][0]["patientGender"];//성별 male:남, female:여
		$patientBirth=$jdata["patientInfo"][0]["patientBirth"];//생년월일
		$patientPhone=$jdata["patientInfo"][0]["patientPhone"];//전화번호 
		$patientmemo=$jdata["patientInfo"][0]["patientmemo"];//처방할때 환자메모

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
			if(isEmpty($val["mediCode"])==false)
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
		$chkFieldList["totalMedicine"]=$totalMedicine;

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
		$chkFieldList["sweetMedi"]=$jdata["recipeInfo"][0]["sweetMedi"];

		//감미제 
		$arr3=$jdata["recipeInfo"][0]["sugarMedi"];
		$sugarMedi="";
		foreach($arr3 as $val) 
		{
			if(isEmpty($val["sugarCode"])==false)
			{
				$sugarCode=$val["sugarCode"];//감미제코드
				$sugarName=$val["sugarName"];//감미제명
				$sugarCapa=$val["sugarCapa"];//감미제량
				$sugarPrice=$val["sugarPrice"];//감미제가격 
				$sugarTotalCapa=$val["sugarTotalCapa"];//감미제들어갈양  

				$sugarMedi=$sugarCode.",".$sugarName.",".$sugarCapa.",".$sugarTotalCapa.",".$sugarPrice;
			}
		}
		$chkFieldList["sugarMedi"]=$jdata["recipeInfo"][0]["sugarMedi"];
		
		//decoctionInfo : 탕전정보
		$specialDecoc=$jdata["decoctionInfo"][0]["specialDecoc"];//특수탕전코드
		$specialDecoctxt=$jdata["decoctionInfo"][0]["specialDecoctxt"];//특수탕전명 예)주수상반
		$specialDecocprice=$jdata["decoctionInfo"][0]["specialDecocprice"];//특수탕전명 예)주수상반
		$chkFieldList["specialDecoc"]=$jdata["decoctionInfo"][0]["specialDecoc"];
		$chkFieldList["specialDecoctxt"]=$jdata["decoctionInfo"][0]["specialDecoctxt"];
		$chkFieldList["specialDecocprice"]=$jdata["decoctionInfo"][0]["specialDecocprice"];
		

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
			if(isEmpty($val["packCode"])==false)
			{
				$packType=$val["packType"]; //포장재종류 pouch(파우치),medibox(한약박스),delibox(배송박스)
				$packCode=$val["packCode"]; //포장재코드
				$packName=$val["packName"]; //포장재명
				$packImage=$val["packImage"]; //포장재이미지 URL
				$packAmount=$val["packAmount"]; //개별포장재비
				$packMaxCapa=$val["packCapa"]; //개별포장재비

				$packinglist.="|".$packType.",".$packCode.",".$packName.",".$packImage.",".$packAmount.",".$packMaxCapa;
			}
		}
		$chkFieldList["packageInfo"]=$packinglist;

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
		

		$chkFieldList["amountTotal"]=$amountTotal;
		$chkFieldList["amountMedicine"]=$amountMedicine;
		$chkFieldList["amountAddmedi"]=$amountAddmedi;
		$chkFieldList["amountSugar"]=$amountSugar;
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


		if($orderStatus=="temp")//임시저장이라면 
		{
			if(isEmpty($orderCode)==false)
			{
				$chkPostData=true;
			}
			else
			{
				$chkPostData=false;
				$chkPostKey="orderCode";
				
			}	
		}
		else
		{
			//꼭 필요하지 않는 변수 
			$exfield=array("sugarMedi","sweetMedi","orderComment","orderAdvice","cautionAdviceFree","foodAdvicFree","wardNo","roomNo","bedNo","mediDays","mediType","mediCapa","mediName","mediAdvice","foodAdvice","cautionAdvice","foodAdvicFree","cautionAdviceFree","productCode","productCodeName","markText","amountAddmedi","amountSugar","amountSpecial","amountSweet","receiveTied","receiveComment","specialDecoc","specialDecoctxt","specialDecocprice");
			foreach($chkFieldList as $key=>$value)
			{
				if(isEmpty($value)==true)
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
		}

		

		if($chkPostData==true)
		{
			$jsdata=insertClob($jsonData);

			$sql=" select SEQ, KEYCODE, ORDERCODE from ".$dbH."_order_medical where ORDERCODE='".$orderCode."' ";
			$dt=dbone($sql);
			if($dt["SEQ"])
			{
				$sql=" update han_order_medical set ORDERDATE=TO_DATE('".$orderDate."','YYYY-MM-DD HH24:MI:SS')	,DELIVERYDATE=TO_DATE('".$deliveryDate."','YYYY-MM-DD HH24:MI:SS')	,MEDICALCODE='".$medicalCode."'	,MEDICALNAME='".$medicalName."',DOCTORCODE='".$doctorCode."',DOCTORNAME='".$doctorName."',ORDERTITLE='".$orderTitle."'	,ORDERTYPECODE='".$orderTypeCode."'	,ORDERTYPE='".$orderType."',ORDERCOUNT='".$orderCount."',PRODUCTCODE='".$productCode."',PRODUCTCODENAME='".$productCodeName."',ORDERCOMMENT=".insertClob($orderComment).",ORDERADVICE=".insertClob($orderAdvice).",ORDERSTATUS='".$orderStatus."',PATIENTCODE='".$patientCode."',PATIENTNAME='".$patientName."',PATIENTGENDER='".$patientGender."',PATIENTBIRTH='".$patientBirth."',PATIENTPHONE='".$patientPhone."',CHUBCNT='".$chubCnt."',PACKCNT='".$packCnt."',PACKCAPA='".$packCapa."',TOTALMEDICINE=".insertClob($totalMedicine).",SWEETMEDI='".$sweetMedi."',SPECIALDECOC='".$specialDecoc."',SPECIALDECOCTXT='".$specialDecoctxt."',MARKTYPE='".$markType."',MARKTEXT='".$markText."',PACKAGEINFO=".insertClob($packinglist).",DELITYPE='".$deliType."',SENDNAME='".$sendName."',SENDPHONE='".$sendPhone."',SENDMOBILE='".$sendMobile."',SENDZIPCODE='".$sendZipcode."',SENDADDRESS='".$sendAddress."',SENDADDRESSDESC='".$sendAddressDesc."',RECEIVENAME='".$receiveName."',RECEIVEPHONE='".$receivePhone."',RECEIVEMOBILE='".$receiveMobile."',RECEIVEZIPCODE='".$receiveZipcode."',RECEIVEADDRESS='".$receiveAddress."',RECEIVEADDRESSDESC='".$receiveAddressDesc."',RECEIVECOMMENT=".insertClob($receiveComment).",RECEIVETIED='".$receiveTied."',AMOUNTTOTAL='".$amountTotal."',AMOUNTMEDICINE='".$amountMedicine."',AMOUNTADDMEDI='".$amountAddmedi."',AMOUNTSWEET='".$amountSugar."',AMOUNTPHARMACY='".$amountPharmacy."',AMOUNTDECOCTION='".$amountDecoction."',AMOUNTSPECIAL='".$amountSpecial."',AMOUNTPACKAGING='".$amountPackaging."',AMOUNTDELIVERY='".$amountDelivery."',FOODADVICE=".insertClob($foodAdvice).",CAUTIONADVICE=".insertClob($cautionAdvice).",FOODADVICFREE=".insertClob($foodAdvicFree).",CAUTIONADVICEFREE=".insertClob($cautionAdviceFree).",WARDNO='".$wardNo."',ROOMNO='".$roomNo."',BEDNO='".$bedNo."',MEDIDAYS='".$mediDays."',MEDITYPE='".$mediType."',MEDICAPA='".$mediCapa."',MEDINAME='".$mediName."',MEDIADVICE='".$mediAdvice."',ORDERADVICEKEY='".$orderAdviceKey."', ORDERCOMMENTKEY='".$orderCommentKey."', JSONDATA=".$jsdata.",patientmemo='".$patientmemo."', MODIFYDATE=sysdate where ORDERCODE='".$orderCode."' ";
				dbcommit($sql);

				$json["han_order_medical_sql"]=$sql;

				$json["seq"]=$dt["SEQ"];
				$json["keyCode"]=$dt["KEYCODE"];
				$json["resultCode"]="200";
				$json["resultMessage"]="OK";

			}
			else
			{	

				$sql=" insert into han_order_medical (SEQ,KEYCODE,ORDERCODE,ORDERDATE,DELIVERYDATE,MEDICALCODE,MEDICALNAME,DOCTORCODE,DOCTORNAME,ORDERTITLE,ORDERTYPECODE,ORDERTYPE,ORDERCOUNT,PRODUCTCODE,PRODUCTCODENAME,ORDERCOMMENT,ORDERADVICE,ORDERSTATUS,PATIENTCODE,PATIENTNAME,PATIENTGENDER,PATIENTBIRTH,PATIENTPHONE,CHUBCNT,PACKCNT,PACKCAPA,TOTALMEDICINE,SWEETMEDI,SPECIALDECOC,SPECIALDECOCTXT,MARKTYPE,MARKTEXT,PACKAGEINFO,DELITYPE,SENDNAME,SENDPHONE,SENDMOBILE,SENDZIPCODE,SENDADDRESS,SENDADDRESSDESC,RECEIVENAME,RECEIVEPHONE,RECEIVEMOBILE,RECEIVEZIPCODE,RECEIVEADDRESS,RECEIVEADDRESSDESC,RECEIVECOMMENT,RECEIVETIED,AMOUNTTOTAL,AMOUNTMEDICINE,AMOUNTADDMEDI,AMOUNTSWEET,AMOUNTPHARMACY,AMOUNTDECOCTION,AMOUNTPACKAGING,AMOUNTDELIVERY,AMOUNTSPECIAL, FOODADVICE,CAUTIONADVICE,FOODADVICFREE,CAUTIONADVICEFREE,WARDNO,ROOMNO,BEDNO,MEDIDAYS,MEDITYPE,MEDICAPA,MEDINAME,MEDIADVICE,ORDERADVICEKEY, ORDERCOMMENTKEY, JSONDATA,INDATE,PATIENTMEMO) values ((SELECT NVL(MAX(SEQ),0)+1 FROM han_order_medical), '".$keyCode."','".$orderCode."',TO_DATE('".$orderDate."','YYYY-MM-DD HH24:MI:SS'),TO_DATE('".$deliveryDate."','YYYY-MM-DD HH24:MI:SS'),'".$medicalCode."','".$medicalName."','".$doctorCode."','".$doctorName."','".$orderTitle."','".$orderTypeCode."','".$orderType."','".$orderCount."','".$productCode."','".$productCodeName."',".insertClob($orderComment).",".insertClob($orderAdvice).",'".$orderStatus."','".$patientCode."','".$patientName."','".$patientGender."','".$patientBirth."','".$patientPhone."','".$chubCnt."','".$packCnt."','".$packCapa."',".insertClob($totalMedicine).",'".$sweetMedi."','".$specialDecoc."','".$specialDecoctxt."','".$markType."','".$markText."',".insertClob($packinglist).",'".$deliType."','".$sendName."','".$sendPhone."','".$sendMobile."','".$sendZipcode."','".$sendAddress."','".$sendAddressDesc."','".$receiveName."','".$receivePhone."','".$receiveMobile."','".$receiveZipcode."','".$receiveAddress."','".$receiveAddressDesc."',".insertClob($receiveComment).",'".$receiveTied."','".$amountTotal."','".$amountMedicine."','".$amountAddmedi."','".$amountSugar."','".$amountPharmacy."','".$amountDecoction."','".$amountPackaging."','".$amountDelivery."','".$amountSpecial."',".insertClob($foodAdvice).",".insertClob($cautionAdvice).",".insertClob($foodAdvicFree).",".insertClob($cautionAdviceFree).",'".$wardNo."','".$roomNo."','".$bedNo."','".$mediDays."','".$mediType."','".$mediCapa."','".$mediName."','".$mediAdvice."', '".$orderAdviceKey."','".$orderCommentKey."',".$jsdata.", sysdate,'".$patientmemo."') ";
				dbcommit($sql);

				$json["han_order_medical_sql"]=$sql;

				
				$ssql=" select SEQ from ".$dbH."_order_medical where KEYCODE='".$keyCode."' ";
				$sdt=dbone($ssql);
				if($sdt["SEQ"])
				{
					$json["seq"]=$sdt["SEQ"];
					$json["keyCode"]=$keyCode;
					$json["resultCode"]="200";
					$json["resultMessage"]="OK";
				}
				else
				{
					$json["keyCode"]="";
					$json["resultCode"]="207";
					$json["resultMessage"]="주문 등록에 실패하였습니다.";
				}
			}



			/*if($orderStatus=="paid")//temp:임시저장, cart:장바구니, paid : 결재완료 
			{
				if($odkeycode)
				{
					$sql=" select OD_SEQ from ".$dbH."_order where OD_KEYCODE='".$odkeycode."' ";
					$dt=dbone($sql);

					if(!$dt["OD_SEQ"])
					{
						include_once $root.$folder."/order/medicaltodjmedi.php";
					}
				}
			}*/

		}
		else
		{
			$json["resultCode"]="204";
			$json["resultMessage"]=$chkPostKey."값이 누락되었습니다.";
			$json["data"]=$chkFieldList;
		}

		$json["type"]=$jdir;
		$json["jsonData"]=$jsonData;
		$json["apiCode"]=$apicode;
		$json["keyCode"]=$keyCode;
		$json["orderCode"]=$orderCode;
	}

	
?>
