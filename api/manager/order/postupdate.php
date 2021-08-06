<?php
	//우체국은 우편번호가 5자리여야함. 
	$apicode=$_GET["apiCode"];
	$language=$_GET["language"];
	$odCode=$_GET["odCode"];
	$zipCode=str_replace("-","",$_GET["zipCode"]);
	$address=$_GET["address"];
	$addressdetail=$_GET["addressdetail"];
	$type=$_GET["type"];
	
	//우편번호가 6자리이면 5자리로 바꾸고, 주소를 지번과 상세주소를 나누자 
	if($apicode!="postupdate"){$json["resultMessage"]="API(apiCode) ERROR2";$apicode="postupdate";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="API(language) ERROR";}
	else if($odCode==""){$json["resultMessage"]="API(odCode) ERROR";}
	else if($zipCode==""){$json["resultMessage"]="API(zipCode) ERROR";}
	else if($address==""){$json["resultMessage"]="API(address) ERROR";}
	else if($addressdetail==""){$json["resultMessage"]="API(addressdetail) ERROR";}
	else if($type==""){$json["resultMessage"]="API(type) ERROR";}
	else
	{
		$returnData=$_GET["returnData"];
		$json=array("apiCode"=>$apicode,"returnData"=>$returnData);

		//20200410 : 일단은 넘겨 받은 zipcode 5자리인지만 체크하여 무조건 update 하자 
		if(strlen($zipCode)==5)
		{
			$newzipCode=$zipCode;
			$newaddresss=$address."||".$addressdetail;
			if($type=="receiver")//받는사람 
			{
				$usql="update han_release set re_zipcode='".$newzipCode."', re_address='".$newaddresss."' , re_addresschk='Y' where re_odcode='".$odCode."' ";
				dbcommit($usql);
			}
			if($type=="sender")//보내는사람
			{
				$usql="update han_release set re_sendzipcode='".$newzipCode."', re_sendaddress='".$newaddresss."' where re_odcode='".$odCode."' ";
				dbcommit($usql);
			}

			$json["re_address"]=$address." ".$addressdetail;
			$json["resultCode"]="200";
			$json["resultMessage"]="OK";
		}
		else
		{
			$json["resultCode"]="198";
			$json["resultMessage"]="zipCode Check";
		}
		/*
		$newzipCode="";

		$sql=" select newzip from han_zipcode where newzip ='".$zipCode."' or  oldzip ='".$zipCode."' "; 
		$dt=dbone($sql);
		$newzipCode=$dt["NEWZIP"];

		if($newzipCode)
		{
			$newaddresss=$address."||".$addressdetail;
			if($type=="receiver")//받는사람 
			{
				$usql="update han_release set re_zipcode='".$newzipCode."', re_address='".$newaddresss."' , re_addresschk='Y' where re_odcode='".$odCode."' ";
				dbcommit($usql);
			}
			if($type=="sender")//보내는사람
			{
				$usql="update han_release set re_sendzipcode='".$newzipCode."', re_sendaddress='".$newaddresss."' where re_odcode='".$odCode."' ";
				dbcommit($usql);
			}

			$json["re_address"]=$address." ".$addressdetail;
			$json["resultCode"]="200";
			$json["resultMessage"]="OK";
		}
		else
		{
			$json["resultCode"]="198";
			$json["resultMessage"]="zipCode Check";
		}
		*/

		$json["type"]=$type;
		$json["zipcode"]=$newzipCode;
	}
?>