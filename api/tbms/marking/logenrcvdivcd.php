<?php
	//로젠 안해도됨 
	//20191031 : 신주소로 검색은 특정 업체만 가능하다
	//구주소로 도착점 코드 검색 
	$client=new SoapClient($LOGEN_SERVER_URL);
	$param=array('parameters' => array('userID'=>$userID,'passWord'=>$passWord,'strAddr'=>$strAddr));
	$garray = $client->__call('W_PHP_NTx_Get_RcvDivCd',$param);
	//var_dump($array);
	$gvar = $garray->W_PHP_NTx_Get_RcvDivCdResult; 
	$json["LOGEN_구도착점코드_gvar"]=$gvar;		

	if($gvar=="Ξ≡〓")
	{
		$DestinationCode="";//도착점코드(3)
		$jejuCheck="";//제주지역여부(1)
		$seaCheck="";//해운지역여부(1)
		$mountainCheck="";//산간지역여부(1)

		$json["DestinationCode"]=$DestinationCode;//도착점코드(3)
		$json["RoadName"]="";//도로명
		$json["ClassificationCode"]="";//분류코드(6)
		$json["ZipCode"]="";//우편번호(5)
		$json["jejuCheck"]=$jejuCheck;//제주지역여부(1)
		$json["seaCheck"]=$seaCheck;//해운지역여부(1)
		$json["mountainCheck"]=$mountainCheck;//산간지역여부(1)
	}
	else
	{
		//도착점코드(3) Ξ 읍면동 Ξ 분류코드(6) Ξ 우편번호(6) Ξ 제주지역여부(1) Ξ 해운지역여부(1) Ξ 산간지역여부(1)
		//624Ξ군서면ΞJ1-624Ξ526852ΞNΞNΞNΞ≡〓
		$gData = explode('Ξ', $gvar);

		$DestinationCode=$gData[0];//도착점코드(3)
		$jejuCheck=$gData[4];//제주지역여부(1)
		$seaCheck=$gData[5];//해운지역여부(1)
		$mountainCheck=$gData[6];//산간지역여부(1)


		$json["DestinationCode"]=$DestinationCode;//도착점코드(3)
		$json["RoadName"]=$gData[1];//도로명
		$json["ClassificationCode"]=$gData[2];//분류코드(6)
		$json["ZipCode"]=$gData[3];//우편번호(6)
		$json["jejuCheck"]=$jejuCheck;//제주지역여부(1)
		$json["seaCheck"]=$seaCheck;//해운지역여부(1)
		$json["mountainCheck"]=$mountainCheck;//산간지역여부(1)
	}
	/*
	//신주소로 도착점코드 검색 
	
	$param=array('parameters' => array('userID'=>$userID,'passWord'=>$passWord,'strAddr'=>$strAddr));
	$narray = $client->__call('W_PHP_NTx_Get_RcvDivCd_Road',$param);
	//var_dump($narray);
	$nvar = $narray->W_PHP_NTx_Get_RcvDivCd_RoadResult; 
	$json["LOGEN_신도착점코드_nvar"]=$nvar;
	if($nvar=="Ξ≡〓")
	{

	}
	else
	{
		//도착점코드(3) Ξ 도로명 Ξ 분류코드(6) Ξ 우편번호(5) Ξ 제주지역여부(1) Ξ 해운지역여부(1) Ξ 산간지역여부(1)
		$nData = explode('Ξ', $nvar);

		$DestinationCode=$nData[0];//도착점코드(3)
		$jejuCheck=$nData[4];//제주지역여부(1)
		$seaCheck=$nData[5];//해운지역여부(1)
		$mountainCheck=$nData[6];//산간지역여부(1)

		$json["DestinationCode"]=$DestinationCode;//도착점코드(3)
		$json["RoadName"]=$nData[1];//도로명
		$json["ClassificationCode"]=$nData[2];//분류코드(6)
		$json["ZipCode"]=$nData[3];//우편번호(5)
		$json["jejuCheck"]=$jejuCheck;//제주지역여부(1)
		$json["seaCheck"]=$seaCheck;//해운지역여부(1)			
		$json["mountainCheck"]=$mountainCheck;//산간지역여부(1)
	}

	*/
?>
