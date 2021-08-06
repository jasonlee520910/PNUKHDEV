<?php  
	/// 제품재고관리 > 제품목록 > 구성요소 팝업 적용하기 버튼 
	$apicode=$_GET["apiCode"];
	$language=$_GET["language"];
	$seq=$_GET["seq"];
	$bomdata=$_GET["bomData"]; //bomdata

	if($apicode!="goodsresetcapa"){$json["resultMessage"]="API(apiCode) ERROR";$apicode="goodsresetcapa";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="API(language) ERROR";}
	else if($seq==""){$json["resultMessage"]="API(seq) ERROR";}
	else if($bomdata==""){$json["resultMessage"]="API(bomData) ERROR";}
	else
	{

		$sql=" update ".$dbH."_goods set gd_bomcode='".$bomdata."', gd_modify=sysdate where gd_seq='".$seq."' ";
		dbcommit($sql);

		$returnData=$_GET["returnData"];
		$json=array("apiCode"=>$apicode,"returnData"=>$returnData,"seq"=>$seq);
		$json["sql"]=$sql;
		$json["resultCode"]="200";
		$json["resultMessage"]="OK";
	}
?>