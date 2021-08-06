	function makeorderhash(page,type,seq)
	{
		location.hash=page+"|"+type+"|"+seq;
	}
	function searchkeyup(id, evt){
		var len=$("input[name="+id+"]").val();
		if(isEmpty(len))
		{
			$(".inp-search__list").html("");
		}
		else
		{
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
						console.log("medicalId = " + medicalId);
						console.log("search = " + search);
						var data="apiCode=patientlist&language=kor&medicalid="+medicalId+"&searchTxt="+encodeURI(search);
						callapi("GET","/medical/patient/",data);
						break;
					case "searchmedi":
						var medicalId=$("input[name=medicalId]").val();
						var search=$("input[name=searchmedi]").val();
						var data="apiCode=medicinelist&language=kor&searchTxt="+encodeURI(search);
						callapi("GET","/medical/medicine/",data);
						break;
					case "searchrecipe":
						var medicalId=$("input[name=medicalId]").val();
						var search=$("input[name=searchrecipe]").val();
						var data="apiCode=medicalsclist&language=kor&medicalId="+medicalId+"&searchTxt="+encodeURI(search);
						callapi("GET","/medical/recipe/",data);
						break;
				}
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

	//환자정보 
	function callPatient(orderid)
	{
		$("#orderpatient").load("/Skin/Order/order.patient.php", function(){callInfo(orderid);});
	}
	//처방내용-처방명첩수 
	function callInfo(orderid)
	{
		$("#orderinfo").load("/Skin/Order/order.info.php", function(){callMedicine(orderid);});
	}
	function callMedicine(orderid)
	{
		$("#ordermedicine").load("/Skin/Order/order.medicine.php", function(){callDecoc(orderid);});
	}
	function callDecoc(orderid)
	{
		$("#orderdecoc").load("/Skin/Order/order.decoc.php", function(){callAdvice(orderid);});
	}
	function callAdvice(orderid)
	{
		$("#orderadvice").load("/Skin/Order/order.advice.php", function(){callComment(orderid);});
	}
	function callComment(orderid)
	{
		$("#ordercomment").load("/Skin/Order/order.comment.php", function(){callPayment(orderid);});
	}
	function callPayment(orderid)
	{
		$("#orderpayment").load("/Skin/Order/order.payment.php", function(){callApiorder(orderid);});
	}
	function callApiorder(orderid)
	{
		var medicalId=$("input[name=medicalId]").val();
		callapi('GET','/medical/order/','apiCode=orderdesc&language=kor&seq='+orderid+"&medicalId="+medicalId);
	}


	function viewscription(orderid){
		var medicalId=$("input[name=medicalId]").val();

		console.log("#### viewscription orderid = " + orderid + ", medicalId = " + medicalId);

		callPatient(orderid);
		
		/*
		var parr=["patient","info","medicine","decoc","advice","comment","payment"]
		$.each(parr, function(idx, val){
			$("#order"+val).load("/Skin/Order/order."+val+".php?="+orderid);
		});

		setTimeout("callapi('GET','/medical/config/','apiCode=getconfig&language=kor')",500);
		setTimeout("callapi('GET','/medical/config/','apiCode=getpacking&language=kor&medicalId="+medicalId+"')",500);
		setTimeout("callapi('GET','/medical/order/','apiCode=orderdesc&language=kor&seq="+orderid+"')",600);  //주문내역 > 임시처방하기에서 왔을때 상세 뿌리는거.
		*/

		gotop();
	}


	function callSender(orderid)
	{
		$("#ordersender").load("/Skin/Order/order.sender.php", function(){callReceiver(orderid);});
	}
	function callReceiver(orderid)
	{
		$("#orderreceiver").load("/Skin/Order/order.receiver.php", function(){callRecipe(orderid);});
	}
	function callRecipe(orderid)
	{
		$("#orderrecipe").load("/Skin/Order/order.recipe.php", function(){callDecocview(orderid);});
	}
	function callDecocview(orderid)
	{
		$("#orderdecocview").load("/Skin/Order/order.decocview.php", function(){callAdviceview(orderid);});
	}
	function callAdviceview(orderid)
	{
		$("#orderadviceview").load("/Skin/Order/order.adviceview.php", function(){callCommentview(orderid);});
	}
	function callCommentview(orderid)
	{
		$("#ordercommentview").load("/Skin/Order/order.commentview.php", function(){callPaymentview(orderid);});
	}
	function callPaymentview(orderid)
	{
		$("#orderpaymentview").load("/Skin/Order/order.paymentview.php", function(){callApiorderNext(orderid);});
	}
	function callApiorderNext(orderid)
	{
		callapi('GET','/medical/order/','apiCode=orderdescnext&language=kor&seq='+orderid);
	}
	function viewscription2(orderid){
		var medicalId=$("input[name=medicalId]").val();

		callSender(orderid);

		/*
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
		*/
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
		$("#specialDecocdiv").text(json["decoctionInfo"][0]["specialDecoctxt"]);//특수탕전

		var sweet=json["recipeInfo"][0]["sweetMedi"];
		for(i=0;i<sweet.length;i++)
		{
			if(!isEmpty(sweet[i]["sweetCode"]))
			{
				console.log(sweet[i]["sweetName"]);
				$("#sweetdiv").text(sweet[i]["sweetName"]);
			}
		}
		
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
		var amountSweet=json["paymentInfo"][0]["amountSweet"];
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

		console.log("amountSweet = " + amountSweet);
		//감미제 
		$("#idviewsweet").hide();
		if(!isEmpty(amountSweet)&&parseInt(amountSweet)>0)
		{
			$("#idviewsweet").show();
			$("#payviewsweet").text(amountSweet);
		}

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

	function orderupdate(dir){
		var data = $("textarea[name=join_jsondata]").val();
		console.log("-------------------->>>  orderupdate");
		console.log(JSON.stringify(data));
		dir=!isEmpty(dir)?dir:"";
		callapi("POST","/medical/order/","data="+data+"&dir="+dir);  //apicode=orderregist

		//console.log("callapi하고 페이지는 주문내역으로 이동");
		//location.href="/Order/";
	}

	function setPatient(seq){
		var data = "apiCode=patientdesc&language=kor&seq="+seq;
		callapi("GET","/medical/patient/",data);
	}

	function setMedicine(seq){
		var miGrade=chkGrade(getCookie("ck_miGrade"));
		var data = "apiCode=medicinedesc&language=kor&seq="+seq+"&miGrade="+miGrade;
		callapi("GET","/medical/medicine/",data);
	}

	function setRecipe(seq){
		var data = "apiCode=medicalscdesc&language=kor&seq="+seq;
		callapi("GET","/medical/recipe/",data);
	}


	function setGetpacking(data)
	{
		var i=0;
		var selectedImg="";
		var txt="";
		var imgurl="";
		$.each(data["boxmedi"], function(idx, val){
		
			if(val["afThumbUrl"]!="" && val["afThumbUrl"]!="NoIMG")
			{
				imgurl=getUrlData("FILE_DOMAIN")+val["afThumbUrl"];
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
		$.each(data["packtype"], function(idx, val){
			if(val["afThumbUrl"]!="" && val["afThumbUrl"]!="NoIMG")
			{
				imgurl=getUrlData("FILE_DOMAIN")+val["afThumbUrl"];
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
	}


	function makepage(result){
		var json = JSON.parse(result);
		console.log(json);
		if(json["resultCode"]=="200"){
			switch(json["apiCode"]){
				 /*case "getconfig":
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
					break;*/
				 case "orderlist": 				 
						var uri = location.pathname;
						if(uri.indexOf("/Order/") != -1)//주문내역 
						{
							var hdata=location.hash.replace("#","").split("|");
							var type=hdata[1];
							if(type=="temp")//임시저장일경우에는 
							{
								var marr=["orderdate","ordercode","ordertype","ordertitle","patientname","amounttotal","orderstatus"];	
								makelist(result, marr);
							}
							else
							{
								var marr=["mychkbox","orderdate","ordercode","ordertype","ordertitle","patientname","amounttotal","orderstatus"];	
								makelist(result, marr);
							}
						}
						else
						{
							var marr=["orderdate","ordercode","ordertype","ordertitle","patientname","amounttotal","orderstatus"];	
							makelist(result, marr);
						}
					break;
				case "myrecipelist"://나의처방 
					var marr=["mychkboxdel","rcType","rcTitle","rcMedicine","rcMedicineCnt","rcChub","rcPackcnt","rcPackcapa","rcEtc"];	
					makelist(result, marr);
					break;
				case "myrecipeupdate":
					alert("나의처방으로 등록되었습니다.");
					clearmycheck();
					break;
				case "myrecipedelete":
					alert("나의처방이 삭제되었습니다.");
					makeorderhash("","mydecoc","");
					break;
				 case "patientlist": 
					 searchlist("searchpatient",json["list"]);
					break;
				 case "patientdesc": 
					var arr=["meChartno","meName","meSexTxt","meBirthDay","mePhone","meMobile","meAddress","lastScript","meMemo"];
					$.each(arr, function(idx, val){
						if(val=="meAddress")
						{
							$("#"+val).text("["+json["meZipcode"]+"] "+json[val]);
							$("input[name=paZipcode]").val(json["meZipcode"]);
							$("input[name=paAddr]").val(json["meAddress0"]+"||"+json["meAddress1"]);
						}
						else if(val=="lastScript")
						{
							var lasthtml='<a href="javascript:lastorderBtn(\''+json["lastseq"]+'\');" id="lastorder" class="bg-blue color-white radius">'+json["lastScript"]+'</a>';
							$("#"+val).html(lasthtml);
						}
						else
						{
							$("#"+val).text(json[val]);
						}
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

					var chkmedi=false;
					$("#meditbl tbody tr").each(function()
					{
						var mediCode=$(this).children("td").eq(0).find("input").val(); //약재코드
						if(mediCode==json["mdCode"])
						{
							chkmedi=true;
						}
					});

					if(chkmedi==true)
					{
						alert("이미 추가된 약재입니다.");
					}
					else
					{
						addmeditbl(json);
					}
					
					$(".inp-search__list").html("");
					$("input[name=searchrecipe]").val("");
					break;
				 case "medicalsclist":
					 searchlist("searchrecipe",json["list"]);
					break;
				 case "medicalscdesc":
					 $("#meditbl tbody").html("");
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
				/* case "getpacking":
					var i=0;
					var selectedImg="";
					 var txt="";
					var imgurl="";
					$.each(json["data"]["boxmedi"], function(idx, val){
						
							if(val["afThumbUrl"]!="" && val["afThumbUrl"]!="NoIMG")
							{
								imgurl=getUrlData("FILE_DOMAIN")+val["afThumbUrl"];
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
							imgurl=getUrlData("FILE_DOMAIN")+val["afThumbUrl"];
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

					break;*/
				 case "myinfodesc":
					 var chk=json["returnData"];
					 console.log("chk = " + chk);
					 console.log(json);
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
					else
					{
						if(isEmpty(type))
						{
							alert("임시저장되었습니다.");
						}
						makeorderhash("",type,seq);
					}
					break;

				 case "orderdescnext":  //다음페이지에서 상세화면 

					if(!isEmpty(json["jsondata"]))
					{
						$("textarea[name=join_jsondata]").val(json["jsondata"]);
					}

					//보내는사람구분
					var txt=checked='';
					console.log(json["reSendType"]);
					$.each(json["reSendType"], function(idx, val){
						checked="";
						if(val["cdCode"]==json["sendType"])
						{
							checked="checked";
						}

						console.log("val="+val["cdCode"]+", json="+json["sendType"]);
						txt+='<div class="inp inp-radio">';
						txt+='<label for="r'+(idx)+'" class="d-flex">';
						txt+='<input type="radio" name="sendertype" id="r'+(idx)+'" class="blind" value="'+val["cdCode"]+'" onclick="getSenderInfo()"  '+checked+'>';
						txt+='<span></span>'+val["cdName"];
						txt+='</label>';
						txt+='</div>';
					});
					$("#resendtype").html(txt);

					if(isEmpty(json["sendType"]))
					{
						$('input:radio[name=sendertype]').eq(2).attr("checked", true);
					}

					//받는사람구분 
					var txt=checked='';
					console.log(json["reReceiverType"]);
					$.each(json["reReceiverType"], function(idx, val){
						checked="";
						if(val["cdCode"]==json["receiveType"])
						{
							checked="checked";
						}
						console.log("val="+val["cdCode"]+", json="+json["receiveType"]);
						txt+='<div class="inp inp-radio">';
						txt+='<label for="q'+(idx)+'" class="d-flex">';
						txt+='<input type="radio" name="receivertype" id="q'+(idx)+'" class="blind" value="'+val["cdCode"]+'" onclick="getReceiverInfo()"  '+checked+'>';
						txt+='<span></span>'+val["cdName"];
						txt+='</label>';
						txt+='</div>';
					});
					$("#receivetype").html(txt);

					if(isEmpty(json["receiveType"]))
					{
						$('input:radio[name=receivertype]').eq(2).attr("checked", true);
					}



					$("input[name=sendName]").val(json["sendName"]);
					$("input[name=sendPhone0]").val(json["sendPhone0"]);
					$("input[name=sendPhone1]").val(json["sendPhone1"]);
					$("input[name=sendPhone2]").val(json["sendPhone2"]);
					$("input[name=sendMobile0]").val(json["sendMobile0"]);
					$("input[name=sendMobile1]").val(json["sendMobile1"]);
					$("input[name=sendMobile2]").val(json["sendMobile2"]);

					$("input[name=sendZipcode]").val(json["sendZipcode"]);
					$("input[name=sendAddress]").val(json["sendAddress"]);
					$("input[name=sendAddressDesc]").val(json["sendAddressDesc"]);



					$("input[name=receiveName]").val(json["receiveName"]);
					$("input[name=receivePhone0]").val(json["receivePhone0"]);
					$("input[name=receivePhone1]").val(json["receivePhone1"]);
					$("input[name=receivePhone2]").val(json["receivePhone2"]);

					$("input[name=receiveMobile0]").val(json["receiveMobile0"]);
					$("input[name=receiveMobile1]").val(json["receiveMobile1"]);
					$("input[name=receiveMobile2]").val(json["receiveMobile2"]);

					$("input[name=receiveZipcode]").val(json["receiveZipcode"]);
					$("input[name=receiveAddress]").val(json["receiveAddress"]);
					$("input[name=receiveAddressDesc]").val(json["receiveAddressDesc"]);


					$("input[name=receiveComment]").val(json["receiveComment"]);
					


					viewadviceview();
					viewcommentview();
					viewdecocview();
					viewrecipe();
					viewpayment();

					break;
				 case "orderdesc":  //임시처방에서 상세화면 뿌리기
					var miGrade=chkGrade(getCookie("ck_miGrade"));
					console.log("miGrade = " + miGrade);


					//getconfig
					//한의원등급에 따라서 달라져야함 
					var payMaking=parseInt(json["config"]["cfMakingprice"+miGrade]);
					var payDecoction=parseInt(json["config"]["cfDecocprice"+miGrade]);
					var payPacking=parseInt(json["config"]["cfPackingprice"+miGrade]);
					var payRelease=parseInt(json["config"]["cfReleaseprice"+miGrade]);

					var payInfirst=parseInt(json["config"]["cfFirstprice"+miGrade]);
					var payInafter=parseInt(json["config"]["cfAfterprice"+miGrade]);
					console.log("payInfirst = " + payInfirst+", payInafter="+payInafter);
 
					$("#payMaking").attr("value",payMaking).text(commasFixed(payMaking));

					$("#payMaking").attr("data-infirst",payInfirst);//선전비
					$("#payMaking").attr("data-inafter",payInafter);//후하비 


					$("#payDecoction").attr("value",payDecoction).text(commasFixed(payDecoction));
					$("#payPacking").attr("value",payPacking).text(commasFixed(payPacking));
					$("#payRelease").attr("value",payRelease).text(commasFixed(payRelease));
					var payTotal=payMaking + payDecoction + payPacking + payRelease;
					$("#payTotal").text(commasFixed(payTotal));

					//getpacking
					setGetpacking(json["packing"]);

					//orderdesc
					
					console.log("apiCode>>>>> "+json["apiCode"]);
					
					//환자정보 
					$("#meChartno").text(json["patientCode"]); //차트번호
					$("#meName").text(json["patientName"]);
					$("#meSexTxt").text(json["patientGender"]);
					$("#meBirthDay").text(json["patientBirth"]);
					$("#mePhone").text(json["patientPhone"]);
					$("#meMobile").text(json["patientMobile"]);

					if(!isEmpty(json["patientZipcode"])&&!isEmpty(json["patientAddr"]))
					{
						$("#meAddress").text("["+json["patientZipcode"]+"] "+json["patientAddr"]);//주소
					}
					else
					{
						$("#meAddress").text("");//주소
					}
					$("input[name=paZipcode]").val(json["patientZipcode"]);
					$("input[name=paAddr]").val(json["patientAddr0"]+"||"+json["patientAddr1"]);

				

					//주문정보  
					//$("input[name=medicalId]").val(json["medicalCode"]);
					$("input[name=medicalName]").val(json["medicalName"]);
					//$("input[name=doctorId]").val(json["doctorCode"]);
					$("input[name=doctorName]").val(json["doctorName"]);

					//처방정보 
					$("#chubCnt option[value="+json["chubCnt"]+"]").attr("selected", "selected");
					$("input[name=odTitle]").val(json["orderTitle"]);
					$("textarea[name=orderAdvice]").val(json["orderAdvice"]);
					$("textarea[name=orderComment]").val(json["orderComment"]);


					//옵션설정
					//팩수
					$("#packCnt option[value="+json["packCnt"]+"]").attr("selected", "selected");
					//팩용량
					$("#packCapa option[value="+json["packCapa"]+"]").attr("selected", "selected");

					//특수탕전
					$("#specialDecoc").html("");
					var txt="";
					$.each(json["dcSpecialList"], function(idx, val){
						console.log("특수탕전 ==> "+val["cdCode"]);
						var code=val["cdCode"];
						var title=val["cdName"];
						txt+='<option value="'+code+'" >'+title+'</option>';
					});
					$("#specialDecoc").html(txt);
					if(!isEmpty(json["specialDecoc"]))
					{
							console.log("특수탕전111 ==> "+json["specialDecoc"]);
						$("#specialDecoc option[value="+json["specialDecoc"]+"]").attr("selected", "selected");
					}

					//감미제
					//sweet
					$("#sweet").html("");
					var txt='<option value="">없음</option>';
					$.each(json["sugar"], function(idx, val){
						var sweetvalue=val["mdTitle"]+val["mdCapa"]+val["mdDan"];
						var sweetprice=val["mdPrice"+miGrade];//한의원등급에 따라서 달라져야함 
						txt+='<option value="'+sweetvalue+'" data-code="'+val["mdCode"]+'" data-capa="'+val["mdCapa"]+'" data-price="'+sweetprice+'">'+sweetvalue+'</option>';
					});
					$("#sweet").html(txt);

					/*
					<?php $arr=array("올리고당5g","올리고당10g","올리고당15g","자하거10ml","자하거20ml","자하거30ml");?>
					<option value="">없음</option>
					<?php for($i=0;$i<count($arr);$i++){?>
						<option value="<?=$arr[$i]?>"><?=$arr[$i]?>ml</option>
					<?php }?>
					*/




					

					//처방약재리스트
					var data=[];
					$.each(json["totalMedicine"],function(idx, val){
						console.log(val);
						data["mdCode"]=val["mediCode"];
						data["mediType"]=val["mediType"];
						data["mdTitle"]=val["mediName"];
						data["mdOrigin"]=val["mediOriginTxt"];
						data["mdPrice"]=val["mediAmount"];
						data["mediCapa"]=val["mediCapa"];
						addmeditbl(data);
					});

					//|HD017602KR0001J,올리고당10g,10
					//감미제 
					var swcode=swname=swcapa="";
					
					$.each(json["sweetMedi"],function(idx, val){
						if(!isEmpty(val["sweetCode"]))
						{
							swcode=val["sweetCode"];
							swname=val["sweetName"];
							swcapa=val["sweetCapa"];
							swprice=val["sweetPrice"];
							
							console.log("감미제 =====>>>>>>  swcode = "+swcode+", swname= " + swname+", swcapa = " + swcapa+",swprice="+swprice);
						}
					});

					if(!isEmpty(swname))
					{
						$("#sweet option[value="+swname+"]").attr("selected", "selected");
					}

					

					//박스
					changeboxmedi(json["odmedibox"],json["odmediboxtitle"],json["odmediboxprice"]);
					//파우치 
					changepacktype(json["odpacktype"],json["odpacktypetitle"],json["odpacktypeprice"]);



					$("#payMedicine").text(json["amountMedicine"]);  //약제비
					$("#payMaking").text(json["amountPharmacy"]);  //조제비
					$("#payDecoction").text(json["amountDecoction"]);  //탕전료
					$("#payPacking").text(json["amountPackaging"]);  //포장비
					$("#payRelease").text(json["amountDelivery"]);  //배송비
					
					$("#payTotal").text(json["amountTotal"]);  //합계

					$("input[name=medicalkeycode]").val(json["keycode"]);
					$("input[name=medicalseq]").val(json["seq"]);

					if(!isEmpty(json["jsondata"]))
					{
						$("textarea[name=join_jsondata]").val(json["jsondata"]);
					}

					resetCnt();


				break;
			}
		}
		else if(json["resultCode"]!="404")
		{
			alert(json["resultMessage"]+"("+json["resultCode"]+")");
			return false;
		}
	}


/*
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
	*/


	function addpatient(){
		location.href="/Patient/?p=mod";
	}
	function capakeydown(event)
	{
		if(event.keyCode==13)
		{
			$('input[name=searchmedi]').focus();
		}
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
				txt+="<td class='d-flex product-name'>";
				//txt+="<div class='d-flex product-name'>";
				txt+=json["mdTitle"];
				//txt+="</div>";
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
				txt+="<input type='text' name='capa' placeholder='' value='"+mediCapa+"' class='schubamt' onkeyup='resetCnt()'  onkeydown='capakeydown(event)' onfocus='this.select();' onchange='onlynumber(event, true);' maxlength='6'>";
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
				txt+="<select name='mediType' id='' onchange='resetCnt()'>";
				//var carr=["infirst","inmain","inafter","inlast"];
				//var tarr=["선전","일반","후하","별전"];
				var carr=["infirst","inmain","inafter"];
				var tarr=["선전","일반","후하"];
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
			setTimeout("$('input[name=capa]').focus();",300);
			setTimeout("resetCnt()",300);
			initialize_table();
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
		var chubcnt=parseFloat($("select[name=chubCnt]").val());
		var packCnt=parseFloat($("select[name=packCnt]").val());
		var totchubcapa=totcapa=totmedicine=0;
		var infirst=inafter=0;
		var chubprice=chubpricetotal=0;
		$("#meditbl tbody tr").each(function(idx, val){
			$(this).children("td").eq(1).text(idx+1);
			var chubcapa=parseFloat($(this).children("td").eq(4).children(".gram").children(".inp").children("input").val());
			if(chubcapa==undefined)chubcapa=0;
			if(isNaN(chubcapa)==true)chubcapa=0;
			var tcapa=chubcnt * chubcapa;
			//console.log("chubcapa   >>>  "+chubcapa);
			//console.log("tcapa   >>>  "+tcapa);
			$(this).children("td").eq(5).children(".gram").children(".inp").children("input").val(tcapa);
			var unit=parseFloat($(this).children("td").eq(6).children(".amount").attr("value"));
			if(unit==undefined)unit=0;
			if(isNaN(unit)==true)unit=0;
			var amount = tcapa * unit;
			$(this).children("td").eq(6).html("<span class='amount' value='"+unit+"'>"+amount+"</span><span class='won'>원</span>");
			var meditype=$(this).children("td").eq(7).children(".inp-select").children("select").val();
			console.log(meditype);
			if(!isEmpty(meditype)&&meditype=="infirst")
			{
				infirst++;
			}
			if(!isEmpty(meditype)&&meditype=="inafter")
			{
				inafter++;
			}

			chubprice=chubcapa*unit;
			chubpricetotal+=chubprice;

			console.log("약재추가 >>> "+chubcapa+"_"+tcapa+"_"+unit+"_"+amount+", chubprice="+chubprice+", chubpricetotal="+chubpricetotal);

			totchubcapa+=chubcapa;
			totcapa+=tcapa;
			totmedicine+=amount;
		});
		var payMaking=parseInt($("#payMaking").attr("value"));
		var totmaking=payMaking * packCnt;//조제비 
		$("input[name=infirstamount]").val(0);
		$("input[name=inafteramount]").val(0);
		if(infirst>0)
		{
			$("input[name=infirstamount]").val($("#payMaking").attr("data-infirst"));
		}
		if(inafter>0)
		{
			$("input[name=inafteramount]").val($("#payMaking").attr("data-inafter"));
		}

		var totinfirst=totinafter=0;
		totinfirst=parseInt($("input[name=infirstamount]").val());
		totinafter=parseInt($("input[name=inafteramount]").val());

		totmaking+=(totinfirst+totinafter);

		console.log("resetCntresetCntresetCntresetCntresetCntresetCntresetCnt  totmaking= "+totmaking);


		$("#totChubcapa").html(totchubcapa+"<span>g</span>");
		$("#totCapa").html(totcapa+"<span>g</span>");
		$("#totAmount").html(totmedicine+"<span>원</span>");

		//감미제
		var packCapa=$("select[name=packCapa]").val();
		


		var sweetcapa=$("select[name=sweet]").children("option:selected").data("capa");
		sweetcapa=!isEmpty(sweetcapa)?sweetcapa:"0";
		var sweetprice=$("select[name=sweet]").children("option:selected").data("price");
		sweetprice=!isEmpty(sweetprice)?sweetprice:"0";
		console.log("sweetprice = " + sweetprice);


		var totsweet=(packCnt*packCapa)*(sweetcapa/100);


		var swtotprice=0;
		$("#paySweet").text("");
		$("#idSweet").hide();
		if(parseInt(sweetprice)>0)
		{
			swtotprice=parseInt(sweetprice)*parseInt(totsweet);
			$("#idSweet").show();
			$("#paySweet").html(commasFixed(swtotprice));
		}
		console.log("### 감미제 sweetcapa = "+sweetcapa+", sweetprice = " + sweetprice+", swtotprice = " + swtotprice);




		$("#payMedicine").html(commasFixed(totmedicine));  //약재비
		$("#payMaking").html(commasFixed(totmaking));  //조제비 
		var payTotal=totmedicine;
		var payDecoction=$("#payDecoction").attr("value");//탕전비
		var payPacking=$("#payPacking").attr("value");//포장비 
		var payRelease=$("#payRelease").attr("value");//배송비 

		var payTotal=parseFloat(totmedicine) + parseFloat(totmaking) + parseFloat(payDecoction) + parseFloat(payPacking) + parseFloat(payRelease) + parseFloat(swtotprice);



		console.log("totmedicine = " + totmedicine+", totmaking = " + totmaking+", payDecoction = "+payDecoction+", payPacking = " +payPacking + ", payRelease = " + payRelease + ", payTotal = " + payTotal);
		$("#payTotal").html(commasFixed(payTotal));
	}

	function changeboxmedi(val,title,price)
	{
		console.log("changeboxmedi  val="+val+", title = " +title+", price = "+price);
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
		console.log("changepacktype  val="+val+", title = " +title+", price = "+price);
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

	function setprevdata()
	{
		var json=JSON.parse($("textarea[name=join_jsondata]").val());

		console.log("setprevdatasetprevdatasetprevdatasetprevdata  dir = " + dir);

		//$("input[name=medicalId]").val(json["orderInfo"][0]["medicalCode"]);
		$("input[name=medicalName]").val(json["orderInfo"][0]["medicalName"]);
		//$("input[name=doctorId]").val(json["orderInfo"][0]["doctorCode"]);
		$("input[name=doctorName]").val(json["orderInfo"][0]["doctorName"]);
		$("input[name=odTitle]").val(json["orderInfo"][0]["orderTitle"]);
		$("textarea[name=orderAdvice]").val(json["orderInfo"][0]["orderAdvice"]);
		$("textarea[name=orderComment]").val(json["orderInfo"][0]["orderComment"]);


		//환자정보 
		$("#meChartno").text(json["patientInfo"][0]["patientCode"]);
		$("#meName").text(json["patientInfo"][0]["patientName"]);
		$("#meSexTxt").text(json["patientInfo"][0]["patientGender"]);
		$("#meBirthDay").text(json["patientInfo"][0]["patientBirth"]);
		$("#mePhone").text(json["patientInfo"][0]["patientPhone"]);
		$("#meMobile").text(json["patientInfo"][0]["patientMobile"]);
		$("input[name=paZipcode]").val(json["patientInfo"][0]["patientZipcode"]);
		$("input[name=paAddr]").val(json["patientInfo"][0]["patientAddr"]);



/*

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
		*/
	}
	function chkMedicineCapa()
	{
		var chk="Y";
		$(".schubamt").each(function(){
			console.log("schubamt  : "+$(this).val());
			var val=$(this).val();
			if(isEmpty(val) || parseFloat(val)==0)
			{
				chk="N";
			}
		});

		if(chk=="N")
		{
			return false;
		}

		return true;
	}
	function saveOrder(dir){
		//DOO:: 여기에서 jsondata를 말자 

		//alert("saveOrder 임시저장/다음단계 dir = " + dir);
		var json=JSON.parse($("textarea[name=join_jsondata]").val());
		console.log($("#meChartno").text());

		var medicalseq=$("input[name=medicalseq]").val();

		console.log("saveOrder  dir = "+dir+", medicalseq = " + medicalseq);

		var keycode=$("input[name=medicalkeycode]").val();//json["orderInfo"][0]["keycode"];
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

		console.log("################   keycode = " + keycode);

		json["orderInfo"][0]["keycode"]=keycode;//주문코드, 부산대주문코드

		if(dir=="" || dir=="next")//임시저장이거나 다음단계
		{
			orderStatus="temp";

			var odpacktype=$("input[name=odpacktype]").val();
			var odmedibox=$("input[name=odmedibox]").val();
			var medicount=$("#meditbl tbody tr").length;
			var mechartno=$("#meChartno").text();
			var odtitle=$("input[name=odTitle]").val();

			if(isEmpty(mechartno))
			{
				alert("환자를 선택해 주세요.");
				return;
			}


			if(isEmpty(medicount) || medicount<=0)
			{
				alert("약재를 선택해 주세요.");
				return;
			}

			if(chkMedicineCapa()==false)
			{
				alert("약재의 첩량을 입력해 주세요.");
				return;
			}

			if(isEmpty(odtitle))
			{
				alert("처방명을 입력해 주세요.");
				return;
			}

			if(dir!="")
			{
				if(isEmpty(odpacktype))
				{
					alert("파우치를 선택해 주세요.");
					return;
				}

				if(isEmpty(odmedibox))
				{
					alert("한약박스를 선택해 주세요.");
					return;
				}
			}
		
			var medicalId=$("input[name=medicalId]").val();
			var medicalName=$("input[name=medicalName]").val();
			var doctorId=$("input[name=doctorId]").val();
			var doctorName=$("input[name=doctorName]").val();
			var odTitle=$("input[name=odTitle]").val();
			var orderAdvice=$("textarea[name=orderAdvice]").val();
			var orderComment=$("textarea[name=orderComment]").val();
			var orderStatus=json["orderInfo"][0]["orderStatus"];

			medicalId=!isEmpty(medicalId)?medicalId:getCookie("ck_miUserid");
			medicalName=!isEmpty(medicalName)?medicalName:getCookie("ck_miName");
			doctorId=!isEmpty(doctorId)?doctorId:getCookie("ck_meUserId");
			doctorName=!isEmpty(doctorName)?doctorName:getCookie("ck_meName");
			
			//주문정보
			json["orderInfo"][0]["keycode"]=keycode;//주문코드, 부산대주문코드
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
			json["patientInfo"][0]["patientPhone"]=$("#mePhone").text();
			json["patientInfo"][0]["patientMobile"]=$("#meMobile").text();
			json["patientInfo"][0]["patientZipcode"]=$("input[name=paZipcode]").val();
			json["patientInfo"][0]["patientAddr"]=$("input[name=paAddr]").val();


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
			var sdarr=new Array();
			var sweetcode=$("select[name=sweet]").children("option:selected").data("code");
			var sweettitle=$("select[name=sweet]").val();
			var sweetcapa=$("select[name=sweet]").children("option:selected").data("capa");
			var sweetprice=$("select[name=sweet]").children("option:selected").data("price");
			console.log("### 감미제 sweetcode = "+sweetcode+", sweettitle = " + sweettitle+", sweetcapa = " + sweetcapa+", sweetprice = " + sweetprice);
			var sdata={}; 
			sdata["sweetCode"]=sweetcode;
			sdata["sweetName"]=sweettitle;
			sdata["sweetCapa"]=sweetcapa;
			sdata["sweetPrice"]=sweetprice;
			sdarr.push(sdata);
			json["recipeInfo"][0]["sweetMedi"]=sdarr;


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
			var paysweet=$("#paySweet").text();
			paysweet=!isEmpty(paysweet)?paysweet:0;
			json["paymentInfo"][0]["amountTotal"]=$("#payTotal").text().replace(/\,/gi,'');
			json["paymentInfo"][0]["amountMedicine"]=$("#payMedicine").text();
			json["paymentInfo"][0]["amountSweet"]=paysweet;
			json["paymentInfo"][0]["amountPharmacy"]=$("#payMaking").text();
			json["paymentInfo"][0]["amountDecoction"]=$("#payDecoction").text();
			json["paymentInfo"][0]["amountPackaging"]=$("#payPacking").text();
			json["paymentInfo"][0]["amountDelivery"]=$("#payRelease").text();
			json["paymentInfo"][0]["amountInfirst"]=$("input[name=infirstamount]").val();//선전비
			json["paymentInfo"][0]["amountInafter"]=$("input[name=inafteramount]").val();//후하비 


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
		else if(dir=="prev" || dir=="cart")//접수 
		{
			var regExpPhone = /^\d{2,3}-\d{3,4}-\d{4}$/;
			var regExpMobile = /^\d{3}-\d{3,4}-\d{4}$/;
			var regExpMobile2 = /^01([0|1|6|7|8|9]?)-?([0-9]{3,4})-?([0-9]{4})$/;

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
				return;
			}

			if (!regExpPhone.test(receivePhone)) 
			{
				alert("잘못된 수신인 전화번호입니다.");
				return;
			}

			if (!regExpMobile.test(receiveMobile)) 
			{
				alert("잘못된 수신인 휴대전화번호입니다.");
				return;
			}

			//if (!regExpMobile2.test(receiveMobile)) 
			//{
			//	alert("잘못된 수신인 휴대전화번호입니다.");
			//	return;
			//}

				

			if(isEmpty(receiveZipcode))
			{
				alert("수신인 우편번호가 없습니다.");
				return;
			}
			if(isEmpty(receiveAddress))
			{
				alert("수신인 주소가 없습니다.");
				return;
			}
			if(isEmpty(receiveAddressDesc))
			{
				alert("수신인 상세주소가 없습니다.");
				return;
			}

			//보내는사람
			var sendName=$("input[name=sendName]").val();
			var sendZipcode=$("input[name=sendZipcode]").val();
			var sendAddress=$("input[name=sendAddress]").val();
			var sendAddressDesc=$("input[name=sendAddressDesc]").val();

			var sendPhone0=$("input[name=sendPhone0]").val();
			var sendPhone1=$("input[name=sendPhone1]").val();
			var sendPhone2=$("input[name=sendPhone2]").val();
			var sendPhone=sendPhone0+"-"+sendPhone1+"-"+sendPhone2;

			var sendMobile0=$("input[name=sendMobile0]").val();
			var sendMobile1=$("input[name=sendMobile1]").val();
			var sendMobile2=$("input[name=sendMobile2]").val();
			var sendMobile=sendMobile0+"-"+sendMobile1+"-"+sendMobile2;


			if(isEmpty(sendName))
			{
				alert("발신인 이름이 없습니다.");
				return;
			}
			if (!regExpPhone.test(sendPhone)) 
			{
				alert("잘못된 발신인 전화번호입니다.");
				return;
			}

			if (!regExpMobile.test(sendMobile)) 
			{
				alert("잘못된 발신인 휴대전화번호입니다.");
				return;
			}

			//if (!regExpMobile2.test(sendMobile)) 
			//{
			//	alert("잘못된 발신인 휴대전화번호입니다.");
			//	return;
			//}

			if(isEmpty(sendZipcode))
			{
				alert("발신인 우편번호가 없습니다.");
				return;
			}
			if(isEmpty(sendAddress))
			{
				alert("발신인 주소가 없습니다.");
				return;
			}
			if(isEmpty(sendAddressDesc))
			{
				alert("발신인 상세주소가 없습니다.");
				return;
			}





			if(dir=="prev")//이전단계
			{
				orderStatus="temp";
			}
			else
			{
				orderStatus="cart";
			}






			json["orderInfo"][0]["orderStatus"]=orderStatus;//주문상태 cart(장바구니),paid(결재완료),done(등록완료)

			
			

			json["deliveryInfo"][0]["deliType"]="post"; //배송종류 direct(직배), post(택배)
			json["deliveryInfo"][0]["sendName"]=sendName; //보내는사람
			json["deliveryInfo"][0]["sendPhone"]=sendPhone0+"-"+sendPhone1+"-"+sendPhone2; //보내는사람 전화번호
			json["deliveryInfo"][0]["sendMobile"]=sendMobile0+"-"+sendMobile1+"-"+sendMobile2; //보내는사람 휴대폰번호
			json["deliveryInfo"][0]["sendZipcode"]=sendZipcode; //보내는사람 우편번호
			json["deliveryInfo"][0]["sendAddress"]=sendAddress; //보내는사람 주소
			json["deliveryInfo"][0]["sendAddressDesc"]=sendAddressDesc; //보내는사람 상세주소

			json["deliveryInfo"][0]["receiveName"]=receiveName; //받는사람
			json["deliveryInfo"][0]["receivePhone"]=receivePhone0+"-"+receivePhone1+"-"+receivePhone2; //받는사람 전화번호
			json["deliveryInfo"][0]["receiveMobile"]=receiveMobile0+"-"+receiveMobile1+"-"+receiveMobile2; //받는사람 휴대폰번호
			json["deliveryInfo"][0]["receiveZipcode"]=receiveZipcode; //받는사람 우편번호
			json["deliveryInfo"][0]["receiveAddress"]=receiveAddress; //받는사람 주소
			json["deliveryInfo"][0]["receiveAddressDesc"]=receiveAddressDesc; //받는사람 상세주소
			json["deliveryInfo"][0]["receiveComment"]=$("input[name=receiveComment]").val();; //배송요구사항
			json["deliveryInfo"][0]["receiveTied"]=""; //묶음배송마스터주문코드 (부산대주문코드)
			json["deliveryInfo"][0]["sendType"]=$("input[name=sendertype]:checked").val();
			json["deliveryInfo"][0]["receiveType"]=$("input[name=receivertype]:checked").val();

			console.log("################  saveorder receivePhone = " + receivePhone+", receiveMobile = " + receiveMobile);
			
		}

		//임시저장, 다음단계, 접수에도 저장하자! 


		console.log(json);
		$("textarea[name=join_jsondata]").val(JSON.stringify(json));

		orderupdate(dir);

	}

	//처방정보 빛 주문 > 보내는사람
	function getSenderInfo()
	{	
		var chk=$("input[name=sendertype]:checked").val();
		var medicalid=$("input[name=medicalId]").val();
		console.log("medicalid = "+medicalid+", chk = " + chk);
	
		switch(chk){
			case "medical":  //의료기관
				var data="apiCode=myinfodesc&language=kor&returnData=sender&medicalid="+medicalid;
				callapi("GET","/medical/member/",data);
				break;
			case "base": //탕전원
				$(".sender").val("");
				$("input[name=sendName]").val("부산대학교한방병원원외탕전실");

				$("input[name=sendPhone0]").val("055");
				$("input[name=sendPhone1]").val("360");
				$("input[name=sendPhone2]").val("5520");

				$("input[name=sendMobile0]").val("055");
				$("input[name=sendMobile1]").val("360");
				$("input[name=sendMobile2]").val("5520");

				$("input[name=sendZipcode]").val("50612");

				$("input[name=sendAddress]").val("경상남도 양산시 물금읍 금오로 20");
				$("input[name=sendAddressDesc]").val("부산대학교한방병원 원외탕전실");
				break;
			default: //새로입력
				$(".sender").val("");
		}
	}
	function getReceiverInfo(){
		var chk=$("input[name=receivertype]:checked").val();
		var medicalid=$("input[name=medicalId]").val();
		console.log("medicalid = "+medicalid);
		switch(chk){
			case "medical":
				var data="apiCode=myinfodesc&language=kor&returnData=receiver&medicalid="+medicalid;
				callapi("GET","/medical/member/",data);
				break;
			case "patient":
					var json=$("textarea[name=join_jsondata]").val();
					var obj = JSON.parse(json);
					var receive=obj["patientInfo"];
					console.log(receive);
					$(".receive").val("");
					$("input[name=receiveName]").val(receive[0]["patientName"]);
					console.log(receive[0]["patientPhone"])
					var parr=receive[0]["patientPhone"].split("-");
					console.log(parr);
					$("input[name=receivePhone0]").val(parr[0]);
					$("input[name=receivePhone1]").val(parr[1]);
					$("input[name=receivePhone2]").val(parr[2]);
					var marr=receive[0]["patientMobile"].split("-");

					$("input[name=receiveMobile0]").val(marr[0]);
					$("input[name=receiveMobile1]").val(marr[1]);
					$("input[name=receiveMobile2]").val(marr[2]);


					var patientZipcode=receive[0]["patientZipcode"];
					var aarr=receive[0]["patientAddr"].split("||");;

					$("input[name=receiveZipcode]").val(patientZipcode);
					$("input[name=receiveAddress]").val(aarr[0]);
					$("input[name=receiveAddressDesc]").val(aarr[1]);
				break;
			default:
				$(".receive").val("");
		}
	}

	function mediBtn(type){
		switch(type){
			case "recipe":
				$("input[name=searchmedi]").val("");
				$("#searchtab").attr({"name":"searchrecipe","placeholder":"빠른 처방 추가","onkeyup":"searchkeyup('searchrecipe',event)"});
				$("#recipeBtn").addClass("border-gray");
				$("#mediBtn").removeClass("border-gray");
				//$("#mediBtn").text("약재추가").attr("href","javascript:mediBtn('medi');").removeClass("bg-blue").addClass("bg-red");
				break;
			case "medi":
				$("input[name=searchrecipe]").val("");
				$("#searchtab").attr({"name":"searchmedi","placeholder":"빠른 약재 추가","onkeyup":"searchkeyup('searchmedi',event)"});
				//$("#mediBtn").text("처방추가").attr("href","javascript:mediBtn('recipe');").removeClass("bg-red").addClass("bg-blue");
				$("#recipeBtn").removeClass("border-gray");
				$("#mediBtn").addClass("border-gray");
				break;
		}
	}
	function chkmyall()
	{
		console.log("chkmyallchkmyallchkmyall");
		$("#tbl tbody tr th input:checkbox[name=chkmyall]").prop("checked",true);
		$("#tbl tbody tr").each(function(){
			$(this).children("td").eq(0).find("input").prop("checked",true);
		});
	}
	function clearmycheck()
	{
		$("#tbl tbody tr").each(function(){
			$(this).children("td").eq(0).find("input").prop("checked",false);
		});
		$("#tbl tbody tr th input:checkbox[name=chkmyall]").prop("checked",false);
	}
	function addmyrecipe()
	{
		console.log("addmyrecipeaddmyrecipeaddmyrecipeaddmyrecipe");
		if(confirm("나의처방으로 등록하시겠습니까?"))
		{
			var seqdata="";
			$("#tbl tbody tr").each(function(){
				var val=$(this).children("td").eq(0).find("input").prop("checked");
				if(val==true)
				{
					var rcseq=$(this).children("td").eq(0).find("input").data("rcseq");
					seqdata+=","+rcseq;
				}
			});

			console.log("seqdata = " + seqdata);

			var txt="<input type='hidden' class='ajaxdata' name='seqdata' value='"+seqdata+"'>";
			$("body").prepend(txt);
			callapi("POST","/medical/recipe/",getdata("myrecipeupdate"));
			$("input[name=seqdata]").remove();
		}		
	}
	function delmyrecipe()
	{
		console.log("delmyrecipedelmyrecipedelmyrecipe");
		if(confirm("삭제하시겠습니까?"))
		{
			var seqdata="";
			$("#tbl tbody tr").each(function(){
				var val=$(this).children("td").eq(0).find("input").prop("checked");
				if(val==true)
				{
					var seq=$(this).children("td").eq(0).find("input").data("seq");
					seqdata+=","+seq;
				}
			});

			console.log("seqdata = " + seqdata);
			var txt="<input type='hidden' class='ajaxdata' name='seqdata' value='"+seqdata+"'>";
			$("body").prepend(txt);
			callapi("POST","/medical/recipe/",getdata("myrecipedelete"));
			$("input[name=seqdata]").remove();
		}
	}