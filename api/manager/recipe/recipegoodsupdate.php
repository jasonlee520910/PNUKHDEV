<?php  
	///처방관리 > 약속처방 > 약속처방 등록&수정
	$apicode=$_POST["apiCode"];
	$language=$_POST["language"];
	$rc_code=$_POST["rcCode"];
	if($apicode!="recipegoodsupdate"){$json["resultMessage"]="API(apiCode) ERROR";$apicode="recipegoodsupdate";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="API(language) ERROR";}
	else if($rc_code==""){$json["resultMessage"]="API(rcCode) ERROR";}
	else
	{
		$rc_chub=$_POST["rcChub"];
		$rc_seq=$_POST["seq"];
		$rc_title=$_POST["rcTitle"];
		$rc_medicine=$_POST["rcMedicine"];
		$rc_sweet=$_POST["rcSweet"];

		$rc_status=$_POST["rcStatus"];
		$rc_medical="goods";  //약속처방
		$rc_userid="1000000000"; //청연 rc_userid
		
		/// 파우치, 한약박스, 팩수, 팩용량  추가 
		$rc_packtype=$_POST["rePacktype"];
		$rc_medibox=$_POST["reBoxmedi"];
		$rc_packcnt=$_POST["rcPackcnt"];
		$rc_packcapa=$_POST["rcPackcapa"];

		if($rc_seq)
		{
			$sql=" update ".$dbH."_recipemedical set rc_medical ='".$rc_medical."', rc_title_".$language." ='".$rc_title."' ,rc_sweet ='".$rc_sweet."',rc_medicine ='".$rc_medicine."',rc_chub ='".$rc_chub."' ,rc_userid ='".$rc_userid."' , rc_packcnt='".$rc_packcnt."',rc_packcapa='".$rc_packcapa."',rc_medibox='".$rc_medibox."',rc_packtype='".$rc_packtype."',rc_status ='".$rc_status."' ,rc_modify=SYSDATE where rc_seq='".$rc_seq."'";
			dbcommit($sql);
		}
		else
		{
			$sql=" insert into ".$dbH."_recipemedical (rc_seq,rc_code, rc_medical, rc_userid, rc_title_".$language." ,rc_medicine ,rc_sweet,rc_chub , rc_packcnt,rc_packcapa,rc_medibox,rc_packtype, rc_status , rc_date) values ((SELECT NVL(MAX(rc_seq),0)+1 FROM ".$dbH."_recipemedical),'".$rc_code."','".$rc_medical."','".$rc_userid."','".$rc_title."','".$rc_medicine."','".$rc_sweet."','".$rc_chub."','".$rc_packcnt."','".$rc_packcapa."','".$rc_medibox."','".$rc_packtype."','".$rc_status."',SYSDATE) ";
			dbcommit($sql);

			$gd_code="MA".date("ymdHis"); ///14자리

			///처방 입력시 goods도 등록
			$sql2=" insert into ".$dbH."_goods (gd_seq,gd_recipe, gd_loss, gd_losscapa, gd_capa,gd_stable,gd_type,gd_code,gd_unit,gd_name_kor,gd_desc,gd_use,gd_date)";
			$sql2.=" values ((SELECT NVL(MAX(gd_seq),0)+1 FROM ".$dbH."_goods),'".$rc_code."','0','0','1','1000','goodsdecoction'";
			$sql2.=" ,'".$gd_code."','1','".$rc_title."','".$gd_desc."','Y',SYSDATE) ";  
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
