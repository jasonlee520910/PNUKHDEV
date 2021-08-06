<?php 
	function curl_get($domain,$url,$code,$data)
	{
		$language=$_COOKIE["ck_language"];
		if(!$language){$language="kor";}
		$url=$domain."".$url."/?apiCode=".$code."&language=".$language."&".$data;
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL,$url);
		curl_setopt($ch, CURLOPT_POST, 0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('ck_authkey:'.urlencode($_COOKIE["ck_authkey"]), 'ck_stStaffid:'.$_COOKIE["ck_stStaffid"]));
		$result = curl_exec($ch);
		curl_close ($ch);
		return $result;
	}
	function curl_getFile($url)
	{
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL,$url);
		curl_setopt($ch, CURLOPT_POST, 0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		
		$result = curl_exec($ch);
		curl_close($ch);

		return $result;
	}
	function isEmpty($value)
	{
		if( $value == "" || $value == null || $value == NULL || empty($value) || $value == "null")
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
	function logOutCookie($url)
	{
		$past = time() - 3600; 
		foreach ( $_COOKIE as $key => $value ) {  unset($_COOKIE[$key]); setcookie( $key, "", $past, '/'); } 
		header("Location: ".$url); 
	}
	function checkSession($url)
	{
		//세션이 있는지 여부 체크 (로그인)
		if(!isset($_COOKIE["ck_stUserid"]) || isEmpty($_COOKIE["ck_stUserid"]))
		{
			logOutCookie($url);
		}
		else
		{
			switch($_COOKIE["ck_stDepart"])
			{
			case "manager":case "admin":case "pharmacist"://20191104:약사추가 
				break;
			default:
				logOutCookie($url);
				break;
			}
		}

	}


	//기간선택
	function selectperiod()
	{
		global $txtdt;
		global $file;
		$sdate = $_GET["sdate"];
		$edate = $_GET["edate"];
		if($sdate && $edate)
		{
			$sdate=str_replace("-",".",$sdate);//시작날짜
			$edate=str_replace("-",".",$edate);//끝 날짜
		}
		else
		{
			$sdate="";
			$edate="";
		}
		$str="";
		//api에서 주문일과 배송요청일 둘다 검색하자
		//나중에 정렬만 추가 하자
		//1186 : 시작일 입력해 주세요.
		//1299 : 종료일 입력해 주세요.
		//$str.="</select>";
		$str="<input title='".$txtdt["1186"]."' value='".$sdate."' class='reqdata searperiod' type='text' id='sdate' name='sdate' readonly> ";
		$str.=" ~ ";
		$str.="<input title='".$txtdt["1299"]."' value='".$edate."' class='reqdata searperiod' type='text' id='edate' name='edate' readonly> ";

		$carr=array("today","yesterday","week","month","month3","month4","all");
		//$tarr=array("오늘","어제","1주","1개월","3개월","6개월","전체");
		$tarr=array($txtdt["1228"],$txtdt["1221"],$txtdt["1004"],$txtdt["1003"],$txtdt["1011"],$txtdt["1013"],$txtdt["1284"]);

		for($i=0;$i<count($carr);$i++)
		{
			//if($_GET["searPeriodEtc"]==$carr[$i]){$checked=" checked";}else{$checked=" ";}
			if(strpos($_GET["searPeriodEtc"],$carr[$i])){$checked="checked";}else{$checked="";}
			$str.="<span class='chkradio'> ";
			$str.="<input type='radio' id='jon-".$i."' name='searPeriodEtc' class='searPeriodEtc".$carr[$i]."' onclick='setperiod(this.value)' value='".$carr[$i]."' ".$checked."/> ";
			$str.="<label for='jon-".$i."'>".$tarr[$i]."</label> ";
			$str.="</span>";
		}

		return $str;
	}
	//주문상태별
	function selectstatus()
	{
		global $txtdt;
		global $file;
		switch($file)
		{
			case "OrderList":
				//$carr=array("order","paid","cancel","making","decoction","marking","packing","release","done","stop");
				//$tarr=array("입금확인","작업지시","취소","조제","탕전","마킹","포장","배송","완료","중지");
				//$tarr=array($txtdt["1268"],$txtdt["1279"],$txtdt["1356"],$txtdt["1291"],$txtdt["1361"],$txtdt["1076"],$txtdt["1391"],$txtdt["1105"],$txtdt["1230"],$txtdt["1315"]);

				//$carr=array("order","paid","cancel","making","decoction","marking","release","done","stop");
				//$tarr=array("입금확인","작업지시","취소","조제","탕전","마킹","포장&배송","완료","중지");
				//$tarr=array($txtdt["1268"],$txtdt["1279"],$txtdt["1356"],$txtdt["1291"],$txtdt["1361"],$txtdt["1076"],$txtdt["1391"].'&'.$txtdt["1105"],$txtdt["1230"],$txtdt["1315"]);

				//$carr=array("paid","cancel","making_apply","making","done","stop");
				//$tarr=array("작업대기","취소","조제대기","조제","완료","중지");
				//$tarr=array($txtdt["1740"],$txtdt["1356"],$txtdt["1756"],$txtdt["1291"],$txtdt["1230"],$txtdt["1315"]);
				//20190416 : 조제는 제외 
				//$carr=array("paid","cancel","making_apply","done","stop");
				//$tarr=array("작업대기","취소","조제대기","완료","중지");
				//$tarr=array($txtdt["1740"],$txtdt["1356"],$txtdt["1756"],$txtdt["1230"],$txtdt["1315"]);

				//20190507 : 탕전,마킹,포장&배송추가  //20190516 주문/접수 추가
				//$carr=array("order","paid","cancel","making","decoction","marking","release","done","stop");
				//$tarr=array("주문/접수","작업대기","취소","조제","탕전","마킹","포장&배송","완료","중지");
				//$tarr=array($txtdt["1781"],$txtdt["1740"],$txtdt["1356"],$txtdt["1291"],$txtdt["1361"],$txtdt["1076"],$txtdt["1391"].'&'.$txtdt["1105"],$txtdt["1230"],$txtdt["1315"]);

				//20190905 : 작업진행별 추가때문에 취소,중지는 빼기 
				$carr=array("order","paid","making","decoction","marking","release","goods","done");
				//$tarr=array("주문/접수","작업대기","조제","탕전","마킹","포장","약속","완료");
				$tarr=array($txtdt["1781"],$txtdt["1740"],$txtdt["1291"],$txtdt["1361"],$txtdt["1076"],$txtdt["1391"],$txtdt["1937"],$txtdt["1230"]);
				break;
			case "MemberList": case "DoctorList":
				$carr=array("confirm","standby","delete","reject");
				//$tarr=array("승인","대기","탈퇴","차단");
				$tarr=array($txtdt["1185"],$txtdt["1055"],$txtdt["1360"],$txtdt["1318"]);
				break;
			case "UniquePrescriptionList":
				$carr=array("F","Y");
				//$tarr=array("승인","미승인");
				$tarr=array($txtdt["1185"],$txtdt["1448"]);
				break;
			case "PouchTag":
				$carr=array("infirst","inmain","inafter","inlast");
				//$tarr=array("선전","일반","후하","별전");
				$tarr=array($txtdt["1171"],$txtdt["1251"],$txtdt["1420"],$txtdt["1115"]);
				break;
			case "PotCode":
				$carr=array("standby","ready","ing","finish","repair","disposal");
				//$tarr=array("대기","준비중","사용중","완료","고장수리중","폐기");
				$tarr=array($txtdt["1055"],$txtdt["1466"],$txtdt["1149"],$txtdt["1230"],$txtdt["1027"],$txtdt["1390"]);
				break;
			case "PackagingCode":
				$carr=array("odPacktype","reBoxmedi","reBoxdeli", "rePot","reStick","rejewanBox");
				//$tarr=array("파우치","포장박스","배송박스","항아리","스틱","제환박스");=> 한약박스, 포장박스
				$tarr=array($txtdt["1470"],$txtdt["1468"],$txtdt["1469"], $txtdt["1802"], $txtdt["1803"], $txtdt["1804"]);
				break;
			case "Goods":
				//$carr=array("goods","pregoods","origin","material");
				//$tarr=array("제품","반제품","원재료","부자재");
				$carr=array("goods","pregoods","material","commercial","goodsdecoction");
				$tarr=array("제품","반제품","부자재","상비","약속탕전");
				//$tarr=array($txtdt["1470"],$txtdt["1468"],$txtdt["1469"], $txtdt["1802"], $txtdt["1803"], $txtdt["1804"]);
				break;
			case "GoodsLog":  //제품입출고목록
				$carr=array("goods","pregoods","material");
				$tarr=array("제품","반제품","부자재");
				break;
			case "Equipment":  //장비관리
				$carr=array("standby","ready","ing","finish","repair","disposal");
				//$tarr=array("대기","준비중","사용중","완료","고장수리중","폐기");
				$tarr=array($txtdt["1055"],$txtdt["1466"],$txtdt["1149"],$txtdt["1230"],$txtdt["1027"],$txtdt["1390"]);
				break;
		}
		$str="";
		for($i=0;$i<count($carr);$i++)
		{
			if(strpos($_GET["searchStatus"],$carr[$i])){$cls="checked";}else{$cls="";}
			$str.="<span class='chkbox'> ";
			$str.="<input type='checkbox' id='etc".$i."' value='".$carr[$i]."' name='searchStatus' class='searcls searchStatus".$carr[$i]."' onclick='searcls()' ".$cls."/> ";
			$str.="<label for='etc".$i."'>".$tarr[$i]."</label> ";
			$str.="</span> ";
		}
		return $str;
	}
	function selectprogress()
	{
		global $txtdt;
		global $file;
		switch($file)
		{
			case "OrderList":
				$carr=array("apply","processing","stop","cancel","done");
				//$tarr=array("대기","진행","중지","취소","완료");
				$tarr=array($txtdt["1055"],$txtdt["1317"],$txtdt["1315"],$txtdt["1356"],$txtdt["1230"]);
				break;
			case "GoodsLog":  //제품구분			
				//$tarr=array("대기","진행","중지","취소","완료");
				//$tarr=array($txtdt["1055"],$txtdt["1317"],$txtdt["1315"],$txtdt["1356"],$txtdt["1230"]);
				$carr=array("produce","use","disposal","return");
				$tarr=array("생산","사용","폐기","반품");				
				break;
		}
		$str="";
		for($i=0;$i<count($carr);$i++)
		{
			if(strpos($_GET["searchProgress"],$carr[$i])){$cls="checked";}else{$cls="";}
			$str.="<span class='chkbox'> ";
			$str.="<input type='checkbox' id='etcp".$i."' value='".$carr[$i]."' name='searchProgress' class='searprocls searchProgress".$carr[$i]."' onclick='searprocls()' ".$cls."/> ";
			$str.="<label for='etcp".$i."'>".$tarr[$i]."</label> ";
			$str.="</span> ";
		}
		return $str;
	}
	function selectmatype()
	{
		global $txtdt;
		global $file;
		switch($file)
		{
			case "OrderList":
				$carr=array("decoction","goods","commercial","goodsmaking");
				$tarr=array("탕제","약속","상비","사전");
				//$carr=array("decoction","worthy","goods","commercial","goodsmaking");
				//$tarr=array("탕제","실속","약속","상비","사전");
				//$tarr=array($txtdt["1055"],$txtdt["1317"],$txtdt["1315"],$txtdt["1356"],$txtdt["1230"]);
				break;
			case "GoodsLog":  //제품입출고목록
				//$carr=array("milling","mixedmilling","shape","solid");				
				//$tarr=array("제분","혼합제분","제형","고");
				$carr=array("milling","mixedmilling","shape");
				$tarr=array("제분","혼합제분","제형");
				//$tarr=array($txtdt["1055"],$txtdt["1317"],$txtdt["1315"],$txtdt["1356"],$txtdt["1230"]);
				break;
			case "Goods":
				$carr=array("kok","gbh","kgd","org","nyr","sky");
				$tarr=array("경옥고","감비환","공진단","협력기관","설기획","하늘체");
				//$tarr=array($txtdt["1470"],$txtdt["1468"],$txtdt["1469"], $txtdt["1802"], $txtdt["1803"], $txtdt["1804"]);
				break;
		}
		$str="";
		for($i=0;$i<count($carr);$i++)
		{
			if(strpos($_GET["searchMatype"],$carr[$i])){$cls="checked";}else{$cls="";}
			$str.="<span class='chkbox'> ";
			$str.="<input type='checkbox' id='etcm".$i."' value='".$carr[$i]."' name='searchMatype' class='searmatypecls searchMatype".$carr[$i]."' onclick='searmatypecls()' ".$cls."/> ";
			$str.="<label for='etcm".$i."'>".$tarr[$i]."</label> ";
			$str.="</span> ";
		}
		return $str;
	}
	function selectdelitype()
	{
		global $txtdt;
		global $file;
		switch($file)
		{
			case "DeliveryList":
				//$carr=array("logen","post","direct");
				//$tarr=array("로젠","우체국","직배");
				$carr=array("post","direct");
				$tarr=array("우체국","직배");
				break;
		}
		$str="";
		for($i=0;$i<count($carr);$i++)
		{
			if(strpos($_GET["searchDelitype"],$carr[$i])){$cls="checked";}else{$cls="";}
			$str.="<span class='chkbox'> ";
			$str.="<input type='checkbox' id='etcm".$i."' value='".$carr[$i]."' name='searchDelitype' class='seardelitypecls searchDelitype".$carr[$i]."' onclick='seardelitypecls()' ".$cls."/> ";
			$str.="<label for='etcm".$i."'>".$tarr[$i]."</label> ";
			$str.="</span> ";
		}
		return $str;
	}
	//검색
	function selectsearch()
	{
		global $txtdt;
		global $file;
		$pop = false;
		//echo 'selectsearch : '.$file.','.$_GET["type"].'<br>';
		$deli="";
		switch($file)
		{
		case "layer-recipe": //주문리스트 > 주문내역 > 처방검색버튼 클릭시 나오는 화면
			switch($_GET["type"])
			{
			case "Unique":
				//$carr=array("rcSourceTxt","rcTitle");
				//$tarr=array($txtdt["1462"],$txtdt["1323"]);
				$carr=array("rcTitle");
				//$tarr=array("처방명");
				$tarr=array($txtdt["1323"]);
				$pop = true;
				break;
			case "General":
				$carr=array("reName");
				//$tarr=array("환자명");
				$tarr=array($txtdt["1414"]);
				$pop = true;
				break;
			case "smu":
				$carr=array("rcSourceTxt","rcTitle");
				//$tarr=array("처방집","처방명");
				$tarr=array($txtdt["1462"],$txtdt["1323"]);
				$pop = true;
				break;
			case "worthy":  //실속처방
				$carr=array("rcTitle");
				//$tarr=array("처방집","처방명");
				$tarr=array($txtdt["1323"]);
				$pop = true;
				break;
			case "commercial":  //상비처방
				$carr=array("rcTitle");
				//$tarr=array("처방집","처방명");
				$tarr=array($txtdt["1323"]);
				$pop = true;
				break;
			case "recipegoods":  //약속처방
				$carr=array("rcTitle");
				//$tarr=array("처방집","처방명");
				$tarr=array($txtdt["1323"]);
				$pop = true;
				break;
			case "goods":  
				$carr=array("rcTitle");
				//$tarr=array("처방집","처방명");
				$tarr=array($txtdt["1323"]);
				$pop = true;
				break;
			case "pill":  
				$carr=array("rcTitle");
				//$tarr=array("처방집","처방명");
				$tarr=array($txtdt["1323"]);
				$pop = true;
				break;
			}
			break;
		case "layer-medicine":
		case "layer-medicinesmu":
			$carr=array("mdTitle","mhTitle");
			//$tarr=array("약재명","본초명");
			$tarr=array($txtdt["1204"],$txtdt["1124"]);
			$pop = true;
			break;
		case "layer-recipebook":
			$carr=array("rbCode","rbTitle","rbIndex","rbBookno");
			//$tarr=array("처방코드","처방서적","대목차","책번호");
			$tarr=array($txtdt["1463"],$txtdt["1324"],$txtdt["1057"],$txtdt["1319"]);
			$pop = true;
			break;
		case "DeliveryList":
			//echo "searchdelibk:".$_GET["searchdelibk"]."/";
			if(strpos($_GET["searchdelibk"],"Y")){$val="Y";$cls="checked";}else{$val="N";$cls="";}

			//$deli="버키<input type='checkbox' name='searchdelibk' id='bkchk' class='searchdelibk' value='".$val."' onclick='seardelitypecls()' ".$cls.">";
			break;
		}

		$str = "";
		$str.=$deli;
		if($pop)
		{
			//없애면 리스트페이지로 간다.. 그래서 일단은 안보이게 수정 
			$typestyle="";
			if($_GET["type"]=="Unique" || $_GET["type"]=="General" || $_GET["type"]=="worthy" || $_GET["type"]=="commercial" || $_GET["type"]=="goods")
			{
				$typestyle="display:none;";
			}
			$str="<select title='".$txtdt["1172"]."' name='searchType' class='searselect_pop' style='".$typestyle."'>";
			if($_GET["searchType"]==""){$cls=" selected";}else{$cls=" ";}
			for($i=0;$i<count($carr);$i++){
				if($_GET["searchType"]==$carr[$i]){$cls=" selected";}else{$cls=" ";}
				$str.="<option value='".$carr[$i]."' ".$cls.">".$tarr[$i]."</option>";
			}

			//==========================================================
			//수기처방, 고유처방 약재검색시 앰플들은 검색안되게 하기 위함.
			$_GET["reData"]="";
			if($_GET["type"] == "order") 
			{
				$_GET["reData"]="order";
			}
			else if($_GET["type"] == "Unique") 
			{
				$_GET["reData"]="Unique";
			}
			else if($_GET["type"] == "worthy") //실속
			{
				$_GET["reData"]="worthy";
			}
			else if($_GET["type"] == "general") //실속
			{
				$_GET["reData"]="general";
			}
			else if($_GET["type"] == "commercial") //상비
			{
				$_GET["reData"]="commercial";
			}
			else if($_GET["type"] == "recipegoods") //약속
			{
				$_GET["reData"]="recipegoods";
			}
			else if($_GET["type"] == "goods") 
			{
				$_GET["reData"]="goods";
			}
			else if($_GET["type"] == "stock")
			{
				$_GET["reData"]="stock";
			}
			else if($_GET["type"] == "medicinesmu")
			{
				$_GET["reData"]="medicinesmu";
			}
			else if($_GET["type"] == "GoodsMedicine")  //제품 원재료관리에서 약재명 검색
			{
				$_GET["reData"]="GoodsMedicine";
			}
			else if($_GET["type"] == "medibox")
			{
				$_GET["reData"]="medibox";
			}
			//==========================================================

			$str.="</select> ";
			$str.="<input value='".$_GET["searchTxt"]."' type='text' id='searchTxt' name='searchTxt' title='".$txtdt["1021"]."' class='reqdata seartext_pop' onkeydown='searchpopkeydown(event,\"".$_GET["reData"]."\")'> ";
			$str.="<button class='sdp-btn' type='button' onclick='searchpopbtn(\"".$_GET["reData"]."\")'><span>".$txtdt["1020"]."</span></button> ";
		}
		else
		{
			$str.="<input value='".$_GET["searchTxt"]."' type='text' id='searchTxt' name='searchTxt' title='".$txtdt["1021"]."' class='reqdata seartext' onkeydown='searchkeydown(event)'> ";
			$str.="<button class='sdp-btn' type='button' onclick='searchbtn()'><span>".$txtdt["1020"]."</span></button> ";
		}

		return $str;
	}

	//한의원관리 > 상태별 검색
	function statusType()
	{
		global $txtdt;
		global $file;
		switch($file)
		{
			case "OrderList":
				//$carr=array("order","paid","cancel","making","decoction","marking","packing","release","done","stop");
				//$tarr=array("입금확인","작업지시","취소","조제","탕전","마킹","포장","배송","완료","중지");
				//$tarr=array($txtdt["1268"],$txtdt["1279"],$txtdt["1356"],$txtdt["1291"],$txtdt["1361"],$txtdt["1076"],$txtdt["1391"],$txtdt["1105"],$txtdt["1230"],$txtdt["1315"]);

				$carr=array("order","paid","making","decoction","marking","release","done","stop");
				//$tarr=array("입금확인","작업지시","조제","탕전","마킹","포장&배송","완료","중지");
				$tarr=array($txtdt["1268"],$txtdt["1279"],$txtdt["1291"],$txtdt["1361"],$txtdt["1076"],$txtdt["1391"].'&'.$txtdt["1105"],$txtdt["1230"],$txtdt["1315"]);
				break;
			case "MemberList": case "DoctorList":
				$carr=array("confirm","standby","delete","reject");
				//$tarr=array("승인","대기","탈퇴","차단");
				$tarr=array($txtdt["1185"],$txtdt["1055"],$txtdt["1360"],$txtdt["1318"]);
				break;
			case "UniquePrescriptionList":
				$carr=array("F","Y");
				//$tarr=array("승인","미승인");
				$tarr=array($txtdt["1185"],$txtdt["1448"]);
				break;
			case "PouchTag":
				$carr=array("infirst","inmain","inafter","inlast");
				//$tarr=array("선전","일반","후하","별전");
				$tarr=array($txtdt["1171"],$txtdt["1251"],$txtdt["1420"],$txtdt["1115"]);
				break;
			case "PotCode":
				$carr=array("standby","ready","ing","finish","repair","disposal");
				//$tarr=array("대기","준비중","사용중","완료","고장수리중","폐기");
				$tarr=array($txtdt["1055"],$txtdt["1466"],$txtdt["1149"],$txtdt["1230"],$txtdt["1027"],$txtdt["1390"]);
				break;
			case "PackagingCode":
				$carr=array("odPacktype","reBoxmedi","reBoxdeli");
				//$tarr=array("파우치","포장박스","배송박스");=> 한약박스, 포장박스
				$tarr=array($txtdt["1470"],$txtdt["1468"],$txtdt["1469"]);
				break;
		}
		$str="";
		for($i=0;$i<count($carr);$i++)
		{
			if(strpos($_GET["searchStatus"],$carr[$i])){$cls="checked";}else{$cls="";}
			$str.="<span class='chkbox'> ";
			$str.="<input type='checkbox' id='etc".$i."' value='".$carr[$i]."' name='searchStatus' class='searcls searchStatus".$carr[$i]."' onclick='searcls()' ".$cls."/> ";
			$str.="<label for='etc".$i."'>".$tarr[$i]."</label> ";
			$str.="</span> ";
		}
		return $str;
	}

	function selectsugar($name)
	{
		global $txtdt;
		global $odData;
		$list=array();
		$data="";
		$title="";

		$list=$odData["dcSugarList"];
		$data=($odData["dcSugarCode"])?$odData["dcSugarCode"]:"";
		$title="감미제";
		$miGrade=($odData["miGrade"])?$odData["miGrade"]:"E";

		$str='<select class="reqdata resetcode w20p" name="'.$name.'" id="'.$name.'" title="'.$title.'"  onchange="codeChange(this);">';
		$str.='<option value="" data-capa="0" data-price="0">없음</option>';
		foreach($list as $key => $value)
		{
			$selected="";
			if($data == $list[$key]["mdCode"])
			{
				$selected = "selected";
			}
			$sugarprice= $list[$key]["mdPrice".$miGrade];//한의원등급에 따라서 달라져야함 
			$str.="<option value='".$list[$key]["mdTitle"]."' ".$selected." data-code='".$list[$key]["mdCode"]."' data-capa='".$list[$key]["mdCapa"]."' data-price='".$sugarprice."' >".$list[$key]["mdTitle"]."</option>";
		}

		$str.="</select>";
		$str.="<input type='hidden' name='dcSugarData' class='reqdata'  value='' readonly />";
		return $str;
	}

	//탕전 select box 
	function selectdecoction($name)
	{
		global $txtdt;
		global $odData;

		//var_dump($odData);
		$list=array();
		$data="";
		$title="";
		$miGrade=($odData["miGrade"])?$odData["miGrade"]:"E";
		switch($name)
		{
		case "dcTitle"://탕전법 
			$list=$odData["dcTitleList"];			
			$data=($odData["dcTitle"])?$odData["dcTitle"]:"decoctype03";
			$title=$txtdt["1367"];
			break;
		case "dcSpecial"://특수탕전
			$list=$odData["dcSpecialList"];
			$data=($odData["dcSpecial"])?$odData["dcSpecial"]:"spdecoc01";
			$dcSpecialPrice=($odData["dcSpecialPrice"])?$odData["dcSpecialPrice"]:"0";
			$title=$txtdt["1369"];

			if($data=="spdecoc03")//주수상반
			{
				echo '<script>$("#speDiv").show();</script>';
			}
			else
			{
				echo '<script>$("#speDiv").hide();</script>';
			}
			break;
		}

		$str='<select class="reqdata resetcode w50p" name="'.$name.'" id="'.$name.'" title="'.$title.'" onchange="codeChange(this);" >';

		foreach($list as $key => $value)
		{
			$selected="";
			$dcPrice=0;
			if($data == $list[$key]["cdCode"])
			{
				$selected = "selected";
				$dcPrice=$dcSpecialPrice;
			}
			else
			{
				if($list[$key]["cdCode"]=="spdecoc01")//특수탕전없음
				{
					$dcPrice=0;
				}
				else if($list[$key]["cdCode"]=="spdecoc03")//주수상반
				{
					$dcPrice=$list[$key]["cdPrice".$miGrade];
				}
				else if($list[$key]["cdCode"]=="spdecoc05")//증류탕전
				{
					$dcPrice=$list[$key]["cdPrice".$miGrade];
				}
				else if($list[$key]["cdCode"]=="spdecoc06")//건조탕전
				{
					$dcPrice=$list[$key]["cdPrice".$miGrade];
				}
			}
			$str.="<option value='".$list[$key]["cdCode"]."' ".$selected." data-value='".$list[$key]["cdDesc"]."' data-price='".$dcPrice."'>".$list[$key]["cdName"]."</option>";
		}

		$str.="</select>";

		if($name=="dcSpecial")
		{
			$str.="<input type='hidden' name='dcSpecialPrice' class='reqdata'  value='".$dcSpecialPrice."' readonly />";

			$str.="<div id='speDiv' style='display:inline-block;'><input type='hidden' name='dcWaterbak' value='".$odData["plDcwater"]."' readonly /><input type='text' class='w50p reqdata' title='' name='dcAlcohol' value='".$odData["dcAlcohol"]."' readonly /><span class='mg5'> ml</span></div>";
			echo "<script>setDcWaterAlcohol('".$name."', '".$data."');</script>";
		}

		return $str;
	}
	//주문현황/주문/파우치,한약박스,배송박스 
	function selectpack($name)
	{
		global $txtdt;
		global $odData;
		global $NET_FILE_URL;

		$miGrade=($odData["miGrade"])?$odData["miGrade"]:"E";

		$list=array();
		$data="";
		$title="";
		$price=$selprice=0;
		$str="";
		switch($name)
		{
		case "odPacktype"://파우치
			$price=($odData["odPackprice"])?$odData["odPackprice"]:0;
			$list=$odData["odPacktypeList"];			
			$data=($odData["odPacktype"])?$odData["odPacktype"]:"";
			$title=$txtdt["1382"];
			break;
		case "reBoxmedi"://한약박스
			$price=($odData["reBoxmediprice"])?$odData["reBoxmediprice"]:0;
			$list=$odData["reBoxmediList"];			
			$data=($odData["reBoxmedi"])?$odData["reBoxmedi"]:"";
			$title=$txtdt["1468"];
			break;
		case "reBoxdeli"://포장박스 
			$price=($odData["reBoxdeliprice"])?$odData["reBoxdeliprice"]:0;
			$list=$odData["reBoxdeliList"];			
			$data=($odData["reBoxdeli"])?$odData["reBoxdeli"]:"";
			$title=$txtdt["1396"];
			break;
		}
	
		foreach($list as $key => $value)
		{
			$checked="";
			if($key==0)
			{
				$checked = "checked";
				$selprice=$list[$key]["pbPrice".$miGrade];
			}
			if($data && $data == $list[$key]["pbCode"])
			{
				$checked = "checked";
				$selprice=$list[$key]["pbPrice".$miGrade];
			}

			$opprice=" data-priceA='".$list[$key]["pbPriceA"]."' data-priceB='".$list[$key]["pbPriceB"]."'  data-priceC='".$list[$key]["pbPriceC"]."' data-priceD='".$list[$key]["pbPriceD"]."' data-priceE='".$list[$key]["pbPriceE"]."' ";

			$str.='<li>';
			$str.='<p class="check-box" onchange="changepackcode()">';
			$str.='<input type="radio" id="pack-'.$name.'-'.$key.'" name="'.$name.'" value="'.$list[$key]["pbCode"].'" class="radiodata"  data-capa="'.$list[$key]["pbCapa"].'" '.$opprice.' '.$checked.' />';
			$str.='<label for="pack-'.$name.'-'.$key.'">';
			if($list[$key]["afThumbUrl"]!="NoIMG")
			{
				if(substr($list[$key]["afThumbUrl"], 0,4)=="http")
				{
					$str.= '<img src="'.$list[$key]["afThumbUrl"].'" onerror="this.src=\'/_Img/Content/noimg.png\'" />';
				}
				else
				{
					$str.= '<img src="'.$NET_FILE_URL.$list[$key]["afThumbUrl"].'" onerror="this.src=\'/_Img/Content/noimg.png\'" />';
				}
			}
			else
			{
				$str.= '<img src="/_Img/Content/noimg.png" alt=""/>';
			}
				
			$str.= '<span class="btxt">'.$list[$key]["pbTitle"].'</span>';
			$str.= '</label>';
			$str.= '</p>';
			$str.= '</li>';

		}

		$pricestr='';
		switch($name)
		{
		case "odPacktype";
			$pricestr='<input type="hidden" name="odPackprice" class="reqdata" value="'.$selprice.'">';
			break;
		case "reBoxmedi";
			$pricestr='<input type="hidden" name="reBoxmediprice" class="reqdata" value="'.$selprice.'">';
			break;
		case "reBoxdeli";
			$pricestr='<input type="hidden" name="reBoxdeliprice" class="reqdata" value="'.$selprice.'">';
			break;
		}

		$allstr="";
		$allstr = '<ul class="pack-list11">';
		$allstr .= $pricestr;
		$allstr .= $str;
		$allstr .= '</ul>';

		return $allstr;
	}
	/*
	function getpillcodename($code)
	{
		global $txtdt;
		$title="";
		
		switch($code)
		{
		case "plFineness"://제환분말도
			$title=$txtdt["1796"];
			break;
		case "plConcentRatio"://농축비율 
			$title=$txtdt["1950"];
			break;
		case "plConcentTime"://농축시간 
			$title=$txtdt["1951"];
			break;
		case "plBinders"://결합제
			$title=$txtdt["1770"];
			break;
		case "plstirBinders"://결합제
			$title=$txtdt["1770"];
			break;
		case "plWarmupTemperature"://중탕온도 
			$title=$txtdt["1952"];
			break;
		case "plWarmupTime"://중탕시간  
			$title="중탕시간";//$txtdt["1951"];
			break;
		case "plFermentTemperature"://숙성온도 
			$title="숙성온도";//$txtdt["1952"];
			break;
		case "plFermentTime"://숙성시간  
			$title="숙성시간";//$txtdt["1951"];
			break;
		case "plShape"://제형 		
			$title=$txtdt["1664"];
			break;
		case "plDryTemperature"://건조온도 
			$title="건조온도";//$txtdt["1952"];
			break;
		case "plDryTime"://건조시간  
			$title=$txtdt["1841"];
			break;
		case "plJuice"://착즙유무  
			$title="착즙유무";
			break;
		case "plSoakTime"://불린시간 
			$title="불린시간";
			break;
		case "plMillingloss"://제분손실 
			$title="제분손실";
			break;
		case "plDctime"://탕전시간 
			$title="탕전시간";
			break;
		case "plLosspill"://제형손실 
			$title="제형손실";
			break;
		}
		return $title;
	}
	*/

	/*
	function getpillcodelist($code)
	{
		global $odData;
		$list=array();
		switch($code)
		{
		case "plFineness"://제환분말도
			$list=$odData["pillFinenessList"];
			break;
		case "plConcentRatio"://농축비율 
			$list=$odData["pillRatioList"];
			break;
		case "plConcentTime"://농축시간 
			$list=$odData["pillTimeList"];
			break;
		case "plBinders"://결합제
		case "plstirBinders"://결합제
			$list=$odData["pillBindersList"];
			break;
		case "plWarmupTemperature"://중탕온도 
			$list=$odData["pillTemperatureList"];
			break;
		case "plWarmupTime"://중탕시간  
			$list=$odData["pillTimeList"];
			break;
		case "plFermentTemperature"://숙성온도 
			$list=$odData["pillTemperatureList"];
			break;
		case "plFermentTime"://숙성시간  
			$list=$odData["pillRipenList"];
			break;
		case "plShape"://제형 
			$list=$odData["pillShapeList"];
			break;
		case "plDryTemperature"://건조온도 
			$list=$odData["pillTemperatureList"];
			break;
		case "plDryTime"://건조시간  
			$list=$odData["pillTimeList"];
			break;
		case "plJuice"://착즙유무  
			$list=$odData["pillJuiceList"];
			break;
		case "plSoakTime"://불린시간 
			$list=$odData["pillTimeList"];
			break;
		case "plDctitle"://탕전법
			$list=$odData["dcTitleList"];
			break;
		case "plDcspecial"://특수탕전 
			$list=$odData["dcSpecialList"];
			break;
		}
		return $list;
	}
	*/
	
	//제환
	function selectpill($name)
	{
		global $txtdt;
		global $odData;

		$list=array();
		$data=$title=$classname="";

		switch($name)
		{
		case "pillFineness"://제환분말도
			$list=$odData["pillFinenessList"];
			$data=($odData["plFineness"])?$odData["plFineness"]:"";
			$title=$txtdt["1796"];
			break;
		case "pillConcentRatio"://농축비율 
			$list=$odData["pillRatioList"];
			$data=($odData["plConcentratio"])?$odData["plConcentratio"]:"";
			$title=$txtdt["1950"];
			break;
		case "pillConcentTime"://농축시간 
			$list=$odData["pillTimeList"];
			$data=($odData["plConcenttime"])?$odData["plConcenttime"]:"";
			$title=$txtdt["1951"];
			break;
		case "pillBinders"://결합제
			$list=$odData["pillBindersList"];
			$data=($odData["plBinders"])?$odData["plBinders"]:"";
			$title=$txtdt["1770"];
			break;
		case "plstirBinders"://결합제
			$list=$odData["pillBindersList"];
			$data=($odData["plstirBinders"])?$odData["plstirBinders"]:"";
			$title=$txtdt["1770"];
			break;
		case "pillWarmupTemperature"://중탕온도 
			$list=$odData["pillTemperatureList"];
			$data=($odData["plWarmuptemperature"])?$odData["plWarmuptemperature"]:"";
			$title=$txtdt["1952"];
			break;
		case "pillWarmupTime"://중탕시간  
			$list=$odData["pillTimeList"];
			$data=($odData["plWarmuptime"])?$odData["plWarmuptime"]:"";
			$title="중탕시간";//$txtdt["1951"];
			break;
		case "pillFermentTemperature"://숙성온도 
			$list=$odData["pillTemperatureList"];
			$data=($odData["plFermenttemperature"])?$odData["plFermenttemperature"]:"";
			$title="숙성온도";//$txtdt["1952"];
			break;
		case "pillFermentTime"://숙성시간  
			$list=$odData["pillTimeList"];
			$data=($odData["plFermenttime"])?$odData["plFermenttime"]:"";
			$title="숙성시간";//$txtdt["1951"];
			break;
		case "pillShape"://제형 
			$list=$odData["pillShapeList"];			
			$data=($odData["plShape"])?$odData["plShape"]:"";
			$title=$txtdt["1664"];
			break;
		case "pillDryTemperature"://건조온도 
			$list=$odData["pillTemperatureList"];
			$data=($odData["plDrytemperature"])?$odData["plDrytemperature"]:"";
			$title="건조온도";//$txtdt["1952"];
			break;
		case "pillDryTime"://건조시간  
			$list=$odData["pillTimeList"];
			$data=($odData["plDrytime"])?$odData["plDrytime"]:"";
			$title=$txtdt["1841"];
			break;
		case "pillJuice"://착즙유무  
			$list=$odData["pillJuiceList"];
			$data=($odData["plJuice"])?$odData["plJuice"]:"";
			$title="착즙유무";
			break;
		}


		//$str='<span class="bd-line"></span>';
		//$str.='<table>';
		//$str.='<colgroup><col width="16%"><col width="*"></colgroup>';
		//$str.='<tr>';
		//$str.='<th>'.$title.'</th>';
		//$str.='<td>';
		$str='<ul class="maType-list">';
		foreach($list as $key => $value)
		{
			$checked="";
			//echo $key." > ".$data." >> ".$list[$key]["cdCode"]."<br>";
			if($key==0)
			{
				$checked = "checked";
			}
			if($data && $data == $list[$key]["cdCode"])
			{
				$checked = "checked";
			}

			$str.='<li class="W50p">';
			$str.='	<p>';
			$str.='	<input type="radio"  name="'.$name.'" class="radiodata '.$selcatetd.'" title = "'.$title.'" id="'.$name.'-'.$key.'" value="'.$list[$key]["cdCode"].'"  '.$checked.' '.$disable.' onclick="radioClick(this);"  data-value="'.$list[$key]["cdValue"].'" data-desc="'.$list[$key]["cdDesc"].'">';
			$str.='	<label for="'.$name.'-'.$key.'">'.$list[$key]["cdName"].'</label>';
			$str.='	</p>';
			$str.='</li>';
		}
		$str.="</ul>";
		//$str.='</td></tr></table>';
		return $str;
	}
	function inputpill()
	{
		global $txtdt;
		global $odData;
		$str='';

		$str='<div class="gap"></div>';
		$str.='<h3 class="u-tit02">처방량</h3>';
		$str.='<div class="board-view-wrap">';
		$str.='	<span class="bd-line"></span>';
		$str.='	<table>';
		$str.='		<colgroup><col width="12%"><col width="*"></colgroup>';
		$str.='		<tr>';
		$str.='			<th><span class="nec">처방량</span></th>';
		$str.='			<td>';
		$str.='			<input type="text" class="w15p reqdata necdata r" title="처방량" name="odPillcapa" id="odPillcapa" value="'.$odData["odPillcapa"].'" maxlength="4" onfocus="this.select();" onchange="changeNumber(event, false);" onblur="pillkeyup()" /> g ';
		$str.='			<input type="text" class="w15p reqdata necdata r" title="처방량갯수" name="odQty" id="odQty" value="'.$odData["odQty"].'" maxlength="9" onfocus="this.select();" onchange="changeNumber(event, false);" onblur="pillkeyup()" /> ea';
		$str.='			<input type="hidden" name="pilltotalcapa" class="" value="'.$odData["pilltotalcapa"].'">';
		$str.='			</td>';
		$str.='		</tr>';
		$str.='	</table>';
		$str.='</div>';

		return $str;
	}
?>