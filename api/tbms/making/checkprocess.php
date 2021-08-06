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
		//20191113:조제테이블의 책임자(약사)ID 가져오기 
		$sql=" select mt_pharmacist from han_makingtable where mt_code='".$maTable."' ";
		$dt=dbone($sql);
		$mtPharmacist=$dt["MT_PHARMACIST"];
		$json["mtPharmacist"]=$mtPharmacist;


		$jsql=" a inner join ".$dbH."_medical m on a.od_userid=m.mi_userid ";
		$jsql.=" inner join ".$dbH."_making b on a.od_code=b.ma_odcode ";
		$jsql.=" inner join ".$dbH."_release e on a.od_code=e.re_odcode ";
		$jsql.=" inner join ".$dbH."_recipeuser u on u.rc_code=a.od_scription ";		
		$jsql.=" left join ".$dbH."_packingbox z1 on a.od_packtype=z1.pb_code and z1.pb_type='odPacktype' ";
		$jsql.=" left join ".$dbH."_code z2 on a.od_matype=z2.cd_code and z2.cd_type='maType' ";
		$jsql.=" left join ".$dbH."_staff s on s.st_staffid=b.ma_staffid ";
		$wsql="  where  ";
		$wsql.="  ma_barcode='".$code."' ";
		$sql=" select ";
		$sql.=" a.od_seq, a.od_code, a.od_userid, a.od_staff, to_char(a.od_date, 'yyyy-mm-dd hh24:mi:ss') as ODDATE, a.od_chubcnt, a.od_packcnt, a.od_goods,a.od_packcapa, a.od_title, a.od_status, a.od_scription,a.od_matype, u.rc_source, ";
		$sql.=" b.ma_table, b.ma_barcode, b.ma_status, b.ma_staffid, e.re_name, e.re_address, m.mi_name, z1.pb_title packtype , s.st_name, z2.cd_name_kor maTypeName ";
		$sql.=" from ".$dbH."_order $jsql $wsql $osql ";

		$dt=dbone($sql);
		$od_code = $dt["OD_CODE"];
		$json["sql"]=$sql;

		$maTypeName=getMatypeName($dt["OD_MATYPE"], $dt["MATYPENAME"], $dt["OD_GOODS"], $dt["RC_SOURCE"]);


		if($od_code)
		{
			if(strpos($dt["MA_STATUS"], "_apply") !== false || strpos($dt["MA_STATUS"], "_start") !== false || strpos($dt["MA_STATUS"], "_processing") !== false) 
			{
				if($dt["MA_STAFFID"]==$staffid || $dt["MA_STAFFID"]=="")
				{				
					if($dt["MA_TABLE"] == $maTable || $dt["MA_TABLE"]=="")
					{	
						if($proc=="MKD")
						{
							$sql0 ="update ".$dbH."_making set ma_table = null where ma_table='".$maTable."' and ma_tablestat is null";
							dbcommit($sql0);
							$sql1 ="update ".$dbH."_making set ma_table='".$maTable."', ma_pharmacist='".$mtPharmacist."' where ma_barcode = '".$code."' and ma_table is null and ma_tablestat is null ";
							dbcommit($sql1);
							$sql2 ="update ".$dbH."_makingtable set mt_odcode='".$od_code."', mt_staff='".$staffid."',  mt_intime=sysdate, mt_status='hold' where mt_code = '".$maTable."'";
							dbcommit($sql2);
						}


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
							"ma_table"=>$dt["MA_TABLE"],
							"re_name"=>$dt["RE_NAME"],//processuser
							"re_address"=>$re_address,//processuser
							"maTypeName"=>$maTypeName,//processscription

							"status"=>$dt["MA_STATUS"],
							"od_status"=>$dt["OD_STATUS"],//viewCheckProcess
							"barcode"=>$dt["MA_BARCODE"]//viewCheckProcess

							);

						$json["medi"]=$medi;
					}
					else
					{
						$json["data"]=array(
							"tableCheck"=>"true",
							"ma_table"=>$dt["MA_TABLE"],
							"status"=>$dt["MA_STATUS"],
							"maTypeName"=>$maTypeName,//processscription
							"od_staff"=>$dt["OD_STAFF"], //processmember
							"od_status"=>$dt["OD_STATUS"]//viewCheckProcess
							);
					}
				}
				else
				{
					$json["data"]=array(
						"staffCheck"=>"true",
						"ma_table"=>$dt["MA_TABLE"],
						"status"=>$dt["MA_STATUS"],
						"staffid"=>$dt["MA_STAFFID"],
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
					"ma_table"=>$dt["MA_TABLE"],
					"status"=>$dt["MA_STATUS"],
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
		$json["sql1"] = $sql1;
		$json["sql2"] = $sql2;
		$json["sql3"] = $sql3;

		$json["apiCode"] = $apiCode;
		$json["resultCode"]="200";
		$json["resultMessage"]="OK";
	}
?>