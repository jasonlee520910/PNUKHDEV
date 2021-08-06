<?php
	/// 환경설정 > 코드관리 > 리스트 
	$apiCode=$_GET["apiCode"];
	$language=$_GET["language"];
	$page=$_GET["page"];

	if($apiCode!="codelist"){$json["resultMessage"]="API(apiCode) ERROR";$apiCode="codelist";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="API(language) ERROR";}
	else{
		
		$searchtxt=$_GET["searchTxt"]; 

		$jsql=" a ";
		$wsql=" where a.cd_use <> 'D' ";

		if($searchtxt)
		{
			$wsql.=" and (a.cd_type_".$language." like '%".$searchtxt."%'";
			$wsql.=" or a.cd_type like '%".$searchtxt."%'";
			$wsql.=" or a.cd_code like '%".$searchtxt."%'";
			$wsql.=" or a.cd_name_".$language." like '%".$searchtxt."%' ";
			$wsql.=" or a.cd_desc_".$language." like '%".$searchtxt."%' ";
			$wsql.=" or a.cd_value_".$language." like '%".$searchtxt."%' ) ";
		}

		$pg=apipaging("a.cd_type","code",$jsql,$wsql);

		//list에서는 이렇게 4000까지만 뽑아서 뿌려준다. 
		$sql=" select * from (";
		$sql.=" select ROW_NUMBER() OVER (ORDER BY a.cd_type) NUM ";
		$sql.=" ,a.cd_type, a.cd_type_".$language." as cdTypeName, min(DBMS_LOB.SUBSTR(a.cd_desc_kor, 4000, 1)) as cdDesc, to_char(max(a.CD_MODIFY), 'yyyy-mm-dd hh24:mi:ss') as cdDate ";
		$sql.=" ,( select count(cd_seq) from ".$dbH."_code where cd_type=a.cd_type and cd_use = 'Y') subcnt ";
		$sql.=" from ".$dbH."_code $jsql $wsql  ";
		$sql.=" group by a.cd_type, a.cd_type_".$language;
		$sql.=" order by a.cd_type asc ";
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
			if($dt["CDDESC"]) {$desc=$dt["CDDESC"];}else{$desc='';}

			$addarray=array(
				"cdType"=>$dt["CD_TYPE"], /// 그룹코드
				"cdTypeTxt"=>$dt["CDTYPENAME"],///그룹코드명
				"cdDesc"=>$desc, ///코드설명
				"cdDate"=>$dt["CDDATE"], ///수정일
				"cdSubcnt"=>$dt["SUBCNT"]///서브코드갯수 
			);
			array_push($json["list"], $addarray);
		}

		$json["apiCode"]=$apiCode;
		$json["returnData"]=$returnData;
		$json["resultCode"]="200";
		$json["resultMessage"]="OK";
	}
?>