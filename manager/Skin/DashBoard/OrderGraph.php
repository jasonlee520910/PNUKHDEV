<?php
	$root = "../..";
	include_once $root."/_common.php";
	include_once $root."/00_DashBoard/dashboard.lib.php";
	$apiOrderData="";
	$pagegroup = "order";
	$pagecode = "dashboard";
?>
<script>
	function togglePeriod(){
		var type=$("#dashPeriod").attr("value");
		if(type=="week"){
			var ntype="today";
			$("#dashPeriod").attr("value","today");
		}else{
			var ntype="week";
			$("#dashPeriod").attr("value","week");
		}
		callapi('GET','order','dashboard',"dashType="+ntype);
	}

	setInterval("togglePeriod()",5000);

</script>
<div class="process-top">
	<div class="today" style="width:300px;" id="dashPeriod" value="week" onclick="togglePeriod()">
		<span class="btxt" id="todaytit"></span>
		<span class="stxt" id="today"></span>
	</div>

	<div class="con" style="margin-left:100px;">
		<p>
			<span class="btxt"><?=$txtdt["1340"]?><!-- 총주문 --></span>
			<span class="stxt"><i id="order"></i><?=$txtdt["1019"]?><!--건--></span>
		</p>
		<p>
			<span class="btxt"><?=$txtdt["1267"]?><!-- 입금전 --></span>
			<span class="stxt"><i id="prepaid"></i><?=$txtdt["1019"]?><!--건--></span>
		</p> 
		<p>
			<span class="btxt"><?=$txtdt["1230"]?><!-- 완료 --></span>
			<span class="stxt"><i id="done"></i><?=$txtdt["1019"]?><!--건--> <i id="doneper"></i></span>
		</p>
		<p>
			<span class="btxt">작업<?=$txtdt["1055"]?><!-- 대기 --></span>
			<span class="stxt"><i id="wait"></i><?=$txtdt["1019"]?><!--건--></span>
		</p>
		<!-- <p>
			<span class="btxt"><?=$txtdt["1315"]?> --><!-- 중지 --><!-- </span>
			<span class="stxt"><i id="stop"></i><?=$txtdt["1019"]?> --><!--건--><!-- </span>
		</p> -->
		<p>
			<span class="btxt"><?=$txtdt["1356"]?><!-- 취소 --></span>
			<span class="stxt"><i id="cancel"></i><?=$txtdt["1019"]?><!--건--></span>
		</p>  
		<p>
			<span class="btxt">작업중<?//=$txtdt["1356"]?><!-- 취소 --></span>
			<span class="stxt"><i id="proccessing"></i><?=$txtdt["1019"]?><!--건--></span>
		</p>  
	</div>
</div>
<style>
	.process-con{}
	.process-con  ul{}
	.process-con  ul li{height:300px;}
	.totalcnt{position:absolute;width:100px;margin:60% 0 0 70%;line-height:120%;font-size:30px;font-weight:bold;text-align:center;}
	.totalcnt b{font-size:30px;font-weight:bold;}
</style>
<div class="process-con">
	<ul>
		<li>
			<div class="totalcnt">완료<br><b id="matotcnt"></b>건</div>
			<canvas id="canvas"></canvas>
		</li>
		<li>
			<div class="totalcnt">완료<br><b id="dctotcnt"></b>건</div>
			<canvas id="canvas1"></canvas>
		</li>
		<li>
			<div class="totalcnt">완료<br><b id="mrtotcnt"></b>건</div>
			<canvas id="canvas2"></canvas>
		</li>
		<li>
			<div class="totalcnt">완료<br><b id="retotcnt"></b>건</div>
			<canvas id="canvas3"></canvas>
		</li>
	</ul>
</div>

<div class="process-top">    
    <div class="con">
        <p>
            <span class="btxt"><?=$txtdt["1284"]?> <?=$txtdt["1471"]?><!-- 전체 탕전기 --></span>
            <span class="stxt"><i id="boTcnt"></i><?=$txtdt["1465"]?><!-- 기 --></span>
        </p>
        <p>
            <span class="btxt"><?=$txtdt["1361"]?><!-- 탕전 --></span>
            <span class="stxt"><i id="boIng"></i><?=$txtdt["1465"]?><!-- 기 --><i id="boPer"></i></span>
        </p>
        <p>
            <span class="btxt"><?=$txtdt["1466"]?><!-- 준비중 --></span>
            <span class="stxt"><i id="boReady"></i><?=$txtdt["1465"]?><!-- 기 --></span>
        </p>
        <p>
            <span class="btxt"><?=$txtdt["1055"]?><!-- 대기 --></span>
            <span class="stxt"><i id="boStandby"></i><?=$txtdt["1465"]?><!-- 기 --></span>
        </p>
        <p>
            <span class="btxt"><?=$txtdt["1287"]?><!-- 점검 --></span>
            <span class="stxt"><i id="boRepair"></i><?=$txtdt["1465"]?><!-- 기 --></span>
        </p>
    </div>
</div>


<div class="stats-time" id="boilerDiv"></div>

<script  type="text/javascript" src="<?=$root?>/00_DashBoard/dashboard_200309.js?v=<?=time();?>"></script> 
<script>

	var ma_applydata=ma_processingdata=ma_stopdata=ma_canceldata=ma_donedata=ma_greydata="";
	var de_applydata=de_processingdata=de_stopdata=de_canceldata=de_donedata=de_greydata="";
	var mr_applydata=mr_processingdata=mr_stopdata=mr_canceldata=mr_donedata=mr_greydata="";
	var re_applydata=re_processingdata=re_stopdata=re_canceldata=re_donedata=re_greydata="";

	function chartdata(){
		chartData = {
			datasets: [{
					data: [
						ma_applydata,
						ma_processingdata,
						ma_stopdata,
						ma_canceldata,
						ma_donedata,
						ma_greydata
					],
					backgroundColor: [
						window.chartColors.green,
						window.chartColors.yellow,
						window.chartColors.orange,
						window.chartColors.red,
						window.chartColors.blue,
						window.chartColors.grey
					]
			}],
			labels: [
				'<?=$txtdt["1055"]?> ('+ma_applydata+'<?=$txtdt["1019"]?>)', //대기 / 건 
				'<?=$txtdt["1317"]?> ('+ma_processingdata+'<?=$txtdt["1019"]?>)',//진행
				'<?=$txtdt["1315"]?> ('+ma_stopdata+'<?=$txtdt["1019"]?>)',//중지
				//'<?=$txtdt["1356"]?> ('+ma_canceldata+'<?=$txtdt["1019"]?>)',//취소
				//'<?=$txtdt["1230"]?> ('+ma_donedata+'<?=$txtdt["1019"]?>)'//완료 
			]
		};
		return chartData;
	}

	function chartdata1(){
		chartData1 = {
			datasets: [{
					data: [
						de_applydata,
						de_processingdata,
						de_stopdata,
						de_canceldata,
						de_donedata,
						de_greydata
					],
					backgroundColor: [
						window.chartColors.green,
						window.chartColors.yellow,
						window.chartColors.orange,
						window.chartColors.red,
						window.chartColors.blue,
						window.chartColors.grey
					]
			}],
			labels: [
				'<?=$txtdt["1055"]?> ('+de_applydata+'<?=$txtdt["1019"]?>)', //대기 / 건 
				'<?=$txtdt["1317"]?> ('+de_processingdata+'<?=$txtdt["1019"]?>)',//진행
				'<?=$txtdt["1315"]?> ('+de_stopdata+'<?=$txtdt["1019"]?>)',//중지
				//'<?=$txtdt["1356"]?> ('+de_canceldata+'<?=$txtdt["1019"]?>)',//취소
				//'<?=$txtdt["1230"]?> ('+de_donedata+'<?=$txtdt["1019"]?>)'//완료 
			]
		};
		return chartData1;
	}

	function chartdata2(){
		chartData2 = {
			datasets: [{
					data: [
						mr_applydata,
						mr_processingdata,
						mr_stopdata,
						mr_canceldata,
						mr_donedata,
						mr_greydata
					],
					backgroundColor: [
						window.chartColors.green,
						window.chartColors.yellow,
						window.chartColors.orange,
						window.chartColors.red,
						window.chartColors.blue,
						window.chartColors.grey
					]
			}],
			labels: [
				'<?=$txtdt["1055"]?> ('+mr_applydata+'<?=$txtdt["1019"]?>)', //대기 / 건 
				'<?=$txtdt["1317"]?> ('+mr_processingdata+'<?=$txtdt["1019"]?>)',//진행
				'<?=$txtdt["1315"]?> ('+mr_stopdata+'<?=$txtdt["1019"]?>)',//중지
				//'<?=$txtdt["1356"]?> ('+mr_canceldata+'<?=$txtdt["1019"]?>)',//취소
				//'<?=$txtdt["1230"]?> ('+mr_donedata+'<?=$txtdt["1019"]?>)'//완료 
			]
		};
		return chartData2;
	}

	function chartdata3(){
		chartData3 = {
			datasets: [{
					data: [
						re_applydata,
						re_processingdata,
						re_stopdata,
						re_canceldata,
						re_donedata,
						re_greydata
					],
					backgroundColor: [
						window.chartColors.green,
						window.chartColors.yellow,
						window.chartColors.orange,
						window.chartColors.red,
						window.chartColors.blue,
						window.chartColors.grey
					]
			}],
			labels: [
				'<?=$txtdt["1055"]?> ('+re_applydata+'<?=$txtdt["1019"]?>)', //대기 / 건 
				'<?=$txtdt["1317"]?> ('+re_processingdata+'<?=$txtdt["1019"]?>)',//진행
				'<?=$txtdt["1315"]?> ('+re_stopdata+'<?=$txtdt["1019"]?>)',//중지
				//'<?=$txtdt["1356"]?> ('+re_canceldata+'<?=$txtdt["1019"]?>)',//취소
				//'<?=$txtdt["1230"]?> ('+re_donedata+'<?=$txtdt["1019"]?>)'//완료 
			]
		};
		return chartData3;
	}

	function makepage(json)
	{
		console.log("list makepage ----------------------------------------------- ")
		var obj = JSON.parse(json);
		console.log(obj)
		console.log("apiCode : " + obj["apiCode"])
		console.log("-------------------------------------------------------- ")

		if(obj["apiCode"]=="dashboard") //주문리스트
		{
			console.log(obj["dashType"]);
			if(obj["dashType"]=="today"){
				$("#todaytit").text("오늘");
				$("#today").text(obj["todaytxt"]);
			}else{
				$("#todaytit").text("최근 일주일");
				$("#today").text(obj["stime"]+" ~ "+obj["etime"]);
			}

			$("#order").text(obj["order"]);  //총주문
			$("#prepaid").text(obj["prepaid"]); //입금전
			$("#done").text(obj["done"]); //완료
			$("#wait").text(obj["wait"]); //대기
			$("#stop").text(obj["stop"]); //중지
			$("#cancel").text(obj["cancel"]); //취소
			$("#proccessing").text(obj["proccessing"]); //취소

			var per = Number(obj["done"]) / Number(obj["order"]) * 100;

			per = (isNaN(Number(per))) ? 0 : per;
			$("#doneper").text("("+ per.toFixed(2) + "%)");
			
			$("#matotcnt").text(obj["maDoneTotal"]);
			$("#dctotcnt").text(obj["dcDoneTotal"]);
			$("#mrtotcnt").text(obj["mrDoneTotal"]);
			$("#retotcnt").text(obj["reDoneTotal"]);

			$("#maApply").text(obj["maApply"]);
			$("#maProc").text(obj["maProc"]);

		
			$("#dcApply").text(obj["dcApply"]);
			$("#dcProc").text(obj["dcProc"]);

			$("#mrApply").text(obj["mrApply"]);
			$("#mrProc").text(obj["mrProc"]);

			$("#reApply").text(obj["reApply"]);
			$("#reProc").text(obj["reProc"]);

			$("#boTcnt").text(obj["boTcnt"]);  //전체탕전기 
			$("#boIng").text(obj["boIng"]);  //탕전 
			$("#boReady").text(obj["boReady"]);  //준비중 
			$("#boStandby").text(obj["boStandby"]);  //대기
			$("#boRepair").text(obj["boRepair"]);  //점검

			
			ma_applydata=obj["ma_apply"];
			ma_processingdata=obj["ma_processing"];
			ma_stopdata=obj["ma_stop"];
			ma_canceldata=obj["ma_cancel"];
			ma_donedata=obj["ma_done"];

			de_applydata=obj["de_apply"];
			de_processingdata=obj["de_processing"];
			de_stopdata=obj["de_stop"];
			de_canceldata=obj["de_cancel"];
			de_donedata=obj["de_done"];

			mr_applydata=obj["mr_apply"];
			mr_processingdata=obj["mr_processing"];
			mr_stopdata=obj["mr_stop"];
			mr_canceldata=obj["mr_cancel"];
			mr_donedata=obj["mr_done"];

			re_applydata=obj["re_apply"];
			re_processingdata=obj["re_processing"];
			re_stopdata=obj["re_stop"];
			re_canceldata=obj["re_cancel"];
			re_donedata=obj["re_done"];

			//대기,진행,중지,취소,완료 데이터가 하나도 없을 경우에 처리 하기 위함 
			ma_greydata="";
			if(ma_applydata=="0" && ma_processingdata=="0" && ma_stopdata=="0" && ma_canceldata=="0" && ma_donedata=="0")
			{
				ma_greydata="1";
			}

			de_greydata="";
			if(de_applydata=="0" && de_processingdata=="0" && de_stopdata=="0" && de_canceldata=="0" && de_donedata=="0")
			{
				de_greydata="1";
			}

			mr_greydata="";
			if(mr_applydata=="0" && mr_processingdata=="0" && mr_stopdata=="0" && mr_canceldata=="0" && mr_donedata=="0")
			{
				mr_greydata="1";
			}

			re_greydata="";
			if(re_applydata=="0" && re_processingdata=="0" && re_stopdata=="0" && re_canceldata=="0" && re_donedata=="0")
			{
				re_greydata="1";
			}

			var boPer="";

			if(isEmpty(obj["boIng"]) || isEmpty(obj["boTcnt"]))
			{
				boPer="0";
				$("#boPer").text("("+ boPer + "%)");
			}
			else
			{
				boPer = Number(obj["boIng"]) / Number(obj["boTcnt"]) * 100;
				$("#boPer").text("("+ boPer.toFixed(2) + "%)");
			}
		

			var data = '<ul>';

			$(obj["boiler"]).each(function( index, value )
			{
				data+='<li class="'+value["boStatus"]+'">';
				data+='<a href="#">';
				data+='<span class="name">'+value["boLocate"]+'</span>';
				data+='<span class="stxt">'+value["boStattxt"]+'</span>';
				data+='</a>';
				data+='</li>';
			});


			data+='</ul>'

			$("#boilerDiv").html(data);
		}
	}

	//그래프 로드하기 
	setTimeout("loadchart('bar','doughnut')",500);
	//그래프 로드후에 텍스트 수정하기 
	setTimeout(function(){
		if(!isEmpty(myChartData))
		{
			myChartData.options.title.text='<?=$txtdt["1291"]?>';//조제			
		}
		if(!isEmpty(myChartData1))
		{
			myChartData1.options.title.text='<?=$txtdt["1361"]?>';//탕전
		}
		if(!isEmpty(myChartData2))
		{
			myChartData2.options.title.text='<?=$txtdt["1076"]?>';//마킹
		}
		if(!isEmpty(myChartData3))
		{
			myChartData3.options.title.text='<?=$txtdt["1391"]?>';//포장
		}

	},500);

	//주문리스트 API 호출 
	callapi('GET','order','dashboard',"<?=$apiOrderData?>");

</script>