<?php  //묶음배송리스트(200103)
	$apiCode=$_GET["apiCode"];
	$language=$_GET["language"];
	if($apiCode!="deliverytied"){$json["resultMessage"]="API(apiCode) ERROR";$apiCode="deliverytied";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="API(language) ERROR";}
	else
	{
		
		//delicode 
		$delicode=$_GET["delicode"];
		$trName=$_GET["trName"];

		$sql=" select 
			 a.re_sendname, a.re_name, a.re_zipcode, a.re_address, a.re_delino 
			,b.od_seq, b.od_code, b.od_title, b.od_goods 
			,oc.orderCode cyodcode 
			from han_release a 
			inner join han_order b on a.re_odcode=b.od_code
			left join han_order_client oc on b.od_keycode=oc.keycode
			where a.re_delino ='".$delicode."' and a.re_deliexception like '%,T%'";

		$res=dbqry($sql);
		$json["sql"]=$sql;
		$json["list"]=array();
		while($dt=dbarr($res))
		{
			$arr=explode("||",$dt["RE_ADDRESS"]);

			//$od_chartpk=($dt["od_chartpk"]) ? $dt["od_chartpk"] : "";
			//if($dt["od_chartpk"]){$od_chartpk="<span style='padding:2px 5px;border-radius:2px;background:#CC66CC;color:#fff;'>OK ".$dt["od_chartpk"]."</span>";}else{$od_chartpk="";}
			//if($dt["cyodcode"]){$cyodcode="<span style='padding:2px 5px;border-radius:2px;background:#6699FF;color:#fff;'>BK ".($dt["cyodcode"]+10000)."</span>";}else{$cyodcode="";}
			//if($cyodcode){$od_chartpk=$cyodcode;}
			//if($dt["od_goods"]=="G"){$gGoods=" 사전";}else{$gGoods="";}
			//if(!$od_chartpk) {$od_chartpk="<span style='padding:2px 5px;border-radius:2px;background:#549E08;color:#fff;'>CY ".($dt["od_seq"]+50000)."".$gGoods."</span>";}

			$addarray=array(
				"odCode"=>$dt["OD_CODE"], //주문번호
				"odTitle"=>$od_chartpk." ".$dt["OD_TITLE"], //처방

				"reSendname"=>$dt["RE_SENDNAME"], //보내는사람
				"reName"=>$dt["RE_NAME"], //받는사람

				"reZipcode"=>$dt["RE_ZIPCODE"], //우편번호
				"reAddress"=>$arr[0]." ".$arr[1], //주소
				"deliCode"=>$dt["RE_DELINO"] //송장번호	
			);
			array_push($json["list"], $addarray);
		}

		$json["trName"]=$trName;
		$json["apiCode"] = $apiCode;
		$json["resultCode"]="200";
		$json["resultMessage"]="OK";
	}
?>
