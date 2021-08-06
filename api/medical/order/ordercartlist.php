<?php
	$apiCode=$_GET["apiCode"];
	$language=$_GET["language"];
	$page=$_GET["page"];
	$medicalid=$_GET["medicalid"];
	if($apiCode!="ordercartlist"){$json["resultMessage"]="API(apiCode) ERROR";$apiCode="ordercartlist";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="API(language) ERROR";}
	else
	{
		//나중에 페이징을 만들더라도.. 일단은 이대로 고고 
		$sql=" select 
				SEQ, ORDERTYPE, DOCTORNAME, ORDERTITLE, ORDERCOUNT, AMOUNTTOTAL, AMOUNTMEDICINE, AMOUNTADDMEDI, AMOUNTSWEET, AMOUNTPHARMACY, AMOUNTDECOCTION, AMOUNTPACKAGING, AMOUNTDELIVERY, PATIENTNAME, to_char(ORDERDATE,'yyyy-mm-dd HH24:MI:SS') as ODDATE
				from han_order_medical where medicalcode='".$medicalid."' and ORDERSTATUS='cart' order by INDATE desc ";

		$res=dbqry($sql);
		$json["list"]=array();

		while($dt=dbarr($res))
		{	
			$addarray=array(
				"seq"=>$dt["SEQ"], 
				"ordertype"=>$dt["ORDERTYPE"], 
				"doctorname"=>$dt["DOCTORNAME"], 
				"ordertitle"=>$dt["ORDERTITLE"], 
				"ordercount"=>$dt["ORDERCOUNT"], 
				"amounttotal"=>$dt["AMOUNTTOTAL"], 
				"amountmedicine"=>$dt["AMOUNTMEDICINE"], 
				"amountaddmedi"=>$dt["AMOUNTADDMEDI"], 
				"amountsweet"=>$dt["AMOUNTSWEET"], 
				"amountpharmacy"=>$dt["AMOUNTPHARMACY"], 
				"amountdecoction"=>$dt["AMOUNTDECOCTION"], 
				"amountpackaging"=>$dt["AMOUNTPACKAGING"], 
				"amountdelivery"=>$dt["AMOUNTDELIVERY"], 
				"patientname"=>$dt["PATIENTNAME"], 
				"oddate"=>$dt["ODDATE"]
			);
			array_push($json["list"], $addarray);
		}

		$json["apiCode"] = $apiCode;
		$json["resultCode"]="200";
		$json["resultMessage"]="OK";
	}
?>