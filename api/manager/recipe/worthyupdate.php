<?php  
	///처방관리 > 실속처방 > 실속처방 등록&수정
	$apicode=$_POST["apiCode"];
	$language=$_POST["language"];
	$rc_code=$_POST["rcCode"];

	if($apicode!="worthyupdate"){$json["resultMessage"]="API(apiCode) ERROR";$apicode="worthyupdate";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="API(language) ERROR";}
	else if($rc_code==""){$json["resultMessage"]="API(rcCode) ERROR";}
	else
	{
		$rc_seq=$_POST["seq"];
		$rc_source=$_POST["rcSource"];
		//$rc_userid=$_POST["rcUserid"];
		$rc_title=$_POST["rcTitle"];
		$rc_detail=$_POST["rcDetail"];
		$rc_medicine=$_POST["rcMedicine"];
		$rc_sweet=$_POST["rcSweet"];
		$rc_chub=$_POST["rcChub"];
		$rc_efficacy=$_POST["rcEfficacy"];
		$rc_maincure=$_POST["rcMaincure"];
		$rc_tingue=$_POST["rcTingue"];
		$rc_pulse=$_POST["rcPulse"];
		$rc_usage=$_POST["rcUsage"];
		$rc_base=$_POST["rcBase"];
		$rc_desc=$_POST["rcDesc"];
		$rc_status=$_POST["rcStatus"];
		$rc_medical="worthy";  //실속처방
		$rc_userid="1000000000"; //청연 rc_userid
		
		//20191015 : 파우치, 한약박스, 팩수, 팩용량  추가 
		$rc_packtype=$_POST["rePacktype"];
		$rc_medibox=$_POST["reBoxmedi"];
		$rc_packcnt=$_POST["rcPackcnt"];
		$rc_packcapa=$_POST["rcPackcapa"];

		if($rc_seq)
		{
			$sql=" update ".$dbH."_recipemedical set rc_source ='".$rc_source."', rc_medical ='".$rc_medical."', rc_title_".$language." ='".$rc_title."' ,rc_detail_".$language." ='".$rc_detail."' ,rc_medicine ='".$rc_medicine."' ,rc_sweet ='".$rc_sweet."' ,rc_chub ='".$rc_chub."' ,rc_userid ='".$rc_userid."' , rc_packcnt='".$rc_packcnt."',rc_packcapa='".$rc_packcapa."',rc_medibox='".$rc_medibox."',rc_packtype='".$rc_packtype."', rc_efficacy_".$language." ='".$rc_efficacy."' ,rc_maincure_".$language." ='".$rc_maincure."' ,rc_tingue_".$language." ='".$rc_tingue."' ,rc_pulse_".$language." ='".$rc_pulse."' ,rc_usage_".$language." ='".$rc_usage."' ,rc_base_".$language." ='".$rc_base."' ,rc_desc_".$language." ='".$rc_desc."' ,rc_status ='".$rc_status."' ,rc_modify=SYSDATE where rc_seq='".$rc_seq."'";
			dbcommit($sql);
		}
		else
		{
			$sql=" insert into ".$dbH."_recipemedical (rc_seq,rc_code, rc_source, rc_medical, rc_userid, rc_title_".$language." , rc_detail_".$language." ,rc_medicine ,rc_sweet ,rc_chub , rc_packcnt,rc_packcapa,rc_medibox,rc_packtype, rc_efficacy_".$language." ,rc_maincure_".$language." ,rc_tingue_".$language." ,rc_pulse_".$language." ,rc_usage_".$language." ,rc_base_".$language." ,rc_desc_".$language." ,rc_status , rc_date) values ((SELECT NVL(MAX(rc_seq),0)+1 FROM ".$dbH."_recipemedical),'".$rc_code."','".$rc_source."','".$rc_medical."','".$rc_userid."','".$rc_title."','".$rc_detail."','".$rc_medicine."','".$rc_sweet."','".$rc_chub."','".$rc_packcnt."','".$rc_packcapa."','".$rc_medibox."','".$rc_packtype."','".$rc_efficacy."','".$rc_maincure."','".$rc_tingue."','".$rc_pulse."','".$rc_usage."','".$rc_base."','".$rc_desc."','".$rc_status."',SYSDATE) ";
			dbcommit($sql);

			$gd_code="MA".date("ymdHis"); //14자리

			//처방 입력시 goods도 등록
			$sql2=" insert into ".$dbH."_goods (gd_seq,gd_recipe, gd_loss, gd_losscapa, gd_capa,gd_stable,gd_type,gd_code,gd_unit,gd_name_kor,gd_desc,gd_use,gd_date) values ((SELECT NVL(MAX(gd_seq),0)+1 FROM ".$dbH."_goods),'".$rc_code."','0','0','1','1000','worthy','".$gd_code."','1','".$rc_title."','".$gd_desc."','Y',SYSDATE) ";  
			dbcommit($sql2);
		}


		$returnData=$_POST["returnData"];
		$json=array("apiCode"=>$apicode,"returnData"=>$returnData);
		$json["resultCode"]="200";
		$json["resultMessage"]="OK";
		$json["sql"]=$sql;
		$json["sql2"]=$sql2;
	}
?>
