<?php
	$apiCode=$_GET["apiCode"];
	$language=$_GET["language"];

	//url=&depart=making&proc=MDB&stat=MDB_medibox&code=MDB0000000095&medigroup=medibox_infirst&mediwait=,undefined&medihold=
	$code=$_GET["code"];
	$mediwait=$_GET["mediwait"];
	$medihold=$_GET["medihold"];
	$medifinish=$_GET["medifinish"];
	$depart=$_GET["depart"];
	$medigroup=$_GET["medigroup"];
	$odcode=$_GET["odcode"];
	$st_inlast=$_GET["st_inlast"];	
	
			
	if($apiCode!="checkmedibox"){$json["resultMessage"]="API(apiCode) ERROR";$apiCode="checkmedibox";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="API(language) ERROR";}
	else
	{
		$sql=" select a.mb_table, a.mb_medicine, a.mb_capacity, b.md_qty from ".$dbH."_medibox a inner join ".$dbH."_medicine b on a.mb_medicine=b.md_code where a.mb_code='".$code."' ";
		$dt=dbone($sql);
		
		$json["data"]=array(
			"mb_table"=>$dt["MB_TABLE"],
			"mb_medicine"=>$dt["MB_MEDICINE"],
			"mb_capacity"=>$dt["MB_CAPACITY"], //약재함의 재고량
			"md_qty"=>$dt["MD_QTY"]	//창고의 재고량 (공통약재일때에는 창고와 함께 더해서 확인한다)
			);
		
		if($dt["MB_MEDICINE"])
		{
			$usql=" update ".$dbH."_making set ma_medicine='".$code."'where ma_odcode='".$odcode."' ";
			dbcommit($usql);
			$json["usql"] = $usql;
		}

		$json["sql"] = $sql;

		$json["code"] = $code;
		$json["mediwait"] = $mediwait;
		$json["medihold"] = $medihold;
		$json["medifinish"] = $medifinish;
		$json["depart"] = $depart;
		$json["medigroup"] = $medigroup;
		$json["odcode"] = $odcode;
		$json["st_inlast"] = $st_inlast;
		
		$json["apiCode"] = $apiCode;
		$json["resultCode"]="200";
		$json["resultMessage"]="OK";
	}
?>