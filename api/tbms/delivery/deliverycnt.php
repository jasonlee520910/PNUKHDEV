<?php
	$apiCode=$_GET["apiCode"];
	$language=$_GET["language"];
	$returnData=$_GET["returnData"];
	
	if($apiCode!="deliverycnt"){$json["resultMessage"]="API(apiCode) ERROR";$apiCode="deliverycnt";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="API(language) ERROR";}
	else
	{
		//$sql=" select count(re_confirm) delicnt  
		//			from ".$dbH."_release a 
		//			inner join ".$dbH."_order b on a.re_odcode=b.od_code 
		//			where a.re_confirm='N' and b.od_status = 'done' ";

		//20191023 : han_release에서 han_delicode로 수정 
		/*
		$sql=" select count(deliconfirm) logenDelicnt 
				from ".$dbH."_delicode a 
				inner join ".$dbH."_order b on a.odcode=b.od_code 
				where a.deliconfirm='N' and b.od_status = 'done' ";
		
		$dt=dbone($sql);
		$logenDelicnt=$dt["logenDelicnt"];
		*/
		$logenDelicnt=0;

		$psql=" select count(deliconfirm) postDeliCnt 
				from ".$dbH."_delicode_post a 
				inner join ".$dbH."_order b on a.odcode=b.od_code 
				where a.deliconfirm='N' and b.od_status = 'done' ";

		$pdt=dbone($psql);
		$postDeliCnt=$pdt["POSTDELICNT"];

		$deliveryCnt=intval($logenDelicnt)+intval($postDeliCnt);	
		
		$json["apiCode"] = $apiCode;
		$json["deliveryCnt"] = $deliveryCnt;
		$json["sql"] = $sql;
		$json["returnData"] = $returnData;
		$json["resultCode"]="200";
		$json["resultMessage"]="OK";
	}
?>