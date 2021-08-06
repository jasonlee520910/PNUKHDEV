<?php
	$apicode=$_GET["apiCode"];
	$language=$_GET["language"];

	if($apicode!="ordermarkingupdate"){$json["resultMessage"]="API(apiCode) ERROR2";$apicode="ordermarkingupdate";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="API(language) ERROR";}
	else
	{
		$returnData=$_GET["returnData"];
		$json=array("apiCode"=>$apicode,"returnData"=>$returnData);

		$od_keycode=$_GET["keycode"]; //주문키코드 
		$cdCode=$_GET["cdCode"];
		
		//마킹정보 
		$sql=" update ".$dbH."_marking ";
		$sql.=" set mr_desc='".$cdCode."'  where mr_keycode='".$od_keycode."' ";
		dbcommit($sql);

		$json["sql"]=$sql;

		$json["resultCode"]="200";
		$json["resultMessage"]="OK";
	}
?>
