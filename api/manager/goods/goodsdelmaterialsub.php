<?php
	$apicode=$_GET["apiCode"];
	$language=$_GET["language"];
	$topseq=$_GET["topseq"];
	$gdcode=$_GET["goods"];
	$delcode=$_GET["code"];
	if($apicode!="goodsdelmaterialsub"){$json["resultMessage"]="API(apiCode) ERROR";$apicode="goodsdelmaterialsub";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="API(language) ERROR";}
	else if($topseq==""){$json["resultMessage"]="API(topseq) ERROR";}
	else if($gdcode==""){$json["resultMessage"]="API(gdcode) ERROR";}
	else if($delcode==""){$json["resultMessage"]="API(delcode) ERROR";}
	else{
		$sql=" select gd_bomcode from ".$dbH."_goods where gd_code='".$gdcode."' ";
		$json["sql1"]=$sql;
		$dt=dbone($sql);
		$gd_bomcode=$dt["gd_bomcode"];
		$boarr=explode(",",$gd_bomcode);
		if (($key = array_search($delcode, $boarr)) !== false) {
			unset($boarr[$key]);
		}
		$gdbomcode=implode(",",$boarr);

		$sql=" update ".$dbH."_goods set gd_bomcode='".$gdbomcode."', gd_modify=now() where gd_code='".$gdcode."' ";
		dbqry($sql);

		$returnData=$_GET["returnData"];
		$json=array("apiCode"=>$apicode,"returnData"=>$returnData,"seq"=>$topseq);
		$json["sql2"]=$sql;
		$json["resultCode"]="200";
		$json["resultMessage"]="OK";
	}
?>