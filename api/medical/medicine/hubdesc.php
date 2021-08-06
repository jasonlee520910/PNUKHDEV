<?php  
	///본초관리 리스트
	$apiCode=$_GET["apiCode"];
	$language=$_GET["language"];
	$mh_seq=$_GET["seq"];
	

	if($apiCode!="hubdesc"){$json["resultMessage"]="API코드오류";$apiCode="hubdesc";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="언어코드오류";}
	///else if($mh_seq==""){$json["resultMessage"]="seq 없음";}
	else
	{
		if($mh_seq)
		{
			$jsql=" a left join han_code c  on a.mh_poison=c.cd_code and c.cd_type='mhPoison' ";
			$jsql.=" left join han_file f on a.mh_code=f.af_fcode and f.af_code='medihub' and f.af_use='Y'  ";

			$jsql=" a ";

			$wsql=" where mh_use <>'D' and mh_seq='".$mh_seq."' ";

			$sql=" select a.mh_seq,a.mh_idx,a.mh_title_kor,a.mh_title_chn,a.mh_title_eng,a.mh_origin";
			$sql.=" ,a.mh_redefinition,a.mh_beginning,a.mh_stitle_kor,a.mh_dtitle_kor,a.mh_ctitle_kor,a.mh_efficacy_kor,a.mh_caution_kor,a.mh_desc_kor";
			$sql.=" from ".$dbH."_hubdictionary $jsql $wsql  ";

			$res=dbqry($sql);

			while($dt=dbarr($res))
			{

				$json=array(

					"seq"=>$dt["MH_SEQ"], 
					///"mhCode"=>$dt["mh_code"], ///본초 약제코드
					"mhTitle"=>$dt["MH_TITLE_KOR"],///본초명 	
					"mhTitleChn"=>$dt["MH_TITLE_CHN"],///본초명 				
					"mhTitleEng"=>$dt["MH_TITLE_ENG"],///본초명 				

					"mhRedefinition"=>getClob($dt["MH_REDEFINITION"]), ///설명

					"MH_STITLE_KOR"=>getClob($dt["MH_STITLE_KOR"]), ///학명
					"mhCtitleKor"=>getClob($dt["MH_CTITLE_KOR"]), ///과명
					"mhDtitleKor"=>getClob($dt["MH_DTITLE_KOR"]), ///이명


					"mhEfficacyKor"=>getClob($dt["MH_EFFICACY_KOR"]), ///효능
					"mhDescKor"=>getClob($dt["MH_DESC_KOR"]), ///주치
					"mhCautionKor"=>getClob($dt["MH_CAUTION_KOR"]), ///금기


					

					

		
					);
			}
		}

		
		$json["sql"]=$sql;
		$json["apiCode"]=$apiCode;
		$json["resultCode"]="200";
		$json["resultMessage"]="OK";
	}
?>