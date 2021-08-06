<?php
	$apicode=$_GET["apiCode"];
	$language=$_GET["language"];
	$seq=$_GET["seq"];
	$gd_code=$_GET["gdCode"]; //ETSJHW
	$gd_rate=$_GET["gdRate"];  //용량

	if($apicode!="goodsaddcapa"){$json["resultMessage"]="API(apiCode) ERROR";$apicode="goodsaddcapa";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="API(language) ERROR";}
	else if($seq==""){$json["resultMessage"]="API(seq) ERROR";}
	else if($gd_code==""){$json["resultMessage"]="API(gdCode) ERROR";}
	else if($gd_rate==""){$json["resultMessage"]="API(gdRate) ERROR";}
	else
	{
		$sql=" select gd_bomcode from ".$dbH."_goods where gd_seq='".$seq."' ";
		$dt=dbone($sql);
		$gdbomcode="";
		$gd_bomcode=$dt["gd_bomcode"];
		$boarr=explode(",",$gd_bomcode);
		foreach($boarr as $val){
			$boarr2=explode("|",$val);
			if($val!="" && $val!="|"){
				//코드가 같을때 용량 업데이트
				if($boarr2[0]==$gd_code){
					$gdbomcode.=",".$boarr2[0]."|".$gd_rate;
				}else{
					$gdbomcode.=",".$boarr2[0]."|".$boarr2[1];
				}
			}
		}

		$sql=" update ".$dbH."_goods set gd_bomcode='".$gdbomcode."', gd_modify=now() where gd_seq='".$seq."' ";
		dbqry($sql);

		$returnData=$_GET["returnData"];
		$json=array("apiCode"=>$apicode,"returnData"=>$returnData,"seq"=>$seq);
		$json["sql"]=$sql;
		$json["resultCode"]="200";
		$json["resultMessage"]="OK";
	}
?>