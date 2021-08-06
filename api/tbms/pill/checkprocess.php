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
		$sql=" select 
		a.od_seq, a.od_code, a.od_userid, a.od_staff, to_char(a.od_date, 'yyyy-mm-dd hh24:mi:ss') as ODDATE, a.OD_GOODS 
		, a.od_matype, a.OD_PILLCAPA, a.OD_QTY, a.od_title, a.od_status, a.od_scription 
		, m.mi_name
		, p.PL_MACHINESTAT, p.PL_STATUS , p.PL_STAFFID , p.PL_BARCODE 
		, z2.cd_name_kor maTypeName
		, u.rc_source
		, r.re_name 
		from ".$dbH."_order  a 
		inner join ".$dbH."_medical m on a.od_userid=m.mi_userid 
		inner join ".$dbH."_pill p on p.PL_KEYCODE=a.OD_KEYCODE 
		inner join ".$dbH."_recipeuser u on u.rc_code=a.od_scription 
		inner join ".$dbH."_release r on a.od_code=r.re_odcode
		left join ".$dbH."_code z2 on a.od_matype=z2.cd_code and z2.cd_type='maType' 
		where p.PL_BARCODE='".$code."' ";

		$dt=dbone($sql);
		$od_code = $dt["OD_CODE"];
		$pl_machinestat=$dt["PL_MACHINESTAT"];

		$maTypeName=getMatypeName($dt["OD_MATYPE"], $dt["MATYPENAME"], $dt["OD_GOODS"], $dt["RC_SOURCE"]);
		
		if($od_code)
		{
			if(strpos($dt["PL_STATUS"], "_apply") !== false || strpos($dt["PL_STATUS"], "_start") !== false || strpos($dt["PL_STATUS"], "_processing") !== false) 
			{
				if($dt["PL_STAFFID"]==$staffid || $dt["PL_STAFFID"]=="")
				{
					$medi = getMedicineList("user",$dt["OD_SCRIPTION"]);

					$re_address="";

					$json["data"]=array(
						"od_seq"=>$dt["OD_SEQ"], //processmember
						"od_userid"=>$dt["OD_USERID"], //processmember

						"od_code"=>$dt["OD_CODE"], //processmember
						"mi_name"=>$dt["MI_NAME"], //processmember
						"od_staff"=>$dt["OD_STAFF"], //processmember
						"od_date"=>$dt["ODDATE"],//processmember

						"od_title"=>$dt["OD_TITLE"],//processscription
						"maTypeName"=>$maTypeName,//processscription
						"pl_machinestat"=>$pl_machinestat,
						"re_name"=>$dt["RE_NAME"],//processuser
						"status"=>$dt["PL_STATUS"],
						"od_status"=>$dt["OD_STATUS"],//viewCheckProcess
						"barcode"=>$dt["PL_BARCODE"]//viewCheckProcess

						);

				}
				else
				{
					$json["data"]=array(
						"status"=>$dt["PL_STATUS"],
						"staffCheck"=>"true",
						"od_staff"=>$dt["OD_STAFF"], //processmember
						"maTypeName"=>$maTypeName,//processscription
						"pl_machinestat"=>$pl_machinestat,
						"od_status"=>$dt["OD_STATUS"]//viewCheckProcess
						);
				}
			}
			else
			{
				$json["data"]=array(
					"status"=>$dt["PL_STATUS"],
					"od_staff"=>$dt["OD_STAFF"], //processmember
					"maTypeName"=>$maTypeName,//processscription
					"pl_machinestat"=>$pl_machinestat,
					"od_status"=>$dt["OD_STATUS"]//viewCheckProcess
					);
			}

		}
		else
		{
			$json["data"]=array();
		}

		$json["od_code"]=$od_code;
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