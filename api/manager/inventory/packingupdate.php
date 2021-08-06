<?php  
	/// 자재코드관리 > 포장재관리 > 등록&수정 
	/// 사용자관리 > 한의원관리 상세보기 > 등록&수정	
	$apicode=$_POST["apiCode"];
	$language=$_POST["language"];
	if($apicode!="packingupdate"){$json["resultMessage"]="API(apiCode) ERROR";$apicode="packingupdate";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="API(language) ERROR";}
	else
	{
		$allPbMember=$_POST["allPbMember"];  //공통여부 라디오박스 추가
		$pb_seq=$_POST["pbseq"];
		$pb_code=$_POST["pbCode"];
		$pb_type=$_POST["pbType"];
		$pb_title=$_POST["pbTitle"];
		$pb_grade=$_POST["pbGrade"];
		$pb_codeonly=$_POST["pbCodeonly"];  //포장재마킹 

		$pb_volume=$_POST["pbVolume"];	//부피
		$pb_maxcnt=$_POST["pbMaxcnt"];	//최대팩수

		$pbMember=explode(",",$_POST["pbMember"]);
		$pb_member="";
		foreach($pbMember as $val)
		{
			if($pb_member!="")$pb_member.=",";
			if($val!="0000")
			{
				$pb_member.=$val;
			}
		}
		$pb_staff=$_POST["pbStaff"];
		$pb_desc=$_POST["pbDesc"];

		$pb_price=$_POST["pbPrice"];
		$pb_priceA=$_POST["pbPriceA"];
		$pb_priceB=$_POST["pbPriceB"];
		$pb_priceC=$_POST["pbPriceC"];
		$pb_priceD=$_POST["pbPriceD"];
		$pb_priceE=$_POST["pbPriceE"];

		$pb_capa=$_POST["pbCapa"];
			
		$returnData=$_POST["returnData"];

		if($pb_seq)
		{
			$sql=" update ".$dbH."_packingbox set pb_code='".$pb_code."',pb_type='".$pb_type."',pb_price='".$pb_price."',pb_priceA='".$pb_priceA."',pb_priceB='".$pb_priceB."',pb_priceC='".$pb_priceC."',pb_priceD='".$pb_priceD."',pb_priceE='".$pb_priceE."',pb_capa='".$pb_capa."', pb_title='".$pb_title."',pb_member='".$pb_member."',pb_staff='".$pb_staff."',pb_desc='".$pb_desc."',pb_grade='".$pb_grade."',pb_codeonly='".$pb_codeonly."',pb_volume='".$pb_volume."',pb_maxcnt='".$pb_maxcnt."', pb_modify=SYSDATE where pb_seq='".$pb_seq."' ";
		}
		else  
		{
			$sql=" insert into ".$dbH."_packingbox ";
			$sql.="(pb_seq,pb_code,pb_type,pb_title ";
			$sql.=" ,pb_member,pb_staff,pb_capa ";
			$sql.=" ,pb_price,pb_priceA,pb_priceB,pb_priceC,pb_priceD,pb_priceE,pb_desc ";
			$sql.=" ,pb_grade,pb_codeonly,pb_volume,pb_maxcnt, pb_date )";
			$sql.=" values((SELECT NVL(MAX(pb_seq),0)+1 FROM ".$dbH."_packingbox),'".$pb_code."','".$pb_type."','".$pb_title."' ";
			$sql.=", '".$pb_member."','".$pb_staff."','".$pb_capa."' ";
			$sql.=", '".$pb_price."','".$pb_priceA."','".$pb_priceB."','".$pb_priceC."','".$pb_priceD."','".$pb_priceE."','".$pb_desc."' ";
			$sql.=", '".$pb_grade."','".$pb_codeonly."','".$pb_volume."','".$pb_maxcnt."',SYSDATE) ";
		}

		dbcommit($sql);

		$json["sql"]=$sql;
		$json["apiCode"]=$apicode;
		$json["returnData"]=$returnData;
		$json["resultCode"]="200";
		$json["resultMessage"]="OK";
	}
?>