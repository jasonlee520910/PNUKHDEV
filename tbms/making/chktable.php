<?php
	$root="..";
	include_once $root."/_common.php";
	//include_once $root."/_Inc/head.php";
?>
 <style>
	div.cagediv{overflow:hidden;background:#ccc;width:100%;padding:0;}
	div.tbldiv{overflow:hidden;float:left;margin:10px 0;padding:0;}
	dl.tbl{overflow:hidden;margin:0;padding:0;}
	dl.tbl dd{float:right;display:block;margin:2px;padding:0;text-align:center;height:30px;font-size:12px;line-height:220%;overflow:hidden;}
	dl.tbl dd.nobox{background:#000;color:#fff;font-size:23px;font-weight:bold;line-height:140%;}
	dl.tbl dd.inuse{background:#87CEFA;font-size:12px;}
	dl.tbl dd.nouse{background:#ccc;color:#ccc;font-size:12px;}
	dl.tbl dd.skip{background:#87CEFA;font-size:12px;}
	dl.tbl dd.lighton{background:red;color:#fff;font-size:12px;}
	dl.tbl dd.chkuse{background:#ccc;}
	#tbltxtdl{width:100%;padding-bottom:10px;overflow:hidden;}	
	#tbltxtdl dt{display:block;float:left;text-align:center;width:17%;margin:10px 1%;padding:0;font-size:25px;font-weight:bold;}
	#tbltxtdl dd{display:block;float:left;text-align:center;width:12%;margin:10px 1%;padding:0;font-size:25px;font-weight:bold;}
	#tbltxtdl dd{font-size:25px;color:blue;}
	.scanok{width:auto;background:#fff;color:green;font-size:30px;padding:10px 0;margin:20px;text-align:center;font-weight:bold;}
	.scandeny{width:auto;background:#fff;padding:10px 0;margin:20px;text-align:center;overflow:hidden;}
	.scandeny span{color:red;font-size:30px;font-weight:bold;margin:0 20px;}
	.scandeny .right{float:right;color:#111;}
	#scannoti{clear:both;font-size:20px;color:#111;font-weight:bold;margin:20px;}
	.blink_me {
		float:left;
	  animation: blinker 1s linear infinite;
	}
	@keyframes blinker {  
	  50% { opacity: 0; }
	}
	#scancls{float:right;;width:270px;font-size:30px;padding:10px 0;margin:0 20px;color:#000;font-weight:bold;text-align:center;}
 </style>
 <?php
 /*
	//케이지 수
	$cage=1;
	$cagewidth=intval(100 / $cage ) - 2;
	//케이지당 가로
	$cage_ho=5;
	$boxwidth=intval(100 / $cage_ho ) - 2;
	//케이지당 세로
	$cage_ve=4;
	//예외
	$exc=array(10,15);
*/
	//케이지 수 세명대
 /*
	$cage=5;
	$cagewidth=intval(100 / ($cage+1) );//조제케이지는 두배
	//케이지당 가로
	$cage_ho=5;
	$boxwidth=intval(100 / $cage_ho ) - 2;
	$boxwidth="40px";
	//케이지당 세로
	$cage_ve=8;
	//조제케이지위치
	$mcage=2;
	//조제케이지 가로
	$mcage_ho=8;
	$mboxwidth=intval(100 / $mcage_ho ) - 2;
	$mboxwidth="40px";
	//조제케이지 세로
	$mcage_ve=8;
	//예외
	$exc=array(51,52,53,54,59,60,61,62,73,74,75,76,77,78,79,80,132,133,134,137,138,139,142,143,144);
*/
	//케이지 수 DEV
	$cage=3;
	$cagewidth=intval(100 / ($cage+1) );//조제케이지는 두배
	//케이지당 가로
	$cage_ho=5;
	$boxwidth=intval(100 / $cage_ho ) - 2;
	$boxwidth="50px";
	//케이지당 세로
	$cage_ve=8;
	//조제케이지위치
	$mcage=2;
	//조제케이지 가로
	$mcage_ho=8;
	$mboxwidth=intval(100 / $mcage_ho ) - 2;
	$mboxwidth="50px";
	//조제케이지 세로
	$mcage_ve=8;
	//skip
	//$skip=array(1,2,3,4,5,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,34,35,39,40,41,42,43,44,45,46,47,48,81,82,83,84,85,86,87,88,89,90,91,92,93,94,95,96,97,98,99,100,101,102,103,104,105,106,107,108,109,120,121,122,123,124,125,126,127,128,129,130,131,132,133,134,135,136,137,138,139,140,141);
	//예외
	$exc=array(59,60,61,62,67,68,69,70,73,74,75,76,77,78,79,80);

	$selectbox=$_GET["medibox"];
	$selecttbl=$_GET["meditbl"];
	$odCode=$_GET["odCode"];
	$maTablestat=$_GET["maTablestat"];
	$langauge=$_GET["langauge"];

 ?>
  <div class="cagediv" id="cagediv" value="0" onclick="cageOnClick();">
  <?php $n=$val=$real=0;?>
	<?php for($i=1;$i<=$cage;$i++){?>
	<?php if($i==$mcage){?>
		<div class="tbldiv" style="width:432px;margin:20px 0;">
			<dl class="tbl">
				<?php for($k=1;$k<=($mcage_ho * $mcage_ve);$k++){?>
					<?php
						$view="";
						$cnt=$n+1;
						if(in_array($cnt,$exc)){
							$cls="nouse";
						}else{
							$val++;
							$cls="box box".sprintf("%03d",$val);
							$view=sprintf("%03d",$val);
						}
					?>
					<dd style="width:<?=$mboxwidth;?>;" class="<?=$cls;?> <?=$cnt?>"><?//=$cnt?><?//=$view?></dd>
					<?php $n++;?>
				<?php }?>
			</dl>
		</div>
	<?php }else{?>
		<div class="tbldiv" style="width:270px;margin:20px;">
			<dl class="tbl">
				<?php for($k=1;$k<=($cage_ho * $cage_ve);$k++){ ?>
					<?php
						$view="";
						$cnt=$n+1;
						if(in_array($cnt,$exc)){
							$cls="nouse";
						}else{
							$val++;
							$cls="box box".sprintf("%03d",$val);
							$view=sprintf("%03d",$val);
						}
					?>
					<dd style="width:<?=$mboxwidth;?>;" class="<?=$cls;?> <?=$cnt?>"><?//=$cnt?><?//=$view?></dd>
					<?php $n++;?>
				<?php }?>
			</dl>
		</div>
	<?php }?>
	<?php }?>
  </div>

<script>
	var waittime;
	function cageOnClick()
	{
		var scanok = $(".scanok").length;
		var scandeny = $(".scandeny").length;
		console.log("scanok = " + scanok+", scandeny ="+scandeny);
		
		if(scanok > 0)
		{
			$("#cagediv").remove();
			$("#screen").fadeOut(200);
			$("#makingtblestatdiv").remove();

			//190408 세명대 조제 시간 체크하기 위해 ma_start 시간 추가
			var odcode = $("#ordercode").attr("value");
			var data="odCode="+odcode;
			console.log("조제시작 callapi  :"+data);
			callapi('GET','making','makingstart',data);	

			var waitcnt=$('.st_wait').length;
			var medigroup=$(".contenton").attr("id");
			console.log("waitcntwaitcntwaitcntwaitcnt  waitcnt = " + waitcnt + ", medigroup = " + medigroup);

			
			if(waitcnt <= 0)
			{
				console.log("안내창");

				workerconfirm("<?=$txtdt['9036']?>");

				/*
				if(medigroup=="medibox_inlast")
				{
					//---------------------------------------------------------
					var jsondata={};
					jsondata["odcode"]=odcode;
					callapi('POST','making','mediboxinlastupdate',jsondata);
					//---------------------------------------------------------					
				
					//gotostep(5);
					//$("#addagainphoto").html("");
					//setAgainPhoto();
					//layersign("success",getTxtData("9001"), "",'confirm_making');//정량을 확인 후 정상일 경우 작업지시서를 스캔해 주세요
				
					console.log("cageOnClick==>makinggostep");
					makinggostep();
				}
				else
				{
					console.log("cageOnClick  gotostep(4) ");
					gotostep(4);
					//20190419 : DJMEDI 프로세스로 돌리기 
					status_txt=getTxtdt("step50"); //부직포 바코드를 스캔 해 주세요
					$("#status_txt").text(status_txt);
					layersign("success",status_txt,'','1000');
				}
				*/
			}
			else 
			{
				setRequestPopup();
			}
		}
		else if(scandeny > 0)
		{
			//******************************************
			//20190402 약재함 오류나서 스캔하러 가자 
			//******************************************
			var chknext=$(".scaning").length;
			if(chknext <= 0) //스캔중일때 버튼 클릭 안되게 하자 
			{
				var odcode = $("#ordercode").attr("value");
				var data="odCode="+odcode;
				callapi('GET','making','makingscan',data);				
			}
			//******************************************
		}
		$("#mainbarcode").focus();
	}
	//**********************************************
	//20190402 약재함수량 오류시 scan을 하기 위해서 
	//**********************************************
	function rescanmap(obj)
	{
		if(obj["resultCode"] == "200") //ma_tablestat이 finish일경우 애니메이션 처리해주자!!! scan 처리중..
		{
			if(obj["ma_tablestat"] == "finish" || obj["ma_tablestat"] == "hold") 
			{
				$("#scandenystat").text("<?=$txtdt['scaning']?>"); //스캔중 
				$(".cagediv").addClass("scaning");//스캔중일때 확인 버튼 클릭안되게 하기위해서 class 추가하여 처리함 
				$("#scannoti").text(""); //약재함을 선택해제후 확인버튼을 눌러주세요 텍스트 제거 
				$("#scanright").css("display", "none");//스캔중일때 확인버튼 사라지게 하자!
				
				waittime=setInterval("tablescan()",500);

				//10초후 ma_tablestat null로 바꾸기 
				setTimeout(function(){
					var odcode = $("#ordercode").attr("value");
					var data="odCode="+odcode;
					callapi('GET','making','makingtablestatupdate',data);
				}, 10000); 
			}
			else if(obj["ma_tablestat"] == "cancel") //20190415 : cancel 추가 
			{
				$("#scandenystat").text("<?=$txtdt['scaning']?>"); //스캔중 
				$(".cagediv").addClass("scaning");//스캔중일때 확인 버튼 클릭안되게 하기위해서 class 추가하여 처리함 
				$("#scannoti").text(""); //약재함을 선택해제후 확인버튼을 눌러주세요 텍스트 제거 
				$("#scanright").css("display", "none");//스캔중일때 확인버튼 사라지게 하자!

				//waittime=setInterval("tablescan()",500);

				var odcode = $("#ordercode").attr("value");
				var data="odCode="+odcode;
				callapi('GET','making','makingcancel',data);

				//일단은 20초후에 list로 가게 하자 
				setTimeout(function(){
					$("#cagediv").remove();
					$("#screen").fadeOut(200);
					$("#makingtblestatdiv").remove();
					$('#procmember').html('');
					$('#procscription').html('');
					$('#procuser').html('');
					$("#gram").html('');
					$("#addagainphoto").html("");
					gotostep(1);
					gomainload("../_Inc/list.php?depart=making");
					$("#mainbarcode").val("");
					$("#mainbarcode").focus();
				}, 20000);


			}
		}
		else 
		{
			//finish가 아닐 경우 약재함 선택해달라는 문구를 보여주자 !!
			//확인을 누르면.. makingscan을 다시 부른다.. finish가 될때까지...
			if(obj["resultCode"] == "888" && obj["resultMessage"] == "MEDIBOXCLEAR")
			{
				$("#scandenystat").text("<?=$txtdt['remediboxclear']?>"); //먼저 약재함을 선택해제해 주세요.
			}
		}
	}
	//**********************************************

	function lightontable()
	{
		$("dd").removeClass("lighton");
		var selectbox="<?=$selectbox?>";
		var selecttbl="<?=$selecttbl?>";
		var langauge="<?=$langauge?>";
		langauge=isEmpty(langauge) ? "kor" : langauge;
		//20190415:selectbox 추가 
		var url = getUrlData("API")+"/making/?apiCode=lighton&language="+langauge+"&maTable="+getCookie("ck_matable")+"&selectbox="+selectbox;
		console.log("lightontable  selectbox = " + selectbox+", selecttbl = " + selecttbl + ", url = " + url);
		$.ajax({
			type : "GET", //method
			url : url,
			data : "",
			success : function (result) {
				var obj = JSON.parse(result);
				console.log(obj);
				if(obj["resultCode"]=="200")
				{
					if(obj["apiCode"]=="lighton") {
						//++++++++++++++++++++++++++++++++++++++++++++++++++++
						// 20190412 : 약재함이 안들어오는 것은 블랙으로 바꾸자 
						//++++++++++++++++++++++++++++++++++++++++++++++++++++
						//blackon 
						var boxno=obj["boxno"];
						var noboxarr=new Array();
						$.each(boxno, function(index, value){
							//000000000000000
							if(value.indexOf("MDB") == -1)
							{
								$(".box"+index).addClass("nobox");
								$(".box"+index).text("※");
							}
						});
						//++++++++++++++++++++++++++++++++++++++++++++++++++++
						
						//lighton
						var tableInfo=obj["tableInfo"];
						var boxarr=new Array();
						$.each(tableInfo, function(index, value){
							$(".box"+value["no"]).addClass("inuse");
							$(".box"+value["no"]).text(value["name"]);
							boxarr[index]=value["no"]+"|"+value["name"];
						});
						// selmedi on
						var selmedi="";
						if(selectbox!=""){
							selmedi=selectbox.split(",");
						}
						var selmedicnt=selmedi.length;

						$.each(selmedi, function(index, value){
							if(boxarr[value]!="" && boxarr[value]!=undefined){
								boxarrval=boxarr[value].split("|");
								$(".box"+boxarrval[0]).addClass("lighton");
								$(".box"+boxarrval[0]).text(boxarrval[1]);
							}
						});
						// tblmedi cnt
						var tblmedi=0;
						if(selecttbl!=""){
							tblmedi=selecttbl.split(",").length;
						}
						//20190412 총 처방약재 갯수 
						var totalmedicnt = parseInt(selmedicnt) + parseInt(tblmedi);
						
						//******************************************
						//20190412 불켜진것과 처방약재가 같다면 약재스캔완료하면서 
						//******************************************
						var lightoncnt=$(".lighton").length;
						var lightcls = "";
						if(lightoncnt==selmedicnt)
						{
							lightcls = "";
						}
						else
						{
							lightcls = "style='color:red;'";
						}

						var txt="<dl id='tbltxtdl'>";
							//20190412 총 처방약재 추가 
							txt+="<dt><?=$txtdt['totalordercnt']?></dt><dd>"+totalmedicnt+" <?=$txtdt['cnt']?></dd>"; //총 처방약재  건 
							txt+="<dt><?=$txtdt['tablemedicine']?></dt><dd "+lightcls+">"+lightoncnt+" <?=$txtdt['cnt']?></dd>"; //조제대약재  건
							txt+="<dt><?=$txtdt['commedicine']?></dt><dd>"+tblmedi+" <?=$txtdt['cnt']?></dd>";//공통약재  건 
							txt+="</dl>";
							txt+="<div id='scandDiv'></div>";

						//*******************************
						//20190402 기존 화면 데이터 삭제 
						//*******************************
						$("#tbltxtdl").html("");
						$("#scandDiv").html("");
						$(".cagediv span").remove();
						$(".cagediv p").remove();
						//*******************************


						$("#cagediv").append(txt);
						$(".cagediv").removeClass("scaning");

						
						if(lightoncnt==selmedicnt)
						{
							txt="<span id='scancls'><?=$txtdt['scancls']?>(<?=$txtdt['close']?>) !</span><p class='scanok'><?=$txtdt['scanok']?></p>"; //확인완료(닫기) 약재스캔완료!
						}
						else
						{
							//==============================================================
							//20190415:약재함박스를 못읽어오는 경우와 없는 경우의 예외처리 
							//==============================================================
							var len = $(".nobox").length;
							if(len > 0)
							{
								txt="<p class='scandeny'>";
								txt+="<span id='scandenystat' class='blink_me'><?=$txtdt['scandeny']?></span>";//※ 표시된 약재함을 확인해 주세요!!
								txt+="<span id='scanright' class='right'><?=$txtdt['confirm']?></span>";
								txt+="<div id='scannoti'>* <?=$txtdt['mediboxclear']?></div>"; //약재함을 선택해제후 확인버튼을 눌러주세요
								txt+="</p>";
							}
							else
							{
								txt="<p class='scandeny'>";
								txt+="<span id='scandenystat' class='blink_me'><?=$txtdt['scandenymedibox']?></span>";//아래 해당하는 조제대의 약재함이 없습니다.
								txt+="<span id='scanright' class='right'><?=$txtdt['confirm']?></span>";
								if(!isEmpty(obj["noneMediBoxName"]))
								{
									txt+="<div id='scannoti'>* "+obj["noneMediBoxName"]+"</div>"; //약재함을 선택해제후 확인버튼을 눌러주세요
								}
								txt+="</p>";
							}
							//==============================================================

						}
						$("#scandDiv").html(txt);
						//$("#tbltxtdl").after(txt);
						//******************************************

							
					}
				}
				else
				{
				}
			},
			error:function(request,status,error){
				console.log("code:"+request.status+"\n"+"message:"+request.responseText+"\n"+"error:"+error);
			}
		});
	}

	function tablescan()
	{
		var odcode=$("#ordercode").attr("value");
		var langauge="<?=$langauge?>";
		langauge=isEmpty(langauge) ? "kor" : langauge;
		var url=getUrlData("API")+"/making/?apiCode=tablescan&language="+langauge+"&odCode="+odcode+"&maTable="+getCookie("ck_matable");
		console.log("tablescan  odcode = " + odcode+", url = " + url);
		$.ajax({
			type : "GET", //method
			url : url,
			data : "",
			success : function (result) {
				var obj = JSON.parse(result);
				if(obj["resultCode"]=="200")
				{
					if(obj["apiCode"]=="tablescan") {
						//**************************************************
						//201900402 스캔중 
						//**************************************************
						console.log("obj[tableStat] = " + obj["tableStat"]);

						if(obj["tableStat"]=="scaned")
						{
							clearInterval(waittime);
							lightontable();
						}
						//**************************************************
					}
				}
				else
				{
				}
			},
			error:function(request,status,error){
				console.log("code:"+request.status+"\n"+"message:"+request.responseText+"\n"+"error:"+error);
			}
		});
	}

	function tablewait() {
		/*
		var boxcnt=$(".box").length;
		var cnt = $("#cagediv").attr("value");
		cnt++;
		$("#cagediv").attr("value",cnt);
		$(".box"+pad(cnt, 3)).addClass("inuse");
		if(boxcnt < cnt){
			$("#cagediv").attr("value",0);
		}
		*/
		var tot=$("#cagediv").attr("value");
		var boxcnt=$(".chkuse").length;
		var no=tot - boxcnt;
		$(".chkuse"+no).removeClass("chkuse").addClass("inuse");
		if(boxcnt < 5){
			clearInterval(waittable);
		}
	}

	var maTablestat="<?=$maTablestat?>";

	console.log("00000 maTablestat = " + maTablestat);
	/*
	if(maTablestat=="start" || maTablestat == "null")
	{
		console.log("startstartstartstartstartstart");
		var waittime=setInterval("tablescan()",500);
		var waittable=setInterval("tablewait()",70);
	}
	else if(maTablestat=="scaned")
	{
		console.log("scanedscanedscanedscanedscaned");
		lightontable();
	}
	*/
	//if(maTablestat=="scaned")
	{
		lightontable();
	}
	/*else
	{
		var waittime=setInterval("tablescan()",500);
		var waittable=setInterval("tablewait()",70);
	}*/
	setTimeout("$('input[name=unfuocus]').focus()",1000);
</script>
