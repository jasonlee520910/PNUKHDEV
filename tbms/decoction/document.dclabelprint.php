<?php
	$root="..";
	include_once $root."/_common.php";
	include_once $root."/_Inc/headpop.php";

	//$lblCnt=$_GET["lblCnt"];
	$code=$_GET["code"];

	$apiData="code=".$code;
?>
<script src="<?=$root?>/_Js/jquery.qrcode.js"></script> <!-- 새로추가한 jquery -->
<script src="<?=$root?>/_Js/qrcode.js"></script> <!-- 새로추가한 jquery -->
<style>
	html, body{padding:0;margin:0;/*width:8cm;height:6cm;border:1px solid red;*/}
	.section_print{width: 7.6cm;height: 5.6cm;text-align:center;line-height:3cm;font-family:"NanumSquareRoundB";padding:5px;/*border:1px solid black;*/}
	.section_print .lbtbl tr{height:20px;}
	.section_print .lbtbl th{text-align:left;font-size:13px;}
	.section_print .lbtbl td{text-align:left;font-size:13px;}
</style>
<script>
window.addEventListener('afterprint', (event) => {
	self.close();
});
</script>
	<div class="section_print">
		<table class="lbtbl">
			<col width="23%">
			<col width="*">
			<col width="25%">
			<tbody>
			<tr>
				<th>이름:</th>
				<td colspan="2" id="odName"></td>
			</tr>
			<tr>
				<th>용량:</th>
				<td colspan="2" id="capa"></td>
			</tr>
			<tr>
				<th>용법:</th>
				<td colspan="2">복약안내문 참고.</td>
			</tr>

			<tr>
			<td colspan="3"></td>
			</tr>

			<tr>
				<th>조제일자:</th>
				<td colspan="2" id="maDate"></td>
			</tr>
			<tr>
				<th>복용기한:</th>
				<td colspan="2">제조일로부터 3개월 이내</td>
			</tr>
			<tr>
				<th>조제자명:</th>
				<td id="msStaffName"></td>
				<td rowspan="3" style="text-align:center;"><div id="qrdiv"></div></td>
			</tr>
			<tr>
				<th>탕전실명:</th>
				<td>부산대학교한방병원 원외탕전실 (경남 양산시 물급읍 금오로20)</td>
			</tr>
			<tr>
				<th>조제번호:</th>
				<td id="odCode"></td>
			</tr>
			</tbody>
		</table>
	</div>
<script>

	function makepage(json)
	{
		var obj = JSON.parse(json);
		console.log(obj);
		if(obj["apiCode"]=="releaselabel")
		{
			$("#odName").text(obj["odName"]);//환자명
			$("#capa").text(obj["odPackcapa"]+"cc x "+obj["odPackcnt"]+"팩");//용량
			$("#maDate").text(obj["maDate"]);
			$("#msStaffName").text(obj["msStaffName"]);
			$("#odCode").text(obj["odCode"]);
			var reportkey=obj["reportkey"];


			var qrurl="https://tbms.dev.pnuh.djmedi.net/report/?key="+reportkey;
			console.log("qrurl = " + qrurl)

			$("#qrdiv").qrcode({render : "canvas",
				width : 80,
				height : 80,
				text   : qrurl
				});

			setTimeout('print();', 500);

		}
	}

	$("#odName").focus();
	callapi('GET','release','releaselabel',"<?=$apiData?>");
	//탕전UI에 맞게 수정 후 API도 수정해야함. 
</script>