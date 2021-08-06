<?php
	//GET
	$apicode=$_GET["apiCode"];
	$language=$_GET["language"];
	$od_seq=$_GET["seq"];
	$od_code=$_GET["code"];

	if($apicode!="orderreport"){$json["resultMessage"]="API(apicode) ERROR";$apicode="orderreport";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="API(language) ERROR";}
	else{
		$returnData=$_GET["returnData"];
		
		$jsql=" a inner join ".$dbH."_medical m on a.od_userid=m.mi_userid ";
		$jsql.=" left join ".$dbH."_packingbox z on a.od_packtype=z.pb_code ";

		$jsql.=" inner join ".$dbH."_making b on a.od_code=b.ma_odcode ";
		$jsql.=" left join ".$dbH."_staff s1 on b.ma_staffid=s1.st_staffid ";

		$jsql.=" inner join ".$dbH."_decoction c on a.od_code=c.dc_odcode ";
		$jsql.=" left join ".$dbH."_code z2 on c.dc_title=z2.cd_code and z2.cd_type='dcTitle' ";
		$jsql.=" left join ".$dbH."_code z21 on c.dc_special=z21.cd_code and z21.cd_type='dcSpecial' ";
		$jsql.=" left join ".$dbH."_staff s2 on c.dc_staffid=s2.st_staffid ";

		$jsql.=" inner join ".$dbH."_marking d on a.od_code=d.mr_odcode ";
		$jsql.=" left join ".$dbH."_code z3 on d.mr_desc=z3.cd_code and z3.cd_type='mrDesc' ";
		$jsql.=" left join ".$dbH."_staff s3 on d.mr_staffid=s3.st_staffid ";
		
		$jsql.=" inner join ".$dbH."_release e on a.od_code=e.re_odcode ";
		$jsql.=" left join ".$dbH."_file z4 on e.re_boxmedi=z4.af_fcode   ";
		/*
		$jsql.=" left join ".$dbH."_code z4 on e.re_boxmedi=z4.cd_code and z4.cd_type='reBoxmedi' ";
		$jsql.=" left join ".$dbH."_code z41 on e.re_boxdeli=z41.cd_code and z41.cd_type='reBoxdeli' ";
		*/
		$jsql.=" left join ".$dbH."_staff s4 on e.re_staffid=s4.st_staffid ";
		//$jsql.=" left join ".$dbH."_staff s4 on e.re_staffid=s4.st_userid ";
		$jsql.=" left join ".$dbH."_staff s41 on e.re_qmstaff=s41.st_userid ";

		$jsql.=" left join ".$dbH."_recipeuser r on a.od_scription=r.rc_code ";

		$wsql="  where a.od_use in ('Y','C') ";
		if($od_seq){
			$wsql.=" and a.od_seq='".$od_seq."' ";
		}else{
			$wsql.=" and a.od_code='".$od_code."' ";
		}
		
		$fsql=" z.pb_title packtype ";
		$fsql.=", z2.cd_name_".$language." dctitle, z21.cd_name_".$language." dcspecial ";
		$fsql.=", z3.cd_name_".$language." mrdesc, z3.cd_desc_".$language." mrdesctxt";
		$fsql.=", z4.af_name boxmedi, z4.af_url boxmediimg ";
		/*
		$fsql.=", z4.cd_name_".$language." boxmedi, z4.cd_value_".$language." boxmediimg ";
		$fsql.=", z41.cd_name_".$language." boxdeli, z41.cd_value_".$language." boxdeliimg ";
		*/
		$fsql.=", s41.st_name qmStaff ";
		$fsql.=", a.*,b.*,c.*,d.*,e.*,m.mi_name,m.mi_phone,m.mi_address, r.rc_medicine, r.rc_sweet, DATE_FORMAT(r.rc_modify,'%Y.%m.%d') rcDate";
		$fsql.=", s1.st_name makingstaff, s2.st_name decoctionstaff, s3.st_name markingstaff, s4.st_name releasestaff ";
		$sql=" select $fsql from ".$dbH."_order $jsql $wsql ";

		$dt=dbone($sql);
		$boxmedi=$dt["boxmedi"];
		$boxmediimg=$dt["boxmediimg"];
		$json=array(
			"seq"=>$dt["od_seq"], "odCode"=>$dt["od_code"], "odName"=>$dt["od_name"], "odStaff"=>$dt["od_staff"], "miName"=>$dt["mi_name"], "miPhone"=>$dt["mi_phone"], "miAddress"=>$dt["mi_address"]
			, "odTitle"=>$dt["od_title"], "odPacktype"=>$dt["packtype"], "odPackcapa"=>$dt["od_packcapa"], "odPackimg"=>$dt["packimg"], "odChubcnt"=>$dt["od_chubcnt"], "odPackcnt"=>$dt["od_packcnt"], "odAdvice"=>$dt["od_advice"], "odRequest"=>$dt["od_request"], "odDate"=>$dt["od_date"],"odMatype"=>$dt["od_matype"]
			, "maStaff"=>$dt["makingstaff"], "dcStaff"=>$dt["decoctionstaff"], "mrStaff"=>$dt["markingstaff"], "reStaff"=>$dt["releasestaff"]
			, "maDate"=>$dt["ma_modify"], "dcDate"=>$dt["dc_modify"], "mrDate"=>$dt["mr_modify"], "reDate"=>$dt["re_modify"]
			, "dcTitle"=>$dt["dctitle"], "dcSpecial"=>$dt["dcspecial"], "dcTime"=>$dt["dc_time"], "dcWater"=>$dt["dc_water"], "dcSterilized"=>$dt["dc_sterilized"], "dcCooling"=>$dt["dc_cooling"]
			, "mrDesc"=>$dt["mrdesctxt"]
			, "reCode"=>$dt["re_code"], "reName"=>$dt["re_name"], "qmCode"=>$dt["re_quality"], "qmStaff"=>$dt["qmStaff"], "rePhone"=>$dt["re_phone"], "reMobile"=>$dt["re_mobile"], "reZipcode"=>$dt["re_zipcode"], "reAddress"=>$dt["re_address"], "reBoxmedi"=>$dt["boxmedi"], "reBoxdeli"=>$dt["boxdeli"], "reDelitype"=>$dt["re_delitype"], "reDelicomp"=>$dt["re_delicomp"], "reDelino"=>$dt["re_delino"], "reDelidate"=>$dt["re_delidate"], "reBoxmediimg"=>$dt["boxmediimg"], "reBoxdeliimg"=>$dt["boxdeliimg"]
			, "rcMedicine"=>$dt["rc_medicine"], "rcSweet"=>$dt["rc_sweet"], "rcDate"=>$dt["rcDate"]/*, "sql"=>$sql*/);


		$json["sql"]=$sql;

		//재촬영이 있어서 각각의 limit 1만 가져온다.
		$json["files"]=array();
/*
		//making_infirst
		$sql=" select af_fcode, af_url from han_file where af_use='Y' and af_code='".$od_code."' and af_fcode ='making_infirst' order by af_no desc limit 1  ";
		$dt=dbone($sql);
		if($dt["af_fcode"])
		{
			$addarray=array(
				"afFcode"=>$dt["af_fcode"], 
				"afUrl"=>$dtdom.$dt["af_url"]
			);
			$json["files"]["making_infirst"]=$addarray;
		}
		else
		{
			$json["files"]["making_infirst"]=null;
		}
*/
		

		//making_inmain
		$sql=" select * from han_file where af_use='Y' and af_code='".$od_code."' and af_fcode ='making_inmain' order by af_no desc limit 1  ";
		$dt=dbone($sql);
		if($dt["af_fcode"])
		{
			$addarray=array(
				"afFcode"=>$dt["af_fcode"], 
				"afUrl"=>$dtdom.$dt["af_url"]
			);
			$json["files"]["making_inmain"]=$addarray;
		}
		else
		{
			$json["files"]["making_inmain"]=null;
		}

		//일반과 포장재이미지가 보내기로 함(임시: 190828)
		$json["files"]["making_inafter"]=null;
		$json["files"]["making_inlast"]=null;
		$json["files"]["making_infirst"]=null;

/*
		//making_inafter
		$sql=" select * from han_file where af_use='Y' and af_code='".$od_code."' and af_fcode ='making_inafter' order by af_no desc limit 1  ";
		$dt=dbone($sql);
		if($dt["af_fcode"])
		{
			$addarray=array(
				"afFcode"=>$dt["af_fcode"], 
				"afUrl"=>$dtdom.$dt["af_url"]
			);
			$json["files"]["making_inafter"]=$addarray;
		}
		else
		{
			$json["files"]["making_inafter"]=null;
		}

		//making_inlast
		$sql=" select * from han_file where af_use='Y' and af_code='".$od_code."' and af_fcode ='making_inlast' order by af_no desc limit 1  ";
		$dt=dbone($sql);
		if($dt["af_fcode"])
		{
			$addarray=array(
				"afFcode"=>$dt["af_fcode"], 
				"afUrl"=>$dtdom.$dt["af_url"]
			);
			$json["files"]["making_inlast"]=$addarray;
		}
		else
		{
			$json["files"]["making_inlast"]=null;
		}
		//release_medibox
		$sql=" select * from han_file where af_use='Y' and af_code='".$od_code."' and af_fcode ='release_medibox' order by af_no desc limit 1  ";
		$dt=dbone($sql);
		if($dt["af_fcode"])
		{
			$addarray=array(
				"afFcode"=>$dt["af_fcode"], 
				"afUrl"=>$dtdom.$dt["af_url"]
			);
			$json["files"]["release_medibox"]=$addarray;
		}
		else
		{
			$json["files"]["release_medibox"]=null;
		}
*/
		if($boxmedi)
		{
			$addarray=array(
				"afFcode"=>$boxmedi, 
				"afUrl"=>$dtdom.$boxmediimg
			);
			$json["files"]["release_medibox"]=$addarray;
		}
		else
		{
			$json["files"]["release_medibox"]=null;
		}


		$json["apiCode"]=$apicode;
		$json["resultCode"]="200";
		$json["resultMessage"]="OK";
	}
?>
