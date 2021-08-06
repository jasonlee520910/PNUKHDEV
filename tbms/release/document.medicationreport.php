<?php  //복약지도서 부산대한방병원
	$root="..";
	include_once $root."/_common.php";
	$code=$_GET["code"];
	$apiData="code=".$code;
?>
<meta charset="UTF-8">
<meta http-equiv="content-type" content="text/html;charset=utf-8" />
<meta name="author" content="" />
<meta http-equiv="X-UA-Compatible" content="IE=edge"><!--ie 최상위버전 -->
<script  type="text/javascript" src="<?=$root?>/_Js/jquery-2.2.4.js"></script> <!-- 새로추가한 jquery -->
<script  type="text/javascript" src="<?=$root?>/_Js/jquery.cookie_new.js"></script> <!-- 새로추가한 jquery -->
<script  type="text/javascript" src="<?=$root?>/_Js/jquery.js"></script> <!-- 새로추가한 jquery -->
<script  type="text/javascript" src="<?=$root?>/_Js/jquery-barcode.js"></script> <!-- 새로추가한 jquery -->
<link rel="stylesheet" type="text/css" href="<?=$root?>/_Css/print_style.css">

<style type="text/css">
		/* A4용지에 making, decoction, marking 각각 한장씩 출력하는 css추가*/
		html{background:none; min-width:0; min-height:0;font-weight:bold;}
		.section_print{width: 21cm;min-height: 29.7cm;}
		.barcode img{width:300px;height:54px;}
		.barcodetext {margin-top:-1px;font-size:16px;font-weight:bold;}
		.totalcapa {float:right;}
		table tr th, table tr td{padding:5px;font-size:15px;}
		.maintbl{width:100%;border-top:1px solid #333;border-left:1px solid #333;margin-bottom:5px;}
		.maintbl tr th, .maintbl tr td{border-right:1px solid #333;border-bottom:1px solid #333}
		.tbltitle tr th{font-size:25px;font-weight:bold;}
		
		.lstbl, .lstbl tr th{border-right:red;border-left: 1px solid #333}

		.form_dtl_pop{overflow:hidden;width:100%;margin-bottom: 5px;}
		.form_dtl_pop .fl{float:left; width:69%;}
		.form_dtl_pop .fr{float:right; width:30%;}

		.decoctbl{width:100%;border-top:1px solid #333;border-left:1px solid #333;border-right:1px solid #333;margin-top:5px;}
		.decoctbl tr th, .decoctbl tr td{width:10%;border:none;border-right:1px solid #333;border-bottom:1px solid #333;font-size:13px;text-align:center;height:30px;}
		.decoctbl tr td{width:15%;font-weight:bold;}


</style>
<body>
<div style="display:none">
	<textarea id="urldata" cols="100" rows="100" style="display:none;"><?=json_encode($NetURL)?></textarea>
</div>
<div class="section_print">
	<input type="hidden" name="ChubcntDiv" value="">
    <div class="form_cont" style="padding-top:10px;">
		<div class="barcode" id="" ></div>
		<div class="barcodetext" id=""></div>
		<div>
			<table class="maintbl tbltitle">
				<tr>				
					<th id="" style="height:100px;">o 탕 약 복 약 안 내 문 o</th>
				</tr>
			</table>
			<table class="maintbl" >
				<col width="10%"><col width="13%"><col width="10%"><col width="10%">
				<col width="10%"><col width="15%"><col width="10%"><col width="22%">
				<tr>					
					<td id="" align="center" style="font-weight: bold;">부산대학교한방병원에서 사용하는 모든 한약재는 식품의약품안전처에서 허가받은 제약회사의<br> 의약품만을 엄선하여 사용하고 있으며, 최적의 유효성분을 추출할 수 있는 시스템을 도입하여 <br> (000 님)의 약을 정성껏 조제, 탕전하였습니다. <br>한약의 특성상 동일한 처방으로 조제된 한약이라도 탕전 후 <br> 색이나 맛이 약간 다를수 있으나, 약효는 차이가 없습니다.</td>
				</tr>
			</table>
		</div>
		<!-- 탕전정보 -->
		<div class="form_dtl_pop">
			<table class="decoctbl" id="decocID">
				<col width="13%"><col width="25%"><col width="13%"><col width="25%">
				<tbody>
				<tr>
					<th>환자번호<?//=$txtdt["titdecoction"]?><!-- 탕전법 --></th>
					<td id=""></td>
					<th>성명<?//=$txtdt["decoctime"]?><!-- 탕전시간 --></th>
					<td id=""></td>
				</tr>
				<tr>
					<th>진료과<?//=$txtdt["decocwater"]?><!-- 탕전물량 --></th>
					<td id=""></td>
					<th>진료의사<?//=$txtdt["spdecoction"]?><!-- 특수탕전 --></th>
					<td id="dcSpecial"></td>
				</tr>
				<tr>
					<th>처방일<?//=$txtdt["decocwater"]?><!-- 탕전물량 --></th>
					<td id=""></td>
					<th>한약사<?//=$txtdt["spdecoction"]?><!-- 특수탕전 --></th>
					<td id="dcSpecial"></td>
				</tr>
				<tr>
					<th>복용법<?//=$txtdt["decocwater"]?><!-- 탕전물량 --></th>
					<td id=""  colspan='3'></td>
				</tr>
				</tbody>
			</table>
			<table class="decoctbl" id="" >
				<col width="20%"><col width="30%">
				<tbody>
				<tr>
					<th>주의사항<?//=$txtdt["9028"]?><!-- 제형 --></th>
					<td id=""></td>
				</tr>
				<tr>
					<th id="" style="height:200px;" colspan="2" >
					<div style="text-align:left;">
						(1) 약의 복용 기간 동안 음주, 흡연을 절제하시기 바랍니다. <br>
						(2) 소화에 지장을 초래할 수 있는 음식은 피하시기 바랍니다. (예: 기름진 음식, 빙과류 등)<br>
						(3) 냉장보관 (4도 이하) 하십시오.<br>
						(4) 보관기간을 한달이 넘지 않는 것이 좋습니다.(* 기간 초과시 상담바랍니다.)<br>
						(5) 평소에 복용하는 약물이 있으면 복용 전 진료의사에게 확인하십시오.<br>
						(6) 남은 약을 타인에게 주거나 의사의 확인 없이 복용하여서는 안됩니다.<br>
						(7) 기타 주의사항<br><br><br><br><br><br><br><br>
					</div>
					</th>						
				</tr>
				<tr>
					<th>비고<?//=$txtdt["9028"]?><!-- 제형 --></th>
					<td id=""></td>
				</tr>
				<tr>
					<th id="" style="height:200px;" colspan="2" >

					</th>						
				</tr>
				</tbody>
			</table>

			<table class="" id="" style="border:1px solid #333;" >
				<col width="100%">
				<tbody>
				<tr>
					<div style="text-align:center;">
						<th>000 님의 빠른 쾌유를 기원합니다.<?//=$txtdt["9028"]?><!-- 제형 --></th>
						<td id=""></td>
					</div>
				</tr>
				<tr >
					<div style="text-align:center;">
						<th>대표전화 : 055-360-5555<?//=$txtdt["9028"]?><!-- 제형 --></th>
						<td id=""></td>
					</div>
				</tr>
				<tr>
					<div style="text-align:center;">
						<th>한약국 : 055-360-5565<?//=$txtdt["9028"]?><!-- 제형 --></th>
						<td id=""></td>
					</div>
				</tr>
				</tbody>
				<div style="margin:10px 0 10px 0;text-align:center;">
					<a href="/">
						<img src="<?=$root?>/logo.gif" alt="">
					</a>
				</div>
			</table>
		</div>
	</div>
</div><!-- section_print div -->

</body>
</html>

<script>
	function makepage(json)
	{
		console.log("making makepage ----------------------------------------------- ")
		var obj = JSON.parse(json);
		console.log(obj)
		console.log("apiCode : " + obj["apiCode"])		

		if(obj["apiCode"]=="")
		{

		}

	}

	callapi('GET','release','orderreport',"<?=$apiData?>");
</script>
