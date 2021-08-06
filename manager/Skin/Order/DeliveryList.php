<?php
	$root = "../..";
	$upload=$root."/_module/excel";

	include_once $root."/_common.php";
	include_once $upload."/excelupload.lib.php";

	$pagegroup = "order";
	$pagecode = "deliverylist";
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
	.btn-deli1{padding:3px 5px;background:skyblue;color:#000;border:none;width:60px;}
	.btn-deli2{padding:3px 5px;background:#999;color:#fff;border:none;width:60px;}
</style>
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
			<col width="180">
			<col width="*">
		</colgroup>

		<tbody>
			<tr>
				<th><span><?=$txtdt["1038"]?><!-- 기간선택 --></span></th>
				<td class="selperiod"><?=selectperiod()?></td>
			</tr>
			<tr>
				<th>택배회사<!-- 주문구분 --></th>
				<td><?=selectdelitype()?><!-- 탕제/실속/제환(은 나중에) --></td>
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
	</div>
    <table id="deliverylisttbl" class="tblcss">
		<caption><span class="blind">번호,분류,내용,담당자,등록일,완료예정일,완료일,중요도,상태를 나타내는 이슈관리 테이블 입니다.</span></caption>
		<colgroup>		
			<col scope="col" width="6%"> 
			<col scope="col" width="6%"> 
			<col scope="col" width="4%"> 
			<col scope="col" width="11%">
			<col scope="col" width="18%">
			<col scope="col" width="10%">
			<col scope="col" width="10%">
			<col scope="col" width=""> 
			<col scope="col" width="8%"> 
			<col scope="col" width="10%"> 
		</colgroup>
		<thead>
			<tr>
				<th>배송접수일<!-- 배송접수일 --></th>
				<th>택배사등록<!-- 택배사등록 --></th>
				<th>묶음<!-- 묶음배송 --></th>
				<th>주문번호<!-- 주문번호 --></th>
				<th>처방명<!-- 거래처코드 --></th>
				<th>보내는사람<!-- 보내는사람 --></th>
				<th>받는사람<!-- 받는사람 --></th>
				<th>주소<!-- 주소 --></th>
				<th>송장번호<!-- 송장번호 --></th>
				<th>추가출력/재출력<!-- 송장번호 --></th>
			</tr>
		</thead>
		<tbody>
		</tbody>
    </table>
</div>

<div class="gap"></div>

<!-- s : 게시판 페이징 -->
<div class='paging-wrap' id="deliverylistpage"></div>
<!-- e : 게시판 페이징 -->

<script>
	function calltbmsapi(type,group,code,data)
	{
		var language=$("#gnb-wrap").attr("value");
		var timestamp = new Date().getTime();
		if(isEmpty(language)){language="kor";}

		var url=getUrlData("API_TBMS")+group+"/";
		switch(type)
		{
		case "GET": case "DELETE":
			url+="?apiCode="+code+"&language="+language+"&v="+timestamp+"&"+data;
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
	function viewconfirm(confirm, confirmName)
	{
		var str_html=cls2=cls="";
		switch(confirm)
		{
		case "C":
			cls2="r-stat15";
			cls="statlink";
			break;
		case "Y":
			cls2="r-stat13";
			cls="";
			break;
		case "N":
		default:
			cls="procwork";
			cls2="r-stat16";
			break;
		}
		str_html ="<span class='"+cls+" r-stat "+cls2+"'>"+confirmName+"</span>";
		return str_html;
	}
	

	function viewtied(delicode, trName){
		var apidata="delicode="+delicode+"&trName="+trName;
		callapi('GET','order','deliverytied',apidata);
	}

	function repageload()
	{
		console.log("no  repageload ");
	}
	function addpostprint(odcode)
	{
		var type="POST";
		var deliexception="N";
		var delicomp="POST";
		window.open(getUrlData("TBMS")+"marking/document.deliprint.php?odCode="+odcode+"&type="+type+"&deliexception="+deliexception+"&delicomp="+delicomp+"&site=MANAGER&addprint=R", "proc_report_deli","width=800,height=500");//ok  -새창. 로딩이 걸리네.
	}
	function repostprint(odcode, delicode)
	{
		var type="POST";
		var deliexception="N";
		var delicomp="POST";
		window.open(getUrlData("TBMS")+"marking/document.deliprint.php?odCode="+odcode+"&type="+type+"&deliexception="+deliexception+"&delicode="+delicode+"&delicomp="+delicomp+"&site=MANAGER", "proc_report_deli","width=800,height=500");//ok  -새창. 로딩이 걸리네.
	}
	function relogenprint(odcode, delicode)
	{
		var type="POST";
		var deliexception="N";
		var delicomp="LOGEN";
		window.open(getUrlData("TBMS")+"marking/document.deliprint.php?odCode="+odcode+"&type="+type+"&deliexception="+deliexception+"&delicode="+delicode+"&delicomp="+delicomp+"&site=MANAGER", "proc_report_deli","width=800,height=500");//ok  -새창. 로딩이 걸리네.
	}
	function addlogenprint(odcode)
	{
		var type="POST";
		var deliexception="N";
		var delicomp="LOGEN";
		window.open(getUrlData("TBMS")+"marking/document.deliprint.php?odCode="+odcode+"&type="+type+"&deliexception="+deliexception+"&delicomp="+delicomp+"&site=MANAGER&addprint=R", "proc_report_deli","width=800,height=500");//ok  -새창. 로딩이 걸리네.
	}
	function chkconfirm(odcode, deliconfirm, delitype, delicode, delitypeName)
	{
		console.log("chkconfirm odcode = "+odcode+", deliconfirm = " + deliconfirm+", delitype = " + delitype+", delicode = " + delicode);

		if(!isEmpty(deliconfirm)&&deliconfirm=="Y")
		{
			alertsign("warning", "완료된 송장입니다.", "", "1500");
		}
		else if(!isEmpty(deliconfirm)&&deliconfirm=="C")
		{
			alertsign("warning", "이미 취소된 송장입니다.", "", "1500");
		}
		else
		{
			if(!confirm('['+delitypeName + '] 운송장번호 '+delicode+'를 취소하시겠습니까?')){return;}

			if(!confirm('정말로 취소하시겠습니까?')){return;}

			var url="odCode="+odcode+"&delitype="+delitype+"&delicode="+delicode;
			console.log("취소하러 가자!!!  url = " + url);
			calltbmsapi('GET','marking','deliverycancel',url);
		}
		
	}
	function makepage(json)
	{
		console.log("list makepage ----------------------------------------------- ")
		var obj = JSON.parse(json);
		console.log(obj);

		if(obj["apiCode"]=="deliverylist") //배송리스트
		{
			var data="";
			if(!isEmpty(obj["list"]))
			{
				$(obj["list"]).each(function( index, value )
				{
					var reDelidate="";
					var deliCode=value["delicode"];
					var cusutomer=!isEmpty(value["cusutomer"]) ? value["cusutomer"]:"";
					var desticode=!isEmpty(value["desticode"]) ? value["desticode"]:"";
					var region=!isEmpty(value["region"]) ? value["region"]:"";
					var destiname=!isEmpty(value["destiname"]) ? value["destiname"]:"";
					data+="<tr style='cursor:pointer;' id='"+value["trName"]+"' value='"+value["odCode"]+"'>";

					if(value["reDelidate"]=="1970.01.01"){reDelidate=" - ";}else{reDelidate=value["reDelidate"];}

					data+="<td title='"+value["reDelidateTxt"]+"'>"+reDelidate+"</td>"; //배송접수일

					var deliname=value["delitypeName"]+" "+value["deliConfirmName"];

					if(value["delitype"]=="POST" || value["delitype"]=="post")
					{
						data+="<td><span class='link' onclick=\"chkconfirm('"+value["odCode"]+"','"+value["deliConfirm"]+"','"+value["delitype"]+"', '"+value["deliCode"]+"', '"+value["delitypeName"]+"')\">"+viewconfirm(value["deliConfirm"],deliname)+"</span></td>"; //택배사등록
					}
					else if(value["delitype"]=="logen" || value["delitype"]=="LOGEN")
					{
						data+="<td><span class='link' onclick=\"chkconfirm('"+value["odCode"]+"','"+value["deliConfirm"]+"','"+value["delitype"]+"', '"+value["deliCode"]+"', '"+value["delitypeName"]+"')\">"+viewconfirm(value["deliConfirm"],deliname)+"</span></td>"; //택배사등록
					}
					else
					{
						data+="<td>"+viewconfirm(value["deliConfirm"],deliname)+"</td>"; //택배사등록
					}

					data+="<td>"+value["deliTied"]+"</td>"; //묶음배송
					data+="<td>"+value["odCode"]+"</td>"; //주문번호
					data+="<td class='lf'>"+value["odTitle"]+"</td>"; //처방명
					data+="<td>"+value["reSendname"]+"</td>"; //보내는사람
					data+="<td>"+value["reName"]+"</td>"; //받는사람
					data+="<td class='l'>"+"["+value["reZipcode"]+"] "+value["reAddress"]+"</td>"; //주소
					data+="<td>"+value["deliCodeView"]+"</td>"; //송장번호
					if(value["deliBtnChk"]=="R"){
						data+="<td>";
						if(!isEmpty(value["deliBtn"]))
						{
							if(value["delitype"]=="LOGEN" || value["delitype"]=="logen")
							{
								data+="<a href='javascript:;' onclick=\"addlogenprint('"+value["odCode"]+"');\">"+value["deliBtn"]+"</a>"; //송장번호
							}
							else
							{
								data+="<a href='javascript:;' onclick=\"addpostprint('"+value["odCode"]+"');\">"+value["deliBtn"]+"</a>"; //송장번호
							}
						}

						if(!isEmpty(value["delireBtn"]))
						{
							if(value["delitype"]=="LOGEN" || value["delitype"]=="logen")
							{
								data+=" <a href='javascript:;' onclick=\"relogenprint('"+value["odCode"]+"','"+value["deliCode"]+"');\">"+value["delireBtn"]+"</a>"; //송장번호
							}
							else
							{
								data+=" <a href='javascript:;' onclick=\"repostprint('"+value["odCode"]+"','"+value["deliCode"]+"');\">"+value["delireBtn"]+"</a>"; //송장번호
							}
						}
						data+="</td>";
						
					}else{
						data+="<td>";
						if(!isEmpty(value["delireBtn"]))
						{
							if(value["delitype"]=="LOGEN" || value["delitype"]=="logen")
							{
								data+="<a href='javascript:;' onclick=\"relogenprint('"+value["odCode"]+"','"+value["deliCode"]+"');\">"+value["delireBtn"]+"</a>"; //송장번호
							}
							else
							{
								data+="<a href='javascript:;' onclick=\"repostprint('"+value["odCode"]+"','"+value["deliCode"]+"');\">"+value["delireBtn"]+"</a>"; //송장번호
							}
						}
						data+="</td>";
					}
					data+="</tr>";
				});	
			}
			else
			{
				data+="<tr>";
				data+="	<td colspan='10'><?=$txtdt['1665']?></td>";
				data+="</tr>";
			}
			//테이블에 넣기
			$("#deliverylisttbl tbody").html(data);
			$("#pagecnt").text(comma(obj["tcnt"])+" <?=$txtdt['1019']?>");
			//페이징
			getsubpage("deliverylistpage",obj["tpage"], obj["page"], obj["block"], obj["psize"]);

		}
		else if(obj["apiCode"]=="deliverycancel") //취소처리 
		{
			var hashdata=location.hash;
			if(hashdata=="")hashdata="#1||";
			if(hashdata.indexOf("renew") < 0){
				location.hash=hashdata+"|renew";
			}else{
				location.hash=hashdata.replace("|renew","");
			}

			if(obj["resultCode"]=="200")
			{
				alertsign("warning", "취소되었습니다.", "", "2000");
			}
			else 
			{
				alertsign("warning", obj["resultMessage"], "", "2000");
			}

		}
		else if(obj["apiCode"]=="deliverytied")//묶음배송 
		{
			var data="";
			$(obj["list"]).each(function( index, value )
			{	
				data="<tr style='cursor:pointer;'>";
				data+="<td colspan='3'>묶음배송</td>"; //배송접수일
				data+="<td>"+value["odCode"]+"</td>"; //주문번호 
				data+="<td class='lf'>"+value["odTitle"]+"</td>"; //처방명
				data+="<td>"+value["reSendname"]+"</td>"; //보내는사람
				data+="<td>"+value["reName"]+"</td>"; //받는사람
				data+="<td class='l'>"+"["+value["reZipcode"]+"] "+value["reAddress"]+"</td>"; //주소
				data+="<td colspan='2'></td>"; //송장번호
				data+="</tr>";
				console.log(data);
				console.log(obj["trName"]);

				$("#"+obj["trName"]).after(data);
			});
		}
	}


	//배송리스트 API 호출
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
		if(sarr[7]!=undefined)var sarr8=sarr[7].split("=");
		if(sarr[8]!=undefined)var sarr9=sarr[8].split("=");
		if(sarr1[1]!=undefined)var sdate=sarr1[1];
		if(sarr2[1]!=undefined)var edate=sarr2[1];
		if(sarr3[1]!=undefined)var searchTxt=sarr3[1];
		if(sarr6[1]!=undefined)var searchPeriodEtc=sarr6[1];
		if(sarr7[1]!=undefined)var searchMatype=sarr7[1];
		if(sarr8[1]!=undefined)var searchDelitype=sarr8[1];
		if(sarr9[1]!=undefined)var searchdelibk=sarr9[1];

		
		
		//if(sarr2[1]!=undefined)var searchStatus=sarr2[1];
		$("input[name=sdate]").val(sdate);
		$("input[name=edate]").val(edate);
		$("input[name=searchTxt]").val(decodeURI(searchTxt));

		//------------------------------------------------------
		//버키 체크박스 
		//------------------------------------------------------
		if(!isEmpty(searchdelibk)&&searchdelibk=="Y")
		{
			$(".searchdelibk").attr("checked",true);
		}
		//------------------------------------------------------

		//------------------------------------------------------
		//택배회사별 체크박스 
		//------------------------------------------------------
		var mtarr=searchDelitype.split(",");
		for(var i=0;i<mtarr.length;i++){
			if(mtarr[i]!=""){
				$(".searchDelitype"+mtarr[i]).attr("checked",true);
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

		apiOrderData="&sdate="+sdate+"&edate="+edate+"&searchTxt="+encodeURI(searchTxt)+"&searchDelitype="+searchDelitype+"&searchdelibk="+searchdelibk;
	}

	var apidata="page="+page+apiOrderData;
	console.log("apidata     : "+apidata);
	callapi('GET','order','deliverylist',apidata);
	$("#searchTxt").focus();

</script>
