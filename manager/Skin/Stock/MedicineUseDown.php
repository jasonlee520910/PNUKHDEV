<?php //재고관리>약재사용다운로드
$root = "../..";
include_once ($root.'/_common.php');
?>

<script>
    $(document).ready(function(){
        setDateBox();
    });  

    function setDateBox()
	{
		//오늘날짜를 기본값으로 함
		var data=getNowFull(4);
		var year = data.substr(0,4);
		var month = data.substr(4,2);
		var day = data.substr(6,2);

		var selected="";
        var dt = new Date();
        var com_year = dt.getFullYear();
		
        for(var i = com_year; i <= (com_year+10); i++)
		{
			if(i==year){selected=" selected";}else{selected=" ";}
            $("#YEAR").append("<option value='"+ i +"' "+selected+" >"+ i + " 년" +"</option>");
			$("#sdateyear").append("<option value='"+ i +"' "+selected+" >"+ i + " 년" +"</option>");
			$("#edateyear").append("<option value='"+ i +"' "+selected+" >"+ i + " 년" +"</option>");
        }
		
        for(var i = 1; i <= 12; i++)
		{			
			if(i==month){selected=" selected";}else{selected=" ";}
            $("#MONTH").append("<option value='"+ i +"' "+selected+" >"+ i + " 월" +"</option>");
			$("#sdatemonth").append("<option value='"+ i +"' "+selected+" >"+ i + " 월" +"</option>");
			$("#edatemonth").append("<option value='"+ i +"' "+selected+" >"+ i + " 월" +"</option>");
        }
 
        for(var i = 1; i <= 31; i++)
		{			
			if(i==day){selected=" selected";}else{selected=" ";}
            $("#Day").append("<option value='"+ i +"' "+selected+" >"+ i + " 일" +"</option>");
			$("#sdateday").append("<option value='"+ i +"' "+selected+" >"+ i + " 일" +"</option>");
			$("#edateday").append("<option value='"+ i +"' "+selected+" >"+ i + " 일" +"</option>");

        }
    }
</script>

<style>
#DownloadBtn{background:#0e98c0;border:1px solid #0f7d9d;padding:5px 10px;vertical-align:top;font-weight:500;font-size:13px;color:#fff;margin-right:330px;}
</style>

<!--// page start -->
<input type="hidden" name="today" value="">
<input type="hidden" name="sdate" value="">
<input type="hidden" name="edate" value="">

<div class="board-view-wrap">
	<span class="bd-line"></span>
	<table>
		  <caption><span class="blind"></span></caption>
		  <colgroup>
			  <col width="180">
			  <col width="*">
		  </colgroup>
		  <tbody>
			<tr>
				<th><span><?=$txtdt["1038"]?><!-- 기간선택 --></span></th>
				<td class="selperiod">		
					<select name="YEAR" id="YEAR" onchange="newlist();" ></select>    
					<select name="MONTH" id="MONTH" onchange="newlist();" ></select>
					<select name="Day" id="Day" onchange="newlist();"></select>
					<p class="fr">
						<a href="javascript:;" onclick="Download();">
							<button id="DownloadBtn" class="btn-blue"><span>Excel Download</span></button>
						</a>
					</p>
				</td>
				<td>
					<select name="sdateyear" id="sdateyear"  onchange="periodnewlist();" ></select>    
					<select name="sdatemonth" id="sdatemonth"  onchange="periodnewlist();" ></select>
					<select name="sdateday" id="sdateday"  onchange="periodnewlist();"></select>
					 ~ 
					<select name="edateyear" id="edateyear"   onchange="periodnewlist();" ></select>    
					<select name="edatemonth" id="edatemonth"  onchange="periodnewlist();" ></select>
					<select name="edateday" id="edateday"  onchange="periodnewlist();"></select>
					<p class="fr" style="margin-right:100px;margin-top:3px;">
						<button type="button" class="sp-btn" onclick="periodDownload();">Period Download</button>
					</p>					
				</td>
			</tr> 
		  </tbody>
	</table>
</div>
<div class="gap"></div>

<div class="board-list-wrap">
	<span class="bd-line"></span>
	<div class="list-select">
	<span id="pagecnt" class="tcnt" style="float:left"></span>
		<!-- <p class="fr">
			<a href="javascript:;" onclick="Download();"><button class="btn-blue"><span>excel Download</span></button></a>
		</p> -->
	</div>
	<table id="tbllist" class="tblcss">
		  <caption><span class="blind"></span></caption>
		  <colgroup>
			 <col scope="col" width="8%">
			 <col scope="col" width="*">
			 <col scope="col" width="10%">
			 <col scope="col" width="10%">
			 <col scope="col" width="12%">
			 <col scope="col" width="10%">
			 <col scope="col" width="10%">
			 <col scope="col" width="10%">
			 <col scope="col" width="8%">
			 <col scope="col" width="8%">
		  </colgroup>
		  <thead>
			 <tr>
				  <th><?=$txtdt["1893"]?><!-- 조제일 --></th>
				  <th><?=$txtdt["1460"]?><!-- 한의원명 --></th>
				  <th><?=$txtdt["1894"]?><!-- 약재이름 --></th>
				  <th><?=$txtdt["1895"]?><!-- 규격 --></th>
				  <th><?=$txtdt["1620"]?><!-- 수량  --></th>
				  <th><?=$txtdt["1589"]?><!-- 단가  --></th>
				  <th><?=$txtdt["1896"]?><!-- 공급가액  --></th>
				  <th><?=$txtdt["1897"]?><!-- 세액  --></th>
				  <th><?=$txtdt["1898"]?><!-- 합계금액  --></th>
				  <th><?=$txtdt["1887"]?><!-- 환자명   --></th>
			  </tr>
		  </thead>
		  <tbody>	
		  </tbody>
	  </table>
</div>
<div class="gap"></div>
<!--// page end -->

<script>
	function periodDownload()
	{	
		var sdateperiod = $("input[name=sdate]").val();
		var edateperiod = $("input[name=edate]").val();

		if(sdateperiod<=edateperiod)
		{
			var exdata="sdate="+sdateperiod+"&edate="+edateperiod;
			console.log(exdata);

			$("#tbllist tbody").append("<iframe id='workframe' name='workframe' style='position:fixed;display:none;width:99%;height:0;bottom:0;background:#fff;'></iframe>");
			$("#workframe").attr("src","https://api.the-han.co.kr/manager/_module/PHP_EXCEL/exceldownload.php?"+exdata);
		}
		else
		{
			alert("<?=$txtdt['1899']?>");  //시작일이 종료일보다 늦을수없습니다. 날짜를 다시 확인해주세요
		}
	}

	function Download()
	{	
		var sdateperiod = $("input[name=today]").val();
		var edateperiod = $("input[name=today]").val();

		var exdata="sdate="+sdateperiod+"&edate="+edateperiod;
		console.log(exdata);

		$("#tbllist tbody").append("<iframe id='workframe' name='workframe' style='position:fixed;display:none;width:99%;height:0;bottom:0;background:#fff;'></iframe>");
		$("#workframe").attr("src","https://api.the-han.co.kr/manager/_module/PHP_EXCEL/exceldownload.php?"+exdata);
	}


	//해당하는 날짜에 callapi(화면에 뿌려지는 내용)
	function newlist()
	{
		var yeardata= $("select[name=YEAR]").val();
		var monthdata= $("select[name=MONTH]").val();
		var daydata= $("select[name=Day]").val();

		if(monthdata.length=='1'){var newmonthdata="0"+monthdata;}else{newmonthdata=monthdata;}
		if(daydata.length=='1'){var newdaydata="0"+daydata;}else{newdaydata=daydata;}

		var apidata="date="+yeardata+"-"+newmonthdata+"-"+newdaydata;
		console.log("apidata     : "+apidata); 

		$("input[name=today]").val(yeardata+"-"+newmonthdata+"-"+newdaydata); 
		callapi('GET','stock','medicineuselist',apidata); 
	}

	function periodnewlist()
	{
		var sdateyear= $("select[name=sdateyear]").val();
		var sdatemonth= $("select[name=sdatemonth]").val();
		var sdateday= $("select[name=sdateday]").val();

		var edateyear= $("select[name=edateyear]").val();
		var edatemonth= $("select[name=edatemonth]").val();
		var edateday= $("select[name=edateday]").val();

		if(sdatemonth.length=='1'){var newsdatemonth="0"+sdatemonth;}else{newsdatemonth=sdatemonth;}
		if(sdateday.length=='1'){var newsdateday="0"+sdateday;}else{newsdateday=sdateday;}

		if(edatemonth.length=='1'){var newedateyear="0"+edatemonth;}else{newedateyear=edatemonth;}
		if(edateday.length=='1'){var newedateday="0"+edateday;}else{newedateday=edateday;}

		$("input[name=sdate]").val(sdateyear+"-"+newsdatemonth+"-"+newsdateday); 
		$("input[name=edate]").val(edateyear+"-"+newedateyear+"-"+newedateday); 
	}

	function makepage(json)
	{
		var obj = JSON.parse(json);
		console.log(obj);
		
		if(obj["apiCode"] == "medicineuselist")
		{
			var data=mtitle=price=remain=mbcode="";
			$("#tbllist tbody").html("");
			if(!isEmpty(obj["list"]))
			{
				$(obj["list"]).each(function( index, value )
				{
					data+="<tr>";
					data+="<td>"+value["maEnd"]+"</td>"; //조제일 
					data+="<td>"+value["miName"]+"</td>"; //한의원명 
					data+="<td>"+value["medivalue"]+"</td>"; //약재이름 
					data+="<td>"+"1g"+"</td>"; //규격 
					data+="<td>"+comma(value["totalvalue"])+"</td>"; //수량 
					data+="<td>"+value["medicode"]+"</td>"; //단가 
					data+="<td>"+comma(value["value"])+"</td>"; //공급가액 
					data+="<td>"+comma(value["taxvalue"])+"</td>"; //세액 
					data+="<td>"+comma(value["cntvalue"])+"</td>"; //합계금액 
					data+="<td>"+value["odName"]+"</td>"; //환자명 
					data+="</tr>";
				});
			}
			else
			{
				data+="<tr>";
				data+="	<td colspan='10'><?=$txtdt['1665']?></td>";
				data+="</tr>";
			}
			$("#tbllist tbody").html(data);
		}		
		return false;
	}

	//약재사용 리스트  API 호출
	newlist();

	var yeardata= $("select[name=YEAR]").val();
	var monthdata= $("select[name=MONTH]").val();
	var daydata= $("select[name=Day]").val();

	if(monthdata.length=='1'){var newmonthdata="0"+monthdata;}else{newmonthdata=monthdata;}
	if(daydata.length=='1'){var newdaydata="0"+daydata;}else{newdaydata=daydata;}

	$("input[name=sdate]").val(yeardata+"-"+newmonthdata+"-"+newdaydata); 
	$("input[name=edate]").val(yeardata+"-"+newmonthdata+"-"+newdaydata); 
</script>
