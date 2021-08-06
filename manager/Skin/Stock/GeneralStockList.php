<?php //자재입출고
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
<div id="pagecode" value="genstocklist"></div>

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
		<p class="fr">
			<a href="javascript:;" onclick="viewdetaildesc('add')"><button class="btn-blue"><span>+ <?=$txtdt["1272"]?><!-- 자재입출고 --></span></button></a>
		</p>
	</div>

	<table id="tbllist" class="tblcss">
		<caption><span class="blind"></span></caption>

		<colgroup>
			<col scope="col" width="10%">
			<col scope="col" width="17%">
			<col scope="col" width="10%">
			<col scope="col" width="10%">
			<col scope="col" width="9%">
			<col scope="col" width="8%">
			<col scope="col" width="9%">
			<col scope="col" width="8%">
			<col scope="col" width="">
		</colgroup>

		<thead>
			<tr>
				<th><?=$txtdt["1044"]?><!-- 날자 --></th>
				<th><?=$txtdt["1273"]?><!-- 자재코드 --></th>
				<th><?=$txtdt["1132"]?><!-- 분류 --></th>
				<th><?=$txtdt["1275"]?><!-- 자재품명 --></th>
				<th><?=$txtdt["1288"]?><!-- 제조사 --></th>
				<th><?=$txtdt["1262"]?><!-- 입고량 --></th>
				<th><?=$txtdt["1347"]?><!-- 출고량 --></th>
				<th><?=$txtdt["1054"]?><!-- 담당자 --></th>
				<th><?=$txtdt["1139"]?><!-- 비고 --></th>
			</tr>
		</thead>

		<tbody>
		</tbody>
	</table>
</div>

<div class="gap"></div>

<!-- s : 게시판 페이징 -->
<div class='' id="genstocklistpage"></div>
<!-- e : 게시판 페이징 -->

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
			$("#listdiv").load("<?=$root?>/Skin/Stock/GeneralStockWrite.php?seq="+seq);
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
			gowriteload(seq, "<?=$root?>/Skin/Stock/GeneralStockWrite.php");
		else
			gowriteload(seq, "<?=$root?>/Skin/Stock/GeneralStockDetail.php");
	}
*/
	function makepage(json)
	{
		var obj = JSON.parse(json);
		var in_qty = out_qty = category = "";

		console.log(obj);
		if(obj["apiCode"]=="genstocklist")
		{
			var data="";

			$("#tbllist tbody").html("");
			if(!isEmpty(obj["list"]))
			{
				$(obj["list"]).each(function( index, value )
				{
					category = isEmpty(value["whCategory"])?"-":value["whCategory"];
					in_qty = out_qty = "";
					if(value["whStatus"]=='incoming')
					{
						in_qty = value["whQty"];
						out_qty="";
					}
					if(value["whStatus"]=='outgoing')
					{
						in_qty="";
						out_qty = value["whQty"];
					}
					data+="<tr style='cursor:pointer;' onclick=\"viewdesc('"+value["seq"]+"')\">";
					data+="<td><a href='javascript:;'>"+value["whDate"]+"</a></td>"; //날자
					data+="<td>"+value["whCode"]+"</td>"; //자재코드
					data+="<td>"+category+"</td>"; //분류
					data+="<td>"+value["whTitle"]+"</td>"; //자재품명
					data+="<td>"+value["whMaker"]+"</td>"; //제조사
					data+="<td>"+in_qty+"</td>"; //입고량
					data+="<td>"+out_qty+"</td>"; //출고량
					data+="<td>"+value["whStaff"]+"</td>"; //담당자
					data+="<td>"+value["whMemo"]+"</td>"; //비고
					data+="</tr>";

				});
			}
			else
			{
				data+="<tr>";
				data+="	<td colspan='9'><?=$txtdt['1665']?></td>";
				data+="</tr>";
			}

			$("#tbllist tbody").html(data);

			$("#pagecnt").text(comma(obj["tcnt"])+" <?=$txtdt['1019']?>");
			getsubpage("genstocklistpage",obj["tpage"], obj["page"], obj["block"], obj["psize"]);
			return false;
		}
	}

	//자재입출고 리스트  API 호출
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
	callapi('GET','stock','genstocklist',apidata); 
	$("#searchTxt").focus();

	//상세 내용 출력
	$(".reqsearch").on("click",function()
	{
		var url=getseardata();
		gopage(url);
	});

</script>
