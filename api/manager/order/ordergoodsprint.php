<?php
	//GET
	$apicode=$_GET["apiCode"];
	$language=$_GET["language"];
	$od_code=$_GET["odCode"];
	if($apicode!="ordergoodsprint"){$json["resultMessage"]="API(apiCode) ERROR";$apicode="ordergoodsprint";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="API(language) ERROR";}
	else if($od_code==""){$json["resultMessage"]="API(od_code) ERROR";}
	else
	{
		$returnData=$_GET["returnData"];

		
		$jsql=" a inner join ".$dbH."_release b on b.re_odcode=a.gp_odcode ";
		$jsql.=" inner join ".$dbH."_order c on c.od_code=a.gp_odcode ";
		$jsql.=" inner join ".$dbH."_goods d on d.gd_code=a.gp_goods ";
		$jsql.=" inner join ".$dbH."_medical e on e.mi_userid=b.re_userid ";
		$jsql.=" inner join ".$dbH."_medical m on c.od_userid=m.mi_userid ";
		$jsql.=" left join ".$dbH."_code c4 on b.re_delitype=c4.cd_code and cd_type='reDelitype' ";
		$jsql.=" left join ".$dbH."_order_client oc on oc.keycode=c.od_keycode ";
		$jsql.=" left join ".$dbH."_code t7 on t7.cd_type='meSex' and c.od_gender=t7.cd_code ";
		$jsql.=" left join ".$dbH."_code z1 on c.od_meditype=z1.cd_code and z1.cd_type='odMeditype' ";
		$jsql.=" left join ".$dbH."_code z2 on b.re_delitype=z2.cd_code and z2.cd_type='reDelitype' ";
		$jsql.=" left join ".$dbH."_code t on t.cd_type='maType' and c.od_matype=t.cd_code ";
		$jsql.=" left join ".$dbH."_recipeuser r on c.od_scription=r.rc_code ";

		$wsql=" where a.gp_odcode='".$od_code."' and c.od_use in ('Y','C') ";

		$fsql=" a.GP_GOODSCNT , a.GP_SUBGOODS as GPSUBGOODS ";
		$fsql.=", b.re_name,  b.re_zipcode , b.re_address, b.re_phone, b.re_mobile, b.re_request as REREQUEST, b.re_delicomp, b.re_deliexception  ";
		$fsql.=", to_char(b.re_delidate, 'yyyy-mm-dd') as reDelidate , z2.cd_name_".$language." reDelitype, b.re_name reUserName ";
		$fsql.=", b.re_sendtype, b.re_sendname, b.re_sendphone, b.re_sendmobile, b.re_sendzipcode, b.re_sendaddress ";

		$fsql.=", c.od_code,c.od_name odName,c.od_title odTitle, to_char(c.od_date, 'yyyy-mm-dd hh24:mi:ss') as odDate, c.od_matype, c.od_request as ODREQUEST, to_char(c.od_birth, 'yyyy-mm-dd') as ODBIRTH, c.od_goods  ";
		$fsql.=", d.gd_name_kor as goodsName ";
		$fsql.=", oc.orderCode cyodcode, oc.markText ";
		$fsql.=", z1.cd_name_".$language." odMeditype ";
		$fsql.=", t7.cd_name_".$language." as odGenderName ";
		$fsql.=", t.cd_name_".$language." as maTypeName ";
		$fsql.=", m.mi_name ";
		$fsql.=", r.rc_source ";


		$sql=" select $fsql from ".$dbH."_package $jsql $wsql ";
		$dt=dbone($sql);

	
		//$od_chartpk=($dt["od_chartpk"]) ? $dt["od_chartpk"] : "";
		//if($dt["od_chartpk"]){$od_chartpk="<span style='padding:2px 5px;border-radius:2px;background:#CC66CC;color:#fff;'>OK ".$dt["od_chartpk"]."</span>";}else{$od_chartpk="";}
		//if($dt["CYODCODE"]){$cyodcode="<span style='padding:2px 5px;border-radius:2px;background:#6699FF;color:#fff;'>BK ".($dt["CYODCODE"]+10000)."</span>";}else{$cyodcode="";}
		//if($cyodcode){$od_chartpk=$cyodcode;}

		
		//택배는 무조건 CJ 
		$reDelicomp=getDeliveryCompName($dt["RE_DELIEXCEPTION"], $dt["RE_DELICOMP"]);
		$sendaddr=explode("||", $dt["RE_SENDADDRESS"]);

		$maTypeName=getMatypeName($dt["OD_GOODS"], $dt["MATYPENAME"], $dt["RC_SOURCE"]);

		$json=array(
				"odCode"=>$dt["OD_CODE"],//주문코드 
				"odName"=>$dt["ODNAME"],//환자명
				"odTitle"=>$dt["ODTITLE"],//처방명_PACKNAME_첩약명
				"odMeditype"=>$dt["ODMEDITYPE"], //처방종류
				"odDate"=>$dt["ODDATE"], //order od_modify 날짜 

				"odRequest"=>getClob($dt["ODREQUEST"]), //주문자요청사항 

				"odChartPK"=>$od_chartpk, //20191011 od_chartpk
				"cymarkText"=>$dt["MARKTEXT"],

				//20190823 :: 성별,생년월일, 사상 추가 
				"odGenderName"=>$dt["ODGENDERNAME"], //성별 
				"odBirth"=>$dt["ODBIRTH"], //생년월일 
				"odMatype"=>$dt["OD_MATYPE"],
					
				"reDelidate"=>$dt["REDELIDATE"], //배송희망일_PRESETDATE_수령예정일
				"reDelitype"=>$dt["REDELITYPE"], //배송방법_PRESETTIME_수령방법

				"reRequest"=>getClob($dt["REREQUEST"]),
				"reDelicomp"=>$reDelicomp,
				"maTypeName"=>$maTypeName,
				"miName"=>$dt["MI_NAME"],	


				"reSendType"=>$dt["RE_SENDTYPE"],
				"reSendname"=>$dt["RE_SENDNAME"],
				"reSendphone"=>$dt["RE_SENDPHONE"],
				"reSendmobile"=>$dt["RE_SENDMOBILE"],
				"reSendzipcode"=>$dt["RE_SENDZIPCODE"],
				"reSendaddress"=>$sendaddr[0],
				"reSendaddress1"=>$sendaddr[1],

				"reName"=>$dt["RE_NAME"],
				"reZipcode"=>$dt["RE_ZIPCODE"],
				"reAddress"=>str_replace("||", "", $dt["RE_ADDRESS"]),
				"rePhone"=>$dt["RE_PHONE"],
				"reMobile"=>$dt["RE_MOBILE"],


				"goodsName"=>$dt["GOODSNAME"],//제품명 
				"goodsCnt"=>($dt["GP_GOODSCNT"])?$dt["GP_GOODSCNT"]:1//제품갯수 
			);

		//구성요소
		$tmp_gpsubgoods=getClob($dt["GPSUBGOODS"]);
		$arrg=explode(",", $tmp_gpsubgoods);
		$json["arrg"] = $arrg;
		for($i=1;$i<count($arrg);$i++)
		{
			$arrs=explode("|",$arrg[$i]);
			$gcode=$arrs[0];
			if($i>1)
			{
				$gpcode.=",";
			}
			$gpcode.="'".$gcode."'";
			$gcnt[$gcode]=$arrs[1];
		}

		$gsql=" select ";
		$gsql.=" c1.cd_name_kor as gdTypeName, a.gd_type, a.gd_code, a.gd_name_".$language." as gdname ";
		$gsql.=" ,(select MIN(af_url) KEEP (DENSE_RANK FIRST ORDER BY af_no DESC) from han_file where af_fcode=a.gd_code and af_code='goods' and af_use='Y') as goodsImg ";  
		$gsql.=" from han_goods ";
		$gsql.=" a left join han_code c1 on c1.cd_type='gdType' and c1.cd_code=a.gd_type ";
		$gsql.=" where gd_code in (".$gpcode.") ";
		$gres=dbqry($gsql);
		$json["gsql"] = $gsql;
		$json["goodslist"]=array();
		while($gdt=dbarr($gres))
		{
			$addarray=array(
				"gdTypeName"=>$gdt["GDTYPENAME"], //제품구분이름 
				"gd_type"=>$gdt["GD_TYPE"], //제품구분 
				"gd_code"=>$gdt["GD_CODE"],  //제품코드
				"gd_name"=>$gdt["GDNAME"],  //제품이름 
				"gd_thumb_image"=>getafThumbUrl($gdt["GOODSIMG"]),  //제품이미지 
				"gd_image"=>getafFile($gdt["GOODSIMG"]),  //제품이미지 
				"gd_cnt"=>$gcnt[$gdt["GD_CODE"]] //갯수
			);
			array_push($json["goodslist"], $addarray);			
		}



		$json["apiCode"]=$apicode;
		$json["returnData"]=$returnData;
		$json["sql"]=$sql;
		$json["resultCode"]="200";
		$json["resultMessage"]="OK";
	}
?>
