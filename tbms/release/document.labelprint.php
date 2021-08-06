<?php
	$root="..";
	include_once $root."/_common.php";
	include_once $root."/_Inc/headpop.php";

	//$lblCnt=$_GET["lblCnt"];
	$code=$_GET["code"];
	$type=$_GET["type"];

	//$type="A";//일반
	//$type="B";//입원,외래

	$apiData="code=".$code;
?>
<script src="<?=$root?>/_Js/jquery.qrcode.js"></script> <!-- 새로추가한 jquery -->
<script src="<?=$root?>/_Js/qrcode.js"></script> <!-- 새로추가한 jquery -->
<style>
	html, body{padding:0;margin:0;/*width:8cm;height:6cm;border:1px solid red;*/}
	.section_print{width: 7.6cm;height: 5.6cm;text-align:center;line-height:3cm;font-family:"NanumSquareRoundB";padding:5px;border:1px solid black;}
	.section_print .lbtbl tr{height:20px;/*border: 1px solid #888;*/}
	.section_print .lbtbl th{text-align:left;font-size:13px;/*border: 1px solid #888;*/}
	.section_print .lbtbl td{text-align:left;font-size:13px;/*border: 1px solid #888;*/}
</style>
<script>
window.addEventListener('afterprint', (event) => {
	self.close();
});
</script>
	<div class="section_print">
		
		<?php if($type=="A"){ ?> <!-- 일반 -->
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
		<?php }else if($type=="B"){ ?> <!-- 입원 -->
		<table class="lbtbl">
			<col width="18%">
			<col width="18%">
			<col width="*">
			<col width="8%">
			<col width="3%">
			<col width="8%">
			<tbody>
			<tr>
				<td colspan="2" id="wardroombed">4K(4K-06-04)</td>
				<td rowspan="2"><span id="odName">오은숙개발</span>님</td>
				<td colspan="3" id="patientcode">126673353</td>
			</tr>
			<tr>
				<td colspan="2">오더:<span id="clientorderdate">2020-05-26</span></td>
				<td colspan="2" id="patientage">47/M</td>
				<td id="diagnosisName">입원</td>
			</tr>
			<tr>
				<td colspan="6">출력:<span id="prtdate">05-26 17:43</span></td>
			</tr>
			<tr>
				<td id="meditype">탕제</td>
				<td id="medidays">1일분</td>
				<td colspan="4"></td>
			</tr>
			<tr>
				<td colspan="6" id="medicapa">100cc*3포</td>
			</tr>
			<tr>
				<td colspan="6" id="mediname">작약감초탕</td>
			</tr>
			<tr>
				<td colspan="4" id="mediadvice">1일 3회 식후 1시간에 1포씩 복용</td>
				<td colspan="2" rowspan="2"><div id="qrdiv"></div></td>
			</tr>
			<tr>
				<td colspan="4">약품유효기간:1개월 이내 복용권장<br>(기간초과시 상담요망)</td>
			</tr>
			</tbody>
		</table>
		<?php }?>
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


			if(!isEmpty(obj["diagnosisCode"]) && obj["diagnosisCode"]!="general")
			{
				if(obj["diagnosisCode"]=="outpatient")//외래이면
				{
				$("#wardroombed").text(obj["wardno"]);
				}
				else
				{
					$("#wardroombed").text(obj["wardno"]+"("+obj["wardno"]+"-"+obj["roomno"]+"-"+obj["bedno"]+")");
				}
				
				$("#patientcode").text(obj["patientcode"]);
				$("#clientorderdate").text(obj["clientorderdate"]);
				$("#patientage").text(obj["patientage"]+"/"+obj["patientgender"]);
				$("#diagnosisName").text(obj["diagnosisName"]);
				$("#prtdate").text(obj["prtDate"]);
				$("#meditype").text(obj["meditype"]);
				$("#medidays").text(obj["medidays"]);

				$("#medicapa").text(obj["medicapa"]);
				$("#mediname").text(obj["mediname"]);
				$("#mediadvice").text(obj["mediadvice"]);
			}





			var qrurl="https://tbms.pnuh.djmedi.net/report/?key="+reportkey;
			console.log("qrurl = " + qrurl)

			$("#qrdiv").qrcode({render : "canvas",
				width : 80,
				height : 80,
				text   : qrurl
				});

			//setTimeout('print();', 500);

		}
	}

	$("#odName").focus();
	callapi('GET','release','releaselabel',"<?=$apiData?>");
</script>