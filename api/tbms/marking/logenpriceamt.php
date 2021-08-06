<?php
	//로젠 안해도됨 
	//20191106 : 거래처 계약 단가 확인 
	$client=new SoapClient($LOGEN_SERVER_URL);
	$strFixCustCd=$userID;
	$param=array('parameters' => array('userID'=>$userID,'passWord'=>$passWord,'strFixCustCd'=>$strFixCustCd,'freightType'=>$freightType));
	$json["LOGEN_거래처계약단가_param"]=$param;
	$garray = $client->__call('W_PHP_NTx_FixCont_PriceAmt_Get_Select',$param);
	$json["LOGEN_거래처계약단가_garray"]=$garray;
	//var_dump($garray);
	$gvar = $garray->W_PHP_NTx_FixCont_PriceAmt_Get_SelectResult; 
	$json["LOGEN_거래처계약단가_1param"]=$param;
	$json["LOGEN_거래처계약단가_2garray"]=$garray;
	$json["LOGEN_거래처계약단가_3gvar"]=$gvar;

	if($gvar=="〓")
	{
		$priceAmt="3000";
		$json["priceAmt"]=$priceAmt;//집하선불운임
	}
	else
	{
		//고정거래처코드(8)Ξ고정거래처명Ξ집하선불운임
		$gData = explode('Ξ', $gvar);
		$priceAmt=$gData[2];//집하선불운임
		$json["priceAmt"]=$priceAmt;//집하선불운임
	}
?>
