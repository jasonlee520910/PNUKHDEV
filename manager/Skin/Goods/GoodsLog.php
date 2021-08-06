<?php //제품관리 리스트
$root = "../..";
include_once ($root.'/_common.php');
$pagegroup = "goods";
$pagecode = "goodslog";
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

<div id="pagegroup" value="<?=$pagegroup?>"></div>
<div id="pagecode" value="<?=$pagecode?>"></div>
<input type="hidden" name="modifyAuth" class="" value="<?=$modifyAuth?>">
<input type="hidden" name="apiCode" class="reqdata" value="potupdate">
<textarea name="selworker" rows="10" cols="100%" class="hidden" id="selworkerDiv"></textarea>

<!--// page start -->
<div class="board-view-wrap" id="boardviewDiv">
	<span class="bd-line"></span>
	<table>
		<caption><span class="blind"></span></caption>
		
		<colgroup>
			<col width="13%">
			<col width="23%">
			<col width="13%">
			<col width="23%">
			<col width="13%">
			<col width="23%">
		</colgroup>
		
		<tbody>
			<tr>
				<th><span><?=$txtdt["1038"]?><!-- 기간선택 --></span></th>
				<td class="selperiod" colspan="5"><?=selectperiod()?></td>
			</tr>
			<tr>
				<th>제품종류</th>
				<td><?=selectstatus()?></td>
				<th>구분</th>
				<td colspan="3"><?=selectprogress()?></td>
			</tr>
			<tr>
				<th><span><?=$txtdt["1020"]?><!-- 검색 --></span></th>
				<td colspan="5"><?=selectsearch()?></td>
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
			<?php if($modifyAuth == "true" || $modifyAuth == "admin"){?>
			   <!-- <button type="button" class="btn-blue">
				<span class="modinput_" onclick="location.href='/08_Goods/GoodsRegist.php'">+ <?//=$txtdt["1365"]?>제품등록<!--탕전기 추가 --></span>
				<!-- </button> --> 
			<?php }?>
		</p>
	</div>
	<table id="tbllist" class="tblcss">
		<caption><span class="blind">번호,분류,내용,담당자,등록일,완료예정일,완료일,중요도,상태를 나타내는 이슈관리 테이블 입니다.</span></caption>

		<colgroup>
			<col scope="col" width="7%">
			<!-- <col scope="col" width="7%"> -->
			<col scope="col" width="5%">
			<col scope="col" width="7%">
			<col scope="col" width="12%">
			<col scope="col" width="*">
			<col scope="col" width="10%">
			<col scope="col" width="10%">
			<col scope="col" width="10%">
			<!-- <col scope="col" width="11%"> -->
			<col scope="col" width="11%">
		</colgroup>

		<thead>
			<tr>			
				<th>제품종류</th>
				<th>구분></th>
				<th>주문코드</th>
				<th>품목코드</th>
				<th class="lf">제품명</th>
				<th>직전재고량</th>
				<th>재고추가량</th>
				<th>현재재고량</th>
				<th>등록/수정일</th>
			</tr>
		</thead>

		<tbody>
		</tbody>
	</table>
</div>

<div class="gap"></div>

<!-- s : 게시판 페이징 -->
<div class='paging-wrap' id="potcodelistpage"></div>
<!-- e : 게시판 페이징 -->
<style>
#addgdqty{position:absolute;width:400px;margin:-10px 0 0 -10px;background:#fff;border:3px solid #111;padding:10px;}
#addgdqty dl dt{width:100px;font-size:19px;font-weight:bold;display:inline-block;padding:5px 10px;}
#addgdqty dl dd{display:inline-block;padding:5px 10px;}
#addgdqty dl dd input{font-size:19px;font-weight:bold;}
#addgdqty p{padding:10px 10px;}
#addgdqty p button{margin:0 10px;}
</style>
<script>
	function repageload(){
	console.log("no  repageload ");
	}

	function makepage(json)
	{
		var obj = JSON.parse(json);
		console.log(obj);

		if(obj["apiCode"]=="goodslog")
		{
			var data = "";
			$("#tbllist tbody").html("");
			if(!isEmpty(obj["list"]))
			{
				$(obj["list"]).each(function( index, value )
				{
					data+="<tr id='goods"+value["seq"]+"'>";					
					data+="<td>"+value["gdType"]+"</td>"; //제품종류
					//data+="<td>"+value["gdCategory"]+"</td>"; //제품분류
					data+="<td>"+value["ghType"]+"</td>"; //구분
					data+="<td>"+value["odCodePk"]+"</td>"; //주문코드
					data+="<td>"+value["gdCode"]+"</td>"; //품목코드
					data+="<td class='lf'>"+value["gdName"]+"</td>"; //제품명
					data+="<td>"+value["ghOldqty"]+"</td>"; //직전재고량
					data+="<td>"+value["ghAddqty"]+"</td>"; //재고추가량
					data+="<td>"+value["ghQty"]+"</td>"; //재고량
					//data+="<td>"+value["ghWorkcode"]+"</td>"; //작업코드
					data+="<td>"+value["ghDate"]+"</td>"; //등록.수정일
					data+="</tr>";
				});
			}
			else
			{
				data+="<tr>";
				data+="<td colspan='9'><?=$txtdt['1665']?></td>";
				data+="</tr>";
			}

			$("#tbllist tbody").html(data);

			$("#pagecnt").text(comma(obj["tcnt"])+" <?=$txtdt['1019']?>");
			getsubpage("potcodelistpage",obj["tpage"], obj["page"], obj["block"], obj["psize"]);
			return false;
		}
	}

	//탕전기관리  API 호출
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


		//------------------------------------------------------
		//구분 체크박스 
		//------------------------------------------------------
		var starr=searchStatus.split(",");
		for(var i=0;i<starr.length;i++){
			if(starr[i]!=""){
				$(".searchStatus"+starr[i]).attr("checked",true);
			}
		}
		//------------------------------------------------------

		//------------------------------------------------------
		//분류박스 
		//------------------------------------------------------
		var mtarr=searchMatype.split(",");
		for(var i=0;i<mtarr.length;i++){
			if(mtarr[i]!=""){
				$(".searchMatype"+mtarr[i]).attr("checked",true);
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
		//기간선택 라디오박스 
		//------------------------------------------------------
		var pearr=searchPeriodEtc.split(",");
		for(var i=0;i<pearr.length;i++){
			if(pearr[i]!=""){
				$(".searPeriodEtc"+pearr[i]).attr("checked",true);
			}
		}
		//------------------------------------------------------


		apiOrderData="&sdate="+sdate+"&edate="+edate+"&searchTxt="+(searchTxt)+"&searchStatus="+searchStatus+"&searchProgress="+searchProgress+"&searchMatype="+searchMatype;
	}
	var apidata="page="+page+apiOrderData;
	console.log("apidata     : "+apidata);

	callapi('GET','<?=$pagegroup?>','<?=$pagecode?>',apidata);
	$("#searchTxt").focus();
</script>
