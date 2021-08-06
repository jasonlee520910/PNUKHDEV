<?php
	$apiCode=$_GET["apiCode"];
	$language=$_GET["language"];
	$code=$_GET["code"];
	if($apiCode!="releasemain"){$json["resultMessage"]="API(apiCode) ERROR";$apiCode="releasemain";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="API(language) ERROR";}
	else
	{
		//$code="RED2021030514295300001";

		$jsql=" a  inner join ".$dbH."_order b on a.re_odcode=b.od_code ";
		$jsql.=" inner join ".$dbH."_medical m on a.re_userid=m.mi_userid ";
		$jsql.=" left join ".$dbH."_packingbox c1 on b.od_packtype=c1.pb_code";
		$jsql.=" left join ".$dbH."_packingbox c2 on a.re_boxmedi=c2.pb_code";
		$jsql.=" left join ".$dbH."_packingbox c3 on a.re_boxdeli=c3.pb_code";
		$jsql.=" left join han_code c4 on a.re_delitype=c4.cd_code and c4.cd_type='reDelitype'  ";	
		$jsql.=" left join ".$dbH."_order_client oc on b.od_keycode=oc.keycode ";

		//,  f2.af_url AFBOXMEDI, f3.af_url AFPACKTYPE
		$wsql=" where a.re_barcode='".$code."' ";
		$sql=" select ";
		$sql.=" a.RE_BOXMEDI, a.RE_DELITYPE, a.RE_PRECIPITATE, a.RE_LEAK, a.RE_NAME, a.RE_ZIPCODE, a.RE_ADDRESS, a.RE_PHONE, a.RE_MOBILE ";
		$sql.=" , a.RE_DELICOMP, a.RE_DELIEXCEPTION, a.RE_BOXMEDICNT  ";
		$sql.=" ,a.RE_REQUEST as REREQUEST  ";
		$sql.=" ,m.MI_NAME, m.MI_ZIPCODE, m.MI_ADDRESS, m.MI_PHONE ";
		$sql.=" ,b.OD_PACKTYPE, b.OD_TITLE, b.OD_PACKCNT, b.OD_PACKCAPA, b.OD_GOODS, b.OD_NAME ";
		$sql.=" , b.OD_REQUEST as ODREQUEST  ";
		$sql.=" , b.OD_ADVICE as ODADVICE  ";
		$sql.=" ,(select MIN(af_url) KEEP (DENSE_RANK FIRST ORDER BY af_no DESC) from han_file where af_fcode=b.od_packtype and af_code='packingbox' and af_use='Y') as AFPACKTYPE ";
		$sql.=" ,(select MIN(af_url) KEEP (DENSE_RANK FIRST ORDER BY af_no DESC) from han_file where af_fcode=a.re_boxmedi and af_code='packingbox' and af_use='Y') as AFBOXMEDI ";
		$sql.=", c4.cd_name_".$language." DELITYPENAME ";
		$sql.=", c1.pb_code pouchcode, c1.pb_title pouchtit";
		$sql.=", c2.pb_code boxmedi, c2.pb_title boxmeditit";
		$sql.=", c3.pb_code boxdeli, c3.pb_title boxdelitit ";
		$sql.=", oc.PATIENTCODE, oc.PATIENTGENDER, oc.PATIENTBIRTH, to_char(oc.ORDERDATE, 'yyyy-mm-dd') as clientorderdate, oc.WARDNO, oc.ROOMNO, oc.BEDNO, oc.MEDIDAYS, oc.MEDITYPE, oc.MEDICAPA, oc.MEDINAME, oc.MEDIADVICE ";
		//$sql.=", cy.packageInfo cypackageInfo ";
		$sql.=" from ".$dbH."_release $jsql where a.re_barcode='".$code."' ";

		$dt=dbone($sql);

		$afBoxmedi=getafFile($dt["AFBOXMEDI"]);
		$afPacktype=getafFile($dt["AFPACKTYPE"]);

		$re_boxmedicnt=($dt["RE_BOXMEDICNT"]) ? $dt["RE_BOXMEDICNT"] : "0";

		$diagnosisType=($dt["PATIENTCODE"])?"B":"A";//A는 일반, B는 입원/외래 라벨프린트 하기 위함 

		$json=array(
			"od_packtype"=>$dt["OD_PACKTYPE"],
			"re_boxmedi"=>$dt["RE_BOXMEDI"],
			"re_delitype"=>$dt["RE_DELITYPE"],
			"re_delitypename"=>$dt["DELITYPENAME"],	//배송방법 text			
			"re_precipitate"=>$dt["RE_PRECIPITATE"],
			"re_leak"=>$dt["RE_LEAK"],
			"icon_re_precipitate"=>chkrelease($dt["RE_PRECIPITATE"]),
			"icon_re_leak"=>chkrelease($dt["RE_LEAK"]),
			"re_name"=>$dt["RE_NAME"],
			"re_zipcode"=>$dt["RE_ZIPCODE"],
			"re_address"=>str_replace("||"," ",$dt["RE_ADDRESS"]),
			"re_phone"=>($dt["RE_PHONE"])?$dt["RE_PHONE"]:"",
			"re_mobile"=>$dt["RE_MOBILE"],
			"re_request"=>getClob($dt["REREQUEST"]),

			"re_delicomp"=>$dt["RE_DELICOMP"],
			"re_deliexception"=>$dt["RE_DELIEXCEPTION"],
			"re_boxmedicnt"=>$re_boxmedicnt,//20191106 : 배송예외('O=oversea','T=tied', D=direct)

	
			"mi_name"=>$dt["MI_NAME"],
			"mi_zipcode"=>$dt["MI_ZIPCODE"],
			"mi_address"=>str_replace("||"," ",$dt["MI_ADDRESS"]),
			"mi_phone"=>$dt["MI_PHONE"],
			
			"diagnosisType"=>$diagnosisType,

			"od_title"=>$dt["OD_TITLE"],
			"od_packcnt"=>$dt["OD_PACKCNT"],
			"od_packcapa"=>$dt["OD_PACKCAPA"],
			"od_goods"=>$dt["OD_GOODS"],
			"od_name"=>$dt["OD_NAME"],//환자명 
			"od_request"=>getClob($dt["ODREQUEST"]),			
			"od_advice"=>getClob($dt["ODADVICE"]),					

			"pouchcode"=>$dt["POUCHCODE"],  //파우치
			"pouchtit"=>$dt["POUCHTIT"],  //파우치
			"boxmedi"=>$dt["BOXMEDI"], //하늘담아
			"boxmeditit"=>$dt["BOXMEDITIT"], 
			//"boxdeli"=>$dt["boxdeli"], //핑크한약박스
			"boxdelitit"=>$dt["BOXDELITIT"],				
			
			"afBoxmedi"=>$afBoxmedi,
			"afPacktype"=>$afPacktype
			);


		$json["apiCode"] = $apiCode;
		$json["sql"] = $sql;
		$json["resultCode"]="200";
		$json["resultMessage"]="OK";

	}

function chkrelease($data)
{
	if($data > 0){
		$txt="icon_ok";
	}else{
		$txt="icon_no";
	}
	return $txt;
}
?>