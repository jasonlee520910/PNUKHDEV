var _thisLayout_style = {};
var _orgLayout_style = {};
var _thisPage_cfg  = {};
function checkPageStyle(){
	_orgLayout_style =  $.extend({},_thisLayout_style);  _thisLayout_style = getPageStyle();
}
function getPageStyle(){
	var pg_type = {};
	var chkW = $("body").width();
	if(_isLowBr_ && chkW >999) chkW = wsize.win.w;
	return pg_type;

}
function _getLayoutHeaderHeight(){
	return	$("#header-wrap").height();
}
function _getLayoutFooterHeight(){
	return	$("#footer-wrap").height();
}

function resetTabSize(){
	var tabLimit = 6;
try{
	if(_thisPage_cfg.tab_line_limit!=undefined && _thisPage_cfg.tab_line_limit) tabLimit = _thisPage_cfg.tab_line_limit;
}catch(e){}

	/*if($(".u-tab01").not(".wfull").not(".noAutoTab").length>0){
		$(".u-tab01").not(".wfull").not(".noAutoTab").rspnsvTab_fwidth({height:40,showCtrlBtns:true,line_limit: tabLimit});
	}*/

	//setContToggleViewTab();
	if($(".b-tab01").not(".noAutoTab").length>0){
		$(".b-tab01").not(".noAutoTab").rspnsvTab_auto({height:49,showCtrlBtns:true,ctrlBtnWidth:51,line_limit: 8});
	}
}

function viewFolingItem(id,h){
	
		if($('#'+id).hasClass("isOpen")){
			$('#'+id).stop().animate({"height":0},400);
			$('#'+id).removeClass("isOpen");
			$("#"+id+"-tit a").removeClass("over");
		}else{
			$('#'+id).stop().animate({"height":h},400);
			$('#'+id).addClass("isOpen");
			$("#"+id+"-tit a").addClass("over");
		}
}
//다중폴딩
function viewFolingListItem(idx){
	var obj = $(".foldings-list #foldings-data"+idx);
	var obj_other = $(".foldings-list li").not("#foldings-data"+idx);
	
	$(".foldings-in-cont",$(obj_other)).slideUp("fast");
	$(obj_other).removeClass("over");			

	if(obj.hasClass("over")){
		
		$(".foldings-in-cont",$(obj)).slideUp("fast");
		$(obj).removeClass("over");
	}else{

		$(".foldings-in-cont",$(obj)).slideDown("fast");
		$(obj).addClass("over");
	}

}
//전체 메뉴 보기
function viewSiteAllMenu(){
	if(mainNavi.mnType=="H"){
		mainNavi_H.toggleMenu();
		return false;
	}else{
		return true;
	}

}
// 이미지확대 버튼
function resetImgZoom(){
	var zwObj =  $('.img-zoom');
	zwObj.each(function(){
		var this_s = $(this);
		var zwObjImg = this_s.children("img");
		var zwObjUrl = zwObjImg.attr("src");		
		var win_w = $(window).innerWidth();

		if(win_w<=768){					
			this_s.append("<a href='" + zwObjUrl + "' class='btn-zoom' target='_blank' title='새창열림'><span class='blind'>이미지 확대보기</span></a>");		
			zwObjImg.addClass("zoom");
		}
	});	
}


