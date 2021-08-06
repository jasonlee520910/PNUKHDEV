<?php
	header('Content-Type: text/html; charset=utf-8');
	
	$RESULT_CODE = $_POST["RESULT_CODE"];
	$RESULT_MSG = $_POST["RESULT_MSG"];
	$DRESULT_CODE = $_POST["DRESULT_CODE"];
	$DRESULT_MSG = $_POST["DRESULT_MSG"];

	$result_array = Array();
	$PAY_INFO = Array();

	$PAY_INFO["PAY_METHOD"] = $_POST["PAY_METHOD"];							//VA:가상계좌  CC:신용카드                

	if($RESULT_CODE == "EC0000") { // 성공시

		if($PAY_INFO["PAY_METHOD"] == "CC"){
			$PAY_INFO["MSG_CODE"] = "1000";									//승인코드
		}else if($PAY_INFO["PAY_METHOD"] == "BA"){
			$PAY_INFO["MSG_CODE"] = "2000";
		}else if($PAY_INFO["PAY_METHOD"] == "VA"){
			$PAY_INFO["MSG_CODE"] = "3000";
		}
		
		$PAY_INFO["MID"] = $_POST["MID"];									//상점ID      
		//결제하는 상점이 다수일 경우 pgcs.cfg설정파일의 KEY_STORE_TYPE항목을 ETC로 변경 후
		//결제진행 하고자하는 상점정보를 MID, API_KEY를 payInfo에 넣어준다.
		//$PAY_INFO["MID"] = "";
		//$PAY_INFO["API_KEY"] = "";           
		$PAY_INFO["CID"] = $_POST["CID"];									//계약ID                       
		$PAY_INFO["TID"] = $_POST["TID"];									//원거래번호                   
		$PAY_INFO["ORDERNO"] = $_POST["ORDERNO"];							//주문번호                     
		$PAY_INFO["BUYER_NM"] = $_POST["BUYER_NM"];							//구매자명                     
		$PAY_INFO["BUYER_EMAIL"] = $_POST["BUYER_EMAIL"];					//구매자E-MAIL                 
		$PAY_INFO["BUY_REQAMT"] = $_POST["BUY_REQAMT"];						//상품금액                     
		$PAY_INFO["BANK_CD"] = $_POST["BANK_CD"];							//선택한 은행코드              
		$PAY_INFO["TRBEGIN"] = $_POST["TRBEGIN"];							//입금시작일                   
		$PAY_INFO["TREND"] = $_POST["TREND"];								//입금종료일                   
		$PAY_INFO["CATR_ISSUE_YN"] = $_POST["CATR_ISSUE_YN"];				//현금영수증 발급 여부코드 목록
		$PAY_INFO["CATR_ISSUE_METHOD"] = $_POST["CATR_ISSUE_METHOD"];		//현금영수증 발급수단          
		$PAY_INFO["CATR_ISSUE_TYPE"] = $_POST["CATR_ISSUE_TYPE"];			//현금영수증 발급 용도         
		$PAY_INFO["CATR_ISSUE_CONTENTS"] = $_POST["CATR_ISSUE_CONTENTS"];	//현금영수증 발급 내용         
		$PAY_INFO["CORP_TYPE"] = $_POST["CORP_TYPE"];						//고객유형(법인/개인)          
		$PAY_INFO["CURRENCY_TYPE"] = $_POST["CURRENCY_TYPE"];				//통화유형                     
		$PAY_INFO["RESERVED01"] = $_POST["RESERVED01"];						//예약필드1                    
		$PAY_INFO["RESERVED02"] = $_POST["RESERVED02"];						//예약필드2                    
		$PAY_INFO["PAYMENT_TYPE"] = $_POST["PAYMENT_TYPE"];					//ISP/SMPI/XMPI/KMPI/KBAPP/LOCAL01/LOCAL02
		$PAY_INFO["PAY_KEY"] = $_POST["PAY_KEY"];							//인증추적키
		$PAY_INFO["BANK_NM"] = $_POST["BANK_NM"];							//은행명
		$PAY_INFO["ESCR_FLAG"] = $_POST["ESCR_FLAG"];						//에스크로 적용여부
			
		// 승인응답 --------------------------------------------------------------------------
		if($PAY_INFO["PAY_METHOD"] == "CC"){
			//$run = "java -jar /home/T-PGCS/bin/ccPayHandler-1.0.0.jar";
			$run = "java -jar C:\\inetpub\\T-PGCS\\bin\\ccPayHandler-1.0.0.jar";
			//$path="/home/T-PGCS/config/pgcs.cfg";
			$path = "C:\\inetpub\\T-PGCS\\config\\pgcs.cfg";
		} else if($PAY_INFO["PAY_METHOD"] == "BA"){
			//$run = "java -jar /home/T-PGCS/bin/ccPayHandler-1.0.0.jar";
			$run = "java -jar C:\\inetpub\\T-PGCS\\bin\\baPayHandler-1.0.0.jar";
			$path = "C:\\inetpub\\T-PGCS\\config\\pgcs.cfg";
		} else if($PAY_INFO["PAY_METHOD"] == "VA"){
			$run = "java -jar C:\\inetpub\\T-PGCS\\bin\\vaPayHandler-1.0.0.jar";
			$path = "C:\\inetpub\\T-PGCS\\config\\pgcs.cfg";
		}
		$arg = http_build_query($PAY_INFO);
		$flag = "PAY";
		$space=" ";
		
		$cmd=$run.$space.escapeshellarg($PAY_INFO["PAY_METHOD"]).$space.escapeshellarg($flag).$space."\"".$arg."\"".$space.escapeshellarg($path);

//echo $cmd."<br>";
		$result = exec($cmd);
		
		parse_str($result, $result_array);
	//var_dump($_POST);
	//var_dump($result);

	} else { // 실패시
		$result_array["RESULT_CODE"] = $RESULT_CODE;
		$result_array["RESULT_MSG"] = $RESULT_MSG;
		$result_array["DRESULT_CODE"] = $DRESULT_CODE;
		$result_array["DRESULT_MSG"] = $DRESULT_MSG;
	}
/*	
	function build_query( $query ){
		$query_array = array();

		foreach( $query as $key => $key_value ){
			//$query_array[] = urlencode( $key ) . '=' . urlencode( $key_value );
			$query_array[] = $key . '=' . urlencode( $key_value );
		}

		return implode( '&', $query_array );
	}
*/
?>
<!DOCTYPE html PUBLIC"-//W3C//DTD XHTML 1.0 Transitional//EN""http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>인증 - 승인결과</title>
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
		<tr><td>결과코드(가맹점)</td><td><input type="text" style="width:500px;" value="<?=$result_array["RESULT_CODE"]?>"/>&nbsp;</td></tr>
		<tr><td>결과메시지(가맹점)</td><td><input type="text" style="width:500px;" value="<?=$result_array["RESULT_MSG"]?>"/>&nbsp;</td></tr>
		<tr><td>결과코드(사용자)</td><td><input type="text" style="width:500px;" value="<?=$result_array["DRESULT_CODE"]?>"/>&nbsp;</td></tr>
		<tr><td>결과메시지(사용자)</td><td><input type="text" style="width:500px;" value="<?=$result_array["DRESULT_MSG"]?>"/>&nbsp;</td></tr>
		<tr><td>거래번호</td><td><input type="text" style="width:500px;" value="<?=$result_array["TID"]?>"/>&nbsp;</td></tr>
		<tr><td>주문번호</td><td><input type="text" style="width:500px;" value="<?=$result_array["ORDERNO"]?>"/>&nbsp;</td></tr>
		<tr><td>예약필드1</td><td><input type="text" style="width:500px;" value="<?=$result_array["RESERVED01"]?>"/>&nbsp;</td></tr>
		<tr><td>예약필드2</td><td><input type="text" style="width:500px;" value="<?=$result_array["RESERVED02"]?>"/>&nbsp;</td></tr>
	</table>
	<div style="float: left;">
	<table id="succ"><tr><td colspan="2"><span> [ 신용카드 성공시 아래 항목 필수 ]</span></td></tr></table>
	<table class="returnTable">	
		<tr><td>승인번호</td><td><input type="text" style="width:500px;" value="<?=$result_array["APPROVNO"]?>"/>&nbsp;</td></tr>
		<tr><td>승인일자(YYYYMMDD)</td><td><input type="text" style="width:500px;" value="<?=$result_array["APPRODT"]?>"/>&nbsp;</td></tr>
		<tr><td>승인시각(HH24MISS)</td><td><input type="text" style="width:500px;" value="<?=$result_array["APPROTM"]?>"/>&nbsp;</td></tr>
		<tr><td>승인금액</td><td><input type="text" style="width:500px;" value="<?=$result_array["APPROAMT"]?>"/>&nbsp;</td></tr>
		<tr><td>카드번호</td><td><input type="text" style="width:500px;" value="<?=$result_array["CARD_NO"]?>"/>&nbsp;</td></tr>
		<tr><td>발급사코드</td><td><input type="text" style="width:500px;" value="<?=$result_array["ISSUE_CODE"]?>"/>&nbsp;</td></tr>
		<tr><td>발급사명</td><td><input type="text" style="width:500px;" value="<?=$result_array["ISSUE_NAME"]?>"/>&nbsp;</td></tr>
		<tr><td>매입사코드</td><td><input type="text" style="width:500px;" value="<?=$result_array["PURCHASE_CODE"]?>"/>&nbsp;</td></tr>
		<tr><td>매입사명</td><td><input type="text" style="width:500px;" value="<?=$result_array["PURCHASE_NAME"]?>"/>&nbsp;</td></tr>
		<tr><td>무이자여부</td><td><input type="text" style="width:500px;" value="<?=$result_array["NOINT"]?>"/>&nbsp;</td></tr>
		<tr><td>할부개월수</td><td><input type="text" style="width:500px;" value="<?=$result_array["QUOTA_MONTHS"]?>"/>&nbsp;</td></tr>
		<tr><td>신용카드/체크카드</td><td><input type="text" style="width:500px;" value="<?=$result_array["CHECKCD"]?>"/>&nbsp;</td></tr>
	</table>
	</div>
	
	<div style="float: left; padding-right: 130px;">
	<table id="succ"><tr><td colspan="2"><span> [ 가상계좌 성공시 아래 항목 필수 ] </span></td></tr></table>
	<table class="returnTable">	
		<tr><td>입금시작일</td><td><input type="text" style="width:500px;" value="<?=$result_array["TRBEGIN"]?>"/>&nbsp;</td></tr>
		<tr><td>입금종료일</td><td><input type="text" style="width:500px;" value="<?=$result_array["TREND"]?>"/>&nbsp;</td></tr>
		<tr><td>결제금액</td><td><input type="text" style="width:500px;" value="<?=$result_array["BUY_REQAMT"]?>"/>&nbsp;</td></tr>
		<tr><td>선택한 은행코드</td><td><input type="text" style="width:500px;" value="<?=$result_array["BANK_CD"]?>"/>&nbsp;</td></tr>
		<tr><td>선택한 은행명</td><td><input type="text" style="width:500px;" value="<?=$result_array["BANK_NM"]?>"/>&nbsp;</td></tr>
		<tr><td>계좌번호</td><td><input type="text" style="width:500px;" value="<?=$result_array["ACCT_NO"]?>"/>&nbsp;</td></tr>
	</table>
	</div>
	
	<div style="float: left; padding-right: 130px;">
	<table id="succ"><tr><td colspan="2"><span> [ 계좌이체 성공시 아래 항목 필수 ] </span></td></tr></table>
	<table class="returnTable">
		<tr><td>상점 ID</td><td><input type="text" style="width:500px;" value="<?=$result_array["MID"]?>"/>&nbsp;</td></tr>
		<tr><td>선택한 은행코드</td><td><input type="text" style="width:500px;" value="<?=$result_array["BANK_CD"]?>"/>&nbsp;</td></tr>
		<tr><td>선택한 은행명</td><td><input type="text" style="width:500px;" value="<?=$result_array["BANK_NM"]?>"/>&nbsp;</td></tr>
		<tr><td>계좌번호</td><td><input type="text" style="width:500px;" value="<?=$result_array["ACCT_NO"]?>"/>&nbsp;</td></tr>
	</table>
	</div>
</body>
</html>
