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
</style>
<div class="page">
	<?php include_once $root."/_Inc/left.php"; ?>
	<div class="container" id="containerDiv" value="<?=$depart?>" data-value="<?=$goodsprocess?>">
		<div class="section_goods">
			<div id="my_camera" style="display:none;position:absolute;z-index:9999;margin:2px 0 0 -140px;"></div>
			<div id="snapshot" style="display:none;position:absolute;z-index:9999;width:640px;height:480px;margin:2px 0 0 0;border:10px solid #777;background:#fff;"></div>
			<div id="bigimage" style="display:none;position:absolute;z-index:9999;width:640px;height:480px;margin:2px 0 0 0;border:10px solid #777;background:#fff;"></div>
			<?php include_once $root."/_Inc/navi.php"; ?>
			<section id="goods">
				<ol class="sect_step" id="step_info"></ol>
				<div id="maindiv"></div>
			</section>
		</div>
	</div>
</div>
<textarea name="odRequest" id="odRequest" cols="500" rows="5" style="display:none"></textarea>
<input type="hidden" id="reDeliexception" name="reDeliexception" value="" style="color:#fff;border:1px solid #fff;" />
<input type="hidden" id="reDelicomp" name="reDelicomp" value="" style="color:#fff;border:1px solid #fff;" />
<input type="hidden" id="reBoxmedicnt" name="reBoxmedicnt" value="" style="color:#fff;border:1px solid #fff;" />
<?php include_once $root."/_Inc/tail.php"; ?>
<script>$("#mainbarcode").focus();</script>
<script>
	function addDeliveryPrint()
	{
		var no=$("#step_info").find("li.on").index();
		if(no>=4)
		{
			console.log("?????? ?????? ????????????!!!!!!!!!!!!!!!!!!!!!!!!");
			var code=$("#ordercode").attr("value");
			var type="POST";			
			//var delicomp="LOGEN";
			var delicomp=$("input[name=reDelicomp]").val();
			var deliexception=$("input[name=reDeliexception]").val();
			console.log("code = "+code+", delicomp = " + delicomp+", deliexception = " + deliexception);
			window.open("/marking/document.deliprint.php?odCode="+code+"&type="+type+"&deliexception="+deliexception+"&delicomp="+delicomp+"&addprint=R", "proc_report_deli","width=800,height=500");//ok  -??????. ????????? ?????????.
		}
	}
	function showDeliPrint()
	{
		var code=$("#ordercode").attr("value");
		var delicomp=$("input[name=reDelicomp]").val();
		var deliexception=$("input[name=reDeliexception]").val();

		console.log("delicomp = " + delicomp+", deliexception = " + deliexception+", reBoxmedicnt = " + reBoxmedicnt);
		window.open("/marking/document.deliprint.php?odCode="+code+"&deliexception="+deliexception+"&delicomp="+delicomp, "proc_report_deli","width=800,height=500");//ok  -??????. ????????? ?????????.
	}
	function parentdelClose()
	{
		layersign("success",getTxtData("9022"), "",'confirm_release');//????????? ????????? ????????? ???????????? ??????????????? ????????? ?????????.
		//nextstep();
		gotostep(5);
		$("#mainbarcode").focus();
	}
	function goodsok()
	{
		var no=$("#step_info").find("li.on").index();
		if(no==2)
		{
			$(".hgrp").addClass("goodsok");
			nextstep();
		}
	}
	function componentok(id)
	{
		var no=$("#step_info").find("li.on").index();
		if(no==3)
		{
			$("#"+id).addClass("componentok");
			var totok=$(".componentok").length;
			var totgoods=$("#goodsdata").data("totcnt");

			if(totgoods==totok)
			{
				nextstep();

				var code=$("#ordercode").attr("value");
				var type="POST";
				var deliexception=$("input[name=reDeliexception]").val();
				//var delicomp="LOGEN";//???????????? ????????? CJ
				var delicomp=$("input[name=reDelicomp]").val();
				var reBoxmedicnt=$("input[name=reBoxmedicnt]").val();

				if(delicomp.toUpperCase()=="POST" && !isEmpty(reBoxmedicnt)&&parseInt(reBoxmedicnt)<=0)
				{
					if (!isEmpty(deliexception)&&deliexception.indexOf("O") != -1 || !isEmpty(deliexception)&&deliexception.indexOf("T") != -1 || !isEmpty(deliexception)&&deliexception.indexOf("D") != -1)
					{
						window.open("/marking/document.deliprint.php?odCode="+code+"&type="+type+"&deliexception="+deliexception+"&delicomp="+delicomp, "proc_report_deli","width=800,height=500");//ok  -??????. ????????? ??????
					}
					else
					{
						window.open("/marking/document.delicnt.php?odCode="+code, "proc_delicnt_deli","width=800,height=500");//ok  -??????. ????????? ?????????.
					}
				}
				else
				{
					window.open("/marking/document.deliprint.php?odCode="+code+"&type="+type+"&deliexception="+deliexception+"&delicomp="+delicomp, "proc_report_deli","width=800,height=500");//ok  -??????. ????????? ?????????.
				}

				//20190816:release?????? marking?????? ???????????? 
				//20190618 : checkprocess ???????????? releasemain ???????????? ??????????????? ???????????? 
				//20190902 : ?????? ?????????????????? ?????? ???????????? ?????? ???????????? ?????? 
				//20191017 : ?????? ?????? ?????? 
				//window.open("/marking/document.deliprint.php?odCode="+code+"&type="+type+"&delicomp="+delicomp+"&deliexception="+deliexception, "proc_report_deli","width=800,height=500");//ok  -??????. ????????? ?????????.
			}
		}
	}
	function onbigimgclose()
	{
		document.getElementById('bigimage').style.display = 'none';
		$("#mainbarcode").focus();
	}
	function onbigimgdel(seq)
	{
		var url="seq="+seq;
		callapi('GET','goods','goodsphotodelete',url);
	}
	function onclickbigimg(url, seq)
	{
		var txt=" <input type='button' name='imgdel' class='btnbigimg' onclick='onbigimgdel(\""+seq+"\")' value='??????'></button>"; //??????";
		txt+=" <input type='button' name='imgclose' class='btnbigimg' onclick='onbigimgclose()' value='??????'></button>"; //??????";
		document.getElementById('bigimage').style.display = 'block';
		$('#bigimage').html('<img src="'+url+'" /> ' + txt);
	}
	function makepage(json)
	{
		console.log("makepage ----------------------------------------------- ")
		var obj = JSON.parse(json);
		console.log(obj)
		console.log("apiCode ========================== >>>>>>>> " + obj["apiCode"])
		console.log("-------------------------------------------------------- ")
		var depart = "<?=$depart?>";

		if(obj["apiCode"]=="goodslist") //???????????????
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
		else if(obj["apiCode"]=="goodsmain")
		{
			var data="";
			$("textarea[name=odRequest]").val(obj["od_request"]);

			$("#delino").text(obj["delino"]);//????????????
			$("#re_delitype").text(obj["re_delitypename"]);//????????????

			var goodscnt=obj["gp_goodscnt"];

			data = obj["goodsName"] + " / " + goodscnt + "???";//????????? / 2???
			$("#goodsName").text(data);//?????????

			
			$("#re_name").text(obj["re_name"]);
			data="["+obj["re_zipcode"]+"] "+obj["re_address"];
			$("#re_address").text(data);
			data=obj["re_phone"]+", "+obj["re_mobile"];
			$("#re_phone").text(data);

			$("#re_sendname").text(obj["re_sendname"]);
			data="["+obj["re_sendzipcode"]+"] "+obj["re_sendaddress"];
			$("#re_sendaddress").text(data);
			data=obj["re_sendphone"];
			$("#re_sendphone").text(data);

			$("#od_request").text(obj["od_request"]);
			$("input[name=reDeliexception]").val(obj["re_deliexception"]);//???????????? 
			$("input[name=reDelicomp]").val(obj["re_delicomp"]); 
			$("input[name=reBoxmedicnt]").val(obj["re_boxmedicnt"]); 
			
			//$("#qmcode").text(obj["od_advice"]);

			//??????????????? ????????? ?????? ?????? 
			/*
			goodslist: Array(5)
			0: {gdTypeName: "?????????", gd_type: "pregoods", gd_code: "ETGDSH", gd_name: "???????????????(??????) / 1???", gd_cnt: "9"}
			1: {gdTypeName: "?????????", gd_type: "pregoods", gd_code: "ETSJHW", gd_name: "?????????????????? / kg", gd_cnt: "3"}
			2: {gdTypeName: "?????????", gd_type: "material", gd_code: "FTXX012", gd_name: "?????? ?????????", gd_cnt: "1"}
			3: {gdTypeName: "?????????", gd_type: "material", gd_code: "FTYX001", gd_name: "??????????????? ??????", gd_cnt: "1"}
			4: {gdTypeName: "?????????", gd_type: "material", gd_code: "FTZE001", gd_name: "????????? PE ?????? 50??????", gd_cnt: "1"}
			*/

			data="";
			var imgsrc="";
			var glcnt=obj["goodslist"].length;
			$(obj["goodslist"]).each(function( index, value )
			{
				if(!isEmpty(value["gd_thumb_image"]) && value["gd_thumb_image"]!="NoIMG")
				{
					imgsrc=getUrlData("FILE_DOMAIN")+value["gd_thumb_image"];
				}
				else
				{
					imgsrc="<?=$root?>/_Img/noimg.png";
				}
				if(value["gd_type"]=="material"){var unit="???";}else{var unit="g";}
				data+="<dl id='"+value["gd_code"]+"' onclick='componentok(\""+value["gd_code"]+"\");'><dt>"+value["gd_name"]+"";
				data+="<i>"+(parseInt(value["gd_cnt"]) * parseInt(goodscnt))+unit+"</i></dt>";
				data+="<dd class='img'><img src='"+imgsrc+"'></dd></dl>"
			});

			$("#goodsdata").html(data);
			$("#goodsdata").data("totcnt",glcnt);

			var ordercode=$("#ordercode").attr("value");
			var url="odcode="+ordercode;
			callapi('GET','goods','goodsphotolist',url);

		}
		else if(obj["apiCode"]=="goodsphotolist")
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
		else if(obj["apiCode"]=="goodsphotodelete")
		{
			if(obj["resultCode"]=="200")
			{
				var ordercode=$("#ordercode").attr("value");
				var url="odcode="+ordercode;
				callapi('GET','goods','goodsphotolist',url);
				layersign('success',"?????????????????????.",'','1000');//?????????????????????
				$("#mainbarcode").focus();
			}
			onbigimgclose();
		}
		

		$("#mainbarcode").focus();

	}
	callapi('GET','goods','goodslist',"<?=$apiData?>");
</script>