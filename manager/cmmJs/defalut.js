var $wbr =getBrowsertInfo();
var wsize = null;	
var psize = null;
var lowIeChk = {old_w:0,old_h:0 }
function getWindowSizeObj(){
		var sizeObj = {
		scr : {w:screen.width,h:screen.height},
		availscr : {w:screen.availWidth,h:screen.availHeight},
		win : (_isLowBr_)? {w:$(window).width(),h:$(window).height()}: {w:window.innerWidth,h:window.innerHeight}
	}
	return sizeObj;
}
function getPageSizeObj(){
	var sizeObj = {
		doc : {w:document.documentElement.scrollWidth,h:document.documentElement.scrollHeight},
		scroll : {x:document.documentElement.scrollLeft,y:document.documentElement.scrollTop,top:$(window).scrollTop(),left:$(window).scrollLeft()}
		, header:{h:$("#header-wrap").height()}, footer:{h:$("#footer-wrap").height() + 1}
	};
	return sizeObj;
}
function getWindowSize(){
	wsize =getWindowSizeObj();
}
function getPageSize(){
	psize = getPageSizeObj();
	printWinSizeInfo();
}
function printWinSizeInfo(){
	var str = "";
	str +="window [w : "+wsize.win.w+", h:"+wsize.win.h+"] ";		
	str +="doc [w : "+psize.doc.w+", h:"+psize.doc.h+"]<br/>";
}
var docChkTimer = null;var DOC_COMPLET = null;
function docLoading(loadFunc){
	clearTimeout(docChkTimer);
	if(document.readyState=="loaded" || document.readyState=="complete"){
		DOC_COMPLET = true;
		if(loadFunc!=undefined) loadFunc();
	}
	else{
		docChkTimer = setTimeout(function(){docLoading(loadFunc);},500);
	}
}
function getBrowsertInfo(){
	var $agent = navigator.userAgent;
	var $s = "";
	var $br = {browser:"",browserType:"",browserVer:[]};
		
    if ((/msie 5.0[0-9]*/i).test($agent))         { $s = "MSIE 5.0"; }
    else if((/msie 5.5[0-9]*/i).test($agent))     { $s = "MSIE 5.5"; }
    else if((/msie 6.0[0-9]*/i).test($agent))     { $s = "MSIE 6.0"; }
    else if((/msie 7.0[0-9]*/i).test($agent))     { $s = "MSIE 7.0"; }
    else if((/msie 8.0[0-9]*/i).test($agent))     { $s = "MSIE 8.0"; }
    else if((/msie 9.0[0-9]*/i).test($agent))     { $s = "MSIE 9.0"; }
	else if((/msie 10.0[0-9]*/i).test($agent))     { $s = "MSIE 10.0"; }
	else if((/windows*/i).test($agent) && (/rv:11.0[0-9]*/i).test($agent))     { $s = "MSIE 11.0"; }
    else if((/msie 4.[0-9]*/i).test($agent))      { $s = "MSIE 4.x"; }
    else if((/firefox/i).test($agent))            { $s = "FireFox"; }
    else if((/safari/i).test($agent))            { $s = "FireFox"; }
    else if((/x11/i).test($agent))                { $s = "Netscape"; }
    else if((/opera/i).test($agent))              { $s = "Opera"; }
    else if((/gec/i).test($agent))                { $s = "Gecko"; }
    else if((/bot|slurp/i).test($agent))          { $s = "Robot"; }
    else if((/internet explorer/i).test($agent))  { $s = "IE"; }
    else if((/mozilla/i).test($agent))            { $s = "Mozilla"; }
    else { $s = ""; }
	$br.browser = $s;
	if((/msie/i).test($s)){
		$br.browserType = "IE";
		$br.browserVer =  $s.replace("MSIE " ,"").split(".");
	}
	return $br;
}

function popHide(pop_id){
	if (document.getElementById("chk"+pop_id).checked==true)
	{
		setCookie( pop_id, "done" , 24); 
	}
	document.getElementById(pop_id).style.display = "none";
}
function popClose(pop_id){
	if (document.getElementById("chk"+pop_id).checked==true)
	{
		setCookie( pop_id, "done" , 1); 
	}
	this.close();
}

function checkPop(pop_id) {
	if ( getCookie(pop_id) != "done" ) {
		document.getElementById(pop_id).style.display = "";
	}else{
		document.getElementById(pop_id).style.display = "none";
	}
}
function getCookie( name )
{
	var nameOfCookie = name + "=";
	var x = 0;
	while ( x <= document.cookie.length )
	{
		var y = (x+nameOfCookie.length);
		if ( document.cookie.substring( x, y ) == nameOfCookie ) {
			if ( (endOfCookie=document.cookie.indexOf( ";", y )) == -1 )
				endOfCookie = document.cookie.length;
			return unescape( document.cookie.substring( y, endOfCookie ) );
		}
		x = document.cookie.indexOf( " ", x ) + 1;
		if ( x == 0 )
			break;
	}
	return "";
}

function setCookie( name, value, expiredays ){ 
	var todayDate = new Date(); 
	todayDate.setDate( todayDate.getDate() + expiredays ); 
	document.cookie = name + "=" + escape( value ) + "; path=/; expires=" +		todayDate.toGMTString() + ";" 
}




