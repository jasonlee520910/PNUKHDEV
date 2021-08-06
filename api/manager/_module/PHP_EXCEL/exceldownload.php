<?php  
	$root="../../..";
	$folder="/manager";
	$sdate = $_GET["sdate"];
	$edate = $_GET["edate"];
	include_once $root.$folder."/_common/db/db.inc.php";
	include './PHPExcel-1.8/Classes/PHPExcel.php';

	//115.95.52.52 청연
	if($_SERVER["REMOTE_ADDR"]!="59.7.50.122" && $_SERVER["REMOTE_ADDR"]!="115.95.52.52"){$json["resultMessage"]="Auth";$apiCode="dbwork";}
	else
	{
		function column_char($i) { return chr( 65 + $i ); }
		// 자료 생성
		$headers = array('조제일','한의원명','약재이름','규격','수량','단가','공급가액','세액','합계금액','환자명');
		$rows = array();

		//$sql=" select a.rc_seq,a.rc_code, a.rc_userid, a.rc_title_kor, a.rc_medicine ,a.rc_userid,b.mi_name ,o.od_date,o.od_name, o.od_packcnt from han_recipeuser a left join han_medical b on a.rc_userid=b.mi_userid left join han_order o on o.od_scription=a.rc_code order by rc_seq DESC ";

		$ssql="  a.rc_seq,a.rc_code, a.rc_userid, a.rc_title_kor rcTitle, a.rc_medicine ,b.mi_name ,o.od_name, o.od_chubcnt ,m.ma_end ";
		$jsql.=" o inner join ".$dbH."_making m on o.od_code=m.ma_odcode ";
		$jsql.=" inner join ".$dbH."_recipeuser a on a.rc_code=o.od_scription ";
		$jsql.=" inner join ".$dbH."_medical b on a.rc_userid=b.mi_userid ";		
		$wsql=" where m.ma_status='making_done' ";

		if($sdate&&$edate)
		{
			$wsql.=" and ( ";
			$wsql.=" left(m.ma_end,10)>= '".$sdate."' and left(m.ma_end,10) <= '".$edate."' ";		
			$wsql.=" ) ";
		}

		$sql=" select $ssql from ".$dbH."_order  $jsql $wsql order by m.ma_end desc" ;

		$res=dbqry($sql);

		while($dt=dbarr($res))
		{
			//$rowdata=array($dt["rc_seq"],$dt["rc_userid"],$dt["rc_title_kor"],$dt["rc_medicine"]);
			//echo $dt["rc_medicine"]."<br>";

			$medidata=explode("|",$dt["rc_medicine"]);

			//echo "<br>".$dt["rc_seq"]."****>>> :".$dt["rc_title_kor"]."<br>"; 
			for($i=1;$i<count($medidata);$i++)
			{				
				//echo $i."--->>>".$medidata[$i]."<br>";
				$medicode=explode(",",$medidata[$i]);
				
				//echo $i."--->>>".$medicode[0]."<br>";  //약재코드들만 뽑은게 0번째
				//echo $i."--->>>".$medicode[1]."<br>";  //처방량(실제투입량 X)

				$medivalue=getname($medicode[0]);
	/*	
				$totalvalue=round(floatval($medicode[1])*floatval($dt["od_chubcnt"]));  //수량 = 처방량 * od_chubcnt
				//echo "처방량 : ".$medicode[1].", 첩 (od_chubcnt):".$dt["od_chubcnt"].", 수량 :".$totalvalue."<br>";
				
				$cntvalue=round(floatval($totalvalue)*floatval($medicode[3]));   //합계금액 = 수량 * 단가
				//echo "수량 : ".$totalvalue.", 단가 ".$medicode[3].", 합계금액 ".$cntvalue."<br>";
				
				$value=round($cntvalue/1.1);
				//echo "공급가액 >>> ".$value."<br>";

				$taxvalue=round($cntvalue-$value);
				//echo "세액 >>> ".$taxvalue."<br>";
*/				
					

				$tprice=$medicode[3];//약재값 
				$totalvalue=floatval($medicode[1])*floatval($dt["od_chubcnt"]);//첩당약재 * 첩수 = 총약재( 수량 = 처방량 * od_chubcnt	)
				$cntvalue = floor($totalvalue * floatval($tprice));//총약재 * 약재값 

				$value=round($cntvalue/1.1);
				$taxvalue=round($cntvalue-$value);
				
				//echo $i."--->>>".$medicode[3].'totalvalue'.$totalvalue.$dt["od_chubcnt"].$cntvalue."<br>";
				$date = date("Y-m-d", strtotime($dt["ma_end"] ) );				

				//echo "조제일 :".$date."  한의원명 :".$dt["mi_name"]." 약재이름 :".$medivalue." 규격 :".'1g'." 수량 :".$totalvalue." 단가 :".$medicode[3]." 공급가액 ".$value." 세액 ".$taxvalue."  합계금액 :  ".$cntvalue.' 환자명 : '.$dt["od_name"].'<br>';

				$rowdata=array($date,$dt["mi_name"],$medivalue,'1g',$totalvalue,$medicode[3],$value,$taxvalue,$cntvalue,$dt["od_name"]);
				array_push($rows, $rowdata);

				$data = array_merge(array($headers), $rows);
			}	
		}
//////////////////////////////////////////
		// 스타일 지정
		$widths = array(30,30,30,20,20,20,20,20,20,20); //넓이 사이즈 조정
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
				'size' => 13 //폰트설정
			),
			'alignment' => array(
				'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
			)
		];
		$excel->getActiveSheet()->getStyle("A1:J".(count($rows)+1))->applyFromArray($fontStyle);//1행
		$excel->getActiveSheet()->getStyle("A1:A".(count($rows)+1))->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB($left_bgcolor);//getStyle(어느부분에 블록으로 제목 색깔처리해줄것인지설정)  //1열("A1:A")
		$excel->getActiveSheet()->setTitle("판매현황");
		//$excel->getActiveSheet()->getStyle('A1:G20')
		//	->getProtection()->setLocked(PHPExcel_Style_Protection::PROTECTION_UNPROTECTED);

		$writer = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');

		header("Content-Type: application/vnd.ms-excel");
		header("Content-Disposition: attachment; filename=cy_".date("Ymdhis").".xlsx");//다운받을 파일이름 설정
		header("Cache-Control: max-age=0");
		$writer->save("php://output");
	}

		//약재코드로 약재명(medicine_djmedi)조회
		function getname($medicode)
		{
			global $dbH;
			$medivalue="";
			if($medicode)
			{				
				$sql=" select mm_title_kor mmTitleName from ".$dbH."_medicine_djmedi where md_code= '".$medicode."' ";
				$res=dbqry($sql);	
				
				while($hub=dbarr($res))
				{					
					$medivalue.=$hub["mmTitleName"];
				}				
			}
			return $medivalue;		
		}
?>
