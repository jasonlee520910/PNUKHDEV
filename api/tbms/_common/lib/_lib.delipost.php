<?php
//신청정보 예약신청 취소
function getResCancelCmd($custNo,$apprNo,$reqType,$reqNo,$resNo,$regiNo,$reqYmd,$delYn)
{
	global $certifykey;
	global $ePOST_SERVER_URL;

	$ePostData=array();

	$epdata="custNo=".$custNo."&apprNo=".$apprNo."&reqType=".$reqType."&reqNo=".$reqNo."&resNo=".$resNo."&regiNo=".$regiNo."&reqYmd=".$reqYmd."&delYn=".$delYn;
	$encryptStr=encryptdata($epdata);

	$url="regData=".$encryptStr."&key=".$certifykey;
	$sendapi=$ePOST_SERVER_URL."api.GetResCancelCmd.jparcel?".$url;

	//$sendapi="http://ship.epost.go.kr/api.GetResCancelCmd.jparcel?key=test&regData=980e605c405a3264e00acbb0a341902c";
	$xml = simplexml_load_file($sendapi,'SimpleXMLElement',LIBXML_NOCDATA); 

	$error_code=$xml->error->error_code;

	if(!$error_code)
	{
		$xmlArray=(array)$xml;
		$arr=array();
		foreach($xmlArray as $key=>$val)
		{
			$value=(array)$val;
			$value = preg_replace('/\r\n|\r|\n/','',$value);
			$arr[$key]=$value[0];
		}
		$ePostData["stat"]=true;
		$ePostData["data"]=$arr;
	}
	else
	{
		$error_code=$xml->error->error_code;
		$message=$xml->error->message;	
		$ePostData["stat"]=false;
		$ePostData["data"]=$message."(".$error_code.")";
	}
	return $ePostData;
}
//집배코드조회 
function getDelivArea($zipcode, $addr)
{
	global $delivArecertifykey;

	$ePostData=array();

	$sendapi="http://biz.epost.go.kr/KpostPortal/openapi2?regkey=".$delivArecertifykey."&target=delivArea&zip=".$zipcode."&addr=".$addr."&mdiv=1";
	
	$xml=simplexml_load_file($sendapi);

	$error_code=$xml->error->error_code;

	if(!$error_code)
	{
		$arrCnpoNm=$xml->arrCnpoNm;
		$delivPoNm=$xml->delivPoNm;
		$delivAreaCd=$xml->delivAreaCd;

		$ePostData["stat"]=true;
		$arr=array("arrCnpoNm"=>$arrCnpoNm,"delivPoNm"=>$delivPoNm,"delivAreaCd"=>$delivAreaCd);
		$ePostData["data"]=$arr;
	}
	else
	{
		$error_code=$xml->error->error_code;
		$message=$xml->error->message;	
		$ePostData["stat"]=false;
		$ePostData["data"]=$message."(".$error_code.")";
	}
	return $ePostData;
	
}
//신청정보 예약상태 조회 
function getResInfo($custNo, $orderNo, $reqYmd)
{
	global $certifykey;
	global $ePOST_SERVER_URL;

	$ePostData=array();

	$epdata="custNo=".$custNo."&reqType=1&orderNo=".$orderNo."&reqYmd=".$reqYmd;
	$encryptStr=encryptdata($epdata);

	$url="regData=".$encryptStr."&key=".$certifykey;
	$sendapi=$ePOST_SERVER_URL."api.GetResInfo.jparcel?".$url;
	//echo "sendapi : ".$sendapi."<br>";

	$xml=simplexml_load_file($sendapi);

	$error_code=$xml->error->error_code;
	//echo "error_code : ".$error_code."<br>";

	if(!$error_code)
	{
		$list=array();
		foreach($xml->resInfo as $resInfo) 
		{
			$reqNo=$resInfo->reqNo;//우체국택배신청번호 
			$resNo=$resInfo->resNo;//예약번호 
			$regiNo=$resInfo->regiNo;//운송장번호 
			$regiPoNm=$resInfo->regiPoNm;//접수우체국 
			$resDate=$resInfo->resDate;//예약일시 
			$price=$resInfo->price;//(예상)접수요금
			$vTelNo=$resInfo->vTelNo;//가상전화번호 (가상번호 채번 안 된 경우 NULL값)
			$arr=array("reqNo"=>$reqNo,"resNo"=>$resNo,"regiNo"=>$regiNo,"regiPoNm"=>$regiPoNm,"resDate"=>$resDate,"price"=>$price,"vTelNo"=>$vTelNo);
			array_push($list, $arr);
		}

		$ePostData["stat"]=true;
		$ePostData["data"]=$list;
	}
	else
	{
		$error_code=$xml->error->error_code;
		$message=$xml->error->message;	
		$ePostData["stat"]=false;
		$ePostData["data"]=$message."(".$error_code.")";
	}
	return $ePostData;

}
//택배신청(픽업요청) 정보 생성
function InsertOrder($postdata)
{
	global $certifykey;
	global $ePOST_SERVER_URL;

	$ePostData=array();

	$encryptStr=encryptdata($postdata);

	$url="regData=".$encryptStr."&key=".$certifykey;
	$sendapi=$ePOST_SERVER_URL."api.InsertOrder.jparcel?".$url;

	$xml=simplexml_load_file($sendapi);

	$error_code=$xml->error->error_code;
	//echo "error_code : ".$error_code."<br>";

	if(!$error_code)
	{
		$reqNo=$xml->reqNo;//우체국택배신청번호 (건당부여)
		$resNo=$xml->resNo;//예약번호 (일자당 부여) 
		$regiNo=$xml->regiNo;//운송장번호 
		$regiPoNm =$xml->regiPoNm;//서울광진 접수우체국 
		$resDate=$xml->resDate;//예약일시 
		$price=$xml->price;//예상접수요금 
		$vTelNo=$xml->vTelNo;//가상전화번호 
		$arrCnpoNm=$xml->arrCnpoNm;//도착집중국명
		$delivPoNm=$xml->delivPoNm;//배달우체국명
		$delivAreaCd=$xml->delivAreaCd;//배달구구분코드

		$ePostData["stat"]=true;
		$arr=array("reqNo"=>$reqNo,"resNo"=>$resNo,"regiNo"=>$regiNo,"regiPoNm"=>$regiPoNm,"resDate"=>$resDate,"price"=>$price,"vTelNo"=>$vTelNo,"arrCnpoNm"=>$arrCnpoNm,"delivPoNm"=>$delivPoNm,"delivAreaCd"=>$delivAreaCd);
		$ePostData["data"]=$arr;
	}
	else
	{
		$error_code=$xml->error->error_code;
		$message=$xml->error->message;	
		$ePostData["stat"]=false;
		$ePostData["data"]=$message."(".$error_code.")";
	}
	return $ePostData;
}
//공급지정보 조회 
function getOfficeInfo($custNo)
{
	global $certifykey;
	global $ePOST_SERVER_URL;

	$ePostData=array();

	$epdata="custNo=".$custNo;
	$encryptStr=encryptdata($epdata);

	$url="regData=".$encryptStr."&key=".$certifykey;
	$sendapi=$ePOST_SERVER_URL."api.GetOfficeInfo.jparcel?".$url;

	$xml=simplexml_load_file($sendapi);

	$error_code=$xml->error->error_code;
	//echo "error_code : ".$error_code."<br>";

	if(!$error_code)
	{
		$officeSer=$xml->officeInfo[0]->officeSer;//공급지코드
		$officeNm=$xml->officeInfo[0]->officeNm;//공급지명
		$officeZip=$xml->officeInfo[0]->officeZip;//우편번호
		$officeAddr=$xml->officeInfo[0]->officeAddr;//주소
		$officeTelno=$xml->officeInfo[0]->officeTelno;// 전화번호
		$contactNm=$xml->officeInfo[0]->contactNm;// 담당자명

		$ePostData["stat"]=true;
		$arr=array("officeSer"=>$officeSer,"officeNm"=>$officeNm,"officeZip"=>$officeZip,"officeAddr"=>$officeAddr,"officeTelno"=>$officeTelno,"contactNm"=>$contactNm);
		$ePostData["data"]=$arr;
	}
	else
	{
		$error_code=$xml->error->error_code;
		$message=$xml->error->message;	
		$ePostData["stat"]=false;
		$ePostData["data"]=$message."(".$error_code.")";
	}
	return $ePostData;
}
//계약승인번호 조회 
function getApprNo($custNo)
{
	global $certifykey;
	global $ePOST_SERVER_URL;

	$ePostData=array();

	$epdata="custNo=".$custNo;
	$encryptStr=encryptdata($epdata);

	$url="regData=".$encryptStr."&key=".$certifykey;
	$sendapi=$ePOST_SERVER_URL."api.GetApprNo.jparcel?".$url;
	//echo "sendapi : ".$sendapi."<br>";
	
	$xml=simplexml_load_file($sendapi);
	//var_dump($xml);

	$error_code=$xml->error->error_code;
	//echo "error_code : ".$error_code."<br>";

	if(!$error_code)//에러가 아니라면 
	{
		$apprNo=$xml->contractInfo->apprNo;//우체국 고객번호
		$payTypeCd=$xml->contractInfo->payTypeCd;//즉납/후납 구분코드 10(즉납)/12(후납)
		$payTypeNm=$xml->contractInfo->payTypeNm;//즉납/후납 구분
		$postNm=$xml->contractInfo->postNm;// 계약우체국명

		$ePostData["stat"]=true;
		$arr=array("apprNo"=>$apprNo,"payTypeCd"=>$payTypeCd,"payTypeNm"=>$payTypeNm,"postNm"=>$postNm);
		$ePostData["data"]=$arr;
	}
	else
	{
		$error_code=$xml->error->error_code;
		$message=$xml->error->message;	
		$ePostData["stat"]=false;
		$ePostData["data"]=$message."(".$error_code.")";
	}
	return $ePostData;
}
//고객번호 조회 
function getCustNo()
{
	global $postUserID;
	global $certifykey;
	global $ePOST_SERVER_URL;
	$ePostData=array();

	$epdata="memberID=".$postUserID;
	$encryptStr=encryptdata($epdata);

	$url="regData=".$encryptStr."&key=".$certifykey;
	$sendapi=$ePOST_SERVER_URL."api.GetCustNo.jparcel?".$url;
	//echo "sendapi : ".$sendapi."<br>";
	
	$xml=simplexml_load_file($sendapi);
	
	$error_code=$xml->error->error_code;
	//echo "error_code : ".$error_code."<br>";

	if(!$error_code)//에러가 아니라면 
	{
		$custNo=$xml->custNo;
		$ePostData["stat"]=true;
		$ePostData["data"]=$custNo;
		//echo "고객번호조회custNo : ".$custNo."<br>";
	}
	else
	{
		$error_code=$xml->error->error_code;
		$message=$xml->error->message;	
		$ePostData["stat"]=false;
		$ePostData["data"]=$message."(".$error_code.")";
		//echo $message."(".$error_code.")";
	}
	return $ePostData;
}
function fixNull($source)
{
      $rData = "";
      if ($source == NULL) {
      	$rData = "";
      }else{ 
      	$rData = $source;
      }
      return $rData;	
}
function encryptdata($data)
{
	global $securityKey; 

	$seedKey = fixNull($securityKey);
	$seeddata = fixNull($data);

	$seed = new SEED128();
	$encryptStr="";
	if ($seeddata!=NULL) 
	{
		$encryptStr = $seed->getEncryptData($seedKey, $seeddata);
	}
	return $encryptStr;
}
?>