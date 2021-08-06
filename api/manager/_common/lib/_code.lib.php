<?php	
	///=========================================================================
	////  20200327 (OK)
	////  함수 명     : getNewCodeTitle()
	////  함수 설명   : han_code 테이블 리스트 (select, option 에서 쓰이는 목록 )
	///=========================================================================
	function getNewCodeTitle($field)
	{
		global $language;
		global $dbH; 

		$field = str_replace(",","','",$field);

		$list = array();
		$blist=array();
		//코드가 사용이거나 odStatus(주문상태)가 아닐경우만 리스트로 뽑아오기 
		$wsql=" where cd_use <> 'D' and cd_type in ('".$field."')";
		$sql=" select ";
		$sql.=" CD_SEQ, CD_TYPE, CD_CODE, CD_SORT, CD_TYPE_".$language." as CDTYPENAME, CD_NAME_".$language." as CDNAME ";
		$sql.=" ,CD_DESC_".$language." as CDDESC ";
		$sql.=" ,CD_VALUE_".$language." as CDVALUE ";
		$sql.=" from ".$dbH."_code $wsql order by cd_type ASC, cd_sort ASC ";

		$res=dbqry($sql);
		while($dt=dbarr($res))
		{
			$addarray = array(
				"seq"=>$dt["CD_SEQ"],
				"cdType"=>$dt["CD_TYPE"], 
				"cdCode"=>trim($dt["CD_CODE"]), 
				"cdSort"=>trim($dt["CD_SORT"]), 
				"cdTypeTxt"=>trim($dt["CDTYPENAME"]), 
				"cdName"=>trim($dt["CDNAME"]), 
				"cdDesc"=>getClob($dt["CDDESC"]), 
				"cdValue"=>getClob($dt["CDVALUE"])
				);


			array_push($blist[$dt["CD_CODE"]]=$addarray);
			$list[$dt["CD_TYPE"]][]=$blist[$dt["CD_CODE"]];
		}


		return $list;

	}
	//clob data 가져오기 
	function getClob($clobdata)
	{
		if(is_object($clobdata))// protect against a NULL LOB
		{ 
			$data = $clobdata->load();
			$clobdata->free();
			return $data;
		}
		return "";
	}
	function insertClob($jsonstatus)
	{
		$CLOB_DAN=1000;
		$mt_logstaustext="";
		$tlen=mb_strlen($jsonstatus, "UTF-8");
		if($tlen>0)
		{
			$cnt=ceil($tlen/$CLOB_DAN);
			$num=0;
			$max=0;
			for($i=0;$i<$cnt;$i++)
			{
				//$max=($i+1)*$CLOB_DAN;
				$max=$CLOB_DAN;
				if($i>0)
				{
					$num=($i*$CLOB_DAN);
					$mt_logstaustext.=" || ";
					if($i==($cnt-1))
					{
						$max=$tlen;
					}
				}
				$mt_logstaustext.="TO_CLOB('".mb_substr($jsonstatus, $num, $max, 'utf-8')."')";
			}
		}
		else
		{
			$mt_logstaustext="TO_CLOB('')";
		}
		return $mt_logstaustext;
	}
	///=========================================================================
	////  20200327 (OK)
	////  함수 명     : getCodeList()
	////  함수 설명   : Code 리스트형
	////  페러미터    : $list -> getCodeTitle 함수에서 쿼리해온 리스트 데이터 
	///				  $type -> han_code 테이블에 cd_type 코드타입 값 
	///				  $data -> 뽑아올 데이터 코드값 
	///=========================================================================
	function getCodeList($list, $type)
	{
		return $list[$type];
	}
	///=========================================================================
	///  20200327 (OK)
	///  함수 명     : getConfigInfo()
	///  함수 설명   : orderdesc에서 쓰이는 han_config 
	///=========================================================================
	function getConfigInfo()
	{
		global $language;
		global $dbH; 

		//코드가 사용이거나 odStatus(주문상태)가 아닐경우만 리스트로 뽑아오기 
		$sql=" select ";
		$sql.=" CF_FTPHOST,CF_FTPPORT,CF_FTPUSER,CF_FTPPASS,CF_FTPDIR,CF_COMPANY,CF_PHONE,CF_STAFFMOBILE,CF_ZIPCODE,CF_ADDRESS,CF_MAKINGPRICEA,CF_MAKINGPRICEB,CF_MAKINGPRICEC,CF_MAKINGPRICED ";
		$sql.=",CF_MAKINGPRICEE,CF_DECOCPRICEA,CF_DECOCPRICEB,CF_DECOCPRICEC,CF_DECOCPRICED,CF_DECOCPRICEE,CF_RELEASEPRICEA,CF_RELEASEPRICEB,CF_RELEASEPRICEC,CF_RELEASEPRICED,CF_RELEASEPRICEE ";
		$sql.=",CF_PACKINGPRICE,CF_PACKINGPRICEA,CF_PACKINGPRICEB,CF_PACKINGPRICEC,CF_PACKINGPRICED,CF_PACKINGPRICEE ";
		$sql.=",CF_AFTERPRICE,CF_AFTERPRICEA,CF_AFTERPRICEB,CF_AFTERPRICEC,CF_AFTERPRICED,CF_AFTERPRICEE ";
		$sql.=",CF_FIRSTPRICE,CF_FIRSTPRICEA,CF_FIRSTPRICEB,CF_FIRSTPRICEC,CF_FIRSTPRICED,CF_FIRSTPRICEE ";
		$sql.=",CF_CHEOBPRICEA,CF_CHEOBPRICEB,CF_CHEOBPRICEC,CF_CHEOBPRICED,CF_CHEOBPRICEE";
		$sql.=",CF_ALCOHOLPRICE,CF_ALCOHOLPRICEA,CF_ALCOHOLPRICEB,CF_ALCOHOLPRICEC,CF_ALCOHOLPRICED,CF_ALCOHOLPRICEE ";
		$sql.=",CF_DISTILLATIONPRICE,CF_DISTILLATIONPRICEA,CF_DISTILLATIONPRICEB,CF_DISTILLATIONPRICEC,CF_DISTILLATIONPRICED,CF_DISTILLATIONPRICEE ";
		$sql.=",CF_DRYPRICE,CF_DRYPRICEA,CF_DRYPRICEB,CF_DRYPRICEC,CF_DRYPRICED,CF_DRYPRICEE ";
		$sql.=",CF_CHEOBBASEPRICE,CF_CHEOBBASEPRICEA,CF_CHEOBBASEPRICEB,CF_CHEOBBASEPRICEC,CF_CHEOBBASEPRICED,CF_CHEOBBASEPRICEE  ";
		$sql.=",CF_CHEOBMAKINGPRICE,CF_CHEOBMAKINGPRICEA,CF_CHEOBMAKINGPRICEB,CF_CHEOBMAKINGPRICEC,CF_CHEOBMAKINGPRICED,CF_CHEOBMAKINGPRICEE  ";
		$sql.=",CF_SANBASEPRICE,CF_SANBASEPRICEA,CF_SANBASEPRICEB,CF_SANBASEPRICEC,CF_SANBASEPRICED,CF_SANBASEPRICEE  ";
		$sql.=",CF_SANMILLINGPRICE,CF_SANMILLINGPRICEA,CF_SANMILLINGPRICEB,CF_SANMILLINGPRICEC,CF_SANMILLINGPRICED,CF_SANMILLINGPRICEE ";
		$sql.=",CF_SANRELEASEPRICE,CF_SANRELEASEPRICEA,CF_SANRELEASEPRICEB,CF_SANRELEASEPRICEC,CF_SANRELEASEPRICED,CF_SANRELEASEPRICEE ";
		$sql.=" from ".$dbH."_config ";
		$dt=dbone($sql);

		$json=array(
			"ftpHost"=>$dt["CF_FTPHOST"], 
			"ftpPort"=>$dt["CF_FTPPORT"], 
			"ftpUser"=>$dt["CF_FTPUSER"], 
			"ftpPass"=>$dt["CF_FTPPASS"], 
			"ftpDir"=>$dt["CF_FTPDIR"],

			"cfCompany"=>$dt["CF_COMPANY"],
			"cfPhone"=>$dt["CF_PHONE"],
			"cfStaffmobile"=>$dt["CF_STAFFMOBILE"],
			"cfZipcode"=>$dt["CF_ZIPCODE"],
			"cfAddress"=>$dt["CF_ADDRESS"],
				
			"cfMakingpriceA"=>$dt["CF_MAKINGPRICEA"],//조제비A
			"cfMakingpriceB"=>$dt["CF_MAKINGPRICEB"],//조제비B
			"cfMakingpriceC"=>$dt["CF_MAKINGPRICEC"],//조제비C
			"cfMakingpriceD"=>$dt["CF_MAKINGPRICED"],//조제비D
			"cfMakingpriceE"=>$dt["CF_MAKINGPRICEE"],//조제비E

			"cfDecocpriceA"=>$dt["CF_DECOCPRICEA"],//탕전비A
			"cfDecocpriceB"=>$dt["CF_DECOCPRICEB"],//탕전비B
			"cfDecocpriceC"=>$dt["CF_DECOCPRICEC"],//탕전비C
			"cfDecocpriceD"=>$dt["CF_DECOCPRICED"],//탕전비D
			"cfDecocpriceE"=>$dt["CF_DECOCPRICEE"],//탕전비E

			"cfReleasepriceA"=>$dt["CF_RELEASEPRICEA"],//배송비A
			"cfReleasepriceB"=>$dt["CF_RELEASEPRICEB"],//배송비B
			"cfReleasepriceC"=>$dt["CF_RELEASEPRICEC"],//배송비C
			"cfReleasepriceD"=>$dt["CF_RELEASEPRICED"],//배송비D
			"cfReleasepriceE"=>$dt["CF_RELEASEPRICEE"],//배송비E

			"cfFirstprice"=>$dt["CF_FIRSTPRICE"],//선전비
			"cfFirstpriceA"=>$dt["CF_FIRSTPRICEA"],
			"cfFirstpriceB"=>$dt["CF_FIRSTPRICEB"],
			"cfFirstpriceC"=>$dt["CF_FIRSTPRICEC"],
			"cfFirstpriceD"=>$dt["CF_FIRSTPRICED"],
			"cfFirstpriceE"=>$dt["CF_FIRSTPRICEE"],

			"cfAfterprice"=>$dt["CF_AFTERPRICE"],//후하비 
			"cfAfterpriceA"=>$dt["CF_AFTERPRICEA"],
			"cfAfterpriceB"=>$dt["CF_AFTERPRICEB"],
			"cfAfterpriceC"=>$dt["CF_AFTERPRICEC"],
			"cfAfterpriceD"=>$dt["CF_AFTERPRICED"],
			"cfAfterpriceE"=>$dt["CF_AFTERPRICEE"],

			"cfPackingprice"=>$dt["CF_PACKINGPRICE"],//포장비 
			"cfPackingpriceA"=>$dt["CF_PACKINGPRICEA"],
			"cfPackingpriceB"=>$dt["CF_PACKINGPRICEB"],
			"cfPackingpriceC"=>$dt["CF_PACKINGPRICEC"],
			"cfPackingpriceD"=>$dt["CF_PACKINGPRICED"],
			"cfPackingpriceE"=>$dt["CF_PACKINGPRICEE"],

			"cfCheobprice"=>$dt["CF_CHEOBPRICE"],//첩약배송비 
			"cfCheobpriceA"=>$dt["CF_CHEOBPRICEA"],
			"cfCheobpriceB"=>$dt["CF_CHEOBPRICEB"],
			"cfCheobpriceC"=>$dt["CF_CHEOBPRICEC"],
			"cfCheobpriceD"=>$dt["CF_CHEOBPRICED"],
			"cfCheobpriceE"=>$dt["CF_CHEOBPRICEE"],

			"cfAlcoholprice"=>$dt["CF_ALCOHOLPRICE"],//주수상반 
			"cfAlcoholpriceA"=>$dt["CF_ALCOHOLPRICEA"],
			"cfAlcoholpriceB"=>$dt["CF_ALCOHOLPRICEB"],
			"cfAlcoholpriceC"=>$dt["CF_ALCOHOLPRICEC"],
			"cfAlcoholpriceD"=>$dt["CF_ALCOHOLPRICED"],
			"cfAlcoholpriceE"=>$dt["CF_ALCOHOLPRICEE"],

			"cfDistillationprice"=>$dt["CF_DISTILLATIONPRICE"],//증류탕전 
			"cfDistillationpriceA"=>$dt["CF_DISTILLATIONPRICEA"],
			"cfDistillationpriceB"=>$dt["CF_DISTILLATIONPRICEB"],
			"cfDistillationpriceC"=>$dt["CF_DISTILLATIONPRICEC"],
			"cfDistillationpriceD"=>$dt["CF_DISTILLATIONPRICED"],
			"cfDistillationpriceE"=>$dt["CF_DISTILLATIONPRICEE"],

			"cfDryprice"=>$dt["CF_DRYPRICE"],//건조탕전  
			"cfDrypriceA"=>$dt["CF_DRYPRICEA"],
			"cfDrypriceB"=>$dt["CF_DRYPRICEB"],
			"cfDrypriceC"=>$dt["CF_DRYPRICEC"],
			"cfDrypriceD"=>$dt["CF_DRYPRICED"],
			"cfDrypriceE"=>$dt["CF_DRYPRICEE"],

			//첩제기본비
			"cfCheobbaseprice"=>$dt["CF_CHEOBBASEPRICE"],
			"cfCheobbasepriceA"=>$dt["CF_CHEOBBASEPRICEA"],
			"cfCheobbasepriceB"=>$dt["CF_CHEOBBASEPRICEB"],
			"cfCheobbasepriceC"=>$dt["CF_CHEOBBASEPRICEC"],
			"cfCheobbasepriceD"=>$dt["CF_CHEOBBASEPRICED"],
			"cfCheobbasepriceE"=>$dt["CF_CHEOBBASEPRICEE"],
			//첩제조제비
			"cfCheobmakingprice"=>$dt["CF_CHEOBMAKINGPRICE"],
			"cfCheobmakingpriceA"=>$dt["CF_CHEOBMAKINGPRICEA"],
			"cfCheobmakingpriceB"=>$dt["CF_CHEOBMAKINGPRICEB"],
			"cfCheobmakingpriceC"=>$dt["CF_CHEOBMAKINGPRICEC"],
			"cfCheobmakingpriceD"=>$dt["CF_CHEOBMAKINGPRICED"],
			"cfCheobmakingpriceE"=>$dt["CF_CHEOBMAKINGPRICEE"],

			//산제기본비
			"cfSanbaseprice"=>$dt["CF_SANBASEPRICE"],
			"cfSanbasepriceA"=>$dt["CF_SANBASEPRICEA"],
			"cfSanbasepriceB"=>$dt["CF_SANBASEPRICEB"],
			"cfSanbasepriceC"=>$dt["CF_SANBASEPRICEC"],
			"cfSanbasepriceD"=>$dt["CF_SANBASEPRICED"],
			"cfSanbasepriceE"=>$dt["CF_SANBASEPRICEE"],
			//산제제분비
			"cfSanmillingprice"=>$dt["CF_SANMILLINGPRICE"],
			"cfSanmillingpriceA"=>$dt["CF_SANMILLINGPRICEA"],
			"cfSanmillingpriceB"=>$dt["CF_SANMILLINGPRICEB"],
			"cfSanmillingpriceC"=>$dt["CF_SANMILLINGPRICEC"],
			"cfSanmillingpriceD"=>$dt["CF_SANMILLINGPRICED"],
			"cfSanmillingpriceE"=>$dt["CF_SANMILLINGPRICEE"],
			//산제배송비 
			"cfSanreleaseprice"=>$dt["CF_SANRELEASEPRICE"],
			"cfSanreleasepriceA"=>$dt["CF_SANRELEASEPRICEA"],
			"cfSanreleasepriceB"=>$dt["CF_SANRELEASEPRICEB"],
			"cfSanreleasepriceC"=>$dt["CF_SANRELEASEPRICEC"],
			"cfSanreleasepriceD"=>$dt["CF_SANRELEASEPRICED"],
			"cfSanreleasepriceE"=>$dt["CF_SANRELEASEPRICEE"]

			);

		return $json;

	}
	///=========================================================================
	///  20200327 (OK)
	///  함수 명     : getDecoCodeTitle()
	///  함수 설명   : han_txtdata 선전,일반,후하 리스트 
	///=========================================================================
	function getDecoCodeTitle($state='3')
	{
		global $language;
		global $dbH; 		

		if($state=='all')
		{
			$sql=" select td_code, td_name_".$language." as TD_NAME from ".$dbH."_txtdata where td_code in ('infirst','inmain','inafter','inlast') order by decode(td_code, 'infirst','1','inmain','2','inafter','3','inlast','4')";
		}
		else
		{
			$sql=" select cd_code as TD_CODE, cd_name_".$language." as TD_NAME from ".$dbH."_code where cd_type='dcType' and cd_code in ('infirst','inmain','inafter') order by decode(cd_code, 'infirst','1','inmain','2','inafter','3')";
		}

		$res=dbqry($sql);
		$list = array();

		for($m=0;$dt=dbarr($res);$m++)
		{
			$decocarr=array("cdCode"=>$dt["TD_CODE"], "cdName"=>$dt["TD_NAME"]);
			array_push($list, $decocarr);
		}			


		return $list;
	}
	///=========================================================================
	///  20200327 (OK)
	///  함수 명     : getDoctor()
	///  함수 설명   : 로그인한 한의원의 의사 리스트 
	///=========================================================================
	function getDoctor($medicalId)
	{
		global $language;
		global $dbH;

		$wsql="  where me_use <>'D' and me_company='".$medicalId."' ";
		$ssql=" LISTAGG(CONCAT(CONCAT(me_name, '|'), me_userid),'\n') as mi_doctor ";
		$sql=" select $ssql from ".$dbH."_member $wsql ";

		$dt=dbone($sql);
		$list = array();

		if($dt["MI_DOCTOR"]!="")
		{
			$arr=explode("\n",$dt["MI_DOCTOR"]);
			foreach($arr as $val)
			{
				$arr2=explode("|",$val);
				$addarray=array("doctorName"=>$arr2[0], "doctorNo"=>$arr2[1]);
				array_push($list, $addarray);
			}
		}
		return $list;
	}
	//복용지시, 조제지시 
	function getMemberDocx($type)
	{
		global $language;
		global $dbH; 
		$list=array();

		$sql=" select a.MD_SEQ, a.MD_TYPE, a.MD_TITLE, a.MD_CONTENTS, b.AF_NAME, b.AF_URL,b.AF_SIZE    
				from han_member_docx   a  
				left join han_file b on b.AF_SEQ=a.MD_FILEIDX and b.AF_USE='Y' 
				where  a.MD_USE<>'D' and a.MD_TYPE='".$type."'   
				order by a.MD_DATE desc ";

		$res=dbqry($sql);
		
		while($dt=dbarr($res))
		{
			$addarray=array(
				"mdSeq"=>$dt["MD_SEQ"], 
				"mdType"=>$dt["MD_TYPE"],//복용인지, 조제인지 
				"mdTitle"=>$dt["MD_TITLE"], //제목
				"mdContents"=>getClob($dt["MD_CONTENTS"]), //내용 
				"afName"=>$dt["AF_NAME"], //파일이름
				"afUrl"=>getafFile($dt["AF_URL"]),
				"afThumbUrl"=>getafFile($dt["AF_URL"]),
				"afSize"=>$dt["AF_SIZE"] //사이즈 
			);
			array_push($list, $addarray);
		}

		return $list;
	}
	//감미제 
	function getSugar()
	{
		global $language;
		global $dbH; 

		$sql=" select a.md_code, a.md_title_kor as mdTitle, a.MD_PRICEA,a.MD_PRICEB,a.MD_PRICEC,a.MD_PRICED,a.MD_PRICEE
				from han_medicine a  
				inner join han_medicine_djmedi b on b.md_code=a.md_code and b.MM_USE<>'D'   
				where a.md_type ='sugar' and a.md_use<>'D'  
				order by md_code asc "; //감미제 
		$res=dbqry($sql);
		$list=array();
		$len=$capa=0;
		$dan="";
		while($dt=dbarr($res))
		{
			$dan="bx";
			$capa=preg_replace("/[^0-9]*/s", "",$dt["MDTITLE"]);//숫자만 추출 

			$medicine=array(
				"mdCode"=>$dt["MD_CODE"], 
				"mdTitle"=>$dt["MDTITLE"],
				"mdPriceA"=>$dt["MD_PRICEA"],
				"mdPriceB"=>$dt["MD_PRICEB"],
				"mdPriceC"=>$dt["MD_PRICEC"],
				"mdPriceD"=>$dt["MD_PRICED"],
				"mdPriceE"=>$dt["MD_PRICEE"],
				"mdCapa"=>$capa,
				"mdDan"=>$dan
				);
			array_push($list, $medicine);
		}
		return $list;
	}
	//특수탕전 
	function getSpecial()
	{
		global $language;
		global $dbH; 

		//코드가 사용이거나 odStatus(주문상태)가 아닐경우만 리스트로 뽑아오기 
		$wsql=" where cd_use <> 'D' and cd_type='dcSpecial' ";
		$sql=" select ";
		$sql.=" CD_SEQ, CD_TYPE, CD_CODE, CD_SORT, CD_TYPE_".$language." as CDTYPENAME, CD_NAME_".$language." as CDNAME ";
		$sql.=" ,CD_DESC_".$language." as CDDESC ";
		$sql.=" ,CD_VALUE_".$language." as CDVALUE ";
		$sql.=" from ".$dbH."_code $wsql order by cd_type ASC, cd_sort ASC ";

		$res=dbqry($sql);
		$list = array();
		while($dt=dbarr($res))
		{
			$cdCode=$dt["CD_CODE"];
			$cdPriceA=$cdPriceB=$cdPriceC=$cdPriceD=$cdPriceE=0;

			if(chkdcSpecial($cdCode)=="alcohol")//주수상반일경우 
			{
				$msql=" select a.md_code, a.md_title_kor as mdTitle, a.MD_PRICEA,a.MD_PRICEB,a.MD_PRICEC,a.MD_PRICED,a.MD_PRICEE
						from han_medicine a  
						inner join han_medicine_djmedi b on b.md_code=a.md_code and b.MM_USE<>'D'   
						where a.md_type ='alcohol' and a.md_use<>'D'  
						order by md_code asc "; //알콜  
				$mdt=dbone($msql);

				$cdPriceA=($mdt["MD_PRICEA"])?$mdt["MD_PRICEA"]:0;
				$cdPriceB=($mdt["MD_PRICEB"])?$mdt["MD_PRICEB"]:0;
				$cdPriceC=($mdt["MD_PRICEC"])?$mdt["MD_PRICEC"]:0;
				$cdPriceD=($mdt["MD_PRICED"])?$mdt["MD_PRICED"]:0;
				$cdPriceE=($mdt["MD_PRICEE"])?$mdt["MD_PRICEE"]:0;
			}
			else if(chkdcSpecial($cdCode)=="distillation")//증류탕전
			{
				$csql=" select ";
				$csql.=" CF_DISTILLATIONPRICE,CF_DISTILLATIONPRICEA,CF_DISTILLATIONPRICEB,CF_DISTILLATIONPRICEC,CF_DISTILLATIONPRICED,CF_DISTILLATIONPRICEE ";
				$csql.=" from ".$dbH."_config ";
				$cdt=dbone($csql);
				$cdPriceA=$cdt["CF_DISTILLATIONPRICEA"];
				$cdPriceB=$cdt["CF_DISTILLATIONPRICEB"];
				$cdPriceC=$cdt["CF_DISTILLATIONPRICEC"];
				$cdPriceD=$cdt["CF_DISTILLATIONPRICED"];
				$cdPriceE=$cdt["CF_DISTILLATIONPRICEE"];
			}
			else if(chkdcSpecial($cdCode)=="dry")//건조탕전 
			{
				$csql=" select ";
				$csql.=" CF_DRYPRICE,CF_DRYPRICEA,CF_DRYPRICEB,CF_DRYPRICEC,CF_DRYPRICED,CF_DRYPRICEE ";
				$csql.=" from ".$dbH."_config ";
				$cdt=dbone($csql);

				$cdPriceA=$cdt["CF_DRYPRICEA"];
				$cdPriceB=$cdt["CF_DRYPRICEB"];
				$cdPriceC=$cdt["CF_DRYPRICEC"];
				$cdPriceD=$cdt["CF_DRYPRICED"];
				$cdPriceE=$cdt["CF_DRYPRICEE"];
			}

			$addarray = array(
				"seq"=>$dt["CD_SEQ"],
				"cdType"=>$dt["CD_TYPE"], 
				"cdCode"=>$dt["CD_CODE"], 
				"cdSort"=>$dt["CD_SORT"], 
				"cdTypeTxt"=>$dt["CDTYPENAME"], 
				"cdName"=>$dt["CDNAME"], 
				"cdPriceA"=>$cdPriceA,
				"cdPriceB"=>$cdPriceB,
				"cdPriceC"=>$cdPriceC,
				"cdPriceD"=>$cdPriceD,
				"cdPriceE"=>$cdPriceE,
				"cdDesc"=>getClob($dt["CDDESC"]), 
				"cdValue"=>getClob($dt["CDVALUE"])
				);

			array_push($list, $addarray);
		}
		return $list;
	}
	///=========================================================================
	///20200331(OK)
	///  함수 명     : getMediCate()
	///  함수 설명   : 본초관리에서 분류1과 분류2 리스트 
	///=========================================================================
	function getMediCate($code)
	{
		global $language;
		global $dbH;

		if($code) //분류 1 값이 있을때
		{
			$sql=" select ";
			$sql.=" a.mc_code02, a.mc_title02_kor, a.mc_title02_chn ";
			$sql.=" from han_medicate  a ";
			$sql.=" where a.mc_use <>'D' and a.mc_code01 = '".$code."' ";
			$sql.=" order by a.mc_code02 ";
		}
		else
		{
			$sql=" select ";
			$sql.=" a.mc_code01,a.mc_title01_kor, a.mc_title01_chn ";
			$sql.=" from han_medicate a";
			$sql.=" where a.mc_use <>'D'   "; 
			$sql.=" group by a.mc_code01,a.mc_title01_kor, a.mc_title01_chn ";
			$sql.=" order by a.mc_code01 ";
		}

		$res=dbqry($sql);
		$list=array();

		while($dt=dbarr($res))
		{
			$addarray=array(
				"sql"=>$sql, 
				"mcCode01"=>$dt["MC_CODE01"], 
				"mcTitle01"=>$dt["MC_TITLE01_KOR"], 
				"mcCode02"=>$dt["MC_CODE02"], 
				"mcTitle02"=>$dt["MC_TITLE02_KOR"]
			);
			array_push($list, $addarray);
		}
		return $list;
	}
	
	///=========================================================================
	/// 20200331 (OK)
	/// 엑셀업로드 및 버키에서 넘어올때 약재가 없을 경우 
	///=========================================================================
	function getNewMediCode($code)
	{
		if(strpos($code, "__") !== false)//약재code에 __이 있다면 
		{
			$mdarr=explode("__",$code);
			$newmdcode=$mdarr[0];
		}
		else
		{
			$newmdcode=$code;
		}
		return $newmdcode;
	}
	function getNewExcelTitle($code)
	{
		if(strpos($code, "__") !== false)//약재code에 __이 있다면 
		{
			$mdarr=explode("__",$code);
			$title=$mdarr[1];
		}
		else
		{
			$title="";
		}
		return $title;
	}
	function getCYMediCode($code)
	{
		if(strpos($code, "_") !== false)//약재code에 _이 있다면 
		{
			$mdarr=explode("_",$code);
			$code=$mdarr[1];
		}
		else
		{
			$code="";
		}
		return $code;
	}
	function getCYMediTitle($code)
	{
		if(strpos($code, "_") !== false)//약재code에 _이 있다면 
		{
			$mdarr=explode("_",$code);
			$code=$mdarr[0];
		}
		else
		{
			$code="";
		}
		return $code;
	}
	///=========================================================================
	///  20200401(OK)
	///  함수 명     : getSweet()
	///  함수 설명   : 별전 
	///=========================================================================
	function getSweet($rc_sweet)
	{
		global $language;
		global $dbH; 
		$sql=" select ";
		$sql.=" a.md_code, b.mm_title_".$language." mmTitle, a.md_priceA, a.md_priceB,a.md_priceC, a.md_priceD,a.md_priceE, a.md_water, a.md_origin_".$language." mdOrigin ";
		$sql.=" from ".$dbH."_medicine ";
		$sql.=" a inner join ".$dbH."_medicine_djmedi b on b.md_code=a.md_code ";
		$sql.=" where a.md_type ='sweet' and (a.md_use='Y ' and b.mm_use='Y') ";
		$sql.=" order by a.md_seq asc ";

		$res=dbqry($sql);
		$list=array();

		if($rc_sweet)
		{
			$arr=explode("|",$rc_sweet);
			for($i=1;$i<count($arr);$i++)
			{
				$arr2=explode(",",$arr[$i]);
				$sweetcapa[$arr2[0]]=$arr2[1];
				$sweetprice[$arr2[0]]=$arr2[3];
			}
		}

		while($dt2=dbarr($res))
		{
			$capa = ($sweetcapa[$dt2["MD_CODE"]]) ? $sweetcapa[$dt2["MD_CODE"]] : 0;
			$price = ($sweetprice[$dt2["MD_CODE"]]) ? $sweetprice[$dt2["MD_CODE"]] : "";
			$medicine=array(
				"rcMedicode"=>$dt2["MD_CODE"], 
				"rcMedititle"=>$dt2["MMTITLE"],
				"rcCapa"=>$capa,
				"rcDecoctype"=>"inlast", 
				"rcOrigin"=>$dt2["MDORIGIN"],
				"rcWater"=>$dt2["MD_WATER"],
				"rcPrice"=>$price,
				"rcPriceA"=>$dt2["MD_PRICEA"],
				"rcPriceB"=>$dt2["MD_PRICEB"],
				"rcPriceC"=>$dt2["MD_PRICEC"],
				"rcPriceD"=>$dt2["MD_PRICED"],
				"rcPriceE"=>$dt2["MD_PRICEE"]
				);
			array_push($list, $medicine);
		}

		return $list;
	}
	///=========================================================================
	///  20200401(OK)
	///  함수 명     : getBoxMediinfo()
	///  함수 설명   : 한약박스의정보  
	///=========================================================================
	function getBoxMediinfo($od_keycode, $re_boxmedi, $re_boxmedivol, $re_boxmedipack)
	{
		global $language;
		global $dbH; 
		$data=array();
		if(intval($re_boxmedivol)>0 && intval($re_boxmedipack)>0)
		{
			$data["pb_medichk"]="true";
			$data["pb_code"]=$re_boxmedi;
			$data["pb_volume"]=$re_boxmedivol;
			$data["pb_maxcnt"]=$re_boxmedipack;
		}
		else
		{
			//한약박스의 정보 가져오자 
			if($re_boxmedi=="RBM200117151838")//사전조제한약박스일경우 
			{
				$bsql=" select pb_code, pb_type, pb_title, pb_volume, pb_maxcnt, pb_use from ".$dbH."_packingbox where pb_code='".$re_boxmedi."' ";
				$data["pb_medichk"]="false";
				$data["pb_code"]="RBM200117151838";
				$data["pb_title"]="사전조제한약박스";
				$data["pb_volume"]="0";
				$data["pb_maxcnt"]="0";
			}
			else
			{
				$bsql=" select pb_code, pb_type, pb_title, pb_volume, pb_maxcnt, pb_use from ".$dbH."_packingbox where pb_code='".$re_boxmedi."' and pb_use <>'D'  ";
			
				$bdt=dbone($bsql);
				if($bdt["PB_CODE"])
				{
					$data["bsql"]=$bsql;
					$data["pb_code"]=$bdt["PB_CODE"];
					$data["pb_title"]=$bdt["PB_TITLE"];
					$data["pb_volume"]=$bdt["PB_VOLUME"];
					$data["pb_maxcnt"]=$bdt["PB_MAXCNT"];

					if(intval($bdt["PB_VOLUME"])>0 && intval($bdt["PB_MAXCNT"])>0)
					{
						if($od_keycode)
						{
							$data["pb_medichk"]="true";

							$rbsql=" update ".$dbH."_release ";
							$rbsql.=" set re_boxmedivol='".$bdt["PB_VOLUME"]."', re_boxmedipack='".$bdt["PB_MAXCNT"]."', re_boxmedibox='".$bdt["PB_MAXCNT"]."' where re_keycode='".$od_keycode."' ";
							dbqry($rbsql);
						}
						else
						{
							$data["pb_medichk"]="false";
						}
					}
					else
					{
						$data["pb_medichk"]="false";
					}
				}
				else
				{
					$data["pb_medichk"]="false";
					$data["pb_code"]="";
					$data["pb_title"]="";
					$data["pb_volume"]="0";
					$data["pb_maxcnt"]="0";
				}
			}
		}
		return $data;
	}
	///=========================================================================
	///  20200421(OK)
	///  함수 명     : getBoxDeliinfo()
	///  함수 설명   : 배송박스의정보  
	///=========================================================================
	function getBoxDeliinfo($od_keycode, $re_boxdeli, $re_boxmedivol, $re_boxmedipack)
	{
		global $language;
		global $dbH; 
		$data=array();
		if(intval($re_boxmedivol)>0 && intval($re_boxmedipack)>0)
		{
			$data["pb_medichk"]="true";
			$data["pb_code"]=$re_boxdeli;
			$data["pb_volume"]=$re_boxmedivol;
			$data["pb_maxcnt"]=$re_boxmedipack;
		}
		else
		{
			
			$bsql=" select pb_code, pb_type, pb_title, pb_volume, pb_maxcnt, pb_use from ".$dbH."_packingbox where pb_code='".$re_boxdeli."' and pb_use <>'D'  ";
		
			$bdt=dbone($bsql);
			if($bdt["PB_CODE"])
			{
				$data["bsql"]=$bsql;
				$data["pb_code"]=$bdt["PB_CODE"];
				$data["pb_title"]=$bdt["PB_TITLE"];
				$data["pb_volume"]=$bdt["PB_VOLUME"];
				$data["pb_maxcnt"]=$bdt["PB_MAXCNT"];

				if(intval($bdt["PB_VOLUME"])>0 && intval($bdt["PB_MAXCNT"])>0)
				{
					if($od_keycode)
					{
						$data["pb_medichk"]="true";

						$rbsql=" update ".$dbH."_release ";
						$rbsql.=" set re_boxmedivol='".$bdt["PB_VOLUME"]."', re_boxmedipack='".$bdt["PB_MAXCNT"]."' where re_keycode='".$od_keycode."' ";
						dbqry($rbsql);
					}
					else
					{
						$data["pb_medichk"]="false";
					}
				}
				else
				{
					$data["pb_medichk"]="false";
				}
			}
			else
			{
				$data["pb_medichk"]="false";
				$data["pb_code"]="";
				$data["pb_title"]="";
				$data["pb_volume"]="0";
				$data["pb_maxcnt"]="0";
			}
		}
		return $data;
	}
	///=========================================================================
	///  20200401(OK)
	///  함수 명     : getDeliveryCompName()
	///  함수 설명   : 배송관련이름   
	///=========================================================================
	function getDeliveryCompName($re_deliexception, $re_delicomp)
	{
		if(strpos($re_deliexception, "D") !== false)
		{
			$reDelicomp="직배";
		}
		else
		{
			if($re_delicomp=="POST" || $re_delicomp=="post")
			{
				$reDelicomp="우체국";
			}
			else if($re_delicomp=="CJ" || $re_delicomp=="cj")
			{
				$reDelicomp="CJ";
			}
			else if($re_delicomp=="LOGEN" || $re_delicomp=="logen")
			{
				$reDelicomp="로젠";
			}
			else
			{
				$reDelicomp="없음";
			}
		}
		return $reDelicomp;
	}
	///=========================================================================
	///  20200401(OK)
	///  함수 명     : getDcTime()
	///  함수 설명   : 탕전시간 
	///=========================================================================
	function getDcTime($dc_time)
	{
		$evaporation = 400;
		$itime=intval($dc_time)/60;
		$addwater = $itime*$evaporation;
		return $addwater;
	}
	///=========================================================================
	///  20200401(OK)
	///  함수 명     : getSibdan()
	///  함수 설명   : 버림  
	///=========================================================================
	function getSibdan($amount)
	{
		return intval($amount/10)*10;
	}
	///=========================================================================
	///  20200401(OK)
	///  함수 명     : setConfigPrice()
	///  함수 설명   : 가격계산에 쓰이는  config   
	///=========================================================================
	function setConfigPrice()
	{
		global $language;
		global $dbH; 
		$csql=" select ";
		$csql.=" CF_MAKINGPRICEA,CF_MAKINGPRICEB,CF_MAKINGPRICEC,CF_MAKINGPRICED,CF_MAKINGPRICEE ";
		$csql.=" ,CF_DECOCPRICEA,CF_DECOCPRICEB,CF_DECOCPRICEC,CF_DECOCPRICED,CF_DECOCPRICEE ";
		$csql.=" ,CF_RELEASEPRICEA,CF_RELEASEPRICEB,CF_RELEASEPRICEC,CF_RELEASEPRICED,CF_RELEASEPRICEE ";
		$csql.=",CF_PACKINGPRICEA,CF_PACKINGPRICEB,CF_PACKINGPRICEC,CF_PACKINGPRICED,CF_PACKINGPRICEE ";
		$csql.=",CF_AFTERPRICEA,CF_AFTERPRICEB,CF_AFTERPRICEC,CF_AFTERPRICED,CF_AFTERPRICEE ";
		$csql.=",CF_FIRSTPRICEA,CF_FIRSTPRICEB,CF_FIRSTPRICEC,CF_FIRSTPRICED,CF_FIRSTPRICEE ";
		$csql.=",CF_CHEOBPRICEA,CF_CHEOBPRICEB,CF_CHEOBPRICEC,CF_CHEOBPRICED,CF_CHEOBPRICEE";
		$csql.=",CF_ALCOHOLPRICE,CF_ALCOHOLPRICEA,CF_ALCOHOLPRICEB,CF_ALCOHOLPRICEC,CF_ALCOHOLPRICED,CF_ALCOHOLPRICEE ";
		$csql.=",CF_DISTILLATIONPRICE,CF_DISTILLATIONPRICEA,CF_DISTILLATIONPRICEB,CF_DISTILLATIONPRICEC,CF_DISTILLATIONPRICED,CF_DISTILLATIONPRICEE ";
		$csql.=",CF_DRYPRICE,CF_DRYPRICEA,CF_DRYPRICEB,CF_DRYPRICEC,CF_DRYPRICED,CF_DRYPRICEE ";
		$csql.=",CF_CHEOBBASEPRICE,CF_CHEOBBASEPRICEA,CF_CHEOBBASEPRICEB,CF_CHEOBBASEPRICEC,CF_CHEOBBASEPRICED,CF_CHEOBBASEPRICEE  ";
		$csql.=",CF_CHEOBMAKINGPRICE,CF_CHEOBMAKINGPRICEA,CF_CHEOBMAKINGPRICEB,CF_CHEOBMAKINGPRICEC,CF_CHEOBMAKINGPRICED,CF_CHEOBMAKINGPRICEE  ";
		$csql.=",CF_SANBASEPRICE,CF_SANBASEPRICEA,CF_SANBASEPRICEB,CF_SANBASEPRICEC,CF_SANBASEPRICED,CF_SANBASEPRICEE  ";
		$csql.=",CF_SANMILLINGPRICE,CF_SANMILLINGPRICEA,CF_SANMILLINGPRICEB,CF_SANMILLINGPRICEC,CF_SANMILLINGPRICED,CF_SANMILLINGPRICEE ";
		$csql.=",CF_SANRELEASEPRICE,CF_SANRELEASEPRICEA,CF_SANRELEASEPRICEB,CF_SANRELEASEPRICEC,CF_SANRELEASEPRICED,CF_SANRELEASEPRICEE ";
		$csql.=" from ".$dbH."_config ";
		$cdt=dbone($csql);

		$config["maPriceA"]=$cdt["CF_MAKINGPRICEA"];//조제비A
		$config["maPriceB"]=$cdt["CF_MAKINGPRICEB"];//조제비B
		$config["maPriceC"]=$cdt["CF_MAKINGPRICEC"];//조제비C
		$config["maPriceD"]=$cdt["CF_MAKINGPRICED"];//조제비D
		$config["maPriceE"]=$cdt["CF_MAKINGPRICEE"];//조제비E

		$config["dcPriceA"]=$cdt["CF_DECOCPRICEA"];//탕전비A
		$config["dcPriceB"]=$cdt["CF_DECOCPRICEB"];//탕전비B
		$config["dcPriceC"]=$cdt["CF_DECOCPRICEC"];//탕전비C
		$config["dcPriceD"]=$cdt["CF_DECOCPRICED"];//탕전비D
		$config["dcPriceE"]=$cdt["CF_DECOCPRICEE"];//탕전비E

		$config["rePriceA"]=$cdt["CF_RELEASEPRICEA"];//배송비A
		$config["rePriceB"]=$cdt["CF_RELEASEPRICEB"];//배송비B
		$config["rePriceC"]=$cdt["CF_RELEASEPRICEC"];//배송비C
		$config["rePriceD"]=$cdt["CF_RELEASEPRICED"];//배송비D
		$config["rePriceE"]=$cdt["CF_RELEASEPRICEE"];//배송비E

		$config["firstPriceA"]=$cdt["CF_FIRSTPRICEA"];//선전비
		$config["firstPriceB"]=$cdt["CF_FIRSTPRICEB"];//선전비
		$config["firstPriceC"]=$cdt["CF_FIRSTPRICEC"];//선전비
		$config["firstPriceD"]=$cdt["CF_FIRSTPRICED"];//선전비
		$config["firstPriceE"]=$cdt["CF_FIRSTPRICEE"];//선전비

		$config["afterPriceA"]=$cdt["CF_AFTERPRICEA"];//후하비
		$config["afterPriceB"]=$cdt["CF_AFTERPRICEB"];//후하비
		$config["afterPriceC"]=$cdt["CF_AFTERPRICEC"];//후하비
		$config["afterPriceD"]=$cdt["CF_AFTERPRICED"];//후하비
		$config["afterPriceE"]=$cdt["CF_AFTERPRICEE"];//후하비

		$config["packPriceA"]=$cdt["CF_PACKINGPRICEA"];//포장비
		$config["packPriceB"]=$cdt["CF_PACKINGPRICEB"];//포장비
		$config["packPriceC"]=$cdt["CF_PACKINGPRICEC"];//포장비
		$config["packPriceD"]=$cdt["CF_PACKINGPRICED"];//포장비
		$config["packPriceE"]=$cdt["CF_PACKINGPRICEE"];//포장비

		$config["cheobPriceA"]=$cdt["CF_CHEOBPRICEA"];//첩약배송비 
		$config["cheobPriceB"]=$cdt["CF_CHEOBPRICEB"];//첩약배송비 
		$config["cheobPriceC"]=$cdt["CF_CHEOBPRICEC"];//첩약배송비 
		$config["cheobPriceD"]=$cdt["CF_CHEOBPRICED"];//첩약배송비 
		$config["cheobPriceE"]=$cdt["CF_CHEOBPRICEE"];//첩약배송비 

		$config["alcoholPriceA"]=$cdt["CF_ALCOHOLPRICEA"];//주수상반 
		$config["alcoholPriceB"]=$cdt["CF_ALCOHOLPRICEB"];//주수상반 
		$config["alcoholPriceC"]=$cdt["CF_ALCOHOLPRICEC"];//주수상반 
		$config["alcoholPriceD"]=$cdt["CF_ALCOHOLPRICED"];//주수상반 
		$config["alcoholPriceE"]=$cdt["CF_ALCOHOLPRICEE"];//주수상반 


		$config["distillationPriceA"]=$cdt["CF_DISTILLATIONPRICEA"];//증류탕전 
		$config["distillationPriceB"]=$cdt["CF_DISTILLATIONPRICEB"];//증류탕전 
		$config["distillationPriceC"]=$cdt["CF_DISTILLATIONPRICEC"];//증류탕전 
		$config["distillationPriceD"]=$cdt["CF_DISTILLATIONPRICED"];//증류탕전 
		$config["distillationPriceE"]=$cdt["CF_DISTILLATIONPRICEE"];//증류탕전 

		$config["drypriceA"]=$cdt["CF_DRYPRICEA"];//건조탕전 
		$config["drypriceB"]=$cdt["CF_DRYPRICEB"];//건조탕전 
		$config["drypriceC"]=$cdt["CF_DRYPRICEC"];//건조탕전 
		$config["drypriceD"]=$cdt["CF_DRYPRICED"];//건조탕전 
		$config["drypriceE"]=$cdt["CF_DRYPRICEE"];//건조탕전 

		//첩제기본비
		$config["cheobbasePrice"]=$cdt["CF_CHEOBBASEPRICE"];
		$config["cheobbasePriceA"]=$cdt["CF_CHEOBBASEPRICEA"];
		$config["cheobbasePriceB"]=$cdt["CF_CHEOBBASEPRICEB"];
		$config["cheobbasePriceC"]=$cdt["CF_CHEOBBASEPRICEC"];
		$config["cheobbasePriceD"]=$cdt["CF_CHEOBBASEPRICED"];
		$config["cheobbasePriceE"]=$cdt["CF_CHEOBBASEPRICEE"];
		//첩제조제비
		$config["cheobmakingPrice"]=$cdt["CF_CHEOBMAKINGPRICE"];
		$config["cheobmakingPriceA"]=$cdt["CF_CHEOBMAKINGPRICEA"];
		$config["cheobmakingPriceB"]=$cdt["CF_CHEOBMAKINGPRICEB"];
		$config["cheobmakingPriceC"]=$cdt["CF_CHEOBMAKINGPRICEC"];
		$config["cheobmakingPriceD"]=$cdt["CF_CHEOBMAKINGPRICED"];
		$config["cheobmakingPriceE"]=$cdt["CF_CHEOBMAKINGPRICEE"];

		//산제기본비
		$config["sanbasePrice"]=$cdt["CF_SANBASEPRICE"];
		$config["sanbasePriceA"]=$cdt["CF_SANBASEPRICEA"];
		$config["sanbasePriceB"]=$cdt["CF_SANBASEPRICEB"];
		$config["sanbasePriceC"]=$cdt["CF_SANBASEPRICEC"];
		$config["sanbasePriceD"]=$cdt["CF_SANBASEPRICED"];
		$config["sanbasePriceE"]=$cdt["CF_SANBASEPRICEE"];
		//산제제분비
		$config["sanmillingPrice"]=$cdt["CF_SANMILLINGPRICE"];
		$config["sanmillingPriceA"]=$cdt["CF_SANMILLINGPRICEA"];
		$config["sanmillingPriceB"]=$cdt["CF_SANMILLINGPRICEB"];
		$config["sanmillingPriceC"]=$cdt["CF_SANMILLINGPRICEC"];
		$config["sanmillingPriceD"]=$cdt["CF_SANMILLINGPRICED"];
		$config["sanmillingPriceE"]=$cdt["CF_SANMILLINGPRICEE"];
		//산제배송비 
		$config["sanreleasePrice"]=$cdt["CF_SANRELEASEPRICE"];
		$config["sanreleasePriceA"]=$cdt["CF_SANRELEASEPRICEA"];
		$config["sanreleasePriceB"]=$cdt["CF_SANRELEASEPRICEB"];
		$config["sanreleasePriceC"]=$cdt["CF_SANRELEASEPRICEC"];
		$config["sanreleasePriceD"]=$cdt["CF_SANRELEASEPRICED"];
		$config["sanreleasePriceE"]=$cdt["CF_SANRELEASEPRICEE"];


		return $config;
	}
	function getConfigPrice($type, $grade)
	{
		global $config;
		$tmp=0;
		$grade=chkGrade($grade);
		switch($type)
		{
		case "making":
			$tmp = floatval($config["maPrice".$grade]);
			break;
		case "decoction":
			if(floatval($config["dcPrice".$grade]) >=0 )
			{
				$tmp = floatval($config["dcPrice".$grade]);
			}
			else
			{
				$tmp = floatval($config["dcPriceE"]);
			}
			break;
		case "release":
			$tmp = floatval($config["rePrice".$grade]);
			break;
		case "first":
			$tmp = floatval($config["firstPrice".$grade]);
			break;
		case "after":
			$tmp = floatval($config["afterPrice".$grade]);
			break;
		case "packing":
			$tmp = floatval($config["packPrice".$grade]);
			break;
		case "cheob":
			$tmp = floatval($config["cheobPrice".$grade]);
			break;
		case "alcohol"://주수상반 
			$tmp = floatval($config["alcoholPrice".$grade]);
			break;
		case "distillation"://증류탕전
			$tmp = floatval($config["distillationPrice".$grade]);
			break;
		case "dry"://건조탕전
			$tmp = floatval($config["dryPrice".$grade]);
			break;
		case "cheobbase"://첩약기본비
			$tmp = floatval($config["cheobbasePrice".$grade]);
			break;
		case "cheobmaking"://첩약조제비  
			$tmp = floatval($config["cheobmakingPrice".$grade]);
			break;

		case "sanbase"://산제기본비  
			$tmp = floatval($config["sanbasePrice".$grade]);
			break;
		case "sanmilling"://산제제분비  
			$tmp = floatval($config["sanmillingPrice".$grade]);
			break;
		case "sanrelease"://산제배송비  
			$tmp = floatval($config["sanreleasePrice".$grade]);
			break;

		}
		return $tmp;
	}
	///=========================================================================
	///  20200402(OK)
	///  함수 명     : getPackCodeTitle()
	///  함수 설명   : han_packingbox 테이블 리스트 (select, option 에서 쓰이는 목록 )
	///=========================================================================
	function getPackCodeTitle($medicalId, $codes)
	{
		global $language;
		global $dbH; 
		$djCompany="1000000000";//DJMEDI 고유회사번호 

		$list = array();

		//공통과 로그인한 한의원의 파우치,배송박스,한약박스등 
		if($medicalId)
		{
			$memberid=$medicalId;
		}
		else
		{
			$memberid=$djCompany;
		}
		
		$arr=explode(",",$codes);

		for($i=0;$i<count($arr);$i++)
		{
			$sql=" select ";
			$sql.=" pb_code, pb_type, pb_title, pb_codeonly, pb_priceA, pb_priceB,pb_priceC, pb_priceD,pb_priceE ";
			$sql.=" , pb_capa, pb_volume, pb_maxcnt, pb_member, pb_staff, to_char(pb_desc) as pbdesc ";
			$sql.=" , (select MIN(af_url) KEEP (DENSE_RANK FIRST ORDER BY af_no DESC) from ".$dbH."_file where pb_code=af_fcode and af_code='packingbox' and af_use='Y') as af_url ";
			$sql.=" from ".$dbH."_packingbox ";
			$sql.=" where pb_use ='Y' and pb_member like '%".$memberid."%' and pb_type='".$arr[$i]."'  ";
			$sql.=" group by pb_code, pb_type, pb_title, pb_codeonly, pb_priceA, pb_priceB,pb_priceC, pb_priceD,pb_priceE, pb_capa, pb_volume, pb_maxcnt, pb_member, pb_staff, to_char(pb_desc) ";
			$sql.=" order by pb_code desc ";

			$res=dbqry($sql);
			$totalCount=dbrows($sql);

			$list[$arr[$i]]=array();
			
			$list["sql"].=$sql;
			$list["totalCount"].=$totalCount;
			if(intval($totalCount) > 0)
			{
				if($arr[$i] == "reBoxdeli")
				{
					array_push($list[$arr[$i]], addReBoxDeli($djCompany));//포장박스없음
				}
				else if($arr[$i] == "odPacktype")//20200115:파우치없음추가 
				{
					//array_push($list[$arr[$i]], addOdPackType1($djCompany));//파우치없음
					//array_push($list[$arr[$i]], addOdPackType2($djCompany));//사전조제파우치
				}
				else if($arr[$i] == "reBoxmedi")
				{
					//array_push($list[$arr[$i]], addReBoxMedi($djCompany));//사전조제한약박스 
				}

				while($dt=dbarr($res))
				{				
					$afFile=getafFile($dt["AF_URL"]);
					$afThumbUrl=getafThumbUrl($dt["AF_URL"]);

					$capa=($dt["PB_TYPE"]=="reBoxmedi") ? $dt["PB_MAXCNT"]:$dt["PB_CAPA"];

					$addarray = array(
						"pbCode"=>$dt["PB_CODE"], 
						"pbType"=>$dt["PB_TYPE"], 
						"pbTitle"=>$dt["PB_TITLE"], 
						"pbCodeOnly"=>$dt["PB_CODEONLY"],
						"pbPriceA"=>($dt["PB_PRICEA"])?$dt["PB_PRICEA"]:0, 
						"pbPriceB"=>($dt["PB_PRICEB"])?$dt["PB_PRICEB"]:0,
						"pbPriceC"=>($dt["PB_PRICEC"])?$dt["PB_PRICEC"]:0,
						"pbPriceD"=>($dt["PB_PRICED"])?$dt["PB_PRICED"]:0,
						"pbPriceE"=>($dt["PB_PRICEE"])?$dt["PB_PRICEE"]:0,
						"pbVolume"=>$dt["PB_VOLUME"],
						"pbMaxcnt"=>$dt["PB_MAXCNT"],
						"pbCapa"=>$capa, 
						"pbMember"=>$dt["PB_MEMBER"], 
						"pbStaff"=>$dt["PB_STAFF"], 
						"pbDesc"=>$dt["PB_DESC"], 
						"afFilel"=>$afFile,
						"afThumbUrl"=>$afThumbUrl
					);
					array_push($list[$arr[$i]], $addarray);
				}	
			}
			else //한의원에 속한것들이 없다면 DjMedi것으로 나오게 하자 
			{
				$dsql=" select ";
				$dsql.=" pb_code, pb_type, pb_title, pb_codeonly, pb_priceA, pb_priceB,pb_priceC, pb_priceD,pb_priceE ";
				$dsql.=" , pb_capa, pb_volume, pb_maxcnt, pb_member, pb_staff, to_char(pb_desc) as pbdesc ";
				$dsql.=" , (select MIN(af_url) KEEP (DENSE_RANK FIRST ORDER BY af_no DESC) from ".$dbH."_file where pb_code=af_fcode and af_code='packingbox' and af_use='Y') as AFURL ";
				$dsql.=" from ".$dbH."_packingbox ";
				$dsql.=" where pb_use ='Y' and pb_member like '%".$djCompany."%' and pb_type='".$arr[$i]."'  ";
				$dsql.=" group by pb_code, pb_type, pb_title, pb_codeonly, pb_priceA, pb_priceB,pb_priceC, pb_priceD,pb_priceE, pb_capa, pb_volume, pb_maxcnt, pb_member, pb_staff, to_char(pb_desc) ";
				$dsql.=" order by pb_code desc ";

				$dres=dbqry($dsql);
				//$allTotalCount=dbrows($dsql);
				$list["dsql"].=$dsql;
				//$list["allTotalCount"].=$allTotalCount;

				if($arr[$i] == "reBoxdeli")
				{
					array_push($list[$arr[$i]], addReBoxDeli($djCompany));//포장박스없음
				}
				else if($arr[$i] == "odPacktype")//20200115:파우치없음추가 
				{
					//array_push($list[$arr[$i]], addOdPackType1($djCompany));//파우치없음
					//array_push($list[$arr[$i]], addOdPackType2($djCompany));//사전조제파우치 
				}
				else if($arr[$i] == "reBoxmedi")
				{
					//array_push($list[$arr[$i]], addReBoxMedi($djCompany));//사전조제한약박스 
				}
				
				while($ddt=dbarr($dres))
				{
					$djafFile=getafFile($ddt["AFURL"]);
					$djafThumbUrl=getafThumbUrl($ddt["AFURL"]);
					$capa=($ddt["PB_TYPE"]=="reBoxmedi") ? $ddt["PB_MAXCNT"]:$ddt["PB_CAPA"];
				
					$addarray = array(
						"pbCode"=>$ddt["PB_CODE"], 
						"pbType"=>$ddt["PB_TYPE"], 
						"pbTitle"=>$ddt["PB_TITLE"], 
						"pbCodeOnly"=>$ddt["PB_CODEONLY"],
						"pbPriceA"=>($ddt["PB_PRICEA"])?$ddt["PB_PRICEA"]:0, 
						"pbPriceB"=>($ddt["PB_PRICEB"])?$ddt["PB_PRICEB"]:0,
						"pbPriceC"=>($ddt["PB_PRICEC"])?$ddt["PB_PRICEC"]:0,
						"pbPriceD"=>($ddt["PB_PRICED"])?$ddt["PB_PRICED"]:0,
						"pbPriceE"=>($ddt["PB_PRICEE"])?$ddt["PB_PRICEE"]:0,
						"pbVolume"=>$ddt["PB_VOLUME"],
						"pbMaxcnt"=>$ddt["PB_MAXCNT"],
						"pbCapa"=>$capa, 
						"pbMember"=>$ddt["PB_MEMBER"], 
						"pbStaff"=>$ddt["PB_STAFF"], 
						"pbDesc"=>$ddt["PB_DESC"], 
						"afFilel"=>$djafFile,
						"afThumbUrl"=>$djafThumbUrl
					);
					
					array_push($list[$arr[$i]], $addarray);
				}
			

			}
		}
		
		return $list;

	}
	function addReBoxDeli($djCompany)
	{
		$addarray = array(						
			"pbCode"=>"RBD190710182024", 
			"pbType"=>"reBoxdeli", 
			"pbTitle"=>"포장박스없음", 
			"pbCodeOnly"=>"",
			"pbPriceA"=>"0", 
			"pbPriceB"=>"0", 
			"pbPriceC"=>"0", 
			"pbPriceD"=>"0", 
			"pbPriceE"=>"0", 
			"pbVolume"=>"0", 
			"pbMaxcnt"=>"0", 
			"pbCapa"=>"1",  
			"pbMember"=>$djCompany, 
			"pbStaff"=>"", 
			"pbDesc"=>"", 
			"afFilel"=>"NoIMG",
			"afThumbUrl"=>"NoIMG"
		);
		return $addarray;
	}
	function addReBoxMedi($djCompany)
	{
		$addarray = array(
			"pbCode"=>"RBM200117151838", 
			"pbType"=>"reBoxmedi", 
			"pbTitle"=>"사전조제한약박스", 
			"pbCodeOnly"=>"marking03|Y",
			"pbPriceA"=>"0", 
			"pbPriceB"=>"0", 
			"pbPriceC"=>"0", 
			"pbPriceD"=>"0", 
			"pbPriceE"=>"0", 
			"pbCapa"=>"1", 
			"pbMember"=>$djCompany, 
			"pbStaff"=>"", 
			"pbDesc"=>"", 
			"afFilel"=>"NoIMG",
			"afThumbUrl"=>"NoIMG"
		);
		return $addarray;
	}
	function addOdPackType1($djCompany)
	{
		$addarray = array(
			"pbCode"=>"PCB190710182024", 
			"pbType"=>"odPacktype", 
			"pbTitle"=>"파우치없음", 
			"pbCodeOnly"=>"marking03|Y",
			"pbPriceA"=>"0", 
			"pbPriceB"=>"0", 
			"pbPriceC"=>"0", 
			"pbPriceD"=>"0", 
			"pbPriceE"=>"0", 
			"pbVolume"=>"0", 
			"pbMaxcnt"=>"0", 
			"pbCapa"=>"1", 
			"pbMember"=>$djCompany, 
			"pbStaff"=>"", 
			"pbDesc"=>"", 
			"afFilel"=>"NoIMG",
			"afThumbUrl"=>"NoIMG"
		);
		return $addarray;
	}
	function addOdPackType2($djCompany)
	{
		$addarray = array(
			"pbCode"=>"PCB200117151735", 
			"pbType"=>"odPacktype", 
			"pbTitle"=>"사전조제파우치", 
			"pbCodeOnly"=>"marking03|Y",
			"pbPriceA"=>"0", 
			"pbPriceB"=>"0", 
			"pbPriceC"=>"0", 
			"pbPriceD"=>"0", 
			"pbPriceE"=>"0", 
			"pbCapa"=>"120", 
			"pbMember"=>$djCompany, 
			"pbStaff"=>"", 
			"pbDesc"=>"", 
			"afFilel"=>"NoIMG",
			"afThumbUrl"=>"NoIMG"
		);
		return $addarray;
	}

	///=========================================================================
	/// 20200402(OK)
	///  함수 명     : getafFile()
	///  함수 설명   : 이미지 원본 url 
	///=========================================================================
	function getafFile($afurl) //원본이미지 크기 
	{
		$afFile="NoIMG";
		if($afurl)
		{
			if(strtolower($afurl)=="noimg" || strtolower($afurl)=="")
			{
				$afFile="NoIMG";
			}
			else
			{			
				$afFile=$afurl;
			}
		}
		return $afFile;
	}
	///=========================================================================
	/// 20200402(OK)
	///  함수 명     : getafThumbUrl()
	///  함수 설명   : 이미지 썸네일 url 
	///=========================================================================
	function getafThumbUrl($afurl)//썸네일이미지 (작은사이즈)
	{
		$afThumbUrl="NoIMG";
		if($afurl)
		{
			if(strtolower($afurl)=="noimg" || strtolower($afurl)=="")
			{
				$afFile="NoIMG";
			}
			else
			{
				if(substr($afurl, 0, 4)=="http")
				{
					$afThumbUrl=$afurl;
				}
				else
				{
					$iarr = explode("/",$afurl);
					$iarr = insert_array($iarr, sizeof($iarr)-1, "thumb");
					$thumbName = implode( '/', $iarr );
					$afThumbUrl=$thumbName;
				}
			}
		}
		return $afThumbUrl;
	}
	///=========================================================================
	/// 20200402(OK)
	///  함수 명     : chkGoodsTie()
	///  함수 설명   : 약속처방(기획) 예외처리 하는 부분 
	///=========================================================================
	function chkGoodsTie($code, $type, $goods)
	{
		if($code=="427" || ($type=="goods" && $goods=="P"))//productcode가 427이거나 약속이면서 P인것은 
		{
			return true;
		}
		return false;
	}
	///=========================================================================
	/// 20200403(OK)
	///  함수 명     : getMatypeName()
	///  함수 설명   : 조제타입 이름 
	///=========================================================================
	function getMatypeName($od_goods, $maTypeName, $rc_source)
	{
		if($od_goods=="G")
		{
			$typename=$maTypeName."(사전)";
		}
		else if($od_goods=="Y")
		{
			if($rc_source)
			{
				$typename=$maTypeName."(재고)";
			}
			else
			{
				$typename=$maTypeName."(상품)";
			}
		}
		else if($od_goods=="M")
		{
			$typename=$maTypeName."(첩약)";
		}
		else if($od_goods=="P")
		{
			$typename=$maTypeName."(기획)";
		}
		else
		{
			if($maTypeName=="탕제")
			{
				$typename=$maTypeName;
			}
			else
			{
				$typename=$maTypeName."(탕제)";
			}
		}
		return $typename;
	}

	///=========================================================================
	/// 20200409(OK)
	///  함수 명     : getmaTableList()
	///  함수 설명   : 조제대테이블 리스트 뽑아오기 
	///=========================================================================	
	function getmaTableList()
	{
		global $language;
		global $dbH; 

		///코드가 사용이거나 odStatus(주문상태)가 아닐경우만 리스트로 뽑아오기 
		$wsql=" where mt_use = 'Y' ";
		$sql=" select mt_code, mt_title from ".$dbH."_makingtable $wsql order by mt_code ASC ";

		$res=dbqry($sql);
		$list = array();
		while($dt=dbarr($res))
		{
			$addarray = array(
				"cdCode"=>$dt["MT_CODE"],
				"cdName"=>$dt["MT_TITLE"],
				"cdType"=>"mbTalbe"
				);

			array_push($list, $addarray);
		}

		return $list;
	}
	///=========================================================================
	/// 20200416(OK)
	///  함수 명     : calcDcWater()
	///  함수 설명   : 물량계산
	///=========================================================================
	function calcDcWater($dc_time, $watertotal, $od_packcnt, $od_packcapa)
	{
		$dooWater=0;
		$packaddcnt = 4;
		$evaporation=700;//증발량
		$addwater=getDcTime($dc_time);
		$water=$watertotal + (($od_packcnt+$packaddcnt) * $od_packcapa);
		$newWater = $water+$addwater;
		
		
		//20200714착즙쥴 제거 
		//$chagjeub=($newWater*5)/100;
		//$dooWater=$newWater+$chagjeub;

		$dooWater=$newWater + $evaporation;

		//5000cc이하일 경우 증발량 900적용(기본이 700이여서 -200만 더함 )
		if(intval($dooWater)<=5000)
		{
			$dooWater=$dooWater-200;
		}
		$dooWater=getSibdan($dooWater);
		return $dooWater;
	}
	//주수상반
	function calcWaterAlcohol($totwater)
	{
		return intval(($totwater - ( $totwater * 0.1)) / 10) * 10;
	}
	//증류탕전
	function calcWaterDistillation($totwater)
	{
		return $totwater + 1000;
	}
	//건조탕전
	function calcWaterDry($watertotal, $od_packcnt, $od_packcapa)
	{
		$evaporation=700;//증발량
		$water=$watertotal+($od_packcapa*$od_packcnt);
		return $water;
	}
	function chkdcSpecial($dc_special)
	{
		if($dc_special=="spdecoc03")//주수상반
		{
			return "alcohol";
		}
		else if($dc_special=="spdecoc05")//증류탕전
		{
			return "distillation";
		}
		else if($dc_special=="spdecoc06")//건조탕전 
		{
			return "dry";
		}
		return "";
	}

	//json_encode 한글 깨짐 방지 
	function my_json_encode($arr)
	{
		array_walk_recursive($arr, function (&$item, $key) { if (is_string($item)) $item = mb_encode_numericentity($item, array (0x80, 0xffff, 0, 0xffff), 'UTF-8'); });
		return mb_decode_numericentity(json_encode($arr), array (0x80, 0xffff, 0, 0xffff), 'UTF-8');
	}
	//선전이 있으면 선전비 추가 
	function chkInfirstPrice($rc_medicine, $firstPrice)
	{
		if (strpos($rc_medicine, ",infirst,") !== false) 
		{
			$infirst=$firstPrice;	
		}
		else
		{
			$infirst=0;
		}
		return $infirst;
	}
	//후하가 있으면 후하비 추가 
	function chkInafterPrice($rc_medicine, $afterPrice)
	{
		if (strpos($rc_medicine, ",inafter,") !== false) 
		{
			$inafter=$afterPrice;	
		}
		else
		{
			$inafter=0;
		}
		return $inafter;
	}
	//첩약인지체크 
	function chkCheob($od_goods)
	{
		if($od_goods=="M") //첩약배송비 
		{
			return true;
		}
		return false;
	}
	//녹용이 있으면 탕전시간을 120분으로 기본은 80으로 
	function chkVelvetTime($rc_medicine)
	{
		if(strpos($rc_medicine, "HD0336") !== false || strpos($rc_medicine, "HD0337") !== false)//녹용,녹각 있다면.. 탕전시간을 120으로 수정 
		{
			return 120;
		}
		return 80;
	}
	//////////////////////////////////////////////////////
	//밑에는 하나씩 수정하자 
















	function checkMediCode($code)
	{
		if(strpos($code, "__") !== false)
		{
			return true;
		}
		else
		{
			return false;
		}
	}


	

	function add_hyphen($tel)
	{
		$tel = preg_replace("/[^0-9]/", "", $tel);    // 숫자 이외 제거
		if (substr($tel,0,2)=='02')
			return preg_replace("/([0-9]{2})([0-9]{3,4})([0-9]{4})$/", "\\1-\\2-\\3", $tel);
		else if (strlen($tel)=='8' && (substr($tel,0,2)=='15' || substr($tel,0,2)=='16' || substr($tel,0,2)=='18'))
			// 지능망 번호이면
			return preg_replace("/([0-9]{4})([0-9]{4})$/", "\\1-\\2", $tel);
		else
			return preg_replace("/([0-9]{3})([0-9]{3,4})([0-9]{4})$/", "\\1-\\2-\\3", $tel);
	}
	function chkGrade($grade)
	{
		$grade=($grade) ? strtoupper($grade) : "E";

		if($grade=="A" || $grade=="B" || $grade=="C" || $grade=="D" || $grade=="E")
		{
			return strtoupper($grade);
		}
		else
		{
			return "E";
		}
	}

	function getPackPrice($data, $grade)
	{
		$grade=chkGrade($grade);
		return $data["pbPrice".$grade];
	}
	function getMediPrice($medi, $grade)
	{
		$grade=chkGrade($grade);
		return $medi["md_price".$grade];
	}
	function getmedicinerecipe($rc_seq, $type)
	{
		global $language;
		global $dbH;

		switch($type)
		{
			case "Unique":
			case "smu":
				$tbl="member";
				break;
			case "General":
				$tbl="user";
				break;
			case "worthy":  //실속처방
			case "commercial":  //상용처방
			case "goods":  //약속처방
			case "pill": //제환		
				$tbl="medical";
				break;
		}
		$ssql="";
		switch($type)
		{
		case "worthy":  //실속속처방
		case "commercial":  //상용처방
		case "goods":  //약속처방
			$ssql=" , a.rc_chub, a.rc_packcnt, a.rc_packtype, a.rc_packcapa, a.rc_medibox  ";
			break;
		case "pill":  //제환 
			$ssql=" , b.GD_PILLORDER, b.GD_BOMCODE, b.GD_CODE ";
			break;
		}

		if($rc_seq)
		{
			$sql=" select a.rc_seq rcSeq ";
			$sql.=" ,a.rc_medicine as RCMEDICINE ";
			$sql.=" ,a.rc_sweet as RCSWEET ".$ssql." from ".$dbH."_recipe".$tbl;
			if($type=="pill")
			{
				$sql.=" a left join ".$dbH."_goods b on a.rc_code=b.GD_RECIPE ";
			}
			else
			{
				$sql.=" a left join ".$dbH."_recipebook b on a.rc_source=b.rb_code ";
			}
			$sql.=" where a.rc_seq='".$rc_seq."'";
			//echo $sql;
			$dt=dbone($sql);
		}
		$list=array();

		switch($type){
			case "worthy":  //실속속처방
			case "commercial":  //상용처방
			case "goods":  //약속처방
				$list=array("seq"=>$dt["RCSEQ"], 
					"rcMedicine"=>getClob($dt["RCMEDICINE"]), 
					"rcSweet"=>getClob($dt["RCSWEET"]), 
					"rcChub"=>$dt["RC_CHUB"], 
					"rcPackcnt"=>$dt["RC_PACKCNT"], 
					"rcPacktype"=>$dt["RC_PACKTYPE"], 
					"rcPackcapa"=>$dt["RC_PACKCAPA"], 
					"rcMedibox"=>$dt["RC_MEDIBOX"]
				);
			break;
			case "pill":
				//$list=getPillorderData(getClob($dt["GD_PILLORDER"]));
				$list=getGatherpillorder($dt["GD_BOMCODE"], $dt["GD_CODE"], getClob($dt["GD_PILLORDER"]));
				$list["seq"]=$dt["RCSEQ"];
				$list["type"]=$type;
				break;
			default:
				$list=array("seq"=>$dt["RCSEQ"], "rcMedicine"=>getClob($dt["RCMEDICINE"]), "rcSweet"=>getClob($dt["RCSWEET"]));
				break;
		}
		$list["sql"]=$sql;
		return $list;
	}
	

	function getbeforepillincapa($blist, $plkey, $renum)
	{
		$incapa=$innum=$inkey=0;
		for($h=count($blist)-1;$h>=0;$h--)
		{
			$porder=$blist[$h]["order"]["order"]["medicine"];
			$outcapa=$blist[$h]["order"]["outcapa"];
			//if(intval($outcapa)<=0)
			{
				foreach($porder as $hey=>$value)
				{
					if($porder[$hey]["ok"]=="ok")
					{
						$pok="ok";
					}
					else
					{
						$pok="notok";
					}
					if($porder[$hey]["code"]==$plkey && $pok=="notok")
					{
						$incapa=$blist[$h]["order"]["order"]["medicine"][$hey]["capa"];
						$inkey=$hey;
						$innum=$h;
						break;
					}
				}
			}
		}

		return $incapa."_".$innum."_".$inkey;
	}
	//부모와 자식들의 pillorder 데이터를 불러오자 
	function getGatherpillorder($gdBomcode, $gdCode, $gdPillorder)
	{
		global $dbH;
		global $language;
		global $mi_grade;

		global $pillodPillcapa;
		global $pillodQty;
		global $pilltotalcapa;

		global $pillOrderList;

		//$plist=array();

		$bomcode = substr($gdBomcode, 1); ///한자리만 자르기 
		$childbomcodeList=getpillchildlist($bomcode);
		$childlist=$childbomcodeList["list"];//해당하는 자신의 구성요소의 자식들 제환순서 
		$parentlist=$childbomcodeList["parent"];//해당하는 자신의 구성요소의 제환순서 
		$thislist[0]=array("key"=>$gdCode, "order"=>$gdPillorder);//해당하는 자신의 제환순서
		$plist=array_merge($parentlist, $childlist);
		$plist=array_merge($plist, $thislist);

		$pillorder=array();
		$pillmedicine=array();
		$rcMedicineCnt=$totmedicapa=$totmediprice=$dcWater=$odPillcapa=0;

		for($i=0;$i<count($plist);$i++)
		{
			$plkey=$plist[$i]["key"];
			$plorder=json_decode($plist[$i]["order"], true);
			$plist[$i]["order"]=$plorder;
			$ptype=$plorder["type"];
			if (in_array($ptype, $pillorder)==false) 
			{
				array_push($pillorder, $ptype);
			}
		}

		//제환순서 다시 정렬함 
		$repillorder=array();
		$pilllist=array();
		for($i=count($pillOrderList)-1;$i>=0;$i--)
		{
			$poCodeType=$pillOrderList[$i]["cdCode"];
			for($j=0;$j<count($plist);$j++)
			{
				$pltype=$plist[$j]["order"]["type"];
				if($poCodeType==$pltype)
				{
					array_push($repillorder, $poCodeType);

					array_push($pilllist, $plist[$j]);
				}
			}
		}
		
		//정렬된 제환순서대로 데이터 계산하기
		$rerows=$renum=-1;
		for($j=0;$j<count($repillorder);$j++)
		{
			$retype=$repillorder[$j];
			$renum=$rerows;

			for($i=0;$i<count($pilllist);$i++)
			{
				$pltype=$pilllist[$i]["order"]["type"];
				$ploutcapa=$pilllist[$i]["order"]["outcapa"];

				if($retype==$pltype&&intval($ploutcapa)<=0)//
				{
					$plkey=$pilllist[$i]["key"];
					$rerows=$i;
					//////////
					if($retype=="packing")
					{	
						$pilllist[$i]["order"]["incapa"]=$pilltotalcapa;
						$pilllist[$i]["order"]["outcapa"]=$pillodQty;

						$porder=$pilllist[$i]["order"]["order"]["medicine"];
						foreach($porder as $key=>$value)
						{
							if($porder[$key]["kind"]=="unit")//갯수
							{
								$pilllist[$i]["order"]["order"]["medicine"][$key]["capa"]=$pillodQty;
							}
							else
							{
								$pilllist[$i]["order"]["order"]["medicine"][$key]["capa"]=round($pilllist[$i]["order"]["incapa"]*$porder[$key]["value"]/100);
							}
						}
					}
					else
					{
						$beincapa1=getbeforepillincapa($pilllist, $plkey, $renum);
						$barr=explode("_",$beincapa1);
						$beincapa=$barr[0];
						$beinnum=$barr[1];
						$beinkey=$barr[2];
						$pilllist[$beinnum]["order"]["order"]["medicine"][$beinkey]["ok"]="ok";


						$pilllist[$i]["order"]["outcapa"]=$beincapa;
						//$renum, $retype, $plkey
						$belosstype=$pilllist[$i]["order"]["losstype"];
						$belosscapa=$pilllist[$i]["order"]["losscapa"];
						$afincapa=$beincapa;

						if($belosstype=="200")//unit
						{
							$afincapa=$beincapa+$belosscapa;
						}
						else
						{
							if(intval($belosscapa)<=0)
							{
								$afincapa=$beincapa;
							}
							else
							{
								$afincapa=round($beincapa/(1-($belosscapa/100)));
							}
						}
						$pilllist[$i]["order"]["incapa"]=$afincapa;

						$porder=$pilllist[$i]["order"]["order"]["medicine"];
						foreach($porder as $key=>$value)
						{
							if($porder[$key]["kind"]=="unit")//갯수
							{
								$pilllist[$i]["order"]["order"]["medicine"][$key]["capa"]=round($pilllist[$i]["order"]["incapa"]*$porder[$key]["unit"]/100);
							}
							else
							{
								$pilllist[$i]["order"]["order"]["medicine"][$key]["capa"]=round($pilllist[$i]["order"]["incapa"]*$porder[$key]["value"]/100);
							}

						}

					}

					$reKey=$plkey;


					break;
				}
			}
		}

		
		//최종약재 데이터 말기
		$medilist=[];
		for($i=0;$i<count($pilllist);$i++)
		{
			$plkey=$pilllist[$i]["key"];
			$plorder=$pilllist[$i]["order"];
			$ptype=$plorder["type"];
			$ptypename=$plorder["typetxt"];

			//$ptypename=getPillorderTypName($ptype);
			$porder=$plorder["order"]["medicine"];
			$pilllist[$i]["order"]["typetxt"]=$ptypename;

			foreach($porder as $key=>$value)
			{
				if($porder[$key]["type"]=="medicine")//원재료 
				{
					$medicode=$porder[$key]["code"];
					$msql=" select ";
					$msql.=" a.mb_seq gd_seq, a.mb_code ";
					$msql.=", (select LISTAGG(mb_table, ',') WITHIN GROUP (ORDER BY mb_table asc) from ".$dbH."_medibox where mb_medicine = a.mb_medicine and mb_use <> 'D' and mb_table not in ('99999','44444') ) as MBTABLE";
					$msql.=", b.mm_code gd_code, b.mm_title_".$language." gd_name, b.md_code ";
					$msql.=", d.md_origin_".$language." gd_origin, d.md_maker_".$language." gd_maker ";
					$msql.=", d.md_priceA, d.md_priceB, d.md_priceC, d.md_priceD, d.md_priceE,  d.md_qty  ";
					$msql.=", (select sum(mb_capacity)  from ".$dbH."_medibox where mb_medicine = d.md_code and mb_use <> 'D' and mb_table not in ('99999','44444') ) as mbCapacity ";
					$msql.=" from ".$dbH."_medibox  ";
					$msql.=" a inner join ".$dbH."_medicine_djmedi b on a.mb_medicine=b.md_code  ";
					$msql.=" inner join ".$dbH."_medicine d on a.mb_medicine=d.md_code  ";
					$msql.=" where b.mm_code = '".$medicode."' and a.mb_table='99999' ";
					$mdt=dbone($msql); 

					$title=$mdt["GD_NAME"];
					$origin=$mdt["GD_ORIGIN"]."/".$mdt["GD_MAKER"];
					$dismatch="-";
					$poison="-";
				
					if(strpos($mdt["MBTABLE"],"00000")!==false)//포함되어있다면 
					{
						$medibox="▲";
					}
					else
					{
						$medibox="O";
					}
					$mbcapacity=!isEmpty($mdt["MBCAPACITY"])?$mdt["MBCAPACITY"]:0;
					$md_qty=!isEmpty($mdt["MD_QTY"])?$mdt["MD_QTY"]:0;
					$totalqty=$mbcapacity + $md_qty; //조제대와 창고 합친것 
					$medicapa=$porder[$key]["capa"];

					$grade=chkGrade($mi_grade);
					$mediprice=$mdt["MD_PRICE".$grade];
					$totalprice=$medicapa*$mediprice;
					$md_code=$mdt["MD_CODE"];

					$medicine=array(
						"type"=>$ptype,
						"typetxt"=>$ptypename,
						"code"=>$medicode,//부산대약재코드 
						"mdCode"=>$md_code,//우리약재코드
						"title"=>$title,
						"origin"=>$origin,
						"dismatch"=>$dismatch,
						"poison"=>$poison,
						"medibox"=>$medibox,
						"totalqty"=>$totalqty,
						"medicapa"=>$medicapa,
						"mediprice"=>$mediprice,
						"totalprice"=>$totalprice
						);

					if (in_array($md_code, $medilist)==false) 
					{
						$md_medicapa=$medilist[$md_code]["medicapa"];
						$md_totalprice=$medilist[$md_code]["totalprice"];
						$md_totalqty=$medilist[$md_code]["totalqty"];

						$medicine["medicapa"]+=$md_medicapa;
						$medicine["totalprice"]+=$md_totalprice;
						$medicine["totalqty"]+=$md_totalqty;
					}

					$medilist[$md_code]=$medicine;


					
				
					$totmediprice+=$totalprice;
					$totmedicapa+=$medicapa;
					
				}
				else if($porder[$key]["type"]=="material")//부자재
				{
					if(intval($porder[$key]["unit"])>0 && $odPillcapa<=0)
					{
						$odPillcapa=$porder[$key]["unit"];
					}
				}
			}
		}
		$rcMedicineCnt=count($medilist);
		$dcWater=$totmedicapa*6;//토탈약재량*6 탕전물량 


		//$pillmedicine=$medilist;
		foreach($medilist as $key => $value)
		{
			array_push($pillmedicine,$medilist[$key]);
		}

		//최종pilllist 다시 수정 
		$pilldata=[];
		for($i=0;$i<count($pilllist);$i++)
		{
			$plkey=$pilllist[$i]["key"];
			$plorder=$pilllist[$i]["order"];
			$ptype=$plorder["type"];

			
			$pdata=$pilllist[$i];
			$medilist=[];
			if (in_array($plkey, $pilldata)==false)
			{
				$pincapa=$pilldata[$ptype]["order"]["incapa"];
				$poutcapa=$pilldata[$ptype]["order"]["outcapa"];
				$pname=$pilldata[$ptype]["order"]["name"];
				$pmedicine=$pilldata[$ptype]["order"]["order"]["medicine"];


				$nmedicine=$pdata["order"]["order"]["medicine"];
				$pdata["order"]["incapa"]+=$pincapa;
				$pdata["order"]["outcapa"]+=$poutcapa;
				$medicineList=array();
				//현재약재리스트
				
				for($j=0;$j<count($nmedicine);$j++)
				{
					$type=$nmedicine[$j]["type"];
					//if($type!="material")
					{
						$code=$nmedicine[$j]["code"];
						$medicine=$nmedicine[$j];
						$medicine["parentname"]=$pdata["order"]["name"];

						$mediChk="N";
						foreach($medilist as $key => $value)
						{
							if($medilist[$key]["code"]==$code)
							{
								$mediChk="Y";
								break;
							}
						}

						if($mediChk=="Y")
						{
							$medicapa=$medilist[$code]["capa"];
							$medicine["capa"]+=$medicapa;
						}

						$medilist[$code]=$medicine;
					}
				}
				///이전 
				for($j=0;$j<count($pmedicine);$j++)
				{
					$type=$pmedicine[$j]["type"];
					//if($type!="material")
					{
						$code=$pmedicine[$j]["code"];
						$medicine=$pmedicine[$j];

						$mediChk="N";
						foreach($medilist as $key => $value)
						{
							if($medilist[$key]["code"]==$code)
							{
								$mediChk="Y";
								break;
							}
						}

						if($mediChk=="Y")
						{
							$medicapa=$medilist[$code]["capa"];
							$medicine["capa"]+=$medicapa;
						}

						$medilist[$code]=$medicine;
					}
				}


				foreach($medilist as $key => $value)
				{
					array_push($medicineList,$medilist[$key]);
				}

				$pdata["order"]["order"]["medicine"]=$medicineList;
				

			}

			$pilldata[$ptype]=$pdata;

		}


		//최종정렬 
		$pillfinallist=array();
		for($i=0;$i<count($pillOrderList);$i++)
		{
			$poCodeType=$pillOrderList[$i]["cdCode"];
			foreach($pilldata as $key => $value)
			{
				$pltype=$pilldata[$key]["order"]["type"];
				if($poCodeType==$pltype)
				{
					$pillfinallist[$poCodeType]=$pilldata[$key];
				}
			}
		}


		$list=array("pilllist"=>$pillfinallist,"pilldata"=>$pilldata,"pillorder"=>$pillorder,"repillorder"=>$repillorder,"pillmedicine"=>$pillmedicine,"medilist"=>$medilist,"rcMedicineCnt"=>$rcMedicineCnt, "dcWater"=>$dcWater, "odPillcapa"=>$odPillcapa, "totmedicapa"=>$totmedicapa, "totmediprice"=>$totmediprice);

		return $list;
	}
	//order에 저장된 데이터를 불러온 데이터로 
	function getPillorderData($gd_pillorder)
	{
		$gdPillorder=json_decode($gd_pillorder, true);
		$pilllist=$gdPillorder["pilllist"];
		$pillmedicine=$gdPillorder["pillmedicine"];
		$totmedicapa=$gdPillorder["totmedicapa"];
		$totmediprice=$gdPillorder["totmediprice"];

		$pillorder=array();
		foreach($pilllist as $key => $value)
		{
			$plorder=$pilllist[$key]["order"];
			$ptype=$plorder["type"];
			if (in_array($ptype, $pillorder)==false) 
			{
				array_push($pillorder, $ptype);
			}
		}

		$list=array("pilllist"=>$pilllist,"pillorder"=>$pillorder,"pillmedicine"=>$pillmedicine,"rcMedicineCnt"=>$rcMedicineCnt, "dcWater"=>$dcWater, "totmedicapa"=>$totmedicapa, "totmediprice"=>$totmediprice);

		return $list;
	}

	function getpillparentlist($val)   ///ETGDSH|9,FTZE001|3,FTYX001|4,FTXX012|5
	{
		global $dbH;
		global $language;
		$Arry = explode(',', $val);			
		$bomdata=array();

		foreach($Arry as $value)
		{
			///순서를 원재료, 제품, 반제품, 순서대로 넣기 
			$items = explode('|', $value);

			///text구해오기
			///$sql = " select gd_name_kor as title, gd_type as gdType from han_goods where gd_code ='".$items[0]."' ";

			$sql = " select 
						a.gd_seq, a.gd_name_kor as title, a.gd_type as gdType, a.GD_PILLORDER, a.GD_CAPA, b.cd_name_kor as name 
						from han_goods 
						a inner join han_code b on a.gd_type=b.cd_code and cd_type='gdType' 
						where a.gd_code ='".$items[0]."' and a.gd_type!='origin' ";

			$dt2=dbone($sql);

			if($dt2["GD_SEQ"])
			{
				$bomarr=array(
					"bomseq"=>$dt2["GD_SEQ"],
					"bomcode"=>$items[0],
					"bomcapa"=>$items[1],
					"bomtext"=>$dt2["TITLE"],
					"gdCapa"=>$dt2["GD_CAPA"],
					"gdPillorder"=>getClob($dt2["GD_PILLORDER"]),
					"gdType"=>$dt2["GDTYPE"],
					"gdTypename"=>$dt2["NAME"]
					);

				$bomdata[$dt2["GDTYPE"]][]=$bomarr;
			}
			else
			{
				$sql2=" select ";
				$sql2.=" a.mb_seq gd_seq, a.mb_code, b.mm_code gd_code, b.mm_title_".$language." gd_name, c.cd_name_".$language." gdType ";
				$sql2.=", d.md_origin_".$language." gd_origin, d.md_maker_".$language." gd_maker ";
				$sql2.=" from ".$dbH."_medibox  ";
				$sql2.=" a inner join ".$dbH."_medicine_djmedi b on a.mb_medicine=b.md_code  ";
				$sql2.=" inner join han_code c on c.cd_code='origin' and c.cd_type='gdType' ";
				$sql2.=" inner join ".$dbH."_medicine d on a.mb_medicine=d.md_code  ";
				$sql2.=" where b.mm_code = '".$items[0]."' and a.mb_table='99999' ";

				$dt3=dbone($sql2);
				if($dt3["GD_ORIGIN"]){$gd_origin="(".$dt3["GD_ORIGIN"].")";}else{$gd_origin="";}
				if($dt3["GD_MAKER"]){$gd_maker=" - ".$dt3["GD_MAKER"];}else{$gd_maker="";}
				$bomarr=array(
					///"sql2"=>$sql2,
					"bomseq"=>$dt3["GD_SEQ"],
					"bomcode"=>$items[0],
					"bomcapa"=>$items[1],
					"bomtext"=>$dt3["GD_NAME"].$gd_origin.$gd_maker,
					"gdCapa"=>"",
					"gdPillorder"=>"",
					"gdType"=>"origin",
					"gdTypename"=>$dt3["GDTYPE"]
					);

				$bomdata["medicine"][]=$bomarr;

			}
			///array_push($bomdata,$bomarr);
		}
		return $bomdata;			
	}
	
	function getpillchild($code)
	{
		global $dbH;
		global $language;
		$sql = " select GD_BOMCODE, GD_PILLORDER from ".$dbH."_goods where gd_code ='".$code."' and gd_type!='origin' ";
		$dt=dbone($sql);
		$gd_bomcode=$dt["GD_BOMCODE"];
		$gd_pillorder=getClob($dt["GD_PILLORDER"]);
		$codedata=array("bomcode"=>$gd_bomcode, "pillorder"=>$gd_pillorder);
		return $codedata;
	}
	function getpillchildlist($val)
	{
		global $dbH;
		global $language;
		$Arry = explode(',', $val);
		$list=array();
		$childlist=array();
		$childdata=array();
		$parentlist=array();
		$childdata["0val"]=$val;

		foreach($Arry as $value)//부모 
		{
			$items = explode('|', $value);
			if(!isEmpty($items[0]))
			{
				$child=getpillchild($items[0]);
				$childdata["0".$items[0]]=$child;
				if(!isEmpty($child["bomcode"]))
				{
					$chpill=array("key"=>$items[0], "order"=>$child["pillorder"]);
					array_push($parentlist, $chpill);
					//$parentlist[$items[0]]=$child["pillorder"];
					//array_push($childlist, $items1[0]);
				}

				//밑에는 parent 자식들부터 넣는다 
				//1-----------------------------------
				if(!isEmpty($child["bomcode"]))
				{
					$Arry1=explode(',', $child["bomcode"]);
					$childdata["1val"]=$child["bomcode"];
					foreach($Arry1 as $value1)
					{
						$items1 = explode('|', $value1);
						if(!isEmpty($items1[0]))
						{
							$child1=getpillchild($items1[0]);							
							$childdata["1".$items1[0]]=$child1;
							if(!isEmpty($child1["bomcode"]))
							{
								//$childlist[$items1[0]]=$child1["pillorder"];
								$chpill=array("key"=>$items1[0], "order"=>$child1["pillorder"]);
								array_push($childlist, $chpill);
							}

							//2-----------------------------------
							if(!isEmpty($child1["bomcode"]))
							{
								$Arry2=explode(',', $child1["bomcode"]);
								$childdata["2val"]=$child1["bomcode"];
								foreach($Arry2 as $value2)
								{
									$items2 = explode('|', $value2);									
									if(!isEmpty($items2[0]))
									{
										$child2=getpillchild($items2[0]);
										$childdata["2".$items2[0]]=$child2;
										if(!isEmpty($child2["bomcode"]))
										{
											//$childlist[$items2[0]]=$child2["pillorder"];
											//array_push($childlist, $items2[0]);
											$chpill=array("key"=>$items2[0], "order"=>$child2["pillorder"]);
											array_push($childlist, $chpill);
										}

										//3-----------------------------------
										if(!isEmpty($child2["bomcode"]))
										{
											$Arry3=explode(',', $child2["bomcode"]);
											$childdata["3val"]=$child2["bomcode"];
											foreach($Arry3 as $value3)
											{
												$items3 = explode('|', $value3);									
												if(!isEmpty($items3[0]))
												{
													$child3=getpillchild($items3[0]);
													$childdata["3".$items3[0]]=$child3;
													if(!isEmpty($child3["bomcode"]))
													{
														//$childlist[$items3[0]]=$child3["pillorder"];
														//array_push($childlist, $items3[0]);
														$chpill=array("key"=>$items3[0], "order"=>$child3["pillorder"]);
														array_push($childlist, $chpill);
													}

													//4-----------------------------------
													if(!isEmpty($child3["bomcode"]))
													{
														$Arry4=explode(',', $child3["bomcode"]);
														$childdata["4val"]=$child3["bomcode"];
														foreach($Arry4 as $value4)
														{
															$items4 = explode('|', $value4);
															if(!isEmpty($items4[0]))
															{
																$child4=getpillchild($items4[0]);
																$childdata["4".$items4[0]]=$child4;
																if(!isEmpty($child4["bomcode"]))
																{
																	//$childlist[$items4[0]]=$child4["pillorder"];
																	//array_push($childlist, $items4[0]);
																	$chpill=array("key"=>$items4[0], "order"=>$child4["pillorder"]);
																	array_push($childlist, $chpill);
																}
															}

															//5-----------------------------------
															if(!isEmpty($child4["bomcode"]))
															{
																$Arry5=explode(',', $child4["bomcode"]);
																$childdata["5val"]=$child4["bomcode"];
																foreach($Arry5 as $value5)
																{
																	$items5 = explode('|', $value5);
																	if(!isEmpty($items5[0]))
																	{
																		$child5=getpillchild($items5[0]);
																		$childdata["5".$items5[0]]=$child5;
																		if(!isEmpty($child5["bomcode"]))
																		{
																			//$childlist[$items5[0]]=$child5["pillorder"];
																			//array_push($childlist, $items5[0]);
																			$chpill=array("key"=>$items5[0], "order"=>$child5["pillorder"]);
																			array_push($childlist, $chpill);
																		}
																	}
																}
															}
															//------------------------------------
														}
													}
													//------------------------------------
												}
											}
										}
										//------------------------------------
									}
								}
							}
							//------------------------------------
						}
					}
				}
				//------------------------------------
			}
		}

		$list["list"]=$childlist;
		$list["data"]=$childdata;
		$list["parent"]=$parentlist;

		return $list;
	}


?>