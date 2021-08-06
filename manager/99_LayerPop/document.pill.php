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
		table tr th, table tr td{padding:3px;font-size:15px;}
		.maintbl{width:100%;border-top:1px solid #333;border-left:1px solid #333;margin-bottom:5px;}
		.maintbl tr th, .maintbl tr td{border-right:1px solid #333;border-bottom:1px solid #333}
		.tbltitle tr th{font-size:25px;font-weight:bold;}
		.tblinfo tr th{font-size:13px;}
		.tblinfo tr td{font-size:13px;font-weight:bold;}

		.subtbl{width:100%;border-bottom:1px solid #ddd;}
		.subtbl tr th, .subtbl tr td{border:none;border-right:1px solid #ddd;border-top:1px solid #ddd;font-size:13px;text-align:center;height:28px;}
		.subtbl tr th{font-weight:normal;background:#f4f4f4;}
		.subtbl tr td{text-align:left;}

		.fitbl{margin-left:0;margin-right:1px;border-left:none;;}
		.lstbl, .lstbl tr th{border-right:red;border-left: 1px solid #333}
		dl.subbot{/*margin:1%;*/float:right;overflow:hidden;padding-left:5px;font-weight:bold;font-size:13px;}
		dl.subbot dt{float:left;width:auto;padding-right:5px;}
		dl.subbot dd{float:left;text-align:left;padding-right:20px;}
		dl.subbot dd.total{float:left;width:22%;}
		
		.form_cont .half{float:left;width:46%;font-size:14px;padding:5px 2%;margin-bottom:10px;overflow:hidden;}
		.form_cont .rt{text-align:right;}
		.form_cont .ct{text-align:center;}
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
		.pill{}
		.pill dl{width:7%;margin:1%;display:inline-block;vertical-align:top;}
		.pill dl dt{width:auto;border:1px solid #ddd;text-align:center;padding:10px 5px;font-size:17px;font-weight:bold;}
		.pill dl dt.on{color:#111;border:1px solid #333;background:#48DAFF;}
		.pill dl dd{margin:2px auto;width:100%;}
		.pilltbl{border-left:1px solid #ddd;width:33%;table-layout: fixed;float:left;margin-right:2px;}
		.circle{position:absolute;width:20px;height:20px;border:1px solid #111;border-radius:50%;font-size:13px;text-align:center;color:#000;}
		.pilltit{margin-left:25px;}

		.medidiv{overflow:hidden;padding:3px;margin-bottom:5px;width:100%;}
		.medidiv2{float:left;overflow:hidden;border:1px solid black;padding:0;margin-bottom:5px;width:50%;}
		.medir{float:right;margin-right:0;}
		.subtit{float:left;background:#666;display:inline-block;;color:#fff;vertical-align:top;width:7%;text-align:center;padding:4px 6px;margin:0;font-size:15px;margin:-5px 0 0 -5px;}
		.medidiv2 .subtit{width:14%;margin:0;}
		.medidiv .rtit, .medidiv2 .rtit{float:right;font-size:15px;font-weight:bold;padding:2px 5px 0 0;}

		dl.medilist{float:left;width:93%;}
		dl.medilist dd{display:inline-block;border:1px solid #ddd;padding:3px;margin:2px;}
		dl.medilist dd span{font-size:13px;display:inline-block;width:auto;height:17px;}
		dl.medilist dd span.rect{font-size:12px;border:1px solid #111;text-align:center;background:#777;color:#fff;}
		dl.medilist dd span.icon{font-size:12px;width:17px;border:1px solid #111;border-radius:50%;text-align:center;background:#777;color:#fff;}
		dl.subbot{padding:5px;}
		.desc{padding:10px;}
</style>

<div class="section_print">
    <div class="form_cont" style="padding-top:10px;">
		<div class="barcode" id="barcodeDiv">11</div>
		<div class="barcodetext" id="barcodeTextDiv">11</div>
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
					<th id="odType">사전</th>
					<th><span id="smuInoutFlag"></span><span id="odTitle">뉴경옥고스틱 10,000개</span></th>
				</tr>
			</table>
			<div class='pill' id="pillorderdiv">

			</div>
			<div class="medidiv" id="div_medicine">
				<dl id="medilist" class="medilist"></dl>
				<dl class="subbot">
					<dt><?=$txtdt["1498"]?><!-- 약미 -->: </dt><dd id="odmedicnt">16</dd>
					<dt><?=$txtdt["1773"]?><!-- 총용량 -->: </dt><dd class="total" id="odmedicapa">30,000g</dd>
				</dl>
			</div>
			
			<div id="div_pillorder">
			</div>


			<div class="medidiv" id="div_packing">

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
			$("#odTitle").text(obj["odTitle"]+obj["odQty"]+"개");//<!-- 첩약처방명 -->

			//약재리스트
			var cnt=obj["gdPillmedicine"].length;
			$("#odmedicnt").text(cnt);
			var	data='<table class="subtbl pilltbl">';
				data+='<colgroup><col style="width:10%;"><col style="width:60%;"><col style="width:30%;"></colgroup>';					
				data+='<tbody>';

			var	table='<table class="subtbl pilltbl">';
				table+='<colgroup><col style="width:10%;"><col style="width:60%;"><col style="width:30%;"></colgroup>';					
				table+='<tbody>';

			var medititle=mediorigin=medicapa="";
			//var totalmedicapa=0;
			for(var i=0;i<12;i++)
			{
				medititle=mediorigin=medicapa="";
				if(i==0 || i % 4 == 0)
				{
					if(i==0){
					}else if(i==8){
						data+="</tbody></table>"+table;
					}else{
						if(i>0){data+="</tbody></table>"+table;}
					}
					data+="<tr><th colspan='2'><?=$txtdt['1576']?></th><th><?=$txtdt['1771']?></th></tr>";
				}
				if(i<cnt)
				{
					medititle=obj["gdPillmedicine"][i]["title"];
					console.log("medititle = " + medititle);
					mediorigin=obj["gdPillmedicine"][i]["origin"].substring(0,1);
					medicapa=obj["gdPillmedicine"][i]["medicapa"];

					data+='<tr>';
					data+='	<td class="fi ct">'+(i+1)+'</td>';
					data+='	<td class="lt"><div class="circle">'+mediorigin+'</div> <span class="pilltit">'+medititle+'</span></td>';
					data+='	<td class="rt">'+(parseFloat(medicapa).toFixed(1))+'</td>';
					data+='</tr>';

					//totalmedicapa+=medicapa;
				}
				else
				{
					data+='<tr><td class="fi ct">'+(i+1)+'</td><td></td><td></td></tr>';
				}
			}
			data+='</tbody></table>';
			$("#pillorderdiv").html(data);
			$("#odmedicapa").text(comma(obj["gdtotmedicapa"]) + "g");


			//pillorder data
			var pdata=worktxt=packdata="";
			for(i in obj["gdPilllist"])
			{
				var porder=obj["gdPilllist"][i]["order"];
				var ptype=porder["type"];
				worktxt="";

				if(ptype!="making")
				{
					var ptypetxt=porder["typetxt"];
					var pname=porder["name"];
					var poutcapa=porder["outcapa"];
					var medicine=porder["order"]["medicine"];
					var medicinetxt="";
					for(var j=0;j<medicine.length;j++)
					{
						if(medicine[j]["kind"]=="unit")
						{
							medicinetxt+=medicine[j]["name"]+" : "+comma(medicine[j]["capa"])+"개<br>";
						}
						else
						{
							medicinetxt+=medicine[j]["name"]+" : "+comma(medicine[j]["capa"])+"g<br>";
						}
					}

					if(ptype=="packing")
					{
						packdata+='<div class="subtit">'+ptypetxt+'</div><span  class="rtit">'+pname+' : '+comma(poutcapa)+'개</span>';
						packdata+='<table class="subtbl">';
						packdata+='	<tr><th>투입재료</th><td>'+medicinetxt+'</td></tr>';
						packdata+='	<tr><td colspan="2">잘 포장 해 주세요</td></tr>';
						packdata+='</table>';
					}
					else
					{
						var pwork=porder["order"]["work"];
						console.log(pwork);

						for(j=0;j<pwork.length;j++)
						{
							var pwcode=pwork[j]["code"];
							var pwcodetxt=pwork[j]["codetxt"];
							var pwvalue=pwork[j]["value"];
							var pwvaluetxt=pwork[j]["valuetxt"];
							console.log("pwcode : "+pwcode);

							if(!isEmpty(pwcodetxt) && !isEmpty(pwcode))
							{
								worktxt+=pwcodetxt+" : "+pwvaluetxt+",";
							}

						}

						pdata+='<div class="medidiv2" id="div_"'+ptype+'>';
						pdata+='	<div class="subtit">'+ptypetxt+'</div><span  class="rtit">'+pname+' : '+comma(poutcapa)+'g</span>';
						pdata+='	<table class="subtbl">';
						pdata+='		<tr><th>투입재료</th><td>'+medicinetxt+'</td></tr>';
						pdata+='		<tr><td colspan="2">'+worktxt+'</td></tr>';
						pdata+='	</table>';
						pdata+='</div>';
					}

				}
					
				

			}

			//포장재리스트
			if(!isEmpty(obj["packinglist"]))
			{
				packdata+='<table class="subtbl">';
				packdata+='	<col width="16%"><col width="16%"><col width="16%"><col width="16%"><col width="16%"><col width="16%">';
				var len=obj["packinglist"].length/6;
				var maxlen=6;
				var pi=0;
				for(var j=0;j<len;j++)
				{
					packdata+='	<tr>';
					
					for(var i=0;i<maxlen;i++)
					{
						pi=(j*6)+i;
						if(!isEmpty(obj["packinglist"][pi]))
						{
							packdata+='		<th>'+obj["packinglist"][pi]["name"]+'</th>';
						}
						else
						{
							packdata+='		<th></th>';
						}
					}
					packdata+='	</tr>';
					packdata+='	<tr>';
					for(var i=0;i<maxlen;i++)
					{
						pi=(j*6)+i;
						if(!isEmpty(obj["packinglist"][pi]))
						{
							packdata+='		<td><img src="'+getUrlData("FILE_DOMAIN")+obj["packinglist"][pi]["file"]+'" onerror="this.src=\'<?=$root?>/_Img/Content/noimg.png\'" /></td>';
						}
						else
						{
							packdata+='		<td></td>';
						}
					}
					packdata+='	</tr>';
				}

				packdata+='</table>';
			}

			console.log(packdata);

			$("#div_pillorder").html(pdata);
			$("#div_packing").html(packdata);


		}
	}

	callapi('GET','order','orderprintpill','<?=$apiprinterData?>');

</script>
