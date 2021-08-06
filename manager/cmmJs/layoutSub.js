var _thisSite = {};	
var _thisPage = {};
var _isMobile_ = false;
var _isLowBr_ = false 
var bodyHeight ;
var headerH_;
var ContentH_;
function resizeVisImg(){
	var limit_w =(_isLowBr_)? wsize.win.w : $(".div-wrap:eq(0)").width();
	if(limit_w > 1000 ) limit_w = 1000;
	$(".visimg-wr").each(function(){
		var $bg = $(".visImg-bg",this);
		var $img = $(".visimg-img img",this);

		var imgSize = {w:$img.attr("org_width"),h:$img.attr("org_height")};

		var resizeRate = (imgSize.w > 1000)? (limit_w / 1000) : (limit_w / imgRsize.w);
		var resizeTo = {w: resizeRate * imgSize.w , h: resizeRate * imgSize.h};
		$img.css({"width":resizeTo.w,"height":resizeTo.h});
		$img.parent().css({"position":"absolute","margin-left":-1 * ((resizeTo.w)/2 ),"left":"50%","width":resizeTo.w,"height":resizeTo.h});
		$bg.css({height:resizeTo.h});
		$(this).parent().css({"height":resizeTo.h});
	});
}
function initPageLayout(){
	resetTabSize();
	initNavigation();
	resetImgZoom();
	if(_thisPage.initAction!=undefined && _thisPage.initAction.length>0){$(_thisPage.initAction).each(function(i,func){try{func();}catch(e){ alert(e);}});}
}
function setPageLayout(){
	resetTabSize();
	if(_thisPage.initAction!=undefined && _thisPage.initAction.length>0){$(_thisPage.initAction).each(function(i,func){try{func();}catch(e){ alert(e);}});}
	try{ thisPageResizeAction(); }catch(e){}
    
	var headerH_ = $('#header-wrap').outerHeight();
	var bodyHeight = document.documentElement.clientHeight;
	var ContentH_ = $('#contents-wrap').outerHeight();

	//console.log("bodyHeight = " + bodyHeight+", wsize.win.w = " + wsize.win.w+", headerH_ = " + headerH_+", ContentH_ = " + ContentH_);
	
	if( bodyHeight < 768 && wsize.win.w>1024){
		//$('#container-wrap').css({'height': ContentH_ + 49 });
		$('#footer').css({'position':'relative','left':'auto','bottom':'auto'})
		
	}
	if ( bodyHeight > 768 && wsize.win.w>1024){
		if( bodyHeight - headerH_ + 49 <  ContentH_ + 49){
			//$('#container-wrap').css({'height': ContentH_ + 49 }); //기존소스
			$('#container-wrap').css({'height':'auto' });//DOO : 바꾼소스 
			$('#footer').css({'position':'relative','left':'auto','bottom':'auto'})
			
		}else{
			//$('#container-wrap').css({'height': bodyHeight - headerH_ - 49 }); //기존소스
			$('#container-wrap').css({'height':'auto' });//DOO : 바꾼소스 
			$('#footer').css({'position':'fixed','left':'0','bottom':'0'})
		}
		

		
	}
	if ( wsize.win.w<1024){
		//$('#container-wrap').css({'height':'auto' });
		$('#footer').css({'position':'relative','left':'auto','bottom':'auto'})
	}
	
}
function resetPageLayout(){
	resetTabSize();
	mainNavi._reset();
	resetImgZoom();
	if(_thisPage.resizeAction!=undefined && _thisPage.resizeAction.length>0){$(_thisPage.resizeAction).each(function(i,func){try{func();}catch(e){ alert(e);}});}
	try{ thisPageResizeAction(); }catch(e){}
	if(wsize.win.w>1000){
		$("#leftmenu").show();
	}
	if(wsize.win.w>1024){
		$('#user-wrap').css({'height':'auto','padding':'15px'})
	}
	if(wsize.win.w<1024){
		$('#user-wrap').css({'height':'0','padding':'0'})
		$('#project-name').find('#view-btn').removeClass('isOver');
		projectInfo = false;
	}
	
	var headerH_ = $('#header-wrap').outerHeight();
	var bodyHeight = document.documentElement.clientHeight;
	var ContentH_ = $('#contents').outerHeight();
	
	if( bodyHeight < 768 && wsize.win.w>1024){
		//$('#container-wrap').css({'height': ContentH_ + 49 });
		$('#footer').css({'position':'relative','left':'auto','bottom':'auto'})
		
	}
	if ( bodyHeight > 768 && wsize.win.w>1024){
		if( bodyHeight - headerH_ + 49 <  ContentH_ + 49){
			//$('#container-wrap').css({'height': ContentH_ + 49 });
			$('#footer').css({'position':'relative','left':'auto','bottom':'auto'})
			
		}else{
			$('#container-wrap').css({'height': bodyHeight - headerH_ - 49 });
			$('#footer').css({'position':'fixed','left':'0','bottom':'0'})
		}
		
	}
	if ( wsize.win.w<1024){
		$('#container-wrap').css({'height':'auto' });
		$('#footer').css({'position':'relative','left':'auto','bottom':'auto'})
	}
	
	
}
function resizePageLayoutHeight(){
}


function setScrollEndLayout(){
	var scrTop = $(window).scrollTop();	
	var chkH = $("#header-wrap").height();
	
	if(_thisPage.scrollAction!=undefined && _thisPage.scrollAction.length>0){
		$(_thisPage.scrollAction).each(function(i,func){
			try{func();}catch(e){ alert(e);}		
		});	
	}
}
function setScrollAfertLayout(){
}
function setWindowRotation(){
	if(typeof(thisPageRotation)=="function" && thisPageRotation!=undefined){
		thisPageRotation();
	}else{
	}
}
if('onorientationchange' in window){window.addEventListener('onorientationchange', setWindowRotation, false);}

$(document).ready(function(){
	try{initPageCssFiles();}catch(e){}
	try{initPageJavascript();}catch(e){}
	try{getWindowSize();}catch(e){ alert(e);}
	try{getPageSize();}catch(e){}
	try{setLowBrowser();}catch(e){	}
	try{initPageLayout();}catch(e){	}
	try{setMediaObjectFunc();}catch(e){	}
	//try{resetTabSize();}catch(e){}
	try{_thisLayout_style = getPageStyle(); }catch(e){}
	docLoading(function(){
	});
});
$(window).load(function(){
	try{initImgSizeInfo();}catch(e){	}
	setPageLayout();	
});
$(window).resize(function(e){
	var resizeTimeGap = 10;
	if(_isLowBr_) resizeTimeGap=100;
	clearTimeout(window.resizeEvt);
	window.resizeEvt = setTimeout(function()
	{
		getWindowSize();getPageSize();
		try{
		if(old_wsize.win== undefined ||  wsize.win.w!=old_wsize.win.w){
			resetPageLayout();
		}else{
			resizePageLayoutHeight();
		}
		}catch(e){
			resetPageLayout();
		}
		try{ 		
			$(msgPopArr).each(function(k,pp){
				pp._resize();
			});
		}catch(e){}
	}, resizeTimeGap);
});

$(window).scroll(function(){
	var scrTimeGap = 10;
	if(_isLowBr_) scrTimeGap=200;
	clearTimeout(window.scrollEvt);
	window.scrollEvt = setTimeout(function()
	{
		try{ setScrollEndLayout();}catch(e){}
		
	}, scrTimeGap);
	
	clearTimeout(window.scrollAfterEvt);
	window.scrollAfterEvt = setTimeout(function()
	{
		try{ setScrollAfertLayout();}catch(e){}
	}, 5000);

});
