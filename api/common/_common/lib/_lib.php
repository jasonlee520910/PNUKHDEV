<?php
	/// 사용하는 함수 

	///==========================================================
	/// 20200324:페이징(OK)
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
		$pg["psize"] = $psize;	///페이지당 갯수
		if(!$block)$block=10;
		$pg["block"] = $block;	///화면당 페이지수
		$pg["snum"] = ($pg["page"]-1)*$pg["psize"];
		if(!$page)$page=1;
		///search

		$sql=" select count(".$use.") TCNT from ".$dbH."_".$tbl." ".$jsql." ".$wsql;
		$dt=dbone($sql);

		$pg["psql"] = $sql;
		$pg["tcnt"] = $dt["TCNT"];
		$pg["tpage"] = ceil($dt["TCNT"] / $pg["psize"]);
		$pg["tlast"] = $pg["snum"]+$pg["psize"];
		return $pg;
	}
	///==========================================================
	/// 20200331:keycode (OK)
	///==========================================================
	function getkeyCodeLast($datecode)
	{ 
		global $language;
		global $dbH; 


		$sql=" select ";
		$sql.=" (select count(*) from han_order where od_keycode like '20200408115239%') as ORDERCNT ";
		$sql.=" ,(select count(*) from han_order_client where keycode like '20200408115239%') as CLIENTCNT ";
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


	///------------------------------------------------------------
	/// han_medicine_djmedi mmtitle 가져오기 (OK)
	///------------------------------------------------------------
	function getmmtitle($val)
	{
		global $language;

		if($val == '' || $val == false || $val == null)
		{
			$rcMedicineTxt = "-";
		}
		else
		{
			$rcMedicineArry = explode('|', $val);
			$where_rcMedicine_arry = array();

			foreach($rcMedicineArry as $value)
			{
				$items = explode(',', $value);
				array_push($where_rcMedicine_arry, "'".$items[0]."'");
			}
			$where_rcMedicine = implode(",", $where_rcMedicine_arry);
			$sql_rcMedicine= " select LISTAGG(mm_title_kor, ',')  WITHIN GROUP (ORDER BY mm_title_kor asc) as TITLE from han_medicine_djmedi";
			$sql_rcMedicine.= "	where md_code in (".$where_rcMedicine.") ";
			$dt_rcMedicine=dbone($sql_rcMedicine);
			$rcMedicineTxt = $dt_rcMedicine["TITLE"];
		}
		return $rcMedicineTxt;
	}
	function getPillTitle($val)
	{
		global $language;

		if($val == '' || $val == false || $val == null)
		{
			$rcMedicineTxt = "-";
		}
		else
		{
			$rcMedicineArry = explode(',', $val);
			$where_rcMedicine_arry = array();
			foreach($rcMedicineArry as $value)
			{
				$items = explode('|', $value);
				if($items[0])
				{
					array_push($where_rcMedicine_arry, "'".$items[0]."'");
				}
			}
			$where_rcMedicine = implode(",", $where_rcMedicine_arry);

			$sql_rcMedicine=" select LISTAGG(TITLE, ',') as TITLE from (
					select LISTAGG(GD_NAME_KOR, ',')  WITHIN GROUP (ORDER BY GD_NAME_KOR asc) as TITLE 
					from han_goods 
					where GD_CODE in (".$where_rcMedicine.")

					union 

					select LISTAGG(MM_TITLE_KOR, ',')  WITHIN GROUP (ORDER BY MM_TITLE_KOR asc) as TITLE 
					from HAN_MEDICINE_DJMEDI 
					where MM_CODE in (".$where_rcMedicine.")
				) dual ";

			$dt_rcMedicine=dbone($sql_rcMedicine);
			$rcMedicineTxt = $dt_rcMedicine["TITLE"];//$dt_rcMedicine["TITLE"];
		}
		return $rcMedicineTxt;
	}
	///=========================================================================
	/// 20200408 (OK)
	///  함수 명     : getTxtdt()
	///  함수 설명   : 
	///=========================================================================
	function getTxtData($data)
	{
		global $language;
		global $dbH;

		$step=array();
		$sql=" select td_code, td_barcode, td_name_".$language." td_name from ".$dbH."_txtdata where td_type='0' and td_use='Y' and td_code in (".$data.") order by td_code ";
		$res=dbqry($sql);

		while($dt=dbarr($res))
		{
			$step[$dt["TD_CODE"]]=$dt["TD_NAME"];
		}
		$step["sql"]=$sql;

		return $step;
	}
	///=========================================================================
	/// 20200408 (OK)
	///  함수 명     : getMedicine()
	///	 파라 미터	: $val - 약재목록 리스트 
	///  함수 설명   : 탕전타입  
	/// $type='desc' 수정했으나 $type == 'list'쪽은 아직 처리안함.
	///=========================================================================
	function getMedicine($val, $type='desc')
	{
		global $language;

		if($type == 'list')
		{
			if($val == '' || $val == false || $val == null)
			{
				$rcMedicineTxt = "-";
			}
			else
			{
				$rcMedicineArry = explode('|', $val);			
				$where_rcMedicine_arry = array();

				foreach($rcMedicineArry as $value)
				{
					$items = explode(',', $value);
					array_push($where_rcMedicine_arry, "'".$items[0]."'");
				}
				$where_rcMedicine = implode(",", $where_rcMedicine_arry);
				$sql_rcMedicine = " select LISTAGG(md_title_kor, ',')  WITHIN GROUP (ORDER BY md_title_kor asc) as TITLE from han_medicine where md_code in (".$where_rcMedicine.")";
				$dt_rcMedicine=dbone($sql_rcMedicine);
				$rcMedicineTxt = $dt_rcMedicine["TITLE"];
			}

			return $rcMedicineTxt;
		}
		else
		{
			if($val == '' || $val == false || $val == null)
			{
				$list = null;
			}
			else
			{
				$rcMedicineArry = explode('|', $val);			
				$where_array = array();
				$where_type_array = array();
				$list = array();
				$i = 0;

				///검색할 약재코드 뽑아오기 
				foreach($rcMedicineArry as $value)
				{
					$items = explode(',', $value);
					if($items[0])
					{
						$list[$items[0]]["idx"] = $i;
						$list[$items[0]]["code"] = $items[0];///약재명코드
						$list[$items[0]]["chub"] = $items[1];///첩당약재
						$list[$items[0]]["type"] = $items[2];///탕전타입
						array_push($where_array, "'".$items[0]."'");
						array_push($where_type_array, "'".$items[2]."'");
						$i++;
					}
				}

				///뽑은 약재코드 implode 시켜 쿼리하기 
				$where_medicine = implode(",", $where_array);
				$sql_medicine = " select md_code, md_title_".$language." as md_title, md_origin_".$language." as md_origin, md_water, md_price, md_property_".$language." as md_property from han_medicine where md_code in (".$where_medicine.") ";

				$res_rcMedicine=dbqry($sql_medicine);
				///쿼리로 뽑아온 데이터 비교하여 list 만들자 
				while($dt_rcMedicine=dbarr($res_rcMedicine))
				{
					foreach($list as $key => $value)
					{
						if($key == $dt_rcMedicine["MD_CODE"])
						{
							$list[$key]["title"] = ($dt_rcMedicine["MD_TITLE"])?$dt_rcMedicine["MD_TITLE"]:"-";
							$list[$key]["origin"] = ($dt_rcMedicine["MD_ORIGIN"]) ? $dt_rcMedicine["MD_ORIGIN"] : "-";
							$list[$key]["price"] = ($dt_rcMedicine["MD_PRICE"])?$dt_rcMedicine["MD_PRICE"]:"0";
							$list[$key]["water"] = ($dt_rcMedicine["MD_WATER"])?$dt_rcMedicine["MD_WATER"]:"0";
							$list[$key]["property"] = ($dt_rcMedicine["MD_PROPERTY"]) ? $dt_rcMedicine["MD_PROPERTY"] : "0";

							

							
						}
					}
				}

				///뽑은 탕전타입 implode 시켜 쿼리하기 
				$where_type = implode(",", $where_type_array);
				$sql_type = " select td_code, td_name_".$language." as td_title from han_txtdata where td_code in (".$where_type.")";
				$res_type=dbqry($sql_type);
				///쿼리로 뽑아온 데이터 비교하여 list 만들자 
				while($dt_type=dbarr($res_type))
				{
					foreach($list as $key => $value)
					{
						if($list[$key]["type"] == $dt_type["TD_CODE"])
						{
							$list[$key]["typeText"] = $dt_type["TD_TITLE"];
						}
					}
				}
			}
			//$list["sql"] =$sql_medicine; 

			///배열 정렬 
			///arrayOrderBy($list, 'idx asc');
			
			return $list;
		}
		
		

	}




	///=============================================================


	///밑에 함수는 안쓰는거 찾아서 삭제 해야함.


	///랜덤생성함수영문
	function randkey($no){
		$chars = "ABCDEFGHJKLMNPQRSTUVWXYZ";
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
	///랜덤생성함수혼합
	function randmix($no){
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
	
	///숫자 콤마 표시 
	function viewno($no)
	{
		return number_format($no);
	}
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
	function insert_array($arr, $idx, $add)
	{
		$arr_front = array_slice($arr, 0, $idx); ///처음부터 해당 인덱스까지 자름
		$arr_end = array_slice($arr, $idx); ///해당인덱스 부터 마지막까지 자름
		$arr_front[] = $add;///새 값 추가
		return array_merge($arr_front, $arr_end);
	}



	function arrayOrderBy(array &$arr, $order = null) 
	{
		if (is_null($order)) 
		{
			return $arr;
		}
		$orders = explode(',', $order);
		usort($arr, function($a, $b) use($orders) {
			$result = array();
			foreach ($orders as $value) {
				list($field, $sort) = array_map('trim', explode(' ', trim($value)));
				if (!(isset($a[$field]) && isset($b[$field]))) {
					continue;
				}
				if (strcasecmp($sort, 'desc') === 0) {
					$tmp = $a;
					$a = $b;
					$b = $tmp;
				}
				if (is_numeric($a[$field]) && is_numeric($b[$field]) ) {
					$result[] = $a[$field] - $b[$field];
				} else {
					$result[] = strcmp($a[$field], $b[$field]);
				}
			}
			return implode('', $result);
		});
		return $arr;
	}


	///=========================================================================
	///  함수 명     : getMedicine()
	///	파라 미터	: $val - 약재목록 리스트 
	///  함수 설명   : 탕전타입  
	///=========================================================================
	function viewstatus($status){
		global $dbH;
		global $language;
		$sql=" select cd_code, cd_name_".$language." cdName from ".$dbH."_code where cd_type='odStatus' and cd_use='Y' ";
		$res=dbqry($sql);
		$stat=array();
		while($dt=dbarr($res)){
			$stat[$dt["cd_code"]]=$dt["cdName"];
		}
		$arr=explode("_",$status);
		$str=$stat[$arr[0]]." ".$stat[$arr[1]];
		return $str;
	}

	///성별 
	function calcSex($sex)
	{
		return ($sex == "male") ? 'M' : 'F';
	}
	///만나이 계산
	function calcAge($birth)
	{
		$birthday = date("Ymd", strtotime($birth));///생년월일
		$nowday = date("Ymd");///현재날짜
		$age = floor(($nowday - $birthday) / 10000);
		return $age;
	}



	

	function djEncrypt($data, $authkey)
	{
		$crypt_iv = "abcdefghij123456";//"#@$%^&*()_+=-";
		$endata = openssl_encrypt($data, 'aes-256-cbc', $authkey, true, $crypt_iv);
		$endata = base64_encode($endata);
		$endata = urlencode($endata);
		return $endata;
	}
	function djDecrypt($endata, $authkey)
	{
		$crypt_iv = "abcdefghij123456";//"#@$%^&*()_+=-";
		$data = base64_decode($endata);
		$endata = openssl_decrypt($data, "aes-256-cbc", $authkey, true, $crypt_iv);
		return $endata;
	}

	function getOrderkeyCodeLast($datecode)
	{ 
		global $language;
		global $dbH; 

		$sql=" select ";
		$sql.=" (select count(*) from han_order where od_keycode like '".$datecode."%') as ordercnt ";
		$dt=dbone($sql);
		
		$lastCnt=intVal($dt["ordercnt"]);/// + intVal($dt["okchartcnt"]) + intVal($dt["medicalcnt"]);/// + intVal($dt["cycnt"]);
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


///구성요소확인
function getbomData($bomcode){
	global $dbH;
	$tot=0;
	$bom=array();
	$bomarr=explode(",",$bomcode);
	foreach($bomarr as $val){
		if($val){
			$arr=explode("|",$val);
			$tot=$tot+$arr[1];///전체투입량
			///제품.반제품.부재료 조회
			$sql=" select gd_type gtype,  gd_loss gloss,  gd_losscapa glosscapa from ".$dbH."_goods where gd_code='".$arr[0]."'";
			$subdt=dbone($sql);
			///제품.반제품.부재료가 아닌 경우
			///원재료로 재검색
			if(!$subdt["gd_seq"]){
				$sql=" select 'medicine' gtype,  b.md_loss gloss,  b.md_losscapa glosscapa from ".$dbH."_medicine_djmedi a
							inner join ".$dbH."_medicine b on a.md_code=b.md_code where a.mm_code='".$arr[0]."'";
				$subdt=dbone($sql);
			}
			$addarr=array("type"=>$subdt["gtype"], "code"=>$arr[0], "qty"=>$arr[1], "loss"=>$subdt["gloss"], "losscapa"=>$subdt["glosscapa"]);
			array_push($bom,$addarr);
		}
	}
	$result["data"]=$bom;
	$result["tot"]=$tot;
	return $result;
}


	///기타출고는 제외한 조제대테이블 리스트 뽑아오기 
	function notgetmaTableList()
	{
		global $language;
		global $dbH; 

		///코드가 사용이거나 odStatus(주문상태)가 아닐경우만 리스트로 뽑아오기 
		$wsql=" where mt_use = 'Y' and mt_code<>'44444' ";
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

?>