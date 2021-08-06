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
		$jsql.=" inner join ".$dbH."_package e on a.od_code=e.gp_odcode ";
		$jsql.=" inner join ".$dbH."_release r on a.od_code=r.re_odcode ";
		$jsql.=" inner join ".$dbH."_recipeuser u on u.rc_code=a.od_scription ";	
		$jsql.=" left join ".$dbH."_code z2 on a.od_matype=z2.cd_code and z2.cd_type='maType' ";

		$wsql="  where  ";
		$wsql.=" e.gp_barcode='".$code."' ";
		$sql=" select ";
		$sql.="a.od_seq, a.od_code, a.od_userid, a.od_staff, to_char(a.od_date, 'yyyy-mm-dd hh24:mi:ss') as ODDATE, a.od_matype, a.od_goods, a.od_chubcnt, a.od_packcnt, a.od_packcapa, a.od_title, a.od_status, a.od_scription, u.rc_source, ";
		$sql.=" e.gp_barcode, e.gp_staffid,  e.gp_status, r.re_name, r.re_address, m.mi_name, z2.cd_name_kor maTypeName  ";
		$sql.=" from ".$dbH."_order $jsql $wsql $osql ";

		$dt=dbone($sql);
		$od_code = $dt["OD_CODE"];

		$maTypeName=getMatypeName($dt["OD_MATYPE"], $dt["MATYPENAME"], $dt["OD_GOODS"], $dt["RC_SOURCE"]);
		
		if($od_code)
		{
			if(strpos($dt["GP_STATUS"], "_apply") !== false || strpos($dt["GP_STATUS"], "_start") !== false || strpos($dt["GP_STATUS"], "_processing") !== false) 
			{
				if($dt["GP_STAFFID"]==$staffid || $dt["GP_STAFFID"]=="")
				{
					$medi = getMedicineList("user",$dt["OD_SCRIPTION"]);

					$re_address=str_replace("||", " ", $dt["RE_ADDRESS"]);

					$json["data"]=array(
						"od_seq"=>$dt["OD_SEQ"], //processmember
						"od_userid"=>$dt["OD_USERID"], //processmember

						"od_code"=>$dt["OD_CODE"], //processmember
						"mi_name"=>$dt["MI_NAME"], //processmember
						"od_staff"=>$dt["OD_STAFF"], //processmember
						"od_date"=>$dt["ODDATE"],//processmember

						"od_chubcnt"=>$dt["OD_CHUBCNT"],//processscription
						"od_packcnt"=>$dt["OD_PACKCNT"],//processscription
						"od_packcapa"=>$dt["OD_PACKCAPA"],//processscription
						"packtype"=>$dt["PACKTYPE"],//processscription
						"od_title"=>$dt["OD_TITLE"],//processscription
						"maTypeName"=>$maTypeName,//processscription

						"re_name"=>$dt["RE_NAME"],//processuser
						"re_address"=>$re_address,//processuser
						"status"=>$dt["GP_STATUS"],
						"od_status"=>$dt["OD_STATUS"],//viewCheckProcess
						"barcode"=>$dt["GP_BARCODE"]//viewCheckProcess

						);

				}
				else
				{
					$json["data"]=array(
						"status"=>$dt["GP_STATUS"],
						"staffCheck"=>"true",
						"od_staff"=>$dt["OD_STAFF"], //processmember
						"maTypeName"=>$maTypeName,//processscription
						"od_status"=>$dt["OD_STATUS"]//viewCheckProcess
						);
				}
			}
			else
			{
				$json["data"]=array(
					"status"=>$dt["GP_STATUS"],
					"od_staff"=>$dt["OD_STAFF"], //processmember
					"maTypeName"=>$maTypeName,//processscription
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