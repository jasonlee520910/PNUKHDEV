<?php  //복약지도서 
	//GET
	$apicode=$_GET["apiCode"];
	$language=$_GET["language"];
	$od_code=$_GET["code"];

	if($apicode!="orderadvice"){$json["resultMessage"]="API(apicode) ERROR";$apicode="orderadvice";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="API(language) ERROR";}
	else
	{
		$sql=" select od_advice as ODADVICE from han_order where od_code='".$od_code."'  ";
		$dt=dbone($sql);

		$odadvice=getClob($dt["ODADVICE"]);
		$data=str_replace("\"","'",$odadvice);
		$data=str_replace("&lt;","<",$data);
		$data=str_replace("&gt;",">",$data);
		$data=str_replace("&amp;nbsp;"," ",$data);
		$data=str_replace("&quot;","'",$data);

		$json=array(
			"apiCode"=>$apiCode,
			"od_advice"=>$odadvice,
			"data"=>$data
			);

		$json["sql"]=$sql;
		$json["apiCode"]=$apicode;
		$json["resultCode"]="200";
		$json["resultMessage"]="OK";
	}		

?>
