<?php
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
		$newmobile = array();
		foreach($sheetData as $rows) {
			if($i>0){
				if($rows["D"]!=null)array_push($newmobile,$rows["D"]);
				if($rows["E"]!=null)array_push($newmobile,$rows["E"]);
				if($rows["F"]!=null)array_push($newmobile,$rows["F"]);
				if($rows["G"]!=null)array_push($newmobile,$rows["G"]);
			}
			$i++;
		}
		echo "<script src='".$root."/adm/_common/jquery-1.11.2.min.js'></script>";
		$json=json_encode($newmobile);
		$tot=count($newmobile)."<br>";
		$net=count(array_unique($newmobile));


		if($tot == $net){
			//업데이트 시작
			$oridata = array();
			$sql=" select HOUSE_ID_DONG, HOUSE_ID_HO, HOUSE_NAME, MOBILE_NO, MOBILE_NO2, MOBILE_NO3, MOBILE_NO4  
					from SM_HOUSE_MST_INFO where HOUSE_ID_DONG <>'' and HOUSE_ID_HO <> ''
					order by HOUSE_ID_DONG, HOUSE_ID_HO ";
			$res=dbqry($sql);
			while($dt=dbarr($res)){
				$oridata[$dt["HOUSE_ID_DONG"].$dt["HOUSE_ID_HO"]]=array($dt["MOBILE_NO"],$dt["MOBILE_NO2"],$dt["MOBILE_NO3"],$dt["MOBILE_NO4"],$dt["HOUSE_NAME"]);
				array_push($oridata,$rowdata);
			}
			$cnt=0;
			$errstr="";
			$newdata = array();
			$i=0;
			$chktelno=array("010","011","016","017","018","019");
			foreach($sheetData as $rows) {
				if($i>0){
					$rowdata=array($rows["A"],$rows["B"],$rows["D"],$rows["E"],$rows["F"],$rows["G"]);
					array_push($newdata,$rowdata);
					if($rows["D"] && (strlen(trim($rows["D"])) < 12 || strlen(trim($rows["D"])) > 13 || in_array(substr(trim($rows["D"]),0,3),$chktelno)<1 )){
						$substr.='<li><dl><dd>'.$rows["C"].'</dd><dd style="color:red;">'.trim($rows["D"]).' (오류) </dd></dl></li>';
						$errstr="1";
						$cnt++;
					}
					if($rows["E"] && (strlen(trim($rows["E"])) < 12 || strlen(trim($rows["E"])) > 13 || in_array(substr(trim($rows["E"]),0,3),$chktelno)<1 )){
						$substr.='<li><dl><dd>'.$rows["C"].'</dd><dd style="color:red;">'.trim($rows["E"]).' (오류) </dd></dl></li>';
						$errstr="1";
						$cnt++;
					}
					if($rows["F"] && (strlen(trim($rows["F"])) < 12 || strlen(trim($rows["F"])) > 13 || in_array(substr(trim($rows["F"]),0,3),$chktelno)<1 )){
						$substr.='<li><dl><dd>'.$rows["C"].'</dd><dd style="color:red;">'.trim($rows["F"]).' (오류) </dd></dl></li>';
						$errstr="1";
						$cnt++;
					}
					if($rows["G"] && (strlen(trim($rows["G"])) < 12 || strlen(trim($rows["G"])) > 13 || in_array(substr(trim($rows["G"]),0,3),$chktelno)<1 )){
						$substr.='<li><dl><dd>'.$rows["C"].'</dd><dd style="color:red;">'.trim($rows["G"]).' (오류) </dd></dl></li>';
						$errstr="1";
						$cnt++;
					}
				}
				$i++;
			}
			//CSS
			$str='<style>ul.resul{margin:10px 0 10px 0;overflow:hidden;} ul.resul li{overflow:hidden;padding:5px 0;float:left;width:50%;border-bottom:1px solid #aaa;}</style>';
			$str.='<style>ul.resul li dl dd{display:inline;font-size:14px;padding:5px 10px 5px 10px;}</style>';
			$str.='<style>ul.resul li dl dd i{color:#ccc;}</style>';
			$str.='<style>ul.resul li dl dd b{color:#000;font-size:14px;}</style>';
			
			if($errstr==1){
				//오류데이터존재
				$str.='<div class="respop"><h3	style="font-size:15px;font-weight:bold;">입주자 전화번호오류 ('.$cnt.' 건)</h3><ul class="resul"style="">';
				$str.=$substr;
				$str.='</ul><p style="clear:both;padding:10px 0 0 0;text-align:center;"><span class="btn btn_primary" onclick="clsrespop()">닫기</span></p></div>';
				?>
					<script>
						var txt='<div id="respop"><div id="resdiv" style="border:3px solid #111;"><?=$str?></div></div>';
						$("body", parent.document).prepend(txt);
					</script>
				<?php
			}else{
				/* 데이터 처리 */
				//데이터비교 후 업데이트
				$cnt=0;
				$chkstr="";
				$substr="";
				foreach($newdata as $val){
					if(str_replace("-","",trim($val[2]))!=str_replace("-","",trim($oridata[$val[0].$val[1]][0]))){
						$sql=" update SM_HOUSE_MST_INFO set MOBILE_NO = '".$val[2]."',HOUSE_PWD='', CHANGE_DATE = now() 
									where HOUSE_ID_DONG = '".$val[0]."' and HOUSE_ID_HO = '".$val[1]."'";
						echo $sql."<br>";
						dbqry($sql);
						$cnt++;
						if(trim($oridata[$val[0].$val[1]][0])){$oritel=trim($oridata[$val[0].$val[1]][0]);}else{$oritel="<i>없음</i>";}
						if(trim($val[2])){$newtel=trim($val[2]);}else{$newtel="<i>없음</i>";}
						$substr.="<li><dl><dd>".$oridata[$val[0].$val[1]][4]."</dd><dd>".$oritel." -> <b>".$newtel."</b></dd></dl></li>";
						$chkstr="1";
					}
					if(str_replace("-","",trim($val[3]))!=str_replace("-","",trim($oridata[$val[0].$val[1]][1]))){
						$sql=" update SM_HOUSE_MST_INFO set MOBILE_NO2 = '".$val[3]."',HOUSE_PWD2='', CHANGE_DATE = now() 
									where HOUSE_ID_DONG = '".$val[0]."' and HOUSE_ID_HO = '".$val[1]."'";
						echo $sql."<br>";
						dbqry($sql);
						$cnt++;
						if(trim($oridata[$val[0].$val[1]][1])){$oritel=trim($oridata[$val[0].$val[1]][1]);}else{$oritel="<i>없음</i>";}
						if(trim($val[3])){$newtel=trim($val[3]);}else{$newtel="<i>없음</i>";}
						$substr.="<li><dl><dd>".$oridata[$val[0].$val[1]][4]."</dd><dd>".$oritel." -> <b>".$newtel."</b></dd></dl></li>";
						$chkstr="1";
					}
					if(str_replace("-","",trim($val[4]))!=str_replace("-","",trim($oridata[$val[0].$val[1]][2]))){
						$sql=" update SM_HOUSE_MST_INFO set MOBILE_NO3 = '".$val[4]."',HOUSE_PWD3='', CHANGE_DATE = now()   
									where HOUSE_ID_DONG = '".$val[0]."' and HOUSE_ID_HO = '".$val[1]."'";
						echo $sql."<br>";
						dbqry($sql);
						$cnt++;
						if(trim($oridata[$val[0].$val[1]][2])){$oritel=trim($oridata[$val[0].$val[1]][2]);}else{$oritel="<i>없음</i>";}
						if(trim($val[4])){$newtel=trim($val[4]);}else{$newtel="<i>없음</i>";}
						$substr.="<li><dl><dd>".$oridata[$val[0].$val[1]][4]."</dd><dd>".$oritel." -> <b>".$newtel."</b></dd></dl></li>";
						$chkstr="1";
					}
					if(str_replace("-","",trim($val[5]))!=str_replace("-","",trim($oridata[$val[0].$val[1]][3]))){
						$sql=" update SM_HOUSE_MST_INFO set MOBILE_NO4 = '".$val[5]."',HOUSE_PWD4='', CHANGE_DATE = now()   
									where HOUSE_ID_DONG = '".$val[0]."' and HOUSE_ID_HO = '".$val[1]."'";
						echo $sql."<br>";
						dbqry($sql);
						$cnt++;
						if(trim($oridata[$val[0].$val[1]][3])){$oritel=trim($oridata[$val[0].$val[1]][3]);}else{$oritel="<i>없음</i>";}
						if(trim($val[5])){$newtel=trim($val[5]);}else{$newtel="<i>없음</i>";}
						$substr.="<li><dl><dd>".$oridata[$val[0].$val[1]][4]."</dd><dd>".$oritel." -> <b>".$newtel."</b></dd></dl></li>";
						$chkstr="1";
					}
					$sql=" update SM_HOUSE_MST_INFO set";
					if(trim($val[2])=="" && trim($val[3])=="" && trim($val[4])=="" && trim($val[5])==""){
						$sql.=" HOUSE_USE = 'N'";
					}else{
						$sql.=" HOUSE_USE = 'Y'";
					}
					$sql.=" where HOUSE_ID_DONG = '".$val[0]."' and HOUSE_ID_HO = '".$val[1]."'"; 
					dbqry($sql);
				}
				if($cnt < 1){
					echo "<script>alert('업로드 성공 후 변경된 동/호가 없습니다.');</script>";
					echo "<script>top.location.reload();</script>";
				}
			}
		}else{
			$str='<style>ul.resul{margin:10px 0 10px 0;overflow:hidden;} ul.resul li{overflow:hidden;padding:5px 0;float:left;width:50%;border-bottom:1px solid #aaa;}</style>';
			$str.='<style>ul.resul li dl dd{display:inline;font-size:14px;padding:5px 10px 5px 10px;}</style>';
			$newdata = array();
			$i=$cnt=0;
			foreach($sheetData as $rows) {
				if($i>0){
					if(count(array_keys($newmobile, $rows["D"])) > 1 ){
						$substr.="<li><dl><dd>".$rows["C"]."</dd><dd>".$rows["D"]."</dd></dl></li>";
						$cnt++;
					}
					if(count(array_keys($newmobile, $rows["E"])) > 1 ){
						$substr.="<li><dl><dd>".$rows["C"]."</dd><dd>".$rows["E"]."</dd></dl></li>";
						$cnt++;
					}
					if(count(array_keys($newmobile, $rows["F"])) > 1 ){
						$substr.="<li><dl><dd>".$rows["C"]."</dd><dd>".$rows["F"]."</dd></dl></li>";
						$cnt++;
					}
					if(count(array_keys($newmobile, $rows["G"])) > 1 ){
						$substr.="<li><dl><dd>".$rows["C"]."</dd><dd>".$rows["G"]."</dd></dl></li>";
						$cnt++;
					}
				}
				$i++;
			}
			//중복데이터존재
			$str.='<div class="respop"><h3	style="font-size:15px;font-weight:bold;">입주자 중복전화번호 ('.$cnt.' 건)</h3><ul class="resul"style="">';
			$str.=$substr;
			$str.='</ul><p style="clear:both;padding:10px 0 0 0;text-align:center;"><span class="btn btn_primary" onclick="clsrespop()">닫기</span></p></div>';
		?>
			<script>
				var txt='<div id="respop"><div id="resdiv" style="border:3px solid #111;"><?=$str?></div></div>';
				$("body", parent.document).prepend(txt);
			</script>
		<?php
		}
		if($chkstr==1){
			$str.='<div class="respop"><h3	style="font-size:15px;font-weight:bold;">입주자 업로드 결과 ('.$cnt.' 건)</h3><span style="float:right;margin-top:-10px;font-size:15px;">현재전화번호 -> 수정전화번호</span><ul class="resul"style="">';
			$str.=$substr;
			$str.='</ul><p style="clear:both;padding:10px 0 0 0;text-align:center;"><span class="btn btn_primary" onclick="successpop()">닫기</span></p></div>';
		?>
			<script>
				var txt='<div id="respop"><div id="resdiv" style="border:3px solid #111;"><?=$str?></div></div>';
				$("body", parent.document).prepend(txt);
			</script>
		<?php
		}
	}else{
		echo "<script>alert('업로드 된 파일이 없습니다.');</script>";
	}
?>