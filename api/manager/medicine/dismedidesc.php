<?php  
	///약재관리 > 상극알람 > 리스트 중 상세보기
	$apiCode=$_GET["apiCode"];
	$language=$_GET["language"];
	$dm_seq=$_GET["seq"];


	if($apiCode!="dismedidesc"){$json["resultMessage"]="API(apiCode) ERROR";$apiCode="dismedidesc";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="API(language) ERROR";}
	//else if($dm_seq==""){$json["resultMessage"]="API(seq) ERROR";}
	else
	{
		if(isset($dm_seq) && $dm_seq != '') ///클릭하면 상세 출력
		{
			
			$sql=" select dm_seq ,dm_code,dm_group,dm_medicine,dm_notice_kor,dm_notice_chn,to_char(dm_desc_kor) as dmdesckor ,to_char(dm_desc_chn) as dmdescchn ";
			$sql.=" from ".$dbH."_medi_dismatch where dm_seq = '".$dm_seq."' ";
		
			$dt=dbone($sql);		

			$medititle=getmedititle($dt["DM_MEDICINE"]);

			$json=array(			
				"seq"=>$dt["DM_SEQ"], 
				"dmCode"=>$dt["DM_CODE"], 
				"dmGroup"=>$dt["DM_GROUP"], 
				"dmMedicine"=>$dt["DM_MEDICINE"], ///코드값

				"dmMeditxt"=>$medititle,  ///상극약재 코드를 한글로 변환 
	
				"dmNoticeKor"=>$dt["DM_NOTICE_KOR"],
				"dmNoticeChn"=>$dt["DM_NOTICE_CHN"],
			
				"dmDescKor"=>$dt["DMDESCKOR"], 
				"dmDescChn"=>$dt["DMDESCCHN"]
				);
		}

		$json["sql"]=$sql;
		$json["apiCode"]=$apiCode;
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
				$sql=" select  mh_title_kor as mh_title  from ".$dbH."_medihub where mh_code ='".$dm_medi[$i]."' ";
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

