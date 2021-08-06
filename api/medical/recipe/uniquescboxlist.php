<?php  ///(추천처방-input 자동완성 box)
	$apiCode=$_GET["apiCode"];
	$language=$_GET["language"];
	$page=$_GET["page"];

	if($apiCode!="uniquescboxlist"){$json["resultMessage"]="API(apiCode) ERROR2";$apiCode="uniquescboxlist";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="API(language) ERROR";}
	else
	{

		$returnData=$_GET["returnData"];
		$json=array("apiCode"=>$apicode,"returnData"=>$returnData);
		$search=$_GET["searchTxt"]; ///검색단어

		$jsql="  ";
		$wsql=" where rc_use = 'Y' and rc_userid = '2172498925' ";   ///2172498925 -> han_recipemember 의 rc_userid 값

		if($search)  ///검색단어
		{
			$wsql.=" and rc_title_".$language." like '".$search."%'  ";
		}

		$sql=" select ";
		$sql.=" rc_code, rc_title_".$language." RCTITLE, rc_medicine RCMEDICINE ";
		$sql.=" from ".$dbH."_recipemember $jsql $wsql ";
		$sql.=" order by rc_seq desc ";

		$res=dbqry($sql);
		$json["sql"]=$sql;
		$json["list"]=array();

		while($dt=dbarr($res))
		{
			///------------------------------------------------------------
			/// DOO :: 약재정보 이름으로 보여지기 위한 쿼리 추가 
			///------------------------------------------------------------
			$rcMedicine = substr($dt["RCMEDICINE"], 1); ///한자리만 자르기 
			$rcMedicineTxt = getMedicine($rcMedicine, 'list');
			///------------------------------------------------------------
			$addarray = array(
					"rcCode"=>$dt["RC_CODE"],
					"rcTitle"=>$dt["RCTITLE"], 
					"rcMedicineTxt"=>$rcMedicineTxt,
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