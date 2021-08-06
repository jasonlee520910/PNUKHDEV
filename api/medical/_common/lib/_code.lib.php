<?php	
	///=========================================================================
	///  (OK)
	///  함수 명     : getNewCodeTitle()
	///  함수 설명   : han_code 테이블 리스트 (select, option 에서 쓰이는 목록 )
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
				"cdCode"=>$dt["CD_CODE"], 
				"cdSort"=>$dt["CD_SORT"], 
				"cdTypeTxt"=>$dt["CDTYPENAME"], 
				"cdName"=>$dt["CDNAME"], 
				"cdDesc"=>getClob($dt["CDDESC"]), 
				"cdValue"=>getClob($dt["CDVALUE"])
				);

			array_push($blist[$dt["CD_CODE"]]=$addarray);
			$list[$dt["CD_TYPE"]][]=$blist[$dt["CD_CODE"]];
		}
		return $list;
	}


	///clob data 가져오기 
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
	///  함수 명     : getCodeList()
	///  함수 설명   : Code 리스트형
	///  페러미터    : $list -> getCodeTitle 함수에서 쿼리해온 리스트 데이터 
	///				  $type -> han_code 테이블에 cd_type 코드타입 값 
	///				  $data -> 뽑아올 데이터 코드값 
	///=========================================================================
	function getCodeList($list, $type)
	{
		return $list[$type];
	}


	///=========================================================================
	/// 20200402(OK)
	///  함수 명     : getafFile()
	///  함수 설명   : 이미지 원본 url 
	///=========================================================================
	function getafFile($afurl) //원본이미지 크기 
	{
		$afFile="NoIMG";
		if(isEmpty($afurl)==false)
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
		if(isEmpty($afurl)==false)
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


	///=========================================================================
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
			
			$list["sql".$arr[$i]]=$sql;
			$list["totalCount"].=$totalCount;
			if(intval($totalCount) > 0)
			{
				if($arr[$i] == "reBoxdeli")
				{
					///array_push($list[$arr[$i]], addReBoxDeli($djCompany));//포장박스없음
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
					//array_push($list[$arr[$i]], addReBoxDeli($djCompany));//포장박스없음
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

	///=========================================================================
	///  함수 명     : getDecoCodeTitle()
	///  함수 설명   : han_txtdata 선전,일반,후하 리스트 
	///=========================================================================
	function getDecoCodeTitle($state='3')
	{
		global $language;
		global $dbH; 		

		if($state=='all')
		{
			//$sql=" select td_code, td_name_".$language." as td_name from ".$dbH."_txtdata where td_code in ('infirst','inmain','inafter','inlast') order by field(td_code, 'infirst','inmain','inafter','inlast')";
			$sql=" select td_code, td_name_".$language." as TD_NAME from ".$dbH."_txtdata where td_code in ('infirst','inmain','inafter','inlast') order by decode(td_code, 'infirst','1','inmain','2','inafter','3','inlast','4')";
		}
		else
		{
			//$sql=" select td_code, td_name_".$language." as td_name from ".$dbH."_txtdata where td_code in ('infirst','inmain','inafter') order by field(td_code, 'infirst','inmain','inafter')";
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
	///  함수 명     : setConfigPrice()
	///  함수 설명   : han_config 공통으로 쓰이는 테이블 
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
		case "cheob"://첩약배송비 
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
	//복용지시,조제지시  
	function getMemberDocx($type, $doctorId, $medicalId)
	{
		global $language;
		global $dbH; 
		$list=array();
		if(isEmpty($doctorId)==false)
		{
			$sql=" select a.MD_SEQ, a.MD_TYPE, a.MD_TITLE, a.MD_CONTENTS, b.AF_NAME, b.AF_URL,b.AF_SIZE    
					from han_member_docx   a  
					left join han_file b on b.AF_SEQ=a.MD_FILEIDX and b.AF_USE='Y' 
					where  a.MD_USE<>'D' and a.MD_DOCTORID='".$doctorId."' and a.MD_TYPE='".$type."'   
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
			$cdDesc=getClob($dt["CDDESC"]);
			$cdValue=getClob($dt["CDVALUE"]);
			if(chkdcSpecial($cdCode)=="alcohol")//주수상반일경우 
			{
				$msql=" select a.md_code, a.md_title_kor as mdTitle, a.MD_PRICEA,a.MD_PRICEB,a.MD_PRICEC,a.MD_PRICED,a.MD_PRICEE
						from han_medicine a  
						inner join han_medicine_djmedi b on b.md_code=a.md_code and b.MM_USE<>'D'   
						where a.md_type ='alcohol' and a.md_use<>'D' and a.md_code='".$cdValue."'  
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
				"cdDesc"=>$cdDesc, 
				"cdValue"=>$cdValue
				);

			array_push($list, $addarray);
		}
		return $list;
	}

	function getMedicalInfo($medicalId)
	{
		global $language;
		global $dbH;

		$sql=" select ";
		$sql.=" mi_name, mi_zipcode, mi_address,mi_phone,mi_mobile ";
		$sql.=" from ".$dbH."_medical ";
		$sql.=" where mi_use <> 'D' and mi_userid='".$medicalId."' ";

		$dt=dbone($sql);

		$data=array(
			"miName"=>$dt["MI_NAME"],
			"miZipcode"=>$dt["MI_ZIPCODE"],
			"miAddress"=>$dt["MI_ADDRESS"],
			"miPhone"=>$dt["MI_PHONE"],
			"miMobile"=>$dt["MI_MOBILE"]
		);

		return $data;
	}

	///=========================================================================
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


//----------------------------------------------------------------------------아래부분은 수정안한것이므로 확인 필요


	//=========================================================================
	//  함수 명     : getCodeName()
	//  함수 설명   : Code 이름만 넘기기 
	//  페러미터    : $list -> getCodeTitle 함수에서 쿼리해온 리스트 데이터 
	//				  $type -> han_code 테이블에 cd_type 코드타입 값 
	//				  $data -> 뽑아올 데이터 코드값 
	//=========================================================================
	/*
	function getCodeName($list, $type, $data)
	{
		$statName = ($data=='') ? "-" : $list[$type][$data]["cdName"];

		return $statName;
	}
	*/



	///=========================================================================
	///  함수 명     : getMediCate()
	///  함수 설명   : 본초관리에서 분류1과 분류2 리스트 
	///=========================================================================
	function getMediCate($code)
	{
		global $language;
		global $dbH;

		$jsql=" a ";
		$wsql=" where mc_use <>'D' ";
		$gsql=" group by a.mc_code01 ";
		if($code) ///분류 1 값이 있을때
		{
			$wsql.=" and a.mc_code01 = '".$code."' ";
			$gsql=" ";
			$ssql.=" distinct(a.mc_code01), a.mc_seq, a.mc_code, a.mc_code01, a.mc_title01_kor, a.mc_title01_chn, a.mc_code02, a.mc_title02_kor, a.mc_title02_chn ";
		} 
		else ///분류 1 값이 없을때
		{
			$ssql.=" a.mc_seq, a.mc_code, a.mc_code01, a.mc_title01_kor, a.mc_title01_chn, a.mc_code02, a.mc_title02_kor, a.mc_title02_chn ";
		}
		$sql=" select $ssql from ".$dbH."_medicate $jsql $wsql $gsql order by a.mc_code ";

		$res=dbqry($sql);
		$list=array();

		while($dt=dbarr($res))
		{
			$addarray=array(
				"sql"=>$sql, 
				"seq"=>$dt["mc_seq"], 
				"mcCode01"=>$dt["mc_code01"], 
				"mcTitle01"=>$dt["mc_title01_".$language], 
				//"mcTitle01chn"=>$dt["mc_title01_chn"], 
				"mcCode02"=>$dt["mc_code02"], 
				"mcTitle02"=>$dt["mc_title02_".$language]
			//	"mcTitle02chn"=>$dt["mc_title02_chn"]
			);

			array_push($list, $addarray);
		}
		return $list;
	}

	///조제대테이블 리스트 뽑아오기 
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
				"cdCode"=>$dt["mt_code"],
				"cdName"=>$dt["mt_title"],
				"cdType"=>"mbTalbe"
				);

			array_push($list, $addarray);
		}

		return $list;
	}


	function getNewExcelTitle($code)
	{
		if(strpos($code, "__") !== false)///약재code에 __이 있다면 
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
		$grade=($grade) ? $grade : "E";

		if($grade=="A" || $grade=="B" || $grade=="C" || $grade=="D" || $grade=="E")
		{
			return strtoupper($grade);
		}
		else
		{
			return "E";
		}
	}
	function getMediPrice($medi, $grade)
	{
		$grade=chkGrade($grade);
		return $medi["MD_PRICE".$grade];
	}
	function getDcTime($dc_time)
	{
		$evaporation = 400;
		$itime=intval($dc_time)/60;
		$addwater = $itime*$evaporation;
		return $addwater;
	}
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
	function getSugarCapa($packCnt, $packCapa, $sugarcapa)
	{
		$capa=($packCnt*$packCapa)*($sugarcapa/100);
		return getSibdan($capa);
	}
	

	function getSibdan($amount)
	{
		return intval($amount/10)*10;
	}


	////han_code name 가져오기
	function hancodetext($medicode,$cdtype)
	{
		global $dbH;
		$sql="";
		$medititle="";
		if($medicode)
		{
			$dm_medi=explode(",",$medicode);
			$dm_medi_len=count($dm_medi);

			for($i=0;$i<$dm_medi_len;$i++)
			{			
				$sql=" select LISTAGG(cd_name_kor,',') as codename  from ".$dbH."_code where cd_type='".$cdtype."' and cd_code in ('".$dm_medi[$i]."') ";
				$res=dbqry($sql);
				while($hub=dbarr($res))
				{
					if($medititle!="")$medititle.=",";
					$medititle.=$hub["CODENAME"];
				}				
			}
		}
		return $medititle;
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

?>