<?php  
	///약재관리 > 본초관리 > 본초관리 상세
	$apiCode=$_GET["apiCode"];
	$language=$_GET["language"];
	$mh_seq=$_GET["seq"];
	$page=$_GET["page"];

	if($apiCode!="hubdesc"){$json["resultMessage"]="API(apiCode) ERROR";$apiCode="hubdesc";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="API(language) ERROR";}
	else
	{
		$mcCode=$_GET["mcCode"];

		$hCodeList = getNewCodeTitle("mhState,mhTaste,mhObject,mhFeature,mhPoison,mdStatus");
		$stateList = getCodeList($hCodeList, 'mhState');
		$tasteList = getCodeList($hCodeList, 'mhTaste');
		$objectList = getCodeList($hCodeList, 'mhObject');
		$featureList = getCodeList($hCodeList, 'mhFeature');
		$poisonList = getCodeList($hCodeList, 'mhPoison');
		$StatusList = getCodeList($hCodeList, 'mdStatus');

		$mCateList = getMediCate(''); ///분류1 리스트를 뽑아오기 위해 code값을 null값을 보냄


		if($mh_seq)
		{
			$sql=" SELECT ";
			$sql.=" MH_SEQ,MH_CODE, MH_TITLE_KOR,TO_CHAR(MH_TITLE_CHN) AS MHTITLECHN ,MH_CATEGORY1,MH_CATEGORY2,TO_CHAR(MH_STITLE_KOR) AS MHSTITLEKOR "; 
			$sql.=" ,TO_CHAR(MH_STITLE_CHN) AS MHSTITLECHN,TO_CHAR(MH_DTITLE_KOR) AS MHDTITLEKOR ,TO_CHAR(MH_DTITLE_CHN) AS MHDTITLECHN ";
			$sql.=" ,TO_CHAR(MH_CTITLE_KOR) AS MHCTITLEKOR";
			$sql.=" ,TO_CHAR(MH_CTITLE_CHN) AS MHCTITLECHN,MH_STATE,MH_TASTE,MH_OBJECT,MH_POISON,TO_CHAR(MH_DESC_KOR) AS MHDESCKOR ,TO_CHAR(MH_DESC_CHN) AS MHDESCCHN ";
			$sql.=" ,TO_CHAR(MH_CAUTION_KOR) AS MHCAUTIONKOR,TO_CHAR(MH_CAUTION_CHN) AS MHCAUTIONCHN ";
			$sql.=" ,TO_CHAR(MH_USAGE_KOR) AS MHUSAGEKOR ,TO_CHAR(MH_USAGE_CHN) AS MHUSAGECHN ";
			$sql.=" ,TO_CHAR(MH_USAGE_KOR) AS MHUSAGEKOR,TO_CHAR(MH_USAGE_CHN) AS MHUSAGECHN"; 
			$sql.=" ,TO_CHAR(MH_EFFICACY_KOR) AS MHEFFICACYKOR,TO_CHAR(MH_EFFICACY_KOR) AS MHEFFICACYKOR  "; 
			$sql.=" FROM ".$dbH."_MEDIHUB  WHERE MH_SEQ='".$mh_seq."'";
			$dt=dbone($sql);

			$cCode = $dt["MH_CATEGORY1"];  
			$mCate2List = getMediCate($cCode); ///분류1의 값을 보낸다. 분류 2값을 뽑아오기위해

			$mhCate = intval(substr($dt["MH_CATEGORY2"],2,4));  ///DB내용이 카테고리가 text인경우 0 으로 출력됨(intval)

			$json=array(
				"seq"=>$dt["MH_SEQ"], 
				"mhCode"=>$dt["MH_CODE"], ///본초 약제코드
				"mhTitlekor"=>$dt["MH_TITLE_KOR"],///본초명 
				"mhTitlechn"=>$dt["MHTITLECHN"],///본초명 
				"mhStitlekor"=>$dt["MHSTITLEKOR"], ///학명
				"mhStitlechn"=>$dt["MHSTITLECHN"], ///학명
				"mhDtitlekor"=>$dt["MHDTITLEKOR"], ///이명
				"mhDtitlechn"=>$dt["MHDTITLECHN"], ///이명
				"mhCtitlekor"=>$dt["MHCTITLEKOR"], ///과명	
				"mhCtitlechn"=>$dt["MHCTITLECHN"], ///과명

				"mhCategory1"=>$cCode, ///본초 1차분류
				"mhCategory2"=>$mhCate, ///본초 2차분류
				"mhState"=>$dt["MH_STATE"], ///성
				"mhTaste"=>$dt["MH_TASTE"], ///미
				"mhObject"=>$dt["MH_OBJECT"],///귀경

				"mhPoison"=>$dt["MH_POISON"], ///중독

				"mhDesckor"=>$dt["MHDESCKOR"], ///본초 설명
				"mhDescchn"=>$dt["MHDESCCHN"], ///본초 설명
				"mhCautionkor"=>$dt["MHCAUTIONKOR"], ///주의사항
				"mhCautionchn"=>$dt["MHCAUTIONCHN"], ///주의사항
				"mhUsagekor"=>$dt["MHUSAGEKOR"], ///법제
				"mhUsagechn"=>$dt["MHUSAGECHN"], ///법제
				"mhEfficacykor"=>$dt["MHEFFICACYKOR"], ///효능효과
				"mhEfficacychn"=>$dt["MHEFFICACYKOR"], ///효능효과

				"mCateList"=>$mCateList, ///분류 1 
				"mCate2List"=>$mCate2List, ///분류2 		

				"stateList"=>$stateList, ///본초 성(性)리스트 
				"tasteList"=>$tasteList, ///본초 미(味)리스트
				"objectList"=>$objectList, ///본초 귀경(歸經)리스트
				"featureList"=>$featureList, ///본초 사상(四象)리스트
				"poisonList"=>$poisonList, ///본초 중독 리스트	
				
				"StatusList"=>$StatusList ///약재상태 리스트
	
				);

	///약재목록 api 추가 리스트 -약재명, 원산지/제조사

			$sql2=" select af_seq, af_name, af_url as AFURL from ".$dbH."_file where af_use='Y' and af_code='medihub' and af_fcode='".$dt["MH_CODE"]."' order by af_no desc ";
			$res=dbqry($sql2);

			$json["afFiles"]=array();
			for($i=0;$dt=dbarr($res);$i++)
			{
				$afFile=getafFile($dt["AFURL"]);
				$afThumbUrl=getafThumbUrl($dt["AFURL"]);

				$addarray=array(
					"afseq"=>$dt["AF_SEQ"], 
					"afCode"=>$dt["AF_CODE"], 
					"afThumbUrl"=>$afThumbUrl, 
					"afUrl"=>$afFile, 
					"afName"=>$dt["AF_NAME"], 
					"afSize"=>$dt["AF_SIZE"]
					);
				array_push($json["afFiles"], $addarray);
			}
		}
		else
		{
			$mCate2List = getMediCate('');  ///seq가 없을때 분류1 리스트를 뽑아오기 위해 code값을 null값을 보냄 

			///관리자에서 본초관리 > 본초등록시 보여지는 리스트들(체크박스)
			$json = array(		
			"stateList"=>$stateList, ///본초 성(性)리스트 
			"tasteList"=>$tasteList, ///본초 미(味)리스트
			"objectList"=>$objectList, ///본초 귀경(歸經)리스트
			"featureList"=>$featureList, ///본초 사상(四象)리스트
			"poisonList"=>$poisonList, ///본초 중독 리스트	
			
			"mCateList"=>$mCateList, ///분류 1 
			"mCate2List"=>$mCate2List, ///분류2 

			"StatusList"=>$StatusList ///약재상태 리스트
			);
		}
	
		$json["sql"]=$sql;
		$json["apiCode"]=$apiCode;
		$json["resultCode"]="200";
		$json["resultMessage"]="OK";
	}
?>