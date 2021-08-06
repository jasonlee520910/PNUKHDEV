<?php  
	///나의처방
	$apiCode=$_GET["apiCode"];
	$language=$_GET["language"];
	$page=$_GET["page"];
	$medicalId=$_GET["medicalId"]; ///한의원
	$meUserId=$_GET["meUserId"]; ///한의사

	if($apiCode!="mediuniqsclist"){$json["resultMessage"]="API(apiCode) ERROR2";$apiCode="mediuniqsclist";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="API(language) ERROR";}
	else
	{
		$returnData=$_GET["returnData"];
		$json=array("apiCode"=>$apiCode,"returnData"=>$returnData);
		$search=$_GET["searchTxt"]; ///검색단어

		$jsql=" a ";
		$wsql=" where a.rc_use = 'Y' and a.RC_MEDICAL = '".$medicalId."' and a.RC_USERID='".$meUserId."' ";//한의원과 한의사ID로 검색하여 가져온다. 

		if($search)  ///검색단어
		{
			$wsql.=" and ( ";
			$wsql.=" a.rc_title_".$language." like '%".$search."%' ";///처방명
			$wsql.=" ) ";
		}

		$pg=apipaging("a.rc_code","recipemember",$jsql,$wsql);

		$sql=" select * from (";
		$sql.=" select ROW_NUMBER() OVER (ORDER BY a.rc_seq) NUM ";
		$sql.=" ,a.rc_seq RCSEQ, a.rc_code , a.rc_chub, a.rc_title_kor RCTITLE ";
		$sql.=" ,a.rc_medicine RCMEDICINE ";
		$sql.=" from ".$dbH."_recipemember  $jsql $wsql  ";
		$sql.=" order by a.rc_seq ";
		$sql.=" ) where NUM>".$pg["snum"]." and NUM<=".$pg["tlast"];


		$res=dbqry($sql);
		$json["sql"]=$sql;
		$json["page"]=$pg["page"];
		$json["tcnt"]=$pg["tcnt"];
		$json["tpage"]=$pg["tpage"];
		$json["psize"]=$pg["psize"];
		$json["block"]=$pg["block"];
		$json["list"]=array();

		while($dt=dbarr($res))
		{
			$rcMedicine = substr(getClob($dt["RCMEDICINE"]), 1); ///한자리만 자르기 
			$rcMedicineTxt = getMedicine($rcMedicine, 'list');

			$rcChub = ($dt["RC_CHUB"]) ? $dt["RC_CHUB"] : "1";

			$arr=explode("|",$rcMedicine);///약재갯수(약미)
			$addarray = array(
					"seq"=>$dt["RCSEQ"], ///seq
					"rcCode"=>$dt["RC_CODE"], ///rcCode
					"rcTitle"=>$dt["RCTITLE"], ///처방명 
					"rcChub"=>$rcChub,///첩수 
					"rcMedicine"=>$rcMedicine, ///약재리스트
					"rcMedicineTxt"=>$rcMedicineTxt,///약재명 
					"rcMedicineCnt"=>count($arr)  ///약재갯수 	
					);
			array_push($json["list"], $addarray);
		}
		$json["search"]=$search;
		$json["sql"]=$sql;
		$json["apiCode"]=$apiCode;
		$json["resultCode"]="200";
		$json["resultMessage"]="OK";
	}
?>