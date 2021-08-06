<?php  
	/// 자재코드관리 > 조제태그관리 >  삭제
	$apicode=$_GET["apiCode"];
	$language=$_GET["language"];
	$pt_seq=$_GET["seq"];
	if($apicode!="pouchtagdelete"){$_GET["resultMessage"]="API(apiCode) ERROR";$apicode="pouchtagdelete";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="API(language) ERROR";}
	else if($pt_seq==""){$_GET["resultMessage"]="API(seq) ERROR";}
	else
	{		
		$sql=" update ".$dbH."_pouchtag set ";
		$sql.=" pt_use='D', pt_modify=SYSDATE ";
		$sql.=" where pt_seq='".$pt_seq."'";
		dbcommit($sql);

		$returnData=$_GET["returnData"];
		$json=array("apiCode"=>$apicode,"returnData"=>$returnData);
		$json["resultCode"]="200";
		$json["resultMessage"]="OK";
	}
?>