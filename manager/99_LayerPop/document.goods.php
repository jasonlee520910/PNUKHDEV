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
		.subtbl{width:255px;height:29px;float:left;border:none;border-left:1px solid #333;border-right:1px solid #333;margin-left:2px;}
		.subtbl tr td{border:none;border-left:1px solid #333;border-top:1px solid #333;font-size:14px;text-align:center;height:29px;font-weight:bold;}
		.subtbl tr td.leftDiv{border:1px solid;}
		.subtbl tr td.lt{text-align:left;}
		.subtbl tr td.fi{border-left:none;}
		.fitbl{margin-left:0;margin-right:1px;border-left:none;;}
		.lstbl, .lstbl tr th{border-right:red;border-left: 1px solid #333}
		dl.subbot{/*margin:1%;*/overflow:hidden;padding-left:5px;font-weight:bold;font-size:17px;}
		dl.subbot dt{float:left;width:auto;padding-right:5px;}
		dl.subbot dd{float:left;text-align:left;padding-right:30px;}
		dl.subbot dd.total{float:left;width:22%;}
		
		.form_cont .half{float:left;width:46%;font-size:14px;padding:5px 2%;margin-bottom:10px;overflow:hidden;}
		.form_cont .rt{float:right;text-align:right;line-height:180%;}
		.form_cont .line{clear:both;margin:15px 15px 20px 15px;;border-top:1px dotted #999;}
		span.spanrt{float:right;margin-right:20px;}
		.etc{font-size:13px;padding:4px;}

		.form_dtl_pop{overflow:hidden; clear:both;width:100%;}
		.form_dtl_pop .fl{float:left; width:69%;}
		.form_dtl_pop .fr{float:right; width:30%;}


		.relesetbl{border-top:1px solid #333;border-left:1px solid #333;border-right:1px solid #333;margin-left:2px;margin-top:5px;}
		.relesetbl tr th, .relesetbl tr td{width:4%;border:none;border-right:1px solid #333;border-bottom:1px solid #333;font-size:13px;text-align:center;height:50px;}
		.relesetbl tr td{width:15%;font-weight:bold;text-align:left;}

		.requesttbl{border-top:1px solid #333;border-left:1px solid #333;border-right:1px solid #333;margin-left:2px;margin-top:5px;}
		.requesttbl tr th, .requesttbl tr td{width:4%;border:none;border-right:1px solid #333;border-bottom:1px solid #333;font-size:13px;text-align:center;height:130px;}
		.requesttbl tr td{width:15%;font-weight:bold;text-align:left;}



		#odRequestDiv {height:60px;text-align: left;overflow-y:auto;}
		.inth {padding-left:10px;padding-right:10px;letter-spacing: -1px;}

		.feature {position:absolute;top:0;right:0;float:right;width:400px;height:40px;margin-top:10px;margin-right:10px;padding-right:10px;font-size:25px;font-weight:bold;text-align:right;}


	#goodsdata{float:left;width:100%;}
	#goodsdata dl{float: left;width: 49%;margin-right: 1%;overflow: hidden;margin-bottom: 1%;background-color: #ECF0F1;border: 1px solid #797D7F;}
	#goodsdata dl dt{float: left;width: 69%; padding: 0; height: 45px; text-align: center;line-height:50px;background-color: #D0D3D4;font-size:17px;font-weight:bold;border-bottom: 1px solid #797D7F;}
	#goodsdata dl dd{float: left; width: 69%; padding: 0; text-align: center; line-height:50px;height: 45px; background-color: #ECF0F1;font-size:17px;}
	#goodsdata dl .img{float: left;height: 90px;    overflow: hidden;   width: 30%;border-right: 1px solid #797D7F;}
	#goodsdata dl .img img{height:99%;}
</style>

<div class="section_print">
    <div class="form_cont" style="padding-top:10px;">
		<div class="barcode" id="barcodeDiv"></div>
		<div class="barcodetext" id="barcodeTextDiv"></div>
		<div class="feature"><span id="reDelicompAdd"></span><span id="reDelicomp" style='padding:5px 10px;border-radius:10px;background:#3300CC;color:#fff;margin-right:10px;'></span><span id="antler"></span><span id="odFeature"></span></div>
		<div>
			<table class="maintbl tbltitle">
				<tr>
					<th id="smuInoutFlag"></th>
					<th id="odTitle"></th>
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
					<th><?=$txtdt["1889"]?><!-- 생년월일 --></th>
					<td id="odBirth"></td>
					<th><?=$txtdt["1888"]?><!-- 성별 --></th>
					<td id="odGender"></td>
					<th><?=$txtdt["1139"]?><!-- 비고 --></th>
					<td colspan="3" id="odNote"></td>
				</tr>
			</table>

			<table class="maintbl tbltitle">
				<tr>
					<th id="goodsName"></th>
					<th id="goodsCnt"></th>
				</tr>
			</table>

			<div id="goodsdata"></div>
			
			<div class="lst_tb2" >
				<div id="sweetDiv"></div> <!-- 앰플/기타약재  내용  -->
			</div>
			
			<div class="form_dtl_pop">	
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

		if(obj["apiCode"]=="ordergoodsprint")
		{
			
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
			//처방PK
			$("#odFeature").html(obj["odChartPK"]);
		
			
			//성별 
			$("#odGender").text(obj["odGenderName"]);
			//생년월일  
			$("#odBirth").text(obj["odBirth"]);

			$("#smuInoutFlag").text(obj["maTypeName"]); //탕전
			//주문자
			$("#userName").text(obj["miName"]);
			//받는사람
			$("#reName").text(obj["reName"]);
			//주문일자
			$("#odDate").text(obj["odDate"]);
			//배송희망일
			$("#reDelidate").text(obj["reDelidate"]);
			//배송희망일
			$("#odNote").text("환자명 : "+obj["odName"]+"");


			//첩약처방명 : TS57022(대명전 가감)
			$("#odTitle").text(obj["odTitle"]);//<!-- 첩약처방명 -->

			//제품명 
			$("#goodsName").text(obj["goodsName"]);			
			var goodsCnt=obj["goodsCnt"];
			//제품갯수 
			$("#goodsCnt").text(goodsCnt+"개");

			data="";
			var imgsrc="";
			var glcnt=obj["goodslist"].length;
			$(obj["goodslist"]).each(function( index, value )
			{
				if(!isEmpty(value["gd_thumb_image"]) && value["gd_thumb_image"]!="NoIMG")
				{
					imgsrc=getUrlData("FILE_DOMAIN")+value["gd_thumb_image"];
				}
				else
				{
					imgsrc="<?=$root?>/_Img/Content/noimg.png";
				}

				data+="<dl id='"+value["gd_code"]+"'>";
				data+="<dd class='img'><img src='"+imgsrc+"'></dd>";
				data+="<dt>"+value["gd_name"]+"</dt>";
				data+="<dd>"+(parseInt(value["gd_cnt"]) * parseInt(goodsCnt))+"개</dd>";

				data+="</dl>"
			});

			$("#goodsdata").html(data);
				

			//보내는 사람
			$("#meNameDiv").html(obj["reSendname"] + "<br> [" + obj["reSendzipcode"]+"] "+obj["reSendaddress"]+" "+obj["reSendaddress1"]);
			//받는 사람
			var addr = !isEmpty(obj["reAddress"]) ? obj["reAddress"].replace("||", " ") : "";
			$("#reNameDiv").html(obj["reName"] + " (Tel."+obj["rePhone"]+" / Mobile."+obj["reMobile"]+") <br> [" + obj["reZipcode"] +"] "+ addr);
			//배송요청사항 
			var request=!isEmpty(obj["reRequest"]) ? obj["reRequest"] : "";
			$("#reRequestDiv").html(request);

			//주문자요청사항 
			var odRequest=!isEmpty(obj["odRequest"]) ? obj["odRequest"] : "";
			//cy 마킹정보 
			var cymarkText=!isEmpty(obj["cymarkText"]) ? obj["cymarkText"]:"";
			$("#odRequestDiv").html(cymarkText+"\n"+odRequest);
	
			
	
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

			setTimeout('print();', 500);
			
		}
		
	}

	callapi('GET','order','ordergoodsprint','<?=$apiprinterData?>');

</script>
