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

	if($apiCode!="checkpacking"){$json["resultMessage"]="API(apiCode) ERROR";$apiCode="checkpacking";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="API(language) ERROR";}
	else
	{
		//주문번호의 탕전 상태값 가져오기 
		$sql=" select dc_status from ".$dbH."_decoction where dc_odcode='".$odcode."' ";
		$dt=dbone($sql);
		$dc_status=$dt["DC_STATUS"];
		$json["dc_status"]=$dc_status;

		//주문번호로 포장기 선택이 되어있는지 체크하자 
		$sql=" select pa_code from ".$dbH."_packing where pa_odcode='".$odcode."' ";
		$dt=dbone($sql);
		$pa_code=$dt["PA_CODE"];
		$json["od_paCode"]=$pa_code;

		//넘어온 포장기코드로 검색하자 
		$sql=" select pa_seq, pa_odcode, pa_status, pa_staff from ".$dbH."_packing where pa_code='".$code."' ";
		$dt=dbone($sql);
		$pa_odcode=$dt["PA_ODCODE"];
		$json["pa_odcode"]=$dt["PA_ODCODE"];
		$json["pa_status"]=$dt["PA_STATUS"];
		$json["pa_staff"]=$dt["PA_STAFF"];
		$json["pa_seq"]=$dt["PA_SEQ"];


		//주문번호로 검색된 포장기번호와 넘어온 포장기번호가 다를 경우 주문번호에 있는 포장기를 대기로 바꾼다 
		//if(!$pa_odcode)//넘어온포장기코드의 주문번호가 있다면 
		{
			if($pa_code!=$code)
			{
				$usql=" update ".$dbH."_packing set pa_status='standby', pa_intime=NULL, pa_odcode='', pa_staff=''  where pa_code='".$pa_code."' ";
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