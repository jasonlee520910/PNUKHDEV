<?php
	$apicode=$_GET["apiCode"];
	$language=$_GET["language"];
	if($apicode!="ordersubjectupdate"){$json["resultMessage"]="API(apiCode) ERROR2";$apicode="ordersubjectupdate";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="API(language) ERROR";}
	else
	{
		$returnData=$_GET["returnData"];
		$json=array("apiCode"=>$apicode,"returnData"=>$returnData);

		$od_keycode=$_GET["keycode"]; //주문키코드 
		//받는사람 이름 
		$reName=$_GET["newReName"];
		//품목 
		$odSubject=$_GET["odSubject"];
		//품목 
		$odSubjectType=$_GET["odSubjectType"];
		
		
		//주문정보업데이트
		$sql=" update ".$dbH."_order ";
		$sql.=" set od_subject='".$odSubject."', od_subjecttype='".$odSubjectType."',  od_modify=sysdate where od_keycode='".$od_keycode."' ";
		dbcommit($sql);
		$json["품목1sql"]=$sql;
	
		//출고정보업데이트
		$sql=" update ".$dbH."_release ";
		$sql.=" set re_name='".$reName."' where re_keycode='".$od_keycode."' ";
		dbcommit($sql);
		$json["품목2sql"]=$sql;

		$json["resultCode"]="200";
		$json["resultMessage"]="OK";
	}
?>
