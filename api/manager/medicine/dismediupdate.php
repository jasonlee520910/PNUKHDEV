<?php  
	///약재관리 > 상극알람 > 등록&수정
	$apiCode=$_POST["apiCode"];
	$language=$_POST["language"];
	$dm_seq=$_POST["seq"];

	if($apiCode!="dismediupdate"){$json["resultMessage"]="API(apiCode) ERROR";$apiCode="dismediupdate";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="API(language) ERROR";}
	///else if($dm_code==""){$json["resultMessage"]="API(dmCode) ERROR";}
	else
	{
		$dm_code=$_POST["dmCode"];
		$dm_group=$_POST["dmGroup"];
		$dm_medicine=$_POST["dmMedicine"];
		$dm_notice_kor=$_POST["dmNoticeKor"];
		$dm_notice_chn=$_POST["dmNoticeChn"];
		$dm_desc_kor=$_POST["dmDescKor"];
		$dm_desc_chn=$_POST["dmDescChn"];

		if($dm_medicine)
		{
			$dm_desc_eng=getmedititle($dm_medicine);  ///약재 text명
		}

		if($dm_seq)
		{
			$sql=" update ".$dbH."_medi_dismatch set dm_code='".$dm_code."',dm_desc_eng='".$dm_desc_eng."', dm_group='".$dm_group."', dm_medicine ='".$dm_medicine."', dm_notice_kor ='".$dm_notice_kor."', dm_notice_chn ='".$dm_notice_chn."',dm_desc_kor ='".$dm_desc_kor."',dm_desc_chn ='".$dm_desc_chn."',dm_date=sysdate where dm_seq='".$dm_seq."'";
		}
		else
		{
			$sql=" insert into ".$dbH."_medi_dismatch (dm_seq,dm_desc_eng, dm_code,dm_group,dm_medicine,dm_notice_kor,dm_notice_chn,dm_desc_kor,dm_desc_chn,dm_use, dm_date) values ((SELECT NVL(MAX(dm_seq),0)+1 FROM ".$dbH."_medi_dismatch),'".$dm_desc_eng."','".$dm_code."','".$dm_group."','".$dm_medicine."','".$dm_notice_kor."','".$dm_notice_chn."','".$dm_desc_kor."','".$dm_desc_chn."', 'Y',sysdate) ";
		}
		
			dbcommit($sql);

			$returnData=urldecode($_POST["returnData"]);
			$json=array("apiCode"=>$apiCode,"returnData"=>$returnData);
			$json["sql"]=$sql;
			$json["resultCode"]="200";
			$json["resultMessage"]="OK";		
		
	}



	///약재코드를 약재명으로 변환
	function getmedititle($medicode)
	{
		global $dbH;
		global $language;
		$medititle="";
		if($medicode)
		{
			$dm_medi=explode(",",$medicode);
			$dm_medi_len=count($dm_medi);

			for($i=0;$i<$dm_medi_len;$i++)
			{
			
				$sql=" select  mh_title_".$language." as mh_title  from ".$dbH."_medihub where mh_code ='".$dm_medi[$i]."' ";
				$res=dbqry($sql);
				while($hub=dbarr($res))
				{
					if($medititle!="")$medititle.=",";
					$medititle.=$hub["MH_TITLE"];
				}
					
			}
		}
		return $medititle;
	}
?>
