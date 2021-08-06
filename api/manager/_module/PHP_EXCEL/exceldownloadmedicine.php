<?php  
	$root="../../..";
	$folder="/manager";
	include_once $root.$folder."/_common/db/db.inc.php";
	include './PHPExcel-1.8/Classes/PHPExcel.php';


	$searyear=$_GET["searyear"];//년 
	$searmonth=$_GET["searmonth"];//월 
	$searday=$_GET["searday"];//일
	$seartime=$_GET["seartime"];//일

	$searyear1=$_GET["searyear1"];//년 
	$searmonth1=$_GET["searmonth1"];//월 
	$searday1=$_GET["searday1"];//일
	$seartime1=$_GET["seartime1"];//일

	$searchtxt=urldecode($_GET["searchtxt"]);//약재명 

	if($searmonth == "all")
	{
		$start_date = date("Y-m-d", mktime(0, 0, 0, 1 , 1, $searyear)); //해당년의 1월1일부터
		$end_date = date("Y-m-d", mktime(0, 0, 0, 13, 0, $searyear)); //해당년의 12월 마지막일까지 
	}
	else
	{
		if($searday == "all")
		{
			$start_date = date("Y-m-d", mktime(0, 0, 0, $searmonth , 1, $searyear)); //해당년월의 1일부터 
			$end_date = date("Y-m-d", mktime(0, 0, 0, $searmonth+1 , 0, $searyear)); //해당년월의 마지막일까지 
		}
		else
		{
			
			$start_date = date("Y-m-d H:i:s", mktime($seartime, 0, 0, $searmonth , $searday, $searyear)); 
			if($seartime1==0)
			{
				$end_date = date("Y-m-d H:i:s", mktime($seartime1, 0, 0, $searmonth1 , $searday1, $searyear1)); 
			}
			else
			{
				$end_date = date("Y-m-d H:i:s", mktime($seartime1, 59, 59, $searmonth1 , $searday1, $searyear1)); 
			}
		}
	}
	//mktime함수의 인자는 순서대로 시간, 분, 초, 월, 일, 년도 입니다.

	//115.95.52.52 청연
	//if($_SERVER["REMOTE_ADDR"]!="59.7.50.122" && $_SERVER["REMOTE_ADDR"]!="115.95.52.52"){$json["resultMessage"]="Auth";$apiCode="dbwork";}
	//else
	//{
		$objPHPExcel = new PHPExcel();

		//해당하는 년월일의 데이터를 뽑아오자!
		$sql=" select ";
		$sql.=" a.db_mdcode, b.mm_title_kor as mmTitle, b.mm_unit, sum(REPLACE(a.db_mdcapa,'P','')) as totalmdcapa, sum(REPLACE(a.db_makingcapa,'P','')) as totalmkcapa ";
		$sql.=" ,(select LISTAGG(mb_table, ',')  WITHIN GROUP (ORDER BY mb_table asc) from han_medibox where mb_medicine=a.db_mdcode) as mbTable  ";
		$sql.=" ,(select md_origin_kor from han_medicine where md_code=a.db_mdcode) as mdOrigin   ";
		$sql.=" from han_dashboard a ";
		$sql.=" inner join han_medicine_djmedi b on b.md_code=a.db_mdcode ";
		$sql.=" where to_char(a.db_oddate,'YYYY-MM-DD hh24:mi:ss') >= '".$start_date."' AND to_char(a.db_oddate,'YYYY-MM-DD hh24:mi:ss') <= '".$end_date."' ";

		if($searchtxt)
		{
			$sql.=" and b.mm_title_kor like '%".$searchtxt."%' ";
		}
		

		$sql.=" group by a.db_mdcode, b.mm_title_kor, b.mm_unit ";
		$sql.=" order by totalmkcapa DESC ";

		$res=dbqry($sql);
		$medicine="";
		$arrdata=array();
		$i=1;
		while($dt=dbarr($res))
		{
			$totalmdcapa=floor($dt["TOTALMDCAPA"]);
			$totalmkcapa=floor($dt["TOTALMKCAPA"]);
			$jarwith=intval($totalmkcapa) - intval($totalmdcapa);

			$mm_unit=($dt["MM_UNIT"])?floatval($dt["MM_UNIT"]):0;
			if($mm_unit>0)
			{
				$mminput=round($totalmkcapa/$mm_unit, 2);
			}
			else
			{
				$mminput=0;
			}

			$arrdata[$i]=array(
				"db_mdcode"=>$dt["DB_MDCODE"], 
				"mdOrigin"=>$dt["MDORIGIN"],
				"mmTitle"=>$dt["MMTITLE"], 
				"mb_table"=>$dt["MBTABLE"], 		
				"mm_unit"=>$mm_unit,//단위
				"mminput"=>$mminput,//투입량 
				"totalmdcapa"=>$totalmdcapa, //처방용량
				"totalmkcapa"=>$totalmkcapa,//조제용량 
				"jarwith"=>$jarwith//차인량
			);
			$i++;

			$medicine.=",'".$dt["DB_MDCODE"]."'";
		}

		if($medicine)
		{
			$medicine=substr($medicine,1);
			$totlalist=array();
			
			//누적사용량을 가져오기 위함 
			$sql=" select ";
			$sql.=" a.db_mdcode, sum(REPLACE(a.db_mdcapa,'P','')) as totalmdcapa, sum(REPLACE(a.db_makingcapa,'P','')) as totalmkcapa ";
			$sql.=" from han_dashboard a ";
			$sql.=" inner join han_medicine_djmedi b on b.md_code=a.db_mdcode and b.MM_USE<>'D' ";
			$sql.=" where a.db_mdcode in (".$medicine.") ";
			$sql.=" group by a.db_mdcode ";
			$sql.=" order by decode(a.db_mdcode, ".$medicine.") ";

			$res=dbqry($sql);
			$json["totlalist"]=array();
			while($dt=dbarr($res))
			{
				
				$totlalist[$dt["DB_MDCODE"]]=array(
					"db_mdcode"=>$dt["DB_MDCODE"], 
					"accruemdcapa"=>floor($dt["TOTALMDCAPA"]), //처방용량
					"accruemkcapa"=>floor($dt["TOTALMKCAPA"])//조제용량 
				);
				//$totlalist[$dt["db_mdcode"]]=$addarray;
			}
		}
		//var_dump($totlalist);


		//제목
		$objPHPExcel -> setActiveSheetIndex(0)
		-> setCellValue("B1", "기간설정 : ".$start_date." ~ ".$end_date)
		-> setCellValue("A2", "NO.")
		-> setCellValue("B2", "약재명")
		-> setCellValue("C2", "원산지")
		-> setCellValue("D2", "단위")
		-> setCellValue("E2", "투입량")
		-> setCellValue("F2", "처방용량")
		-> setCellValue("G2", "조제용량")
		-> setCellValue("H2", "차인량")
		-> setCellValue("I2", "누적처방량")
		-> setCellValue("J2", "누적조제량");

		$count = 2;

		foreach($arrdata as $key => $val) 
		{
			$num = 2 + $key;

			$objPHPExcel -> setActiveSheetIndex(0)		
			-> setCellValue(sprintf("A%s", $num), $key)
			-> setCellValue(sprintf("B%s", $num), $val['mmTitle'])//약재명
			-> setCellValue(sprintf("C%s", $num), $val['mdOrigin'])//약재명
			-> setCellValue(sprintf("D%s", $num), $val['mm_unit'])//단위
			-> setCellValue(sprintf("E%s", $num), $val['mminput'])//투입량 
			-> setCellValueExplicit(sprintf("F%s", $num), $val['totalmdcapa'], PHPExcel_Cell_DataType::TYPE_NUMERIC)//처방용량
			-> setCellValueExplicit(sprintf("G%s", $num), $val['totalmkcapa'], PHPExcel_Cell_DataType::TYPE_NUMERIC)//조제용량
			-> setCellValueExplicit(sprintf("H%s", $num), $val['jarwith'], PHPExcel_Cell_DataType::TYPE_NUMERIC)//차인량
			-> setCellValueExplicit(sprintf("I%s", $num), $totlalist[$val['db_mdcode']]['accruemdcapa'], PHPExcel_Cell_DataType::TYPE_NUMERIC)//누적처방량
			-> setCellValueExplicit(sprintf("J%s", $num), $totlalist[$val['db_mdcode']]['accruemkcapa'], PHPExcel_Cell_DataType::TYPE_NUMERIC);//누적조제량

			$count++;

		}

		// 가로 넓이 조정
		$objPHPExcel -> getActiveSheet() -> getColumnDimension("A") -> setWidth(6);
		$objPHPExcel -> getActiveSheet() -> getColumnDimension("B") -> setWidth(30);
		$objPHPExcel -> getActiveSheet() -> getColumnDimension("C") -> setWidth(20);
		$objPHPExcel -> getActiveSheet() -> getColumnDimension("D") -> setWidth(20);
		$objPHPExcel -> getActiveSheet() -> getColumnDimension("E") -> setWidth(20);
		$objPHPExcel -> getActiveSheet() -> getColumnDimension("F") -> setWidth(30);
		$objPHPExcel -> getActiveSheet() -> getColumnDimension("G") -> setWidth(30);
		$objPHPExcel -> getActiveSheet() -> getColumnDimension("H") -> setWidth(20);
		$objPHPExcel -> getActiveSheet() -> getColumnDimension("I") -> setWidth(40);
		$objPHPExcel -> getActiveSheet() -> getColumnDimension("J") -> setWidth(40);

		// 전체 가운데 정렬
		$objPHPExcel -> getActiveSheet() -> getStyle(sprintf("A1:J%s", $count)) -> getAlignment() -> setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
		$objPHPExcel -> getActiveSheet() -> getStyle(sprintf("A2:J%s", $count)) -> getAlignment() -> setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

		// 전체 테두리 지정
		$objPHPExcel -> getActiveSheet() -> getStyle(sprintf("A1:J%s", $count)) -> getBorders() -> getAllBorders() -> setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

		// 타이틀 부분
		$objPHPExcel -> getActiveSheet() -> mergeCells('B1:J1');
		$objPHPExcel -> getActiveSheet() -> getStyle('B1')->getFont()->setSize(15)->setBold(true);
		$objPHPExcel -> getActiveSheet() -> getStyle("A2:J2") -> getFont() -> setBold(true);
		$objPHPExcel -> getActiveSheet() -> getStyle("A2:J2") -> getFill() -> setFillType(PHPExcel_Style_Fill::FILL_SOLID) -> getStartColor() -> setRGB("CECBCA");


		// 내용 지정
		$objPHPExcel -> getActiveSheet() -> getStyle(sprintf("A3:J%s", $count)) -> getFill() -> setFillType(PHPExcel_Style_Fill::FILL_SOLID) -> getStartColor() -> setRGB("F4F4F4");
		$objPHPExcel -> getActiveSheet() -> getStyle(sprintf("F3:J%s", $count)) -> getNumberFormat() -> setFormatCode("#,##0");

		// 시트 네임
		$objPHPExcel -> getActiveSheet() -> setTitle("부산대약재보고서");

		// 첫번째 시트(Sheet)로 열리게 설정
		$objPHPExcel -> setActiveSheetIndex(0);

		// 파일의 저장형식이 utf-8일 경우 한글파일 이름은 깨지므로 euc-kr로 변환해준다.
		$filename = iconv("UTF-8", "EUC-KR", "약재보고서");

		// 브라우저로 엑셀파일을 리다이렉션
		header("Content-Type:application/vnd.ms-excel");
		header("Content-Disposition: attachment;filename=".$filename.date("Ymdhis").".xls");
		header("Cache-Control:max-age=0");

		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, "Excel5");

		$objWriter -> save("php://output");

	//}

?>
