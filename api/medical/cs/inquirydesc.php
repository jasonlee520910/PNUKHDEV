<?php  
	///고객센터 > 1대1문의상세보기
	$apiCode=$_GET["apiCode"];
	$language=$_GET["language"];
	$seq=$_GET["seq"];

	if($apiCode!="inquirydesc"){$json["resultMessage"]="API(apiCode) ERROR2";$apiCode="inquirydesc";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="API(language) ERROR";}
	else
	{
		if($seq)
		{

			$sql=" select ";
			$sql.=" bb_seq,bb_code,bb_userid,bb_title,bb_desc,bb_type,bb_indate,bb_answer";
			//$sql.=" ,to_char(a.bb_indate,'yyyy-mm-dd') as bb_indate "; 
			//$sql.=" ,to_char(a.bb_modify,'yyyy-mm-dd') as bb_modify "; 
			$sql.=" from ".$dbH."_board  where bb_seq='".$seq."'";
			$dt=dbone($sql);
	//echo $sql;

			if($dt["BB_ANSWER"]){$bb_answer=getClob($dt["BB_ANSWER"]);}else{$bb_answer="";}
			$json=array(
				"seq"=>$dt["BB_SEQ"], 
				"bb_code"=>$dt["BB_CODE"], 
				"bb_title"=>$dt["BB_TITLE"], 
				"bb_desc"=>getClob($dt["BB_DESC"]), 
				"bb_answer"=>$bb_answer, 
				"bb_type"=>$dt["BB_TYPE"], 
				"bb_indate"=>$dt["BB_INDATE"], 
				"bb_modify"=>$dt["BB_MODIFY"] 	
				);
		}
	
		$json["sql"]=$sql;
		$json["apiCode"]=$apiCode;
		$json["resultCode"]="200";
		$json["resultMessage"]="OK";
	}
?>


