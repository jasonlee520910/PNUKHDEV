<?php //재고관리>약재재고 목록
$root = "../..";
include_once ($root.'/_common.php');
?>
<script>
	$.datepicker.setDefaults({
			dateFormat: 'yy.mm.dd',
			prevText: '이전 달',
      nextText: '다음 달',
      monthNames: ['1월', '2월', '3월', '4월', '5월', '6월', '7월', '8월', '9월', '10월', '11월', '12월'],
      monthNamesShort: ['1월', '2월', '3월', '4월', '5월', '6월', '7월', '8월', '9월', '10월', '11월', '12월'],
      dayNames: ['일', '월', '화', '수', '목', '금', '토'],
      dayNamesShort: ['일', '월', '화', '수', '목', '금', '토'],
      dayNamesMin: ['일', '월', '화', '수', '목', '금', '토'],
      showMonthAfterYear: true,
      yearSuffix: '년'
		});

	$(function(){
		//달력
		$("#sdate").datepicker({
			maxDate :  $.datepicker.parseDate($.datepicker._defaults.dateFormat, $("#edate").val()),
			onSelect:function(selectedDate){
				$("#edate").datepicker('option', 'minDate', $.datepicker.parseDate($.datepicker._defaults.dateFormat, selectedDate));
			}
		});
		$("#edate").datepicker({
			minDate :  $.datepicker.parseDate($.datepicker._defaults.dateFormat, $("#sdate").val()),
			onSelect:function(selectedDate){
				$("#sdate").datepicker('option', 'maxDate', $.datepicker.parseDate($.datepicker._defaults.dateFormat, selectedDate));
			}
		});
	})
</script>
<!--// page start -->
<div id="pagegroup" value="stock"></div>
<div id="pagecode" value="medistocklist"></div>

<div class="board-view-wrap">
	<span class="bd-line"></span>
	<table>
		  <caption><span class="blind"></span></caption>
		  <colgroup>
			  <col width="180">
			  <col width="*">
		  </colgroup>
		  <tbody>
			<tr>
				<th><span><?=$txtdt["1038"]?><!-- 기간선택 --></span></th>
				<td class="selperiod"><?=selectperiod()?></td>
			</tr>
			<tr>
				<th><span><?=$txtdt["1020"]?><!-- 검색 --></span></th>
				<td><?=selectsearch()?></td>
			</tr>
		  </tbody>
	</table>
</div>
<div class="gap"></div>
<div class="board-list-wrap">

	<span class="bd-line"></span>
	<div class="list-select">
	<span id="pagecnt" class="tcnt" style="float:left"></span>
	<p class="notice">* <?=$txtdt["1555"]?><!-- 붉은색 재고수량은 적정수량에 비해 수량이 부족한 약재입니다. --></p>
		<p class="fl">
		</p>
	</div>
	<table id="tbllist" class="tblcss">
		  <caption><span class="blind"></span></caption>
		  <colgroup>
			 <col scope="col" width="9%">
			 <col scope="col" width="*">
			 <col scope="col" width="9%">
			 <col scope="col" width="9%">
			 <col scope="col" width="8%">
			 <col scope="col" width="10%">
			 <col scope="col" width="10%">
			 <col scope="col" width="10%">
			 <col scope="col" width="8%">
			 <col scope="col" width="8%">
			 <col scope="col" width="4%">
		  </colgroup>
		  <thead>
			 <tr>
				  <th><?=$txtdt["1213"]?><!-- 약재코드 --></th>
				  <th><?=$txtdt["1204"]?><!-- 약재명 --></th>
				  <th><?=$txtdt["1237"]?><!-- 원산지 --></th>
				  <th><?=$txtdt["1288"]?><!-- 제조사 --></th>
				  <th><?=$txtdt["1383"]?><!-- 판매가격 --></th>
				  <th><?=$txtdt["1282"]?><!-- 재고수량 --></th>
				  <th><?=$txtdt["1778"]?><!-- 약재함잔량 --></th>				  
				  <th><?=$txtdt["1549"]?><!-- 적정수량 --></th>
				  <th><?=$txtdt["1164"]?><!-- 상태 --></th>
				  <th><?=$txtdt["1344"]?><!-- 최종입고일 --></th>
				  <th><?=$txtdt["1513"]?><!-- 주문 --></th>
			  </tr>
		  </thead>
		  <tbody>
		  </tbody>
	  </table>
	</div>
<div class="gap"></div>
<!-- s : 게시판 페이징 -->
<div class='' id="medistocklistpage"></div>
<!-- e : 게시판 페이징 -->
<!--// page end -->

<script>
	function repageload(){
	console.log("no  repageload ");
	}
	function mediStatusClick(obj, seq)
	{
		if(obj.checked == true)
		{
			//call api 
			var jsondata={};
			jsondata["seq"] = seq;
			jsondata["returnData"] = "<?=$root?>/Skin/Stock/StockList.php";
			callapi("POST","stock","medistatusupdate",jsondata);
		}
	}
	function viewStockDesc(stock)
	{
		var url="/99_LayerPop/layer-stockdesc.php?whStock="+stock;		
		viewlayer(url,700,700,"");
	}
	function makepage(json)
	{
		var obj = JSON.parse(json);
		console.log(obj);
		var redview=origin=maker=data=stable=trbackg=mbCapaBack=statusBack=statusCheck="";
		var qty=price=0;

		if(obj["apiCode"] == "medistocklist")
		{
			$("#tbllist tbody").html("");
			if(!isEmpty(obj["list"]))
			{
				$(obj["list"]).each(function( index, value )
				{
					origin=isEmpty(value["mdOrigin"]) ? "-" : value["mdOrigin"];
					maker=isEmpty(value["mdMaker"]) ? "-" : value["mdMaker"];
					//qty=parseInt(value["mbCapacity"]) + parseInt(value["mdQty"]);
					price=(!isEmpty(value["mdPrice"])) ? value["mdPrice"] : 0;
					if(value["mdStatus"] == "shortage")//약재부족
					{
						trbackg="style='background-color: #FBEFEF;'";
						statusCheck="<label class='checkbox-wrap'>";
						statusCheck+="<input type='checkbox' name='mcorder' id='mcorder' value=''  onClick='mediStatusClick(this, "+value["seq"]+");'>";
						statusCheck+="<i class='check-icon'></i></label>"; //주문 
					}
					else if(value["mdStatus"]=="complete")//주문완료 
					{
						trbackg="style='background-color: #EFFBF5;'";
						statusCheck="";
					}
					else //사용,품절,일시정지,단종등 
					{
						trbackg="";
						statusCheck="";
					}

					if(parseInt(value["mbCapa"]) <= 0)
						mbCapaBack="style='color:#E23D27;font-weight:bold;cursor:pointer;'";
					else
						mbCapaBack="style='cursor:pointer;'";

					if(value["mdStatus"] == "shortage" || value["mdStatus"]=="complete")//약재부족
						statusBack="style='font-weight:bold;'";
					else
						statusBack="style='font-weight:normal;'";
					
					data+="<tr "+trbackg+">";
					data+="<td>"+value["mdCode"]+"</td>"; //약재코드
					data+="<td>"+value["mdTitle"]+"</td>"; //약재명
					data+="<td>"+origin+"</td>"; //원산지
					data+="<td>"+maker+"</td>"; //제조사
					data+="<td class='r'>"+comma(price)+"</td>"; //판매가격
					data+="<td class='r' "+mbCapaBack+"><span onclick=\"viewStockDesc('"+value["mdCode"]+"')\"><span>"+comma(parseInt(value["mdQty"]))+"</span></span></td>"; //재고수량
					data+="<td class='r' "+mbCapaBack+"><span>"+comma(parseInt(value["mbCapacity"]))+"</span></td>"; //약재함잔량 
					data+="<td class='r'>"+value["mdStable"]+"</td>"; //적정수량
					data+="<td "+statusBack+">"+value["mdStatusName"]+"</td>"; //상태 
					data+="<td>"+value["inDate"]+"</td>"; //최종입고일
					data+="<td>"+statusCheck+"</td>"; //주문 		
					data+="</tr>";
				});
			}
			else
			{
				data+="<tr>";
				data+="	<td colspan='11'><?=$txtdt['1665']?></td>";
				data+="</tr>";
			}
			$("#tbllist tbody").html(data);
			$("#pagecnt").text(comma(obj["tcnt"])+" <?=$txtdt['1019']?>");
			//페이지
			getsubpage("medistocklistpage",obj["tpage"], obj["page"], obj["block"], obj["psize"]);
		}
		else if(obj["apiCode"] == "medistockdesc")
		{
			$("#pop_sdtbl tbody").html("");

			$("input[name=medidescstock]").val(obj["whStock"]);

			if(!isEmpty(obj["list"]))
			{
				$(obj["list"]).each(function( index, value )
				{
					var mtTitle = isEmpty(value["mtTitle"]) ? "-" : value["mtTitle"];
					var qty=(!isEmpty(value["whQty"])) ? value["whQty"] : 0;
					data+="<tr>";
					data+="<td>"+value["whDate"]+"</td>"; //입출고일 
					data+="<td>"+value["whStatusName"]+"</td>"; //상태 
					data+="<td>"+mtTitle+"</td>"; //조제대
					data+="<td class='r'>"+comma(qty)+"</td>"; //수량 
					data+="</tr>";
				});
			}
			else
			{
				data+="<tr>";
				data+="	<td colspan='4'><?=$txtdt['1665']?></td>";
				data+="</tr>";
			}
			$("#pop_sdtbl tbody").html(data);
			//페이지
			getsubpage("medistockdescpage",obj["tpage"], obj["page"], obj["block"], obj["psize"]);
		}
		return false;
}

	//약재재고목록 리스트  API 호출
	var hdata=location.hash.replace("#","").split("|");
	var page=hdata[0];
	var apiOrderData="";
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
		if(sarr1[1]!=undefined)var sdate=sarr1[1];
		if(sarr2[1]!=undefined)var edate=sarr2[1];
		if(sarr3[1]!=undefined)var searchTxt=sarr3[1];
		if(sarr5[1]!=undefined)var searchPeriodEtc=sarr5[1];
		$("input[name=sdate]").val(sdate);
		$("input[name=edate]").val(edate);
		$("input[name=searchTxt]").val(decodeURI(searchTxt));

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

		apiOrderData="&sdate="+sdate+"&edate="+edate+"&searchTxt="+searchTxt;
	}

	var apidata="page="+page+apiOrderData;
	console.log("apidata     : "+apidata);
	callapi('GET','stock','medistocklist',apidata); 
	$("#searchTxt").focus();
</script>
