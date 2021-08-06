<?php  
	/// 자재코드관리 > 포장기관리 > 리스트
	$apiCode=$_GET["apiCode"];
	$language=$_GET["language"];
	$page=$_GET["page"];

	if($apiCode!="packlist"){$json["resultMessage"]="API(apiCode) ERROR";$apiCode="packlist";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="API(language) ERROR";}
	else
	{
		$returnData=$_GET["returnData"];
		$json=array("apiCode"=>$apiCode,"returnData"=>$returnData);
		$searperiodtype=$_GET["searPeriodType"];
		$searchperiod=$_GET["searchPeriod"];
		$searchstatus=$_GET["searchStatus"];
		$searchtype=$_GET["searchType"];
		$searchtxt=$_GET["searchTxt"];

		$jsql=" ";
		$wsql=" where pa_use='Y' ";

		if($searchtxt)
		{
			$wsql.=" and ( ";
			$wsql.=" pa_code like '%".$searchtxt."%' ";
			$wsql.=" or ";
			$wsql.=" pa_model like '%".$searchtxt."%' ";
			$wsql.=" or ";
			$wsql.=" pa_locate like '%".$searchtxt."%' ";
			$wsql.=" ) ";
		}

		$pg=apipaging("pa_code","packing",$jsql,$wsql);

		$sql=" select * from (";
		$sql.=" select ROW_NUMBER() OVER (ORDER BY pa_code desc) NUM ";	
		$sql.=" ,PA_SEQ,PA_CODE,PA_MODEL,PA_TITLE,PA_LOCATE,PA_TOP,PA_LEFT,PA_STATUS,PA_STAFF ";
		$sql.=" ,to_char(PA_DATE,'yyyy-mm-dd') as PA_DATE ";
		$sql.=" from ".$dbH."_packing  $jsql $wsql  ";
		$sql.=" order by pa_code desc ";
		$sql.=" ) where NUM>".$pg["snum"]." and NUM<=".$pg["tlast"];
		$res=dbqry($sql);

		$json["page"]=$pg["page"];
		$json["tcnt"]=$pg["tcnt"];
		$json["tpage"]=$pg["tpage"];
		$json["psize"]=$pg["psize"];
		$json["block"]=$pg["block"];
		$json["list"]=array();

		while($dt=dbarr($res))
		{
			if($dt["PA_MODEL"]){$PA_MODEL=$dt["PA_MODEL"];}else{$PA_MODEL=" - ";}	

			$addarray=array(			
				"seq"=>$dt["PA_SEQ"], 
				"paCode"=>$dt["PA_CODE"], 
				"paModel"=>$PA_MODEL, 
				"paTitle"=>$dt["PA_TITLE"], 
				"paLocate"=>$dt["PA_LOCATE"], 
				"paTop"=>$dt["PA_TOP"],
				"paLeft"=>$dt["PA_LEFT"],
				"paStatus"=>$dt["PA_STATUS"], 
				"paStaff"=>$dt["PA_STAFF"], 				
				"paDate"=>$dt["PA_DATE"]
				);
			array_push($json["list"], $addarray);
		}

		$json["sql"]=$sql;
		$json["apiCode"]=$apiCode;
		$json["resultCode"]="200";
		$json["resultMessage"]="OK";
	}
?>