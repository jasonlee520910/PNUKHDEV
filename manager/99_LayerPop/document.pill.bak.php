`<?php 
	//20190726 : 작업일지출력 
	$root = "..";
	$odCode=$_GET["odCode"];
	$apiprinterData = "odCode=".$odCode;
	include_once ($root.'/cmmInc/headPrint.php');
?>
<style type="text/css">
		/* A4용지에 making, decoction, marking 각각 한장씩 출력하는 css추가*/
		html{background:none; min-width:0; min-height:0;font-weight:bold;}
		.section_print{width: 21cm;min-height: 29.7cm;}
		.barcode img{width:300px;height:54px;}
		.barcodetext {margin-top:-1px;font-size:14px;font-weight:bold;}
		.lst_tb{overflow:hidden;}
		.lst_tb table{width:49%;float:left;margin-right:1%;}
		.lst_tb table.one{width:100%;float:left;margin-right:1%;}
		.form_dtl .lst_tb table tbody tr.meditr td{padding:5px;}
		.form_dtl .lst_tb table tbody tr.meditr td.mediumfont{padding:5px;font-size: 13px;}
		.form_dtl .lst_tb table tbody tr.meditr td.smallfont{padding:5px;font-size: 12px;}
		.totalcapa {float:right;}
		table tr th, table tr td{padding:5px;font-size:15px;}
		.maintbl{width:100%;border-top:1px solid #333;border-left:1px solid #333;margin-bottom:5px;}
		.maintbl tr th, .maintbl tr td{border-right:1px solid #333;border-bottom:1px solid #333}
		.tbltitle tr th{font-size:25px;font-weight:bold;}
		.tblinfo tr th{font-size:13px;}
		.tblinfo tr td{font-size:13px;font-weight:bold;}

		.subtbl{width:100%;border-bottom:1px solid #ddd;}
		.subtbl tr th, .subtbl tr td{border:none;border-right:1px solid #ddd;border-top:1px solid #ddd;font-size:13px;text-align:center;height:28px;}
		.subtbl tr th{font-weight:normal;background:#f4f4f4;}
		.subtbl tr td{font-weight:bold;}

		.fitbl{margin-left:0;margin-right:1px;border-left:none;;}
		.lstbl, .lstbl tr th{border-right:red;border-left: 1px solid #333}
		dl.subbot{/*margin:1%;*/float:right;overflow:hidden;padding-left:5px;font-weight:bold;font-size:13px;}
		dl.subbot dt{float:left;width:auto;padding-right:5px;}
		dl.subbot dd{float:left;text-align:left;padding-right:20px;}
		dl.subbot dd.total{float:left;width:22%;}
		
		.form_cont .half{float:left;width:46%;font-size:14px;padding:5px 2%;margin-bottom:10px;overflow:hidden;}
		.form_cont .rt{float:right;text-align:right;line-height:180%;}
		.form_cont .line{clear:both;margin:15px 15px 20px 15px;;border-top:1px dotted #999;}
		span.spanrt{float:right;margin-right:20px;}
		.etc{font-size:13px;padding:4px;}

		.form_dtl_pop{overflow:hidden; clear:both;width:100%;}
		.form_dtl_pop .fl{float:left; width:69%;}
		.form_dtl_pop .fr{float:right; width:30%;}

		#odRequestDiv {height:60px;text-align: left;overflow-y:auto;}
		.inth {padding-left:10px;padding-right:10px;letter-spacing: -1px;}

		.feature {position:absolute;top:0;right:0;float:right;width:400px;height:40px;margin-top:10px;margin-right:10px;padding-right:10px;font-size:25px;font-weight:bold;text-align:right;}

		#prtNowDate {font-size: 14px;text-align: center; padding: 5px 10px 5px 0;}
		#prtNowId {font-size: 14px;text-align: center; padding: 5px 10px 5px 0;}
		#prtNowIp {font-size: 14px;text-align: center; padding: 5px 5px 5px 0;}
		#smuInoutFlag{float:left;}
		#odTitle{float:right;}
		#odType{background:#4169E1;color:#fff;}
		#dcWater{text-align:right;padding-right:5px;}
		
</style>

<div class="section_print">
    <div class="form_cont" style="padding-top:10px;">
		<div class="barcode" id="barcodeDiv"></div>
		<div class="barcodetext" id="barcodeTextDiv"></div>
		<div class="feature">
<!-- 			<span id="reDelicompAdd"></span>
			<span id="reDelicomp" style='padding:5px 10px;border-radius:10px;background:#3300CC;color:#fff;margin-right:10px;'></span>
			<span id="antler"></span>
			<span id="odFeature"></span>
			 -->		</div>
		<div>
			<table class="maintbl tbltitle">
				<col style="width:10%;">
				<col style="width:90%;">
				<tr>
					<th id="odType">일반</th>
					<th><span id="smuInoutFlag"></span><span id="odTitle"></span></th>
				</tr>
			</table>
			<table class="maintbl tblinfo">
				<tr>
					<th><?=$txtdt["1459"]?><!-- 주문자 --></th>
					<td id="userName"></td>
					<th><?=$txtdt["1100"]?><!-- 받는사람 --></th>
					<td id="reName"></td>
					<th><?=$txtdt["1304"]?><!-- 주문일 --></th>
					<td id="odDate"></td>
				</tr>
				<tr>
					<th><!-- <?=$txtdt["1139"]?>비고 -->환자명</th>
					<td id="odNote">환자명</td>
					<th><?=$txtdt["1889"]?><!-- 생년월일 -->/<?=$txtdt["1888"]?><!-- 성별 --></th>
					<td><span id="odBirth">1889</span> / <span id="odGender">성</span></td>
					<th><?=$txtdt["1112"]?><!-- 배송희망일 --></th>
					<td id="reDelidate">1889</td>
				</tr>
			</table>
			<style>
				.pill dl{width:7%;margin:1%;display:inline-block;vertical-align:top;}
				.pill dl dt{width:auto;border:1px solid #ddd;text-align:center;padding:10px 5px;font-size:17px;font-weight:bold;}
				.pill dl dt.on{color:#111;border:1px solid #333;background:#48DAFF;}
				.pill dl dd{margin:2px auto;width:100%;}

			</style>
			<div class='pill' id="pillorderdiv">
				
			</div>

			<style>
				.medidiv{overflow:hidden;border:1px solid black;padding:5px;margin-bottom:5px;width:100%;}
				.medidiv2{float:left;overflow:hidden;border:1px solid black;padding:0;margin-bottom:5px;width:50%;}
				.medir{float:right;margin-right:0;}
				.subtit{float:left;background:#666;display:inline-block;;color:#fff;vertical-align:top;width:7%;text-align:center;padding:4px 6px;margin:0;font-size:15px;margin:-5px 0 0 -5px;}
				.medidiv2 .subtit{width:14%;margin:0;}

				dl.medilist{float:left;width:93%;}
				dl.medilist dd{display:inline-block;border:1px solid #ddd;padding:3px;margin:2px;}
				dl.medilist dd span{font-size:13px;display:inline-block;width:auto;height:17px;}
				dl.medilist dd span.rect{font-size:12px;border:1px solid #111;text-align:center;background:#777;color:#fff;}
				dl.medilist dd span.icon{font-size:12px;width:17px;border:1px solid #111;border-radius:50%;text-align:center;background:#777;color:#fff;}
				dl.subbot{padding:5px;}
				.desc{padding:10px;}
			</style>
			<div class="medidiv" id="div_medicine">
				<div class='subtit'>조제</div>
				<dl id="medilist" class="medilist"></dl>
				<dl class="subbot">
					<dt><?=$txtdt["1498"]?><!-- 약미 -->: </dt><dd id="odmedicnt"></dd>
					<dt><?=$txtdt["1773"]?><!-- 총용량 -->: </dt><dd class="total" id="odmedicapa"></dd>
				</dl>
			</div>
			<div class="medidiv2" id="div_smash">
				<div class='subtit'>분쇄</div>
				<table class="subtbl">
					<tr><th>분쇄타입</th><th>분말도</th></tr>
					<tr><td id="td_pillMillingloss"></td><td id="td_pillFineness"></td></tr>
				</table>
				<div class='desc'>잘 갈아주세요</div>
			</div>
			<div class="medidiv2" id="div_decoction">
				<div class='subtit'>탕전</div>
				<table class="subtbl">
					<tbody>
					<tr>
						<th><?=$txtdt["1367"]?><!-- 탕전법 --></th>
						<th><?=$txtdt["1369"]?><!-- 탕전시간 --></th>
						<th><?=$txtdt["1366"]?><!-- 탕전물량 --></th>
						<th><?=$txtdt["1381"]?><!-- 특수탕전 --></th>
					</tr>
					<tr>
						<td id="dcTitle"></td>
						<td id="dcTime"></td>
						<td id="dcWater"></td>
						<td id="dcSpecial"></td>
					</tr>
					</tbody>
				</table>
				<div class='desc'>잘 다려주세요</div>
			</div>
			<div class="medidiv2" id="div_concent">
				<div class='subtit'>농축</div>
				<table class="subtbl">
					<tr><th>농축비율</th><th>농축시간</th></tr>
					<tr><td id="td_pillConcentRatio">70%</td><td id="td_pillConcentTime">120분</td></tr>
				</table>
				<div class='desc'>잘 농축 해주세요</div>
			</div>
			<div class="medidiv2" id="div_juice">
				<div class='subtit'>착즙</div>
				<table class="subtbl">
					<tr><th>착즙유무</th></tr>
					<tr><td id="td_pillJuice">유</td></tr>
				</table>
				<div class='desc'>잘 착즙 해주세요</div>
			</div>
			<div class="medidiv2" id="div_mixed">
				<div class='subtit'>혼합</div>
				<table class="subtbl">
					<tr><th>결합제</th><th>결합제량</th></tr>
					<tr><td id="td_pillBinders">70 ℃</td><td id="td_pillBindersliang">72시간</td></tr>
				</table>
				<div class='desc'>잘 혼합 해주세요</div>
			</div>
			<div class="medidiv2" id="div_warmup">
				<div class='subtit'>중탕</div>
				<table class="subtbl">
					<tr><th>중탕온도</th><th>중탕시간</th></tr>
					<tr><td id="td_pillWarmupTemperature">70 ℃</td><td id="td_pillWarmupTime">72시간</td></tr>
				</table>
				<div class='desc'>잘 중탕 해주세요</div>
			</div>
			<div class="medidiv2" id="div_ferment">
				<div class='subtit'>숙성</div>
				<table class="subtbl">
					<tr><th>숙성온도</th><th>숙성시간</th></tr>
					<tr><td id="td_pillFermentTemperature">60 ℃</td><td id="td_pillFermentTime">24시간</td></tr>
				</table>
				<div class='desc'>잘 숙성 시켜주세요</div>
			</div>
			<div class="medidiv2" id="div_plasty">
				<div class='subtit'>제형</div>
				<table class="subtbl">
					<tr><th>제형</th><th>제환손실</th></tr>
					<tr><td id="td_pillShape">호환</td><td id="td_pillLosspill">녹두대</td></tr>
				</table>
				<div class='desc'>잘 제형 해주세요</div>
			</div>
			<div class="medidiv2" id="div_dry">
				<div class='subtit'>건조</div>
				<table class="subtbl">
					<tr><th>건조온도</th><th>건조시간</th></tr>
					<tr><td id="td_pillDryTemperature">70 ℃</td><td id="td_pillDryTime">300분</td></tr>
				</table>
				<div class='desc'>잘 건조 시켜주세요</div>
			</div>
			<div class="medidiv" id="div_packing">
				<div class='subtit'>포장</div>
				<table class="subtbl">
					<col width="33%"><col width="33%"><col width="33%">
					<tr>
						<th id="odpackName"><?=$txtdt["1636"]?><!-- 파우치이미지 --></th>
						<th id="reboxmediName"><?=$txtdt["1637"]?><!-- 포장재이미지 --></th>
						<th id="reboxdeliName"><?=$txtdt["1638"]?><!-- 배송박스이미지 --></th>
					</tr>
					<tr>
						<td id="odPacktype"><img src="https://data.djmedi.kr/data/2018/03/01/20180301193446.jpg"></td>
						<td id="reBoxmedi"><img src="https://data.djmedi.kr/data/2018/03/01/20180301193446.jpg"></td>
						<td id="reBoxdeli"><img src="https://data.djmedi.kr/data/2018/03/01/20180301193446.jpg"></td>
					</tr>
				</table>
				<div class='desc'>잘 포장 해주세요</div>
			</div>
		</div>
    </div> <!-- form_cont div -->
</div><!-- section_print div -->
</body>
</html>
<script type="text/javascript" src="https://jsgetip.appspot.com"></script>
<script>
	function makepage(json)
	{
		console.log("making makepage ----------------------------------------------- ")
		var obj = JSON.parse(json);
		console.log(obj)
		console.log("apiCode : " + obj["apiCode"])
		console.log("-------------------------------------------------------- ")

		if(obj["apiCode"]=="orderprintpill")
		{
			var barcode=obj["odCode"];
			$("#barcodeDiv").barcode(barcode, "code128", {barWidth:2, barHeight: 40, fontSize:15, showHRI:false});
			$("#barcodeDiv").css('width', '600px');
			$("#barcodeDiv").css('height', '40px');
			$("#barcodeDiv").css('margin-left', '-20px');
			//바코드텍스트 
			$("#barcodeTextDiv").text(barcode);

			$("#smuInoutFlag").text(obj["matypeName"]); //탕전
			$("#odTitle").text(obj["odTitle"]);//<!-- 첩약처방명 -->


			//주문자
			$("#userName").text(obj["miName"]);
			//받는사람
			$("#reName").text(obj["reName"]);
			//주문일자
			$("#odDate").text(obj["odDate"]);
			//배송희망일
			$("#reDelidate").text(obj["reDelidate"]);
			//환자명 
			$("#odNote").text(obj["odName"]);
			//성별 
			$("#odGender").text(obj["odGenderName"]);
			//생년월일  
			$("#odBirth").text(obj["odBirth"]);

			//제환순서 
			if(!isEmpty(obj["mrlist"]["pillorder"]))
			{
				pillorder=obj["mrlist"]["pillorder"];
			}
			else
			{
				pillorder="";
			}
			$("#pillorderdiv").html(pillorder);

			//조제 
			if(!isEmpty(obj["mrlist"]["medicine"]))
			{
				$("#div_medicine").show();
				//약재량
				var medicapa=!isEmpty(obj["mrlist"]["totmedicapa"])?obj["mrlist"]["totmedicapa"]:0;
				//약미
				var medicnt=!isEmpty(obj["mrlist"]["rcMedicineCnt"])?obj["mrlist"]["rcMedicineCnt"]:0;

				$("#odmedicapa").text(parseFloat(medicapa).toFixed(1)+"g");
				$("#odmedicnt").text(medicnt);
	
				var data="";
				for(var i=0;i<medicnt;i++)
				{
					var typetxt=obj["mrlist"]["medicine"][i]["typetxt"];
					var title=obj["mrlist"]["medicine"][i]["title"];
					var origin=obj["mrlist"]["medicine"][i]["origin"].substring(0,1);
					var oridata="<span class='icon'>"+origin+"</span> ";
					var medicapa=obj["mrlist"]["medicine"][i]["medicapa"];

					data+="<dd>";
					data+="	<span class='rect'>"+typetxt+"</span>";
					data+='	<span>'+oridata+"<span>"+title+'</span>'+'</span>';
					data+='	<span>'+(parseFloat(medicapa).toFixed(1))+'</span>';
					data+='</dd>';
				}

				$("#medilist").html(data);
			}
			else
			{
				$("#div_medicine").hide();
			}

			//----------------------------
			//분쇄
			//----------------------------
			if(!isEmpty(obj["mrlist"]["pilllist"]["smash"]))
			{
				$("#div_smash").show();
				//분말도
				$("#td_pillFineness").text(obj["plFinenessName"]);
				//제분손실
				$("#td_pillMillingloss").text(obj["plMillingloss"]+"g");
			}
			else
			{
				$("#div_smash").hide();
			}
			//----------------------------

			//----------------------------
			//탕전
			//----------------------------
			if(!isEmpty(obj["mrlist"]["pilllist"]["decoction"]))
			{
				$("#div_decoction").show();
				//탕전법
				$("#dcTitle").text(obj["plDctitleName"]);
				//특수탕전
				$("#dcSpecial").text(obj["plDcspecialName"]);
				//탕전시간
				$("#dcTime").text(obj["plDctime"]+"분");
				//탕전물량
				$("#dcWater").text(commasFixed(obj["plDcwater"])+"ml");
			}
			else
			{
				$("#div_decoction").hide();
			}
			//----------------------------

			//----------------------------
			//농축
			//----------------------------
			if(!isEmpty(obj["mrlist"]["pilllist"]["concent"]))
			{
				$("#div_concent").show();
				//농축비율
				$("#td_pillConcentRatio").text(obj["plConcentratioName"]);
				//농축시간
				$("#td_pillConcentTime").text(obj["plConcenttimeName"]);
			}
			else
			{
				$("#div_concent").hide();
			}
			//----------------------------

			//----------------------------
			//착즙
			//----------------------------
			if(!isEmpty(obj["mrlist"]["pilllist"]["juice"]))
			{
				$("#div_juice").show();
				//착즙유무
				$("#td_pillJuice").text(obj["plJuiceName"]);
			}
			else
			{
				$("#div_juice").hide();
			}
			//----------------------------
			

			//----------------------------
			//혼합
			//----------------------------
			if(!isEmpty(obj["mrlist"]["pilllist"]["mixed"]))
			{
				$("#div_mixed").show();
				//결합제
				$("#td_pillBinders").text(obj["plBindersName"]);
				//결합제량
				$("#td_pillBindersliang").text(obj["plBindersliang"]+"g");
			}
			else
			{
				$("#div_mixed").hide();
			}
			//----------------------------

			//----------------------------
			//중탕
			//----------------------------
			if(!isEmpty(obj["mrlist"]["pilllist"]["warmup"]))
			{
				$("#div_warmup").show();
				//중탕온도
				$("#td_pillWarmupTemperature").text(obj["plWarmuptemperatureName"]);
				//중탕시간
				$("#td_pillWarmupTime").text(obj["plWarmuptimeName"]);
			}
			else
			{
				$("#div_warmup").hide();
			}
			//----------------------------

			//----------------------------
			//숙성
			//----------------------------
			if(!isEmpty(obj["mrlist"]["pilllist"]["ferment"]))
			{
				$("#div_ferment").show();
				//숙성온도
				$("#td_pillFermentTemperature").text(obj["plFermenttemperatureName"]);
				//숙성시간
				$("#td_pillFermentTime").text(obj["plFermenttimeName"]);
			}
			else
			{
				$("#div_ferment").hide();
			}
			//----------------------------

			//----------------------------
			//제형
			//----------------------------
			if(!isEmpty(obj["mrlist"]["pilllist"]["plasty"]))
			{
				$("#div_plasty").show();
				//제형
				$("#td_pillShape").text(obj["plShapeName"]);
				//제환손실
				$("#td_pillLosspill").text(obj["plLosspill"]+"g");
			}
			else
			{
				$("#div_plasty").hide();
			}
			//----------------------------

			//----------------------------
			//건조 
			//----------------------------
			if(!isEmpty(obj["mrlist"]["pilllist"]["dry"]))
			{
				$("#div_dry").show();
				//건조온도
				$("#td_pillDryTemperature").text(obj["plDrytemperatureName"]);
				//건조시간
				$("#td_pillDryTime").text(obj["plDrytimeName"]);
			}
			else
			{
				$("#div_dry").hide();
			}
			//----------------------------	

			//setTimeout('print();', 500);

		}
	}

	callapi('GET','order','orderprintpill','<?=$apiprinterData?>');

</script>
