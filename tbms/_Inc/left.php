<?php
	$root="..";
	include_once $root."/_common.php";
?>
<!--// page start -->
<textarea id="steptxtdt" cols="100" rows="100" style="display:none;"></textarea>
<textarea id="urldata" cols="100" rows="100" style="display:none;"><?=json_encode($NetURL)?></textarea>
<style>
	#logoName {font-size:15px;margin-left:-20px;}
	#maTypeName {float:right;width:auto;text-align:right;color:yellow;font-weight:bold;font-size:15px;margin-right:-10px;}
</style>
<div class="sidebar">
	<header class="head_wrap" style="padding:15px 15px 15px 10px;">	
		<a href="/" style="display:inline-block;width:70%;line-height:20px;"><img src="../_Img/logo_pnuh.png" alt="부산대학교한방병원원외탕전실" /></a>
		<!-- <h1 class="logo" id="logoName"><?=$txtdt["logo"]?>원외탕전실 현대화 시스템</h1> -->
		<h1 class="matype" id="maTypeName"></h1>
	</header>
	<aside>
			<div class="sect_maker" id="staffinfo" onclick="insbarcode('MEM','<?=$_COOKIE["ck_stStaffid"]?>')" style="margin-left:-10px;"></div>
			<div class="sect_prescriber procmember" id="procmember" onclick="insbarcode('ODD','')"></div>
			<div class="sect_prescribe_dtl procscription" id="procscription"></div>
			<div class="sect_user procuser" id="procuser"></div>
			<div style="color:#fff;margin-left:30px;margin-top:10px;font-size:90px;"  class="gram" id="gram"></div> 
			<ol class="sect_step" id="sect_step"><?=str_replace("margin-left:-120px;","",$step["txt"])?></ol>
	</aside>	
</div>

<script>
	function insbarcode(type,code)
	{
		var ordercode=$("#ordercode").attr("value");
		console.log("type : " + type + ", code = " + code);
		var sec=$("#nav").attr("data-bind");   // 이부분은 navi.php에 있는 부분   //data-bind  이   making
		var barcode=code.substring(3,19);

		if(type=="MEM")
		{
			sec=type;
		}
		else if(type=="MDB" || type=="MEI")
		{
			sec="";
			barcode=code;
		}
		else if(type=="ODD")
		{
			if(!isEmpty(ordercode))
			{
				sec="";
				barcode=ordercode;
			}
		}	
		else
		{
			switch(sec)
			{
				case "making":sec="MKD";break;
				case "decoction":sec="DED";break;
				case "marking":sec="MRK";break;
				case "release":sec="RED";break;	
				case "goods":sec="GDS";break;
				case "pill":sec="PIL";break;
				default:
					sec=type;
			}
		}

		$("input[name=mainbarcode]").val(sec+barcode).focus();

		if(type=="MDB" || type=="MEI")//약재를 클릭하면 엔터키 바로 실행 
		{
			var e = $.Event( "keydown", { keyCode: 13 } );
			$("input[name=mainbarcode]").trigger(e);
		}

	}

	// php.lib.php function getstaff(){ 함수
	function getstaffInfo(pgid,staff)
	{
		var txt=nowDate=status_txt="";
		nowDate=getTime();
		status_txt = getTxtdt("step10");
		if(!isEmpty(staff))
		{
			txt="<span class=\"thumb\">";
			txt+="<img src=\"<?=$root?>/_Img/thumb.png\" alt=\""+staff["stName"]+"사진\" />";
			txt+="</span>";
			txt+="<span class=\"name\">"+staff["stName"]+"</span>";
			txt+="<span class=\"barcode\">"+staff["stUserid"]+"</span><br>";
			txt+="<span class=\"date\">"+nowDate+"</span>";
		}
		else
		{
			txt="<span class=\"thumb\">";
			txt+="<img src=\"<?=$root?>/_Img/thumb.png\" alt=\"사진 \" />";
			txt+="</span>";
			txt+="<span class=\"nostaff\">"+status_txt+"</span>";
		}

		$("#"+pgid).html(txt);
	}

	function gramtxt()
	{
		var txt="<dl>";
		txt+="<dd>";
		txt+="<em id=\'nowGram\' style=\'font-size:80px;\'>0</em><em style=\'font-size:30px;\' id=\'nowGramRight\'>g</em>";
		txt+="</dd>";
		txt+="</dl>";
		txt+="<dl style='float:right;'>";
		txt+="<dd>";
		txt+="<em id=\'totalGram\' style=\'font-size:80px;\'>0</em><em style=\'font-size:30px;\'  id=\'totalGramRight\'>g</em>";
		txt+="</dd>";
		txt+="</dl>";
		txt+="<div style='position:fixed;bottom:150px;width:250px;border:1px solid #999;padding:10px;text-align:center;' id='pass' onclick='passOnClick();'>CHECK";
		txt+="</div>";
		return txt;
	}
</script>
