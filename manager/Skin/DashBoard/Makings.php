<?php
	$root = "../..";
	include_once $root."/_common.php";
	include_once $root."/00_DashBoard/dashboard.lib.php";
?>
<style>
	#makingstbll thead tr th{color:#3d434c; border-right:1px solid #e3e3e4; border-bottom:1px solid #e3e3e4; background:#f5f5f6; position:relative;padding:7px 0;text-align:center;font-size:13px;}
	#makingstbll tbody tr td{padding:3px;border-right:1px solid #e3e3e4;}
	#weekdaytxt {color:gray;font-size:11px;}
</style>
<div class="board-view-wrap">
	<table class="dashtbl dashtop">
		<tr>
			<th><?=$txtdt["1823"]?><!-- 전체조제시간 --></th><td id="topTotalTime">3,800분</td>
			<th><?=$txtdt["1824"]?><!-- 전체조제수 --></th><td id="topTotalCnt">3,800분</td>
			<th><?=$txtdt["1827"]?><!-- 조제당평균소요시간 --></th><td id="topAvgTime">3분30초</td>
			<th><?=$txtdt["1828"]?><!-- 조제당평균약재수량 --></th><td id="topAvgMedicine">20건</td>
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
			<table class="subtbl" id="makingstbll" style="margin-bottom: 100px;">
				<colgroup>
					<col scope="col" width="20%">
					<col scope="col" width="20%">
					<col scope="col" width="20%">
					<col scope="col" width="20%">
					<col scope="col" width="20%">
				</colgroup>
				<thead>
					<tr>
						<th></th>
						<th><?=$txtdt["1823"]?><!-- 전체조제시간 --></th>
						<th><?=$txtdt["1824"]?><!-- 전체조제수 --></th>
						<th><?=$txtdt["1825"]?><!-- 평균소요시간 --></th>
						<th><?=$txtdt["1826"]?><!-- 평균약재갯수 --></th>
					</tr>
				</thead>

				<tbody>
				</tbody>

			</table>
		</div>
	</div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.13.0/moment.min.js"></script>
<script  type="text/javascript" src="<?=$root?>/00_DashBoard/dashboard_200309.js?v=<?=time();?>"></script> 
<script>
	var timeFormat = 'HH:mm';

	function newDate(days) {
		return moment().add(days, 'd').toDate();
	}

	function newDateString(days) {
		return moment().add(days, 'd').format(timeFormat);
	}

	var labelAry=new Array();
	var timedata=new Array();
	var medicinedata=new Array();
	
	function chartdata(){
		var chartData = {
			labels: labelAry,
			datasets: [{
				type: 'line',
				label: '<?=$txtdt["1825"]?>',//평균소요시간 
				backgroundColor:window.chartColors.red,
				borderColor: window.chartColors.red,
				data: timedata,
				pointRadius: 0,
				fill: false,
				lineTension: 0,
				borderWidth: 2,
				yAxisID: 'y-axis-1',
			},{
				type: 'bar',
				label: '<?=$txtdt["1826"]?>',//평균약재갯수 
				backgroundColor:window.chartColors.blue,
				borderColor: window.chartColors.blue,
				data: medicinedata,
				pointRadius: 0,
				fill: false,
				lineTension: 0,
				borderWidth: 2,
				yAxisID: 'y-axis-2'
			}
					]
		};
		return chartData;
	}
	//초를 시분초로 나누어서 보여주자 
	function secondToTimes(seconds) 
	{
		var hour = parseInt(seconds/3600);
		var min = parseInt((seconds%3600)/60);
		var sec = seconds%60;
		var str = "";
		if(hour>0)
			str+=hour+"시";
		if(min>0)
			str+=min+"<?=$txtdt['1437']?>";
		if(sec>0)
		{
			str+=Math.round(sec)+"초";
		}
		
		return str;
	}
	function humanReadable(seconds) {
		var myNum = parseInt(seconds, 10);
		var hours   = Math.floor(myNum / 3600);
		var minutes = Math.floor((myNum - (hours * 3600)) / 60);
		var seconds = myNum - (hours * 3600) - (minutes * 60);

		if (hours   < 10) {hours   = "0"+hours;}
		if (minutes < 10) {minutes = "0"+minutes;}
		if (seconds < 10) {seconds = "0"+seconds;}
		return hours+''+minutes;//+''+seconds;
		//return hours+''+minutes;//+':'+seconds;
	}
	function makepage(json)
	{
		console.log("list makepage ----------------------------------------------- ")
		var obj = JSON.parse(json);
		console.log(obj)
		console.log("apiCode : " + obj["apiCode"])
		console.log("-------------------------------------------------------- ")

		var data=weekday=days=chartTitle="";
		var topTotalTime=topTotalCnt=topAvgTime=topAvgMedicine=avgmedicine=avgtime=0;

		labelAry=[];
		timedata=[];
		medicinedata=[];

		if(obj["apiCode"]=="makingsdaily") //조제보고서 > 일자별 
		{
			$("#makingstbll tbody").html("");

			if(!isEmpty(obj["list"]))
			{
				$(obj["list"]).each(function( index, value )
				{
					avgtime = Math.round(parseFloat(value["total_time"]) / parseFloat(value["total_cnt"]));
					avgmedicine = Math.round(parseFloat(value["total_medicine"]) / parseFloat(value["total_cnt"]));

					data+=" <tr> ";
					data+=" 	<td>"+value["dt"]+" / "+value["week"]+"</td> ";
					data+=" 	<td>"+secondToTimes(value["total_time"])+" </td> ";
					data+=" 	<td>"+value["total_cnt"]+" <?=$txtdt['1018']?></td> ";
					data+=" 	<td>"+secondToTimes(avgtime)+"</td> ";
					data+=" 	<td>"+avgmedicine+" <?=$txtdt['1018']?></td> ";
					data+=" </tr> ";


					weekday=value["dt"].split("-");
					labelAry.push(weekday[2]+"일");
					timedata.push(humanReadable(avgtime));
					medicinedata.push(avgmedicine);

					topTotalTime+=parseFloat(value["total_time"]);//전체조제시간 
					topTotalCnt+=parseFloat(value["total_cnt"]);//전체조제수
					topAvgTime+=parseFloat(value["total_time"]);//평균조제소요시간 
					topAvgMedicine+=parseFloat(value["total_medicine"]);//평균약재수량
				});
				
			}
			else
			{
				data+="<tr>";
				data+="	<td colspan='5'><?=$txtdt['1665']?></td>";
				data+="</tr>";
			}

			$("#makingstbll tbody").html(data);

			chartTitle="<?=$txtdt['1784']?> - <?=$txtdt['1811']?>";//조제보고서 - 일자별 

		}
		else if(obj["apiCode"]=="makingsweekly") //조제보고서 > 요일별  
		{
			$("#makingstbll tbody").html("");

			var weeklist = ["","일","월","화","수","목","금","토"];

			if(!isEmpty(obj["list"]))
			{
				$(obj["list"]).each(function( index, value )
				{				
					avgtime = parseFloat(value["total_time"]) / parseFloat(value["total_cnt"]);
					avgmedicine = Math.round(parseFloat(value["total_medicine"]) / parseFloat(value["total_cnt"]));
					data+=" <tr> ";
					data+=" 	<td>"+value["week"]+"</td> ";
					data+=" 	<td>"+secondToTimes(value["total_time"])+" </td> ";
					data+=" 	<td>"+value["total_cnt"]+" <?=$txtdt['1018']?></td> ";
					data+=" 	<td>"+secondToTimes(avgtime)+"</td> ";
					data+=" 	<td>"+avgmedicine+" <?=$txtdt['1018']?></td> ";

					labelAry.push(value["week"]);
					timedata.push(humanReadable(avgtime));
					medicinedata.push(avgmedicine);

					topTotalTime+=parseFloat(value["total_time"]);//전체조제시간 
					topTotalCnt+=parseFloat(value["total_cnt"]);//전체조제수
					topAvgTime+=parseFloat(value["total_time"]);//평균조제소요시간 
					topAvgMedicine+=parseFloat(value["total_medicine"]);//평균약재수량

				});
			}
			else
			{
				data+="<tr>";
				data+="	<td colspan='5'><?=$txtdt['1665']?></td>";
				data+="</tr>";
			}



			$("#makingstbll tbody").html(data);

			chartTitle="<?=$txtdt['1784']?> - <?=$txtdt['1813']?>";//조제보고서 - 요일별 
		}
		else if(obj["apiCode"]=="makingsweekday") //조제보고서 > 주간별   
		{
			$("#makingstbll tbody").html("");
	
			if(!isEmpty(obj["list"]))
			{
				$(obj["list"]).each(function( index, value )
				{				

					avgtime = parseFloat(value["total_time"]) / parseFloat(value["total_cnt"]);
					avgmedicine = Math.round(parseFloat(value["total_medicine"]) / parseFloat(value["total_cnt"]));
					data+=" <tr> ";
					data+=" 	<td>"+value["weeks"]+"주</td> ";
					data+=" 	<td>"+secondToTimes(value["total_time"])+" </td> ";
					data+=" 	<td>"+value["total_cnt"]+" <?=$txtdt['1018']?></td> ";
					data+=" 	<td>"+secondToTimes(avgtime)+"</td> ";
					data+=" 	<td>"+avgmedicine+" <?=$txtdt['1018']?></td> ";

					/*
					days=parseInt(value["weeks"])-1;
					days=(days>0)?days:0;

					timedata.splice(days, 1,  humanReadable(avgtime));//평균소요시간
					medicinedata.splice(days, 1, avgmedicine);//평균약재갯수 
					*/
					labelAry.push(value["weeks"]+"주");
					timedata.push(humanReadable(avgtime));
					medicinedata.push(avgmedicine);

					topTotalTime+=parseFloat(value["total_time"]);//전체조제시간 
					topTotalCnt+=parseFloat(value["total_cnt"]);//전체조제수
					topAvgTime+=parseFloat(value["total_time"]);//평균조제소요시간 
					topAvgMedicine+=parseFloat(value["total_medicine"]);//평균약재수량

				});
			}
			else
			{
				data+="<tr>";
				data+="	<td colspan='5'><?=$txtdt['1665']?></td>";
				data+="</tr>";
			}
			$("#makingstbll tbody").html(data);

			chartTitle="<?=$txtdt['1784']?> - <?=$txtdt['1812']?>"; //조제보고서 - 주간별 
		}

		var avgTopTime=avgTopMedicine=0;
		if(topAvgTime>0 && topTotalCnt > 0)
		{
			avgTopTime=Math.round(parseFloat(topAvgTime) / parseFloat(topTotalCnt));
		}
		if(topAvgMedicine>0 && topTotalCnt > 0)
		{
			avgTopMedicine=Math.round(parseFloat(topAvgMedicine) / parseFloat(topTotalCnt));
		}
		$("#topTotalTime").text(secondToTimes(topTotalTime)); //전체조제시간 
		$("#topTotalCnt").text(topTotalCnt + "<?=$txtdt['1018']?>"); //전체조제수
		$("#topAvgTime").text(secondToTimes(avgTopTime));//조제당평균소요시간
		$("#topAvgMedicine").text(avgTopMedicine + "<?=$txtdt['1018']?>");//조제당평균약재수량


			//console.log(timedata);
			//console.log(medicinedata);

		if(!isEmpty(myChartData))
		{
			myChartData.options.title.text=chartTitle;
		}
		if(!isEmpty(chartData))
		{
			chartData.labels=labelAry;
			chartData.datasets.forEach(function(dataset) {
				if(dataset.label=="<?=$txtdt['1825']?>")//평균소요시간 
					dataset.data = timedata;
				else if(dataset.label=="<?=$txtdt['1826']?>") //평균약재갯수 
					dataset.data = medicinedata;
			});

				
			window.myChart.update();
		}
	}

	setTimeout("loadchart('bar','multi')",100);

	searchsendapi();
</script>
