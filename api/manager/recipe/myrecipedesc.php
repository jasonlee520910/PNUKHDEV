<?php  
	///처방관리 > 나의처방 > 나의처방 상세 
	$apicode=$_GET["apiCode"];
	$language=$_GET["language"];
	$rc_seq=$_GET["seq"];

	if($apicode!="myrecipedesc"){$json["resultMessage"]="API(apiCode) ERROR_uniquescdesc";$apicode="myrecipedesc";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="API(language) ERROR";}
	else
	{
		if($rc_seq)
		{
			$sql=" select ";
			$sql.=" a.rc_seq, a.rc_code, a.rc_title_".$language." as rcTitle ,a.rc_medicine ,a.rc_sweet ";
			$sql.=" ,a.rc_chub, a.rc_packcnt, a.rc_packcapa ";
			$sql.=" ,a.rc_status, to_char(a.rc_date,'YYYY-MM-DD hh24:mi:ss') as RCDATE, m.ME_NAME, c.MI_NAME ";
			$sql.=" from ".$dbH."_recipemedical ";
			$sql.=" a left join ".$dbH."_member m on a.RC_USERID=m.me_userid ";
			$sql.=" left join ".$dbH."_medical c on a.RC_MEMBER=c.mi_userid ";
			$sql.=" where a.rc_seq='".$rc_seq."'  ";
			$dt=dbone($sql);

			$rcMedicine = getClob($dt["RC_MEDICINE"]);
			$rcMedicine = trim($rcMedicine);///빈공간있으면 일단은 삭제
			$rcMedicineList = getMedicine($rcMedicine);

			$json = array(
				"seq"=>$dt["RC_SEQ"], 
				"rcCode"=>$dt["RC_CODE"], 
				"meName"=>$dt["ME_NAME"], 
				"miName"=>$dt["MI_NAME"], 

				"rcTitle"=>$dt["RCTITLE"], 
				"rcSweet"=>getClob($dt["RC_SWEET"]), 
				"rcChub"=>$dt["RC_CHUB"],
				"rcPackcnt"=>$dt["RC_PACKCNT"], 
				"rcPackcapa"=>$dt["RC_PACKCAPA"], 
				"RCMEDICINE"=>$dt["RCMEDICINE"],

				"rcMedicine"=>$rcMedicine,  
				"rcMedicineList"=>$rcMedicineList,
				"rcStatusList"=>$rcStatusList,///승인,미승인 

				"rcStatus"=>$dt["RC_STATUS"], 
				"rcDate"=>$dt["RCDATE"]
				);
		}
		

		$json["apiCode"]=$apicode;
		$json["sql"]=$sql;
		$json["resultCode"]="200";
		$json["resultMessage"]="OK";
	}
?>
