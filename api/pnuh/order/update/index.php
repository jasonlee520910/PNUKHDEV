<?php
	$root="../../..";
	$folder="/pnuh";
	include_once $root.$folder."/head.php";

	$json["resultCode"]="404";
	$json["resultMessage"]="regist API(apiCode) ERROR";
	$jdata=json_decode($_POST["data"],true);
	//$jdata=json_decode($_GET["data"],true);
	$jsonData=$_POST["data"];

	//------------------------------------------
	// 테스트 
	//------------------------------------------
	/*
	$jsonString = '{"apiCode":"orderupdate","keyCode":"2020011512272100001","language":"kor","orderInfo":[{"orderCode":"72","orderDate":"2018-06-04 10:46:39","deliveryDate":"2018-06-07","medicalName":"청연_상무한방","medicalCode":"7","doctorName":"정서연","doctorCode":"108","orderTitle":"청연_자근탕(60첩 60팩 120cc)","orderType":"상용처방","orderCount":"1","productCode":"","patientName":"남/11층 한방병동/19950109/010-1234-5678","orderComment":"","orderAdvice":"12121","orderStatus":"cart"}],"recipeInfo":null,"decoctionInfo":null,"markingInfo":null,"packageInfo":null,"deliveryInfo":[{"deliType":"직배","recieveName":"청연_상무한방","recievePhone":"062-371-1075","recieveMobile":"062-371-1075","recieveZipcode":"61949","recieveAddress":"광주 서구 상무중앙로 64","recieveAddressDesc":"5층, 9~13층(치평동)","recieveComment":"","deliveryCompany":null,"deliveryNo":null}],"paymentInfo":[{"amountTotal":"47280","amountMedicine":"0","amountAddmedi":"0","amountSweet":"0","amountPharmacy":"0","amountDecoction":"0","amountPackaging":"0","amountDelivery":"4000"}],"sweetMedi":null}';
	$jdata = json_decode($jsonString, true);
	$jsonData=$jsonString;
	*/
	//------------------------------------------

	$apicode=$jdata["apiCode"];
	$keyCode=$jdata["keyCode"];//djmedi keycode 
	if($apicode!="orderupdate"){$json["resultMessage"]="API(apiCode) ERROR2";$apicode="orderupdate";}
	else if($keyCode=="" || $keyCode==null){$json["resultMessage"]="API(keyCode) ERROR";}
	else
	{
		$orderCode=$jdata["orderInfo"][0]["orderCode"];  //주문코드, CY주문코드
		$orderDate=$jdata["orderInfo"][0]["orderDate"]; //주문일
		$deliveryDate=$jdata["orderInfo"][0]["deliveryDate"];  //배송희망일
		$medicalName=$jdata["orderInfo"][0]["medicalName"];  //한의원명
		$medicalCode=$jdata["orderInfo"][0]["medicalCode"];  //한의원코드 

		$doctorName=$jdata["orderInfo"][0]["doctorName"];  //처방자
		$doctorCode=$jdata["orderInfo"][0]["doctorCode"];  //처방자코드 
		$orderTitle=$jdata["orderInfo"][0]["orderTitle"]; //처방명
		$orderType=$jdata["orderInfo"][0]["orderType"];  //조제타입

		//20200113:주문상태 추가 
		$orderStatus=$jdata["orderInfo"][0]["orderStatus"];  //주문상태 

		//20191021 주문갯수 orderCount 추가 
		$orderCount=$jdata["orderInfo"][0]["orderCount"];  //주문갯수
		//20191021 약속처방데이터 PK productCode 추가 
		$productCode=$jdata["orderInfo"][0]["productCode"];  //약속처방데이터 PK 
		//20191031 조제지시(주문자요청사항) 추가 
		//$orderComment=$jdata["orderInfo"][0]["orderComment"];
		$orderComment=str_replace("'"," ",$jdata["orderInfo"][0]["orderComment"]); //주문자요청사항
		//20191031 복약지도서 추가 
		//$orderAdvice=$jdata["orderInfo"][0]["orderAdvice"];
		$orderAdvice=str_replace("'"," ",$jdata["orderInfo"][0]["orderAdvice"]); //복약지도서
		//20191101 : 환자명추가
		$patientName=$jdata["orderInfo"][0]["patientName"];

		$chubCnt=$jdata["recipeInfo"][0]["chubCnt"];  //첩수
		$packCnt=$jdata["recipeInfo"][0]["packCnt"];  //팩수
		$packCapa=$jdata["recipeInfo"][0]["packCapa"];  //팩용량

		$totalMedicine="";
		$arr=$jdata["recipeInfo"][0]["totalMedicine"];  //총약재량
		foreach($arr as $val) 
		{
			$mediType=$val["mediType"];  //처방타입
			$mediCode=$val["mediCode"];  //약재코드
			$mediName=str_replace(",","/",$val["mediName"]); //약재명
			$mediName=str_replace("_","/",$mediName); //약재명
			$mediName=str_replace(" ","",$mediName); //약재명
			$mediPoison=$val["mediPoison"];  //독성
			$mediDismatch=$val["mediDismatch"];  //상극
			$mediOrigin=$val["mediOrigin"];  //원산지
			$mediCapa=$val["mediCapa"];  //첩당약재량
			$mediAmount=$val["mediAmount"];  //첩당약재비
			$totalMedicine.="|".$mediType.",".$mediCode.",".$mediName.",".$mediPoison.",".$mediDismatch.",".$mediOrigin.",".$mediCapa.",".$mediAmount;
		}

		//20191101 : 감미제 추가 
		$sweetMedi=$jdata["sweetMedi"];

		//20191112 : 특수탕전,마킹정보 
		$specialDecoc=$jdata["decoctionInfo"][0]["specialDecoc"];  //탕전정보-특수탕전
		$markType=$jdata["markingInfo"][0]["markType"];  //마킹정보-마킹형태
		$markText=$jdata["markingInfo"][0]["markText"];  //마킹정보-마킹내용

		$packinglist="";
		$arr=$jdata["packageInfo"];  //총포장재
		foreach($arr as $val)
		{
			$packType=$val["packType"]; //포장재종류
			$packCode=$val["packCode"];  //포장재코드 
			$packName=$val["packName"];  //포장재명
			$packImage=$val["packImage"];  //포장재이미지
			$packAmount=$val["packAmount"];  //개별포장재비
			$packinglist.="|".$packType.",".$packCode.",".$packName.",".$packImage.",".$packAmount;
		}

		$deliType=$jdata["deliveryInfo"][0]["deliType"]; //배송종류
		$recieveName=$jdata["deliveryInfo"][0]["recieveName"];  //받는사람
		$recievePhone=$jdata["deliveryInfo"][0]["recievePhone"];  //전화번호
		$recieveMobile=$jdata["deliveryInfo"][0]["recieveMobile"];  //휴대폰번호		
		$recieveZipcode=$jdata["deliveryInfo"][0]["recieveZipcode"];  //우편번호 

		$recieveAddress=str_replace("'"," ",$jdata["deliveryInfo"][0]["recieveAddress"]); //주소
		$recieveAddressDesc=str_replace("'"," ",$jdata["deliveryInfo"][0]["recieveAddressDesc"]); //주소
		
		$recieveComment=str_replace("'"," ",$jdata["deliveryInfo"][0]["recieveComment"]); //배송요구사항

		$amountTotal=$jdata["paymentInfo"][0]["amountTotal"]; //총주문금액
		$amountMedicine=$jdata["paymentInfo"][0]["amountMedicine"]; //약재
		$amountAddmedi=$jdata["paymentInfo"][0]["amountAddmedi"]; //별전
		$amountSweet=$jdata["paymentInfo"][0]["amountSweet"];  //감미제
		$amountPharmacy=$jdata["paymentInfo"][0]["amountPharmacy"]; //조제비
		$amountDecoction=$jdata["paymentInfo"][0]["amountDecoction"]; //탕전비
		$amountPackaging=$jdata["paymentInfo"][0]["amountPackaging"]; //포장비
		$amountDelivery=$jdata["paymentInfo"][0]["amountDelivery"]; //배송비

		
		$usql=" select orderStatus from ".$dbH."_order_cy where keycode= '".$keyCode."' ";
		$udt=dbone($usql);


		if($udt["orderStatus"])
		{
			if($udt["orderStatus"]=="done")
			{
				$json["resultCode"]="205";
				$json["resultMessage"]="작업등록된 주문입니다.";
			}
			else if($udt["orderStatus"]=="cart")
			{
				//20191021 : orderCount, productCode 추가 
				//20191031 : orderComment 추가 , orderAdvice 추가 
				//20191101 : patientName 추가 
				//20191107 : recieveAddressDesc 추가 
				//20191112 :specialDecoc,markType,markText 추가
				$sql=" update han_order_cy set 
					orderDate='".$orderDate."', 
					deliveryDate='".$deliveryDate."',  
					medicalName='".$medicalName."',
					medicalCode='".$medicalCode."',  
					doctorName='".$doctorName."', 
					doctorCode='".$doctorCode."', 
					patientName='".$patientName."', 
					orderTitle='".$orderTitle."', 
					orderCount='".$orderCount."', 
					productCode='".$productCode."', 
					orderType='".$orderType."', 
					orderComment='".$orderComment."', 
					orderAdvice='".$orderAdvice."', 
					chubCnt='".$chubCnt."', 
					packCnt='".$packCnt."', 
					packCapa='".$packCapa."', 
					totalMedicine='".$totalMedicine."', 
					sweetMedi='".$sweetMedi."', 
					specialDecoc='".$specialDecoc."', 
					markType='".$markType."', 
					markText='".$markText."', 
					packageInfo='".$packinglist."', 
					deliType='".$deliType."', 
					recieveName='".$recieveName."', 
					recievePhone='".$recievePhone."', 
					recieveMobile='".$recieveMobile."', 
					recieveZipcode='".$recieveZipcode."', 
					recieveAddress='".$recieveAddress."',
					recieveAddressDesc='".$recieveAddressDesc."', 
					recieveComment='".$recieveComment."',
					amountTotal='".$amountTotal."',
					amountMedicine='".$amountMedicine."',
					amountAddmedi='".$amountAddmedi."',
					amountSweet='".$amountSweet."',
					amountPharmacy='".$amountPharmacy."',
					amountDecoction='".$amountDecoction."',
					amountPackaging='".$amountPackaging."',
					amountDelivery='".$amountDelivery."', 
					jsonData='".$jsonData."', 
					modifyDate=now()
					where keycode='".$keyCode."' ";


				$json["sql"]=$sql;
				dbqry($sql);	

				include_once $root.$folder."/order/regist/cytodjmedi.php";

				$json["resultCode"]="200";
				$json["resultMessage"]="OK";

			}
			else
			{
				$json["resultCode"]="207";
				$json["resultMessage"]="삭제되거나 없는 keyCode입니다.";
			}
		}
		else
		{
			$json["resultCode"]="207";
			$json["resultMessage"]="삭제되거나 없는 keyCode입니다.";
		}

		$json["apiCode"]=$apicode;
		$json["keyCode"]=$keyCode;
			
	}
	
	include_once $root.$folder."/tail.php";
?>
