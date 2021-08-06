<?php
	if($json["resultCode"]=="")$json["resultCode"]="204";
	if($json["resultMessage"]=="")$json["resultMessage"]="ERROR";
	$json["taskId"]=date("YmdHis")."_".substr(intval(microtime() * 10000),0,4);

	if($json)
	{
		$jsondata=json_encode($json);
		echo  $jsondata; 
	}
	else
	{
		echo "work!";
	}
?>