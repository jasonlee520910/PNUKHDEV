<?php
	$apiCode=$_GET["apiCode"];
	$language=$_GET["language"];
	$odCode=$_GET["odCode"];

	if($apiCode!="makingscan"){$json["resultMessage"]="API(apiCode) ERROR";$apiCode="makingscan";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="API(language) ERROR";}
	else if($odCode==""){$json["resultMessage"]="API(odCode) ERROR";}
	else
	{	
		$json["apiCode"] = $apiCode;

		//-------------------------------------------------------------------------------------
		// 해당하는 주문코드의 ma_tablestat 이 finish 인지 체크하자 
		//-------------------------------------------------------------------------------------
		$sql=" select ma_table, ma_tablestat from ".$dbH."_making ";
		$sql.=" where ma_odcode='".$odCode."' ";
		$dt=dbone($sql);
		//-------------------------------------------------------------------------------------

		$json["sql"]=$sql;
		$ma_table=$dt["MA_TABLE"];
		$json["ma_tablestat"]=$dt["MA_TABLESTAT"];

		//20190415 hold 추가 (chktable 할때 기계를 껐을 경우 hold가 된다. 그럴때 리스트로 가기위해 )
		if($dt["MA_TABLESTAT"] == "finish" || $dt["MA_TABLESTAT"] == "hold") 
		{
			//han_config cf_making을  scan으로 바꾸자  조제작업금지 = N, 테이블 스캔시작 = scan
			//$sql=" update ".$dbH."_config set cf_making='N',  cf_makingtable='scan' ";//config에서 cf_makingtable
			//20191030 : han_config 테이블에서 han_makingtable로 이동 
			$sql=" update ".$dbH."_makingtable set mt_making='N',  mt_makingtable='scan' where mt_code = '".$ma_table."' ";//config에서 cf_makingtable
			dbcommit($sql);
			
			$json["resultCode"]="200";
			$json["resultMessage"]="OK";
		}
		else if($dt["MA_TABLESTAT"] == "cancel") 
		{
			$json["resultCode"]="200";
			$json["resultMessage"]="OK";
		}
		else
		{
			$json["resultCode"]="888";
			$json["resultMessage"]="MEDIBOXCLEAR";//먼저 약재함을 선택해제해 주세요.
		}

	}
?>