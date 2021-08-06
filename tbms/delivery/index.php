<?php
	$root="..";
	include_once $root."/_common.php";
	include_once $root."/_Inc/head.php";
?>
<textarea id="steptxtdt" cols="100" rows="100" style="display:none;"></textarea>
<textarea id="urldata" cols="100" rows="100" style="display:none;"><?=json_encode($NetURL)?></textarea>
<div id="nav" data-bind="manual"></div>
<div id="staffinfo" data-bind="manual"><span class="barcode"></span></div>
<div class="page">
	<header class="head_wrap">	
		<h1 class="logo">청연 원외탕전실<!--원외탕전 현대화 시스템--></h1>		
	</header>
	<div id="maindiv" style="border:1px solid #666;">
		<div id="containerDiv" value="manual" data-value="true"><aside><span class="logoutbarcode" onclick="javascript:gologout();"><span class="barimg"><img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAGUAAAAyCAIAAADKlYLXAAAAqElEQVRoge3QQQoCMRAAwcH//zkeBAkmin2vOizZYXcIPTMzM2ut13M/nK/7x+eP5/w8fFv7/4Yf54/hvvw6uW64XuM9eQyFXo1ejV6NXo1ejV6NXo1ejV6NXo1ejV6NXo1ejV6NXo1ejV6NXo1ejV6NXo1ejV6NXo1ejV6NXo1ejV6NXo1ejV6NXo1ejV6NXo1ejV6NXo1ejV6NXo1ejV6NXo1ejV7NE83YjNbgU387AAAAAElFTkSuQmCC"></span>LOGOUT</span></aside></div>
<style>
	.manualdiv{background:#333;width:1200px;margin:100px auto;overflow:hidden;padding:20px;}
	.manualdiv h1{color:#fafafa;margin:10px;font-size:30px;}
	.manualdiv ul, .manualdiv dl{width:36%;float:left;color:#fafafa;padding:20px 0;}
	.manualdiv dl{width:40%;}
	.manualdiv ul li{padding:20px 0;}
	.manualdiv ul li a{color:#fff;}
	.manualdiv ul li input{width:95%;height:70px;font-size:25px;font-weight:bold;color:#fff;
			padding:15px;border:none;background:#555;}
	::placeholder{color:#999;}
	.manualdiv ul li.btn{text-align:center;padding:20px;}
	.manualdiv ul li.btn button{background:#ccc;font-size:40px;font-weight:bold;margin:40px auto;padding:20px;border-radius:10px;cursor:pointer;}
	.manualdiv dl dt, .manualdiv dl dd{border:1px solid #fff;padding:10px 0;}
	.manualdiv dl dt{text-align:center;font-size:25px;font-weight:bold;padding:20px;}
	.manualdiv dl dd{padding:0;}
	.manualdiv dl dd .mntbl{width:100%;border:none;}
	.manualdiv dl dd .mntbl tr th, .manualdiv dl dd .mntbl tr td{border:none;border-right:1px solid #ccc;border-bottom:1px solid #ccc;padding:20px;font-size:15px;}
	#remainbox, .remainbox, #confirmbox, .confirmbox{margin:40px auto;
		width:auto;font-size:60px;font-weight:bold;text-align:center;font-style:normal;}
	#confirmbox, .confirmbox{color:yellow;}
	.manualdiv .confirm{width:24%;padding:10px;margin-top:-60px;}
	.confirm li.tit{font-size:30px;font-weight:bold;padding:0  20px;}
	.confirm li.list{height:525px;overflow-y:scroll;}
	.confirm li div{background:#ccc;padding:10px 10px;border-radius:10px;margin:0 20px 5px 20px;}
	.confirm li div span{float:left;display:inline-block;width:27px;height:27px;padding:7px 0 0 0;margin:10px 10px 0 0;text-align:center;background:blue;color:#fff;border-radius:50%;font-weight:bold;}
	.confirm li div h3{color:#000;font-size:17px;}
	#deliinfo{position:absolute;display:none;color:#fafafa;margin:0;font-size:30px;border:1px solid #fff;margin-left:250px;padding:3px 10px;text-align:right;}
	#deliinfo span{color:yellow;}
</style>
		<div class="manualdiv">
			<div id="deliinfo">배송회사 : <span id="delicomp">------</span>, 송장번호 : <span id="delino">------</span></div>
			<h1>배송확인</h1>
			<ul>
				<li><input type="text" name="delicodescan" onkeyup="if(event.keyCode==13)delicodeenter()" placeholder="송장 스캔 해주세요" value=""></li>
				<li>
					<div class="remainbox">대기 <i id="remainbox">0</i> 건</div>
					<div class="confirmbox">확인 <i id="confirmbox">0</i> 건</div>
				</li>
			</ul>
			<dl>
				<dt>배송정보</dt>
				<dd>
					<table class="mntbl">
					<col style="width:30%;"><col style="width:70%;">
					<tr>
						<th>주문번호</th>
						<td id="odCode"> - </td>
					</tr>
					<tr>
						<th>보내는사람</th>
						<td id="reSendName"> - </td>
					</tr>
					<tr>
						<th>보내는사람주소</th>
						<td id="reSendAddress"> - </td>
					</tr>
					<tr>
						<th>받는사람</th>
						<td id="reName"> - </td>
					</tr>
					<tr>
						<th>받는사람주소</th>
						<td id="reAddress"> - </td>
					</tr>
					<tr>
						<th>배송상품명</th>
						<td id="odTitle"> - </td>
					</tr>
					</table>
					<div></div>
				</dd>
			</dl>
			<ul class="confirm">
				<li class="tit">확인완료</li>
				<li class="list" id="confirmlist">
				
				</li>
			</ul>
		</div>
	</div>
</div>
			


<?php include_once $root."/_Inc/tail.php"; ?>
<script>
	function returnBarcode(){
		$("#mainbarcode").focus();
	}

	function makepage(json)
	{
		var obj = JSON.parse(json);
		var depart = "<?=$depart?>";
		var status_txt="";
		console.log(obj);
		if(obj["apiCode"]=="deliverycnt") //
		{
			var cnt=$(".confirmlist div").length;
			$("#remainbox").text(obj["deliveryCnt"]);
		}
		else if(obj["apiCode"]=="searchdelivery") //
		{
			if(obj["resultCode"]=="204"){
				layersign('warning',obj["resultMessage"],'','1000');
				$("#delicomp").text("");
				$("#delino").text("");
				$("#deliinfo").css("display","none");
				//주문번호 
				$("#odCode").text("");
				//보내는사람
				$("#reSendName").text("");
				//보내는사람주소
				$("#reSendAddress").text("");
				//받는사람
				$("#reName").text("");
				//받는사람주소
				$("#reAddress").text("");
				//배송상품명
				$("#odTitle").text("");
			}else{
				//주문번호 
				$("#odCode").text(obj["deliInfo"]["odCode"]);
				//보내는사람
				$("#reSendName").text(obj["deliInfo"]["reSendName"]);
				//보내는사람주소
				$("#reSendAddress").text(obj["deliInfo"]["reSendAddress"]);
				//받는사람
				$("#reName").text(obj["deliInfo"]["reName"]);
				//받는사람주소
				$("#reAddress").text(obj["deliInfo"]["reAddress"]);
				//배송상품명
				$("#odTitle").text(obj["deliInfo"]["odTitle"]);
				//남은배송상품수
				$("#remainbox").text(obj["deliveryCnt"]);
				var cnt=$("#confirmlist div").length + 1;
				var txt="<div><span>"+cnt+"</span>";
					txt+="<h3>"+obj["deliInfo"]["reDeliNo"]+"</h3><h3>"+obj["deliInfo"]["reName"]+"</h3></div>";
				$("#confirmlist").prepend(txt);
				$("#delicomp").text(obj["deliInfo"]["reDeliCompany"]);
				$("#delino").text(obj["deliInfo"]["reDeliNo"]);
				$("#deliinfo").css("display","block");
				$("#confirmbox").text(cnt);
			}
			$("input[name=delicodescan]").val("");
		}
		else if(obj["apiCode"]=="manualtagupdate") //
		{
			if(obj["resultCode"]=="200" && obj["resultMessage"]=="OK")
			{
				//조제태그
				var tagInfo="<ul class='tagul'>";
				$.each(obj["tagInfo"], function(index, val){
					tagInfo+="<li>"+val["tagName"]+"<i>"+val["tagCode"]+"</i></li>";
				});
				tagInfo+="</ul>";
				$("#tagCode").html(tagInfo);
				
				layersign('success','조제태그('+obj["utag"]+')가 등록되었습니다.','','1000');
				$("input[name=tagscan]").val("");
			}
			else
			{
				layersign('warning',obj["resultMessage"],'','2000');
			}

		}
		else if(obj["apiCode"]=="manualupdate") //
		{
			if(obj["resultCode"]=="200" && obj["resultMessage"]=="OK")
			{				
				layersign('success','수동조제작업이 완료되었습니다.','','1000');
				$("input[name=delicodescan]").val("");
				$("input[name=tagscan]").val("");
				$("#odCode").text(" - ");
				$("#tagCode").text(" - ");
				$("#odTitle").text(" - ");
				$("#odName").text(" - ");
				$("#mediCount").text(" - ");
			}
			else
			{
				layersign('warning',obj["resultMessage"],'','2000');
			}

		}
	}

	function focusscan()
	{
		//var delicode=$("input[name=delicodescan]").val();
		$("input[name=delicodescan]").focus();
	}

	function manualconfirm()
	{
		var odcode=$("input[name=delicodescan]").val();
		if(isEmpty(odcode))
		{
			layersign('warning',"작업지시서를 스캔해 주세요!",'','2000');
		}
		else
		{
			if(!confirm("수동조제작업을 완료하시겠습니까?")){return;}
			callapi('GET','manual','manualupdate',"odCode="+odcode);
			
			/*
			popupDoneMessage("수동조제작업이 완료되었습니다.",'2000');//
			$("input[name=delicodescan]").val("");
			$("input[name=tagscan]").val("");
			$("#odCode").text(" - ");
			$("#tagCode").text(" - ");
			$("#odTitle").text(" - ");
			$("#odName").text(" - ");
			$("#mediCount").text(" - ");
			*/
		}
	}

	function delicodeenter(){
		var code=$("input[name=delicodescan]").val();
		inscode("delicodescan", code);
	}

	function inscode(type, code)
	{
		if(type=="delicodescan")
		{
			callapi('GET','delivery','searchdelivery',"deliCode="+code);
		}
	}

	$("input").on("blur",function(){
		focusscan();
	});
	focusscan();
	callapi('GET','delivery','deliverycnt',"");
</script>
