<?php  
	///약재관리 > 약재목록_디제이메디 > 약재관리 상세보기
	$apiCode=$_GET["apiCode"];
	$language=$_GET["language"];
	$md_seq=$_GET["seq"];

	if($apiCode!="medicinedesc"){$json["resultMessage"]="API(apiCode) ERROR";$apiCode="medicinedesc";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="API(language) ERROR";}
	//else if($md_seq==""){$json["resultMessage"]="API(seq) ERROR";}
	else
	{
		$hCodeList = getNewCodeTitle("mdStatus,mdWater,mdWaterchk,mdSweet,CountryCode");
		$StatusList = getCodeList($hCodeList, 'mdStatus');
		$WaterList = getCodeList($hCodeList, 'mdWater');
		$WaterchkList = getCodeList($hCodeList, 'mdWaterchk');
		$SweetList = getCodeList($hCodeList, 'mdSweet'); ///별전
		$CountryCodeList = getCodeList($hCodeList, 'CountryCode'); ///국가코드


		$MakerList = getMakerList();//제조사 리스트

		if($md_seq)
		{
			$returnData=$_GET["returnData"];
			$json=array("apiCode"=>$apiCode,"returnData"=>$returnData);

			$sql=" select ";
			$sql.=" a.md_seq,a.md_type,a.md_code,a.md_title_kor,a.md_origin_kor,a.md_maker_kor,a.md_qty,a.md_waterchk,a.md_water,a.md_water,a.md_loss ";
			$sql.=" ,a.md_price,a.md_priceA,a.md_priceB,a.md_priceC,a.md_priceD,a.md_priceE ";
			$sql.=" ,a.md_relate_kor,a.md_property_kor,a.md_stable,a.md_qty,a.md_alias_kor,a.md_feature_kor,a.md_note_kor,a.md_interact_kor,a.md_date ";
			$sql.=" ,to_char(MD_DATE,'yyyy-mm-dd') as MDDATE ";		
			$sql.=" ,to_char(a.md_desc_".$language.") as mdDesc";
			$sql.=" ,b.mh_code ,b.mh_title_kor,to_char(b.mh_ctitle_".$language.") as MHCTITLE ,to_char(b.mh_stitle_".$language.") as mhStitle ";		
			$sql.=" from ".$dbH."_medicine ";
			$sql.=" a inner join ".$dbH."_medihub b on a.md_hub=b.mh_code ";
			$sql.=" where a.md_seq='".$md_seq."'";
			$dt=dbone($sql);


			$json = array(
				"seq"=>$dt["MD_SEQ"], 
				"mhCode"=>$dt["MH_CODE"], 
				"mhTitle"=>$dt["MH_TITLE_KOR"],///본초명 
				"mhStitle"=>$dt["MHSTITLE"], ///학명
				"mhDtitle"=>$dt["MHDTITLE"],///이명
				"mhCtitle"=>$dt["MHCTITLE"],///과명

				"mdTitle"=>$dt["MD_TITLE_KOR"],///약재명   
				"mdCode"=>$dt["MD_CODE"],///약재코드


				"mdPrice"=>$dt["MD_PRICE"],///판매가격 
				"mdPriceA"=>$dt["MD_PRICEA"],///판매가격 
				"mdPriceB"=>$dt["MD_PRICEB"],///판매가격 
				"mdPriceC"=>$dt["MD_PRICEC"],///판매가격 
				"mdPriceD"=>$dt["MD_PRICED"],///판매가격 
				"mdPriceE"=>$dt["MD_PRICEE"],///판매가격 

				"mdWater"=>$dt["MD_WATER"],///흡수율
				"mdLoss"=>$dt["MD_LOSS"],///로스율
				"mdOrigin"=>$dt["MD_ORIGIN_KOR"],///원산지
				"mdMaker"=>$dt["MD_MAKER_KOR"], ///제조자
				"mdRelate"=>$dt["MD_RELATE_KOR"],///연관어
				"mdProperty"=>$dt["MD_PROPERTY_KOR"], ///법제
				"mdStable"=>$dt["MD_STABLE"],///적정수량 
				"mdQty"=>$dt["MD_QTY"], ///재고수량
				"mdAlias"=>$dt["MD_ALIAS_KOR"],///별칭
				"mdDesc"=>$dt["MDDESC"],///내용

				"mdFeature"=>$dt["MD_FEATURE_KOR"],///기미특징
				"mdNote"=>$dt["MD_NOTE_KOR"], ///참고사항
				"mdInteract"=>$dt["MD_INTERACT_KOR"],///상호작용
				"mdDate"=>$dt["MDDATE"],///등록일
			
				"mdType"=>$dt["MD_TYPE"],///별전				

				"mhState"=>$mhState,///성
				"mhTaste"=>$mhTaste, ///미
				"mhObject"=>$mhObject, ///귀경
				"mhFeature"=>$mhFeature,///사상
				//"mhPoison"=>$dt["mh_poison".$language], 			
				
				"mdStatus"=>$dt["MD_STATUS"], 
				
				
				"mdWatercode"=>$dt["MD_WATERCODE"],///약재흡수율코드
				"mdWaterchk"=>$dt["MD_WATERCHK"],///약재흡수율예외처리
 
				"MakerList"=>$MakerList,///제조사 리스트
				"CountryCodeList"=>$CountryCodeList,///국가코드
				"WaterList"=>$WaterList,///흡수율 리스트
				"SweetList"=>$SweetList,//별전
				"WaterchkList"=>$WaterchkList,///약재흡수율예외처리 리스트
				"StatusList"=>$StatusList///약재상태 리스트
			);

			$sql2=" select af_seq, af_name, af_url as afUrl from ".$dbH."_file where af_use='Y' and af_code='medihub' and af_fcode='".$dt["MH_CODE"]."' order by af_no desc ";
			$res=dbqry($sql2);
			$json["afFiles"]=array();
			for($i=0;$dt=dbarr($res);$i++)
			{
				$afFile=getafFile($dt["AFURL"]);
				$afThumbUrl=getafThumbUrl($dt["AFURL"]);

				$addarray=array(
					"afseq"=>$dt["AF_SEQ"], 
					"afCode"=>$dt["AF_CODE"], 
					"afUrl"=>$afFile, 
					"afName"=>$dt["AF_NAME"], 
					"afSize"=>$dt["AF_SIZE"]
					);
				array_push($json["afFiles"], $addarray);
			}
		}
		else
		{	
			$json = array(		
			"mdWater"=>60,///흡수율(처음 디폴트된 약재흡수율코드가 뿌리류여서 그에 해당하는 흡수율60을 보냄)
			"MakerList"=>$MakerList,///국가코드
			"CountryCodeList"=>$CountryCodeList,///국가코드
			"WaterList"=>$WaterList,///흡수율 리스트	
			"WaterchkList"=>$WaterchkList,///약재흡수율예외처리 리스트
			"SweetList"=>$SweetList,
			"StatusList"=>$StatusList///약재상태 리스트
			);		
		}

		$json["sql"]=$sql;
		$json["sql2"]=$sql2;
		$json["apiCode"]=$apiCode;
		$json["resultCode"]="200";
		$json["resultMessage"]="OK";
	}

	///제조사 리스트 가지고 오기
	function getMakerList()
	{
		global $language;
		global $dbH; 

		$wsql=" where cd_use = 'Y' ";
		$sql=" select cd_type, cd_name_kor from ".$dbH."_maker $wsql order by cd_type ";

		$res=dbqry($sql);
		$list = array();
		while($dt=dbarr($res))
		{
			$addarray = array(
				"cdCode"=>$dt["CD_TYPE"],
				"cdName"=>$dt["CD_NAME_KOR"]		
				);

			array_push($list, $addarray);
		}

		return $list;
	}

?>