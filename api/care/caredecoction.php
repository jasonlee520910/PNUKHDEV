<?php
	//GET
	$apicode=$_GET["apiCode"];
	$language=$_GET["language"];
	$uc_seq=$_GET["seq"];
	if($apicode!="caredecoction"){$json["resultMessage"]="API코드오류";$apicode="caredecoction";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="언어코드오류";}
	else if($uc_seq==""){$json["resultMessage"]="seq 없음";}
	else{
		$returnData=$_GET["returnData"];
		$json=array("apiCode"=>$apicode,"returnData"=>$returnData);

		$jsql=" a inner join ".$dbH."_decoction c on a.uc_odcode=c.dc_odcode ";
		$jsql.=" left join ".$dbH."_code z2 on c.dc_title=z2.cd_code and z2.cd_type='dcTitle' ";
		$jsql.=" left join ".$dbH."_code z21 on c.dc_special=z21.cd_code and z21.cd_type='dcSpecial' ";

		$wsql="  where a.uc_use <> 'D' and a.uc_seq='".$uc_seq."' ";
		$fsql=" z2.cd_name_".$language." dctitle, z21.cd_name_".$language." dcspecial ";
		$fsql.=", a.*,c.*, if(c.dc_sterilized='Y','살균','') dcSterilized, if(c.dc_cooling='Y','냉각','') dcCooling ";
		$sql=" select $fsql from ".$dbH."_usercare $jsql $wsql ";
//echo $sql;
		$dt=dbone($sql);
		$json=array(
			"seq"=>$dt["uc_seq"], "odCode"=>$dt["od_code"]
			, "dcTitle"=>$dt["dctitle"], "dcSpecial"=>$dt["dcspecial"], "dcTime"=>$dt["dc_time"], "dcTime"=>$dt["dc_time"], "dcTime"=>$dt["dc_time"], "dcWater"=>$dt["dc_water"], "dcSterilized"=>$dt["dcSterilized"], "dcCooling"=>$dt["dcCooling"]);

		$json["sql"]=$sql;
		$json["resultCode"]="200";
		$json["resultMessage"]="OK";
	}
?>
