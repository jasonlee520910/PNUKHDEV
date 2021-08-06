<?php 
	$apiCode=$_POST["apiCode"];
	$language=$_POST["language"];
	$odcode=$_POST["odcode"];
	$staffid=$_POST["staffid"];//탕전사아이디
	$packingid=$_POST["packingid"];//포장담당아이디
	
	$returnData=$_POST["returnData"];

	if($apiCode!="decocprocessing"){$json["resultMessage"]="API(apiCode) ERROR";$apiCode="decocprocessing";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="API(language) ERROR";}
	else
	{

		//order 상태값 바꾸기 
		$sql2=" update ".$dbH."_order set od_status='decoction_processing' where od_code='".$odcode."'";
		dbcommit($sql2);
		$json["2order_주문"]=$sql2;

		//decoction  상태값 바꾸기 
		$sql3=" update ".$dbH."_decoction set dc_stime=sysdate, dc_status='decoction_processing' where dc_odcode='".$odcode."'";
		dbcommit($sql3);
		$json["3탕전_decoction"]=$sql3;

		$json["apiCode"] = $apiCode;
		$json["resultCode"]="200";
		$json["resultMessage"]="OK";
	}
?>