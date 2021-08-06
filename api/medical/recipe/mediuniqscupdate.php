<?php  ///나의처방 등록&수정
	$apiCode=$_POST["apiCode"];
	$language=$_POST["language"];
	if($apiCode!="mediuniqscupdate"){$json["resultMessage"]="2_API코드오류";$apiCode="mediuniqscupdate";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="언어코드오류";}
	else
	{
		$returnData=$_POST["returnData"];
		$json=array("apiCode"=>$apiCode,"returnData"=>$returnData);

		$rc_userid=$_POST["meUserId"]; ///한의원
		$medicalId=$_POST["medicalId"]; ///한의사

		$rc_seq=$_POST["seq"];
		$rc_code=$_POST["rcCode"];
		$rc_source=$_POST["rcSource"];  
		$rc_sourcetit=$_POST["rcSourcetit"]; ///목차
		$rc_title=$_POST["rcTitle"]; ///처방명
		$rc_detail=$_POST["rcDetail"]; ///상세
		$rc_medicine=$_POST["rcMedicine"];
		///$rc_sweet=$_POST["rcSweet"];
		$rc_chub=$_POST["rcChub"];///첩수
		$rc_efficacy=$_POST["rcEfficacy"]; ///효능
		$rc_maincure=$_POST["rcMaincure"];///주치
		$rc_tingue=$_POST["rcTingue"];  ///설진단
		$rc_pulse=$_POST["rcPulse"];  ///맥상
		$rc_usage=$_POST["rcUsage"]; ///복용법
		$rc_base=$_POST["rcBase"];
		$rc_desc=$_POST["rcDesc"];
		$rc_status=$_POST["rcStatus"];  ///승인여부
		if(!$rc_status)$rc_status="F"; ///승인여부 체크하는 부분

		///rc_source 는 고유처방 입력 받을때 비워두게 작업하라고 하심 (2019.06.17)

		if($rc_seq=="add")
		{
			$rc_code="RC".date("YmdHis");
			$sql=" insert into ".$dbH."_recipemember (rc_seq,rc_medical, rc_code, rc_sourcetit, rc_userid, rc_title_".$language." , rc_detail_".$language."  ";
			$sql.=" ,rc_medicine ,rc_sweet ,rc_chub ,rc_efficacy_".$language." ,rc_maincure_".$language." ,rc_tingue_".$language." ,rc_pulse_".$language."  ";
			$sql.=" ,rc_usage_".$language." ,rc_base_".$language." ,rc_desc_".$language." ,rc_status ,rc_date) ";
			$sql.=" values ((SELECT NVL(MAX(rc_seq),0)+1 FROM ".$dbH."_recipemember),'".$medicalId."','".$rc_code."','".$rc_source.",".$rc_sourcetit."','".$rc_userid."' ";
			$sql.=" ,'".$rc_title."','".$rc_detail."','".$rc_medicine."','".$rc_sweet."','".$rc_chub."','".$rc_efficacy."','".$rc_maincure."','".$rc_tingue."' ";
			$sql.=" ,'".$rc_pulse."','".$rc_usage."','".$rc_base."','".$rc_desc."','".$rc_status."',sysdate) ";

			$json["resultMessage"]="등록되었습니다.";
		}
		else
		{
			$sql=" update ".$dbH."_recipemember set rc_sourcetit ='".$rc_source.",".$rc_sourcetit."', rc_userid ='".$rc_userid."' ";
			$sql.=" ,rc_medical ='".$medicalId."', rc_title_".$language." ='".$rc_title."' ,rc_detail_".$language." ='".$rc_detail."' ";
			$sql.=" ,rc_medicine ='".$rc_medicine."' ,rc_sweet ='".$rc_sweet."' ,rc_chub ='".$rc_chub."' ,rc_efficacy_".$language." ='".$rc_efficacy."' ";
			$sql.=" ,rc_maincure_".$language." ='".$rc_maincure."' ,rc_tingue_".$language." ='".$rc_tingue."' ,rc_pulse_".$language." ='".$rc_pulse."' ";
			$sql.=" ,rc_usage_".$language." ='".$rc_usage."' ,rc_base_".$language." ='".$rc_base."' ,rc_desc_".$language." ='".$rc_desc."' ";
			$sql.=" ,rc_status ='".$rc_status."' ,rc_modify=sysdate where rc_seq='".$rc_seq."'";

			$json["resultMessage"]="수정되었습니다.";
		}
///echo $sql;
		dbcommit($sql);

		$json["sql"]=$sql;
		$json["apiCode"]=$apiCode;
		$json["resultCode"]="200";
		$json["resultMessage"]="OK";
	}
?>