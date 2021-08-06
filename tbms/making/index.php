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

	div.scalediv{overflow:hidden;background:#ccc;width:1000px;height:400px;padding:0 5px 0 5px;}
	div.scalediv div{float:left;width:960px;height:360px;text-align: center;}
	.scalemodetitle{width:auto;background:#fff;color:green;font-size:50px;padding:10px 0;margin:20px;text-align:center;font-weight:bold;}
	.scalemodesingle{float:left;width:450px;height:150px;background:#CE8D92;color:white;font-size:40px;padding:10px 0;margin:20px 20px 20px 30px;text-align:center;font-weight:bold;line-height:130px;}
	.scalemodetotal{float:left;width:450px;height:150px;background:#2B7499;color:white;font-size:40px;padding:10px 0;margin:20px 20px 20px 25px;text-align:center;font-weight:bold;line-height:130px;}



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

</style>

<div class="page">
	<?php include_once $root."/_Inc/left.php"; ?>
	<div class="container" id="containerDiv" value="<?=$depart?>" data-value="<?=$makingprocess?>">
		<div class="section_making">			
			<div id="my_camera" style="display:none;position:absolute;z-index:9999;margin:2px 0 0 -140px;"></div>
			<div id="snapshot" style="display:none;position:absolute;z-index:9999;width:640px;height:480px;margin:2px 0 0 0;border:10px solid #777;background:#fff;"></div>
			<?php include_once $root."/_Inc/navi.php"; ?>
			<div style="display:none">
			<input type="hidden" id="scaleMode" name="scaleMode" value="" style="color:#fff;border:1px solid #fff;" />
			<input type="hidden" id="passCapa" name="passCapa" value="" style="color:#fff;border:1px solid #fff;" />
			<textarea id="medidata" cols="500" rows="5" style="display:none"></textarea>
			<textarea id="medicapadata" cols="500" rows="5" style="display:none"></textarea>
			<textarea name="odRequest" id="odRequest" cols="500" rows="5" style="display:none"></textarea>
			<textarea name="donetxtContent" id="donetxtContent" cols="500" rows="5" style="display:none"></textarea>
			</div>
			<section id="making" class="section" value="<?=$_COOKIE["ck_matable"]?>">
				<ol class="sect_step" id="step_info"></ol>
				<div id="maindiv">
				</div>
			</section>
		</div>
	</div>
</div>
			


<?php 
include_once $root."/_Inc/tail.php"; 
?>
<script>
	function setRequestPopup()
	{
		var h=$(window).height();
		var content=$("textarea[name=odRequest]").val();
		var txt="<div id='requestscreen' style='position:fixed;width:100%;top:0;background:#000;opacity:0.4;height:"+h+"px; z-index:999;'></div><div id='makingtblestatdiv' style='position:absolute;width:100%;z-index:1000;' onclick='requestOnClick();'><div id='requeststat' style='position:relative;width:1200px;max-height:400px;margin:150px auto;padding:0;background:#fff;'><div class='requestdiv' id='requestdiv'><p class='requesttitle'><?=$txtdt['reqorder']?></p><div class='requestcontent' id='requestcontent'>"+content+"</div><p class='reuqestok'><?=$txtdt['confirm']?></p></div></div></div>";
		$("body").prepend(txt);
	}

	function requestOnClick()
	{
		var scaleMode=$("input[name=scaleMode]").val();
		console.log("requestOnClickrequestOnClickrequestOnClickrequestOnClickrequestOnClick  scaleMode = " + scaleMode);
		$("#makingtblestatdiv").remove();
		$("#requestscreen").remove();
		$("#mainbarcode").focus();
		if(isEmpty(scaleMode))
		{
			setScaleMode();
		}
	}

	function setScaleMode()
	{
		var h=$(window).height();
		var txt="<div id='requestscreen' style='position:fixed;width:100%;top:0;background:#000;opacity:0.4;height:"+h+"px; z-index:999;'></div><div id='makingtblestatdiv' style='position:absolute;width:100%;z-index:1000;'><div id='scalestat' style='position:relative;width:1000px;max-height:400px;margin:180px auto;padding:0;background:#fff;'><div class='scalediv' id='scalediv'><p class='scalemodetitle'>저울모드</p><button type='button' onclick='scalemodeupdate(\"Y\");' class='scalemodesingle'>개별모드</button><button type='button' onclick='scalemodeupdate(\"N\");' class='scalemodetotal'>누적모드</button></div></div></div>";
		$("body").prepend(txt);
	}
	function scalemodeupdate(type)
	{
		var ordercode=$("#ordercode").attr("value");
		console.log("scalemodeupdatescalemodeupdatescalemodeupdate type = " + type+", ordercode = " + ordercode);
		var data="ordercode="+ordercode+"&type="+type;
		console.log("scalemodeupdatescalemodeupdatescalemodeupdate type = " + type+", ordercode = " + ordercode+", data = " + data);
		callapi('GET','making','scalemodeupdate',data);

		$("#makingtblestatdiv").remove();
		$("#requestscreen").remove();
		$("#scalediv").remove();
		$("#mainbarcode").focus();
	}

	function returnBarcode(){
		$("#mainbarcode").focus();
	}

	function resetmTable()
	{
		deleteCookie("ck_matable");
		deleteCookie("ck_matabletitle");
		location.reload();
	}
	function selectTable(no,title,status,staff)
	{
		if(status==""||status=="ready")
		{
			setCookie("ck_matable", no, 365);
			setCookie("ck_matabletitle", title, 365);
			location.reload();
		}
		else
		{
			if(status=="hold" && staff == getCookie("ck_stUserid"))
			{
				setCookie("ck_matable", no, 365);
				setCookie("ck_matabletitle", title, 365);
				location.reload();
			}
			else
			{
				var str="<?=$txtdt['clearselecttable']?>"; //현재 []가 사용중입니다.<br/>해제하고 사용하시겠습니까?
				str=str.replace('[]',staff);
				str=str.replace('<br/>',"\n");
				if(confirm(str))
				{
					setCookie("ck_matable", no, 365);
					setCookie("ck_matabletitle", title, 365);
					location.reload();
				}
			}
		}
	}
	function mtablestat(code)
	{
		var str = "<?=$txtdt['wait']?>";//대기
		switch(code)
		{
			case "start":str="<?=$txtdt['begin']?>";break;//시작
			case "finish":str="<?=$txtdt['end']?>";break;//종료
			case "hold":str="<?=$txtdt['preparing']?>";break;//준비중
			default:str="<?=$txtdt['wait']?>";break;//대기
		}
		return str;
	}
	function viewmakingtable(pgid, list, matable)
	{
		var str = "";
		if(!isEmpty(matable))
		{
			str+='<h3 class="matable"><?=$txtdt["choicematable"]?><span class="" onclick="resetmTable()">[<?=$txtdt["resetmatable"]?>]</span></h3>';//선택된 조제대 / 다시선택
			str+='<dl class="matable" onclick="returnBarcode()"><dd><span>['+getCookie("ck_matable")+'] '+getCookie("ck_matabletitle")+'</span></dd></dl>';
		}
		else
		{
			str+='<h3 class="matable"><?=$txtdt["selectmatable"]?></h3>';//조제대를 선택해 주세요.
			str+='<dl class="matable">';
			for(var key in list)
			{
				//20191029 : 공통, 수동조제,제환실은 제외
				if(list[key]["mtCode"] == '00000' || list[key]["mtCode"] == '00080' || list[key]["mtCode"] == '99999' || list[key]["mtCode"] == '44444')
				{
				}
				else
				{
					str+='<dd onclick="selectTable(\''+list[key]["mtCode"]+'\',\''+list[key]["mtTitle"]+'\', \''+list[key]["mtStatus"]+'\', \''+list[key]["mtStaff"]+'\')">';
					str+='<span>';
					str+='['+list[key]["mtCode"]+'] '+list[key]["mtTitle"]+' <br><?=$txtdt["state"]?> '+mtablestat(list[key]["mtStatus"]); //상태
					str+='</span>';
					str+='</dd>';
				}
			}
			str+='</dl>';
		}
		$("#"+pgid).html(str);
		setTimeout("$('#mainbarcode').focus()",700);
	}
	function getDecoText(list, data)
	{
		var str="";
		for(var key in list)
		{
			checked = "";
			if(!isEmpty(data))
			{
				if(data == list[key]["cdCode"])
				{
					str=list[key]["cdName"];
					break;
				}
			}
			else if(i == 0)
			{
				str=list[key]["cdName"];
				break;
			}
		}
		return str;
	}

	function proccancel(){
		$('#layersign').remove();
		var odcode=$("#mainbarcode").val().replace("MKD","ODD");
		$("#mainbarcode").val("");
		$("#mainbarcode").focus();
		var data="medi=delete&stat=making_apply&code="+odcode+"&proc=&returnData=";
		callapi('GET','making','makingapplyupdate',data);
		setTimeout(function(){gomainload("../_Inc/list.php?depart=making");},500);
	}

	function procconfirm(){
		$('#layersign').remove();
		var odcode=$("#mainbarcode").val();
		checkbarcode(odcode);
	}

	function procdone()
	{
		var odcode=$("#mainbarcode").val().replace("MKD","ODD");
		setDoneMediboxBarcode(odcode);
	}

	function proDoneKeyDown(event)
	{
		if(event.keyCode == 13)
		{
			console.log("proDoneKeyDownproDoneKeyDownproDoneKeyDown");
			var ugly = document.getElementById('donetxtContent').value;
			var txtdt = JSON.parse(ugly);

			/*
			var infirst=!isEmpty($("input[name=proinfirst]").val()) ? $("input[name=proinfirst]").val() : "";
			var inmain=!isEmpty($("input[name=proinmain]").val()) ? $("input[name=proinmain]").val() : "";
			var inafter=!isEmpty($("input[name=proinafter]").val()) ? $("input[name=proinafter]").val() : "";
			var inlast=!isEmpty($("input[name=proinlast]").val()) ? $("input[name=proinlast]").val() : "";

			infirst=(!isEmpty($("#sinfirst").text())) ? "":infirst;
			inmain=(!isEmpty($("#sinmain").text())) ? "":inmain;
			inafter=(!isEmpty($("#sinafter").text())) ? "":inafter;

			//cllapi 
			var data="odcode="+$("#donecontent").data("code")+"&proinfirst="+infirst+"&proinmain="+inmain+"&proinafter="+inafter+"&proinlast="+inlast;

			
		
			
			*/
			var probarcode=$("input[name=probarcode]").val();

			var data="odcode="+$("#donecontent").data("code");

			if(!isEmpty(txtdt["proinfirst"]))
			{
				data+="&proinfirst="+probarcode;
			}
			if(!isEmpty(txtdt["proinmain"]))
			{
				data+="&proinmain="+probarcode;
			}
			if(!isEmpty(txtdt["proinafter"]))
			{
				data+="&proinafter="+probarcode;
			}
			if(!isEmpty(txtdt["proinlast"]))
			{
				data+="&proinlast=MDT0000000004";
			}

			console.log("data = " + data);
			callapi('GET','making','mediboxinupdate',data);

		}
	}


	function setDoneMediboxBarcode(odcode)
	{
		var ugly = document.getElementById('donetxtContent').value;
		var txtdt = JSON.parse(ugly);

		var txt="";
		txt="<div id='makingdonediv' style='position:absolute;width:100%;z-index:30000;' > ";
		txt+="	<div id='requeststat' style='position:relative;width:1000px;max-height:400px;margin:150px auto;padding:0;background:#fff;'> ";
		txt+="		<div class='donediv' id='donediv'> ";
		txt+="			<p class='requesttitle'><?=$txtdt['9020']?></p> ";
		txt+="			<div class='donecontent' id='donecontent' data-code='"+txtdt["promaodCode"]+"'> ";
		txt+="				<p><?=$txtdt['orderno']?> : "+txtdt["promaodCode"]+"</p>";
		txt+="				<p><?=$txtdt['hospital']?>/<?=$txtdt['oduser']?> : "+txtdt["prominame"]+" / "+txtdt["prorename"]+"</p>";
		txt+="				<p><?=$txtdt['scription']?> : "+txtdt["protitle"]+"</p><div style='height:2px;background-color:gray;width:99%;margin:5px;'></div>";
		txt+="				<div style='float:left;width:30%;height: 200px;margin-left:10px;'>";
		txt+="				 <input type='text' value='' class='probarcode' name='probarcode' id='probarcode' onkeydown='proDoneKeyDown(event);' /> ";
		txt+="				</div>";
		txt+="				<div class='doneright' style='float:right;width:60%;height:200px;'>";

		if(!isEmpty(txtdt["proinfirst"]))
		{
			txt+="				<p>선전 : <input type='text' value='' class='proinfirst' name='proinfirst' id='proinfirst' readonly/> <spna id='sinfirst'></span></p>";
		}
		if(!isEmpty(txtdt["proinmain"]))
		{
			txt+="				<p>일반 : <input type='text' value='' class='proinmain' name='proinmain' id='proinmain' readonly/> <spna id='sinmain'></span></p>";
		}
		if(!isEmpty(txtdt["proinafter"]))
		{
			txt+="				<p>후하 : <input type='text' value='' class='proinafter' name='proinafter' id='proinafter' readonly /> <spna id='sinafter'></span></p>";
		}
		if(!isEmpty(txtdt["proinlast"]))
		{
			txt+="				<p>별전 : <input type='text' value='MDT0000000004' class='proinlast' name='proinlast' id='proinlast' readonly /> <spna id='sinlast'></span></p>";
		}
		txt+="				<div>";
		txt+="			</div>";
		txt+="		</div> ";
		txt+="	</div>";
		txt+="			<p class='doneok' onclick='procdoneOK()'><?=$txtdt['procdone']?></p>";
		txt+="			<p class='doneclose' onclick='procdoneClose()'><?=$txtdt['close']?></p>";
		txt+="</div>";
		$("body").prepend(txt);

		$("#probarcode").focus();

	}

	function procdoneOK()
	{
		var ugly = document.getElementById('donetxtContent').value;
		var txtdt = JSON.parse(ugly);

		if(!isEmpty(txtdt["proinfirst"]))
		{
			if($("#sinfirst").text()=="")
			{
				popupDoneMessage("<?=$txtdt['infirst']?><?=$txtdt['9020']?>",'1000');//사용중이지 않거나 없는 
				return false;
			}
		}
		if(!isEmpty(txtdt["proinmain"]))
		{
			if($("#sinmain").text()=="")
			{
				popupDoneMessage("<?=$txtdt['inmain']?><?=$txtdt['9020']?>",'1000');//사용중이지 않거나 없는 
				return false;
			}
		}
		if(!isEmpty(txtdt["proinafter"]))
		{
			if($("#sinafter").text()=="")
			{
				popupDoneMessage("<?=$txtdt['inafter']?><?=$txtdt['9020']?>",'1000');//사용중이지 않거나 없는 
				return false;
			}
		}

		$("#makingdonediv").remove();
		$('#layersign').remove();
		var odcode=$("#mainbarcode").val().replace("MKD","ODD");

		$("#mainbarcode").val("");
		$("#mainbarcode").focus();
		var jsondata={};
		jsondata["code"]=odcode;
		callapi('POST','making','makingdone',jsondata);

		var data="odCode="+odcode;
		console.log("조제 마치는 시간 여기서 callapi   :"+data);
		callapi('GET','making','makingend',data);

		
	}
	function procdoneClose()
	{
		$("#makingdonediv").remove();
	}

	function passOnClick()
	{
		var mdtotal=total="";
		var st_ing_len = $(".contenton .st_ing").length;
		if(st_ing_len > 0 && $(".contenton .st_ing").attr('data-pass').indexOf('P') < 0)
		{
			if($(".contenton .addhold").length <= 0) //20190401 hold가 있으면 pass를 못하게 하자 
			{
				//totalcapa
				total=$("#medipocketcapa").text();
				mdtotal=parseInt(total.replace("g",""));

				var nowGram = parseInt($("#nowGram").text());
				var totalGram=parseInt($('#totalGram').text());
				var passCapa=parseInt($('#passCapa').val());
				
				//패스 클릭시 pass 약재량 = totalGram - nowGram
				var passGram = totalGram - nowGram;
				$('#passCapa').val(passCapa + parseInt(passGram));
				var mdbox=$(".contenton .st_ing").attr('data-value');
				var code= $(".contenton .st_ing").attr('data-code');

				//var mdcapa=($("#meditarget_"+code).attr('value'));
				//pass를 누르면 현재무게 그대로 업데이트 되게 하자!
				var mdpass="P"+nowGram;
				$(".contenton .st_ing").attr('data-pass', mdpass);

				var pass=$(".contenton .st_ing").attr('data-pass');
				//passTotal 이 아니고 현재 약새 전체 실 중량
				var passTotal=mdtotal + nowGram;
				//var codedata="MEI"+pad(passTotal,4)+"0000";
				var codedata="MEI"+pad(mdtotal,4)+"000";

				console.log("passOnClick  nowGram = "+nowGram+", code = " +code + ", mdcapa = "+totalGram+", mdbox = " + mdbox + ", mdtotal = "+mdtotal +", pass = " + pass+", codedata = " + codedata);

				//alert("passOnClick  code = " +code + ", mdcapa = "+totalGram+", mdbox = " + mdbox + ", mdtotal = "+mdtotal +", pass = " + pass+", codedata = " + codedata);
				
				insbarcode("MEI", codedata);
			}
		}
		//------------------------------
		//20190401 check 버튼 클릭시 포커스가 사라짐 
		$("#mainbarcode").focus();
		//------------------------------
	}

	function makepage(json)
	{
		var obj = JSON.parse(json);
		var depart = "<?=$depart?>";
		var status_txt="";
		console.log("makepage");
		console.log(obj);

		if(obj["apiCode"]=="makinglist") //조제리스트
		{
			//steptxtdt를 쓰려면 txt를 꼭 먼저 셋팅해야함.
			setTxtdt(obj["txtdt"]);
			viewbacodearea("containerDiv", obj["step"]["list"]);
			viewstatusstep("step_info", obj["step"], "<?=$language;?>");
			viewstatusstep("sect_step", obj["step"], "<?=$language;?>");
			viewmakingtable("maindiv", obj["makingTableList"], getCookie("ck_matable"));
			getstaffInfo("staffinfo", null);//staff 리스트
		}
		else if(obj["apiCode"]=="getstaff")
		{
			viewGetStaff(obj["data"], depart);
		}
		else if(obj["apiCode"]=="orderlist")
		{
			viewOrderList(obj["list"], obj["tpage"], obj["page"], obj["block"], obj["psize"]);

			setTimeout(function(){
				if(obj["resultCode"]=="999") //약재가 부족할 경우 
				{
					console.log("orderlist  gotostep(1) ");
					switch(obj["resultMessage"])
					{
						case "MEDISHORTAGE"://약재가 부족합니다.
							closelayer();
							var meditxt=obj["medi"]["medishortage"].substring(1);
							layersign('danger', getTxtData("MEDISHORTAGE"),meditxt,"close"); //약재가 부족합니다.
							//gomainload("../_Inc/list.php?depart=making");
							$("#procmember").html("");
							$("#procscription").html("");
							$("#procuser").html("");
							$("#gram").html("");

							$("#mainbarcode").focus();
							break;
						case "MEDIBOXNONE"://약재함이 존재하지 않거나 사용할수 없습니다.
							closelayer();
							var meditxt=obj["medi"]["mediboxnone"].substring(1);
							layersign('danger', getTxtData("MEDIBOXNONE"),meditxt,"close"); //약재함이 존재하지 않거나 사용할수 없습니다.
							//gomainload("../_Inc/list.php?depart=making");
							$("#procmember").html("");
							$("#procscription").html("");
							$("#procuser").html("");
							$("#gram").html("");
							$("#mainbarcode").focus();
							break;
					}
					
				}
				else
				{
					if(!isEmpty(obj["promaBarcode"]))
					{
						//작업 시작 시 이전작업 체크부분
						//-테이블 상태확인하여  null 이거나 start 일때는 팝업화면 정상표시
						//-scaned 일때는  팝업 창에서 스캔중 스크립트 없이 약재박스 선택된 화면표시
						//-finish 인 경우 작업 화면 표시
						//-그 외에는 테이블정보 초기화, 상태변경(apply)및 작업 초기화 후 리스트 리로딩

						console.log("stat == " + obj["promatableStat"]+",  table ==  " + obj["promatable"]);

						if(obj["promatableStat"]=="start" || obj["promatableStat"]==null || obj["promatableStat"] == "standby")
						{
							console.log("테이블 상태확인하여  null 이거나 start 일때는 팝업화면 정상표시"); //작업하러 가자
							checkbarcode(obj["promaBarcode"]);
						}
						else if(obj["promatableStat"]=="scaned")
						{
							console.log("scaned 일때는  팝업 창에서 스캔중 스크립트 없이 약재박스 선택된 화면표시"); //작업하러 가자
							checkbarcode(obj["promaBarcode"]);
							nextstep();
						}
						else if(obj["promatableStat"]=="finish")
						{
							console.log("finish 인 경우 작업 화면 표시"); //작업하러 가자
							$("#mainbarcode").val(obj["promaBarcode"]);
							setTimeout("layersign('danger', '<?=$txtdt['processingwork']?>','','confirm')",1000)	; //

							//20190828 :: 완료처리일시 부직포 바코드를 스캔 받기 위해서 임..
							var json={};
							json["promaodCode"]=obj["promaodCode"];
							json["protitle"]=obj["protitle"];
							json["prominame"]=obj["prominame"];
							json["prorename"]=obj["prorename"];

							json["proinfirst"]=obj["proinfirst"];
							json["proinmain"]=obj["proinmain"];
							json["proinafter"]=obj["proinafter"];
							json["proinlast"]=obj["proinlast"];

							console.log(JSON.stringify(json)); //작업하러 가자


							var pretty = JSON.stringify(json);
							document.getElementById('donetxtContent').value = pretty;

						}
						else
						{
							
							//---------------------------------------------------------
							//해당하는 order에 상태값을 apply로 바꾸자 
							//---------------------------------------------------------					
							data="medi=delete&stat=making_apply&code="+obj["promaodCode"]+"&proc=&returnData=";
							callapi('GET','making','makingapplyupdate',data);
							//---------------------------------------------------------
						}
					}
				}
			}, 500);
		}
		else if(obj["apiCode"]=="checkprocess")
		{
			viewCheckProcess(depart, obj["data"], obj["medi"], obj["proccode"], obj["code"], obj["stat"]);
		}
		else if(obj["apiCode"]=="checkmedipocket")
		{
			viewCheckmediPocket(depart, obj["data"], "<?=$https?>");
		}
		else if(obj["apiCode"]=="makingmain")
		{
			$("textarea[name=odRequest]").val(obj["od_request"]);
			//초기화하기 
			$("input[name=passCapaTotal]").val("0");
			$("input[name=passCapa]").val("0");
			var scaleMode=!isEmpty(obj["maScalemode"])?obj["maScalemode"]:"";
			$("input[name=scaleMode]").val(scaleMode);

			console.log("makingmain  scaleMode = " + scaleMode);

			
			
			//if(!isEmpty(obj["medi"]["medishortage"]))
			console.log("makingmainmakingmainmakingmainmakingmain  resultCode =  " + obj["resultCode"]);
			if(obj["resultCode"]=="999") //약재가 부족할 경우 
			{
				console.log("makingmain  gotostep(1) ");
				switch(obj["resultMessage"])
				{
					case "MEDISHORTAGE"://약재가 부족합니다.
						closelayer();
						var meditxt=obj["medi"]["medishortage"].substring(1);
						layersign('danger', getTxtData("MEDISHORTAGE"),meditxt,"close"); //약재가 부족합니다.
						gomainload("../_Inc/list.php?depart=making");
						$("#procmember").html("");
						$("#procscription").html("");
						$("#procuser").html("");
						$("#gram").html("");
						$("#addagainphoto").html("");
						gotostep(1);
						$("#mainbarcode").focus();
						break;
					case "MEDIBOXNONE"://약재함이 존재하지 않거나 사용할수 없습니다.
						closelayer();
						var meditxt=obj["medi"]["mediboxnone"].substring(1);
						layersign('danger', getTxtData("MEDIBOXNONE"),meditxt,"close"); //약재함이 존재하지 않거나 사용할수 없습니다.
						gomainload("../_Inc/list.php?depart=making");
						$("#procmember").html("");
						$("#procscription").html("");
						$("#procuser").html("");
						$("#gram").html("");
						$("#addagainphoto").html("");
						gotostep(1);
						$("#mainbarcode").focus();
						break;
				}
				
			}
			else
			{
				viewMakingMain(obj);
			}
		}
		else if(obj["apiCode"]=="checkmedibox")
		{
			console.log(obj["mediwait"]);
			// select mb_medicine from han_medibox a inner join han_medicine b on a.mb_medicine=b.md_code where a.mb_code='MDB0000000072'
			if(obj["mediwait"].indexOf(obj["data"]["mb_medicine"]) >= 0 || (obj["st_inlast"].indexOf(obj["data"]["mb_medicine"]) >= 0))
			{
				var capaQty=0;
				var maTable = getCookie("ck_matable");
				var dataTable = obj["data"]["mb_table"]; //조제대 
				var dataCapacity = parseInt($('#meditarget_'+obj["data"]["mb_medicine"]).attr('value'));

				

				if(!isEmpty(obj["medihold"]))
				{
					console.log("checkmediboxcheckmediboxcheckmediboxcheckmediboxcheckmediboxcheckmedibox addClass('st_finish')");
					setMedicineCapaUpdate();
					$('#medibox_'+obj["medihold"]).removeClass('addhold').removeClass('st_ing').addClass('st_finish');
				}
				//console.log("medicine : "+obj["data"]["mb_medicine"]+", ma조제대 : " + maTable+", 데이터 조제대  : " + dataTable + ", dataCapacity = " + dataCapacity+", 약재함 : " + obj["data"]["mb_capacity"]);
				if(dataTable == '00000' || maTable == dataTable) //공통약재이거나 조제대가 같다면 
				{
					capaQty=parseInt(obj["data"]["mb_capacity"]);//공통이 아닐 경우에는 약재함의 재고량으로만 체크 
					if(dataTable == '00000')  //공통일 경우 창고의 재고량과 더해서 확인한다. 
					{
						capaQty = parseInt(obj["data"]["md_qty"]) + parseInt(obj["data"]["mb_capacity"]); //창고의 재고량 + 약재함의 재고량 
					}
					if(capaQty >= dataCapacity)
					{
						//별전인경우
						if(obj["medigroup"]=="medibox_inlast")
						{
							var chkarr=obj["mediwait"].split(",");
							var arrlen=chkarr.length;
							//console.log("arrlen = " + arrlen);
							$('#medibox_'+obj["data"]["mb_medicine"]).removeClass('st_wait').addClass('st_finish');
							console.log("medibox_inlastmedibox_inlastmedibox_inlastmedibox_inlastmedibox_inlastmedibox_inlast   addClass('st_finish')");
							setSweetCapaUpdate(obj["data"]["mb_medicine"], obj["code"], dataCapacity, maTable);

							//---------------------------------------------------------
							var jsondata={};
							//console.log("별전 약재차감 ordercode = " + obj["odcode"]+", mdcode = " + mdcode+", data = " + data);
							jsondata["ordercode"]=obj["odcode"];//주문번호
							jsondata["mediCode"]=obj["data"]["mb_medicine"];//스캔받은약재코드
							jsondata["medibarcode"]=obj["code"];//스캔받은약재함의코드
							jsondata["mediCapa"]=dataCapacity;//스캔받은약재함의코드
							jsondata["mbTable"]=maTable;
							//console.log(JSON.stringify(jsondata));
							setMediTxtdt(jsondata);
							callapi('POST',"making",'medicinecapaupdate',jsondata);
							//---------------------------------------------------------

							if(arrlen<=2)
							{
								//---------------------------------------------------------
								var jsondata={};
								jsondata["odcode"]=obj["odcode"];
								callapi('POST',depart,'mediboxinlastupdate',jsondata);
								//---------------------------------------------------------
								console.log("checkmedibox inlast ==>makinggostep ");
								makinggostep();
								/*
								console.log(" inlist  gotostep(5) ");
								gotostep(5);
								layersign("success",getTxtData("9001"), "",'confirm_making');//정량을 확인 후 정상일 경우 작업지시서를 스캔해 주세요
								*/
							}
							else
							{							
								console.log("checkmedibox  gotostep(2) ");
								status_txt=getTxtdt("step30");
								$('#status_txt').text(status_txt);
								layersign('success',status_txt,'','1000');
								gotostep(2);
							}
						}
						else
						{
							console.log("checkmedibox  nextstep() ");
							$('#nowGram').text('0');
							$('#totalGram').text(comma(dataCapacity));
							$('#nowGramRight').text('g');
							$('#totalGramRight').text('g');

							$('#medibox_'+obj["data"]["mb_medicine"]).removeClass('st_wait').addClass('st_ing');
							$('#medibox_'+obj["data"]["mb_medicine"]).addClass('colorbox'); //선택한 약재 테두리 색상 변경  .boxcolor
							$('#medibox_'+obj["data"]["mb_medicine"]).addClass('ingcolor'); // 약재명도 글씨 색상 변경

							status_txt=getTxtdt("step40");//약재를 표시된 무게만큼 약재함에 올려주세요
							$('#status_txt').text(status_txt);
							layersign('success',status_txt,'','1000');
							nextstep();
						}

						$("#mainbarcode").focus();
					}
					else
					{
						$('#nowGram').text('0');
						$('#totalGram').text(comma(dataCapacity));
						if(obj["medigroup"]=="medibox_inlast")
						{
							$('#nowGramRight').text('ea');
							$('#totalGramRight').text('ea');
						}
						else
						{
							$('#nowGramRight').text('g');
							$('#totalGramRight').text('g');
						}
						$('#medibox_'+obj["data"]["mb_medicine"]).addClass('st_ing').addClass('st_stop_33');
						$('#medibox_'+obj["data"]["mb_medicine"]).addClass('colorbox'); //선택한 약재 테두리 색상 변경  .boxcolor
						$('#medibox_'+obj["data"]["mb_medicine"]).addClass('ingcolor'); // 약재명도 글씨 색상 변경
						status_txt=getTxtdt("step33");//약재가 부족합니다.
						$('#status_txt').text(status_txt);
						layersign('warning',status_txt,'','medi_confirm_short');

						var objtxt={};
						objtxt["code"]=obj["code"];
						setMediTxtdt(objtxt);

						$("#mainbarcode").focus();
						//medicapadata
					}

				}
				else
				{
					status_txt=getTxtdt("step31");//"약재 바코드 불일치, 다시 약재바코드를 스캔 해 주세요"
					$('#status_txt').text(status_txt);
					layersign('warning',status_txt,'','2000');
					$("#mainbarcode").focus();
				}
			}
			else
			{
				status_txt=getTxtdt("step32");//약재 바코드를 다시 스캔 해 주세요
				$('#status_txt').text(status_txt);
				layersign('warning',status_txt,'','2000');
				$("#mainbarcode").focus();
			}
			getsummary();
			cleardiv();
		}
		//**********************************************
		//20190402 makingscan ma_tablestat이 finish인지 체크하기 위해서 
		//**********************************************
		else if(obj["apiCode"]=="makingscan") 
		{
			rescanmap(obj);
		}
		//**********************************************
		else if(obj["apiCode"]=="mediboxinupdate")
		{
			if(obj["resultCode"]=="200")
			{
				if(obj["kind"]=="infirst")
				{
					$("input[name=proinfirst]").val(obj["infirst"]);
					$("input[name=proinfirst]").attr("disabled", true);
					$("#sinfirst").text("<?=$txtdt['done']?>");
					$("#probarcode").val("");
					$("#probarcode").focus();
				}
				else if(obj["kind"]=="inmain")
				{
					$("input[name=proinmain]").val(obj["inmain"]);
					$("input[name=proinmain]").attr("disabled", true);
					$("#sinmain").text("<?=$txtdt['done']?>");
					$("#probarcode").val("");
					$("#probarcode").focus();
				}
				else if(obj["kind"]=="inafter")
				{
					$("input[name=proinafter]").val(obj["inafter"]);
					$("input[name=proinafter]").attr("disabled", true);
					$("#sinafter").text("<?=$txtdt['done']?>");
					$("#probarcode").val("");
					$("#probarcode").focus();
				}

				if(obj["inlastkind"]=="inlast")
				{
					$("input[name=proinlast]").attr("disabled", true);
					$("#sinlast").text("<?=$txtdt['done']?>");
				}	

			}
			else if(obj["resultCode"]=="599")
			{
				console.log("mediboxinupdatemediboxinupdatemediboxinupdate = " + obj["resultMessage"]);
				//9019
				var msg="<?=$txtdt['9019']?>";

				if(obj["resultMessage"]!="OK")
				{
					popupDoneMessage(msg,'2000');//사용중이지 않거나 없는 부직포 바코드입니다.
					$("#probarcode").val("");
					$("#probarcode").focus();
				}

			}
			else if(obj["resultCode"]=="589")
			{
				
				if(!isEmpty(obj["updateinfirst"]))
				{
					popupDoneMessage('<?=$txtdt["infirst"]?> <?=$txtdt["9021"]?>','2000');//선전 부직포 바코드는 등록되어 있습니다.
				}
				else if(!isEmpty(obj["updateinmain"]))
				{
					popupDoneMessage('<?=$txtdt["inmain"]?> <?=$txtdt["9021"]?>','2000');//일반 부직포 바코드는 등록되어 있습니다.
				}
				else if(!isEmpty(obj["updateinafter"]))
				{
					popupDoneMessage('<?=$txtdt["inafter"]?> <?=$txtdt["9021"]?>','2000');//후하 부직포 바코드는 등록되어 있습니다.
				}
				$("#probarcode").val("");
				$("#probarcode").focus();
			}
		}
		else if(obj["apiCode"]=="scalemodeupdate")
		{
			var scaleMode=!isEmpty(obj["mode"])?obj["mode"]:"N";
			$("input[name=scaleMode]").val(scaleMode);

			var scaleMode=$("input[name=scaleMode]").val();
			console.log("scaleMode === " + scaleMode);
		}
	}

	function popupDoneMessage(maintxt, chktop)
	{
		var w=600;
		var h=45;
		var arr=popupcenter(w,h).split("|");
		var top=arr[0];
		var left=arr[1];

		var txt="<div id='layersignpop' style='position:fixed;width:"+w+"px;height:"+h+"px;top:"+top+"px;left:"+left+"px;z-index:30100;padding:50px' class='calloutp calloutp-warning'>";
			txt+="<h4 style='font-size:30px;font-weight:bold;'>"+maintxt+"</h4>";
			txt+="</div>";
		$("body").prepend(txt);
		setTimeout("$('#layersignpop').remove()",parseInt(chktop));
	}

	function setMediTxtdt(txtdt)
	{
		//steptxtdt textrea에 넣는다.
		var pretty = JSON.stringify(txtdt);
		document.getElementById('medicapadata').value = pretty;
	}
	//셋팅한 steptxt 텍스트 뽑아쓰기
	function getMediTxtdt(name)
	{
		var ugly = document.getElementById('medicapadata').value;
		var txtdt = JSON.parse(ugly);
		return txtdt[name];
	}
	function chkmedishort()
	{
		console.log("약재부족 확인을 눌러 다시 약재량을 체크하러 가자 !!!!!!  code " + getMediTxtdt("code"));
		closelayer();
		checkmedibox("MDB", "medi", getMediTxtdt("code"));
	}
	function chkmedicapa()
	{
		console.log("약재부족 확인을 눌러 다시 약재량을 체크하러 가자 !!!!!!  code " + getMediTxtdt("mediCode"));
		closelayer();
		var ugly = document.getElementById('medicapadata').value;
		var jsondata = JSON.parse(ugly);
		callapi('POST',"making",'medicinecapaupdate',jsondata);
	}
	function EnterInsBarCode(type, code)
	{
		insbarcode(type, code);
	}
	//makingmain >> 약재
	function viewMedicine(medi, decolist, od_chubcnt, mdfinishcapa, maTablestat)
	{
		//medicine
		var strtotal=strtop=str=topname=meditotcode=beTable="";
		var toplen=len=m=i=medicapa=0;
		var meditotcapa = {};
		toplen = medi["dmarr"].length;
		meditotcode=beTable="";
		for(m=0;m<toplen;m++)
		{
			topname=medi["dmarr"][m];
			topDeco=getDecoText(decolist, topname);
			strtop="<div class='content' id='medibox_"+topname+"'>";
			strtop+="<h1 style='font-size:17px;'>";
			//strtop+="<span class='tit'><?=$txtdt['gibontable']?></span>";
			//20190419:DJMEDI 프로세스로 돌리기 
			strtop+="<span class='tit'>"+topDeco+"</span>";
			strtop+="<span><?=$txtdt['pocket']?> : <em id='pouchtag_"+topname+"'></em></span>";
			strtop+="</h1>";
			str="";
			var arrList=medi["list"][topname];
			if(!isEmpty(medi["capa"][topname]))
			{
				var capaarr=medi["capa"][topname].split(",");
				len=(!isEmpty(arrList)) ? arrList.length : 0;
				if(len > 0)
				{
					for(i=0;i<len;i++)
					{
						//-------------------------------------------------------------------------
						if(beTable!=arrList[i]['mb_table'] && arrList[i]['mb_table'] == "00000")
						{
							str+="<br><br>";
							str+="<h1 style='width:100%;font-size:17px;'>";
							str+="<span class='tit'><?=$txtdt['commontable']?></span>";
							str+="</h1>";
						}
						beTable = arrList[i]['mb_table'];
						medicapa= parseFloat(arrList[i]['medicapa']);
						//console.log("code="+arrList[i]['md_code']+", medicapa = " + medicapa+", od_chubcnt = " + od_chubcnt);
						//-------------------------------------------------------------------------
						str+="<dl class='elementsmall' id='mediboxsmall_"+arrList[i]['md_code']+"'>";
						str+="	<dt class='titsmall'><em>"+arrList[i]['mediname']+"</em>";

						var fcapap=mdfinishcapa[arrList[i]['md_code']].toString();
						var fcapa=0;
						if(fcapap.indexOf('P') >= 0)
						{
							fcapa=parseInt(fcapap.replace("P",""));
						}
						else
						{
							fcapa=parseInt(fcapap);
						}
						
						if(fcapap.indexOf('P') >= 0)
						{
							fcapa=parseInt(fcapap.replace("P",""));
							str+="		<span class='target medismallcapa' id='medicapasmall_"+arrList[i]['md_code']+"'>"+fcapa+"<small>g</small></span>";
						}
						else
						{
							if(fcapa > 0)
							{
								str+="		<span class='target medismallcapa' id='medicapasmall_"+arrList[i]['md_code']+"'>"+fcapa+"<small>g</small></span>";
							}
							else
							{
								str+="		<span class='target medismallcapa' id='medicapasmall_"+arrList[i]['md_code']+"'>"+medicapa+"<small>g</small></span>";
							}
						}

						str+="	</dt>";
						str+="</dl>";
						if(fcapap.indexOf('P') >= 0)
						{
							fcapa=parseInt(fcapap.replace("P",""));
							str+="<dl class='element st_finish' id='medibox_"+arrList[i]['md_code']+"' data-code='"+arrList[i]['md_code']+"' data-value='"+arrList[i]['mb_code']+"' data-pass='"+fcapap+"' >";
						}
						else
						{
							if(fcapa > 0)
							{
								str+="<dl class='element st_finish' id='medibox_"+arrList[i]['md_code']+"' data-code='"+arrList[i]['md_code']+"' data-value='"+arrList[i]['mb_code']+"' data-pass='' >";
							}
							else
							{
								str+="<dl class='element st_wait' id='medibox_"+arrList[i]['md_code']+"' data-code='"+arrList[i]['md_code']+"' data-value='"+arrList[i]['mb_code']+"' data-pass='' onclick=\"EnterInsBarCode('MDB', '"+arrList[i]['mb_code']+"')\">";
							}
						}
						str+="	<dt class='tit'><em>"+arrList[i]['mediname']+"</em></dt>";//약재명한글(한자)
						str+="	<dd class='weight'>";
						str+="		<label for='value' id='valuecss' ><input type='text' value='"+fcapa+"' class='medicapa' readonly id='medicapa_"+arrList[i]['md_code']+"' /><small>g</small></label>";
						str+="		<span class='target' id='meditarget_"+arrList[i]['md_code']+"' value='"+medicapa+"'>"+medicapa+"<small>g</small></span>";
						str+="	</dd>";
						str+="	<dd class='status'><?=$txtdt['done']?></dd>";
						str+="</dl>";
					}


					if(maTablestat=="start" || maTablestat==null || maTablestat=="scaned")
					{
						//----------------------------------------------------
						console.log("====테이블 비교위한배열저장=======  maTablestat :: " + maTablestat);
						console.log(medi);	
						if(isEmpty(maTablestat))
						{
							console.log("테이블 셋팅값이 null 인경우 :: ");
							maTablestat="null";
						}
						//----------------------------------------------------
						var medibox=new Array();
						var meditbl = new Array();
						$.each(medi["list"], function(index, value){
							$.each(value, function(index2, value2){
								if(value2["mb_table"]=="00000"){
									//공통약재
									meditbl.push(value2["mb_code"].replace(" ",""));
								}else{
									//기본약재
									medibox.push(value2["mb_code"].replace(" ",""));
								}
							})
						})

						$("#makingtblestat").remove();
						$("#makingtblestatdiv").remove();

						var odCode=$("#ordercode").attr("value");
						var h=$(window).height();
						var screen="<div id='screen' style='position:fixed;width:100%;top:0;background:#000;opacity:0.4;height:"+h+"px; z-index:999;'></div>"
						$("body").prepend(screen);
						var txt="<div id='makingtblestatdiv' style='position:absolute;width:100%;z-index:1000;'><div id='makingtblestat' style='position:relative;width:1052px;max-height:400px;margin:150px auto;padding:0;background:#fff;'></div></div>";
						$("body").prepend(txt);
						var langauge=getCookie("ck_language");
						langauge=!isEmpty(langauge) ? langauge : "kor";

						$("#makingtblestat").load("<?=$root?>/making/chktable.php?odCode="+odCode+"&medibox="+medibox+"&meditbl="+meditbl+"&maTablestat="+maTablestat+"&langauge="+langauge);
						console.log("====테이블 비교위한배열저장=======  medibox = " + medibox);

						//----------------------------------------------------
					}
					/*else if(obj["promatableStat"]=="finish")
					{

					}*/

					if(i>0)
					{
						strtotal+=strtop+str+"</div>";
					}
				}
			}
		}
		return strtotal;
	}
	//makingmain >> 별전
	function viewSweet(medi, decolist, mdfinishcapa)
	{
		var strtotal=strtop=str=topDeco=meditotcode="";
		var meditotcapa={};

		topDeco=getDecoText(decolist, "inlast");
		strtop="<div class='content' id='medibox_inlast'>";
		strtop+="<h1 style='font-size:17px;'>";
		strtop+="<span class='tit'>"+topDeco+"</span>";
		strtop+="</h1>";

		str="";
		
		var arrList=medi["sweetlist"];
		len=(!isEmpty(arrList)) ? arrList.length : 0;
		console.log("viewSweet len = " + len);
		meditotcode="";
		if(len > 0)
		{
			for(i=0;i<len;i++)
			{
				str+="<dl class='elementsmall' id='mediboxsmall_"+arrList[i]['md_code']+"'>";
				str+="	<dt class='titsmall'><em>"+arrList[i]['mediname']+"</em>";
				str+="		<span class='target medismallcapa' id='medicapasmall_"+arrList[i]['md_code']+"'>"+arrList[i]['medicapa']+"<small>g</small></span>";
				str+="	</dt>";
				str+="</dl>";
				if(mdfinishcapa[arrList[i]['md_code']] > 0)
					str+="<dl class='element st_finish' id='medibox_"+arrList[i]['md_code']+"' data-code='"+arrList[i]['md_code']+"' data-value='"+arrList[i]['mb_code']+"'>";
				else
					str+="<dl class='element st_wait' id='medibox_"+arrList[i]['md_code']+"' data-code='"+arrList[i]['md_code']+"' data-value='"+arrList[i]['mb_code']+"' onclick=\"EnterInsBarCode('MDB', '"+arrList[i]['mb_code']+"')\">";
				str+="	<dt class='tit_last'><em>"+arrList[i]['mediname']+"</em></dt>";
				str+="	<dd class='weight'>";
				//str+="		<label for='value' id='valuecss' ><input type='text' value='0' class='medicapa' readonly id='medicapa_"+arrList[i]['md_code']+"' style='width: 80%;' /><small>ea</small></label>";
				str+="		<span class='target' id='meditarget_"+arrList[i]['md_code']+"' value='"+arrList[i]['medicapa']+"'>"+arrList[i]['medicapa']+"<small>g</small></span>";
				str+="	</dd>";
				str+="	<dd class='status'><?=$txtdt['done']?></dd>";
				str+="</dl>";
			}

			if(i>0)
			{
				strtotal+=strtop+str+"</div>";
			}
		}

		return strtotal;
	}	
	function viewMakingMain(obj)
	{
		var medifinishcnt=0;
		var arr=obj["medi"]["medicine"].split("|");//선전,일반,후하 약재 
		var sarr={};
		if(!isEmpty(obj["medi"]["medisweet"]))
		{
			sarr=obj["medi"]["medisweet"].split("|");//별전
		}
		var chubcnt=obj["od_chubcnt"];//첩수
		var mdfinishcapa={};
		var passNoCapa=medifinishCapa=needCapa=0;
		var mcode="";
		console.log("viewMakingMainviewMakingMainviewMakingMainviewMakingMainviewMakingMainviewMakingMain");
		console.log(arr);
		

		//------------------------------------------------------------------------------
		// 약재와 별전 투입한 양이 있는지 체크하여 처리완료로 바꾸기 위함 
		//------------------------------------------------------------------------------
		//|1002,3.0,inmain,22,61|1008,3.5,inmain,22
		for(var i=1;i<arr.length;i++)
		{
			arr2=arr[i].split(",");
			if(arr2[0].indexOf("__") >= 0)
			{
				var marr=arr2[0].split("__");
				mcode=marr[0];
			}
			else
			{
				mcode=arr2[0];
			}
			mdfinishcapa[mcode]=(!isEmpty(arr2[4])) ? arr2[4] : 0;//투입한 약재량			
			if(!isEmpty(arr2[4]))
			{
				medifinishcnt++;
				if(arr2[4].indexOf('P')>=0)
				{
					if(arr2[4]=='P0')
					{
						var pc=arr2[4].replace('P','');
						mdfinishcapa[mcode]=mdfinishcapa[mcode];
						medifinishCapa+=parseFloat(pc);
					}
					else
					{
						var pc=arr2[4].replace('P','');
						mdfinishcapa[mcode]=mdfinishcapa[mcode];
						medifinishCapa+=parseFloat(pc);
					}
				}
				else
				{
					//passNoCapa+=parseFloat(arr2[4]); 
					medifinishCapa+=parseFloat(arr2[4]);
				}
				//------------------------------------
				//20190416:parseInt를 parseFloat
				//------------------------------------
				var tcapa=parseFloat(arr2[1]) * parseFloat(chubcnt);
				tcapa = Math.round(tcapa);
				needCapa = parseInt(needCapa) + parseInt(tcapa);
				needCapa = parseInt(needCapa);
				//------------------------------------
			}
		}
		var passCapa = needCapa - medifinishCapa;
		$("#passCapa").val(passCapa);
		console.log(mdfinishcapa);
		console.log("needCapa = " + needCapa);
		console.log("medifinishCapa = " + medifinishCapa);

		//|9980,2,inlast,1300|9986,1,inlast,18000|9987,1,inlast,0|9989,3,inlast,0
		for(var i=1;i<sarr.length;i++)
		{
			sarr2=sarr[i].split(",");
			mdfinishcapa[sarr2[0]]=(!isEmpty(sarr2[4])) ? sarr2[4] : 0;//투입한 약재량			
			if(!isEmpty(sarr2[4]))
			{
				medifinishcnt++;
			}
		}

		//$("input[name=passCapa]").val(passNoCapa);
		$("#medipocketcapa").text(medifinishCapa+"g");
		//------------------------------------------------------------------------------
		//------------------------------------------------------------------------------
		// 조제대,약재수량,완료,대기,보류,선전/일반/후하 파우치바코드 셋팅 
		//------------------------------------------------------------------------------
		$("#matable").text(obj["mt_title"]);
		$("#meditotcnt").text(obj["medi"]["medicnt"]);
		$("#medifinishcnt").text(medifinishcnt);

		$("#mediwaitcnt").text(obj["medi"]["medicnt"]-medifinishcnt);
		$("#mediholdcnt").text(0);
		//***********************
		// 20190401 진행중추가 
		//***********************
		$("#mediingcnt").text(0);
		//***********************

		//작업하고 있던 약재함 
		var ma_medibox=(!isEmpty(obj["ma_medibox"])) ? obj["ma_medibox"] : "";
		var mb_medicine=(!isEmpty(obj["mb_medicine"])) ? obj["mb_medicine"] : "";
		console.log("#### 작업하고 있떤 약재함  ma_medibox  :: " + ma_medibox + ", mb_medicine = " + mb_medicine);


		console.log("*****  viewMakingMain  medifinishcnt  = " + medifinishcnt +", mediwaitcnt = " + (obj["medi"]["medicnt"]-medifinishcnt));
		//------------------------------------------------------------------------------
		// 약재와 별전 화면 구성 및 처리 
		//------------------------------------------------------------------------------
		var strtotal = viewMedicine(obj["medi"], obj["decolist"], obj["od_chubcnt"], mdfinishcapa, obj["maTablestat"]);
		strtotal += viewSweet(obj["medi"], obj["decolist"], mdfinishcapa);

		$("#info_proc").html(strtotal);
		var infirst=inmain=inafter="";
		infirst=(!isEmpty(obj["medibox_infirst"])) ? obj["medibox_infirst"] : "";
		inmain=(!isEmpty(obj["medibox_inmain"])) ? obj["medibox_inmain"] : "";
		inafter=(!isEmpty(obj["medibox_inafter"])) ? obj["medibox_inafter"] : "";


		//------------------------------------------------------------------------------
		$('#pouchtag_infirst').text(infirst);//선전
		$('#pouchtag_inmain').text(inmain);//일반
		$('#pouchtag_inafter').text(inafter);//후하
		//------------------------------------------------------------------------------
		if($("#medibox_infirst").length > 0)
		{
			console.log("#### 선전은 있다");
		}
		if($("#medibox_inmain").length > 0)
		{
			console.log("#### 일반은 있다");
		}
		if($("#medibox_inafter").length > 0)
		{
			console.log("#### 후하은 있다");
		}
		if($("#medibox_inlast").length > 0)
		{
			console.log("#### 별전은 있다");
		}

		console.log("#### infirst = "+infirst+", inmain = " + inmain+", inafter = " + inafter);


		$('.content').eq(0).addClass('contenton');
		$('.content .element').fadeOut(0);
		$('.content .elementsmall').fadeIn(0);
		$('.contenton .element').fadeIn(0);
		$('.contenton .elementsmall').fadeOut(0);
		//------------------------------------------------------------------------------

		//------------------------------------------------------------------------------
		var medi=obj["medi"];
		medi["dmarr"].push("inlast");
		//console.log(medi["dmarr"]);
		var toplen = medi["dmarr"].length;
		var count=finish=0;
		var medigroup=nextmedigroup="";
		for(m=0;m<toplen;m++)
		{
			var topname=medi["dmarr"][m];
			var inpouchtag=$('#pouchtag_'+topname).text();

			medigroup=topname;
			count=$("#medibox_"+topname+" .element").length;
			finish=$("#medibox_"+topname+" .st_finish").length;
			console.log("#### medigroup = " + medigroup+", topname = "+topname+", inpouchtag = "+inpouchtag+", count = " + count+", finish = " + finish);

			if(medigroup&&count>0)
			{
				if(count==finish)
				{
					if(!isEmpty(inpouchtag))
					{
						nextmedigroup="";
						if(m<toplen)
						{
							nextmedigroup=medi["dmarr"][m+1];
						}
						$('#medibox_'+medigroup).removeClass('contenton');
						$('#medibox_'+medigroup+' .element').fadeOut(0);
						$('#medibox_'+medigroup+' .elementsmall').fadeIn(0);
						$('#medibox_'+nextmedigroup).addClass('contenton');
					}
					else
					{
						break;
					}
				}
				else
				{
					break;
				}
			}
			else
			{
				medigroup="";
			}
		} 

		var waitcnt=$('.contenton .st_wait').length;
		console.log("#### makingmain  waitcnt = " + waitcnt+", medigroup = " + medigroup+", nextmedigroup = " + nextmedigroup);
		if(waitcnt > 0)
		{
			if(!isEmpty(medigroup))
			{
				$('.content').removeClass('contenton');
				$('#medibox_'+medigroup).addClass('contenton');
				$('#medibox_'+medigroup+' .element').fadeIn(0);
				$('#medibox_'+medigroup+' .elementsmall').fadeOut(0);
				$('.groupmedicode').removeClass('groupmedion');
				$('input[name=groupmedicode_'+medigroup+']').addClass('groupmedion');
			}			
			console.log("#### 11111111111 viewMakingMain  gotostep(2) 1111111");
			status_txt=getTxtdt("step30");//약재 바코드를 스캔 해 주세요
			$('#status_txt').text(status_txt);
			gotostep(2);


			if(!isEmpty(mb_medicine))
			{
				var medibox_finish=$("#medibox_"+mb_medicine).hasClass("st_finish");
				console.log("11111 medibox_finish = " + medibox_finish);
				if(!isEmpty(medibox_finish)&&medibox_finish==true)
				{
					$("#medibox_"+mb_medicine).removeClass('st_finish').addClass("st_ing").addClass('addhold').addClass('colorbox');
				}
			}
		}
		else
		{
			var count=$("#medibox_"+medigroup+" .element").length;
			var finish=$("#medibox_"+medigroup+" .st_finish").length;
			var inpouchtag=$('#pouchtag_'+medigroup).text();

			console.log("#### 22222222222 medigroup = "+medigroup+", count = " + count+", finish = " + finish+", inpouchtag = " + inpouchtag);
			if(medigroup=="inlast") //별전이면 
			{
				//---------------------------------------------------------
				var jsondata={};
				jsondata["odcode"]=obj["odcode"];
				callapi('POST',"making",'mediboxinlastupdate',jsondata);
				//---------------------------------------------------------
				console.log("viewMakingMain inlast ==>makinggostep ");
				makinggostep();
			}
			else
			{
				if(count==finish)
				{
					var ninfirst=$("#medibox_infirst").length;
					var ninmain=$("#medibox_inmain").length;
					var ninafter=$("#medibox_inafter").length;
					//var ninlast=$("#medibox_inlast").length;
					var ntotal=parseInt(ninfirst)+parseInt(ninmain)+parseInt(ninafter);//+parseInt(ninlast);
					//console.log("ntotal="+ntotal+",ninfirst="+ninfirst+",ninmain="+ninmain+",ninafter="+ninafter);
					var finishtotal=0;
					if(ninfirst>0&&!isEmpty(infirst))
					{
						finishtotal++;
					}
					if(ninmain>0&&!isEmpty(inmain))
					{
						finishtotal++;
					}
					if(ninafter>0&&!isEmpty(inafter))
					{
						finishtotal++;
					}

					//console.log("#### finishtotal="+finishtotal+", infirst = "+infirst+", inmain = " + inmain+", inafter = " + inafter);

					if(finishtotal==ntotal)
					{
						makinggostep();
						console.log("마지막이다!!!!!!!!!!!!!");
					}
					else
					{
						//console.log("#### viewMakingMain  gotostep(4) 222222   mb_medicine = " + mb_medicine);
						gotostep(4);
						//20190419 : DJMEDI 프로세스로 돌리기 
						status_txt=getTxtdt("step50"); //부직포 바코드를 스캔 해 주세요
						$("#status_txt").text(status_txt);
						layersign("success",status_txt,'','1000');

						var medibox_finish=$("#medibox_"+mb_medicine).hasClass("st_finish");
						console.log("11111 medibox_finish = " + medibox_finish);
						if(!isEmpty(medibox_finish)&&medibox_finish==true)
						{
							$("#medibox_"+mb_medicine).removeClass('st_finish').addClass("st_ing").addClass('addhold').addClass('colorbox');
						}
					}
				}
				else
				{
					console.log("#### viewMakingMain  gotostep(2) 33333");
					status_txt=getTxtdt("step30");//약재 바코드를 스캔 해 주세요
					$('#status_txt').text(status_txt);
					gotostep(2);
				}
			}


			if(isEmpty(nextmedigroup))
			{
				$('.content').removeClass('contenton');
				$('#medibox_'+medigroup).addClass('contenton');
				$('#medibox_'+medigroup+' .element').fadeIn(0);
				$('#medibox_'+medigroup+' .elementsmall').fadeOut(0);
				$('.groupmedicode').removeClass('groupmedion');
				$('input[name=groupmedicode_'+medigroup+']').addClass('groupmedion');
			}
			else
			{
				$('.content').removeClass('contenton');
				$('#medibox_'+nextmedigroup).addClass('contenton');
				$('#medibox_'+nextmedigroup+' .element').fadeIn(0);
				$('#medibox_'+nextmedigroup+' .elementsmall').fadeOut(0);
				$('.groupmedicode').removeClass('groupmedion');
				$('input[name=groupmedicode_'+nextmedigroup+']').addClass('groupmedion');
			}
			
		}




	}
	callapi('GET','making','makinglist',"<?=$apiData?>");
</script>
