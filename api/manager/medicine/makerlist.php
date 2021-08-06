<?php  
	///약재관리 > 스탭관리 리스트
	$apiCode=$_GET["apiCode"];
	$language=$_GET["language"];
	$page=$_GET["page"];

	if($apiCode!="makerlist"){$json["resultMessage"]="API(apiCode) ERROR";$apiCode="makerlist";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="API(language) ERROR";}
	else
	{
		$searchtxt=$_GET["searchTxt"]; ///검색하는 단어

		$search="";
		$jsql=" a  ";
		$wsql=" where a.cd_use <>'D'  ";



		///단어 검색
		if($searchtxt)
		{
			$wsql.=" and ( ";
			$wsql.=" a.cd_name_kor like '%".$searchtxt."%' ";///제약사 이름
			$wsql.=" ) ";

			$search.="&searchType=".$searchtxt;
		}

		$pg=apipaging("cd_seq","maker",$jsql,$wsql);

		$sql=" select * from (";
		$sql.=" select ROW_NUMBER() OVER (ORDER BY a.cd_seq desc) NUM ";
		$sql.=" ,a.cd_seq, a.cd_type, a.cd_name_kor,to_char(a.cd_date,'yyyy-mm-dd') as CDDATE ";		
		$sql.=" from ".$dbH."_maker $jsql $wsql ";
		$sql.=" order by a.cd_seq desc ";
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
			$addarray=array(
				"seq"=>$dt["CD_SEQ"], 
				"cd_type"=>$dt["CD_TYPE"],  
				"cd_name_kor"=>$dt["CD_NAME_KOR"], 
				"cdDate"=>$dt["CDDATE"]
				);
			array_push($json["list"], $addarray);
		}

		$json["sql"]=$sql;
		$json["apiCode"]=$apiCode;
		$json["resultCode"]="200";
		$json["resultMessage"]="OK";
	}
?>