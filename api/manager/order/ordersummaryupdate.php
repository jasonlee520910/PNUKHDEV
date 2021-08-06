<?php
	$apicode=$_POST["apiCode"];
	$language=$_POST["language"];
	if($apicode!="ordersummaryupdate"){$json["resultMessage"]="API(apiCode) ERROR2";$apicode="ordersummaryupdate";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="API(language) ERROR";}
	else
	{
		$returnData=$_POST["returnData"];
		$json=array("apiCode"=>$apicode,"returnData"=>$returnData);

		$od_keycode=$_POST["odKeycode"]; //주문키코드 

		$firstChk=$_POST["firstChk"]; //ordersummary에서 처음 데이터 부를때  

		//$dt["OD_GOODS"], $dt["MATYPENAME"], $dt["RC_SOURCE"]
		//약속제환이지 체크하기 위해서 
		$sql=" select a.od_goods, a.od_matype, b.rc_source from han_order a inner join han_recipeuser b on b.RC_CODE=a.OD_SCRIPTION where a.od_keycode='".$od_keycode."' ";
		$dt=dbone($sql);
		$od_goods=$dt["OD_GOODS"];
		$od_matype=$dt["OD_MATYPE"];
		$rc_source=$dt["RC_SOURCE"];

		
		$dc_sugar=$_POST["dcSugar"];//감미제 
		$dc_sugar=($dc_sugar)?$dc_sugar:"HD99999_01";
		
		$od_packtype=$_POST["odPackType"];//파우치 
		$re_boxmedi=$_POST["reBoxmedi"];//한약박스
		$re_boxdeli=$_POST["reBoxdeli"];//포장박스 

		$od_packprice=($_POST["odPackprice"])?$_POST["odPackprice"]:0;//파우치가격
		$re_boxmediprice=($_POST["reBoxmediprice"])?$_POST["reBoxmediprice"]:0;//한약박스가격
		$re_boxdeliprice=($_POST["reBoxdeliprice"])?$_POST["reBoxdeliprice"]:0;//배송포장재가격 





		
		$od_packcapa=$_POST["odPackcapa"];//팩용량 
		$dc_water=$_POST["dcWater"];//물량 
		$dc_alcohol=$_POST["dcAlcohol"];//물량 
		$od_packcnt=$_POST["odPackcnt"];//팩수 


		//주문금액 json data
		$od_amountdjmedi=$_POST["odAmountdjmedi"];	
		$od_amount=$_POST["odAmount"];//토탈금액 

		//별전
		$rc_sweet=$_POST["rcSweet"];//별전  
		$rc_code=$_POST["rcCode"];//별전  


		if($od_matype=="goods"&&$od_goods=="Y"&&!$rc_source)//약속제환인지체크 ==> 우체국때문에 배송박스를 선택함 부피,무게를 업데이트 하기 위해서 
		{
			$bm=getBoxDeliinfo($od_keycode, $re_boxdeli, $pb_volume, $pb_maxcnt);
		}
		else
		{
			$bm=getBoxMediinfo($od_keycode, $re_boxmedi, $pb_volume, $pb_maxcnt);
		}
		
		$json["pb_medichk"]=$bm["pb_medichk"];
		$json["pb_code"]=$bm["pb_code"];
		$json["pb_title"]=$bm["pb_title"];
		$json["pb_volume"]=$bm["pb_volume"];
		$json["pb_maxcnt"]=$bm["pb_maxcnt"];

		$pb_volume=$bm["pb_volume"];
		$pb_maxcnt=$bm["pb_maxcnt"];


		
		$json["파우치"]=$od_packtype;
		$json["한약박스"]=$re_boxmedi;
		$json["포장박스"]=$re_boxdeli;

		$json["파우치가격"]=$od_packprice;
		$json["한약박스가격"]=$re_boxmediprice;
		$json["포장박스가격"]=$re_boxdeliprice;




		//주문정보업데이트
		$sql=" update ".$dbH."_order ";
		$sql.=" set od_packprice='".$od_packprice."', od_packtype='".$od_packtype."',od_packcnt='".$od_packcnt."',od_packcapa='".$od_packcapa."', od_amount='".$od_amount."', od_amountdjmedi='".$od_amountdjmedi."', od_modify=sysdate where od_keycode='".$od_keycode."' ";
		dbcommit($sql);
		$json["주문sql"]=$sql;

		//탕전정보업데이트
		$sql=" update ".$dbH."_decoction ";
		$sql.=" set dc_water='".$dc_water."', dc_alcohol='".$dc_alcohol."', dc_modify=sysdate where dc_keycode='".$od_keycode."' ";
		dbcommit($sql);
		$json["탕전sql"]=$sql;

		//출고정보업데이트
		$sql=" update ".$dbH."_release ";
		$sql.=" set re_boxdeliprice='".$re_boxdeliprice."',re_boxmediprice='".$re_boxmediprice."', re_boxmedi='".$re_boxmedi."', re_boxmedivol='".$pb_volume."', re_boxmedipack='".$pb_maxcnt."', re_boxmedibox='".$pb_maxcnt."', re_boxdeli='".$re_boxdeli."' where re_keycode='".$od_keycode."' ";
		dbcommit($sql);
		$json["출고sql"]=$sql;
		if($rc_code)
		{
			//처방정보업데이트
			$sql=" update ".$dbH."_recipeuser set rc_sweet='".$rc_sweet."', rc_modify=sysdate where rc_code='".$rc_code."' ";
			dbcommit($sql);
		}


		$json["firstChk"]=$firstChk;
		$json["sql"]=$sql;
		$json["resultCode"]="200";
		$json["resultMessage"]="OK";
	}
?>
