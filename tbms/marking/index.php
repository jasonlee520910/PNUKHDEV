<?php
	$root="..";
	include_once $root."/_common.php";
	include_once $root."/_Inc/head.php";
	$apiData="depart=".$depart;
	$tbmsip = $_SERVER['REMOTE_ADDR'];
?>
<style>
	div.requestdiv{overflow:hidden;background:#ccc;width:1200px;height:560px;padding:0 5px 0 5px;}
	div.requestdiv div{float:left;width:1160px;height:360px;text-align: left;overflow-y:auto;}
	.requesttitle{width:auto;background:#fff;color:green;font-size:30px;padding:10px 0;margin:20px;text-align:center;font-weight:bold;}
	.requestcontent{display:block;background:#fff;float:left;text-align:center;width:17%;margin:10px 20px;padding:0;font-size:27px;font-weight:bold;line-height:1.5em;}
	.reuqestok{float:right;width:250px;height:50px;background:green;color:white;font-size:30px;padding:10px 0;margin:0 20px;text-align:center;font-weight:bold;}

	h3.mrprint{color:yellow;font-size:20px;font-weight:bold;}
	dl.mrprint{width:100%;}
	dl.mrprint dd{float:left;width:257px;height:240px;margin:10px;padding:0;cursor:pointer;background:url("../_Img/makingtable11.png") no-repeat;text-align:center;opacity:0.7;}
	dl.mrprint dd span{display:block;margin-top:190px;color:#fff;font-size:15px;}
	dl.mrprint dd:hover{opacity:1.0;}
</style>
<div class="page">
	<?php include_once $root."/_Inc/left.php"; ?>
	<div class="container" id="containerDiv" value="<?=$depart?>" data-value="<?=$markingprocess?>">
		<div class="section_marking" >
			<?php include_once $root."/_Inc/navi.php"; ?>
			<div style="display:none">
			<input type="hidden" id="reDeliexception" name="reDeliexception" value="" style="color:#fff;border:1px solid #fff;" />
			<input type="hidden" id="reDelicomp" name="reDelicomp" value="" style="color:#fff;border:1px solid #fff;" />
			<input type="hidden" id="mobile" name="mobile" value="" style="color:#fff;border:1px solid #fff;" />
			<input type="hidden" id="reBoxmedicnt" name="reBoxmedicnt" value="" style="color:#fff;border:1px solid #fff;" />
			
			
			</div>
			<section id="marking" value="<?=$_COOKIE["ck_mrPrinter"]?>" data-step="">
				<ol class="sect_step" id="step_info"></ol>
				<div id="maindiv"></div>
			</section>
		</div>
	</div>
</div>
<textarea name="odRequest" id="odRequest" cols="500" rows="5" style="display:none"></textarea>
<?php include_once $root."/_Inc/tail.php"; ?>
<script>$("#mainbarcode").focus();</script>
<script>
	function addDeliveryPrint()
	{
		console.log("?????? ?????? ????????????!!!!!!!!!!!!!!!!!!!!!!!!");
		var code=$("#ordercode").attr("value");
		var type="POST";			
		var delicomp=$("input[name=reDelicomp]").val();
		var deliexception=$("input[name=reDeliexception]").val();
		console.log("code = "+code+", delicomp = " + delicomp+", deliexception = " + deliexception);
		window.open("document.deliprint.php?odCode="+code+"&type="+type+"&deliexception="+deliexception+"&delicomp="+delicomp+"&addprint=R", "proc_report_deli","width=800,height=500");//ok  -??????. ????????? ?????????.
	}
	function setRequestPopup()
	{
		var h=$(window).height();
		var content=$("textarea[name=odRequest]").val();
		var txt="<div id='requestscreen' style='position:fixed;width:100%;top:0;background:#000;opacity:0.4;height:"+h+"px; z-index:999;'></div><div id='makingtblestatdiv' style='position:absolute;width:100%;z-index:1000;' onclick='requestOnClick();'><div id='requeststat' style='position:relative;width:1200px;max-height:400px;margin:150px auto;padding:0;background:#fff;'><div class='requestdiv' id='requestdiv'><p class='requesttitle'><?=$txtdt['reqorder']?></p><div class='requestcontent' id='requestcontent'>"+content+"</div><p class='reuqestok'><?=$txtdt['confirm']?></p></div></div></div>";
		$("body").prepend(txt);
	}

	function requestOnClick()
	{
		$("#makingtblestatdiv").remove();
		$("#requestscreen").remove();
		$("#mainbarcode").focus();
	}

	var timer="";
	function getpouchcnt()
	{
		var code=$("#ordercode").attr("value");
		var mrPrinter=$("#marking").attr("value");
		var packcnt=parseInt($("#packcnt").data("value"));
		var pouchcnt=parseInt($("#pouchcnt").val());
		var jsondata={};
		console.log("getpouchcnt packcnt = " + packcnt + ", pouchcnt = " + pouchcnt);		

		//--------------------------------------
		//????????? ???????????? API ??????
		//--------------------------------------
		jsondata["odCode"] = code;
		jsondata["mrPrinter"] = mrPrinter;
		jsondata["odCount"]=pouchcnt;

		console.log(JSON.stringify(jsondata));
		callapi('POST','marking','markingcountupdate',jsondata);
		//--------------------------------------

		var ip=getCookie("ck_mrPrinterIP");
		var port=getCookie("ck_mrPrinterPort");

		var tbmsip="<?=$tbmsip;?>";
		alert("tbmsip = " + tbmsip);
		if(tbmsip=="59.7.50.122")
		{
			markingwork("/_Lib/markingprt/markingwork.php?work=markingcount&ip="+ip+"&port="+port);	
		}
		else
		{
			callmarkingapi("apiCode=markingcount&ip="+ip+"&port="+port);
		}

		var no=$("#step_info").find("li.on").index();
		console.log("getpouchcnt no = " + no);

		if((pouchcnt>=packcnt) && no==3)
		{
			//--------------------------------------
			//????????? ???????????? API ??????
			//--------------------------------------
			jsondata["odCode"] = code;
			jsondata["mrPrinter"] = mrPrinter;

			console.log(JSON.stringify(jsondata));
			callapi('POST','marking','markingfinishupdate',jsondata);
			//--------------------------------------
			//?????? ?????? ??? ???????????? ??????
			layersign("success",getTxtdt("step44"),'','1000');//????????? ?????????????????????.
			
			setTimeout(function(){
				nextstep();
				$('#status_txt').text(getTxtdt('step50'))
				;$('#marking').data('step','1');
			},1000);

		}
		else if(no==4)
		{
			var stepchk=$("#marking").data("step");
			console.log("stepchk = " + stepchk);
			if(!isEmpty(stepchk) && stepchk=='1')
			{
				$('#marking').data('step','4'); 
				layersign("success",getTxtdt("step50"), "",'confirm_marking');//????????? ?????? ??? ??????????????? ???????????? - ??????
			}
		}
		else if(no==5)
		{
			var stepchk=$("#marking").data("step");
			console.log("stepchk = " + stepchk);
			if(!isEmpty(stepchk) && stepchk=='5')
			{
				setDeliPrint();
			}

		}

	}
	function showDeliPrint()
	{
		var code=$("#ordercode").attr("value");
		var delicomp=$("input[name=reDelicomp]").val();
		var deliexception=$("input[name=reDeliexception]").val();

		console.log("delicomp = " + delicomp+", deliexception = " + deliexception+", reBoxmedicnt = " + reBoxmedicnt);
		window.open("document.deliprint.php?odCode="+code+"&deliexception="+deliexception+"&delicomp="+delicomp, "proc_report_deli","width=800,height=500");//ok  -??????. ????????? ?????????.
	}
	function setDeliPrint()
	{
		var no=$("#step_info").find("li.on").index();
		console.log("setDeliPrint  no = " + no);

		workerconfirm("<?=$txtdt['9039']?>");

		//if(no==5)
		{
			$("#transid").show();
			$("#adddeli").show();
			$("#status_txt").text(getTxtdt("step60"));
			$('#marking').data('step','6'); 

			var code=$("#ordercode").attr("value");
			var type="POST";			
			var delicomp=$("input[name=reDelicomp]").val();
			var deliexception=$("input[name=reDeliexception]").val();
			var reBoxmedicnt=$("input[name=reBoxmedicnt]").val();
			console.log("delicomp = " + delicomp+", deliexception = " + deliexception+", reBoxmedicnt = " + reBoxmedicnt);

			//20190816:release?????? marking?????? ???????????? 
			//20190618 : checkprocess ???????????? releasemain ???????????? ??????????????? ???????????? 
			//20190902 : ?????? ?????????????????? ?????? ???????????? ?????? ???????????? ?????? 
			//20191017 : ?????? ?????? ?????? 
			//
			//?????????????????? reBoxmedicnt ??? ?????? ?????? 
			if(delicomp.toUpperCase()=="POST" && !isEmpty(reBoxmedicnt)&&parseInt(reBoxmedicnt)<=0)
			{
				if (!isEmpty(deliexception)&&deliexception.indexOf("O") != -1 || !isEmpty(deliexception)&&deliexception.indexOf("T") != -1 || !isEmpty(deliexception)&&deliexception.indexOf("D") != -1)
				{
					window.open("document.deliprint.php?odCode="+code+"&type="+type+"&deliexception="+deliexception+"&delicomp="+delicomp, "proc_report_deli","width=800,height=500");//ok  -??????. ????????? ??????
				}
				else
				{
					window.open("document.delicnt.php?odCode="+code, "proc_delicnt_deli","width=800,height=500");//ok  -??????. ????????? ?????????.
				}
			}
			else
			{
				window.open("document.deliprint.php?odCode="+code+"&type="+type+"&deliexception="+deliexception+"&delicomp="+delicomp, "proc_report_deli","width=800,height=500");//ok  -??????. ????????? ?????????.
			}
		}
	}
	
	function parentdelClose()
	{
		console.log("parentdelCloseparentdelCloseparentdelClose");
		gotostep(6);
		//nextstep();
		$("#mainbarcode").focus();
	}
	function intrevalprint()
	{
		closelayer();
		printID=setInterval("getpouchcnt()",2000);
		console.log("intrevalprint printID = " + printID);
	}
	function startmarking()
	{

		var imgfrontclick=$("#imgfront").data("value");
		console.log("imgfrontclick ==== " + imgfrontclick);
		if(isEmpty(imgfrontclick))
		{
			$("#imgfront").data("value", "1");

			var markingprt="<?=$markingprt?>";
			var markingtxt=$(".pouch_txt dl dd").text();
			var code=$("#ordercode").attr("value");
			console.log("startmarking markingprt = " + markingprt+", markingtxt = " + markingtxt+", code = " + code);

			//DOO :: 20181029 ??????????????? ?????? true, ????????? false 
			if(markingprt == "false") //??????????????? ??????????????? 
			{
				gotostep(4);
				setTimeout("delaylayer()",200);
				setTimeout("nextstep()",5000);
				setTimeout("setDeliPrint()",6000);
				
			}
			else
			{
				var staffid=getCookie("ck_stStaffid");

				/*if(!isEmpty(staffid) && staffid =="MEM190529105708" || !isEmpty(staffid) && staffid =="MEM190529110943")
				{
					gotostep(4);
					setTimeout("delaylayer()",200);
					setTimeout("nextstep()",5000);
					setTimeout("setDeliPrint()",6000);
				}
				else
				{
				if(markingtxt!="" && markingtxt!="No Marking")
				{*/
					//--------------------------------------
					//??????????????? ????????? ????????? ??????????????? start log ????????? 
					//--------------------------------------
					var jsondata={};
					var mrPrinter=$("#marking").attr("value");

					jsondata["odCode"] = code;
					jsondata["staffid"] = getCookie("ck_ntStaffid");
					jsondata["mrPrinter"] = mrPrinter;

					console.log(JSON.stringify(jsondata));
					callapi('POST','marking','markingstartupdate',jsondata);
					//--------------------------------------
					var medical=encodeURI($("#procmember dl dd em").eq(0).text());
					var patient=encodeURI($("#procuser dl dd em.name").text());
					var prtype=$("#markingtxt").attr("data-desc");
					//layersign("info","?????? ????????? ??????","?????? ????????? ?????? ??? ?????????. ?????? ????????? ?????????","unlimit");
					layersign("info",getTxtdt("steptprt"),getTxtdt("stepcprt"),"unlimit");

					var ip=getCookie("ck_mrPrinterIP");
					var port=getCookie("ck_mrPrinterPort");

					var mobile=$("input[name=mobile]").val();
					console.log("mobile = " + mobile);

					var tbmsip="<?=$tbmsip;?>";
					//alert("tbmsip = " + tbmsip);
					if(tbmsip=="59.7.50.122")
					{
						markingwork("/_Lib/markingprt/markingwork.php?work=markingsetting&code="+code+"&medical="+medical+"&patient="+patient+"&prtype="+prtype+"&ip="+ip+"&port="+port+"&mobile="+mobile);
					}
					else
					{
						callmarkingapi("apiCode=markingsetting&code="+code+"&medical="+medical+"&patient="+patient+"&prtype="+prtype+"&ip="+ip+"&port="+port+"&mobile="+mobile);
					}
					//
					

				/*}
				else
				{
					gotostep(4);
					setTimeout("delaylayer()",200);
					setTimeout("nextstep()",5000);
					setTimeout("setDeliPrint()",6000);
				}
				}*/
			}
		}

		$("#mainbarcode").focus();
	}

	function delaylayer()
	{
		console.log($(".sect_step .on .txt").text());
		layersign("success",$("aside .sect_step .on .txt").text(),'','7000');////????????? ?????? ??? ??????????????? ???????????? - ??????
		$("#mainbarcode").focus();		
	}
	function markingwork(url)
	{
		$("#workdiv").remove();
		var view="width:0;height:0;";
		console.log("markingwork url = " + url);
		$("body").append("<div id='workdiv' style='position:fixed;"+view+"bottom:0;width:100%;height:0;;z-index:10000;border:5px solid red;background:#fff;overflow-y:scroll;display:none'></div>");
		$("#workdiv").load(url);
		$("#mainbarcode").focus();
	}
	function callmarkingapi(data)
	{
		var url="http://localhost/markingprt/markingwork.php?"+data;//getUrlData("API_TBMS")+group+"/"+code+".php";

		console.log("callmarkingapi url : "+url);

		$.ajax({
			type : "GET", //method
			url : url,
			data : "",
			success : function (result) {
				console.log("callmarkingapi  result " + result);
				markingmakepage(result);
			},
			error:function(request,status,error){
				console.log("code:"+request.status+"\n"+"message:"+request.responseText+"\n"+"error:"+error);
			}
	   });
	}
	function markingmakepage(json)
	{
		console.log("-------------------------------------------------------- ")
		var obj = JSON.parse(json);
		console.log("markingmakepage apiCode : " + obj["apiCode"])
		console.log("-------------------------------------------------------- ")

		if(obj["apiCode"]=="markingsetting") //??????????????? ??????
		{
			var mstxt="";

			if(obj["resultCode"]=="200" && obj["resultMessage"]=="OK") //??????????????? ?????? ?????? 
			{
				console.log("??????????????? ?????? ??????");
				//$('#layersign').remove();
				mstxt="<?=$txtdt['markingprt05'];?>";
				var mssubtxt="<?=$txtdt['markingprt06'];?>";

				console.log("mstxt : " + mstxt+", mssubtxt = " + mssubtxt);
				layersign('success',mstxt,mssubtxt,'3000');
				setTimeout(function(){
					nextstep();
					intrevalprint();
				},1000);
			}
			else
			{
				if(obj["resultCode"]=="397")
				{
					alert('???????????? ?????? ??????!'+obj["resultMessage"]);//???????????? ????????????!
					$('#layersign').fadeOut(1000);
					$('#imgfront').data('value', '');
				}
				else if(obj["resultCode"]=="396")//???????????? ???????????? ????????????. 
				{
					if(confirm("???????????? ??????????????? ???????????? ????????????\n\n????????? ?????????????????????????"))
					{
						closelayer();
						gotostep(5);
						setDeliPrint();
					}
					else
					{
						$('#layersign').fadeOut(1000);
						$('#imgfront').data('value', '');
					}	
				}
				else if(obj["resultCode"]=="395")//?????????????????? 
				{
					mstxt="<?=$txtdt['markingprt02']?>";
					alert(mstxt+" "+obj["resultMessage"]);
					$('#layersign').fadeOut(1000);
					$('#imgfront').data('value', '');
				}
				else if(obj["resultCode"]=="394")//??????????????? ????????????!
				{
					mstxt="<?=$txtdt['markingprt04']?>";
					alert(mstxt+" "+obj["resultMessage"]);
					$('#layersign').fadeOut(1000);
					$('#imgfront').data('value', '');
				}
				else if(obj["resultCode"]=="9999")
				{
					mctxt="????????? ????????????. ??????????????? ??????????????? ????????????.";
					alert(mctxt); //????????? ????????????. ??????????????? ??????????????? ????????????. 
					$('#layersign').fadeOut(1000);
				}
				else if(obj["resultCode"]=="398")
				{
					mctxt="??????????????? ?????? ??????(2)";
					alert(mctxt+" "+obj["resultMessage"]); //??????????????? ?????? ?????? ??????  
					$('#layersign').fadeOut(1000);
				}
				else if(obj["resultCode"]=="399")
				{
					mctxt="??????????????? ?????? ??????(1)";
					alert(mctxt+" "+obj["resultMessage"]); //??????????????? ?????? ?????? ??????  
					$('#layersign').fadeOut(1000);
				}
			}
		}
		else if(obj["apiCode"]=="markingcount") //?????? ????????? 
		{
			var mctxt="";
			if(obj["resultCode"]=="200" && obj["resultMessage"]=="OK")
			{
				var cnt=obj["markingcount_count"];
				$('#pouchcnt').val(cnt);
			}
			else
			{
				if(obj["resultCode"]=="392")
				{
					mctxt="<?=$txtdt['markingprt00']?>";
					alert(mctxt); //????????????????????? 
					$('#layersign').fadeOut(1000);
				}
				else if(obj["resultCode"]=="393")
				{
					mctxt="<?=$txtdt['markingprt01']?> "+obj["resultMessage"];
					alert(mctxt);//????????? ????????????! 
					$('#layersign').fadeOut(1000);
				}
				else if(obj["resultCode"]=="9999")
				{
					mctxt="????????? ????????????. ??????????????? ??????????????? ????????????.";
					alert(mctxt); //????????? ????????????. ??????????????? ??????????????? ????????????. 
					$('#layersign').fadeOut(1000);
				}
				else if(obj["resultCode"]=="398")
				{
					mctxt="??????????????? ?????? ??????(2)";
					alert(mctxt+" "+obj["resultMessage"]); //??????????????? ?????? ?????? ??????  
					$('#layersign').fadeOut(1000);
				}
				else if(obj["resultCode"]=="399")
				{
					mctxt="??????????????? ?????? ??????(1)";
					alert(mctxt+" "+obj["resultMessage"]); //??????????????? ?????? ?????? ??????  
					$('#layersign').fadeOut(1000);
				}
			}
		}
	}
	function viewmarkingprinter(pgid, list, mrprint)
	{
		console.log("viewmarkingprinter  pgid = " + pgid);
		var str = "";
		if(!isEmpty(getCookie("ck_mrPrinterIP")) && !isEmpty(getCookie("ck_mrPrinterPort")) && !isEmpty(getCookie("ck_mrPrinter")))
		{
			str+='<h3 class="mrprint"><?=$txtdt["9005"]?><span class="" onclick="resetPrinter()">[<?=$txtdt["resetmatable"]?>]</span></h3>';//????????? ????????? / ????????????
			str+='<dl class="mrprint"><dd><span>['+getCookie("ck_mrPrinter")+'] '+getCookie("ck_mrPrintertitle")+'</span></dd></dl>';
		}
		else
		{
			str+='<h3 class="mrprint"><?=$txtdt["9006"]?></h3>';//?????????????????? ????????? ?????????.
			str+='<dl class="mrprint">';
			var code=title=status=staff=ip=port="";
			for(var key in list)
			{
				code=list[key]["mpCode"];
				title=list[key]["mpTitle"];
				status=list[key]["mpStatus"];
				staff=list[key]["mpStaff"];
				ip=list[key]["mpIp"];
				port=list[key]["mpPort"];

				str+='<dd onclick="selectPrinter(\''+code+'\',\''+title+'\', \''+status+'\', \''+staff+'\', \''+ip+'\', \''+port+'\')");">';
				str+='<span>';
				str+='['+code+'] '+title+'<br><?=$txtdt["state"]?>'+list[key]["mpStateName"];
				str+='</span>';
				str+='</dd>';
			}
			str+='</dl>';
		}
		$("#"+pgid).html(str);
		setTimeout("$('#mainbarcode').focus()",700);
	}
	function resetPrinter()
	{
		deleteCookie("ck_mrPrinter");
		deleteCookie("ck_mrPrintertitle");
		deleteCookie("ck_mrPrinterIP");
		deleteCookie("ck_mrPrinterPort");
		location.reload();
	}
	function selectPrinter(no, title, status, staff, ip, port)
	{
		if(status==""||status=="ready")
		{
			setCookie("ck_mrPrinter", no, 365);
			setCookie("ck_mrPrintertitle", title, 365);
			
			setCookie("ck_mrPrinterIP", ip, 365);
			setCookie("ck_mrPrinterPort", port, 365);
			location.reload();
		}
		else
		{
			if(status=="hold" && staff == getCookie("ck_stUserid"))
			{
				setCookie("ck_mrPrinter", no, 365);
				setCookie("ck_mrPrintertitle", title, 365);
				setCookie("ck_mrPrinterIP", ip, 365);
				setCookie("ck_mrPrinterPort", port, 365);
				location.reload();
			}
			else
			{
				var str="<?=$txtdt['clearselecttable']?>"; //?????? []??? ??????????????????.<br/>???????????? ?????????????????????????
				str=str.replace('[]',staff);
				str=str.replace('<br/>',"\n");
				if(confirm(str))
				{
					setCookie("ck_mrPrinter", no, 365);
					setCookie("ck_mrPrintertitle", title, 365);
					setCookie("ck_mrPrinterIP", ip, 365);
					setCookie("ck_mrPrinterPort", port, 365);
					location.reload();
				}
			}
		}
	}
	function setChildDeliNo(dvCode)
	{
		$("#delino").text(dvCode);
	}
	function makepage(json)
	{
		console.log("makepage ----------------------------------------------- ")
		var obj = JSON.parse(json);
		console.log(obj)
		console.log("apiCode ========================== >>>>>>>> " + obj["apiCode"])
		console.log("-------------------------------------------------------- ")

		var depart = "<?=$depart?>";
		
		if(obj["apiCode"]=="markinglist") //???????????????
		{

			//steptxtdt??? ????????? txt??? ??? ?????? ???????????????.
			setTxtdt(obj["txtdt"]);

			viewbacodearea("containerDiv", obj["step"]["list"]);

			viewstatusstep("step_info", obj["step"], "<?=$language;?>");
			viewstatusstep("sect_step", obj["step"], "<?=$language;?>");

			viewmarkingprinter("maindiv", obj["markingPrinterList"], getCookie("ck_mrPrinter"));

			getstaffInfo("staffinfo", null);//staff ?????????

		}
		else if(obj["apiCode"]=="getstaff")
		{
			viewGetStaff(obj["data"], depart);
		}
		else if(obj["apiCode"]=="orderlist")
		{
			viewOrderList(obj["list"], obj["tpage"], obj["page"], obj["block"], obj["psize"]);
		}
		else if(obj["apiCode"]=="checkprocess")
		{
			viewCheckProcess(depart, obj["data"], obj["medi"], obj["proccode"], obj["code"], obj["stat"]);
		}
		else if(obj["apiCode"]=="markingmain")
		{
			$("#transid").hide();
			$("#adddeli").hide();

			$("textarea[name=odRequest]").val(obj["od_request"]);
			$("#pouchboxcode").text(obj["pouchcode"]); //?????????????????? ??????
			$("#delino").text(obj["delino"]);//????????????


			
			$("input[name=reDelicomp]").val(obj["re_delicomp"]);//???????????? 
			$("input[name=reDeliexception]").val(obj["re_deliexception"]);//???????????? 
			
			
			$("input[name=reBoxmedicnt]").val(obj["re_boxmedicnt"]);//???????????? ?????? 

			console.log("re_boxmedicnt = " + obj["re_boxmedicnt"]+" - "+$("input[name=reBoxmedicnt]").val());
			

			$("input[name=mobile]").val(obj["mobile"]);
			

			var data=obj["od_packcnt"]+"<small><?=$txtdt['pack']?></small><small class='dsc'>("+obj["od_packcapa"]+"ML)</small>";
			$("#packcnt").html(data); //?????????/???????????????
			$("#packcnt").data("value", obj["od_packcnt"])

			var packcnt=parseInt($("#packcnt").data("value"));
			console.log("packcnt ==== " + packcnt);
		
			$("#markingtxt").html(obj["markingtxt"]); //???????????????
			$("#markingtxt").attr("data-desc", obj["mr_desc"]);

			//20191014 : ???????????? ???????????? ?????????, ??????????????? ???????????? ????????? 
			var img="";
			if(!isEmpty(obj["cyPouchImg"]))
			{
				$("#lpacktype").text(obj["cyPouchName"]);

				//?????????
				$("#txtfront").html(obj["cyPouchName"]);//???????????????
				$("#packtype").text(obj["cyPouchName"]); //???????????????
				img='<img src="'+obj["cyPouchImg"]+'" alt="'+obj["cyPouchName"]+'" onerror="this.src=\'<?=$root?>/_Img/noimg.png\'" onclick="startmarking();" >';
				$("#imgfront").html(img);
			}
			else
			{
				$("#packtype").text(obj["packtype"]); //??????????????? 
				var front="<?=$txtdt['front']?>";//??????
				if(!isEmpty(obj["afUrl"]) && obj["afUrl"]!="NoIMG")
				{
					if(obj["afUrl"].substring(0,4)=="http")
					{
						data="<img src="+obj["afUrl"]+" alt='"+front+"' onclick='startmarking();' >";
					}
					else
					{
						data="<img src="+getUrlData("FILE_DOMAIN")+obj["afUrl"]+" alt='"+front+"' onerror='this.src=\"<?=$root?>/_Img/noimg.png\"' onclick='startmarking();' >";
					}					
				}
				else
				{
					data="<img src='<?=$root?>/_Img/noimg.png' onclick='startmarking();'>";
				}
				$("#imgfront").html(data);
			}

			setRequestPopup();
		}

		$("#mainbarcode").focus();
	}

	callapi('GET','marking','markinglist',"<?=$apiData?>");
</script>