<?php /// 방제사전
	///GET
	$apiCode=$_GET["apiCode"];
	$language=$_GET["language"];
	$rb_seq=$_GET["seq"];

	if($apiCode!="resourcedesc"){$json["resultMessage"]="API(apiCode) ERROR2";$apiCode="resourcedesc";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="API(language) ERROR";}
	else if($rb_seq==""){$json["resultMessage"]=" API(rb_seq) ERROR";}
	else
	{
		$sql=" select rb_seq, rb_title_".$language." RBTITLE, rb_desc_".$language." RBDESC, rb_index, rb_bookno  from ".$dbH."_recipebook where rb_seq='".$rb_seq."'";
		$dt=dbone($sql);
		$json=array( 
			"rbSeq"=>$dt["RB_SEQ"], 
			///"rbCode"=>$dt["rb_code"], 
			"rbTitle"=>$dt["RBTITLE"], 
			"rbDesc"=>$dt["RBDESC"], 
			"rbIndex"=>$dt["RB_INDEX"], 
			"rbBookno"=>$dt["RB_BOOKNO"] 

			);

		$json["sql"]=$sql;
		$json["apiCode"]=$apiCode;
		$json["resultCode"]="200";
		$json["resultMessage"]="OK";
	}
?>
