<?php
	$root="..";
	include_once $root."/_common.php";
	include_once $root."/_Inc/head.php";

	$apiData="depart=".$depart;
?>
<textarea id="steptxtdt" cols="100" rows="100" style="display:none;"></textarea>
<textarea id="urldata" cols="100" rows="100" style="display:none;"><?=json_encode($NetURL)?></textarea>
<div id="nav" data-bind="pharmacy"></div>
<div id="staffinfo" data-bind="pharmacy"><span class="barcode"></span></div>
<div class="page">
	<header class="head_wrap">	
		<h1 class="logo"><?=$txtdt["logo"]?><!--원외탕전 현대화 시스템--></h1>		
	</header>
	<div id="containerDiv" value="pharmacy" data-value="true"><aside><span class="logoutbarcode" onclick="pharmacylogout();"><span class="barimg"><img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAGUAAAAyCAIAAADKlYLXAAAAqElEQVRoge3QQQoCMRAAwcH//zkeBAkmin2vOizZYXcIPTMzM2ut13M/nK/7x+eP5/w8fFv7/4Yf54/hvvw6uW64XuM9eQyFXo1ejV6NXo1ejV6NXo1ejV6NXo1ejV6NXo1ejV6NXo1ejV6NXo1ejV6NXo1ejV6NXo1ejV6NXo1ejV6NXo1ejV6NXo1ejV6NXo1ejV6NXo1ejV6NXo1ejV6NXo1ejV7NE83YjNbgU387AAAAAElFTkSuQmCC"></span>LOGOUT</span></aside></div>
	<div id="maindiv" style="border:1px solid #666;">
		<style>
			.pharmacydiv{background:#333;width:1300px;margin:100px auto;overflow:hidden;padding:20px;}
			.pharmacydiv h1{color:#fafafa;margin:10px;font-size:30px;}
			.pharmacydiv ul, .pharmacydiv dl{width:80%;float:left;color:#fafafa;padding:20px 0;}
			.pharmacydiv ul li input{width:95%;height:90px;font-size:35px;font-weight:bold;color:#fff;padding:15px;border:none;background:#555;}
		</style>
		<div class="pharmacydiv">
			<h1>수동조제</h1>
			<ul>
				<li><!-- <a href="javascript:inscode('orderscan','ODD1910024075605703')">ODD1910024075605703</a> --><input type="text" name="staffidscan" onkeyup="if(event.keyCode==13)makngworker()" placeholder="조제사 태그 해주세요" value=""></li>
			</ul>
		</div>
	</div>
</div>
<?php include_once $root."/_Inc/tail.php"; ?>
<script>
	function pharmacylogout(){
		var txt=$("input[name=staffidscan]").val();
		if(txt ==undefined){
			location.href="/pharmacy/";
		}else{
			gologout();
		}
	}

	function returnBarcode(){
		$("#mainbarcode").focus();
	}

	function makepage(json)
	{
		var obj = JSON.parse(json);
		var depart = "<?=$depart?>";
		var status_txt="";
		console.log(obj);
		if(obj["apiCode"]=="pharmacydesc") //
		{
			if(obj["resultCode"]=="204"){
				layersign('warning',obj["resultMessage"],'','1000');
				$("input[name=orderscan]").val("").focus();
			}else{
				//주문번호 
				$("#odCode").text(obj["odinfo"]["odCode"]);
				//조제태그
				var tagInfo="<ul class='tagul'>";
				$.each(obj["pouchTag"], function(index, val){
					tagInfo+="<li>"+val["name"]+" : <i id='tag"+val["code"]+"' class='tagcode'></i></li>";
				});
				tagInfo+="</ul>";
				$("#tagCode").html(tagInfo);
				//처방명 
				$("#odTitle").text(obj["odinfo"]["odTitle"]);
				//주문자명 
				$("#odName").text(obj["odinfo"]["odName"]);
				//약재종류수 
				$("#mediCapa").text(obj["odinfo"]["mediCapa"]);
				//약재종류수 
				$("#mediCount").text(obj["odinfo"]["mediCount"]);
				$("input[name=odMatype]").val(obj["odinfo"]["odMatype"]);
			}

		}
		else if(obj["apiCode"]=="pharmacytagupdate") //
		{
			if(obj["resultCode"]=="200" && obj["resultMessage"]=="OK")
			{
				//조제태그
				/*
				var tagInfo="<ul class='tagul'>";
				$.each(obj["tagInfo"], function(index, val){
					tagInfo+="<li>"+val["tagName"]+"<i>"+val["tagCode"]+"</i></li>";
				});
				tagInfo+="</ul>";
				$("#tagCode").html(tagInfo);
				*/
				$("#tag"+obj["ptCode"]).text(obj["tagCode"]);
				layersign('success','조제태그('+obj["ptName"]+')가 등록되었습니다.','','1000');
				$("input[name=tagscan]").val("");
			}
			else
			{
				layersign('warning',obj["resultMessage"],'','2000');
			}

		}
		else if(obj["apiCode"]=="pharmacyupdate") //
		{
			if(obj["resultCode"]=="200" && obj["resultMessage"]=="OK")
			{				
				//layersign('success','수동조제작업이 완료되었습니다.','','1000');
				alert("수동조제작업이 완료되었습니다");
				//$("#maindiv").load("./index.php");
				location.reload("/pharmacy/");
				/*
				$("input[name=orderscan]").val("");
				$("input[name=tagscan]").val("");
				$("#odCode").text(" - ");
				$("#tagCode").text(" - ");
				$("#odTitle").text(" - ");
				$("#odName").text(" - ");
				$("#mediCount").text(" - ");
				*/
			}
			else
			{
				layersign('warning',obj["resultMessage"],'','2000');
			}

		}
		else if(obj["apiCode"]=="getstaff")
		{
			$("#makingStaff").attr("value",obj["data"]["stStaffid"]);
			$("#makingStaff").text(obj["data"]["stName"]);
			$("input[name=orderscan]").focus();
		}
		else if(obj["apiCode"]=="checkstaffid")
		{
			if(obj["resultCode"]=="200" && obj["resultMessage"]=="OK")
			{				
				var url="./main.php?code="+obj["staffID"];
				console.log("checkstaffidcheckstaffidcheckstaffidcheckstaffid  url = " + url);
				$("#maindiv").load(url);
			}
			else
			{
				layersign('warning',obj["resultMessage"],'','1000');
				$("input[name=staffidscan]").val("");
			}
		}
		
	}

	function focusscan()
	{
		var order=$("input[name=orderscan]").val();
		var tag=$("input[name=tagscan]").val();
		if(order!="" && tag!=""){
			checktagcode(order, tag);
		}else if(order!=""){
			console.log("order"+order+"&tag="+tag);
			$("input[name=tagscan]").focus();
		}else if(tag!=""){
			$("input[name=tagscan]").val("");
			$("input[name=orderscan]").focus();
		}else{
			$("input[name=orderscan]").focus();
		}
	}

	function checktagcode(order, tag)
	{
		console.log("checktagcode  order = "+order+", tag = " + tag);

		if(!isEmpty(tag))
		{
			var tagcode=tag.substring(0, 3);
			if(tagcode=="MDT")
			{
				callapi('GET','pharmacy','pharmacytagupdate',"odCode="+order+"&tagCode="+tag);
			}
			else
			{
				layersign('warning',"부직포 바코드를 스캔해 주세요.",'','2000');
			}
		}
	}
	function pharmacyrescan(){
		$("input[name=orderscan]").val("").focus();
		$("input[name=tagscan]").val("");
		$("#odCode").text("");
		$("#tagCode").html("");
		$("#odTitle").text("");
		$("#odName").text("");
		$("#mediCount").text("");
	}

	function pharmacyconfirm()
	{
		var odcode=$("input[name=orderscan]").val();
		var staffID=$("input[name=staffidscan]").val();
		var ma_pharmacist=getCookie("ck_stStaffid");
		var odchk=$("#odCode").text().trim();
		console.log("pharmacyconfirm  odchk = " + odchk);
		if(odchk=="-" || odchk==""){

			console.log("pharmacyconfirm  odchk = " + odchk + ", odcode = " + odcode);
			layersign('warning',"작업지시서를 스캔해 주세요!1",'','2000');
			$("input[name=orderscan]").val("").focus();
			$("input[name=tagscan]").val("");
			$("#odCode").text("");
			$("#tagCode").html("");
			$("#odTitle").text("");
			$("#odName").text("");
			$("#mediCount").text("");

		}else{
			console.log("pharmacyconfirm else   odchk = " + odchk + ", odcode = " + odcode);
			if(isEmpty(odcode))
			{
				layersign('warning',"작업지시서를 스캔해 주세요!2",'','2000');
			}
			else
			{
				var matype=$("input[name=odMatype]").val();
				console.log("pharmacyconfirm else   matype = " + matype);
				//20191111 : 나중에는 약재가 있어서 삭제해야 함.. 
				if(!isEmpty(matype)&&matype=="goods" || !isEmpty(matype)&&matype=="commercial" || !isEmpty(matype)&&matype=="worthy")
				{
					if(!confirm("수동조제작업을 완료하시겠습니까?")){return;}
					callapi('GET','pharmacy','pharmacyupdate',"odCode="+odcode+"&staffID="+staffID+"&pharmacist="+ma_pharmacist);
				}
				else
				{
					var chk="N";
					$(".tagcode").each(function(){
						console.log("tagcode  "+$(this).text())
						if($(this).text()!=""){
							 chk="Y";
							 return;
						}
					});
					if(chk=="Y"){
						if(!confirm("수동조제작업을 완료하시겠습니까?")){return;}
						callapi('GET','pharmacy','pharmacyupdate',"odCode="+odcode+"&staffID="+staffID+"&pharmacist="+ma_pharmacist);
					}else{
						layersign('warning',"작업태그를 모두 스캔해 주세요!",'','2000');
					}
				}
			}
		}
	}

	function odcodeenter(){
		var code=$("input[name=orderscan]").val();
		inscode("orderscan", code);
	}

	function inscode(type, code)
	{
		if(type=="orderscan")
		{
			callapi('GET','pharmacy','pharmacydesc',"odCode="+code);
		}
		$("input[name="+type+"]").val(code);
		focusscan();
	}

	function makngworker(){
		var staffid=$("input[name=staffidscan]").val();
		callapi('GET','pharmacy','checkstaffid',"code=making&staffID="+staffid);
	}

	function staffidscan()
	{
		$("input[name=staffidscan]").focus();
	}

	staffidscan();
</script>
