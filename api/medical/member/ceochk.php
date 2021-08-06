<?php ///대표 한의사가 한의원탈퇴시 소속한의사가 없는지 체크
	$apiCode=$_GET["apiCode"];
	$language=$_GET["language"];
	$meUserId=$_GET["meUserId"];
	$medicalid=$_GET["medicalid"];

	if($apiCode!="ceochk"){$json["resultMessage"]="API(apiCode) ERROR2";$apiCode="ceochk";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="API(language) ERROR";}
	else
	{
//r&medicalId=0583054228&doctorId=6220187474&medicalid=0583054228&meUserId=6220187474&meGrade=30
		$returnData=$_GET["returnData"];
		$json=array("apiCode"=>$apiCode,"returnData"=>$returnData);

		$sql=" select me_seq from ".$dbH."_member where me_company='".$medicalid."' and me_userid <> '".$meUserId."' ";
		$dt=dbone($sql);

		$json=array("apiCode"=>$apiCode);
		if($dt["ME_SEQ"]){
			$json["resultCode"]="204"; ///사용불가능
		}else{
			$json["resultCode"]="200"; ///사용가능함
		}
		$json["resultMessage"]="OK";


		$json["sql"]=$sql;
		$json["apiCode"]=$apiCode;
	}
?>


