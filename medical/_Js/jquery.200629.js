	//------------------------------------------------------------------------------------
	// urlData : url data
	//------------------------------------------------------------------------------------
	function getUrlData(name)
	{
		var ugly = document.getElementById('urldata').value;
		var txtdt = JSON.parse(ugly);
		return txtdt[name];
	}

	function callapi(type,url,data)
	{
		var authkey=$("input[name=ssAuthkey]").val();

		var furl=getUrlData("API")+url;
		console.log("callapi url = " + furl+data);
		$.ajax({
			"url" : furl,
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
					//console.log("result   >>> "+result);
					if(json["apiCode"]=="login"){
						makepage_login(result);
					}else{
						makepage(result);
					}
				}
			},
			"error" : function(request,error)
			{
				alert("Request: "+JSON.stringify(request));
			}
		});
	}

	function paynow(seq)
	{
		if(confirm("장바구니에 담았습니다.\n장바구니로 이동하시겠습니까?"))
		{
			location.href="/Cart/index.php?seq="+seq;  //결제하기를 누르면 페이지 이동(상세보여주는거?)
		}
		var ck_cart=getCookie("ck_cart");
		ck_cart+=","+seq+",";
		ck_cart=ck_cart.replace(",,",",");
		setCookie("ck_cart", ck_cart, 365);
		viewpage();
	}


	function goorder(seq)
	{
		location.href="/Order/Potion.php#||"+seq; ///?seq="+seq;  //장바구니로 가기
	}

	function makelist(result, marr)
	{
		var json = JSON.parse(result);
		//console.log("json >>> "+json);

	//console.log("여기서 검색어를 넣으면 ...search>>> "+json["search"]);
	//$("input[name=searchTxt]").val(decodeURI(searchTxt));
	$("input[name=search]").val(json["search"]);

		if(json["resultCode"]=="200")
		{
			var data="";
			
			$.each(json["list"] ,function(index, val){
				
				if(json["apiCode"]=="orderlist")
				{
					data+="<tr  id='DescDiv"+val["seq"]+"'>";				
				}
				else
				{
				
					data+="<tr  id='DescDiv"+val["seq"]+"' onclick='viewdesc("+val["seq"]+")'>";
				}
				
				for(i=0;i<marr.length;i++)
				{
					if(marr[i]=="RCDETAIL"){var cls="td-txtLeft";}else{var cls="";}
					if(marr[i]=="mhRedefinition"){
						var txt=val[marr[i]].substring(0,35)+"...";
						cls="td-txtLeft";
					}else if(marr[i]=="mhDtitleKor"){
						var txt=val[marr[i]].substring(0,10)+"...";
						cls="td-txtLeft";
					}else if(marr[i]=="mhOrigin"){
						var txt=val[marr[i]].substring(0,15)+"...";
						cls="td-txtLeft";
					}else if(marr[i]=="rcMedicine"){
						var txt=val[marr[i]].substring(0,50)+"...";
						cls="td-txtLeft";
					}
					else if(marr[i]=="RCEFFICACY"){
						var txt=val[marr[i]].substring(0,15)+"...";
						cls="td-txtLeft";
					}
					else if(marr[i]=="bbAnswer") //답변상태
					{
						var txt="";
						if(isEmpty(val[marr[i]])){txt="답변대기";}else{ txt="답변완료";}						
						cls="";
					}
					else if(marr[i]=="totalmedicine" || marr[i]=="totalmaking" || marr[i]=="totaldelivery" || marr[i]=="ordertype" || marr[i]=="ordercount") 
					{
						var txt=val[marr[i]];
						cls="td-txtcenter";
					}
					//"doctorname","ordercode","orderdate","patientname","ordertitle","orderstatus","amounttotal
					else if(marr[i]=="doctorname" || marr[i]=="ordercode" || marr[i]=="orderdate" || marr[i]=="patientname" || marr[i]=="amounttotal" ) 
					{
						var txt=val[marr[i]];
						cls="td-txtcenter";
					}
					else if(marr[i]=="cartchkbox")
					{
						console.log("aaaa");
						txt="<div class='inp-checkBox'>";
						txt+="	<div class='inp inp-check d-flex'>";
						txt+="		<label for='cartid"+val["seq"]+"' class='d-flex'>";
						txt+="			<input type='checkbox' name='cartcb"+val["seq"]+"' id='cartid"+val["seq"]+"' class='cblind' onclick='resetamount();' data-seq='"+val["seq"]+"'>";
						txt+="			<span></span>";
						txt+="		</label>";
						txt+="	</div>";
						txt+="</div>";
					}
					else if(marr[i]=="orderstatus") 
					{
						var txt="";
						
						var ck_cart=getCookie("ck_cart");
						console.log("ck_cart = " + ck_cart);

						if(val[marr[i]]=="주문완료")
						{
							txt+="<a href='javascript:;' class='d-flex btn color-white radius' style='background:#8FCFBD;width:70px;height:20px;'>"+val[marr[i]]+"</a>";
						}
						else
						{
							if(val[marr[i]]=="장바구니")
							{
								if(ck_cart.indexOf(","+val["seq"]+",")!=-1)
								{
									txt+="<div class='btnBox'><a href='javascript:;' class='d-flex btn bg-blue color-white radius' style='width:70px;height:20px;'>결제대기</a></div>";
								}
								else
								{
									txt+="<div class='btnBox'><a href='javascript:;' onclick='paynow("+val["seq"]+");' class='d-flex btn bg-blue color-white radius' style='width:70px;height:20px;'>"+val[marr[i]]+"</a></div>";
								}
							
							}
							else
							{
								txt+="<div class='btnBox'><a href='javascript:;' onclick='goorder("+val["seq"]+");' class='d-flex btn bg-blue color-white radius' style='width:70px;height:20px;'>"+val[marr[i]]+"</a></div>";
							}
						}
					

						
						cls="td-txtcenter";
					}
					else	
					{
						var txt=val[marr[i]];						
					}
				 					
						data+="<td class='td-txtLeft "+cls+"'>"+txt+"</td>";
								
				}
				data+="</tr>";

				if(json["apiCode"]=="noticelist" || json["apiCode"]=="faqlist" || json["apiCode"]=="qnalist")//고객센터 > 공지사항
				{
					if(json["apiCode"]=="noticelist" || json["apiCode"]=="faqlist" )
					{
						var colspantext="2";
					}
					else
					{
						var colspantext="4";
					}

					//data+="<tr class='noticeDIV' style='border:2px solid red;display:none;'>";
					data+="<tr>";
					//data+="<td colspan='3 td-txtLeft'>"+val["bbDesc"]+" ";
					data+="<td colspan="+colspantext+">";
					data+="<div class='board-cont'>";
					data+="<p>"+val["bbDesc"]+"";

					if(json["apiCode"]=="qnalist" && val["bbAnswer"])
					{
						data+="<div class='board-cont'>";
						data+="<p><답변><br> "+val["bbAnswer"]+"";
						data+="</p>";
						data+="</div>";
					}

					if(json["apiCode"]=="qnalist")  //삭제버튼 추가
					{                                                       
						data+="<div class='btnBox d-flex topBtn' >";						
						data+=" <a href='javascript:;' class='d-flex btn btn--small border-rightGray color-gray' onclick=qnadelete('"+val["seq"]+"'); return false;'>삭제하기</a>";
						data+="</div>";
					}
					data+="</p>";
					data+="</div>";
					data+="</td>";
					data+="</tr>";
				}
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

	//1대1문의 삭제버튼
	function qnadelete(seq)
	{

		alert(seq);
		callapi("GET","/medical/cs/",getdata("inquirydelete")+"&seq="+seq);  
		location.reload();

	}

	//검색어도 함께 묶어서 api
	function getdata(apiCode)
	{
		var data = "apiCode="+apiCode+"&language=kor";
		$(".ajaxdata").each(function(){
			var name=$(this).attr("name");
			data+="&"+name+"="+encodeURI($(this).val());
			//console.log("getdata    데이터 묶기 >>>"+data);
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
					txt+="<a href='javascript:gopage("+i+");'  class='paging__num "+cls+"'>"+i+"</a>";
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

	function moremove(id){
		$("#"+id).css("display","none").remove();
	}

	function viewmodal(id){
		var h=$(window).scrollTop();
		$("#"+id).css({"margin-top":(h-100)+"px"});
		showModal(id);
	}

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


	//------------------------------------------------------------------------------------
	//우편번호검색
	//------------------------------------------------------------------------------------
	function getzip(zipfld,addrfld){
		console.log("zipfld   >>>   "+zipfld);
		console.log("addrfld   >>>   "+addrfld);
		medicalviewlayer("../_module/postal/index.php?zipfld="+zipfld+"&addrfld="+addrfld,800,600,"우편번호검색","");
	}

	function medicalviewlayer(url,width,height,code)
	{
	console.log("medicalviewlayer url   >>>   "+url);
	console.log("medicalviewlayer width   >>>   "+width);
	console.log("medicalviewlayer height   >>>   "+height);
	console.log("medicalviewlayer code   >>>   "+code);

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

	//화면중앙팝업레이어
	function popupcenter(dw,dh){
		var winwidth = $(window).width();
		var winheight = $(window).height();
	//console.log("winheight"+screen.height);
		//var ie=getagent();
		if(winheight>screen.height){
			winheight=screen.height;
		}
		var left=(parseInt(winwidth)-dw)/2;
		var top=(parseInt(winheight))/2-(dh/2);
		//alert(screen.height+"+"+dw+"|"+dh+"|"+winwidth+"|"+winheight+"|"+top+"|"+left);
		return top+"|"+left;
	}

	function goscreen(type)
	{
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

	function closediv(id)
	{
		goscreen("close");
		$("#"+id).remove();
	}

	//팝업
	function medicallayer(id, seq)
	{	$("#layermedicalbox").remove();
		var txt="<div id='layermedicalbox'></div>";
		$("body").prepend(txt);
		var url="/_LayerPop/"+id+".php?seq="+seq;
		$("#layermedicalbox").load(url,function(){
			//alert();
		});
	}

	function setSession(obj)
	{

		console.log("setSession");
		console.log(JSON.stringify(obj));

		var url="/session.php";
			url+="?seq="+obj["seq"];
			url+="&meGrade="+obj["meGrade"]; //등급 30-원장,22-간호사....
			url+="&meUserId="+encodeURI(obj["meUserId"]);  //한의사id
			url+="&meLoginid="+encodeURI(obj["meLoginid"]); //한의사로그인id
			url+="&meName="+encodeURI(obj["meName"]); //한의사이름 
			url+="&miUserid="+encodeURI(obj["miUserid"]);  //한의사에 소속한 한의원 ID
			url+="&miRegistNo="+encodeURI(obj["miRegistNo"]); //의료기관코드 
			url+="&url="+encodeURI(obj["locationURL"]);  

			$.ajax({
				type : "GET", //method
				url : url,
				data : [],
				success : function (result) {
					window.location.href=result;
				},
				error:function(request,status,error){
					console.log("code:"+request.status+"\n"+"message:"+request.responseText+"\n"+"error:"+error);
				}
			});
	}

	//로그아웃
	function removeSession()
	{
	
		var url="/session.php";
			url+="?type=logout&url=/Member/Login.php";
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

	//------------------------------------------------------------------------------------
	// jquery cookie Set,Get
	//------------------------------------------------------------------------------------
	function setCookie(cname, cvalue, exdays) 
	{
		Cookies.set(cname, cvalue, { expires: exdays, path: '/',  secure: false });
	}

	function getCookie(cname) 
	{
		if(Cookies.get(cname)==undefined){
			var ckname ="";
		}else{
			var ckname =Cookies.get(cname);
		}
		return ckname;
	}

	function deleteAllCookies()
	{
		var cookies = Cookies.get();
		console.log(cookies);
		for(var cookie in cookies) 
		{
			var ckpop=cookie.substring(0,6);
			if(cookie != "ck_language" && cookie != "ck_languageName" && ckpop!="ck_pop")
			{
				deleteCookie(cookie);
			}
		}
	}

	function deleteCookie(name)
	{
		setCookie(name,null,-1);
		Cookies.remove(name);
	}

	//숫자만 적기
	function onlynumber(evt, check=false)
	{
		var _value = event.srcElement.value;
		console.log("changeNumber  evt = " + evt+", _value : " + _value);
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
	//로그인
	function login()
	{
		var userID=$("input[name=userID]").val();
		var userPWD=$("input[name=userPWD]").val();
		if(isEmpty(userID)){alert("아이디를 입력해 주세요.");return false;}
		if(isEmpty(userPWD)){alert("패스워드를 입력해 주세요.");return false;}
	
		if($("input[name=saveid]").prop("checked")==true){
			setCookie("ck_saveid", userID, 365);
		}else{
			deleteCookie("ck_saveid");
		}

		console.log("userID   >>>  "+userID);
		console.log("userPWD   >>>  "+userPWD);
		
		callapi("POST","/medical/member/",getdata("login"));  
	}


	function makepage_login(result)
	{
		var obj = JSON.parse(result);
		console.log(obj);
		console.log("apiCode>>>"+obj["apiCode"]);
		if(obj["resultCode"]=="200")
		{
			setSession(obj);

			//쿠키저장 - 한의사
			setCookie('ck_meSeq', obj["seq"], 365);
			setCookie('ck_meGrade', obj["meGrade"], 365); //등급 30-원장,22-간호사....
			setCookie('ck_meUserId', obj["meUserId"], 365);//한의사id
			setCookie('ck_meLoginid', obj["meLoginid"], 365); //한의사로그인id
			setCookie('ck_meName', obj["meName"], 365); //한의사이름

			//쿠키저장 - 한의원
			setCookie('ck_miUserid', obj["miUserid"], 365); //한의사에 소속한 한의원 ID
			setCookie('ck_miName', obj["miName"], 365); //한의원이름 
			setCookie('ck_miGrade', obj["miGrade"], 365); //한의원등급 
			setCookie('ck_miRegistNo', obj["miRegistNo"], 365); //의료기관코드	

			location.href=obj["locationURL"];
		}
		else if(obj["resultCode"]=="900")
		{
			alert("이메일 인증전입니다. 인증후 사용하실수 있습니다");
			hiddenModal('modal-login');
		}
		else if(obj["resultCode"]=="899")
		{
			alert(obj["resultMessage"]);
		}
	}

	function setCk(id){
		var chk=$("input[name="+id+"]").is(":checked");
		if(chk==true){
			setCookie('ck_saveid', "Y", 365);
		}else{
			setCookie('ck_saveid');
		}
	}

	function chkkeylen(name, to)
	{
		var input=$("input[name="+name+"]");
		var len=input.attr("maxlength");
		var vlen=input.val().length;
		if(len==vlen){
			$("input[name="+to+"]").focus();
		}
	}

	//필수데이터 처리
	function ajaxnec(){
		var nec="Y";
		$(".ajaxnec").each(function(){
			var dt=$(this).val();
			if(dt==""){
				var title=$(this).attr("placeholder");
				alert("("+title+") 입력 해주세요.");
				nec="N";
				return false;
			}
		});
		return nec;
	}

	//이메일 직접입력
	function selemail(name){
		var email=$("select[name="+name+"]").val();
		$("#stEmail1").val(email); //선택값 입력
		if(email== "")
		{ //직접입력일 경우 
			$("#stEmail1").attr("disabled",false); //활성화
		}
		else //직접입력이 아닐경우 
		{ 
			$("#stEmail1").attr("disabled",true); //비활성화 
		} 
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

	function commasFixed(n)
	{
		n=parseFloat(n);
		n=n.toFixed(1);
			var parts=n.toString().split(".");
		return parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ",") + ((parseInt(parts[1]) > 0) ? "." + parts[1] : "");
	}

	function chkGrade(grade)
	{
		grade=!isEmpty(grade) ? grade : "E";

		if(grade=="A" || grade=="B" || grade=="C" || grade=="D" || grade=="E")
		{
			return grade.toUpperCase();
		}
		else
		{
			return "E";
		}
	}