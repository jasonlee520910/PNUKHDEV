<?php
	//GET
	$apiCode=$_GET["apiCode"];
	$language=$_GET["language"];
	$odKeycode=$_GET["odKeycode"];
	$medicode=$_GET["medicode"];
	
	if($apiCode!="changemedicodelist"){$json["resultMessage"]="API(apiCode) ERROR";$apiCode="changemedicodelist";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="API(language) ERROR";}
	else if($medicode==""){$json["resultMessage"]="API(medicode) ERROR";}
	else
	{
		$json["odKeycode"]=$odKeycode;
		$json["medicode"]=$medicode;

		$meditmp=substr($medicode,0, 6);
		$medihub=str_replace('HD','HB',$meditmp);

		$jsql=" a inner join ".$dbH."_medicine_djmedi b on b.md_code=a.md_code and b.mm_use <> 'D' 
				 inner join ".$dbH."_medihub d on d.mh_code=a.md_hub ";
		$wsql=" where a.md_use <> 'D' and a.md_hub='".$medihub."' and a.md_code != '".$medicode."'  "; 

		$gsql = " group by a.md_seq, a.md_type, a.md_code, b.md_code, b.mm_title_kor, a.md_origin_kor, a.md_maker_kor, d.mh_title_kor, a.md_date  ";

		$pg=apipaging("a.md_seq","medicine",$jsql,$wsql);

		$sql=" select * from (
					select ROW_NUMBER() OVER (ORDER BY a.md_date desc) NUM,   
					a.md_seq, a.md_type, b.md_code, b.mm_title_kor mmTitle, a.md_origin_kor mdOrigin, a.md_maker_kor mdMaker, d.mh_title_kor mhTitle  
					from ".$dbH."_medicine $jsql $wsql $gsql order by a.md_date desc ) where NUM>".$pg["snum"]." and NUM<=".$pg["tlast"];
		$res=dbqry($sql);
		$json["sql"]=$sql;
		$json["pg"]=$pg;
		$json["page"]=$pg["page"];
		$json["tcnt"]=$pg["tcnt"];
		$json["tpage"]=$pg["tpage"];
		$json["psize"]=$pg["psize"];
		$json["block"]=$pg["block"];
		$json["list"]=array();

		while($dt=dbarr($res))
		{
			$mdType=$dt["MD_TYPE"];
			$mdCode=$dt["MD_CODE"];
			$mdTitle=$dt["MMTITLE"];
			$mdOrigin=$dt["MDORIGIN"];
			$mdMaker=$dt["MDMAKER"];
			$mhTitle=$dt["MHTITLE"];
			
			$addarray=array(
				"mdType"=>$mdType,
				"mdCode"=>$mdCode, 
				"mdTitle"=>$mdTitle,//약재명 
				"mhTitle"=>$mhTitle,//본초명
				"mdOrigin"=>$mdOrigin, //원산지
				"mdMaker"=>$mdMaker //제조사
				);
			array_push($json["list"], $addarray);
		}
		$json["medicode"]=$medicode;
		$json["apiCode"]=$apiCode;
		$json["resultCode"]="200";
		$json["resultMessage"]="OK";
	
	}
?>
