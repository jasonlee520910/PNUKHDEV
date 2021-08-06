<?php
	$root="..";
	include_once $root."/_common.php";

	$code=$_GET["code"];
	$apiData="code=".$code;

?>
<style>
	#maindiv .content{overflow:hidden;background-color: rgba(0,0,0,.3);}
	#addphoto{position:fixed;top:10px;right:300px;width:150px;border:1px solid #999;padding:10px;text-align:center;font-size:20px;font-weight:bold;color:#fff;border-radius:3px;}
	.invoice{width:50%;}
	.section_goods .invoice [class^="info_"]{float:none;width:100%;}
	.section_goods .invoice [class^="info_"] dt{line-height:180%;height:auto;}
	.section_goods .invoice [class^="info_"] dd{line-height:230%;height:auto;}
	.section_goods .invoice [class^="info_"] dd.addr{}

	.goodsDiv .count {float:left;width:39%;height:50px;}
	#od_request{clear:both;border:1px solid #666;padding:20px;min-height:300px;}
	#goodsdata{float:left;width:50%;height:700px;overflow-y:scroll;}
	#goodsdata dl{float:left;width:23%;margin:0 0 20px 1%;overflow:hidden;border:1px solid #aaa;}
	#goodsdata dl dt, #goodsdata dl dd{width:100%;color:#fff;font-size:15px;overflow:hidden;padding:10px;margin:0;}
	#goodsdata dl dt{height:60px}
	#goodsdata dl dt i{float:right;font-size:17px;}
	#goodsdata dl dd{width:auto;padding:0;border:1px solid #aaa;text-align:center;}
	#goodsdata dl .img{height:130px;overflow:hidden;}
	#goodsdata dl .img img{width:auto;max-width:auto;height:130px;}
	#goodsdata dl.componentok {border: 1px solid green;background:green;}
	
	#photolist{float:left;width:60%;height:50px;}
	#photolist dl{float:left;width:auto;margin:0 0 0 1%;}
	#photolist dl dt, #photolist dl dd{width:100%;color:#fff;font-size:15px;overflow:hidden;padding:10px;margin:0;}
	#photolist dl dt i{float:right;font-size:17px;}
	#photolist dl dd{width:auto;padding:0;text-align:center;}
	#photolist dl .img{overflow:hidden;}
	#photolist dl .img img{height:50px;}

	dd.btndiv{width:500px;}
	dd.btndiv button{width:100px;height:40px;padding:5px;font-size:20px;font-weight:bold;background:green;border-radius:3px;color:#fff;text-align:center;cursor:pointer;}
	#adddeli {width:130px;height:40px;padding:5px;font-size:20px;font-weight:bold;background:#FF8C00;border-radius:3px;color:#fff;text-align:center;cursor:pointer;}

</style>
<div class="info_dtl goodsDiv">
	<dl class="count">
		<dt ><?=$txtdt["transno"]?><!-- 송장번호 --></dt>
		<dd><em class="st_num" id="delino" ></em></dd>
		<dt ><?=$txtdt["delitype"]?><!-- 포장방법 --></dt>
		<dd><em class="st_num" id="re_delitype" >A123456</em></dd>
		<dd>
			<button id="adddeli" name="adddeli" onclick="addDeliveryPrint();"><?//=$txtdt["9009"]?>송장추가출력<!-- 송장출력 --></button>
		</dd>
	</dl>
	<div id="photolist"></div>
</div>
<div class="content">
	<div class="invoice" style="float:left;">
		<div class="hgrp" onclick="goodsok();">
			<h4 class="tt" id="goodsName"></h4>
		</div>
		<dl class="info_to">
			<dt><?=$txtdt["receiver"]?><!-- 받는사람 --></dt>
			<dd class="name" id="re_name"></dd>
			<dd class="addr" id="re_address"></dd>
			<dd class="phone" id="re_phone"></dd>
		</dl>
		<dl class="info_from">
			<dt><?=$txtdt["sender"]?><!-- 보내는사람 --></dt>
			<dd class="name" id="re_sendname"></dd>
			<dd class="addr" id="re_sendaddress"></dd>
			<dd class="phone" id="re_sendphone"></dd>
		</dl>
		<dl class="info_memo">
			<dt><?=$txtdt["memo"]?><!-- 포장메모 --></dt>
			<dd id="od_request"></dd>
		</dl>
		<!-- <dl class="memo">
			<dt><?//=$txtdt["advice"]?><!-- 복약지도 --><!-- </dt>
			<dd id="qmcode"></dd>
		</dl> -->
	</div>
	<div id="goodsdata" style="float:left;">
		
	</div>
	
</div>
<script type="text/javascript" src="<?=$root?>/_Js/webcam/webcam.min.js"></script>
<!-- Configure a few settings and attach camera -->
<script language="JavaScript">
	Webcam.set({
		width: 80,
		height: 60,
		dest_width: 640,
		dest_height: 480,
		image_format: 'jpeg',
		jpeg_quality: 90,
		force_flash: false,
        flip_horiz: true,
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
		//console.log(process);
		if(process=="component"){
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
				formData.append('uploadFile', blob, "snapshot_goods.jpg");
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
						//저장한 이미지 불러오기 
						var url="odcode="+ordercode;
						callapi('GET','goods','goodsphotolist',url);
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
		if(process=="component_add"){
			var snapshotcnt=$("#snapshotcnt").text();
			snapshotcnt++;
			$("#snapshotcnt").text(snapshotcnt);
		}
		setTimeout("snapShotNext()", 2000);
	}
	function addGoodsPhoto()
	{
		var snapshotcnt=$("#snapshotcnt").text();
		var data=$("#addagainphoto").html();
		snapshotcnt=!isEmpty(snapshotcnt) ? snapshotcnt : "0";
		data+="<div id='addphoto' onclick='againGoodsPhoto();'><?=$txtdt['9044']?>(<span>"+snapshotcnt+"</span>)</div>";
		$("#addagainphoto").html(data);
	}
	function againGoodsPhoto()
	{
		var depart=$("#containerDiv").attr("value");
		document.getElementById('snapshot').style.display = 'block';
		$('#snapshot').html('<div style=\"font-size:30px;font-weight:bold;margin:200px 0 0 230px;\">2'+getTxtdt("stepphoto")+'</div>').fadeIn(0);
		setTimeout("snapshot('component_add','')",2000);
	}
	
	function snapShotNext()
	{
		var no=$("#step_info").find("li.on").index();

		//20190725: 재촬영 추가 
		$("#addagainphoto").html("");
		if(no==5)
		{
			setAgainPhoto();
			addGoodsPhoto();
		}

		console.log("snapShotNext  nextstep() ");

		workerconfirm("<?=$txtdt['9048']?>");
			$('#snapshot').html('').fadeOut(1000);
		cleardiv();

		$("#mainbarcode").focus();
	
	}

	
</script>

<script>
	callapi('GET','goods','goodsmain','<?=$apiData?>');
	function setHeight(){
		var invoiceHeight=$(".invoice").height();
		$("#goodsdata").height(invoiceHeight);
	}
	setTimeout("setHeight()",1000);
</script>
