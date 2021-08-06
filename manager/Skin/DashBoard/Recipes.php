<?php
	$root = "../..";
	include_once $root."/_common.php";
	include_once $root."/00_DashBoard/dashboard.lib.php";
?>
<style>
	#recipestbll thead tr th{color:#3d434c; border-right:1px solid #e3e3e4; border-bottom:1px solid #e3e3e4; background:#f5f5f6; position:relative;padding:7px 0;text-align:center;font-size:13px;}
	#recipestbll tbody tr td{padding:3px;border-right:1px solid #e3e3e4;}
	#weekdaytxt {color:gray;font-size:11px;}
	#medizero {color:blue;font-weight:bold; }	
</style>
<div class="board-view-wrap">
	<table class="dashtbl dashtop">
		<tr>
			<th><?=$txtdt["1809"]?></th><td id="topTotalOrderCnt">580개</td>
			<th><?=$txtdt["1807"]?></th><td id="topTotalOrderCapa">15,000g</td>
			<th><?=$txtdt["1810"]?></th><td id="topTotalMakingCnt">560개</td>
			<th><?=$txtdt["1808"]?></th><td id="topTotalMakingCapa">14,000g</td>
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
			<p>*조제약재클릭 시 약재목록</p>
			<table class="subtbl" id="recipestbll" style="margin-bottom: 100px;">
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
						<th><?=$txtdt["1809"]?></th><!-- 처방약재수량 -->
						<th><?=$txtdt["1807"]?></th><!-- 처방약재용량 -->
						<th><?=$txtdt["1810"]?></th><!-- 조제약재수량 -->
						<th><?=$txtdt["1808"]?></th><!-- 조제약재용량 -->
					</tr>
				</thead>

				<tbody>
				</tbody>

			</table>
		</div>
	</div>
</div>
<script  type="text/javascript" src="<?=$root?>/00_DashBoard/dashboard_200309.js?v=<?=time();?>"></script> 
<script>
	var labelAry=new Array();
	var recipedata=new Array();
	var makingdata=new Array();
	var color = Chart.helpers.color;
	function chartdata(){
		var chartData = {
			labels: labelAry,
			datasets: [{
				label: '<?=$txtdt["1807"]?>',//처방약재용량
				backgroundColor: color(window.chartColors.red).alpha(0.5).rgbString(),
				borderColor: window.chartColors.red,
				borderWidth: 1,
				data: recipedata
			}, {
				label: '<?=$txtdt["1808"]?>',//조제약재용량 
				backgroundColor: color(window.chartColors.blue).alpha(0.5).rgbString(),
				borderColor: window.chartColors.blue,
				borderWidth: 1,
				data: makingdata
			}]
/*
			datasets: [{
				label: '처방약재용량',
				borderColor: window.chartColors.red,
				backgroundColor: window.chartColors.red,
				fill: false,
				data: recipedata
			}, {
				label: '조제약재용량',
				borderColor: window.chartColors.blue,
				backgroundColor: window.chartColors.blue,
				fill: false,
				data: makingdata
			}]
					*/
		};
		return chartData;
	}
	function goMakingZero(seardate)
	{
		//seardate
	}
	function makepage(json)
	{
		console.log("list makepage ----------------------------------------------- ")
		var obj = JSON.parse(json);
		console.log(obj)
		console.log("apiCode : " + obj["apiCode"])
		console.log("-------------------------------------------------------- ")

		var data=weekday=days=chartTitle="";
		var topTotalOrderCnt=topTotalOrderCapa=topTotalMakingCnt=topTotalMakingCapa=0;

		labelAry=[];
		recipedata=[];
		makingdata=[];


		if(obj["apiCode"]=="recipesdaily") //처방보고서 > 일자별 
		{
			$("#recipestbll tbody").html("");

			/*
			var searyear=$("select[name=searyear]").val(); //년
			var searmonth=$("select[name=searmonth]").val();//월 
			var lastDay = (new Date( searyear, searmonth, 0)).getDate();
			for(i=1;i<=lastDay;i++)
			{
				labelAry.push(i+"일");
				recipedata.push(0);
				makingdata.push(0);
			}
			*/

			if(!isEmpty(obj["list"]))
			{
				$(obj["list"]).each(function( index, value )
				{
					data+=" <tr> ";
					data+=" 	<td>"+value["dt"]+" / "+value["week"]+"</td> ";
					data+=" 	<td>"+comma(value["odcnt"])+"<?=$txtdt['1018']?></td> ";
					data+=" 	<td>"+comma(value["odcapa"])+"g</td> ";
					data+=" 	<td><span class='link' id='medizero' onclick=\"getlayer('layer-makingzero','800,700','"+value["dt"]+"')\">"+comma(value["mkcnt"])+"<?=$txtdt['1018']?></span></td> ";
					data+=" 	<td>"+comma(value["mkcapa"])+"g</td> ";
					data+=" </tr> ";
				
					weekday=value["dt"].split("-");
					/*
					days=parseInt(weekday[2])-1;
					days=(days>0)?days:0;

					recipedata.splice(days, 1, value["odcapa"]);//처방약재용량
					makingdata.splice(days, 1, value["mkcapa"]);//조제약재용량 
					*/
					labelAry.push(parseInt(weekday[2])+"일");
					recipedata.push(value["odcapa"]);
					makingdata.push(value["mkcapa"]);


					topTotalOrderCnt+=parseInt(value["odcnt"]);//전체처방약재수량
					topTotalOrderCapa+=parseInt(value["odcapa"]);//전체처방약재용량
					topTotalMakingCnt+=parseInt(value["mkcnt"]);//전체조제약재수량
					topTotalMakingCapa+=parseInt(value["mkcapa"]);//전체조제약재용량 
				});
				
			}
			else
			{
				data+="<tr>";
				data+="	<td colspan='5'><?=$txtdt['1665']?></td>";
				data+="</tr>";
			}

			$("#recipestbll tbody").html(data);

			chartTitle="<?=$txtdt['1785']?> - <?=$txtdt['1811']?>";//처방보고서  - 일자별 

		}
		else if(obj["apiCode"]=="recipesweekly") //처방보고서 > 요일별  
		{
			$("#recipestbll tbody").html("");

			var weeklist = ["","일","월","화","수","목","금","토"];
	
			if(!isEmpty(obj["list"]))
			{
				$(obj["list"]).each(function( index, value )
				{
					data+=" <tr> ";
					data+=" 	<td>"+value["week"]+"</td> ";
					data+=" 	<td>"+comma(value["odcnt"])+"<?=$txtdt['1018']?></td> ";
					data+=" 	<td>"+comma(value["odcapa"])+"g</td> ";
					data+=" 	<td><span class='link' id='medizero' onclick=\"getlayer('layer-makingzero','800,700','"+value["dt"]+"')\">"+comma(value["mkcnt"])+"<?=$txtdt['1018']?></span></td> ";
					data+=" 	<td>"+comma(value["mkcapa"])+"g</td> ";


					labelAry.push(value["week"]);
					recipedata.push(value["odcapa"]);
					makingdata.push(value["mkcapa"]);


					topTotalOrderCnt+=parseInt(value["odcnt"]);//전체처방약재수량
					topTotalOrderCapa+=parseInt(value["odcapa"]);//전체처방약재용량
					topTotalMakingCnt+=parseInt(value["mkcnt"]);//전체조제약재수량
					topTotalMakingCapa+=parseInt(value["mkcapa"]);//전체조제약재용량 

				});
			}
			else
			{
				data+="<tr>";
				data+="	<td colspan='5'><?=$txtdt['1665']?></td>";
				data+="</tr>";
			}

			$("#recipestbll tbody").html(data);

			chartTitle="<?=$txtdt['1785']?> - <?=$txtdt['1813']?>"; //처방보고서 - 요일별 
		}
		else if(obj["apiCode"]=="recipesweekday") //처방보고서 > 주간별   
		{
			$("#recipestbll tbody").html("");
			if(!isEmpty(obj["list"]))
			{
				$(obj["list"]).each(function( index, value )
				{
					data+=" <tr> ";
					data+=" 	<td>"+value["weeks"]+"주</td> ";
					data+=" 	<td>"+comma(value["odcnt"])+"<?=$txtdt['1018']?></td> ";
					data+=" 	<td>"+comma(value["odcapa"])+"g</td> ";
					data+=" 	<td><span class='link' id='medizero' onclick=\"getlayer('layer-makingzero','800,700','"+value["dt"]+"')\">"+comma(value["mkcnt"])+"<?=$txtdt['1018']?></span></td> ";
					data+=" 	<td>"+comma(value["mkcapa"])+"g</td> ";

					labelAry.push(value["weeks"]+"주");
					recipedata.push(value["odcapa"]);
					makingdata.push(value["mkcapa"]);


					topTotalOrderCnt+=parseInt(value["odcnt"]);//전체처방약재수량
					topTotalOrderCapa+=parseInt(value["odcapa"]);//전체처방약재용량
					topTotalMakingCnt+=parseInt(value["mkcnt"]);//전체조제약재수량
					topTotalMakingCapa+=parseInt(value["mkcapa"]);//전체조제약재용량 

				});
			}
			else
			{
				data+="<tr>";
				data+="	<td colspan='5'><?=$txtdt['1665']?></td>";
				data+="</tr>";
			}
			$("#recipestbll tbody").html(data);

			chartTitle="<?=$txtdt['1785']?> - <?=$txtdt['1812']?>"; //처방보고서 - 주간별 
		}
		else if(obj["apiCode"]=="makingmedizero")
		{
			$("#mkzerotbll tbody").html("");

			if(!isEmpty(obj["list"]))
			{
				$(obj["list"]).each(function( index, value )
				{
					var capa = parseInt(value["makingcapa"]) / parseInt(value["mdcapa"]) * 100;
					data+=" <tr> ";
					data+=" 	<td>"+value["mmTitle"]+"</td> ";
					data+=" 	<td>"+comma(value["mdcapa"])+"g</td> ";
					data+=" 	<td>"+comma(value["makingcapa"])+"g</td> ";
					if(capa >= 100)
					{
						data+=" 	<td><span style='color:red;'>▲"+commasFixed(capa)+"%</span></td> ";
					}
					else
					{
						data+=" 	<td><span style='color:blue;'>▼"+commasFixed(capa)+"%</span></td> ";
					}
					data+=" </tr> ";				
				});
				
			}
			else
			{
				data+="<tr>";
				data+="	<td colspan='4'><?=$txtdt['1665']?></td>";
				data+="</tr>";
			}

			$("#mkzerotbll tbody").html(data);
		}

		if(obj["apiCode"]!="makingmedizero")
		{
			$("#topTotalOrderCnt").text(comma(topTotalOrderCnt) + "<?=$txtdt['1018']?>"); //전체처방약재수량 
			$("#topTotalOrderCapa").text(comma(topTotalOrderCapa) + "g"); //전체처방약재용량
			$("#topTotalMakingCnt").text(comma(topTotalMakingCnt) + "<?=$txtdt['1018']?>");//전체조제약재수량
			$("#topTotalMakingCapa").text(comma(topTotalMakingCapa) + "g");//전체조제약재용량

			if(!isEmpty(myChartData))
			{
				myChartData.options.title.text=chartTitle;
			}
			if(!isEmpty(chartData))
			{
				chartData.labels=labelAry;
				chartData.datasets.forEach(function(dataset){
					if(dataset.label=="<?=$txtdt['1807']?>")//처방약재용량
						dataset.data = recipedata;
					else if(dataset.label=="<?=$txtdt['1808']?>")//조제약재용량 
						dataset.data = makingdata;
				});
				window.myChart.update();
			}
		}
	}

	setTimeout("loadchart('bar','linebar')",100);

	searchsendapi();
</script>
