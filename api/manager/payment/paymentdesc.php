<?php
	//GET
	$apicode=$_GET["apiCode"];
	$language=$_GET["language"];
	$odCode=$_GET["odCode"];

	if($apicode!="paymentdesc"){$json["resultMessage"]="API(apiCode) ERROR";$apicode="paymentdesc";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="API(language) ERROR";}
	else if($odCode==""){$json["resultMessage"]="API(seq) ERROR";}
	else
	{
		$returnData=$_GET["returnData"];

		$jsql=" a inner join ".$dbH."_medical m on a.od_userid=m.mi_userid ";
		$jsql.=" inner join ".$dbH."_release e on a.od_code=e.re_odcode ";
		$jsql.=" left join ".$dbH."_packingbox z on a.od_packtype=z.pb_code ";
		
		$ssql="a.OD_SEQ, a.OD_CODE,a.OD_USERID,a.OD_TITLE,a.OD_PACKCNT,a.OD_AMOUNT,a.OD_PAYTYPE,a.OD_PAYCHECK,a.OD_PAYAMOUNT,a.OD_DATE,a.OD_STATUS ";
		$ssql.=" , e.RE_NAME, e.RE_ADDRESS, m.mi_name ,z.pb_title PACKTYPE ";

		$wsql=" where a.od_code = '".$odCode."' ";
		$sql=" select ".$ssql." from ".$dbH."_order $jsql $wsql ";
		$dt=dbone($sql);

		$txtdt = getpaymenttxtdt("'1268','1269','1243','1190'");
		//주문상태
		$carr=array("order","paid");
		$tarr=array("1269","1268");
		$odStatusList = array();
		for($i=0;$i<count($carr);$i++)
		{
			$addarray = array(
				"cdCode"=>$carr[$i], 
				"cdName"=>$txtdt[$tarr[$i]],
				"cdValue"=>""
			);
			$odStatusList[$carr[$i]] = $addarray;
		}
		
		//결재방법
		$carr=array("pmbank","pmcredit");
		$tarr=array("1243","1190");
		$odPaytypeList = array();
		for($i=0;$i<count($carr);$i++)
		{
			$addarray = array(
				"cdCode"=>$carr[$i], 
				"cdName"=>$txtdt[$tarr[$i]],
				"cdValue"=>""
			);
			$odPaytypeList[$carr[$i]] = $addarray;
		}

		$json=array(
			"seq"=>$dt["OD_SEQ"], 
			"odCode"=>$dt["OD_CODE"], 
			"odUserid"=>$dt["OD_USERID"],
			"miName"=>$dt["MI_NAME"],
			"odTitle"=>$dt["OD_TITLE"], 
			"odPackcnt"=>$dt["OD_PACKCNT"], 
			"odPacktype"=>$dt["PACKTYPE"], 
			"odAmount"=>$dt["OD_AMOUNT"], 
			"odPaytype"=>$dt["OD_PAYTYPE"], 
			"odPaycheck"=>$dt["OD_PAYCHECK"], 
			"odPayamount"=>$dt["OD_PAYAMOUNT"], 
			"odDate"=>$dt["OD_DATE"], 
			"odStatus"=>$dt["OD_STATUS"],
			"reName"=>$dt["RE_NAME"], 
			"reAddress"=>str_replace("||"," ",$dt["RE_ADDRESS"]),
			"odStatusList"=>$odStatusList,
			"odPaytypeList"=>$odPaytypeList
		);

		$json["sql"]=$sql;
		$json["txtdt"]=$txtdt;

		$json["apiCode"]=$apicode;
		$json["returnData"]=$returnData;
		$json["resultCode"]="200";
		$json["resultMessage"]="OK";
	}
	//=========================================================================
	//  함수 명     : getpaymenttxtdt()
	//  함수 설명   : 언어별로 필요한 텍스트 가져오기 
	//=========================================================================
	function getpaymenttxtdt($txt)
	{
		global $language;
		global $dbH;
		$sql=" select td_code, td_name_".$language." td_name from ".$dbH."_txtdata where td_use = 'Y' and td_code in (".$txt.") ";

		$res=dbqry($sql);
		$list = array();
		while($dt=dbarr($res))
		{
			$list[$dt["TD_CODE"]]=$dt["TD_NAME"];
		}
		return $list;
	}
?>
