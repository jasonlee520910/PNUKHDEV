<?php 
	//20190726 : 품질보고서_부산 
	$root = "..";
	$code=$_GET["code"];
	$apiprinterData = "code=".$code;
	include_once ($root.'/cmmInc/headPrint.php');
?>
<style type="text/css">
	/* A4용지에 making, decoction, marking 각각 한장씩 출력하는 css추가*/
	html{background:none; min-width:0; min-height:0;font-weight:bold;}
	.section_print{width: 21cm;min-height: 29.7cm;page-break-after: always;}
	table tr th, table tr td{padding:5px;font-size:13px;}

	.maintbl{width:100%;border-top:1px solid #333;border-left:1px solid #333;margin-bottom:10px;}
	.maintbl tr th, .maintbl tr td{border-right:1px solid #333;border-bottom:1px solid #333}		

	.r {text-align:right !important;}
	.c {text-align:center !important;}

	.meditbl{width:100%;border-top:1px solid #333;border-left:1px solid #333;margin-bottom:10px;font-size:12px;}
	.meditbl tr th, .meditbl tr td{border-right:1px solid #333;border-bottom:1px solid #333}
	.medihubimg{text-align: center;}
	.medihubimg img{height:50px;}
	.pdfimg{text-align: center;}
	.pdfimg img{height:40px;}

	.makingtbl{width:100%;border:1px solid #333;margin-left:2px;}
	.makingtbl tr th, .makingtbl tr td{width:10%;border:none;border:1px solid #333;font-size:13px;text-align:center;height:30px;}
	.makingtbl tr td{width:15%;font-weight:bold;}

	.lst_tit{font-size:16px; color:#000;}

	.form_dtl_pop{overflow:hidden; clear:both;margin-top:15px;margin-bottom:20px;width:100%;}
	.form_dtl_pop .fl{float:left; width:66%;}
	.form_dtl_pop .fr{float:right; width:33%;}
	.form_dtl_pop .img{ padding:5px; font-size:0; border:1px solid #000; text-align:center; overflow:hidden;}
	.form_dtl_pop .img img{max-width:100%; max-height:100%; display:inline-block;}
	.capture{width:100%;padding:0;margin:0;}
	.capture dd{display:inline-block;width:50%;height:180px;margin-top:3px;margin-bottom: 3px;}


	.form_dtl_advice{overflow:hidden; clear:both;width:100%;}
	.form_dtl_advice .txt{min-height:119px;margin-bottom:30px; padding:5px; font-size:13; border:1px solid #000; text-align:left; overflow:hidden;}

	.form_dtl_mkstate{overflow:hidden; clear:both;width:100%;}
	.form_dtl_mkstate .center{text-align:center; }

	.tbltitle tr th { font-size: 25px; font-weight: bold;}
</style>

<div class="section_print">
    <div class="form_cont" style="padding-top:10px;">
		<div>
			<table class="maintbl tbltitle">
				<colgroup>
					<col width="15%" />
					<col width="*" />
					<col width="15%" />
				</colgroup>
				<tr>
					<th id="barcodeDiv"></th>
					<th id="odTitle"><?=$txtdt["1774"]?><!-- 한약처방전 --></th>
					<th></th>
				</tr>
			</table>
			<table class="maintbl">
				<tr>
					<th><?=$txtdt["1459"]?><!-- 주문자 --></th>
					<td id="userName"></td>
					<th><?=$txtdt["1100"]?><!-- 받는사람 --></th>
					<td id="reName"></td>
					<th><?=$txtdt["1304"]?><!-- 주문일 --></th>
					<td id="odDate"></td>
					<th><?=$txtdt["1112"]?><!-- 배송희망일 --></th>
					<td id="reDelidate"></td>
				</tr>
				<tr>
					<th><?=$txtdt["1498"]?><!-- 약미 --></th>
					<td id="odMediCnt1"></td>
					<th><?=$txtdt["1335"]?><!-- 첩수 --></th>
					<td id="odChubCnt1"></td>
					<th><?=$txtdt["1384"]?><!-- 팩수 --></th>
					<td id="odPackCnt1"></td>
					<th><?=$txtdt["1386"]?><!-- 팩용량 --></th>
					<td id="odPackCapa1"></td>
				</tr>
			</table>

			<div>
				<h3 class="lst_tit"><?=$txtdt["1551"]?><!-- 조제이력 --></h3>
				<table class="makingtbl">
					<colgroup>
						<col width="12%" />
						<col width="15%" />
						<col width="20%" />
						<col width="*" />
					</colgroup>
					<thead>
						<tr>
							<th scope="col"><?=$txtdt["1552"]?><!-- 공정 --></th>
							<th scope="col"><?=$txtdt["1054"]?><!-- 담당자 --> </th>
							<th scope="col"><?=$txtdt["1553"]?><!-- 처리시간 --></th>
							<th scope="col"><?=$txtdt["1139"]?><!-- 비고 --></th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td><?=$txtdt["1291"]?><!-- 조제 --></td>
							<td id="maStaff"></td>
							<td id="maDate"></td>
							<td></td>
						</tr>
						<tr>
							<td><?=$txtdt["1361"]?><!-- 탕전 --></td>
							<td id="dcStaff"></td>
							<td id="dcDate"></td>
							<td></td>
						</tr>
						<tr>
							<td><?=$txtdt["1076"]?><!-- 마킹 --></td>
							<td id="mrStaff"></td>
							<td id="mrDate"></td>
							<td></td>
						</tr>
						<tr>
							<td><?=$txtdt["1346"]?><!-- 출고 --></td>
							<td id="reStaff"></td>
							<td id="reDate"></td>
							<td></td>
						</tr>
					</tbody>
				</table>
			</div>

			<div class="form_dtl_pop">
				<div class="fl">
					<h3 class="lst_tit"><?=$txtdt["1291"]?><!-- 조제 --></h3>
					<div class="img" >
						<dl class="capture" id="makingPhotoDiv">

						</dl>
					</div>
				</div>
				<div class="fr">
					<h3 class="lst_tit"><?=$txtdt["1391"]?><!-- 포장 --></h3>
					<div class="img"  id="releasePhotoDiv">
					</div>
				</div>

			</div>

			<div class="form_dtl_advice">
				<h3 class="lst_tit"><?=$txtdt["1118"]?><!-- 복약지도 --></h3>
				<div class="txt">
					<p id="odAdvice"></p>
				</div>
			</div>

			<div class="form_dtl_mkstate">
				<h3 class="lst_tit">검사<!-- <?=$txtdt["1118"]?> --><!-- 조제상태검사 --></h3>
				<table class="maintbl tbltitle">
					<colgroup>
						<col width="24%" />
						<col width="10%" />
						<col width="23%" />
						<col width="10%" />
						<col width="23%" />
						<col width="10%" />
					</colgroup>
					<tbody>
						<tr>
							<td>■ <?=$txtdt["1789"]?><!-- 약재상태검사 --></td>
							<td class="center">PASS</td>
							<td>■ <?=$txtdt["1790"]?><!-- 조재량검사 --></td>
							<td class="center">PASS</td>
							<td>■ <?=$txtdt["1791"]?><!-- 추출후 파우치 수량 검사 --></td>
							<td class="center">PASS</td>
						</tr>
						<tr>
							<td>■ <?=$txtdt["1792"]?><!-- 추출후 포장상태 검사 --></td>
							<td class="center">PASS</td>
							<td>■ <?=$txtdt["1793"]?><!-- 이물질 혼입/오염검사 --></td>
							<td class="center">PASS</td>
							<td>■ <?=$txtdt["1794"]?><!-- 마킹후 포장상태 검사 --></td>
							<td class="center">PASS</td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
    </div> <!-- form_cont div -->
</div><!-- section_print div -->

<!-- 약재리스트 -->
<div class="section_print">
    <div class="form_cont" style="padding-top:10px;">
		<div>
			<h3 class="lst_tit"><?=$txtdt["1203"]?><!-- 약재리스트 --></h3>
			<table class="meditbl" id="mdtbl">
				<colgroup>
					<col width="11%" />
					<col width="*" />
					<col width="11%" />
					<col width="15%" />
					<col width="15%" />
					<col width="11%" />
					<col width="11%" />
					<col width="10%" />
				</colgroup>
				<thead>
					<tr>
						<th><?=$txtdt["1129"]?><!-- 본초이미지 --></th>
						<th><?=$txtdt["1204"]?><!-- 약재명 --></th>
						<th><?=$txtdt["1338"]?><!-- 총약재량 --></th>
						<th><?=$txtdt["1237"]?><!-- 원산지 --></th>
						<th><?=$txtdt["1775"]?><!-- 생산자 --></th>
						<th><?=$txtdt["1776"]?><!-- 재고입고일 --></th>
						<th><?=$txtdt["1242"]?><!-- 유통기한 --></th>
						<th><?=$txtdt["1782"]?><!-- 품질보고서 --></th>
					</tr>
				</thead>
				<tbody>
				</tbody>
			</table>

		</div>
    </div> <!-- form_cont div -->
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
		console.log("-------------------------------------------------------- ")

		if(obj["apiCode"]=="orderreport")
		{
			//첩약처방명 : TS57022(대명전 가감)
			$("#odTitle").text(obj["odTitle"]);//<!-- 첩약처방명 -->


			//주문자
			$("#userName").text(obj["miName"]);
			//받는사람
			$("#reName").text(obj["reName"]);
			//주문일자
			$("#odDate").text(obj["odDate"]);
			//배송희망일
			$("#reDelidate").text(obj["reDelidate"]);

			var medicnt=0;
			if(!isEmpty(obj["rcMedicine"]))
			{
				var medicnttxt=obj["rcMedicine"].split("|");
				medicnt=medicnttxt.length - 1;
			}
			//약미
			$("#odMediCnt1").text(medicnt+"<?=$txtdt['1090']?>");
			//첩수_CHUBCNT_첩수
			$("#odChubCnt1").text(obj["odChubCnt"]+"<?=$txtdt['1330']?>");
			//팩수_PACKCNT_팩수
			$("#odPackCnt1").text(obj["odPackCnt"]+"<?=$txtdt['1604']?>");
			//팩용량_PACKCC_팩용량
			$("#odPackCapa1").text(obj["odPackCapa"]+"ml");

			//탕전법
			$("#dcTitle").text(obj["dcTitle"]);
			//탕전시간
			var dcTime=!isEmpty(obj["dcTime"]) ? obj["dcTime"] : 60;
			$("#dcTime").text(dcTime+"<?=$txtdt['1437']?>");
			//탕전물량
			$("#dcWater").text(comma(obj["dcWater"])+"ml");
			//특수탕전 
			$("#dcSpecial").text(obj["dcSpecial"]);

			//보내는 사람
			$("#meNameDiv").html("디제이메디" + "<br>" + "경기도 고양시 일산동구 호수로 358-25 동문타워2차 601호");
			//받는 사람
			var addr = !isEmpty(obj["reAddress"]) ? obj["reAddress"].replace("||", "") : "";
			$("#reNameDiv").html(obj["reName"] + "<br> [" + obj["reZipcode"] +"] <br>"+ addr);
			//배송요청사항 
			var request=!isEmpty(obj["reRequest"]) ? obj["reRequest"] : "";
			$("#reRequestDiv").html(request);

			//복약지도 
			if(!isEmpty(obj["odAdvice"]))
			{
				$("#odAdvice").text(obj["odAdvice"]);
			}

			//마킹
			$("#MarkingDiv").text(obj["odMrDesc"]);
			

			//담당자 
			$("#maStaff").text(obj["smaName"]);
			$("#dcStaff").text(obj["sdcName"]);
			$("#mrStaff").text(obj["smrName"]);
			$("#reStaff").text(obj["sreName"]);
			//처리시간 
			$("#maDate").text(obj["ma_modify"]);
			$("#dcDate").text(obj["dc_modify"]);
			$("#mrDate").text(obj["mr_modify"]);
			$("#reDate").text(obj["re_modify"]);

			//이미지 
			var pictureimg=releaseimg="";
			if(!isEmpty(obj["files"]))
			{
				$(obj["files"]).each(function( index, value )
				{
					switch(value["afFcode"])
					{
					case "making_infirst":
					case "making_inmain":
					case "making_inafter":
					case "making_inlast":
						pictureimg+="<dd><img src='"+getUrlData("FILE_DOMAIN")+value["afUrl"]+"' /></dd>";
						break;
					case "release_medibox":
						releaseimg+="<img src='"+getUrlData("FILE_DOMAIN")+value["afUrl"]+"' />";
						break;
					}

				});


				$("#makingPhotoDiv").html(pictureimg);
				$("#releasePhotoDiv").html(releaseimg);
			}
		
			//바코드 
			$('#barcodeDiv').qrcode({render	: "canvas", width : 60, height : 60, text	: obj["maCode"] });	

			//약재리스트 
			if(!isEmpty(obj["medicinelist"]))
			{
				var data=bonImg=incomindate=incomexpired="";
				var incoming;
				$(obj["medicinelist"]).each(function( index, value )
				{
					bonImg = (!isEmpty(value["af_url"])) ? "<img src='"+getUrlData("FILE_DOMAIN")+value["af_url"]+"' />" : "<img src='<?=$root?>/_Img/Content/noimg.png' />";
					incomindate="";
					incomexpired="";
					if(!isEmpty(value["incoming"]))
					{
						incoming=value["incoming"].split(",");
						incomindate=!isEmpty(incoming[1]) ? incoming[1] : "";
						incomexpired=!isEmpty(incoming[0]) ? incoming[0] : "";
					}
					data+="<tr>";
					data+="	<td class='medihubimg'>"+bonImg+"</td>";//본초이미지
					data+="	<td>"+value["mm_title"]+"</td>";//약재명
					data+="	<td class='r'>"+value["mbCapa"]+"g</td>";//첩량
					data+="	<td>"+value["md_origin"]+"</td>";//원산지
					data+="	<td>"+value["md_maker"]+"</td>";//생산자
					data+="	<td class='c'>"+incomindate+"</td>";//재고입고일
					data+="	<td class='c'>"+incomexpired+"</td>";//유통기한
					data+="	<td class='c pdfimg'><img src='<?=$root?>/_Img/Content/pdf.png' /></td>";//품질보고서 
					data+="</tr>";
				});

				$("#mdtbl tbody").html(data);
			}
			

		}
	}

	//한의원 상세 정보
	callapi('GET','order','orderreport','<?=$apiprinterData?>');

</script>
