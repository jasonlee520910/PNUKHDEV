<?php //스탭관리
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
<style>
	rd.viewchk input{disabled}
</style>
<div id="pagegroup" value="member"></div>
<div id="pagecode" value="stafflist"></div>
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
				<td><?=selectperiod()?></td>
			</tr>
			<tr>
				<th><span><?=$txtdt["1020"]?><!-- 검색 --></span></th>
				<td><?=selectsearch()?></td>
			</tr>
		</tbody>
	</table>
</div>

<div class="gap"></div>

<!-- <div class="u-tab04"></div> -->

<div class="board-list-wrap">
	<span class="bd-line"></span>
	<div class="list-select">
	<span id="pagecnt" class="tcnt" style="float:left"></span>
		<p class="fl"></p>
		<p class="fr"><button class="btn-blue"><span onclick="viewdesc('add')">+ <?=$txtdt["1184"]?><!-- 스탭등록 --></span></button></p>
	</div>
	<table id="tbllist" class="tblcss">
		<caption><span class="blind">번호,분류,내용,담당자,등록일,완료예정일,완료일,중요도,상태를 나타내는 이슈관리 테이블 입니다.</span></caption>
		<colgroup>
			<col scope="col" width="6%">
			<col scope="col" width="13%">
			<col scope="col" width="8%">
			<col scope="col" width="8%">
			<col scope="col" width="5%">
			<col scope="col" width="8%">
			<col scope="col" width="15%">
			<col scope="col" width="8%">
			<col scope="col" width="">
			<col scope="col" width="8%">
		</colgroup>
		<thead>
			<tr>
				<th>사진/서명<?//=$txtdt["1150"]?><!-- 사원코드 --></th>
				<th><?=$txtdt["1150"]?><!-- 사원코드 --></th>
				<th><?=$txtdt["1193"]?><!-- 아이디 --></th>
				<th><?=$txtdt["1244"]?><!-- 이름 --></th>
				<th><?//=$txtdt["1177"]?>권한</th>
				<th><?=$txtdt["1177"]?><!-- 소속 --></th>
				<th><?=$txtdt["1286"]?><!-- 전화번호 --></th>
				<th><?=$txtdt["1072"]?><!-- 등록일 --></th>
				<th>비고<?//=$txtdt["1072"]?><!-- 등록일 --></th>
				<th><?=$txtdt["1164"]?><!-- 상태 --></th>
			</tr>
		</thead>
		<tbody>
		</tbody>
	</table>
</div>

<div class="gap"></div>

<!-- s : 게시판 페이징 -->
<div class='paging-wrap' id="stafflistpage"></div>
<!-- e : 게시판 페이징 -->


<script>
/*
	//스탭 등록
	function godesc(seq)
	{
		gowriteload(seq, "<?=$root?>/Skin/Member/StaffWrite.php");
	}
*/
	function makepage(json)
	{
		$("#tbllist tbody").html("");
		var obj = JSON.parse(json);
		console.log(obj);
		if(obj["apiCode"]=="stafflist")
		{
			var data=stDepart=stStatus="";

			$("#tbllist tbody").html("");
			if(!isEmpty(obj["list"]))
			{
				$(obj["list"]).each(function( index, value )
				{
					stDepart = memberdepart(value["stDepart"]);
					stStatus = memberstatus(value["stStatus"]);
					if(value["stPhoto"]!="" && value["stPhoto"]!=null){var chk1="checked";}else{var chk1="";}
					if(value["stSignature"]!="" && value["stSignature"]!=null){var chk2="checked";}else{var chk2="";}
					data+="<tr style='cursor:pointer;' onclick=\"viewdesc('"+value["seq"]+"')\">";
					data+="<td class='viewchk'><input type='checkbox' name='' "+chk1+"  onclick='return false;'> / <input type='checkbox' name='' "+chk2+" onclick='return false;'></td>"; //사원코드
					data+="<td>"+value["stStaffid"]+"</td>"; //사원코드
					data+="<td>"+value["stUserid"]+"</td>"; //아이디
					data+="<td>"+value["stName"]+"</td>"; //이름
					data+="<td>"+value["stAuth"]+"</td>"; //권한
					data+="<td>"+stDepart+"</td>"; //소속
					data+="<td>"+value["stMobile"]+"</td>"; //전화번호
					data+="<td>"+value["stDate"]+"</td>"; //등록일
					data+="<td></td>"; //상태
					data+="<td>"+stStatus+"</td>"; //상태
					data+="</tr>";
				});
			}
			else
			{
				data+="<tr>";
				data+="<td colspan='10'><?=$txtdt['1665']?></td>";
				data+="</tr>";
			}

			$("#tbllist tbody").html(data);

			$("#pagecnt").text(comma(obj["tcnt"])+" <?=$txtdt['1019']?>");
			getsubpage("stafflistpage",obj["tpage"], obj["page"], obj["block"], obj["psize"]);
		}
	}

	//스탭 소속 표시
	function memberdepart(depart)
	{
		var carr=["making","decoction","marking","release","manager","sales","marketing","goods","delivery","pharmacy"];
		var txt=cls=departtxt="";
		for(var i=0;i<carr.length;i++)
		{
			if(carr[i]=depart)
			{
				switch(carr[i])
				{
					case "making":txt="<?=$txtdt['1291']?>"/*"조제"*/;cls="r-stat01";break;
					case "decoction":txt="<?=$txtdt['1361']?>"/*"탕전"*/;cls="r-stat02";break;
					case "marking":txt="<?=$txtdt['1467']?>"/*"마킹"*/;cls="r-stat03";break;
					case "release":txt="<?=$txtdt['1391']?>"/*"포장"*/;cls="r-stat04";break;
					case "manager":txt="<?=$txtdt['1080']?>"/*"매니저"*/;cls="r-stat04";break;
					case "sales":txt="<?=$txtdt['1663']?>"/*"영업"*/;cls="r-stat04";break;
					case "marketing":txt="<?=$txtdt['1565']?>"/*"마케팅"*/;cls="r-stat04";break;
					case "goods":txt="약속포장"/*"약속포장"*/;cls="r-stat05";break;//20191004 추가 
					case "delivery":txt="배송"/*"배송"*/;cls="r-stat07";break;//20191004 추가 
					case "pharmacy":txt="수동조제"/*"수동조제"*/;cls="r-stat08";break;//20191004 추가 
					case "pharmacist":txt="한약사"/*"한약사"*/;cls="r-stat15";break;//20200123 추가 

				}
			}
		}
		departtxt+="<span class='r-stat "+cls+"'>"+txt+"</span>";
		return departtxt;
	}

	//스탭 상태
	function memberstatus(status)
	{
		var carr=["confirm","standby","delete","reject","ready"];
		var txt=cls=departtxt=stattxt="";
		for(var i=0;i<carr.length;i++)
		{
			if(carr[i]=status)
			{
				switch(carr[i])
				{
					case "confirm":txt="<?=$txtdt['1185']?>"/*"승인"*/;cls="r-stat08";break;
					case "ready":txt="<?=$txtdt['1185']?>"/*"승인"*/;cls="r-stat08";break;
					case "standby":txt="<?=$txtdt['1055']?>"/*"대기"*/;cls="r-stat12";break;
					case "delete":txt="<?=$txtdt['1360']?>"/*"탈퇴"*/;cls="r-stat00";break;
					case "reject":txt="<?=$txtdt['1318']?>"/*"차단"*/;cls="r-stat07";break;
				}
			}
		}
		departtxt+="<span class='r-stat "+cls+"'>"+txt+"</span>";
		return departtxt;
	}

	function repageload(){
	console.log("no  repageload ");
	}

	//스텝 목록  API 호출
	var hdata=location.hash.replace("#","").split("|");
	console.log("hdata          :"+hdata);   //1,,sdate=&edate=&searchTxt=test&searchStatus=&searchPeriodEtc=
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
		if(sarr4[1]!=undefined)var searchStatus=sarr4[1];
		if(sarr5[1]!=undefined)var searchPeriodEtc=sarr5[1];
		
		$("input[name=sdate]").val(sdate);
		$("input[name=edate]").val(edate);
		$("input[name=searchTxt]").val(decodeURI(searchTxt));
	
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
		//기간선택 라디오박스 
		//------------------------------------------------------
		var pearr=searchPeriodEtc.split(",");
		for(var i=0;i<pearr.length;i++){
			if(pearr[i]!=""){
				$(".searPeriodEtc"+pearr[i]).attr("checked",true);
			}
		}
		//------------------------------------------------------

		apiOrderData="&sdate="+sdate+"&edate="+edate+"&searchTxt="+searchTxt+"&searchStatus="+searchStatus;
	}

	var apidata="page="+page+apiOrderData;
	console.log("apidata     : "+apidata);
	callapi('GET','member','stafflist',apidata);
	$("#searchTxt").focus();

</script>
