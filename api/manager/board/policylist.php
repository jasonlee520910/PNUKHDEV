<?php
	/// 환경설정 > 개인정보처리 > 리스트 
	$apiCode=$_GET["apiCode"];
	$language=$_GET["language"];
	$page=$_GET["page"];

	if($apiCode!="policylist"){$json["resultMessage"]="API(apiCode) ERROR";$apiCode="policylist";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="API(language) ERROR";}
	else{
		
		$searchtxt=$_GET["searchTxt"]; 

		//$jsql=" a left join ".$dbH."_code b on b.CD_TYPE='inPolicy' and b.CD_CODE=a.PO_TYPE and b.CD_USE='Y' ";
		$jsql=" a ";
		$wsql=" where a.PO_USE <> 'D' ";

		if($searchtxt)
		{
			$wsql.=" and ( ";
			$wsql.=" a.PO_CONTENTS".$language." like '%".$searchtxt."%' )";
		}

		$wsql.=" group by a.PO_GROUP ";


		$pg=apipaging("a.PO_SEQ","policy",$jsql,$wsql);

		$sql=" select * from (";
		$sql.=" select ROW_NUMBER() OVER (ORDER BY a.PO_GROUP DESC) NUM ";
		$sql.=" , to_char(a.PO_GROUP, 'yyyy-mm-dd') as poGroup ";
		$sql.=" from ".$dbH."_policy $jsql $wsql  ";
		$sql.=" ) where NUM>".$pg["snum"]." and NUM<=".$pg["tlast"];

		
	
		$res=dbqry($sql);
		$json["page"]=$pg["page"];
		$json["tcnt"]=$pg["tcnt"];
		$json["tpage"]=$pg["tpage"];
		$json["psize"]=$pg["psize"];
		$json["block"]=$pg["block"];

		$json["sql"]=$sql;
		$json["list"]=array();

		while($dt=dbarr($res))
		{
			$addarray=array(
				"poGroup"=>$dt["POGROUP"]//날짜
			);
			array_push($json["list"], $addarray);
		}

		$json["apiCode"]=$apiCode;
		$json["returnData"]=$returnData;
		$json["resultCode"]="200";
		$json["resultMessage"]="OK";
	}
?>