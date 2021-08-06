<?php 
	$root = "..";
	include_once $root."/_common.php";

	$seardate=$_GET["seardate"];
	$apiData = "seardate=".$seardate;

?>
<style>
	#mkzerotbll {font-size:11px;}
	#mkzerotbll thead tr th{color:#3d434c; border-right:1px solid #e3e3e4; border-bottom:1px solid #e3e3e4; background:#f5f5f6; position:relative;padding:7px 0;text-align:center;font-size:12px;}
	#mkzerotbll tbody tr td{padding:3px;border-right:1px solid #e3e3e4;}
</style>
<!-- s: -->
<div class="layer-wrap">
	<div class="layer-top">
		<h2 id="h2_name">약재목록 - <?=$seardate?></h2>
		<a href="javascript:;" class="close-btn" onclick="closediv('viewlayer')"><span class="blind">닫기</span></a>
	</div>
	<div class="layer-con medical-search">
		<div class="board-view-wrap" style='overflow: auto;height:557px;'>
			<span class="bd-line"></span>
				<table class="subtbl" id="mkzerotbll">
					<colgroup>
						<col scope="col" width="25%">
						<col scope="col" width="25%">
						<col scope="col" width="25%">
						<col scope="col" width="25%">
					</colgroup>
					<thead>
						<tr>
							<th><span class='link' onclick="goMakingZeroOrder('mmTitle')" id="mtspan">약재명</span></th>
							<th><span class='link' onclick="goMakingZeroOrder('mdcapa')" id="mdspan">처방량</span></th>
							<th><span class='link' onclick="goMakingZeroOrder('makingcapa')" id="maspan">조제량</span></th>
							<th>차인량</th>
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
</script>
