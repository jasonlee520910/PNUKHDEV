<?php  
	//결제취소시 카드결제인지 무통장인지 확인
	$apiCode=$_GET["apiCode"];
	$language=$_GET["language"];
	$keycode=$_GET["keycode"];

	if($apiCode!="orderpaychk"){$json["resultMessage"]="API(apiCode) ERROR2";$apiCode="orderpaychk";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="API(language) ERROR";}
	else
	{

		
		$sql=" select a.ct_paytype ,b.pm_tradeid,b.pm_payment,b.pm_pay_key ";
		$sql.=" from ".$dbH."_cart a  ";	
		$sql.=" inner join ".$dbH."_payment b on a.ct_cartid=b.pm_cartid ";
		$sql.=" where a.ct_pdcode = '".$keycode."' ";
		
		$dt=dbone($sql);

		if($dt["CT_PAYTYPE"]=="CC")
		{
			$ct_paytypetext="신용카드결제";
		}
		else if($dt["CT_PAYTYPE"]=="VA")
		{
			$ct_paytypetext="가상계좌결제";
		}
		else if($dt["CT_PAYTYPE"]=="BA")
		{
			$ct_paytypetext="계좌이체결제";
		}
		else 
		{
			$ct_paytypetext="기타결제";
		}

			$json = array(
				"ct_paytype"=>$dt["CT_PAYTYPE"],  //결제수단
				"ct_paytypetext"=>$ct_paytypetext,  //결제수단 text
				"pm_tradeid"=>$dt["PM_TRADEID"],  //원거래번호
				"TID"=>$dt["PM_TRADEID"],  //원거래번호
				"pm_pay_key"=>$dt["PM_PAY_KEY"],  //인증추적키


				"pm_payment"=>$dt["PM_PAYMENT"]  //총금액
			);




		//$json["wsql"]=$wsql;

		$json["ct_paytypetext"]=$ct_paytypetext;  //결제 타입
		$json["sql"]=$sql;
		$json["keycode"]=$keycode;
		$json["apiCode"]=$apiCode;
		$json["resultCode"]="200";
		$json["resultMessage"]="OK";

	}
?>

