<?php
	$apicode=$_GET["apiCode"];
	$language=$_GET["language"];
	$od_seq=$_GET["seq"];
	if($apicode!="goodsconfirmpill"){$json["resultMessage"]="API(apiCode) ERROR";$apicode="goodsconfirmpill";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="API(language) ERROR";}
	else if($od_seq==""){$json["resultMessage"]="API(seq) ERROR";}
	else{

		$returnData=$_GET["returnData"];
		$odGoods=$_GET["odGoods"];//사전조제
		

		$json=array("apiCode"=>$apicode,"seq"=>$od_seq,"returnData"=>$returnData);

		$sql=" select PL_KEYCODE, PL_DCWATER, to_char(PL_DATE, 'yyyy-mm-dd') as plDate ";
		$sql.=" from ".$dbH."_pill ";
		$sql.=" where PL_KEYCODE = (select od_keycode from ".$dbH."_order where od_seq='".$od_seq."') ";
		$dt=dbone($sql);
		$json["sql0"]=$sql;
		$plDate=$dt["PLDATE"];
		$plDcwater=($dt["PL_DCWATER"])?$dt["PL_DCWATER"]:0;
		$odKeycode=$dt["PL_KEYCODE"];


		$sql=" select MAX(od_no+1) as addno from han_order where to_char(od_date,'yyyy-mm-dd') = '".$plDate."' order by od_no desc ";
		$dt=dbone($sql);
		$json["sql1"]=$sql;
		if($dt["ADDNO"]>0)
		{
			$odNo=intval($dt["ADDNO"]);
		}
		else
		{
			$odNo=1;
		}
		$json["sql00_odNo"]=$odNo;
		//날짜 + seq + 물량 + 침포시간  작업시작시 처리 시작전에는 키코드사용
		//코드변경  날짜 =>  180702 + 00000 + 0000 + 0
		$odNo=sprintf("%05d",$odNo);
		$tmp=intval($plDcwater/10);
		if(strlen($tmp)<=4)
		{
			$water=sprintf("%04d",intval($plDcwater/10));//물량은 꼭 숫자로 바꾸기 
		}
		else
		{
			$water=substr($tmp,0,4);//물량은 꼭 숫자로 바꾸기 
		}
		//ODD 200106 00094 2948 3
		//ODD 200106 00095 0872 3
		//ODD 200106 00096 0499 3
		//ODD 200106 00097 1471 3
		$melting=3;
		$newdate=date("ymd", strtotime($plDate));
		$odcode=$newdate.$odNo.$water.$melting;

		$sql=" update ".$dbH."_order set od_code='ODD".$odcode."', od_no='".$odNo."' where od_keycode='".$odKeycode."' ";
		$json["sql1"].=$sql;
		dbcommit($sql);
		$sql=" update ".$dbH."_making set ma_odcode='ODD".$odcode."',  ma_barcode='MKD".$odcode."' where ma_keycode='".$odKeycode."' ";
		$json["sql2"].=$sql;
		dbcommit($sql);
		$sql=" update ".$dbH."_decoction set dc_odcode='ODD".$odcode."',  dc_barcode='DED".$odcode."' where dc_keycode='".$odKeycode."' ";
		$json["sql3"].=$sql;
		dbcommit($sql);
		$sql=" update ".$dbH."_marking set mr_odcode='ODD".$odcode."',  mr_barcode='MRK".$odcode."' where mr_keycode='".$odKeycode."' ";
		$json["sql4"].=$sql;
		dbcommit($sql);
		$sql=" update ".$dbH."_release set re_odcode='ODD".$odcode."', re_barcode='RED".$odcode."' where re_keycode='".$odKeycode."' ";
		$json["sql5"].=$sql;
		dbcommit($sql);
		$sql=" update ".$dbH."_pill set PL_ODCODE='ODD".$odcode."', PL_BARCODE='PIL".$odcode."' where PL_KEYCODE='".$odKeycode."' ";
		$json["sql6"].=$sql;
		dbcommit($sql);

		$json["odCode"]='ODD'.$odcode;
		$json["resultCode"]="200";
		$json["resultMessage"]="OK";
	
	}
?>
