<?php //제품관리 
	//GET
	$apiCode=$_GET["apiCode"];
	$language=$_GET["language"];
	$page=$_GET["page"];
	$mt_seq=$_GET["seq"];

	if($apiCode!="goodsoriginlist"){$json["resultMessage"]="API(apiCode) ERROR";$apiCode="goodsoriginlist";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="API(language) ERROR";}
	else{
		$returnData=$_GET["returnData"];
		$json=array("apiCode"=>$apiCode,"returnData"=>$returnData);
		$searchTxt=$_GET["searchTxt"];

		$jsql=" a  ";
		$wsql=" where a.gd_use='Y' and a.gd_type = 'origin' ";

		if($searchtxt)
		{
			$wsql.=" and ( ";
			$wsql.=" a.gd_code like '%".$searchtxt."%' ";//품목코드
			$wsql.=" or ";
			$wsql.=" a.gd_name_kor like '%".$searchtxt."%' ";//제품명
			$wsql.=" or ";
			$wsql.=" a.gd_name_chn like '%".$searchtxt."%' ";//제품명
			$wsql.=" or ";
			$wsql.=" a.gd_name_eng like '%".$searchtxt."%' ";//제품명
			$wsql.=" ) ";
		}

		$pg=apipaging("gd_seq","goods",$jsql,$wsql);

		$sql="  select * from ".$dbH."_goods $jsql $wsql order by gd_seq desc limit ".$pg["snum"].", ".$pg["psize"];
//echo $sql;
		$res=dbqry($sql);
		$json["page"]=$pg["page"];
		$json["tcnt"]=$pg["tcnt"];
		$json["tpage"]=$pg["tpage"];
		$json["psize"]=$pg["psize"];
		$json["block"]=$pg["block"];
		$json["list"]=array();

		while($dt=dbarr($res)){


			$addarray=array(
				"gdSeq"=>$dt["gd_seq"], 
				"gdCode"=>$dt["gd_code"], 
				"gdType"=>$dt["gd_type"], 
				"gdName"=>$dt["gd_name_kor"], 
				"gdSpec"=>$dt["gd_spec"], 
				"gdUse"=>$dt["gd_use"], 

				"gdSales"=>number_format($dt["gd_sales"]), 
				"gdQty"=>number_format($dt["gd_qty"]), 
				"incomingDate"=>$incomingdate, 
				"outgoingDate"=>$outgoingdate, 
				"gdDate"=>substr($dt["gd_modify"],0,16)
				);
			array_push($json["list"], $addarray);
		}

		$json["sql"]=$sql;
		$json["apiCode"]=$apiCode;
		$json["resultCode"]="200";
		$json["resultMessage"]="OK";
	}
?>