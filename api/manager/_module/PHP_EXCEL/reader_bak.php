<?
	$root="../../..";
	include_once $root."/adm/common.php";
	include_once $root."/adm/module/excel/PHPExcel-1.8/Classes/PHPExcel.php";
	$UpFile = $_FILES["upfile"];
	$UpFileName = $UpFile["name"];
	$UpFilePathInfo = pathinfo($UpFileName);
	$UpFileExt = strtolower($UpFilePathInfo["extension"]);

	if($UpFileExt != "xls" && $UpFileExt != "xlsx") {
		echo "<script>alert('엑셀파일만 업로드 가능합니다. (xls, xlsx 확장자의 파일포멧)')</script>";
		//echo "엑셀파일만 업로드 가능합니다. (xls, xlsx 확장자의 파일포멧)";
		exit;
	}

	//-- 읽을 범위 필터 설정 (아래는 A열만 읽어오도록 설정함  => 속도를 중가시키기 위해)
	class MyReadFilter implements PHPExcel_Reader_IReadFilter
	{
		public function readCell($column, $row, $worksheetName = '') {
		// Read rows 1 to 7 and columns A to E only
			if (in_array($column,range('A','G'))) {
				return true;
			}
			return false;
		}
	}
	$filterSubset = new MyReadFilter();

	//업로드된 엑셀파일을 서버의 지정된 곳에 옮기기 위해 경로 적절히 설정
	$upload_path = $_SERVER["DOCUMENT_ROOT"]."/data/excel";
	$upfile_path = $upload_path."/".date("Ymd_His")."_".$UpFileName;
	if(is_uploaded_file($UpFile["tmp_name"])) {
		if(!move_uploaded_file($UpFile["tmp_name"],$upfile_path)) {
			echo "<script>alert('업로드 중 에러가 발생했습니다')</script>";
			//echo "업로드된 파일을 옮기는 중 에러가 발생했습니다.";
			exit;
		}

		//파일 타입 설정 (확자자에 따른 구분)
		$inputFileType = 'Excel2007';
		if($UpFileExt == "xls") {
			$inputFileType = 'Excel5'; 
		}

		//엑셀리더 초기화
		$objReader = PHPExcel_IOFactory::createReader($inputFileType);

		//데이터만 읽기(서식을 모두 무시해서 속도 증가 시킴)
		$objReader->setReadDataOnly(true); 

		//범위 지정(위에 작성한 범위필터 적용)
		$objReader->setReadFilter($filterSubset);

		//업로드된 엑셀 파일 읽기
		$objPHPExcel = $objReader->load($upfile_path);

		//첫번째 시트로 고정
		$objPHPExcel->setActiveSheetIndex(0);

		//고정된 시트 로드
		$objWorksheet = $objPHPExcel->getActiveSheet();

		  //시트의 지정된 범위 데이터를 모두 읽어 배열로 저장
		$sheetData = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);

		//$json=json_encode($sheetData);

		$total_rows = count($sheetData);
		//DB 조회 업데이트
		$oridata = array();
		$sql=" select HOUSE_ID_DONG, HOUSE_ID_HO, HOUSE_NAME, MOBILE_NO, MOBILE_NO2, MOBILE_NO3, MOBILE_NO4  
				from SM_HOUSE_MST_INFO where HOUSE_ID_DONG <>'' and HOUSE_ID_HO <> ''
				order by HOUSE_ID_DONG, HOUSE_ID_HO ";
		$res=dbqry($sql);
		while($dt=dbarr($res)){
			$oridata[$dt["HOUSE_ID_DONG"].$dt["HOUSE_ID_HO"]]=array($dt["MOBILE_NO"],$dt["MOBILE_NO2"],$dt["MOBILE_NO3"],$dt["MOBILE_NO4"],$dt["HOUSE_NAME"]);
			array_push($oridata,$rowdata);
		}
		$newdata = array();
		$i=0;
		foreach($sheetData as $rows) {
			if($i>0){
				$rowdata=array($rows["A"],$rows["B"],$rows["D"],$rows["E"],$rows["F"],$rows["G"]);
				array_push($newdata,$rowdata);

			}
			$i++;
		}
		//$sql=" update SM_HOUSE_MST_INFO set

		/* 데이터 처리 */
		//데이터비교 후 업데이트
		$cnt=0;
		$str="";
		foreach($newdata as $val){
//echo str_replace("-","",$oridata[$val[0].$val[1]][0])."_".str_replace("-","",$val[2])."<br>";
//echo str_replace("-","",$oridata[$val[0].$val[1]][1])."_".str_replace("-","",$val[3])."<br>";
//echo str_replace("-","",$oridata[$val[0].$val[1]][2])."_".str_replace("-","",$val[4])."<br>";
//echo str_replace("-","",$oridata[$val[0].$val[1]][3])."_".str_replace("-","",$val[5])."<br>";
			if(str_replace("-","",$val[2])!=str_replace("-","",$oridata[$val[0].$val[1]][0])){
				$sql=" update SM_HOUSE_MST_INFO set MOBILE_NO = '".$val[2]."',HOUSE_PWD=''  
							where HOUSE_ID_DONG = '".$val[0]."' and HOUSE_ID_HO = '".$val[1]."'";
				//echo $sql."<br>";
				dbqry($sql);
				$cnt++;
				$str.="\\n".$oridata[$val[0].$val[1]][4]." ".$oridata[$val[0].$val[1]][0]." -> ".$val[2];
			}
			if(str_replace("-","",$val[3])!=str_replace("-","",$oridata[$val[0].$val[1]][1])){
				$sql=" update SM_HOUSE_MST_INFO set MOBILE_NO2 = '".$val[3]."',HOUSE_PWD2=''  
							where HOUSE_ID_DONG = '".$val[0]."' and HOUSE_ID_HO = '".$val[1]."'";
				//echo $sql."<br>";
				dbqry($sql);
				$cnt++;
				$str.="\\n".$oridata[$val[0].$val[1]][4]." ".$oridata[$val[0].$val[1]][1]." -> ".$val[3];
			}
			if(str_replace("-","",$val[4])!=str_replace("-","",$oridata[$val[0].$val[1]][2])){
				$sql=" update SM_HOUSE_MST_INFO set MOBILE_NO3 = '".$val[4]."',HOUSE_PWD3=''  
							where HOUSE_ID_DONG = '".$val[0]."' and HOUSE_ID_HO = '".$val[1]."'";
				//echo $sql."<br>";
				dbqry($sql);
				$cnt++;
				$str.="\\n".$oridata[$val[0].$val[1]][4]." ".$oridata[$val[0].$val[1]][2]." -> ".$val[4];
			}
			if(str_replace("-","",$val[5])!=str_replace("-","",$oridata[$val[0].$val[1]][3])){
				$sql=" update SM_HOUSE_MST_INFO set MOBILE_NO4 = '".$val[5]."',HOUSE_PWD4=''  
							where HOUSE_ID_DONG = '".$val[0]."' and HOUSE_ID_HO = '".$val[1]."'";
				//echo $sql."<br>";
				dbqry($sql);
				$cnt++;
				$str.="\\n".$oridata[$val[0].$val[1]][4]." ".$oridata[$val[0].$val[1]][3]." -> ".$val[5];
			}
		}
		if($cnt < 1){
			echo "<script>alert('업로드 성공 후 변경된 동/호가 없습니다.');</script>";
		}else{
			echo "<script>alert('업로드 성공 후 ".$cnt." 건 변경되었습니다".$str."');</script>";
		}
	}else{
		echo "<script>alert('업로드 된 파일이 없습니다.');</script>";
	}
	echo "<script>top.location.reload();</script>";
?>