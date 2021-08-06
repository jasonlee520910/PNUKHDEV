<?php 
	function radiotypes($code){
		$marr=array("weekday","weekly","daily");
		$mtarr=array("주간별","요일별","일자별");
		if($code=="")$code="daily";
		$txt="";
		for($i=0;$i<count($marr);$i++){
			if($code==$marr[$i]){$cls="on";}else{$cls="";}
			$txt.="<dd class='seartyperadio ".$cls."' value='".$marr[$i]."' >".$mtarr[$i]."</dd>";
		}
		return $txt;
	}

	function selecttypes($code, $value){
		switch($code){
			case "age":
				$tit="나이별";
				$marr=array("0,19","20,29","30,39","40,49","50,59","60,69","70,200");
				$mtarr=array("~19","20~29","30~39","40~49","50~59","60~69","70~");
				break;
			case "gender":
				$tit="성별";
				$marr=array("female","male");
				$mtarr=array("여성","남성");
				break;
		}
		if(is_array($mtarr)){
			$txt.="<select id='".$code."' name='".$code."' class='seartypesel'>";
			$txt.="<option value=''>".$tit."전체";
			for($i=0;$i<count($marr);$i++){
				$txt.="<option value='".$marr[$i]."'>".$mtarr[$i]."</option>";;
			}
			$txt.="</select>";
		}
		return $txt;
	}

	function selecttypedate(){
		$year=date("Y");
		$month=date("m");
		$txt="<select name='searyear' class='seartypesel'>";
		for($i=2019;$i<=date("Y");$i++){
			if($year==$i){$selected=" selected";}else{$selected="";}
			$txt.="<option value='".$i."' ".$selected.">".$i."년</option>";;
		}
		$txt.="</select>";
		$txt.="<select name='searmonth' class='seartypesel'>";
		for($i=1;$i<=12;$i++){
			$d=sprintf("%02d",$i);
			if($month==$d){$selected=" selected";}else{$selected="";}
			$txt.="<option value='".$d."' ".$selected.">".$i."월</option>";;
		}
		$txt.="</select>";
		return $txt;
	}

	function selectmedidate(){
		//하루전 데이터를 보여주자 
		$year=date("Y");
		$month=date("m");
		$day=date("d");
		$hour=date("H");
		$monLastDay = date('t', strtotime($year."-".$month."-01"));///해당년월의 마지막일 뽑아오기 

		$week=date('w',strtotime($year."-".$month."-".$day));//오늘날짜의 요일 가져오기 
		if($week == 1)//월요일이면 
		{
			$yesterday=date("Y-m-d", strtotime("-2 day", time())); //이틀전 
		}
		else
		{
			$yesterday=date("Y-m-d", strtotime("-1 day", time())); //하루전 
		}
		$yesterarr=explode("-",$yesterday);
		$selY=$yesterarr[0];
		$selM=$yesterarr[1];
		$selD=$yesterarr[2];
		$selT=0;
		$selT1=23;

		$txt="<select name='searyear' id='searyear' class='searyearsel'>";
		for($i=2019;$i<=date("Y");$i++){
			if($selY==$i){$selected=" selected";}else{$selected="";}
			$txt.="<option value='".$i."' ".$selected.">".$i."년</option>";
		}
		$txt.="</select>";

		$txt.="<select name='searmonth' id='searmonth' class='searmonthsel'>";
		for($i=1;$i<=$month;$i++){
			if($i==0)
			{
				if($selM==$d){$selected=" selected";}else{$selected="";}
				$txt.="<option value='all' ".$selected.">전체"."</option>";
			}
			else
			{
				$d=sprintf("%02d",$i);
				if($selM==$d){$selected=" selected";}else{$selected="";}
				$txt.="<option value='".$d."' ".$selected.">".$i."월</option>";
			}
		}
		$txt.="</select>";

		if(intval($selM)==intval($month))
			$monLastDay=$day;

		$txt.="<select name='searday' id='searday' class='seardaysel'>";
		for($i=1;$i<=$monLastDay;$i++){
			if($i==0)
			{
				if($selD==$d){$selected=" selected";}else{$selected="";}
				$txt.="<option value='all' ".$selected.">전체</option>";
			}
			else
			{
				$d=sprintf("%02d",$i);
				if($selD==$d){$selected=" selected";}else{$selected="";}
				$txt.="<option value='".$d."' ".$selected.">".$i."일</option>";
			}
		}
		$txt.="</select>";

		$txt.="<select name='seartime' id='seartime' class='seartimesel'>";
		for($i=0;$i<24;$i++){
			$d=sprintf("%02d",$i);
			if($selT==$d){$selected=" selected";}else{$selected="";}
			$txt.="<option value='".$d."' ".$selected.">".$i."시</option>";
		}
		$txt.="</select>";

		$txt.=" ~ ";

		$txt.="<select name='searyear1' id='searyear1' class='searyearsel1'>";
		for($i=2019;$i<=date("Y");$i++){
			if($selY==$i){$selected=" selected";}else{$selected="";}
			$txt.="<option value='".$i."' ".$selected.">".$i."년</option>";
		}
		$txt.="</select>";

		$txt.="<select name='searmonth1' id='searmonth1' class='searmonthsel1'>";
		for($i=1;$i<=$month;$i++){
			if($i==0)
			{
				if($selM==$d){$selected=" selected";}else{$selected="";}
				$txt.="<option value='all' ".$selected.">전체"."</option>";
			}
			else
			{
				$d=sprintf("%02d",$i);
				if($selM==$d){$selected=" selected";}else{$selected="";}
				$txt.="<option value='".$d."' ".$selected.">".$i."월</option>";
			}
		}
		$txt.="</select>";

		if(intval($selM)==intval($month))
			$monLastDay=$day;

		$txt.="<select name='searday1' id='searday1' class='seardaysel1'>";
		for($i=1;$i<=$monLastDay;$i++){
			if($i==0)
			{
				if($selD==$d){$selected=" selected";}else{$selected="";}
				$txt.="<option value='all' ".$selected.">전체</option>";
			}
			else
			{
				$d=sprintf("%02d",$i);
				if($selD==$d){$selected=" selected";}else{$selected="";}
				$txt.="<option value='".$d."' ".$selected.">".$i."일</option>";
			}
		}
		$txt.="</select>";
		$txt.="<select name='seartime1' id='seartime1' class='seartimesel1'>";
		for($i=0;$i<24;$i++){
			$d=sprintf("%02d",$i);
			if($selT1==$d){$selected=" selected";}else{$selected="";}
			$txt.="<option value='".$d."' ".$selected.">".$i."시</option>";
		}
		$txt.="</select>";
		return $txt;
	}

	function selectmediweek()
	{
		//요일 
		$weeklist = array("요일전체","일","월","화","수","목","금","토");

		$txt="<select name='searweekly' id='searweekly' class='searweeklysel'>";
		
		for($i=0;$i<count($weeklist);$i++)
		{
			if($i==0){$selected=" selected";}else{$selected="";}
			if($i==0)
			{
				$txt.="<option value=''  ".$selected.">".$weeklist[$i]."</option>";
			}
			else
			{
				$txt.="<option value='".$i."' ".$selected.">".$weeklist[$i]."</option>";
			}
			
		}
		$txt.="</select>";

		//주차 
		$txt.="<select name='searweekday' id='searweekday' class='searweekdaysel'>";
		for($i=0;$i<1;$i++)
		{
			if($i==0){$selected=" selected";}else{$selected="";}
			if($i==0)
			{
				$txt.="<option value='' ".$selected.">주전체</option>";
			}
			else
			{
				$txt.="<option value='".$i."' ".$selected.">".$i."</option>";
			}
			
		}
		$txt.="</select>";

		return $txt;
	}

	function searchbtn($code){
		$txt="<input tpye='text' name='".$code."' onkeyup='searchEnterkey();' >";
		$txt.="<span class='searchbtn'>검색</span>";
		return $txt;
	}

?>