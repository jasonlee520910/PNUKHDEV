<?php  ///이전처방에 있는 내용을 나의처방으로 등록하기 
	$apiCode=$_POST["apiCode"];
	$language=$_POST["language"];
	if($apiCode!="addprescriptionupdate"){$json["resultMessage"]="2_API코드오류";$apiCode="addprescriptionupdate";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="언어코드오류";}
	else
	{
		$returnData=$_POST["returnData"];
		$json=array("apiCode"=>$apiCode,"returnData"=>$returnData);
 
		$medicalId=$_POST["medicalId"];  ///한의원  6961221599
		$meUserId=$_POST["meUserId"]; ///한의사  3549219923

		$rc_title=$_POST["rcTitle"];
		$rc_medicine="|".$_POST["rcMedicine"];
		$rc_code=$_POST["rcCode"];


		$sql=" insert into ".$dbH."_recipemember (rc_medical, rc_userid, rc_code, rc_title_".$language." ,rc_medicine,rc_date) ";
		$sql.=" values ('".$medicalId."','".$meUserId."','".$rc_code."','".$rc_title."','".$rc_medicine."',sysdate) ";

		$json["resultMessage"]="등록되었습니다.";
		
		dbcommit($sql);

		$json["sql"]=$sql;
		$json["apiCode"]=$apiCode;
		$json["resultCode"]="200";
		$json["resultMessage"]="OK";
	}
?>