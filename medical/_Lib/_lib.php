<?php
	//고객센터>공지사항,FAQ,1:1문의 메뉴 
	function viewcstab($type)
	{
		$nActive=$fActive=$iActive="";
		switch($type)
		{
		case "notice":
			$nActive="active";
			break;
		case "faq":
			$fActive="active";
			break;
		case "inquiry":
			$iActive="active";
			break;
		}

		checkSession();

		if($_COOKIE["ck_miUserid"])  //로그인했을때만 보이게 처리
		{
			$str='<a href="/CS/Notice.php" class="tab__link '.$nActive.'">공지사항</a>';
			$str.='<a href="/CS/Faq.php" class="tab__link '.$fActive.'">FAQ</a>';
			$str.='<a href="/CS/Inquiry.php" class="tab__link '.$iActive.'">1:1문의</a>';
		}

		return $str;
	}
	//회원정보>정보관리,처방옵션설정,처방기록 메뉴 
	function viewmembertab($type)
	{
		$iActive=$oActive=$rActive=$mActive="";
		switch($type)
		{
		case "info":
			$iActive="active";
			break;
		case "option":
			$oActive="active";
			break;
		case "record":
			$rActive="active";
			break;
		case "mydoctor":  //소속 한의사
			$mActive="active";
			break;
		}

		$str='<a href="/Member/Info.php" class="tab__link '.$iActive.'">정보관리</a>';
		$str.='<a href="/Member/Option.php" class="tab__link '.$oActive.'">처방옵션 설정</a>';
		$str.='<a href="/Member/Record.php" class="tab__link '.$rActive.'">처방기록</a>';

		if($_COOKIE["ck_meStatus"]=="confirm" && $_COOKIE["ck_miStatus"]=="confirm"  && $_COOKIE["ck_meGrade"]=="30")  //confirm 이 되고 원장만 소속한의사 탭을 볼수있음 
		{
			$str.='<a href="/Member/Mydoctor.php" class="tab__link '.$mActive.'">소속한의사</a>';
		}
		return $str;
	}
	//처방사전>방제사전,본초사전 메뉴 
	function viewdictionarytab($type)
	{
		$fActive=$hActive="";
		switch($type)
		{
		case "formulary":
			$fActive="active";
			break;
		case "herb":
			$hActive="active";
			break;
		}

		$str='<a href="/Dictionary/Formulary.php" class="tab__link '.$fActive.'">방제사전</a>';
		$str.='<a href="/Dictionary/Herb.php" class="tab__link '.$hActive.'">본초사전</a>';
		return $str;
	}
	//처방하기>탭 
	function viewpotiontab($type)
	{
		$dActive=$piActive=$pwActive=$mActive=$rActive=$peActive=$tActive=$myActive="";
		switch($type)
		{
		case "potion"://탕전처방
			$dActive="active";
			break;
		case "pill"://환제처방
			$piActive="active";
			break;
		case "powder"://산제처방
			$pwActive="active";
			break;
		case "medicine"://첩약처방
			$mActive="active";
			break;
		case "recommend"://추천처방
			$rActive="active";
			break;
		case "prev"://이전처방
			$peActive="active";
			break;
		case "mydecoc"://나의처방
			$myActive="active";
			break;
		case "temp"://임시처방
			$tActive="active";
			break;
		}

		$str='<a href="javascript:goPotionList();" class="tab__link '.$dActive.'">탕전처방</a>';
		$str.='<a href="javascript:alert(\'준비중입니다\');" class="tab__link '.$piActive.'">환제처방</a>';
		$str.='<a href="javascript:alert(\'준비중입니다\');" class="tab__link '.$pwActive.'">산제처방</a>';
		$str.='<a href="javascript:alert(\'준비중입니다\');" class="tab__link '.$mActive.'">첩약처방</a>';
		$str.='<a href="javascript:goRecommendList();" class="tab__link '.$rActive.'">추천처방</a>';
		$str.='<a href="javascript:goMyList();" class="tab__link '.$myActive.'">나의처방</a>';
		//$str.='<a href="javascript:alert(\'준비중입니다\');" class="tab__link '.$peActive.'">이전처방</a>';
		$str.='<a href="javascript:goTempList();" class="tab__link '.$tActive.'">임시저장</a>';
		return $str;
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
	function logOutCookie()
	{
		$past = time() - 3600; 
		foreach ( $_COOKIE as $key => $value ) {  unset($_COOKIE[$key]); setcookie( $key, "", $past, '/'); } 
		echo "<script>alert('로그인 후 이용가능합니다.');</script>";
		echo "<script>location.href='/';</script>";
	}
	function checksession(){
		if(!isset($_COOKIE["ck_meUserId"]) || isEmpty($_COOKIE["ck_meUserId"]))
		{
			logOutCookie();
		}
	}
	
	function tblinfo($carr, $marr, $larr="")
	{
		$tbltxt="<div class='table table--list'><table id='tbl'><colgroup>";
		foreach($carr as $val)
		{
			if($val){$val.="%";}
			$tbltxt.="<col width='".$val."'>";
		}
		$tbltxt.="</colgroup><thead><tr>";
		$i=0;
		foreach($marr as $val)
		{
			$txtcls="th-txtcenter";
			$cls="";
			if($larr[$i]=="lt"){$cls="lt";}
			if($val=="결제금액"){$txtcls="th-txtRight";}
			if($val=="주문상품정보" || $val=="약재정보"){$txtcls="th-txtLeft";}
			if($val=="처방명"){$txtcls="th-txtLeft";}
			if($val=="효능" || $val=="본초명"  || $val=="설명" || $val=="이명" || $val=="교과서분류" ){$txtcls="th-txtLeft";}
			if($val=="mycheck" || $val=="mychkdel")
			{
				$tbltxt.="<th class='".$cls." ".$txtcls." '>";
				$tbltxt.="	<div class='inp-checkBox'>";
				$tbltxt.="		<div class='inp inp-check'>";
				$tbltxt.="			<label for='chkmyalld1' class='d-flex'>";
				$tbltxt.="				<input type='checkbox' name='chkmyall' id='chkmyalld1' class='' onclick='chkmyall();'>";
				$tbltxt.="				<span></span>";
				$tbltxt.="			</label>";
				$tbltxt.="		</div>";
				$tbltxt.="	</div>";
				$tbltxt.="</th>";
			}
			else
			{
				if($val=="처방명" || $val=="본초명")
				{
					$tbltxt.="<th class='".$cls." ".$txtcls." ' onclick='changeno(\"".$val."\");'>".$val."<span id='arrowDiv'>▲</span></th>";		

				}
				else
				{
					$tbltxt.="<th class='".$cls." ".$txtcls." '>".$val."</th>";			
				}			
			}	
			
			$i++;
		}
		$tbltxt.="</tr></thead>";
		$tbltxt.="<tbody></tbody></table>";
		$tbltxt.="</div><div class='paging d-flex' id='paging'></div>";
		return $tbltxt;
	}
                  
	//팝업용 따로 뺌							
	function popuptblinfo($carr, $marr, $larr="")
	{
		$tbltxt="<div class='table table--list'><table id='popuptbl'>";
		$tbltxt.="<colgroup>";
		foreach($carr as $val)
		{
			if($val){$val.="%";}
			$tbltxt.="<col width='".$val."'>";
		}
		$tbltxt.="</colgroup><thead><tr>";
		$i=0;
		foreach($marr as $val)
		{
			$txtcls="th-txtcenter";
			$cls="";
			if($larr[$i]=="lt"){$cls="lt";}
			$tbltxt.="<th class='".$cls." ".$txtcls." '>".$val."</th>";			
			$i++;
		}
		$tbltxt.="</tr></thead>";
		$tbltxt.="<tbody></tbody></table>";
		$tbltxt.="</div><div class='paging d-flex' id='poppaging'></div>";
		return $tbltxt;
	}
       										
	//랜덤생성함수숫자
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

	//기간선택
	function selectperiod()
	{
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
		$str="<div class='form inner'>";
		$str.="<div class='form__row d-flex ' style='display:inline-block;'>";
		$str.="<div class='' style='height:30px;'>";
		$str.="<input title='시작일 입력해 주세요' value='".$sdate."' class='ajaxdata inp inp-input inp-radius' type='text' id='sdate' name='sdate'> ";
		$str.=" ~ ";
		$str.="<input title='종료일 입력해 주세요' value='".$edate."' class='ajaxdata inp inp-input inp-radius' type='text' id='edate' name='edate'> ";
		$str.="</div>";

		$carr=array("today","yesterday","week","month","month3","month4","all");
		$tarr=array("오늘","어제","1주","1개월","3개월","6개월","전체");

		$str.="</div>";
		$str.="<div class='form__row' style='display:inline-block;'>";
		$str.="<div class='inp-radioBox d-flex'>";
		
		for($i=0;$i<count($carr);$i++)
		{
			if(strpos($_GET["searPeriodEtc"],$carr[$i])){$checked="checked";}else{$checked="";}
			$str.="<div class='inp inp-radio'>";
			$str.="	<label for='jon-".$i."' class='d-flex' style='cursor:pointer;'>";
			$str.="		<input type='radio' id='jon-".$i."' name='searPeriodEtc' class='blind searPeriodEtc".$carr[$i]."' onclick='setperiod(this.value)' value='".$carr[$i]."' ".$checked." >";
			$str.="		<span>".$tarr[$i]."</span>";
			$str.="	</label>";
			$str.="</div>";

		}
		$str.="</div></div></div>";

		return $str;
	}
		//검색 함수
	function searcharea()
	{
		$txt="<div class='inp-searchBox'> <div class='inp inp-search d-flex' >";
		$txt.="<input type='text'  name='searchTxt' id='searchTxt' class='ajaxdata seartext searcls' value='' placeholder='' onkeydown='if(event.keyCode==13)searcls()'>";
		$txt.="<button class='inp-search__btn' type='button' onclick='searcls()' style='cursor:pointer;'><span></span></button>";
		$txt.="</div></div>";
		return $txt;
	}

?>