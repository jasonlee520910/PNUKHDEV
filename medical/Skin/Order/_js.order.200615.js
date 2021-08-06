	function searchkeyup(id, evt){
		var len=$("input[name="+id+"]").val();
		console.log(len);
		if(evt.keyCode==38 || evt.keyCode==40 || evt.keyCode==13){//위아래
			if(evt.keyCode==38){
				movesearfocus(id,"prev");
			}
			if(evt.keyCode==40){
				movesearfocus(id,"next");
			}
			if(evt.keyCode==13){
				var seq=$(".inp-search__list ul li.on").attr("value");
				if(seq!="" && seq!=undefined){
					$("input[name="+id+"]").val("");
					switch(id){
						case "searchpatient":setPatient(seq);break;
						case "searchmedi":setMedicine(seq);break;
						case "searchrecipe":setRecipe(seq);break;
					}
				}
			}
		}else{
			switch(id){
				case "searchpatient":
					var medicalId=$("input[name=medicalId]").val();
					var search=$("input[name=searchpatient]").val();
					var data="apiCode=patientlist&language=kor&medicalid="+medicalId+"&searchTxt="+search;
					callapi("GET","/medical/patient/",data);
					break;
				case "searchmedi":
					var medicalId=$("input[name=medicalId]").val();
					var search=$("input[name=searchmedi]").val();
					var data="apiCode=medicinelist&language=kor&searchTxt="+search;
					callapi("GET","/medical/medicine/",data);
					break;
				case "searchrecipe":
					var medicalId=$("input[name=medicalId]").val();
					var search=$("input[name=searchrecipe]").val();
					var data="apiCode=medicalsclist&language=kor&medicalId="+medicalId+"&searchTxt="+search;
					callapi("GET","/medical/recipe/",data);
					break;
			}
		}
	}

	function searchlist(id, list){
		var txt="<ul>";
		console.log(list);
		switch(id){
			case "searchpatient":
				$.each(list ,function(idx, val){
						txt+="<li value='"+val["seq"]+"'>";
						txt+="<a href='javascript:setPatient("+val["seq"]+");' class='d-flex'>";
						txt+="<span class='name'>"+val["meName"]+"</span>";
						txt+="<span class='date'>"+val["meBirth"]+"</span>";
						txt+="<span class='number'>"+val["meMobile"]+"</span>";
						txt+="<span class='number'>"+val["meSex"]+"</span>";
						txt+="</a>";
						txt+="</li>";
				});
				break;
			case "searchmedi":
				$.each(list ,function(idx, val){
						txt+="<li value='"+val["seq"]+"'>";
						txt+="<a href='javascript:setMedicine("+val["seq"]+");' class='d-flex'>";
						txt+="<span class='tit'>"+val["mediname"]+"("+val["hubname"]+")</span>";
						txt+="<span class='origin'>"+val["origin"]+"</span>";
						txt+="</a>";
						txt+="</li>";
				});
				break;
			case "searchrecipe":
				$.each(list ,function(idx, val){
						txt+="<li value='"+val["seq"]+"'>";
						txt+="<a href='javascript:setRecipe("+val["seq"]+");' class='d-flex'>";
						txt+="<span class='tit'>"+val["rcTitle"]+")</span>";
						txt+="<span class='origin'>약미:"+val["odMedicineCnt"]+"</span>";
						txt+="</a>";
						txt+="</li>";
				});
				break;
		}
		txt+="</ul>";
		$("input[name="+id+"]").parent().next().html(txt);
	}

	function movesearfocus(id,dir){
		var idx=$("input[name="+id+"]").parent().next().children().children("li.on").index();
		$("input[name="+id+"]").parent().next().children().children("li.on").removeClass("on");
		if(dir=="prev"){
			idx--;
		}
		if(dir=="next"){
			idx++;
		}
		$("input[name="+id+"]").parent().next().children().children("li").eq(idx).addClass("on");
	}


	function viewscription(orderid){
		var medicalId=$("input[name=medicalId]").val();
		var seq=$("input[name=medicalseq]").val();
		
		var parr=["patient","info","medicine","decoc","advice","comment","payment"]
		$.each(parr, function(idx, val){
			$("#order"+val).load("/Skin/Order/order."+val+".php?="+orderid);
		});
		var keycode=$("input[name=keycode]").val();
		if(keycode!="")
		{
		}
		else
		{
		}
		setTimeout("callapi('GET','/medical/config/','apiCode=getconfig&language=kor')",500);
		setTimeout("callapi('GET','/medical/config/','apiCode=getpacking&language=kor&medicalId="+medicalId+"')",500);
		setTimeout("callapi('GET','/medical/order/','apiCode=orderdesc&language=kor&seq="+seq+"')",500);  //주문내역 > 임시처방하기에서 왔을때 상세 뿌리는거.

		gotop();
	}
	function viewadviceview()
	{
		var json=JSON.parse($("textarea[name=join_jsondata]").val());
		var orderAdvice=json["orderInfo"][0]["orderAdvice"];//복약지도서
		console.log("viewadviceviewviewadviceviewviewadviceview : " + orderAdvice);
		$("#adviceDiv").text(orderAdvice);
	}
	function viewcommentview()
	{
		var json=JSON.parse($("textarea[name=join_jsondata]").val());
		var orderComment=json["orderInfo"][0]["orderComment"];//조제지시
		console.log("viewcommentviewviewcommentviewviewcommentview : " + orderComment);
		$("#commentDiv").text(orderComment);
	}
	function viewdecocview()
	{
		var json=JSON.parse($("textarea[name=join_jsondata]").val());

		var pinfo=json["packageInfo"];

		for(i=0;i<pinfo.length;i++)
		{
			console.log("type="+pinfo[i]["packType"]+" ===>"+pinfo[i]["packImage"]);
			if(pinfo[i]["packType"]=="pouch")
			{	
				$("#packtypeimgdiv").html("<img src='"+pinfo[i]["packImage"]+"' >");//파우치이미지
			}
			else if(pinfo[i]["packType"]=="medibox")
			{
				$("#mediboximgdiv").html("<img src='"+pinfo[i]["packImage"]+"' >");//박스이미지
			}
		}

		$("#packcntdiv").text(json["recipeInfo"][0]["packCnt"]);//팩수
		$("#packcapadiv").text(json["recipeInfo"][0]["packCapa"]);//팩용량
		$("#specialDecoc").text(json["decoctionInfo"][0]["specialDecoctxt"]);//특수탕전
		//$("#mediboximgdiv").text("감미제없음");//감미제

	}
	function getmeditype(type)
	{
		if(type=="inmain")
		{
			return "일반";
		}
		else if(type=="infirst")
		{
			return "선전";
		}
		else if(type=="inafter")
		{
			return "후하";
		}
		else if(type=="inlast")
		{
			return "별전";
		}
	}
	function viewrecipe()
	{
		var json=JSON.parse($("textarea[name=join_jsondata]").val());
		var chubCnt=json["recipeInfo"][0]["chubCnt"];
		$("#odtitleDiv").text(json["orderInfo"][0]["orderTitle"]);//처방명
		
		$("#odtypediv").text(json["orderInfo"][0]["orderType"]);//제형
		$("#odchutdiv").text(chubCnt);//첩수

		var data="";
		$("#vimeditbl tbody").html("");
		var medicine=json["recipeInfo"][0]["totalMedicine"];
		var medilen=medicine.length;
		var totonemedi=totalmedi=totalprice=0;
		for(i=0;i<medilen;i++)
		{
			
			var medicapa=parseFloat(medicine[i]["mediCapa"])*parseFloat(chubCnt);
			var mediprice=parseFloat(medicine[i]["mediAmount"])*medicapa;
			var meditype=getmeditype(medicine[i]["mediType"]);
			data+="<tr>";
			data+="	<td>"+(i+1)+"</td>";
			data+="	<td class='td-txtLeft'>"+medicine[i]["mediName"]+"</td>";
			data+="	<td>"+meditype+"</td>";
			data+="	<td>"+medicine[i]["mediOriginTxt"]+"</td>";
			data+="	<td>"+medicine[i]["mediCapa"]+"</td>";
			data+="	<td>"+medicapa+"</td>";
			data+="	<td>"+mediprice+"</td>";
			data+="</tr>";

			totonemedi+=parseFloat(medicine[i]["mediCapa"]);
			totalmedi+=medicapa;
			totalprice+=mediprice;
		}

		$("#mdcntdiv").text(medilen);//약재
		$("#vimeditbl tbody").html(data);

		$("#onemedicapa").text(totonemedi);//
		$("#totalmedicapa").text(totalmedi);
		$("#totalmediprice").text(totalprice);

	}
	function viewpayment()
	{
		var json=JSON.parse($("textarea[name=join_jsondata]").val());

		var amountTotal=json["paymentInfo"][0]["amountTotal"];
		var amountMedicine=json["paymentInfo"][0]["amountMedicine"];
		var amountPharmacy=json["paymentInfo"][0]["amountPharmacy"];
		var amountDecoction=json["paymentInfo"][0]["amountDecoction"];
		var amountPackaging=json["paymentInfo"][0]["amountPackaging"];
		var amountDelivery=json["paymentInfo"][0]["amountDelivery"];

		$("#payviewmedicine").text(amountMedicine); //약재비
		$("#payviewmaking").text(amountPharmacy);//조제비
		$("#payviewdecoction").text(amountDecoction);//탕전비
		$("#payviewpacking").text(amountPackaging);//포장비
		$("#payviewdelivery").text(amountDelivery);//배송비
		$("#payviewtotal").text(commasFixed(amountTotal));//합게 
	}
	function viewscription2(orderid){
		var medicalId=$("input[name=medicalId]").val();
		var parr=["sender","receiver","recipe","decocview","adviceview","commentview","paymentview"]

		$.each(parr, function(idx, val){
			if(val=="adviceview")
			{
				$("#order"+val).load("/Skin/Order/order."+val+".php?="+orderid, function(){viewadviceview();});
			}
			else if(val=="commentview")
			{
				$("#order"+val).load("/Skin/Order/order."+val+".php?="+orderid, function(){viewcommentview();});
			}
			else if(val=="decocview")
			{
				$("#order"+val).load("/Skin/Order/order."+val+".php?="+orderid, function(){viewdecocview();});
			}
			else if(val=="recipe")
			{
				$("#order"+val).load("/Skin/Order/order."+val+".php?="+orderid, function(){viewrecipe();});
			}
			else if(val=="paymentview")
			{
				$("#order"+val).load("/Skin/Order/order."+val+".php?="+orderid, function(){viewpayment();});
			}
			else
			{
				$("#order"+val).load("/Skin/Order/order."+val+".php?="+orderid);
			}
		});
		//setTimeout("callapi('GET','/medical/config/','apiCode=getconfig&language=kor')",500);
		//setTimeout("callapi('GET','/medical/config/','apiCode=getpacking&language=kor&medicalId="+medicalId+"')",500);
		gotop();
	}

	function modpatbl(){
		var arr=["patel","pamobile","pamemo"];
		$.each(arr ,function(idx, val){
		//$("#patbl tr td").each(function(idx, val){
			$("#"+val).attr("data-value",$("#"+val).text()).html("<input type='text' class='ajaxdata' name='"+$("#"+val).attr("id")+"' value='"+$("#"+val).text()+"'>");
			$("#pabtn").text("확인").attr("onclick","alert()");
		});
	}

	function updatepatbl(){
		callapi("GET","/medical/",getdata("odpatientupdate"));
	}

	function orderupdate(){
		console.log("orderupdate   >> "+data);
		var data = $("textarea[name=join_jsondata]").val();
		console.log("----------------------");
		console.log(JSON.stringify(data));
		callapi("POST","/medical/order/","data="+data);  //apicode=orderregist

		console.log("callapi하고 페이지는 주문내역으로 이동");
		location.href="/Order/";
	}

	function setPatient(seq){
		var data = "apiCode=patientdesc&language=kor&seq="+seq;
		callapi("GET","/medical/patient/",data);
	}

	function setMedicine(seq){
		var data = "apiCode=medicinedesc&language=kor&seq="+seq;
		callapi("GET","/medical/medicine/",data);
	}

	function setRecipe(seq){
		var data = "apiCode=medicalscdesc&language=kor&seq="+seq;
		callapi("GET","/medical/recipe/",data);
	}


	function makepage(result){
		var json = JSON.parse(result);
		console.log(json);
		if(json["resultCode"]=="200"){
			switch(json["apiCode"]){
				 case "getconfig":
					 var payMaking=parseInt(json["data"]["cfMakingpriceE"]);
					 var payDecoction=parseInt(json["data"]["cfDecocpriceE"]);
					 var payPacking=parseInt(json["data"]["cfPackingpriceE"]);
					 var payRelease=parseInt(json["data"]["cfReleasepriceE"]);
					 $("#payMaking").attr("value",payMaking).text(commasFixed(payMaking));
					 $("#payDecoction").attr("value",payDecoction).text(commasFixed(payDecoction));
					 $("#payPacking").attr("value",payPacking).text(commasFixed(payPacking));
					 $("#payRelease").attr("value",payRelease).text(commasFixed(payRelease));
					 var payTotal=payMaking + payDecoction + payPacking + payRelease;
					 $("#payTotal").text(commasFixed(payTotal));

					 resetCnt();
					break;
				 case "patientlist": 
					 searchlist("searchpatient",json["list"]);
					break;
				 case "patientdesc": 
					var arr=["meChartno","meName","meSexTxt","meBirthDay","mePhone","meMobile","meAddress","lastScript","meMemo"];
					$.each(arr, function(idx, val){
						$("#"+val).text(json[val]);
					});
					$(".inp-search__list").html("");
					//$("#pabtn").attr("href","javascript:addpatient('"+json["seq"]+"');").fadeIn(500);
					//처방초기화
					//옵션초기화
					//비용초기화
					callapi("GET","/medical/config/","apiCode=getconfig&language=kor");
					break;
				 case "medicinelist":
					 searchlist("searchmedi",json["list"]);
					break;
				 case "medicinedesc":
					json["mediType"]="inmain";
				 console.log("json   >>> "+json);
				 console.log(JSON.stringify(json));

					addmeditbl(json);
					$(".inp-search__list").html("");
					$("input[name=searchrecipe]").val("");
					break;
				 case "medicalsclist":
					 searchlist("searchrecipe",json["list"]);
					break;
				 case "medicalscdesc":
					$("input[name=odTitle]").val(json["rcTitle"]);
				 var data=[];
					$.each(json["rcMedicineList"],function(idx, val){
						console.log(val);
						data["mdCode"]=val["code"];
						data["mediType"]=val["type"];
						data["mdTitle"]=val["title"];
						data["mdOrigin"]=val["origin"];
						data["mdPrice"]=val["price"];
						data["mediCapa"]=val["chub"];
						addmeditbl(data);
					});
					$(".inp-search__list").html("");
					$("input[name=searchrecipe]").val("");
					break;
				 case "getpacking":
					var i=0;
					var selectedImg="";
					 var txt="";
					var imgurl="";
						$.each(json["data"]["boxmedi"], function(idx, val){
						
							if(val["afThumbUrl"]!="" && val["afThumbUrl"]!="NoIMG")
							{
								imgurl=fileurl()+"/"+val["afThumbUrl"];
							}
							else
							{
								imgurl="/assets/images/noimg.png";
							}
							txt+="<li class='custom-img-select-item ' onclick='changeboxmedi(\""+val["pbCode"]+"\",\""+val["pbTitle"]+"\",\""+val["pbPriceA"]+"\");'>";
							txt+="<label for='img"+val["pbCode"]+"'>";
							txt+="<input type='radio' name='img' value='"+imgurl+"' id='img"+val["pbCode"]+"'>";
							txt+="<img  src='"+imgurl+"' alt=''  onerror='this.src=\"/assets/images/noimg.png\"'>";
							//txt+=val["pbTitle"];
							txt+="</label>";
							txt+="</li>";
					});
					//console.log(txt);
					$("#medibox").html(txt);
					txt="";
					//selectedImg
					i=0;
					$.each(json["data"]["packtype"], function(idx, val){
						if(val["afThumbUrl"]!="" && val["afThumbUrl"]!="NoIMG")
						{
							imgurl=fileurl()+"/"+val["afThumbUrl"];
						}
						else
						{
							imgurl="/assets/images/noimg.png";
						}
						txt+="<li class='custom-img-select-item' onclick='changepacktype(\""+val["pbCode"]+"\",\""+val["pbTitle"]+"\",\""+val["pbPriceA"]+"\");'>";
						txt+="<label for='img"+val["pbCode"]+"'>";
						txt+="<input type='radio' name='img' value='"+imgurl+"' id='img"+val["pbCode"]+"' data-src='https://via.placeholder.com/100x100?img1'>";
						txt+="<img  src='"+imgurl+"' alt=''  onerror='this.src=\"/assets/images/noimg.png\"'>";
						//txt+=val["pbTitle"];
						txt+="</label>";
						txt+="</li>";
					});
					//console.log(txt);
					$("#packtype").html(txt);

					break;
				 case "myinfodesc":
					 var chk=json["returnData"];
					 if(chk=="sender"){
						 $("input[name=sendName]").val(json["mi_name"]);
						 $("input[name=sendPhone0]").val(json["miPhone0"]);
						 $("input[name=sendPhone1]").val(json["miPhone1"]);
						 $("input[name=sendPhone2]").val(json["miPhone2"]);
						 if(!isEmpty(json["me_mobile"]))
						 {
							var marr=json["me_mobile"].split("-");
							 $("input[name=sendMobile0]").val(marr[0]);
							 $("input[name=sendMobile1]").val(marr[1]);
							 $("input[name=sendMobile2]").val(marr[2]);
						 }
						 else
						 {
							 $("input[name=sendMobile0]").val(json["miPhone0"]);
							 $("input[name=sendMobile1]").val(json["miPhone1"]);
							 $("input[name=sendMobile2]").val(json["miPhone2"]);

						 }


						 $("input[name=sendZipcode]").val(json["mi_zipcode"]);
						 $("input[name=sendAddress]").val(json["miAddress"]);
						 $("input[name=sendAddressDesc]").val(json["miAddress1"]);
					 }
					 if(chk=="receiver"){
						 $("input[name=receiveName]").val(json["mi_name"]);
						 $("input[name=receivePhone0]").val(json["miPhone0"]);
						 $("input[name=receivePhone1]").val(json["miPhone1"]);
						 $("input[name=receivePhone2]").val(json["miPhone2"]);
						 if(!isEmpty(json["me_mobile"]))
						 {
							var marr=json["me_mobile"].split("-");
							$("input[name=receiveMobile0]").val(marr[0]);
							$("input[name=receiveMobile1]").val(marr[1]);
							$("input[name=receiveMobile2]").val(marr[2]);
						 }
						 else
						 {
							$("input[name=receiveMobile0]").val(json["miPhone0"]);
							$("input[name=receiveMobile1]").val(json["miPhone1"]);
							$("input[name=receiveMobile2]").val(json["miPhone2"]);
						 }
						 $("input[name=receiveZipcode]").val(json["mi_zipcode"]);
						 $("input[name=receiveAddress]").val(json["miAddress"]);
						 $("input[name=receiveAddressDesc]").val(json["miAddress1"]);
					 }
					break;
				 case "orderregist":
					 var keycode=json["keyCode"];
console.log("keycode    >>>  "+keycode);
						//setCookie("od_keycode", keycode, 1);
					break;

				 case "orderdesc":  //임시처방에서 상세화면 뿌리기
					var obj = JSON.parse(result);
					console.log(obj);
					console.log("apiCode>>>>> "+obj["apiCode"]);

					

					$("#meChartno").text(obj["ORDERCODE"]); //차트번호
					$("#meSexTxt").text(obj["PATIENTGENDER"]); //성별
					$("#mePhone").text(obj["ORDERCODE"]); //연락처
					$("#meAddress").text(obj["meAddress"]); //주소
					$("#meName").text(obj["PATIENTNAME"]); //환자명
					$("#meBirthDay").text(obj["PATIENTBIRTH"]); //생년월일
					$("#mePhone").text(obj["PATIENTPHONE"]); //휴대전화

								

					$("#lastScript").text(obj[""]); //최근처방정보
					$("#meMemo").text(obj[""]); //기타

					console.log("totalMedicine>>>"+obj["totalMedicine"]);
					console.log(JSON.stringify(obj["totalMedicine"]));

					orderdescaddmeditbl(obj["totalMedicine"][0]);//약재

					//옵션설정
					$("textarea[name=orderAdvice]").text(obj["mediAdvice"]); //복용지시
					$("textarea[name=orderComment]").text(obj["orderComment"]); //복용지시

					$("#payMedicine").text(obj["amountMedicine"]);  //약제비
					$("#payMaking").text(obj["amountPharmacy"]);  //조제비
					$("#payDecoction").text(obj["amountDecoction"]);  //탕전료
					$("#payPacking").text(obj["amountPackaging"]);  //포장비
					$("#payRelease").text(obj["amountDelivery"]);  //배송비
					
					$("#payTotal").text(obj["amountTotal"]);  //합계

					$("input[name=medicalkeycode]").val(obj["keycode"]);

					resetCnt();


					break;
			}
		}else if(json["returnCode"]=="204"){
			return false;
		}
	}

	function orderdescaddmeditbl(json){
		var no=$("#meditbl tbody tr").length + 1;
		console.log("######## orderdescaddmeditbl medicode "+ json["mediCode"]);
		var txt="<tr>";
				txt+="<td>";
				txt+="<div class='inp-checkBox'>";
				txt+="<div class='inp inp-check'>";
				txt+="<label for='d"+no+"' class='d-flex'>";
				txt+="<input type='checkbox' name='chk' id='d"+no+"' class='blind'  onclick='chkall()' value='"+json["mediCode"]+"'>"; //약재코드
				txt+="<span></span>";
				txt+="</label>";
				txt+="</div>";
				txt+="</div>";
				txt+="</td>";
				txt+="<td>"+no+"</td>";
				txt+="<td>";
				txt+="<div class='d-flex product-name'>";
				txt+=json["mediName"];  //약재이름
				//txt+="<span class='impossible'>처방불가</span>";
				txt+="</div>";
				txt+="</td>";
				txt+="<td>"+json["mediOriginTxt"]+"</td>";
				txt+="<td>";
				txt+="<div class='gram d-flex'>";
				txt+="<div class='inp inp-input inp-radius'>";
				if(json["mediCapa"]!=null){var mediCapa=json["mediCapa"];}else{var mediCapa=0;}
				txt+="<input type='text' name='capa' placeholder='' value='"+mediCapa+"' onkeyup='resetCnt()'>";
				txt+="</div>";
				txt+="<span>g</span>";
				txt+="</div>";
				txt+="</td>";
				txt+="<td>";
				txt+="<div class='gram d-flex'>";
				txt+="<div class='inp inp-input inp-radius'>";
				txt+="<input type='text' name='tcapa' placeholder='' value='0' readonly>";
				txt+="</div>";
				txt+="<span>g</span>";
				txt+="</div>";
				txt+="</td>";
				txt+="<td>";
				txt+="<span class='amount' value='"+json["mediAmount"]+"'>"+json["mediAmount"]+"</span>";  //가격
				txt+="<span class='won'>원</span>";
				txt+="</td>";
				txt+="<td>";
				txt+="<div class='inp inp-select inp-radius'>";
				txt+="<select name='mediType' id=''>";
				var carr=["infirst","inmain","inafter","inlast"]
				var tarr=["선전","일반","후하","별전"]
				for(var m=0;m<carr.length;m++){
					if(json["mediType"]==carr[m]){var cls=" selected";}else{var cls=" ";}
					txt+="<option value='"+carr[m]+"' "+cls+">"+tarr[m]+"</option>";
				}
				txt+="</select>";
				txt+="</div>";
				txt+="</td>";
				txt+="</tr>";
				//console.log("txt   >>>> "+txt);
			$("#meditbl tbody").append(txt);
			setTimeout("orderresetCnt()",300);
	}

	function orderresetCnt(){
		var chubcnt=parseInt($("select[name=chubCnt]").val());
		var packCnt=parseInt($("select[name=packCnt]").val());
		var totchubcapa=totcapa=totmedicine=0
		$("#meditbl tbody tr").each(function(idx, val){
			$(this).children("td").eq(1).text(idx+1);
			var chubcapa=parseInt($(this).children("td").eq(4).children(".gram").children(".inp").children("input").val());
			var tcapa=chubcnt * chubcapa;
			console.log("chubcapa   >>>  "+chubcapa);
			console.log("tcapa   >>>  "+tcapa);
			$(this).children("td").eq(5).children(".gram").children(".inp").children("input").val(tcapa);
			var unit=parseInt($(this).children("td").eq(6).children(".amount").attr("value"));
			if(unit==undefined)unit=0;
			var amount = tcapa * unit;
			$(this).children("td").eq(6).html("<span class='amount' value='"+unit+"'>"+amount+"</span><span class='won'>원</span>");
			console.log("약재추가 >>> "+chubcapa+"_"+tcapa+"_"+unit+"_"+amount);
			totchubcapa+=chubcapa;
			totcapa+=tcapa;
			totmedicine+=amount;
		});
		var payMaking=parseInt($("#payMaking").attr("value"));
		var totmaking=payMaking * packCnt;


		$("#totChubcapa").html(totchubcapa+"<span>g</span>");
		$("#totCapa").html(totcapa+"<span>g</span>");
		$("#totAmount").html(totmedicine+"<span>원</span>");
		 
		

		console.log("orderresetCntorderresetCntorderresetCnt totmedicine :  " + totmedicine);
		


	}


	function addpatient(){
		location.href="/Patient/?p=mod";
	}

	//처방내용> 약재추가
	function addmeditbl(json){
		var no=$("#meditbl tbody tr").length + 1;
		console.log("addmeditbl mdcode="+json["mdCode"]);
		var txt="<tr>";
				txt+="<td>";
				txt+="<div class='inp-checkBox'>";
				txt+="<div class='inp inp-check'>";
				txt+="<label for='d"+no+"' class='d-flex'>";
				txt+="<input type='checkbox' name='chk' id='d"+no+"' class='blind'  onclick='chkall()' value='"+json["mdCode"]+"'>";
				txt+="<span></span>";
				txt+="</label>";
				txt+="</div>";
				txt+="</div>";
				txt+="</td>";
				txt+="<td>"+no+"</td>";
				txt+="<td>";
				txt+="<div class='d-flex product-name'>";
				txt+=json["mdTitle"];
				//txt+="<span class='impossible'>처방불가</span>";
				txt+="</div>";
				txt+="</td>";
				/*  //옵션
				txt+="<td>";
				txt+="<div class='inp inp-select inp-radius'>";
				txt+="<select name='mediType' id=''>";
				var carr=["infirst","inmain","inafter","inlast"]
				var tarr=["선전","일반","후하","별전"]
				for(var m=0;m<carr.length;m++){
					if(json["mediType"]==carr[m]){var cls=" selected";}else{var cls=" ";}
					txt+="<option value='"+carr[m]+"' "+cls+">"+tarr[m]+"</option>";
				}
				txt+="</select>";
				txt+="</div>";
				txt+="</td>";
				*/
				txt+="<td>"+json["mdOrigin"]+"</td>";
				txt+="<td>";
				txt+="<div class='gram d-flex'>";
				txt+="<div class='inp inp-input inp-radius'>";
				if(json["mediCapa"]!=null){var mediCapa=json["mediCapa"];}else{var mediCapa=0;}
				txt+="<input type='text' name='capa' placeholder='' value='"+mediCapa+"' onkeyup='resetCnt()'>";
				txt+="</div>";
				txt+="<span>g</span>";
				txt+="</div>";
				txt+="</td>";
				txt+="<td>";
				txt+="<div class='gram d-flex'>";
				txt+="<div class='inp inp-input inp-radius'>";
				txt+="<input type='text' name='tcapa' placeholder='' value='0' readonly>";
				txt+="</div>";
				txt+="<span>g</span>";
				txt+="</div>";
				txt+="</td>";
				txt+="<td>";
				txt+="<span class='amount' value='"+json["mdPrice"]+"'>0</span>";
				txt+="<span class='won'>원</span>";
				txt+="</td>";
				txt+="<td>";
				txt+="<div class='inp inp-select inp-radius'>";
				txt+="<select name='mediType' id=''>";
				var carr=["infirst","inmain","inafter","inlast"]
				var tarr=["선전","일반","후하","별전"]
				for(var m=0;m<carr.length;m++){
					if(json["mediType"]==carr[m]){var cls=" selected";}else{var cls=" ";}
					txt+="<option value='"+carr[m]+"' "+cls+">"+tarr[m]+"</option>";
				}
				txt+="</select>";
				txt+="</div>";
				txt+="</td>";
				txt+="</tr>";
				console.log("txt   >>>> "+txt);
			$("#meditbl tbody").append(txt);
			setTimeout("resetCnt()",300);
	}

	function allchk(){
		var chk=$("#meditbl thead tr th input:checkbox[name=allchk]").prop("checked");
		$("#meditbl tbody tr td input:checkbox[name=chk]").each(function(){
			$(this).prop("checked",chk);
		});
	}

	function chkall(){
		var chk=$("#meditbl tbody tr td input:checkbox[name=chk]").length;
		var chked=$("#meditbl tbody tr td input:checkbox[name=chk]:checked").length;
		if(chk==chked){
			$("#meditbl thead tr th input:checkbox[name=allchk]").prop("checked",true);
		}else{
			$("#meditbl thead tr th input:checkbox[name=allchk]").prop("checked",false);
		}
	}

	function clearchk(){
		$("#meditbl tbody tr td input:checkbox[name=chk]").each(function(){
			var chk=$(this).prop("checked");
			if(chk==true){
				$(this).parent().parent().parent().parent().parent().remove();
			}
		});
		resetCnt();
	}

	function resetCnt(){
		var chubcnt=parseInt($("select[name=chubCnt]").val());
		var packCnt=parseInt($("select[name=packCnt]").val());
		var totchubcapa=totcapa=totmedicine=0
		$("#meditbl tbody tr").each(function(idx, val){
			$(this).children("td").eq(1).text(idx+1);
			var chubcapa=parseInt($(this).children("td").eq(4).children(".gram").children(".inp").children("input").val());
			var tcapa=chubcnt * chubcapa;
			console.log("chubcapa   >>>  "+chubcapa);
			console.log("tcapa   >>>  "+tcapa);
			$(this).children("td").eq(5).children(".gram").children(".inp").children("input").val(tcapa);
			var unit=parseInt($(this).children("td").eq(6).children(".amount").attr("value"));
			if(unit==undefined)unit=0;
			var amount = tcapa * unit;
			$(this).children("td").eq(6).html("<span class='amount' value='"+unit+"'>"+amount+"</span><span class='won'>원</span>");
			console.log("약재추가 >>> "+chubcapa+"_"+tcapa+"_"+unit+"_"+amount);
			totchubcapa+=chubcapa;
			totcapa+=tcapa;
			totmedicine+=amount;
		});
		var payMaking=parseInt($("#payMaking").attr("value"));
		var totmaking=payMaking * packCnt;

		console.log("resetCntresetCntresetCntresetCntresetCntresetCntresetCnt");


		$("#totChubcapa").html(totchubcapa+"<span>g</span>");
		$("#totCapa").html(totcapa+"<span>g</span>");
		$("#totAmount").html(totmedicine+"<span>원</span>");
		$("#payMedicine").html(commasFixed(totmedicine));   
		$("#payMaking").html(commasFixed(totmaking));   
		var payTotal=totmedicine;


		var payDecoction=$("#payDecoction").attr("value");
		var payPacking=$("#payPacking").attr("value");
		var payRelease=$("#payRelease").attr("value");

		var payTotal=parseFloat(totmedicine) + parseFloat(totmaking) + parseFloat(payDecoction) + parseFloat(payPacking) + parseFloat(payRelease);



		console.log("totmedicine = " + totmedicine+", totmaking = " + totmaking+", payDecoction = "+payDecoction+", payPacking = " +payPacking + ", payRelease = " + payRelease + ", payTotal = " + payTotal);
		$("#payTotal").html(commasFixed(payTotal));
	}

	function changeboxmedi(val,title,price)
	{
		//alert(val);
		var imgurl=$("#img"+val).val();
		//alert(imgurl);
		$("input[name=odmedibox]").val(val);
		$("input[name=odmediboxtitle]").val(title);
		$("input[name=odmediboxprice]").val(price);
		$("input[name=odmediboximg]").val(imgurl);
		$("#mediboxbtn").children("img").attr("src", imgurl);

		$("#medibox").fadeOut(10);
		//viewpack('medibox');
	}
	function changepacktype(val,title,price)
	{
		//alert(val);
		var imgurl=$("#img"+val).val();
		$("input[name=odpacktype]").val(val);
		$("input[name=odpacktypetitle]").val(title);
		$("input[name=odpacktypeprice]").val(price);
		$("input[name=odpacktypeimg]").val(imgurl);
		//alert(imgurl);
		$("#packtypebtn").children("img").attr("src", imgurl);
		//viewpack('packtype');
		$("#packtype").fadeOut(10);
	}

	function setjsondata(dir)
	{
		var json=JSON.parse($("textarea[name=join_jsondata]").val());

		if(dir=="")//임시저장
		{

		}
		else if(dir=="next")//다음단계
		{

		}
		else if(dir=="prev")//이전단계
		{
			$("input[name=medicalId]").val(json["orderInfo"][0]["medicalCode"]);
			$("input[name=medicalName]").val(json["orderInfo"][0]["medicalName"]);
			$("input[name=doctorName]").val(json["orderInfo"][0]["doctorName"]);
			$("input[name=odTitle]").val(json["orderInfo"][0]["orderTitle"]);
			$("textarea[name=orderAdvice]").val(json["orderInfo"][0]["orderAdvice"]);
			$("textarea[name=orderComment]").val(json["orderInfo"][0]["orderComment"]);

			$("#meChartno").text(json["patientInfo"][0]["patientCode"]);
			$("#meName").text(json["patientInfo"][0]["patientName"]);
			$("#meSexTxt").text(json["patientInfo"][0]["patientGender"]);
			$("#meBirthDay").text(json["patientInfo"][0]["patientBirth"]);
			$("#meMobile").text(json["patientInfo"][0]["patientPhone"]);

			//환자정보
			var birth=$("#meBirthDay").text();
			birth=birth.replace(".","-");
			json["patientInfo"][0]["patientCode"]=$("#meChartno").text();
			json["patientInfo"][0]["patientName"]=$("#meName").text();
			json["patientInfo"][0]["patientGender"]=$("#meSexTxt").text();
			json["patientInfo"][0]["patientBirth"]=birth;
			json["patientInfo"][0]["patientPhone"]=$("#meMobile").text();


			//처방정보
			$("#chubCnt").val(json["recipeInfo"][0]["chubCnt"]).attr("selected","seleceted");
			$("#packCnt").val(json["recipeInfo"][0]["packCnt"]).attr("selected","seleceted");
			$("#packCapa").val(json["recipeInfo"][0]["packCapa"]).attr("selected","seleceted");

			var medicine=json["recipeInfo"][0]["totalMedicine"];
			var medilen=medicine.length;
			$("#meditbl tbody").html("");
			for(i=0;i<medilen;i++)
			{
				var json={};
					json["seq"]="";
					json["mdTitle"]=medicine[i]["mediName"];
					json["mdCode"]=medicine[i]["mediCode"];
					json["mdOrigin"]=medicine[i]["mediOriginTxt"];
					json["mdPrice"]=medicine[i]["mediAmount"];
					json["mediType"]=medicine[i]["mediType"];
				
				addmeditbl(json);
			}

		}
		else if(dir=="cart")//접수 
		{

		}
	}
	function saveOrder(dir){
		//DOO:: 여기에서 jsondata를 말자!!!

		//alert("saveOrder 임시저장/다음단계 dir = " + dir);
		var json=JSON.parse($("textarea[name=join_jsondata]").val());
		console.log($("#meChartno").text());

		//setjsondata(dir);


		var keycode=json["orderInfo"][0]["keycode"];
		var ordercode=json["orderInfo"][0]["orderCode"];
		var orderdate=json["orderInfo"][0]["orderDate"];
		var deliveryDate=json["orderInfo"][0]["deliveryDate"];
		if(isEmpty(ordercode))
		{
			var d=new Date()
			var month=("0" + (d.getMonth() + 1)).slice(-2);
			var day=("0" + d.getDate()).slice(-2);
			var hour=("0" + d.getHours()).slice(-2);
			var minute=("0" + d.getMinutes()).slice(-2);
			var second=("0" + d.getSeconds()).slice(-2);
			ordercode="MDD"+d.getFullYear()+month+day+hour+minute+second;
			orderdate=d.getFullYear()+"-"+month+"-"+day+" "+hour+":"+minute+":"+second;
			deliveryDate=orderdate;
		}


		if(dir=="")//임시저장
		{
			orderStatus="temp";
		}
		else if(dir=="next")//다음단계
		{
			orderStatus="temp";

			var odpacktype=$("input[name=odpacktype]").val();
			var odmedibox=$("input[name=odmedibox]").val();
			var medicount=$("#meditbl tbody tr").length;
			var mechartno=$("#meChartno").text();
			var odtitle=$("input[name=odTitle]").val();

			if(isEmpty(medicount) || medicount<=0)
			{
				alert("약재를 선택해 주세요.");
				return false;
			}

			if(isEmpty(mechartno))
			{
				alert("환자를 선택해 주세요.");
				return false;
			}

			if(isEmpty(odpacktype))
			{
				alert("파우치를 선택해 주세요.");
				return false;
			}

			if(isEmpty(odmedibox))
			{
				alert("한약박스를 선택해 주세요.");
				return false;
			}

			if(isEmpty(odtitle))
			{
				alert("처방명을 입력해 주세요.");
				return false;
			}

			
			

		
			var ck_miUserid=getCookie("ck_miUserid");
			var medicalId=$("input[name=medicalId]").val();
			var medicalName=$("input[name=medicalName]").val();
			var doctorId=ck_miUserid;
			var doctorName=$("input[name=doctorName]").val();
			var odTitle=$("input[name=odTitle]").val();
			var orderAdvice=$("textarea[name=orderAdvice]").val();
			var orderComment=$("textarea[name=orderComment]").val();
			var orderStatus=json["orderInfo"][0]["orderStatus"];
			
			//주문정보
			//json["orderInfo"][0]["keycode"];//주문코드, 부산대주문코드
			json["orderInfo"][0]["orderCode"]=ordercode;//주문코드, 부산대주문코드
			json["orderInfo"][0]["orderDate"]=orderdate;//주문일
			json["orderInfo"][0]["deliveryDate"]=deliveryDate;//배송희망일
			json["orderInfo"][0]["medicalCode"]=medicalId;//한의원코드
			json["orderInfo"][0]["medicalName"]=medicalName;//한의원
			json["orderInfo"][0]["doctorCode"]=doctorId;//처방자코드
			json["orderInfo"][0]["doctorName"]=doctorName;//처방자
			json["orderInfo"][0]["orderTitle"]=odTitle;//처방명
			json["orderInfo"][0]["orderTypeCode"]="decoction";//조제타입코드
			json["orderInfo"][0]["orderType"]="탕제";//조제타입명
			json["orderInfo"][0]["orderCount"]=1;//주문갯수
			json["orderInfo"][0]["productCode"]="";//처방코드
			json["orderInfo"][0]["productCodeName"]="";//처방코드명
			json["orderInfo"][0]["orderComment"]=orderComment;//조제지시
			json["orderInfo"][0]["orderAdvice"]=orderAdvice;//복약지도서
			json["orderInfo"][0]["orderStatus"]=orderStatus;//주문상태 cart(장바구니),paid(결재완료),done(등록완료)

			//환자정보
			var birth=$("#meBirthDay").text();
			birth=birth.replace(".","-");
			json["patientInfo"][0]["patientCode"]=$("#meChartno").text();
			json["patientInfo"][0]["patientName"]=$("#meName").text();
			json["patientInfo"][0]["patientGender"]=$("#meSexTxt").text();
			json["patientInfo"][0]["patientBirth"]=birth;
			json["patientInfo"][0]["patientPhone"]=$("#meMobile").text();

			//처방정보
			var chubCnt=$("select[name=chubCnt]").val();
			var packCnt=$("select[name=packCnt]").val();
			var packCapa=$("select[name=packCapa]").val();
			console.log("chubCnt = " + chubCnt+", packCnt = " + packCnt+", packCapa="+packCapa);
			json["recipeInfo"][0]["chubCnt"]=chubCnt;
			json["recipeInfo"][0]["packCnt"]=packCnt;
			json["recipeInfo"][0]["packCapa"]=packCapa;
			//약재
			var mdarr=new Array();
			$("#meditbl tbody tr").each(function()
			{
				var mediType=$(this).children("td").eq(7).find("select").val();//처방타입
				var mediCode=$(this).children("td").eq(0).find("input").val(); //약재코드
				var mediName=$(this).children("td").eq(2).text();//약재명
				var mediPoison="";//독성 ( 0 , 1)
				var mediDismatch=""; //상극 ( 0 , 1)
				var mediOrigin="";//원산지코드
				var mediOriginTxt=$(this).children("td").eq(3).text();//원산지명 
				var mediCapa=$(this).children("td").eq(4).find("input").val();//첩당약재량
				var mediAmount=$(this).children("td").eq(6).find(".amount").attr("value");//첩당약재비

				console.log("약재 mediType = " + mediType+", mediCode= " + mediCode+", mediName= " + mediName+", mediPoison= " + mediPoison+", mediDismatch= " + mediDismatch+", mediOrigin= " + mediOrigin+", mediOriginTxt= " + mediOriginTxt+", mediCapa= " + mediCapa+", mediAmount= " + mediAmount);
				//alert(code);

				var mdata={};
				mdata["mediType"]=mediType;
				mdata["mediCode"]=mediCode;
				mdata["mediName"]=mediName;
				mdata["mediPoison"]=mediPoison;
				mdata["mediDismatch"]=mediDismatch;
				mdata["mediOrigin"]=mediOrigin;
				mdata["mediOriginTxt"]=mediOriginTxt;
				mdata["mediCapa"]=mediCapa;
				mdata["mediAmount"]=mediAmount;

				
				mdarr.push(mdata);

			});
			console.log(mdarr);
			json["recipeInfo"][0]["totalMedicine"]=mdarr;

			console.log(json["recipeInfo"][0]["totalMedicine"]);
			console.log(JSON.stringify(json["recipeInfo"][0]["totalMedicine"]))


			//감미제

			//탕전정보
			var specialDecoc=$("select[name=specialDecoc]").val();
			var specialDecoctxt=$("select[name=specialDecoc]").children("option:selected").text();
			json["decoctionInfo"][0]["specialDecoc"]=specialDecoc;//특수탕전코드
			json["decoctionInfo"][0]["specialDecoctxt"]=specialDecoctxt;//특수탕전명 예)주수상반

			//마킹정보
			json["markingInfo"][0]["markType"]="marking07";//특수탕전코드
			json["markingInfo"][0]["markText"]="";//특수탕전명 예)주수상반

			//포장재정보
			var parr=new Array();
			var pdata={};
			//파우치
			pdata["packType"]="pouch"; //포장재종류 pouch(파우치),medibox(한약박스),delibox(배송박스)
			pdata["packCode"]=$("input[name=odpacktype]").val(); //포장재코드
			pdata["packName"]=$("input[name=odpacktypetitle]").val(); //포장재명
			pdata["packImage"]=$("input[name=odpacktypeimg]").val(); //포장재이미지 URL
			pdata["packAmount"]=$("input[name=odpacktypeprice]").val(); //개별포장재비
			parr.push(pdata);
			var pdata1={};
			//한약박스
			pdata1["packType"]="medibox"; //포장재종류 pouch(파우치),medibox(한약박스),delibox(배송박스)
			pdata1["packCode"]=$("input[name=odmedibox]").val(); //포장재코드
			pdata1["packName"]=$("input[name=odmediboxtitle]").val(); //포장재명
			pdata1["packImage"]=$("input[name=odmediboximg]").val(); //포장재이미지 URL
			pdata1["packAmount"]=$("input[name=odmediboxprice]").val(); //개별포장재비
			parr.push(pdata1);

			var pdata2={};
			//배송박스
			pdata2["packType"]="delibox"; //포장재종류 pouch(파우치),medibox(한약박스),delibox(배송박스)
			pdata2["packCode"]="RBD190710182024"; //포장재코드
			pdata2["packName"]="포장박스없음"; //포장재명
			pdata2["packImage"]=""; //포장재이미지 URL
			pdata2["packAmount"]="0"; //개별포장재비
			parr.push(pdata2);

			console.log(parr);

			json["packageInfo"]=parr;
			console.log(json["packageInfo"]);
			console.log(JSON.stringify(json["packageInfo"]))
		

			//결재정보 
			json["paymentInfo"][0]["amountTotal"]=$("#payTotal").text().replace(/\,/gi,'');
			json["paymentInfo"][0]["amountMedicine"]=$("#payMedicine").text();
			json["paymentInfo"][0]["amountPharmacy"]=$("#payMaking").text();
			json["paymentInfo"][0]["amountDecoction"]=$("#payDecoction").text();
			json["paymentInfo"][0]["amountPackaging"]=$("#payPacking").text();
			json["paymentInfo"][0]["amountDelivery"]=$("#payRelease").text();


			//복약지도정보
			json["adviceInfo"][0]["foodAdvice"]=""; //주의음식
			json["adviceInfo"][0]["cautionAdvice"]=""; //기타주의사항
			json["adviceInfo"][0]["foodAdvicFree"]=""; //주의음식(FREETEXT)
			json["adviceInfo"][0]["cautionAdviceFree"]=""; //기타주의사항(FREETEXT)


			//입원환자용라벨 
			json["labelInfo"][0]["wardNo"]=""; //병동코드
			json["labelInfo"][0]["roomNo"]=""; //병실코드
			json["labelInfo"][0]["bedNo"]=""; //베드코드
			json["labelInfo"][0]["mediDays"]=""; //첩약기간
			json["labelInfo"][0]["mediType"]=""; //첩약종류
			json["labelInfo"][0]["mediCapa"]=""; //첩약용량
			json["labelInfo"][0]["mediName"]=""; //첩약명
			json["labelInfo"][0]["mediAdvice"]=""; //복약지도


		}
		else if(dir=="prev")//이전단계
		{
			orderStatus="temp";
		}
		else if(dir=="cart")//접수 
		{
			//받는사람
			var receiveName=$("input[name=receiveName]").val();
			var receiveZipcode=$("input[name=receiveZipcode]").val();
			var receiveAddress=$("input[name=receiveAddress]").val();
			var receiveAddressDesc=$("input[name=receiveAddressDesc]").val();

			var receivePhone0=$("input[name=receivePhone0]").val();
			var receivePhone1=$("input[name=receivePhone1]").val();
			var receivePhone2=$("input[name=receivePhone2]").val();
			var receivePhone=receivePhone0+"-"+receivePhone1+"-"+receivePhone2;

			var receiveMobile0=$("input[name=receiveMobile0]").val();
			var receiveMobile1=$("input[name=receiveMobile1]").val();
			var receiveMobile2=$("input[name=receiveMobile2]").val();
			var receiveMobile=receiveMobile0+"-"+receiveMobile1+"-"+receiveMobile2;



			if(isEmpty(receiveName))
			{
				alert("수신인 이름이 없습니다.");
				return false;
			}
			if(isEmpty(receiveZipcode))
			{
				alert("수신인 우편번호가 없습니다.");
				return false;
			}
			if(isEmpty(receiveAddress))
			{
				alert("수신인 주소가 없습니다.");
				return false;
			}
			if(isEmpty(receiveAddressDesc))
			{
				alert("수신인 상세주소가 없습니다.");
				return false;
			}

			//보내는사람
			var sendName=$("input[name=sendName]").val();
			var sendZipcode=$("input[name=sendZipcode]").val();
			var sendAddress=$("input[name=sendAddress]").val();
			var sendAddressDesc=$("input[name=sendAddressDesc]").val();
			if(isEmpty(sendName))
			{
				alert("발신인 이름이 없습니다.");
				return false;
			}
			if(isEmpty(sendZipcode))
			{
				alert("발신인 우편번호가 없습니다.");
				return false;
			}
			if(isEmpty(sendAddress))
			{
				alert("발신인 주소가 없습니다.");
				return false;
			}
			if(isEmpty(sendAddressDesc))
			{
				alert("발신인 상세주소가 없습니다.");
				return false;
			}

			orderStatus="cart";
			json["orderInfo"][0]["orderStatus"]=orderStatus;//주문상태 cart(장바구니),paid(결재완료),done(등록완료)
			//배송정보
			//보내는사람정보 
			 var sendName=!isEmpty($("input[name=sendName]").val())?$("input[name=sendName]").val():"";
			 var sendPhone0=!isEmpty($("input[name=sendPhone0]").val())?$("input[name=sendPhone0]").val():"";
			 var sendPhone1=!isEmpty($("input[name=sendPhone1]").val())?$("input[name=sendPhone1]").val():"";
			 var sendPhone2=!isEmpty($("input[name=sendPhone2]").val())?$("input[name=sendPhone2]").val():"";
			 var sendMobile0=!isEmpty($("input[name=sendMobile0]").val())?$("input[name=sendMobile0]").val():"";
			 var sendMobile1=!isEmpty($("input[name=sendMobile1]").val())?$("input[name=sendMobile1]").val():"";
			 var sendMobile2=!isEmpty($("input[name=sendMobile2]").val())?$("input[name=sendMobile2]").val():"";
			 var sendZipcode=!isEmpty($("input[name=sendZipcode]").val())?$("input[name=sendZipcode]").val():"";
			 var sendAddress=!isEmpty($("input[name=sendAddress]").val())?$("input[name=sendAddress]").val():"";
			 var sendAddressDesc=!isEmpty($("input[name=sendAddressDesc]").val())?$("input[name=sendAddressDesc]").val():"";
			//받는사람정보
			 var receiveName=!isEmpty($("input[name=receiveName]").val())?$("input[name=receiveName]").val():"";
			 var receivePhone0=!isEmpty($("input[name=receivePhone0]").val())?$("input[name=receivePhone0]").val():"";
			 var receivePhone1=!isEmpty($("input[name=receivePhone1]").val())?$("input[name=receivePhone1]").val():"";
			 var receivePhone2=!isEmpty($("input[name=receivePhone2]").val())?$("input[name=receivePhone2]").val():"";
			 var receiveMobile0=!isEmpty($("input[name=receiveMobile0]").val())?$("input[name=receiveMobile0]").val():"";
			 var receiveMobile1=!isEmpty($("input[name=receiveMobile1]").val())?$("input[name=receiveMobile1]").val():"";
			 var receiveMobile2=!isEmpty($("input[name=receiveMobile2]").val())?$("input[name=receiveMobile2]").val():"";
			 var receiveZipcode=!isEmpty($("input[name=receiveZipcode]").val())?$("input[name=receiveZipcode]").val():"";
			 var receiveAddress=!isEmpty($("input[name=receiveAddress]").val())?$("input[name=receiveAddress]").val():"";
			 var receiveAddressDesc=!isEmpty($("input[name=receiveAddressDesc]").val())?$("input[name=receiveAddressDesc]").val():"";

			json["deliveryInfo"][0]["deliType"]="post"; //배송종류 direct(직배), post(택배)
			json["deliveryInfo"][0]["sendName"]=sendName; //보내는사람
			json["deliveryInfo"][0]["sendPhone"]=sendPhone0+"-"+sendPhone1+"-"+sendPhone2; //보내는사람 전화번호
			json["deliveryInfo"][0]["sendMobile"]=sendMobile0+"-"+sendMobile1+"-"+sendMobile2; //보내는사람 휴대폰번호
			json["deliveryInfo"][0]["sendZipcode"]=sendZipcode; //보내는사람 우편번호
			json["deliveryInfo"][0]["sendAddress"]=sendAddress; //보내는사람 주소
			json["deliveryInfo"][0]["sendAddressDesc"]=sendAddressDesc; //보내는사람 상세주소
			json["deliveryInfo"][0]["receiveName"]=receiveName; //받는사람
			json["deliveryInfo"][0]["receivePhone"]=sendPhone0+"-"+sendPhone1+"-"+sendPhone2; //받는사람 전화번호
			json["deliveryInfo"][0]["receiveMobile"]=receiveMobile0+"-"+receiveMobile1+"-"+receiveMobile2; //받는사람 휴대폰번호
			json["deliveryInfo"][0]["receiveZipcode"]=receiveZipcode; //받는사람 우편번호
			json["deliveryInfo"][0]["receiveAddress"]=receiveAddress; //받는사람 주소
			json["deliveryInfo"][0]["receiveAddressDesc"]=receiveAddressDesc; //받는사람 상세주소
			json["deliveryInfo"][0]["receiveComment"]=sendName; //배송요구사항
			json["deliveryInfo"][0]["receiveTied"]=sendName; //묶음배송마스터주문코드 (부산대주문코드)
			
		}



		console.log(json);
		$("textarea[name=join_jsondata]").val(JSON.stringify(json));

		if(dir.length > 3){
		makehash("",dir,"");
		if(dir=="prev"){setTimeout("viewscription('')",1000);}
		}

		if(dir=="cart" || dir=="")//임시저장이거나
		{
			orderupdate();
		}

		/////

		//원래소스 
	/*


		json["orderInfo"][0]["deliveryDate"]="";
		json["orderInfo"][0]["medicalCode"]=$("input[name=medicalId]").val();
		json["orderInfo"][0]["medicalName"]=$("input[name=medicalName]").val();
		json["orderInfo"][0]["doctorCode"]=$("input[name=doctorId]").val();
		json["orderInfo"][0]["doctorName"]=$("input[name=doctorName]").val();
		json["orderInfo"][0]["orderTitle"]=$("input[name=odTitle]").val();
		json["orderInfo"][0]["orderTypeCode"]="decoction";
		json["orderInfo"][0]["orderType"]="탕제";
		json["orderInfo"][0]["orderCount"]=1;
		json["orderInfo"][0]["productCode"]="";
		json["orderInfo"][0]["productCodeName"]="";
		json["orderInfo"][0]["orderAdvice"]=$("textarea[name=orderAdvice]").val();
		json["orderInfo"][0]["orderComment"]=$("textarea[name=orderComment]").val();
	//	json["orderInfo"][0]["orderStatus"]="cart";



		json["patientInfo"][0]["patientCode"]=$("#meChartno").text();
		json["patientInfo"][0]["patientName"]=$("#meName").text();
		json["patientInfo"][0]["patientGender"]=$("#meSexTxt").text();
		json["patientInfo"][0]["patientBirth"]=$("#meBirthDay").text();
		json["patientInfo"][0]["patientPhone"]=$("#meMobile").text();
	
		json["paymentInfo"][0]["amountTotal"]=$("#payTotal").text().replace(/\,/gi,'');
		json["paymentInfo"][0]["amountMedicine"]=$("#payMedicine").text();
		json["paymentInfo"][0]["amountPharmacy"]=$("#payMaking").text();
		json["paymentInfo"][0]["amountDecoction"]=$("#payDecoction").text();
		json["paymentInfo"][0]["amountPackaging"]=$("#payPacking").text();
		json["paymentInfo"][0]["amountDelivery"]=$("#payRelease").text();

		
		$("#meditbl tbody tr").each(function(){
			var code=$(this).children("td").eq(0).find("input").val();
			//alert(code);
		});
		json["recipeInfo"][0]["chubCnt"]=$("select[name=chubCnt]:selected").val();
		json["recipeInfo"][0]["packCnt"]=$("select[name=packCnt]:selected").val();
		json["recipeInfo"][0]["packCapa"]=$("select[name=packCapa]:selected").val();


		var keycode=json["orderInfo"][0]["keycode"];
		var ordercode=json["orderInfo"][0]["orderCode"];
		//if(keycode!="")	setCookie("od_keycode", keycode, 1);
		if(ordercode==""){
			var d=new Date()
			var month=("0" + (d.getMonth() + 1)).slice(-2);
			var day=("0" + d.getDate()).slice(-2);
			var hour=("0" + d.getHours()).slice(-2);
			var minute=("0" + d.getMinutes()).slice(-2);
			var second=("0" + d.getSeconds()).slice(-2);
			ordercode="MDD"+d.getFullYear()+month+day+hour+minute+second;
			var orderdate=d.getFullYear()+"-"+month+"-"+day+" "+hour+":"+minute+":"+second;
			json["orderInfo"][0]["orderCode"]=ordercode;
			json["orderInfo"][0]["orderDate"]=orderdate;
			json["orderInfo"][0]["deliveryDate"]=orderdate;
		}
		console.log(orderdate);
		console.log(json);
		$("textarea[name=join_jsondata]").val(JSON.stringify(json));




*/


		//orderupdate();
		//setCookie("od_ordercode", ordercode, 1);


	/*	if(dir.length > 3){
			makehash("",dir,"");
			if(dir=="prev"){setTimeout("viewscription('')",1000);}
		}
		*/
	//odTitle  chubCnt packCnt packCapa specialDecoc specialDecoc specialDecoctxt sweet mediBox packType foodAdvice cautionAdvice

	}

	//처방정보 빛 주문 > 보내는사람
	function getSenderInfo()
	{	
		var chk=$("input[name=sendertype]:checked").val();
	
		switch(chk){
			case "medical":  //의료기관
				var data="apiCode=myinfodesc&language=kor&returnData=sender&medicalid="+$("input[name=medicalId]").val();
				callapi("GET","/medical/member/",data);
				break;
			case "patient": //탕전원
				$(".sender").val("");
				break;
			default: //새로입력
				$(".sender").val("");
		}
	}
	function getReceiverInfo(){
		var chk=$("input[name=receivertype]:checked").val();
		switch(chk){
			case "medical":
				var data="apiCode=myinfodesc&language=kor&returnData=receiver&medicalid="+$("input[name=medicalId]").val();
				callapi("GET","/medical/member/",data);
				break;
			case "patient":
				$(".receiver").val("");
				break;
			default:
				$(".receiver").val("");
		}
	}

	function mediBtn(type){
		switch(type){
			case "recipe":
				$("input[name=searchmedi]").val("");
				$("#searchtab").attr({"name":"searchrecipe","placeholder":"빠른 처방 추가","onkeyup":"searchkeyup('searchrecipe',event)"});
				$("#mediBtn").text("약재추가").attr("href","javascript:mediBtn('medi');").removeClass("bg-blue").addClass("bg-red");
				break;
			case "medi":
				$("input[name=searchrecipe]").val("");
				$("#searchtab").attr({"name":"searchmedi","placeholder":"빠른 약재 추가","onkeyup":"searchkeyup('searchmedi',event)"});
				$("#mediBtn").text("처방추가").attr("href","javascript:mediBtn('recipe');").removeClass("bg-red").addClass("bg-blue");
				break;
		}
	}
