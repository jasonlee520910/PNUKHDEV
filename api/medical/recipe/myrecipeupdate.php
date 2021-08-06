<?php  
	//주문내역에서 나의처방등록 했을 경우 
	$apiCode=$_POST["apiCode"];
	$language=$_POST["language"];
	if($apiCode!="myrecipeupdate"){$json["resultMessage"]="API코드오류";$apiCode="myrecipeupdate";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="언어코드오류";}
	else
	{
		$returnData=$_POST["returnData"];
		$json=array("apiCode"=>$apiCode,"returnData"=>$returnData);

		$doctorId=$_POST["doctorId"]; ///한의사
		$medicalId=$_POST["medicalId"]; ///한의원
		$seqdata=$_POST["seqdata"]; ///등록할 처방seq 

		$seqarr=explode(",",$seqdata);

		$sql1="";
		for($i=1;$i<count($seqarr);$i++)
		{
			$rc_medibox="";
			$rc_packtype="";
			$osql=" select 
					b.OD_CHUBCNT, b.OD_PACKCNT, b.OD_PACKCAPA 
					from HAN_RECIPEUSER 
					a inner join han_order b on b.OD_SCRIPTION=a.RC_CODE 
					where a.RC_SEQ='".$seqarr[$i]."' ";
			$odt=dbone($osql);

			$rc_chub=($odt["OD_CHUBCNT"])?$odt["OD_CHUBCNT"]:"0";
			$rc_packcnt=($odt["OD_PACKCNT"])?$odt["OD_PACKCNT"]:"0";
			$rc_packcapa=($odt["OD_PACKCAPA"])?$odt["OD_PACKCAPA"]:"0";

			$rc_code="RC".date("YmdHis");
			$csql=" select NVL(COUNT(RC_SEQ),0)+1 as CNT from ".$dbH."_recipemedical where RC_CODE like '".$rc_code."%' ";
			$cdt=dbone($csql);
			$odNo=($cdt["CNT"])?$cdt["CNT"]:1;

			$odNo=sprintf("%05d",$odNo);
			$newCode=$rc_code.$odNo;

			$rc_medical="myrecipe";

			//RC20200617 105428 00001
			$sql=" insert into ".$dbH."_recipemedical (rc_seq,rc_code, rc_source, rc_medical, rc_member, rc_userid, rc_title_".$language." , rc_medicine ,rc_sweet ,rc_chub , rc_packcnt,rc_packcapa,rc_medibox,rc_packtype, RC_PILLORDER, rc_status , RC_USE, rc_date ) select (SELECT NVL(MAX(RC_SEQ),0)+1 FROM ".$dbH."_recipemedical), '".$newCode."', RC_SOURCE, '".$rc_medical."', '".$medicalId."','".$doctorId."', RC_TITLE_KOR,   RC_MEDICINE, RC_SWEET, '".$rc_chub."', '".$rc_packcnt."','".$rc_packcapa."','".$rc_medibox."','".$rc_packtype."', RC_PILLORDER, 'Y', 'Y', sysdate   from HAN_RECIPEUSER where RC_SEQ='".$seqarr[$i]."' ";
			dbcommit($sql);

			$sql1.=$sql;
		}

		$json["_POST"]=$_POST;
		$json["sql1"]=$sql1;
		$json["apiCode"]=$apiCode;
		$json["resultCode"]="200";
		$json["resultMessage"]="OK";
	}
?>