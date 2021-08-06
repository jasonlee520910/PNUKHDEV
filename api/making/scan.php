<?php
	$apicode=$_GET["apiCode"];
	$language=$_GET["language"];
	$ma_table=$_GET["maTable"];

	if($apicode!="scan"){$json["resultMessage"]="API(apiCode) ERROR";$apicode="scan";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="API(language) ERROR";}
	else if($ma_table==""){$json["resultMessage"]="API(TableNo) ERROR";}
	else{
		//$sql=" select cf_making from ".$dbH."_config where cf_makingtable = '".$ma_table."' ";
		//$sql=" select cf_makingtable from ".$dbH."_config ";
		//20191030 : han_config 테이블에서 han_makingtable로 이동 
		$json=array("apiCode"=>$apicode,"returnData"=>$returnData);

		$sql=" select mt_makingtable from ".$dbH."_makingtable where mt_code = '".$ma_table."' ";
		$dt=dbone($sql);
		$mt_makingtable=$dt["MT_MAKINGTABLE"];

		$json["resultCode"]="200";
		$json["resultMessage"]="no";

		if($mt_makingtable == "scan") //scan으로 업데이트 
		{
			$json["resultMessage"]="scan";
			//$sql=" update ".$dbH."_config set cf_making='Y',  cf_makingtable = null ";
			//20191030 : han_config 테이블에서 han_makingtable로 이동 
			//20191105 : log.php로 이동 
			//$sql=" update ".$dbH."_makingtable set mt_making='Y',  mt_makingtable = null where mt_code = '".$ma_table."' ";
			//dbqry($sql);
		}
	}

?>