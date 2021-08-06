<?php 
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
		.subtbl{width:255px;height:29px;float:left;border:none;border-left:1px solid #333;border-right:1px solid #333;margin-left:2px;}
		.subtbl tr td{border:none;border-left:1px solid #333;border-top:1px solid #333;font-size:13px;text-align:center;height:29px;font-weight:bold;}
		.subtbl tr td.leftDiv{border:1px solid;}
		.subtbl tr td.lt{text-align:left;}
		.subtbl tr td.fi{border-left:none;}
		.fitbl{margin-left:0;margin-right:1px;border-left:none;;}
		.lstbl, .lstbl tr th{border-right:red;border-left: 1px solid #333}
		dl.subbot{/*margin:1%;*/overflow:hidden;padding-left:5px;font-weight:bold;font-size:17px;}
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

		.decoctbl{width:100%;border-top:1px solid #333;border-left:1px solid #333;border-right:1px solid #333;margin-left:2px;margin-top:5px;}
		.decoctbl tr th, .decoctbl tr td{width:22%;border:none;border-right:1px solid #333;border-bottom:1px solid #333;font-size:13px;text-align:center;height:30px;font-size:17px;}
		.decoctbl tr td{width:28%;font-weight:bold;}

		.sugartbl{width:100%;border-top:1px solid #333;border-left:1px solid #333;border-right:1px solid #333;margin-left:2px;margin-top:5px;}
		.sugartbl tr th, .sugartbl tr td{width:5%;border:none;border-right:1px solid #333;border-bottom:1px solid #333;font-size:13px;text-align:center;height:30px;}
		.sugartbl tr td{width:15%;font-weight:bold;}

		.markingtbl{width:100%;border-top:1px solid #333;border-left:1px solid #333;border-right:1px solid #333;margin-left:2px;margin-top:5px;}
		.markingtbl tr th, .markingtbl tr td{width:5%;border:none;border-right:1px solid #333;border-bottom:1px solid #333;font-size:13px;text-align:center;height:30px;}
		.markingtbl tr td{width:15%;font-weight:bold;}

		.relesetbl{width:100%;border-top:1px solid #333;border-left:1px solid #333;border-right:1px solid #333;margin-left:2px;margin-top:5px;}
		.relesetbl tr th, .relesetbl tr td{width:4%;border:none;border-right:1px solid #333;border-bottom:1px solid #333;font-size:13px;text-align:center;height:50px;}
		.relesetbl tr td{width:15%;font-weight:bold;text-align:left;}

		.requesttbl{width:100%;border-top:1px solid #333;border-left:1px solid #333;border-right:1px solid #333;margin-left:2px;margin-top:5px;}
		.requesttbl tr th, .requesttbl tr td{width:4%;border:none;border-right:1px solid #333;border-bottom:1px solid #333;font-size:13px;text-align:center;height:80px;}
		.requesttbl tr td{width:15%;font-weight:bold;text-align:left;}


		.mrktbl{margin-top:5px;width:100%;border:1px solid #333;}
		.mrktbl tr th, .mrktbl tr td{border:1px solid #333;font-size:14px;text-align:center;padding:5px 0 5px 0;}
		.mrktbl tr td{font-weight:bold;}
		.mrktbl tr td img{width:70%;height:86px;}

		#odRequestDiv {height:40px;text-align: left;overflow-y:auto;}
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
		<!-- <div class="feature"><span id="reDelicompAdd"></span><span id="reDelicomp" style='padding:5px 10px;border-radius:10px;background:#3300CC;color:#fff;margin-right:10px;'></span><span id="antler"></span><span id="odFeature"></span></div> -->
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
					<td id="odNote"></td>
					<th><?=$txtdt["1889"]?><!-- 생년월일 -->/<?=$txtdt["1888"]?><!-- 성별 --></th>
					<td><span id="odBirth"></span> / <span id="odGender"></span></td>
					<th><?=$txtdt["1112"]?><!-- 배송희망일 --></th>
					<td id="reDelidate"></td>
				</tr>
			</table>
			<style>
			#sweetlist{width:100%;border:1px solid black;font-size:15px;margin-bottom:5px;}
			#sweetlist tr{}
			#sweetlist td{border:1;border-left:1px solid black;border-right:1px solid black;text-align: left;font-size: 15px;}
			.lst_tit{color:#000;}
			</style>
			<div class="lst_tb2" >
				<div id="sweetDiv"></div> <!-- 앰플/기타약재  내용  -->
			</div>
			<table class="maintbl">
				<colgroup>
					<col width="15%">
					<col width="19%">
					<col width="15%">
					<col width="18%">
					<col width="15%">
					<col width="18%">
				</colgroup>
				</tr>
					<td style="padding:0;" id="medilist">
					</td>
				</tr>
				<tr><td>
					<dl class="subbot">
						<dt><?=$txtdt["1498"]?><!-- 약미 -->: </dt><dd id="odMediCnt1"></dd>
						<dt>갯수<?//=$txtdt["1335"]?><!-- 첩수 -->: </dt><dd id="odQty1"></dd>
						<dt><?=$txtdt["1335"]?><!-- 첩수 -->: </dt><dd id="odChubCnt1"></dd>
						<dt><?=$txtdt["1384"]?><!-- 팩수 -->: </dt><dd id="odPackCnt1"></dd>
						<dt><?=$txtdt["1386"]?><!-- 팩용량 -->: </dt><dd id="odPackCapa1"></dd>
						<dt><?=$txtdt["1773"]?><!-- 총용량 -->: </dt><dd class="total" id="smuTotalWater"></dd>
					</dl>
				</td></tr>
			</table>
			<div class="form_dtl_pop">
				<div class="fl">
					<table class="sugartbl">
						<tbody>
						<tr>
							<th class="inth">감미제</th>
							<td id="SugarDiv"></td>
						</tr>
						</tbody>
					</table>

					<table class="decoctbl" id="decocID">
						<tbody>
						<tr>
							<th><?=$txtdt["1367"]?><!-- 탕전법 --></th>
							<td id="dcTitle"></td>
							<th><?=$txtdt["1369"]?><!-- 탕전시간 --></th>
							<td id="dcTime"></td>
						</tr>
						<tr>
							<th><?=$txtdt["1366"]?><!-- 탕전물량 --></th>
							<td id="dcWater"></td>
							<th><?=$txtdt["1381"]?><!-- 특수탕전 --></th>
							<td id="dcSpecial"></td>
						</tr>
						</tbody>
					</table>

					<table class="decoctbl" id="sfextID">
						<tbody>
						<tr>
							<th><?=$txtdt["1664"]?><!-- 제형 --></th>
							<td id="dcShape"></td>
							<th><?=$txtdt["1770"]?><!-- 결합제 --></th>
							<td id="dcBinders"></td>
						</tr>
						<tr>
							<th><?=$txtdt["1796"]?><!-- 분말도 --></th>
							<td id="dcFineness"></td>							
							<th><?=$txtdt["1841"]?><!-- 건조시간 --></th>
							<td id="dc_dry"></td>
						</tr>
						<tr>
							<th><?=$txtdt["1797"]?><!-- 제분손실 --></th>
							<td id="dcMillingloss"></td>
							<th><?=$txtdt["1798"]?><!-- 제환손실 --></th>
							<td id="dcLossjewan"></td>
						</tr>
						<tr>
							<th><?=$txtdt["1770"]?><!-- 결합제 --></th>
							<td id="dcBindersliang"></td>
							<th><?=$txtdt["1799"]?><!-- 완성량 --></th>
							<td id="dcCompleteliang"></td>
						</tr>
						</tbody>
					</table>


					<table class="decoctbl" id="edextractID">
						<tbody>
						<tr>
							<th><?=$txtdt["1796"]?><!-- 분말도 --></th>
							<td id="edcFineness"></td>
							<th><?=$txtdt["1844"]?><!-- 숙성 --></th>
							<td id="dcRipen"></td>
						</tr>
						<tr>
							<th><?=$txtdt["1845"]?><!-- 중탕 --></th>
							<td id="dcJungtang"></td>							
							<th></th>
							<td></td>
						</tr>
						</tbody>
					</table>

					<table class="markingtbl">
						<tbody>
						<tr>
							<th class="inth"><?=$txtdt["1077"]?><!-- 마킹 --></th>
							<td id="MarkingDiv"></td>
						</tr>
						</tbody>
					</table>

					<table class="relesetbl">
						<tbody>
						<tr>
							<th class="inth"><?=$txtdt["1634"]?><!-- 보내는사람 --></th>
							<td id="meNameDiv"></td>
						</tr>
						<tr>
							<th class="inth"><?=$txtdt["1100"]?><!-- 받는사람 --></th>
							<td id="reNameDiv"></td>
						</tr>						
						<tr>
							<th class="inth"><?=$txtdt["1635"]?><!-- 배송요청사항 --></th>
							<td id="reRequestDiv"></td>
						</tr>
						</tbody>
					</table>

					<table class="requesttbl">
						<tbody>
						<tr>
							<th class="inth"><?=$txtdt["1292"]?><!-- 주문자요청사항 --></th>
							<td id="odRequestDiv"></td>
						</tr>
						</tbody>
					</table>
				</div>

				<div class="fr">
					<table class="mrktbl">
						<tbody>
						<tr>
							<th id="odAdvice" style="padding:10px;"></th>
						</tr>
						<tr>
							<th id="odpackName"><?=$txtdt["1636"]?><!-- 파우치이미지 --></th>
						</tr>
						<tr>
							<td id="odPacktype"><img src="https://data.djmedi.kr/data/2018/03/01/20180301193446.jpg"></td>
						</tr>
						<tr>
							<th id="reboxmediName"><?=$txtdt["1637"]?><!-- 포장재이미지 --></th>
						</tr>
						<tr>
							<td id="reBoxmedi"><img src="https://data.djmedi.kr/data/2018/03/01/20180301193446.jpg"></td>
						</tr>
						<tr>
							<th id="reboxdeliName"><?=$txtdt["1638"]?><!-- 배송박스이미지 --></th>
						</tr>
						<tr>
							<td id="reBoxdeli"><img src="https://data.djmedi.kr/data/2018/03/01/20180301193446.jpg"></td>
						</tr>
						</tbody>
					</table>
				</div>

				<div style="width:100%;float:right;margin-top:5px;text-align:right;">
					<span id="prtNowDate"></span>
					<span id="prtNowId"></span>
					<span id="prtNowIp"></span>
				</div>
			</div>
		</div>
    </div> <!-- form_cont div -->
</div><!-- section_print div -->

</body>
</html>
<script type="text/javascript" src="https://jsgetip.appspot.com"></script>
<script>
	function ipv()
	{
	  return -1 !=ip().indexOf(":")?6:4
	}
	function getDecoTypeName(list, data)
	{
		var str = "<?=$txtdt['1251']?>";//일반
		for(var key in list)
		{
			if(data == list[key]["cdCode"])
			{
				str = list[key]["cdName"];
				break;
			}
		}
		return str;
	}
	function makepage(json)
	{
		console.log("making makepage ----------------------------------------------- ")
		var obj = JSON.parse(json);
		console.log(obj)
		console.log("apiCode : " + obj["apiCode"])
		console.log("-------------------------------------------------------- ")

		if(obj["apiCode"]=="orderprint")
		{
			
			$("#decocID").hide();
			$("#sfextID").hide();
			$("#edextractID").hide();

			//"odGender"=>$dt["od_gender"], //성별 
			//"odBirth"=>$dt["od_birth"], //생년월일 
			//"odFeature"=>$dt["od_feature"], //사상 
			//20191011 : 사상은 빼고 그자리에 BK,OK pk 번호 보여주기 

			//묶음배송,해외배송
			var data="";
			if(!isEmpty(obj["reDelicompO"]))
			{
				data="<span style='padding:5px 10px;border-radius:10px;background:#0064FF;color:#fff;margin-right:10px;'>"+obj["reDelicompO"]+"</span>";
			}
			if(!isEmpty(obj["reDelicompT"]))
			{
				data+="<span style='padding:5px 10px;border-radius:10px;background:#FF8200;color:#fff;margin-right:10px;'>"+obj["reDelicompT"]+"</span>";
			}
			$("#reDelicompAdd").html(data);
			
			//배송회사 
			$("#reDelicomp").html(obj["reDelicomp"]);
			if(obj["odGoods"]=="G") //사전이면 
			{
				$("#reDelicomp").hide();
			}
			else
			{
				$("#reDelicomp").show();
			}
			
			//처방PK
			$("#odFeature").html(obj["odChartPK"]);
		

			/*
			//사상 
			if(obj["odFeature"]=="140")
			{
				$("#odFeature").text("");
			}
			else
			{
				$("#odFeature").text(obj["odFeatureName"]);
			}
			*/
			
			//성별 
			$("#odGender").text(obj["odGenderName"]);
			//생년월일  
			$("#odBirth").text(obj["odBirth"]);


			
			//$("#smuInoutFlag").text("<?=$txtdt['1361']?>"); //탕전
			$("#smuInoutFlag").text(obj["maTypeName"]); //탕전
			switch(obj["odMatype"])
			{
			case "decoction": case "worthy": case "goods": case "commercial"://20191108:실속,약속,상비 추가 
				$("#decocID").show();
				break;
			case "sfextract":

				break;
			case "jehwan":
				$("#sfextID").show();
				break;
			case "edextract":
				$("#edextractID").show();
				break;
			}
			//주문자
			$("#userName").text(obj["miName"]);
			//받는사람
			$("#reName").text(obj["reName"]);
			//주문일자
			$("#odDate").text(obj["odDate"]);
			//배송희망일
			$("#reDelidate").text(obj["reDelidate"]);
			//배송희망일
			//$("#odNote").text("환자명 : "+obj["odName"]+"");
			$("#odNote").text(obj["odName"]+"");



			var medicnt=obj["rcMedicine"].split("|");
			medicnt=medicnt.length - 1;
			var sweetcnt=obj["rcSweet"].split("|");
			sweetcnt=sweetcnt.length - 1;
			//약미
			$("#odMediCnt1").text((medicnt + sweetcnt)+"<?=$txtdt['1090']?>");
			//갯수
			$("#odQty1").text(obj["orderCount"]+"<?=$txtdt['1018']?>");
			
			//첩수_CHUBCNT_첩수
			$("#odChubCnt1").text(obj["odChubCnt"]+"<?=$txtdt['1330']?>");
			//팩수_PACKCNT_팩수
			$("#odPackCnt1").text(obj["odPackCnt"]+"<?=$txtdt['1604']?>");

			//팩용량_PACKCC_팩용량
			$("#odPackCapa1").text(obj["odPackCapa"]+"cc");

			//탕전구분 : 탕
			$("#odMeditype1").text(obj["odMeditype"]);


			//첩약처방명 : TS57022(대명전 가감)
			$("#odTitle").text(obj["odTitle"]);//<!-- 첩약처방명 -->

			//----------------------------------------------------------------------------
			//탕제 
			//----------------------------------------------------------------------------
			//탕전법
			$("#dcTitle").text(obj["dcTitle"]);
			//탕전시간
			//20191010 : 80분을 1시간20분으로 표시 
			var dcTime=!isEmpty(obj["dcTime"]) ? obj["dcTime"] : "<?=$BASE_DCTIME?>";
			var tmpdcTime=getHHMMSS(dcTime);
			console.log("tmpdcTime :: " + tmpdcTime);
			//$("#dcTime").text(dcTime+"<?=$txtdt['1437']?>");
			$("#dcTime").text(tmpdcTime);
			//탕전물량
			//var water=calcWaterAlcohol(obj["dcWater"]);//parseInt((obj["dcWater"] - ( obj["dcWater"] * 0.1)) / 10) * 10;
			//var alchol=obj["dcWater"] - water;
			if(!isEmpty(obj["dcAlcohol"])&&parseInt(obj["dcAlcohol"])>0)
			{
				$("#dcWater").html("물 : "+comma(obj["dcWater"])+"ml <br> "+obj["dcSpecialName"]+" : "+comma(obj["dcAlcohol"])+"cc");
			}
			else
			{
				$("#dcWater").html(comma(obj["dcWater"])+"ml");
			}
			
			//특수탕전 
			$("#dcSpecial").html(obj["dcSpecial"]);
			//----------------------------------------------------------------------------
		
			//----------------------------------------------------------------------------
			//제환  
			//----------------------------------------------------------------------------
			$("#dcShape").text(obj["dcShapeName"]);
			$("#dcBinders").text(obj["dcBindersName"]);
			$("#dcFineness").text(obj["dcFinenessName"]);
			$("#dcTerm").text(obj["dcTermsName"]);
			$("#dcMillingloss").text(obj["dc_millingloss"]+"g");
			$("#dcLossjewan").text(obj["dc_lossjewan"]+"g");
			$("#dcBindersliang").text(obj["dc_bindersliang"]+"g");
			$("#dcCompleteliang").text(obj["dc_completeliang"]+"g / "+obj["dc_completecnt"]+"ea");
			$("#dc_dry").text(obj["dc_dry"]+"<?=$txtdt['1842']?>");//건조시간 
			//----------------------------------------------------------------------------

			//농축엑기스 
			$("#edcFineness").text(obj["dcFinenessName"]);
			$("#dcRipen").text(obj["dcRipenName"]);
			$("#dcJungtang").text(obj["dcJungtangName"]);

			//보내는 사람
			$("#meNameDiv").html(obj["reSendname"] + "<br> [" + obj["reSendzipcode"]+"] "+obj["reSendaddress"]+" "+obj["reSendaddress1"]);
			//받는 사람
			var addr = !isEmpty(obj["reAddress"]) ? obj["reAddress"].replace("||", "") : "";
			$("#reNameDiv").html(obj["reName"] + " (Tel."+obj["rePhone"]+" / Mobile."+obj["reMobile"]+") <br> [" + obj["reZipcode"] +"] "+ obj["reAddress"]);
			//배송요청사항 
			var request=!isEmpty(obj["reRequest"]) ? obj["reRequest"] : "";
			$("#reRequestDiv").html(request);

			if(obj["odGoods"]=="G") //사전이면 
			{
				$(".relesetbl").hide();
				$(".markingtbl").hide();
			}
			else
			{
				$(".relesetbl").show();
				$(".markingtbl").show();
			}

			//주문자요청사항 
			var odRequest=!isEmpty(obj["odRequest"]) ? obj["odRequest"] : "";
			//cy 마킹정보 
			var cymarkText=!isEmpty(obj["cymarkText"]) ? obj["cymarkText"]:"";
			$("#odRequestDiv").html(cymarkText+"\n"+odRequest);

			if(obj["odGoods"]=="G") //사전이면 
			{
				$("#odRequestDiv").css("height","300px");
			}
			else
			{
				$("#odRequestDiv").css("height","70px");
			}

			//감미제 
			$("#SugarDiv").html(obj["sugartxt"]);

			//마킹
			$("#MarkingDiv").html(obj["markingtxt"]);

			//파우치
			$("#odpackName").html(obj["odpackName"]);//파우치이름
			if(obj["odPackimg"] == "NoIMG"){img="<img src='<?=$root?>/_Img/Content/noimg.png'>";}
			else
			{
				if(obj["odPackimg"].substring(0,4)=="http")
				{
					img='<img src="'+obj["odPackimg"]+'" onerror="this.src=\'<?=$root?>/_Img/Content/noimg.png\'">';
				}
				else
				{
					img='<img src="'+getUrlData("FILE_DOMAIN")+obj["odPackimg"]+'" onerror="this.src=\'<?=$root?>/_Img/Content/noimg.png\'">';
				}
			}
			$("#odPacktype").html(img);

			//한약박스
			$("#reboxmediName").html(obj["reboxmediName"]);//포장재이름
			if(obj["reBoxmediimg"] == "NoIMG"){img="<img src='<?=$root?>/_Img/Content/noimg.png'>";}
			else
			{
				if(obj["reBoxmediimg"].substring(0,4)=="http")
				{
					img='<img src="'+obj["reBoxmediimg"]+'" onerror="this.src=\'<?=$root?>/_Img/Content/noimg.png\'">';
				}
				else
				{
					img='<img src="'+getUrlData("FILE_DOMAIN")+obj["reBoxmediimg"]+'" onerror="this.src=\'<?=$root?>/_Img/Content/noimg.png\'">';
				}					
			}

			$("#reBoxmedi").html(img);

			//배송박스 
			$("#reboxdeliName").html(obj["reboxdeliName"]);//배송박스이름
			if(obj["reBoxdeliimg"] == "NoIMG"){img="<img src='<?=$root?>/_Img/Content/noimg.png'>";}
			else
			{
				img='<img src="'+getUrlData("FILE_DOMAIN")+obj["reBoxdeliimg"]+'" onerror="this.src=\'<?=$root?>/_Img/Content/noimg.png\'">';
			}
			$("#reBoxdeli").html(img);
	
			//----------------------------------------------------------------------
			//복약지도서 유무 표시(1209)
			if(!isEmpty(obj["odAdvice"]))
			{
				img="<span style='padding:5px 10px;border-radius:10px;background:#666;color:#fff;margin-right:10px;'>복약지도서 있음</span>";
				var httpchk=obj["odAdvice"].substring(0, 4);
				console.log("httpchk = " + httpchk );
				if(httpchk=="file" || httpchk=="http" )//http or file/download
				{
					img+="<span style='padding:5px 10px;border-radius:10px;background:blue;color:#fff;margin-right:10px;'>포장</span>";
				}
			}
			else
			{
			
				img="<span style='padding:5px 10px;border-radius:10px;background:#eee;color:#aaa;margin-right:10px;'>복약지도서 없음</span>";
			}

			$("#odAdvice").html(img);
			//----------------------------------------------------------------------


			//바코드 :: 20190723 maCode에서 odCode로 바꿈 
			var barcode=obj["odCode"];
			$("#barcodeDiv").barcode(barcode, "code128", {barWidth:2, barHeight: 40, fontSize:15, showHRI:false});
			//$("#barcodeDiv").barcode(obj["maCode"], "code128", {barWidth:2, barHeight: 40, fontSize:15, showHRI:false});
			$("#barcodeDiv").css('width', '600px');
			$("#barcodeDiv").css('height', '40px');
			//$("#barcodeDiv").css('margin', '0 auto');
			$("#barcodeDiv").css('margin-left', '-20px');
			//바코드텍스트 
			$("#barcodeTextDiv").text(barcode);
			var url = "medicine="+obj["rcMedicine"]+"&sweet="+obj["rcSweet"];//+"&smuNewCode="+smuNewCode;
			callapi('GET','medicine','medicinetitle',url);

			var nowip=ip();
			var ck_stUserid=getCookie("ck_stUserid");
			var d = new Date();
			var nowdate = pad(d.getFullYear(), 4) + '-' + pad(d.getMonth() + 1, 2) + '-' + pad(d.getDate(), 2) + ' ' + pad(d.getHours(), 2) + ':' + pad(d.getMinutes(), 2) + ':' + pad(d.getSeconds(), 2);
			
			$("#prtNowDate").text("출력일시 : "+nowdate);
			$("#prtNowId").text("ID : "+hide_str(ck_stUserid));
			$("#prtNowIp").text("IP : "+nowip);
		}
		else if(obj["apiCode"]=="medicinetitle")
		{
			var totcapa=sweetcapa=medicapa=cnt=0;
			var value=rcmedicine=medibox=data="";

			//별전&약재리스트
			var	data='<table class="subtbl fitbl" style="width:33%;table-layout: fixed;">';
					data+='<col style="width:9%;"><col style="width:9%;"><col style="width:60%;"><col style="width:22%;">';					
					data+='<tbody>';
			var	table='<table class="subtbl" style="width:33%;table-layout: fixed;">';
					table+='<col style="width:9%;"><col style="width:9%;"><col style="width:60%;"><col style="width:22%;">';					
					table+='<tbody>';

			
			var newMediSweet;
			if(!isEmpty(obj["sweet"]))
			{
				newMediSweet=obj["sweet"].concat(obj["medicine"]);
			}
			else
			{
				newMediSweet=obj["medicine"];
			}

			cnt=newMediSweet.length;
			
			for(var i=0;i<42;i++)
			{
				if(i==0 || i % 14 == 0)
				{
					if(i==0){
						data+=table.replace("subtbl","subtbl fitbl");
					}else if(i==28){
						data+="</tbody></table>"+table.replace("subtbl","subtbl lstbl");
					}else{
						if(i>0){data+="</tbody></table>"+table;}
					}
					data+="<tr><th colspan='3'><?=$txtdt['1576']?><!-- 품목 --></th><th><?=$txtdt['1771']?><!-- 용량 --></th></tr>";
				}
				if(i<cnt)
				{
					value=newMediSweet[i];//obj["medicine"][i];
					if(value["rcDecoctype"]=='inlast')
					{
						medicapa=parseFloat(value["rcCapa"]);
						sweetcapa+=medicapa;
					}
					else
					{
						medicapa = parseFloat(value["rcCapa"]) * parseFloat($("#odChubCnt1").text());
						totcapa+=parseFloat(medicapa);
					}

					if(value["rcmedibox"].indexOf("00000") >= 0)
					{
						medibox = "▲";
					}
					else
					{
						if(isEmpty(value["rcmedibox"]))
							medibox = "X";
						else
							medibox = "O";
					}				
					data+='<tr>';

						var rcDecoctypedata="";
						if(value["rcDecoctype"]=='infirst')
						{
							rcDecoctypedata="선";
						}
						else if(value["rcDecoctype"]=='inmain')
						{
							rcDecoctypedata="일";
						}
						else if(value["rcDecoctype"]=='inafter')
						{
							rcDecoctypedata="후";
						}
						else if(value["rcDecoctype"]=='inlast')
						{
							rcDecoctypedata="별";
						}

					data+='	<td class="fi" style="letter-spacing: -1px;font-size:13p;">'+(i+1)+'</td>';
					data+='	<td class="lt">'+rcDecoctypedata+'</td>';


					var origin=value["rcOrigin"].substring(0,1);
					var oridata="<div style='position:absolute;width:20px;height:20px;border:1px solid #111;border-radius:50%;font-size:13px;text-align:center;color:#000;'>"+origin+"</div> ";

					if(!isEmpty(value["exceltitle"]))
					{
						data+='	<td class="lt" style="letter-spacing: -1px;text-overflow:string; overflow:hidden; white-space:nowrap;">'+oridata+"<span style='margin-left:22px;'>"+value["exceltitle"]+'</span>'+'</td>';
					}
					else
					{

						data+='	<td class="lt" style="letter-spacing: -1px;text-overflow:string; overflow:hidden; white-space:nowrap;">'+oridata+"<span style='margin-left:22px;'>"+value["rcMedititle"]+'</span'+'</td>';//품목 
					}
					
					data+='	<td >'+(parseFloat(medicapa).toFixed(1))+'</td>';
					data+='</tr>';
				}
				else
				{
					data+='<tr><td class="fi" style="letter-spacing: -1px">'+(i+1)+'</td><td></td><td></td><td></td></tr>';
				}

				if(value["rcMedicode"].indexOf("HD10337") != -1 || value["rcMedicode"].indexOf("HD10336_15") != -1)//녹용이면 
				{
					var origin=value["rcOrigin"].substring(0,1);
					$("#antler").html("<span style='padding:5px 10px;border-radius:10px;background:#b22222;color:#fff;margin-right:10px;'>녹("+origin+")</span>");
				}
			}
			data+='</tbody></table>';
			$("#medilist").html(data);

			var pack=$("#odPackCnt1").text();
			var capa=$("#odPackCapa1").text();
			//총용량 
			$("#smuTotalWater").text(totcapa.toFixed(1)+"g/" + sweetcapa+"g");

			setTimeout('print();', 500);

		}

	}

	function hide_str(s)
	{
		var result = "";
		result = s.split("");
		for(var i = 3; i < result.length; i++){
			result[i] = "*";
		}
		return result.join("");
	}

	function getHHMMSS(dctime)
	{
		var myNum = parseInt(dctime*60, 10);
		var hours   = Math.floor(myNum / 3600);
		var minutes = Math.floor((myNum - (hours * 3600)) / 60);
		var seconds = myNum - (hours * 3600) - (minutes * 60);

		if (hours   < 10) {hours   = "0"+hours;}
		if (minutes < 10) {minutes = "0"+minutes;}
		if (seconds < 10) {seconds = "0"+seconds;}
		return hours+'시간'+minutes+'분';//+seconds;
	}

	//한의원 상세 정보
	//callapi('GET','order','orderprint_smu','<?=$apiprinterData?>');
	callapi('GET','order','orderprint','<?=$apiprinterData?>');

</script>
