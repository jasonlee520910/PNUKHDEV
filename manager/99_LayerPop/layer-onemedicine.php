<?php 
	$root = "..";
	include_once $root."/_common.php";

	$searyear=$_GET["searyear"];
	$searmonth=$_GET["searmonth"];
	$searday=$_GET["searday"];
	$mdcode=$_GET["mdcode"];
	$mdtitle=$_GET["mdtitle"];
	
	$apiData = "searyear=".$searyear."&searmonth=".$searmonth."&searday=".$searday."&mdcode=".$mdcode;

?>
<style>
	#onemeditbll {font-size:11px;}
	#onemeditbll thead tr th{color:#3d434c; border-right:1px solid #e3e3e4; border-bottom:1px solid #e3e3e4; background:#f5f5f6; position:relative;padding:7px 0;text-align:center;font-size:13px;}
	#onemeditbll tbody tr td{padding:3px;border-right:1px solid #e3e3e4;border-bottom:1px solid #e3e3e4;letter-spacing:-1px;font-size:13px;}
</style>
<!-- s: -->
<div class="layer-wrap">
	<div class="layer-top">
		<h2 id="h2_name"><span style="font-size:15px;font-weight:bold;"><?=$mdtitle?> :: </span><span id="onemdtitle"></span></h2>
		<a href="javascript:;" class="close-btn" onclick="closediv('viewlayer')"><span class="blind">닫기</span></a>
	</div>
	<div class="layer-con medical-search">
		<div class="board-view-wrap-pop" style='overflow: auto;height:659px;'>
			<span class="bd-line"></span>
				<table class="subtbl" id="onemeditbll">
					<colgroup>
						<col scope="col" width="17%">
						<col scope="col" width="19%">
						<col scope="col" width="16%">
						<col scope="col" width="16%">
						<col scope="col" width="16%">
						<col scope="col" width="16%">
					</colgroup>
					<thead>
						<tr>
							<th>날짜</th>
							<th>처방명</th>
							<th>처방용량</th>
							<th>조제용량</th>
							<th>차인량</th>
							<th>조제마친시간</th>
						</tr>
					</thead>

					<tbody>
					</tbody>

				</table>
		</div>
		<div class="mg20t c">
			<a href="javascript:;" class="cw-btn close" onclick="closediv('viewlayer')"><span><?=$txtdt["1595"]?><!-- 닫기 --></span></a>
		</div>
	</div>
</div>

<script>
/*
	var spanAlign=spanBefore="";
	function goMakingZeroOrder(orderby)
	{
		if(spanBefore == orderby)
		{
			spanAlign=(spanAlign == "DESC") ? "ASC" : "DESC";
		}
		//▲▼
		if(orderby == 'makingcapa')
		{
			$("#mtspan").text("약재명");
			$("#mdspan").text("처방량");
			if(spanAlign == "DESC")
				$("#maspan").text("조제량(▲)");
			else
				$("#maspan").text("조제량(▼)");

			spanBefore=orderby;
		}
		else if(orderby == 'mdcapa')
		{
			if(spanAlign == "DESC")
				$("#mdspan").text("처방량(▲)");
			else 
				$("#mdspan").text("처방량(▼)");
			$("#mtspan").text("약재명");
			$("#maspan").text("조제량");
			spanBefore=orderby;
		}
		else if(orderby == 'mmTitle')
		{
			if(spanAlign == "DESC")
				$("#mtspan").text("약재명(▲)");
			else 
				$("#mtspan").text("약재명(▼)");
			$("#mdspan").text("처방량");
			$("#maspan").text("조제량");
			spanBefore=orderby;
		}


		var seardate="<?=$seardate?>";		
		var data="seardate="+seardate+"&searorder="+orderby+"&searalign="+spanAlign;
		callapi('GET','dashboard','makingmedizero',data);
	}

	spanAlign="DESC";
	spanBefore="";
	goMakingZeroOrder('makingcapa');
	//callapi('GET','dashboard','makingmedizero','<?=$apiData?>');
*/
	callapi('GET','dashboard','onemedicine','<?=$apiData?>');
</script>
