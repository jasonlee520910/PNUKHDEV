<?php
	$apicode=$_POST["apiCode"];
	$language=$_POST["language"];
	$od_seq=$_POST["seq"];
	if($apicode!="paymentupdate"){$json["resultMessage"]="API(apiCode) ERROR";$apicode="paymentupdate";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="API(language) ERROR";}
	else if($od_seq==""){$json["resultMessage"]="API(seq) ERROR";}
	else{
		$od_status=$_POST["odStatus"];
		$od_paytype=$_POST["odPaytype"];
		$od_payinfo=$_POST["odPayinfo"];
		$od_payamount=$_POST["odPayamount"];
		if($od_seq)
		{
			$sql=" update ".$dbH."_order set od_paytype='".$od_paytype."', od_payinfo='".$od_payinfo."', od_payamount='".$od_payamount."' ";
			if($od_status=="paid")$sql.=", od_status='".$od_status."'";
			$sql.=" where od_seq='".$od_seq."' ";
			dbcommit($sql);
		}
		$returnData=$_POST["returnData"];
		$json=array("apiCode"=>$apicode,"returnData"=>$returnData);

		$json["sql"]=$sql;

		$json["resultCode"]="200";
		$json["resultMessage"]="OK";
	}
?>