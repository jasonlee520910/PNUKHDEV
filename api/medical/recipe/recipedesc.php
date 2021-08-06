<?php
	$apiCode=$_GET["apiCode"];
	$language=$_GET["language"];
	$rcCode=$_GET["rcCode"];

	if($apiCode!="recipedesc"){$json["resultMessage"]="API(apiCode) ERROR2";$apiCode="recipedesc";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="API(language) ERROR";}
	else if($rcCode==""){$json["resultMessage"]=" API(rcCode) ERROR";}
	else
	{
		$state=$_GET["state"];

		$wsql=" where rc_code = '".$rcCode."' ";
		$sql=" select rc_code, rc_medicine, rc_title_".$language." RCTITLE  from ".$dbH."_recipemember $wsql ";
		$dt=dbone($sql);

		///------------------------------------------------------------
		/// DOO :: 약재정보 이름으로 보여지기 위한 쿼리 추가 
		///------------------------------------------------------------
		$rcMedicine = substr($dt["RC_MEDICINE"], 1); ///한자리만 자르기 
		$rcMedicineList = getMedicine($rcMedicine);
		///------------------------------------------------------------

		$json=array(
			"rcCode"=>$dt["RC_CODE"],
			"rcTitle"=>$dt["RCTITLE"],
			"rcMedicine"=>$rcMedicine,///처방한 약재목록
			"rcMedicineList"=>$rcMedicineList///처방한 약재목록
			);


		$json["sql"]=$sql;
		$json["apiCode"]=$apiCode;
		$json["resultCode"]="200";
		$json["resultMessage"]="OK";
	}
?>