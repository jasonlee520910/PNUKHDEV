<?php
	$root="../../..";
	include_once $root."/adm/common.php";
	include './PHPExcel-1.8/Classes/PHPExcel.php';
	function column_char($i) { return chr( 65 + $i ); }
 	// 자료 생성
	//동/호수/동호수/핸드폰번호1/핸드폰번호2/핸드폰번호3/핸드폰번호4
	$headers = array('동','호수','동호수','핸드폰번호1','핸드폰번호2','핸드폰번호3','핸드폰번호4','사용여부','접속횟수','등록/수정일','비고');
	$rows = array();
	$sql=" select HOUSE_ID_DONG, HOUSE_ID_HO, HOUSE_NAME, MOBILE_NO, MOBILE_NO2, MOBILE_NO3, MOBILE_NO4, HOUSE_USE, USE_COUNT, CHANGE_DATE, HOUSE_NOTE  
				from SM_HOUSE_MST_INFO where HOUSE_ID_DONG <>'' and HOUSE_ID_HO <> ''
				order by HOUSE_ID_DONG, HOUSE_ID_HO ";
	$res=dbqry($sql);
	while($dt=dbarr($res)){
		$rowdata=array($dt["HOUSE_ID_DONG"],$dt["HOUSE_ID_HO"],$dt["HOUSE_NAME"],$dt["MOBILE_NO"],$dt["MOBILE_NO2"],$dt["MOBILE_NO3"],$dt["MOBILE_NO4"],$dt["HOUSE_USE"],$dt["USE_COUNT"],$dt["CHANGE_DATE"],$dt["HOUSE_NOTE"]);
		array_push($rows, $rowdata);
	}
	$data = array_merge(array($headers), $rows);
	 
	// 스타일 지정
	$widths = array(10, 10, 20, 23, 23, 23, 23, 7, 10, 30, 50);
	$header_bgcolor = 'FFABCDEF';
	$left_bgcolor = 'FFABCDEF';
	 
	// 엑셀 생성
	$last_char = column_char( count($headers) - 1 );
	 
	$excel = new PHPExcel();
	$excel->setActiveSheetIndex(0)->getStyle( "A1:${last_char}1" )
		->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB($header_bgcolor);
	$excel->setActiveSheetIndex(0)->getStyle( "A:$last_char" )
		->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER)->setWrapText(true);

	foreach($widths as $i => $w) $excel->setActiveSheetIndex(0)->getColumnDimension( column_char($i) )->setWidth($w);
	$excel->getActiveSheet()->fromArray($data,NULL,'A1');

	// 글꼴 및 정렬
	$fontStyle = [
		'font' => array(
            'size' => 15
        ),
        'alignment' => array(
            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
        )
	];
	$excel->getActiveSheet()->getStyle("A1:K".(count($rows)+1))->applyFromArray($fontStyle);
	$excel->getActiveSheet()->getStyle("A1:C".(count($rows)+1))->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB($left_bgcolor);
	$excel->getActiveSheet()->setTitle("양지금호1단지입주자");
	//$excel->getActiveSheet()->getStyle('A1:G20')
	//	->getProtection()->setLocked(PHPExcel_Style_Protection::PROTECTION_UNPROTECTED);

	$writer = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');

	header("Content-Type: application/vnd.ms-excel");
	header("Content-Disposition: attachment; filename=kumhoall_".date("Ymdhis").".xlsx");
	header("Cache-Control: max-age=0");
	$writer->save("php://output");
?>
