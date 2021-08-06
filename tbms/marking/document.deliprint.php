<?php
	$root="..";
	include_once $root."/_common.php";
	include_once $root."/_Inc/headpop.php";

	$type="POST";
	$odCode=$_GET["odCode"];
	$zipCode=$_GET["zipCode"];
	$deliexception=$_GET["deliexception"];

	if(strpos($deliexception,"O")!==false || strpos($deliexception,"T")!==false || strpos($deliexception,"D")!==false)
	{
		$delicomp="LOGEN";//로젠화면으로 수정했음
	}
	else
	{
		$delicomp=$_GET["delicomp"];
	}

	
	$site=$_GET["site"];
	$addprint=$_GET["addprint"];
	$delicode=$_GET["delicode"];
	
	$apiData="type=".$type."&odCode=".$odCode."&odCode=".$odCode."&zipCode=".$zipCode."&addprint=".$addprint."&delicode=".$delicode;


?>
<!-- s: -->
<style>
	*{font-family:"Nanum Gothic B700";font-size:14px;padding:0;margin:0;}
	table{table-layout:fixed;}
	/* 로젠 송장 css */
	dl, ul{width:100%;clear:left;border:1px solid red_;overflow:hidden;}
	dd{display:inline-block;float:left;}
	dd, li{border:1px solid red_;}
	span{padding:0;}
	/*.prt_div{width: 19.5cm;min-height: 9.5cm;background:url('/_Img/deliprt_logen_bg.png') no-repeat 0 0;background-size:100% auto;}*/
	.prt_div{width: 19.5cm;min-height: 9.5cm;}
	.prt_div div{float:left;width:48%;}
	.prt_div .prt_R{width:52%;}
	.ltop{height:85px;overflow:hidden;}
	.ltop dd{padding:0 0 0 2%;}
	.ltop dd{display:block;width:20%;}
	.ltop dd span{display:block;clear:left;;}
	.ltop dd.code1{width:75%;}
	#ClassificationCode1{font-size:60px;font-family:"Nanum Gothic B800";line-height:100%;letter-spacing:3px;}
	#BranchCode1{padding-left:30px;}
	#barcodeText1{width:100%;font-size:20px;font-family:"Nanum Gothic B700";text-align:center;}
	#barcodeDiv1{position:absolute;margin-left:-30px;}
	.lcode{height:40px;overflow:hidden;}
	.lcode .d1{width:25%;padding-top:10px;}
	#BranchfullCode{position:absolute;z-index:100;margin-left:5px;}
	.lcode .d2{width:70%;}
	.linfo{width:87%;height:52px;overflow:hidden;}
	.linfo2{clear:both;height:100px;}
	#reName2{padding-left:20px;letter-spacing:-1px;}
	.linfo .laddr{padding-top:3px;height:32px;overflow:hidden;}
	.ldate dd{width:35%;padding-left:13%;}
	#reSendname1{padding-left:60px;}
	#reRequest1{width:100%;height:50px;overflow:hidden;}
	#barcodeText4{float:right;width:50%;margin:-20px 20px 0 0;font-size:20px;}
	.ldesc{width:90%;height:80px;overflow:hidden;}
	.ldesc dd{width:35%;height:70px;padding-top:10px;text-align:center;}
	.ldesc .ibotc{padding-top:0;height:80px;}
	.ldesc .ibotc span{display:block;clear:both;font-size:18px;font-weight:bold;}
	.ldesc .lbot{width:30%;}
	#quantity2{}

	.rtop{height:78px;overflow:hidden;}
	.rtop dt{padding-left:60px;}
	.rtop dt.add{padding-left:0;}
	.rtop .d1{width:70%;}
	.rtop .d2{width:28%;}
	.rtop dd span{display:block;clear:left;}
	.rtop .add{clear:both;}
	.rcode{width:100%;height:64px;overflow:hidden;}
	.rcode dd{width:35%;}
	.rcode dd.bar{width:63%;}
	#quantity1{position:absolute;width:auto;font-size:16px;font-weight:bold;margin:65px 0 0 350px;}
	#barcodeText2{width:auto;font-size:18px;font-weight:bold;text-align:center;margin-left:50px;}
	#barcodeText3{width:auto;font-size:18px;font-weight:bold;text-align:center;margin-left:50px;}
	.rcode2{width:100%;height:63px;overflow:hidden;}
	.rcode2 span{margin-left:30px;}
	#ClassificationCode2{display:block;width:auto;margin:10px 0 0 0;font-size:28px;font-family:"Nanum Gothic B800";line-height:100%;text-align:center;}
	.rdeli{width:100%;height:58px;overflow:hidden;}
	.rdeli dd span, .rinfo dd span{display:block;}
	.rdeli .d1{width:88%;}
	.rdeli .d1{line-height:100%;}
	.rdeli .d1 span{display:inline-block;line-height:100%;}
	.rdeli .d1 .rname{margin-left:30px;}
	.rdeli .d1 .raddr{height:28px;overflow:hidden;line-height:100%;padding:0;}
	.rdeli .d1 .rrequ{height:14px;overflow:hidden;line-height:100%;padding:0;}
	.rdeli .d2{width:10%;text-align:center;}
	.rinfo{width:100%;height:35px;overflow:hidden;}
	.rinfo .d1{width:57%;padding-left:5%;letter-spacing:-1px;}
	.rinfo .d2{width:27%;padding-left:7%;}
	.rdesc{width:100%;height:50px;padding-top:20px;}
	.rdesc dd{width:30%;height:50px;text-align:center;}
	.rdesc .rbot{width:55%;}
	.rdesc .rlast{width:13%;}
	#quantity3{font-size:22px;font-family:"Nanum Gothic B800";}

	dl.btndiv{width:550px;margin:50px auto;}
	dl.btndiv dd span{float:left;width:140px;padding:10px;margin:10px;font-size:20px;font-weight:bold;background:green;border-radius:3px;color:#fff;text-align:center;cursor:pointer;}
	dl.btndiv dd span.btnsend{background:#0e98c0;}
	dl.btndiv dd span.noClick{background:gray;}

	/*우체국 송장 css*/
	/*.prt_post{width: 16.8cm;min-height: 10.7cm;background:url('/_Img/deliprt_post_bg.png') no-repeat 0 0;background-size:100% auto;}*/
	.prt_post{width: 16.8cm;min-height: 10.7cm;}
	.prt_post div{float:left;width:36%;}
	.prt_post .prt_post_C{width:54%;}
	.prt_post .prt_post_R{width:10%;}
	.prt_post .prt_post_B{width:85%;margin-left:15px;margin-top:3px;font-size:11px;white-space: nowrap;overflow: hidden;}
	.prt_post table {width:100%;}
	.prt_post table tr td{font-size:12px;}

	.vertical-text-3 {-ms-transform: rotate(270deg);-moz-transform: rotate(270deg);-webkit-transform: rotate(270deg);transform: rotate(270deg);-ms-transform-origin: right bottom;-moz-transform-origin: right bottom;-webkit-transform-origin: right bottom;transform-origin: right bottom;}

	.prt_post .prt_post_R div{position:absolute;font-size:10px;}
	#epostSendaddress2 {width:300px;margin:85px 0 0 -285px;}
	#epostSendname2 {width:300px;margin:85px 0 0 -270px;}
	#eposttitleqty {width:300px;margin:85px 0 0 -255px;}
	#epostbarcode2 {width:100px;margin:-12px 0 0 -115px;z-index:999;}
	#epostbarcode2 div {position:relative;}
	#epostbarcodeName2 {width:100px;margin:10px 0 0 -55px;z-index:999;}

	#epostzipbarcode{padding:0;margin-left:0px;}
	#epostzipbarcodeText {width:100%;font-size:15px;text-align:center;}

	#epostreMobile{letter-spacing: -1px;font-size:13px;}
	#epostdeliname1{width:100%;}

	#edelivAreaCd1{font-family:"Nanum Gothic B800";font-size:33px;text-align:center;padding-top:25px;}
	#edelivAreaCd2{font-family:"Nanum Gothic B800";font-size:33px;text-align:center;padding-top:25px;}

	#earrCnpoNm {font-family:"Nanum Gothic B800";font-size:15px;text-align:center;padding-top:40px;}
	#edelivPoNm {font-family:"Nanum Gothic B800";font-size:15px;text-align:center;padding-top:40px;}

	#edelivAreaCd3 {font-family:"Nanum Gothic B800";font-size:29px;text-align:center;}
	#edelivAreaCd4 {font-family:"Nanum Gothic B800";font-size:29px;text-align:center;}
	#edelivAreaCd5{font-family:"Nanum Gothic B800";font-size:15px;text-align:center;}

	.post_td {padding-left:18px;}

	#epostbarcode1 {width:300px !important;} 

	dl.btnpostdiv{width:550px;margin:50px auto;}
	dl.btnpostdiv dd span{float:left;width:140px;padding:10px;margin:10px;font-size:20px;font-weight:bold;background:green;border-radius:3px;color:#fff;text-align:center;cursor:pointer;}
	dl.btnpostdiv dd span.btnsend{background:#0e98c0;}
	dl.btnpostdiv dd span.noClick{background:gray;}

	#screen {position:absolute;width:100%;height:500px;background-color:#333;opacity:0.5;z-index:998;}
	#loadingID {position:absolute;width:100%;height:0;text-align:center;z-index:999;}
	#loadimg {position:relative;width:64px;height:64px;text-align:center;margin:auto;
		background-image:url("/_Img/deliprt_loading2.gif");background-size:100% 100%;background-position:50% 50%;background-repeat:no-repeat;}

	dl.confirmbtn{text-align:center;overflow:hidden;float:right;padding:0px 0px 20px 0px;}
	dl.confirmbtn dd{float:right;display:inline-block;padding:10px;width:40px;height:15px;border:1px solid #111;background:#fff;font-weight:bold;font-size:14px;color:#000;margin:20px 20px 0 0;}
</style>

<script>
window.addEventListener('afterprint', (event) => {
	console.log("afterprintafterprintafterprintafterprint");
	setTimeout('showDeliPrint();', 1000); 
});
</script>
<div id="prt_div">
<?php if($delicomp=="LOGEN" || $delicomp=="logen"){?>
<div class="prt_div">
	<div class="prt_L">
		<dl class="ltop">
			<dd class="" style="padding-left:5px;">
				<span id="BranchCode1"></span>
				<span id="BranchName1"></span>
				<span id="priceEncry1"></span>
				<span id="FreightName1"></span>
			</dd>
			<dd class="code1">
				<span id="ClassificationCode1"></span>
				<div class="barcodetext" id="barcodeText1"></div>
			</dd>
		</dl>
		<dl class="lcode">
			<dd class="d1"><span id="BranchfullCode"></span></dd>
			<dd class="d2">
				<div class="barcode" id="barcodeDiv1"></div>
			</dd>
		</dl>
		<ul class="linfo">
			<li class="li01"><span id="reName2"></span>&nbsp;&nbsp;&nbsp;<span id="rePhone2"></span></li>
			<li class="laddr" style="padding-left:5px;"><span id="reAddr2"></span></li>
		</ul>
		<dl class="ldate">
			<dd><span id="reDeliDate2"></span></dd>
			<dd><span id="rescheduleDate2"></span></dd>
		</dl>
		<ul class="linfo linfo2">
			<li><span id="reSendname1"></span></li>
			<li class="laddr" style="padding-left:5px;"><span id="reSendaddress"></span></li>
			<div id="reRequest1" style="padding-left:5px;"></div>
		</ul>
		<div class="barcodetext" id="barcodeText4"></div>
		<dl class="ldesc">
			<dd><span id="odTitle1"></span></dd>
			<dd class="ibotc">
				<span id="quantity2"></span>
				<span id="RoadName"></span>
				<span id="SalesName"></span>
			</dd>
			<dd class="lbot">
				<span id="priceEncry4"></span><br>
				<span id="FreightName3"></span>
			</dd>
		</dl>
	</div>
	<div class="prt_R">
		<dl class="rtop">
			<div id="quantity1"></div>
			<dt><span id="reName1"></span></dt>
			<dd class="d1">
				<span id="rePhone1"></span>
				<span id="reMobile1"></span>
			</dd>
			<dd class="d2">
				<span id="reDeliDate1"></span>
				<span id="rescheduleDate1"></span>
			</dd>
			<dt class="add"><span id="reAddr1"></span></dt>
		</dl>
		<dl class="rcode">
			<dd>
				<span id="userID1"></span><br>
				<span id="priceEncry2"></span><br>
				<span id="FreightName2"></span>
			</dd>
			<dd class="bar">
				<div class="barcodetext" id="barcodeText2"></div>
				<div class="barcode" id="barcodeDiv2" style="margin-left:-20px;"></div>
			</dd>
		</dl>
		<dl class="rcode rcode2">
			<dd style="padding-top:5px;">
				<span id="BranchCode2"></span>
				<span id="BranchName2"></span><br>
				<span id="ClassificationCode2"></span>
			</dd>
			<dd class="bar">
				<div class="barcode" id="barcodeDiv3" style="margin-left:-20px;"></div>
				<div class="barcodetext" id="barcodeText3"></div>
			</dd>
		</dl>
		<dl class="rdeli">
			<dd class="d1">
				<span id="reName3" class="rname"></span><span id="rePhone3"></span><br>
				<span class="raddr" id="reAddr3"></span><br>
				<span class="rrequ" id="reRequest2"></span>
			</dd>
			<dd class="d2">
				<span id="priceEncry3"></span>
				<span id="FreightName4"></span>
			</dd>
		</dl>
		<dl class="rinfo">
			<dd class="d1">
				<span id="reSendname2"></span>
				<span id="custName"></span>
			</dd>
			<dd class="d2">
				<span id="userID2"></span>
				<span id="reDeliDate3"></span>
			</dd>
		</dl>
		<dl class="rdesc">
			<dd class="rbot">
			</dd>
			<dd>
				<span id="odTitle2"></span>
			</dd>
			<dd class="rlast">
				<span id="quantity3"></span>
			</dd>
		</dl>
	</div>
	<dl class="btndiv" id="btndl" >
		<dd><span id="btnclose" onclick="popdeliclose();">닫기</span></dd>
		<dd><span id="btnprt" class="btnsend" onclick="sendlogen();" data-type=""  data-aprint="" style="display:none;"></span></dd>
		<?php if($site!="MANAGER"){?>
			<dd><span id="btnprtship" class="btnShipping" onclick="getlogenshipping();" style="display:none;">로젠묶음배송</span></dd>
		<?php }?>
	</dl>
</div>
<?php }else if($delicomp=="POST" || $delicomp=="post"){?>
<div class="prt_post">
	<div class="prt_post_L">
		<style>
			table.ltbl tr td{vertical-align:top;padding:3px 0 0 6px;}
		</style>
		<table class="ltbl">
		<colgroup>
			<col width="40%">
			<col width="30%">
			<col width="30%">
		</colgroup>
		<tr height="63">
			<td id="epostNm" style="padding-top:40px;"></td>
			<td id="epostDate" colspan="2" style="padding-top:40px;"></td>
		</tr>
		<tr height="25">
			<td colspan="3" id="miName"></td>
		</tr>
		<tr height="21">
			<td colspan="3" id="ordCompNm"></td>
		</tr>
		<tr height="21">
			<td colspan="3" style="text-align:right;">요금:계약요금</td>
		</tr>
		<tr height="85">
			<td colspan="2">
				<div class="barcode" id="epostzipbarcode"></div>
				<div class="barcodetext" id="epostzipbarcodeText"></div>
			</td>
			<td id="epostqty1" style="text-align:right;"></td>
		</tr>
		<tr height="148">
			<td colspan="3"><span id="epostodTitle1"></span>,,<span id="epostqty2"></span></td>
		</tr>
		</table>
	</div>

	<div class="prt_post_C">
		<style>
			table.ctbl tr td{vertical-align:top;padding-top:3px;font-size:15px;}
		</style>
		<table class="ctbl">
		<colgroup>
			<col width="17%">
			<col width="16%">
			<col width="16%">
			<col width="16%">
			<col width="16%">
			<col width="16%">
		</colgroup>
		<tr height="40">
			<td rowspan="2" id="edelivAreaCd1"></td><td rowspan="2" id="earrCnpoNm"></td><td rowspan="2" id="edelivAreaCd2"></td><td rowspan="2" id="edelivPoNm"></td><td id="edelivAreaCd3"></td><td id="edelivAreaCd4"></td>
		</tr>
		<tr height="24">
			<td colspan="2" id="edelivAreaCd5">-11-</td>
		</tr>
		<tr height="23">
			<td colspan="4" rowspan="2" id="epostreAddress" class="post_td"></td><td colspan="2" id="epostrezipcode" style="text-align:right;padding-right:20px;"></td>
		</tr>
		<tr height="18">
			<td colspan="2" id="epostrePhone" style="font-size:13px;"></td>
		</tr>
		<tr height="22">
			<td colspan="4" id="epostreName" class="post_td"></td><td colspan="2" id="epostreMobile"></td>
		</tr>

		<tr height="50">
			<td colspan="6" id="epostSendaddress1" class="post_td" style="padding-right:5px;"></td>
		</tr>
		<tr height="25">
			<td colspan="6" id="epostSendname1" class="post_td"></td>
		</tr>
		<tr height="23">
			<td colspan="6" id="epvTelNo" class="post_td"></td>
		</tr>
		<tr height="15">
			<td colspan="6" style="font-size:10px;" class="post_td">*고객님의 개인정보 보호를 위하여 임시 가상번호를 사용합니다.</td>
		</tr>
		<tr height="27">
			<td colspan="6" class="post_td"><div class="barcodetext" id="epostdeliname1"></div></td>
		</tr>
		<tr height="87">
			<td colspan="6"><div class="barcode" id="epostbarcode1"></div></td>
		</tr>
		</table>
	</div>

	<div class="prt_post_R">
		<div class="vertical-text-3" id="epostSendaddress2"></div>
		<div class="barcode vertical-text-3" id="epostbarcode2"></div>
		<div class="vertical-text-3" id="epostbarcodeName2"></div>
		<div class="vertical-text-3" id="epostSendname2"></div>
		<div class="vertical-text-3" id="eposttitleqty"></div>
	</div>

	<div class="prt_post_B" id="epostRequest"></div>

	<dl class="btnpostdiv" id="btnpostdl" >
		<dd><span id="btnepclose" onclick="popePostclose();">닫기</span></dd>
		<dd><span id="btnepprt" class="btnsend" onclick="sendpost();" data-type="" data-aprint="" style="display:none;"></span></dd>
		<?php if($site!="MANAGER"){?>
			<dd><span id="btneprtship" class="btnShipping" onclick="getpostshipping();" style="display:none;">우체국묶음배송</span></dd>
		<?php }?>
	</dl>
</div>
<?php }?>
</div>
<input type="hidden" id="postcnt" name="postcnt" value="" />
<input type="hidden" id="reBoxmedicnt" name="reBoxmedicnt" value="" />
<input type="hidden" id="logendeliId" name="logendeliId" value="" />
<!-- e: 서울한의원 -->
<script>
	
	function getlogenshipping()
	{
		console.log("로젠묶음배송!!!");

		var odCode="<?=$odCode?>";

		//self.close();
		window.open("/goods/document.shipping.php?delicomp=LOGEN&odCode="+odCode, "proc_shipping_logen","width=900,height=850");//ok  -새창. 

	}
	function getpostshipping()
	{
		console.log("우체국묶음배송!!!");

		var odCode="<?=$odCode?>";

		//self.close();
		window.open("/goods/document.shipping.php?delicomp=POST&odCode="+odCode, "proc_shipping_post","width=900,height=850");//ok  -새창. 
	}
	function sendpost()
	{
		loadingscreen();
		var odCode="<?=$odCode?>";
		var type=$("#btnepprt").data("type");
		var aprint=$("#btnepprt").data("aprint");
		var url="odCode="+odCode+"&sendtype="+type+"&addprint="+aprint;
		console.log("sendpost  url = " + url);
		$("#btnepprt").css("display","none");
		$("#btneprtship").css("display","none");
		callapi('GET','marking','markingdeliverypost',url);
	}
	function popePostclose()
	{
		var site="<?=$site?>";
		console.log("popePostclose site = " + site);
		if(site=="MANAGER")
		{
			self.close();
		}
		else
		{
			childdelClose();
		}
	}
	function sendlogen()
	{
		loadingscreen();
		var odCode="<?=$odCode?>";
		var type=$("#btnprt").data("type");
		var aprint=$("#btnprt").data("aprint");
		var url="odCode="+odCode+"&sendtype="+type+"&addprint="+aprint;
		$("#btnprtship").css("display","none");
		$("#btnprt").css("display","none");
		callapi('GET','marking','markingdelivery',url);
	}
	function popdeliclose()
	{
		var site="<?=$site?>";
		console.log("popdeliclosepopdeliclose site = " + site);
		if(site=="MANAGER")
		{
			self.close();
		}
		else
		{
			childdelClose();
		}
	}
	function childdelClose()
	{
		//아래와 같이 하면 opener를 찾을수 없다. 그래서.. windows.open으로 하지 말고.. api로 바꿔야 할듯.......
		console.log("childdelClosechilddelClosechilddelClose");
		//window.close();
		opener.location.href = "javascript:parentdelClose();";
		self.close();		
	}
	function popdelidoneclose()
	{
		$("#screen1").remove();
		$("#layersignpop").remove();
	}
	function popupDoneMessage(maintxt, subtxt)
	{
		$("#screen1").remove();
		$("#layersignpop").remove();
		var w=500;
		var h=150;
		var arr=popupcenter(w,h).split("|");
		var top=arr[0];
		var left=arr[1];
		var hh=window.innerHeight;

		var txt="<div id='screen1'  style='position:fixed;width:100%;top:0;background:#000;opacity:0.7;height:"+hh+"px; z-index:9999;'></div>";
			txt+="<div id='layersignpop' style='position:fixed;top:0;left:0;z-index:10001;overflow:hidden;display:block;width:"+w+"px;height:"+h+"px;margin:"+top+"px 0 0 "+left+"px;padding:25px 15px 15px 15px;background-color:#0EAA6E' class='calloutp calloutp-warning'>";
			txt+="<h4 style='font-size:30px;font-weight:bold;color:white;text-align: center;'>"+maintxt+"</h4>";
			txt+="<h4 style='font-size:30px;font-weight:bold;color:white;text-align: center;'>"+subtxt+"</h4>";
			txt+="<dl class='confirmbtn'><dd onclick='javascript:popdelidoneclose()'>"+getTxtData("CONFIRM")+"</dd></dl>"; //확인 
			txt+="</div>";
		$("body").prepend(txt);
		//setTimeout("$('#layersignpop').remove()",parseInt(chktop));
	}
	function showDeliPrint()
	{
		var code="<?=$odCode?>";
		var delicomp="<?=$delicomp?>";
		var deliexception="<?=$deliexception?>";

		var site="<?=$site?>";
		console.log("popdeliclosepopdeliclose site = " + site);
		if(site=="MANAGER")
		{
			self.close();
		}
		else
		{
			if(delicomp=="POST" || delicomp=="post")
			{
				console.log("delicomp = " + delicomp+", deliexception = " + deliexception+", reBoxmedicnt = " + reBoxmedicnt);
				//리로드로 바꿈.. 
				window.location.reload();
				//window.open("document.deliprint.php?odCode="+code+"&deliexception="+deliexception+"&delicomp="+delicomp, "proc_report_deli","width=800,height=500");//ok  -새창. 로딩이 걸리네.
			}
			else
			{
				self.close();
			}
		}

	}
	function makepage(json)
	{
		//console.log("makepage //////////////////////// ")
		var obj = JSON.parse(json);
		console.log(obj)

		if(obj["apiCode"]=="markingdelivery")//로젠
		{
			if(obj["resultCode"]=="200")
			{
				
				if(!isEmpty(obj["sendtype"]) && obj["sendtype"]=="relogen" || !isEmpty(obj["sendtype"]) && obj["sendtype"]=="logen")
				{
					$("#btnprt").css("display", "none");
					$("#btnprtship").css("display", "none");
				}
				else
				{
					$("#btnprt").css("display", "block");
					$("#btnprtship").css("display", "block");
				}


				//송장번호 
				var deliCode=obj["deliCode"];
				//바코드
				if(!isEmpty(deliCode))
				{
					var deliCodeView=deliCode.substring(0,3)+"-"+deliCode.substring(3,7)+"-"+deliCode.substring(7,11);
					$("#barcodeDiv1").barcode(deliCode, "code128", {barWidth:2, barHeight: 40, fontSize:15, showHRI:false});
					//$("#barcodeDiv2").barcode(deliCode, "code128", {barWidth:2, barHeight: 44, fontSize:15, showHRI:false});
					//$("#barcodeDiv3").barcode(deliCode, "code128", {barWidth:2, barHeight: 44, fontSize:15, showHRI:false});
					$("#barcodeDiv2").barcode(deliCode, "code128", {color:"#191919", barWidth:2, barHeight: 44, fontSize:15, showHRI:false});
					$("#barcodeDiv3").barcode(deliCode, "code128", {color:"#191919",barWidth:2, barHeight: 44, fontSize:15, showHRI:false});

					$("#barcodeText1").text(deliCodeView);
					$("#barcodeText2").text(deliCodeView);
					$("#barcodeText3").text(deliCodeView);
					$("#barcodeText4").text(deliCodeView);
				}
				//지점코드 (639)
				var BranchCode=!isEmpty(obj["BranchCode"]) ? obj["BranchCode"] : "";
				$("#BranchCode1").text(BranchCode);
				$("#BranchCode2").text(BranchCode);
				//지점명 (장성)
				var BranchName=!isEmpty(obj["BranchName"]) ? obj["BranchName"] : "";
				$("#BranchName1").text(BranchName);
				$("#BranchName2").text(BranchName);

				//수량
				var quantity = "1";
				$("#quantity1").text(quantity);
				$("#quantity2").text(quantity);
				$("#quantity3").text(quantity);

				//금액
				var priceEncry=!isEmpty(obj["priceEncry"]) ? obj["priceEncry"] : "";
				$("#priceEncry1").text(priceEncry);
				$("#priceEncry2").text(priceEncry);
				$("#priceEncry3").text(priceEncry);
				$("#priceEncry4").text(priceEncry);
				
				//운임구분
				var freightName=!isEmpty(obj["freightName"]) ? obj["freightName"] : "";
				$("#FreightName1").text(freightName);
				$("#FreightName2").text(freightName);
				$("#FreightName3").text(freightName);
				$("#FreightName4").text(freightName);

				//분류코드 
				var ClassificationCode=!isEmpty(obj["ClassificationCode"]) ? obj["ClassificationCode"] : "";
				$("#ClassificationCode1").text(ClassificationCode);
				$("#ClassificationCode2").text(ClassificationCode);


				//품명
				$("#odTitle1").text(obj["odTitle"]);
				$("#odTitle2").text(obj["odTitle"]);

				//업체코드
				$("#userID1").text("업체코드"+obj["userID"]);
				$("#userID2").text(obj["userID"]);

				
				//받는사람 
				var re_name=obj["reName"];
				var re_phone=obj["rePhone"];
				var re_mobile=obj["reMobile"];
				var re_addr1=obj["reAddress1"];
				var re_addr2=obj["reAddress2"];
				
				var rePhoneS="--";
				if(obj["rePhone"]!="--"){
					rePhoneS=obj["rePhone"].substring(0,(obj["rePhone"].length) -4)+"****";
				}
				//var rePhoneS=obj["rePhone"].substring(0,(obj["rePhone"].length) -4)+"****";
				var reMobileS="--";
				if(obj["reMobile"]!="--"){
					reMobileS=obj["reMobile"].substring(0,(obj["reMobile"].length) -4)+"****";
				}
				//var reMobileS=obj["reMobile"].substring(0,(obj["reMobile"].length) -4)+"****";

				var nlen=re_name.length;
				var reNameS="";
				if(nlen==2 || nlen==3)
				{
					reNameS=obj["reName"].substring(0, (obj["reName"].length)-1)+"*";
				}
				else if(nlen==4 || nlen==5)
				{
					reNameS=obj["reName"].substring(0, (obj["reName"].length)-2)+"**";
				}
				else if(nlen>=6)
				{
					var len=nlen-4;
					var restar="";
					if(len>2)len=2;
					for(i=0;i<len;i++)
					{
						restar+="*";
					}
					reNameS=obj["reName"].substring(0, 4)+restar;
				}

				//받는사람 이름
				$("#reName1").text(re_name);
				$("#reName2").text(reNameS);
				$("#reName3").text(re_name);
				//받는사람 전화번호  / 폰번호
				$("#rePhone1").text(re_phone);
				$("#reMobile1").text(re_mobile);
				$("#rePhone2").text(rePhoneS + "/" + reMobileS);
				$("#rePhone3").text(re_phone + "/" + re_mobile);
				//받는사람 주소 
				$("#reAddr1").text(re_addr1 +" "+ re_addr2);
				$("#reAddr2").text(re_addr1 +" "+ re_addr2);
				$("#reAddr3").text(re_addr1 +" "+ re_addr2);
				//받는사람 상세 주소 
				//$("#redeAddr1").text(re_addr2);
				//$("#redeAddr2").text(re_addr2);
				//$("#redeAddr3").text(re_addr2);
				

				//받는사람 DONG
				$("#RoadName").text(obj["RoadName"]);
				//배송영업소			
				$("#SalesName").text(obj["SalesName"]);

				//배송요청사항
				$("#reRequest1").text(obj["reRequest"]);
				$("#reRequest2").text(obj["reRequest"]);

				//계약영업소 코드
				$("#BranchfullCode").text(obj["custCode"]);
				//계약영업소 직원 
				$("#custName").text(obj["custName"]);

				//보내는사람
				var sendphone=obj["reSendphone"];
				if(sendphone=="--")
				{
					sendphone=obj["reSendmobile"];
				}
				else
				{
					sendphone=obj["reSendphone"];
				}
				$("#reSendname1").text(obj["reSendname"] + " " + sendphone);
				$("#reSendname2").text(obj["reSendname"] + " " + sendphone);
				//보내는사람주소 
				$("#reSendaddress").text(obj["reSendaddress1"]+" "+obj["reSendaddress2"]);

				//발송일
				//$("#reDeliDate1").text(obj["reDeliDate"]);
				//$("#reDeliDate2").text(obj["reDeliDate"]);
				//$("#reDeliDate3").text(obj["reDeliDate"]);
				$("#reDeliDate1").text(" ");
				$("#reDeliDate2").text(" ");
				$("#reDeliDate3").text(" ");

				//배송예정일 
				//$("#rescheduleDate1").text(obj["reScheduleDate"]);
				//$("#rescheduleDate2").text(obj["reScheduleDate"]);
				$("#rescheduleDate1").text(" ");
				$("#rescheduleDate2").text(" ");

				if(!isEmpty(obj["re_delino"]) && obj["re_deliexception"].indexOf(",T")!==-1)
				{
					//분류코드 
					var ClassificationCode=obj["deliExName"];
					$("#ClassificationCode1").text(ClassificationCode);
					$("#ClassificationCode1").css("font-size","40px");

					$("#btnclose").css("display","none");
					$("#btnprtship").css("display","none");
					$("dl.btndiv").remove();
				}
				else
				{
					if(!isEmpty(obj["sendtype"]) && obj["sendtype"]=="logen")//로젠서버에 보내고 
					{
						$("#btnclose").css("display","none");
						$("#btnprtship").css("display","none");
						$("dl.btndiv").remove();
						setTimeout('print();', 500);
					}
					else if(!isEmpty(obj["sendtype"]) && obj["sendtype"]=="relogen")
					{
						$("#btnclose").css("display","none");
						$("#btnprtship").css("display","none");
						$("dl.btndiv").remove();
						setTimeout('print();', 500);
						
						var site="<?=$site?>";
							console.log("site = " + site);
						if(!isEmpty(site)&&site=="MANAGER")
						{
						}
						else
						{
							setTimeout('childdelClose();', 500);
						}
					}
					else
					{
						$("#btnprt").text("로젠전송승인");
						$("#btnprt").data("type","logen");

						var addprint=!isEmpty(obj["addprint"]) ? obj["addprint"] :"<?=$addprint?>";

						if(!isEmpty(addprint) && addprint=="R")
						{
							$("#btnprtship").css("display","none");
							$("#btnprt").text("로젠추가승인");
							$("#btnprt").data("aprint","R");
						}
						else
						{
							$("#btnprt").data("aprint","");
						}
						
					}
				}
			}
			else
			{
				alert(obj["resultMessage"]);
			}

			closeloadingscreen();

		}
		else if(obj["apiCode"]=="markingdeliverypost")//우체국 
		{
			if(obj["resultCode"]=="200")
			{
				if(!isEmpty(obj["sendtype"]) && obj["sendtype"]=="repost" || !isEmpty(obj["sendtype"]) && obj["sendtype"]=="epost")
				{
					$("#btnepprt").css("display", "none");
					$("#btneprtship").css("display","none");
				}
				else
				{
					$("#btnepprt").css("display", "block");
					$("#btneprtship").css("display","block");
				}


				//접수국
				$("#epostNm").text("접수국:"+obj["epostNm"]);
				//신청일
				$("#epostDate").text("신청일:"+obj["epostDate"]);

				//주문인
				$("#miName").text("주문인: "+obj["miName"]);
				//고객주문처 
				var ordCompNm=!isEmpty(obj["ordCompNm"]) ? obj["ordCompNm"] : "";
				$("#ordCompNm").text("고객주문처:"+ordCompNm);

				//배송요청사항
				$("#epostRequest").text(obj["reRequest"]);

				//집배코드 
				$("#earrCnpoNm").text(obj["earrCnpoNm"]);
				$("#edelivPoNm").text(obj["edelivPoNm"]);

				//처방명
				$("#epostodTitle1").text(obj["odTitle"]);
				$("#eposttitleqty").text(obj["odTitle"]+",,수량:1");

				//왼쪽 수량 
				$("#epostqty1").html("(1/1)<br>(1/1)");
				$("#epostqty2").text("수량:1");

				//받는사람 주소 
				$("#epostSendaddress1").text(obj["reAddress1"] + " " + obj["reAddress2"]);
				$("#epostSendaddress2").text(obj["reAddress1"] + " " + obj["reAddress2"]);
				//받는사람 이름 
				var epvTelNo="";
				if(!isEmpty(obj["epvTelNo"]))
				{
					epvTelNo=obj["epvTelNo"];
					//0503 5891 6445
					var epevTelNo1=epvTelNo.substring(0,4);
					var epevTelNo2=epvTelNo.substring(4,8);
					var epevTelNo3=epvTelNo.substring(8,12);
					epvTelNo=epevTelNo1+"-"+epevTelNo2+"-"+epevTelNo3;
				}
				else
				{
					epvTelNo="050358916445";
					//0503 5891 6445
					var epevTelNo1=epvTelNo.substring(0,4);
					var epevTelNo2=epvTelNo.substring(4,8);
					var epevTelNo3=epvTelNo.substring(8,12);
					epvTelNo=epevTelNo1+"-"+epevTelNo2+"-"+epevTelNo3;
					//epvTelNo="0505-624-9694";
				}

				$("#epostSendname1").text(obj["reName"]+" 님");
				$("#epostSendname2").text(obj["reName"]+" 님 " + " " + epvTelNo);
				//받는사람 가상번호 
				$("#epvTelNo").text("T: "+epvTelNo);

				//보내는사람 
				$("#epostreName").text(obj["reSendname"]);
				$("#epostreMobile").text("M: "+obj["reSendmobile"]);
				$("#epostrePhone").text("T: "+obj["reSendphone"]);
				$("#epostreAddress").text(obj["reSendaddress1"]+" "+obj["reSendaddress2"]);
				$("#epostrezipcode").text(obj["reSendzipcode"]);

				//집배코드 
				//"제1 052 61 05"
				var edelivAreaCd=obj["edelivAreaCd"];

				edelivAreaCd1=edelivAreaCd.substring(0,2);
				edelivAreaCd2=edelivAreaCd.substring(2,5);
				edelivAreaCd3=edelivAreaCd.substring(5,7);
				edelivAreaCd4=edelivAreaCd.substring(7,9);

				$("#edelivAreaCd1").text(edelivAreaCd1);
				$("#edelivAreaCd2").text(edelivAreaCd2);
				$("#edelivAreaCd3").text(edelivAreaCd3);
				$("#edelivAreaCd4").text(edelivAreaCd4);

				var epostzipcode=obj["reZipcode"];
				//받는사람 5자리 우편번호 바코드
				$("#epostzipbarcode").barcode(epostzipcode, "code128", {barWidth:2, barHeight: 50, fontSize:14, showHRI:false});
				$("#epostzipbarcodeText").text(epostzipcode);

				//송장번호 
				var deliCode=obj["delicode"];
				if(deliCode=="TESTREGINOAPI") {deliCode="7892121841383";}//DOO::일단은 잠시 송장번호 넣기 
				//바코드
				if(!isEmpty(deliCode))
				{
					//12345-6789-0123
					var deliCodeView=deliCode.substring(0,5)+"-"+deliCode.substring(5,9)+"-"+deliCode.substring(9,13);
					$("#epostbarcode1").barcode(deliCode, "code128", {barWidth:2, barHeight: 60, fontSize:10, showHRI:false});
					$("#epostbarcode2").barcode(deliCode, "code128", {barWidth:1, barHeight: 20, fontSize:10, showHRI:false});
					$("#epostdeliname1").text("등기번호: "+deliCodeView);
					$("#epostbarcodeName2").text(deliCodeView);
				}
				
				$("input[name=reBoxmedicnt]").val(obj["reBoxmedicnt"]);
				$("input[name=postcnt]").val(obj["postcnt"]);
				//

				console.log("dddd");
				if(!isEmpty(obj["re_delino"]) && obj["re_deliexception"].indexOf(",T")!==-1)
				{
					//분류코드 
					var ClassificationCode=obj["deliExName"];
					$("#epostbarcode1").text(ClassificationCode);
					$("#epostbarcode1").css("font-size","40px");

					$("#btnepclose").css("display","none");
					$("#btneprtship").css("display","none");
					$("dl.btnpostdiv").remove();
				}
				else
				{
					if(!isEmpty(obj["sendtype"]) && obj["sendtype"]=="epost")//우체국 서버에 보내고 
					{
						$("#btnepclose").css("display","none");
						$("#btneprtship").css("display","none");
						$("dl.btnpostdiv").remove();
						setTimeout('print();', 500);
					}
					else if(!isEmpty(obj["sendtype"]) && obj["sendtype"]=="repost")
					{
						$("#btnepclose").css("display","none");
						$("#btneprtship").css("display","none");
						$("dl.btnpostdiv").remove();
						setTimeout('print();', 500);
						var site="<?=$site?>";
						console.log("site = " + site);
						if(!isEmpty(site)&&site=="MANAGER")
						{
						}
						else
						{
							console.log("popdeliclose repost");

							var delicomp="<?=$delicomp;?>";
							console.log("popdeliclose delicomp = " + delicomp+"");
							if(delicomp.toUpperCase()=="POST")
							{
								var reBoxmedicnt=obj["reBoxmedicnt"];
								var postcnt=obj["postcnt"];

								console.log("repost   ==>>> delicomp = " + delicomp+", reBoxmedicnt = " + reBoxmedicnt + ", postcnt = " + postcnt);

								if(parseInt(reBoxmedicnt)<=parseInt(postcnt))
								{
									console.log("다 출력함.. ");
									setTimeout('childdelClose();', 500);
								}
								else
								{
									console.log("송장 "+ postcnt+"번째 출력하러 가자!");
									//self.close();
									//showDeliPrint();
									//loadingscreen();

									//callapi('GET','marking','markingdeliverypost','<?=$apiData?>');
								}
							}



							
						}
					}
					else
					{
						
						console.log("44444444");
						if(parseInt(obj["postcnt"])>=0)
						{
							var postcnt=parseInt(obj["postcnt"]);
							if(postcnt==parseInt(obj["reBoxmedicnt"]))
							{
								$("#btnepprt").hide();
								$("#btneprtship").hide();
								popupDoneMessage("송장이 "+obj["reBoxmedicnt"]+"건 있습니다.","("+postcnt+"건 모두 출력하였습니다.)");
							}
							else
							{
								$("#btnepprt").show();
								$("#btneprtship").show();
								popupDoneMessage("송장이 "+obj["reBoxmedicnt"]+"건 있습니다.","("+(postcnt+1)+"번째 송장 출력)");

								$("#btnepprt").text("우체국전송승인");
								$("#btnepprt").data("type","epost");
								var addprint=!isEmpty(obj["addprint"]) ? obj["addprint"] :"<?=$addprint?>";

								console.log("우체국전송승인우체국전송승인  addprint = " + addprint);
								if(!isEmpty(addprint) && addprint=="R")
								{
									$("#btneprtship").css("display","none");
									$("#btnepprt").text("우체국추가승인");
									$("#btnepprt").data("aprint","R");
								}
								else
								{
									$("#btnepprt").data("aprint","");
								}
							}
						}

					}
				}
			}
			else
			{
				alert(obj["resultMessage"]);
			}


			

			closeloadingscreen();

		}
		else if(obj["apiCode"]=="markingdeliveryex")
		{
			if(obj["resultCode"]=="200")
			{
				//분류코드 
				var ClassificationCode=obj["deliExName"];
				$("#ClassificationCode1").text(ClassificationCode);
				$("#ClassificationCode1").css("font-size","40px");

				//품명
				$("#odTitle1").text(obj["odTitle"]);
				$("#odTitle2").text(obj["odTitle"]);

				//받는사람 
				var re_name=obj["reName"];
				var re_phone=obj["rePhone"];
				var re_mobile=obj["reMobile"];
				var re_addr1=obj["reAddress1"];
				var re_addr2=obj["reAddress2"];
				
				var rePhoneS="--";
				if(obj["rePhone"]!="--"){
					rePhoneS=obj["rePhone"].substring(0,(obj["rePhone"].length) -4)+"****";
				}
				//var rePhoneS=obj["rePhone"].substring(0,(obj["rePhone"].length) -4)+"****";
				var reMobileS="--";
				if(obj["reMobile"]!="--"){
					reMobileS=obj["reMobile"].substring(0,(obj["reMobile"].length) -4)+"****";
				}
				//var reMobileS=obj["reMobile"].substring(0,(obj["reMobile"].length) -4)+"****";

				var nlen=re_name.length;
				var reNameS="";
				if(nlen==2 || nlen==3)
				{
					reNameS=obj["reName"].substring(0, (obj["reName"].length)-1)+"*";
				}
				else if(nlen==4 || nlen==5)
				{
					reNameS=obj["reName"].substring(0, (obj["reName"].length)-2)+"**";
				}
				else if(nlen>=6)
				{
					var len=nlen-4;
					var restar="";
					if(len>2)len=2;
					for(i=0;i<len;i++)
					{
						restar+="*";
					}
					reNameS=obj["reName"].substring(0, 4)+restar;
				}

				//받는사람 이름
				$("#reName1").text(re_name);
				$("#reName2").text(reNameS);
				$("#reName3").text(re_name);
				//받는사람 전화번호  / 폰번호
				$("#rePhone1").text(re_phone);
				$("#reMobile1").text(re_mobile);
				$("#rePhone2").text(rePhoneS + "/" + reMobileS);
				$("#rePhone3").text(re_phone + "/" + re_mobile);
				//받는사람 주소 
				$("#reAddr1").text(re_addr1 + re_addr2);
				$("#reAddr2").text(re_addr1 + re_addr2);
				$("#reAddr3").text(re_addr1 + re_addr2);
				
				//배송요청사항
				$("#reRequest1").text(obj["reRequest"]);
				$("#reRequest2").text(obj["reRequest"]);

				//보내는사람
				var sendphone=obj["reSendphone"];
				if(sendphone=="--")
				{
					sendphone=obj["reSendmobile"];
				}
				else
				{
					sendphone=obj["reSendphone"];
				}
				$("#reSendname1").text(obj["reSendname"] + " " + sendphone);
				$("#reSendname2").text(obj["reSendname"] + " " + sendphone);
				//보내는사람주소 
				$("#reSendaddress").text(obj["reSendaddress1"]+" "+obj["reSendaddress2"]);

				$("#btnprtship").css("display","none");

				//setTimeout('childdelClose();', 500);
			}
			else
			{
				alert(obj["resultMessage"]);
			}

			closeloadingscreen();
		}
	}


	var deliexception="<?=$deliexception;?>";
	var delicomp="<?=$delicomp;?>";
	console.log("deliexception = " + deliexception+", delicomp = " + delicomp);

	if (!isEmpty(deliexception)&&deliexception.indexOf("O") != -1 || !isEmpty(deliexception)&&deliexception.indexOf("T") != -1 || !isEmpty(deliexception)&&deliexception.indexOf("D") != -1)
	{
		callapi('GET','marking','markingdeliveryex',"<?=$apiData?>");
	}
	else
	{
		if(delicomp=="LOGEN" || delicomp=="logen")
		{
			loadingscreen();

			callapi('GET','marking','markingdelivery','<?=$apiData?>');
		}
		else if(delicomp=="POST" || delicomp=="post")
		{
			loadingscreen();

			callapi('GET','marking','markingdeliverypost','<?=$apiData?>');
		}
		else
		{
			callapi('GET','marking','markingdeliveryex',"<?=$apiData?>");
		}
	}

function pageReload()
{
	window.location.reload();
}

function loadingscreen(){
	//var h=$("#prt_div").height();
	var h=window.innerHeight;
	var hh=(h / 2) - (64 / 2);
	var txt="<div id='screen' style='height:"+h+"px;'></div>";
	      txt+="<div id='loadingID' style='padding-top:"+hh+"px;'><div id='loadimg'></div></div>";
	$("body").prepend(txt);

	var delicomp="<?=$delicomp;?>";

	if(delicomp=="LOGEN" || delicomp=="logen")
	{
		console.log("@@@@@@@@@@@@@@@@@@@@ 로젠 처음접속..5초..setTime ");
		var redeliId=setTimeout("pageReload()",5000);
		$("input[name=logendeliId]").val(redeliId);

		console.log("loadingscreen  redeliId = " + redeliId);
	}
}
function closeloadingscreen()
{
	var delicomp="<?=$delicomp;?>";

	console.log("closeloadingscreencloseloadingscreencloseloadingscreen");
	if(delicomp=="LOGEN" || delicomp=="logen")
	{
		var redeliId=$("input[name=logendeliId]").val();
		console.log("@@@@@@@@@@@@@@@@@@@@ 데이터 다 가져왔다. redeliId = " + redeliId);
		if(!isEmpty(redeliId))
		{
			clearTimeout(redeliId);
		}
	}

	$('#loadingID').remove();

	$('#screen').remove();

}
</script>
