<?php //처방관리>처방관리
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
<div id="pagegroup" value="recipe"></div>
<div id="pagecode" value="generalsclist"></div>

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
		<p class="fr">
			<!-- <a href="PrescriptionWrite.php"><button class="btn-blue"><span>+ 처방추가</span></button></a> -->
		</p>
	</div>

	<table id="tbllist" class="tblcss">
		<caption><span class="blind"></span></caption>

		<colgroup>
			<col scope="col" width="10%">
			<col scope="col" width="10%">
			<col scope="col" width="10%">
			<col scope="col" width="15%">
			<col scope="col" width="">
			<col scope="col" width="5%">
		</colgroup>

		<thead>
			<tr>
				<th><?=$txtdt["1327"]?><!-- 처방일 --></th>
				<th><?=$txtdt["1403"]?><!-- 한의원 --></th>
				<th><?=$txtdt["1414"]?><!-- 환자명 --></th>
				<th><?=$txtdt["1102"]?><!-- 방제명 --></th>
				<th><?=$txtdt["1103"]?><!-- 방제정보 --></th>
				<th><?=$txtdt["1335"]?><!-- 첩수 --></th>
			</tr>
		</thead>
		<tbody>
		</tbody>
	</table>
</div>

<div class="gap"></div>

<!-- s : 게시판 페이징 -->
<div class='' id="generalsclistpage"></div>
<!-- e : 게시판 페이징 -->

<script>
	function repageload(){
	console.log("no  repageload ");
	}


	function makepage(json)
	{
		var obj = JSON.parse(json);
		console.log(obj);

		if(obj["apiCode"]=="generalsclist")
		{
			var data="";

			$("#tbllist tbody").html("");
			if(!isEmpty(obj["list"]))
			{
				$(obj["list"]).each(function( index, value )
				{
					data+="<tr style='cursor:pointer;' onclick=\"viewdesc('"+value["seq"]+"')\">";
					data+="<td>"+value["rcDate"]+"</td>"; //처방일
					data+="<td>"+value["miName"]+"</td>"; //한의원
					data+="<td>"+value["reName"]+"</td>";//환자명
					data+="<td><a href='javascript:;'>"+value["rcTitle"]+"</a></td>"; //방제명
					data+="<td class='l'>"+value["rcMedicineTxt"]+"</td>"; //방제정보
					data+="<td>"+value["odChubcnt"]+"</td>"; //첩수
					data+="</tr>";
				});
			}
			else
			{
				data+="<tr>";
				data+="	<td colspan='6'><?=$txtdt['1665']?></td>";
				data+="</tr>";
			}

			$("#tbllist tbody").html(data);

			$("#pagecnt").text(comma(obj["tcnt"])+" <?=$txtdt['1019']?>");
			//페이지
			getsubpage("generalsclistpage",obj["tpage"], obj["page"], obj["block"], obj["psize"]);
		}
		return false;
	}

	var hdata=location.hash.replace("#","").split("|");
	console.log("hdata    :"+hdata);
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

	callapi('GET','recipe','generalsclist',apidata);
	$("#searchTxt").focus();

</script>
