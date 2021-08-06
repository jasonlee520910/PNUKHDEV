function apiurl(){
	var url="https://api.pnuh.djmedi.net";
	return url;
}

function callapi(type,url,data)
{
	var authkey=$("input[name=ssAuthkey]").val();
	
	$.ajax({
		"url" : apiurl()+url+data,
		"type" : type,
		"data" : data,
		//"headers" : {"authkey":authkey},
		"success" : function(result) {
			var json = JSON.parse(result);

			if(json["apiCode"]=="memberlevel")
			{
				$("#lflevel").text(json["grade"]);
			}
			else
			{
				makepage(result);
			}
		},
		"error" : function(request,error)
		{
			alert("Request: "+JSON.stringify(request));
		}
	});
}

function makelist(result, marr)
{
	var json = JSON.parse(result);
		console.log(json);

console.log("여기서 검색어를 넣으면 깜박 api에서 받은 값으로 넣는것임....search>>> "+json["search"]);
//$("input[name=searchTxt]").val(decodeURI(searchTxt));
$("input[name=search]").val(json["search"]);

	if(json["resultCode"]=="200")
	{
		console.log("apiCode    >>> "+json["apiCode"]);
		var data="";
		
		$.each(json["list"] ,function(index, val){
			data+="<tr onclick='viewdesc("+val["seq"]+")'>";
			for(i=0;i<marr.length;i++){
				data+="<td>"+val[marr[i]]+"</td>";
			}
			data+="</tr>";
		});
		$("#tbl tbody").html(data);
		//$("#totcnt").text(json["tcnt"]);
		paging("paging", json["tpage"],  json["page"]);
	}
	else if(json["recode"]=="204")
	{
		alert(json["remsg"]);
		return false;
	}
}

//검색어도 함께 묶어서 api
function getdata(apiCode)
{
	var data = "?apiCode="+apiCode+"&language=kor";
	$(".ajaxdata").each(function(){
		var name=$(this).attr("name");
		data+="&"+name+"="+encodeURI($(this).val());
	});


	var hdata=location.hash.replace("#","").split("|");
	var page=hdata[0];
	if(page){data+="&page="+page;}
	var searchTxt=hdata[2];
	if(searchTxt){data+="&searchTxt="+searchTxt;}
	//console.log("API를 그리기전에 검색단어를 넣는다."+searchTxt);
	//$("input[name=search]").val(searchTxt);	

	//검색어를 여기서 보낼
	console.log(" 최종 api호출 getdata  data   >>>  "+data);	
	return data;
}

function makediv(url){
	var txt="<div id='makediv' style='position:fixed;width:100%;height:200px;border:1px solid blue;display:none;'></div>";
	$("body").prepend(txt);
	$("#makediv").load(url);
}

function gotop(){
	$("html, body").animate( { scrollTop : 0 }, 200 );
}

function logout(){
	var userid=$("#ss_userid").attr("value");
	var data="apiCode=logout&userid="+userid;
	makediv("/session.php?"+data);
}

//페이징
function paging(pgid, tpage, page)
{
	var block=psize=10;
	var prev=next=0;
	var inloop = (parseInt((page - 1) / block) * block) + 1;
	prev = inloop - 1;
	next = inloop + block;
	var txt="<div class='paging__arrow d-flex'>";
	var link = "";
	if(prev<1){prev = 1;}	link = "gopage("+prev+")";
	txt+="<a href='javascript:gopage(1);'  class='paging__btn paging__fst'>처음</a></li>";
	txt+="<a href='javascript:"+link+";' class='paging__btn paging__prev'>이전</a></div>";
	if(tpage == 0)//데이터가 없을 경우
	{
		txt+="<a href='javascript:gopage(1);'>1</a>";
	}
	else
	{
		for (var i=inloop;i < inloop + block;i++)
		{		
			if (i <= tpage)
			{
				if(i==page){var cls="active";}else{var cls="";}
				txt+="<a href='javascript:gopage("+i+");'  class='"+cls+"'>"+i+"</a>";
			}
		}
	}
	txt+="</div><div class='paging__arrow d-flex'>";
	if(next>tpage){next=tpage;}	link = "gopage("+next+");";
	txt+="<a href='javascript:"+link+";' class='paging__btn paging__next'>다음</a>";
	txt+="<a href='javascript:gopage("+tpage+");' class='paging__btn paging__lst'>마지막</a>";
	txt+="</div>";
	$("#"+pgid).html(txt);
	return;
}

function sethash()
{
	console.log("sethash sethash ");
	var page=$("input[name=page]").val();
	if(page==undefined)page="";
	var seq=$("input[name=seq]").val();
	if(seq==undefined)seq="";
	var search=$("input[name=search]").val();
	console.log("search 검색단어 넘기기  >>  "+search);


//$("input[name=search]").val(decodeURI(search));

	if(search==undefined)search="";
	var searchsel=$("select[name=searchsel]").val();
	if(searchsel==undefined)searchsel="";
	console.log("sethash   >>> "+page+"|"+search+"|"+searchsel);
	location.hash=page+"|"+seq+"|"+encodeURI(search)+"|"+encodeURI(searchsel);
}

function gethash(){
	var hdata=location.hash;
		console.log(hdata);
	if(hdata!=""){
		var arr=hdata.split("|");
		$("input[name=page]").val(arr[0]);
		$("input[name=search]").val(decodeURI(arr[1]));
		$("select[name=searchsel]").val(arr[2]);
	}
}

function gopage(no)
{
	$("input[name=page]").remove();
	var chkpop=$("#poppaging").hasClass("paging-wrap");
	if(chkpop==true)
	{
		var txt="<input type='hidden' class='ajaxdata' name='poppage' value='"+no+"'>";
		$("#poppaging").prepend(txt);
		sethash();
		poplist();
	}
	else
	{
		var txt="<input type='hidden' class='ajaxdata' name='page' value='"+no+"'>";
		$("#paging").prepend(txt);
		sethash();
		//getlist();
		gotop();
	}
}

function screen(){
	var chk=$("#screendiv").css("position");
	if(chk!="absolute"){
		var h=$(window).height();
		var screen="<div id='screendiv' style='position:absolute;width:100%;height:"+h+"px;background:#333;opacity:0.5;z-index:1000;'><div>";
		$("body").prepend(screen);
	}
}

function viewlayertxt(url,width,height){
	$("#popdiv").remove();
	screen();
	var txt="<div id='popdiv' style='position:absolute;width:100%;height:0;z-index:1100;'>";
				txt+="<div id='layerdiv' style='width:"+width+"px;height:"+height+"px;margin:50px auto;background:#fff;padding:10px;overflow-y:scroll;'></div>";
				txt+="</div>";
	$("body").prepend(txt)
	$("#layerdiv").html(url);
}

function viewlayer(url){
	$("#popdiv").remove();
	screen();
	var txt="<div id='popdiv' style='position:absolute;width:100%;height:0;z-index:1100;'>";
				txt+="<div id='layerdiv' style='width:600px;margin:50px auto;'></div>";
				txt+="</div>";
	$("body").prepend(txt)
	$("#layerdiv").load(url);
}

function viewlayer2(url){
	$("#popdiv2").remove();
	screen();
	var txt="<div id='popdiv2' style='position:absolute;width:100%;height:0;z-index:1110;'>";
				txt+="<div id='layerdiv2' style='width:600px;margin:50px auto;'></div>";
				txt+="</div>";
	$("body").prepend(txt)
	$("#layerdiv2").load(url);
}

function layerclose(){
	$("#popdiv").remove();
	$("#screendiv").remove();
}

function layer2close(){
	$("#popdiv2").remove();
	var chk=$("#popdiv").css("position");
	if(chk!="absolute"){
		$("#screendiv").remove();
	}
}

function goupdate(method,dir,code){
	var nec="Y";
	$(".ajaxnec").each(function(){
		if($(this).val()==""){nec="N";}
	});
	if(nec=="N"){
		alert("필수값 입력!");
	}else{
		var datalink=$("#regibtn").attr("onclick");
		var datatitle=$("#regibtn").text();
		$("#regibtn").attr({
			"data-link":datalink
			,"data-title":datatitle
			,"onclick":""
		}).text("등록/업데이트 중....");
		var data=getdata(code);
		callapi(method,dir,getdata(code));
	}
}

//기간선택 클릭시
function setperiod(data)
{
	//console.log("-----------------------------> setperiod data : " + data);
	var tmp="";
	var d=new Date();
	var e=d.getFullYear()+"-"+("0" +(d.getMonth() + 1)).slice(-2)+"-"+("0" +(d.getDate())).slice(-2);
	switch(data){
		case "today":break;
		case "yesterday":d.setDate(d.getDate() - 1);break;
		case "week":d.setDate(d.getDate() - 7);break;
		case "month":d.setMonth(d.getMonth() - 1);break;
		case "month3":d.setMonth(d.getMonth() - 3);break;
		case "month4":d.setMonth(d.getMonth() - 6);break;
	}
	var s=d.getFullYear()+"-"+("0" +(d.getMonth() + 1)).slice(-2)+"-"+("0" +(d.getDate())).slice(-2);
	if(data=="all"){s="";e="";}
	$("input[name=sdate]").val(s);
	$("input[name=edate]").val(e);
	//var url=getseardata();
	//console.log("기간선택 클릭시   ======>>>>   url : " + url);
	gopage(1);
	//searchhash(url);
}
