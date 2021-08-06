<?php
	//로젠 안해도됨 
	//계약 영업소 정보 
	$client=new SoapClient($LOGEN_SERVER_URL);
	
	$param=array('parameters' => array('userID'=>$userID,'passWord'=>$passWord));
	$garray = $client->__call('W_PHP_NTx_Get_FixCustSales',$param);
	//var_dump($array);
	$gvar = $garray->W_PHP_NTx_Get_FixCustSalesResult; 
	$json["LOGEN_계약영업소정보_gvar"]=$gvar;

	if($gvar=="〓")
	{
		$json["custCode"]="";//영업소코드(8)
		$json["custName"]="";//영업소명-연락처(34)
		$json["BranchCode"]="";//지점코드(3)
		$json["BranchName"]="";//지점명(20)
	}
	else
	{
		//"63911012Ξ장성-정배근(010-2637-7193)Ξ639Ξ장성Ξ≡〓"
		//영업소코드(8),영업소명-연락처(34), 지점코드(3), 지점명(20)
		$gData = explode('Ξ', $gvar);

		$json["custCode"]=$gData[0];//영업소코드(8)
		$json["custName"]=$gData[1];//영업소명-연락처(34)
		$json["BranchCode"]=$gData[2];//지점코드(3)
		$json["BranchName"]=$gData[3];//지점명(20)
	}
?>
