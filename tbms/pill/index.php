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

	dl.confirmbtn{text-align:center;width:100%;padding:10px;overflow:hidden;}
	dl.confirmbtn dd{display:inline-block;padding:20px;width:100px;margin:20px 20px;border:1px solid #111;background:#fff;font-weight:bold;font-size:25px;}
	#pass{width:100%;padding:10px 50px;font-size: 30px;font-weight: bold;color:#fff;border-radius: 3px;}

	div.donediv{overflow:hidden;background:#ccc;width:1200px;height:560px;padding:0 5px 0 5px;}
	div.donediv div{float:left;width:1160px;height:360px;text-align: left;}
	.donecontent{display:block;background:#fff;float:left;text-align:center;width:17%;margin:10px 20px;padding:0;font-size:27px;font-weight:bold;line-height:1.5em;}
	.doneok{float:right;width:250px;height:50px;background:green;color:white;font-size:30px;padding:10px 0;margin:0 20px;text-align:center;font-weight:bold;}
	.doneclose{float:right;width:250px;height:50px;background:gray;color:white;font-size:30px;padding:10px 0;margin:0 20px;text-align:center;font-weight:bold;}

	.calloutp{padding:10px;}
	.calloutp-success{background:#019C50;}
	.calloutp-warning{background:#F19113;}
	.calloutp-danger{background:#F19113;}
	.calloutp-info{background:#00B8ED;}
	.calloutp h4, .callout p{color:#fff;}
	.calloutp h4{font-size:15px;padding-bottom:10px;}


	.pill dl{width:20%;margin:1%;display:inline-block;vertical-align:top;}
	.pill dl dt{width:auto;border:1px solid #ddd;border-radius:7px;text-align:center;padding:35px 10px;color:#fff;font-size:30px;font-weight:bold;}
	.pill dl dt.on, .pill dl dt:hover{color:#111;border:1px solid #48DAFF;background:#48DAFF;}
	.pill dl dd{margin:2px auto;width:100%;}
	.pill dl dt:hover{background:#D7DBDD;color:#000;}

</style>

<div class="page">
	<?php include_once $root."/_Inc/left.php"; ?>
	<div class="container" id="containerDiv" value="<?=$depart?>" data-value="<?=$pillprocess?>">
		<div class="section_pill">			
			<div id="my_camera" style="display:none;position:absolute;z-index:9999;margin:2px 0 0 -140px;"></div>
			<div id="snapshot" style="display:none;position:absolute;z-index:9999;width:640px;height:480px;margin:2px 0 0 0;border:10px solid #777;background:#fff;"></div>
			<?php include_once $root."/_Inc/navi.php"; ?>
			<div style="display:none">
			<input type="hidden" id="plStatus" name="plStatus" value=""/>
			<input type="hidden" id="plMachinestat" name="plMachinestat" value=""/>
			<input type="hidden" id="pilltypeName" name="pilltypeName" value=""/>
			<input type="hidden" id="plMachine" name="plMachine" value=""/>
			<textarea name="odRequest" id="odRequest" cols="500" rows="5" style="display:none"></textarea>
			<textarea id="pilllist" cols="100" rows="100" style="display:none;"></textarea>
			<textarea id="opjson" name="opjson" style="display:none;"></textarea>
			</div>
			<section id="pill" class="section" value="<?=$_COOKIE["ck_pilltype"]?>">
				<ol class="sect_step" id="step_info"></ol>
				
				<div id="maindiv">
				</div>
			</section>
		</div>
	</div>
</div>




<?php include_once $root."/_Inc/tail.php"; ?>
<script>
	function setRequestPopup()
	{
		var h=$(window).height();
		var content=$("textarea[name=odRequest]").val();
		var txt="<div id='requestscreen' style='position:fixed;width:100%;top:0;background:#000;opacity:0.4;height:"+h+"px; z-index:999;'></div><div id='makingtblestatdiv' style='position:absolute;width:100%;z-index:1000;' onclick='requestOnClick();'><div id='requeststat' style='position:relative;width:1200px;max-height:400px;margin:150px auto;padding:0;background:#fff;'><div class='requestdiv' id='requestdiv'><p class='requesttitle'>요청사항</p><div class='requestcontent' id='requestcontent'>"+content+"</div><p class='reuqestok'><?=$txtdt['confirm']?></p></div></div></div>";
		$("body").prepend(txt);
	}
	function requestOnClick()
	{
		console.log("requestOnClickrequestOnClickrequestOnClickrequestOnClickrequestOnClick");
		$("#makingtblestatdiv").remove();
		$("#requestscreen").remove();
		$("#mainbarcode").focus();
	}
	function selectpill(type, pilltype)
	{
		setCookie("ck_pilltype", type, 365);
		location.reload();
	}
	function viewpilltable(pgid, list, pilltype)
	{
		var str=cls="";
		str+="<h3 class='matable'>진행하실 작업을 선택해 주세요.</h3>";//조제대를 선택해 주세요.
		str+="<div class='pill'>";
		for(var key in list)
		{
			cls="";
			if(list[key]["type"]==pilltype)
			{
				cls="on";
			}
			str+="<dl id='"+list[key]["type"]+"' onclick='selectpill(\""+list[key]["type"]+"\", \""+pilltype+"\")'>";
			str+="<dt class='"+cls+"'>"+list[key]["name"]+"</dt>";
			str+="</dl>";
		}
		str+="</div>";


		$("#"+pgid).html(str);

	
		setTimeout("$('#mainbarcode').focus()",700);
	}
	//장비리스트 
	function viewMachine(pgid, list, data)
	{	
		var ordercode=$("#ordercode").attr("value");
		var str=cls="";
		var len=i=j=left=0;
		var darr={};
		var mhData={};
		if(!isEmpty(data))
		{
			darr=data.split("|");
			for(i=1;i<darr.length;i++)
			{
				var karr=darr[i].split(",");
				mhData[karr[0]]=karr[1];
			}
		}

		var clsArr = new Array("one","two","three");
		var clsok="";
		for(var key in list) 
		{
			len=list[key].length;
			str+="<div><ul class='machinview'>";
			for(i=0;i<len;i++)
			{
				if(!isEmpty(mhData))
				{
					if(list[key][i]["mcCode"]==mhData[key])
					{
						clsok="machine"+clsArr[j%3]+"ok";
					}
					else
					{
						clsok="";
					}
				}
				else
				{
					clsok="";
				}

				left=j*9;
				str+="<li class='list"+(i+1)+" "+clsArr[j%3]+" "+clsok+"' style='margin:"+list[key][i]["mcTop"]+"% 0 0 "+left+"%;' id='"+list[key][i]["mcCode"]+"' data-type='"+list[key][i]["mcType"]+"'>";
				str+="	<a href=\"javascript:machineok('"+list[key][i]["mcCode"]+"', '"+clsArr[j%3]+"', '"+list[key][i]["mcStatus"]+"');\">";
				str+="	<span class='name'>"+list[key][i]["mcTitle"]+"</span>";
				str+="	<span class='stxt'>"+list[key][i]["mcStatusName"]+"</span>";
				str+="	</a>";
				str+="	</li>";
			}
			str+="</ul></div>";
			j++;

		}


		$("#"+pgid).data("totcnt",j);
		$("#"+pgid).html(str);
	}
	function machineok(id, cls, stat)
	{
		var no=$("#step_info").find("li.on").index();
		if(no==2)
		{
			if(stat!="ing")
			{
				$(".machinview li").removeClass("machine"+cls+"ok");
				$("#"+id).addClass("machine"+cls+"ok");

				var totmachine=$("#machinDiv").data("totcnt");
				var clsArr = new Array("one","two","three");
				var totok=0;
				var plmachine="";
				for(var key in clsArr) 
				{
					totok+=$(".machine"+clsArr[key]+"ok").length;
					if($(".machine"+clsArr[key]+"ok").length>0)
					{
						var type=$(".machine"+clsArr[key]+"ok").data("type");
						var code=$(".machine"+clsArr[key]+"ok").attr("id");
						console.log("type="+type+", code="+code);
						plmachine+="|"+type+","+code;
					}
				}
				
				$("input[name=plMachine]").val(plmachine);
			
				if(totmachine==totok)
				{
					console.log("똑같다 약재로 가자");
					var totmedicine=$("#medicineDiv").data("totcnt");
					console.log("totmedicine = " + totmedicine);
					if(totmedicine>0)
					{
						layersign('success', '약재를 선택해 주세요. ','','1000');
						gotostep(3);
					}
					else
					{
						layersign('success', '종류를 확인해 주세요. ','','1000');
						gotostep(4);
					}
				}
			}
		}
	}
	function viewMedicine(pgid, list)
	{
		var ordercode=$("#ordercode").attr("value");
		var data="";
		var len=list.length;
		console.log("viewMedicine  ordercode = " + ordercode+", len = " + len);


		data="<ul class='medicineview'>";
		for(i=0;i<len;i++)
		{
			var top=Math.floor(i/2)*6;
			var left=(i%2)*11;
			console.log("i = " + i+", code = " + list[i]["code"]+", i/2="+Math.floor(i/2)+", top = " + top+", left = "+left);
			data+="<li class='list"+(i+1)+"' style='margin:"+top+"% 0 0 "+left+"%;' id='"+list[i]["code"]+"' >";
			data+="	<a href=\"javascript:medicineok('"+list[i]["code"]+"');\">";
			data+="	<span class='name'>"+list[i]["name"]+"</span>";
			data+="	<span class='capa'>"+list[i]["capa"]+"</span>";
			data+="	<span class='stxt'>-</span>";
			data+="	</a>";
			data+="	</li>";
		}
		data+="</ul>";

		console.log("viewMedicine  data = " + data);

		$("#"+pgid).data("totcnt",len);
		$("#"+pgid).html(data);
	}
	function viewMakingMedicine(pgid, list)
	{
		var ordercode=$("#ordercode").attr("value");
		var data="";
		var len=list.length;
		console.log("viewMakingMedicine  ordercode = " + ordercode+", len = " + len);


		data="<ul class='medicineview'>";
		for(i=0;i<len;i++)
		{
			var top=Math.floor(i/2)*6;
			var left=(i%2)*11;
			console.log("i = " + i+", code = " + list[i]["code"]+", i/2="+Math.floor(i/2)+", top = " + top+", left = "+left);
			data+="<li class='list"+(i+1)+"' style='margin:"+top+"% 0 0 "+left+"%;' id='"+list[i]["code"]+"' >";
			data+="	<a href=\"javascript:medicineok('"+list[i]["code"]+"');\">";
			data+="	<span class='name'>"+list[i]["title"]+"</span>";
			data+="	<span class='capa'>"+list[i]["medicapa"]+"</span>";
			data+="	<span class='stxt'>"+list[i]["origin"]+"</span>";
			data+="	</a>";
			data+="	</li>";
		}
		data+="</ul>";

		console.log("viewMakingMedicine  data = " + data);

		$("#"+pgid).data("totcnt",len);
		$("#"+pgid).html(data);
	}
	function medicineok(id)
	{
		var no=$("#step_info").find("li.on").index();
		if(no==3)
		{
			$("#"+id).addClass("medicineok");

			var totok=$(".medicineok").length;
			var totmedicine=$("#medicineDiv").data("totcnt");
			var pltype=getCookie("ck_pilltype");

			console.log("medicineok  pltype = " + pltype+", totok = " + totok+", totmedicine = " + totmedicine);
			//if(pltype=="making")
			{
				var totcapa=capa=0;

				$('.medicineok .capa').each(function(){
				  capa = parseInt($(this).text());
				  totcapa+=capa;
				  console.log("medicineok  capa="+capa+", totcapa = "+totcapa);
				});
			
				var plMachinestat=$("input[name=plMachinestat]").val();
				if(plMachinestat.match("_processing"))
				{
					$("input[name=outcapa]").val(totcapa);
				}
				else
				{
					$("input[name=incapa]").val(totcapa);
				}
			}

			if(totmedicine==totok)
			{
				var tottype=$("#pilltypeDiv").data("totcnt");
				console.log("medicineok  tottype = " + tottype);
				if(tottype>0)
				{
					console.log("medicineok  똑같다 종류로 가자");
					layersign('success', '종류를 확인해 주세요. ','','1000');
					gotostep(4);
				}
				else
				{
					console.log("medicineok  똑같다 다음스텝 넘어가자!!");
					var msg=$("#step_info_INP_steppill61").text();
					layersign('success', msg,'','1000');
					gotostep(5);
				}


			}
		}
	}
	function componentok(id)
	{
		var no=$("#step_info").find("li.on").index();
		if(no==4)
		{
			$("#"+id).addClass("componentok");
			var totok=$(".componentok").length;
			var totgoods=$("#pilltypeDiv").data("totcnt");

			if(totgoods==totok)
			{
				console.log("똑같다 다음스텝 넘어가자!!");
				gotostep(5);
			}
		}
	}
	function pillcapaok()
	{
		var no=$("#step_info").find("li.on").index();
		if(no==5)
		{
			var msg=$("#step_info_PIL_steppill72").text();
			layersign('success', msg,'','1000');
			gotostep(6);
		}		
	}
	function viewTypeData(pgid, worktxt, list)
	{
		var pltype=getCookie("ck_pilltype");
		var data='';
		var cnt=0;

		switch(pltype)
		{
		case "making"://조제
			break;
		case "packing"://포장
			for(var key in list) 
			{
				data+='	<dl id="'+pltype+key+'" onclick="componentok(\''+pltype+key+'\');">';
				data+='		<dt>'+list[key]["name"]+'</dt>';//포장이름  
				data+='		<dd class="img"><img src="'+getUrlData("FILE_DOMAIN")+list[key]["file"]+'"  onerror="this.src=\'<?=$root?>/_Img/noimg.png\'" /></dd>';//포장이미지 
				data+='	</dl>';
				cnt++;
			}
			break;
		default:
			var workarr=worktxt.split("|");
			var worklen=workarr.length;
			cnt=worklen-1;
			for(var i=1;i<worklen;i++)
			{
				var workdata=workarr[i].split(",");
				data+='	<dl id="'+pltype+i+'" onclick="componentok(\''+pltype+i+'\');">';
				data+='		<dt>'+workdata[0]+'</dt>';
				data+='		<dd>'+workdata[1]+'</dd>';
				data+='	</dl>';
			}
			break;
		}
		
		$("#"+pgid).data("totcnt",cnt);

		$("#"+pgid).html(data);


	}
	function setPillList(list)
	{
		var pretty = JSON.stringify(list);
		document.getElementById('pilllist').value = pretty;
	}
	function getPillList()
	{
		var ugly = document.getElementById('pilllist').value;
		var list = JSON.parse(ugly);
		return list;
	}
	function setOrderpill()
	{
		/*
		console.log("setOrderpill  ======");
		if(!isEmpty($("textarea[name=opjson]").val()))
		{
			var pilltype=getCookie("ck_pilltype");

			var adpill=JSON.parse($("textarea[name=opjson]").val());
			//$gdPillorder=json_decode($rcPillorder, true);

			console.log(adpill);
			//pillorder data 풀기 
			var poarr=adpill["pilllist"];
			console.log(poarr);

			//해당하는 타입의 capa들을 셋팅하여 넣는다. 
			var outcapa=$("input[name=outcapa]").val();
			var incapa=$("input[name=incapa]").val();
			var originincapa=$("input[name=originincapa]").val();
			var originoutcapa=$("input[name=originoutcapa]").val();

			for(var key in poarr)
			{
				//console.log(poarr[key]);
				if(poarr[key]["type"]==pilltype)
				{
					poarr[key].originincapa=originincapa;
					poarr[key].originoutcapa=originoutcapa;
					poarr[key].incapa=incapa;
					poarr[key].outcapa=outcapa;
				}
			}


			//console.log(poarr);
			console.log(adpill);
			console.log(JSON.stringify(adpill));
			//$("textarea[name=opjson]").val(JSON.stringify(adpill));
		}
		*/
	}
	function makepage(json)
	{
		var obj = JSON.parse(json);
		var depart = "<?=$depart?>";
		console.log(obj);

		if(obj["apiCode"]=="pilllist") //조제리스트
		{
			//steptxtdt를 쓰려면 txt를 꼭 먼저 셋팅해야함.
			setTxtdt(obj["txtdt"]);

			viewbacodearea("containerDiv", obj["step"]["list"]);

			viewstatusstep("step_info", obj["step"], "<?=$language;?>");
			viewstatusstep("sect_step", obj["step"], "<?=$language;?>");
			
			
			setPillList(obj["pilllist"]);
			viewpilltable("maindiv", obj["pilllist"], getCookie("ck_pilltype"));
			getstaffInfo("staffinfo", null);//staff 리스트
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
		else if(obj["apiCode"]=="pillmain")
		{
			$("input[name=plMachine]").val(obj["plMachine"]);
			$("input[name=pilltypeName]").val(obj["pilltypeName"]);
			$("input[name=plMachinestat]").val(obj["plMachinestat"]);

			$("textarea[name=opjson]").val(obj["rcPillorder"]);

			$("textarea[name=odRequest]").val(obj["odRequest"]);
			

			$("#plcapa").text();
			
			
			//장비리스트
			viewMachine("machinDiv",obj["machineList"], obj["plMachine"]);
			//약재리스트
			if(obj["pilltype"]=="making")
			{
				viewMakingMedicine("medicineDiv",obj["medicineList"]);
			}
			else
			{
				viewMedicine("medicineDiv",obj["medicineList"]);
			}
			//종류별 데이터 
			viewTypeData("pilltypeDiv",obj["worktxt"], obj["packingList"]);

			//status에 따라 incapa , outcapa 
			
			
			
			$("input[name=originincapa]").val(obj["incapa"]);
			$("input[name=originoutcapa]").val(obj["outcapa"]);
			if(obj["plMachinestat"].match("_processing"))
			{
				$("input[name=outcapa]").val(0);
				$("#plcapa").text(obj["incapa"]);
				$("#ploutcapa").text(obj["outcapa"]);
				gotostep(3);
				$("#step_info_INP_steppill41").text("산출재료를 선택해 주세요");//일단임시 나중에 수정해야함 
				status_txt=getTxtdt('step61');//산출량을 선택해 주세요.
				console.log("pill = " + status_txt);
				$("#step_info_INP_steppill61").text(status_txt);
				$("#sect_step_INP_steppill61").text(status_txt);
				$("input[name=incapa]").hide();
				$("input[name=outcapa]").show();
				//$("#plcapaName").text("산출량");
			}
			else
			{
				$("input[name=incapa]").val(0);
				console.log(obj["incapa"]+"__"+obj["outcapa"]);
				$("#plcapa").text(obj["incapa"]);
				$("#ploutcapa").text(obj["outcapa"]);
				$("input[name=incapa]").show();
				$("input[name=outcapa]").hide();
				//$("#plcapaName").text("투입량");


				setRequestPopup();
			}

			setOrderpill();

			
		}
	}

	callapi('GET','pill','pilllist',"<?=$apiData?>");
</script>
