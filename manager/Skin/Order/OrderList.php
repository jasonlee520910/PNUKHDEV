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
				<th><?=$txtdt["1303"]?><!-- 작업상태별 --></th>
				<td colspan="3"><?=selectstatus()?></td>
			</tr>
			<tr>
				<th><?=$txtdt["1903"]?><!-- 작업진행별 --></th>
				<td><?=selectprogress()?></td>
				<th>주문구분<!-- 주문구분 --></th>
				<td><?=selectmatype()?><!-- 탕제/실속/제환(은 나중에) --></td>
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
			<p class="fr">
				<a href="javascript:;" onclick="viewdesc('add')"><button class="btn-blue"><span>+ <?=$txtdt["1182"]?><!-- 수기처방입력 --></span></button></a>
			</p>
			<p class="fr" style="margin-right:10px;">
				<a href="javascript:;" onclick="viewdesc('addg')"><button class="btn-blue" style="background:#5E8E2E;border:1px solid #599704;"><span>+ 사전조제입력<!-- 수기처방입력 --></span></button></a>
			</p>
			<!-- <p class="fr" style="margin-right:10px;margin-top:8px;">
				<?=excelupload($_COOKIE["ck_language"], $NET_URL_API_MANAGER)?>
			</p> -->
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
	function getDelitied(){
		var odcode=$("#td_code").val();
		alert(odcode);
	}

	function calltbmsapi(type,group,code)
	{
		var language=$("#gnb-wrap").attr("value");
		var timestamp = new Date().getTime();
		if(isEmpty(language)){language="kor";}

		var url=getUrlData("API_TBMS")+group+"/"+code+".php";
		console.log("calltbmsapi  url = " + url);

		switch(type)
		{
		case "GET": case "DELETE":
			url+="?apiCode="+code+"&language="+language;
			data="";
			break;
		case "POST":
			data["apiCode"]=code;
			data["language"]=language;
			break;
		}

		console.log("calltbmsapi url : "+url);
		$.ajax({
			type : type, //method
			url : url,
			data : data,
			success : function (result) {
				console.log("result " + result);
				chkMember(type, result);
			},
			error:function(request,status,error){
				console.log("code:"+request.status+"\n"+"message:"+request.responseText+"\n"+"error:"+error);
			}
	   });
	}
	function linkAddr(){
		var url="https://www.juso.go.kr/";
		window.open(url, "searchaddr", "width=1200,height=800");
	}

	function repageload(){
	console.log("no  repageload ");
	}
	function goLayerOrderPillPrint(odCode, medical)
	{
		var chkmedi = $("#tr_"+odCode).data("value");
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
			viewlayer(url,900,850,"");
		}
	}
	function goLayerOrderPrint(odCode, medical)
	{
		var chkmedi = $("#tr_"+odCode).data("value");
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
			var url="/99_LayerPop/layer-orderPrint.php?odCode="+odCode;
			viewlayer(url,900,850,"");
		}
	}
	function chkstatus(seq,odCode,stat, odGoods, matype)
	{
		var chkmedi = $("#tr_"+odCode).data("value");
		if(!isEmpty(chkmedi) && chkmedi == "1")
		{
			alertsign('error',"<?=$txtdt['1835']?>",'','2000');//등록된 약재가 없습니다. 약재 등록 후 사용하세요!
		}
		else
		{
			//_processing 일때는 중지 못하게 하자 
			if(stat.match("_apply")=="_apply"||stat.match("_start")=="_start")//||stat.match("_processing")=="_processing")
			{
				if(!confirm('<?=$txtdt["1276"]?>')){return;}//작업을 중지하시겠습니까?
				var url=$("#comSearchData").val();

				url+='&seq='+seq;
				var arr=stat.split("_");
				url+='&process='+arr[0];
				if(arr[1]=="apply"||arr[1]=="start")//||arr[1]=="processing")
				{
					url+='&status=stop&statustxt=<?=$txtdt["1315"]?>'; //중지
				}
				else if(arr[1]=="stop")
				{
					url+='&status=cancel&statustxt=<?=$txtdt["1356"]?>';//취소 
				}

				url+='&returnData=<?=$root?>/Skin/Order/OrderList.php';

				console.log("chkstatus  url = " + url);
				callapi('GET','order','orderchange',url);
				viewpage();

			}
			else if(stat.match("_stop")=="_stop")
			{
				if(!confirm('<?=$txtdt["1277"]?>')){return;}//작업을 취소하시겠습니까?
				//취소사유 입력
				var url="/99_LayerPop/layer-cancel.php?seq="+seq+"&status="+stat;
				viewlayer(url,650,400,"");
			}
			else if(stat.match("_cancel")=="_cancel")
			{
				orderviewdesc(seq, stat, odGoods);
			}
			else if(stat=="done")
			{
				if(!confirm('<?=$txtdt["1923"]?>')){return;}//재포장하시겠습니까??
				//취소사유 입력
				var url="/99_LayerPop/layer-cancel.php?seq="+seq+"&status="+stat;
				viewlayer(url,650,400,"");
			}
			else if(stat=="order")
			{
				var url="/99_LayerPop/layer-payment.php?odCode="+odCode;
				viewlayer(url,650,600,"");
			}
			else if(stat=="paid" || stat=="register")
			{
				var url="";
				if(!isEmpty(matype)&&matype=="pill")
				{
					url="/99_LayerPop/layer-orderPillPrint.php?odCode="+odCode;
				}
				else
				{
					url="/99_LayerPop/layer-orderPrint.php?odCode="+odCode;
				}
				viewlayer(url,900,850,"");
			}
			else
			{
				orderviewdesc(seq, stat, odGoods);
			}
		}
	}
	function chkNoMedicine(odCode)
	{
		var chkmedi = $("#tr_"+odCode).data("value");
		if(!isEmpty(chkmedi) && chkmedi == "1")
		{
			alertsign('error',"<?=$txtdt['1835']?>",'','2000'); //등록된 약재가 없습니다. 약재 등록 후 사용하세요!!
		}
	}
	function chkNoMedical(medical)
	{
		if(checkMedical(medical)==false)
		{
			alertsign('error',"<?=$txtdt['1863']?>",'','2000');//등록된 한의원이 없습니다. 한의원 등록 후 사용하세요!
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
	function noneMedicalUpdate(odKeycode, odSite)
	{
		var url="odKeycode="+odKeycode+"&site="+odSite;
		console.log("url = " + url);
		callapi('GET','member','nonemedical',url);
	}
	function viewstatus(status, statusName)
	{
		var str_html=cls2=cls=data=data2=addstat="";
		var chkstat=status.split("_");
		var substat=chkstat[0];
		var substat2=chkstat[1];
		switch(substat)
		{
		case "preorder": case "cancel":
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
		case "register":
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

	//order에서만 사용
	function orderviewdesc(seq,odStatus, odGoods)
	{
		var hdata=location.hash.replace("#","").split("|");
		var page=hdata[0];
		if(page==undefined){page="";}
		var search=hdata[2];
		if(search==undefined){search="";}
		location.hash=page+"|"+seq+"|"+search+"|"+odStatus+"|"+odGoods;
	}
	function CommercialBtn(rmcode,cypk)
	{
		var odkeycode=$("input[name=odKeycode]").val();
		var site=$("input[name=odSitecategoryDiv]").val();
		var title=encodeURIComponent($("#td_title").text());
		var data = "page=1&psize=5&block=10&type=commercial&title="+title+"&cypk="+cypk+"&site="+site+"&odkeycode="+odkeycode;
		url="<?=$root?>/99_LayerPop/layer-goodsmedical.php?"+data;
		viewgoodslayer(url);
		console.log("GoodsBtn  ========================================>>>>>>>>>>>>>  url = " + url);
	}
	function WorthyBtn(rmcode,cypk)
	{
		var odkeycode=$("input[name=odKeycode]").val();
		var site=$("input[name=odSitecategoryDiv]").val();
		var title=encodeURIComponent($("#td_title").text());
		var data = "page=1&psize=5&block=10&type=worthy&title="+title+"&cypk="+cypk+"&site="+site+"&odkeycode="+odkeycode;
		url="<?=$root?>/99_LayerPop/layer-goodsmedical.php?"+data;
		viewgoodslayer(url);
		console.log("GoodsBtn  ========================================>>>>>>>>>>>>>  url = " + url);
	}
	function GoodsBtn(cypk)
	{
		var data="";
		var title=encodeURIComponent($("#td_title").text());
		var site=$("input[name=odSitecategoryDiv]").val();
		var goods=$("input:checkbox[id='goodsDecoction']").is(":checked");
		var type=(goods==false) ? "goods":"decoction";
		data = "page=1&psize=5&block=10&type="+type+"&cypk="+cypk+"&title="+title+"&site="+site;
		url="<?=$root?>/99_LayerPop/layer-goodsmedical.php?"+data;
		viewgoodslayer(url);
		console.log("GoodsBtn  ========================================>>>>>>>>>>>>>  url = " + url);
	}
	function gogoodsscreen(type)
	{
		if(type=="close"){
			$("#goodsscreen").fadeOut(300).remove();
		}else{
			$("#goodsscreen").remove();
			var dh = $(document).height();
			var style="background:#000;filter:alpha(opacity=30);opacity:0.3;position:fixed;top:0;left:0;width:100%;height:"+dh+"px;z-index:4500;";
			var txt="<div id='goodsscreen' style='"+style+"'></div>";
			$("body").prepend(txt);
		}
	}
	function viewgoodslayer(url)
	{
		$("#viewgoodslayer").remove();
		var width=700;
		var height=600;
		var arr=popupcenter(width,height).split("|");
		var top=arr[0];
		var left=arr[1];

		gogoodsscreen('');

		var style="position:fixed;top:0;left:0;z-index:6000;background:#fff;overflow:hidden;";
		style+="display:block;width:"+width+"px;height:"+height+"px;margin:"+top+"px 0 0 "+left+"px;";
		$("body").prepend("<div id='viewgoodslayer' style='"+style+"'></div>");
		$("#viewgoodslayer").load(url);
	}
	//보내는사람 우편번호 
	function ZipCodeBtn(delivery)
	{
		var zipCode=$("input[name=senderZipcode]").val();
		var addr=$("input[name=reSendaddress]").val();
		var sendaddr=addr.split("||");
		if(isEmpty(zipCode))
		{
			alert("우편번호를 입력해 주세요.");
			return;
		}

		if(delivery=="LOGEN" || delivery=="logen")
		{
			if(zipCode.length!=6)
			{
				alert("우편번호를 입력해 주세요.");
				return;
			}
		}

		if(zipCode.indexOf("-")  > -1)//문자열이 있으면
		{
			zipCode=zipCode.replace('-','');				
		}

		var apidata = "odCode="+$("#td_code").text()+"&zipCode="+zipCode+"&address="+sendaddr[0]+"&addressdetail="+sendaddr[1]+"&type=sender"; //receiver 받는사람 //sender 보내는 사람

		console.log("apidata   >>  "+apidata);	
		callapi('GET','order','postupdate',apidata);   //devapi@106.10.37.144:/www/delivery/HPL/getdelicode.php	
	}
    function PostBtn(type)
    {
		var zipCode=$("input[name="+type+"Zipcode]").val();
		var address=$("input[name="+type+"Address]").val();
		var addressdetail=$("input[name="+type+"Addressdetail]").val();
		console.log("zipCode : "+zipCode+", address : "+address+", addressdetail = " + addressdetail);

		$("#"+type+" p").eq(0).attr("onclick","").children("a").children("button").text("<?=$txtdt['1485']?>");
		if(isEmpty(zipCode))
		{
			alert("우편번호를 입력해 주세요.");
			return;
		}
		if(isEmpty(address))
		{
			alert("지번주소를 입력해 주세요.");
			return;
		}
		if(isEmpty(addressdetail))
		{
			alert("상세주소를 입력해 주세요.");
			return;
		}

		if(zipCode.indexOf("-")  > -1)//문자열이 있으면
		{
			zipCode=zipCode.replace('-','');				
		}

		var apidata = "odCode="+$("#td_code").text()+"&zipCode="+zipCode+"&address="+address+"&addressdetail="+addressdetail+"&type="+type; //receiver 받는사람 //sender 보내는 사람

		console.log("apidata   >>  "+apidata);	
		callapi('GET','order','postupdate',apidata);   //devapi@106.10.37.144:/www/delivery/HPL/getdelicode.php		
	}
    function AddrBtn(type, alertchk)
    {
		alertchk=isEmpty(alertchk)?true:alertchk;
		var receiverAddress=$("input[name='receiverAddress']").val();
		var receiverAddrDetail=$("input[name='receiverAddressdetail']").val();
		console.log(receiverAddress +"||"+receiverAddrDetail);

		if(alertchk==true)
		{
			$("#"+type+" p").eq(0).attr("onclick","").children("a").children("button").text("<?=$txtdt['1485']?>");
			if(isEmpty(receiverAddress))
			{
				alert("지번주소를 입력해주세요.");
				return;
			}
			if(isEmpty(receiverAddrDetail))
			{
				alert("상세주소를 입력해 주세요.");
				return;
			}
		}

		var apidata = "odCode="+$("#td_code").text()+"&receiverAddress="+receiverAddress+"&receiverAddrDetail="+receiverAddrDetail; //receiver 받는사람 //sender 보내는 사람
		console.log(" addressupdate    apidata   >>  "+apidata);	
		callapi('GET','order','addressupdate',apidata);   
	}
	function mediboxinfo(title, volume, maxcnt)
	{
		//직배인지체크 
		//사전조제인지 체크 
		var tdDirect=$("input:checkbox[id='tdDirect']").is(":checked");//직배인지 
		var odGoods=$("input[name=odGoods]").val();
		
		console.log("mediboxinfo  title = " + title+", volume = " + volume+",  maxcnt = " + maxcnt+", 직배인지 : " + tdDirect+", odGoods= "+odGoods);
		if(odGoods=="G" || tdDirect==true) //사전조제이면서 직배인지 체크 
		{
		}
		else
		{
			if(!isEmpty(title))
			{
				alertmedibox(title, volume, maxcnt);
			}
		}
	}
	function mediboxinfoupdate()
	{
		var odkeycode=$("input[name=odKeycode]").val();
		var pb_volume=$("input[name=pb_volume]").val();
		var pb_maxcnt=$("input[name=pb_maxcnt]").val();

		if(isEmpty(odkeycode)){alert("주문번호가 없습니다. 확인해 주세요.");return;}
		if(isEmpty(pb_volume) || !isEmpty(pb_volume) && parseInt(pb_volume)==0) {alert("부피를 입력해 주세요.");return;}
		if(isEmpty(pb_maxcnt) || !isEmpty(pb_maxcnt) && parseInt(pb_maxcnt)==0) {alert("최대팩수를 입력해 주세요.");return;}

		var url="odkeycode="+odkeycode+"&pb_volume="+pb_volume+"&pb_maxcnt="+pb_maxcnt;
		console.log("mediboxinfoupdate url = " + url);
		callapi('GET','order','ordermediboxinfoupdate',url);

		//$("#screen1").remove();
		//$("#layermedibox").remove();
	}
	function alertmedibox(title, volume, maxcnt) //error-red,info-blue,warning-yellow,success-green
	{
		$("#screen1").remove();
		$("#layermedibox").remove();

		var w=600;
		var h=200;

		var arr=popupcenter(w,h).split("|");
		var top=arr[0];
		var left=arr[1];

		var txt="한약박스 : "+title+"의 부피,최대팩수가 없습니다.";
		var hh=window.innerHeight;

		var str="<div id='screen1'  style='position:fixed;width:100%;top:0;background:#000;opacity:0.4;height:"+hh+"px; z-index:9999;'></div>";
			str+="<div id='layermedibox' style='position:fixed;top:0;left:0;z-index:10001;overflow:hidden;display:block;width:"+w+"px;height:"+h+"px;margin:"+top+"px 0 0 "+left+"px;padding:25px 15px 15px 15px;background-color:#226A03' class='alert success'>";
			str+="<p style='font-size:20px;font-weight:bold;padding:6px 0 6px 0;'>"+txt+"</p>";
			str+="<p style='font-size:20px;font-weight:bold;padding:6px 0 6px 0;'>입력해 주세요.</p>";
			str+="<p style='font-size:17px;padding:10px 0 10px 0;'>부피 <input type='text' name='pb_volume' class='w20p reqdata' value='"+volume+"' onfocus='this.select();' onchange='changeNumber(event, false);'> 최대팩수 <input type='text' name='pb_maxcnt' class='w20p reqdata' value='"+maxcnt+"' onfocus='this.select();' onchange='changeNumber(event, false);'> </p>";
			str+="<dl class='confirmbtn' style='padding:0 20px 0 0;'><dd onclick='javascript:mediboxinfoupdate();'>적용</dd></dl>"; //확인
			
			str+="</div>";
		$("body").prepend(str);
	}



	function makepage(json)
	{
		console.log("list makepage ----------------------------------------------- ")
		var obj = JSON.parse(json);
		console.log(obj)
		console.log("apiCode : " + obj["apiCode"])
		console.log("-------------------------------------------------------- ")

		if(obj["apiCode"]=="orderlist") //주문리스트
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
					var doctor="";
					if(checkMedical(value["miName"])==false) // 
					{
						data+="	<td><span class='link' onclick=\"chkNoMedical('"+value["miName"]+"')\"><span>"+value["miName"]+"</span></span><button type='button' class='cp-btn' onclick=\"noneMedicalUpdate('"+value["odKeycode"]+"','"+value["odSitecategory"]+"')\" ><span><?=$txtdt['1407']?></span></button></td>";						

						doctor=!isEmpty(value["od_doctorname"]) ? value["od_doctorname"] : value["doctorName"];
					}
					else
					{
						data+="	<td ><span class='link' onclick=\"getlayer('layer-hospital','650,370','"+value["miUserid"]+"')\"><span>"+value["miName"]+"</span></span></td>";
						
						doctor=!isEmpty(value["doctorName"]) ? value["doctorName"] : "";
						
					}
					//-----------------------------------------------------------------------------------------------------------------
					//한의사
					data+="	<td><span>"+doctor+"</span></td>";
					//-----------------------------------------------------------------------------------------------------------------
					//주문자
					data+="	<td><span>"+value["reName"]+"</span></td>";
					//-----------------------------------------------------------------------------------------------------------------
					//조제타입
					if(value["odGoods"]=="G")//사전이면
					{
						if(value["maType"]=="pill")
						{
							data+="	<td><span class=' matype mtdecoctiongoods' onclick=\"goLayerOrderPillPrint('"+value["odCode"]+"', '"+value["miName"]+"');\">사전(제)</span></td>";
						}
						else
						{
							data+="	<td><span class=' matype mtdecoctiongoods' onclick=\"goLayerOrderPrint('"+value["odCode"]+"', '"+value["miName"]+"');\">사전(탕)</span></td>";
						}
					}
					else
					{
						data+="	<td><span class=' matype mt"+value["maType"]+"' onclick=\"goLayerOrderPrint('"+value["odCode"]+"', '"+value["miName"]+"');\">"+value["maTypeName"]+"</span></td>";
					}
					//-----------------------------------------------------------------------------------------------------------------
					//처방명 
					if(checkMedical(value["miName"])==false) //포함되어있따면 
					{
						data+="	<td class='l'><span class='link' onclick=\"chkNoMedical('"+value["miName"]+"')\"><span>"+value["odChartPK"]+"  "+value["gGoods"]+retitle+" "+value["odTitle"]+"</span></span></td>";	
					}
					else
					{
						data+="	<td class='l'><span class='link' onclick=\"orderviewdesc('"+value["seq"]+"','"+value["odStatus"]+"','"+value["odGoods"]+"')\"><span>"+value["odChartPK"]+"  "+value["gGoods"]+retitle+" "+value["odTitle"]+"</span></span></td>";
					}
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
					//한의원이 없는경우
					if(checkMedical(value["miName"])==false) // 
					{
						data+="	<td><button type='button' class='cp-btn' onclick=\"noneMedicalUpdate('"+value["odKeycode"]+"', '"+value["odSitecategory"]+"')\" ><span><?=$txtdt['1407']?></span></button></td>";
					}
					else
					{
						if(value["odStatus"]=="done" && !isEmpty(value["deliconfirm"]) && value["deliconfirm"]=="Y")
						{
							data+="	<td><span class='link'>"+viewstatus(value["odStatus"], value["odStatusName"])+"</td>";
						}
						else
						{
							data+="	<td><span class='link' onclick=\"chkstatus('"+value["seq"]+"','"+value["odCode"]+"','"+value["odStatus"]+"','"+value["odGoods"]+"','"+value["maType"]+"')\">"+viewstatus(value["odStatus"], value["odStatusName"])+"</td>";
						}
						
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
		else if(obj["apiCode"]=="ordersummary")
		{
			var readonly=readonlypouch=readonlybox="";
			

			//200116:상비일경우에만 하기로 (약사님과통화함)
			$("#tdMedi").css("display","none");
			$("#tdMediTitle").css("display","none");
			if(obj["odMatype"]=="commercial")
			{
				$("#tdMedi").css("display","inline-block");
				$("#tdMediTitle").css("display","inline-block");
			}

			$("input[name=odGoods]").val(obj["odGoods"]);
			//사전조제이면 
			if(obj["odGoods"]=="G")
			{
				$("#prttr1").css("display","none");
				$("#prttr2").css("display","none");
				$("#prttr3").css("display","none");
				$("#prttr4").css("display","none");
				$("#prttr5").css("display","none");
				$("#td_deli").css("display","none");
			}

			//조제타입에 따른 작업일지출력을 다르게 하기 위해서 
			if(obj["odMatype"]=="pill")
			{
				$(".printdocument").attr("data-bind","pill");
			}
			else
			{
				$(".printdocument").attr("data-bind","making");
			}
			console.log("bind = "+$(".printdocument").attr("data-bind"));

			if(obj["odStatus"]=="order" || obj["odStatus"]=="paid" || obj["odStatus"]=="register")
			{
				readonly='';
				readonlypouch='';
				readonlybox='';
			}
			else if(obj["odStatus"].substr(0,6)=="making" || obj["odStatus"]=="decoction_apply" || obj["odStatus"]=="decoction_start" || obj["odStatus"]=="decoction_processing")
			{
				readonly='disabled="disabled"';
				readonlypouch='';
				readonlybox='';
			}
			else if(obj["odStatus"]=="decoction_done" || obj["odStatus"].substr(0,7)=="marking" || obj["odStatus"]=="release_apply")//파우치는 탕전완료전까지 수정 가능
			{
				readonly='disabled="disabled"';
				readonlypouch='disabled="disabled"';
				readonlybox='';
			}
			else if(obj["odStatus"]=="release_start" || obj["odStatus"]=="release_processing" || obj["odStatus"]=="release_done")//박스는 포장 시작 전까지 수정가능
			{
				readonly='disabled="disabled"';
				readonlypouch='disabled="disabled"';
				readonlybox='disabled="disabled"';
			}
			else 
			{
				readonly='disabled="disabled"';
				readonlypouch='disabled="disabled"';
				readonlybox='disabled="disabled"';
			}


			var status=status2="";
			if(obj["odStatus"].indexOf("_") != -1)
			{
				var statarr=obj["odStatus"].split("_");
				status=statarr[0];
				status2=statarr[1];
			}
			else
			{
				status=obj["odStatus"];
			}
			console.log("DOO:: status = " + status + ", odStatus:"+obj["odStatus"]+", redelicomp="+obj["reDelicomp"]);
			
			if(obj["odGoods"]=="G")
			{
				$("#reprintDiv").css("display","none");
				$("#directDiv").css("display","none");
				$("#deliveryDiv").css("display","none");
				$("#deliverycntDiv").css("display","none");
			}
			else
			{
				if(status=="making" || status=="decoction" || status=="marking" || status=="release" )
				{
					if(status2!="cancel")
					{
						$("input[name=chkdelicode]").val(obj["chkdelicode"]);
						$("#reprintDiv").css("display","inline-block");

						if(!isEmpty(obj["reDeliexception"]))
						{
							if(obj["reDeliexception"].indexOf("O") != -1 || obj["reDeliexception"].indexOf("T") != -1 || obj["reDeliexception"].indexOf("D") != -1)
							{
								$("#directDiv").css("display","none");
							}
							else
							{
								$("#directDiv").css("display","inline-block");
								$("#directDiv").data("delicode",obj["chkdelicode"]);
								$("#directDiv").data("delicomp",obj["reDelicompName"]);
							}
						}
						else
						{
							$("#directDiv").css("display","none");
						}
					}
					else
					{
						$("#reprintDiv").css("display","none");
						$("#directDiv").css("display","none");
					}
				}
				else
				{
					$("#reprintDiv").css("display","none");
					$("#directDiv").css("display","none");
				}

				//택배변경 버튼, 배송상품정보
				if(obj["odStatus"] =="order" || obj["odStatus"] =="paid" || obj["odStatus"]=="register" || (status=="making"&&status2!="cancel") || (status=="decoction"&&status2!="cancel") || (status=="marking"&&status2!="cancel") )
				{
				
					$("#deliverycntDiv").css("display","inline-block");
					
				}
				else if(status=="release"&&status2!="cancel")
				{
					$("#deliverycntDiv").css("display","inline-block");
				}
				else
				{
					//$("#deliveryDiv").css("display","none");
					$("#deliverycntDiv").css("display","none");
				}
				
			}



			$("input[name=reDelicomp]").val(obj["reDelicomp"]);

			
			$("input[name=rcCode]").val(obj["rcCode"]);//키코드 
			$("input[name=odKeycode]").val(obj["odKeycode"]);//키코드 
			$("#td_code").text(obj["odCode"]);//주문코드
			$("#odChartPK").html(obj["odChartPK"]+" "+obj["gGoods"]);//pk
			$("#td_name").text(obj["miName"]);//한의원
			$("input[name=miGrade]").val(obj["miGrade"]);
			$("#td_title").text(obj["odTitle"]);//처방
			//$("#td_date").text(obj["odDate"]);//주문일자
			var orderCount=!isEmpty(obj["orderCount"])?obj["orderCount"]:"1";
			$("#td_ordercnt").text(orderCount+"개");

			$("input[name=rcMedicine]").val(obj["rcMedicine"]);

			//복약지도서
			if(!isEmpty(obj["odAdvice"]))
			{
				var httpchk=obj["odAdvice"].substring(0, 4);
				if(httpchk=="file" || httpchk=="http" )//http or file/download
				{
					$("#odAdviceDiv").css("display","block");
				}
			}

			$("input[name=dcSugar]").val(obj["dcSugar"]);//감미제 
			$("input[name=dcSpecialPrice]").val(obj["dcSpecialprice"]);//특수탕전비 
			$("input[name=dcSpecialName]").val(obj["dcSpecialName"]);//특수탕전이름




			var reDeliexception=obj["reDeliexception"];
			var oCheck=tCheck=dCheck=mCheck=deliException="";
			$("input[name=reDeliexception]").val(reDeliexception);
			if(!isEmpty(reDeliexception))
			{
				if(reDeliexception.indexOf("O") != -1)
				{
					oCheck="checked";
				}
				if(reDeliexception.indexOf("T") != -1)
				{
					tCheck="checked";
				}
				if(reDeliexception.indexOf("D") != -1)
				{
					dCheck="checked";
				}
			}
			//console.log("reDeliexception = " + reDeliexception+", oCheck = " + oCheck+", tCheck = " + tCheck+", dCheck = " + dCheck);
			var od_goods=obj["odGoods"];
			if(!isEmpty(od_goods) && od_goods=="M")//약재 
			{
				mCheck="checked";
			}
			

			//묶음배송, 해외배송, 직배 작업등록이나 작업지시할때만 가능하게 하고 나머지는 못하게 disabled;
			deliException='disabled="disabled"';
			if(!isEmpty(od_goods) && od_goods=="M")
			{
			}
			else
			{
				if(obj["odStatus"] =="order" || obj["odStatus"] =="paid" || obj["odStatus"] =="register")
				{
					deliException="";
				}
			}
			var tdMedi = "<input type='checkbox' name='tdMedi' id='tdMedi' value='M' "+mCheck+" "+deliException+" onclick='setOrderGoodsMedi()'>";
			$("#tdMedi").html(tdMedi);//약재
			//var tdTied = "<input type='checkbox' name='tdTied' id='tdTied' value='T' "+tCheck+" "+deliException+" onclick='setDeliexception()'>";
			//$("#td_tied").html(tdTied);//묶음배송
			var tdOversea = "<input type='checkbox' name='tdOversea' id='tdOversea' value='O' "+oCheck+"  "+deliException+" onclick='setDeliexception()'>";
			$("#td_oversea").html(tdOversea);//해외배송
			var tdDirect = "<input type='checkbox' name='tdDirect' id='tdDirect' value='D' "+dCheck+"  "+deliException+" onclick='setDeliexception()'>";
			$("#td_direct").html(tdDirect);//직배 

			var td_delivery='<i class="postname">'+obj["reDelicompName"]+'</i>';
			$("#td_delivery").html(td_delivery);//택배회사이름  
			
			$("#td_odRequest").text(obj["odRequest"]);//주문자요청사항 

			$("input[name=reZipDiv]").val(obj["reZipcode"]); //받는사람
			$("input[name=reSendZipDiv]").val(obj["reSendzipcode"]);//보내는사람  


			$("input[name=odSitecategoryDiv]").val(obj["odSitecategory"]);//받는사람 
			$("input[name=odStatusDiv]").val(obj["odStatus"]);//받는사람 
			$("input[name=odCodeDiv]").val(obj["odCode"]);//받는사람 
			$("input[name=odSeqDiv]").val(obj["odSeq"]);//받는사람 


			//보내는사람이름
			var reSendname=obj["reSendname"];
			//받는사람이름
			var reName=obj["reName"];
			//환자명
			var odName=obj["odName"];
			//한의원이름 
			var miName=obj["miName"];


			//보내는사람이름
			$("#sendname").text(reSendname);
			//받는사람이름
			$("#recename").text(reName);
			//환자명
			$("#patientname").text(odName);

			//보내는주소
			var reSendaddress=obj["reSendaddress"];
			//받는주소 
			var reAddress=obj["reAddress"];
			var chartpk=obj["chartpk"];
			var recieveName=obj["recieveName"];

			$("input[name=reAddress]").val(reAddress);//받는주소
			$("input[name=reSendaddress]").val(reSendaddress);//보내는주소  
			$("input[name=chartpk]").val(chartpk);//처방전PK 
			$("input[name=recieveName]").val(recieveName);//cy에서 넘어온 받는사람  


			if(obj["odStatus"] =="order" || obj["odStatus"] =="paid" || obj["odStatus"]=="register")
			{
				if(!isEmpty(obj["odSubjecttype"]))
				{
					$("input[name=subjectRadio]:radio[value="+obj["odSubjecttype"]+"]").prop("checked", true);	
				}
				else
				{
					//0일반 
					$("input[name=subjectRadio]:radio[value=subject0]").prop("checked", true);

					if(miName==reName)//주문자한의원==받는사람한의원
					{
						//1한의원 
						$("input[name=subjectRadio]:radio[value=subject1]").prop("checked", true);
					}

					if(reSendaddress==reAddress) //보내는주소==받는사람주소
					{
						//3환자명(한의원)
						$("input[name=subjectRadio]:radio[value=subject3]").prop("checked", true);
					}

					if(miName==reName && odName!=reName) //주문자한의원==받는사람한의원 && 받는사람!=환자명(개인)
					{
						//2한의원(환자명) 
						$("input[name=subjectRadio]:radio[value=subject2]").prop("checked", true);
					}
				}

				$('input:radio[name="subjectRadio"]:checked').click();
			}
			else
			{	
				if(!isEmpty(obj["odSubjecttype"]))
				{
					$("input[name=subjectRadio]:radio[value="+obj["odSubjecttype"]+"]").prop("checked", true);	
					//$('input:radio[name="subjectRadio"]:checked').click();
				}
				else
				{
					$("input[name=subjectRadio]:radio[value=subject0]").prop("checked", true);
					//$('input:radio[name="subjectRadio"]:checked').click();
				}

				$("input:radio[name=subjectRadio]").attr("disabled",true);
			}
			


			//받는사람  우편번호확인
			var redata=readdr1=readdr2='';
			var readdr=obj["reAddress"].split("||");
			readdr1=readdr[0];
			readdr2=readdr[1];
			console.log("reZipchk_reAaddresschk "+obj["reZipchk"]+"_"+obj["reAaddresschk"]);

			if(obj["reZipchk"]==1 && obj["reAaddresschk"]==1)
			{
				redata+='<span id="receiverzip"><i class="postok">확인완료</i>['+obj["reZipcode"]+']</span> '+readdr1+' '+readdr2;
				$("input[name=receiverchkBtn]").val(1);			
			}
			else
			{
				redata+='	<button class="postbtn postlink" id="postaddrlink" onclick="linkAddr();">주소조회링크</span></button>';		
				if(obj["miDelivery"]=="POST" || obj["miDelivery"]=="post")
				{
					redata+='	<button class="postbtn" id="receiverbtn" onclick="PostBtn(\'receiver\');"><?=$txtdt["1917"]?>확인</span></button>';		
					redata+='<span id="receiverzip">[<input type="text" name="receiverZipcode" value="'+obj["reZipcode"]+'" class="zip">]</span><span id="receiveraddr">'+readdr1+' '+readdr2+'</span>';
				}
				else
				{
					redata+='	<button class="postbtn" id="receiverbtn" onclick="AddrBtn(\'receiver\');"><?=$txtdt["1917"]?>확인</span></button>';	
					redata+='<span id="receiverzip">[<input type="text" name="receiverZipcode" value="'+obj["reZipcode"]+'" class="zip">]</span><span id="receiveraddr">'+readdr1+' '+readdr2+'</span>';
				}
				
			}
			redata+='<input type="text" name="receiverAddress" value="'+readdr1+'" class="address" placeholder="지번주소 입력"><input type="text" name="receiverAddressdetail" value="'+readdr2+'" class="address2" placeholder="상세주소입력">';
			$("#receiver").html(redata); 

			if(obj["reZipchk"]==1 && obj["reAaddresschk"]==1)
			{
				$("input[name=receiverAddress]").css("display","none");
				$("input[name=receiverAddressdetail]").css("display","none");
			}

			//보내는사람  우편번호확인
			var senddata='';
			var sendaddress=obj["reSendaddress"].replace("||"," ");
			if(obj["reSendzipchk"]==1){
				senddata+='<i class="postok">확인완료</i><span id="senderzip">['+obj["reSendzipcode"]+']</span> '+sendaddress+'';
				$("input[name=senderchkBtn]").val(1);			
			}else{
				senddata+='<span id="senderzip">[<input type="text" name="senderZipcode" value="'+obj["reSendzipcode"]+'" class="zip">]</span> '+sendaddress+'';
				senddata+='<input type="hidden" name="reSendaddress" value="'+obj["reSendaddress"]+'">';
				senddata+='	<button class="postbtn"  onclick="ZipCodeBtn(\''+obj["miDelivery"]+'\');"><?=$txtdt["1917"]?>확인</span></button>';				
			}
			$("#sender").html(senddata); //보내는사람 

			var meditotal=!isEmpty(obj["meditotal"])?obj["meditotal"]:0;
			if(isNaN(meditotal)){meditotal=0;}
			$("#sptotmediCapa").text(commasFixed(meditotal));
			$("#sptotsweetCapa").text(commasFixed(obj["sweettotal"]));

			var totmedicnt=parseInt(obj["totMedicine"])+parseInt(obj["totSweet"]);
			$("#td_totMedicine").text(totmedicnt);//약미
			$("#td_totMedicine").data("count", obj["totMedicine"]);
			$("#td_totPoison").text(obj["totPoison"] +" / "+obj["totDismatch"]);//독성/상극

			if(obj["odStatus"]!="making_apply")//조제 대기일때만 수정가능하게 작업
			{
				selworker("div_making", obj["makinglist"], obj["odCode"], obj["maStaffid"], "making", "<?=$txtdt['1256']?>", readonly);
			}
			else
			{
				selworker("div_making", obj["makinglist"], obj["odCode"], obj["maStaffid"], "making", "<?=$txtdt['1256']?>", "");
			}

			//감미제 
			//parseSelectBox("td_sugar","dcSugar", obj["dcSugarList"], obj["dcSugar"], readonly);
			//별전 
			$("input[name=rcSweet]").val(obj["rcSweet"]);
			parseSweetBox("td_sweet","rcSweetDiv", obj["sweetList"], obj["rcSweet"], readonly);
			if(!isEmpty(readonly))
			{
				$("input[name=sweetcnt]").attr("disabled",true);
			}
			


			//파우치
			parsePackSelectBox("td_poutch","odPackType", obj["poutchList"], obj["odPacktype"], obj["mrDescList"], readonlypouch);


			
			//마킹 
			$("input[name=mrDesc]").val(obj["mrDesc"]);
			parsemarkingcodes("markingDiv", obj["mrDescList"], '<?=$txtdt["1077"]?>','mrDesc', 'mrDesc', obj["mrDesc"]);


			//한약박스
			parseSelectBox("td_medibox","reBoxmedi", obj["reBoxmediList"], obj["reBoxmedi"], readonlybox);
			//포장박스 
			parseSelectBox("td_delibox","reBoxdeli", obj["reBoxdeliList"], obj["reBoxdeli"], readonlybox);


			//팩용량 
			$("input[name=odPackcapa]").val(obj["odPackcapa"]);
			if(!isEmpty(readonly))
			{
				$("input[name=odPackcapa]").attr("disabled",true);
			}

			//특수탕전
			$("input[name=dcSpecial]").val(obj["dcSpecial"]);

			//탕전물량 
			var dcwater=!isEmpty(obj["dcWater"])?obj["dcWater"]:0;
			var dcalcohol=!isEmpty(obj["dcAlcohol"])?obj["dcAlcohol"]:0;
			console.log("DOO====>>> dcwater " + dcwater + ", dcalcohol = " + dcalcohol);
			if(isNaN(dcwater)){dcwater=0;}

			if(!isEmpty(dcalcohol)&&parseInt(dcalcohol)>0)
			{
				$("#td_dcAlcohol").show();
				$("#td_alcoholunit").show();
				$("#td_dcWater").text("물 : "+dcwater);
				$("#td_dcAlcohol").text(obj["dcSpecialName"]+" : "+dcalcohol);
			}
			else
			{
				$("#td_dcAlcohol").hide();
				$("#td_alcoholunit").hide();
				$("#td_dcWater").text(dcwater);
			}
			$("input[name=dcWater]").val(dcwater);
			//탕전시간 
			$("input[name=dcTime]").val(obj["dcTime"]);
			//총탕전물량 
			$("input[name=watertotal]").val(obj["watertotal"]);
			console.log("watertotalwatertotalwatertotal == " + obj["watertotal"]);


				

			//첩수 
			$("input[name=odChubcnt]").val(obj["odChubcnt"]);
			//팩수 
			$("input[name=odPackcnt]").val(obj["odPackcnt"]);
			if(!isEmpty(readonly))
			{
				$("input[name=odPackcnt]").attr("disabled",true);
			}

			//조제타입
			$("input[name=odMatype]").val(obj["odMatype"]);

			$("#div_goods").html("");
			var gp_type=obj["gp_type"];//약속처방 탕전이다 
			var gd_code=obj["gd_code"];
			var productCode=obj["productCode"];

			var odGoods=(!isEmpty(obj["odGoods"]) && obj["odGoods"]=="Y") ? "checked":"";
			var wcdisabled=getWcDisabled(status, obj["odCode"]);

			if(obj["odMatype"]=="goods")
			{
				//약속처방 
				if(!isEmpty(gp_type)&&gp_type=="goods")
				{
					$("#div_goods").html("<input type='checkbox' id='goodsDecoction' name='goodsDecoction' value='1' disabled>약속처방 탕전");
					$("input[name=nonegoods]").val(1);
					$("#nonegoods").html("<i class='goodsok'>등록된상품</i>");
				}
				else if(!isEmpty(gp_type)&&gp_type=="decoction")//약속처방탕전
				{
					$("#div_goodsDecoc").hide();
					parseGoodsDecoction("div_goodsDecoc", "gdMarking", obj["goodsDecoList"]);

					$("#div_goods").html("<input type='checkbox' id='wcMarking' name='wcMarking' value='1' "+odGoods+" "+wcdisabled+" onclick='gdMarkingCheck(this, \""+gp_type+"\" )' ><span id='wcMarkingTxt'>사전조제 재고</span> <input type='checkbox' id='goodsDecoction' name='goodsDecoction' value='1' checked  "+wcdisabled+" onclick='goodsDecocCheck(this)' >약속처방 탕전");
					$("input[name=nonegoods]").val(1);
					$("#nonegoods").html("<i class='goodsok'>등록된상품</i>");
				}
				else if(!isEmpty(gp_type)&&gp_type=="marking")//마킹 
				{
					$("#div_goodsDecoc").hide();
					parseGoodsDecoction("div_goodsDecoc", "gdMarking", obj["goodsDecoList"]);

					$("#div_goods").html("<input type='checkbox' id='wcMarking' name='wcMarking' value='1' "+odGoods+" "+wcdisabled+" onclick='gdMarkingCheck(this, \""+gp_type+"\" )' ><span id='wcMarkingTxt'>사전조제 재고</span> <input type='checkbox' id='goodsDecoction' name='goodsDecoction' value='1' "+wcdisabled+" onclick='goodsDecocCheck(this)' >약속처방 탕전");
					$("input[name=nonegoods]").val(1);
					$("#nonegoods").html("<i class='goodsok'>등록된상품</i>");
				}				
				else //미등록된 상품
				{
					$("#div_goodsDecoc").hide();
					parseGoodsDecoction("div_goodsDecoc", "gdMarking", obj["goodsDecoList"]);

					$("#div_goods").html("<input type='checkbox' id='wcMarking' name='wcMarking' value='1' "+odGoods+" "+wcdisabled+" onclick='gdMarkingCheck(this, \""+gp_type+"\" )' ><span id='wcMarkingTxt'>사전조제 재고</span> <input type='checkbox' id='goodsDecoction' name='goodsDecoction' value='1' "+wcdisabled+" onclick='goodsDecocCheck(this)' >약속처방 탕전");
					$("#nonegoods").html('<button class="goodsbtn"  onclick="GoodsBtn(\''+productCode+'\');">미등록된 상품</span></button>');
					$("input[name=nonegoods]").val(0);
				}

				if(!isEmpty(gp_type)&&gp_type=="marking")
				{
					$("#wcMarking").show();
					$("#wcMarkingTxt").show();
					$("#nonegoods").html('');
				}
				else
				{
					var goods=$("input:checkbox[id='goodsDecoction']").is(":checked");
					if(goods==true)
					{
						$("#wcMarking").show();
						$("#wcMarkingTxt").show();
					}
					else
					{
						$("#wcMarking").hide();
						$("#wcMarkingTxt").hide();
					}
				}
			}
			else if(obj["odMatype"]=="commercial")//상비
			{
				if(!isEmpty(gp_type)&&gp_type=="commercial")
				{
					$("#div_goods").html("<input type='checkbox' id='wcMarking' name='wcMarking' value='1' "+odGoods+" "+wcdisabled+" onclick='commMarkingCheck(this)'>상품재고가 있습니다.");
					$("input[name=nonegoods]").val(2);
					$("#nonegoods").html("<i class='goodsok'>등록된상품</i>");
				}
				else
				{
					$("#nonegoods").html('<button class="commercialbtn"  onclick="CommercialBtn(\''+gd_code+'\',\''+productCode+'\');">미등록된 상품</span></button>');
					$("input[name=nonegoods]").val(0);
				}
			}
			else if(obj["odMatype"]=="worthy")//실속
			{
				if(!isEmpty(gp_type)&&gp_type=="worthy")
				{
					$("#div_goods").html("<input type='checkbox' id='wcMarking' name='wcMarking' value='1' "+odGoods+" "+wcdisabled+">상품재고가 있습니다.");
					$("input[name=nonegoods]").val(2);
					$("#nonegoods").html("<i class='goodsok'>등록된상품</i>");
				}
				else
				{
					$("#nonegoods").html('<button class="worthybtn"  onclick="WorthyBtn(\''+gd_code+'\',\''+productCode+'\');">미등록된 상품</span></button>');
					$("input[name=nonegoods]").val(0);
				}

			}
			else if(obj["odMatype"]=="decoction" && obj["odGoods"]!="G")//탕제
			{
				var tmp_type="nonegoods_decoction";
				$("#div_goodsDecoc").hide();
				parseGoodsDecoction("div_goodsDecoc", "gdMarking", obj["goodsDecoList"]);
	
				$("#div_goods").html("<input type='checkbox' id='wcMarking' name='wcMarking' value='1' "+odGoods+" "+wcdisabled+" onclick='gdMarkingCheck(this, \""+tmp_type+"\" )' ><span id='wcMarkingTxt'>사전조제 재고</span>");
				$("input[name=nonegoods]").val(2);

				$("#wcMarking").show();
				$("#wcMarkingTxt").show();
			}


			var osdisabled=getWcDisabled(obj["odStatus"], obj["odCode"]);

			//console.log("osdisabled = " + osdisabled);

			if(osdisabled=="disabled")
			{
				$("#wcMarking").prop("disabled",true);
				$("#goodsDecoction").prop("disabled",true);
				$("input:checkbox[id='tdMedi']").prop("disabled",true);
			}
			else
			{
				if(obj["odStatus"] =="order" || obj["odStatus"] =="paid" || obj["odStatus"]=="register")
				{
					if(!isEmpty(gp_type)&&gp_type=="goods")
					{
						$("#wcMarking").prop("disabled",true);
						$("#goodsDecoction").prop("disabled",true);
					}
					else
					{
						$("#wcMarking").prop("disabled",false);
						$("#goodsDecoction").prop("disabled",false);
					}
				}
				else
				{
					$("#wcMarking").prop("disabled",true);
					$("#goodsDecoction").prop("disabled",true);
				}

				var od_goods=obj["odGoods"];
				if(!isEmpty(od_goods) && od_goods=="M")//약재 
				{
					//사전조제재고 비활성화 
					$("input:checkbox[id='wcMarking']").prop("disabled",true);
					$("input:checkbox[id='wcMarking']").prop("checked",false);
				}
			}


			$("input[name=maPrice]").val(obj["maPrice"]);//maPrice
			$("input[name=dcPrice]").val(obj["dcPrice"]);//dcPrice
			$("input[name=rePrice]").val(obj["rePrice"]);//rePrice

			$("input[name=firstPrice]").val(obj["maFirstprice"]);//maFirstprice
			$("input[name=afterPrice]").val(obj["maAfterprice"]);//maAfterprice

			
			
			//100팩당1박스
			$("input[name=reBox]").val(obj["reBox"]);
			//re_boxmedibox
			$("input[name=reBoxmedibox]").val(obj["reBoxmedibox"]);

			//파우치가격
			$("input[name=odPackprice]").val(obj["odPackprice"]);
			//한약박스가격
			$("input[name=reBoxmediprice]").val(obj["reBoxmediprice"]);
			//포장박스가격 
			$("input[name=reBoxdeliprice]").val(obj["reBoxdeliprice"]);
			//포장비 
			$("input[name=packPrice]").val(obj["rePackingprice"]);

			console.log("ordersummary " + obj["odPackprice"]+", " + obj["reBoxmediprice"]+", " + obj["reBoxdeliprice"]+", "+obj["packPrice"]);



			//약재가 부족할때 
			if(!isEmpty(obj["shortage"]))
			{
				var data="<div class='statlink r-stat r-stat15'><?=$txtdt['1245']?></div>";
				$("#div_shortage").html(data);//약재부족;
			}
			//약재함이 존재하지 않을때 
			if(!isEmpty(obj["mediboxshortage"]))
			{
				var data="<div class='statlink r-stat r-stat15'><?=$txtdt['1708']?></div>";
				$("#div_mediboxshortage").html(data);//약재함이 존재하지 않거나 사용할수 없습니다.
				$("#div_mediboxshortage").attr("data-value", obj["mediboxshortage"].substr(1));
			}

			//등록된 약재가 없을 경우 
			if(!isEmpty(obj["nonemedi"]))
			{
				var data="<div class='statlink r-stat r-stat15'><?=$txtdt['1835']?></div>"; //등록된 약재가 없습니다. 약재 등록 후 사용하세요!
				$("#div_nonemedicine").html(data);
				$("#div_nonemedicine").attr("data-check", "true");
			}

			//주문금액
			$("textarea[name=odAmountdjmedi]").val(obj["odAmountdjmedi"]);
			var adjmedi = JSON.parse(obj["odAmountdjmedi"]);
			//console.log(adjmedi);
			var totalmedicine=adjmedi["totalmedicine"];//약재비 
			var totalpack=adjmedi["totalpack"];//포장비
			var decoctionarr=adjmedi["decoction"].split(",");//탕전비
			var decoction=decoctionarr[2];
			//var makingarr=adjmedi["making"].split(",");//조제비
			var making=adjmedi["making"];
			var releasearr=adjmedi["release"].split(",");//배송비 
			var release=releasearr[2];
			var totalamount=adjmedi["totalamount"];//주문금액
			console.log("release = " + release+", totalamount = " + totalamount);

			var sugaramount=specialamount=0;
			console.log("#####DOO  sugar : "+adjmedi["sugar"]);
			if(!isEmpty(adjmedi["sugar"]))//"교이10bx,540,32,17280"
			{
				var sugararr=adjmedi["sugar"].split(",");
				if(!isEmpty(sugararr[0]))
				{
					sugarname=sugararr[0];
					sugarcapa=!isEmpty(sugararr[1])?parseFloat(sugararr[1]):0;
					sugarprice=!isEmpty(sugararr[2])?parseFloat(sugararr[2]):0;
					sugaramount=!isEmpty(sugararr[3])?parseFloat(sugararr[3]):0;

					console.log("#####DOO  sugaramount : "+sugaramount);
				}
			}
			if(!isEmpty(adjmedi["special"]))
			{
				var specialarr=adjmedi["special"].split(",");//amountdjmedi["special"]=specialName+","+specialAmount;//특수탕전비 
				if(!isEmpty(specialarr[1]))
				{
					console.log("특수탕전비 :: "+ specialarr[1]);
					specialamount=parseFloat(specialarr[1]);//특수탕전비  
				}
			}


			if(isNaN(totalmedicine)){totalmedicine=0;}
			if(isNaN(decoction)){decoction=0;}
			if(isNaN(making)){making=0;}

			if(isNaN(totalpack)){totalpack=0;}
			if(isNaN(release)){release=0;}
			if(isNaN(totalamount)){totalamount=0;}
			if(isNaN(sugaramount)){sugaramount=0;}

			$("#tot_meditotalprice").text(comma(setPriceFloor(totalmedicine))+"<?=$txtdt['1235']?>");//약재비
			$("#tot_sugartotalprice").text(comma(sugaramount)+"<?=$txtdt['1235']?>");//감미제

			console.log("#####DOO  111 sugaramount : "+sugaramount);

			$("#tot_makingtotalprice").text(comma(setPriceFloor(making))+"<?=$txtdt['1235']?>");//조제비

			$("#tot_decoctiontotalprice").text(comma(setPriceFloor(decoction))+"<?=$txtdt['1235']?>");//탕전비
			$("#tot_specialtotalprice").text(comma(setPriceFloor(specialamount))+"<?=$txtdt['1235']?>");//특수탕전비


			$("#tot_packingtotalprice").text(comma(setPriceFloor(totalpack))+"<?=$txtdt['1235']?>");//포장비
			$("#tot_releasetotalprice").text(comma(setPriceFloor(release))+"<?=$txtdt['1235']?>");//배송비
			$("#td_total_price").text(comma(setPriceFloor(totalamount))+"<?=$txtdt['1235']?>");//주문금액


			$("input[name=reZipcode]").val(obj["reZipcode"]);
			$("input[name=reSendzipcode]").val(obj["reSendzipcode"]);


			//한약박스, 배송박스 선택시 
			if(!isEmpty(obj["odStatus"]) && obj["odStatus"] == 'paid' || !isEmpty(obj["odStatus"]) && obj["odStatus"] == 'order')
			{
				changepacktype();
				changepackcodeprint();
				$("input[name=firstChk]").val("1");
			}

			//------------------------------------------
			// 버튼
			//------------------------------------------
			
			//사전조제
			if(obj["odGoods"]=="G")
			{
				$("input[name=senderchkBtn]").val(1);
				$("input[name=receiverchkBtn]").val(1);
			}
			
			setTimeout("workBtn()",100);

			//품질보고서 버튼
			if(obj["odGoods"]=="G" || obj["maTable"]=="00080" || obj["odMatype"]=="goods") //사전조제이거나 수동이거나 약속일 경우에는 안보임 
			{
			}
			else
			{
				if(!isEmpty(obj["odStatus"]) && obj["odStatus"] == 'done')
				{
					btn_html='<a href="javascript:;"><button class="btn-blue" onclick="qareport(\''+obj["odCode"]+'\')"><?=$txtdt["1510"]?><!--품질보고서 --></span></button></a>';//<!-- 품질검수보고서출력 -->
					$("#reportDiv").html(btn_html);

					//btn_html+='<a href="javascript:;"><button class="btn-blue" onclick="qareport2()">QR</span></button></a>';
					//$("#reportDiv").html(btn_html);
				}
			}

			//복약지도서
			var medication_html='<a href="javascript:;" style="margin-right: 10px;" ><button class="btn-blue" style="background:#F781D8;border:1px solid #F781D8;"onclick="medicationreport(\''+obj["odCode"]+'\')"><?=$txtdt["1639"]?><!--복약지도서--></span></button></a>';
			$("#medicationDiv").html(medication_html);


			//한약박스 정보
			console.log("pb_medichk = " + obj["pb_medichk"]);
			if(!isEmpty(obj["pb_medichk"]) && obj["pb_medichk"]=="false")
			{
				setTimeout(function(){mediboxinfo(obj["pb_title"],obj["pb_volume"],obj["pb_maxcnt"]);}, 100);
			}
		}
		else if (obj["apiCode"]=="postupdate") //  postupdate new 우편번호 적용
		{
			if(obj["resultCode"] == "200")
			{
				var type=obj["type"];
				var zipcode="<i class='postok'>확인완료</i>["+obj["zipcode"]+"]";
				console.log(zipcode);
				$("#"+type+"zip").html(zipcode);
				$("#"+type+"addr").text(obj["re_address"]);
				$("input[name="+type+"chkBtn]").val(1);
				$("input[name="+type+"chkBtn]").val(1);
				if(type=="receiver")$("input[name=reZipcode]").val(zipcode);
				if(type=="sender")$("input[name=reSendzipcode]").val(zipcode);
				$("#"+type+"btn").css("display","none");
				$("#postaddrlink").css("display","none");
				$("input[name=receiverAddress]").css("display","none");
				$("input[name=receiverAddressdetail]").css("display","none");
				setTimeout("workBtn()",100);
			}
			else
			{			
				console.log("우편번호를 확인해주세요1");
				alertsign("warning", "우편번호를 확인해 주세요.", "", "1500"); //우편번호를 확인해주세요
			}
			return false;
		}
		else if (obj["apiCode"]=="addressupdate") //  addressupdate 지번주소 적용
		{
			if(obj["resultCode"] == "200" && (obj["readdresschk"]==1 || obj["readdressexception"]!="N"))
			{
				var zipcode="<i class='postok'>확인완료</i>["+obj["zipcode"]+"]";
				console.log(zipcode);
				$("#receiverzip").html(zipcode);
				$("#receiveraddr").text(obj["re_address"]);
				$("input[name=reZipcode]").val(zipcode);
				$("input[name=receiverchkBtn]").val(1);
				$("#receiverbtn").css("display","none");
				$("#postaddrlink").css("display","none");
				$("input[name=receiverAddress]").css("display","none");
				$("input[name=receiverAddressdetail]").css("display","none");
				setTimeout("workBtn()",100);
			}
			else
			{
				var redata=readdr1=readdr2='';
				var readdr=obj["reAddress"].split("||");
				readdr1=readdr[0];
				readdr2=readdr[1];
				redata='	<button class="postbtn postlink" id="postaddrlink" onclick="linkAddr();">주소조회링크</span></button>';				
				redata+='	<button class="postbtn" id="receiverbtn" onclick="AddrBtn(\'receiver\');"><?=$txtdt["1917"]?>확인</span></button>';				
				redata+='<span id="receiverzip">[우편번호]</span><span id="receiveraddr">'+readdr1+' '+readdr2+'</span><br><input type="text" name="receiverAddress" value="'+readdr1+'" class="address" placeholder="지번주소 입력"><input type="text" name="receiverAddressdetail" value="'+readdr2+'" class="address2" placeholder="상세주소입력">';
				$("#receiver").html(redata);
				console.log("지번 주소를 다시 확인해주세요1");
				alertsign("warning", "<?=$txtdt['1919']?>", "", "1500"); //지번 주소를 다시 확인해주세요
			}
			return false;
		}
		else if(obj["apiCode"]=="workerchange")
		{
			var stname = isEmpty(obj["stName"]) ? "<?=$txtdt['1256']?>" : obj["stName"];
			var stNamehtml = "<span class='link' onclick=\"chkstatus('"+obj["odSeq"]+"','"+obj["odCode"]+"','paid', '"+obj["odGoods"]+"','"+obj["maType"]+"')\">"+stname+"</a>";

			if(obj["depart"] == "making")
				$("#orderlisttbl tbody #tr_" + obj["odCode"]+" td:eq(7)").html(stNamehtml);
			//else if(obj["depart"] == "decoction")
			//	$("#orderlisttbl tbody #tr_" + obj["odCode"]+" td:eq(6)").html(stNamehtml);
			return false;
		}
		else if(obj["apiCode"]=="medicaldesc")
		{

			$("#h2_name").text(obj["miName"]);
			$("#td_name").text(obj["miName"]);

			$("#td_bno").text(obj["miBusinessNo"]);
			var email = !isEmpty(obj["miEmail"]) ? obj["miEmail"] : "-";
			$("#td_email").text(email);

			//원장 
			var persion="-";
			$(obj["member"]).each(function( index, value )
			{
				if(value["meGrade"] == 30)
				{
					persion=value["meName"];
				}
			});
			$("#td_staff").text(persion);

			var miFax = (!isEmpty(obj["miFax0"])) ? (obj["miFax0"]+"-"+obj["miFax1"]+"-"+obj["miFax2"]) : "-";
			var miPhone = (!isEmpty(obj["miPhone0"])) ? (obj["miPhone0"]+"-"+obj["miPhone1"]+"-"+obj["miPhone2"]) : "-";
			var phone = "";
			phone+='<span class="cblue">Tel</span>.'+miPhone;
			phone+=' / <span class="cgreen">Fax</span>.'+miFax;

			$("#td_phone").html(phone);
			var add1 = (!isEmpty(obj["miAddress"])) ? obj["miAddress"] : "";
			var add2 = (!isEmpty(obj["miAddress1"])) ? obj["miAddress1"] : "";
			var addr = '['+obj["miZipcode"]+'] '+add1 + ' '+ add2;
			$("#td_addr").text(addr);
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
				
				viewlayer(url,900,850,"");
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
		/*else if(obj["apiCode"]=="orderconfirmpill")
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
		}*/
		else if(obj["apiCode"]=="orderconfirm")
		{
			if(obj["resultCode"]=="200")
			{
				var odCode = obj["odCode"];
				var url="/99_LayerPop/layer-orderPrint.php?odCode="+odCode;
				viewlayer(url,900,850,"");
				alertsign('success','<?=$txtdt["1657"]?>','','1500');////작업등록되었습니다
				//$("input:checkbox[id='goodsDecoction']").attr("disabled", ture);

				$("#confirmid").attr("onclick", "orderconfirm('"+obj["seq"]+"')");
				$("#confirmid span").text("작업등록");

			}
			else
			{
				if(obj["resultMessage"]=="ERR_NOT_PRODUECTCODE")
				{
					alertsign('error','매칭할 상품코드가 없습니다.','','2000');
				}
				else if(obj["resultMessage"]=="ERR_NOT_ORDERCOUNT")
				{
					alertsign('error','약속 처방 갯수가 없습니다.','','2000');
				}
				else if(obj["resultMessage"]=="ERR_NOT_GDCODE")
				{
					alertsign('error','매칭된 상품이 없습니다.','','2000');
				}
				else if(obj["resultMessage"]=="ERR_NOT_GDQTY")
				{
					alertsign('error','매칭된 상품의 재고가 없습니다.','','2000');
				}
				else if(obj["resultMessage"]=="ERR_NOT_GDCODE_MARKING")
				{
					alertsign('error','등록된 상품이 없습니다.','','2000');
				}
				else if(obj["resultMessage"]=="ERR_NOT_GDBOMCODE")
				{
					alertsign('error','매칭된 상품의 구성요소가 없습니다.','','2000');
				}
				else if(obj["resultMessage"]=="ERR_NOT_MEDICINE")
				{
					alertsign('error','매칭된 상품의 약재가 없습니다.','','2000');
				}
				else if(obj["resultMessage"]=="ERR_NOT_CHUBCNT")
				{
					alertsign('error','매칭된 상품의 첩수가 없습니다.','','2000');
				}
				else if(obj["resultMessage"]=="ERR_NOT_PACKCNT")
				{
					alertsign('error','매칭된 상품의 팩수가 없습니다.','','2000');
				}
				else if(obj["resultMessage"]=="ERR_NOT_RCPACKTYPE")
				{
					alertsign('error','매칭된 상품의 파우치가 없습니다.','','2000');
				}
				else if(obj["resultMessage"]=="ERR_NOT_PACKCAPA")
				{
					alertsign('error','매칭된 상품의 팩용량이 없습니다.','','2000');
				}
				else if(obj["resultMessage"]=="ERR_NOT_RCMEDIBOX")
				{
					alertsign('error','매칭된 상품의 한약박스가 없습니다.','','2000');
				}
				else if(obj["resultMessage"]=="ERR_NOT_DATA_CHUBCNT")
				{
					alertsign('error','첩수가 없습니다.','','2000');
				}
				else if(obj["resultMessage"]=="ERR_NOT_DATA_PACKCNT")
				{
					alertsign('error','팩수가 없습니다.','','2000');
				}
				else if(obj["resultMessage"]=="ERR_NOT_DATA_RCPACKTYPE")
				{
					alertsign('error','파우치가 없습니다.','','2000');
				}
				else if(obj["resultMessage"]=="ERR_NOT_DATA_PACKCAPA")
				{
					alertsign('error','팩용량이 없습니다.','','2000');
				}
				else if(obj["resultMessage"]=="ERR_NOT_DATA_RCMEDIBOX")
				{
					alertsign('error','한약박스가 없습니다.','','2000');
				}
				$("#confirmid").attr("onclick", "orderconfirm('"+obj["seq"]+"')");
				$("#confirmid span").text("작업등록");

			}
		}
		else if(obj["apiCode"]=="paymentdesc")
		{
			var data="";

			$("#seq").val(obj["seq"]);
			$("#odPayinfo").val(obj["odPayinfo"]);
			$("#odPayamount").val(obj["odPayamount"]);

			data="<b>"+obj["odCode"]+"</b>";
			$("#odCode").html(data);

			data="["+obj["reName"]+"] "+obj["odTitle"];
			$("#reName").text(data);

			data=obj["odPacktype"]+", "+obj["odPackcnt"]+"<?=$txtdt['1604']?>";
			$("#odPacktype").text(data);
			$("#reAddress").text(obj["reAddress"]);

			$("#odAmount").text(comma(obj["odAmount"]));


			parseradiocodes("odStatusDiv", obj["odStatusList"], '<?=$txtdt["1302"]?>', "odStatus", "delitype-list", obj["odStatus"]);
			parseradiocodes("odPaytypeDiv", obj["odPaytypeList"], '<?=$txtdt["1517"]?>', "odPaytype", "delitype-list", obj["odPaytype"]);

		}
		else if(obj["apiCode"]=="ordercanceltype")
		{
			parsecodes("canceltypeDiv", obj["cancelTypeList"], '<?=$txtdt["1670"]?>', 'cancelType', 'cancelType', 'cpacking', '', '');
		}
		else if(obj["apiCode"] == "nonemedical") //한의원 등록되었는지 체크하고 등록되었으면 업데이트, 아니면 메세지 
		{
			if(obj["resultCode"]=="388" && obj["resultMessage"] == "POP_MEDICAL")//한의원리스트 보여주자 
			{
				getlayer('layer-member','600,550',"page=1&psize=5&block=10&site="+obj["odSite"]+"&od_medicalname="+encodeURIComponent(obj["od_medicalname"])+"&od_doctorname="+encodeURIComponent(obj["od_doctorname"])+"&od_doctorpk="+obj["od_doctorpk"]+"&od_keycode="+obj["od_keycode"]);
			}
			else if(obj["resultCode"]=="389" && obj["resultMessage"] == "NONE_MEDICAL") //한의원이 등록 안되어있다. 
			{
				alertsign('error',"<?=$txtdt['1863']?>",'','2000');//등록된 한의원이 없습니다. 한의원 등록 후 사용하세요!
			}
			else if(obj["resultCode"]=="398" && obj["resultMessage"] == "NONE_ORDER") //주문번호를 확인해 주세요.
			{
				alertsign("error", "<?=$txtdt['1838']?>", "", "2000");//주문번호가 존재하지 않습니다. 확인해 주세요.
			}
			else if(obj["resultCode"]=="381" && obj["resultMessage"] == "ADD_CLIENT_MEMBER") //주문번호를 확인해 주세요.
			{
				alertsign("error", "매칭된 PK가 있습니다. 한의사를 새로 등록해 주세요.", "", "2000");//주문번호가 존재하지 않습니다. 확인해 주세요.
			}
			else if(obj["resultCode"]=="381" && obj["resultMessage"] == "ADD_OK_MEMBER") //주문번호를 확인해 주세요.
			{
				alertsign("error", "매칭된 엑셀 PK가 있습니다. 한의사를 새로 등록해 주세요.", "", "2000");//주문번호가 존재하지 않습니다. 확인해 주세요.
			}
			else if(obj["resultCode"]=="200" && obj["resultMessage"] == "OK")
			{
				alertsign("info", "<?=$txtdt['1864']?>", "", "2000");//'한의원이 등록되었습니다.'
				viewpage();
			}
		}
		else if(obj["apiCode"] == "memberlist")
		{
			var data = "";

			$("#pop_medicaltbl tbody").html("");
			if(!isEmpty(obj["list"]))
			{
				$(obj["list"]).each(function( index, value )
				{
					data+='<tr class="putpopdata" onclick="javascript:putpopdata(this);" data-doctorid="'+value["me_userid"]+'">';
					data+='<td class="l">'+value["mi_name"]+'</td>';
					data+='<td>'+value["me_name"]+'</td>';
					data+='<td>'+value["me_auth"]+'</td>';
					data+='<td>'+value["me_idpk"]+'</td>';
					
					data+='</tr>';
				});
			}
			else
			{
				data+="<tr>";
				data+="	<td colspan='4'><?=$txtdt['1665']?></td>";
				data+="</tr>";
			}

			//한의원리스트
			$("#pop_medicaltbl tbody").html(data);

			//페이징
			getsubpage_pop("medicallistpage",obj["tpage"], obj["page"], obj["block"], obj["psize"]);
		}
		else if(obj["apiCode"] == "setordergoods")
		{
			$("input[name=odGoods]").val(obj["odGoods"]);

			if(obj["odGoods"]=="M")
			{
				//사전조제재고 비활성화 
				$("input:checkbox[id='wcMarking']").prop("disabled",true);
				$("input:checkbox[id='wcMarking']").prop("checked",false);
			}
			else
			{
				//사전조제재고 활성화 
				$("input:checkbox[id='wcMarking']").prop("disabled",false);
				$("input:checkbox[id='wcMarking']").prop("checked",false);
			}
			//AddrBtn('receiver', false);
		}
		else if(obj["apiCode"] == "setdeliexception")
		{
			$("input[name=reDeliexception]").val(obj["re_deliexception"]);
			//AddrBtn('receiver', false);
		}
		else if(obj["apiCode"]=="goodsgoodslist")//약속처방 제품
		{
			var data = "";
			$("#pop_goodstbl tbody").html("");
			if(!isEmpty(obj["list"]))
			{
				$(obj["list"]).each(function( index, val )
				{
					data+="<tr class='putpopdata' onclick='javascript:putpopdata(this);' id='goods"+val["seq"]+"' data-seq='"+val["seq"]+"' title='"+val["gdGoodsTxt"]+"'>";
					data+="<td>"+val["gdCypk"]+"</td>"; //cyPK 
					data+="<td>"+val["gdCode"]+"</td>"; //제품코드
					data+="<td>"+val["gdName"]+"</td>"; //제품명
					data+="<td>"+val["gdBom"]+"</td>"; ///구성
					data+="</tr>";
				});
			}
			else
			{
				data+="<tr>";
				data+="<td colspan='4'><?=$txtdt['1665']?></td>";
				data+="</tr>";
			}

			$("#pop_goodstbl tbody").html(data);

			getsubpage_pop("goodslistpage",obj["tpage"], obj["page"], obj["block"], obj["psize"], obj["reData"]);
		}
		else if(obj["apiCode"]=="nonegoods")
		{
			if(obj["resultCode"] == "200")
			{
				$("#nonegoods").html("<i class='goodsok'>등록된상품</i>");
				$("input:checkbox[id='goodsDecoction']").attr("disabled", true);
				$("input:checkbox[id='wcMarking']").attr("disabled", true);
				$("input[name=nonegoods]").val(1);
				setTimeout("workBtn()",100);
			}
			else
			{
				alertsign("warning", "매칭에 실패하였습니다. 확인해주세요.", "", "1500");
			}
		}
		else if(obj["apiCode"]=="recipemedicallist")//약속처방 탕전 , 상비 
		{
			var data = "";
			$("#pop_goodstbl tbody").html("");
			if(!isEmpty(obj["list"]))
			{
				$(obj["list"]).each(function( index, val )
				{
					data+="<tr class='putpopdata' onclick='javascript:putpopdata(this);' id='goods"+val["seq"]+"' data-seq='"+val["seq"]+"' title='"+val["rcMedicineTxt"]+"'>";
					data+="<td>"+val["rcSource"]+"</td>"; //cyPK 
					data+="<td>"+val["rcCode"]+"</td>"; //제품코드
					data+="<td class='l'>"+val["rcTitle"]+"</td>"; //제품명
					data+="<td>"+val["rcMedicineCnt"]+"</td>"; ///구성
					data+="</tr>";
				});
			}
			else
			{
				data+="<tr>";
				data+="<td colspan='4'><?=$txtdt['1665']?></td>";
				data+="</tr>";
			}

			$("#pop_goodstbl tbody").html(data);

			getsubpage_pop("goodslistpage",obj["tpage"], obj["page"], obj["block"], obj["psize"], obj["reData"]);
		}
		else if(obj["apiCode"]=="nonerecipemedical")
		{
			if(obj["resultCode"] == "200")
			{
				$("#nonegoods").html("<i class='goodsok'>등록된상품</i>");
				$("input:checkbox[id='goodsDecoction']").attr("disabled", false);
				$("input:checkbox[id='wcMarking']").attr("disabled", false);
				$("input[name=nonegoods]").val(1);
				setTimeout("workBtn()",100);
			}
			else
			{
				alertsign("warning", "매칭에 실패하였습니다. 확인해주세요.", "", "1500");
			}
		}
		else if(obj["apiCode"]=="nonecommercial")
		{
			if(obj["resultCode"] == "200")
			{
				$("#nonegoods").html("<i class='goodsok'>등록된상품</i>");
				$("#div_goods").html("<input type='checkbox' id='wcMarking' name='wcMarking' value='1' "+odGoods+" "+wcdisabled+" onclick='commMarkingCheck(this)'>상품재고가 있습니다.");
				$("input:checkbox[id='wcMarking']").prop("disabled",false);
				$("input:checkbox[id='wcMarking']").prop("checked",false);
				$("input[name=nonegoods]").val(2);
				setTimeout("workBtn()",100);
			}
			else
			{
				alertsign("warning", "매칭에 실패하였습니다. 확인해주세요.", "", "1500");
			}
		}
		else if(obj["apiCode"]=="deliverydirectupdate")
		{
			if(obj["resultCode"] == "200")
			{
				$("input[name=reDeliexception]").val(obj["reDeliexception"]);
				var td_delivery='<i class="postname">직배</i>';
				$("#td_delivery").html(td_delivery);//택배회사이름  
				$('input:checkbox[id="tdDirect"]').attr("checked", true); //단일건
				$("#directDiv").css("display", "none");
				alertsign('warning','직배로 변경하였습니다.','','2000');
			}
			else
			{
				alertsign("warning", "직배변경에 실패하였습니다.", "", "1500");
			}
		}
		else if(obj["apiCode"]=="deliverychangeupdate")
		{
			if(obj["resultCode"] == "200")
			{
				var td_delivery='<i class="postname">'+obj["delicompName"]+'</i>';
				$("#td_delivery").html(td_delivery);//택배회사이름  
				$("#senderzip").text('['+obj["re_sendzipcode"]+']');
				$("#receiverzip").html('<i class="postok">확인완료</i>['+obj["re_zipcode"]+']');

				$("input[name=reDelicomp]").val(obj["delicompchange"]);
				$("#deliveryDiv").data("delicode",obj["chkdelicode"]);
				$("#deliveryDiv").data("delicomp",obj["delicompchange"]);
				if(obj["delicompchange"].toUpperCase()=="LOGEN")
				{
					$("#deliveryDiv").data("delicompchange","POST");
				}
				else if(obj["delicompchange"].toUpperCase()=="POST")
				{
					$("#deliveryDiv").data("delicompchange","LOGEN");
				}



				alertsign('warning',obj["delicompName"]+'으로 변경하였습니다.','','2000');
			}
			else
			{
				if(obj["resultCode"] == "399" || obj["resultCode"] == "398" || obj["resultCode"] == "397")
				{
					alertsign("warning", obj["resultMessage"], "", "1500");
				}
				else
				{
					alertsign("warning", "택배변경에 실패하였습니다.", "", "1500");
				}	
			}
		}
		else if(obj["apiCode"]=="ordergoodsdecocupdate")//사전조제재고 선택시 
		{
			//파우치 사전조재 추가 
			setPoutchMedibox(obj);
		}
		else if(obj["apiCode"]=="ordergoodscommercialupdate")//상품재고가 있습니다. 선택시 
		{
			//파우치 사전조재 추가 
			setPoutchMedibox(obj);
			/*
			var opprice=opcode=opcapa="";
			if(!isEmpty(obj["odPacktype"]))
			{
				opprice=" data-priceA="+obj["odPacktype"]["pb_priceA"]+" data-priceB="+obj["odPacktype"]["pb_priceB"]+" data-priceC="+obj["odPacktype"]["pb_priceC"]+" data-priceD="+obj["odPacktype"]["pb_priceD"]+"  data-priceE="+obj["odPacktype"]["pb_priceE"];
				opcode=" data-codeonly="+obj["odPacktype"]["pb_codeonly"];
				opcapa=" data-capa="+obj["odPacktype"]["pb_capa"];

				$("#odPackType option:eq(0)").after("<option value='"+obj["odPacktype"]["pb_code"]+"' "+opcapa+" "+opprice+" "+opcode+">"+obj["odPacktype"]["pb_title"]+"</option>");


				$("#odPackType option:eq(1)").prop("selected", true);
				$("#odPackType").change();
			}
			else
			{
				$("#odPackType option:eq(1)").remove();
				$("#odPackType option:eq(0)").prop("selected", true);
				$("#odPackType").change();
			}

			if(!isEmpty(obj["reBoxmedi"]))
			{
				//한약박스 사전조재 추가 
				opprice=" data-priceA="+obj["reBoxmedi"]["pb_priceA"]+" data-priceB="+obj["reBoxmedi"]["pb_priceB"]+" data-priceC="+obj["reBoxmedi"]["pb_priceC"]+"data-priceD="+obj["reBoxmedi"]["pb_priceD"]+" data-priceE="+obj["reBoxmedi"]["pb_priceE"];
				opcode=" data-codeonly="+obj["reBoxmedi"]["pb_codeonly"];
				opcapa=" data-capa="+obj["reBoxmedi"]["pb_maxcnt"];
				opvolcnt=" data-volcnt="+obj["reBoxmedi"]["pb_volume"]+"|"+obj["reBoxmedi"]["pb_maxcnt"];
				$("#reBoxmedi option:eq(0)").after("<option value='"+obj["reBoxmedi"]["pb_code"]+"' "+opcapa+" "+opvolcnt+" "+opprice+" "+opcode+">"+obj["reBoxmedi"]["pb_title"]+"</option>");

				$("#reBoxmedi option:eq(1)").prop("selected", true);
				$("#reBoxmedi").change();
			}
			else
			{
				$("#reBoxmedi option:eq(1)").remove();
				$("#reBoxmedi option:eq(0)").prop("selected", true);
				$("#reBoxmedi").change();
			}


			//마킹 
			var mrdesc=$("input[name=mrDesc]").val();
			parsemarkingcodes("markingDiv", obj["mrDescList"], '<?=$txtdt["1077"]?>','mrDesc', 'mrDesc', mrdesc);

			if(!isEmpty(obj["od_matype"]) && obj["od_matype"]=="goods")
			{				
				$("input[name=odChubcnt]").val(obj["od_chubcnt"]);
				$("input[name=odPackcnt]").val(obj["od_packcnt"]);
				$("input[name=odPackcapa]").val(obj["od_packcapa"]);
			}
			*/

		}
		else if(obj["apiCode"]=="ordermediboxinfoupdate")
		{
			//한약박스 정보
			$("#screen1").remove();
			$("#layermedibox").remove();

			console.log("pb_medichk = " + obj["pb_medichk"]);
			if(!isEmpty(obj["pb_medichk"]) && obj["pb_medichk"]=="false")
			{
				setTimeout(function(){mediboxinfo(obj["pb_title"],obj["pb_volume"],obj["pb_maxcnt"]);}, 100);
			}
		}
	}
	function setPoutchMedibox(obj)
	{
		var opprice=opcode=opcapa=opadd=opvolcnt="";
		console.log("setPoutchMedibox ============================= ");
		console.log(obj);
		if(!isEmpty(obj["odPacktype"]))
		{
			opprice=" data-priceA="+obj["odPacktype"]["pb_priceA"]+" data-priceB="+obj["odPacktype"]["pb_priceB"]+" data-priceC="+obj["odPacktype"]["pb_priceC"]+" data-priceD="+obj["odPacktype"]["pb_priceD"]+"  data-priceE="+obj["odPacktype"]["pb_priceE"];
			opcode=" data-codeonly="+obj["odPacktype"]["pb_codeonly"];
			opcapa=" data-capa="+obj["odPacktype"]["pb_capa"];
			opadd=" data-add=1";

			$("#odPackType option:eq(0)").after("<option value='"+obj["odPacktype"]["pb_code"]+"' "+opcapa+" "+opprice+" "+opcode+" "+opadd+">"+obj["odPacktype"]["pb_title"]+"</option>");
 

			$("#odPackType option:eq(1)").prop("selected", true);
			//$("#odPackType").change();
		}
		else
		{
			opadd=$("#odPackType option:selected").data("add");
			console.log("DOO :: opadd = " + opadd);
			if(!isEmpty(opadd)&&opadd=="1")
			{
				$("#odPackType option:eq(1)").remove();
			}

			$("#odPackType option:eq(0)").prop("selected", true);
			//$("#odPackType").change();
		}

		if(!isEmpty(obj["reBoxmedi"]))
		{
			//한약박스 사전조재 추가 
			opprice=" data-priceA="+obj["reBoxmedi"]["pb_priceA"]+" data-priceB="+obj["reBoxmedi"]["pb_priceB"]+" data-priceC="+obj["reBoxmedi"]["pb_priceC"]+"data-priceD="+obj["reBoxmedi"]["pb_priceD"]+" data-priceE="+obj["reBoxmedi"]["pb_priceE"];
			opcode=" data-codeonly="+obj["reBoxmedi"]["pb_codeonly"];
			opcapa=" data-capa="+obj["reBoxmedi"]["pb_maxcnt"];
			opvolcnt=" data-volcnt="+obj["reBoxmedi"]["pb_volume"]+"|"+obj["reBoxmedi"]["pb_maxcnt"];
			opadd=" data-add=1";

			$("#reBoxmedi option:eq(0)").after("<option value='"+obj["reBoxmedi"]["pb_code"]+"' "+opcapa+" "+opvolcnt+" "+opprice+" "+opcode+" "+opadd+">"+obj["reBoxmedi"]["pb_title"]+"</option>");

			$("#reBoxmedi option:eq(1)").prop("selected", true);
			//$("#reBoxmedi").change();
		}
		else
		{
			opadd=$("#reBoxmedi option:selected").data("add");
			console.log("DOO :: opadd = " + opadd);
			if(!isEmpty(opadd)&&opadd=="1")
			{
				$("#reBoxmedi option:eq(1)").remove();
			}
			$("#reBoxmedi option:eq(0)").prop("selected", true);
			//$("#reBoxmedi").change();
		}


		//마킹 
		var mrdesc=$("input[name=mrDesc]").val();
		parsemarkingcodes("markingDiv", obj["mrDescList"], '<?=$txtdt["1077"]?>','mrDesc', 'mrDesc', mrdesc);

		if(!isEmpty(obj["od_matype"]) && obj["od_matype"]=="goods")
		{				
			$("input[name=odChubcnt]").val(obj["od_chubcnt"]);
			$("input[name=odPackcnt]").val(obj["od_packcnt"]);
			$("input[name=odPackcapa]").val(obj["od_packcapa"]);
		}


		//$("#odPackType").change();
		//$("#reBoxmedi").change();	

		ordersummaryupdate();

	}

	function getWcDisabled(status, odCode)
	{
		var wcdisabled="";
		if(status=="paid" || status=="order" || status=="register")
		{
			var today = new Date();
			var yyyy = today.getFullYear();
			var yyyy2 = yyyy-1;
			var chk=odCode.substring(0,7);
			//console.log("status = "+status+", odCode = " + odCode + ", chk = " + chk);
			if((chk == ("ODD"+yyyy) && odCode.length == 22) || (chk == ("ODD"+yyyy2) && odCode.length == 22))
			{
				wcdisabled="";
			}
			else
			{
				wcdisabled="disabled";
			}
		}
		return wcdisabled;
	}

	//버튼
	function workBtn()
	{
		var btn_html=chk=odCode=url="";
		btn_html ='<a href="javascript:;" class="cw-btn close" onclick="orderprintclosediv()"><span><?=$txtdt["1595"]?></span></a> ';//닫기
		$("#div_outermaking").hide();
		var odSitecategory = $("input[name=odSitecategoryDiv]").val();
		var odStatus = $("input[name=odStatusDiv]").val();
		var odCode = $("input[name=odCodeDiv]").val();
		var odSeq = $("input[name=odSeqDiv]").val();
		var nonegoods=$("input[name=nonegoods]").val();
		var mattype=$("input[name=odMatype]").val();

		console.log("workBtn mattype="+mattype+", nonegoods = " + nonegoods+", yyyy2 = " + yyyy2);
		
		console.log($("input[name=senderchkBtn]").val()+"_"+$("input[name=receiverchkBtn]").val());
		if($("input[name=senderchkBtn]").val() == 1 && $("input[name=receiverchkBtn]").val() == 1 )//|| (mattype=="goods"&&nonegoods == 1) || (mattype=="commercial"&&nonegoods == 2)) //배송우편번호적용 버튼처리가 되었을때 작업등록, 작업지시가 가능하게 처리
		{
			var today = new Date();
			var yyyy = today.getFullYear();
			var yyyy2 = yyyy-1;
			
				
			chk=odCode.substring(0,7);
			/*if(odStatus =="order" || odStatus =="paid")
			{
				//ODD2019080512223100001
				if(chk == ("ODD"+yyyy) && odCode.length == 22  || chk == ("ODD"+yyyy2) && odCode.length == 22)//20190805 :: 주문코드를 17자리에서 22자리로 바꿈.. 엑셀로 등록할시에 같은 주문번호가 나옴.
				{
					btn_html+='<a href="javascript:;" class="cdp-btn close" id="confirmid" onclick="orderconfirm(\''+odSeq+'\');" ><span><?=$txtdt["1656"]?></span></a>';//작업등록
					$("#div_outermaking").hide();
				}
				else
				{
					btn_html+='<a href="javascript:;" class="cdp-btn close" onclick="orderchange(\''+odSeq+'\');" ><span><?=$txtdt["1279"]?></span></a>';//작업지시
					$("#div_outermaking").show();
				}
			}
			*/
			if(odStatus =="order" || odStatus =="paid")
			{
				btn_html+='<a href="javascript:;" class="cdp-btn close" id="confirmid" onclick="orderconfirm(\''+odSeq+'\');" ><span><?=$txtdt["1656"]?></span></a>';//작업등록	
			}
			else if(odStatus=="register")
			{
				btn_html+='<a href="javascript:;" class="cdp-btn close" onclick="orderchange(\''+odSeq+'\');" ><span><?=$txtdt["1279"]?></span></a>';//작업지시
			}

		}
		//console.log(odStatus);
		$("#btnOPDiv").html(btn_html);  //작업등록버튼 
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
	$("#searchTxt").focus();


</script>