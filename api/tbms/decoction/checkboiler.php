<?php
	$apiCode=$_GET["apiCode"];
	$language=$_GET["language"];
	$depart=$_GET["depart"];
	$odcode=$_GET["odcode"];
	
	$stat=$_GET["stat"];
	$proc=$_GET["proc"];
	$code=$_GET["code"];

	$medigroup=$_GET["medigroup"];
	$nextmedigroup=$_GET["nextmedigroup"];
	$returnData=$_GET["returnData"];

	if($apiCode!="checkboiler"){$json["resultMessage"]="API(apiCode) ERROR";$apiCode="checkboiler";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="API(language) ERROR";}
	else
	{
		
		//주문번호의 탕전 상태값 가져오기 
		$sql=" select DC_STATUS from ".$dbH."_decoction where dc_odcode='".$odcode."' ";
		$dt=dbone($sql);
		$dc_status=$dt["DC_STATUS"];
		$json["dc_status"]=$dc_status;

		//주문번호로 탕전기가 선택이 되어있는지 체크하자 
		$sql=" select BO_CODE from ".$dbH."_boiler where bo_odcode='".$odcode."' ";
		$dt=dbone($sql);
		$bo_code=$dt["BO_CODE"];
		$json["od_boCode"]=$bo_code;

		//넘어온 보일러코드로 검색하자 
		$sql=" select BO_SEQ, BO_ODCODE, BO_STATUS,BO_STAFF from ".$dbH."_boiler where bo_code='".$code."' ";
		$dt=dbone($sql);
		$bo_odcode=$dt["BO_ODCODE"];
		$json["bo_odcode"]=$bo_odcode;
		$json["bo_status"]=$dt["BO_STATUS"];
		$json["bo_staff"]=$dt["BO_STAFF"];
		$json["bo_seq"]=$dt["BO_SEQ"];


		//주문번호로 검색된 탕전기번호와 넘어온 탕전기번호가 다를 경우 주문번호에 있는 탕전기를 대기로 바꾼다 
		//if(!$bo_odcode)//넘어온보일러코드의 주문번호가 있다면 
		{
			if($bo_code!=$code)
			{
				$usql=" update ".$dbH."_boiler set bo_status='standby', bo_intime=NULL, bo_odcode='', bo_staff=''  where bo_code='".$bo_code."' ";
				dbcommit($usql);
				$json["usql"]=$usql;
			}
		}


		$json["code"] = $code;
		$json["sql"] = $sql;
		$json["apiCode"] = $apiCode;
		$json["resultCode"]="200";
		$json["resultMessage"]="OK";
	}
?>