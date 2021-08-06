<?php
	$apicode=$_GET["apiCode"];
	$language=$_GET["language"];
	$tu_seq=$_GET["seq"];
	if($apicode!="tutorialdesc"){$json["resultMessage"]="API코드오류";$apiCode="tutorialdesc";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="언어코드오류";}
	else{
		$returnData=$_GET["returnData"];

		$jsql=" a  ";
		$wsql="  where a.tu_seq = '".$tu_seq."' ";

		$ssql=" a.* ";
		$sql=" select $ssql from ".$dbH."_tutorial $jsql $wsql ";
//echo $sql;
		$dt=dbone($sql);
		$tuDesc=$dt["tu_desc_".$language];
		$json=array("apiCode"=>$apicode, "returnData"=>$returnDat, "seq"=>$dt["tu_seq"], "tuNo"=>$dt["tu_no"], "tuDesckor"=>$dt["tu_desc_kor"], "tuDescchn"=>$dt["tu_desc_chn"], "tuDesceng"=>$dt["tu_desc_eng"], "tuDesc"=>$tuDesc, "tuDate"=>$dt["tu_date"]);

		$json["sql"]=$sql;
		$json["resultCode"]="200";
		$json["resultMessage"]="OK";
	}
?>