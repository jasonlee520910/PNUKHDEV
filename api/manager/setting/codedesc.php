<?php
	/// 환경설정 > 코드관리 > 상세
	$apiCode=$_GET["apiCode"];
	$language=$_GET["language"];
	$cd_type=$_GET["seq"];
	$returnData=$_GET["returnData"];

	if($apiCode!="codedesc"){$json["resultMessage"]="API(apiCode) ERROR";$apiCode="codedesc";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="API(language) ERROR";}
	else{
		$jsql="";
		$wsql=" where cd_use <> 'D' and cd_type = '".$cd_type."' ";
		$sql=" select CD_SEQ, CD_TYPE, CD_TYPE_KOR, CD_TYPE_CHN, CD_CODE, CD_NAME_KOR, CD_NAME_CHN, CD_SORT ";
		$sql.=", CD_DESC_KOR as cdDescKor, CD_DESC_CHN as cdDescChn ";
		$sql.=", CD_VALUE_KOR as cdValueKor, CD_VALUE_CHN as cdValueChn ";
		$sql.=", to_char(CD_MODIFY, 'yyyy-mm-dd hh24:mi:ss') as cdDate";
		$sql.=" from ".$dbH."_code $jsql $wsql order by cd_sort";

		$res=dbqry($sql);
		$json["list"]=array();
		$i = 0;
		while($dt=dbarr($res))
		{
			if($i == 0)
			{
				$json["cdType"] = $dt["CD_TYPE"];
				$json["cdTypeTxtkor"] = $dt["CD_TYPE_KOR"];
				$json["cdTypeTxtchn"] = $dt["CD_TYPE_CHN"];
				$json["cdDesckor"] = getClob($dt["CDDESCKOR"]);
				$json["cdDescchn"] = getClob($dt["CDDESCCHN"]);
			}
			$addarray=array(
				"seq"=>$dt["CD_SEQ"], 
				"cdType"=>$dt["CD_TYPE"], 
				"cdTypeTxtkor"=>$dt["CD_TYPE_KOR"], ///코드타입한글
				"cdTypeTxtchn"=>$dt["CD_TYPE_CHN"], ///코드타입중문
				"cdCode"=>$dt["CD_CODE"], 
				"cdNamekor"=>$dt["CD_NAME_KOR"], ///코드명한글
				"cdNamechn"=>$dt["CD_NAME_CHN"], ///코드명중문
				"cdDesckor"=>getClob($dt["CDDESCKOR"]), ///코드설명한글
				"cdDescchn"=>getClob($dt["CDDESCCHN"]), ///코드설명중문
				"cdSort"=>$dt["CD_SORT"],
				"cdValuekor"=>getClob($dt["CDVALUEKOR"]), ///코드값한글
				"cdValuechn"=>getClob($dt["CDVALUECHN"]), ///코드값중문
				"cdDate"=>$dt["CDDATE"]/// 수정일 
			);
			array_push($json["list"], $addarray);
			$i++;
		}

		$json["sql"]=$sql;
		$json["apiCode"]=$apiCode;
		$json["returnData"]=$returnData;
		$json["resultCode"]="200";
		$json["resultMessage"]="OK";
	}
?>