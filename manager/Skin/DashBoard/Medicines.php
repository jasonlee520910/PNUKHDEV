<?php
	$root = "../..";
	include_once $root."/_common.php";
	include_once $root."/00_DashBoard/dashboard.lib.php";
?>
<style>
	#medicinestbll thead tr th{color:#3d434c; border-right:1px solid #e3e3e4; border-bottom:1px solid #e3e3e4; background:#f5f5f6; position:relative;padding:7px 0;text-align:center;font-size:13px;}
	#medicinestbll tbody tr td{padding:3px;border-right:1px solid #e3e3e4;}
	.td_text_overflow {width:100px;overflow: hidden;white-space: nowrap;}
</style>
<div class="board-view-wrap">
	<table class="dashtbl dashtop">
		<tr>
			<th><?=$txtdt["1819"]?><!-- 처방약재량 --></th><td id="topTotalRecipeCapa">20,000g</td>
			<th><?=$txtdt["1820"]?><!-- 조제약재량 --></th><td id="topTotalMakingCapa">19,000g</td>
			<th><?=$txtdt["1821"]?><!-- 누적사용량 --></th><td id="topAccrueMakingCapa">100,000g</td>
		</tr>
	</table>
	<dl class="searbtn">
		<dd class="sel selmedidate"><?=selectmedidate()?></dd>
		<dd class="input sel01"><?=searchbtn('searchtxt')?></dd>
	
		<button type="button" class="sp-btn"  onclick="medicineDownload();">Excel Download</button>

		<!-- <dd class="sel seldate"><?=selectmediweek()?></dd> --> <!-- 20200309 : 요일,주전체는 제외 -->
	</dl>
	<span id="totListCnt" style="float:right;text-align:right;vertical-align:bottom;"></span>
	<div class="dashdiv">
		<div class="graphdiv">
			<canvas id="canvas"></canvas>
		</div>
		<div class="tbldiv">			
			<table class="subtbl" id="medicinestbll" style="margin-bottom: 100px;">
				<colgroup>
					<col scope="col" width="18%">
					<col scope="col" width="10%">
					<col scope="col" width="12%">
					<col scope="col" width="11%">
					<col scope="col" width="15%">
					<col scope="col" width="15%">
					<col scope="col" width="10%">
					<col scope="col" width="16%">
					<col scope="col" width="16%">
				</colgroup>
				<thead>
					<tr>
						<th><?=$txtdt["1204"]?><!-- 약재명 --></th>
						<th>원산지<?//=$txtdt["1814"]?><!-- 단위 --></th>
						<th>단위<?//=$txtdt["1814"]?><!-- 단위 --></th>
						<th>투입량<?//=$txtdt["1814"]?><!-- 투입량 --></th>
						<th><?=$txtdt["1814"]?><!-- 처방용량 --></th>
						<th><?=$txtdt["1815"]?><!-- 조제용량 --></th>
						<th><?=$txtdt["1816"]?><!-- 차인량 --></th>
						<th><?=$txtdt["1817"]?><!-- 누적처방량 --></th>
						<th><?=$txtdt["1818"]?><!-- 누적조제량 --></th>
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

	function chartdata(){
		var color = Chart.helpers.color;
		var chartData = {
			labels: labelAry,
			datasets: [{
				label: '<?=$txtdt["1814"]?>',//처방용량
				backgroundColor: color(window.chartColors.red).alpha(0.5).rgbString(),
				borderColor: window.chartColors.red,
				borderWidth: 1,
				data: recipedata
			}, {
				label: '<?=$txtdt["1815"]?>',//조제용량 
				backgroundColor: color(window.chartColors.blue).alpha(0.5).rgbString(),
				borderColor: window.chartColors.blue,
				data: makingdata
			}]

		};
		return chartData;
	}
	function medicineDownload()
	{
		var searyear=$("select[name=searyear]").val(); //년
		var searmonth=$("select[name=searmonth]").val();//월 
		var searday=$("select[name=searday]").val();//일
		var seartime=$("select[name=seartime]").val();//시간 

		var searyear1=$("select[name=searyear1]").val(); //년
		var searmonth1=$("select[name=searmonth1]").val();//월 
		var searday1=$("select[name=searday1]").val();//일
		var seartime1=$("select[name=seartime1]").val();//시간 

		var searchtxt=(!isEmpty($("input[name=searchtxt]").val())) ? "&searchtxt="+encodeURI($("input[name=searchtxt]").val()) : "";

		var exdata = "searyear="+searyear+"&searmonth="+searmonth+"&searday="+searday+"&seartime="+seartime+"&searyear1="+searyear1+"&searmonth1="+searmonth1+"&searday1="+searday1+"&seartime1="+seartime1+searchtxt;

		console.log("넘어갈때 날짜 확인 >>>"+exdata); 

		$("#medicinestbll tbody").append("<iframe id='workframe' name='workframe' style='position:fixed;display:none1;width:99%;height:0;bottom:0;background:#fff;'></iframe>");

		$("#workframe").attr("src",getUrlData("API")+"manager/_module/PHP_EXCEL/exceldownloadmedicine.php?"+exdata);		
	}
	function makepage(json)
	{
		console.log("list makepage ----------------------------------------------- ")
		var obj = JSON.parse(json);
		console.log(obj)
		console.log("apiCode : " + obj["apiCode"])
		console.log("-------------------------------------------------------- ")

		var data=weekday=days=chartTitle=maTable="";
		var topTotalRecipeCapa=topTotalMakingCapa=topAccrueMakingCapa=jarwith=i=tablei=0;

		labelAry=[];
		recipedata=[];
		makingdata=[];

		if(obj["apiCode"]=="medicines") //약재보고서  
		{
			$("#medicinestbll tbody").html("");

			if(!isEmpty(obj["list"]))
			{
				$(obj["list"]).each(function( index, value )
				{
					jarwith=parseInt(value["totalmkcapa"]) - parseInt(value["totalmdcapa"]);
					maTable="";
					if(value["mb_table"].indexOf("00000")!==-1)
					{
						tablei++;
						maTable="<?=$txtdt['1822']?>"; //공통 
					}

					var searyear=$("select[name=searyear]").val(); //년
					var searmonth=$("select[name=searmonth]").val();//월 
					var searday=$("select[name=searday]").val();//일
					var onedata = "searyear="+searyear+"&searmonth="+searmonth+"&searday="+searday+"&mdcode="+value["db_mdcode"]+"&mdtitle="+value["mmTitle"];


					//<span class='link' id='medizero' >"+comma(value["mkcnt"])+"<?=$txtdt['1018']?></span>
					data+=" <tr> ";
					data+=" 	<td class='l td_text_overflow'><span class='link' onclick=\"getlayer('layer-onemedicine','900,800','"+onedata+"')\">"+value["mmTitle"]+"</span></td> "; //약재명
					data+=" 	<td>"+value["mdOrigin"]+"</td>";//원산지
					data+=" 	<td>"+value["mm_unit"]+"</td>";//단위
					data+=" 	<td>"+value["mminput"]+"</td>";//투입량 
					data+=" 	<td>"+comma(parseInt(value["totalmdcapa"]))+"g</td>";//처방용량
					data+=" 	<td>"+comma(parseInt(value["totalmkcapa"]))+"g</td> ";//조제용량
					if(jarwith >= 0)
						data+=" 	<td>"+jarwith+"g</td> ";//차인량
					else
						data+=" 	<td><span style='color:red;'>"+jarwith+"g</span></td> ";//차인량
					data+=" 	<td>"+comma(obj["totlalist"][value["db_mdcode"]]["accruemdcapa"])+"g</td> ";//누적처방량
					data+=" 	<td>"+comma(obj["totlalist"][value["db_mdcode"]]["accruemkcapa"])+"g</td> ";//누적조제량 
					data+=" </tr> ";

					//top20개만 보여주자 
					if(i < 20)
					{
						labelAry.push(value["mmTitle"]);
						recipedata.push(parseInt(value["totalmdcapa"]));//처방약재용량
						makingdata.push(parseInt(value["totalmkcapa"]));//조제약재용량
					}

					topTotalRecipeCapa+=parseInt(value["totalmdcapa"]);//전체처방약재량
					topTotalMakingCapa+=parseInt(value["totalmkcapa"]);//전체조제약재량
					topAccrueMakingCapa+=parseInt(obj["totlalist"][value["db_mdcode"]]["accruemkcapa"]);//누적사용량 

					i++;
				});

				if(obj["list"].length==1)
				{
					if((parseInt(recipedata[0])-10) < 10)
					{
						recipedata.push(0);//처방약재용량
					}
					else
					{
						recipedata.push(parseInt(recipedata[0])-10);//처방약재용량
					}

					if((parseInt(makingdata[0])-10) < 10)
					{
						makingdata.push(0);//조제약재용량
					}
					else
					{
						makingdata.push(parseInt(makingdata[0])-10);//조제약재용량
					}
				}
				
			}
			else
			{
				data+="<tr>";
				data+="	<td colspan='9'><?=$txtdt['1665']?></td>";
				data+="</tr>";
			}

			$("#totListCnt").text("<?=$txtdt['1822']?> : "+tablei+"<?=$txtdt['1018']?> / Total : "+i+"<?=$txtdt['1018']?>"); //공통 

			$("#medicinestbll tbody").html(data);

			chartTitle="<?=$txtdt['1786']?> - TOP20"; //약재보고서 

		}
		else if(obj["apiCode"]=="onemedicine")
		{
			$("#onemeditbll tbody").html("");
			var totmacapa=totmdcapa=totcapa=0;

			if(!isEmpty(obj["list"]))
			{
				$(obj["list"]).each(function( index, value )
				{
					jarwith=parseInt(value["db_makingcapa"]) - parseInt(value["db_mdcapa"]);
					totmacapa+=parseInt(value["db_makingcapa"]);
					totmdcapa+=parseInt(value["db_mdcapa"]);
					var db_mkend=(!isEmpty(value["db_mkend"]))?value["db_mkend"]:"-";
					data+=" <tr> ";
					data+=" 	<td>"+value["db_oddate"]+"</td> ";
					data+=" 	<td class='l'>"+value["od_title"]+"</td> ";
					data+=" 	<td class='r'>"+comma(value["db_mdcapa"])+"g</td> ";
					data+=" 	<td class='r'>"+comma(value["db_makingcapa"])+"g</td> ";

					if(jarwith >= 0)
						data+=" 	<td class='r'>"+jarwith+"g</td> ";//차인량
					else
						data+=" 	<td class='r'><span style='color:red;'>"+jarwith+"g</span></td> ";//차인량

					
					data+=" 	<td>"+db_mkend+"</td> ";
					data+=" </tr> ";				
				});

				totcapa=totmacapa-totmdcapa;

				$("#onemdtitle").text("<?=$txtdt['1814']?> : " + comma(totmdcapa)+"g / <?=$txtdt['1815']?> : " + comma(totmacapa)+"g = <?=$txtdt['1816']?> : " + totcapa+"g");
				
			}
			else
			{
				data+="<tr>";
				data+="	<td colspan='6'><?=$txtdt['1665']?></td>";
				data+="</tr>";
			}

			$("#onemeditbll tbody").html(data);

		}

		if(obj["apiCode"]!="onemedicine")
		{
			$("#topTotalRecipeCapa").text(comma(topTotalRecipeCapa) + "g"); //처방약재량 
			$("#topTotalMakingCapa").text(comma(topTotalMakingCapa) + "g"); //조제약재량
			$("#topAccrueMakingCapa").text(comma(topAccrueMakingCapa) + "g");//누적사용량

			if(!isEmpty(myChartData))
			{
				myChartData.options.title.text=chartTitle;
			}
			if(!isEmpty(chartData))
			{
				chartData.labels=labelAry;
				chartData.datasets.forEach(function(dataset){
					if(dataset.label=="<?=$txtdt['1814']?>")//처방용량 
						dataset.data = recipedata;
					else if(dataset.label=="<?=$txtdt['1815']?>")//조제용량 
						dataset.data = makingdata;
				});
				window.myChart.update();
			}
		}
	}

	setTimeout("loadchart('bar','horizon')",100);

	//기본으로 보낼 년,월 
	var searyear=$("select[name=searyear]").val(); //년
	var searmonth=$("select[name=searmonth]").val();//월 
	var searday=$("select[name=searday]").val();//일
	var seartime=$("select[name=seartime]").val();//시간 

	var searyear1=$("select[name=searyear1]").val(); //년
	var searmonth1=$("select[name=searmonth1]").val();//월 
	var searday1=$("select[name=searday1]").val();//일
	var seartime1=$("select[name=seartime1]").val();//시간 

	var data = "searyear="+searyear+"&searmonth="+searmonth+"&searday="+searday+"&seartime="+seartime+"&searyear1="+searyear1+"&searmonth1="+searmonth1+"&searday1="+searday1+"&seartime1="+seartime1;
	callapi('GET','dashboard','medicines',data);


	$("input[name=searchtxt]").focus();
</script>
