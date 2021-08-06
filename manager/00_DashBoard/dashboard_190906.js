var chartData;
var chartData1;
var chartData2;
var chartData3;
var myChartData;
var myChartData1;
var myChartData2;
var myChartData3;
var yLeftData;
function searchsendapi(seardata)
{
	var value=$("#listdiv").attr("data-value");
	var valTitle=value.split("/");
	var onvalue=$(".searbtn .on").attr("value");
	var apicode=data="";
	onvalue=(!isEmpty(onvalue)) ? onvalue : "";
	if(valTitle[3] == "Medicines") //약재보고서만 따로 예외처리 
	{
		apicode=(valTitle[3]+""+onvalue).toLowerCase();
	}
	else
	{
		apicode=(valTitle[3]+""+onvalue).toLowerCase();
	}
	

	//기본으로 보낼 년,월 
	var searyear=$("select[name=searyear]").val(); //년
	var searmonth=$("select[name=searmonth]").val();//월 
	var searday=$("select[name=searday]").val();//일

	var searyear1=$("select[name=searyear1]").val(); //년
	var searmonth1=$("select[name=searmonth1]").val();//월 
	var searday1=$("select[name=searday1]").val();//일


	var searchtxt=(!isEmpty($("input[name=searchtxt]").val())) ? "&searchtxt="+encodeURI($("input[name=searchtxt]").val()) : "";
	
	if(valTitle[3] == "Medicines")//약재보고서에는 년월일을 보내야함 
	{
		data = "searyear="+searyear+"&searmonth="+searmonth+"&searday="+searday+"&searyear1="+searyear+"&searmonth1="+searmonth+"&searday1="+searday+searchtxt+seardata;
	}
	else
	{
		data = "searyear="+searyear+"&searmonth="+searmonth+seardata;
	}

	

	var hdata=location.hash.replace("#","").split("|");
	var medical=hdata[0];
	console.log(hdata);
	console.log(medical);
	if(!isEmpty(medical))
	{	
		data += "&medicalID="+medical;
	}

	console.log("searchsendapi   click :: " + valTitle[3]+"_"+onvalue+", "+ apicode+", data="+data);

	callapi('GET','dashboard',apicode,data);
}

//일자별,요일별,주간별 클릭시 - 주문보거서,조제보고서,처방보고서 
$(".seartyperadio").on("click",function(){

	var before=after="";
	before = $(".searbtn .on").attr("value");

	$(".seartyperadio").removeClass("on");
	$(this).addClass("on");
	after = $(".searbtn .on").attr("value");

	console.log("before = " + before+", after = " + after);

	if(before != after)
	{
		searchsendapi("");

		//일자별,요일별,주간별을 클릭시에 선택한 연령별,성별 select 박스들 초기화 하자 
		var selgender = document.getElementById("gender");
		selgender.selectedIndex = 0;
		var selage = document.getElementById("age");
		selage.selectedIndex = 0;
	}
});
//연령별,성별 select box 클릭시 - 주문보거서,조제보고서,처방보고서 
$(".seartypesel").on("change",function(){

	var gender=$("select[name=gender]").val(); //성별 
	var age=$("select[name=age]").val();//연령별

	gender = !isEmpty(gender) ? gender : "";
	age = !isEmpty(age) ? age : "";

	var seardata="&gender="+gender+"&age="+age;
	console.log("seartypesel searchsendapi  call  seardata = " + seardata );
	searchsendapi(seardata);
});

//약재보고서 > 년을 선택시 
$(".searyearsel").on("change",function(){
	var today = new Date();
	var dd = today.getDate();
	var mm = parseInt(today.getMonth()+1); //January is 0!
	var yyyy = today.getFullYear();
	var selyy=parseInt($("select[name=searyear]").val()); //년  
	console.log("searyearsel  selyy = " + selyy +", yyyy =" + yyyy);
	$("input[name=searchtxt]").val("");
	if(selyy <= yyyy)
	{
		//초기화하여 월을 바꾸자 
		$("#searmonth").html("<option value='all'>월전체</option>");

		$("#searmonth option:eq(0)").prop("selected", "selected"); //월을 전체로 바꾸기 
		$("#searday option:eq(0)").prop("selected", "selected"); //일을 전체로 바꾸기 
		$("#searweekly option:eq(0)").prop("selected", "selected"); // 요일를 전체로 바꾸기 
		$("#searweekday option:eq(0)").prop("selected", "selected"); //주를 전체로 바꾸기 


		var month=12;
		if(yyyy==selyy)
			month=mm;
		for(i=1;i<=month;i++)
		{		
			$("#searmonth").append("<option value='"+i+"'>"+i+"</option>");
		}
		searchsendapi("");
	}

});
//약재보고서 > 월을 선택시 
$(".searmonthsel").on("change",function(){
	var today = new Date();
	var dd = today.getDate();
	var mm = today.getMonth()+1; //January is 0!
	var yyyy = today.getFullYear();
	var selyy=$("select[name=searyear]").val();
	var selmm=$("select[name=searmonth]").val(); //월 
	console.log("searmonthsel  selmm = " + selmm +", mm =" + mm);
	$("input[name=searchtxt]").val("");
	if(selmm == "all") //전체이면 
	{
		$("#searday option:eq(0)").prop("selected", "selected"); //일을 전체로 바꾸기 
		$("#searweekday option:eq(0)").prop("selected", "selected"); //주를 전체로 바꾸기 
		$("#searweekly option:eq(0)").prop("selected", "selected"); // 요일를 전체로 바꾸기 
		searchsendapi("");
	}
	else
	{
		if(parseInt(mm) >= parseInt(selmm))
		{
			//초기화하여 일을 바꾸자 
			$("#searday").html("<option value='all'>일전체</option>");
			$("#searday option:eq(0)").prop("selected", "selected"); //일을 전체로 바꾸기 
			$("#searweekly option:eq(0)").prop("selected", "selected"); // 요일를 전체로 바꾸기 
			$("#searweekday option:eq(0)").prop("selected", "selected"); //주를 전체로 바꾸기 



			//주차에 해당년월의 주차 추가 
			$("#searweekday").html("<option value=''>주전체</option>");
			var lastweek = getWeekCountOfMonth(selyy,selmm);
			for(i=1;i<lastweek;i++)
			{		
				$("#searweekday").append("<option value='"+i+"'>"+i+"주</option>");
			}

			//해당년월의 일 추가 
			var lastdate=new Date(selyy, selmm, 0);
			var lastday = lastdate.getDate();
			var day="";

			if(parseInt(selmm)==parseInt(mm))
				lastday=dd;

			for(i=1;i<=lastday;i++)
			{
				day=pad(i,2);
				$("#searday").append("<option value='"+day+"'>"+i+"</option>");
			}

			searchsendapi("");
		}
	}

});
//약재보고서 > 일을 선택시 
$(".seardaysel").on("change",function(){
	$("input[name=searchtxt]").val("");
	$("#searweekly option:eq(0)").prop("selected", "selected"); // 요일를 전체로 바꾸기 
	$("#searweekday option:eq(0)").prop("selected", "selected"); //주를 전체로 바꾸기 

	searchsendapi("");
});


//약재보고서에서 쓰이는 약재검색 
$(".searchbtn").on("click",function(){
	$("#searweekly option:eq(0)").prop("selected", "selected"); // 요일를 전체로 바꾸기 
	$("#searweekday option:eq(0)").prop("selected", "selected"); //주를 전체로 바꾸기 
	searchsendapi("");
});
//약재명입력텍스트박스에서 엔터키 눌렀을 경우 
function searchEnterkey()
{
	if (window.event.keyCode == 13) 
	{
		$("#searweekly option:eq(0)").prop("selected", "selected"); // 요일를 전체로 바꾸기 
		$("#searweekday option:eq(0)").prop("selected", "selected"); //주를 전체로 바꾸기 
		searchsendapi("");
	}
}

//약재보고서 > 요일 선택시  
$(".searweeklysel").on("change",function(){
	$("input[name=searchtxt]").val("");//텍스트  제거 
	$("#searday option:eq(0)").prop("selected", "selected"); //일을 전체로 바꾸기 
	$("#searweekday option:eq(0)").prop("selected", "selected"); //주를 전체로 바꾸기 
	var weekly=$("select[name=searweekly]").val();
	var seardata="&weekly="+weekly;
	console.log("searweeklysel seardata = " + seardata);
	searchsendapi(seardata);
});

//약재보고서 > 주차 선택시  
$(".searweekdaysel").on("change",function(){
	$("input[name=searchtxt]").val("");//텍스트  제거 
	$("#searweekly option:eq(0)").prop("selected", "selected"); //요일를 전체로 바꾸기 
	$("#searday option:eq(0)").prop("selected", "selected"); //일을 전체로 바꾸기 

	var weekday=$("select[name=searweekday]").val();
	var seardata="&weekday="+weekday;
	console.log("searweekdaysel seardata = " + seardata);
	searchsendapi(seardata);
});



function getWeekCountOfMonth(year,month) 
{		 
	var nowDate = new Date(year, month-1, 1);
	var lastDate = new Date(year, month, 0).getDate();
	var monthSWeek = nowDate.getDay();
 
	var weekSeq = Math.ceil((parseInt(lastDate) + monthSWeek - 1)/7) + 1;
 
	return weekSeq;
}

function loadchart(type,scales)
{
	chartData = chartdata(); //making,orders,medicines,recipes에서 공통으로 쓰임 
	if(scales=="doughnut"){

		chartData1 = chartdata1();
		chartData2 = chartdata2();
		chartData3 = chartdata3();

		myChartData= {
			type: 'doughnut',
			data: chartData,
			options: {
				maintainAspectRatio : false,
				responsive: true,
				legend: {
					display: true,
					position: 'right'
				},
				title: {
					display: true,
					fontSize:30,
					text: '조제'//조제
				},
				tooltips: {
					enabled:false,
				},
				animation: {
					animateScale: true,
					animateRotate: true
				}
			}
		}

		myChartData1= {
			type: 'doughnut',
			data: chartData1,
			options: {
				maintainAspectRatio : false,
				responsive: true,
				legend: {
					display: true,
					position: 'right'
				},
				title: {
					display: true,
					fontSize:30,
					text: '탕전'//탕전
				},
				tooltips: {
					enabled:false,
				},
				animation: {
					animateScale: true,
					animateRotate: true
				}
			}
		}

		myChartData2= {
			type: 'doughnut',
			data: chartData2,
			options: {
				maintainAspectRatio : false,
				responsive: true,
				legend: {
					display: true,
					position: 'right'
				},
				title: {
					display: true,
					fontSize:30,
					text: '마킹'//마킹
				},
				tooltips: {
					enabled:false,
				},
				animation: {
					animateScale: true,
					animateRotate: true
				}
			}
		}

		myChartData3= {
			type: 'doughnut',
			data: chartData3,
			options: {
				maintainAspectRatio : false,
				responsive: true,
				legend: {
					display: true,
					position: 'right'
				},
				title: {
					display: true,
					fontSize:30,
					text: '배송'//배송 
				},
				tooltips: {
					enabled:false,
				},
				animation: {
					animateScale: true,
					animateRotate: true
				}
			}
		}
	}
	else if(scales=="stack"){
		myChartData= {
			type: 'bar',
			data: chartData,
			options: {
				title: {
					display: true,
					text: '주문보고서 - 일자별'
				},
				tooltips: {
					mode: 'index',
					intersect: false
				},
				responsive: true,
				scales: {
					xAxes: [{
						stacked: true
					}],
					yAxes: [{
						stacked: true,
						ticks:{userCallback: function(tick) {
								return tick.toString() + '건';
							}}
					}]
				}
			}
		}
	}else if(scales=="multi"){
		myChartData= {
			type: 'bar',
			data: chartData,
			options: {
				title: {
					display: true,
					text: '조제보고서 - 일자별'
				},
				tooltips: {
					mode: 'index',
					intersect: true
				},
				scales: {
					yAxes: [{
						type: 'linear', // only linear but allow scale type registration. This allows extensions to exist solely for log scale for instance						
						display: true,
						position: 'left',
						id: 'y-axis-1',
						ticks:{min:0,userCallback: function(tick) {
								return tick.toString() + '분';
							}}
					}, {
						type: 'linear', // only linear but allow scale type registration. This allows extensions to exist solely for log scale for instance
						display: true,
						position: 'right',
						id: 'y-axis-2',
						ticks:{min:0,userCallback: function(tick) {
								return tick.toString() + '개';
							}},
						// grid line settings
						gridLines: {
							drawOnChartArea: false, // only want the grid lines for one axis to show up
						}
					}],
				}
			}
		}
	}else if(scales=="linebar"){
		myChartData={
			type: 'bar',
			data: chartData,
			options: {
				responsive: true,
				legend: {
					position: 'top',
				},
				title: {
					display: true,
					text: '처방보고서 - 일자별'
				}
			}
		}
	}else if(scales=="horizon"){
		myChartData = {
			type: 'horizontalBar',
			data: chartData,
			options: {
				elements: {
					rectangle: {
						borderWidth: 2,
					}
				},
				responsive: true,
				legend: {
					position: 'right',
				},
				title: {
					display: true,
					text: '약재보고서 - TOP20'
				}
			}
		}
	}else{
		myChartData=false;
	}

	if(scales=="doughnut")
	{
		var ctx = document.getElementById('canvas').getContext('2d');
		var ctx1 = document.getElementById('canvas1').getContext('2d');
		var ctx2 = document.getElementById('canvas2').getContext('2d');
		var ctx3 = document.getElementById('canvas3').getContext('2d');

		window.myChart = new Chart(ctx, myChartData);
		window.myChart = new Chart(ctx1, myChartData1);
		window.myChart = new Chart(ctx2, myChartData2);
		window.myChart = new Chart(ctx3, myChartData3);

	}
	else
	{
		var ctx = document.getElementById('canvas').getContext('2d');
		if(scales=="line"){
			window.myChart = Chart.Line(ctx, myChartData);
		}else{
			window.myChart = new Chart(ctx, myChartData);
		}
	}
}