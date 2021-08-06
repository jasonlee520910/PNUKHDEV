<?php  
	///나의처방
	$apiCode=$_GET["apiCode"];
	$language=$_GET["language"];
	$page=$_GET["page"];
	$medicalId=$_GET["medicalId"]; ///한의원
	$meUserId=$_GET["meUserId"]; ///한의사

	if($apiCode!="myrecipelist"){$json["resultMessage"]="API(apiCode) ERROR2";$apiCode="myrecipelist";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="API(language) ERROR";}
	else
	{
		$returnData=$_GET["returnData"];
		$json=array("apiCode"=>$apiCode,"returnData"=>$returnData);
		$search=urldecode($_GET["searchTxt"]); ///검색단어
		$sdate = $_GET["sdate"];
		$edate = $_GET["edate"];

		$jsql=" a ";
		$wsql=" where a.rc_use = 'Y' and a.RC_MEDICAL='myrecipe' and  a.RC_MEMBER = '".$medicalId."' and a.RC_USERID='".$meUserId."' ";//한의원과 한의사ID로 검색하여 가져온다. 

		if($search)  ///검색단어
		{
			$wsql.=" and ( ";
			$wsql.=" a.rc_title_kor like '%".$search."%' ";///처방명
			$wsql.=" ) ";
		}

		if($sdate&&$edate) //등록일 기준 
		{
			$wsql.=" and ( ";
			$wsql.=" to_char(a.RC_DATE, 'yyyy-mm-dd') >= '".$sdate."' and to_char(a.RC_DATE, 'yyyy-mm-dd') <= '".$edate."' ";
			$wsql.=" ) ";
		}

		$pg=apipaging("a.rc_code","RECIPEMEDICAL",$jsql,$wsql);

		$sql=" select * from (";
		$sql.=" select ROW_NUMBER() OVER (ORDER BY a.rc_seq) NUM ";
		$sql.=" ,a.rc_seq RCSEQ, a.rc_code ,a.rc_title_kor RCTITLE, a.RC_CHUB, a.RC_PACKCNT, a.RC_PACKCAPA ";
		$sql.=" ,a.rc_medicine RCMEDICINE ";
		$sql.=" from ".$dbH."_RECIPEMEDICAL  $jsql $wsql  ";
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

			$arr=explode("|",$rcMedicine);///약재갯수(약미)
			$addarray = array(
					"seq"=>$dt["RCSEQ"], ///seq
					"rcType"=>"탕제",
					"rcCode"=>$dt["RC_CODE"], ///rcCode
					"rcChub"=>$dt["RC_CHUB"], ///첩수 
					"rcPackcnt"=>$dt["RC_PACKCNT"],//팩수
					"rcPackcapa"=>$dt["RC_PACKCAPA"],//팩용량
					"rcTitle"=>$dt["RCTITLE"], ///처방명 
					"rcMedicine"=>$rcMedicineTxt, ///약재리스트
					"rcEtc"=>"",
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