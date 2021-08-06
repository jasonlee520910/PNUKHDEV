<?php
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

	///=========================================================================
	///  함수 명     : getMedicine()  -> OK
	///	파라 미터	: $val - 약재목록 리스트 
	///  함수 설명   : 탕전타입  
	///$type='desc' 수정했으나 $type == 'list'쪽은 아직 처리안함.
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



	function getkeyCodeLast($datecode)
	{ 
		global $language;
		global $dbH; 

		$sql=" select ";
		$sql.=" (select count(*) from han_order where od_keycode like '".$datecode."%') as ORDERCNT, ";
		$sql.=" (select count(*) from han_order_okchart where od_keycode like '".$datecode."%') as OKCHARTCNT, ";
		$sql.=" (select count(*) from han_order_medical where keycode like '".$datecode."%') as MEDICALCNT ";
		$dt=dbone($sql);
		
		$lastCnt=intVal($dt["ORDERCNT"]) + intVal($dt["OKCHARTCNT"]) + intVal($dt["MEDICALCNT"]);
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
	function chkkeyCode($keycode)
	{ 
		global $language;
		global $dbH; 

		$sql=" select ";
		$sql.=" (select count(*) from han_order where od_keycode='".$keycode."') as ordercnt, ";
		$sql.=" (select count(*) from han_order_okchart where od_keycode='".$keycode."') as okchartcnt, ";
		$sql.=" (select count(*) from han_order_medical where keycode='".$keycode."') as medicalcnt  ";
		$dt=dbone($sql);
		
		$lastCnt=intVal($dt["ordercnt"]) + intVal($dt["okchartcnt"]) + intVal($dt["medicalcnt"]);
		if($lastCnt > 0)
		{
			return false;
		}
		return true;
	}
	///==========================================================
	/// 페이징(OK)
	///==========================================================
	function apipaging($use,$tbl,$jsql="",$wsql="")
	{
		global $dbH;
		global $pagefile;
		global $disc;
		$page=isset($_GET["page"])?$_GET["page"]:"";
		$psize=isset($_GET["psize"])?$_GET["psize"]:"";
		$block=isset($_GET["block"])?$_GET["block"]:"";
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


//----------------------------------------------------------------------------아래부분은 수정안한것이므로 확인 필요


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


	///성별 
	function calcSex($sex)
	{
		return ($sex == "male") ? 'M' : 'F';
	}
	///만나이 계산
	function calcAge($birth)
	{
		$birthday = date("Ymd", strtotime($birth));//생년월일
		$nowday = date("Ymd");//현재날짜
		$age = floor(($nowday - $birthday) / 10000);
		return $age;
	}

	//=========================================================================
	//  함수 명     : getTxtdt()
	//  함수 설명   : 
	//=========================================================================
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

		return $step;
	}

	/*
	function createbarcode_api($basecode)
	{
		include_once "../_common/module/barcode/barcode.php";
		//Create the barcode
		$img = code128BarCode($basecode, 1);
		//Start output buffer to capture the image
		//Output PNG image
		ob_start();
		imagepng($img);
		//Get the image from the output buffer
		$barcode=ob_get_clean();
		$barcode=addslashes("<img src=data:image/png;base64,".base64_encode($barcode).">");
		return $barcode;
	}
	*/

	function djEncrypt($data, $authkey)
	{
		$crypt_iv = "#@$%^&*()_+=-";
		$endata = openssl_encrypt($data, 'aes-256-cbc', $authkey, true, $crypt_iv);
		$endata = base64_encode($endata);
		return $endata;
	}
	function djDecrypt($endata, $authkey)
	{
		$crypt_iv = "#@$%^&*()_+=-";
		$data = base64_decode($endata);
		$endata = openssl_decrypt($data, "aes-256-cbc", $authkey, true, $crypt_iv);
		return $endata;
	}

	///=========================================================================
	///  20200327 (OK)
	///  함수 명     : getConfigInfo()
	///  함수 설명   : han_config 공통으로 쓰이는 테이블 
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

?>