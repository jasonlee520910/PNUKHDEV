
function modalzip(field){
	var txt="<!-- S: modalpostalpop --><div class='modalpostalpop'>";
			txt+="<div class='postalpop' id='modalpostalpop' style='width:800px;height:600px;'></div>";
			txt+="</div><!-- //E: modalpostalpop -->";

	$("#wrap").before(txt);
	$("#modalpostalpop").load("/_module/postal/index.php?field="+field);
	modalpopview('postalpop');
}

var yOffset;
function modalpopview(modalName){
	var modalWidth = $("#modalpostalpop").width()/2;
	var modalHeight = $("#modalpostalpop").height()/2;
	$(".translayer").remove();
	$("#wrap").append("<div class='translayer' style='position:fixed'></div>");
	$(".translayer").attr("onclick", "modalHide('"+modalName+"')");
	//$(".modalpostalpop .popupwrap."+modalName).css("top", "50%").css("left","50%").css("margin-top", -modalHeight+s100+"px").css("margin-left", -modalWidth+"px").animate({opacity:1}, 500);
	$(".modalpostalpop").css({"width":$("#modalpostalpop").width()+"px"});
	$("#modalpostalpop").css({"position":"absolute","top":"50px","margin":"auto"}).animate({opacity:1}, 500);
}

function modalpophide(modalName){
	$("#modalpostalpop").animate({opacity:0}, 400, function(){
		//$(".modalpostalpop .popupwrap."+modalName).css("top", "-99999px").css("left","-99999px");
		$(".modalpostalpop ."+modalName).css("top", "-99999px");
		$("#viewlayer").remove();
	})
	$(".translayer").animate({opacity:0}, 400, function(){
		$(this).remove();
		$("#viewlayer").remove();
	});
	$("#screendiv").fadeOut(300).remove();
	$("#viewlayer").remove();
	yOffset = 0;
}

//우편번호선택
function contactzip(no){
	var addr1=$(".result_"+no+"").find(".zipno").html().split("<br>");
	var addr2=$(".result_"+no+"").find(".addr").html().split("<br>");
	//var addr2=$(".result_"+no+"").find("dd").html().split("<br>");
	//var address = [ addr1[0], addr1[1], addr2[0], addr2[1], addr2[2], addr2[3]];
	//alert($("input[name=returnfield]").val());
	$("input[name="+$("input[name=zipfld]").val()+"]").val(addr1[0]);
	$("input[name="+$("input[name=addrfld]").val()+"]").val(addr2[0]);
	goscreen("close");
	modalpophide("postalpop");
	return;
}

function gopostalpage(page){
	$("input[name=currentPage]").val(page);
	postallist();
}

function postallist(){
	var apiUrl=encodeURI($("input[name=apiUrl]").val());
	var confmKey=encodeURI($("input[name=confmKey]").val());
	var currentPage=$("input[name=currentPage]").val();
	var countPerPage=$("input[name=countPerPage]").val();
	var keyword=encodeURI($.trim($("#keyword").val()));
	if(keyword==""){alert("도로명을 입력해 주세요");$("#keyword").focus();return;}
	var url="/_module/postal/postal.lib.php?apiUrl="+apiUrl+"&confmKey="+confmKey+"&currentPage="+currentPage+"&countPerPage="+countPerPage+"&keyword="+keyword;
	$("#postallist").load(url);
}
