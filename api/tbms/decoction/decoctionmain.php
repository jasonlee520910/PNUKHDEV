<?php
	$apiCode=$_GET["apiCode"];
	$language=$_GET["language"];

	$code=$_GET["code"];
	$stat=$_GET["stat"];
	$ordercode=$_GET["ordercode"];
	$ck_staffid=$_GET["ck_staffid"];

	if($apiCode!="decoctionmain"){$json["resultMessage"]="API(apiCode) ERROR";$apiCode="decoctionmain";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="API(language) ERROR";}
	else
	{
		
		$jsql=" a  inner join ".$dbH."_order b on a.dc_odcode=b.od_code ";
		$jsql.=" left join ".$dbH."_code c1 on a.dc_title=c1.cd_code and c1.cd_type='dcTitle' ";
		$jsql.=" left join ".$dbH."_packingbox c2 on b.od_packtype=c2.pb_code ";
		$jsql.=" left join ".$dbH."_code c3 on a.dc_special=c3.cd_code and c3.cd_type='dcSpecial' ";
		$jsql.=" left join ".$dbH."_order_client cy on b.od_keycode=cy.keycode ";
		
		$sql=" select ";
		$sql.=" b.OD_PACKTYPE, b.OD_PACKCNT,b.OD_PACKCAPA,b.OD_REQUEST as ODREQUEST,b.OD_SCRIPTION,b.OD_CODE,b.OD_TITLE,b.OD_SITECATEGORY  ";
		$sql.=" ,a.DC_TIME,a.DC_WATER,a.DC_ALCOHOL,a.DC_COOLING,a.DC_STERILIZED,a.DC_STAFFID,a.DC_BOILERCODE,a.DC_PACKINGCODE,a.DC_PACKINGID, a.DC_STATUS ";
		$sql.=", c1.cd_name_".$language." decoctype, c2.pb_code pouchcode, c2.pb_title packtype, c3.cd_name_".$language." special, c3.cd_value_".$language." specialname";
		$sql.=", (select MIN(af_url) KEEP (DENSE_RANK FIRST ORDER BY af_no DESC) from han_file where af_fcode=b.OD_PACKTYPE and af_code='packingbox' and af_use='Y') as PACKIMG ";
		$sql.=", cy.packageInfo cypackageInfo ";
		$sql.=" from ".$dbH."_decoction $jsql where a.dc_barcode='".$code."' ";

		$dt=dbone($sql);
		$json["sql"]=$sql;
	
		$dc_staffid=$dt["DC_STAFFID"];
		$dc_boilercode=$dt["DC_BOILERCODE"];
		$dc_packingcode=$dt["DC_PACKINGCODE"];
		$dc_packingid=$dt["DC_PACKINGID"];
		$od_code=$dt["OD_CODE"];
		$od_title=$dt["OD_TITLE"];
		$od_sitecategory=$dt["OD_SITECATEGORY"];

		$specialname=getClob($dt["SPECIALNAME"]);
		$specialname=($specialname)?$specialname:"청주";
		
		
		$boilerlist=getBoilerList();
		$packinglist=getpackingList();
		$decolist=getDecoCodeTitle("all");
		$medi = getMedicineList("user",$dt["OD_SCRIPTION"]);		
		$timer=makehour($dt["DC_TIME"]);	

		while($md=dbarr($medi["list"]))
		{
			$meditxt[$md["md_code"]]["name"]=$md["mediname"];
			if($md["origin"]){$meditxt[$md["md_code"]]["origin"]=$md["origin"];}else{$meditxt[$md["md_code"]]["origin"]= " ";}
			$meditxt[$md["md_code"]]["poison"]=$md["md_poison"];
			$meditxt[$md["md_code"]]["addiction"]=$md["md_addiction"];		
		}
		
		//부직포 검증 초기화
		if($stat=="decoction_apply"||$stat=="decoction_start")
		{
			$sql5=" update ".$dbH."_decoction set dc_medibox_infirst='', dc_medibox_inmain='', dc_medibox_inafter='', dc_medibox_inlast='', dc_modify=sysdate where dc_odcode='".$ordercode."' ";
			dbcommit($sql5);
		}


		$total = $dt["OD_PACKCNT"]*$dt["OD_PACKCAPA"];

		$afFile=getafFile($dt["PACKIMG"]);
		$afThumbUrl=getafFile($dt["PACKIMG"]);
		


		$json=array(			
			"sql"=>$sql,

			"pouchboxcode"=>$dt["OD_PACKTYPE"],
			"odPackcnt"=>$dt["OD_PACKCNT"], 
			"odPackcapa"=>$dt["OD_PACKCAPA"],
			"odRequest"=>getClob($dt["ODREQUEST"]),
			"total"=>$total,
			"od_sitecategory"=>$od_sitecategory,
			
		
			"dc_status"=>$dt["DC_STATUS"],
			"dc_time"=>$dt["DC_TIME"],
			"dcWater"=>$dt["DC_WATER"],
			"dcAlcohol"=>$dt["DC_ALCOHOL"],
			"specialname"=>$specialname,
			"dcCooling"=>$dt["DC_COOLING"], // 냉각
			"dcSterilized"=>$dt["DC_STERILIZED"],	//살균		

			"totaltime"=>$timer["no"],
			"dcTime"=>$timer["txt"],
			"decoctype"=>$dt["DECOCTYPE"],
			"pouchcode"=>$dt["POUCHCODE"],
			"packtype"=>$dt["PACKTYPE"],
			"special"=>$dt["SPECIAL"],
			"afUrl"=>$afFile,
			"afThumbUrl"=>$afThumbUrl
		);

		$arr=explode("|",$medi["medicine"]);
		for($i=1;$i<count($arr);$i++)
		{
			$arr2=explode(",",$arr[$i]);
			${"decoc".$arr2[2]}.=",".$arr2[0];			
		}

		$decocmedilist=array();	

		for($i=0;$i<count($decolist);$i++)
		{
			$tmp=${"decoc".$decolist[$i]["cdCode"]};
			$decocmedilist[$decolist[$i]["cdCode"]]=$tmp;
		}	

		$json["meditxt"]=$meditxt;
		$json["decocmedilist"]=$decocmedilist;
		$json["decolist"]=$decolist;
		$json["boilerlist"]=$boilerlist;
		$json["packinglist"]=$packinglist;

		
		

		$json["apiCode"] = $apiCode;
		$json["resultCode"]="200";
		$json["resultMessage"]="OK";
	}


	

?>