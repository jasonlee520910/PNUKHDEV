<?php
	$apicode=$_GET["apiCode"];
	$language=$_GET["language"];
	$page=$_GET["page"];
	$ma_odcode=$_GET["odCode"];
	$ma_table=$_GET["maTable"];
	
	if($apicode!="status"){$json["resultMessage"]="API(apiCode) ERROR";$apicode="status";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="API(language) ERROR";}
	else if($ma_table==""){$json["resultMessage"]="API(TableNo) ERROR";}
	else if($ma_odcode==""){$json["resultMessage"]="API(odCode) ERROR";}
	else{

		$status=$_GET["status"];
		$returnData=$_GET["returnData"];
		$json=array("apiCode"=>$apicode,"returnData"=>$returnData,"status"=>$status);
/*
		$sql=" select ma_tablestat, ma_status from ".$dbH."_making where ma_odcode = '".$ma_odcode."' and  ma_table = '".$ma_table."' ";
		$dt=dbone($sql);
		$ma_tablestat=$dt["ma_tablestat"];
		$ma_ststua=$dt["ma_ststua"];
*/
		//$od_code=$dt["odCode"];
		//20190415:cancel 추가 스캔은 안하고 리스트로 가기 
		if($status == "cancel" ){
			$sql=" update ".$dbH."_making set ma_tablestat = 'cancel' where ma_odcode = '".$ma_odcode."' and ma_tablestat = 'scaned' and ma_table = '".$ma_table."'";
			dbcommit($sql);
		}

		if($status == "hold" ){
			$sql=" update ".$dbH."_making set ma_tablestat = 'hold' where ma_odcode = '".$ma_odcode."' and ma_tablestat = 'scaned' and ma_table = '".$ma_table."'";
			dbcommit($sql);
		}
		if($status == "start" ){
			$sql=" update ".$dbH."_making set ma_tablestat = 'start' where ma_odcode = '".$ma_odcode."' and ma_tablestat is null and ma_table = '".$ma_table."'";
			dbcommit($sql);
		}
		if($status == "finish" ){
			$sql=" update ".$dbH."_making set ma_tablestat = 'finish' where ma_odcode = '".$ma_odcode."' and ma_tablestat = 'scaned' and ma_table = '".$ma_table."'";
			dbcommit($sql);
		}
		if($status == "scaned" ){
			//2019.03.29일 start와 scaned 의 간격이 3초인데 가끔 좀더 오버되는듯 하여 일단은 scaned로 바꿈. 
			//$sql=" update ".$dbH."_making set ma_tablestat = 'scaned' where ma_odcode = '".$ma_odcode."' and ma_tablestat = 'start' and ma_table = '".$ma_table."'";
			$sql=" update ".$dbH."_making set ma_tablestat = 'scaned' where ma_odcode = '".$ma_odcode."' and (ma_tablestat = 'start' OR ma_tablestat is null) and ma_table = '".$ma_table."'";
			dbcommit($sql);
		}
		if($status == "null" || $status == null){
			$sql=" update ".$dbH."_making set ma_tablestat = null where ma_odcode = '".$ma_odcode."' and ma_tablestat = 'start' and ma_table = '".$ma_table."'";
			dbcommit($sql);
		}

		$json["sql"]=$sql;
		$json["resultCode"]="200";
		$json["resultMessage"]="OK";
	}
?>