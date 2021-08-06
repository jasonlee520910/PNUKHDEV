<?php
	$root="..";
	include_once $root."/_common.php";

	$code=$_GET["code"];
	$apiData="code=".$code;
	
?>
<style>
	dd.btndiv{width:500px;}
	dd.btndiv button{width:100px;height:40px;padding:5px;font-size:20px;font-weight:bold;background:green;border-radius:3px;color:#fff;text-align:center;cursor:pointer;}
	#adddeli {width:130px;height:40px;padding:5px;font-size:20px;font-weight:bold;background:#FF8C00;border-radius:3px;color:#fff;text-align:center;cursor:pointer;}
</style>
<div class="info_dtl">
	<dl class="count">
		<dt><?=$txtdt["pouch"]?><!-- 파우치--></dt>
		<dd><em class="st_code" id="pouchboxcode"></em></dd>
		<dt><?=$txtdt["transno"]?><!-- 송장번호 --></dt>
		<dd class="btndiv">
			<em class="st_num" id="delino" ></em>
			<button id="transid" name="transid" onclick="javascript:setDeliPrint();"><?=$txtdt["9009"]?><!-- 송장출력 --></button>
			<!-- <button id="adddeli" name="adddeli" onclick="addDeliveryPrint();"><?//=$txtdt["9009"]?>송장추가출력송장출력</button> -->
		</dd>
	</dl> 
</div>
<div class="content">
	<div class="pouch_info">
		<dl>
			<dt><?=$txtdt["pouchtype"]?><!-- 파우치 종류 --></dt>
			<dd>
				<em id="packtype"></em>
			</dd>
		</dl>
		<dl>
			<dt><?//=$txtdt["countpouch"]?><!-- 카운트/파우치수량 --></dt>
			<dd>
				<style>
				.newweight{position:absolute;height:100px;margin:200px 0  0 -100px;}
				.newweight .newtit{font-size:25px;color:#fff;}
				#pouchcnt, #packcnt{font-size:50px;padding:10px;margin:20px;}
				</style>
				<div class="weight newweight">
					<div class="newtit"><?=$txtdt["countpouch"]?><!-- 카운트/파우치수량 --></div>
					<label for="value"><input type="text" id="pouchcnt" value="0" style="height:50px"/><small><?=$txtdt["pack"]?><!-- 팩 --></small></label>
					<span class="target" id="packcnt" data-value='' onclick="markingskip()"></span>
				</div>
			</dd>
		</dl>
	</div>

	<div class="pouch_txt">
		<dl>
			<dt><?=$txtdt["mkpouch"]?><!-- 파우치마킹 --></dt>
			<dd id="markingtxt"></dd>
		</dl>
	</div>

	<div class="pouch_img">
		<dl>
			<dd id="imgfront" data-value=''>
			</dd>
			<dt><!-- <?=$txtdt["front"]?> --><!-- 앞면 --></dt>
		</dl>
		<!-- <dl>
			<dd id="imgback">				
			</dd>
			<dt><?=$txtdt["back"]?>뒷면</dt>
		</dl> -->
	</div>
</div>

<script>
	function markingskip(){
		var nowcnt=parseInt($("#pouchcnt").val());
		var packcnt=parseInt($("#packcnt").data("value"));
		$("#pouchcnt").val(packcnt);
		//if(nowcnt>-1){
			//--------------------------------------
			//카운터 될때마다 API 호출
			//--------------------------------------
			var code=$("#ordercode").attr("value");
			var mrPrinter=$("#marking").attr("value");
			var jsondata={};
			jsondata["odCode"] = code;
			jsondata["mrPrinter"] = mrPrinter;
			console.log(JSON.stringify(jsondata));
			callapi('POST','marking','markingfinishupdate',jsondata);
			//--------------------------------------
			//마킹 없을 시 아랫부분 정리
			layersign("success",getTxtdt("step44"),'','1000');//마킹이 종료되었습니다.
			
			nextstep();
			$("#status_txt").text(getTxtdt("step50"));
			$('#marking').data('step','1');
		//}
	}

	$("#pouchboxcode").on("click",function()
	{
		$("#mainbarcode").val($(this).text()).focus();
	});
	callapi('GET','marking','markingmain',"<?=$apiData?>");
</script>