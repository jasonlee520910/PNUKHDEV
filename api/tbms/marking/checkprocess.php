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
	$mpPrinter=$_GET["mpPrinter"];

	if($apiCode!="checkprocess"){$json["resultMessage"]="API(apiCode) ERROR";$apiCode="checkprocess";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="API(language) ERROR";}
	else
	{
		$jsql=" a inner join ".$dbH."_medical m on a.od_userid=m.mi_userid ";
		$jsql.=" inner join ".$dbH."_marking b on a.od_code=b.mr_odcode ";
		$jsql.=" inner join ".$dbH."_release e on a.od_code=e.re_odcode ";
		$jsql.=" inner join ".$dbH."_recipeuser u on u.rc_code=a.od_scription ";	
		$jsql.=" left join ".$dbH."_packingbox z1 on a.od_packtype=z1.pb_code and z1.pb_type='odPacktype' ";
		$jsql.=" left join ".$dbH."_code z2 on a.od_matype=z2.cd_code and z2.cd_type='maType' ";
		$jsql.=" left join ".$dbH."_staff s on s.st_staffid=b.mr_staffid ";
		$wsql="  where ";
		$wsql.=" mr_barcode='".$code."' ";
		$sql=" select ";
		$sql.=" a.od_code, a.od_staff, a.od_name, to_char(a.od_date, 'yyyy-mm-dd hh24:mi:ss') as ODDATE, a.od_matype, a.od_goods, a.od_chubcnt, a.od_packcnt, a.od_packcapa, a.od_title, a.od_status, a.od_scription, u.rc_source, ";
		$sql.=" b.mr_barcode, b.mr_staffid,  b.mr_status,  e.re_name, e.re_zipcode, e.re_address, m.mi_name, z1.pb_title packtype , s.st_name, z2.cd_name_kor maTypeName ";
		$sql.=" from ".$dbH."_order $jsql $wsql $osql ";

		$dt=dbone($sql);
		$od_code = $dt["OD_CODE"];

		$maTypeName=getMatypeName($dt["OD_MATYPE"], $dt["MATYPENAME"], $dt["OD_GOODS"], $dt["RC_SOURCE"]);
		
		if($od_code)
		{
			if(strpos($dt["MR_STATUS"], "_apply") !== false || strpos($dt["MR_STATUS"], "_start") !== false || strpos($dt["MR_STATUS"], "_processing") !== false) 
			{
				if($dt["MR_STAFFID"]==$staffid || $dt["MR_STAFFID"]=="")
				{
					if($mpPrinter)
					{
						$sql2 ="update ".$dbH."_markingprinter set mp_odcode='".$od_code."', mp_staff='".$staffid."', mp_status='hold' where mp_code = '".$mpPrinter."'";
						dbcommit($sql2);
					}

					$medi = getMedicineList("user",$dt["OD_SCRIPTION"]);

					$re_address=str_replace("||", " ", $dt["RE_ADDRESS"]);

					$json["data"]=array(

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

						"re_name"=>$dt["OD_NAME"],//20191023 : 주문자에서 환자명으로 교체 tbms는 수정안하기 위해서 이렇게 바꿈 
						"re_zipcode"=>$dt["RE_ZIPCODE"],
						"re_address"=>$re_address,//processuser
						"status"=>$dt["MR_STATUS"],
						"od_status"=>$dt["OD_STATUS"],//viewCheckProcess
						"barcode"=>$dt["MR_BARCODE"]//viewCheckProcess

						);

					$json["medi"]=$medi;
				}
				else
				{
					$json["data"]=array(
						"staffCheck"=>"true",
						"status"=>$dt["MR_STATUS"],
						"staffid"=>$dt["MR_STAFFID"],
						"maTypeName"=>$maTypeName,//processscription
						"st_name"=>$dt["ST_NAME"],
						"od_staff"=>$dt["OD_STAFF"], //processmember
						"od_status"=>$dt["OD_STATUS"]//viewCheckProcess
						);
				}
			}
			else
			{
				$json["data"]=array(
					"status"=>$dt["MR_STATUS"],
					"maTypeName"=>$maTypeName,//processscription
					"od_staff"=>$dt["OD_STAFF"], //processmember
					"od_status"=>$dt["OD_STATUS"]//viewCheckProcess
					);
			}


		}

		$json["proccode"]=$proccode;
		$json["depart"]=$depart;
		$json["code"]=$code;
		$json["stat"]=$stat;

		
		$json["sql"] = $sql;
		//$json["sql1"] = $sql1;
		//$json["sql2"] = $sql2;
		//$json["sql3"] = $sql3;

		$json["apiCode"] = $apiCode;
		$json["resultCode"]="200";
		$json["resultMessage"]="OK";
	}
?>