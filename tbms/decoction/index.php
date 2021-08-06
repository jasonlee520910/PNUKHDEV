<?php
	$root="..";
	include_once $root."/_common.php";
	include_once $root."/_Inc/head.php";

	$apiData="depart=".$depart;
?>
<style>
	div.requestdiv{overflow:hidden;background:#ccc;width:1200px;height:560px;padding:0 5px 0 5px;}
	div.requestdiv div{float:left;width:1160px;height:360px;text-align: left;overflow-y:auto;}
	.requesttitle{width:auto;background:#fff;color:green;font-size:30px;padding:10px 0;margin:20px;text-align:center;font-weight:bold;}
	.requestcontent{display:block;background:#fff;float:left;text-align:center;width:17%;margin:10px 20px;padding:0;font-size:27px;font-weight:bold;line-height:1.5em;}
	.reuqestok{float:right;width:250px;height:50px;background:green;color:white;font-size:30px;padding:10px 0;margin:0 20px;text-align:center;font-weight:bold;}

	#labelNamePrint {position:fixed;top:10px;right:150px;text-align:center;font-size:20px;font-weight:bold;width:130px;height:40px;padding:5px;background:#FF8C00;border-radius:3px;color:#fff;text-align:center;cursor:pointer;}
</style>

<div class="page">
	<?php include_once $root."/_Inc/left.php"; ?>
	<div class="container" id="containerDiv" value="<?=$depart?>" data-value="<?=$decoctionprocess?>">
		<div class="section_decoction">
			<?php include_once $root."/_Inc/navi.php"; ?>
			<section id="decoction" class="section">
				<ol class="sect_step" id="step_info"></ol>
				<div id="maindiv"></div>
			</section>
		</div>
	</div>
</div>
<textarea name="odRequest" id="odRequest" cols="500" rows="5" style="display:none"></textarea>
<input type="hidden" name="odSitecategory" value="">
<input type="hidden" name="dcStatus" value="">

<?php include_once $root."/_Inc/tail.php"; ?>
<script>$("#mainbarcode").focus();</script>
<script>
	function setDecoctionLabelPrint()
	{
		var lblCnt=$("#lbcnt option:selected").val();
		var lblName=$("#lbcnt option:selected").data("name");
		var code=$("#ordercode").attr("value");
		//encodeURI();

		//window.open("/release/document.labelprint.php?lblCnt="+lblCnt+"&code="+code, "proc_lblprt_deli","width=600,height=700");//ok  -새창. 로딩이 걸리네.
		window.open("/release/document.labelprint.php?code="+code, "proc_lblprt_deli","width=600,height=700");//ok  -새창. 로딩이 걸리네.

		console.log("setLabelPrint  cnt = " + lblCnt + ", name = " + lblName);
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

	function startdecoction()
	{
		var ordercode=$("#ordercode").attr("value");
		var no=$("#step_info").find("li.on").index();
		var pouchbox=$("#pouchboxcode").text();
		console.log("파우치박스코드  ordercode=  " + ordercode+", no = " + no + ", pouchbox = " + pouchbox);

		if(no==4)
		{
			workerconfirm("<?=$txtdt['9038']?>");
			
			//status_txt=getTxtdt("step60");  //탕전지시서 바코드를 스캔 해 주세요
			//layersign("success",status_txt,'','1000');
			//$("#status_txt").text(status_txt);
			nextstep();
			
			var dcStatus=$("input[name=dcStatus]").val();
			if(dcStatus=="decoction_processing")
			{
			}
			else
			{
				setDecoctionLabelPrint();
			}
			
		}
		$("#mainbarcode").focus();
	}
	function addDecoctionLabel()
	{
		$("#addagainphoto").html("");
		var data="";
		data+="<button id='labelNamePrint' name='labelNamePrint' onclick='javascript:setDecoctionLabelPrint();'>라벨출력</button>";
		$("#addagainphoto").html(data);
	}
	function makepage(json)
	{
		console.log("makepage ----------------------------------------------- ")
		var obj = JSON.parse(json);
		console.log(obj)
		console.log("apiCode : " + obj["apiCode"])
		console.log("-------------------------------------------------------- ")

		var language = "<?=$language;?>";
		var depart = "<?=$depart?>";
		var ordercode=$("#ordercode").attr("value");

		console.log("language = " + language+", depart = " + depart +", ordercode = " + ordercode);

		if(obj["apiCode"]=="decoctionlist") //탕전리스트
		{
			//steptxtdt를 쓰려면 txt를 꼭 먼저 셋팅해야함.
			setTxtdt(obj["txtdt"]);

			viewbacodearea("containerDiv", obj["step"]["list"]);

			viewstatusstep("step_info", obj["step"], language);
			viewstatusstep("sect_step", obj["step"], language);

			getstaffInfo("staffinfo", null);//staff 리스트
		}
		else if(obj["apiCode"]=="orderlist")
		{
			viewOrderList(obj["list"], obj["tpage"], obj["page"], obj["block"], obj["psize"]);
		}
		else if(obj["apiCode"]=="getstaff")
		{
			viewGetStaff(obj["data"], depart);
		}
		else if(obj["apiCode"]=="checkprocess")
		{
			viewCheckProcess(depart, obj["data"], obj["medi"], obj["proccode"], obj["code"], obj["stat"]);		
		}
		else if(obj["apiCode"]=="decoctionmain")
		{
			$("input[name=odSitecategory]").val(obj["od_sitecategory"]);
			boilerView("boilerDiv", obj["boilerlist"]);  //불꽃 리스트
			medigroupView("info", obj["decolist"], obj["decocmedilist"],obj["meditxt"]);  //약재박스
			dcUseView("type3", obj["dcCooling"], obj["dcSterilized"])
			decolistView("decoDiv", obj["decolist"])

			packingView("packingDiv", obj["packinglist"]);  //포장기 리스트

			//if(obj["dc_status"]=="decoction_processing")
			//{
				//$("#boilerDiv").hide();
				//$("#packingDiv").show();
			//}
			//else
			//{
				//$("#decocproc").data("stepbp", "boiler");
				//$("#boilerDiv").show();
				//$("#packingDiv").hide();
				//$("#steppackingDiv").hide();
			//}
			showboiler();

			$("input[name=dcStatus]").val(obj["dc_status"]);

			if(obj["dc_status"]=="decoction_processing")
			{
				$("#addagainphoto").html("");
			}
			else
			{
				addDecoctionLabel();
			}
			

			$("#txtfront").text(obj["packtype"]); //파우치이름 
			$("#packtype").text(obj["packtype"]); //파우치이름
			if(!isEmpty(obj["afUrl"]) && obj["afUrl"]!="NoIMG")
			{
				if(obj["afUrl"].substring(0,4)=="http")
				{
					img="<img src="+obj["afUrl"]+" alt='"+obj["packtype"]+"' onclick='startdecoction();' onerror='this.src=\"<?=$root?>/_Img/noimg.png\"' >";
				}
				else
				{
					img="<img src="+getUrlData("FILE_DOMAIN")+obj["afUrl"]+" alt='"+obj["packtype"]+"' onclick='startdecoction();' onerror='this.src=\"<?=$root?>/_Img/noimg.png\"' >";
				}
			}
			else
			{
				img="<img src='<?=$root?>/_Img/noimg.png' onclick='startdecoction();'>";
			}
			$("#imgfront").html(img);

			$("textarea[name=odRequest]").val(obj["odRequest"]);
			$("#odRequest").text(obj["odRequest"]); //한의사요청사항
			$("#decoctype").text(obj["decoctype"]); //탕전법
			$("#dcWater").text(obj["dcWater"]); //투입물용량
			
			if(!isEmpty(obj["dcAlcohol"])&&parseInt(obj["dcAlcohol"])>0)
			{
				$("#alcoholDiv").show();
				$("#dcAlcoholName").text(obj["specialname"]);
				$("#dcAlcohol").text(obj["dcAlcohol"]);
			}
			else
			{
				$("#alcoholDiv").hide();
			}

			$("#odPackcnt").text(obj["odPackcnt"]); //팩수
			$("#odPackcapa").text(obj["odPackcapa"]); //팩용량
			$("#total").text(comma(obj["total"]));
			$("#special").text(obj["special"]); //특수탕전
			$("#sugarDiv").text(obj["sugarTitle"]);//감미제 

			$("input[name=decocstat]").val(obj["dc_status"]);  //상태값

			var dctime = obj["dcTime"];
			dctime = dctime.replace('[1]',"<?=$txtdt['timer']?>");
			dctime = dctime.replace('[2]',"<?=$txtdt['minute']?>");
			$("#dcTime").text(dctime); //시간

			$("#totaltime").text(obj["totaltime"]); //시간
			
			$("#pouchboxcode").text(obj["pouchboxcode"]);

			if(!isEmpty(obj["dc_status"]) && obj["dc_status"].indexOf("processing")<0)
			{
				setRequestPopup();
			}
		}
		else if(obj["apiCode"]=="checkmedipocket")
		{
			viewCheckmediPocket(depart, obj["data"], null);
		}
		else if(obj["apiCode"]=="checkboiler")
		{
			var ordercode=$("#ordercode").attr("value");
			console.log("ordercode = " + ordercode);
			$("input[name=decocstat]").val(obj["dc_status"]);

	
			//boilerView("boilerDiv", obj["boilerlist"]);  //불꽃 리스트

			console.log("bo_seq = " + obj["bo_seq"]);
			console.log("bo_status = " + obj["bo_status"]);
			console.log("bo_odcode = " + obj["bo_odcode"]);

			if(isEmpty(obj["bo_seq"]))
			{
				status_txt=getTxtdt("step41");//탕전기 바코드가 아닙니다. 다시 탕전기 바코드를 스캔 해 주세요
				$('#status_txt').text(status_txt);
				layersign('warning',status_txt,'','1000');
			}
			else if(obj["bo_status"]=="ing")
			{
				status_txt=getTxtdt("step43");//탕전중인 탕전기입니다.
				$('#status_txt').text(status_txt);
				layersign('warning',status_txt,'','1000');
			}
			else if(obj["bo_status"]=="hold")
			{
				if(!isEmpty(obj["bo_odcode"])&&ordercode!=obj["bo_odcode"])
				{
					status_txt="다른 작업에서 먼저 선택된 탕전기입니다.";
					$('#status_txt').text(status_txt);
					layersign('warning',status_txt,'','1000');
				}
				else
				{
					//status_txt="선택된 탕전기입니다.";
					//$('#status_txt').text(status_txt);
					//layersign('warning',status_txt,'','1000');
					showpacking();
					//$("#boilerDiv").hide();
					//$("#packingDiv").show();
					//$("#steppackingDiv").show();
					
				}
			}
			else if(obj["bo_status"]=="ready")
			{
				status_txt="준비중인 탕전기입니다.";//getTxtdt("step43");//탕전중인 탕전기입니다.
				$('#status_txt').text(status_txt);
				layersign('warning',status_txt,'','1000');
			}
			else
			{				
				if(obj["dc_status"]=="decoction_processing")
				{
					var jsondata={};
					jsondata["odcode"]=ordercode;
					jsondata["code"]=obj["code"];

					callapi('POST','decoction','checkboilerupdate',jsondata);

					showpacking();
					//$("#boilerDiv").hide();
					//$("#packingDiv").show();
					//$("#steppackingDiv").show();
					/*
					$("#"+obj["code"]).removeClass('ready').addClass('ing');
					$("#"+obj["code"]).addClass("select");
					$("#"+obj["code"]+" a .stxt").text("선택");
					status_txt=getTxtdt("step50");//파우치 바코드를 스캔 해 주세요
					$('#status_txt').text(status_txt);
					layersign('success',status_txt,'','1000');

					var no=$("#step_info").find("li.on").index();
					if(no==3)
					{
						nextstep();
					}
					*/
				}
				else
				{
					var no=$("#step_info").find("li.on").index();
					if(no==3)
					{
						nextstep();
					}
				}
			}
				cleardiv();
		}
		else if(obj["apiCode"]=="checkpacking")
		{
			var ordercode=$("#ordercode").attr("value");
			console.log("ordercode = " + ordercode);
			$("input[name=decocstat]").val(obj["dc_status"]);
	
			//packingView("packingDiv", obj["packinglist"]);  //포장기 리스트

			console.log("pa_seq = " + obj["pa_seq"]);
			console.log("pa_status = " + obj["pa_status"]);
			console.log("pa_odcode = " + obj["pa_odcode"]);

			if(isEmpty(obj["pa_seq"]))
			{
				status_txt="포장기 바코드가 아닙니다. 다시 포장기 바코드를 스캔해 주세요.";
				$('#status_txt').text(status_txt);
				layersign('warning',status_txt,'','1000');
			}
			else if(obj["pa_status"]=="ing")
			{
				status_txt="현재 사용중인 포장기입니다.";
				$('#status_txt').text(status_txt);
				layersign('warning',status_txt,'','1000');
			}
			else if(obj["pa_status"]=="hold")
			{
				if(!isEmpty(obj["pa_odcode"])&&ordercode!=obj["pa_odcode"])
				{
					status_txt="다른 작업에서 먼저 선택된 포장기입니다.";
					$('#status_txt').text(status_txt);
					layersign('warning',status_txt,'','1000');
				}
				else
				{
					status_txt="선택된 포장기입니다.";
					$('#status_txt').text(status_txt);
					layersign('warning',status_txt,'','1000');
				}
			}
			else if(obj["pa_status"]=="ready")
			{
				status_txt="준비중인 포장기입니다.";
				$('#status_txt').text(status_txt);
				layersign('warning',status_txt,'','1000');
			}
			else
			{				
				if(obj["dc_status"]=="decoction_processing")
				{
					var jsondata={};
					jsondata["odcode"]=ordercode;
					jsondata["code"]=obj["code"];

					callapi('POST','decoction','checkpackingupdate',jsondata);

					$("#"+obj["code"]).removeClass('ready').addClass('ing');
					$("#"+obj["code"]).addClass("select");
					$("#"+obj["code"]+" a .stxt").text("선택");
					status_txt=getTxtdt("step50");//파우치 바코드를 스캔 해 주세요
					$('#status_txt').text(status_txt);
					layersign('success',status_txt,'','1000');
					var no=$("#step_info").find("li.on").index();
					if(no==3)
					{
						nextstep();
					}
				}
				else
				{
					var no=$("#step_info").find("li.on").index();
					if(no==3)
					{
						nextstep();
					}
				}
			}
				cleardiv();
		}

		$("#mainbarcode").focus();
	}

	function boilerView(pgid, list)  //getboiler
	{	
		var ordercode=$("#ordercode").attr("value");
		var data =statustxt= sel="";
		var len = list.length;
		//console.log(list);

		data="<ul class='boilerview'>";
		for(i=0;i<len;i++)
		{
			sel="";
			statustxt=(list[i]["bo_status"]=="hold") ? "됨":"";
			if(!isEmpty(list[i]["bo_odcode"])&&ordercode==list[i]["bo_odcode"])
			{
				sel="select";
				statustxt="";
			}
			//로아스풍선추가
			/*
				로아스
				A4-BLR0000000004,B1-BLR0000000010,C4-BLR0000000021,
				E1-BLR0000000034,E2-BLR0000000035,E3-BLR0000000036
				풍선
				A3-BLR0000000003,A6-BLR0000000006,	B4-BLR0000000013,
				B6-BLR0000000015,C3-BLR0000000020,C5-BLR0000000022,
				D4-BLR0000000029,D5-BLR0000000030,E4-BLR0000000037,
				E7-BLR0000000040,E8-BLR0000000041,E9-BLR0000000059
			*/
			//var larr=["BLR0000000004","BLR0000000010","BLR0000000021","BLR0000000034","BLR0000000035","BLR0000000036"];
			//var barr=["BLR0000000003","BLR0000000006","BLR0000000013","BLR0000000015","BLR0000000020","BLR0000000022","BLR0000000029","BLR0000000030","BLR0000000037","BLR0000000040","BLR0000000041","BLR0000000059"];
			//20200113:D5를 파란색으로, E3를 빨간색으로 이실장님
			var larr=["BLR0000000004","BLR0000000010","BLR0000000021","BLR0000000030","BLR0000000034","BLR0000000035"];
			var barr=["BLR0000000003","BLR0000000006","BLR0000000013","BLR0000000015","BLR0000000020","BLR0000000022","BLR0000000029","BLR0000000036","BLR0000000037","BLR0000000040","BLR0000000041","BLR0000000059"];


			var lcls="";
			var bcls="";
			//console.log($.inArray(list[i]["bo_code"],larr));
			//if($.inArray(list[i]["bo_code"],larr)>-1){var lcls="loas";}else{var lcls="";}
			//if($.inArray(list[i]["bo_code"],barr)>-1){var bcls="balloon";}else{var bcls="";}
			//data+="<li class='list"+(i+1)+" "+list[i]["bo_status"]+" "+sel+"' style='margin:"+arr[0]+"% 0 0 "+arr[1]+"%;' id='"+list[i]["bo_code"]+"' >";
			data+="<li class='list"+(i+1)+" "+lcls+bcls+" "+list[i]["bo_status"]+" "+sel+"' style='margin:"+list[i]["bo_top"]+"% 0 0 "+list[i]["bo_left"]+"%;' id='"+list[i]["bo_code"]+"' >";
			data+="	<a href=\"javascript:setboiler('"+list[i]["bo_code"]+"');\">";
			data+="	<span class='name'>"+list[i]["bo_title"]+"</span>";
			data+="	<span class='stxt'>"+list[i]["statustxt"]+statustxt+"</span>";
			data+="	</a>";
			data+="	</li>";
		}
		data+="</ul>";

	//console.log("data_boilerView************"+data);
		$("#"+pgid).html(data);
	}
	function packingView(pgid, list)  //getboiler
	{
		var ordercode=$("#ordercode").attr("value");
		var data =statustxt= sel="";
		var len = list.length;
		data="<div id='steppackingDiv' class='steppacking' onclick='gostepboiler();'>◀&nbsp;&nbsp;탕전기선택화면</div>";
		data+="<ul class='packingview'>";
		for(i=0;i<len;i++)
		{
			sel="";
			statustxt=(list[i]["pa_status"]=="hold") ? "됨":"";
			if(!isEmpty(list[i]["pa_odcode"])&&ordercode==list[i]["pa_odcode"])
			{
				sel="select";
				statustxt="";
			}
			data+="<li class='"+list[i]["pa_status"]+" "+i+" "+sel+"' style='margin:"+list[i]["pa_top"]+"% 0 0 "+list[i]["pa_left"]+"%;' id='"+list[i]["pa_code"]+"' >";
			data+="	<a href=\"javascript:setpacking('"+list[i]["pa_code"]+"');\">";
			data+="	<span class='name'>"+list[i]["pa_title"]+"</span>";
			data+="	<span class='stxt'>"+list[i]["statustxt"]+statustxt+"</span>";
			data+="	</a>";
			data+="	</li>";
		}
		data+="</ul>";

	//console.log("data_boilerView************"+data);
		$("#"+pgid).html(data);
	}

	function dcUseView(pgid, dcCooling, dcSterilized)
	{
		var data=statustxt="";

		if(dcCooling)
		{
			data+="<dt class='hide'>cooling</dt>";
			data+="<div class='dtl'>";
			data+="<span class='img'>";
			data+="<img src='/_Img/icon_cool.png' alt='' />";
			data+="</span>";
			data+="</div>";
			data+="</dd>";
		}

		if(dcSterilized)
		{
			data+="<dt class='hide'>sterilized</dt>";
			data+="<dd>";
			data+="<div class='dtl dtl2'>";
			data+="<span class='img'>";
			data+="<img src='/_Img/icon_micro.png' alt='' />";
			data+="</span>";
			data+="</div>";
			data+="</dd>";
		}
		//console.log("dcUseView************"+data);
		$("."+pgid).html(data);
	}

	function medigroupView(pgid, decolist, demedilist, meditxt)
	{
		var txt=stat=statname="";
		var len = decolist.length;
		var odSitecategory=$("input[name=odSitecategory]").val();
		console.log("odSitecategory = " + odSitecategory);
		for(i=0;i<len;i++)
		{
			if(decolist[i]["cdCode"])
			{
				stat = decolist[i]["cdCode"];
				statname = decolist[i]["cdName"];
			}
			else
			{
				stat = "basic";
				statname = "<?=$txtdt['basic']?>";  //기본
			}

			var demedi = demedilist[stat];
			if(!isEmpty(demedi))
			{
				if(odSitecategory=="PNUH")
				{
					txt+="<dl id='decoc_"+stat+"' class='medigroup' onclick=\"checkbarcode('MDT0000000000');\">";
					txt+="<dt class='medigroupfonton'>"+statname+"</dt>";

				}
				else
				{
					txt+="<dl id='decoc_"+stat+"' class='medigroup'>";
					txt+="<dt class='medigroupfonton'>"+statname+"</dt>";
				}
			}
			else
			{
				txt+="<dl id='decoc_"+stat+"' class='medigroup'>";
				txt+="<dt class='medigroupfontoff'>"+statname+"</dt>";
			}
			
			

			/*
			var demedi = demedilist[stat];
			if(!isEmpty(demedi))
			{
				
				
				var arr = demedi.split(",");
				if(!isEmpty(arr))
				{
					
					for(j=0;j<arr.length;j++)
					{
						if(!isEmpty(arr[j]))
						{
							txt+="<dd>";
							txt+="	<div class='dtl'>";
							txt+=meditxt[arr[j]]["name"]+" ";
							txt+=" "+meditxt[arr[j]]["origin"];
							txt+="		<span class='property'>";
							if(meditxt[arr[j]]['poison'] == "Y")
							{
								txt+="<span class='p_type1'><?=$txtdt['poison']?></span>";  //독성
							}
							if(meditxt[arr[j]]['addiction'] == "Y")
							{
								txt+="<span class='p_type1'><?=$txtdt['addicted']?></span>";//중독성
							}
							txt+="		</span>";
							txt+="	</div>";
							txt+="</dd>";
						}
					}
				}
			}*/
			txt+="</dl>";
		}
		//console.log("medigroupView**********"+txt);
		$("."+pgid).append(txt);
		//$("."+pgid).prepend(txt);
	}

	function decolistView(pgid, list)
	{
		var txt="";
		var len = list.length;
		var graphRatio= (100/len);

		for(i=0;i<len;i++)
		{
			txt+="<span class='flow"+[i+1]+"'  style='width:"+graphRatio+"%'>";
			txt+="<time>";
			txt+="<dfn>"+list[i]["cdName"]+"</dfn>";
			txt+="</time>";
			txt+="</span>";
		}
		//console.log("decolistView**********"+txt);
		$("#"+pgid).prepend(txt);
	}

	function showboiler()
	{
		$("#decocproc").data("stepbp", "boiler");
		$("#boilerDiv").show();
		$("#packingDiv").hide();
		$("#steppackingDiv").hide();
	}
	function showpacking()
	{
		$("#decocproc").data("stepbp", "packing");
		$("#boilerDiv").hide();
		$("#packingDiv").show();
		$("#steppackingDiv").show();
	}
	callapi('GET','decoction','decoctionlist',"<?=$apiData?>");
</script>
