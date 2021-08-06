<?php
	$root = "../..";
	$upload=$root."/_module/excel";

	include_once $root."/_common.php";
	include_once $upload."/excelupload.lib.php";

	$pagegroup = "order";
	$pagecode = "orderlist";
?>
<style>
	.matype{padding:2px 10px;border-radius:5px;color:#000;cursor:pointer;font-size:12px;}
	.mtdecoction{background:#2F4254;color:#fff;}
	.mtworthy{background:#77F200;}
	.mtgoods{background:#28C1F2;}
	.mtpill{background:#1616E5;color:#fff;}
	.mtcommercial{background:#C4A1D0;}
	.mtdecoctiongoods{background:#FF0000;color:#fff;}
</style>
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

<!-- 엑셀 업로드 -->
<script  type="text/javascript" src="<?=$root?>/cmmJs/jquery/jquery.form.min.js"></script>
<link rel="stylesheet" media="all" href="<?=$upload?>/excelupload.css" />
<script  type="text/javascript" src="<?=$upload?>/excelupload.js"></script>

<div id="pagegroup" value="<?=$pagegroup?>"></div>
<div id="pagecode" value="<?=$pagecode?>"></div>

<div class="board-view-wrap">
    <span class="bd-line"></span>

	<table>
		<caption><span class="blind"></span></caption>

		<colgroup>
			<col width="20%">
			<col width="30%">
			<col width="20%">
			<col width="30%">
		</colgroup>

		<tbody>
			<tr>
				<th><span><?=$txtdt["1038"]?><!-- 기간선택 --></span></th>
				<td class="selperiod" colspan="3"><?=selectperiod()?></td>
			</tr>
			<tr>
				<th><span><?=$txtdt["1020"]?><!-- 검색 --></span></th>
				<td colspan="3"><?=selectsearch()?></td>
			</tr>
		</tbody>
	</table>
</div>

<div class="gap"></div>

<div class="board-list-wrap">
	<span class="bd-line"></span>

	<div class="list-select">
	<span id="pagecnt" class="tcnt" style="float:left"></span>
			<p class="fr" style="margin-right:10px;">
				<a href="javascript:;" onclick="viewdesc('addg')"><button class="btn-blue" style="background:#5E8E2E;border:1px solid #599704;"><span>+ 사전조제입력<!-- 수기처방입력 --></span></button></a>
			</p>
	</div>

    <table id="orderlisttbl" class="tblcss">
		<caption><span class="blind">번호,분류,내용,담당자,등록일,완료예정일,완료일,중요도,상태를 나타내는 이슈관리 테이블 입니다.</span></caption>

		<colgroup>
			
			<col scope="col" width="9%"> <!-- 20190403 : 주문일 8 에서 7 -->
			<col scope="col" width="10%"><!-- 20190403 : 주문자 10 에서 7 -->
			<col scope="col" width="5%"><!-- 20190403 : 주문자 10 에서 7 -->
			<col scope="col" width="10%"><!-- 20190403 : 주문자 10 에서 7 -->
			<col scope="col" width="6%"><!-- 20190403 : 특기사항 9 에서 16 -->
			<col scope="col" width="">
			<col scope="col" width="6%"> <!-- 20190403 : 첩수 7 에서 6 -->
			<col scope="col" width="6%"> <!-- 20190403 : 조재사 9 에서 7 -->
			<col scope="col" width="6%">
			<col scope="col" width="9%">
			<col scope="col" width="6%"> <!-- 20190403 : 배송요청 8 에서 7 -->
			<!-- <col scope="col" width="12%">20190403 : 조제작업 9 에서 12 -->
		</colgroup>

		<thead>
			<tr>
				<th><?=$txtdt["1304"]?><!-- 주문일 --></th>
				<th><?=$txtdt["1403"]?><!-- 한의원 --></th>
				<th><?=$txtdt["1591"]?><!-- 한의사 --></th>				
				<th><?=$txtdt["1459"]?><!-- 주문자 --></th>
				<th><?=$txtdt["1614"]?><!-- 조제타입 --></th>
				<th><?=$txtdt["1323"]?><!-- 처방명 --></th>
				<th><?=$txtdt["1336"]?><!-- 첩수/팩 --></th>
				<th><?=$txtdt["1290"]?><!-- 조재사 --></th>
				<th>복약지도서 HTML / FILE<!-- 복약지도서 --></th>
				<th><?=$txtdt["1302"]?><!-- 주문상태 --></th>
				<th><?=$txtdt["1107"]?><!-- 배송요청 --></th>
			</tr>
		</thead>

		<tbody>
		</tbody>
    </table>
</div>

<div class="gap"></div>

<!-- s : 게시판 페이징 -->
<div class='paging-wrap' id="orderlistpage"></div>
<!-- e : 게시판 페이징 -->


<script>
function viewstatus(status, statusName)
	{
		var str_html=cls2=cls=data=data2=addstat="";
		var chkstat=status.split("_");
		var substat=chkstat[0];
		var substat2=chkstat[1];
		switch(substat)
		{
		case "preorder":
			cls2="r-stat14";
			cls="alert";
			data="";
			break;
		case "order":
			cls2="r-stat16";
			cls="poplayer";
			data="payment";
			break;
		case "paid":
			cls2="r-stat15";
			cls="statlink";
			data="/application/";
			break;
		case "making":case "decoction":case "marking":case "release":case "goods":case"pill":
			if(substat=="making"){cls2="r-stat09";}
			else if(substat=="decoction"){cls2="r-stat10";}
			else if(substat=="marking"){cls2="r-stat11";}
			else if(substat=="release"){cls2="r-stat12";}
			else if(substat=="goods"){cls2="r-stat13";}
			else if(substat=="pill"){cls2="r-stat06";}
			else{cls2="r-stat16";}
			cls="procwork";
			data=substat;
			data2=substat2;
			break;
		case "done":case "delivery":
			cls2="r-stat13";
			cls="";
			data="";
			break;
		default:
			cls="alert";
			data="";
			break;
		}
		str_html ="<span class='"+cls+" r-stat "+cls2+"' data-bind='"+data+"' data-value='"+data2+"'>"+statusName+"</span>";
		return str_html;
	}
	function orderviewdesc(seq,odStatus, odGoods)
	{
		var hdata=location.hash.replace("#","").split("|");
		var page=hdata[0];
		if(page==undefined){page="";}
		var search=hdata[2];
		if(search==undefined){search="";}
		location.hash=page+"|"+seq+"|"+search+"|"+odStatus+"|"+odGoods;
	}
	function goLayerOrderPillPrint(odCode, medical)
	{
		var chkmedi = $("#tr_"+odCode).data("value");
		console.log();
		if(!isEmpty(chkmedi) && chkmedi == "1")
		{
			alertsign('error',"<?=$txtdt['1835']?>",'','2000'); //등록된 약재가 없습니다. 약재 등록 후 사용하세요!
		}
		else if(checkMedical(medical)==false)
		{
			alertsign('error',"<?=$txtdt['1863']?>",'','2000');//등록된 한의원이 없습니다. 한의원 등록 후 사용하세요!
		}
		else
		{
			var url="/99_LayerPop/layer-orderPillPrint.php?odCode="+odCode;
			viewlayer(url,900,810,"");
		}
	}
	function checkMedical(medical)
	{
		if(medical.indexOf("*") > -1) //포함되어있따면 
		{
			return false;
		}
		
		return true;
	}
	function makepage(json)
	{
		console.log("list makepage ----------------------------------------------- ")
		var obj = JSON.parse(json);
		console.log(obj)
		console.log("apiCode : " + obj["apiCode"])
		console.log("-------------------------------------------------------- ")

		if(obj["apiCode"]=="goodspilllist") //주문리스트
		{
			var data = meName = reName = title = mastaff = dcStaff = inflag = "";
			var chup = '<?=$txtdt["1330"]?>';//첩
			if(!isEmpty(obj["list"]))
			{
				$(obj["list"]).each(function( index, value )
				{
					mastaff = (!isEmpty(value["maStaff"])) ? value["maStaff"] : "<?=$txtdt['1256']?>";
					dcStaff = (!isEmpty(value["dcStaff"])) ? value["dcStaff"] : "<?=$txtdt['1256']?>";

					retitle = "";
					if(value["odOldodcode"]) retitle = '<span style="color:red;"><?=$txtdt["1677"]?></span>';//(재)

					//-----------------------------------------------------------------------------------------------------------------
					//20190624 : 약재가 있는지 없는지 체크 (약재가 없다면 tr에 빨간색 추가 )
					if(!isEmpty(value["noMediBox"]) && value["noMediBox"] == "1")
					{
						data+="<tr id='tr_"+value["odCode"]+"' data-value='"+value["noMediBox"]+"' style='background-color: #FADBD8;'>";
					}
					else
					{
						data+="<tr id='tr_"+value["odCode"]+"' data-value='"+value["noMediBox"]+"'>";
					}
					//-----------------------------------------------------------------------------------------------------------------

					//-----------------------------------------------------------------------------------------------------------------
					//주문일 
					data+="	<td>"+value["odDate"]+"</td>";
					//-----------------------------------------------------------------------------------------------------------------

					//-----------------------------------------------------------------------------------------------------------------
					//한의원					
					data+="	<td ><span class='link' onclick=\"getlayer('layer-hospital','650,370','"+value["miUserid"]+"')\"><span>"+value["miName"]+"</span></span></td>";
					doctor=!isEmpty(value["doctorName"]) ? value["doctorName"] : "";
					//-----------------------------------------------------------------------------------------------------------------
					//한의사
					data+="	<td><span>"+doctor+"</span></td>";
					//-----------------------------------------------------------------------------------------------------------------
					//주문자
					data+="	<td><span>"+value["reName"]+"</span></td>";
					//-----------------------------------------------------------------------------------------------------------------
					//조제타입
					data+="	<td><span class=' matype mtdecoctiongoods' onclick=\"goLayerOrderPillPrint('"+value["odCode"]+"', '"+value["miName"]+"');\">사전(제)</span></td>";
					//-----------------------------------------------------------------------------------------------------------------
					//처방명 
					data+="	<td class='l'><span class='link' onclick=\"orderviewdesc('"+value["seq"]+"','"+value["odStatus"]+"','"+value["odGoods"]+"')\"><span>"+value["odChartPK"]+"  "+value["gGoods"]+retitle+" "+value["odTitle"]+"</span></span></td>";
					//-----------------------------------------------------------------------------------------------------------------
					//첩수/팩수
					data+="	<td>"+(value["odChubcnt"]+chup+"/"+value["odPackcnt"])+"</td>";
					//-----------------------------------------------------------------------------------------------------------------
					//조제사
					data+="	<td><span class='link' onclick=\"chkstatus('"+value["seq"]+"','"+value["odCode"]+"','paid','"+value["odGoods"]+"','"+value["maType"]+"')\">"+mastaff+"</a></td>";
					//-----------------------------------------------------------------------------------------------------------------
					
					//복약지도서 유무 표시
					var htmlchk=filechk="";
					if(value["odAdvice"]!="" && value["odAdvice"]!=null)
					{
						if(value["odAdvice"].substring(0,4)=='&lt;')
						{
							 htmlchk="checked";				
						}
						else if(value["odAdvice"].substring(0,4)=='file' || value["odAdvice"].substring(0,4)=='http')
						{
							 filechk="checked";											
						}
					}
					else
					{
						 htmlchk="";
						 filechk="";
					}			

					data+="	<td><span><input type='checkbox' name='' "+htmlchk+"  onclick='return false;'></span> / <span><input type='checkbox' name='' "+filechk+"  onclick='return false;'></span></td>";
					//-----------------------------------------------------------------------------------------------------------------
					//주문상태 
					if(value["odStatus"]=="done" && !isEmpty(value["deliconfirm"]) && value["deliconfirm"]=="Y")
					{
						data+="	<td><span class='link'>"+viewstatus(value["odStatus"], value["odStatusName"])+"</td>";
					}
					else
					{
						data+="	<td><span class='link' onclick=\"chkstatus('"+value["seq"]+"','"+value["odCode"]+"','"+value["odStatus"]+"','"+value["odGoods"]+"','"+value["maType"]+"')\">"+viewstatus(value["odStatus"], value["odStatusName"])+"</td>";
					}
					//-----------------------------------------------------------------------------------------------------------------
					//배송요청일 (사전조제는 배송요청일이 없음)
					var reDelidate="";
					if(value["reDelidate"]=="-0001.11.30")
					{				
						reDelidate=" - ";					
					}
					else
					{
						reDelidate=value["reDelidate"];
					}
					data+="	<td>"+reDelidate+"</td>";
					//-----------------------------------------------------------------------------------------------------------------
					data+="</tr>";

				});
			}
			else
			{
				data+="<tr>";
				data+="	<td colspan='11'><?=$txtdt['1665']?></td>";
				data+="</tr>";
			}
			//테이블에 넣기
			$("#orderlisttbl tbody").html(data);
			$("#pagecnt").text(comma(obj["tcnt"])+" <?=$txtdt['1019']?>");
			//페이징
			getsubpage("orderlistpage",obj["tpage"], obj["page"], obj["block"], obj["psize"]);
		}
		else if(obj["apiCode"]=="goodssummarypill")
		{
			$("#td_code").text(obj["odCode"]);//주문코드
			$("#odChartPK").html(obj["gGoods"]);//사전 
			$("#td_title").text(obj["odTitle"]);//처방명
			$("#td_ordercnt").text(obj["odPillcapa"]+"g / "+obj["odQty"]+"개");//처방량

			//주문자요청사항 
			$("#td_odRequest").text(obj["odRequest"]);

			//약재량
			var medicapa=!isEmpty(obj["totmedicapa"])?obj["totmedicapa"]:0;
			$("#td_medicapa").text(commasFixed(medicapa)+"g");
			//약미
			var medicnt=!isEmpty(obj["totmedicnt"])?obj["totmedicnt"]:0;
			$("#td_medicnt").text(medicnt);

			$("#tblpill tbody").html("");
			var pillData={};
			var data="";
			if(!isEmpty(obj["pilllist"]))
			{
				var i=j=0;
				var worktxt="";
				//for(i=0;i<len;i++)
				for(i in obj["pilllist"])
				{
					worktxt="";
					var porder=obj["pilllist"][i]["order"];
					var ptype=porder["type"];
					if(ptype!="making")
					{
						var ptypetxt=porder["typetxt"];
						var pname=porder["name"];
						var poutcapa=porder["outcapa"];
						var pwork=porder["order"]["work"];
						console.log(pwork);

						for(j=0;j<pwork.length;j++)
						{
							var pwcode=pwork[j]["code"];
							var pwcodetxt=pwork[j]["codetxt"];
							var pwvalue=pwork[j]["value"];
							var pwvaluetxt=pwork[j]["valuetxt"];
							if(!isEmpty(pwcodetxt) && !isEmpty(pwcode))
							{
								worktxt+=pwcodetxt+" : "+pwvaluetxt+",";
							}
						}

						data+="<tr>";
						data+="<td>"+ptypetxt+"</td>";
						data+="<td class='l'>"+pname+"</td>";
						if(ptype=="packing")
						{
							data+="<td class='r'>"+commasFixed(poutcapa)+"개</td>";
						}
						else
						{
							data+="<td class='r'>"+commasFixed(poutcapa)+"g</td>";
						}
						data+="<td class='l'>"+worktxt+"</td>";
						data+="</tr>";
					}
					
				}
			}
			$("#tblpill tbody").html(data);

			//약재비
			var totmediprice=!isEmpty(obj["totmediprice"])?obj["totmediprice"]:0;
			$("#tot_meditotalprice").text(commasFixed(totmediprice)+"원");


			var today = new Date();
			var yyyy = today.getFullYear();
			var yyyy2 = yyyy-1;


			var odSeq=obj["odSeq"];
			var odCode=obj["odCode"];
			var odStatus=obj["odStatus"];
			var btn_html='<a href="javascript:;" class="cw-btn close" onclick="orderprintclosediv()"><span><?=$txtdt["1595"]?></span></a> ';//닫기

			if(odStatus =="order" || odStatus =="paid")
			{
				var chk=odCode.substring(0,7);
				//ODD2019080512223100001
				//20190805 :: 주문코드를 17자리에서 22자리로 바꿈.. 엑셀로 등록할시에 같은 주문번호가 나옴.
				if(chk == ("ODD"+yyyy) && odCode.length == 22  || chk == ("ODD"+yyyy2) && odCode.length == 22)
				{
					btn_html+='<a href="javascript:;" class="cdp-btn close" id="confirmid" onclick="orderconfirmpill(\''+odSeq+'\');" ><span><?=$txtdt["1656"]?></span></a>';//작업등록
				}
				else
				{
					btn_html+='<a href="javascript:;" class="cdp-btn close" onclick="orderchangepill(\''+odSeq+'\');" ><span><?=$txtdt["1279"]?></span></a>';//작업지시
				}
			}

			$("#btnOPDiv").html(btn_html);  //작업등록버튼 

		}
		else if(obj["apiCode"]=="goodsconfirmpill")
		{
			if(obj["resultCode"]=="200")
			{
					var odCode = obj["odCode"];
				var url="/99_LayerPop/layer-orderPillPrint.php?odCode="+odCode;
				viewlayer(url,900,820,"");
				alertsign('success','<?=$txtdt["1657"]?>','','1500');////작업등록되었습니다
				$("#confirmid").attr("onclick", "orderconfirmpill('"+obj["seq"]+"')");
				$("#confirmid span").text("작업등록");
			}
			else
			{
				alertsign('error',obj["resultMessage"],'','2000');
			}
		}
		else if(obj["apiCode"]=="orderchange")
		{
			var alerttext = "";
			//20191014 : 작업지시 팝업이 닫지 않고 다시 호출 
			if(obj["process"] == "order")
			{
				var odCode=obj["odCode"];
				var matype=obj["odMatype"];
				if(!isEmpty(matype)&&matype=="pill")
				{
					url="/99_LayerPop/layer-orderPillPrint.php?odCode="+odCode;
				}
				else
				{
					url="/99_LayerPop/layer-orderPrint.php?odCode="+odCode;
				}
				
				viewlayer(url,900,820,"");
				alerttext='<?=$txtdt["1541"]?>'; //작업지시 되었습니다.
				alertsign('success',alerttext,'','1500');
			}
			else
			{
				var str='<?=$txtdt["1525"]?>'; //작업이 000되었습니다
				alerttext = str.replace("000", obj["statustxt"]);
				alertsign('success',alerttext,'','1500');

				closediv("viewlayer");

				golist(obj["returnData"]);
			}
		}	
	}

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

		apiOrderData="&sdate="+sdate+"&edate="+edate+"&searchTxt="+encodeURI(searchTxt)+"&searchStatus="+searchStatus+"&searchProgress="+searchProgress+"&searchMatype="+searchMatype;
	}


	var apidata="page="+page+apiOrderData;
	console.log("apidata     : "+apidata);
	callapi('GET','goods','goodspilllist',apidata);
	$("#searchTxt").focus();

</script>