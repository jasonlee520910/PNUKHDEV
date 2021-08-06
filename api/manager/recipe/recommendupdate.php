<?php  
	///처방관리 > 추천처방 > 추천처방 등록&수정
	$apicode=$_POST["apiCode"];
	$language=$_POST["language"];
	$rc_code=$_POST["rcCode"];
	if($apicode!="recommendupdate"){$json["resultMessage"]="API(apiCode) ERROR";$apicode="recommendupdate";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="API(language) ERROR";}
	else if($rc_code==""){$json["resultMessage"]="API(rcCode) ERROR";}
	else
	{
		$rc_seq=$_POST["seq"];
		$rc_title=$_POST["rcTitle"];
		$rc_medicine=$_POST["rcMedicine"];
		$rc_sweet=$_POST["rcSweet"];
		$rc_chub=$_POST["rcChub"];
		$rc_packcnt=$_POST["rcPackcnt"];
		$rc_packcapa=$_POST["rcPackcapa"];
		$rc_status=$_POST["rcStatus"];
		$rc_medical="recommend";//추천처방 
		$rc_userid=$_POST["rcUserid"];//한의사ID
		$rc_member="1000000000";//한의원ID


		
		if($rc_seq)
		{
			$sql=" update ".$dbH."_recipemedical set  rc_medical ='".$rc_medical."', rc_title_".$language." ='".$rc_title."' ,rc_medicine ='".$rc_medicine."' ,rc_sweet ='".$rc_sweet."' ,rc_chub ='".$rc_chub."' ,rc_member='".$rc_member."', rc_userid ='".$rc_userid."' , rc_packcnt='".$rc_packcnt."',rc_packcapa='".$rc_packcapa."', rc_status ='".$rc_status."', rc_modify=SYSDATE where rc_seq='".$rc_seq."' ";
			dbcommit($sql);
		}
		else
		{
			$sql=" insert into ".$dbH."_recipemedical (rc_seq,rc_code,  rc_medical, rc_member, rc_userid, rc_title_".$language." , rc_medicine ,rc_sweet ,rc_chub , rc_packcnt,rc_packcapa, RC_PILLORDER, rc_status , RC_USE, rc_date) values ((SELECT NVL(MAX(rc_seq),0)+1 FROM ".$dbH."_recipemedical),'".$rc_code."','".$rc_medical."','".$rc_member."','".$rc_userid."','".$rc_title."',".insertClob($rc_medicine).",".insertClob($rc_sweet).",'".$rc_chub."','".$rc_packcnt."','".$rc_packcapa."','','".$rc_status."','Y',SYSDATE) ";
			dbcommit($sql);
		}
		

		$returnData=$_POST["returnData"];
		$json=array("apiCode"=>$apicode,"returnData"=>$returnData);
		$json["resultCode"]="200";
		$json["resultMessage"]="OK";
		$json["sql"]=$sql;
	}
?>
