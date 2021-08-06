<?php
	$apiCode=$_GET["apiCode"];
	$language=$_GET["language"];
	
	$proc=$_GET["proc"];
	$proccode=$_GET["proccode"];
	$ahd=$_GET["ahd"];
	$code=$_GET["code"];
	$staffid=$_GET["staffid"];
	$maTable=$_GET["maTable"];
	$depart=$_GET["depart"];
	$stat=$_GET["stat"];

	if($apiCode!="checkprocess"){$json["resultMessage"]="API(apiCode) ERROR";$apiCode="checkprocess";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="API(language) ERROR";}
	else
	{
		$jsql=" a inner join ".$dbH."_medical m on a.od_userid=m.mi_userid ";
		$jsql.=" inner join ".$dbH."_release e on a.od_code=e.re_odcode ";
		$jsql.=" inner join ".$dbH."_recipeuser u on u.rc_code=a.od_scription ";		
		$jsql.=" left join ".$dbH."_packingbox z1 on a.od_packtype=z1.pb_code and z1.pb_type='odPacktype' ";
		$jsql.=" left join ".$dbH."_code z2 on a.od_matype=z2.cd_code and z2.cd_type='maType' ";
		$jsql.=" left join ".$dbH."_staff s on s.st_staffid=e.re_staffid ";
		$wsql="  where  ";
		$wsql.=" re_barcode='".$code."' ";
		$sql=" select ";
		$sql.="a.od_seq, a.od_code, a.od_userid, a.od_staff, a.od_date, a.od_chubcnt, a.od_packcnt,a.od_goods, a.od_packcapa, a.od_title, a.od_status, a.od_scription, a.od_matype, u.rc_source, ";
		$sql.=" e.re_barcode,e.re_staffid,  e.re_status, e.re_name, e.re_address, m.mi_name, z1.pb_title packtype , s.st_name, z2.cd_name_kor maTypeName ";
		$sql.=" from ".$dbH."_order $jsql $wsql $osql ";

		$dt=dbone($sql);
		$od_code = $dt["OD_CODE"];


		$maTypeName=getMatypeName($dt["OD_MATYPE"], $dt["MATYPENAME"], $dt["OD_GOODS"], $dt["RC_SOURCE"]);

		
		if($od_code)
		{
			if(strpos($dt["RE_STATUS"], "_apply") !== false || strpos($dt["RE_STATUS"], "_start") !== false || strpos($dt["RE_STATUS"], "_processing") !== false) 
			{
				if($dt["RE_STAFFID"]==$staffid || $dt["RE_STAFFID"]=="")
				{
					$medi = getMedicineList("user",$dt["OD_SCRIPTION"]);

					$str_date = $dt["OD_DATE"];
					$date = date("Y-m-d", strtotime( $str_date ) );

					$re_address=str_replace("||", " ", $dt["RE_ADDRESS"]);

					$json["data"]=array(
						"od_seq"=>$dt["OD_SEQ"], //processmember
						"od_userid"=>$dt["OD_USERID"], //processmember

						"od_code"=>$dt["OD_CODE"], //processmember
						"mi_name"=>$dt["MI_NAME"], //processmember
						"od_staff"=>$dt["OD_STAFF"], //processmember
						"od_date"=>$date,//processmember
						"maTypeName"=>$maTypeName,//processscription

						"od_chubcnt"=>$dt["OD_CHUBCNT"],//processscription
						"od_packcnt"=>$dt["OD_PACKCNT"],//processscription
						"od_packcapa"=>$dt["OD_PACKCAPA"],//processscription
						"packtype"=>$dt["PACKTYPE"],//processscription
						"od_title"=>$dt["OD_TITLE"],//processscription

						"re_name"=>$dt["RE_NAME"],//processuser
						"re_address"=>$re_address,//processuser
						"status"=>$dt["RE_STATUS"],
						"od_status"=>$dt["OD_STATUS"],//viewCheckProcess
						"barcode"=>$dt["RE_BARCODE"]//viewCheckProcess

						);

					$json["medi"]=$medi;
				}
				else
				{
					$json["data"]=array(
						"status"=>$dt["RE_STATUS"],
						"staffCheck"=>"true",
						"staffid"=>$dt["RE_STAFFID"],
						"st_name"=>$dt["ST_NAME"],
						"maTypeName"=>$maTypeName,//processscription
						"od_staff"=>$dt["OD_STAFF"], //processmember
						"od_status"=>$dt["OD_STATUS"]//viewCheckProcess
						);
				}
			}
			else
			{
				$json["data"]=array(
					"status"=>$dt["RE_STATUS"],
					"maTypeName"=>$maTypeName,//processscription
					"od_staff"=>$dt["OD_STAFF"], //processmember
					"od_status"=>$dt["OD_STATUS"]//viewCheckProcess
					);
			}

		}
		else
		{
			$json["data"]=array();
		}


		$json["proccode"]=$proccode;
		$json["depart"]=$depart;
		$json["code"]=$code;
		$json["stat"]=$stat;
		$json["sql"]=$sql;

		$json["apiCode"] = $apiCode;
		$json["resultCode"]="200";
		$json["resultMessage"]="OK";
	}
?>