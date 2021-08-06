<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xml:lang="ko" lang="ko" xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>신용카드 결제취소</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<script type="text/javascript">
		function goCancel(){
			document.form_koces_payment.action = 'card_cancel_return.php';
			document.form_koces_payment.target = "_self";
			document.form_koces_payment.submit();
		}
	</script>
	<style>
	
		input[type="text"] { width:450px; }
		input[type="button"] { height: 50px; width : 150px; font-size : 14px; color:#fff; background-color:#4c7eaf; border-style: none;}
		input[type="button"]:hover{background-color: #255ead; cursor: pointer;}
		
		#reqTable {
			border-collapse: collapse;
			border: 1px solid #4c7eaf;
			background-color: #ffffff;
		}
		
		#reqTable td {
			padding: 3px;
		}
		
		#reqTable .rtable_title{
			font-size: 15px;
			font-weight: bold;
			color: #666666;
			font-family: "맑은 고딕";
			border-bottom: 1px solid #f7f7f7;
		}
		
		#reqTable .rtable_title{
			border-bottom: 1px solid #4c7eaf;
		}
		
		#reqTable td input{
			border-radius: 4px;
			border: 1px solid #BFBCBC;
			padding: 8px;
		}

		#reqTable td:first-child{
			background-color:#4c7eaf;
			color: #ffffff;
		}

		#reqTable td:nth-child(3){
			padding: 5px;
			font-size: 14px;
			color: #666666;
			font-weight: bold;
			padding-right: 10px;
		}

		#reqTable td:nth-child(4){
			font-size: 13px;
			font-family: "맑은 고딕";
			color: #666666;
		}
		
		div {
			font-size: 20px;
			padding-left: 10px;
			font-weight: bold;
			color: #8a8a8a;
		}
		
	</style>
</head>
<body>
	<form id="form_koces_payment" name="form_koces_payment" method="post">
		<div>신용카드 취소 정보</div>
		<table id="reqTable">
			<tr>
				<td class="rtable_title">01. 상점 ID</td>
				<td><input type="text" id="MID" name="MID" value="M20170713100003" /></td>
				<td><span>상점별로 부여되는 상점 ID</span></td>
				<td>Ex) M20170821113324</td>
			</tr>
			<tr>
				<td class="rtable_title">02. 결제수단</td>
				<td><input type="text" id="PAY_METHOD" name="PAY_METHOD" value="CC" /></td>
				<td><span>결제수단</span></td>
				<td>Ex) CC</td>
			</tr>
			<tr>
				<td class="rtable_title">03. 거래번호</td>
			  	<td><input type="text" id="TID" name="TID" value="" /></td>
			  	<td colspan="2"><span>거래번호(거래ID)</span></td>
			</tr>
			<tr>
				<td class="rtable_title">04. 취소금액</td>
			  	<td><input type="text" id="CANCEL_AMT" name="CANCEL_AMT" value="1004" /></td>
			  	<td><span>상점 구매상품명</span></td>
			  	<td>※ 반드시 숫자만 포함.</td>
			</tr>
			<tr>
				<td class="rtable_title">05. 가맹점예약필드1</td>
			  	<td><input type="text" id="RESERVED01" name="RESERVED01" value="가맹점예약필드 1" /></td>
			  	<td colspan="2"><span>가맹점예약필드 1 (응답시 반환용)</span></td>
			</tr>
			<tr>
				<td class="rtable_title">06. 가맹점예약필드2</td>
			  	<td><input type="text" id="RESERVED02" name="RESERVED02" value="가맹점예약필드 2" /></td>
			  	<td colspan="2"><span>가맹점예약필드 2 (응답시 반환용)</span></td>
			</tr>
			<tr>
				<td class="rtable_title">07. 부가세여부 </td>
			  	<td><input type="text" id="TAX_YN" name="TAX_YN" value="" /></td>
			  	<td><span>부가세여부</span></td>
			  	<td>Ex) Y / N</td>
			</tr>
			<tr>
				<td class="rtable_title">08. 부가세금액 </td>
			  	<td><input type="text" id="TAX_AMT" name="TAX_AMT" value="" /></td>
			  	<td colspan="2"><span>부가세금액</span></td>
			</tr>
		</table>
		<div style="width:1228px; text-align: center; margin-top: 20px;">
			<input type="button" value="결제취소" onclick="goCancel();" />
		</div>
	</form>
</body>
</html>