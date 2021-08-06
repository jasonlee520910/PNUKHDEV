<?php  
	///처방관리 > 처방서적 > 처방서적 등록&수정
	$apicode=$_POST["apiCode"];
	$language=$_POST["language"];
	if($apicode!="resourcebookupdate"){$json["resultMessage"]="API(apiCode) ERROR";$apicode="resourcebookupdate";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="API(language) ERROR";}
	else
	{
		$rb_seq=$_POST["seq"];
		$rb_code=$_POST["rbCode"];
		if(!$rb_code||$rb_code=="add")
		{
			$rb_code="RB".date("YmdHis");
		}
		$rb_title_kor=$_POST["rbTitleKor"];
		$rb_desc_kor=$_POST["rbDescKor"];
		$rb_title_chn=$_POST["rbTitleChn"];
		$rb_desc_chn=$_POST["rbDescChn"];
		$rb_index=$_POST["rbIndex"];
		$rb_bookno=$_POST["rbBookno"];
		
		if($rb_seq&&$rb_seq!="add")
		{
			$sql=" update ".$dbH."_recipebook set ";
			$sql.=" rb_title_kor ='".$rb_title_kor."' ";
			$sql.=",rb_title_chn ='".$rb_title_chn."' ";
			$sql.=",rb_desc_kor ='".$rb_desc_kor."' ";
			$sql.=",rb_desc_chn ='".$rb_desc_chn."' ";
			$sql.=",rb_index ='".$rb_index."' ";
			$sql.=",rb_bookno ='".$rb_bookno."' ";
			$sql.=",rb_date=SYSDATE ";
			$sql.=" where rb_seq='".$rb_seq."'";
		}
		else
		{
			$sql=" insert into ".$dbH."_recipebook (rb_seq,rb_code, rb_title_kor, rb_title_chn, rb_index, rb_bookno, rb_desc_kor, rb_desc_chn, rb_use ,rb_date) values ((SELECT NVL(MAX(rb_seq),0)+1 FROM ".$dbH."_recipebook),'".$rb_code."','".$rb_title_kor."','".$rb_title_chn."','".$rb_index."','".$rb_bookno."','".$rb_desc_kor."','".$rb_desc_chn."','Y',SYSDATE) ";
		}
		dbcommit($sql);
		$returnData=$_POST["returnData"];
		$json=array("apiCode"=>$apicode,"returnData"=>$returnData);
		$json["sql"]=$sql;
		$json["resultCode"]="200";
		$json["resultMessage"]="OK";
	}
?>
