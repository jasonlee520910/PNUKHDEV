<?php
	header('Content-Type: text/html; charset=utf-8');
	
	$result_array = Array();
	
	//$PAY_INFO = Array();
	$PAY_INFO["MSG_CODE"] = "1900";	//승인코드      
	$PAY_INFO["MID"] = $_POST["MID"]; 
	$PAY_INFO["PAY_METHOD"] = $_POST["PAY_METHOD"]; 
	$PAY_INFO["TID"] = $_POST["TID"]; 
	$PAY_INFO["CANCEL_AMT"] = $_POST["CANCEL_AMT"]; 
	$PAY_INFO["RESERVED01"] = $_POST["RESERVED01"]; 
	$PAY_INFO["RESERVED02"] = $_POST["RESERVED02"]; 
	
	if($_POST["taxYn"] == "Y"||$_POST["taxYn"] == "N"){
		$PAY_INFO["TAX_YN"] = $_POST["taxYn"];
		$PAY_INFO["TAX_AMT"] = $_POST["taxAmt"];
	}
	
	// 승인응답 --------------------------------------------------------------------------
	
	
	$run = "/usr/java/jdk1.8.0_144/bin/java -jar /PG/web/bin/ccPayHandler-1.0.3.jar";
	$arg = http_build_query($PAY_INFO);
	$flag = "CANCEL";
	$space=" ";
	$path = "/PG/web/config/pgcs.cfg";

	$cmd=$run.$space.escapeshellarg($PAY_INFO["PAY_METHOD"]).$space.escapeshellarg($flag).$space."\"".$arg."\"".$space.escapeshellarg($path);
echo $cmd."<br>";	
	$result = exec($cmd);
var_dump($result);	

	parse_str($result, $result_array);


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>승인결과</title>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
</head>
<body>
	<style>
		.returnTable{
			border-collapse: collapse;
			border: 1px solid #4c7eaf;
			background-color: #ffffff;
		}
		
		.returnTable td {
			padding: 3px;
		}
		
		.returnTable td:nth-child(1){
			font-size: 15px;
			font-weight: bold;
			color: #666666;
			font-family:"맑은 고딕";
			border-bottom: 1px solid #4c7eaf;
			background-color:#4c7eaf;
			color: #ffffff;
			width: 200px;
		}
		
		.returnTable td input{
			border-radius: 4px;
			border: 1px solid #BFBCBC;
			padding: 8px;
		}
		
		#succ span{
			ont-size: 10px;
			font-weight: bold;
			color: #4c7eaf;
			font-family:"맑은 고딕";
			color:#4c7eaf;
			width: 200px;
		}
		
		#succ tr{
			height: 10px;
		}
		
		div {
			font-size: 20px;
			padding-left: 10px;
			font-weight: bold;
			color: #8a8a8a;
		}
	</style>
	<div>승인응답</div>
	<table class="returnTable">
	<?=var_dump($result_array);?>
		<tr><td>결과코드(가맹점)</td><td><input type="text" style="width:500px;" value="<?=$result_array["RESULT_CODE"]?>"/>&nbsp;</td></tr>
		<tr><td>결과메시지(가맹점)</td><td><input type="text" style="width:500px;" value="<?=$result_array["RESULT_MSG"]?>"/>&nbsp;</td></tr>
		<tr><td>결과코드(사용자)</td><td><input type="text" style="width:500px;" value="<?=$result_array["DRESULT_CODE"]?>"/>&nbsp;</td></tr>
		<tr><td>결과메시지(사용자)</td><td><input type="text" style="width:500px;" value="<?=$result_array["DRESULT_MSG"]?>"/>&nbsp;</td></tr>
		<tr><td>거래번호</td><td><input type="text" style="width:500px;" value="<?=$result_array["TID"]?>"/>&nbsp;</td></tr>
		<tr><td>취소금액</td><td><input type="text" style="width:500px;" value="<?=$result_array["CANCEL_AMT"]?>"/>&nbsp;</td></tr>
		<tr><td>예약필드1</td><td><input type="text" style="width:500px;" value="<?=$result_array["RESERVED01"]?>"/>&nbsp;</td></tr>
		<tr><td>예약필드2</td><td><input type="text" style="width:500px;" value="<?=$result_array["RESERVED02"]?>"/>&nbsp;</td></tr>
	</table>
</body>
</html>
