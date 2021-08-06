<?php
echo "aaa";
//우편번호조회  
function getZipcode($zipcode, $addr)
{
	global $delivArecertifykey;

	$ePostData=array();

	        //http://biz.epost.go.kr/KpostPortal/openapi?regkey=test&target=postNew&query=정보화길&countPerPage=20&currentPage=1
	$sendapi="http://biz.epost.go.kr/KpostPortal/openapi?regkey=cb17126a123cd7fea1586166442691&target=postNew&query=정보화길&countPerPage=20&currentPage=1";
	
	$xml=simplexml_load_file($sendapi);

	$error_code=$xml->error_code;

	if(!$error_code)
	{
		$postcd=$xml->postcd;
		$address=$xml->address;
		$addrjibun=$xml->addrjibun;

		$ePostData["stat"]=true;
		$arr=array("postcd"=>$postcd,"address"=>$address,"addrjibun"=>$addrjibun);
		$ePostData["data"]=$arr;
	}
	else
	{
		$error_code=$xml->error_code;
		$message=$xml->message;	
		$ePostData["stat"]=false;
		$ePostData["data"]=$message."(".$error_code.")";
	}
	return $ePostData;
	
}

$zipcode=getZipcode();

var_dump($zipcode);
?>
