<?php
	$root="..";
	include_once $root."/_common.php";
	include_once $root."/_Inc/head.php";

	$apiData="depart=".$depart;
	$ck_staffid=$_COOKIE["staffid"];

	$apiData="depart=".$depart."&staffid=".$ck_staffid;
?>
<style>
	div.requestdiv{overflow:hidden;background:#ccc;width:1200px;height:560px;padding:0 5px 0 5px;}
	div.requestdiv div{float:left;width:1160px;height:360px;text-align: left;overflow-y:auto;}
	.requesttitle{width:auto;background:#fff;color:green;font-size:30px;padding:10px 0;margin:20px;text-align:center;font-weight:bold;}
	.requestcontent{display:block;background:#fff;float:left;text-align:center;width:17%;margin:10px 20px;padding:0;font-size:27px;font-weight:bold;line-height:1.5em;}
	.reuqestok{float:right;width:250px;height:50px;background:green;color:white;font-size:30px;padding:10px 0;margin:0 20px;text-align:center;font-weight:bold;}
	.btnbigimg{float:left;width:250px;height:70px;background:green;color:white;font-size:30px;padding:10px 0;margin:0 30px;text-align:center;font-weight:bold;}

	#odpackcapa {width:400px;height:40px;font-size: 30px;color: yellow;font-weight: 100;margin-right: 10px;text-align:right;vertical-align:top;}
	#lbcnt{width: 80px;height: 40px;margin-right: 10px;font-size: 25px;font-weight: bold;vertical-align:top;}
	#labelNamePrint {width:130px;height:40px;padding:5px;font-size:20px;font-weight:bold;background:#FF8C00;border-radius:3px;color:#fff;text-align:center;cursor:pointer;}
</style>
<div class="page">
	<?php include_once $root."/_Inc/left.php"; ?>
	<div class="container" id="containerDiv" value="<?=$depart?>" data-value="<?=$releaseprocess?>">
		<div class="section_release">
			<div id="my_camera" style="display:none;position:absolute;z-index:9999;margin:2px 0 0 -140px;"></div>
			<div id="snapshot" style="display:none;position:absolute;z-index:9999;width:640px;height:480px;margin:2px 0 0 0;border:10px solid #777;background:#fff;"></div>
			<div id="bigimage" style="display:none;position:absolute;z-index:9999;width:640px;height:480px;margin:2px 0 0 0;border:10px solid #777;background:#fff;"></div>
			<?php include_once $root."/_Inc/navi.php"; ?>
			<section id="release">
				<ol class="sect_step" id="step_info"></ol>
				<div id="maindiv"></div>
			</section>
		</div>
	</div>
</div>
<textarea name="odRequest" id="odRequest" cols="500" rows="5" style="display:none"></textarea>
<textarea name="od_advice" id="od_advice" cols="500" rows="5" ></textarea>
<input type="hidden" id="od_goods" name="od_goods" class="" value="">
<input type="hidden" id="reDeliexception" name="reDeliexception" value="" />
<input type="hidden" id="reDelicomp" name="reDelicomp" value="" />
<input type="hidden" id="reBoxmedicnt" name="reBoxmedicnt" value=""/>
<input type="hidden" id="diagnosisType" name="diagnosisType" value=""/>

<?php include_once $root."/_Inc/tail.php"; ?>
<script>$("#mainbarcode").focus();</script>
<script>
	function showDeliPrint()
	{
		var code=$("#ordercode").attr("value");
		var delicomp=$("input[name=reDelicomp]").val();
		var deliexception=$("input[name=reDeliexception]").val();

		console.log("delicomp = " + delicomp+", deliexception = " + deliexception+", reBoxmedicnt = " + reBoxmedicnt);
		window.open("/marking/document.deliprint.php?odCode="+code+"&deliexception="+deliexception+"&delicomp="+delicomp, "proc_report_deli","width=800,height=500");//ok  -??????. ????????? ?????????.
	}
	function addDeliveryPrint()
	{
		console.log("?????? ?????? ????????????!!!!!!!!!!!!!!!!!!!!!!!!");
		var code=$("#ordercode").attr("value");
		var type="POST";			
		var delicomp=$("input[name=reDelicomp]").val();
		var deliexception=$("input[name=reDeliexception]").val();
		console.log("code = "+code+", delicomp = " + delicomp+", deliexception = " + deliexception);
		window.open("/marking/document.deliprint.php?odCode="+code+"&type="+type+"&deliexception="+deliexception+"&delicomp="+delicomp+"&addprint=R", "proc_report_deli","width=800,height=500");//ok  -??????. ????????? ?????????.
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
		console.log("requestOnClickrequestOnClickrequestOnClickrequestOnClickrequestOnClick");
		$("#makingtblestatdiv").remove();
		$("#requestscreen").remove();
		$("#mainbarcode").focus();
	}
	function onbigimgclose()
	{
		document.getElementById('bigimage').style.display = 'none';
		$("#mainbarcode").focus();
	}
	function onbigimgdel(seq)
	{
		var url="seq="+seq;
		callapi('GET','release','releasephotodelete',url);
	}
	function onclickbigimg(url, seq)
	{
		var txt=" <input type='button' name='imgdel' class='btnbigimg' onclick='onbigimgdel(\""+seq+"\")' value='??????'></button>"; //??????";
		txt+=" <input type='button' name='imgclose' class='btnbigimg' onclick='onbigimgclose()' value='??????'></button>"; //??????";
		document.getElementById('bigimage').style.display = 'block';
		$('#bigimage').html('<img src="'+url+'" /> ' + txt);
	}
	function setLabelPrint()
	{
		var lblCnt=$("#lbcnt option:selected").val();
		var lblName=$("#lbcnt option:selected").data("name");
		var code=$("#ordercode").attr("value");
		var diagnosisType=$("input[name=diagnosisType]").val();
		diagnosisType=!isEmpty(diagnosisType)?diagnosisType:"A";
		//encodeURI();



		//window.open("/release/document.labelprint.php?lblCnt="+lblCnt+"&code="+code, "proc_lblprt_deli","width=600,height=700");//ok  -??????. ????????? ?????????.
		window.open("/release/document.labelprint.php?code="+code+"&type="+diagnosisType, "proc_lblprt_deli","width=600,height=700");//ok  -??????. ????????? ?????????.

		console.log("setLabelPrint  cnt = " + lblCnt + ", name = " + lblName);
	}
	function makepage(json)
	{
		console.log("makepage ----------------------------------------------- ")
		var obj = JSON.parse(json);
		console.log(obj);
		console.log("apiCode ========================== >>>>>>>> " + obj["apiCode"])
		console.log("-------------------------------------------------------- ")
		var depart = "<?=$depart?>";

		if(obj["apiCode"]=="releaselist") //???????????????
		{
			//steptxtdt??? ????????? txt??? ??? ?????? ???????????????.
			setTxtdt(obj["txtdt"]);

			viewbacodearea("containerDiv", obj["step"]["list"]);

			viewstatusstep("step_info", obj["step"], "<?=$language;?>");
			viewstatusstep("sect_step", obj["step"], "<?=$language;?>");

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
		else if(obj["apiCode"]=="releasemain")
		{
			var data="";

			if(obj["od_goods"]=="M")
			{
				$("#delidiv").css("display","block");//????????????
				$("#deliinfo").css("display","none");//??????
			}
			else
			{
				$("#delidiv").css("display","none");
				$("#deliinfo").css("display","block");
			}
			//od_goods
			$("input[name=od_goods]").val(obj["od_goods"]);

			$("input[name=diagnosisType]").val(obj["diagnosisType"]);
			

			$("textarea[name=odRequest]").val(obj["od_request"]);
			$("textarea[name=od_advice]").val(obj["od_advice"]);

			$("#pouchboxcode").text(obj["pouchcode"]);//??????????????????
			$("#delino").text(obj["delino"]);//????????????
			$("#re_delitype").text(obj["re_delitypename"]);//????????????

			data = obj["od_title"] + "<?=$txtdt['etc']?> ("+obj["od_packcnt"]+"<?=$txtdt['pack']?>)";
			$("#odtitle").text(data);//?????????

			//data="<span class="+obj["icon_re_precipitate"]+"></span>";
			//$("#chkprecipitate").html(data);
			//data="<span class="+obj["icon_re_leak"]+"></span>";
			//$("#chkleak").html(data);

			//???????????????
			var prtcnt=i=0;
			var lstr="";
			lstr="<h4 class='tt' id='odpackcapa'></h4>";
			//console.log("od_packcnt : "+obj["od_packcnt"]);
			//if(parseInt(obj["od_packcnt"]) >= 70)
			//{
			//	prtcnt=2;
			//}
			//else
			//{
			//	prtcnt=1;
			//}
			
			//lstr+="<select name='lbcnt' id='lbcnt' class='reqdata'>";
			//for(i=1;i<6;i++)
			//{
			//	if(i==prtcnt){selected="selected";}else{selected="";}
			//	lstr+="<option value='"+i+"' "+selected+" data-name='"+obj["od_name"]+"'>"+i+"</option>";//?????????
			//}
			//lstr+="</select>";
			lstr+="<button id='labelNamePrint' name='labelNamePrint' onclick='javascript:setLabelPrint();'>????????????</button>";
			$("#labelprt").html(lstr);

			//??????/????????? 
			$("#odpackcapa").text(obj["od_packcnt"]+"??? / "+obj["od_packcapa"]+"ml");


			$("#re_name").text(obj["re_name"]);
			data="["+obj["re_zipcode"]+"] "+obj["re_address"];
			$("#re_address").text(data);
			data=obj["re_phone"]+", "+obj["re_mobile"];
			$("#re_phone").text(data);

			$("#mi_name").text(obj["mi_name"]);
			data="["+obj["mi_zipcode"]+"] "+obj["mi_address"];
			$("#mi_address").text(data);
			data=obj["mi_phone"];
			$("#mi_phone").text(data);

			$("#od_request").text(obj["re_request"]);//???????????? 
			$("#qmcode").text(obj["od_advice"]);




			$("input[name=reDelicomp]").val(obj["re_delicomp"]);
			$("input[name=reDeliexception]").val(obj["re_deliexception"]);

			$("input[name=reBoxmedicnt]").val(obj["re_boxmedicnt"]);//???????????? ?????? 

			$("#boxmedi").attr("value", obj["re_boxmedi"]);  //????????????
			var tit=(!isEmpty(obj["boxmeditit"])) ? obj["boxmeditit"] : "";
			$("#boxmedi").text('[<?=$txtdt["boxmedi"]?>]'+'  '+tit);

			if(!isEmpty(obj["afBoxmedi"]) && obj["afBoxmedi"]!="NoIMG")
			{
				if(obj["afBoxmedi"].substring(0,4)=="http")
				{
					img="<img style='width: 300px;'  src="+obj["afBoxmedi"]+"  onerror='this.src=\"<?=$root?>/_Img/noimg.png\"' >";
				}
				else
				{
					img="<img style='width: 300px;'  src="+getUrlData("FILE_DOMAIN")+obj["afBoxmedi"]+"  onerror='this.src=\"<?=$root?>/_Img/noimg.png\"' >";
				}
			}
			else
			{
				img="<img style='width: 300px;'  src='<?=$root?>/_Img/noimg.png'>";
			}
			$("#afBoxmedi").html(img);

			$("#boxdeli").attr("value", obj["pouchcode"]); //?????????
			var delitit=(!isEmpty(obj["pouchtit"])) ? obj["pouchtit"] : "";
			$("#boxdeli").text('[<?=$txtdt["pouch"]?>]'+'  '+delitit);//?????????text
			if(!isEmpty(obj["afPacktype"]) && obj["afPacktype"]!="NoIMG")
			{
				if(obj["afPacktype"].substring(0,4)=="http")
				{
					img="<img style='width: 300px;' src="+obj["afPacktype"]+" onerror='this.src=\"<?=$root?>/_Img/noimg.png\"' >";
				}
				else
				{
					img="<img style='width: 300px;' src="+getUrlData("FILE_DOMAIN")+obj["afPacktype"]+" onerror='this.src=\"<?=$root?>/_Img/noimg.png\"' >";
				}
			}
			else
			{
				img="<img style='width: 300px;'  src='<?=$root?>/_Img/noimg.png'>";
			}
			
			$("#afBoxdeli").html(img);

			setRequestPopup();

			//20190816:release?????? marking?????? ???????????? 
			//20190618 : checkprocess ???????????? releasemain ???????????? ??????????????? ???????????? 
			//window.open("document.deliprint.php", "proc_report_deli","width=700,height=700");//ok  -??????. ????????? ?????????.

			var ordercode=$("#ordercode").attr("value");
			var url="odcode="+ordercode;
			callapi('GET','release','releasephotolist',url);
		}
		else if(obj["apiCode"] == "releaserec")
		{
			if(obj["code"]=="REC0000001000")////????????????????????????
			{
				$('#chkprecipitate').removeClass('icon_no').addClass('icon_ok');
				layersign('success',getTxtdt("stepnopre"),'','1000');//????????? ?????? ?????? ???????????????
			}
			if(obj["code"]=="REC0000002000")//?????????????????????
			{
				$('#chkleak').removeClass('icon_no').addClass('icon_ok');
				layersign('success',getTxtdt("stepdone"),'','1000');//????????? ?????????????????????
			}

			if(obj["re_precipitate"]>0&&obj["re_leak"]>0)
			{
				nextstep();
			}
			cleardiv();
		}
		else if(obj["apiCode"]=="releasephotolist")
		{
			var data=imgsrc=thumsrc="";
			if(!isEmpty(obj["files"]))
			{
				$(obj["files"]).each(function( index, value )
				{
					if(!isEmpty(value["afThumbUrl"]) && value["afThumbUrl"]!="NoIMG")
					{
						thumsrc=getUrlData("FILE_DOMAIN")+value["afThumbUrl"];
					}
					else
					{
						thumsrc="<?=$root?>/_Img/noimg.png";
					}

					if(!isEmpty(value["afUrl"]) && value["afUrl"]!="NoIMG")
					{
						imgsrc=getUrlData("FILE_DOMAIN")+value["afUrl"];
					}
					else
					{
						imgsrc="<?=$root?>/_Img/noimg.png";
					}
					var afseq=value["afseq"];

					data+="<dl onclick='onclickbigimg(\""+imgsrc+"\",\""+afseq+"\")'>";
					data+="<dd class='img'><img src='"+thumsrc+"'></dd>";
					data+="</dl>";
				});
			}
			$("#photolist").html(data);
			$("#mainbarcode").focus();
		}
		else if(obj["apiCode"]=="releasephotodelete")
		{
			if(obj["resultCode"]=="200")
			{
				var ordercode=$("#ordercode").attr("value");
				var url="odcode="+ordercode;
				callapi('GET','release','releasephotolist',url);
				layersign('success',"?????????????????????.",'','1000');//?????????????????????
				$("#mainbarcode").focus();
			}
			onbigimgclose();
		}

		$("#mainbarcode").focus();

	}
	callapi('GET','release','releaselist',"<?=$apiData?>");
</script>
