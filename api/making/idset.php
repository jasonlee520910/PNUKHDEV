<?php
	$apicode=$_GET["apiCode"];
	$language=$_GET["language"];
	$ma_table=$_GET["maTable"];

	if($apicode!="idset"){$json["resultMessage"]="API(apiCode) ERROR";$apicode="idset";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="API(language) ERROR";}
	else if($ma_table==""){$json["resultMessage"]="API(TableNo) ERROR";}
	else{
		//$sql=" update ".$dbH."_making set ma_table = null, ma_tablestat = null where ma_tablestat in ('standby','start','scaned','hold') ";
		//dbqry($sql);

		//20190408 od_status='making_apply' 추가 
		$sql=" update ".$dbH."_order b inner join ".$dbH."_making a on a.ma_odcode = b.od_code set b.od_status = 'making_apply' where a.ma_tablestat in ('standby','start','scaned','hold') and a.ma_table='".$ma_table."' ";
		dbcommit($sql);

		//20190408 ma_status='making_apply' 추가 
		$sql=" update ".$dbH."_making set ma_table = null, ma_tablestat = null, ma_status='making_apply' where ma_tablestat in ('standby','start','scaned','hold') and ma_table='".$ma_table."' ";
		dbcommit($sql);

		$returnData=$_GET["returnData"];
		$json=array("apiCode"=>$apicode,"returnData"=>$returnData);
		$json["resultCode"]="200";
		$json["resultMessage"]="OK";
	}

?>