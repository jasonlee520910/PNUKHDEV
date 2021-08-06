<?php  
	//뒤로 가기를 했을때 결제된 상품인지 한번더 체크
	$apiCode=$_GET["apiCode"];
	$language=$_GET["language"];
	$chkkeycodeamount=$_GET["chkkeycodeamount"];

	if($apiCode!="orderchk"){$json["resultMessage"]="API(apiCode) ERROR2";$apiCode="orderchk";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="API(language) ERROR";}
	else
	{
		$chkkeycode=explode(",",$chkkeycodeamount);

		$chklen=count($chkkeycode);



		for($i=1;$i<$chklen;$i++)
		{
			$sql=" select b.pm_status ";
			$sql.=" from ".$dbH."_cart a  ";	
			$sql.=" inner join ".$dbH."_payment b on a.ct_cartid=b.pm_cartid ";
			$sql.=" where a.ct_pdcode = '".$chkkeycode[$i]."' ";
			$dt=dbone($sql);

			if($dt["PM_STATUS"]=="ok")
			{
				$resultText="결제가 된 상품입니다. 다시 확인해주세요";
			}
		}

		//2020062916134200001  -결제가 된 상품의 keycode

		$json["resultText"]=$resultText;

		$json["sql"]=$sql;
		$json["keycode"]=$keycode;
		$json["apiCode"]=$apiCode;
		$json["resultCode"]="200";
		$json["resultMessage"]="OK";

	}
?>

