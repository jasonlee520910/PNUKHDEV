<?php  
	///처방관리 > 처방서적 > 처방서적 상세보기
	$apiCode=$_GET["apiCode"];
	$language=$_GET["language"];
	$rb_seq=$_GET["seq"];
	
	if($apiCode!="resourcebookdesc"){$json["resultMessage"]="API(apiCode) ERROR";$apiCode="resourcebookdesc";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="API(language) ERROR";}
	else
	{
		if(isset($rb_seq) && $rb_seq != '') ///클릭하면 상세 출력
		{
			$sql=" select RB_SEQ,RB_CODE,RB_TITLE_KOR,RB_TITLE_CHN,RB_INDEX,RB_BOOKNO ";
			//$sql.=" ,DBMS_LOB.SUBSTR(RB_DESC_KOR, DBMS_LOB.GETLENGTH(RB_DESC_KOR)) as RB_DESC_KOR ";
			//$sql.=" ,DBMS_LOB.SUBSTR(RB_DESC_CHN, DBMS_LOB.GETLENGTH(RB_DESC_CHN)) as RB_DESC_CHN ";
			$sql.=" ,RB_DESC_KOR ";
			$sql.=" ,RB_DESC_CHN ";
			$sql.=" from ".$dbH."_recipebook where rb_seq='".$rb_seq."'";			
			$dt=dbone($sql);

			$json=array(
				"seq"=>$dt["RB_SEQ"], 
				"rbCode"=>$dt["RB_CODE"], 
				"rbTitle"=>$dt["RB_TITLE_KOR"], 
				"rbTitleKor"=>$dt["RB_TITLE_KOR"], 
				"rbTitleChn"=>$dt["RB_TITLE_CHN"], 
				"rbDescKor"=>getClob($dt["RB_DESC_KOR"]), 
				"rbDescChn"=>getClob($dt["RB_DESC_CHN"]), 
				"rbIndex"=>$dt["RB_INDEX"], 
				"rbBookno"=>$dt["RB_BOOKNO"], 
				"rbDate"=>$dt["RB_DATE"]
				);
			}

		$json["sql"]=$sql;
		$json["apiCode"]=$apiCode;
		$json["resultCode"]="200";
		$json["resultMessage"]="OK";
	}
?>
