<?php
	///orderreport 품질보고서 
	//GET
	$apicode=$_GET["apiCode"];
	$language=$_GET["language"];
	$od_seq=$_GET["seq"];
	$od_code=$_GET["code"];
	$od_code=str_replace("ODD","",$od_code);

	if($apicode!="orderreport"){$json["resultMessage"]="API(apicode) ERROR";$apicode="orderreport";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="API(language) ERROR";}
	else
	{
		$returnData=$_GET["returnData"];
	
		$sql=" select ";
		$sql.=" a.od_seq, a.od_mobile, a.od_gender, a.od_matype, a.od_name, a.od_code, a.OD_SCRIPTION ";
		$sql.=" ,a.od_packcnt, a.od_chubcnt,a.od_packcapa, a.od_packtype, a.od_title, a.od_staff ";
		$sql.=" , to_char(a.od_birth,'YYYY-MM-DD') as odbirth ";
		$sql.=" , to_char(a.od_date, 'yyyy-mm-dd hh24:mi:ss') as oddate ";
		$sql.=" ,a.od_request as odrequest ";
		$sql.=" ,a.od_advice as odadvice ";
		$sql.=" ,(select MIN(af_url) KEEP (DENSE_RANK FIRST ORDER BY af_no DESC) from ".$dbH."_file where af_fcode=a.od_packtype and af_code='packingbox' and af_use='Y') as pouchimg ";
		$sql.=" ,(select pb_title from ".$dbH."_packingbox where pb_type='odPacktype' and pb_code=a.od_packtype) as packtype ";
		$sql.=" ,m.mi_name,m.mi_phone,m.mi_address ";
		$sql.=" ,b.MA_TABLE, b.ma_end ";
		$sql.=" ,to_char(b.MA_MODIFY, 'yyyy-mm-dd hh24:mi:ss') as MAMODIFY ";
		$sql.=" ,to_char(c.dc_modify, 'yyyy-mm-dd hh24:mi:ss') as DCMODIFY ";
		$sql.="  ,c.dc_time, c.dc_water, c.dc_sterilized, c.dc_cooling ";
		$sql.=" , (select cd_name_".$language." from ".$dbH."_code where cd_type='dcTitle' and cd_code=c.dc_title) as  DCTITLE ";
		$sql.=" , (select cd_name_".$language." from ".$dbH."_code where cd_type='dcSpecial' and cd_code=c.dc_special) as  DCSPECIAL ";
		$sql.=" , (select bo_title from ".$dbH."_boiler where bo_code=c.dc_boilercode) as BOILERNAME ";
		$sql.=" , (select pa_title from ".$dbH."_packing where pa_code=c.dc_packingcode) as PACKINGNAME ";
		$sql.=" ,to_char(d.MR_MODIFY, 'yyyy-mm-dd hh24:mi:ss') as MRMODIFY ";
		$sql.=" , (select cd_desc_".$language." from ".$dbH."_code where cd_type='mrDesc' and cd_code=d.mr_desc) as  mrdesctxt ";
		$sql.=" ,( select max(af_url) from ".$dbH."_file where af_userid=b.MA_PHARMACIST and af_code='staff' and af_fcode='signature'  and af_use='Y' ) as makingsign ";
		$sql.=" ,( select max(af_url) from ".$dbH."_file where af_userid=c.dc_staffid and af_code='staff' and af_fcode='signature'  and af_use='Y' ) as decoctionsign ";
		$sql.=" ,( select max(af_url) from ".$dbH."_file where af_userid=d.mr_staffid and af_code='staff' and af_fcode='signature'  and af_use='Y' ) as markingsign ";
		$sql.=" ,( select max(af_url) from ".$dbH."_file where af_userid=e.re_staffid and af_code='staff' and af_fcode='signature'  and af_use='Y' ) as releasesign ";
		$sql.=" ,to_char(e.re_modify , 'yyyy-mm-dd hh24:mi:ss') as REMODIFY ";
		$sql.=" ,to_char(e.re_delidate , 'yyyy-mm-dd') as REDELIDATE ";
		$sql.=" ,e.re_name, e.re_quality, e.re_phone, e.re_mobile, e.re_zipcode, e.re_address, e.re_delitype, e.re_delicomp, e.RE_DELIEXCEPTION, e.re_delino ";
		$sql.=" ,r.rc_medicine as RCMEDICINE ";
		$sql.=" ,r.rc_sweet as RCSWEET ";
		$sql.=" ,cy.orderCode cyodcode ";
		$sql.=" ,s1.st_name makingstaff, s1.st_userid makingid ";
		$sql.=" , s2.st_name decoctionstaff, s2.st_userid decoctionid ";
		$sql.=" , s3.st_name markingstaff, s3.st_userid markingid ";
		$sql.=" , s4.st_name releasestaff, s4.st_userid releaseid ";
		$sql.=" from ".$dbH."_order a ";
		$sql.=" inner join ".$dbH."_medical m on a.od_userid=m.mi_userid ";
		$sql.=" inner join ".$dbH."_making b on a.od_code=b.ma_odcode ";
		$sql.=" inner join ".$dbH."_decoction c on a.od_code=c.dc_odcode ";
		$sql.=" inner join ".$dbH."_marking d on a.od_code=d.mr_odcode ";
		$sql.=" inner join ".$dbH."_release e on a.od_code=e.re_odcode ";
		$sql.=" inner join ".$dbH."_recipeuser r on a.od_scription=r.rc_code ";
		$sql.=" left join ".$dbH."_order_client cy on a.od_keycode=cy.keycode ";
		$sql.=" left join ".$dbH."_staff s1 on s1.st_staffid=b.ma_staffid ";
		$sql.=" left join ".$dbH."_staff s2 on s2.st_staffid=c.dc_staffid  ";
		$sql.=" left join ".$dbH."_staff s3 on d.mr_staffid=s3.st_staffid ";
		$sql.=" left join ".$dbH."_staff s4 on e.re_staffid=s4.st_staffid ";
		$sql.=" where a.od_use in ('Y','C') ";
		if($od_seq)
		{
			$sql.=" and a.od_seq='".$od_seq."' ";
		}
		else
		{
			$sql.=" and a.od_code='ODD".$od_code."' ";
		}

		$dt=dbone($sql);
		$json["sql"]=$sql;
		

		$odScription=$dt["OD_SCRIPTION"]; //RC2019120416234300001
		$od_packtype=$dt["OD_PACKTYPE"];
		$pouchimg=$dt["POUCHIMG"];
		$re_delicomp=$dt["RE_DELICOMP"];
		$re_deliexception=$dt["RE_DELIEXCEPTION"];

		

		if($dt["OD_GENDER"]=="male"){$odGender="남";}else if($dt["OD_GENDER"]=="female"){$odGender="여";}else{$odGender="--";}
		$od_chartpk="";

		$json=array(
			//order 
			"seq"=>$dt["OD_SEQ"],
			"odCode"=>$dt["OD_CODE"], 
			"odName"=>$dt["OD_NAME"], 
			"odStaff"=>$dt["OD_STAFF"], 
			"odTitle"=>$dt["OD_TITLE"], 
			"odMatype"=>$dt["OD_MATYPE"], 
			"od_packtype"=>$dt["OD_PACKTYPE"],
			"odPackcapa"=>$dt["OD_PACKCAPA"], 
			"odChubcnt"=>$dt["OD_CHUBCNT"], 
			"odPackcnt"=>$dt["OD_PACKCNT"], 
			"odAdvice"=>getClob($dt["ODADVICE"]), 
			"odRequest"=>getClob($dt["ODREQUEST"]), 
			"odDate"=>$dt["ODDATE"],
			"pouchimg"=>$dt["POUCHIMG"], 
			"odPacktype"=>$dt["PACKTYPE"],  
			"odGender"=>$dt["OD_GENDER"], 
			"odGenderTxt"=>$odGender, 
			"odBirth"=>$dt["ODBIRTH"], 
			"odMobile"=>$dt["OD_MOBILE"],
			//medical 
			"miName"=>$dt["MI_NAME"], 
			"miPhone"=>$dt["MI_PHONE"], 
			"miAddress"=>$dt["MI_ADDRESS"],

			//making
			"maEnd"=>$dt["MA_END"],
			"maTable"=>$dt["MA_TABLE"],
			"maDate"=>$dt["MAMODIFY"], 

			//decoction 
			"dcTime"=>$dt["DC_TIME"], 
			"dcWater"=>$dt["DC_WATER"], 
			"dcSterilized"=>$dt["DC_STERILIZED"], 
			"dcCooling"=>$dt["DC_COOLING"], 
			"dcDate"=>$dt["DCMODIFY"], 
			"dcTitle"=>$dt["DCTITLE"], //탕전법 
			"dcSpecial"=>$dt["DCSPECIAL"], //특수탕전명 
			"dcBoiler"=>$dt["BOILERNAME"], //보일러이름 
			"dcPacking"=>$dt["PACKINGNAME"], //포장기번호 

			//marking 
			"mrDate"=>$dt["MRMODIFY"], 
			"mrDesc"=>getClob($dt["MRDESCTXT"]),
				
			//release 
			"reDate"=>$dt["REMODIFY"], 
			"reDelidate"=>$dt["REDELIDATE"], 
			"reName"=>$dt["RE_NAME"],
			"qmCode"=>getClob($dt["RE_QUALITY"]), 
			"rePhone"=>$dt["RE_PHONE"], 
			"reMobile"=>$dt["RE_MOBILE"], 
			"reZipcode"=>$dt["RE_ZIPCODE"], 
			"reAddress"=>$dt["RE_ADDRESS"], 
			"reDelitype"=>$dt["RE_DELITYPE"], 
			"reDelicomp"=>$dt["RE_DELICOMP"], 
			"re_deliexception"=>$dt["RE_DELIEXCEPTION"],
			"reDelino"=>$dt["RE_DELINO"],

			//recipeuser 
			"rcMedicine"=>getClob($dt["RCMEDICINE"]),
			"rcSweet"=>getClob($dt["RCSWEET"]),


			//작업자사인 
			"makingsign"=>$dt["MAKINGSIGN"],  //조제작업자 사인
			"decoctionsign"=>$dt["DECOCTIONSIGN"],
			"markingsign"=>$dt["MARKINGSIGN"],
			"releasesign"=>$dt["RELEASESIGN"],


			"maStaff"=>$dt["MAKINGSTAFF"], //조제는 한약사만 표시되도록
			"dcStaff"=>$dt["DECOCTIONSTAFF"], 
			"mrStaff"=>$dt["MARKINGSTAFF"], 
			"reStaff"=>$dt["RELEASESTAFF"], 

			"makingid"=>$dt["MAKINGID"], // st_userid
			"decoctionid"=>$dt["DECOCTIONID"], 
			"markingid"=>$dt["MARKINGID"], 
			"releaseid"=>$dt["RELEASEID"], 

		
			"odChartPK"=>$od_chartpk

		);

		$json["sql"]=$sql;
		

		$delitype="";
		$confirmdate="";
		if(strpos($re_deliexception,",D")!==false)//직배이면 
		{
			$sqld=" select delitype, to_char(confirmdate, 'yyyy-mm-dd hh24:mi:ss') as confirmdate from ".$dbH."_delicode_direct where odcode='".$od_code."' and deliconfirm in ('N', 'Y') ";
			$ddt=dbone($sqld);

			if($ddt["DELITYPE"])
			{
				$delitype=$ddt["DELITYPE"];
				$confirmdate=$ddt["CONFIRMDATE"];
			}
		}
		else
		{
			if(strtoupper($re_delicomp)=="POST")
			{
				$sqld=" select delitype, to_char(confirmdate, 'yyyy-mm-dd hh24:mi:ss') as confirmdate from ".$dbH."_DELICODE_POST where odcode='".$od_code."' and deliconfirm in ('N', 'Y') ";
				$ddt=dbone($sqld);
				if($ddt["DELITYPE"])
				{
					$delitype=$ddt["DELITYPE"];
					$confirmdate=$ddt["CONFIRMDATE"];
				}
			}
		}

		$delitypename=getDeliveryCompName($re_deliexception, $delitype);
		$json["sqld"]=$sqld; //택배사종류
		$json["delitype"]=$delitypename; //택배사종류
		$json["confirmdate"]=$confirmdate;// 생성출하일

		


		//재촬영이 있어서 각각의 limit 1만 가져온다.
		$json["files"]=array();

		//making_infirst
		$sqlm=" select * from (select AF_URL, AF_FCODE from ".$dbH."_file where af_use='Y' and af_code='".$od_code."' and af_fcode ='making_infirst' order by af_no desc) where rownum=1; ";
		$dt=dbone($sqlm);
		if($dt["AF_FCODE"])
		{
			$afFile=getafFile($dt["AF_URL"]);
			$afThumbUrl=getafThumbUrl($dt["AF_URL"]);

			$addarray=array(
				"afFcode"=>$dt["AF_FCODE"], 
				"afThumbUrl"=>$dtdom.$afThumbUrl, 
				"afUrl"=>$dtdom.$afFile
				);
			$json["files"]["making_infirst"]=$addarray;
		}
		else
		{
			$json["files"]["making_infirst"]=null;
		}

		//making_inmain
		$sqlm=" select * from (select AF_URL, AF_FCODE from ".$dbH."_file where af_use='Y' and af_code='".$od_code."' and af_fcode ='making_inmain' order by af_no desc) where rownum=1; ";
		$dt=dbone($sqlm);
		if($dt["AF_FCODE"])
		{
			$afFile=getafFile($dt["AF_URL"]);
			$afThumbUrl=getafThumbUrl($dt["AF_URL"]);

			$addarray=array(
				"afFcode"=>$dt["AF_FCODE"], 
				"afThumbUrl"=>$dtdom.$afThumbUrl, 
				"afUrl"=>$dtdom.$afFile
				);
			$json["files"]["making_inmain"]=$addarray;
		}
		else
		{
			$json["files"]["making_inmain"]=null;
		}


		//making_inafter
		$sqlm=" select * from (select AF_URL, AF_FCODE from ".$dbH."_file where af_use='Y' and af_code='".$od_code."' and af_fcode ='making_inafter' order by af_no desc) where rownum=1; ";
		$dt=dbone($sqlm);
		if($dt["AF_FCODE"])
		{
			$afFile=getafFile($dt["AF_URL"]);
			$afThumbUrl=getafThumbUrl($dt["AF_URL"]);

			$addarray=array(
				"afFcode"=>$dt["AF_FCODE"], 
				"afThumbUrl"=>$dtdom.$afThumbUrl, 
				"afUrl"=>$dtdom.$afFile
				);
			$json["files"]["making_inafter"]=$addarray;
		}
		else
		{
			$json["files"]["making_inafter"]=null;
		}

		//making_inlast
		$sqlm=" select * from (select AF_URL, AF_FCODE from ".$dbH."_file where af_use='Y' and af_code='".$od_code."' and af_fcode ='making_inlast' order by af_no desc) where rownum=1; ";
		$dt=dbone($sqlm);
		if($dt["AF_FCODE"])
		{
			$afFile=getafFile($dt["AF_URL"]);
			$afThumbUrl=getafThumbUrl($dt["AF_URL"]);

			$addarray=array(
				"afFcode"=>$dt["AF_FCODE"], 
				"afThumbUrl"=>$dtdom.$afThumbUrl, 
				"afUrl"=>$dtdom.$afFile
				);
			$json["files"]["making_inlast"]=$addarray;
		}
		else
		{
			$json["files"]["making_inlast"]=null;
		}

		//포장 촬영한 이미지로 보여지게 작업함(191107)
		$sql=" select AF_URL, AF_FCODE from ".$dbH."_file where af_use='Y' and af_code='".$od_code."' and af_fcode in ('release_medibox','release_medibox_add') order by af_no desc ";
		$res=dbqry($sql);
		$json["boximg"]=array();
		for($i=0;$dt=dbarr($res);$i++)
		{
			$afFile=getafFile($dt["AF_URL"]);
			$afThumbUrl=getafThumbUrl($dt["AF_URL"]);

			$addarray=array(
				"afFcode"=>$dt["AF_FCODE"], 
				"afThumbUrl"=>$dtdom.$afThumbUrl, 
				"afUrl"=>$dtdom.$afFile
				);
			array_push($json["boximg"], $addarray);
		}


		//-------------------------------------------------------------------------------------
		//".$dbH."_recipeuser에 저장한 rc_quality 약재정보를 가져온다. (1204)  뿌려주기

		$sql5=" select rc_quality  from ".$dbH."_recipeuser where rc_code='".$odScription."'  ";
		$dt5=dbone($sql5);	

		$qualitylist=json_decode(getClob($dt5["RC_QUALITY"]), true);

		$json["sql5"]=$sql5;
		$json["qualitylist"]=$qualitylist;
		//-------------------------------------------------------------------------------------
	


		$json["apiCode"]=$apicode;
		$json["resultCode"]="200";
		$json["resultMessage"]="OK";
	}		

?>
