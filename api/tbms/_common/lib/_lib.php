<?php
	/// 사용하는 함수 
	///==========================================================
	/// 20200403:페이징(OK)
	///==========================================================
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
		$pg["psize"] = $psize;	/// 페이지당 갯수
		if(!$block)$block=10;
		$pg["block"] = $block;	/// 화면당 페이지수
		$pg["snum"] = ($pg["page"]-1)*$pg["psize"];
		if(!$page)$page=1;

		$sql=" select count(".$use.") TCNT from ".$dbH."_".$tbl." ".$jsql." ".$wsql;
		$dt=dbone($sql);
		$pg["tsql"] = $sql;
		$pg["tcnt"] = $dt["TCNT"];
		$pg["tpage"] = ceil($dt["TCNT"] / $pg["psize"]);
		$pg["tlast"] = $pg["snum"]+$pg["psize"];
		return $pg;
	}
	///=========================================================================
	///  20200403(OK)
	///  함수 명     : getStepStat()
	///  함수 설명   : 각 파트별 step을 가져온다. 
	///=========================================================================
	function getStepStat($depart)
	{
		global $language;
		global $dbH;

		$step=array();
		if($depart)
		{
			$cnt=1;
			$statcode=$statstatus=$statbarcode=$list=array();
			$sql=" select distinct(td_code) td_code, td_barcode, td_name_".$language." td_name from ".$dbH."_txtdata where td_use='Y' and td_code like 'step".$depart."%' order by td_code asc";
			$step["sql"]=$sql;
			$res=dbqry($sql);
			$stepcnt=0;

			while($dt=dbarr($res))
			{
				array_push($statcode,$dt["TD_CODE"]);
				array_push($statbarcode,$dt["TD_BARCODE"]);
				array_push($statstatus,$dt["TD_NAME"]);
				if(!is_null($dt["TD_BARCODE"]))
				{
					$stepcnt++;
				}
			}
			
			for($i=1;$i<count($statcode);$i++)
			{
				$chkcode=substr(str_replace("step".$depart,"",$statcode[$i]),1,1);
				if($chkcode<1)
				{
					$addarry=array(
						"code"=>$statcode[$i],
						"status"=>$statstatus[$i],
						"barcode"=>$statbarcode[$i]
						);
					array_push($list,$addarry);
					$cnt++;
				}
			}

			$step["list"]=$list;
			$step["cnt"]=($cnt-1);
			$step["stepcnt"]=$stepcnt;
		}

		return $step;
	}
	/// =========================================================================
	///  20200403(OK)
	///   함수 명     : getStepTxt(depart)
	///   함수 설명   : depart 별로 step에 쓰이는 텍스트 문자들 
	/// =========================================================================
	function getStepTxt($depart)
	{
		global $language;
		global $dbH;

		$step=array();
		if($depart)
		{
			$sql=" select td_code, td_barcode, td_name_".$language." td_name from ".$dbH."_txtdata where td_type='0' and td_use='Y' and td_code like 'step%".$depart."%' order by td_code asc ";
			$res=dbqry($sql);

			while($dt=dbarr($res))
			{
				$name = str_replace($depart,"", $dt["TD_CODE"]);
				$step[$name]=$dt["TD_NAME"];
			}
		}

		return $step;
	}
	/// =========================================================================
	///  20200403(OK)
	///   함수 명     : getCodeTitle()
	///   함수 설명   : han_code 테이블 리스트 (select, option 에서 쓰이는 목록 
	/// =========================================================================
	function getCodeTitle($field)
	{
		global $language;
		global $dbH; 

		$field = str_replace(",","','",$field);

		$list = array();
		$blist=array();
		/// 코드가 사용이거나 odStatus(주문상태)가 아닐경우만 리스트로 뽑아오기 
		$wsql=" where cd_use <> 'D' and cd_type in ('".$field."')";
		$sql=" select ";
		$sql.=" cd_seq,cd_type,cd_type_".$language." as cdType ,cd_code,cd_name_".$language." as cdName, cd_sort ";
		$sql.=",cd_desc_".$language." as cdDesc ";
		$sql.=" ,cd_value_".$language." as cdValue ";
		$sql.=" ,to_char(cd_date, 'yyyy-mm-dd hh24:mi:ss') as cdDate";
		$sql.=" from ".$dbH."_code $wsql order by cd_type ASC, cd_sort ASC ";
		$res=dbqry($sql);
		while($dt=dbarr($res))
		{
			$addarray = array(
				"seq"=>$dt["CD_SEQ"],
				"cdType"=>$dt["CD_TYPE"], 
				"cdTypeTxt"=>$dt["CDTYPE"], 
				"cdCode"=>$dt["CD_CODE"], 
				"cdName"=>$dt["CDNAME"], 
				"cdDesc"=>getClob($dt["CDDESC"]), 
				"cdSort"=>$dt["CD_SORT"], 
				"cdValue"=>getClob($dt["CDVALUE"]), 
				"cdDate"=>$dt["CDDATE"]
				);

			array_push($blist[$dt["CD_CODE"]]=$addarray);
			$list[$dt["CD_TYPE"]][]=$blist[$dt["CD_CODE"]];
		}
		return $list;
	}
	/// =========================================================================
	///  20200403(OK)
	///   함수 명     : getodStatus()
	///   함수 설명   : 주문상태값 넘기기 
	///   페러미터    : $list -> getCodeTitle 함수에서 쿼리해온 리스트 데이터 
	/// 				  $status -> 주문상태 값
	/// =========================================================================
	function getodStatus($list, $status, $color='false')
	{
		$chkstat=explode("_",$status);
		$substat=$chkstat[0];
		$substat2=$chkstat[1];

		for($i=0;$i<count($list["odStatus"]);$i++)
		{
			if($list["odStatus"][$i]["cdCode"] == $substat)
			{
				$statName = $list["odStatus"][$i]["cdName"];
			}
			if($list["odStatus"][$i]["cdCode"] == $substat2)
			{
				if($substat2 == 'stop')
				{
					$statName2="<span style=color:purple;'>".$list["odStatus"][$i]["cdName"]."</span>";
				}
				else if($substat2 == 'cancel')
				{
					$statName2="<span style=color:red;'>".$list["odStatus"][$i]["cdName"]."</span>";
				}
				else
				{
					$statName2 = $list["odStatus"][$i]["cdName"];
				}
			}
		}
		return $statName." ".$statName2;

	}
	/// =========================================================================
	///  20200403(OK)
	///  함수 명     : getMatypeName()
	///  함수 설명   : 조제타입명 
	/// =========================================================================
	function getMatypeName($od_matype, $od_matypeName, $od_goods, $rc_source)
	{
		if($od_goods=="G")
		{
			$maTypeName=$od_matypeName."(사전)";
		}
		else if($od_goods=="Y")
		{
			if($rc_source)
			{
				$maTypeName=$od_matypeName."(재고)";
			}
			else
			{
				$maTypeName=$od_matypeName."(상품)";
			}
		}
		else if($od_goods=="M")
		{
			$maTypeName=$od_matypeName."(첩제)";
		}
		else if($od_goods=="P")
		{
			$maTypeName=$od_matypeName."(기획)";
		}
		else
		{
			if($od_matype=="decoction")
			{
				$maTypeName=$od_matypeName;
			}
			else
			{
				$maTypeName=$od_matypeName."(탕제)";
			}
		}
		return $maTypeName;
	}
	/// =========================================================================
	///   20200403(OK)
	///   함수 명     : getMedicineList()
	///   함수 설명   : 약재리스트   
	/// =========================================================================
	function getMedicineList($tbl, $code)
	{
		global $language;
		global $dbH;
		global $refer;

		$sql=" select ";
		$sql.=" rc_medicine as RCMEDICINE, rc_sweet as RCSWEET ";
		$sql.=" from ".$dbH."_recipe".$tbl." where rc_code='".$code."'";

		$dt=dbone($sql);
		$medicine=getClob($dt["RCMEDICINE"]).getClob($dt["RCSWEET"]);
		$arr=explode("|",substr($medicine,1));
		$seqarr=$capaarr="";
		$medicnt=$medicapa=0;
		foreach($arr as $val)
		{
			$arr1=explode(",",$val);
			$seqarr.=",".$arr1[0];
			$capaarr.=",".$arr1[1];
			$decocarr.=",".$arr1[2];
			$medicapa+=$arr1[1];
			$medicnt++;
		}
		$seqarr=substr($seqarr,1);
		$seqarr=str_replace(",","','",$seqarr);
		$sql=" select a.md_code, a.md_origin_".$language." origin, a.md_poison, a.md_dismatch ";
		$sql.=" , r.mm_title_".$language." mediname, r.mm_code ";
		$sql.=" from ".$dbH."_medicine a ";
		$sql.=" inner join ".$dbH."_medicine_".$refer." r on a.md_code=r.md_code  ";
		$sql.=" where a.md_code in ('".$seqarr."') ";
		$sql.=" order by decode(a.md_code,'".$seqarr."')";

		$medilist["sql"]=$sql;
		//$medilist["list"]=dbqry($sql);
		$medilist["medicine"]=$medicine;
		$medilist["medicnt"]=$medicnt;
		$medilist["medicapa"]=$medicapa;
		$medilist["capaarr"]=explode(",",substr($capaarr,1));
		$medilist["decocarr"]=explode(",",substr($decocarr,1));
		return $medilist;
	}
	/// =========================================================================
	///   20200403(OK)
	///   함수 명     : getDecoCodeTitle()
	///   함수 설명   : han_txtdata 선전,일반,후하 리스트 
	/// =========================================================================
	function getDecoCodeTitle($state='3')
	{
		global $language;
		global $dbH; 		

		if($state=='all')
		{
			$sql=" select td_code, td_name_".$language." as td_name from ".$dbH."_txtdata where td_code in ('infirst','inmain','inafter','inlast') order by decode(td_code, 'infirst','1','inmain','2','inafter','3','inlast','4')";
		}
		else
		{
			$sql=" select td_code, td_name_".$language." as td_name from ".$dbH."_txtdata where td_code in ('infirst','inmain','inafter') order by decode(td_code, 'infirst','1','inmain','2','inafter','3')";
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
	/// =========================================================================
	///   20200406(OK)
	///   함수 명     : getBoilerList()
	///   함수 설명   : 보일러리스트 
	/// =========================================================================
	function getBoilerList()
	{
		global $dbH;

		$sql=" select bo_code,bo_odcode,bo_title,bo_locate,bo_top,bo_left,bo_status  from ".$dbH."_boiler  where bo_use='Y' order by bo_code asc ";
		$res=dbqry($sql);
		$list = array();
		while($dt=dbarr($res))
		{
			switch($dt["BO_STATUS"])
			{
			case "standby":$statustxt="대기";
				break;
			case "ready":$statustxt="준비중";
				break;
			case "end":$statustxt="완료";
				break;
			case "repair":$statustxt="고장수리중";
				break;
			case "disposal":$statustxt="폐기";
				break;
			case "space":
				$statustxt="예정";
				break;
			case "ing":
				$statustxt="진행중";
				break;
			case "hold":
				$statustxt="선택";
				break;
			case "sticky":
				$statustxt="농축기";
				break;
			}

			$addarray=array(
				"bo_code"=>$dt["BO_CODE"],
				"bo_odcode"=>$dt["BO_ODCODE"],
				"bo_title"=>$dt["BO_TITLE"],
				"bo_locate"=>$dt["BO_LOCATE"],
				"bo_top"=>$dt["BO_TOP"],
				"bo_left"=>$dt["BO_LEFT"],
				"bo_status"=>$dt["BO_STATUS"],
				"statustxt"=>$statustxt
			);
			array_push($list, $addarray);
		}

		return $list;
	}
	/// =========================================================================
	///   20200406(OK)
	///   함수 명     : getpackingList()
	///   함수 설명   : 포장기리스트 
	/// =========================================================================
	function getpackingList()
	{
		global $dbH;
		$sql=" select pa_code,pa_odcode,pa_title,pa_locate,pa_top, pa_left,pa_status from ".$dbH."_packing where pa_use='Y' order by pa_code asc ";
		$res=dbqry($sql);
		$list = array();
		while($dt=dbarr($res))
		{
			switch($dt["PA_STATUS"])
			{
			case "standby":$statustxt="대기";
				break;
			case "ready":$statustxt="준비중";
				break;
			case "end":$statustxt="완료";
				break;
			case "repair":$statustxt="고장수리중";
				break;
			case "disposal":$statustxt="폐기";
				break;
			case "ing":
				$statustxt="포장중";
				break;
			case "hold":
				$statustxt="선택";
				break;
			}

			$addarray=array(
				"pa_code"=>$dt["PA_CODE"],
				"pa_odcode"=>$dt["PA_ODCODE"],
				"pa_title"=>$dt["PA_TITLE"],
				"pa_locate"=>$dt["PA_LOCATE"],
				"pa_top"=>$dt["PA_TOP"],
				"pa_left"=>$dt["PA_LEFT"],
				"pa_status"=>$dt["PA_STATUS"],
				"statustxt"=>$statustxt
			);
			array_push($list, $addarray);
		}

		return $list;
	}
	/// =========================================================================
	///   20200406(OK)
	///   함수 명     : getNewMediCode()
	///   함수 설명   : __약재코드에 있는지 체크  
	/// =========================================================================
	function getNewMediCode($code)
	{
		if(strpos($code, "__") !== false)/// 약재code에 __이 있다면 
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
	/// =========================================================================
	///   함수 명     : makehour()
	///   함수 설명   : 시간 표현 
	/// =========================================================================
	function makehour($minute)
	{
		global $txtdt;
		$time1 = intval(abs($minute) / 60); 
		if($time1<10)$time1="0".$time1;
		$time2 = abs($minute) % 60;
		if($time2<10)$time2="0".$time2;
		if($time1){$strtxt.=$time1."[1]";}
		if($time2){$strtxt.=" ".$time2."[2]";}
		$str["no"]=$time1.":".$time2;
		$str["txt"]=$strtxt;
		return $str; 
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
	/// 20200325:암호화(OK)
	function djEncrypt($data, $authkey)
	{
		$crypt_iv = "abcdefghij123456";//"#@$%^&*()_+=-";
		$endata = openssl_encrypt($data, 'aes-256-cbc', $authkey, true, $crypt_iv);
		$endata = base64_encode($endata);
		return $endata;
	}
	/// 20200325:복호화(OK)
	function djDecrypt($endata, $authkey)
	{
		$crypt_iv = "abcdefghij123456";//"#@$%^&*()_+=-";
		$data = base64_decode($endata);
		$endata = openssl_decrypt($data, "aes-256-cbc", $authkey, true, $crypt_iv);
		return $endata;
	}
	function randmix($no)
	{
		$chars = "ABCDEFGHJKLMNPQRSTUVWXYZ0123456789";
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
	///////////////////////
	///안쓰는거 삭제 해야함 


	function viewdate($date)
	{
		return date("Y.m.d",strtotime($date));
	}
	function viewdateH($date)
	{
		return date("Y.m.d H:i",strtotime($date));
	}
	function viewdateD($date)
	{
		return date("m/d H:i",strtotime($date));
	}	










	/// =========================================================================
	///   함수 명     : getafFile()
	///   함수 설명   : 이미지 관련 url 
	/// =========================================================================
	function getafFile($afurl) /// 원본이미지 크기 
	{
		$afFile="NoIMG";
		if($afurl)
		{
			if(strtolower($afurl)=="noimg")
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
	function getafThumbUrl($afurl)/// 썸네일이미지 (작은사이즈)
	{
		$afThumbUrl="NoIMG";
		if($afurl)
		{
			if(strtolower($afurl)=="noimg")
			{
				$afFile="NoIMG";
			}
			else
			{
				$iarr = explode("/",$afurl);
				$iarr = insert_array($iarr, sizeof($iarr)-1, "thumb");
				$thumbName = implode( '/', $iarr );
				$afThumbUrl=$thumbName;
			}
		}
		return $afThumbUrl;
	}
	function insert_array($arr, $idx, $add)
	{
		$arr_front = array_slice($arr, 0, $idx); /// 처음부터 해당 인덱스까지 자름
		$arr_end = array_slice($arr, $idx); /// 해당인덱스 부터 마지막까지 자름
		$arr_front[] = $add;/// 새 값 추가
		return array_merge($arr_front, $arr_end);
	}



	function getNewExcelTitle($code)
	{
		if(strpos($code, "__") !== false)/// 약재code에 __이 있다면 
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

	/*function getPillCodeList()
	{
		return array("making","smash","decoction","concent","juice","mixed","warmup","ferment","plasty","dry","packing");
	}
	function getPillCodeNameList()
	{
		return array("조제","분쇄","탕전","농축","착즙","혼합","중탕","숙성","제형","건조","포장");
	}
	*/
	function getPillTypeName($list,$pilltype)
	{
		$pilltypeName="";
		for($i=0;$i<count($list);$i++)
		{
			if($list[$i]["cdCode"]==$pilltype)
			{
				$pilltypeName=$list[$i]["cdName"];
				break;
			}
			
		}
		return $pilltypeName;
	}
	function calcAge($birth)
	{
		$birthday = date("Ymd", strtotime($birth));///생년월일
		$nowday = date("Ymd");///현재날짜
		$age = floor(($nowday - $birthday) / 10000);
		return $age;
	}
?>