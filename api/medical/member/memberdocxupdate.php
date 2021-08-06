<?php ///
	$apiCode=$_POST["apiCode"];
	$language=$_POST["language"];

	$md_doctorid=$_POST["doctorId"];//한의사id
	$md_medicalid=$_POST["medicalId"];//한의원id
	$md_seq=$_POST["mdSeq"];//seq
	$md_title=$_POST["mdTitle"];//제목
	$md_contents=$_POST["mdContents"];//내용 
	

	if($apiCode!="memberdocxupdate"){$json["resultMessage"]="API(apiCode) ERROR";$apiCode="memberdocxupdate";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="API(language) ERROR";}
	else
	{
		$md_type=$_POST["mdType"];
		$md_fileIdx=$_POST["mdFileIdx"];//파일첨부 

		if(isEmpty($md_seq)==false)
		{
			$sql=" update han_member_docx set MD_TITLE='".$md_title."', MD_CONTENTS='".$md_contents."', MD_MODIFY=sysdate where  MD_SEQ='".$md_seq."' ";
			dbcommit($sql);
		}
		else
		{
			$sql=" insert into han_member_docx (MD_SEQ, MD_TYPE, MD_MEDICALID, MD_DOCTORID, MD_FILEIDX, MD_TITLE, MD_CONTENTS, MD_USE, MD_DATE, MD_MODIFY) values ((SELECT NVL(MAX(MD_SEQ),0)+1 FROM han_member_docx), '".$md_type."','".$md_medicalid."','".$md_doctorid."','".$md_fileIdx."','".$md_title."','".$md_contents."','Y', sysdate, sysdate) ";
			dbcommit($sql);
		}
		
		$json["sql"]=$sql;
		$json["mdSeq"]=$md_seq;
		$json["mdTitle"]=$md_title;
		$json["apiCode"]=$apiCode;
		$json["resultCode"]="200";
		$json["resultMessage"]="OK";
	}
?>