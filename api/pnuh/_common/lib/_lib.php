<?php
	///랜덤생성함수숫자
	function randno($no)
	{
		$chars = "0123456789";
		srand((double)microtime()*1000000);
		$i = 0;
		$str = '';
		while ($i < $no) {
			$num = rand() % strlen($chars);
			$tmp = substr($chars, $num, 1);
			$str .= $tmp;
			$i++;
		}
		return $str;
	}
	//페이징
	function apipaging($use,$tbl,$jsql="",$wsql="")
	{
		global $dbH;
		global $pagefile;
		global $disc;
		$page=$_GET["page"];
		$psize=$_GET["psize"];
		$block=$_GET["block"];
		if(!$page)$page=1;
		$pg["page"]=$page;
		if(!$psize)$psize=10;
		$pg["psize"] = $psize;	///페이지당 갯수
		if(!$block)$block=10;
		$pg["block"] = $block;	///화면당 페이지수
		$pg["snum"] = ($pg["page"]-1)*$pg["psize"];
		if(!$page)$page=1;
		///search

		$sql=" select count(distinct(".$use.")) TCNT from ".$dbH."_".$tbl." ".$jsql." ".$wsql;
		$dt=dbone($sql);

		$pg["psql"] = $sql;
		$pg["tcnt"] = $dt["TCNT"];
		$pg["tpage"] = ceil($dt["TCNT"] / $pg["psize"]);
		$pg["tlast"] = $pg["snum"]+$pg["psize"];
		return $pg;
	}
	///==========================================================
	/// 20200408:keycode (OK)
	///==========================================================
	function getkeyCodeLast($datecode)
	{ 
		global $language;
		global $dbH; 


		$sql=" select ";
		$sql.=" (select count(*) from han_order where od_keycode like '".$datecode."%') as ordercnt, ";
		$sql.=" (select count(*) from han_order_okchart where od_keycode like '".$datecode."%') as okchartcnt, ";
		$sql.=" (select count(*) from han_order_medical where keycode like '".$datecode."%') as medicalcnt ";
		$sql.=" from dual ";

		$dt=dbone($sql);
		
		$lastCnt=intVal($dt["ORDERCNT"]) + intVal($dt["CLIENTCNT"]);
		if($lastCnt > 0)
		{
			$num=intVal($lastCnt) + 1;
			$keyCode=sprintf("%05d",$num);
		}
		else
		{
			$keyCode=sprintf("%05d",1);
		}
		
		return $keyCode;
	}



	//=========================================================================
	//  함수 명     : getNewCodeTitle()
	//  함수 설명   : han_code 테이블 리스트 (select, option 에서 쓰이는 목록 )
	//=========================================================================
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
		$sql.=" ,DBMS_LOB.SUBSTR(CD_DESC_".$language.", DBMS_LOB.GETLENGTH(CD_DESC_".$language.")) as CDDESC ";
		$sql.=" ,DBMS_LOB.SUBSTR(CD_VALUE_".$language.", DBMS_LOB.GETLENGTH(CD_VALUE_".$language.")) as CDVALUE ";
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
				"cdDesc"=>$dt["CDDESC"], 
				"cdValue"=>$dt["CDVALUE"]
				);


			array_push($blist[$dt["CD_CODE"]]=$addarray);
			$list[$dt["CD_TYPE"]][]=$blist[$dt["CD_CODE"]];
		}


		return $list;

	}
	function insert_array($arr, $idx, $add)
	{
		$arr_front = array_slice($arr, 0, $idx); //처음부터 해당 인덱스까지 자름
		$arr_end = array_slice($arr, $idx); //해당인덱스 부터 마지막까지 자름
		$arr_front[] = $add;//새 값 추가
		return array_merge($arr_front, $arr_end);
	}
	//=========================================================================
	//  함수 명     : getafFile()
	//  함수 설명   : 이미지 관련 url 
	//=========================================================================
	function getafFile($afurl) //원본이미지 크기 
	{
		$afFile="NoIMG";
		if($afurl)
		{
			if(strpos($afurl, "medicine") !== false || strpos($afurl, "staff") !== false || strpos($afurl, "inventory") !== false || strpos($afurl, "tbms") !== false || strpos($afurl, "member") !== false)
			{
				$afFile=$afurl;
			}
			else
			{
				if(strtolower($afurl)=="noimg")
				{
					$afFile="NoIMG";
				}
				else
				{
					$afFile="data/".$afurl;
				}
			}
			
		}

		return $afFile;
	}
	function getafThumbUrl($afurl)//썸네일이미지 (작은사이즈)
	{
		$afThumbUrl="NoIMG";
		if($afurl)
		{
			if(strpos($afurl, "medicine") !== false || strpos($afurl, "staff") !== false || strpos($afurl, "inventory") !== false || strpos($afurl, "tbms") !== false || strpos($afurl, "member") !== false)
			{
				$iarr = explode("/",$afurl);
				$iarr = insert_array($iarr, sizeof($iarr)-1, "thumb");
				$thumbName = implode( '/', $iarr );
				$afThumbUrl=$thumbName;
			}
			else
			{
				$iarr = explode("/",$afurl);
				$iarr = insert_array($iarr, sizeof($iarr)-1, "thumb");
				$thumbName = implode( '/', $iarr );
				$afThumbUrl="data/".$thumbName;
			}
			
		}
		return $afThumbUrl;
	}
	//=========================================================================
	//  함수 명     : getPackCodeTitle()
	//  함수 설명   : han_packingbox 테이블 리스트 (select, option 에서 쓰이는 목록 )
	//=========================================================================
	//20190918 : 가격추가
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
					array_push($list[$arr[$i]], addOdPackType1($djCompany));//파우치없음
					array_push($list[$arr[$i]], addOdPackType2($djCompany));//사전조제파우치
				}
				else if($arr[$i] == "reBoxmedi")
				{
					array_push($list[$arr[$i]], addReBoxMedi($djCompany));//사전조제한약박스 
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
						"pbPriceA"=>$dt["PB_PRICEA"], 
						"pbPriceB"=>$dt["PB_PRICEB"],
						"pbPriceC"=>$dt["PB_PRICEC"],
						"pbPriceD"=>$dt["PB_PRICED"],
						"pbPriceE"=>$dt["PB_PRICEE"],
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
					array_push($list[$arr[$i]], addOdPackType1($djCompany));//파우치없음
					array_push($list[$arr[$i]], addOdPackType2($djCompany));//사전조제파우치 
				}
				else if($arr[$i] == "reBoxmedi")
				{
					array_push($list[$arr[$i]], addReBoxMedi($djCompany));//사전조제한약박스 
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
						"pbPriceA"=>$ddt["PB_PRICEA"], 
						"pbPriceB"=>$ddt["PB_PRICEB"],
						"pbPriceC"=>$ddt["PB_PRICEC"],
						"pbPriceD"=>$ddt["PB_PRICED"],
						"pbPriceE"=>$ddt["PB_PRICEE"],
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
			"pbCodeOnly"=>"marking07|Y",
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
			"pbCodeOnly"=>"marking07|Y",
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
			"pbCodeOnly"=>"marking07|Y",
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
	//=========================================================================
	//  함수 명     : getCodeList()
	//  함수 설명   : Code 리스트형
	//  페러미터    : $list -> getCodeTitle 함수에서 쿼리해온 리스트 데이터 
	//				  $type -> han_code 테이블에 cd_type 코드타입 값 
	//				  $data -> 뽑아올 데이터 코드값 
	//=========================================================================
	function getCodeList($list, $type, $data)
	{
		return $list[$type];
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
	function getPackPrice($data, $grade)
	{
		$grade=chkGrade($grade);
		return $data["PBPRICE".$grade];
	}
	function getMediPrice($medi, $grade)
	{
		$grade=chkGrade($grade);
		return $medi["md_price".$grade];
	}
	function getDcTime($dc_time)
	{
		$evaporation = 400;
		$itime=intval($dc_time)/60;
		$addwater = $itime*$evaporation;
		return $addwater;
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

		}
		return $tmp;
	}
	function getSibdan($amount)
	{
		return floor($amount/10)*10;
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

		return $config;
	}

	function my_json_encode($arr)
	{
		array_walk_recursive($arr, function (&$item, $key) { if (is_string($item)) $item = mb_encode_numericentity($item, array (0x80, 0xffff, 0, 0xffff), 'UTF-8'); });
		return mb_decode_numericentity(json_encode($arr), array (0x80, 0xffff, 0, 0xffff), 'UTF-8');
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

	function isEmpty($value)
	{
		if( $value == "" || $value == null || $value == NULL || empty($value) || $value == "null" || isset($value)==false)
		{
			return true;
		}
		else
		{
			if($value)
				return false;
			else 
				return true;
		}
	}
?>