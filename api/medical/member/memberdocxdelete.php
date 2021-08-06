<?php 
	///조제지시삭제 

	$apiCode=$_GET["apiCode"];
	$language=$_GET["language"];
	$md_seq=$_GET["mdSeq"];//seq

	if($apiCode!="memberdocxdelete"){$json["resultMessage"]="API(apiCode) ERROR";$apiCode="memberdocxdelete";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="API(language) ERROR";}
	else
	{	
		$sql=" update han_member_docx set MD_USE='D', MD_MODIFY=sysdate where MD_SEQ='".$md_seq."' ";
		dbcommit($sql);

		$json["sql"]=$sql;
		$json["mdTitle"]=$md_title;
		$json["apiCode"]=$apiCode;
		$json["resultCode"]="200";
		$json["resultMessage"]="OK";
	}
?>