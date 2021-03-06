<?php
	///GET
	$apicode=$_GET["apiCode"];
	$language=$_GET["language"];
	$od_code=$_GET["odCode"];
	if($apicode!="orderprint"){$json["resultMessage"]="API(apiCode) ERROR";$apicode="orderprint";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="API(language) ERROR";}
	else if($od_code==""){$json["resultMessage"]="API(od_code) ERROR";}
	else{
		$returnData=$_GET["returnData"];
	
		$sql=" select   ";
		$sql.=" a.od_seq, a.od_code,a.od_name odName,a.od_title odTitle, a.od_chubcnt odChubCnt, a.od_packcnt odPackCnt ";
		$sql.=" , a.od_packcapa odPackCapa, a.od_matype, a.od_feature, a.od_goods, a.od_qty,a.od_packtype ";
		$sql.=" , to_char(a.OD_DATE, 'yyyy-mm-dd hh24:mi:ss') as ODDATE ";
		$sql.=" , to_char(a.OD_BIRTH, 'yyyy-mm-dd') as ODBIRTH ";
		$sql.=" , a.od_request as odRequest ";
		$sql.=" , a.od_advice as odAdvice ";
		$sql.=" , b.ma_barcode mabarcode  ";
		$sql.=" , d.dc_water dcWater, d.dc_time dcTime , d.dc_millingloss, d.dc_lossjewan, d.dc_bindersliang, d.dc_completeliang, d.dc_completecnt, d.dc_dry, d.dc_ripen, d.dc_jungtang, d.DC_ALCOHOL, d.DC_SUGAR ";
		$sql.=" , mr.mr_desc ";
		$sql.=" , e.re_name,  e.re_zipcode , e.re_address, e.re_phone, e.re_mobile, e.re_delicomp, e.re_deliexception  , to_char(e.re_delidate, 'yyyy-mm-dd') as reDelidate  ";
		$sql.=" , e.re_name reUserName , e.re_sendtype, e.re_sendname, e.re_sendphone, e.re_sendmobile, e.re_sendzipcode, e.re_sendaddress,e.re_boxmedi,e.re_boxdeli ";
		$sql.=" , e.re_request as reRequest ";
		$sql.=" , r.rc_medicine as rcMedicine ";
		$sql.=" , r.rc_sweet as rcSweet ";
		$sql.=" , r.rc_source ";
		$sql.=" , m.mi_name ";
		$sql.=" , m1.cd_name_".$language." odMrDesc ";
		$sql.=" , m1.cd_value_".$language." as markingtxt ";
		$sql.=" , z1.cd_name_".$language." odMeditype ";
		$sql.=" , z2.cd_name_".$language." reDelitype  ";
		$sql.=" , t.cd_name_".$language." as maTypeName ";
		$sql.=" , d1.cd_name_".$language." dcTitle  ";
		$sql.=" , d2.cd_name_".$language." dcSpecial  ";
		$sql.=" , d2.cd_value_".$language." dcSpecialName  ";
		$sql.=" , t2.cd_name_".$language." as dcShapeName ";
		$sql.=" , t3.cd_name_".$language." as dcBindersName ";
		$sql.=" , t4.cd_name_".$language." as dcFinenessName  ";
		$sql.=" , t5.cd_name_".$language." as dcRipenName  ";
		$sql.=" , t6.cd_name_".$language." as dcJungtangName  ";
		$sql.=" , t7.cd_name_".$language." as odGenderName  ";
		$sql.=" , t8.cd_name_".$language." as odFeatureName ";
		$sql.=" , oc.orderCode cyodcode, oc.totalMedicine, oc.packageInfo, oc.markText, oc.orderCount ";
		$sql.=" , (select MIN(af_url) KEEP (DENSE_RANK FIRST ORDER BY af_no DESC) from han_file where af_fcode=a.od_packtype and af_code='packingbox' and af_use='Y') as packimg ";
		$sql.=" , (select MIN(af_url) KEEP (DENSE_RANK FIRST ORDER BY af_no DESC) from han_file where af_fcode=e.re_boxdeli and af_code='packingbox' and af_use='Y') as boxdeliimg ";
		$sql.=" , (select MIN(af_url) KEEP (DENSE_RANK FIRST ORDER BY af_no DESC) from han_file where af_fcode=e.re_boxmedi and af_code='packingbox' and af_use='Y') as boxmediimg ";
		$sql.=" , (select pb_title from han_packingbox where pb_code=a.od_packtype and pb_type='odPacktype') as odpackName  ";
		$sql.=" , (select pb_title from han_packingbox where pb_code=e.re_boxmedi and pb_type='reBoxmedi') as reboxmediName  ";
		$sql.=" , (select pb_title from han_packingbox where pb_code=e.re_boxdeli and pb_type='reBoxdeli') as reboxdeliName ";
		$sql.=" from han_order   ";
		$sql.=" a inner join ".$dbH."_making b on a.od_code=b.ma_odcode  ";
		$sql.=" inner join ".$dbH."_decoction d on a.od_code=d.dc_odcode  ";
		$sql.=" inner join ".$dbH."_marking mr on mr.mr_odcode=a.od_code   ";
		$sql.=" inner join ".$dbH."_release e on a.od_code=e.re_odcode   ";
		$sql.=" inner join ".$dbH."_medical m on a.od_userid=m.mi_userid ";
		$sql.=" left join ".$dbH."_recipeuser r on a.od_scription=r.rc_code   ";
		$sql.=" left join ".$dbH."_code m1 on mr.mr_desc=m1.cd_code and m1.cd_type='mrDesc'   ";
		$sql.=" left join ".$dbH."_code z1 on a.od_meditype=z1.cd_code and z1.cd_type='odMeditype' ";
		$sql.=" left join ".$dbH."_code z2 on e.re_delitype=z2.cd_code and z2.cd_type='reDelitype'   ";
		$sql.=" left join ".$dbH."_code t on t.cd_type='maType' and a.od_matype=t.cd_code  ";
		$sql.=" left join ".$dbH."_code d1 on d.dc_title=d1.cd_code and d1.cd_type='dcTitle'   ";
		$sql.=" left join ".$dbH."_code d2 on d.dc_special=d2.cd_code and d2.cd_type='dcSpecial'   ";
		$sql.=" left join ".$dbH."_code t2 on t2.cd_type='dcShape' and d.dc_shape=t2.cd_code   ";
		$sql.=" left join ".$dbH."_code t3 on t3.cd_type='dcBinders' and d.dc_binders=t3.cd_code   ";
		$sql.=" left join ".$dbH."_code t4 on t4.cd_type='dcFineness' and d.dc_fineness=t4.cd_code   ";
		$sql.=" left join ".$dbH."_code t5 on t5.cd_type='dcRipen' and d.dc_ripen=t5.cd_code   ";
		$sql.=" left join ".$dbH."_code t6 on t6.cd_type='dcJungtang' and d.dc_jungtang=t6.cd_code   ";
		$sql.=" left join ".$dbH."_code t7 on t7.cd_type='meSex' and a.od_gender=t7.cd_code   ";
		$sql.=" left join ".$dbH."_code t8 on t8.cd_type='mhFeature' and a.od_feature=t8.cd_code    ";
		$sql.=" left join ".$dbH."_order_client oc on a.od_keycode=oc.keycode     ";
		$sql.=" where a.od_use in ('Y','C') and a.od_code='".$od_code."' ";


		$dt=dbone($sql);
		
		///------------------------------------------------------------
		/// DOO :: ???????????? ????????? ?????? 
		///------------------------------------------------------------
		$rcMedicine = getClob($dt["RCMEDICINE"]);
		$rcMedicine = str_replace(" ", "", $rcMedicine);
		$rcSweet = getClob($dt["RCSWEET"]);
		$rcSweet = str_replace(" ", "", $rcSweet);
		///------------------------------------------------------------

		$sendaddr=explode("||", $dt["RE_SENDADDRESS"]);

		$rc_source=$dt["RC_SOURCE"];

		if($dt["CYODCODE"]){$od_chartpk="<span style='padding:2px 5px;border-radius:2px;background:#6699FF;color:#fff;'>BK ".($dt["CYODCODE"]+10000)."</span>";}else{$cyodcode="";}
		if($dt["OD_GOODS"]=="G") {$od_chartpk="<span style='padding:2px 5px;border-radius:2px;background:#FF0000;color:#fff;'>??????</span>";}

		//????????? 
		//HD017603KR0004J,??????5bx,5,270,32
		if($dt["DC_SUGAR"])
		{
			$sugaraddr=explode(",", $dt["DC_SUGAR"]);
			$txt_sugar=$sugaraddr[1]." ".$sugaraddr[3];
		}
		

		///20191014 : ?????? ?????? ???????????? ?????? 
		$txt_marking=getClob($dt["MARKINGTXT"]);
		if($txt_marking)
		{
			$markingtxt=$txt_marking;
			$markingtxt=str_replace("[od_code]",$dt["OD_CODE"],$markingtxt);///????????????
			$markingtxt=str_replace("[re_name]",$dt["ODNAME"],$markingtxt);///????????? 
			$markingtxt=str_replace("[mi_name]",$dt["MI_NAME"],$markingtxt);///????????? 
			$markingtxt=str_replace("[patientcode]",$dt["OD_NAME"],$markingtxt);///??????????????? 
			$markingtxt=str_replace("<br/>"," + ",$markingtxt);///????????????  + ??? ??????  
		}
		else
		{
			$markingtxt="<p>No Marking</p>";
		}

		///20191104 : ???????????? ?????????
		$re_deliexception=$dt["RE_DELIEXCEPTION"];
		$reDelicomp=$reDelicompO=$reDelicompT="";
		$reDelicomp=getDeliveryCompName($re_deliexception, $dt["RE_DELICOMP"]);

		if(strpos($re_deliexception, "O") !== false)
		{
			$reDelicompO="??????";
		}
		if(strpos($re_deliexception, "T") !== false)
		{
			$reDelicompT="??????";
		}
		
		///goods ///??????
		$maTypeName=getMatypeName($dt["OD_GOODS"], $dt["MATYPENAME"], $dt["RC_SOURCE"]);
		
		///cy ???????????? (????????????)
		if($dt["ORDERCOUNT"])
		{
			$orderCount=$dt["ORDERCOUNT"];
		}
		else
		{
			if($dt["OD_QTY"])
			{
				$orderCount=$dt["OD_QTY"];
			}
			else
			{
				$orderCount=1;
			}
		}

		$dcSpecialName=getClob($dt["dcSpecialName"]);
		$dcSpecialName=($dcSpecialName)?$dcSpecialName:"??????";

		$json=array(
			"odAdvice"=>getClob($dt["odAdvice"]),///???????????????

			"odCode"=>$dt["OD_CODE"],///???????????? 
			"odName"=>($dt["ODNAME"])?$dt["ODNAME"]:"",///?????????
			"odTitle"=>$dt["ODTITLE"],///?????????_PACKNAME_?????????
			"odChubCnt"=>$dt["ODCHUBCNT"],///??????_CHUBCNT_??????
			"odPackCnt"=>$dt["ODPACKCNT"],///??????_PACKCNT_??????
			"odPackCapa"=>$dt["ODPACKCAPA"],///?????????_PACKCC_?????????
			"odMeditype"=>$dt["ODMEDITYPE"], ///????????????
			"odGoods"=>$dt["OD_GOODS"],
			"odDate"=>$dt["ODDATE"], ///order od_modify ?????? 
			"orderCount"=>$orderCount,

			"odRequest"=>getClob($dt["ODREQUEST"]), ///????????????????????? 

			"odChartPK"=>$od_chartpk, ///20191011 od_chartpk
			"odpackName"=>$dt["ODPACKNAME"],///20191011 ???????????????
			"reboxmediName"=>$dt["REBOXMEDINAME"],///20191011 ??????????????????
			"reboxdeliName"=>$dt["REBOXDELINAME"],///20191011 ??????????????????

			///20190823 :: ??????,????????????, ?????? ?????? 
			"odGenderName"=>$dt["ODGENDERNAME"], ///?????? 
			"odBirth"=>$dt["ODBIRTH"], ///???????????? 
			"odFeatureName"=>$dt["ODFEATURENAME"], ///?????? 
			"odFeature"=>$dt["OD_FEATURE"],

			
			"cymarkText"=>$dt["MARKTEXT"],
			"sugartxt"=>$txt_sugar,//????????? 

			
			"reDelidate"=>$dt["REDELIDATE"], ///???????????????_PRESETDATE_???????????????
			"reDelitype"=>$dt["REDELITYPE"], ///????????????_PRESETTIME_????????????

			"dcTitle"=>$dt["DCTITLE"], ///?????????
			"dcSpecial"=>$dt["DCSPECIAL"], ///???????????? 
			"dcWater"=>$dt["DCWATER"], ///??????
			"dcAlcohol"=>$dt["DC_ALCOHOL"],
			"dcTime"=>$dt["DCTIME"], ///????????????

			"odPackimg"=>getafThumbUrl($dt["PACKIMG"]),
			"reBoxmediimg"=>getafThumbUrl($dt["BOXMEDIIMG"]),
			"reBoxdeliimg"=>getafThumbUrl($dt["BOXDELIIMG"]),
			"reRequest"=>getClob($dt["REREQUEST"]),
			"reDelicomp"=>$reDelicomp,
			"reDelicompO"=>$reDelicompO,
			"reDelicompT"=>$reDelicompT,

			"maTypeName"=>$maTypeName,
			"odMatype"=>$dt["OD_MATYPE"],
			"dcShapeName"=>$dt["DCSHAPENAME"],
			"dcBindersName"=>$dt["DCBINDERSNAME"],
			"dcFinenessName"=>$dt["DCFINENESSNAME"],
			"dc_millingloss"=>$dt["DC_MILLINGLOSS"],
			"dc_lossjewan"=>$dt["DC_LOSSJEWAN"],
			"dc_bindersliang"=>$dt["DC_BINDERSLIANG"],
			"dc_completeliang"=>$dt["DC_COMPLETELIANG"],
			"dc_completecnt"=>$dt["DC_COMPLETECNT"],///????????? 20190611 

			"dc_dry"=>$dt["DC_DRY"],
			"dc_ripen"=>$dt["DC_RIPEN"],
			"dcRipenName"=>$dt["DCRIPENNAME"],
			"dc_jungtang"=>$dt["DC_JUNGTANG"],
			"dcJungtangName"=>$dt["DCJUNGTANGNAME"],
			"dcSpecialName"=>$dcSpecialName,


			"reSendType"=>$dt["RE_SENDTYPE"],
			"reSendname"=>$dt["RE_SENDNAME"],
			"reSendphone"=>$dt["RE_SENDPHONE"],
			"reSendmobile"=>$dt["RE_SENDMOBILE"],
			"reSendzipcode"=>$dt["RE_SENDZIPCODE"],
			"reSendaddress"=>$sendaddr[0],
			"reSendaddress1"=>$sendaddr[1],


			"mrDesc"=>$dt["MR_DESC"],
			"odMrDesc"=>$dt["ODMRDESC"],
			///20191014 : ???????????? ???????????? 
			"markingtxt"=>$markingtxt,

			///???????????? 
			"reName"=>$dt["RE_NAME"],
			"reZipcode"=>$dt["RE_ZIPCODE"],
			"reAddress"=>str_replace("||", " ", $dt["RE_ADDRESS"]),
			"rePhone"=>$dt["RE_PHONE"],
			"reMobile"=>$dt["RE_MOBILE"],

			"miName"=>$dt["MI_NAME"],///????????? 
			"rcMedicine"=>$rcMedicine, ///?????? 
			"rcSweet"=>$rcSweet ///??????


		);
		$json["apiCode"]=$apicode;
		$json["returnData"]=$returnData;
		$json["sql"]=$sql;
		$json["resultCode"]="200";
		$json["resultMessage"]="OK";
	}
?>
