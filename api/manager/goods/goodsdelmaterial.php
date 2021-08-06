<?php  
	/// 제품재고관리 > 제품목록 > 구성요소 팝업에서 제품구성목록 삭제버튼

	$apicode=$_GET["apiCode"];
	$language=$_GET["language"];
	$seq=$_GET["seq"];
	$delcode=$_GET["code"];

	if($apicode!="goodsdelmaterial"){$json["resultMessage"]="API(apiCode) ERROR";$apicode="goodsdelmaterial";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="API(language) ERROR";}
	else if($seq==""){$json["resultMessage"]="API(seq) ERROR";}
	else if($delcode==""){$json["resultMessage"]="API(delcode) ERROR";}
	else
	{
		$sql=" select gd_bomcode from ".$dbH."_goods where gd_seq='".$seq."' ";
		$dt=dbone($sql);

		$gdbomcode="";
		$gd_bomcode=$dt["GD_BOMCODE"];
		$boarr=explode(",",$gd_bomcode);
		foreach($boarr as $val){
			$boarr2=explode("|",$val);
			if($boarr2[0]!="" && $boarr2[0]!="|" && $boarr2[0]!=$delcode ){
				$gdbomcode.=",".$boarr2[0]."|".$boarr2[1];
			}
		}

		$sql=" update ".$dbH."_goods set gd_bomcode='".$gdbomcode."', gd_modify=sysdate where gd_seq='".$seq."' ";
		dbcommit($sql);

		$returnData=$_GET["returnData"];
		$json=array("apiCode"=>$apicode,"returnData"=>$returnData,"seq"=>$seq);
		$json["sql"]=$sql;
		$json["resultCode"]="200";
		$json["resultMessage"]="OK";
	}
?>