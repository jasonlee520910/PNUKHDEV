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

		//console.log("callapi type = "+type+", url = " + url+", data="+data);

		var furl=getUrlData("API")+url;
		if(type=="GET")furl+="?";
		console.log("callapi url = " + furl+data);
		$.ajax({
			"url" : furl,
			"type" : type,
			"data" : data,
			//"headers" : {"authkey":authkey},
			"success" : function(result) {
				//console.log(result);
				if(!isEmpty(result))
				{
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
				}
			},
			"error" : function(request,error)
			{
				alert("Request: "+JSON.stringify(request));
			}
		});
	}

	/*
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
	*/

	function chkPhone(phoneno, phonetitle)
	{
		var regExpPhone = /^\d{2,3}-\d{3,4}-\d{4}$/;
		var bak_phoneno=phoneno;

		bak_phoneno=bak_phoneno.replace(/\-/g,"");
		bak_phoneno=bak_phoneno.replace(" ","");

		console.log("chkPhone = "+phoneno);

		if(isEmpty(bak_phoneno))
		{
			alert(phonetitle + " 전화번호를 입력해 주세요.");
			return false;
		}

		if (!regExpPhone.test(phoneno)) 
		{
			alert(phonetitle + " 전화번호를 바르게 입력해 주세요.");
			return false;
		}

		return true;
	}
	function chkMobile(mobileno, mobiletitle)
	{
		var regExpMobile = /^\d{3}-\d{3,4}-\d{4}$/;
		var bak_mobileno=mobileno;

		bak_mobileno=bak_mobileno.replace(/\-/g,"");
		bak_mobileno=bak_mobileno.replace(" ","");

		console.log("chkMobile = "+mobileno);

		if(isEmpty(bak_mobileno))
		{
			alert(mobiletitle+" 휴대전화를 입력해 주세요.");
			return false;
		}

		if (!regExpMobile.test(mobileno)) 
		{
			alert(mobiletitle+" 휴대전화번호를 바르게 입력해 주세요.");
			return false;
		}
		return true;
	}


	function goorder(seq)
	{
		location.href="/Order/Potion.php#||"+seq; ///?seq="+seq;  //장바구니로 가기
	}
	function makelist(result, marr)
	{
		var mdiv="";
		var json = JSON.parse(result);
		//console.log(JSON.stringify(json));

		console.log("json >>> "+json["apiCode"]);

		//console.log("여기서 검색어를 넣으면 ...search>>> "+json["search"]);
		//$("input[name=searchTxt]").val(decodeURI(searchTxt));
		$("input[name=search]").val(json["search"]);

		if(json["resultCode"]=="200")
		{
			var data="";
			var page=1;

			if(json["apiCode"]=="noticelist" || json["apiCode"]=="faqlist" || json["apiCode"]=="qnalist")//고객센터 > 공지사항
			{
				page=json["list"].length;
			}
			
			if(!isEmpty(json["list"]))
			{
				$.each(json["list"] ,function(index, val){			
					if(json["apiCode"]=="orderlist" || json["apiCode"]=="myrecipelist" || json["apiCode"]=="recommendlist")
					{
						data+="<tr  id='DescDiv"+val["seq"]+"'>";				
					}
					else if(json["apiCode"]=="patientlist" || json["apiCode"]=="medicalrecordlist" || json["apiCode"]=="mydoctorlist")
					{
						data+="<tr>";				
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
							var txt=val[marr[i]].substring(0,28)+"...";
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
						else if(marr[i]=="ordertype" || marr[i]=="rcType" ||  marr[i]=="rcMedicineCnt" ||  marr[i]=="rcChub" ||  marr[i]=="rcPackcnt" ||  marr[i]=="rcPackcapa" ||  marr[i]=="meDate" || marr[i]=="meRegistno"  || marr[i]=="meName" || marr[i]=="meMobile" || marr[i]=="meEmail" || marr[i]=="meStatus")
						{
							var txt=val[marr[i]];
							cls="td-txtcenter";
						}
						else if(marr[i]=="totalmedicine" || marr[i]=="totalmaking" || marr[i]=="totaldelivery" ||  marr[i]=="ordercount" || marr[i]=="amounttotal") 
						{
							var txt=commasFixed(val[marr[i]]);
							if(marr[i]=="ordercount")
							{
								cls="td-txtcenter";
							}
							else
							{
								cls="td-txtRight";
							}
							
						}
						else if(marr[i]=="ordertitle")
						{
							var uri = location.pathname;
							console.log("uri = " + uri);
							//if (uri.indexOf("/Member/Record.php") != -1 || uri.indexOf("/Cart/") != -1)//처방기록이거나 장바구니 일경우 약재목록 보여주자 
							//{
								var txt="<div class='mediinfo' data-value='"+val["totmediname"]+"'>"+val[marr[i]];
								if(uri.indexOf("/Cart/") != -1)
								{
									txt+="<span style='padding-top:3px;display:block;text-decoration:normal;font-size:12px;color:gray;width:260px;overflow:hidden; text-overflow:ellipsis; white-space:nowrap;'>"+val["totmediname"]+"</span>";
								}
								else
								{
									txt+="<span style='padding-top:3px;display:block;text-decoration:normal;font-size:12px;color:gray;width:320px;overflow:hidden; text-overflow:ellipsis; white-space:nowrap;'>"+val["totmediname"]+"</span>";
								}
								txt+="</div>";

							//}
							//else
							//{
							//	var txt=val[marr[i]];
								//txt+="<br><div style='font-size:12px;color:gray;width:420px; overflow:hidden; text-overflow:ellipsis; white-space:nowrap;'>"+val["totmediname"]+"</div>";
							//}
							cls="td-txtLeft";
							mdiv=".mediinfo";

						}
						//"doctorname","ordercode","orderdate","patientname","ordertitle","orderstatus","amounttotal
						else if(marr[i]=="doctorname" || marr[i]=="ordercode" || marr[i]=="orderdate" || marr[i]=="patientname") 
						{
							var txt=val[marr[i]];
							cls="td-txtcenter";
						}
						else if(marr[i]=="cartchkbox")
						{
							txt="<div class='inp-checkBox'>";
							txt+="	<div class='inp inp-check d-flex'>";
							txt+="		<label for='cartid"+val["seq"]+"' class='d-flex'>";
							txt+="			<input type='checkbox' name='cartcb"+val["seq"]+"' id='cartid"+val["seq"]+"' class='cblind' onclick='resetamount();' data-seq='"+val["seq"]+"'>";
							txt+="			<span></span>";
							txt+="		</label>";
							txt+="	</div>";
							txt+="</div>";
							cls="td-txtcenter";
						}
						else if(marr[i]=="mychkbox" || marr[i]=="mychkboxdel")
						{
							txt="<div class='inp-checkBox'>";
							txt+="	<div class='inp inp-check d-flex'>";
							txt+="		<label for='myid"+val["seq"]+"' class='d-flex'>";
							if(marr[i]=="mychkboxdel")
							{
								txt+="			<input type='checkbox' name='mycb"+val["seq"]+"' id='myid"+val["seq"]+"' class='' data-seq='"+val["seq"]+"'>";
							}
							else
							{
								txt+="			<input type='checkbox' name='mycb"+val["seq"]+"' id='myid"+val["seq"]+"' class='' data-rcseq='"+val["rc_seq"]+"'>";
							}
							txt+="			<span></span>";
							txt+="		</label>";
							txt+="	</div>";
							txt+="</div>";
							cls="td-txtcenter";
						}				
						else if(marr[i]=="orderstatus") 
						{
							var txt="";
							
							if(val[marr[i]]=="주문완료")
							{
								txt+="<a href='javascript:;' class='btn color-white radius' style='font-size:12px;padding:3px 5px;background:#8FCFBD;' onclick='paycancel(\""+val["keycode"]+"\");'>"+val[marr[i]]+"</a>";
							}
							else
							{
								txt+="<div class='btnBox'><a href='javascript:;' onclick='goorder("+val["seq"]+");' class='btn bg-blue color-white radius' style='font-size:12px;padding:3px 5px;'>"+val[marr[i]]+"</a></div>";
							}
							
							cls="td-txtcenter";
						}
						else if(marr[i]=="keycode" ||marr[i]=="ordertypecode" )   //keycode ordertypecode
						{
							var txt=val[marr[i]];					

							cls="none";  //안보이게 처리																		
						}
						/*
						else if(json["apiCode"]=="patientlist")  //환자 관리 가운데 정렬
						{
							console.log("patientlist>>>>>>>>>>>>>>>"+val["seq"]);
							cls="td-txtcenter";
							var txt=val[marr[i]];
							
							// id='DescDiv"++"'
						}


							data+="<tr  id='DescDiv"+val["seq"]+"' onclick='viewdesc("+val["seq"]+")'>";
						
						else if(marr[i]=="meName")   
						{
							console.log("777777777777777777"+val[marr[i]]);
							var txt=val[marr[i]];					

							cls="td-txtcenter";  //안보이게 처리																		
						}
						*/
						else if(json["apiCode"]=="uniquesclist"  || json["apiCode"]=="hublist" )  //방제사전  본초사전
						{

							if(marr[i]=="no" || marr[i]=="no" )  //순서
							{
								cls="td-txtcenter";	 					
							}	
							else if(marr[i]=="rcTitle")  //처방명
							{						
								cls="td-txtLeft";							
							}
							var txt=val[marr[i]];
						}					
						else	
						{
							if(json["apiCode"]=="noticelist" || json["apiCode"]=="faqlist" || json["apiCode"]=="qnalist")//고객센터 > 공지사항
							{
								if(marr[i]=="seq")
								{
									page=parseInt(json["page"])*page;
									var txt=page;
									page--;
								}
								else
								{
									var txt=val[marr[i]];
								}
							}
							else
							{
								var txt=val[marr[i]];
							}
						}
						
						if(marr[i]=="ordertitle")
						{
							data+="<td class='td-txtLeft "+cls+"' style='padding:0;'>"+txt+"</td>";
						}
						else if(json["apiCode"]=="patientlist")  //환자 관리 가운데 정렬
						{
							if(marr[i]=="meName")  //환자명 클릭하면 상세 
							{
								data+="<td class='td-txtcenter"+cls+"' onclick='viewdesc("+val['seq']+")'>"+txt+"</td>";					
							}
							else
							{					
								data+="<td class='td-txtcenter"+cls+"'>"+txt+"</td>";
							}
							
						}
						else
						{
					
							data+="<td class='td-txtLeft "+cls+"'>"+txt+"</td>";
						}
									
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
			}
			else
			{
				data+="<tr><td colspan='"+marr.length+"'>데이터가 없습니다.</td></tr>";
			}



			$("#tbl tbody").html(data);
			//$("#totcnt").text(json["tcnt"]);
			paging("paging", json["tpage"],  json["page"]);
		}
		else if(json["recode"]=="204")
		{
			alert(json["remsg"]);
			return false;
		}

		//console.log("mdiv = " + mdiv);
		if(!isEmpty(mdiv))
		{
			$(mdiv).on({
				mouseover: function(){
					var mediname=$(this).data("value");
					//console.log("over : " + mediname);
					var html="<div id='tooltip' style='background:white;border:1px solid gray;position:absolute;font-size:14px;padding:5px;vertical-align:middle;'>"+mediname+"</div>";
					$(this).prepend(html);
				},
				 mouseout: function(){
					//console.log("out");
					$("#tooltip").remove();
				}
			});
		}

	}



	//진료기록
	function reorder(userid,name,no)
	{		
		//팝업띄우기modal_medicalrecord
		$("#layermedicalbox").remove();
		var txt="<div id='layermedicalbox'></div>";

			txt+="<input type='hidden' class='' name='userid' value='"+userid+"'>";
			txt+="<input type='hidden' class='' name='patientname' value='"+name+"'>";

		$("body").prepend(txt);
		var url="/_LayerPop/modal_medicalrecord.php?userid="+userid+"&name="+name

		$("#layermedicalbox").load(url,function(){callapi("GET","/medical/patient/",getdata("medicalrecordlist")+"&userid="+userid+"&name="+name+"&page="+no);  });
	}

	//재처방 버튼
	function againorder(seq)
	{
		console.log("againorder*********************************");
		//alert(seq);


		callapi("GET","/medical/patient/",getdata("againorder")+"&seq="+seq);  //재처방 (han_order_medical 에서 select)



	}

	function paycancel(keycode)
	{
		callapi("GET","/medical/order/",getdata("orderpaychk")+"&keycode="+keycode);  //카드결제인지 무통장결제인지 확인
	}


	//1대1문의 삭제버튼
	function qnadelete(seq)
	{

		//alert(seq);
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
			console.log("getdata    데이터 묶기 >>>"+data);
		});
		//alert(data);
console.log(data);
		var hdata=location.hash.replace("#","").split("|");
		var page=hdata[0];
		if(page){data+="&page="+page;}
/*
		var searchTxt=hdata[2];
		if(searchTxt){data+="&searchTxt="+encodeURI(searchTxt);}

*/

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
		if(next>tpage){next=tpage;}	link = "gopage("+next+")";
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
		//임시처방예외처리
		var hdata=location.hash;
		var arr=hdata.split("|");
		if(arr[1]=="temp"){
			seq="temp";
		}

		location.hash=page+"|"+seq+"|"+encodeURI(search)+"|"+encodeURI(searchsel);
	}

	function gethash(){
		var hdata=location.hash;
			console.log("gethashgethashgethashgethash  >>>>>>>>>>>>>>>>>>>>>>>>>>>>  "+hdata);
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
		console.log("gopagegopagegopagegopagegopage ##################  no = "+no + ", chkpop = " + chkpop);
		if(chkpop==true)
		{
			var txt="<input type='hidden' class='ajaxdata' name='poppage' value='"+no+"'>";
			$("#poppaging").prepend(txt);
			sethash();
			poplist();
		}
		else
		{
			//var txt="<input type='text' class='ajaxdata' name='page' value='"+no+"'>";
			//$("#paging").prepend(txt);
			//sethash();
			//getlist();
			var hdata=location.hash.replace("#","").split("|");
			var hdata2="";
			for(var i=1;i<hdata.length;i++){
				hdata2+="|"+hdata[i];
			}
			location.hash=no+hdata2;


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
	//검색을 하면 1페이지로 간다
	function searchhash(search){
		console.log("검색을 하면 1페이지로 간다 "+search);
		var hdata=location.hash.replace("#","").split("|");
		var type=!isEmpty(hdata[1])?hdata[1]:"";
		var seq=!isEmpty(hdata[2])?hdata[2]:"";
		//alert(1+"_"+type+"_"+seq+"_"+search);
		makehash(1,type,seq,search);
	}
	function makehash(page,type,seq,search){
		console.log("makehash  "+search);
		location.hash=page+"|"+type+"|"+seq+"|"+search;
	}
	function searcls()
	{
		var url=getseardata();
		console.log("텍스트 입력시  ======>>>>   url : " + url);
		searchhash(url);
	}
	//기간선택 클릭시
	function setperiod(data)
	{
		console.log("-----------------------------> setperiod data : " + data);
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
		var url=getseardata();
		console.log("기간선택 클릭시   ======>>>>   url : " + url);
		searchhash(url);
	}
	//기간선택,주문상태별,검색에 따른 데이터 정리하여 gopage로 넘기기 위한 url 만들기
	function getseardata()
	{
		var hashtext=url=status=period=progress=matype=delitype=delibk="";
		//기간선택
		$(".ajaxdata").each(function()
		{
			if($(this).attr("name") == 'searchTxt')
			{
				url+="&"+$(this).attr("name")+"="+encodeURI($(this).val());
			}
			if($(this).attr("name") == 'sdate' || $(this).attr("name") == 'edate')
			{
				url+="&"+$(this).attr("name")+"="+$(this).val();
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
		if(period.length>2){
			url+="&searchPeriodEtc="+period;
		}
		
		console.log("모든데이터 말기 getseardata ========::>>>> url = " + url);
		
		return url;
	}
	function searchdata(search)
	{
		//주문리스트 API 호출
		var apiOrderData=sdate=edate=searchTxt=searchPeriodEtc="";
		console.log("#################### 검색 searchdata  search="+search);
		if(!isEmpty(search))
		{
			var sarr=search.split("&");
			$(search.split("&")).each(function(){
				if(this.length>1){
					var sarr2=this.split("=");
					apiOrderData+="&"+sarr2[0]+"="+sarr2[1];
					$("input[name="+sarr2[0]+"]").val( decodeURI(sarr2[1]));
				}
			});
			//------------------------------------------------------
			//기간선택 라디오박스 
			//------------------------------------------------------
			if(searchPeriodEtc!="" && searchPeriodEtc!=undefined){
				var pearr=searchPeriodEtc.split(",");
				for(var i=0;i<pearr.length;i++){
					if(pearr[i]!=""){
						$(".searPeriodEtc"+pearr[i]).attr("checked",true);
					}
				}
			}
			//------------------------------------------------------
			//apiOrderData="&sdate="+sdate+"&edate="+edate+"&searchTxt="+encodeURI(searchTxt);
		}

		console.log("#################### 검색 searchdata  apiOrderData="+apiOrderData);
		return apiOrderData;
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
	{
		console.log("##########################  medicallayer id = " + id + ", seq = " + seq);
		$("#layermedicalbox").remove();
		var txt="<div id='layermedicalbox'></div>";
		$("body").prepend(txt);
		var url="/_LayerPop/"+id+".php?seq="+seq;

		if(!isEmpty(id)&&id=="modal_medicalrecord")
		{
			$("#layermedicalbox").load(url,function(){callapi("GET","/medical/patient/",getdata("medicalrecordlist")+"&userid="+seq);  });
		}
		
		else if(!isEmpty(id)&&id=="modal-option-prepared" || !isEmpty(id)&&id=="modal-option-prepared-modify" || !isEmpty(id)&&id=="modal-option-dose-download" || !isEmpty(id)&&id=="modal-option-dose-modify")//조제지시 & 복용지시 
		{
			$("#layermedicalbox").load(url,function(){$("input[name=mdSeq]").val(seq); callapi("GET","/medical/member/",getdata("memberdocxdesc")+"&mdSeq="+seq); });
		}
		else
		{
			$("#layermedicalbox").load(url);
		}
		
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
					//alert(">>>>>>>>"+result);
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
		var nowdate = new Date();//1시간 
		nowdate.setTime(nowdate.getTime() + 60 * 60  * 1000);
		//console.log("nowdate = "+nowdate);

		Cookies.set(cname, cvalue, { expires: nowdate, path: '/',  secure: false });
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
	function onlynumber(evt, check)
	{
		if(isEmpty(check)){check=false;}

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
			setCookie('ck_meStatus', obj["meStatus"], 365); //한의사이름

			//쿠키저장 - 한의원
			setCookie('ck_miUserid', obj["miUserid"], 365); //한의사에 소속한 한의원 ID
			setCookie('ck_miName', obj["miName"], 365); //한의원이름 
			setCookie('ck_miGrade', obj["miGrade"], 365); //한의원등급 
			setCookie('ck_miRegistNo', obj["miRegistNo"], 365); //의료기관코드	
			setCookie('ck_miStatus', obj["miStatus"], 365); //한의원상태

			//location.href=obj["locationURL"];
		}
		else if(obj["resultCode"]=="900")
		{
			alert("이메일 인증전입니다. 인증후 사용하실수 있습니다");
			hiddenModal('modal-login');
			location.href="/Signup/document.php";

		}
		else if(obj["resultCode"]=="201")//$me_status=='emailauth' || $me_status=='approve'
		{
			//alert(obj["locationURL"]);
			setSession(obj);

			//쿠키저장 - 한의사
			setCookie('ck_meSeq', obj["seq"], 365);
			setCookie('ck_meGrade', obj["meGrade"], 365); //등급 30-원장,22-간호사....
			setCookie('ck_meUserId', obj["meUserId"], 365);//한의사id
			setCookie('ck_meLoginid', obj["meLoginid"], 365); //한의사로그인id
			setCookie('ck_meName', obj["meName"], 365); //한의사이름
			setCookie('ck_meStatus', obj["meStatus"], 365); //한의사이름

			//쿠키저장 - 한의원
			setCookie('ck_miUserid', obj["miUserid"], 365); //한의사에 소속한 한의원 ID
			setCookie('ck_miName', obj["miName"], 365); //한의원이름 
			setCookie('ck_miGrade', obj["miGrade"], 365); //한의원등급 
			setCookie('ck_miRegistNo', obj["miRegistNo"], 365); //의료기관코드	
			setCookie('ck_miStatus', obj["miStatus"], 365); //한의원상태

			
			location.href=obj["locationURL"];
			//location.href="/Signup/document.php";
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
	function getorderregist(json)
	{
		var seq=json["seq"];
		var keycode=json["keyCode"];
		var type=json["type"];
		var jsonData=json["jsonData"];
		console.log("seq    >>>  "+seq+", keycode = "+keycode);
		console.log("jsonData = " + jsonData);
		
		$("input[name=medicalseq]").val(seq);
		$("input[name=medicalkeycode]").val(keycode);

		var obj=JSON.parse(jsonData);
		obj["orderInfo"][0]["keycode"]=keycode;

		$("textarea[name=join_jsondata]").val(JSON.stringify(obj));

		console.log("jsonData after =  " + $("textarea[name=join_jsondata]").val());

		var keycode2=$("input[name=medicalkeycode]").val();
		console.log("######################## type = " + type + ", keycode2 = " + keycode2);

		if(type=="cart")
		{
			alert("접수되었습니다.");
			location.href="/Cart/";
		}
		else if(type=="reorder") //재처방
		{
			alert("재처방되었습니다.");
			goorder(seq);
		}
		else
		{
			if(isEmpty(type))
			{
				alert("임시저장되었습니다.");
			}
			makeorderhash("",type,seq);
		}
	}