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
// urlData : url data 
//------------------------------------------------------------------------------------
function setUrlData(txtdt)
{
	//steptxtdt textrea에 넣는다.
	var pretty = JSON.stringify(txtdt);
	document.getElementById('urldata').value = pretty;
}
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
// jquery cookie Set,Get
//------------------------------------------------------------------------------------
//document.cookie="name=value[; expires=expires] [; path=path] [; domain=domain] [; secure]";
//.cookie('user', '홍길동', { expires: 7, path: '/', domain: 'test.com', secure: false });
function setCookie(cname, cvalue, exdays) 
{
	//$.cookie(cname, cvalue, { expires: exdays, path: '/', domain: getUrlData("DOMAIN"), secure: false });
	var nowdate = new Date();//12시간 
	nowdate.setTime(nowdate.getTime() + 60 * 60  * 1000 * 12);
	console.log("nowdate = "+nowdate);
	
	Cookies.set(cname, cvalue, { expires: nowdate, path: '/', domain: getUrlData("DOMAIN"), secure: false });
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
		deleteCookie(cookie);		
	}
}
function deleteCookie(name)
{
	setCookie(name,null,-1);
	Cookies.remove(name);
	//setCookie(name,null,-1); //$.removeCookie(cookie);
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
		url+="&stAuthKey="+encodeURI(obj["stAuthKey"]);

	$.ajax({
		type : "GET", //method
		url : url,
		data : [],
		success : function (result) {
			console.log("result = "+result+", getCookie ck_stUserid : "+getCookie("ck_stUserid")+", depart = "+obj["stDepart"]);
			window.location.href=result;
		},
		error:function(request,status,error){
			console.log("code:"+request.status+"\n"+"message:"+request.responseText+"\n"+"error:"+error);
		}
	});
}
function removeSession(url)
{
	var url="/session.php";
		url+="?type=logout&url="+url;
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
// api 호출
//------------------------------------------------------------------------------------
function callapi(type,group,code,data)
{
	var language=$("#gnb-wrap").attr("value");
	var timestamp = new Date().getTime();
	if(isEmpty(language)){language="kor";}

	var url=getUrlData("API_MEMBER")+group+"/";

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

	console.log("callapi url = " + url);

	$.ajax({
		type : type, //method
		url : url,
		data : data,
		success : function (result) {
			switch(type)
			{
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
		},
		error:function(request,status,error){
			console.log("code:"+request.status+"\n"+"message:"+request.responseText+"\n"+"error:"+error);
		}
   });
}
function saveupdate(result)
{
	var obj = JSON.parse(result);
	console.log(obj);

	if(obj["resultCode"]=="200")
	{
		if(obj["apiCode"]=="stafflogin")
		{
			setStaffLogin(obj);
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
		if(obj["resultCode"]=="899")
		{
			switch(obj["resultMessage"])
			{
			case "CHECKIDPWD":
				layersign('warning', getTxtData("INFONO"), getTxtData("CHECKIDPWD"),'2000'); //아이디와 비밀번호를 다시 확인해주세요.
			break;
			case "LOGINFAILD":
				layersign('warning', "로그인 5회 실패하였습니다.",'30분후에 다시 로그인 해 주세요.','3000'); //아이디와 비밀번호를 다시 확인해주세요.
			break;
			}
		}
		else if(obj["resultCode"]=="401")
		{
			if(obj["resultMessage"]=="Unauthorized") //권한없음 
			{
				layersign('warning', getTxtData("9011"), "",'2000'); //허용된 접속이 아닙니다. 관리자에게 문의주세요.
			}
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
	if(obj["resultCode"]=="200")
	{
		var url = obj["returnData"];
		gomainload(url);
	}
	else
	{
		alert(obj["resultCode"]+" - "+obj["resultMessage"]);
	}
}
function pad(n, width) 
{
  n = n + '';
  return n.length >= width ? n : new Array(width - n.length + 1).join('0') + n;
}
function setStaffLogin(obj)
{
	if($("#saveid").prop("checked")==true)//아이디 저장이 클릭되어 있다면
	{
		setCookie("ck_saveid", obj["stLoginid"], 365);
	}
	else
	{
		deleteCookie("ck_saveid");
	}
	if(obj["resultMessage"] == 'OK')
	{
		if(obj["stUse"] == 'Y')
		{
			if(obj["stDepart"])
			{
				var d = new Date();
				var stLogin = pad((d.getMonth() + 1), 2)+"-"+pad(d.getDate(),2)+" / "+d.getHours()+":"+d.getMinutes();

				//세션 				
				setSession(obj);

				//쿠키저장
				setCookie('ck_staffseq', obj["seq"], 365);
				setCookie('ck_stUserid', obj["stUserid"], 365);
				setCookie('ck_stStaffid', obj["stStaffid"], 365);
				setCookie('ck_stName', obj["stName"], 365);
				setCookie('ck_stDepart', obj["stDepart"], 365);
				setCookie('ck_stAuth', obj["stAuth"], 365);
				setCookie('ck_stLogin', stLogin, 365);
				setCookie('ck_authkey', obj["stAuthKey"], 365);

			}
			else
			{
				layersign('danger',getTxtData("ACCESSERR"), getTxtData("CHECKDATA"),'top');//'접속오류',' 올바른 정보를 입력하세요.'
			}
		}
		else if(obj["stUse"]=='A')
		{
			layersign('warning',getTxtData("CONFIRMWAIT"), getTxtData("EMAILOKLOGIN"),'top');//인증대기, 이메일 인증 후 로그인 가능합니다.
		}
		else
		{
			layersign('danger',getTxtData("INFONO"), getTxtData("CHECKDATA"),'top');//정보없음, 올바른 정보를 입력하세요
		}
	}
}
function gomainload(url)
{
	$('#maindiv').load(url);
}
//------------------------------------------------------------------------------------
// 팝업창 
//------------------------------------------------------------------------------------
//화면중앙팝업레이어
function popupcenter(dw,dh){
	var winwidth = $(window).width();
	var winheight = $(window).height();
	if(winheight>screen.height){
		winheight=screen.height;
	}
	var left=(parseInt(winwidth)-dw)/2;
	var top=(parseInt(winheight))/2-(dh/2);
	return top+"|"+left;
}
function popupcentertop(dw,dh)
{
	var winwidth = $(window.parent).width();
	var winheight = $(window.parent).height();
	var scheight = window.parent.$("body").scrollTop();
	var left=(parseInt(winwidth)-dw)/2;
	var top=(parseInt(winheight) - scheight -dh)/2;
	return top+"|"+left;
}
function layersign(type, maintxt, subtxt, chktop)
{
	var w=600;
	var h=100;
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
	var txt="<div id='layersign' style='position:fixed;width:"+w+"px;height:"+h+"px;top:"+top+"px;left:"+left+"px;z-index:10001;padding:50px' class='callout callout-"+type+"'>";
		txt+="<h4 style='font-size:30px;font-weight:bold;'>"+maintxt+"</h4>";
	if(subtxt!="")
	{
		txt+="<p style='font-size:20px;font-weight:bold;'>"+subtxt+"</p>";
	}
	if(chktop=="close")
	{
		txt+="<a href='javascript:closelayer();' class='close'>&times;</a>";
	}
	if(chktop=="confirm")
	{
		txt+="<dl><dd>"+getTxtData("CONFIRM")+"</dd><dd>"+getTxtData("CANCEL")+"</dd></dl>";
	}

	txt+="</div>";
	if(chktop=="top")
	{
		$("body",parent.document).prepend(txt);
		setTimeout("$('#layersign',parent.document).remove()",2000);
	}
	else
	{
		$("body").prepend(txt);
		if(chktop=="unlimit"||chktop=="close"||chktop=="confirm")
		{
		}
		else
		{
			setTimeout("$('#layersign').remove()",parseInt(chktop));
		}
	}
}
//------------------------------------------------------------------------------------
//  언어선택시
//------------------------------------------------------------------------------------
$.fn.setCustomizedSelectbox = function() {
	var $selectbox = $(this),
		$optionbox = $selectbox.children("ul.selectbox-options"),
		$options = $optionbox.children("li");
	var isOpened = false;

	function _onToggleOptionBox(event) {
		event.stopPropagation();

		var target = event.target;

		if($.inArray(target, $options) !== -1) {
			if(isOpened) return toggleOptionItem(target);
			isOpened = true;
		} else {
			if(!isOpened) return;
			isOpened = false;
		}

		$optionbox.toggleClass("opened");
	}

	function _onCloseOptionBox(event) {
		event.stopPropagation();

		var $this = $(this),
			$target = $(event.target);

		if(($.inArray(event.target, $options) !== -1 || $target.is($this)) && isOpened) {
			$optionbox.toggleClass("opened");
			isOpened = false;
		}
	}

	function toggleOptionItem(selected) 
	{
		var $selectedItem = $(selected),
			value = $selectedItem.data();
			value = value && value.value || null;

			console.log("selected = "+selected+", value = " + value);
			
		//golanguage(value);

		console.log($selectedItem);
		console.log($options);



		
		// 선택된 아이템의 값을 이곳에서 처리하면 됩니다.
		// form 에 적용한다면 hidden input box 를 만들어서 value 를 업데이트 하거나,
		// 페이지 이동이 필요하면 이곳에서 href relocation 을 처리하면 됩니다. :)

		if(!$selectedItem.hasClass("selected")) 
		{
			$options.removeClass("selected");
			$selectedItem.addClass("selected");
			$selectedItem.trigger("onSorterSelected");
		}

		$selectbox.trigger("click");

		return;
	}

	$selectbox.on("click", _onToggleOptionBox);
	$optionbox.on("mouseleave", _onCloseOptionBox);
}

$(document).ready(function() 
{
	$("#selectbox").setCustomizedSelectbox();
});

function blockRightClick()
{
	layersign('error', '무단복사를 막기 위하여 마우스 우측클릭금지가 설정되어 있습니다.', '','2000'); //아이디를 입력해주세요.
    //alert("무단복사를 막기 위하여 마우스 우측클릭금지가 설정되어 있습니다.");
    return false;
}