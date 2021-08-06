<?php
	$apiCode=$_GET["apiCode"];
	$language=$_GET["language"];
	$odCode=$_GET["odCode"];
	$delicnt=$_GET["delicnt"];
	$delidata=$_GET["delidata"];

	if($apiCode!="releasedelicntupdate"){$json["resultMessage"]="API(apiCode) ERROR";$apiCode="releasedelicntupdate";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="API(language) ERROR";}
	else
	{

		//han_markingprinter table update 
		$sql=" update ".$dbH."_release set re_boxmedicnt='".$delicnt."', re_boxmedicntdata='".$delidata."' where re_odcode='".$odCode."' ";
		dbcommit($sql);
		
		$json["sql"] = $sql;
		$json["apiCode"] = $apiCode;
		$json["odCode"]=$odCode;
		$json["delicnt"] = $delicnt;
		$json["resultCode"]="200";
		$json["resultMessage"]="OK";
	}
?>