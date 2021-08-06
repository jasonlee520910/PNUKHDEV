<?php //약재입고
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
<div id="pagecode" value="instocklist"></div>

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
	<span id="pagecnt" class="tcnt"></span>
		<p class="fl">
		</p>
		<p class="fr">
			<a href="javascript:;" onclick="viewdetaildesc('add')"><button class="btn-blue"><span>+ <?=$txtdt["1208"]?><!-- 약재입고 --></span></button></a>
		</p>
	</div>
	<table id="tbllist" class="tblcss">
		  <caption><span class="blind"></span></caption>
		  <colgroup>
			 <col scope="col" width="14%">
			 <col scope="col" width="10%">
			 <col scope="col" width="10%">
			 <col scope="col" width="%">
			 <col scope="col" width="8%">
			 <col scope="col" width="9%">
			 <col scope="col" width="8%">
			 <col scope="col" width="8%">
			 <col scope="col" width="10%">
			 <col scope="col" width="9%">
		  </colgroup>
		  <thead>
			  <tr>
 				  <th><?=$txtdt["1265"]?><!-- 입고코드 --></th>
 				  <th><?=$txtdt["1264"]?><!-- 입고일 --></th>
 				  <th><?=$txtdt["1204"]?><!-- 약재명 --></th>
 				  <th><?=$txtdt["1266"]?><!-- 입고품명 --></th>
 				  <th><?=$txtdt["1237"]?><!-- 원산지 --></th>
 				  <th><?=$txtdt["1288"]?><!-- 제조사 --></th>
 				  <th><?=$txtdt["1263"]?><!-- 입고수량 --></th>
 				<!--   <th><?=$txtdt["1707"]?>재고량</th> -->
 				  <th><?=$txtdt["1260"]?><!-- 입고가격 --></th>
 				  <th><?=$txtdt["1242"]?><!-- 유통기한 --></th>
 				  <th><?=$txtdt["1045"]?><!-- 납품처 --></th>
 			  </tr>
		  </thead>
		  <tbody>
		</tbody>
	</table>
</div>
<div class="gap"></div>
<!-- s : 게시판 페이징 -->
<div class='' id="instocklistpage"></div>
<!-- e : 게시판 페이징 -->

<!--// page end -->

<script>
	function repageload(){
	console.log("no  repageload ");
	}

	function viewdetaildesc(seq)
	{
		console.log("상세보기 seq    :"+seq);
		if(seq=='add')
		{
			var hdata=location.hash.replace("#","").split("|");
			var page=hdata[0];
			if(page==undefined){page="";}
			var search=hdata[2];
			if(search ===undefined){search="";}
			makehash(page,seq,search)
			$("#listdiv").load("<?=$root?>/Skin/Stock/InStockWrite.php?seq="+seq);
		}
		else
		{
			viewdesc(seq);
		}	
	}

	/*
	function godesc(seq)
	{
		if(isEmpty(seq))
			gowriteload(seq, "<?=$root?>/Skin/Stock/InStockWrite.php");
		else
			gowriteload(seq, "<?=$root?>/Skin/Stock/InStockDetail.php");
	}
	*/

	function makepage(json)
	{
		var obj = JSON.parse(json);
		console.log(obj);
		if(obj["apiCode"]=="instocklist")
		{
			$("#tbllist tbody").html("");

			var data=etc=origin=maker="";

			if(!isEmpty(obj["list"]))
			{
				$(obj["list"]).each(function( index, value )
				{
					etc = isEmpty(value["whEtc"]) ? "-" : value["whEtc"];
					origin = isEmpty(value["mdOrigin"]) ? "-" : value["mdOrigin"];
					maker = isEmpty(value["mdMaker"]) ? "-" : value["mdMaker"];
					cls = (Number(value["whQty"]) < 0) ? "style='color:#E23D27;font-weight:bold;'" : "";

					data+="<tr style='cursor:pointer;' onclick=\"viewdesc('"+value["seq"]+"')\">";
					data+="<td><a href='javascript:;'>"+value["whCode"]+"</a></td>"; //입고코드
					data+="<td>"+value["whDate"]+"</td>"; //입고코드
					data+="<td>"+value["mdTitle"]+"</td>";//약재명
					data+="<td>"+value["whTitle"]+"</td>"; //약재품명
					data+="<td>"+origin+"</td>"; //원산지
					data+="<td>"+maker+"</td>"; //제조사
					data+="<td "+cls+">"+comma(value["whQty"])+"</td>"; //입고수량
					//data+="<td "+cls+">"+comma(value["whRemain"])+"</td>"; //재고량 
					data+="<td>"+comma(value["whPrice"])+"</td>"; //입고가격
					data+="<td>"+value["whExpired"]+"</td>"; //유통기한
					//data+="<td>"+etc+"</td>"; //납품처
					data+="<td>"+value["mdCode"]+"</td>"; //납품처
					data+="</tr>";
				});
			}
			else
			{
				data+="<tr>";
				data+="	<td colspan='10'><?=$txtdt['1665']?></td>";
				data+="</tr>";
			}

			$("#tbllist tbody").html(data);
			$("#pagecnt").text(comma(obj["tcnt"])+" <?=$txtdt['1019']?>");
			getsubpage("instocklistpage",obj["tpage"], obj["page"], obj["block"], obj["psize"]);
			return false;
		}
	}

	//약재입고 리스트  API 호출
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
	callapi('GET','stock','instocklist',apidata); 
	$("#searchTxt").focus();
</script>
