<?php
	$root="..";
	include_once $root."/_common.php";

	$code=$_GET["code"];
	$apiData="code=".$code;

?>
<style>
	#addphoto{position:fixed;top:10px;right:300px;width:150px;border:1px solid #999;padding:10px;text-align:center;font-size:20px;font-weight:bold;color:#fff;border-radius:3px;}

	#photolist{float:left;width:69%;height:50px;}
	#photolist dl{float:left;width:auto;margin:0 0 0 1%;}
	#photolist dl dt, #photolist dl dd{width:100%;color:#fff;font-size:15px;overflow:hidden;padding:10px;margin:0;}
	#photolist dl dt i{float:right;font-size:17px;}
	#photolist dl dd{width:auto;padding:0;text-align:center;}
	#photolist dl .img{overflow:hidden;}
	#photolist dl .img img{height:50px;}

	

	dd.btndiv{float:left;width:30%;}
	dd.btndiv button{width:100px;height:40px;padding:5px;font-size:20px;font-weight:bold;background:green;border-radius:3px;color:#fff;text-align:center;cursor:pointer;}
	#adddeli {width:130px;height:40px;padding:5px;font-size:20px;font-weight:bold;background:#FF8C00;border-radius:3px;color:#fff;text-align:center;cursor:pointer;}
</style>
<div class="info_dtl releaseDiv">
	<dd class="btndiv" id="delidiv" style="display:none;">
		<button id="transid" name="transid" onclick="javascript:setDeliPrint();"><?=$txtdt["9009"]?><!-- 송장출력 --></button>
		<button id="adddeli" name="adddeli" onclick="addDeliveryPrint();"><?//=$txtdt["9009"]?>송장추가출력</button>
	</dd>
	<dl class="count" id="deliinfo" style="display:none;">
		<dt ><?=$txtdt["transno"]?><!-- 송장번호 --></dt>
		<dd><em class="st_num" id="delino" ></em></dd>
		<dt ><?=$txtdt["delitype"]?><!-- 포장방법 --></dt>
		<dd><em class="st_num" id="re_delitype" >A123456</em></dd>
	</dl>
	<div id="photolist">
	</div>
</div>
<div class="content">
	<div class="invoice">
		<div class="hgrp">
			<h4 class="tt" id="odtitle"></h4>
			<div class="test" id="labelprt"></div>
			<!-- <div class="test">
				<dl>
					<dt><?=$txtdt["chkprecipitate"]?>침전검사</dt>
					<dd id="chkprecipitate"></dd>
				</dl>
				<dl>
					<dt><?=$txtdt["chkleak"]?>누수검사</dt>
					<dd id="chkleak"></dd>
				</dl>
			</div> -->
		</div>
		<dl class="info_to">
			<dt><?=$txtdt["receiver"]?><!-- 받는사람 --></dt>
			<dd class="name" id="re_name"></dd>
			<dd class="addr" id="re_address"></dd>
			<dd class="phone" id="re_phone"></dd>
		</dl>
		<dl class="info_from">
			<dt><?=$txtdt["sender"]?><!-- 보내는사람 --></dt>
			<dd class="name" id="mi_name"></dd>
			<dd class="addr" id="mi_address"></dd>
			<dd class="phone" id="mi_phone"></dd>
		</dl>
		<dl class="memo">
			<dt><?=$txtdt["memo"]?><!-- 포장메모 --></dt>
			<dd id="od_request"></dd>
		</dl>
		<dl class="memo">
			<dt><?=$txtdt["advice"]?><!-- 복약지도 --></dt>
			<dd id="qmcode"></dd>
		</dl>
	</div>

	<div class="box_info">
		<dl class="box1 releaseboxclick">
			<dt id="boxmedi"></dt>
			<dd id="afBoxmedi"></dd>
		</dl>
		<dl class="box2 releaseboxclick">
			<dt id="boxdeli"></dt>
			<dd id="afBoxdeli"></dd>
		</dl>
	</div>
</div>
<script type="text/javascript" src="<?=$root?>/_Js/webcam/webcam.min.js"></script>
<!-- Configure a few settings and attach camera -->
<script language="JavaScript">
	Webcam.set({
		width: 80, //라이브 카메라 뷰어의 너비 (픽셀)이며 기본값은 DOM 요소의 실제 크기입니다.
		height: 60,
		dest_width: 1280,//1024,,640, //캡처 된 카메라 이미지의 너비 (픽셀 단위)는 기본적으로 라이브 뷰어 크기입니다.
		dest_height: 720,//768,480,
		image_format: 'jpeg',
		jpeg_quality: 100,
		force_flash: false,
        flip_horiz: false,
        fps: 45
	});
	Webcam.attach('#my_camera');
	$("#my_camera").fadeIn(1000);
</script>
<script language="JavaScript">
	// preload shutter audio clip
	var shutter = new Audio();
	shutter.pause();
	shutter.currentTime =0;
	shutter.autoplay = false;
	shutter.src = navigator.userAgent.match(/Firefox/) ? '/_Js/webcam/shutter.ogg' : '/_Js/webcam/shutter.mp3';

	function snapshot(process,barcode)
	{
		// play sound effect
		//shutter.play();
		// take snapshot and get image data
		console.log(process);
		if(process=="medibox"){
			$("#snapshotcnt").remove();
			$("#addagainphoto").before("<div id='snapshotcnt'>0</div>");
		}
		Webcam.snap( function(data_uri) {
			// display results in page
			document.getElementById('snapshot').innerHTML = '<img id="base64image" src="'+data_uri+'"/>';
			var ordercode=$("#ordercode").attr("value");
			var orderseq=$("#ordercode").attr("data-seq");
			var orderuserid=$("#ordercode").attr("data-userid");
			var section=$("#step_info").parent().attr("id");//making
			var language="<?=$language;?>"

			console.log("snapshot   ordercode = " + ordercode+", orderseq = " + orderseq+",orderuserid = " + orderuserid+", section = " + section+", language = " + language);

			var filecode = ordercode+"|"+(section+"_"+process)+"|"+orderseq;
			var fileck = orderuserid+"|"+language;

			//=================================================================
			var imgs =  document.getElementById("base64image").src;
			var blob = dataURItoBlob(imgs);
			var formData = new FormData();
				formData.append('uploadFile', blob, "snapshot_release.jpg");
				formData.append('filecode',filecode);
				formData.append('fileck', fileck);

			$.ajax({
				type:"POST",
				url:getUrlData("FILE"),//"https://shan.djmedi.kr/_adm/upload/ajaxupload.php",
				data:formData,
				processData : false,
				contentType : false,
				dataType:"json",
				headers : {"HeaderKEY":"first value"},
				beforeSubmit: function (data,form,option) {
					console.log("beforeSubmit  data = " + data + ", form = " + form + ", opotion = " + option);
					return true;
				},
				error: function(response, status, e){
					console.log(JSON.stringify(e));
					console.log("error  response = " + response+", status = " + status+", e = " + e);
				},
				complete:function(xhr){
					var obj = JSON.parse(xhr.responseText);

					console.log("complete  completecompletecompletecomplete");
					console.log(obj);
					if(obj["status"] == "SUCCESS")
					{
						//setTimeout("snapShotNext()", 2000);
						//저장한 이미지 불러오기 
						var url="odcode="+ordercode;
						callapi('GET','release','releasephotolist',url);
					}
					else
					{
						if(obj["message"] == "FILE_UPLOAD_FAIL")
							layersign('warning',getTxtData("FILE_UPLOAD_FAIL"),'','1000');//파일업로드에 실패했습니다.
						else if(obj["message"] == "FILE_UPLOAD_ERR01")
							layersign('warning',getTxtData("FILE_UPLOAD_ERR01"),'','1000');//첨부파일 사이즈는 5MB 이내로 등록 가능합니다.
						else if(obj["message"] == "FILE_UPLOAD_ERR01")
							layersign('warning',getTxtData("FILE_UPLOAD_ERR02"),'','1000');//허용된 파일형식이 아닙니다.
						else if(obj["message"] == "FILE_UPLOAD_ERR01")
							layersign('warning',getTxtData("FILE_UPLOAD_ERR04"),'','1000');//도메인 관리자에게 문의 바랍니다.
						else 
							layersign('warning',getTxtData("FILE_UPLOAD_ERR03"),'','1000');//파일 오류입니다.
					}
				}
			});
			//=================================================================
		} );
		if(process=="medibox_add"){
			var snapshotcnt=$("#snapshotcnt").text();
			snapshotcnt++;
			$("#snapshotcnt").text(snapshotcnt);
		}
		setTimeout("snapShotNext()", 2000);
	}
	function addReleasePhoto()
	{
		var snapshotcnt=$("#snapshotcnt").text();
		var data=$("#addagainphoto").html();
		data+="<div id='addphoto' onclick='againReleasePhoto();'><?=$txtdt['9044']?>(<span>"+snapshotcnt+"</span>)</div>";
		//data+="<div id='addphoto' onclick='againReleasePhoto();'><?=$txtdt['9044']?></div>";
		$("#addagainphoto").html(data);
	}
	function againReleasePhoto()
	{
		var depart=$("#containerDiv").attr("value");
		document.getElementById('snapshot').style.display = 'block';
		$('#snapshot').html('<div style=\"font-size:30px;font-weight:bold;margin:200px 0 0 230px;\">2'+getTxtdt("stepphoto")+'</div>').fadeIn(0);
		setTimeout("snapshot('medibox_add','')",2000);
	}
	
	function snapShotNext()
	{
		var no=$("#step_info").find("li.on").index();

		//20190725: 재촬영 추가 
		$("#addagainphoto").html("");
		if(no==5)
		{
			setAgainPhoto();
			addReleasePhoto();
		}

		console.log("snapShotNext  nextstep() ");

		workerconfirm("<?=$txtdt['9040']?>");
		//layersign('success',obj["message"],'','1000');
		$('#snapshot').html('').fadeOut(1000);
		cleardiv();

		$("#mainbarcode").focus();
	
		//20191014 : 품질보고서 출력 안되게 하기 
	/*
		var ordercode=$("#ordercode").attr("value");
		makingID=setTimeout(function(){
			window.open("/release/document.report.php?code="+ordercode, "proc_report_advice", "width=700,height=700");
		}, 1000);
	*/		
	}

	$(".releaseboxclick").on("click",function(e){
		var no=$("#step_info").find("li.on").index() + 1;
		var value=$("#step_info").find("li.on").attr("data-value");
		var chkcode=value.substring(0,3);
		var objvalue=$(this).find("dt").attr("value");
		var objid=$(this).find("dt").attr("id");
		console.log("클릭이다 no = " + no + ", value = " + value + ", objid  ="+objid+", objvalue = " + objvalue);

			
		var objchkcode = objvalue.substring(0,3);
		//alert("체크중 = " + objchkcode + ", chkcode = " + chkcode );

		if(chkcode == "RBM" && chkcode == objchkcode) //한약박스를 확인해주세요. 
		{
			layersign("success",getTxtdt("step40"),'','1000');//파우치를 확인해주세요.
			$("#status_txt").text($("#steprelease40").val());   //님, 검수 및 포장 작업을 시작 해 주세요
			nextstep();
			$("#mainbarcode").focus();
		}
		else if((chkcode == "PCB" && chkcode == objchkcode) || (chkcode == "RJB" && chkcode == objchkcode) || (chkcode == "RBP" && chkcode == objchkcode) || (chkcode == "RBS" && chkcode == objchkcode))
		{
			//20191101 : 로젠 승인이 떨어질때까지만 잠시 보류 
			/*
			layersign("success",getTxtdt("step50"),'','1000');//송장 바코드를 스캔해 주세요
			$("#status_txt").text($("#steprelease50").val());
			nextstep();
			$("#mainbarcode").focus();
			
				var odadvice=$("textarea[name=od_advice]").val();
				console.log("odadvice = " + odadvice);
				if(!isEmpty(odadvice))
				{
					var ordercode=$("#ordercode").attr("value");
					var url="document.advice.php?code="+ordercode;
					window.open(url, "printmanual", "width=900,height=1000");
				}

				gotostep(5);
				cleardiv();
				layersign("success",getTxtData("9022"), "",'confirm_release');//송장과 포장된 제품을 준비한후 확인버튼을 터치해 주세요.
			*/
			var od_goods=$("input[name=od_goods]").val();
			console.log("od_goods = " +od_goods);

			if(!isEmpty(od_goods) && od_goods=="M")
			{
				setDeliPrint();
			}
			else
			{
				var odadvice=$("textarea[name=od_advice]").val();
				console.log("odadvice = " + odadvice);
				if(!isEmpty(odadvice))
				{
					var ordercode=$("#ordercode").attr("value");
					var url="document.advice.php?code="+ordercode;
					window.open(url, "printmanual", "width=900,height=1000");
				}

				gotostep(5);
				cleardiv();
				layersign("success",getTxtData("9022"), "",'confirm_release');//송장과 포장된 제품을 준비한후 확인버튼을 터치해 주세요.
			}
			
		}
		/*
		//예전소스 
		if(chkcode == objchkcode && chkcode == "RBM") //한약박스를 확인해주세요.
		{
			layersign("success",getTxtdt("step40"),'','1000');//파우치를 확인해주세요.
			$("#status_txt").text($("#steprelease40").val());   //님, 검수 및 포장 작업을 시작 해 주세요
			nextstep();
			$("#mainbarcode").focus();
		}
		else if(chkcode == objchkcode && chkcode == "PCB")//파우치 
		{
			layersign("success",getTxtdt("step50"),'','1000');//송장 바코드를 스캔해 주세요
			$("#status_txt").text($("#steprelease50").val());
			nextstep();
			$("#mainbarcode").focus();
		}
		*/
	});
	function setDeliPrint()
	{
		var code=$("#ordercode").attr("value");
		var type="POST";			
		var delicomp=$("input[name=reDelicomp]").val();
		var deliexception=$("input[name=reDeliexception]").val();
		var reBoxmedicnt=$("input[name=reBoxmedicnt]").val();
		console.log("delicomp = " + delicomp+", deliexception = " + deliexception+", reBoxmedicnt= "+reBoxmedicnt);


		//우체국이면서 reBoxmedicnt 가 없을 경우 
		if(delicomp.toUpperCase()=="POST" && !isEmpty(reBoxmedicnt)&&parseInt(reBoxmedicnt)<=0)
		{
			if (!isEmpty(deliexception)&&deliexception.indexOf("O") != -1 || !isEmpty(deliexception)&&deliexception.indexOf("T") != -1 || !isEmpty(deliexception)&&deliexception.indexOf("D") != -1)
			{
				window.open("/marking/document.deliprint.php?odCode="+code+"&type="+type+"&deliexception="+deliexception+"&delicomp="+delicomp, "proc_report_deli","width=800,height=500");//ok  -새창. 로딩이 걸리
			}
			else
			{
				window.open("/marking/document.delicnt.php?odCode="+code, "proc_delicnt_deli","width=800,height=500");//ok  -새창. 로딩이 걸리네.
			}
		}
		else
		{
			window.open("/marking/document.deliprint.php?odCode="+code+"&type="+type+"&deliexception="+deliexception+"&delicomp="+delicomp, "proc_report_deli","width=800,height=500");//ok  -새창. 로딩이 걸리네.
		}

	}
	function parentdelClose()
	{
		console.log("release parentdelCloseparentdelCloseparentdelClose");
		var odadvice=$("textarea[name=od_advice]").val();
		console.log("odadvice = " + odadvice);
		if(!isEmpty(odadvice))
		{
			var ordercode=$("#ordercode").attr("value");
			var url="document.advice.php?code="+ordercode;
			window.open(url, "printmanual", "width=900,height=1000");
		}

		gotostep(5);
		cleardiv();
		layersign("success",getTxtData("9022"), "",'confirm_release');//송장과 포장된 제품을 준비한후 확인버튼을 터치해 주세요.
	}

//text용 송장번호 입력
$("#delino").on("click",function(){
	$("input[name=mainbarcode]").val("DVC2302192734"); 
	$("input[name=mainbarcode]").focus();
});




</script>

<script>
	callapi('GET','release','releasemain','<?=$apiData?>');
</script>
