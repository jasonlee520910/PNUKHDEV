<?php  
	/// 재고관리 > 약재입고 > 상세보기 > 입고취소 버튼 사용시 체크
	$apicode=$_GET["apiCode"];
	$language=$_GET["language"];
	$wh_code=$_GET["code"];
	if($apicode!="checkoutstock"){$json["resultMessage"]="API(apiCode) ERROR";$apicode="checkoutstock";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="API(language) ERROR";}
	else if($wh_code==""){$json["resultMessage"]="API(code) ERROR";}
	else
	{
		$sql=" select count(wh_seq) as CNT from han_warehouse where wh_code='".$wh_code."' and wh_type='outgoing' and wh_status='outgoing' ";
		//select count(wh_seq) as CNT from han_warehouse where wh_code='STO20200413104200' and wh_type='outgoing' and wh_status='outgoing' 
		$dt=dbone($sql);
		
		if(intval($dt["CNT"])>0)
		{
			$json["cnt"]=$dt["CNT"];
			$json["CHKOUT"]="OUTCANCELFAIL";
		}	
		else
		{
			$json["CHKOUT"]="OUTCANCELOK";
		}

		$json["sql"]=$sql;
		$json["apiCode"]=$apicode;
		$json["returnData"]=$returnData;
		$json["resultCode"]="200";
		$json["resultMessage"]="OK";
	}
?>
