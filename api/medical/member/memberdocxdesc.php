<?php 
	//조제지시&복용법 상세 
	$apiCode=$_GET["apiCode"];
	$language=$_GET["language"];
	$md_seq=$_GET["mdSeq"];
	

	if($apiCode!="memberdocxdesc"){$json["resultMessage"]="API(apiCode) ERROR";$apiCode="memberdocxdesc";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="API(language) ERROR";}
	else
	{
		//상세 
		$sql="select MD_SEQ, MD_TYPE, MD_FILEIDX, MD_TITLE, MD_CONTENTS  ";
		$sql.=" from ".$dbH."_MEMBER_DOCX where MD_SEQ='".$md_seq."' ";
		$dt=dbone($sql);

		$json["mdSeq"]=$dt["MD_SEQ"];
		$json["mdType"]=$dt["MD_TYPE"];
		$mdFileIdx=$dt["MD_FILEIDX"];
		$json["mdFileidx"]=$mdFileIdx;
		$json["mdTitle"]=$dt["MD_TITLE"];
		$json["mdContents"]=getClob($dt["MD_CONTENTS"]);

		if(isEmpty($mdFileIdx)==false)//데이터가 있다면 
		{
			$fsql=" select AF_NAME, AF_URL, AF_SIZE from han_file where AF_SEQ='".$mdFileIdx."' and AF_USE='Y' ";
			$fdt=dbone($fsql);
			$json["afName"]=$fdt["AF_NAME"];
			$json["afUrl"]=getafFile($fdt["AF_URL"]);
			$json["afThumbUrl"]=getafThumbUrl($fdt["AF_URL"]);
			$json["afSize"]=$fdt["AF_SIZE"];
		}

		$json["sql"]=$sql;
		$json["apiCode"]=$apiCode;
		$json["resultCode"]="200";
		$json["resultMessage"]="OK";	
		$json["returnData"]=$_GET["returnData"];
	}
?>