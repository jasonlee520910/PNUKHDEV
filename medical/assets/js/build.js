"use strict";$(document).ready(function(){}),$('.file-custom input[type="file"]').on("change",function(t){t.target.value&&($(this).parents(".file-custom").find(".upload-name").val(t.target.value),$(this).parents(".file-custom").find(".file-delete").show())}),$(".file-custom .file-delete").on("click",function(){$(this).parents(".file-custom").find("input").val(""),$(this).parents(".file-custom").find(".upload-name").val("선택된 파일 없음"),$(this).hide()}),$(".m-tab__link").on("click",function(){var t=$(this).data("tab");$(".m-tab__link").removeClass("active"),$(".m-tab__item").removeClass("active"),$(this).addClass("active"),$("#"+t).addClass("active")}),$(".modal__bg").on("click",function(){$(this).parents(".modal").hide()}),$(".modal-closeBtn").on("click",function(){$(this).parents(".modal").hide()}),$(".modal-closeBtn--type2").on("click",function(){$(this).parents(".modal").hide()}),$(".modal .tab__linkBox .tab__link").on("click",function(t){$(".modal .tab__linkBox .tab__link").removeClass("active"),$(this).addClass("active"),t.preventDefault();var i=$(this).data("tab");$(".tab__item").hide(),$("#tab-item"+i).show()}),$(".customer-service .board-tit").on("click",function(t){t.preventDefault(),$(this).parents("tr").toggleClass("active")});
//# sourceMappingURL=data:application/json;charset=utf8;base64,eyJ2ZXJzaW9uIjozLCJzb3VyY2VzIjpbImZ1bmN0aW9uLmpzIl0sIm5hbWVzIjpbInNob3dNb2RhbCIsImlkIiwiJCIsInNob3ciLCJkb2N1bWVudCIsInJlYWR5Iiwib24iLCJlIiwidGFyZ2V0IiwidmFsdWUiLCJ0aGlzIiwicGFyZW50cyIsImZpbmQiLCJ2YWwiLCJoaWRlIiwibVRhYkFjdGl2ZSIsImRhdGEiLCJyZW1vdmVDbGFzcyIsImFkZENsYXNzIiwicHJldmVudERlZmF1bHQiLCJ2IiwidG9nZ2xlQ2xhc3MiXSwibWFwcGluZ3MiOiJBQUFBLGFBb0NBLFNBQVNBLFVBQVVDLEdBQ2pCQyxFQUFFLElBQU1ELEdBQUlFLE9BbkNkRCxFQUFFRSxVQUFVQyxNQUFNLGNBQ2xCSCxFQUFFLG1DQUFtQ0ksR0FBRyxTQUFVLFNBQVVDLEdBRXREQSxFQUFFQyxPQUFPQyxRQUNYUCxFQUFFUSxNQUFNQyxRQUFRLGdCQUFnQkMsS0FBSyxnQkFBZ0JDLElBQUlOLEVBQUVDLE9BQU9DLE9BQ2xFUCxFQUFFUSxNQUFNQyxRQUFRLGdCQUFnQkMsS0FBSyxnQkFBZ0JULFVBS3pERCxFQUFFLDZCQUE2QkksR0FBRyxRQUFTLFdBQ3pDSixFQUFFUSxNQUFNQyxRQUFRLGdCQUFnQkMsS0FBSyxTQUFTQyxJQUFJLElBQ2xEWCxFQUFFUSxNQUFNQyxRQUFRLGdCQUFnQkMsS0FBSyxnQkFBZ0JDLElBQUksYUFDekRYLEVBQUVRLE1BQU1JLFNBR1ZaLEVBQUUsZ0JBQWdCSSxHQUFHLFFBQVMsV0FDNUIsSUFBSVMsRUFBYWIsRUFBRVEsTUFBTU0sS0FBSyxPQUM5QmQsRUFBRSxnQkFBZ0JlLFlBQVksVUFDOUJmLEVBQUUsZ0JBQWdCZSxZQUFZLFVBQzlCZixFQUFFUSxNQUFNUSxTQUFTLFVBQ2pCaEIsRUFBRSxJQUFNYSxHQUFZRyxTQUFTLFlBRy9CaEIsRUFBRSxjQUFjSSxHQUFHLFFBQVMsV0FDMUJKLEVBQUVRLE1BQU1DLFFBQVEsVUFBVUcsU0FFNUJaLEVBQUUsbUJBQW1CSSxHQUFHLFFBQVMsV0FDL0JKLEVBQUVRLE1BQU1DLFFBQVEsVUFBVUcsU0FFNUJaLEVBQUUsMEJBQTBCSSxHQUFHLFFBQVMsV0FDdENKLEVBQUVRLE1BQU1DLFFBQVEsVUFBVUcsU0FTNUJaLEVBQUUsbUNBQW1DSSxHQUFHLFFBQVMsU0FBVUMsR0FDekRMLEVBQUUsbUNBQW1DZSxZQUFZLFVBQ2pEZixFQUFFUSxNQUFNUSxTQUFTLFVBQ2pCWCxFQUFFWSxpQkFDRixJQUFJQyxFQUFJbEIsRUFBRVEsTUFBTU0sS0FBSyxPQUNyQmQsRUFBRSxjQUFjWSxPQUNoQlosRUFBRSxZQUFja0IsR0FBR2pCLFNBR3JCRCxFQUFFLGdDQUFnQ0ksR0FBRyxRQUFTLFNBQVVDLEdBQ3REQSxFQUFFWSxpQkFDRmpCLEVBQUVRLE1BQU1DLFFBQVEsTUFBTVUsWUFBWSIsImZpbGUiOiJmdW5jdGlvbi5qcyIsInNvdXJjZXNDb250ZW50IjpbIlwidXNlIHN0cmljdFwiO1xuXG4kKGRvY3VtZW50KS5yZWFkeShmdW5jdGlvbiAoKSB7fSk7XG4kKCcuZmlsZS1jdXN0b20gaW5wdXRbdHlwZT1cImZpbGVcIl0nKS5vbignY2hhbmdlJywgZnVuY3Rpb24gKGUpIHtcbiAgLy8gYWxlcnQoZS50YXJnZXQudmFsdWUpXG4gIGlmIChlLnRhcmdldC52YWx1ZSkge1xuICAgICQodGhpcykucGFyZW50cygnLmZpbGUtY3VzdG9tJykuZmluZCgnLnVwbG9hZC1uYW1lJykudmFsKGUudGFyZ2V0LnZhbHVlKTtcbiAgICAkKHRoaXMpLnBhcmVudHMoJy5maWxlLWN1c3RvbScpLmZpbmQoJy5maWxlLWRlbGV0ZScpLnNob3coKTtcbiAgfVxuXG4gIDtcbn0pO1xuJCgnLmZpbGUtY3VzdG9tIC5maWxlLWRlbGV0ZScpLm9uKCdjbGljaycsIGZ1bmN0aW9uICgpIHtcbiAgJCh0aGlzKS5wYXJlbnRzKCcuZmlsZS1jdXN0b20nKS5maW5kKCdpbnB1dCcpLnZhbCgnJyk7XG4gICQodGhpcykucGFyZW50cygnLmZpbGUtY3VzdG9tJykuZmluZCgnLnVwbG9hZC1uYW1lJykudmFsKCfshKDtg53rkJwg7YyM7J28IOyXhuydjCcpO1xuICAkKHRoaXMpLmhpZGUoKTtcbn0pOyAvLyBtYWluIHRhYlxuXG4kKCcubS10YWJfX2xpbmsnKS5vbignY2xpY2snLCBmdW5jdGlvbiAoKSB7XG4gIHZhciBtVGFiQWN0aXZlID0gJCh0aGlzKS5kYXRhKCd0YWInKTtcbiAgJCgnLm0tdGFiX19saW5rJykucmVtb3ZlQ2xhc3MoJ2FjdGl2ZScpO1xuICAkKCcubS10YWJfX2l0ZW0nKS5yZW1vdmVDbGFzcygnYWN0aXZlJyk7XG4gICQodGhpcykuYWRkQ2xhc3MoJ2FjdGl2ZScpO1xuICAkKCcjJyArIG1UYWJBY3RpdmUpLmFkZENsYXNzKCdhY3RpdmUnKTtcbn0pOyAvLyBtb2RhbFxuXG4kKCcubW9kYWxfX2JnJykub24oJ2NsaWNrJywgZnVuY3Rpb24gKCkge1xuICAkKHRoaXMpLnBhcmVudHMoJy5tb2RhbCcpLmhpZGUoKTtcbn0pO1xuJCgnLm1vZGFsLWNsb3NlQnRuJykub24oJ2NsaWNrJywgZnVuY3Rpb24gKCkge1xuICAkKHRoaXMpLnBhcmVudHMoJy5tb2RhbCcpLmhpZGUoKTtcbn0pO1xuJCgnLm1vZGFsLWNsb3NlQnRuLS10eXBlMicpLm9uKCdjbGljaycsIGZ1bmN0aW9uICgpIHtcbiAgJCh0aGlzKS5wYXJlbnRzKCcubW9kYWwnKS5oaWRlKCk7XG59KTtcblxuZnVuY3Rpb24gc2hvd01vZGFsKGlkKSB7XG4gICQoJyMnICsgaWQpLnNob3coKTtcbn1cblxuOyAvLyB0YWJcblxuJCgnLm1vZGFsIC50YWJfX2xpbmtCb3ggLnRhYl9fbGluaycpLm9uKCdjbGljaycsIGZ1bmN0aW9uIChlKSB7XG4gICQoJy5tb2RhbCAudGFiX19saW5rQm94IC50YWJfX2xpbmsnKS5yZW1vdmVDbGFzcygnYWN0aXZlJyk7XG4gICQodGhpcykuYWRkQ2xhc3MoJ2FjdGl2ZScpO1xuICBlLnByZXZlbnREZWZhdWx0KCk7XG4gIHZhciB2ID0gJCh0aGlzKS5kYXRhKCd0YWInKTtcbiAgJCgnLnRhYl9faXRlbScpLmhpZGUoKTtcbiAgJCgnI3RhYi1pdGVtJyArIHYpLnNob3coKTtcbn0pOyAvLyBub3RpY2VcblxuJCgnLmN1c3RvbWVyLXNlcnZpY2UgLmJvYXJkLXRpdCcpLm9uKCdjbGljaycsIGZ1bmN0aW9uIChlKSB7XG4gIGUucHJldmVudERlZmF1bHQoKTtcbiAgJCh0aGlzKS5wYXJlbnRzKCd0cicpLnRvZ2dsZUNsYXNzKCdhY3RpdmUnKTtcbn0pOyJdfQ==


$('.custom-img-selected-item').on('click', function(){
    $(this).parents('.custom-img-select').find('.custom-img-select-options').toggle();
})
$('.custom-img-select input').on('change', function(){
    var src = $(this).data('src');
    var value = this.value;
    $(this).parents('.custom-img-select').find('.selectedImg').attr('src', src);
    $(this).parents('.custom-img-select').find('.custom-img-select-options').hide();
    console.log(value);
})

//20200310:layer 팝업 
function showModal(t)
{
	console.log("showModal >>>"+t);
	if(t=="modal-login" || t=="modal-dictionary")
	{
		var url="/_LayerPop/"+t+".php";
		$("#viewlayer").remove();

		$("body").prepend("<div id='viewlayer'></div>");
		$("#viewlayer").load(url);
	}
	else if(t=="modal-medical-info"||t=="modal-member-info")
	{
		if(t=="modal-medical-info")
		{
			$("#modal-member-info").data("type","medical"); 
		}
		else
		{
			$("#modal-member-info").data("type","member");//수정하기할때 비번 한번더 입력
		}
		$("#modal-member-info").show();
	}
	else
	{
		$("#"+t).show();
	}
}
function hiddenModal(t)
{
	if(t=="modal-login" || t=="modal-dictionary")
	{
		$("#viewlayer").remove();
	}
	else
	{
		$("#"+t).hidden();
	}
}

/* 0623 일단주석처리
//20200311:화면상세페이지 
function viewdesc(seq)
{
	console.log("viewdesc seq="+seq);
	var hdata=location.hash.replace("#","").split("|");
	var page=hdata[0];
	if(page==undefined){page="";}
	var search=hdata[2];
	if(search ===undefined){search="";}
	makehash(page,seq,search)
}
*/
function makehash(page,seq,search)
{
	location.hash=page+"|"+seq+"|"+search;
}
/*   pnuhdevmedical@djmedi.kr:/www/_Js/jquery.200605.js 로 이사(0612)
//20200312:로그인
function setSession(id)
{
	var url="/session.php";
		url+="?seq=1";
		url+="&userid="+encodeURI(id);
		url+="&url=index.php";

		$.ajax({
			type : "GET", //method
			url : url,
			data : [],
			success : function (result) {
				console.log("result = "+result);
				window.location.href=result;
			},
			error:function(request,status,error){
				console.log("code:"+request.status+"\n"+"message:"+request.responseText+"\n"+"error:"+error);
			}
		});
}

//20200312:로그아웃
function removeSession()
{
	var url="/session.php";
		url+="?type=logout&url=index.php";
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
			//console.log("code:"+request.status+"\n"+"message:"+request.responseText+"\n"+"error:"+error);
		}
	});
	
}
*/
