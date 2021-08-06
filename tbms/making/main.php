<?php
	$root="..";
	include_once $root."/_common.php";
	$code=$_GET["code"];
	$apiData="code=".$code."&maTable=".$_COOKIE["ck_matable"];

?>

<div class="info_dtl">
	<dl class="count">
		<dt><?=$txtdt["matable"]?><!-- 조제대 --></dt>
		<dd><em class="st_code" id="matable" value=""></em></dd>
		<dt><?=$txtdt["totmedicnt"]?><!-- 총 약제 수량 --></dt>
		<dd><em class="st_total" id="meditotcnt"></em></dd>
		<dt><?=$txtdt["done"]?><!-- 완료 --></dt>
		<dd><em class="st_finish" id="medifinishcnt"></em></dd>
		<!-- 20190401 진행중추가 ****************************  -->
		<dt><?=$txtdt["process"]?><!-- 진행중 --></dt> 
		<dd><em class="st_waite" id="mediingcnt"></em></dd>
		<!-- ************************************************  -->
		<dt><?=$txtdt["wait"]?><!-- 대기 --></dt>
		<dd><em class="st_waite" id="mediwaitcnt"></em></dd>
		<dt><?=$txtdt["hold"]?><!-- 보류 --></dt>
		<dd><em class="st_hold" id="mediholdcnt"></em></dd>
		<dt class="addphoto"><?=$txtdt["totcapa"]?></dt>
		<dd><em class="st_totcapa" id="medipocketcapa">0g</em></dd>
	</dl>
	<!-- <dl class="property"> -->
		<!-- <dt class="hide"><?=$txtdt["special"]?><!-- 특성: --></dt>
		<!-- <dd><span class="p_type1"><?=$txtdt["poison"]?><!-- 독성 --></span></dd>
		<!-- <dd><span class="p_type2"><?=$txtdt["addicted"]?><!-- 중독성 --></span></dd>
	<!-- </dl> -->
</div>
<div id="info_proc" class="info_proc">
</div>

<!-- WebCam -->
<script type="text/javascript" src="<?=$root?>/_Js/webcam/webcam.min.js"></script>

<!-- Configure a few settings and attach camera -->
<script language="JavaScript">
	function getsummary()
	{
		//---------------------------------------------------------------------------------------------------------
		//20190401 .contenton .st_wait 의 length 가져오자.. 다른곳에 st_finish로 선언이 된곳이 있어서 같이 카운트됨 
		//---------------------------------------------------------------------------------------------------------
		var wcnt=$('.content .st_wait').length;
		wcnt = (wcnt <= 0) ? 0:wcnt;
		$('#mediwaitcnt').text(wcnt);
		var fcnt=$('.content .st_finish').length;
		fcnt = (fcnt <= 0) ? 0:fcnt;
		$('#medifinishcnt').text(fcnt);
		var icnt=$('.content .st_ing').length;
		icnt = (icnt <= 0) ? 0:icnt;
		$('#mediingcnt').text(icnt);		
		//---------------------------------------------------------------------------------------------------------
	}

	Webcam.set({
		width: 80, //라이브 카메라 뷰어의 너비 (픽셀)이며 기본값은 DOM 요소의 실제 크기입니다.
		height: 60,
		dest_width: 1280,//1024,640, //캡처 된 카메라 이미지의 너비 (픽셀 단위)는 기본적으로 라이브 뷰어 크기입니다.
		dest_height: 720,//768, 480,
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
	if(!isEmpty(shutter))
	{
		shutter.pause();
		shutter.currentTime =0;
		shutter.autoplay = false;
		shutter.src = navigator.userAgent.match(/Firefox/) ? '/_Js/webcam/shutter.ogg' : '/_Js/webcam/shutter.mp3';
	}

	function snapshot(process,barcode) 
	{
		// play sound effect
		if(!isEmpty(shutter))
		{
			shutter.play();
		}
		// take snapshot and get image data
		Webcam.snap( function(data_uri) {
			// display results in page
			document.getElementById('snapshot').innerHTML = '<img id="base64image" src="'+data_uri+'"/>';
			var ordercode=$("#ordercode").attr("value");
			var orderseq=$("#ordercode").attr("data-seq");
			var orderuserid=$("#ordercode").attr("data-userid");
			var section=$("#step_info").parent().attr("id");//making
			var language="<?=$language;?>"

			console.log("snapshot   ordercode = " + ordercode+", orderseq = " + orderseq+",orderuserid = " + orderuserid+", section = " + section+", process = "+process+", language = " + language);

			var filecode = ordercode+"|"+(section+"_"+process)+"|"+orderseq;
			var fileck = orderuserid+"|"+language;

			//=================================================================
			var imgs =  document.getElementById("base64image").src;
			var blob = dataURItoBlob(imgs);
			var nowDate = getNowFull(2);
			var formData = new FormData();
				formData.append('uploadFile', blob, "snapshot_making_"+nowDate+".jpg");
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
					//console.log("beforeSubmit  data = " + data + ", form = " + form + ", opotion = " + option);
					return true;
				},
				error: function(response, status, e){
					console.log(JSON.stringify(e));
					console.log("error  response = " + response+", status = " + status+", e = " + e);
				}, 
				complete:function(xhr){
					var obj = JSON.parse(xhr.responseText);

					//console.log("complete  completecompletecompletecomplete");
					

					if(obj["status"] == "SUCCESS")
					{
						//setTimeout("snapShotNext()", 2000);
					}
					else
					{
						//setTimeout("snapShotNext()", 2000);

						if(obj["message"] == "FILE_UPLOAD_FAIL")
							layersign('warning',getTxtData("FILE_UPLOAD_FAIL"),'','1000');//파일업로드에 실패했습니다.
						else if(obj["message"] == "FILE_UPLOAD_ERR01")
							layersign('warning',getTxtData("FILE_UPLOAD_ERR01"),'','1000');//첨부파일 사이즈는 5MB 이내로 등록 가능합니다.
						else if(obj["message"] == "FILE_UPLOAD_ERR02")
							layersign('warning',getTxtData("FILE_UPLOAD_ERR02"),'','1000');//허용된 파일형식이 아닙니다.
						else if(obj["message"] == "FILE_UPLOAD_ERR04")
							layersign('warning',getTxtData("FILE_UPLOAD_ERR04"),'','1000');//도메인 관리자에게 문의 바랍니다.
						else 
							layersign('warning',getTxtData("FILE_UPLOAD_ERR03"),'','1000');//파일 오류입니다.
					}

				}

			});
			//=================================================================


		} );

		setTimeout("snapShotNext()", 2000);
	}
	function snapShotNext()
	{
		var no=$("#step_info").find("li.on").index();
		$('#snapshot').html('').fadeOut(1000);
		cleardiv();

		//20190723: 조제 마지막일 경우에 '정량을 확인 후 정상일 경우 작업지시서를 스캔해 주세요' 문구 보여주기 
		//20190725: 재촬영 추가 
		$("#addagainphoto").html("");
		if(no==5)
		{
			setAgainPhoto();
			setTimeout(function(){
				//layersign("success",getTxtData("9001"), "",'confirm_making');//정량을 확인 후 정상일 경우 작업지시서를 스캔해 주세요
				workerconfirm("<?=$txtdt['9036']?>");

			}, 1000);		
		}
	}
	
</script>
<script>
	callapi('GET','making','makingmain',"<?=$apiData?>");
</script>
