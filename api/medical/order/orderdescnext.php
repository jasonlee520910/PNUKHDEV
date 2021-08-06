<?php  ///주문상세  
	$apiCode=$_GET["apiCode"];
	$language=$_GET["language"];
	$seq=$_GET["seq"];

	if($apiCode!="orderdescnext"){$json["resultMessage"]="API(apiCode) ERROR";$apiCode="orderdescnext";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="API(language) ERROR";}
	else
	{
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
				$keycode=$dt["KEYCODE"];//주문코드, 부산대주문코드

				//배송정보  
				$deliveryInfo=$jsondatadjmedi["deliveryInfo"][0];

				$sendName=$deliveryInfo["sendName"];
				$sendPhone=$deliveryInfo["sendPhone"];
				$sendMobile=$deliveryInfo["sendMobile"];
				$sendZipcode=$deliveryInfo["sendZipcode"];
				$sendAddress=$deliveryInfo["sendAddress"];
				$sendAddressDesc=$deliveryInfo["sendAddressDesc"];
				$receiveName=$deliveryInfo["receiveName"];
				$receivePhone=$deliveryInfo["receivePhone"];
				$receiveMobile=$deliveryInfo["receiveMobile"];
				$receiveZipcode=$deliveryInfo["receiveZipcode"];
				$receiveAddress=$deliveryInfo["receiveAddress"];
				$receiveAddressDesc=$deliveryInfo["receiveAddressDesc"];
				$receiveComment=$deliveryInfo["receiveComment"];
				$receiveTied=$deliveryInfo["receiveTied"];
				$sendType=$deliveryInfo["sendType"];
				$receiveType=$deliveryInfo["receiveType"];

				
				$sendPhoneA=explode("-",$sendPhone);
				$sendMobileA=explode("-",$sendMobile);

				$receivePhoneA=explode("-",$receivePhone);
				$receiveMobileA=explode("-",$receiveMobile);

				$json=array(
					"seq"=>$dt["SEQ"], 
					//주문정보 
					"keycode"=>$keycode, 

					"jsondatadjmedi"=>$jsondatadjmedi, 
					"deliveryInfo"=>$deliveryInfo, 
					
					"sendName"=>$sendName,

					"sendPhone"=>$sendPhone,
					"sendMobile"=>$sendMobile,
					"receivePhone"=>$receivePhone,
					"receiveMobile"=>$receiveMobile,

					"sendPhone0"=>$sendPhoneA[0],
					"sendPhone1"=>$sendPhoneA[1],
					"sendPhone2"=>$sendPhoneA[2],

					"sendMobile0"=>$sendMobileA[0],
					"sendMobile1"=>$sendMobileA[1],
					"sendMobile2"=>$sendMobileA[2],

					"sendZipcode"=>$sendZipcode,
					"sendAddress"=>$sendAddress,
					"sendAddressDesc"=>$sendAddressDesc,

					"receiveName"=>$receiveName,

					"receivePhone0"=>$receivePhoneA[0],
					"receivePhone1"=>$receivePhoneA[1],
					"receivePhone2"=>$receivePhoneA[2],

					"receiveMobile0"=>$receiveMobileA[0],
					"receiveMobile1"=>$receiveMobileA[1],
					"receiveMobile2"=>$receiveMobileA[2],


					"receiveZipcode"=>$receiveZipcode,
					"receiveAddress"=>$receiveAddress,
					"receiveAddressDesc"=>$receiveAddressDesc,
					"receiveComment"=>$receiveComment,
					"receiveTied"=>$receiveTied,
					"sendType"=>$sendType,
					"receiveType"=>$receiveType,

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

		//getsendtype, 
		$hCodeList = getNewCodeTitle("reSendType,reReceiverType");
		$reSendType = getCodeList($hCodeList, 'reSendType');//보내는사람
		$reReceiverType = getCodeList($hCodeList, 'reReceiverType');//받는사람

		$json["reSendType"]=$reSendType;
		$json["reReceiverType"]=$reReceiverType;




	}
?>