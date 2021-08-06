<?php  ///주문삭제   
	$apiCode=$_GET["apiCode"];
	$language=$_GET["language"];
	$seq=$_GET["seq"];

	if($apiCode!="chartdelete"){$json["resultMessage"]="API(apiCode) ERROR";$apiCode="chartdelete";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="API(language) ERROR";}
	else if($seq==""){$json["resultMessage"]="API(seq) ERROR";}
	else
	{		
		$returnData=$_GET["returnData"];

		$sql=" select od_status from ".$dbH."_order_medical where od_seq='".$seq."' and od_use='Y' ";
		$dt=dbone($sql);

		if($dt["OD_STATUS"]=="charted")///해당하는 seq의 상태값이 결제전인것만 update 
		{
			$sql=" update ".$dbH."_order_medical set od_use='D', od_modify=sysdate where od_seq='".$seq."' and od_use='Y' ";
			dbcommit($sql);

			$json["resultCode"]="200";
		}
		else
		{
			$json["resultCode"]="301"; ///삭제 불가 
		}

		$json["apiCode"] = $apiCode;
		$json["returnData"] = $returnData;
		$json["resultMessage"]="OK";

	}
?>