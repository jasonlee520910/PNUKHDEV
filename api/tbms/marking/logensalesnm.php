<?php
	//로젠 안해도됨 
	//배송영업소명 리턴 (수하인주소)
	$client=new SoapClient($LOGEN_SERVER_URL);
	
	$param=array('parameters' => array('strAddr'=>$strAddr));
	$garray = $client->__call('W_PHP_NTx_DlvSalesNm_Get_Select',$param);
	//var_dump($garray);
	$gvar = $garray->W_PHP_NTx_DlvSalesNm_Get_SelectResult; 
	$json["LOGEN_배송영업소명_gvar"]=$gvar;

	$gData = explode('Ξ', $gvar);
	$json["SalesName"]=$gData[0];//배송영업소 

?>
