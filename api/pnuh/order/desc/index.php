<?php
	$root="../../..";
	$folder="/pnuh";
	include_once $root.$folder."/head.php";

	$json["resultCode"]="404";
	$json["resultMessage"]="regist API(apiCode) ERROR";

	$apicode=$_GET["apiCode"];
	$keyCode=$_GET["keyCode"];
	if($apicode!="orderdesc"){$json["resultMessage"]="API(apiCode) ERROR2";$apicode="orderdesc";}
	else if($keyCode==""){$json["resultMessage"]="API(keyCode) ERROR";}
	else
	{
		if($keyCode)
		{
			$sql=" select ";
			$sql.=" b.re_delino,b.re_delicomp,b.re_deliexception,c.od_status, a.* ";
			$sql.=" from han_order_cy ";
			$sql.=" a inner join han_release b on b.re_keycode=a.keycode ";
			$sql.=" inner join han_order c on c.od_keycode=a.keycode ";
			$sql.=" where keyCode = '".$keyCode."' ";
			$dt=dbone($sql);

			$totalMedicine=array();
			$arr=explode("|",$dt["totalMedicine"]);
			for($i=1;$i<count($arr);$i++)
			{
				$arr2=explode(",",$arr[$i]);
				//|,504,일당귀,,,중국,3.0,117.0|
				$mediType=$arr2[0];  //처방타입
				$mediCode=$arr2[1]; //약재명
				$mediName=$arr2[2]; //약재명
				$mediPoison=$arr2[3];  //독성
				$mediDismatch=$arr2[4];  //상극
				$mediOrigin=$arr2[5];  //원산지
				$mediCapa=$arr2[6];  //첩당약재량
				$mediAmount=$arr2[7];  //첩당약재비
				$addarray=array("mediType"=>$mediType,"mediCode"=>$mediCode,"mediName"=>$mediName,"mediPoison"=>$mediPoison,"mediDismatch"=>$mediDismatch,"mediOrigin"=>$mediOrigin,"mediCapa"=>$mediCapa,"mediAmount"=>$mediAmount);
				array_push($totalMedicine, $addarray);
			}

			$packageInfo=array();
			$arr3=explode("|",$dt["packageInfo"]);
			for($i=1;$i<count($arr3);$i++)
			{
				$arr4=explode(",",$arr3[$i]);
				//|한약박스,,파란색,file/download?ty=option&dn=inline&fn=option_347.png,

				$packType=$arr4[0];//포장재종류
				$packCode=$arr4[1];//포장재코드
				$packName=$arr4[2];//포장재명
				$packImage=$arr4[3];//포장재이미지
				$packAmount=$arr4[4];//포장재비
				$addarray=array("packType"=>$packType,"packCode"=>$packCode,"packName"=>$packName,"packImage"=>$packImage,"packAmount"=>$packAmount);
				array_push($packageInfo, $addarray);
			}

			$re_deliexception=$dt["re_deliexception"];
			$reDelicomp=$reDelicompO=$reDelicompT="";
			if(strpos($re_deliexception, "D") !== false)
			{
				$reDelicomp="직배";
			}
			else
			{
				if($dt["re_delicomp"]=="POST" || $dt["re_delicomp"]=="post")
				{
					$reDelicomp="우체국";
				}
				else if($dt["re_delicomp"]=="CJ" || $dt["re_delicomp"]=="cj")
				{
					$reDelicomp="CJ";
				}
				else if($dt["re_delicomp"]=="DIRECT" || $dt["re_delicomp"]=="direct")
				{
					$reDelicomp="직배";
				}
				else
				{
					$reDelicomp="로젠";
				}
			}

			if(strpos($re_deliexception, "O") !== false)
			{
				$reDelicompO="해외";
			}
			if(strpos($re_deliexception, "T") !== false)
			{
				$reDelicompT="묶음";
			}

			$re_delino=($dt["re_delino"]) ? $dt["re_delino"] : "";

			$orderInfo=array(
				"orderCode"=>$dt["orderCode"], //주문코드, CY주문코드
				"orderDate"=>$dt["orderDate"], //주문일
				"deliveryDate"=>$dt["deliveryDate"],  //배송희망일
				"medicalCode"=>$dt["medicalCode"], //한의원
				"medicalName"=>$dt["medicalName"], //한의원
				"doctorCode"=>$dt["doctorCode"], //처방자
				"doctorName"=>$dt["doctorName"], //처방자
				"patientName"=>$dt["patientName"], //환자명
				"orderTitle"=>$dt["orderTitle"], //처방명
				"orderType"=>$dt["orderType"], //조제타입

				"orderCount"=>$dt["orderCount"], //주문갯수 
				"productCode"=>$dt["productCode"], //처방pk
				"orderComment"=>$dt["orderComment"], //조제지시서
				"orderAdvice"=>$dt["orderAdvice"] //복약지도서
				
				);

			$recipeInfo=array(
				"chubCnt"=>$dt["chubCnt"], //첩수
				"packCnt"=>$dt["packCnt"], //팩수
				"packCapa"=>$dt["packCapa"], //팩용량
				"totalMedicine"=>$totalMedicine,
				"sweetMedi"=>$dt["sweetMedi"] //감미제 
				);


			$specialDecoc=($dt["specialDecoc"])?$dt["specialDecoc"]:"";
			$decoctionInfo=array(
				"specialDecoc"=>$specialDecoc //탕전정보 
				);

			$markType=($dt["markType"])?$dt["markType"]:"";
			$markText=($dt["markText"])?$dt["markText"]:"";

			$markingInfo=array(
				"markType"=>$markType, //마킹형태 
				"markText"=>$markText//마킹내용 
				);


			$receiveZipcode=($dt["receiveZipcode"])?$dt["receiveZipcode"]:"";
			$recieveAddressDesc=($dt["recieveAddressDesc"])?$dt["recieveAddressDesc"]:"";
			$deliveryInfo=array(
				"deliType"=>$dt["deliType"], 
				"recieveName"=>$dt["recieveName"], 
				"recievePhone"=>$dt["recievePhone"], 
				"recieveMobile"=>$dt["recieveMobile"], 
				"receiveZipcode"=>$receiveZipcode, 
				"recieveAddress"=>$dt["recieveAddress"], 
				"recieveAddressDesc"=>$recieveAddressDesc, 
				"recieveComment"=>$dt["recieveComment"],
				"deliveryCompany"=>$reDelicomp,  //배송회사
				"deliveryNo"=>$re_delino  //송장번호
				);
			$paymentInfo=array(
				"amountTotal"=>$dt["amountTotal"], 
				"amountMedicine"=>$dt["amountMedicine"], 
				"amountAddmedi"=>$dt["amountAddmedi"], 
				"amountSweet"=>$dt["amountSweet"], 
				"amountPharmacy"=>$dt["amountPharmacy"], 
				"amountDecoction"=>$dt["amountDecoction"], 
				"amountPackaging"=>$dt["amountPackaging"], 
				"amountDelivery"=>$dt["amountDelivery"] 
				);


			$json["orderInfo"]=$orderInfo;
			$json["recipeInfo"]=$recipeInfo;
			$json["decoctionInfo"]=$decoctionInfo;
			$json["markingInfo"]=$markingInfo;

			$json["packageInfo"]=$packageInfo;
			$json["deliveryInfo"]=$deliveryInfo;
			$json["paymentInfo"]=$paymentInfo;

			
		}
		$json["resultCode"]="200";
		$json["resultMessage"]="OK";
		$json["apiCode"]=$apicode;
	}
	
	include_once $root.$folder."/tail.php";
?>
