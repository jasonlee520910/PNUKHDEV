<?php
	$json["resultCode"]="204";
	$apicode=$resjson["apiCode"];
	$language=$resjson["language"];
	if($apicode!="tutorialupdate"){$json["resultMessage"]="API코드오류";$apicode="tutorialupdate";}
	//else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="언어코드오류";}
	else{
		$tu_seq=$resjson["seq"];
		$tu_no=$resjson["tuNo"];
		if(!$tu_no){$tu_no=1;}else{$tu_no++;}
		$afFiles=$resjson["afFiles"];
		$tu_desc_kor=addslashes($resjson["tuDesckor"]);
		$tu_desc_chn=addslashes($resjson["tuDescchn"]);
		$tu_desc_eng=addslashes($resjson["tuDesceng"]);
		$returnData=$resjson["returnData"];
		$json=array("apiCode"=>$apicode,"returnData"=>$returnData);
		$sqlall="";
		if($tu_seq && $tu_seq !="add"){
			$sql=" update ".$dbH."_tutorial set tu_desc_kor='".$tu_desc_kor."',tu_desc_chn='".$tu_desc_chn."',tu_desc_eng='".$tu_desc_eng."',tu_modify=now() where tu_seq='".$tu_seq."'";
			dbqry($sql);
			$sqlall.=$sql;
			$newseq=$tu_seq;
			$newno=$tu_no;
		}else{
			//현순서보다 크거나 같은것 모두 +1
			$sql=" update ".$dbH."_tutorial set tu_no = tu_no + 1 where tu_no >= '".$tu_no."'";
			$sqlall.=$sql;
			dbqry($sql);
			$sql=" insert into ".$dbH."_tutorial (tu_no, tu_desc_kor, tu_desc_chn, tu_desc_eng, tu_date) values ('".$tu_no."','".$tu_desc_kor."','".$tu_desc_chn."','".$tu_desc_eng."',now())";
			$sqlall.=$sql;
			dbqry($sql);
			$sql=" select tu_seq, tu_no from ".$dbH."_tutorial where tu_use='Y' order by tu_seq desc limit 0, 1";
			$sqlall.=$sql;
			$dt=dbone($sql);
			$newseq=$dt["tu_seq"];
			$newno=$dt["tu_no"];
		}
		if($afFiles){
			$sql=" update ".$dbH."_file set af_afseq='".$newseq."', af_no='".$newno."' where af_seq='".$afFiles."'";
			$sqlall.=$sql;
			dbqry($sql);
		}
		$sql=" select af_url from ".$dbH."_file where af_afseq='".$newseq."' and af_code='tutorial' ";
		$sqlall.=$sql;
		$dt=dbone($sql);
		$newsrc=$dtdom.$dt["af_url"];

		$json["newseq"]=$newseq;
		$json["newsrc"]=$newsrc;
		$json["newno"]=$newno;
		$json["sql"]=$sqlall;
		$json["resultCode"]="200";
		$json["resultMessage"]="OK";
	}
?>