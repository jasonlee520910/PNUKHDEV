var timerID;
var makingID;
var printID;
//var orderTimeID=""; //보류
//------------------------------------------------------------------------------------
// 공통함수
//------------------------------------------------------------------------------------
//빈값체크
function isEmpty(value)
{
	if( value == "" || value == null || typeof value == undefined || ( value != null && typeof value == "object" && !Object.keys(value).length ) )
	{
		return true;
	}
	else
	{
		return false;
	}
}
//콤마 표시
function comma(str)
{
    str = String(str);
    return str.replace(/(\d)(?=(?:\d{3})+(?!\d))/g, '$1,');
}
//현재 날짜 시분초
function getTime()
{
	var d = new Date();
	return(
		d.getFullYear() + " " +
	    ("00" + (d.getMonth() + 1)).slice(-2) + "-" +
	    ("00" + d.getDate()).slice(-2) + "-" +

	    ("00" + d.getHours()).slice(-2) + ":" +
	    ("00" + d.getMinutes()).slice(-2) + ":" +
	    ("00" + d.getSeconds()).slice(-2)
	);
}
//오늘날짜뽑아오기 : 20190124180934(년월일시분초) - yearcnt가 2이면 190124180934
function getNowFull(yearcnt)
{
	var date = new Date();
	var year = new String(date.getFullYear());
	year = (yearcnt==4) ? year : year.substring(2,4);
	var month = new String(date.getMonth()+1);
	var day = new String(date.getDate());
	var hours = new String(date.getHours());
	var minutes = new String(date.getMinutes());
	var seconds = new String(date.getSeconds());

	return nowDate = pad(year,yearcnt) + pad(month,2) + pad(day,2) + pad(hours,2) + pad(minutes,2) + pad(seconds,2);
}

//자릿수
function pad(n, width)
{
   n = n + '';
   return n.length >= width ? n : new Array(width - n.length + 1).join('0') + n;
}
//------------------------------------------------------------------------------------
// jquery cookie Set,Get
//------------------------------------------------------------------------------------
//document.cookie="name=value[; expires=expires] [; path=path] [; domain=domain] [; secure]";
//.cookie('user', '홍길동', { expires: 7, path: '/', domain: 'test.com', secure: false });
function setCookie(cname, cvalue, exdays)
{
	//$.cookie(cname, cvalue, { expires: exdays, path: '/', domain: getUrlData("DOMAIN"), secure: false });
	var nowdate = new Date();//1시간 
	nowdate.setTime(nowdate.getTime() + 60 * 60  * 1000 * 12);
	console.log("nowdate = "+nowdate);
	Cookies.set(cname, cvalue, { expires: nowdate, path: '/', domain: getUrlData("DOMAIN"), secure: false });
}
function getCookie(cname)
{
	if(Cookies.get(cname)==null || Cookies.get(cname)=="null")
	{
		return "";
	}
	return Cookies.get(cname);
}
function deleteAllCookies()
{
	//var cookies = $.cookie();
	var cookies = Cookies.get();
	for(var cookie in cookies)
	{
		if(cookie != "ck_language" || cookie != "ck_languageName" || cookie != "ck_matable" || cookie != "ck_mrPrinter" || cookie != "ck_mrPrintertitle"|| cookie != "ck_mrPrinterIP"|| cookie != "ck_mrPrinterPort")
		{
			deleteCookie(cookie);
		}
	}
}
function deleteCookie(name)
{
	setCookie(name,null,-1); //$.removeCookie(cookie);
	Cookies.remove(name);
}
//------------------------------------------------------------------------------------
// 언어 체인지
//------------------------------------------------------------------------------------
function golanguage(lang)
{
	setCookie("ck_language", lang, 365);
	setCookie("ck_languageName", getLanguageName(lang), 365);
	location.reload();
}
function getLanguageName(lang)
{
	switch(lang)
	{
	case "chn":
		return "中文";
	case "eng":
		return "ENGLISH";
	default:
		return "한글";
	}
}
//------------------------------------------------------------------------------------
// 로그아웃
//------------------------------------------------------------------------------------
function gologout()
{
	var section=$("#nav").attr("data-bind");
	var staff=$("#staffinfo .barcode").text();
	var odcode=$("#ordercode").attr("value");
	//console.log("section : "+section+", staff : "+staff+", odcode : "+odcode);
	if(!isEmpty(staff) && !isEmpty(odcode))
	{
		var status_txt=getTxtdt("step20");//00지시서 바코드를 스캔 해 주세요
		console.log(getTxtdt("step60"));
		$('#status_txt').text(status_txt);
		clearIntervalPrint();
		$("#procmember").html("");
		$("#procscription").html("");
		$("#procuser").html("");
		$("#gram").html("");
		$("#addagainphoto").html("");
		gotostep(1);
		cleardiv();
		gomainload("../_Inc/list.php?depart="+section);
	}
	else if(!isEmpty(staff))
	{
		location.reload();
	}
	else
	{
		var stauth = getCookie("ck_stAuth");
		var matable = getCookie("ck_matable");
		var url = "";

		if(!isEmpty(matable))
		{
			//---------------------------------------------------------
			//matable callapi
			var jsondata={};
			jsondata["maTable"]=matable;
			//console.log(JSON.stringify(jsondata));
			callapi('POST','making','matableupdate',jsondata);
			//---------------------------------------------------------
			deleteCookie("ck_matable");
		}

		//세션삭제 후 쿠키도 삭제
		if(stauth == "tutuser")
		{
			url = getUrlData("TUTORIAL");
			//console.log("gologout  url : "+url);
			removeSession(url);
		}
		else
		{
			url = getUrlData("MEMBER");
			//console.log("gologout  url : "+url);
			removeSession(url);//세션삭제 후 쿠키도 삭제
		}
	}
}
function clearIntervalPrint()
{
	console.log("clearIntervalPrint printID = " + printID);
	if(!isEmpty(printID))
	{
		clearInterval(printID);
		printID="";
	}		
}
//------------------------------------------------------------------------------------
// steptxt : 스텝에서 쓰이는 텍스트 셋팅
//------------------------------------------------------------------------------------
function setTxtdt(txtdt)
{
	//steptxtdt textrea에 넣는다.
	var pretty = JSON.stringify(txtdt);
	document.getElementById('steptxtdt').value = pretty;
}
//셋팅한 steptxt 텍스트 뽑아쓰기
function getTxtdt(name)
{
	var ugly = document.getElementById('steptxtdt').value;
	var txtdt = JSON.parse(ugly);
	return txtdt[name];
}
//------------------------------------------------------------------------------------
// ComTxtdt : 공통으로 쓰이는 텍스트 data
//------------------------------------------------------------------------------------
function getTxtData(name)
{
	var ugly = document.getElementById('comTxtdt').value;
	var txtdt = JSON.parse(ugly);
	return txtdt[name];
}
//------------------------------------------------------------------------------------
// urlData : url data
//------------------------------------------------------------------------------------
function getUrlData(name)
{
	var ugly = document.getElementById('urldata').value;
	var txtdt = JSON.parse(ugly);
	return txtdt[name];
}
//------------------------------------------------------------------------------------
// api 호출
//------------------------------------------------------------------------------------
function callapi(type,group,code,data)
{
	//console.log("callapi data : "+data);
	var language=$("#gnb-wrap").attr("value");
	var timestamp = new Date().getTime();
	if(isEmpty(language)){language="kor";}
	language="kor";
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

	var key=getCookie("ck_authkey");
	var id=getCookie("ck_stStaffid");

	console.log("callapi url : "+url+", key="+key+"&id="+id);
	$.ajax({
		type : type, //method
		url : url,
		data : data,
		headers : {"ck_authkey" : key, "ck_stStaffid" : id },
		success : function (result) {
			chkMember(type, result);
		},
		error:function(request,status,error){
			console.log("code:"+request.status+"\n"+"message:"+request.responseText+"\n"+"error:"+error);
		}
   });
}
function chkMember(type, result)
{
	var obj = JSON.parse(result);
	if(obj["resultCode"]=="9999" && obj["resultMessage"]=="MEMBER_DIFFERENT")
	{
		//다른기기에서 로그인되었습니다. 로그인화면으로 이동합니다. 확인 클릭시 로그아웃 후 로그인페이지로 이동 
		layersign('warning', getTxtData("MEMBER_DIFFERENT"),'','confirm_diff');
	}
	else
	{
		switch(type){
			case "GET":
				makepage(result);
				break;
			case "POST":
				saveupdate(result);
				break;
			case "DELETE":
				savedelete(result);
				break;
		}
	}
}
function saveupdate(result)
{
	var obj = JSON.parse(result);
	console.log(obj);
	if(obj["resultCode"]=="200")
	{
		if(obj["apiCode"]=="makingdone") //조제완료
		{
			makingdoneNext();
		}
		else if(obj["apiCode"]=="decoctiondone") //탕전완료 
		{
			status_txt = getTxtdt("stepdone");//탕전이 완료되었습니다
			$('#status_txt').text(status_txt);
			layersign('success', status_txt,'','1500');
		}
		else if(obj["apiCode"]=="medicinecapaupdate" )
		{
			if(obj["mdCapaLast"]=="true")
				checkBarcodeFinish(obj["medigroup"]);//medigroup 20190514
			else
				checkBarcodeProcessing();
		}
		else if(obj["apiCode"] == "releasephoto")
		{
			$('#qmcode').text(obj["qmcode"]);
			$('#delino').text(obj["barcode"]);
			nextstep();
			cleardiv();
			layersign("success",getTxtData("9022"), "",'confirm_release');//송장과 포장된 제품을 준비한후 확인버튼을 터치해 주세요.
		}
		else if(obj["apiCode"] == "checkboilerupdate" || obj["apiCode"] == "checkpackingupdate")
		{
			boilerView("boilerDiv", obj["boilerlist"]);  //불꽃 리스트
			packingView("packingDiv", obj["packinglist"]);  //포장기 리스트
		}
		else
		{
			if(!isEmpty(obj["returnData"]))
			{
				gomainload(obj["returnData"]);
			}
		}
	}
	else
	{
		//console.log("99999999999999  resultMessage = " + obj["resultMessage"]);
		if(obj["resultCode"]=="999")
		{
			switch(obj["resultMessage"])
			{
			case "MEDIBOXNONE":
				layersign('warning', getTxtData("MEDIBOXNONE"),'','2000'); //약재함이 존재하지 않거나 사용할수 없습니다.
			break;
			case "MEDISHORTAGE":
				layersign('warning', getTxtData("MEDISHORTAGE"),obj["meditxt"],'mediconfirmcapa'); //약재가 부족합니다.
			break;
			case "ERR_DELINO_DIFFERENT":
				layersign('warning', getTxtData("9043"),'','2000'); //주문번호와 송장번호가 다릅니다. 다시 송장바코드를 스캔해 주세요.
				break;	
			case "ERR_BOILER_READY":
				layersign('warning', '현재 준비중인 탕전기입니다','','2000'); //현재 준비중인 탕전기입니다
				break;	
			case "ERR_BOILER_READY":
				layersign('warning', '현재 진행중인 탕전기입니다.','','2000'); //현재 진행중인 탕전기입니다.
				break;
			/*case "MEDIDEDUCTFAIL":
				layersign('warning', getTxtData("MEDIDEDUCTFAIL"),'','1000'); //약재차감에 실패하였습니다.
				break;*/
			}
		}
		else
		{
			alert(obj["resultMessage"]+"("+obj["resultCode"]+")");
		}
	}
}
function savedelete(result)
{
	var obj = JSON.parse(result);
	//console.log(obj);
	if(obj["resultCode"]=="200")
	{
		var url = obj["returnData"];
		//console.log("savedelete   ======>>>  url = " + url);
		//"/Skin/Medicine/HubCategory.php?"+url
		$("#listdiv").load(url);
	}
	else
	{
		alert(obj["resultCode"]+" - "+obj["resultMessage"]);
	}
}
function gomainload(url)
{
	if(url.indexOf("list.php")!==-1)
	{
		$("#maTypeName").text("");
	}
	$('#maindiv').load(url);
}
//------------------------------------------------------------------------------------
// session : 일단은 이렇게 작업하되 나중에 도메인이 달라지거나 했을 경우에는 session 관련 작업을 다시 해야함..
//------------------------------------------------------------------------------------
function setSession(obj)
{
	var url="/session.php";
		url+="?seq="+obj["seq"];
		url+="&stName="+encodeURI(obj["stName"]);
		url+="&stUserid="+obj["stUserid"];
		url+="&stStaffid="+obj["stStaffid"];
		url+="&stAuth="+obj["stAuth"];
		url+="&stDepart="+encodeURI(obj["stDepart"]);
		url+="&stLogin="+encodeURI(obj["stLogin"]);
		url+="&url="+encodeURI(obj["locationURL"]);

	$.ajax({
		type : "GET", //method
		url : url,
		data : [],
		success : function (result) {
			//console.log("result = "+result+", getCookie ck_stUserid : "+getCookie("ck_stUserid"));
			window.location.href=result;
		},
		error:function(request,status,error){
			console.log("code:"+request.status+"\n"+"message:"+request.responseText+"\n"+"error:"+error);
		}
	});
}
function removeSession(reUrl)
{
	var url="/session.php";
		url+="?type=logout&url="+reUrl;
	$.ajax({
		type : "GET", //method
		url : url,
		data : [],
		success : function (result) {
			//--------------------------------------------
			//쿠키삭제
			//--------------------------------------------
			deleteAllCookies();
			//--------------------------------------------
			window.location.href=result;
		},
		error:function(request,status,error){
			console.log("code:"+request.status+"\n"+"message:"+request.responseText+"\n"+"error:"+error);
		}
	});
}
//------------------------------------------------------------------------------------
// 리스트형 페이징
//------------------------------------------------------------------------------------
function getsubpage(pgid, tpage, page, block, psize)
{
	block=parseInt(block);
	psize=parseInt(psize);

	var prev=next=0;
	var inloop = (parseInt((page - 1) / block) * block) + 1;
	//console.log("pgid : " + pgid +", tpage = "+tpage+", page = "+page+", block = "+block+", psize = "+psize+", inloop = "+inloop );

	prev = inloop - 1;
	next = inloop + block;
	var txt="<ul class='paging-wrap paging-wrap-main' data-tpage='"+tpage+"' data-page='"+page+"' data-id='"+pgid+"'>";
	var link = cls="";

	if(prev<1)
	{
		link = "";
		prev = 1;
	}
	else
	{
		link = "onclick='subpage("+prev+", "+psize+","+block+");'";
	}

	txt+="<li onclick='subpage("+prev+","+psize+","+block+");'><a href='javascript:;' class='first'>&nbsp;</a></li>";
	txt+="<li "+link+"><a href='javascript:;' class='prev'>&nbsp;</a></li>";

	if(tpage == 0)//데이터가 없을 경우
	{
		txt+="<li  onclick='subpage(1, "+psize+","+block+");'><a href='javascript:;' class='"+cls+"'>1</a></li>";
	}
	else
	{
		for (var i=inloop;i < inloop + block;i++)
		{
			if (i <= tpage){
				if(i==page){cls="active";}else{cls="";}
				txt+="<li  onclick='subpage("+i+", "+psize+","+block+");'><a href='javascript:;' class='"+cls+"'>"+i+"</a></li>";
			}
		}
	}

	if(next>tpage)
	{
		link = "";
		next=tpage;
	}
	else
	{
		link = "onclick='subpage("+next+", "+psize+","+block+");'";
	}
	txt+="<li "+link+"><a href='javascript:;' class='next'>&nbsp;</a></li>";
	txt+="<li onclick='subpage("+tpage+", "+psize+","+block+");'><a href='javascript:;' class='last'>&nbsp;</a></li>";
	txt+="</ul>";

	$("#"+pgid).html(txt);

	//var url="page="+page+"&psize="+psize+"&block="+block;

	return false;
}
//------------------------------------------------------------------------------------
//페이징
//------------------------------------------------------------------------------------
function subpage(page, psize, block)
{
	var depart=$("#containerDiv").attr("value");

	if(isEmpty(psize))
		psize=10;
	if(isEmpty(block))
		block=10;

	var staffid = getCookie("ck_ntStaffid");

	var url="wktype=process&depart="+depart+"&page="+page+"&psize="+psize+"&block="+block+"&staffid="+staffid;//최종적으로 url 쓰이는 부분에서 wktype과 depart 수정
	gopage(url);
	return false;
}
//최종적으로 callapi 호출
function gopage(url)
{
	//console.log("최종적으로 callapi 호출 gopage =======>>>> url : " + url);
	var group=$("#pagegroup").attr("value");
	var code=$("#pagecode").attr("value");
	callapi('GET',group,code,url);
	return false;
}
//------------------------------------------------------------------------------------
// 팝업창
//------------------------------------------------------------------------------------
function viewlayer(url,width,height,code)
{
	$("#viewlayer").remove();
	if(width==""||width==undefined){width=900;}
	if(height==""||height==undefined){height=600;}
	if(code=="img"){
		width = $(window).width() - 50;
		height = $(window).height() - 50;
	}
	var arr=popupcenter(width,height).split("|");
	var top=arr[0];
	var left=arr[1];
	goscreen('');
	var style="position:fixed;top:0;left:0;z-index:3000;background:#fff;overflow:hidden;";
		style+="display:block;width:"+width+"px;height:"+height+"px;margin:"+top+"px 0 0 "+left+"px;";
	$("body").prepend("<div id='viewlayer' style='"+style+"'></div>");
	//console.log(url);
	if(code=="html"||code=="img"){
		$("#viewlayer").html(url);
	}else{
		$("#viewlayer").load(url);
	}
}
function goscreen(type)
{
	if(type=="close")
	{
		$("#screen").fadeOut(300).remove();
	}
	else
	{
		$("#screen").remove();
		var dh = $(document).height();
		var style="background:#000;filter:alpha(opacity=30);opacity:0.3;position:fixed;top:0;left:0;width:100%;height:"+dh+"px;z-index:2500;";
		var txt="<div id='screen' style='"+style+"'></div>";
		$("body").prepend(txt);
	}
}
//화면중앙팝업레이어
function popupcenter(dw,dh)
{
	var winwidth = $(window).width();
	var winheight = $(window).height();
	if(winheight>screen.height)
	{
		winheight=screen.height;
	}
	var left=(parseInt(winwidth)-dw)/2;
	var top=(parseInt(winheight))/2-(dh/2);
	return top+"|"+left;
}
//화면중앙팝업레이어 top agent 체크필요
function popupcentertop(dw,dh)
{
	var winwidth = $(window.parent).width();
	var winheight = $(window.parent).height();
	var scheight = window.parent.$("body").scrollTop();
	var left=(parseInt(winwidth)-dw)/2;
	var top=(parseInt(winheight) - scheight -dh)/2;
	return top+"|"+left;
}
function closediv(id)
{
	goscreen("close");
	$("#"+id).remove();
}
//------------------------------------------------------------------------------------
// 알림창
//------------------------------------------------------------------------------------
function layersign(type, maintxt, subtxt, chktop)//danger-red,info-blue,warning-yellow,success-green
{
	closelayer();
	var len=maintxt.length;//텍스트 길이에 맞춰서 height를 바꾼다.
	var w=600;
	var h=100;

	var height = Math.ceil(len/25); //올림
	var h=height * 50;

	if(subtxt!="")
	{
		var sheight = Math.ceil(subtxt.length/50); //올림
		var sh=sheight * 30;
		h=h+sh;
	}

	//console.log("len="+len+", h="+h+", height= "+height);

	if(chktop=="top")
	{
		var arr=popupcentertop(w,h).split("|");
	}
	else
	{
		var arr=popupcenter(w,h).split("|");
	}
	var top=arr[0];
	var left=arr[1];
	
	if(chktop=="confirm" || chktop=="close" ){h=200;top=top - 50;}
	if(chktop=="medi_confirm_short" || chktop=="mediconfirmcapa" || chktop=="confirm_diff" || chktop=="confirm_making" || chktop=="confirm_marking" || chktop=="confirm_release"){h=110;top=top - 50;}
	
	var txt="<div id='layersign' style='position:fixed;width:"+w+"px;height:"+h+"px;top:"+top+"px;left:"+left+"px;z-index:10001;padding:50px' class='callout callout-"+type+"'>";
		txt+="<h4 style='font-size:30px;font-weight:bold;'>"+maintxt+"</h4>";
	if(subtxt!="")
	{
		txt+="<p style='font-size:20px;font-weight:bold;'>"+subtxt+"</p>";
	}

	switch(chktop)
	{
	case "close":
		txt+="<dl class='confirmbtn'><dd onclick='javascript:closelayer()'>"+getTxtData("CLOSE")+"</dd></dl>"; //닫기 
		break;
	case "confirm_diff":
		var url=getUrlData("MEMBER");
		txt+="<dl class='alertconfirmbtn'><dd onclick='javascript:removeSession(\""+url+"\")'>"+getTxtData("CONFIRM")+"</dd></dl>"; //확인 		
		break;
	case "confirm_making":
		txt+="<dl class='alertconfirmbtn'><dd onclick='javascript:closemakinglayer()'>"+getTxtData("CONFIRM")+"</dd></dl>"; //확인 		
		break;
	case "confirm_marking":
		txt+="<dl class='alertconfirmbtn'><dd onclick='javascript:closemarkinglayer()'>"+getTxtData("CONFIRM")+"</dd></dl>"; //확인 		
		break;
	case "confirm_release":
		txt+="<dl class='alertconfirmbtn'><dd onclick='javascript:closereleaselayer()'>"+getTxtData("CONFIRM")+"</dd></dl>"; //확인 		
		break;
	case "medi_confirm_short": //checkmedibox에서 약재부족 메세지에서 확인 누를시 
		txt+="<dl class='alertconfirmbtn'><dd onclick='javascript:chkmedishort()'>"+getTxtData("CONFIRM")+"</dd></dl>"; //확인 		
		break;
	case "mediconfirmcapa"://medicinecapaupdate에서 약재부족 메세지에서 확인 누를시 
		txt+="<dl class='alertconfirmbtn'><dd onclick='javascript:chkmedicapa()'>"+getTxtData("CONFIRM")+"</dd></dl>"; //확인 	
		break;
	case "confirm":
		txt+="<dl class='confirmbtn'><dd onclick='procconfirm()'>"+getTxtData("PROCCONFIRM")+"</dd><dd onclick='proccancel()'>"+getTxtData("PROCCANCEL")+"</dd><dd onclick='procdone()'>"+getTxtData("PROCDONE")+"</dd></dl>";
		break;
	case "decoc_confirm":
		txt+="<dl class='alertconfirmbtn'><dd onclick='javascript:decoctionconfirm()'>"+getTxtData("CONFIRM")+"</dd></dl>"; //확인
		break;
	}

	txt+="</div>";
	if(chktop=="top")
	{
		$("body",parent.document).prepend(txt);
		timerID=setTimeout("$('#layersign',parent.document).remove()",2000);
	}
	else
	{
		$("body").prepend(txt);
		if(chktop=="decoc_confirm"||chktop=="unlimit"||chktop=="close"||chktop=="confirm" ||chktop=="confirm_diff"||chktop=="medi_confirm_short" ||chktop=="mediconfirmcapa"||chktop=="confirm_making"||chktop=="confirm_marking"||chktop=="confirm_release")
		{

		}
		else
		{
			timerID=setTimeout("$('#layersign').remove()",parseInt(chktop));
		}
	}
}
function closereleaselayer()
{
	var ordercode=$("#ordercode").attr("value");
	var defineprocess=$("#containerDiv").attr("value");
	closelayer();
	console.log("closereleaselayer  ordercode = " + ordercode+", defineprocess = " + defineprocess);
	//촬영-송장바코드
	document.getElementById('snapshot').style.display = 'block';
	$('#snapshot').html('<div style=\"font-size:30px;font-weight:bold;margin:200px 0 0 230px;\">2'+getTxtdt("stepphoto")+'</div>').fadeIn(0);
	if(!isEmpty(defineprocess)&&defineprocess=="goods")
	{
		setTimeout("snapshot('component','"+ordercode+"')",2000);
	}
	else
	{
		setTimeout("snapshot('medibox','"+ordercode+"')",2000);
	}
}
function closemarkinglayer()
{
	$('#marking').data('step','5'); 
	closelayer();
	$("#mainbarcode").focus();
	nextstep();
}

function closemakinglayer()
{
	closelayer();
	$("#mainbarcode").focus();
}
function closelayer()
{
	if(!isEmpty(timerID))
	{
		clearTimeout(timerID);
		timerID="";
	}
	else
	{
		timerID="";
	}
	$('#layersign').remove();
}
function cleardiv()
{
	$("#loading").remove();
	setTimeout("divclose()",1500);
}
//div 전송 후 결과상태 박스레이어닫기
function divclose()
{
	$("#workdiv").animate({
		"opacity": "0"
		},200, "linear", function() {
		$("#workdiv").css({"display":"none"});
	});
}
function checkBarcodeProcessing()
{	
	$('#passCapa').val(0);
}
function checkBarcodeFinish()
{		
	//console.log("checkBarcodeFinishcheckBarcodeFinishcheckBarcodeFinishcheckBarcodeFinishcheckBarcodeFinish addClass('st_finish')");
	gotostep(4);

	//-------------------------
	//20190401 수량들 다시 셋팅
	//-------------------------
	getsummary();
	//-------------------------

	//20190419 : DJMEDI 프로세스로 돌리기 
	status_txt=getTxtdt("step50"); //부직포 바코드를 스캔 해 주세요
	$("#status_txt").text(status_txt);
	layersign("success",status_txt,'','1000');
		
}
//------------------------------------------------------------------------------------
// TBMS 공통으로 쓰이는 프로세스
//------------------------------------------------------------------------------------
//mainbarcode 에서 바코드를 읽었을 경우에  따른 처리
function setMediCapaSmall(mdcode)
{
	var chkhold=$(".contenton .addhold").length;//현재 일치된 약재 hold 전 상태값 저장중량중복체크방지

	console.log("setMediCapaSmall  chkhold ===>  " + chkhold+", mdcode = " + mdcode);

	if(chkhold > 0)//현재 일치된 약재 상태값 있는경우
	{
		console.log("setMediCapaSmall 현재 일치된 약재 상태값 있는경우 nextstep() ");
		nextstep();
	}
	//20190401 addhold 를 밖으로 빼냄 st_finish 대신에 
	$(".contenton .addhold").removeClass('addhold');

	status_txt=getTxtdt("step40"); //약재를 표시된 무게만큼 약재함에 올려주세요
	$("#status_txt").text(status_txt);

	$(".contenton .st_ing").attr('data-pass', "");

	//투입/ 업데이트된 약재용량 초기화
	var ordercode=$("#ordercode").attr("value");
	var mdbarcode=$(".contenton .st_ing").attr("data-value");
	var jsondata={};

	jsondata["ordercode"]=ordercode;//주문번호
	jsondata["mediCode"]=mdcode;//스캔받은약재함의코드
	jsondata["medibarcode"]=mdbarcode;//스캔받은약재함바코드
	jsondata["mediCapa"]="";//스캔받은약재함의용량-일반
	jsondata["mbTable"]=getCookie("ck_matable");

	console.log(JSON.stringify(jsondata));

	setMediTxtdt(jsondata);

	callapi('POST',"making",'medicinecapaupdate',jsondata);
}
function setMediCapaBig(statper, mdcode)
{
	var chkhold=$(".contenton .addhold").length;//현재 일치된 약재 hold 전 상태값 저장중량중복체크방지
	console.log("setMediCapaBig  chkhold ===>  " + chkhold+", statper = " + statper + ", mdcode = " + mdcode);

	if(chkhold > 0)//현재 일치된 약재 상태값 있는경우
	{
		console.log("setMediCapaBig 현재 일치된 약재 상태값 있는경우 nextstep() ");
		nextstep();
	}

	$(".contenton .addhold").removeClass('addhold');
	

	var tmp=getTxtdt("step43");
	var stattxt=tmp.replace("X%",statper+"g"); //표시된 약재무게에서 X% 초과되었습니다.
	$("#status_txt").text(stattxt);
	layersign("warning",stattxt,'','1000');

	$(".contenton .st_ing").attr('data-pass', "");

	//투입/ 업데이트된 약재용량 초기화
	var ordercode=$("#ordercode").attr("value");
	var mdbarcode=$(".contenton .st_ing").attr("data-value");
	var jsondata={};	

	jsondata["ordercode"]=ordercode;//주문번호
	jsondata["mediCode"]=mdcode;//스캔받은약재함의코드
	jsondata["medibarcode"]=mdbarcode;//스캔받은약재함바코드
	jsondata["mediCapa"]="";//스캔받은약재함의용량-일반
	jsondata["mbTable"]=getCookie("ck_matable");
	
	console.log(JSON.stringify(jsondata));
	
	setMediTxtdt(jsondata);

	callapi('POST',"making",'medicinecapaupdate',jsondata);
}
function setMediCapaSame(passCheck, mdcode, mdpassCapa, thiscapa, medigroup)
{
	var chkhold=$(".contenton .addhold").length;//현재 일치된 약재 hold 전 상태값 저장중량중복체크방지
	var chknext=$(".contenton .st_wait").length;

	console.log("setMediCapaSame 약재가 일치해! chkhold = " + chkhold+", chknext = " + chknext);
	//약재가 남은경우
	if(chknext>0)
	{
		if(chkhold < 1)//현재 일치된 약재 상태값 없는경우
		{
			setIngMediCapaSame(passCheck, mdcode, mdpassCapa, thiscapa);
		}
	}
	else
	{
		setLastMediCapaSame(mdcode, mdpassCapa, thiscapa, medigroup);
	}
}
function setIngMediCapaSame(passCheck, mdcode, mdpassCapa, thiscapa)
{
	//---------------------------------------------------------
	var ordercode=$("#ordercode").attr("value");
	var mdbarcode=$(".contenton .st_ing").attr("data-value");
	var jsondata={};
	console.log("setMediCapaSame ordercode = " + ordercode+", mdcode = " + mdcode+", data = " + data);
	jsondata["ordercode"]=ordercode;//주문번호
	jsondata["mediCode"]=mdcode;//스캔받은약재함의코드
	jsondata["medibarcode"]=mdbarcode;//스캔받은약재함바코드
	$(".contenton .st_ing").addClass('addhold');
	if(mdpassCapa!=""){
		jsondata["mediCapa"]="P"+mdpassCapa;//스캔받은약재함의코드
	}
	else
	{									
		jsondata["mediCapa"]=thiscapa;//스캔받은약재함의코드
	}
	jsondata["mbTable"]=getCookie("ck_matable");
	console.log(JSON.stringify(jsondata));
	setMediTxtdt(jsondata);
	callapi('POST',"making",'medicinecapaupdate',jsondata);
	//---------------------------------------------------------
	$("input[name=passCapa]").val(0);
	if(passCheck == false)
	{
		beforestep();
	}
	status_txt=getTxtdt("step41");//일치!! 다음 약재를 스캔하여 주세요
	$("#status_txt").text(status_txt);
	layersign("success",status_txt,'','1000');
}
function setLastMediCapaSame(mdcode, mdpassCapa, thiscapa, medigroup)
{
	$(".contenton .st_ing").addClass('addhold');

	//---------------------------------------------------------
	var ordercode=$("#ordercode").attr("value");
	var mdbarcode=$(".contenton .st_ing").attr("data-value");
	var jsondata={};
	console.log("약재차감 ordercode = " + ordercode+", mdcode = " + mdcode+", data = " + data);
	jsondata["mdCapaLast"]="true";
	jsondata["medigroup"]=medigroup;//medigroup 20190514
	jsondata["ordercode"]=ordercode;//주문번호
	jsondata["mediCode"]=mdcode;//스캔받은약재함의코드
	jsondata["medibarcode"]=mdbarcode;//스캔받은약재함바코드
	if(mdpassCapa!="")
		jsondata["mediCapa"]="P"+mdpassCapa;//스캔받은약재함의용량-패스
	else
		jsondata["mediCapa"]=thiscapa;//스캔받은약재함의용량-일반
	jsondata["mbTable"]=getCookie("ck_matable");

	console.log(JSON.stringify(jsondata));
	setMediTxtdt(jsondata);
	callapi('POST',"making",'medicinecapaupdate',jsondata);
	//---------------------------------------------------------

	//190408 세명대 조제 시간 체크하기 위해 ma_end 시간 추가
	var data="odCode="+ordercode;
	console.log("조제 마치는 시간 여기서 callapi   :"+data);
	callapi('GET','making','makingend',data);
}
function chkDvcNumber(code)
{	
	var len=code.length;
	if(len==11){
		return true;
		//alert(1);
	}else{
		return false;
		//alert(2);
	}
}
function checkbarcode(code)
{
	var islayer=$("#cagediv").html();
	if(islayer!=undefined){
		$("#mainbarcode").val("");
		return;
	}
	var status_txt=data="";
	var process=$("#nav").attr("data-bind")

	code=code.toUpperCase().trim();
	code=code.replace(" ","");

	//20190603 : 조제일지출력의 바코드가 MKD로 시작함..그래서 조제,탕전,마킹,포장에서도 쓸수있게 코드 수정 
	//20190723 : 조제일지 바코드를 MKD에서 ODD로 바꿔서 조제,탕전,마킹,포장에서도 쓸수있게 코드 수정 
	if(process=="making")
	{
		code=code.replace("ODD","MKD");
	}
	else if(process=="decoction")
	{
		code=code.replace("ODD","DED");
	}
	else if(process=="marking")
	{
		code=code.replace("ODD","MRK");
	}
	else if(process=="release")
	{
		code=code.replace("ODD","RED");
	}
	else if(process=="goods")
	{
		code=code.replace("ODD","GDS");
	}
	else if(process=="pill")
	{
		code=code.replace("ODD","PIL");
	}

	console.log("checkbarcode  code = " + code);

	$("#mainbarcode").val("");
	var chk=code.substring(0,3);
	var chkdvc=code.substring(0,1);
	if(chkdvc=="A"){chk="DVC";}
	var sarr=$("#step_info").find("li.on").attr("data-value").split("_");
	var depart=$("#containerDiv").attr("value");

	//20190830 : 송장바코드 스캔받는 부분 
	if(sarr[0]=="DVC")//송장바코드 스캔 단계면 
	{
		if(chkDvcNumber(code)){chk="DVC";}
		else {layersign("warning",'송장바코드가 아닙니다. 다시 스캔해 주세요1'+chkDvcNumber(code)+'.','','1000');}
	}

	
	console.log("checkbarcode code = " + code + ", process = " + process+", chk = " + chk+", chkdvc = " + chkdvc + ", sarr[0] = " + sarr[0]);

	if(sarr[0]=="BLR" && process=="decoction")
	{
		var dc_stat=$("input[name=decocstat]").val();
		var stepbp=$("#decocproc").data("stepbp");
		console.log("dc_stat = " + dc_stat+", stepbp = " + stepbp);
		if(stepbp=="boiler")
		{
			sarr[0]="BLR";
		}
		else if(stepbp=="packing")
		{
			sarr[0]="PCM";
		}
		//if(!isEmpty(dc_stat) && dc_stat=="decoction_processing")
		//{
		//	var stepbp=$("#decocproc").data("stepbp");

			//sarr[0]="PCM";
		//}
	}
	else if(sarr[0]=="PCB" && process=="decoction")
	{
		var stepbp=$("#decocproc").data("stepbp");
		console.log("stepbp = " + stepbp);

		if(stepbp=="boiler")
		{
			sarr[0]="BLR";
		}
		else if(stepbp=="packing")
		{
			sarr[0]="PCM";
		}
	}

	//DOO :: 작업해야함
	if(code=="LOGOUT")//로그아웃
	{
		//makediv("/member/work.php?work=logout");
		return;
	}

	if(chk==sarr[0]||(chk=="RED"&&sarr[0]=="MRK")||(chk=="MDB"&&sarr[0]=="MEI")||(chk=="MEI"&&sarr[0]=="MDB")||(chk=="MEI"&&sarr[0]=="MDT"))
	{
		switch(chk)
		{
		case "MEM"://사원증
			getstaff(code);
			return;
		case "MKD":case "DED":case "MRK":case "RED":case "GDS":case "PIL"://조제,탕제,마킹/포장지시서,약속,제환
			var ordercode=$("#ordercode").attr("value");
			var chking=parseInt($(".content .st_ing").length);
			var chkfinish=parseInt($(".content .st_finish").length);
			var no=$("#step_info").find("li.on").index();
			console.log("ordercode = " + ordercode+", chking = " + chking+", chkfinish = " + chkfinish+", no = " + no);
			if(chk=="MKD"&&chking<1&&chkfinish>0)//조제확인 후
			{
				makingdone(code);
			}
			else if(chk=="DED"&&no==5)//탕전시작마무리
			{
				var stat=$("input[name=decocstat]").val();
				var staffid = getCookie("ck_ntStaffid");
				//console.log("stat  : "+stat);
				if(stat=="decoction_processing")
				{
					var defineprocess=$("#containerDiv").attr("data-value");
					console.log("decoctiondone  code = " + code);
					if(!isEmpty(defineprocess) && defineprocess=="true")//defineprocess true이면 db쿼리 실행
					{
						//makediv("/processing/work.php?work=decoctiondone&code="+ordercode);
						var jsondata={};
						jsondata["odcode"]=ordercode;
						jsondata["decoctionprocess"]="true";
						jsondata["staffid"]=staffid;
						//console.log(JSON.stringify(jsondata));
						callapi('POST','decoction','decoctiondone',jsondata);
					}
					else
					{
						//makediv("/processing/work.php?work=decoctiondone&code="+ordercode);
						var jsondata={};
						jsondata["odcode"]=ordercode;
						jsondata["decoctionprocess"]="false";
						jsondata["staffid"]=staffid;
						//console.log(JSON.stringify(jsondata));
						callapi('POST','decoction','decoctiondone',jsondata);
					}



					getstaffInfo("staffinfo", null);//staff 리스트
					$('#maindiv').text('');  //main 리셋
					$('#procmember').html('');
					$('#procscription').html('');
					$('#procuser').html('');
					$("#addagainphoto").html("");
					gotostep(0);//list로 가기
					cleardiv();
				}
				else
				{
					//makediv("/processing/work.php?work=decocprocessing&code="+ordercode);
					var staffid = getCookie("ck_stStaffid");
					var packingid = getCookie("ck_ntStaffid");
					var jsondata={};
					jsondata["odcode"]=ordercode;
					jsondata["staffid"]=staffid;
					jsondata["packingid"]=packingid;
					callapi('POST','decoction','decocprocessing',jsondata);

					deleteCookie("ck_staffid");

					status_txt = getTxtdt("stepstart");//탕전을 시작 해주세요
					$('#status_txt').text(status_txt);
					layersign('success', status_txt,'','1500');


					getstaffInfo("staffinfo", null);//staff 리스트
					$('#maindiv').text('');  //main 리셋
					$('#procmember').html('');
					$('#procscription').html('');
					$('#procuser').html('');
					$("#addagainphoto").html("");

					gotostep(0);
					cleardiv();
				}
			}
			else if(chk=="MRK"&&process=="marking"&&no==6)//마킹종료// 마킹 Step + 1
			{
				clearIntervalPrint();
				$('#layersign').remove();
				markingdone(ordercode);
			}
			else if((chk=="RED"||chk=="MRK")&&process=="release"&&no==5)//포장종료,작업지시서를 마팅 배송 같이 사용하여 처리
			{
				//makediv("/processing/work.php?work=releasedone&code="+ordercode);
				releasedone(ordercode);
			}
			else if(chk=="GDS"&&process=="goods"&&no==5)//약속처방완료 
			{
				goodsdone(ordercode);
			}
			else if(chk=="PIL"&&process=="pill"&&no==6)//제환처방완료  
			{
				var stat=$("input[name=plMachinestat]").val();
				console.log("stat : " + stat);
				if(stat=="making_apply")
				{
					pilldone(ordercode);
				}
				else
				{
					if(stat.match("_processing"))
					{
						pilldone(ordercode);
					}
					else
					{
						pillprocessing(ordercode);
					}
				}
			}
			else
			{
				checkprocess(sarr[0],"start",code);
			}
			return;
		case "MDB": case "MEI"://약재박스바코드 //약재중량체크

			var scalemode=$("input[name=scaleMode]").val();

			//최초약재바코드스캔
			//console.log("st_wait : " + ($(".contenton .st_wait").length) + ",st_ing : " + ($(".contenton .st_ing").length) + ",st_stop : " + ($(".contenton .st_stop").length)+ ",addhold : " + ($(".contenton .addhold").length)+ ",st_inlast : " + ($(".contenton .st_inlast").length)+", st_stop_33 : " + $(".contenton .st_stop_33").length);
			if(chk=="MDB"&&$(".contenton .st_wait").length > 0&&$(".contenton .st_ing").length < 1)
			{
				checkmedibox(sarr[0],"medibox",code);
			}
			//중량체크중 약재바코드스캔
			if(chk=="MDB"&&$(".contenton .st_wait").length > 0&&$(".contenton .st_ing").length == 1&&$(".contenton .addhold").length == 1)
			{
				checkmedibox(sarr[0],"medibox",code);
			}

			//조제중 선전,일반,후하에서 약재가 부족할때 약재바코드 스캔
			if(chk=="MDB"&&$(".contenton .st_wait").length > 0&&$(".contenton .st_ing").length == 1&&$(".contenton .st_stop_33").length > 0)
			{
				checkmedibox(sarr[0],"medibox",code);
			}

			//별전 바코드 스캔후 처방한 갯수만큼 약재바코드스캔
			if(chk=="MDB"&&$(".contenton .st_wait").length >= 0&&$(".contenton .st_ing").length == 1&&$(".contenton .st_inlast").length > 0)
			{
				checkmedibox(sarr[0],"medibox",code);
			}

			//약재바중량체크
			if(sarr[0]=="MDT")//부직포단계에서 중량이 들어왔을경우
			{
				var medigroup=$(".contenton").attr("id");
				medigroup=medigroup.replace("medibox_", "");
				var pouchtag=$('#pouchtag_'+medigroup).text();

				//Step 전단계로 이동 오류 -hold 제거후 전단계로 이동
				console.log("부직포단계에서 중량이 들어옴  medigroup = "+medigroup+", pouchtag = " + pouchtag);
				if(isEmpty(pouchtag))
				{
					if(scalemode=="Y"&&chk=="MEI"&&$(".contenton .addhold").length == 1)
					{
						//return;
					}
					else
					{
						$(".contenton .addhold").removeClass("addhold").addClass("st_ing");
						beforestep();
					}
				}
				else
				{
					return;
				}
			}
			if(chk=="MEI"&&$(".contenton .st_ing").length < 1)
			{
				status_txt=getTxtdt("step32");
				$("#status_txt").text(status_txt); //약재 바코드를 다시 스캔 해 주세요
				layersign("warning",status_txt,'','1000');
			}
			else if(chk=="MEI")
			{
				//5초(약재완료 후 스냅샷 전 대기)
				clearTimeout(makingID);
				makingID="";

				//현재 진행중인 단계 약재
				var mdcode=$(".contenton .st_ing").attr("data-code");
				var mdbarcode=$(".contenton .st_ing").attr("data-value");
				var mdpass=$(".contenton .st_ing").attr("data-pass");

				var chkmdhold=$(".contenton .addhold").length;
				var chkmdwait=$(".contenton .st_wait").length;
				console.log("mdpass = " + mdpass+", chkmdwait="+chkmdwait+", chkmdhold = " + chkmdhold);

				
				console.log("DOO :: !!  scalemode = " + scalemode);


				//현재 진행중인 단계 약재 기준량
				var meditarget=parseInt($("#meditarget_"+mdcode).attr("value"));
				var passcapa = parseInt($("input[name=passCapa]").val());

				//총약재중량/저장
				var medigroup=$(".contenton").attr("id"); //medigroup 20190514
				var codelen = !isEmpty(code) ? code.length : 0;
				console.log("DOO :: !! code = "+code+", codelen = " + codelen+", medigroup = " + medigroup+", meditarget = " + meditarget+", passcapa = " + passcapa);
				console.log("hold : " + $(".contenton .addhold").length);

				if(scalemode=="Y"&&chk=="MEI"&&$(".contenton .addhold").length == 1)//MEI이고 hold 아이콘( 개별모드일 경우 )이 한개있는 경우
				{

				}
				else
				{
					if(codelen == 10) //입력받은 MEI의 총길이가 10자리일때만 처리한다. 
					{
						if(mdpass.indexOf('P') >= 0 || code != "MEI0000000") //무게가 0이면 처리안함.
						{
							if(mdpass.indexOf('P') >= 0)
							{
								if(code == "MEI0001000")
								{
									
									var mdpassNum=Number(mdpass.replace('P',''));
									data=mdpassNum;

									var passfinish=0;
									$(".contenton .st_finish").each(function(){
										passfinish+=parseInt($(this).children(".weight").children("label").children("input").val());
									});

									data = mdpassNum + passfinish;

									console.log("MEI0001000 if data = " + data+", mdpassNum = "+mdpassNum+", passfinish = " + passfinish);

								}
								else
								{
									data=parseInt(code.substring(3,10)/1000);
									//===> 이것을 parseInt(code.substring(3,10)/100)/10 으로 바꿔서 소수점으로 보여지게 해야함 
									console.log("MEI0001000 else data = " + data);
								}
							}
							else
							{
								data=parseInt(code.substring(3,10)/1000);
							}
							console.log("code = "+code+", data = " + data);
							if(!isNaN(data))
							{
								// 단일약재 중량 표시
								if(scalemode=="Y")
								{
									$("#medipocketcapa").text("0g"); 
								}
								else
								{
									$("#medipocketcapa").text((data)+"g"); 
								}

								//현재 까지 약재 총량
								var finishcapa=thiscapa=0;
								$(".contenton .st_finish").each(function(){
									finishcapa+=parseInt($(this).children(".weight").children("label").children("input").val());
								});


								if(scalemode=="Y")
								{
									thiscapa=data;
								}
								else
								{
									thiscapa=data - finishcapa;
								}
								if(thiscapa<=0) thiscapa=0;
								

								console.log("DOO :: !! data = " + data+", finishcapa = " + finishcapa+", thiscapa = " + thiscapa+", meditarget = " + meditarget);


								//현재 약재량
								$("#medicapa_"+mdcode).val((thiscapa));
								$("#medicapasmall_"+mdcode).html((thiscapa)+"<small>g</small>"); // 전체약재 중량 표시

								$("#nowGram").text(comma(thiscapa));
								$("#totalGram").text(comma(meditarget));

								//수동PASS
								var mdpassCapa = "";
								if(mdpass.indexOf('P')>=0)
								{
									console.log("수동PASS 처리이다!!! ");
									mdpass=mdpass.replace('P','');
									mdpassCapa=mdpass;
									console.log("mdpassCapa = " + mdpassCapa);

									var chkhold=$(".contenton .addhold").length;//현재 일치된 약재 hold 전 상태값 저장중량중복체크방지
									var chknext=$(".contenton .st_wait").length;

									if(scalemode=="Y")
									{
										var chkdata= meditarget + 1;
										var mindata= meditarget - 1; 
									}
									else
									{	
										var chkdata=finishcapa + meditarget + 1;
										var mindata=finishcapa + meditarget - 1;
									}
									//var mindata=finishcapa + meditarget;

									console.log("DOO :: !!  chkdata = " + chkdata+", mindata = " + mindata);

									//약재가 남은경우
									console.log("chknext = " + chknext);
									console.log("chkhold = " + chkhold);
									if(chknext>0)
									{
										if(chkhold < 1)//현재 일치된 약재 상태값 없는경우
										{
											console.log("chkhold < 1 현재 일치된 약재 상태가 없는 경우 ");
											setIngMediCapaSame(false, mdcode, mdpassCapa, thiscapa);
										}
										else if(chkhold > 0)//20190828 :: pass 후에 무게가 들어왔을 경우  처리 
										{
											console.log("chkhold > 0  data = " + data+", mindata = " + mindata+", chkdata = " + chkdata);
											mdpassCapa=0;
											if(data<mindata)
											{	
												console.log("PASS 적다!");
												setMediCapaSmall(mdcode);
											}
											else if(data>chkdata)
											{
												console.log("PASS 크다 !");
												var statper=data - chkdata;
												setMediCapaBig(statper, mdcode);
											}
											else if(data >= mindata && data <= chkdata)
											{
												console.log("PASS 일치하다!");
												$(".contenton .addhold").removeClass('addhold');
												$(".contenton .st_ing").attr('data-pass', "");
												setMediCapaSame(true, mdcode, mdpassCapa, thiscapa, medigroup);
											}
										}
									}
									else //마지막 약재일 경우 
									{
										$(".contenton .addhold").removeClass('addhold');
										$(".contenton .st_ing").attr('data-pass', "");
										console.log("마지막 약재가 pass 일 경우!!! ");
										setLastMediCapaSame(mdcode, mdpassCapa, thiscapa, medigroup);
									}
								}
								else
								{
									console.log("이건 무게를 입력 받았을 경우다!! scalemode = " + scalemode);
									/*
									//기존 1g오버시 
									//현재 진행중인 단계 약재 5% 이하 적정 ----- 1g 오버시 안되게로 수정
									//var chkdata=((meditarget + precapa) * 1.05);
									var chkdata=finishcapa + meditarget + 1;
									var mindata=finishcapa + meditarget;
									*/

									if(scalemode=="Y")
									{
										var chkdata= meditarget + 1;
										//20191105 : 오차범위 -1  
										var mindata= meditarget - 1; 
									}
									else
									{
										var chkdata=finishcapa + meditarget + 1;
										//20191105 : 오차범위 -1  
										var mindata=finishcapa + meditarget - 1; 
									}
									//20191011 : 오차범위 -1 제거 
									//var mindata=finishcapa + meditarget;

									console.log("DOO :: !! chkdata = " + chkdata+", mindata = " + mindata+", meditarget = " + meditarget+", data = "+data+", thiscapa = " + thiscapa);
									if(data<mindata)
									{
										setMediCapaSmall(mdcode);
									}
									else if(data>chkdata)
									{
										var statper=data - chkdata;
										setMediCapaBig(statper, mdcode);
									}
									else if(data >= mindata && data <= chkdata)
									{
										setMediCapaSame(false, mdcode, mdpassCapa, thiscapa, medigroup);
									}
									else
									{
										status_txt = getTxtdt("step40");//약재를 표시된 무게만큼 약재함에 올려주세요
										$("#status_txt").text(status_txt);
									}
								}
							}
						}
					}
				}
				//-------------------------
				//20190401 수량들 다시 셋팅
				//-------------------------
				getsummary();
				//-------------------------
			}
			return;
		case "MDT"://부직포바코드
			checkmedipocket(sarr[0],"medipocket",code);
			return;
		case "BLR"://탕전기바코드
			checkboiler(sarr[0],"boiler",code);
			return;
		case "PCM"://20191106:포장기바코드추가 
			checkpacking(sarr[0],"packing",code);
			return;
		case "PCB"://파우치박스코드
			var ordercode=$("#ordercode").attr("value");
			var no=$("#step_info").find("li.on").index();
			var pouchbox=$("#pouchboxcode").text();
			//console.log("파우치박스코드  ordercode=  " + ordercode+", no = " + no + ", pouchbox = " + pouchbox);
			if(process=="decoction"&&no==4)
			{
				if(!isEmpty(pouchbox))
				{
					if(pouchbox==code)
					{
						status_txt=getTxtdt("step60");  //탕전지시서 바코드를 스캔 해 주세요
						layersign("success",status_txt,'','1000');
						$("#status_txt").text(status_txt);
						nextstep();
					}
					else
					{
						status_txt=getTxtdt("step51");//파우치 바코드가 아닙니다. 다시 파우치 바코드를 스캔 해 주세요
						layersign("success",status_txt,'','1000');
					}
				}
			}
			else if(process=="marking")
			{
				if(pouchbox==code)
				{
					startmarking();
				}
				else
				{
					layersign("warning",getTxtdt("step31"),'','1000');
					$("#status_txt").text(getTxtdt("step32"));
				}
			}
			else if(process=="release")
			{
				var pouchboxcode=$("#pouchboxcode").text();
				if(code==pouchboxcode)
				{
					nextstep();
					status_txt=getTxtdt("step50");
					layersign("success",status_txt,'','1000');
					$("#status_txt").text(status_txt);
				}
				else
				{
					status_txt=getTxtdt("step41");
					layersign("warning",status_txt,'','1000');
					$("#status_txt").text(status_txt);
				}
			}
			return;
		case "PRT"://마킹시작바코드-파우치로이동
			var ordercode=$("#ordercode").attr("value");
			//makediv("/processing/work.php?work=markingprocessing&code="+ordercode);
			markingprocessing(ordercode);
			return;
		case "PRE"://마킹종료바코드-작업지시서로이동
			var ordercode=$("#ordercode").attr("value");
			markingdone(ordercode);
			return;
		case "REC"://누수침전검사
			var ordercode=$("#ordercode").attr("value");
			//console.log("REC 누수침전검사 ordercode = " + ordercode+", code = " + code);
			//---------------------------------------------------------
			//누수침전검사 callapi
			data="ordercode="+ordercode+"&code="+code;
			callapi('GET','release','releaserec',data);
			//---------------------------------------------------------
			return;
		case "RBM"://포장재 검사
			var boxmedi=$("#boxmedi").attr("value");
			//console.log("RBM 포장재 검사 boxmedi = " + boxmedi+", code = " + code);
			if(code==boxmedi)
			{
				layersign("success",getTxtdt("step40"),'','1000');
				nextstep();
			}
			else
			{
				status_txt=getTxtdt("step31");
				$("#status_txt").text(status_txt);
				layersign("warning",status_txt,'','1000');
			}
			return;
		case "RBD"://포장박스 검사
			var boxdeli=$("#boxdeli").attr("value");
			//console.log("RBD 포장박스 검사 boxdeli = " + boxdeli+", code = " + code);
			if(code==boxdeli)
			{
				nextstep();
			}
			else
			{
				status_txt=getTxtdt("step31");
				$("#status_txt").text(status_txt);
				layersign("warning",status_txt,'','1000');
			}
			return;
		case "DVC"://송장바코드
			var ordercode=$("#ordercode").attr("value");
			releasephoto(ordercode, code);
			return;
		default:
			alert("default");
		}
	}
	else
	{
		ignorebarcode(sarr[1]);
	}
}
function releasephoto(code, barcode)
{
	console.log("releasephoto  code = " + code +", barcode  = " + barcode);
	//송장바코드업데이트
	barcode=barcode.replace("A", "");

	//복약지도프린트
	qmcode=code.replace("ODD", "QMC");

	//---------------------------------------------------------
	//releasephoto callapi
	var jsondata={};
	jsondata["code"]=code;
	jsondata["barcode"]=barcode;
	callapi('POST','release','releasephoto',jsondata);
	//---------------------------------------------------------
}
function markingprocessing(code)
{
	//---------------------------------------------------------
	//markingprocessing callapi
	var jsondata={};
	jsondata["code"]=code;
	//console.log("======= 마킹시작바코드-파우치로이동 markingprocessing api 호출  ");
	//console.log(JSON.stringify(jsondata));
	callapi('POST','marking','markingprocessing',jsondata);
	//---------------------------------------------------------
	layersign('success',getTxtdt("step43"),'','1000');
	$('#maindiv').text('');
	$("#addagainphoto").html("");
	gotostep(1);
	cleardiv();
}
function makingdone(code)
{
	var defineprocess=$("#containerDiv").attr("data-value");
	var odcode=$("#ordercode").attr("value");
	var compareodcode=odcode.replace("ODD","MKD");
	console.log("code = " + code+", odcode = " + odcode);

	if(!isEmpty(code) && !isEmpty(compareodcode) && code == compareodcode)
	{
		if(!isEmpty(defineprocess) && defineprocess=="true")//defineprocess true이면 db쿼리 실행
		{
			//---------------------------------------------------------
			//조제확인 후 making_done callapi
			var jsondata={};
			jsondata["code"]=odcode;
			jsondata["defineprocess"]="true";
			callapi('POST','making','makingdone',jsondata);
			//---------------------------------------------------------
		}
		else
		{
			//---------------------------------------------------------
			//조제확인 후 making_done callapi
			var jsondata={};
			jsondata["code"]=odcode;
			jsondata["defineprocess"]="false";
			callapi('POST','making','makingdone',jsondata);
			//---------------------------------------------------------
		}
	}
	else
	{
		status_txt=getTxtdt("step62");//시작한 조제 지시서가 아닙니다. 다시 조제 지시서를 확인해 주세요.
		$('#status_txt').text(status_txt);
		layersign('success',status_txt,'','1000');
	}
}
function makingdoneNext()
{
	status_txt=getTxtdt("step20");//조제지시서 바코드를 스캔 해 주세요
	$('#status_txt').text(status_txt);
	status_txt=getTxtdt("step61");//조제작업이 완료되었습니다.
	layersign('success',status_txt,'','1000');
	gomainload("../_Inc/list.php?depart=making");
	$('#procmember').html('');
	$('#procscription').html('');
	$('#procuser').html('');
	$('#gram').html('');
	$("#addagainphoto").html("");
	gotostep(1);
	cleardiv();
}
function releasedone(code)
{
	var defineprocess=$("#containerDiv").attr("data-value");
	console.log("releasedone  code = " + code);
	if(!isEmpty(defineprocess) && defineprocess=="true")//defineprocess true이면 db쿼리 실행
	{
		//---------------------------------------------------------
		//releasedone callapi
		var jsondata={};
		jsondata["code"]=code;
		jsondata["defineprocess"]="true";
		callapi('POST','release','releasedone',jsondata);
		//---------------------------------------------------------
	}
	else
	{
		//---------------------------------------------------------
		//releasedone callapi
		var jsondata={};
		jsondata["code"]=code;
		jsondata["defineprocess"]="false";		
		callapi('POST','release','releasedone',jsondata);
		//---------------------------------------------------------
	}

	status_txt=getTxtdt("step20");//조제지시서 바코드를 스캔 해 주세요
	$('#status_txt').text(status_txt);

	layersign('success',getTxtdt("stepdone"),'','1000');
	gomainload("../_Inc/list.php?depart=release");
	$('#procmember').html('');
	$('#procscription').html('');
	$('#procuser').html('');
	$("#addagainphoto").html("");
	gotostep(1);
	cleardiv();
}
function pilldone(code)
{
	var outcapa=$("input[name=outcapa]").val();
	var opjson=$("textarea[name=opjson]").val();
	var pilltype=getCookie("ck_pilltype");
	var plMachine=$("input[name=plMachine]").val();

	var jsondata={};
	jsondata["odcode"]=code;
	jsondata["outcapa"]=outcapa;//machinlog / capa에 저장 
	jsondata["opjson"]=opjson;
	jsondata["pilltype"]=pilltype;
	jsondata["plMachine"]=plMachine;
	

	callapi('POST','pill','pilldone',jsondata);

	var status_txt=$("input[name=pilltypeName]").val()+" 완료되었습니다.";
	$('#status_txt').text(status_txt);
	layersign('success', status_txt,'','1500');

	getstaffInfo("staffinfo", null);//staff 리스트
	$('#maindiv').text('');  //main 리셋
	$('#procmember').html('');
	$('#procscription').html('');
	$('#procuser').html('');

	viewpilltable("maindiv", getPillList(), getCookie("ck_pilltype"));

	gotostep(0);
	cleardiv();

}
function pillprocessing(code)
{
	var staffid = getCookie("ck_stStaffid");
	var plMachine=$("input[name=plMachine]").val();
	var opjson=$("textarea[name=opjson]").val();

	var stat=$("input[name=plMachinestat]").val();
	var newstat=stat;
	if(stat.match("_apply"))
	{
		newstat=stat.replace("_apply", "_processing");
	}

	var jsondata={};
	jsondata["odcode"]=code;
	jsondata["staffid"]=staffid;
	jsondata["machinestat"]=newstat;
	jsondata["plMachine"]=plMachine;
	jsondata["opjson"]=opjson;

	callapi('POST','pill','pillprocessing',jsondata);

	status_txt=$("input[name=pilltypeName]").val()+"를 시작해 주세요.";
	$('#status_txt').text(status_txt);
	layersign('success', status_txt,'','1500');


	getstaffInfo("staffinfo", null);//staff 리스트
	$('#maindiv').text('');  //main 리셋
	$('#procmember').html('');
	$('#procscription').html('');
	$('#procuser').html('');

	viewpilltable("maindiv", getPillList(), getCookie("ck_pilltype"));

	gotostep(0);
	cleardiv();
}
function goodsdone(code)
{
	console.log("약속포장마지막이다");
	var defineprocess=$("#containerDiv").attr("data-value");
	console.log("goodsdone  code = " + code);

	//---------------------------------------------------------
	//goodsdone callapi
	var jsondata={};
	jsondata["code"]=code;
	if(!isEmpty(defineprocess) && defineprocess=="true")
	{
		jsondata["defineprocess"]="true";
	}
	else
	{
		jsondata["defineprocess"]="false";
	}
	callapi('POST','goods','goodsdone',jsondata);
	//---------------------------------------------------------

	status_txt=getTxtdt("step20");//작업지시서 바코드를 스캔 해 주세요
	$('#status_txt').text(status_txt);

	layersign('success',getTxtdt("stepdone"),'','1000');//출고가 완료되었습니다
	gomainload("../_Inc/list.php?depart=goods");
	$('#procmember').html('');
	$('#procscription').html('');
	$('#procuser').html('');
	$("#addagainphoto").html("");
	gotostep(1);
	cleardiv();
}
function markingdone(ordercode)
{
	console.log("markingdone  ordercode = " + ordercode);
	var defineprocess=$("#containerDiv").attr("data-value");
	//makediv("/processing/work.php?work=markingdone&code="+ordercode);
	if(!isEmpty(defineprocess) && defineprocess=="true")//defineprocess true이면 db쿼리 실행
	{
		//---------------------------------------------------------
		//markingdone callapi
		var jsondata={};
		jsondata["code"]=ordercode;
		jsondata["defineprocess"]="true";
		callapi('POST','marking','markingdone',jsondata);
		//---------------------------------------------------------
	}
	else 
	{
		//---------------------------------------------------------
		//markingdone callapi
		var jsondata={};
		jsondata["code"]=ordercode;
		jsondata["defineprocess"]="false";
		callapi('POST','marking','markingdone',jsondata);
		//---------------------------------------------------------
	}

	layersign('success',getTxtdt("step45"),'','1000'); //마킹작업이 완료되었습니다.
	gomainload("../_Inc/list.php?depart=marking");
	$('#procmember').html('');
	$('#procscription').html('');
	$('#procuser').html('');
	$("#addagainphoto").html("");
	gotostep(1);
	cleardiv();
}
function ignorebarcode(code)
{
	var txt=$("#status_txt").text($("#"+code).val());
}
function keydown_barcode(obj, event)
{
	if(event.keyCode == 13)
	{
		checkbarcode(obj.value);
	}
}
function viewbacodearea(pgid, list)
{
	var txt="<aside>";
		txt+="<span class='scan'>";
		txt+="<input type='text' id='mainbarcode' name='mainbarcode' class='mainbarcode' style='ime-mode:disabled;' placeholder='Bar Code SCAN' onkeydown='keydown_barcode(this, event);'>";
		txt+="</span>";
		txt+="<span class='info_txt' id='status_txt'>"+list[0]["status"]+"</span>";
		txt+="<div id='addagainphoto'></div>";
		txt+="<span class='logoutbarcode' onclick='javascript:gologout();'><span class='barimg'><img src='data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAGUAAAAyCAIAAADKlYLXAAAAqElEQVRoge3QQQoCMRAAwcH//zkeBAkmin2vOizZYXcIPTMzM2ut13M/nK/7x+eP5/w8fFv7/4Yf54/hvvw6uW64XuM9eQyFXo1ejV6NXo1ejV6NXo1ejV6NXo1ejV6NXo1ejV6NXo1ejV6NXo1ejV6NXo1ejV6NXo1ejV6NXo1ejV6NXo1ejV6NXo1ejV6NXo1ejV6NXo1ejV6NXo1ejV6NXo1ejV7NE83YjNbgU387AAAAAElFTkSuQmCC'></span>LOGOUT</span>";
		txt+="</aside>";
	$("#"+pgid).prepend(txt);
}
function againPhoto()
{
	var depart=$("#containerDiv").attr("value");
	document.getElementById('snapshot').style.display = 'block';
	$('#snapshot').html('<div style=\"font-size:30px;font-weight:bold;margin:200px 0 0 230px;\">2'+getTxtdt("stepphoto")+'</div>').fadeIn(0);
	if(depart=="making")
	{
		var id=$(".contenton").attr("id");
		if(!isEmpty(id))
		{
			var arry=id.split("_");
			medigroup=arry[1];
		}
		else
		{
			medigroup="inmain";
		}

		setTimeout("snapshot('"+medigroup+"','')",2000);
	}
	else if(depart=="release")
	{
		setTimeout("snapshot('medibox','')",2000);
	}	
	else if(depart=="goods")
	{
		setTimeout("snapshot('component','')",2000);
	}
}
function makinggostep()
{
	console.log("makinggostepmakinggostepmakinggostepmakinggostep  gotostep(5) ");
	gotostep(5);
	$("#addagainphoto").html("");
	setAgainPhoto();

	//setTimeout(function(){
		//layersign("success",getTxtData("9001"), "",'confirm_making');//정량을 확인 후 정상일 경우 작업지시서를 스캔해 주세요
	//}, 1000);	
}
function setAgainPhoto()
{
	$("#addagainphoto").html("");
	var data="<div style='position:fixed;top:10px;right:150px;width:120px;border:1px solid #999;padding:10px;text-align:center;font-size:20px;font-weight:bold;color:#fff;border-radius:3px;' onclick='againPhoto();'>"+getTxtData("9003")+"</div>";
	$("#addagainphoto").html(data);
}
function viewstatusstep(pgid, list, language)
{
	var len = list["list"].length;
	var chkcode = stattxt = cls = last = "";
	var cnt = stepstat = 1;
	var chk = gab = tlen = 0;
	var stepcnt = list["stepcnt"];
	var chkData = "문자열체크";
	for(i=0;i<len;i++)
	{
		gab = 15;
		if(cnt==stepstat){cls=" on";}else{cls=" ";}

		chk = chkData.length;
		if(chk == 5)
		{
			tlen = Number(list["list"][i]["status"].length);
			if(language=="chn"){gab=22;}else{gab=15;}
		}
		else
		{
			tlen = Number(list["list"][i]["status"].length) / 3;
			gab=22;
		}

		if(stepcnt==cnt)
		{
			if(pgid!="step_info")
				last = "";
			else
				last="margin-left:-120px;";
		}else{last="";}

		stattxt+="<li class='"+cls+"' data-value='"+list["list"][i]["barcode"]+"'><dfn>STEP 0"+cnt+"</dfn><span class='txt' id='"+pgid+"_"+list["list"][i]["barcode"]+"' style='width:"+(tlen * gab)+"px;"+last+"'>"+list["list"][i]["status"]+"</span></li>";
		cnt++;
	}
	$("#"+pgid).html(stattxt);
	if(pgid == 'step_info')
		$("#"+pgid).addClass("step"+list["cnt"]);
}
//================================================================
// step
//================================================================
function beforestep()
{
	var cnt=$("#step_info li").length;
	var no=$("#step_info").find("li.on").index() - 1;
	//console.log("beforestep  no :: " + no);
	$(".sect_step li").removeClass("on");
	$(".sect_step li:eq("+no+")").addClass("on");
	$("#step_info li").removeClass("on");
	$("#step_info li:eq("+no+")").addClass("on");
}
function nextstep()
{
	var cnt=$("#step_info li").length;
	var no=$("#step_info").find("li.on").index() + 1;

	//console.log("nextstep  no :: " + no);

	if(cnt>no)
	{
		var newdata="";
		var hdata=location.hash.split("/");
		for(var i=1;i<hdata.length;i++)
		{
			newdata+="/"+hdata[i];
		}
		$(".sect_step li").removeClass("on");
		$(".sect_step li:eq("+no+")").addClass("on");
		$("#step_info li").removeClass("on");
		$("#step_info li:eq("+no+")").addClass("on");
	}
	else
	{
		$(".sect_step li").removeClass("on");
		$(".sect_step li:eq(1)").addClass("on");
		$("#step_info li").removeClass("on");
		$("#step_info li:eq(1)").addClass("on");
		layersign("success",getTxtData("WORKDONE"), getTxtData("WORKDONETXT"),'2000');
		//작업완료
		//작업이 완료되었습니다
	}
}

function gotostep(cnt)
{
	//console.log("gotostep  no :: " + cnt);
	$(".sect_step li").removeClass("on");
	$(".sect_step li:eq("+cnt+")").addClass("on");
	$("#step_info li").removeClass("on");
	$("#step_info li:eq("+cnt+")").addClass("on");
}
//================================================================
//staff바코드
function getstaff(code)
{
	console.log("getstaff  code="+code);
	var depart=$("#step_info").parent().attr("id");
	var chk="Y";
	if(depart=="making")
	{
		var tbl=$("#making").attr("value");
		if(!isEmpty(tbl))
		{
			chk="Y";
		}
		else
		{
			layersign("warning",getTxtdt("steptatitle"),getTxtdt("steptacontent"),'2000');//조제대를 먼저 선택해 주세요.
			chk="N";
		}
	}
	else if(depart=="marking")
	{
		var tbl=$("#marking").attr("value");
		if(!isEmpty(tbl))
		{
			chk="Y";
		}
		else
		{
			layersign("warning",getTxtData("9007"),getTxtData("9008"),'2000');//마킹프린터를 먼저 선택해 주세요.
			chk="N";
		}
	}
	else if(depart=="pill")
	{
		var tbl=$("#pill").attr("value");
		if(!isEmpty(tbl))
		{
			chk="Y";
		}
		else
		{
			layersign("warning","진행할 작업을 선택해 주세요.","",'2000');//작업할 
			chk="N";
		}
	}
	if(chk=="Y")
	{
		callapi('GET','common','getstaff','code='+code+"&depart="+depart); //getstaff
	}
}
//================================================================
//프로세스
function checkprocess(proc,stat,code)
{
	var chk=proccode=ahd=data=maTable=staffid="";
	var depart=$("#step_info").parent().attr("id");

	console.log("checkprocess  proc = " + proc+", stat = " + stat+", code= " + code);

	if(depart=="release")
	{
		code=code.replace("MRK","RED");
		proc = "RED";
		stat = "RED_start";
	}
	else
	{
		stat = proc + "_" + stat;
	}

	chk=stat.split("_");

	if(chk[1]=="start")
	{
		switch(proc)
		{
			case "MKD": proccode="making"; ahd="ma"; stat="making_start";break;
			case "DED": proccode="decoction"; ahd="dc"; stat="decoction_start"; break;
			case "MRK": proccode="marking"; ahd="mr"; stat="marking_start"; break;
			case "RED": proccode="release"; ahd="re"; stat="release_start"; break;
			case "GDS": proccode="goods"; ahd="gp"; stat="goods_start"; break;
			case "PIL": proccode="pill"; ahd="pl"; stat="pill_start"; break;
		}
	}

	//쿠키값
	maTable = getCookie("ck_matable");
	staffid = getCookie("ck_ntStaffid");
	mpPrinter=getCookie("ck_mrPrinter");

	data="proc="+proc+"&proccode="+proccode+"&ahd="+ahd+"&stat="+stat+"&code="+code+"&depart="+depart+"&maTable="+maTable+"&staffid="+staffid+"&mpPrinter="+mpPrinter;
	console.log("checkprocess proc = " + proc+", stat = " + stat+", code = " + code+", depart = " + depart + ", data = " + data);
	callapi('GET',depart,'checkprocess',data);

}
//약재바코드
function checkmedibox(proc,stat,code)
{
	var depart=$("#step_info").parent().attr("id");
	var medigroup=$(".contenton").attr("id");
	var odcode=$("#ordercode").attr("value");
	var mediwait="";
	$(".contenton .st_wait").each(function()
	{
		mediwait+=","+$(this).attr("data-code");
	});
	var medihold=$(".contenton .addhold").attr("data-code");
	if(isEmpty(medihold))
	{
		medihold="";
	}
	var st_inlast=$(".contenton .st_inlast").attr("data-code");
	if(isEmpty(st_inlast))
	{
		st_inlast="";
	}
	//var maTable = getCookie("ck_matable");
	var url="depart="+depart+"&proc="+proc+"&stat="+proc+"_"+stat+"&code="+code+"&medigroup="+medigroup+"&odcode="+odcode;
		url+="&mediwait="+mediwait+"&medihold="+medihold+"&st_inlast="+st_inlast;

	console.log("checkmedibox proc="+proc+", stat="+stat+",code="+code+", url="+url);
	callapi('GET',depart,'checkmedibox',url);
}
//부직포바코드
function checkmedipocket(proc,stat,code)
{
	var depart=$("#step_info").parent().attr("id");
	var medigroup=nextmedigroup=chk2="";
	var chk="N";
	if(depart=="making")
	{
		$(".content").each(function()
		{
			var marr=$(this).attr("id").split("_");
			if($(this).hasClass("contenton")==true)
			{
				chk="Y";
				medigroup=marr[1];
			}
			if(chk=="Y"&&medigroup!=marr[1])
			{
				nextmedigroup=marr[1];
				chk="N";
			}
		});

		$("#nowGram").text("0");
		$("#totalGram").text("0");
		$('#pouchtag_'+medigroup).text(code);
	}
	
	

	var odcode=$("#ordercode").attr("value");
	var data="depart="+depart+"&proc="+proc+"&stat="+proc+"_"+stat+"&code="+code+"&odcode="+odcode+"&medigroup="+medigroup+"&nextmedigroup="+nextmedigroup;
	console.log("checkmedipocket  data="+data);

	if(nextmedigroup=="inlast")
	{
		$('#nowGramRight').text('ea');
		$('#totalGramRight').text('ea');
	}
	else
	{
		$('#nowGramRight').text('g');
		$('#totalGramRight').text('g');
	}
	callapi('GET',depart,'checkmedipocket',data);
}
//탕전바코드
function checkboiler(proc,stat,code)
{
	var depart=$("#step_info").parent().attr("id");
	var medigroup=nextmedigroup=chk2="";
	var chk="N";
	var odcode=$("#ordercode").attr("value");
	var data="depart="+depart+"&proc="+proc+"&stat="+proc+"_"+stat+"&code="+code+"&odcode="+odcode+"&medigroup="+medigroup+"&nextmedigroup="+nextmedigroup;
	console.log("checkboiler  data      :"+data);

	callapi('GET',depart,'checkboiler',data);
}
//20191106:포장기바코드
function checkpacking(proc,stat,code)
{
	var depart=$("#step_info").parent().attr("id");
	var medigroup=nextmedigroup=chk2="";
	var chk="N";
	var odcode=$("#ordercode").attr("value");
	var data="depart="+depart+"&proc="+proc+"&stat="+proc+"_"+stat+"&code="+code+"&odcode="+odcode+"&medigroup="+medigroup+"&nextmedigroup="+nextmedigroup;
	console.log("checkpacking  data:"+data);

	callapi('GET',depart,'checkpacking',data);
}
//================================================================
function changeprocess(proc,stat,code,wkcode)
{
	var depart=$("#step_info").parent().attr("id");
	var data=returnData="";
	var chkstat=stat.split("_");
	if(proc==chkstat[0])
	{
		returnData="./main.php?code="+wkcode;
	}
	data="stat="+stat+"&code="+code+"&proc="+proc+"&returnData="+returnData;

	console.log("changeprocess data="+data);

	callapi('GET',depart,'changeprocess',data);
}
function setboiler(code)
{
	var no=$("#step_info").find("li.on").index();
	console.log("setboiler no = " + no);
	if(no==3||no==4)
	{
		//var chkready=parseInt($("#"+code+".ready").length);
		var chkstandby=parseInt($("#"+code+".standby").length);
		var chkselect=parseInt($("#"+code+".select").length);
		console.log("chkselect = "+chkselect+", chkstandby = " + chkstandby);
		if(chkstandby>0 || chkselect>0)
		{
			$("li.select .stxt").text("대기");
			$("li").removeClass("select");
			$("#"+code).addClass("select");
			$("#"+code+" a .stxt").text("선택");
			$("#mainbarcode").val(code);
			checkbarcode(code);
			$("#mainbarcode").trigger("focus");
		}
	}
}
function setpacking(code)
{
	var no=$("#step_info").find("li.on").index();
	console.log("setpacking no = " + no);
	if(no==3||no==4)
	{
		//var chkready=parseInt($("#"+code+".ready").length);
		var chkstandby=parseInt($("#"+code+".standby").length);
		if(chkstandby>0)
		{
			$("li.select .stxt").text("대기");
			$("li").removeClass("select");
			$("#"+code).addClass("select");
			$("#"+code+" a .stxt").text("선택");
			$("#mainbarcode").val(code);
			checkbarcode(code);
			$("#mainbarcode").trigger("focus");
		}
	}
}
//================================================================
function processmember(data)
{
	var txt="";
	txt="<dl id=\"ordercode\" value=\""+data["od_code"]+"\" data-seq=\""+data["od_seq"]+"\" data-userid=\""+data["od_userid"]+"\">";   //ODD180831
	txt+="<dd><em class=\"name\">"+data["mi_name"]+"</em>";// //돌팔한의원
	txt+="<em class=\"name\">/"+data["od_staff"]+"</em></dd>"; //돌팔이
	txt+="<dt>"+getTxtData("SCDATE")+"</dt>";  //처방일  <?=$txtdt["scdate"]?>
	txt+="<dd>"+data["od_date"]+"</dd>";   //처방날짜 2018-08-31
	txt+="<dt>"+getTxtData("SCNO")+"</dt>";   //처방번호  <?=$txtdt["scno"]?>
	txt+="<dd>"+data["od_code"]+"</dd>";   //ODD180831
	txt+="</dl>";
	return txt;
}
function goodsscription(data)
{
	var txt="";
		txt="<dl>";
		txt+="<dt>"+getTxtData("SCRIPTION")+"</dt>";// 처방명
		txt+="<dd>"+data["od_title"]+"</dd>";
		txt+="</dl>";
	return txt;
}
function processscription(data, medi)
{
	var txt=meditotal=packtype="";
		meditotal = parseFloat(medi["medicapa"])*parseFloat(data["od_chubcnt"]);
		packtype=isEmpty(data["packtype"]) ? "":data["packtype"];
		txt="<dl>";
		txt+="<dt>"+getTxtData("SCRIPTION")+"</dt>";   //<?=$txtdt["scription"]?> 처방명
		txt+="<dd>"+data["od_title"]+""+data["od_chubcnt"]+"첩</dd>";  //$txtdt["chub"]
		txt+="</dl>";
		txt+="<ul>";
		txt+="<li>";
		txt+="<dfn>"+getTxtData("TOTMEDICAPA")+"</dfn>"; //<?=$txtdt["totmedicapa"]?> 약재총량
		txt+="<span>"+meditotal+"<small> g</small></span>";
		txt+="</li>";
		txt+="<li>";
		txt+="<dfn>"+getTxtData("DANG")+"</dfn>";   //<?=$txtdt["chub"]?><?=$txtdt["dang"]?> 첩당
		//txt.="<span>".viewno($medi["medicapa"])."<small> g</small></span>";
		txt+="<span>"+medi["medicapa"]+"<small> g</small></span>";
		txt+="</li>";
		txt+="</ul>";
		txt+="<ul class=\"type2\">";
		txt+="<li>";
		txt+="<dfn>"+getTxtData("PACKCNT")+"</dfn>";    //<?=$txtdt["packcnt"]?> 팩수
		txt+="<span>"+data["od_packcnt"]+"<small>EA</small></span>";
		txt+="</li>";
		txt+="<li>";
		txt+="<dfn>"+getTxtData("PACKCAPA")+"</dfn>"; //<?=$txtdt["packcapa"]?> 팩용량
		txt+="<span>"+data["od_packcapa"]+"<small>ml</small></span>";
		txt+="</li>";
		txt+="<li>";
		txt+="<dfn>"+getTxtData("PACKTYPE")+"</dfn>";   // <?=$txtdt["packtype"]?> 팩종류
		txt+="<span id='lpacktype'>"+packtype+"</span>";
		txt+="</li>";
		txt+="</ul>";
	return txt;
}
function processuser(data)
{
	var txt="";
	var addr=!isEmpty(data["re_address"])?data["re_address"]:"";
	txt="<dl>";
	txt+="<dt>"+getTxtData("PATIENT")+"</dt>";  //<?=$txtdt["patient"]?> 복용자 
	txt+="<dd><em class=\"name\">"+data["re_name"]+"</em></dd>";
	txt+="</dl>";
	txt+="<dl>";
	txt+="<dt></dt>";  //<?=$txtdt["dladdress"]?>
	txt+="<dd>"+addr+"</dd>";
	txt+="</dl>";
	//console.log("processuser************"+txt);
	return txt;
}
//================================================================
//orderlist
function viewOrderList(list, tpage, page, block, psize)
{
	var data = "";
	if(!isEmpty(list))
	{
		$(list).each(function( index, value )
		{
			data+="<tr>";
			data+="	<td>"+value["odDate"]+"<i class='ic_new'>new</i></td>";
			data+="	<td onclick=\"insbarcode('','"+value["odCode"]+"')\">"+value["odCode"]+"</td>";
			data+="	<td>"+value["company"]+" / "+value["reName"]+"</td>";
			data+="	<td>"+value["odTitle"]+"</td>";
			data+="	<td>"+value["odStatusName"]+"</td>";
			data+="</tr>";
		});
	}
	else
	{
		data+="<tr>";
		data+="	<td colspan='5'>"+getTxtData("NODATA")+"</td>";
		data+="</tr>";
	}
	//테이블에 넣기
	$("#listtbl tbody").html(data);
	//페이징
	getsubpage("orderlistpage",tpage, page, block, psize);
}
//getstaff
function viewGetStaff(data, depart)
{
	var status_txt=st_depart="";
	if(!isEmpty(data["stSeq"]))
	{
		//20191108:두번째로그인한 staff의 ID쿠키로 생성하자
		setCookie("ck_ntStaffid", data["stStaffid"], 365);
		if(data["stDepart"]==depart)
		{
			//marking : 님 안녕하세요
			//making : 조제사님 안녕하세요
			//decoction : 탕전사님 안녕하세요
			//release : 님 안녕하세요
			status_txt = data["stName"] + " " + getTxtdt("step11");//님 안녕하세요
			$('#status_txt').text(status_txt);
			layersign('success', status_txt,'','1000');
			getstaffInfo("staffinfo", data);//staff 리스트
			st_depart = data["stDepart"];
			gomainload("../_Inc/list.php?depart="+st_depart);
			nextstep();
		}
		else
		{
			//marking : 마킹 권한이 없습니다. 다시 확인해 주세요
			//making : 조제권한이 없습니다. 다시 확인 해 주세요
			//decoction : 탕전권한이 없습니다. 다시 확인 해 주세요
			//release : 포장검수 권한이 없습니다. 다시 확인 해 주세요
			status_txt = getTxtdt("step12");//마킹 권한이 없습니다. 다시 확인해 주세요
			$('#status_txt').text(status_txt);
			layersign('warning', status_txt,'','1000');
		}
	}
	else
	{
		//marking : 사원증 바코드를 다시 스캔 해 주세요
		//making : 사원증 바코드를 다시 스캔 해 주세요
		//decoction : 사원증 바코드를 다시 스캔 해 주세요
		//release : 사원증 바코드를 다시 스캔 해 주세요
		status_txt = getTxtdt("step13");//사원증 바코드를 다시 스캔 해 주세요
		$('#status_txt').text(status_txt);
		layersign('warning', status_txt,'','1000');
	}
}

//checkprocess
function viewCheckProcess(depart, data, medi, proccode, code, stat)
{
	//console.log(data);
	var status_txt=od_code=status="";
	if(!isEmpty(data))
	{
		od_code=data["od_code"];
		status=data["od_status"];
		$("#maTypeName").text(data["maTypeName"]);
	}
	else
	{
		od_code="";
		status="";
		$("#maTypeName").text("");
	}

	console.log("viewCheckProcess od_code =  " + od_code+", status = "+status+", code = " + code+", proccode = " + proccode);
	//console.log(data);

	if(!isEmpty(od_code) && (!isEmpty(status)&&status.indexOf(proccode) >=0))
	{
		var member=processmember(data);
		var scription="";
		if(proccode=="goods"||proccode=="pill")
		{
			scription=goodsscription(data);
		}
		else
		{
			scription=processscription(data, medi);
		}
		var user=processuser(data);
		$('#procmember').html(member);
		$('#procscription').html(scription);
		$('#procuser').html(user);


		var gramview="";
		if(proccode == "making")
		{
			gramview = gramtxt();
			$('#gram').html(gramview);
		}

		var status = proccode+"_processing";

		console.log("viewCheckProcess status =  " + status+", odStatus = " + data["od_status"]);
		if(data["od_status"]==status)
		{
			//--------------------------------------------------------
			//DOO :: 나중에 로그인 작업 후 cookie로 바꿔야함.
			var staffid = getCookie("ck_ntStaffid");
			console.log("viewCheckProcess staffid =  " + staffid+", code = " + code);
			//--------------------------------------------------------
			//---------------------------------------------------------
			//작업자 업데이트
			var jsondata={};
			jsondata["staffid"]=staffid;
			jsondata["code"]=code;
			callapi('POST',depart,'staffupdate',jsondata);
			
			//---------------------------------------------------------

			if(proccode=="decoction")
			{
				//20191106 : 포장기 추가 
				gotostep(3);
			}
			else if(proccode=="marking")
			{
				//marking : 파우치 바코드를 스캔 해 주세요
				//making : 약재 바코드를 스캔 해 주세요
				//decoction : 부직포 바코드를 모두 스캔 해주세요
				//release : 한약박스 바코드를 스캔해주세요
				status_txt = getTxtdt('step30');//약재 바코드를 스캔 해 주세요
				$('#status_txt').text(status_txt);
				layersign('warning', status_txt,'','1000');
				nextstep();
			}
			else if(proccode=="pill")
			{
				var pl_machinestat=data["pl_machinestat"];
				console.log(data);
				console.log("viewCheckProcess pl_machinestat = " + pl_machinestat);
				if(!isEmpty(pl_machinestat)&&pl_machinestat.match("_apply"))
				{
					console.log("viewCheckProcess pill gotostep 3333");	
					status_txt = getTxtdt('step30');//장비를 스캔해 주세요.
					$('#status_txt').text(status_txt);
					layersign('success', status_txt,'','1000');
					gotostep(2);
				}
			}

			gomainload("../"+depart+"/main.php?code="+data["barcode"]);
		}
		else
		{
			//--------------------------------------------------------
			//DOO :: 나중에 로그인 작업 후 cookie로 바꿔야함.
			var staffid = getCookie("ck_ntStaffid");
			console.log("viewCheckProcess staffid =  " + staffid+", code = " + code);
			//--------------------------------------------------------
			//---------------------------------------------------------
			//작업자 업데이트
			var jsondata={};
			jsondata["staffid"]=staffid;
			jsondata["code"]=code;
			callapi('POST',depart,'staffupdate',jsondata);
			
			//---------------------------------------------------------

			if(proccode=="marking")
			{
				//marking : 파우치 바코드를 스캔 해 주세요
				//making : 약재 바코드를 스캔 해 주세요
				//decoction : 부직포 바코드를 모두 스캔 해주세요
				//release : 한약박스 바코드를 스캔해주세요
				status_txt = getTxtdt('step30');//약재 바코드를 스캔 해 주세요
				$('#status_txt').text(status_txt);
				layersign('success', status_txt,'','1000');
				gomainload("../"+depart+"/main.php?code="+data["barcode"]);
			}
			else if(proccode=="pill")
			{
				status_txt = getTxtdt('step30'); //장비를 선택해 주세요.
				$('#status_txt').text(status_txt);
				layersign('success', status_txt,'','1000');
				gomainload("../"+depart+"/main.php?code="+data["barcode"]+"&stat="+data["od_status"]+"&ordercode="+data["od_code"]);
				changeprocess(proccode,stat,od_code,code);
			}
			else
			{
				//marking : 마킹지시서 바코드를 다시 스캔 해 주세요
				//making : []님의 조제작업을 시작 해 주세요
				//decoction : 탕전 부직포를 확인해 주세요
				//release : []님, 검수 및 포장 작업을 시작 해 주세요
				status_txt = getTxtdt('step21');//[]님의 조제작업을 시작 해 주세요
				status_txt = status_txt.replace('[]',data["re_name"]);
				$('#status_txt').text(status_txt);
				layersign('success', status_txt,'','1000');
				gomainload("../"+depart+"/main.php?code="+data["barcode"]+"&stat="+data["od_status"]+"&ordercode="+data["od_code"]);
				changeprocess(proccode,stat,od_code,code);
			}

			if(proccode=="release")//문서출력
			{
				//DOO :: 송장프린트 작업
			}

			nextstep();
		}
	}
	else
	{

		/*
		"9014"=>$txtdt["9014"],
		"9015"=>$txtdt["9015"],//중지된 지시서 입니다.
		"9016"=>$txtdt["9016"],//완료된 지시서 입니다.
		"9017"=>$txtdt["9017"],//다른 작업자가 진행중입니다.
		"9018"=>$txtdt["9018"],//다른 조제대에서 진행중입니다.
		*/
		var small_txt="";
		if(!isEmpty(data))
		{
			if(!isEmpty(data["status"]) &&  data["status"].indexOf("cancel") >=0 )
			{
				status_txt = getTxtData("9014");//취소된 지시서 입니다.
			}
			else if(!isEmpty(data["status"]) && data["status"].indexOf("stop") >=0 )
			{
				status_txt = getTxtData("9015");//중지된 지시서 입니다.
			}
			else if(!isEmpty(data["status"]) && data["status"].indexOf("done") >=0 )
			{
				status_txt = getTxtData("9016");//"완료된 지시서 입니다.";
			}
			else
			{
				if(!isEmpty(data["staffCheck"]) && data["staffCheck"]=="true")
				{
					status_txt = getTxtData("9017");//"다른 작업자가 진행중입니다.";
					small_txt=data["staffid"]+"("+data["st_name"]+")";
				}
				else
				{
					if(!isEmpty(data["tableCheck"]) && data["tableCheck"]=="true")
					{
						status_txt = getTxtData("9018");//"다른 조제대에서 진행중입니다.";
					}
					else
					{
						status_txt = getTxtdt('step22');//배정된 지시서가 아닙니다. 
					}
				}
			}
			$("#maTypeName").text("");
		}
		else
		{
			status_txt = getTxtdt('step22');//배정된 지시서가 아닙니다. 
			$("#maTypeName").text("");
		}
		
	
		
		//marking:배정된 마킹 지시서가 아닙니다. 다시 마킹 지시서를 확인 해 주세요
		//making:배정된 조제 지시서가 아닙니다. 다시 조제 지시서를 확인 해 주세요
		//decoction:배정된 탕전지시서가 아닙니다. 다시 탕전지시서를 확인 해 주세요
		//release:배정된 포장지시서가 아닙니다. 다시 포장지시서를 확인 해 주세요

		$('#status_txt').text(status_txt);
		layersign('warning', status_txt,small_txt,'2000');
	}

	cleardiv();
}
//20190819 :: 별전 capa update
function setSweetCapaUpdate(mediCode, medibarcode, mediCapa, maTable)
{
	console.log("setSweetCapaUpdatesetSweetCapaUpdatesetSweetCapaUpdatesetSweetCapaUpdatesetSweetCapaUpdate");
	//---------------------------------------------------------
	var ordercode=$("#ordercode").attr("value");
	var mdbarcode=medibarcode;
	var mdcode=mediCode;
	var medicapa=mediCapa;
	var jsondata={};
	console.log("NEW 약재차감 ordercode = " + ordercode+", mdbarcode = "+mdbarcode+", mdcode = " + mdcode+", medicapa = " + medicapa);
	jsondata["ordercode"]=ordercode;//주문번호
	jsondata["mediCode"]=mdcode;//스캔받은약재함의코드
	jsondata["medibarcode"]=mdbarcode;//스캔받은약재함바코드
	jsondata["mediCapa"]=medicapa;//스캔받은약재함의코드

	jsondata["mbTable"]=maTable;
	console.log(JSON.stringify(jsondata));
	setMediTxtdt(jsondata);
	callapi('POST',"making",'newmedicapaupdate',jsondata);
	//---------------------------------------------------------
}
//20190819 :: 약재 capa update
function setMedicineCapaUpdate()
{
	console.log("setMedicineCapaUpdatesetMedicineCapaUpdatesetMedicineCapaUpdatesetMedicineCapaUpdatesetMedicineCapaUpdate");
	//---------------------------------------------------------
	var ordercode=$("#ordercode").attr("value");
	var mdbarcode=$(".contenton .addhold").attr("data-value");
	var mdcode=$(".contenton .addhold").attr("data-code");
	var medicapa=$("#medicapa_"+mdcode).val();
	var passmedicapa=$(".contenton .addhold").attr("data-pass");
	var jsondata={};
	console.log("NEW 약재차감 ordercode = " + ordercode+", mdbarcode = "+mdbarcode+", mdcode = " + mdcode+", medicapa = " + medicapa);
	jsondata["ordercode"]=ordercode;//주문번호
	jsondata["mediCode"]=mdcode;//스캔받은약재함의코드
	jsondata["medibarcode"]=mdbarcode;//스캔받은약재함바코드
	if(!isEmpty(passmedicapa))
	{
		jsondata["mediCapa"]=passmedicapa;//스캔받은약재함의코드
	}
	else
	{
		jsondata["mediCapa"]=medicapa;//스캔받은약재함의코드
	}

	jsondata["mbTable"]=getCookie("ck_matable");
	console.log(JSON.stringify(jsondata));
	setMediTxtdt(jsondata);
	callapi('POST',"making",'newmedicapaupdate',jsondata);
	//---------------------------------------------------------
}
function chkinlast()
{
	var odcode=$("#ordercode").attr("value");
	var depart=$("#step_info").parent().attr("id");
	//data=depart=decoction&proc=MDT&stat=MDT_medipocket&code=MDT0000030096&odcode=ODD2001080003214403&medigroup=&nextmedigroup=
	var data="depart="+depart+"&proc=MDT&stat=MDT_medipocket&code=MDT0000000004&odcode="+odcode+"&medigroup=&nextmedigroup=";
	console.log("chkinlast  data="+data);
	callapi('GET',depart,'checkmedipocket',data);
}
function decoctionconfirm()
{
	closelayer();
	chkinlast();
	$('#decoc_inlast dt').addClass('medigroupon');
	status_txt=getTxtdt("step40");//탕전기를 선택 해주세요.
	layersign('success',status_txt,'','1500');
	$('#status_txt').text(status_txt);
	gotostep(3);
}
function viewCheckmediPocket(depart, data, https)
{
	var status_txt = "";
	$("#nowGram").text("");
	$("#totalGram").text("");
	switch(depart)
	{
	case "making":
		$("#nowGram").text("0");
		$("#totalGram").text("0");
		if(data["nextmedigroup"]=="inlast")
		{
			$('#nowGramRight').text('ea');
			$('#totalGramRight').text('ea');
		}
		else
		{
			$('#nowGramRight').text('g');
			$('#totalGramRight').text('g');
		} 
		var inpouchtag="";
		if(data["pt_group"]==data["medigroup"])
		{
			//console.log("viewCheckmediPocketviewCheckmediPocketviewCheckmediPocketviewCheckmediPocketviewCheckmediPocket  addClass('st_finish')");
			setMedicineCapaUpdate();
			$('.contenton .addhold').removeClass('addhold').removeClass('st_ing').addClass('st_finish');
			$('#medipocketcapa').text('0g');
			if(data["nextmedigroup"])
			{
				console.log("viewCheckmediPocket  gotostep(2) ");
				$('.contenton .elementsmall').fadeIn(0);
				$('.contenton .element').fadeOut(0);
				$('.content').removeClass('contenton');
				inpouchtag=(!isEmpty(data["code"])) ? data["code"] : "";
				$('#pouchtag_'+data["medigroup"]).text(inpouchtag);
				$('#medibox_'+data["nextmedigroup"]).addClass('contenton');
				$('#medibox_'+data["nextmedigroup"]+' .element').fadeIn(0);
				$('#medibox_'+data["nextmedigroup"]+' .elementsmall').fadeOut(0);
				$('.groupmedicode').removeClass('groupmedion');
				$('input[name=groupmedicode_'+data["nextmedigroup"]+']').addClass('groupmedion');
				status_txt=getTxtdt("step30");//약재 바코드를 스캔 해 주세요
				$('#status_txt').text(status_txt);
				gotostep(2);
			}
			else
			{
				status_txt=getTxtdt("step60");//조제완료된 작업지시서를를 스캔해주세요
				$('#status_txt').text(status_txt);
				nextstep();
			}
			//https 에서 동작
			//촬영-viewCheckmediPocket
			if(!isEmpty(https))
			{
				document.getElementById('snapshot').style.display = 'block';
				$('#snapshot').html('<div style=\"font-size:30px;font-weight:bold;margin:200px 0 0 230px;\">2'+getTxtdt("stepphoto")+'</div>').fadeIn(0);
				setTimeout("snapshot('"+data["medigroup"]+"','')",2000);
			}
		}
		else
		{
			if(!isEmpty(data["pt_group"]))
			{
				status_txt=getTxtdt("step51");//부직포 바코드가 아닙니다.  부직포 바코드 확인 후 다시 스캔 해 주세요
				$('#status_txt').text(status_txt);
				layersign('warning',status_txt,'','2000');
			}
			else
			{
				status_txt=getTxtdt("step51");//부직포 바코드가 아닙니다.  부직포 바코드 확인 후 다시 스캔 해 주세요
				$('#status_txt').text(status_txt);
				layersign('warning',status_txt,'','2000');
			}
			$('#pouchtag_'+data["medigroup"]).text("");
		}
		getsummary();
		break;
	case "decoction":
		if(!isEmpty(data["infirst"]))
		{
			//console.log(data["infirst"]);
			status_txt=getTxtdt("step33");  //[] 부직포가 확인되었습니다
			status_txt = status_txt.replace('[]',data["decolist"][0]["cdName"]);

			$('#status_txt').text(status_txt);
			layersign('success',status_txt,'','1200');
			$('#decoc_infirst dt').addClass('medigroupon');
		}
		else if(!isEmpty(data["inmain"]))
		{
			status_txt=getTxtdt("step33");  //[] 부직포가 확인되었습니다
			status_txt = status_txt.replace('[]',data["decolist"][1]["cdName"]);
			$('#status_txt').text(status_txt);
			layersign('success',status_txt,'','1200');
			$('#decoc_inmain dt').addClass('medigroupon');
		}
		else if(!isEmpty(data["inafter"]))
		{
			status_txt=getTxtdt("step33"); //[] 부직포가 확인되었습니다
			status_txt = status_txt.replace('[]',data["decolist"][2]["cdName"]);
			$('#status_txt').text(status_txt);
			layersign('success',status_txt,'','1200');
			$('#decoc_inafter dt').addClass('medigroupon');
		}
		else if(!isEmpty(data["inlast"]))
		{
			//올리고당이 있습니다. 
			$('#decoc_inlast dt').addClass('medigroupon');
			status_txt=getTxtdt("step33"); //[] 부직포가 확인되었습니다
			status_txt = status_txt.replace('[]',data["decolist"][3]["cdName"]);
			$('#status_txt').text(status_txt);
			layersign('success',status_txt,'','1200');
			
		}
		else
		{
			status_txt=getTxtData("9023");//"조제에서 스캔한 것과 다르거나 없는 부직포 바코드입니다.";//getTxtdt("step30");//부직포 바코드를 모두 스캔 해주세요
			var subtxt=getTxtData("9024") + " : " + data["bujigpo"];//"스캔할 부직포 바코드 : "+data["bujigpo"];
			$('#status_txt').text(status_txt);
			layersign('warning',status_txt,subtxt,'1500');
		}

		
		setTimeout(function(){
			if(data["chkinlast"]=="on")
			{				
				status_txt=data["chkinlasttitle"]+"이 있습니다.";
				$('#status_txt').text(status_txt);				
				layersign('success',status_txt,'확인해 주세요.','decoc_confirm');
			}
			else
			{
				if(data["ma_medibox"]==data["dc_medibox"])
				{
					status_txt=getTxtdt("step40");//탕전기를 선택 해주세요.
					layersign('success',status_txt,'','1500');
					$('#status_txt').text(status_txt);
					gotostep(3);
				}
			}
		}, 1600);	

		break;
	}

	cleardiv();
}
//================================================================
function dataURItoBlob(dataURI)
{
	// convert base64/URLEncoded data component to raw binary data held in a string
	var byteString;
	if (dataURI.split(',')[0].indexOf('base64') >= 0)
		byteString = atob(dataURI.split(',')[1]);
	else
		byteString = unescape(dataURI.split(',')[1]);

	// separate out the mime component
	var mimeString = dataURI.split(',')[0].split(':')[1].split(';')[0];

	// write the bytes of the string to a typed array
	var ia = new Uint8Array(byteString.length);
	for (var i = 0; i < byteString.length; i++) {
		ia[i] = byteString.charCodeAt(i);
	}

	return new Blob([ia], {type: 'image/jpeg'});
}

	function workerconfirm(alertcontent)
	{
		console.log("alertcontent   >>>>  "+alertcontent);

		$("#requestscreen").remove();
		$("#makingtblestatdiv").remove();
		$("#requestscreen").remove();

		var txt="<div id='requestscreen' style='position:fixed;width:100%;top:0;background:#000;opacity:0.4;z-index:999;'></div>";
			txt+="<div id='makingtblestatdiv' style='position:absolute;width:100%;z-index:1000;'>";
			txt+=" <div id='requeststat' style='position:relative;width:1200px;max-height:400px;margin:150px auto;padding:0;background:#fff;'>";
			txt+=" <div class='requestdiv' id='requestdiv'>";
			//txt+=" <input type='hidden' name='dummy' value='' style='width:0;heght:0' class='dummy'> ";
			txt+="   <p class='requesttitle'>"+getTxtData("9035")+"</p>";//작업이 정상적으로 완료되었으면 아래 사항을 확인후 확인서명(작업지시서 체크) 하세요
			txt+="    <div class='requestcontent' id='requestcontent'>"+alertcontent+"<br><br>"+getTxtData("9037")+"</div>";
			//txt+="     <p class='reuqestok' onclick='OKClick();'>"+getTxtData("CONFIRM")+"</p>"; //확인
			txt+="     <input type='button' name='okbtn' class='reuqestok' onclick='OKClick();' value='"+getTxtData("CONFIRM")+"'></button>"; //확인
			txt+="  </div>";
			txt+=" </div>";
			txt+="</div>";

			$("body").prepend(txt);
			setTimeout("$('input[name=okbtn]').focus()",100);
	}

	function OKClick()
	{
		var type=$("#nav").data("bind");
		console.log("type = " + type);
		$("#makingtblestatdiv").remove();
		$("#requestscreen").remove();
		$("#mainbarcode").focus();
		if(type=="release")
		{
			setLabelPrint();
		}
	}