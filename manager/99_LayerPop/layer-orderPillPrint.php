
<?php 
	$root = "..";
	include_once $root."/_common.php";
	$odCode=$_GET["odCode"];
	$apiorderData = "odCode=".$odCode;
?>
<input type="hidden" name="odKeycode" class="reqdata" value="">
<input type="hidden" name="odGoods" class="reqdata" value="">

<style>
	#tblop .inth {padding-left:10px;padding-right:10px;letter-spacing: -1px;}
	#td_odRequest {float:left;width:660px;height:60px;text-align: left;overflow-y:auto;}
	table.poptblprt tr th, table.poptblprt tr td{padding:0 7px;height:37px;}

	.pill dl{width:7%;margin:1%;display:inline-block;vertical-align:top;background:#f4f4f4;}
	.pill dl dt{width:auto;border:1px solid #ddd;border-radius:7px;text-align:center;padding:10px 5px;color:#000;font-size:17px;font-weight:bold;}
	.pill dl dt.on{color:#111;border:1px solid #48DAFF;background:#48DAFF;}
	.pill dl dd{margin:2px auto;width:100%;}
	.pill dl dd select{width:100%;}
</style>
<!-- s: 제환 작업지시서 출력 -->
<div class="layer-wrap2 layer-orderPrint">
	<div class="layer-top2">
		<h2 style="cursor:Pointer"><?=$txtdt["1504"]?><!-- 작업지시서출력 --></h2>
		<a href="javascript:;" class="close-btn2" onclick="orderprintclosediv()"><span class="blind"><?=$txtdt["1595"]?><!-- 닫기 --></span></a>
	</div>
	<div class="layer-con">
		<div class="board-view-wrap">
			<span class="bd-line"></span>
			<table class="poptblprt">
				<colgroup>
					<col width="11%">
					<col width="22%">
					<col width="13%">
					<col width="20%">
					<col width="13%">
					<col width="20%">
				</colgroup>
				<tbody>
					<tr>
						<th><span><?=$txtdt["1305"]?><!-- 주문코드 --></span></th>
						<td colspan="2">
							<span id="odChartPK"></span>
							<span id="td_code"></span>
						</td>
						<td colspan="3">
							<span id="td_title" style="font-weight:bold;font-size:16px;"></span><span id="td_ordercnt" style="font-weight:bold;font-size:16px;"></span>
						</td>
					</tr>
				 </tbody>
			</table>
		 </div>

		<div class="board-list-wrap">
			<span class="bd-line"></span>

			<table id="tblop" class="poptblprt">
				<colgroup>
					<col width="12%">

					<col width="12%">
					<col width="32%">

					<col width="12%">
					<col width="32%">
				</colgroup>
				<tbody>
					<tr>
						<th colspan="2" class="inth" style="height:60px;"><span><?=$txtdt["1292"]?><!-- 주문자 요청사항 --></span></th>
						<td colspan="5" id="td_odRequest"></td>
					</tr>
					<tr id="tr_medicine">
						<th class="inth" style="border-right:1px solid #e3e3e4;"><span><?=$txtdt["1450"]?><!-- 약재정보 --></span></th>
						<th class="inth"><span><?=$txtdt["1338"]?><!-- 총약재량 --></span></th>
						<td id="td_medicapa"></td>
						<th class="inth"><span><?=$txtdt["1498"]?><!-- 약미 --></span></th>
						<td id="td_medicnt"></td>
					</tr>
				 </tbody>
			</table>

			<table id="tblpill" class="poptblprt">
				<colgroup>
					<col width="10%">
					<col width="15%">
					<col width="13%">
					<col width="">
				</colgroup>
				<thead>
				<tr>
					<th>분류</th>
					<th>반제품명</th>
					<th>산출량</th>
					<th>작업내용/요청사항</th>
				</tr>
				</thead>
				<tbody>
				</tbody>
			</table>


			<table id="tblop" class="poptblprt">
				<colgroup>
					<col width="10%">

					<col width="10%">
					<col width="20%">

					<col width="10%">
					<col width="20%">

					<col width="10%">
					<col width="20%">
				</colgroup>
				<tbody>
					<tr>
						<th rowspan="3" class="inth" style="border-right:1px solid #e3e3e4;"><span><?=$txtdt["1516"]?><!-- 주문금액 --></span></th>
						<th class="inth"><span><?=$txtdt["1606"]?><!-- 약재비 --></span></th>
						<td id="tot_meditotalprice"></td>
						<th class="inth"><span>감미제</span></th>
						<td id="tot_sugartotalprice"></td>
						<th class="inth"><?=$txtdt["1698"]?><!-- 조제비 --></th>
						<td id="tot_makingtotalprice"></td>
					</tr>
					<tr>
						<th class="inth"><?=$txtdt["1697"]?><!-- 탕전기 --></th>
						<td id="tot_decoctiontotalprice"></td>
						<th class="inth">특수탕전비</th>
						<td id="tot_specialtotalprice"></td>
						<th rowspan="2" class="inth"><?=$txtdt["1516"]?><!-- 주문금액 --></th>
						<td rowspan="2" id="td_total_price" class="cred"></td>
					</tr>
					<tr>
						<th class="inth"><span><?=$txtdt["1700"]?><!-- 포장비 --></span></th>
						<td id="tot_packingtotalprice"></td>
						<th class="inth"><?=$txtdt["1701"]?><!-- 배송비 --></th>
						<td id="tot_releasetotalprice"></td>
					</tr>
				 </tbody>
			</table>


			
			<div class="list-select">
				<p class="fr">
					<a href="javascript:;"><button class="btn-blue printdocument" data-bind="pill"><?=$txtdt["1505"]?><!-- 작업일지출력 --></span></button></a>
					<a href="javascript:;" id="reportDiv"></a>
				</p>
			</div>

		</div>

		<div class="mg20t c" id="btnOPDiv">
		</div>
	</div>
</div>

<script>
	function orderprintclosediv()
	{
		//주문리스트 API 호출
		var hdata=location.hash.replace("#","").split("|");
		var page=hdata[0];
		var apiOrderData="";
		//searchTxt=1&searchStatus=
		var search=hdata[2];
		if(page==undefined){
			page=1;
		}

		if(search==undefined || search==""){
			var searchTxt="";
		}else{
			var sarr=search.split("&");
			if(sarr[0]!=undefined)var sarr1=sarr[0].split("=");
			if(sarr[1]!=undefined)var sarr2=sarr[1].split("=");
			if(sarr[2]!=undefined)var sarr3=sarr[2].split("=");
			if(sarr[3]!=undefined)var sarr4=sarr[3].split("=");
			if(sarr[4]!=undefined)var sarr5=sarr[4].split("=");
			if(sarr[5]!=undefined)var sarr6=sarr[5].split("=");
			if(sarr[6]!=undefined)var sarr7=sarr[6].split("=");
			if(sarr1[1]!=undefined)var sdate=sarr1[1];
			if(sarr2[1]!=undefined)var edate=sarr2[1];
			if(sarr3[1]!=undefined)var searchTxt=sarr3[1];
			if(sarr4[1]!=undefined)var searchStatus=sarr4[1];
			if(sarr5[1]!=undefined)var searchProgress=sarr5[1];
			if(sarr6[1]!=undefined)var searchPeriodEtc=sarr6[1];
			if(sarr7[1]!=undefined)var searchMatype=sarr7[1];

			
			//if(sarr2[1]!=undefined)var searchStatus=sarr2[1];
			$("input[name=sdate]").val(sdate);
			$("input[name=edate]").val(edate);
			$("input[name=searchTxt]").val(decodeURI(searchTxt));
			//searPeriodEtc
			//------------------------------------------------------
			//상태 체크박스 
			//------------------------------------------------------
			var starr=searchStatus.split(",");
			for(var i=0;i<starr.length;i++){
				if(starr[i]!=""){
					$(".searchStatus"+starr[i]).attr("checked",true);
				}
			}
			//------------------------------------------------------

			//------------------------------------------------------
			//진행 체크박스 
			//------------------------------------------------------
			var ptarr=searchProgress.split(",");
			for(var i=0;i<ptarr.length;i++){
				if(ptarr[i]!=""){
					$(".searchProgress"+ptarr[i]).attr("checked",true);
				}
			}
			//------------------------------------------------------

			//------------------------------------------------------
			//조제타입별 체크박스 
			//------------------------------------------------------
			var mtarr=searchMatype.split(",");
			for(var i=0;i<mtarr.length;i++){
				if(mtarr[i]!=""){
					$(".searchMatype"+mtarr[i]).attr("checked",true);
				}
			}
			//------------------------------------------------------
			
			//------------------------------------------------------
			//기간선택 라디오박스 
			//------------------------------------------------------
			var pearr=searchPeriodEtc.split(",");
			for(var i=0;i<pearr.length;i++){
				if(pearr[i]!=""){
					$(".searPeriodEtc"+pearr[i]).attr("checked",true);
				}
			}
			//------------------------------------------------------

			apiOrderData="&sdate="+sdate+"&edate="+edate+"&searchTxt="+encodeURI(searchTxt)+"&searchStatus="+searchStatus+"&searchProgress="+searchProgress+"&searchMatype="+searchMatype;
		}

		var apidata="page="+page+apiOrderData;
		console.log("apidata     : "+apidata);
		callapi('GET','order','orderlist',apidata);

		closediv('viewlayer');
	}
	//작업등록
	function orderconfirmpill(seq)
	{
		$("#confirmid").removeAttr("onclick");
		$("#confirmid span").text("작업등록중...");

		var odGoods=$("input[name=odGoods]").val();
		var url="seq="+seq+"&returnData=";
		url+="&odGoods="+odGoods;
		console.log("odGoods = " + odGoods+", url = " + url);

		callapi('GET','goods','goodsconfirmpill',url);
	}
	//작업지시
	function orderchangepill(seq)
	{	
		var odGoods=$("input[name=odGoods]").val();
		var url="seq="+seq+"&process=order&status=pill_apply&returnData=";
		var goodsdata="";
		if(odGoods=="G")
		{
			goodsdata="[제환 사전]\n";
		}
		else
		{
			goodsdata="[제환]\n";
		}
		console.log("bbbbb  orderchange url: " + url);
	
		
		var text = goodsdata+"<?=$txtdt['1421']?>";//작업지시를 하시겠습니까?

		if(confirm(text)) //작업지시를 하시겠습니까?
		{
			callapi('GET','order','orderchange', url);
			viewpage();
		}
		
	}
	$(".printdocument").on("click",function(e)
	{
		var code="<?=$odCode?>";
		var chk=code.length;
		console.log("printdocument  code = " + code );
		if(chk=="22")
		{
			alertsign("warning", "<?=$txtdt['1594']?>", "", "2000");//작업등록을 먼저해야 합니다.
		}
		else
		{
			printdocument("pill",code,900);
		}

	});
	callapi('GET','goods','goodssummarypill','<?=$apiorderData?>');
</script>