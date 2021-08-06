<?php
	$apicode=$_GET["apiCode"];
	$language=$_GET["language"];
	$page=$_GET["page"];
	if($apicode!="tutorialmove"){$json["resultMessage"]="API코드오류";$apicode="tutorialmove";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="언어코드오류";}
	else{
		$returnData=$_GET["returnData"];
		$json=array("apiCode"=>$apicode,"returnData"=>$returnData);
		$seq=$_GET["seq"];
		$dir=$_GET["dir"];
		$tuNo=$_GET["tuNo"];
		switch($dir){
			case "right":
				$newno=intval($tuNo) + 1;
				break;
			case "left":
				$newno=intval($tuNo) - 1;
				break;
		}
		$sql=" select tu_seq from ".$dbH."_tutorial where tu_no='".$newno."'";
		$sqlall.=$sql;
		$dt=dbone($sql);
		$newseq=$dt["tu_seq"];
		$sql=" update ".$dbH."_tutorial set tu_no='".$tuNo."' where tu_seq='".$newseq."'";
		$sqlall.=$sql;
		dbqry($sql);
		$sql=" update ".$dbH."_tutorial set tu_no='".$newno."' where tu_seq='".$seq."'";
		$sqlall.=$sql;
		dbqry($sql);

		$json["sql"]=$sqlall;
		$json["seq"]=$seq;
		$json["tuNo"]=$tuNo;
		$json["newseq"]=$newseq;
		$json["newno"]=$newno;
		$json["resultCode"]="200";
		$json["resultMessage"]="OK";
	}
?>