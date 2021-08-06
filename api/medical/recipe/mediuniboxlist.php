<?php ///나의처방 
	$apiCode=$_GET["apiCode"];
	$language=$_GET["language"];
	$page=$_GET["page"];
	$medicalId=$_GET["medicalId"]; ///한의원
	$meUserId=$_GET["meUserId"]; ///한의사

	if($apiCode!="mediuniboxlist"){$json["resultMessage"]="API(apiCode) ERROR2";$apiCode="mediuniboxlist";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="API(language) ERROR";}
	else
	{
		$searchtxt=urldecode(trim($_GET["searchTxt"])); ///검색단어
		$json=array("apiCode"=>$apiCode,"returnData"=>$returnData,"searchTxt"=>$searchtxt,"reData"=>$reData);

		$jsql="  ";
		$wsql=" where rc_use = 'Y' and rc_medical = '".$medicalId."' ";   ///조건 rc_userid를 rc_medical 로 수정함

		if($searchtxt)  ///검색단어
		{
			$wsql.=" and ( ";
			$wsql.=" rc_title_".$language." like '".$searchtxt."%' ";///처방명
			$wsql.=" ) ";
		}

		$sql=" select ";
		$sql.=" rc_code, rc_title_".$language." RCTITLE, rc_medicine RCMEDICINE ";
		$sql.=" from ".$dbH."_recipemember $jsql $wsql ";
		$sql.=" order by rc_seq desc ";

		$res=dbqry($sql);
		$json["sql"]=$sql;
		$json["list"]=array();

		while($dt=dbarr($res))
		{
			///------------------------------------------------------------
			/// DOO :: 약재정보 이름으로 보여지기 위한 쿼리 추가 
			///------------------------------------------------------------
			$rcMedicine = substr($dt["RCMEDICINE"], 1); ///한자리만 자르기 
			$rcMedicineTxt = getMedicine($rcMedicine, 'list');
			///------------------------------------------------------------			
			$addarray = array(	
					"rcCode"=>$dt["RC_CODE"],
					"rcTitle"=>$dt["RCTITLE"], 
					"rcMedicineTxt"=>$rcMedicineTxt
					);
			array_push($json["list"], $addarray);
		}
		$json["sql"]=$sql;
		$json["apiCode"]=$apiCode;
		$json["resultCode"]="200";
		$json["resultMessage"]="OK";
	}
?>