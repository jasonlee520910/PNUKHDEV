<?php
	$orderdt = date("Ymd");
	$ordertm = date("His");
	
	$orderno = "ORDER12345";		//주문번호
	$buyReqamt = "1004";			//주문금액
		
	$serverMode = "FALSE";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xml:lang="ko" lang="ko" xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>통합결제 - 신용카드</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<script src="//code.jquery.com/jquery.min.js"></script>	
	<script type="text/javascript">
		//var PG_DOMAIN  = 'https://auth.kocespay.com';		// 운영
		var PG_DOMAIN  = 'https://authtest.kocespay.com';		// 개발
		
		function goPc(){
			window.name = "myOpener";
			var win;
			var iLeft = (window.screen.width / 2) - (Number(550) / 2);
		  var iTop = (window.screen.height / 2) - (Number(653) / 2);
			var features = "menubar=no,toolbar=no,status=no,resizable=no,scrollbars=no,location=no";
			features += ",left=" + iLeft + ",top=" + iTop + ",width=" + 550 + ",height=" + 653;
			win = window.open("", "pcPop", features);
			win.focus();
			
			document.form_koces_payment.action = PG_DOMAIN+'/webpay/common/mainFrame.pay';
			document.form_koces_payment.target = "pcPop";
			document.form_koces_payment.submit();
		}
		
		function goMobile(){
			window.name = "myOpener";
			var win;
			var iLeft = (window.screen.width / 2) - (Number(550) / 2);
		    var iTop = (window.screen.height / 2) - (Number(653) / 2);
			var features = "menubar=no,toolbar=no,status=no,resizable=no,scrollbars=no,location=no";
			features += ",left=" + iLeft + ",top=" + iTop + ",width=" + 550 + ",height=" + 653;
			win = window.open("", "mobilePop", features);
			win.focus();
			
			document.form_koces_payment.action = PG_DOMAIN+'/mobile/common/mainFrame.pay';
			document.form_koces_payment.target = "mobilePop";
			document.form_koces_payment.submit();
		}

		function goHash(){

		
			var orderno = document.form_koces_payment.orderno.value;
			var orderdt = document.form_koces_payment.orderdt.value;
			var ordertm = document.form_koces_payment.ordertm.value;
			var buyReqamt = document.form_koces_payment.buyReqamt.value;
			var apiKey =  document.form_koces_payment.apiKey.value;


			console.log("orderno>>>"+orderno);
			console.log("orderdt>>>"+orderdt);
			console.log("ordertm>>>"+ordertm);
			console.log("buyReqamt>>>"+buyReqamt);
			console.log("apiKey>>>"+apiKey);

			
			var hashkey =orderno + orderdt + ordertm + buyReqamt;
		        $.ajax({
		            url:'../checkHash.php',
								method:"POST",
		            data : {"message" : hashkey,"apiKey" : apiKey},
		            success:function(resp){
		            document.getElementById('hashtd').innerHTML = resp;
		            },fail:function(resp){
		            	alert("실패");
		            }
		        })
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
		<div>승인요청 정보</div>
		<table id="reqTable">
			<tr>
				<td class="rtable_title">01. 상점 ID</td>
				<td><input type="text" id="mid" name="mid" value="M20170713100003" /></td>
				<td><span>상점별로 부여되는 상점 ID</span></td>
				<td>Ex) M20170713100003</td>
			</tr>
			<tr>
				<td class="rtable_title">02. return URL</td>				
				<td><input type="text" id="rUrl" name="rUrl" value="http://127.0.0.1/php/simplepay/simplepay_return.php" /></td>
				<td ><span>결제 결과를 Return 받을 URL</span></td>
				<td>Ex) https://abc.com/response.jsp</td>
			</tr>
			<tr>
				<td class="rtable_title">03. return Method</td>
				<td><input type="text" id="rMethod" name="rMethod" value="POST" /></td>
				<td><span>결제 결과를 Return 받을 HTTP 메소드</span></td>
				<td>Ex) POST / GET</td>
			</tr>
			<tr>
				<td class="rtable_title">04. 결제수단</td>
			  	<td><input type="text" id="payType" name="payType" value="" /></td>
			  	<td><span>결제 화면에서 가용한 결제수단<br>(CC:신용카드, VA:가상계좌)</span></td>
			  	<td>Ex) CC</td>
			</tr>
			<tr>
				<td class="rtable_title">05. 상품명</td>
			  	<td><input type="text" id="buyItemnm" name="buyItemnm" value="오이비누" /></td>
			  	<td><span>상점 구매상품명</span></td>
			  	<td>Ex) 오이비누</td>
			</tr>
			<tr>
				<td class="rtable_title">06. 상품가격</td>
			  	<td><input type="text" id="buyReqamt" name="buyReqamt" value="<?=$buyReqamt?>" /></td>
			  	<td><span><font style="color:red;">※ 반드시 숫자만 포함.</font></span></td>
			  	<td>Ex) 5000</td>
			</tr>
			<tr>
				<td class="rtable_title">07. 상품코드</td>
			  	<td><input type="text" id="buyItemcd" name="buyItemcd" value="oiSoap" /></td>
			  	<td><span>상점 판매상품코드</span></td>
			  	<td>Ex) oiSoap</td>
			</tr>
			<tr>
				<td class="rtable_title">08. 구매자 ID</td>
			  	<td><input type="text" id="buyerid" name="buyerid" value="gildonghong" /></td>
			  	<td><span>상점 구매자 ID</span></td>
			  	<td>Ex) gildonghong</td>
			</tr>
			
			<tr>
				<td class="rtable_title">09. 구매자명</td>
			  	<td><input type="text" id="buyernm" name="buyernm" value="홍길동" /></td>
			  	<td><span>상점 구매자명</span></td>
			  	<td>Ex) 홍길동</td>
			</tr>
			<tr>
				<td class="rtable_title">10. 구매자 E-mail</td>
			  	<td><input type="text" id="buyerEmail" name="buyerEmail" value="jdh@tnctec.co.kr" /></td>
			  	<td><span>상점 구매자 Email 주소</span></td>
			  	<td>Ex) gildong2@koces.com</td>
			</tr>
			<tr>
				<td class="rtable_title">11. 주문번호</td>
			  	<td><input type="text" id="orderno" name="orderno" value="<?=$orderno?>" /></td>
			  	<td><span>상점 주문번호</span></td>
			  	<td>Ex) 2017060140292100</td>
			</tr>
			<tr>
				<td class="rtable_title">12. 주문일자</td>
			  	<td><input type="text" id="orderdt" name="orderdt" value="<?=$orderdt?>" /></td>
			  	<td><span>상점 주문일자 (YYYYMMDD)</span></td>
			  	<td>Ex) 2017060140292100</td>
			</tr>
			<tr>
				<td class="rtable_title">13. 주문시간</td>
			  	<td><input type="text" id="ordertm" name="ordertm" value="<?=$ordertm?>" /></td>
			  	<td><span>상점 주문시간 (HHMMSS)</span></td>
			  	<td>Ex) 2017060140292100</td>
			</tr>
			<tr>
				<td class="rtable_title">14. API KEY</td>
			  	<td><input type="text" id="apiKey" name="apiKey" value="cf4dae5bb7b7606aa35e05aaba23b6a6" /></td>
			  	<td colspan="2"><span>API KEY</span></td>
			</tr>
			<?php
				$PAY_INFO = Array();
				$PAY_INFO["MSG_CODE"] = "1100"; //승인코드
				//$PAY_INFO["REQ_TYPE"] = $_POST["REQ_TYPE"];
				$PAY_INFO["REQ_TYPE"] = "R";
				$PAY_INFO["PAY_METHOD"]="CC";
				$run = "java -jar /PG/web/bin/ccPayHandler-1.0.0.jar"; 
				$arg = http_build_query($PAY_INFO);
				$flag = "PAY";
				$space=" ";
				$path="/PG/web/config/pgcs.cfg"; 
				$cmd=$run.$space.escapeshellarg($PAY_INFO["PAY_METHOD"]).$space.escapeshellarg($flag).$space."\"".$arg."\"".$space.escapeshellarg($path); 
				//$cmd=$run.$space.escapeshellarg($PAY_INFO["PAY_METHOD"]).$space.escapeshellarg($flag).$space.escapeshellarg($arg).$space.escapeshellarg($path); 
				echo($cmd)."<br>";
				$result = exec($cmd);
				echo($result)."<br>";
				parse_str($result,$result_array);			
				var_dump($result_array);
			?>
			<tr>
				<td class="rtable_title">15. Hash Key</td>
			  	<td id="hashtd"><input type="text" id="checkHash" name="checkHash" /></td>
			  	<td><span>해시값(검증용)-(orderno+orderdt+ordertm+buyReqamt)</span></td>
			  	<td><input type="button" value="Hash Key 생성" onclick="goHash();" /></td>
			</tr>
			<tr>
				<td class="rtable_title">16. 가맹점예약필드1</td>
			  	<td><input type="text" id="reserved01" name="reserved01" value="가맹점예약필드 1" /></td>
			  	<td colspan="2"><span>가맹점예약필드 1 (응답시 반환용)</span></td>
			</tr>
			<tr>
				<td class="rtable_title">17. 가맹점예약필드2</td>
			  	<td><input type="text" id="reserved02" name="reserved02" value="가맹점예약필드 2" /></td>
			  	<td colspan="2"><span>가맹점예약필드 2 (응답시 반환용)</span></td>
			</tr>
			<tr>
				<td class="rtable_title">18. [신용카드]사용가능 카드 리스트</td>
			  	<td><input type="text" id="cardCode" name="cardCode" value="" /></td>
			  	<td colspan="2"><span>[신용카드]사용가능 카드 리스트</span></td>
			</tr>
			<tr>
				<td class="rtable_title">19. [신용카드]할부개월</td>
			  	<td><input type="text" id="quota" name="quota" value="" /></td>
			  	<td colspan="2"><span>[신용카드]할부개월</span></td>
			</tr>
			<tr>
				<td class="rtable_title">20. [신용카드]카드사별 무이자 할부개월</td>
			  	<td><input type="text" id="noint_inf" name="noint_inf" value="" /></td>
			  	<td colspan="2"><span>[신용카드]카드사별 무이자 할부개월</span></td>
			</tr>
			<tr>
				<td class="rtable_title">21. [가상계좌]사용가능 은행 리스트</td>
			  	<td><input type="text" id="bankCode" name="bankCode" value="" /></td>
			  	<td colspan="2"><span>[가상계좌]사용가능 은행 리스트</span></td>
			</tr>
			<tr>
				<td class="rtable_title">22. [가상계좌]거래 종료 일시</td>
			  	<td><input type="text" id="trend" name="trend" value="" /></td>
			  	<td colspan="2"><span>[가상계좌]거래 종료 일시</span></td>
			</tr>
			<tr>
				<td class="rtable_title">23. 부가세여부  </td>
			  	<td><input type="text" id="taxYn" name="taxYn" value="" /></td>
			  	<td><span>부가세여부</span></td>
			  	<td>Ex) Y / N</td>
			</tr>
			<tr>
				<td class="rtable_title">24. 부가세금액 </td>
			  	<td><input type="text" id="taxAmt" name="taxAmt" value="" /></td>
			  	<td colspan="2"><span>부가세금액</span></td>
			</tr>
		</table>
		<div style="width:1228px; text-align: center; margin-top: 20px;">
			<input type="button" value="PC" onclick="goPc();" />
			<input type="button" value="MOBILE" onclick="goMobile();" />
		</div>
		
	</form>
</body>
</html>
