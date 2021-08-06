<?php  
	/// 제품재고관리 > 제품목록 > 등록 & 수정 >  팝업에서 제품을 추가할때
	$apicode=$_GET["apiCode"];
	$language=$_GET["language"];
	$seq=$_GET["seq"];
	$addcode=$_GET["code"];

	if($apicode!="goodsaddmaterial"){$json["resultMessage"]="API(apiCode) ERROR";$apicode="goodsaddmaterial";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="API(language) ERROR";}
	else if($seq==""){$json["resultMessage"]="API(seq) ERROR";}
	else if($addcode==""){$json["resultMessage"]="API(addcode) ERROR";}
	else
	{
		//넣을때 중복이 있는지 체크하고 update 해야함
		$sql=" select gd_type from ".$dbH."_goods where gd_code='".$addcode."' ";
		$dt=dbone($sql);

		if($dt["GD_TYPE"]=="material"){$baserate="1";}else{$baserate="0";}

		$sql=" select gd_bomcode from ".$dbH."_goods where gd_seq='".$seq."' ";
		$dt=dbone($sql);
		$gd_bomcode=$dt["GD_BOMCODE"];
		$chkcode=strpos($gd_bomcode,$addcode);

		if(!$chkcode)
		{
			$gd_bomcode=$gd_bomcode.",".$addcode."|".$baserate;
		}
		$sql=" update ".$dbH."_goods set gd_bomcode='".$gd_bomcode."', gd_modify=sysdate where gd_seq='".$seq."' ";
		dbcommit($sql);

		$returnData=$_GET["returnData"];
		$json=array("apiCode"=>$apicode,"returnData"=>$returnData,"seq"=>$seq);
		$json["sql"]=$sql;
		$json["resultCode"]="200";
		$json["resultMessage"]="OK";
	}
?>