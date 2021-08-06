<?php
	$root = "../..";
	include_once $root."/_common.php";
	include_once $root."/00_DashBoard/dashboard.lib.php";
?>
<!-- 190620 상시약 을 약속처방으로 명칭변경 by 대표님 -->
<style>
	#orderstbll thead tr th{color:#3d434c; border-right:1px solid #e3e3e4; border-bottom:1px solid #e3e3e4; background:#f5f5f6; position:relative;padding:7px 0;text-align:center;font-size:13px;}
	#orderstbll tbody tr td{padding:3px;border-right:1px solid #e3e3e4;}
	#weekdaytxt {color:gray;font-size:11px;}
</style>
<div class="board-view-wrap">
	<table class="dashtbl dashtop">
		<tr>
			<th><?=$txtdt["1904"]?><!-- 전체주문 --></th><td id="topTotalCnt">9,999건</td>
<!-- 			<th><?=$txtdt["1905"]?>OKCHART처방</th><td id="topAutoCnt">9,999건</td> -->
			<th><?=$txtdt["1906"]?><!-- 수기처방 --></th><td id="topSmuCnt">9,999건</td>
			<th><?=$txtdt["1907"]?><!-- 한의원처방 --></th><td id="topAlwayCnt">9,999건</td>
			<th><?=$txtdt["1356"]?><!-- 취소 --></th><td id="topCancelCnt">9,999건</td>
		</tr>
	</table>
	<dl class="searbtn">
		<?=radiotypes('')?>
		<dd class="sel sel01"><?=selecttypes("age", $age)?></dd>
		<dd class="sel"><?=selecttypes("gender", $gender)?></dd>
		<dd class="sel seldate"><?=selecttypedate()?></dd>
	</dl>
	<div class="dashdiv">
		<div class="graphdiv">
			<canvas id="canvas"></canvas>
		</div>
		<div class="tbldiv">
			<table class="subtbl" id="orderstbll" style="margin-bottom: 100px;">
			<colgroup>
				<col scope="col" width="20%"> <!-- 20190403 : 주문일 8 에서 7 -->				
				<col scope="col" width="16%"> <!-- 20190403 : 주문일 8 에서 7 -->
				<col scope="col" width="16%"> <!-- 20190403 : 주문코드 13에서 12 -->
				<col scope="col" width="16%"><!-- 20190403 : 주문자 10 에서 7 -->
				<col scope="col" width="16%">
				<col scope="col" width="16%"> <!-- 20190403 : 첩수 7 에서 6 -->
			</colgroup>

			<thead>
				<tr>
					<th></th>
					<th><?=$txtdt["1904"]?><!-- 전체주문 --></th>
<!-- 					<th><?=$txtdt["1905"]?>OKCHART처방</th> -->
					<th><?=$txtdt["1906"]?><!-- 수기처방 --></th>
					<th><?=$txtdt["1907"]?><!-- 한의원처방 --></th>
					<th><?=$txtdt['1356']?><!-- 취소 --></th>
				</tr>
			</thead>

			<tbody>
			</tbody>

			</table>
		</div>
	</div>
</div>
<script  type="text/javascript" src="<?=$root?>/00_DashBoard/dashboard_190906.js?v=<?=time();?>"></script> 
<script>
	var labelAry=new Array();
	var totaldata=new Array();
	var autodata=new Array();
	var smudata=new Array();
	var alwaydata=new Array();
	var canceldata=new Array();

	function chartdata(){
		chartData = {
			labels: labelAry,
			datasets: [{
				label: '<?=$txtdt["1906"]?>',//수기처방
				backgroundColor: window.chartColors.green,
				data: smudata
			},{
				label: '<?=$txtdt["1907"]?>',//한의원처방
				backgroundColor: window.chartColors.orange,
				data: alwaydata
			},{
				label: '<?=$txtdt["1356"]?>',//취소
				backgroundColor: window.chartColors.grey,
				data: canceldata
			}
			]
		};
		return chartData;
	}
	function makepage(json)
	{
		console.log("list makepage ----------------------------------------------- ")
		var obj = JSON.parse(json);
		console.log(obj)
		console.log("apiCode : " + obj["apiCode"])
		console.log("-------------------------------------------------------- ")

		var data=weekday=days="";
		var cancel=topTotalCnt=topAutoCnt=topSmuCnt=topAlwayCnt=topCancelCnt=0;

		labelAry=[];
		totaldata=[];
		autodata=[];
		smudata=[];
		alwaydata=[];
		canceldata=[];

		if(obj["apiCode"]=="ordersdaily") //주문보고서 > 일자별 
		{
			$("#orderstbll tbody").html("");

			if(!isEmpty(obj["list"]))
			{
				$(obj["list"]).each(function( index, value )
				{
					data+=" <tr> ";
					data+=" 	<td>"+value["dt"]+" / "+value["week"]+"</td> ";
					data+=" 	<td>"+comma(value["total_cnt"])+" <?=$txtdt['1019']?></td> ";
					//data+=" 	<td>"+comma(value["okchart_cnt"])+" <?=$txtdt['1019']?></td> ";
					data+=" 	<td>"+comma(value["manager_cnt"])+" <?=$txtdt['1019']?></td> ";
					data+=" 	<td>"+comma(value["cy_cnt"])+" <?=$txtdt['1019']?></td> ";
					data+=" 	<td>"+comma(value["cancel_cnt"])+" <?=$txtdt['1019']?></td> ";
					data+=" </tr> ";

					weekday=value["dt"].split("-");
					days=parseInt(weekday[2]);

					labelAry.push(days+"일");
					totaldata.push(value["total_cnt"]);
					//autodata.push(value["okchart_cnt"]);
					smudata.push(value["manager_cnt"]);
					alwaydata.push(value["cy_cnt"]);
					canceldata.push(value["cancel_cnt"]);

					topTotalCnt+=parseInt(value["total_cnt"]);
					//topAutoCnt+=parseInt(value["okchart_cnt"]);
					topSmuCnt+=parseInt(value["manager_cnt"]);
					topAlwayCnt+=parseInt(value["cy_cnt"]);
					topCancelCnt+=parseInt(value["cancel_cnt"]);
				});

				
			}
			else
			{
				data+="<tr>";
				data+="	<td colspan='6'><?=$txtdt['1665']?></td>";
				data+="</tr>";
			}

			$("#orderstbll tbody").html(data);
	
			chartTitle="<?=$txtdt['1783']?> - <?=$txtdt['1811']?>";//주문보고서 - 일자별
		}
		else if(obj["apiCode"]=="ordersweekly") //주문보고서 > 요일별  
		{
			$("#orderstbll tbody").html("");

			var weeklist = ["","일","월","화","수","목","금","토"];

			if(!isEmpty(obj["list"]))
			{
				$(obj["list"]).each(function( index, value )
				{				
					data+=" <tr> ";
					data+=" 	<td>"+value["week"]+"</td> ";
					data+=" 	<td>"+comma(value["total_cnt"])+" <?=$txtdt['1019']?></td> ";
					//data+=" 	<td>"+comma(value["okchart_cnt"])+" <?=$txtdt['1019']?></td> ";
					data+=" 	<td>"+comma(value["manager_cnt"])+" <?=$txtdt['1019']?></td> ";
					data+=" 	<td>"+comma(value["cy_cnt"])+" <?=$txtdt['1019']?></td> ";
					data+=" 	<td>"+comma(value["cancel_cnt"])+" <?=$txtdt['1019']?></td> ";
					data+=" </tr> ";

					days=weeklist[value["week_n"]];
					labelAry.push(days+"요일");
					totaldata.push(value["total_cnt"]);
					//autodata.push(value["okchart_cnt"]);
					smudata.push(value["manager_cnt"]);
					alwaydata.push(value["cy_cnt"]);
					canceldata.push(value["cancel_cnt"]);

					topTotalCnt+=parseInt(value["total_cnt"]);
					//topAutoCnt+=parseInt(value["okchart_cnt"]);
					topSmuCnt+=parseInt(value["manager_cnt"]);
					topAlwayCnt+=parseInt(value["cy_cnt"]);
					topCancelCnt+=parseInt(value["cancel_cnt"]);
				});

			}
			else
			{
				data+="<tr>";
				data+="	<td colspan='6'><?=$txtdt['1665']?></td>";
				data+="</tr>";
			}

			$("#orderstbll tbody").html(data);

			chartTitle="<?=$txtdt['1783']?> - <?=$txtdt['1813']?>";//주문보고서 - 요일별 
		}
		else if(obj["apiCode"]=="ordersweekday") //주문보고서 > 주간별   
		{
			$("#orderstbll tbody").html("");

			if(!isEmpty(obj["list"]))
			{
				$(obj["list"]).each(function( index, value )
				{								
					data+=" <tr> ";
					data+=" 	<td>"+value["weeks"]+"주</td> ";
					data+=" 	<td>"+comma(value["total_cnt"])+" <?=$txtdt['1019']?></td> ";
					//data+=" 	<td>"+comma(value["okchart_cnt"])+" <?=$txtdt['1019']?></td> ";
					data+=" 	<td>"+comma(value["manager_cnt"])+" <?=$txtdt['1019']?></td> ";
					data+=" 	<td>"+comma(value["cy_cnt"])+" <?=$txtdt['1019']?></td> ";
					data+=" 	<td>"+comma(value["cancel_cnt"])+" <?=$txtdt['1019']?></td> ";
					data+=" </tr> ";

					labelAry.push(value["weeks"]+"주");
					totaldata.push(value["total_cnt"]);
					//autodata.push(value["okchart_cnt"]);
					smudata.push(value["manager_cnt"]);
					alwaydata.push(value["cy_cnt"]);
					canceldata.push(value["cancel_cnt"]);

					topTotalCnt+=parseInt(value["total_cnt"]);
					//topAutoCnt+=parseInt(value["okchart_cnt"]);
					topSmuCnt+=parseInt(value["manager_cnt"]);
					topAlwayCnt+=parseInt(value["cy_cnt"]);
					topCancelCnt+=parseInt(value["cancel_cnt"]);
				});
			}
			else
			{
				data+="<tr>";
				data+="	<td colspan='6'><?=$txtdt['1665']?></td>";
				data+="</tr>";
			}
			$("#orderstbll tbody").html(data);

			chartTitle="<?=$txtdt['1783']?> - <?=$txtdt['1812']?>";//주문보고서 - 주간별 
	
		}

		$("#topTotalCnt").text(comma(topTotalCnt) + "<?=$txtdt['1019']?>");
		//$("#topAutoCnt").text(comma(topAutoCnt) + "<?=$txtdt['1019']?>");
		$("#topSmuCnt").text(comma(topSmuCnt) + "<?=$txtdt['1019']?>");
		$("#topAlwayCnt").text(comma(topAlwayCnt) + "<?=$txtdt['1019']?>");
		$("#topCancelCnt").text(comma(topCancelCnt) + "<?=$txtdt['1019']?>");


		if(!isEmpty(myChartData))
		{
			myChartData.options.title.text=chartTitle;
		}

		if(!isEmpty(chartData))
		{
			chartData.labels=labelAry;
			chartData.datasets.forEach(function(dataset) {

				//if(dataset.label=="<?=$txtdt['1905']?>")
				//	dataset.data = autodata;
				//else 
				if(dataset.label=="<?=$txtdt['1906']?>")
					dataset.data = smudata;
				else if(dataset.label=="<?=$txtdt['1907']?>")
					dataset.data = alwaydata;
				else if(dataset.label=="<?=$txtdt['1356']?>")
					dataset.data = canceldata;
			});

				
			window.myChart.update();
		}

	}

	setTimeout("loadchart('bar','stack')",100);


	searchsendapi();


</script>
