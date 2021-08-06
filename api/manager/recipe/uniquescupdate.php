<?php
	$apicode=$_POST["apiCode"];
	$language=$_POST["language"];
	$rc_code=$_POST["rcCode"];
	if($apicode!="uniquescupdate"){$json["resultMessage"]="API(apiCode) ERROR";$apicode="uniquescupdate";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="API(language) ERROR";}
	else if($rc_code==""){$json["resultMessage"]="API(rcCode) ERROR";}
	else{
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
		$rc_userid="0319326783";  //신창호대표님 rc_userid
		if($rc_seq){
			$sql=" update ".$dbH."_recipemember set rc_source ='".$rc_source."', rc_userid ='".$rc_userid."', rc_title_".$language." ='".$rc_title."' ,rc_detail_".$language." ='".$rc_detail."' ,rc_medicine ='".$rc_medicine."' ,rc_sweet ='".$rc_sweet."' ,rc_chub ='".$rc_chub."' ,rc_efficacy_".$language." ='".$rc_efficacy."' ,rc_maincure_".$language." ='".$rc_maincure."' ,rc_tingue_".$language." ='".$rc_tingue."' ,rc_pulse_".$language." ='".$rc_pulse."' ,rc_usage_".$language." ='".$rc_usage."' ,rc_base_".$language." ='".$rc_base."' ,rc_desc_".$language." ='".$rc_desc."' ,rc_status ='".$rc_status."' ,rc_modify=now() where rc_seq='".$rc_seq."'";
		}else{
			$sql=" insert into ".$dbH."_recipemember (rc_code, rc_source, rc_userid, rc_title_".$language." , rc_detail_".$language." ,rc_medicine ,rc_sweet ,rc_chub ,rc_efficacy_".$language." ,rc_maincure_".$language." ,rc_tingue_".$language." ,rc_pulse_".$language." ,rc_usage_".$language." ,rc_base_".$language." ,rc_desc_".$language." ,rc_status ,rc_date) values ('".$rc_code."','".$rc_source."','".$rc_userid."','".$rc_title."','".$rc_detail."','".$rc_medicine."','".$rc_sweet."','".$rc_chub."','".$rc_efficacy."','".$rc_maincure."','".$rc_tingue."','".$rc_pulse."','".$rc_usage."','".$rc_base."','".$rc_desc."','".$rc_status."',now()) ";
		}
		dbqry($sql);
		$returnData=$_POST["returnData"];
		$json=array("apiCode"=>$apicode,"returnData"=>$returnData);
		$json["resultCode"]="200";
		$json["resultMessage"]="OK";
	}
?>
