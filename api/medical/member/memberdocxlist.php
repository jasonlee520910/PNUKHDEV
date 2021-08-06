<?php

	$apiCode=$_GET["apiCode"];
	$language=$_GET["language"];
	$medicalId=$_GET["medicalId"];
	$doctorId=$_GET["doctorId"];
	$md_type=$_GET["mdType"];
	
	
	if($apiCode!="memberdocxlist"){$json["resultMessage"]="API(apiCode) ERROR";$apiCode="memberdocxlist";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="API(language) ERROR";}
	else
	{
		//조제지시&복용지시 리스트
		$jsql=" a   ";
		$wsql=" where  a.MD_USE<>'D' and a.MD_DOCTORID='".$doctorId."' and a.MD_TYPE='".$md_type."' ";
	
		$pg=apipaging("a.MD_SEQ","member_docx",$jsql,$wsql);

		$csql=" select * from (";
		$csql.=" select ROW_NUMBER() OVER (order by a.MD_DATE desc) NUM ";
		$csql.=" , a.MD_SEQ, a.MD_TYPE, a.MD_TITLE, a.MD_CONTENTS ";
		$csql.=" from ".$dbH."_member_docx  $jsql $wsql  ";
		$csql.=" order by a.MD_DATE desc";
		$csql.=" ) where NUM>".$pg["snum"]." and NUM<=".$pg["tlast"];

		$cres=dbqry($csql);
		$json["page"]=$pg["page"];
		$json["tcnt"]=$pg["tcnt"];
		$json["tpage"]=$pg["tpage"];
		$json["psize"]=$pg["psize"];
		$json["block"]=$pg["block"];
		$json["clist"]=array();

		while($cdt=dbarr($cres))
		{
			$addarray=array(
				"mdSeq"=>$cdt["MD_SEQ"], 
				"mdType"=>$cdt["MD_TYPE"],//복용인지, 조제인지 
				"mdTitle"=>$cdt["MD_TITLE"], //제목
				"mdContents"=>getClob($cdt["MD_CONTENTS"]) //내용 
			);
			array_push($json["clist"], $addarray);
		}

		$json["csql"] = $csql;
		$json["mdType"] = $md_type;

		$json["apiCode"]=$apiCode;
		$json["resultCode"]="200";
		$json["resultMessage"]="OK";
	}
?>