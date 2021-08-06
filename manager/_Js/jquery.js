var timerID;
//------------------------------------------------------------------------------------
// 공통함수
//------------------------------------------------------------------------------------
//빈값체크
function isEmpty(value)
{
   if( value == "" || value == "undefined" || value == "null" || value == null || typeof value == undefined || ( value != null && typeof value == "object" && !Object.keys(value).length ) )
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
function commasFixed(n)
{
	n=n.toFixed(1);
    var parts=n.toString().split(".");
	return parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ",") + ((parseInt(parts[1]) > 0) ? "." + parts[1] : "");
}
// 콤마제거
function removeComma(n)
{
	if( typeof n == "undefined" || n == null || n == "" ) 
	{
		return "";
    }
	var txtNumber = '' + n;
	return txtNumber.replace(/(,)/g, "");
}
//언어체인지
function setlanguage(lang)
{
	setCookie("ck_language", lang, 365);
	setCookie("ck_languageName", getLanguageName(lang), 365);
	if(lang=="eng")
	{
		$("#langeng").prop("checked", true)
	}
	else if(lang=="chn")
	{
		$("#langchn").prop("checked", true)
	}
	else
	{
		$("#langkor").prop("checked", true)
	}

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
//오늘날짜뽑아오기 : (2019)년-(01)월-(24)일
function getNewDate()
{
	var date = new Date();
	var year = date.getFullYear();
	var month = new String(date.getMonth()+1);
	var day = new String(date.getDate());

	return nowDate = year + "-" + pad(month,2) + "-" + pad(day,2);
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
	Cookies.set(cname, cvalue, { expires: exdays, path: '/', domain: getUrlData("DOMAIN"), secure: false });
}
function getCookie(cname) 
{
	return Cookies.get(cname);
	//return $.cookie(cname);
}
function deleteAllCookies()
{
	//var cookies = $.cookie();
	var cookies = Cookies.get();
	for(var cookie in cookies) 
	{
		if(cookie != "ck_language" || cookie != "ck_languageName")
		{
			deleteCookie(cookie);
		}
	}
}
function deleteCookie(name)
{
	setCookie(name,null,-1);
	Cookies.remove(name);
	//setCookie(name,null,-1); //$.removeCookie(cookie);
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
// ComTxtdt : 공통으로 쓰이는 텍스트 data
//------------------------------------------------------------------------------------
function getTxtData(name)
{
	var ugly = document.getElementById('comTxtdt').value;
	var txtdt = JSON.parse(ugly);
	return txtdt[name];
}
//------------------------------------------------------------------------------------
// api 호출
//------------------------------------------------------------------------------------
function callapi(type,group,code,data)
{

	var language=$("#gnb-wrap").attr("value");
	var timestamp = new Date().getTime();
	if(isEmpty(language)){language="kor";}

	var url=getUrlData("API_MANAGER")+group+"/";

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
			//console.log("result " + result);
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
		alertsign("warning", getTxtData("MEMBER_DIFFERENT"), "confirm", "");
		//setTimeout("removeSession();",3000);
		//removeSession();	
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
function setTextData(obj)
{
	var furl=getUrlData("FILE_DOMAIN")+"ajaxtxtupload.php";
	console.log("furl = " + furl);

	var data="txtkor0="+JSON.stringify(obj["data"]["txtkor0"]);
	data+="&txtchn0="+JSON.stringify(obj["data"]["txtchn0"]);
	data+="&txteng0="+JSON.stringify(obj["data"]["txteng0"]);

	data+="&txtkor1="+JSON.stringify(obj["data"]["txtkor1"]);
	data+="&txtchn1="+JSON.stringify(obj["data"]["txtchn1"]);
	data+="&txteng1="+JSON.stringify(obj["data"]["txteng1"]);

	data+="&txtkor5="+JSON.stringify(obj["data"]["txtkor5"]);
	data+="&txtchn5="+JSON.stringify(obj["data"]["txtchn5"]);
	data+="&txteng5="+JSON.stringify(obj["data"]["txteng5"]);

	data+="&txtkor7="+JSON.stringify(obj["data"]["txtkor7"]);
	data+="&txtchn7="+JSON.stringify(obj["data"]["txtchn7"]);
	data+="&txteng7="+JSON.stringify(obj["data"]["txteng7"]);

	data+="&netLive="+getUrlData("NETLIVE");

	console.log(data);
	

	$.ajax({
		type : "POST", //method
		url : furl,
		data : data,
		headers : {"HeaderTextKey":"txtJsonKey"},
		success : function (result) {
			if(result["status"] == "SUCCESS" && result["message"] == "TXT_UPLOAD_OK")
			{
				alertsign('success',getTxtData("INSERT_OK"),'top',2000);
			}
			else
			{
				if(result["message"] == "TXT_UPLOAD_ERR")
					alertsign('warning',getTxtData("FILE_UPLOAD_ERR04"),'top',2000);//도메인 관리자에게 문의 바랍니다.
			}
		},
		error:function(request,status,error){
			console.log("code:"+request.status+"\n"+"message:"+request.responseText+"\n"+"error:"+error);
		}
   });


/*
	$('frmt').ajaxForm({
		url:furl,
		data : data,
		processData : false,
		contentType : false,
		error: function(response, status, e){
			console.log("errorerrorerrorerrorerror");
			console.log(JSON.stringify(e));
			//console.log("error  response = " + response+", status = " + status+", e = " + e);
		},

		complete:function(xhr){
			console.log("completecompletecompletecomplete");
			var obj = JSON.parse(xhr.responseText);
			console.log(obj);
		}
	});


	$.ajax({
		type : "POST", //method
		url : furl,
		data : data,
		success : function (result) {
			console.log(result);
		},
		error:function(request,status,error){
			console.log("code:"+request.status+"\n"+"message:"+request.responseText+"\n"+"error:"+error);
		}
   });
  */
}
function saveupdate(result){
	var obj = JSON.parse(result);
	//console.log(obj);
	if(obj["resultCode"]=="200")
	{
		if(obj["apiCode"]=="stafflogin")
		{
			if(obj["resultMessage"] == 'SUCCESS_OK')
			{
				setSession(obj);
			}
		}
		else if(obj["apiCode"]=="textdbupdate")
		{
			setTextData(obj);
		}
		else
		{
			if(obj["resultMessage"] == 'OK') //post, insert, update 일때만 적용..나중에.. 각 페이지별로 문구를 수정....
			{
				alertsign("success", getTxtData("INSERT_OK"), "", "1500");
			}

			if(!isEmpty(obj["returnData"]))
			{
				if(obj["apiCode"]=="paymentupdate") //주문/접수에서 입금확인후 등록버튼 누르면 주문리스트 갱신하자 
				{
					$("#listdiv").load(obj["returnData"]);
				}
				else
				{
					golist(obj["returnData"]);
				}
			}
			else
			{
				if(obj["apiCode"]=="outstockupdate") //약재출고시에 리스트로 넘어가지 않고 그대로 하기 위해서
				{
					//radio data
					$(".radiodata").each(function()
					{
						key=$(this).attr("name");
						$("input:radio[name="+key+"]").eq(0).attr("checked", true);
					});

					$(".reqdata").each(function(){
						$(this).val("");
					});

					$(".outInitData").each(function(){
						$(this).text("");
					});


					$("input[name=OutStockStep]").val('1');
					$('#outInfoTxt').text(getTxtData("MSG_1206"));
				}
			}
		}
	}
	else
	{
		if(obj["resultCode"]=="209") //mediboxupdate 에러처리, outstockupdate 에러처리, instockupdate 에러처리
		{
			if(obj["resultMessage"] == "1714")//해당 조제대에 약재가 등록되어 있습니다.
				alertsign("warning", getTxtData("ERR_1714"), "", "1500");
			else if(obj["resultMessage"] == "1715")//개별 약재로 등록되어 있습니다.
				alertsign("warning", getTxtData("ERR_1715"), "", "1500");
			else if(obj["resultMessage"] == "1716")//공통 약재로 등록되어 있습니다.
				alertsign("warning", getTxtData("ERR_1716"), "", "1500");
			else if(obj["resultMessage"] == "1526")//중복코드
				alertsign("warning", getTxtData("ERR_1526"), "", "1500");
			else if(obj["resultMessage"] == "1708")//약재함이 존재하지 않거나 사용할수 없습니다.
				alertsign("warning", getTxtData("ERR_1708"), "", "1500");
			else if(obj["resultMessage"] == "1723")//약재가 부족합니다.
				alertsign("warning", getTxtData("MSG_1723"), "", "1500");
			else if(obj["resultMessage"] == "1726")//이미 사용중인 약재코드입니다.
				alertsign("warning", getTxtData("MSG_1726"), "", "1500");
				
		}
		else
		{
			alert(obj["resultCode"]+" - "+obj["resultMessage"]);
		}
	}
}

function savedelete(result)
{
	var obj = JSON.parse(result);
	//console.log(obj);
	if(obj["resultCode"]=="200")
	{
		alertsign("success", getTxtData("DELETE_OK"), "", "1500");

		var url = "";
		url=obj["returnData"] + "?" + $("#comSearchData").val();
		//console.log("savedelete   ======>>>  url = " + url);
		//"/Skin/Medicine/HubCategory.php?"+url
		$("#listdiv").load(url);
	}
	else
	{
		alert(obj["resultCode"]+" - "+obj["resultMessage"]);
	}
}
function callapidel(group,code,data)
{
	if(isEmpty(group) || isEmpty(code))
	{
		//alertsign("warning", $("input[name=txt1478]").val(), "", "1500");
		alertsign("warning", getTxtData("NECDATA"), "", "1500");//필수데이터

	}
	else
	{
		if(!confirm(getTxtData("DELETE"))){return;}//삭제하시겠습니까?

		data+="&";
		data+=$("#comSearchData").val();
		data+="&returnData="+encodeURI($("input[name=returnData]").val());
		//console.log("callapidel  group : " + group + ", code : " + code + ", data : " + data);
		callapi('DELETE',group,code,data);
	}
}
function golistload()
{
	var url = $("input[name=returnData]").val()+"?"+$("#comSearchData").val();
	//console.log("golistload  ========:>>>>  url = " + url);
	$("#listdiv").load(url);
}
function gowriteload(seq, url)
{
	var data = "?seq="+seq;
	if(isEmpty(seq))
	{
		$("#comSearchData").val('');
	}
	//console.log("gowriteload  ========:>>>>  url = " + url + data);
	$("#listdiv").load(url + data);
}
function golist(url)
{
	//var data = "?"+$("#comSearchData").val();
	//console.log("golist  ========:>>>>  url = " + url + data);
	//$("#listdiv").load(url + data);
	viewlist();
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
		url+="&url="+encodeURI(obj["returnData"]);
		url+="&stAuthKey="+encodeURI(obj["stAuthKey"]);
	$.ajax({
		type : "GET", //method
		url : url,
		data : [],
		success : function (result) {
			location.href=result;
		},
		error:function(request,status,error){
			console.log("code:"+request.status+"\n"+"message:"+request.responseText+"\n"+"error:"+error);
		}
	});
}
function removeSession(){
	var url="/session.php";
		url+="?type=logout&url="+getUrlData("MEMBER");
			//console.log(url);
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
			//console.log(result);
			location.href=result;
		},
		error:function(request,status,error){
			console.log("code:"+request.status+"\n"+"message:"+request.responseText+"\n"+"error:"+error);
		}
	});
}
//------------------------------------------------------------------------------------
// 필수데이터체크
//------------------------------------------------------------------------------------
function necdata()
{
	var chk="Y";
	var data=title="";
	$(".necdata").each(function()
	{
		title+=","+$(this).attr("title")+"/"+$(this).val()+"";
		//console.log("necdata >>>>>>>>>>  this = "+$(this)+", name = " + $(this).attr("name")+", title = " + $(this).attr("title")+", val = " + $(this).val());
	
        if($(this).attr("name")=="mdWater" || $(this).attr("name")=="pbCapa" || $(this).attr("name")=="dcMillingloss" || $(this).attr("name")=="dcLossjewan" || $(this).attr("name")=="dcBindersliang" || $(this).attr("name")=="dcCompleteliang"|| $(this).attr("name")=="dcJungtang" || $(this).attr("name")=="dcRipen" || $(this).attr("name")=="dcDry") //흡수율이 ㅇ 인 경우도 있어 예외처리
        {
            if(isEmpty($(this).val()))
            {
                if(data!=""){data+=",";}
                data+="-"+$(this).attr("title")+"-";
                chk="N";
            }
        }
        else
        {
            if(isEmpty($(this).val()) || $(this).val() == 0)
            {
                if(data!=""){data+=",";}
                data+="-"+$(this).attr("title")+"-";
                chk="N";
            }
        }
	});
	if(chk=="N")
	{
		var alertdata = getTxtData("NECDATA") + "(" + data + ")";//필수데이터 입력필요
		alertsign("info", alertdata, "", "2000");
		//alert(alertdata);
	}
	return chk;
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
	//console.log(" getsubpage   pgid : " + pgid +", tpage = "+tpage+", page = "+page+", block = "+block+", psize = "+psize+", inloop = "+inloop );

	prev = inloop - 1;
	next = inloop + block;
	var txt="<ul class='paging-wrap paging-wrap-main' data-tpage='"+tpage+"' data-page='"+page+"' data-id='"+pgid+"'>";
	var link = "";

	if(prev<1)
	{
		link = "";
		prev = 1;
	}
	else
	{
		link = "onclick='subpage("+prev+", "+psize+","+block+");'";
	}

	txt+="<li onclick='subpage(1,"+psize+","+block+");'><a href='javascript:;' class='first'>&nbsp;</a></li>";
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
				if(i==page){var cls="active";}else{var cls="";}
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

//console.log(pgid+" : "+txt);
	$("#"+pgid).html(txt);


	var subsearch=getseardata();
	var url="page="+page+"&psize="+psize+"&block="+block+"&"+subsearch;
	//console.log("getsubpage  리스트형 페이지 #comSearchData ========>>>>> url : " + url);
	//$("#comSearchData").val(url);

	return false;
}

//페이징
function subpage(page, psize, block)
{
	var hdata=location.hash.replace("#","").split("|");
	var search=seq="";
	if(hdata[1]!=undefined)seq=hdata[1];
	if(hdata[2]!=undefined)search=hdata[2];
	location.hash=page+"|"+seq+"|"+search;
	console.log("subpage 호출");
	repageload();
	/*
	var subsearch=getseardata();


	if(isEmpty(psize))
		psize=10;
	if(isEmpty(block))
		block=10;
	if(isEmpty(subsearch))
		subsearch='';

	var url="page="+page+"&psize="+psize+"&block="+block+"&"+subsearch;
	console.log("페이징 #comSearchData ========>>>>> url : " + url);
	$("#comSearchData").val(url);

	var subsearch=getseardata();
	var url="page="+page+"&psize="+psize+"&block="+block+"&"+subsearch;
	console.log(" 222222    페이징 #comSearchData ========>>>>> url : " + url);
	gopage(url);
	*/
	return false;
}

//------------------------------------------------------------------------------------
//우편번호검색
//------------------------------------------------------------------------------------
function getzip(zipfld,addrfld){
	viewlayer("../_module/postal/index.php?zipfld="+zipfld+"&addrfld="+addrfld,800,600,"우편번호검색","");
}
function viewlayer(url,width,height,code){
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
function goscreen(type){
	if(type=="close"){
		$("#screen").fadeOut(300).remove();
	}else{
		$("#screen").remove();
		var dh = $(document).height();
		var style="background:#000;filter:alpha(opacity=30);opacity:0.3;position:fixed;top:0;left:0;width:100%;height:"+dh+"px;z-index:2500;";
		var txt="<div id='screen' style='"+style+"'></div>";
		$("body").prepend(txt);
	}
}

//화면중앙팝업레이어
function popupcenter(dw,dh){
	var winwidth = $(window).width();
	var winheight = $(window).height();
//console.log("winheight"+screen.height);
	//var ie=getagent();
	if(winheight>screen.height){
		winheight=screen.height;
	}
//console.log("winwidth"+winwidth);
//console.log("screen"+screen.height);
//console.log("winheight"+winheight);
	//if(ie<0){
		//var scheight = $(window).scrollTop();
	//	winheight=winheight - scheight;
	//}
	var left=(parseInt(winwidth)-dw)/2;
	var top=(parseInt(winheight))/2-(dh/2);
	//alert(screen.height+"+"+dw+"|"+dh+"|"+winwidth+"|"+winheight+"|"+top+"|"+left);
	return top+"|"+left;
}
//화면중앙팝업레이어 top agent 체크필요
function popupcentertop(dw,dh){
	var winwidth = $(window.parent).width();
	var winheight = $(window.parent).height();
	/*
	var chk=getagent();
	if(chk>0){
		var scheight =parent.document.documentElement ? parent.document.documentElement.scrollTop : parent.document.body.scrollTop;
	}else{
	}
	*/
	var scheight = window.parent.$("body").scrollTop();
	var left=(parseInt(winwidth)-dw)/2;
	var top=(parseInt(winheight) - scheight -dh)/2;
	//var top=(parseInt(winheight))/2+scheight-(dh/2);
	return top+"|"+left;
}

function closediv(id){
	goscreen("close");
	$("#"+id).remove();
}

//------------------------------------------------------------------------------------
// 페이지별 검색
//------------------------------------------------------------------------------------
//최종적으로 callapi 호출
function gopage(url)
{
	//console.log("최종적으로 callapi 호출 gopage =======>>>> url : " + url);
	var group=$("#pagegroup").attr("value");
	var code=$("#pagecode").attr("value");
	callapi('GET',group,code,url);
	return false;
}
//기간선택,주문상태별,검색에 따른 데이터 정리하여 gopage로 넘기기 위한 url 만들기
function getseardata()
{
	var hashtext=url=status=period="";
	//기간선택
	$(".reqdata").each(function()
	{
		if($(this).attr("name") == 'searchTxt')
		{
			url+="&"+$(this).attr("name")+"="+encodeURI($(this).val());
		}
		else if($(this).attr("name") == 'sdate' || $(this).attr("name") == 'edate')
		{
			url+="&"+$(this).attr("name")+"="+$(this).val();
		}
		if($(this).attr("name") == 'medidescstock')
		{
			url+="&whStock="+$(this).val();
		}
	});

	//주문상태별
	$('input:checkbox[name="searchStatus"]').each(function()
	{
		if(this.checked)//checked 처리된 항목의 값
		{
			status+=","+this.value;
		}
	});
	period="";
	//주문리스트 기간선택 라디오박스라서 값을 따로 가져와야함
    $('input:radio[name="searPeriodEtc"]').each(function()
	{
		if(this.checked)//checked 처리된 항목의 값
		{
			period+=","+this.value;
		}
	});

	var tmp = url.substring(0,1);
	if(tmp == '&')
	{
		url = url.substring(1);
	}

	url+="&searchStatus="+status;
	url+="&searchPeriodEtc="+period;
	//console.log("모든데이터 말기 #comSearchData getseardata ========::>>>> url = " + url);

	//$("#comSearchData").val(url);



	
	return url;
}
//기간선택 클릭시
function setperiod(data)
{
	//console.log("-----------------------------> setperiod data : " + data);
	var tmp="";
	var d=new Date();
	var e=d.getFullYear()+"."+("0" +(d.getMonth() + 1)).slice(-2)+"."+("0" +(d.getDate())).slice(-2);
	switch(data){
		case "today":break;
		case "yesterday":d.setDate(d.getDate() - 1);break;
		case "week":d.setDate(d.getDate() - 7);break;
		case "month":d.setMonth(d.getMonth() - 1);break;
		case "month3":d.setMonth(d.getMonth() - 3);break;
		case "month4":d.setMonth(d.getMonth() - 6);break;
	}
	var s=d.getFullYear()+"."+("0" +(d.getMonth() + 1)).slice(-2)+"."+("0" +(d.getDate())).slice(-2);
	if(data=="all"){s="";e="";}
	$("input[name=sdate]").val(s);
	$("input[name=edate]").val(e);
	var url=getseardata();
	//console.log("기간선택 클릭시   ======>>>>   url : " + url);
	//gopage(url);
	searchhash(url);

}

//주문상태별 클릭시
function searcls()
{
	var url=getseardata();
	//console.log("주문상태별 클릭시  ======>>>>   url : " + url);
	//gopage(url);
	searchhash(url);
}

//ODD나 MKD로 시작하는 검색어는 검색후 검색란을 비워준다
function textNo(url)
{
	var retext=$("input[name=searchTxt]").val();
	retext= retext.substring(0,3);
	//console.log("retext  ======>>>> url : " + retext);

	if(retext =="ODD" || retext =="MKD" )
	{	
		$("input[name=searchTxt]").val("");
	}
}

//검색 버튼 클릭시
function searchbtn()
{
	var url=getseardata();
	//console.log("검색 버튼 클릭시  ======>>>>  url : " + url);
	searchhash(url);
	//gopage(url);
	textNo();
}

//검색 텍스트에서 엔터키를 눌렀을 경우
function searchkeydown(event)
{
	if(event.keyCode==13)
	{
		var url=getseardata();
		//console.log("검색 텍스트에서 엔터키를 눌렀을 경우  ======>>>> url : " + url);
		//gopage(url);
		searchhash(url);
		textNo();
	}
}
function searchpopbtn(reData)
{
	//console.log("-----------------------------> searchpopbtn reData = " + reData);
	if(!isEmpty(reData))
		subpage_pop(1,5,10, reData);
	else
		subpage_pop(1,5,10,null);
}
function searchpopkeydown(event, reData)
{
	//console.log("-----------------------------> searchpopkeydown reData = " + reData);
	if(event.keyCode==13)
	{
		if(!isEmpty(reData))
			subpage_pop(1,5,10, reData);
		else
			subpage_pop(1,5,10,null);
	}
}


//------------------------------------------------------------------------------------
// 팝업레이어
//------------------------------------------------------------------------------------
function getlayer(url,size,data)
{
	size=size.split(",");
	var addurl="";
	switch(url)
	{
	case "layer-medicine":
		var chkurl=$("input[name=returnData]").val();
		//console.log("chkurl = " + chkurl);
		if(chkurl.match("OrderList"))//주문등록
		{
			var medicine=$("input[name=rcMedicine]").val();
			var sweet=$("input[name=rcSweet]").val();
			sweet = (isEmpty(sweet)) ? "" : sweet;

			//console.log("getlayer  sweet = " + sweet);
			addurl="?type=order&medicine="+medicine+"&sweet="+sweet+data;
		}
		else if(chkurl.match("UniquePrescriptionList"))//고유처방
		{
			var medicine=$("input[name=rcMedicine]").val();
			//var sweet=$("input[name=rcSweet]").val();
			addurl="?type=Unique&medicine="+medicine+"&sweet="+sweet+data;
		}
		else if(chkurl.match("InStockList"))//약재입고
		{
			addurl="?type=stock"+data;
		}
		break;
	case "layer-medihub":
		var chkurl=$("input[name=returnData]").val();
		if(chkurl.match("MedicineList") )
		{
			addurl="?type=medicine";
		}
		else if(chkurl.match("DismatchWarning"))
		{
			addurl="?type=dismatch";
		}
		else if(chkurl.match("PoisonWarning"))
		{
			addurl="?type=poison";
		}
		break;
	case "layer-hospital":
		addurl="?userid="+data;
		break;
	case "layer-orderPrint":
		addurl="?odCode="+data;
		break;
	case "layer-medical":
	case "layer-recipe":
	case "layer-recipebook":
	case "layer-member":
	case "layer-medicinehanpure":
		addurl="?"+data;
		break;
	case "layer-medicinesmu":
		addurl="?type=medicinesmu";
		break;
	}

	url="/99_LayerPop/"+url+".php"+addurl;

	//console.log("getlayer   url = " + url);
	viewlayer(url,size[0],size[1],"");
}


//------------------------------------------------------------------------------------
//프린트
//------------------------------------------------------------------------------------
function printdocument(type,code,h)
{
	//if(type=="making")
	//	type="making_smu";
	window.open("/99_LayerPop/document."+type+".php?odCode="+code,"proc_"+type,"width=800,height="+h);
}
function printbarcode(type,seq,h)
{
    // console.log("printbarcode    함수 type :"+type+"   seq  :"+seq+" :   h   :"+h);
	 window.open("/99_LayerPop/document."+type+".php?seq="+seq,"proc_"+type,"width=800,height="+h);
}


//------------------------------------------------------------------------------------
//작업자리스트
//------------------------------------------------------------------------------------
function selworker(pgid, list, code, staff, depart, temptxt)
{
	var txt = field = cls = "";
	field = (depart) ? (code+"_"+depart) : code;
	if(isEmpty(staff))
	{
		staff=temptxt; //임의지정
	}

	if(code=='bodecoction')
	{
		txt="<select name='"+field+"' class='reqdata' >";
	}
	else
	{
		txt="<select name='"+field+"' class='reqdata' onchange=chnworker('"+code+"','"+depart+"')>";
	}

	txt+="<option>"+temptxt+"</option>";

	for(var key in list)
	{
		if(staff==list[key]["stStaffid"]){cls=" selected";}else{cls="";}
		txt+="<option value='"+list[key]["stStaffid"]+"' "+cls+" title='"+list[key]["stName"]+"'>"+list[key]["stName"]+"</option>";
	}
	txt+="</select>";

	$("#"+pgid).html(txt);
}



//------------------------------------------------------------------------------------
//탕전법, 특수탕전, 복약지도코드, 복약방법코드
//------------------------------------------------------------------------------------
function parsecodes(pgid, list, title, name, type, data, text, readonly)
{
	var selstr = idstr = selected = disable = width="";

	disable = (readonly == 'readonly') ? "disabled='disabled'" : "";

	width = "w90p";
	if(name=='gdcTitle' || name=='gdcSpecial')
	{
		width = "w40p";
	}

	selstr='<select title="'+title+'" class="reqdata resetcode '+width+'" name="'+name+'" onchange="codeChange(this);" '+disable+' >';

	if(!isEmpty(text))
	{
		selstr+='<option value="">'+text+'</option>';
	}

	for(var key in list)
	{
		selected = "";
		if(data == list[key]["cdCode"])
		{
			selected = "selected";
		}

		selstr += "<option value='"+list[key]["cdCode"]+"' "+selected+" data-value='"+list[key]["cdValue"]+"'>"+list[key]["cdName"]+'</option>';
	}

	selstr += "</select>";

	$("#"+pgid).html(selstr);
}
function codeChange(obj)
{
	var name = obj.name;
	var txt = obj.options[obj.selectedIndex].text;
	var val = obj.options[obj.selectedIndex].value;
	var data_val = obj.options[obj.selectedIndex].getAttribute('data-value');

	//복약방법코드, 복약지도코드를 선택시 textarea에 값을 넣기
	if(name == 'odCare' || name == 'selAdvice')
	{
		var be_val = $("textarea[name=odAdvice]").val();
		if(be_val == "" || be_val == null)
			$("textarea[name=odAdvice]").val(data_val);//복약지도 textarea
		else
			$("textarea[name=odAdvice]").val(be_val + "\n" +  data_val);//복약지도 textarea
	}
}

function changeDelitype()
{
	var delitype=$("input:radio[name=reDelitype]:checked").val();
	var name=zipcode=addr1=addr2=requst=phone=phone1=phone2=phone3=mobile=mobile1=mobile2=mobile3="";
	if(delitype == "medicalreceive") //한의원수령일 경우 
	{
		//받는사람 
		name=$("input[name=miName]").val();
		//우편번호
		zipcode=$("input[name=miZipcode]").val();
		//주소 
		var addr=$("input[name=miAddress]").val();
		
		if(!isEmpty(addr))
		{
			var addrData=addr.split("||");
			addr1=addrData[0];
			addr2=addrData[1];
		}

		phone=$("input[name=miPhone]").val();
		console.log("phone :: "+ phone);
		if(!isEmpty(phone))
		{
			var addrData=phone.split("-");
			phone1=addrData[0];
			phone2=addrData[1];
			phone3=addrData[2];
			console.log("phone1 :: "+ phone1);
			console.log("phone2 :: "+ phone2);
			console.log("phone3 :: "+ phone3);
		}

		mobile=$("input[name=miMobile]").val();
		if(!isEmpty(mobile))
		{
			var addrData=mobile.split("-");
			mobile1=addrData[0];
			mobile2=addrData[1];
			mobile3=addrData[2];
		}

		//배송요청사항
		requst=$("input[name=odTitle]").val();
		
	}
	//받는사람 
	$("input[name=reName]").val(name);
	//우편번호 
	$("input[name=reZipcode]").val(zipcode);
	//주소
	$("input[name=reAddress]").val(addr1);
	$("input[name=reAddress1]").val(addr2);
	//배송요청사항
	$("input[name=reRequest]").val(requst);

	$("input[name=rePhone1]").val(phone1);
	$("input[name=rePhone2]").val(phone2);
	$("input[name=rePhone3]").val(phone3);


	$("input[name=reMobile1]").val(mobile1);
	$("input[name=reMobile2]").val(mobile2);
	$("input[name=reMobile3]").val(mobile3);

	
}
//------------------------------------------------------------------------------------
// 배송종류,약재상태,약재흡수율,약재흡수율예외처리
//------------------------------------------------------------------------------------
function radioClick(obj)
{
	if(obj.name == 'meGrade')//회원구분일 경우
	{
		$("input[name=meGradetxt]").val(obj.value);
	}
	else if(obj.name=='pbType')//포장재관리 > 분류 선택시
	{
		var data=getNowFull(2);
		var type=obj.value;
		var catxt="";
		switch(type)
		{
			case "odPacktype":cacode="PCB";break;
			case "reBoxmedi":cacode="RBM";break;
			case "reBoxdeli":cacode="RBD";break;
			case "rePot":cacode="RBP";break;
			case "reStick":cacode="RBS";break;
			case "rejewanBox":cacode="RJB";break;
		}
		$("input[name=pbCode]").val(cacode+data);
		$("input[name=filecode]").val("packingbox|"+$("input[name=pbCode]").val()+"|"+$("input[name=seq]").val());
	}
	else if(obj.name=='whCategory')
	{
		var data=getNowFull(2);
		var type=$('input:radio[name="whCategory"]:checked').val();
		var catxt="";
		switch(type)
		{
			case "pot":cacode="BLR";break;//탕전기
			case "odPacktype":cacode="PCB";break;//파우치
			case "reBoxmedi":cacode="RBM";break;//한약박스
			case "reBoxdeli":cacode="RBD";break;//포장박스
			case "tag":cacode="MDT";break;//부직포태그
		}
		$("input[name=whCode]").val(cacode+data);

		//자재분류선택시
		var now = new Date();
		if(now.getMonth()<9){var month="0"+(now.getMonth()+1);}else{var month=now.getMonth()+1;}
		if(now.getDay()<10){var day="0"+now.getDay();}else{var day=now.getDay();}
		if(now.getHours()<10){var hour="0"+now.getHours();}else{var hour=now.getHours();}
		if(now.getMinutes()<10){var minute="0"+now.getMinutes();}else{var minute=now.getMinutes();}
		if(now.getSeconds()<10){var second="0"+now.getSeconds();}else{var second=now.getSeconds();}
		var dataCode=now.getFullYear()+""+month+""+day+""+hour+""+minute+""+second;
		var type=$('input:radio[name="whCategory"]:checked').val();
		var catxt="";
		$("input[name=barcode]").val(cacode+dataCode);
	}
	else if(obj.name=='mdWatercode')
	{
		var datavalue=obj.getAttribute("data-value");
		$("input[name=mdWater]").val(datavalue);
	}
	else if(obj.name=='whStatus') //자재입출고>입고,출고 전환할때
	{
		if(obj.value=="outgoing")
		{
			$("input[name=inOutType]").val("outgoing");
			$("input[name=whCode]").val("");
			$(".outcodetr").fadeIn(0);
			$(".incodetr").fadeOut(0);
		}
		else
		{
			$("input[name=inOutType]").val("incoming");
			$(".outcodetr").fadeOut(0);
			$(".incodetr").fadeIn(0);
		}
	}
	else if(obj.name=='maType')//조제타입 선택시 
	{
		var type=$('input:radio[name="maType"]:checked').val();

		$("#odPacktypeDecocDiv").hide();
		$("#odPacktypesfextDiv").hide();
		$("#odPacktypejewanDiv").hide();
		$("#odPacktypeedextDiv").hide();
		$("#edextractDiv").hide();


		$("#edextractTitleDiv").hide();
		$("#decocTitleDiv").hide();
		$("#sfextTitleDiv").hide();
		$("#decocDiv").hide();
		$("#sfextDiv").hide();

		switch(type)
		{
		case "decoction":
			$("#decocTitleDiv").show();
			$("#decocDiv").show();
			$("#odPacktypeDecocDiv").show();
			$("input[name=odChubcnt]").val(getUrlData("BASE_CHUBCOUNT"));
			odPackcapa=$("input:radio[name=odPackDecoctype]:checked").data("capa");
			break;
		case "sfextract":
			$("#odPacktypesfextDiv").show();
			$("input[name=odChubcnt]").val("1");
			odPackcapa=$("input:radio[name=odPackSfexttype]:checked").data("capa");
			break;
		case "jewan":
			$("#sfextTitleDiv").show();
			$("#sfextDiv").show();
			$("#odPacktypejewanDiv").show();
			$("input[name=odChubcnt]").val("1");
			odPackcapa=$("input:radio[name=odPackJewantype]:checked").data("capa");
			break;
		case "edextract":
			$("#edextractDiv").show();
			$("#edextractTitleDiv").show();
			$("#odPacktypeedextDiv").show();
			$("input[name=odChubcnt]").val("1");
			odPackcapa=$("input:radio[name=odPackEdexttype]:checked").data("capa");
			break;
		}

		//조제타입을 선택할때마다 packprice 수정하기 
		$("input[name=odPackprice]").val("");
		$("input[name=odPackcapa]").val(odPackcapa);
		resetamount();
		resetmedi();
	}
	else if(obj.name=='dcShape')//제형
	{
		var type=$('input:radio[name="dcShape"]:checked').val();

		//탄자대일 경우에는 결합제는 무조건 봉밀만 선택하게 하자!! 
		if(type == "tanjadae" || type == "goldtanjadae")
		{
			$("input:radio[name=dcBinders]").prop("disabled", true); 
			$('input:radio[name="dcBinders"]:radio[value="honey"]').prop('checked', true);
		}
		else
		{
			$("input:radio[name=dcBinders]").prop("disabled", false); 
			$('input:radio[name="dcBinders"]:radio[value="wheat"]').prop('checked', true);
		}
		resetamount();
	}
	else if(obj.name=='dcBinders')//결합제
	{
		resetamount();
	}
	else if(obj.name=="reSendType")
	{
		setReleaseInfo();
	}
}
function setReleaseInfo()
{
	var type=$('input:radio[name="reSendType"]:checked').val();
	var name=zipcode=addr=addr1=addr2=phone=phone1=phone2=phone3=mobile=mobile1=mobile2=mobile3="";
	var readonly=false;;
	console.log("changereSendType  type  == " + type);
	switch(type)
	{
	case "base":
		name=$("input[name=cfCompany]").val();
		zipcode=$("input[name=cfZipcode]").val();
		addr=$("input[name=cfAddress]").val();
		if(!isEmpty(addr))
		{
			var addrData=addr.split("||");
			addr1=addrData[0];
			addr2=addrData[1];
		}

		phone=$("input[name=cfPhone]").val();
		console.log("phone :: "+ phone);
		if(!isEmpty(phone))
		{
			var addrData=phone.split("-");
			phone1=addrData[0];
			phone2=addrData[1];
			phone3=addrData[2];
			console.log("phone1 :: "+ phone1);
			console.log("phone2 :: "+ phone2);
			console.log("phone3 :: "+ phone3);
		}

		mobile=$("input[name=cfStaffmobile]").val();
		if(!isEmpty(mobile))
		{
			var addrData=mobile.split("-");
			mobile1=addrData[0];
			mobile2=addrData[1];
			mobile3=addrData[2];
		}
		readonly=true;
		break;
	case "medical":
		//받는사람 
		name=$("input[name=miName]").val();
		//우편번호
		zipcode=$("input[name=miZipcode]").val();
		//주소 
		addr=$("input[name=miAddress]").val();
		if(!isEmpty(addr))
		{
			var addrData=addr.split("||");
			addr1=addrData[0];
			addr2=addrData[1];
		}

		phone=$("input[name=miPhone]").val();
		console.log("phone :: "+ phone);
		phone1=phone2=phone3="";
		if(!isEmpty(phone))
		{
			var addrData=phone.split("-");
			phone1=addrData[0];
			phone2=addrData[1];
			phone3=addrData[2];
			console.log("phone1 :: "+ phone1);
			console.log("phone2 :: "+ phone2);
			console.log("phone3 :: "+ phone3);
		}

		mobile=$("input[name=miMobile]").val();
		mobile1=mobile2=mobile3="";
		if(!isEmpty(mobile))
		{
			var addrData=mobile.split("-");
			mobile1=addrData[0];
			mobile2=addrData[1];
			mobile3=addrData[2];
		}
		readonly=true;
		break;
	case "sudong":
		name="";
		phone1="";
		phone2="";
		phone3="";
		mobile1="";
		mobile2="";
		mobile3="";
		zipcode="";
		addr1="";
		addr2="";
		readonly=false;
		break;
	}

	$("input[name=reSendName]").val(name);

	$("input[name=reSendPhone1]").val(phone1);
	$("input[name=reSendPhone2]").val(phone2);
	$("input[name=reSendPhone3]").val(phone3);

	$("input[name=reSendMobile1]").val(mobile1);
	$("input[name=reSendMobile2]").val(mobile2);
	$("input[name=reSendMobile3]").val(mobile3);

	$("input[name=reSendZipcode]").val(zipcode);
	$("input[name=reSendAddress]").val(addr1);
	$("input[name=reSendAddress1]").val(addr2);

	$("input[name=reSendName]").attr("readonly", readonly);

	$("input[name=reSendPhone1]").attr("readonly", readonly);
	$("input[name=reSendPhone2]").attr("readonly", readonly);
	$("input[name=reSendPhone3]").attr("readonly", readonly);

	$("input[name=reSendMobile1]").attr("readonly", readonly);
	$("input[name=reSendMobile2]").attr("readonly", readonly);
	$("input[name=reSendMobile3]").attr("readonly", readonly);

	$("input[name=reSendZipcode]").attr("readonly", readonly);
	$("input[name=reSendAddress]").attr("readonly", readonly);
	$("input[name=reSendAddress1]").attr("readonly", readonly);
}
function resetjewan()
{
	//결합제 
	var type=$('input:radio[name="dcBinders"]:checked').val();//결합제 

	//결합제량을 구하기 위해 DB에 등록된 퍼센트
	var dcBindersValue=$('input:radio[name="dcBinders"]:checked').data("value");
	dcBindersValue=(!isEmpty(dcBindersValue)) ? parseInt(dcBindersValue) : 6;//기본이 6이다 

	//금박지 가격 
	var desc=$('input:radio[name="dcBinders"]:checked').data("desc"); 
	desc=(!isEmpty(desc)) ? parseInt(desc) : 0;

	//총약재량 
	var meditotal = parseInt($("#meditotal").text().replace(",",""));

	//제형이 탄자대이면서 결합제가 봉밀일 경우에만 value가 *2 
	var dcShapeType=$('input:radio[name="dcShape"]:checked').val();
	if((dcShapeType == "tanjadae" && type == "honey") || (dcShapeType == "goldtanjadae" && type == "honey"))
	{
		dcBindersValue = dcBindersValue * 2;
	}
	
	//결합제량 
	var dbs = Math.floor((meditotal * (dcBindersValue / 100)));

	//console.log("type = " + type+", dcBindersValue = " + dcBindersValue + ", desc = " + desc+", meditotal = " + meditotal + ", dbs = " + dbs);
	//결합제 
	$("input[name=dcBindersliang]").val(dbs);

	//제분손실
	var dcMillingloss=parseInt($("input[name=dcMillingloss]").val());
	//제환손실 
	var dcLossjewan=parseInt($("input[name=dcLossjewan]").val());


	//완성량 
	var dcCompleteliang = parseInt(meditotal - dcMillingloss - dcLossjewan + dbs);

	$("input[name=dcCompleteliang]").val(dcCompleteliang);

	//제형종류에 따라 완성량에서 나눌 숫자 
	var dcShapeValue=$('input:radio[name="dcShape"]:checked').data("value");
	dcShapeValue=(!isEmpty(dcShapeValue)) ? parseInt(dcShapeValue) : 1;
	
	var dcCompletecnt = Math.floor(dcCompleteliang / dcShapeValue);

	//완성갯수 
	$("input[name=dcCompletecnt]").val(dcCompletecnt);


	var capa=$("input[name=odPackcapa]").val();
	if(parseInt(capa) > 0)
	{
		var packcnt=Math.floor(parseInt(dcCompleteliang) / parseInt(capa));
		packcnt = (isNaN(packcnt)==false) ? packcnt : 0;
		packcnt=(packcnt < 0) ? 0:packcnt;
		console.log("capa="+capa+", dcCompleteliang="+dcCompleteliang+", packcnt = " + packcnt);
		$("input[name=odPackcnt]").val(packcnt);
	}
	else
	{
		$("input[name=odPackcnt]").val("0");
	}

}
function parseradiocodes(pgid, list, title, name, classname, data, readonly)
{
	var radiostr=checked=disable=raValue=selcatetd="";
	var i = 0;
	disable = (readonly == 'readonly') ? "disabled='disabled'" : "";

	radiostr='<ul class="'+classname+' ">';
	
	selcatetd = "";
	if(name=='whCategory')
		selcatetd = " selcatetd ";

	$.each(list, function(val) {
		checked = datavalue="";
		if(name=='meGrade') //회원구분일 경우
			raValue = list[val]["cdValue"];
		else
		{
			raValue = list[val]["cdCode"];
			datavalue = list[val]["cdValue"];
		}

		if(!isEmpty(data))
		{
			if(name=='mdWaterchk') //약재흡수율예외처리 :: Y,N만 넘어옴
			{
				if(data == 'Y' && list[val]["cdCode"] == '100')
					checked = "checked";
				if(data == 'N' && list[val]["cdCode"] == '110')
					checked = "checked";
			}
			else if(name=='meGrade') //회원구분일 경우는 cdCode가 아니라 cdValue로 체크 해야함
			{
				if(data == list[val]["cdValue"])
					checked = "checked";
			}
			else
			{
				if(data == list[val]["cdCode"])
					checked = "checked";
			}
		}
		else if(i == 0)
		{
			checked = "checked";
		}

		idstr = "0" + i;
		idstr = idstr.slice(-2);

		radiostr += '<li class="w50p">';
		if(name == "reDelitype")
		{
			radiostr += '	<p onchange="changeDelitype()">';
		}
		else
		{
			radiostr += '	<p>';
		}

        if(name=="mdStatus" && (raValue =='complete' || raValue =='shortage'))//약재관리 >약재상태가 약재부족이나 주문완료인경우는 라디오박스 비활성화
        {
            radiostr += '		<input type="radio"  disabled name="'+name+'" class="radiodata '+selcatetd+'" title = "'+title+'" id="'+name+'-'+idstr+'" data-value="'+datavalue+'" value="'+raValue+'"  '+checked+' '+disable+' onclick="radioClick(this);"  data-value="'+list[val]["cdValue"]+'" data-desc="'+list[val]["cdDesc"]+'">';
        }
		else if(name=="whStatus" && raValue =='cancel')//약재입고 >상태가 입고취소는 라디오박스 비활성화
        {
            radiostr += '		<input type="radio"  disabled name="'+name+'" class="radiodata '+selcatetd+'" title = "'+title+'" id="'+name+'-'+idstr+'" data-value="'+datavalue+'" value="'+raValue+'"  '+checked+' '+disable+' onclick="radioClick(this);"  data-value="'+list[val]["cdValue"]+'" data-desc="'+list[val]["cdDesc"]+'">';
        }
        else
        {
            radiostr += '		<input type="radio"  name="'+name+'" class="radiodata '+selcatetd+'" title = "'+title+'" id="'+name+'-'+idstr+'" data-value="'+datavalue+'" value="'+raValue+'"  '+checked+' '+disable+' onclick="radioClick(this);"  data-value="'+list[val]["cdValue"]+'" data-desc="'+list[val]["cdDesc"]+'">';
        }
	
		radiostr += '		<label for="'+name+'-'+idstr+'">'+list[val]["cdName"]+'</label>';
		
		radiostr += '	</p>';
		radiostr += '</li>';
		i++;

	});

	radiostr+='</ul>';
    // console.log("라디오박스   :"+radiostr);
	$("#"+pgid).html(radiostr);
}


//------------------------------------------------------------------------------------
// 라디오박스 (약재상태,약재흡수율예외처리,회원그룹,소속,회원상태)
//------------------------------------------------------------------------------------
function CodeRadio(pgid, list, title, name, classname, data, readonly)
{
    var radiostr=checked=disable=raValue="";
    var i = 0;
    disable = (readonly == 'readonly') ? "disabled='disabled'" : "";
    radiostr='<ul class="'+classname+'">';
    $.each(list, function(val)
    {
        checked = "";
        raValue = list[val]["cdValue"];
        if(!isEmpty(data))
        {
            if(data == list[val]["cdValue"])
             checked = "checked";
        }
        else
        {
            if(name=='mdWaterchk')  //약재흡수율예외처리 는 NO가 기본값
    		{
                if(i == 1)
                {
                    checked = "checked";
                }
    		}
    		else if(name=='miStatus')  //0730 기본값 정회원으로 
    		{
                  if(i == 2)
                {
                    checked = "checked";
                }
    		}
    		else if(i == 0)
    		{
    			checked = "checked";
    		}
        }
            idstr = "0" + i;
            idstr = idstr.slice(-2);

        radiostr += '<li class="w50p">';
        radiostr += '<p>';
        radiostr += '<input type="radio"  name="'+name+'" class="radiodata" title = "'+title+'" id="'+name+'-'+idstr+'" value="'+raValue+'"  '+checked+' '+disable+' >';
        radiostr += '<label for="'+name+'-'+idstr+'">'+list[val]["cdName"]+'</label>';
        radiostr += '</p>';
        radiostr += '</li>';
        	i++;

    });
    radiostr+='</ul>';
   // console.log("radiostr*************************"+radiostr);
    $("#"+pgid).html(radiostr);
}



//------------------------------------------------------------------------------------
// //선전,일반,후하 code 함수
//------------------------------------------------------------------------------------
function parsedecocodes(list, title, name, data)
{
	var selected = selDecoc = "";
	if(name == 'boStatus')
	{
		selDecoc='<select name="'+name+'" title="'+title+'" class="w100p reqdata">';
	}
	else
	{
		selDecoc='<select name="'+name+'" title="'+title+'" class="w100p rcDecoctype" onchange="mediChange();">';
	}

	for(var key in list)
	{
		selected = "";
		if(isEmpty(data))
		{
			if('inmain' == list[key]["cdCode"])
				selected = "selected";
		}
		else
		{
			if(data == list[key]["cdCode"])
				selected = "selected";
		}

		selDecoc+='<option value='+list[key]["cdCode"]+' '+selected+'>'+list[key]["cdName"]+'</option>';
	}


	selDecoc+='</select>';
	return selDecoc;
}

//------------------------------------------------------------------------------------
// 팝업 페이징
//------------------------------------------------------------------------------------
function getsubpage_pop(pgid, tpage, page, block, psize, type)
{
	block=parseInt(block);
	psize=parseInt(psize);

	var link = txt = "";
	var prev=next=0;
	var inloop = (parseInt((page - 1) / block) * block) + 1;
	//console.log("getsubpage_pop  pgid : " + pgid +", tpage = "+tpage+", page = "+page+", block = "+block+", psize = "+psize+", inloop = "+inloop +", type = " + type);

	prev = inloop - 1;
	next = inloop + block;

	txt+="<input type='hidden' name='type_pop' value='"+type+"'>";
	txt+="<input type='hidden' name='page_pop' value='"+page+"'>";
	txt+="<input type='hidden' name='search_pop' value='' style='width:100%;'>";

	txt+= "<ul class='paging-wrap paging-wrap-pop' data-tpage='"+tpage+"' data-page='"+page+"' data-id='"+pgid+"'>";

	if(prev<1)
	{
		link = "";
		prev = 1;
	}
	else
	{
		link = "onclick='subpage_pop("+prev+", "+psize+","+block+",\""+type+"\");'";
	}

	txt+="<li onclick='subpage_pop("+prev+","+psize+","+block+",\""+type+"\");'><a href='javascript:;' class='first'>&nbsp;</a></li>";
	txt+="<li "+link+"><a href='javascript:;' class='prev'>&nbsp;</a></li>";

	if(tpage == 0)//데이터가 없을 경우
	{
		txt+="<li  onclick='subpage_pop(1, "+psize+","+block+",\""+type+"\");'><a href='javascript:;' class='"+cls+"'>1</a></li>";
	}
	else
	{
		for (var i=inloop;i < inloop + block;i++)
		{
			if (i <= tpage){
				if(i==page){var cls="active";}else{var cls="";}
				txt+="<li  onclick='subpage_pop("+i+", "+psize+","+block+",\""+type+"\");'><a href='javascript:;' class='"+cls+"'>"+i+"</a></li>";
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
		link = "onclick='subpage_pop("+next+", "+psize+","+block+",\""+type+"\");'";
	}
	txt+="<li "+link+"><a href='javascript:;' class='next'>&nbsp;</a></li>";
	txt+="<li onclick='subpage_pop("+tpage+", "+psize+","+block+",\""+type+"\");'><a href='javascript:;' class='last'>&nbsp;</a></li>";

	txt+="</ul>";

	$("#"+pgid).html(txt);

	return false;
}
//페이징
function subpage_pop(page, psize, block, reData)
{
	var subsearch=getsearpopdata();
	console.log("subsearch   :"+subsearch);  //&searchPop=%7CsearchType,mdTitle%7CsearchTxt,%EB%8C%80%EB%B3%B5
	if(isEmpty(psize))
		psize=5;
	if(isEmpty(block))
		block=10;
	if(isEmpty(subsearch))
		subsearch='';
	if(isEmpty(reData))
		reData='';


	var page_url = "page="+page+"&psize="+psize+"&block="+block+"&medicalId=all&reData="+reData;
	console.log("page_url    :"+page_url); //page=1&psize=5&block=10&medicalId=all&reData=order
	var url=page_url+subsearch;

	$("#comPageData").val(page_url);

	//console.log("subpage_pop   ========> url : " + url);
	gopage(url);
	//searchhash(url);  
	return false;
}
function getsearpopdata()
{
	var url=search="";

	$(".searselect_pop").each(function(){
		if($(this).val()){
			search+="|"+$(this).attr("name")+","+$(this).val();
		}
	});
	$(".seartext_pop").each(function(){
		if($(this).val()){
			//console.log("name="+$(this).attr("name")+", val = " +$(this).val());
			search+="|"+$(this).attr("name")+","+$(this).val();
		}
	});

	url="&searchPop="+encodeURI(search);//한글이나 몇가지 특수문자때문에 encodeURI를 하는것임


	//console.log("-----------------------------> getsearpopdata  url = " + url);

	return url;
}
//------------------------------------------------------------------------------------
// 알림창
//------------------------------------------------------------------------------------
function alertsign(type, txt, chktop, delay) //error-red,info-blue,warning-yellow,success-green
{
	//console.log("type = " + type+", txt= "+ txt);
	removesignbox();
	var len=txt.length;//텍스트 길이에 맞춰서 height를 바꾼다.
	var w=600;
	var height = Math.ceil(len/50); //올림
	var h=height * 30;

	if(chktop=="confirm")
	{
		h=h+15;
	}

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

	var str="<div id='layersign' style='position:fixed;top:0;left:0;z-index:10001;overflow:hidden;display:block;width:"+w+"px;height:"+h+"px;margin:"+top+"px 0 0 "+left+"px;padding:25px 15px 15px 15px;' class='alert "+type+"'>";
		str+="<div class='boxicon'></div>";
		if(chktop=="confirm")
		{
			str+="<p style='font-size:17px;'>"+txt+"</p>";
			str+="<dl class='confirmbtn'><dd onclick='javascript:removeSession();'>"+getTxtData("CONFIRM")+"</dd></dl>"; //확인
		}
		else
		{
			str+="<p style='font-size:17px;'>"+txt+"<a href='javascript:removesignbox();' class='close'>&times;</a></p>";
		}
		str+="</div>";

		if(chktop=="top")
		{
			$("body",parent.document).prepend(str);
			if(parseInt(delay) > 0)
				timerID=setTimeout("$('#layersign',parent.document).remove()",delay);
		}
		else
		{
			$("body").prepend(str);
			if(chktop=="confirm")
			{
			}
			else
			{
				if(parseInt(delay) > 0)
					timerID=setTimeout("$('#layersign').remove()",delay);
			}
		}
}
function removesignbox()
{
	if(!isEmpty(timerID))
		clearTimeout(timerID);
	$("#layersign").remove();
}


//========================================================================================================
//숫자만 입력가능하게
//========================================================================================================
function changeNumber(evt, check)
{
	var _value = event.srcElement.value;
	//console.log("changeNumber  evt = " + evt+", _value : " + _value);
	//한글삭제
	event.srcElement.value=_value.replace( /[ㄱ-ㅎ|ㅏ-ㅣ|가-힣]/g, '' );

	//영어삭제
	_value = event.srcElement.value;
	event.srcElement.value=_value.replace( /[a-z]/gi, '' );

    //특수문자삭제
    _value = event.srcElement.value;
    event.srcElement.value=_value.replace( /[`~!@#$%^&*|\\\'\";:\/?]/gi, '' );

    //공백 삭제
    _value = event.srcElement.value;
    event.srcElement.value=_value.replace( /^\s*/, '' );

	//최종적으로 float로 변환후 소수점 한자리
	_value = event.srcElement.value;
	_value = !(isEmpty(_value)) ? _value : 0;
	//console.log("changeNumber  evt = " + evt+", _value : " + _value);
	if(check == true)//소수점
		event.srcElement.value=parseFloat(_value).toFixed(1);
	else //정수
		event.srcElement.value=parseInt(_value);

	//console.log("changeNumber  evt = " + evt+", after  _value = " + event.srcElement.value);
}
function changePhoneNumber(evt)
{
	var _value = event.srcElement.value;
	//console.log("changeNumber  evt = " + evt+", _value : " + _value);
	//한글삭제
	event.srcElement.value=_value.replace( /[ㄱ-ㅎ|ㅏ-ㅣ|가-힣]/g, '' );

	//영어삭제
	_value = event.srcElement.value;
	event.srcElement.value=_value.replace( /[a-z]/gi, '' );

    //특수문자삭제
    _value = event.srcElement.value;
    event.srcElement.value=_value.replace( /[`~!@#$%^&*|\\\'\";:\/?]/gi, '' );

    //공백 삭제
    _value = event.srcElement.value;
    event.srcElement.value=_value.replace( /^\s*/, '' );

	//최종적으로 float로 변환후 소수점 한자리
	_value = event.srcElement.value;
	_value = !(isEmpty(_value)) ? _value : "";
	//console.log("changeNumber  evt = " + evt+", _value : " + _value);

	event.srcElement.value = _value;

}

//아이디입력(숫자와영문만가능)
function changeID(evt)
{
    var _value = event.srcElement.value;
    //console.log("changeNumber  evt = " + evt+", _value : " + _value);
    //한글삭제
    event.srcElement.value=_value.replace( /[ㄱ-ㅎ|ㅏ-ㅣ|가-힣]/g, '' );

    //최종적으로 float로 변환후 소수점 한자리
    _value = event.srcElement.value;
    _value = !(isEmpty(_value)) ? _value : "";
    //console.log("changeNumber  evt = " + evt+", _value : " + _value);
    event.srcElement.value = _value;
}

//========================================================================================================
function modinput(type,seq,btn)
{
// console.log("modinput    함수 type   "+type+"    seq:   "+seq+"         btn :"+btn);
	var arr0=arr1=arr2=arr3=arr4=arr5=arr6=arr7=arr8=read=add=worker=stat=statable=group=table=mdcode=bostatus=bostaff=txttype="";
	type=type.split("_");
	var btnName = btn.split(",");
	//var type=$(this).attr("data-type").split("_");
	//var seq=$(this).attr("data-seq");
	$(".modconfirm").remove(0);
	$(".notext").remove(0);//데이터가 없습니다 문구 사라짐  (코드추가 버튼을 누르면)
	$(".modfadeinput").removeClass("modfadeinput").fadeIn(0);
	//console.log("type[0] : "+type[0]);
	if(type[0]=="add")
	{
		//var arrtxt=$("input[name=txt1481]").val();
		//console.log(btnName.length);
		var len = btnName.length - 1;
		var arrtxt = btnName[len]; //버튼의 마지막 것 //자동추가
		var reqdata="";
		arr0=seq="add";
	}
	else
	{
		var reqdata="reqdata";
		var read="readonly";
		var arr=new Array();

		$(".modinput_"+seq).children("td").each(function(){
			if(type[1]=='pouchtag' && !isEmpty($(this).attr('data-group')))
			{
				group = $(this).attr('data-group');
				//console.log("group = " + group);
			}
			if(type[1]=='medibox' && !isEmpty($(this).attr('data-type')))
			{
				group = $(this).attr('data-type');
				//console.log("group = " + group);
			}
			if(type[1]=='medibox' && !isEmpty($(this).attr('data-table')))
			{
				table = $(this).attr('data-table');
				//console.log("table = " + table);
			}
			if(type[1]=='medibox' && !isEmpty($(this).attr('data-mdcode')))
			{
				mdcode = $(this).attr('data-mdcode');
				//console.log("table = " + table);
			}			
			if(type[1]=='pot' && !isEmpty($(this).attr('data-status')))
			{
				bostatus = $(this).attr('data-status');
				//console.log("bostatus = " + bostatus);
			}
			if(type[1]=='pot' && !isEmpty($(this).attr('data-staff')))
			{
				bostaff = $(this).attr('data-staff');
				//console.log("bostaff = " + bostaff);
			}

			if(type[1]=='textdb' && !isEmpty($(this).attr('data-type')))
			{
				txttype = $(this).attr('data-type');
				//console.log("txttype = " + txttype);
			}
			//console.log("text - " + $(this).text());
			arr.push($.trim($(this).text()));
		});
		arr0=arr[0];arr1=arr[1];arr2=arr[2];arr3=arr[3];arr4=arr[4];
		arr5=arr[5];arr6=arr[6];arr7=arr[7];arr8=arr[8];
		var arrtxt=arr0;

	}
	//console.log("arr : "+arr);
	var txt="";
	//console.log("type[1] : "+type[1]);
	switch(type[1])
	{
		case "textdb":
			var json = "seq="+seq;
			stat=$("textarea[name=selstat]").val();
			txt="<tr class='modconfirm'>";
			txt+="<td><input type='hidden' name='seq' class='reqdata' value='"+seq+"'>";
			txt+="<input type='hidden' name='tdCode' class='reqdata' value='"+arr0+"' "+read+">"+arrtxt+"</td>";
			txt+="<td>"+stat+"</td>";
			txt+="<td><input type='text' name='tdNameKor' onkeypress=callapienter(event.keyCode,'textdbupdate') class='reqdata' value='"+arr2+"'></td>";
			txt+="<td><input type='text' name='tdNameChn' onkeypress=callapienter(event.keyCode,'textdbupdate') class='reqdata' value='"+arr3+"'></td>";
			txt+="<td><input type='text' name='tdNameEng' onkeypress=callapienter(event.keyCode,'textdbupdate') class='reqdata' value='"+arr4+"'></td>";
			txt+="<td><button type='button' class='cdp-btn'><span class='cdp-btn' onclick=textdbupdate();>"+btnName[0]+"</span></button>";
			txt+=" <button type='button' class='cdp-btn'><span class='cdp-btn' onclick=callapidel('setting','textdbdelete','"+json+"')>"+btnName[1]+"</span></button></td>";
			txt+="</tr>";
			break;
		case "makingtable":  //조제대관리
			var json = "seq="+seq;
			//stat=$("textarea[name=selstat]").val();
			//stat=stat.replace("title='"+arr3+"'"," checked");
			//worker=$("textarea[name=selworker]").val();
			//worker=worker.replace("title='"+arr4+"'"," selected");
			txt="<tr class='modconfirm'>";
			txt+="<td><input type='hidden' name='seq' class='reqdata' value='"+seq+"'>";
			txt+="<input type='hidden' name='mtCode' class='reqdata' value='"+arr0+"' "+read+">"+arrtxt+"</td>";
			txt+="<td><input type='text' name='mtTitle' class='reqdata' value='"+arr1+"'></td>";
			txt+="<td><input type='text' name='mtModel' class='reqdata' value='"+arr2+"'></td>";
			txt+="<td><input type='text' name='mtLocate' class='reqdata' value='"+arr3+"'></td>";
			txt+="<td>"+arr4+"</td>";
			txt+="<td>"+arr5+"</td>";
			txt+="<td>"+arr6+"</td>";
			txt+="<td>"+arr7+"</td>";

			var Auth = $("input[name=modifyAuth]").val();

			if(Auth=="true")
			{
				txt+="<td><button type='button' class='cdp-btn'><span class='cdp-btn' onclick=makingtableupdate();>"+btnName[0]+"</span></button>";
				txt+=" <button type='button' class='cdp-btn'><span class='cdp-btn' onclick=callapidel('inventory','makingtabledelete','"+json+"')>"+btnName[1]+"</span></button></td>";
			}
			else
			{
				txt+="<td></td>";
			}
			
			txt+="</tr>";
			break;
		case "pot": //탕전기관리
			var json = "seq="+seq;
			stat=$("textarea[name=selstat]").val();
			//stat=stat.replace("title='"+arr3+"'"," checked");
			worker=$("textarea[name=selworker]").val();
			//worker=worker.replace("title='"+arr4+"'"," selected");
			txt="<tr class='modconfirm'>";
			txt+="<td><input type='hidden' name='seq' class='reqdata' value='"+seq+"'>";
			txt+="<input type='hidden' name='boCode' class='reqdata' value='"+arr0+"' "+read+">"+arrtxt+"</td>";
			txt+="<td><input type='text' name='boTitle' class='reqdata' value='"+arr1+"'></td>";
			txt+="<td><input type='text' name='boModel' class='reqdata' value='"+arr2+"'></td>";
			txt+="<td><input type='text' name='boLocate' class='reqdata' value='"+arr3+"'></td>";
			txt+="<td>"+stat+"</td>";
			txt+="<td>"+worker+"</td>";

			var Auth = $("input[name=modifyAuth]").val();

			if(Auth=="true")
			{
				txt+="<td><button type='button' class='cdp-btn'><span class='cdp-btn' onclick=potupdate();>"+btnName[0]+"</span></button>";
				txt+=" <button type='button' class='cdp-btn'><span class='cdp-btn' onclick=callapidel('inventory','potdelete','"+json+"')>"+btnName[1]+"</span></button></td>";
			}
			else
			{
				txt+="<td></td>";
			}
			
			txt+="</tr>";
			break;
		case "pouchtag":  //조제태그
			stat=$("textarea[name=selstat]").val();
			//console.log(stat);
			//stat=stat.replace("title='"+arr1+"'"," checked");
			var json = "seq="+seq;
			txt="<tr class='modconfirm'>";
			txt+="<td><input type='hidden' name='seq' class='reqdata' value='"+seq+"'>";
			txt+="<input type='hidden' name='ptCode'class='reqdata' value='"+arr0+"' "+read+">"+arrtxt+"</td>";
			txt+="<td>"+stat+"</td>";
			txt+="<td><input type='text' name='ptName1' class='reqdata' value='"+arr2+"'></td>";
			txt+="<td><input type='text' name='ptName2' class='reqdata' value='"+arr3+"'></td>";
			txt+="<td><input type='text' name='ptName3' class='reqdata' value='"+arr4+"'></td>";

			var Auth = $("input[name=modifyAuth]").val();

			if(Auth=="true")
			{
				txt+="<td><button type='button' class='cdp-btn'><span class='cdp-btn' onclick=pouchtagupdate();>"+btnName[0]+"</span></button>";
				if(seq!="add")
				{
					txt+=" <button type='button' class='cdp-btn'><span class='cdp-btn' onclick=callapidel('inventory','pouchtagdelete','"+json+"')>"+btnName[1]+"</span></button>";
					txt+=" <button type='button' class='cdp-btn'><span onclick=printbarcode('label','pouchtag|"+seq+"',500)> + "+btnName[2]+"</span></button>";
				}
			}
			else
			{
				txt+="<td>";
				if(seq!="add")
				{
					txt+=" <button type='button' class='cdp-btn'><span onclick=printbarcode('label','pouchtag|"+seq+"',500)> + "+btnName[2]+"</span></button>";
				}
			}
			txt+="</td>";
			txt+="</tr>";
			break;
		case "medibox":  //약재함관리
			var url="/99_LayerPop/layer-medicine.php?type=medibox";
			var json = "seq="+seq;
			statable=$("textarea[name=seltable]").val();
			txt="<tr class='modconfirm'>";
			txt+="<td><input type='hidden' name='seq' class='"+reqdata+"' value='"+seq+"'>";
			txt+="<input type='hidden' name='mbCode' class='reqdata' value='"+arr0+"' "+read+">";
			txt+="<input type='hidden' name='mbMedicine' class='reqdata necdata' title='약재' value='"+mdcode+"' "+read+">"+arrtxt+"</td>";
			txt+="<td>"+statable+"</td>";
			txt+="<td id='mbOriginTxt'>"+arr2+"</td>";
			txt+="<td id='hubtitle'>"+arr3+"</td>";
			txt+="<td id='medititle'>"+arr4+"</td>";
			txt+="<td id='medicode'>"+arr5+"</td>";
			txt+="<td id='medicode'>"+arr6+"</td>";
			txt+="<td id='mbcapacity'>"+arr7+"</td>";
			txt+="<td>";

			var Auth = $("input[name=modifyAuth]").val();

			if(Auth=="true")
			{
				if(seq=="add")
				{
					txt+="<button type='button' class='cdp-btn'><span class='cdp-btn' onclick=viewlayer('"+url+"',650,500,'')> + "+btnName[0]+"</span></button>";
				}
				txt+=" <button type='button' class='cdp-btn'><span class='cdp-btn' onclick=mediboxupdate();>"+btnName[1]+"</span></button>";
				if(seq!="add")
				{
					txt+=" <button type='button' class='cdp-btn'><span class='cdp-btn' onclick=callapidel('inventory','mediboxdelete','"+json+"')>"+btnName[2]+"</span></button>";
					txt+=" <button type='button' class='cdp-btn'><span onclick=printbarcode('label','medibox|"+seq+"',500)>+ "+btnName[3]+"</span></button>";
				}
			}
			else
			{
				if(seq=="add")
				{
					txt+="<button type='button' class='cdp-btn'><span class='cdp-btn' onclick=viewlayer('"+url+"',650,500,'')> + "+btnName[0]+"</span></button>";
				}
				if(seq!="add")
				{
					txt+=" <button type='button' class='cdp-btn'><span onclick=printbarcode('label','medibox|"+seq+"',500)>+ "+btnName[3]+"</span></button>";
				}
			}

			txt+="</td>";
			txt+="</tr>";
			break;
		// case "member": //한의원 소속 사용자 추가   ---> 이부분은 memberwrite.php 에 따로 함수를 만들어 작업함
		// 	stat=$("textarea[name=selstat]").val();
		// 	//console.log("stat*************"+stat);
		// 	console.log("arr"+arr);
		// 	stat=stat.replace("title='"+arr0+"'"," checked");
		// 	txt="<tr class='modconfirm'>";
		// 	txt+="<td class='radio'><input type='hidden' name='meSeq' class='reqdata' value='"+seq+"'>";
		// 	txt+="<input type='hidden' name='meUserid' class='reqdata' value='"+arr0+"' "+read+">"; //한의사 userid
		// 	txt+=""+stat+"</td>";
		// 	if(arr1==""){var chkval="0";}else{var chkval="1";}
		// 	txt+="<td><input type='text' name='meLoginid' title='아이디' class='reqdata' onkeydown='changechk()' value='"+arr1+"'>"; //아이디
		// 	txt+="<input type='hidden' name='idchk' title='' value='"+chkval+"' data-value='"+arr1+"'>";
		// 	txt+="<button type='button' class='cw-btn' onclick='useridchk()'><span>중복확인</span></button>";
		// 	txt+="<p><span class='info-ex02 mg5' id='idchktxt'>6~20자의 영문,숫자 혼합</span></p></td>";
        //
		// 	if(seq!="" && seq!="add")
		// 	{
		// 		console.log("**********"+seq);
		// 		txt+="<td><input type='text' name='mePasswd' title='비밀번호'  value='"+arr2+"'></td>"; //비밀번호
		// 	}
		// 	else
		// 	{
		// 		txt+="<td><input type='text' name='mePasswd' title='비밀번호' class='reqdata' value='"+arr2+"'></td>"; //비밀번호
		// 	}
        //
		// 	//txt+="<td><input type='text' name='mePasswd' title='비밀번호' class='reqdata' value='"+arr2+"'></td>"; //비밀번호
		// 	txt+="<td><input type='text' name='mePasswd2' title='비밀번호확인' value='' onkeyup='passwordCheck()'>"; //비밀번호확인
		// 	txt+="<div class='checkPasswd'><span class='stxt' id='idsame' style='color:red;'></span></div></td>";
        //
		// 	txt+="<td><input type='text' name='meName'  title='이름' class='reqdata' value='"+arr4+"'></td>"; //이름
		// 	txt+="<td><input type='text' name='meRegistno' title='면허번호'  value='"+arr5+"'></td>"; //면허번호
		// 	txt+="<td>"+arr6+"</td>"; //등록일
		// 	txt+="<td>";
		// 	txt+=" <button type='button' class='cdp-btn'><span class='cdp-btn' onclick=memberupdate()>"+$("input[name=txt1070]").val()+"</span></button>";
		// 	txt+=" <button type='button' class='cdp-btn'><span class='cdp-btn' onclick=callapidel('memberdelete','seq','"+seq+"')>"+$("input[name=txt1153]").val()+"</span></button>";
		// 	txt+="</td></tr>";
        //
		// 	break;
	}

	if(type[0]=="add")
	{
		$("#tbllist tbody").prepend(txt);
	}
	else
	{
		//$(this).fadeOut(0);
		//$(this).before(txt);
		$(".modinput_"+seq).addClass("modfadeinput").fadeOut(0);
		$(".modinput_"+seq).before(txt);
	}
	//$(this).children(".modtxt").focus();

	if(type[1] == 'pouchtag' && !isEmpty(group))
	{
		$("input[name=ptGroup]:radio[value="+group+"]").prop("checked", true);
	}
	if(type[1] == 'medibox' && !isEmpty(group))
	{
		$("input[name=mbType]:radio[value="+group+"]").prop("checked", true);
	}
	if(type[1] == 'medibox' && !isEmpty(table))
	{
		$("input[name=mbTable]:radio[value="+table+"]").prop("checked", true);
	}
	if(type[1]=='pot' && !isEmpty(bostatus))
	{
		$("select[name=boStatus]").val(bostatus).prop("selected", true);
	}
	if(type[1]=='pot' && !isEmpty(bostaff))
	{
		$("select[name=boStaff]").val(bostaff).prop("selected", true);
	}

	if(type[1]=='textdb' && !isEmpty(txttype))
	{
		$("input[name=txtType]:radio[value="+txttype+"]").prop("checked", true);
	}

	if(type[1] == 'pouchtag')
	{
		$("input[name=ptName1]").focus();
	}
	if(type[1] == 'pot')
	{
		$("input[name=boTitle]").focus();
	}
	if(type[1] == 'makingtable')
	{
		$("input[name=mtTitle]").focus();
	}
	if(type[1] == 'textdb')
	{
		$("input[name=tdNameKor]").focus();
	}
}
function callapienter(keycode,code)
{
	if(keycode==13)
	{
		textdbupdate();
	}
}
//약재입출고 상세페이지에서 카테고리의 이름만 보여주기 위함..
function getListData(pgid, list, data)
{
	var txt="";
	if(!isEmpty(data))
	{
		for(var key in list)
		{
			if(data == list[key]["cdCode"])
			{
				txt=list[key]["cdName"];
				break;
			}
		}
	}
	$("#"+pgid).html(txt);
}

//0426 해시작업 상세페이지까지
function viewlist(){
	var hdata=location.hash.replace("#","").split("|");
	var page=hdata[0];
	if(page==undefined){page="";}
	var seq="";
	var search=hdata[2];
	if(search ===undefined){search="";}
	makehash(page,seq,search)
}

function viewdesc(seq){
	var hdata=location.hash.replace("#","").split("|");
	var page=hdata[0];
	if(page==undefined){page="";}
	var search=hdata[2];
	if(search ===undefined){search="";}
	makehash(page,seq,search)
}


function makehash(page,seq,search){
	location.hash=page+"|"+seq+"|"+search;
}

//검색을 하면 1페이지로 간다
function searchhash(search){
	makehash(1,"",search);
}

function getdcTime(dcTime)
{
	var evaporation = 300/dcTime; // 1분당 5 
	var subTime = dcTime - 60; //입력받은 
	var addwater = (subTime > 0) ? (subTime * evaporation) : 0;
	return addwater;
}

