<?php
	$apicode=$_GET["apiCode"];
	$language=$_GET["language"];
	$tu_seq=$_GET["seq"];
	if($apicode!="tutorialdelete"){$json["resultMessage"]="API코드오류";$apiCode="tutorialdelete";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="언어코드오류";}
	else{
		$returnData=$_GET["returnData"];
		$sql=" select (select tu_no from ".$dbH."_tutorial where tu_seq = '".$tu_seq."') tuNo, tu_seq, tu_no, af_url from ".$dbH."_tutorial a 
			inner join ".$dbH."_file f on a.tu_seq=f.af_afseq and f.af_code='tutorial' and f.af_use = 'Y' 
			where  tu_use='Y' and tu_no < 
			(select tu_no from ".$dbH."_tutorial where tu_seq = '".$tu_seq."')
			order by tu_no desc limit 0, 1 ";
		$sqlall.=$sql;
		$dt=dbone($sql);
		$tuNo=$dt["tuNo"];
		$newseq=$dt["tu_seq"];
		$newsrc=$dtdom.$dt["af_url"];
		$newno=$dt["tu_no"];
		$sql=" update ".$dbH."_tutorial set tu_no=tu_no - 1 where tu_no > '".$tuNo."' and tu_use='Y' ";
		$sqlall.=$sql;
		dbqry($sql);
		$sql=" update ".$dbH."_tutorial set tu_use='D' where tu_seq = '".$tu_seq."' and tu_use='Y'  ";
		$sqlall.=$sql;
		dbqry($sql);
		$sql=" update ".$dbH."_file set af_use='D' where af_afseq= '".$tu_seq."' and af_code='tutorial' ";
		$sqlall.=$sql;
		dbqry($sql);
		$json=array("apiCode"=>$apicode, "returnData"=>$returnDat, "seq"=>$tu_seq, "newseq"=>$newseq, "newsrc"=>$newsrc, "newno"=>$newno);
		$json["sql"]=$sqlall;
		$json["resultCode"]="200";
		$json["resultMessage"]="OK";
	}
?>