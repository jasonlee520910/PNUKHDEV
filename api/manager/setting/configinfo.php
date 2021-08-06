<?php //기본정보조회 ---> 어디서 호출하는지 확인해서 없으면 삭제하자!!
	//GET
	$apiCode=$_GET["apiCode"];
	$language=$_GET["language"];
	if($apiCode!="configinfo"){$json["resultMessage"]="API(apiCode) ERROR";$apiCode="configinfo";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="API(language) ERROR";}
	else
	{
		$sql="select CF_FTPHOST, CF_FTPPORT, CF_FTPUSER, CF_FTPPASS, CF_FTPDIR from ".$dbH."_config ";
		$dt=dbone($sql);

		$json=array("ftpHost"=>$dt["CF_FTPHOST"], "ftpPort"=>$dt["CF_FTPPORT"], "ftpUser"=>$dt["CF_FTPUSER"], "ftpPass"=>$dt["CF_FTPPASS"], "ftpDir"=>$dt["CF_FTPDIR"]);


		$json["apiCode"]=$apiCode;
		$json["resultCode"]="200";
		$json["resultMessage"]="OK";
	}
?>