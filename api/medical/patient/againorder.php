<?php  
	///재처방
	$apiCode=$_GET["apiCode"];
	$language=$_GET["language"];
	$seq=$_GET["seq"]; ///han_order_medical seq

	if($apiCode!="againorder"){$json["resultMessage"]="API(apiCode) ERROR2";$apiCode="againorder";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="API(language) ERROR";}
	else if(!$seq){$json["resultMessage"]="API(seq) ERROR";}
	else
	{
		$wsql=" where seq='".$seq."' ";

		$sql=" select jsondata ";	
		$sql.=" from ".$dbH."_order_medical $wsql  ";		

		$dt=dbone($sql);

		$json=array(
			"JSONDATA"=>getClob($dt["JSONDATA"])
			);


		//$json["wsql"]=$wsql;
		$json["sql"]=$sql;
		$json["resultCode"]="200";
		$json["resultMessage"]="OK";
		$json["apiCode"]=$apiCode;
		

	}
?>