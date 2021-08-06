<?php //제품등록(약속처방)
	$root = "../..";
	include_once $root."/_common.php";
	$upload=$root."/_module/upload";
	include_once $upload."/upload.lib.php";
if($_GET["seq"]=="add"){
	$apidata="seq=";
	$seq="";
}else{
	$apidata="seq=".$_GET["seq"];
	$seq=$_GET["seq"];
}
?>
<script  type="text/javascript" src="<?=$root?>/cmmJs/jquery/jquery.form.min.js"></script>
<link rel="stylesheet" media="all" href="<?=$upload?>/upload.css?v=<?php echo time();?>" />
<script  type="text/javascript" src="<?=$upload?>/upload.js?v=<?=time()?>"></script>

<!--// page start -->

<input type="hidden" name="seq" class="reqdata" value="<?=$_GET["seq"]?>">
<input type="hidden" name="returnData" class="reqdata" value="<?=$root?>/Skin/Goods/Goods.php">

<div class="board-view-wrap" id="notorigin">
	<span class="bd-line"></span>
	<table>
		<caption><span class="blind"></span></caption>
		<colgroup>
			<col width="10%">
			<col width="40%">
			<col width="10%">
			<col width="40%">
		</colgroup>
		<tbody>
			<tr>
				<th><span class=""><?=$txtdt["1132"]?><!-- 분류---></span></th>
				<td id="gdTypeDiv"></td>
				<th><span class=""><?=$txtdt["1932"]?><!-- 상세분류 ---></span></th>
				<td id="gdCategoryDiv"></td>
			</tr>
			<tr>
				<th><span class=""><?=$txtdt["1926"]?><!-- 제품코드 --></span></th>			
				<td id="gdCodeDiv"></td>			
				<th rowspan="5" style="vertical-align:top;"><span class=""><?=$txtdt["1929"]?><!-- 구성요소---></span></th>	
				<td rowspan="5" id="BomDiv" style="vertical-align:top;"> 
					<table id="bomcodelist" style="border-top:1px solid #ddd;border-right:1px solid #ddd;">
					<div id="elementDiv"></div>
						<colgroup>
							<col width="25%"/> 
							<col width="25%"/> 
							<col width="40%"/>
							<col width="10%"/>
						</colgroup>
						<thead>
						</thead>
						<tbody>
						</tbody>
					</table>
				</td>
			</tr>
			<tr>
				<th><span class=""><?=$txtdt["1928"]?><!-- 제품명---></span></th>
				<td id="gdNameKorDiv"></td>
			</tr>
			<tr>
				<th><span class=""><?=$txtdt["1927"]?><!-- 기준량 --></span></th>
				<td id="gdUnitDiv"></td>
			</tr>
			<tr>
				<th><span class=""><?=$txtdt["1549"]?><!-- 적정수량 --></span></th>
				<td id="gdStableDiv"></td>
			</tr>
			<tr>
				<th><span class=""><?=$txtdt["1931"]?><!-- 로스율 --></span></th>
				<td id="gdLossDiv"></td>
			</tr> 
			<!-- <tr>
				<th><span class=""><?=$txtdt["1144"]?><!-- 사용 --></span></th>
				<!-- <td id="gdUseDiv"></td>
			</tr>  -->
			<tr>
				<th><span><?=$txtdt["1173"]?><!-- 설명----></span></th>				
				<td colspan="3" id="gdDescDiv" style="height: 100px;"></td>
			</tr>
			<tr>
				<th><span><?=$txtdt["1935"]?><!-- 제품사진 ----></span></th>
				<td colspan="3" id="" style="height: 100px;"><?=upload("goods",$_COOKIE["ck_stStaffid"],$_COOKIE["ck_language"])?></td>
			</tr>
		</tbody>
	</table>

	<div class="gap"></div>

	<div class="btn-box c">
		<a href="javascript:;" onclick="viewlist();" class="bw-btn"><span><?=$txtdt["1087"]?></span></a>
		<a href="javascript:goods_del();" class="bdp-btn"><span><?=$txtdt["1154"]?></span></a>
	</div>
</div>
<!--// page end -->

<script>
	//삭제
	function goods_del()
	{
		var data = "seq="+$("input[name=seq]").val();
		var url = encodeURI($("input[name=returnData]").val());
		$("input[name=returnData]").val(url);
		console.log("1111111111"+data);
		callapidel('goods','goodsdelete',data);
		return false;
	}

	//구성요소 보여주기
	function viewbomcodeList(bomcodeList)
	{
console.log("==========bomcodeList");
console.log(bomcodeList);
		var data="";	

		if(isEmpty())
		{		
			//원재료
			var list=bomcodeList["medicine"];
			for(var key in list)
			{
				data+="<tr id='tr"+list[key]["bomseq"]+"');\">";
				data+="<td>"+list[key]["gdTypename"]+"</td>";  
				data+="<td>"+list[key]["bomcode"]+"</td>"; //코드
				data+="<td>"+list[key]["bomtext"]+"</td>"; //재료명
				data+="<td>"+list[key]["bomcapa"]+"</td>";  //용량
				data+="</tr>";
			}
			
			//제품
			list=bomcodeList["goods"];
			for(var key in list)
			{
				data+="<tr id='tr"+list[key]["bomseq"]+"');\">";
				data+="<td>"+list[key]["gdTypename"]+"</td>";  
				data+="<td>"+list[key]["bomcode"]+"</td>"; //코드
				data+="<td>"+list[key]["bomtext"]+"</td>"; //재료명
				data+="<td>"+list[key]["bomcapa"]+"</td>";  //용량
				data+="</tr>";
			}

			//반제품
			list=bomcodeList["pregoods"];
			for(var key in list)
			{
				data+="<tr id='tr"+list[key]["bomseq"]+"');\">";
				data+="<td>"+list[key]["gdTypename"]+"</td>";  
				data+="<td>"+list[key]["bomcode"]+"</td>"; //코드
				data+="<td>"+list[key]["bomtext"]+"</td>"; //재료명
				data+="<td>"+list[key]["bomcapa"]+"</td>";  //용량
				data+="</tr>";
			}

			//실속
			list=bomcodeList["worthy"];
			for(var key in list)
			{
				data+="<tr id='tr"+list[key]["bomseq"]+"');\">";
				data+="<td>"+list[key]["gdTypename"]+"</td>";  
				data+="<td>"+list[key]["bomcode"]+"</td>"; //코드
				data+="<td>"+list[key]["bomtext"]+"</td>"; //재료명
				data+="<td>"+list[key]["bomcapa"]+"</td>";  //용량
				data+="</tr>";
			}
		}
		/*
		for(var key in bomcodeList)
		{
			//data+="<tr id='tr"+bomcodeList[key]["bomseq"]+"' onclick=\"viewGoods("+bomcodeList[key]["bomseq"]+",'"+encodeURI(bomcodeList[key]["gdTypename"])+"');\">";
			data+="<tr id='tr"+bomcodeList[key]["bomseq"]+"');\">";
			data+="<td>"+bomcodeList[key]["gdTypename"]+"</td>";  
			data+="<td>"+bomcodeList[key]["bomcode"]+"</td>"; //코드
			data+="<td>"+bomcodeList[key]["bomtext"]+"</td>"; //재료명
			data+="<td>"+bomcodeList[key]["bomcapa"]+"</td>";  //용량
			data+="</tr>";
		}
		*/
		$("#bomcodelist tbody").html(data);
	}

    function makepage(json)
    {
		console.log("makepage ----------------------------------------------- start")
		var obj = JSON.parse(json);
		console.log(obj)
		console.log("apiCode : " + obj["apiCode"])

		if(obj["apiCode"]=="goodsgoodsdesc") 
		{
			$("#gdTypeDiv").text(obj["gdTypeDiv"]);  //분류
			$("#gdCodeDiv").text(obj["gdCode"]);  //제품코드
			$("#gdNameKorDiv").text(obj["gdNameKor"]);	//제품명
			$("#gdUnitDiv").text(obj["gdUnit"]); //기준량
			$("#gdStableDiv").text(obj["gdStable"]); //적정수량
			$("#gdLossDiv").text(obj["gdLoss"]);	//로스율			
			$("#gdUnitDiv").text(obj["gdUnit"]); //로스율
			$("#gdUseDiv").text(obj["gdUse"]); //사용
			$("#gdDescDiv").text(obj["gdDesc"]); //설명

			viewbomcodeList(obj["bomcodeList"]); //구성요소

			getListData("gdTypeDiv", obj["gdTypeList"],obj["gdType"]); //제품분류

			if(obj["gdCategory"])
			{
				getListData("gdCategoryDiv", obj["gdCategoryList"],obj["gdCategory"]); //반제품의 상세분류
			}
			else
			{
				$('#gdCategoryDiv').text('반제품만 상세분류가 있습니다.');
			}	

			setFileCode("goods", obj["gdCode"], obj["seq"]);
			//upload된 이미지가 있다면
			if(!isEmpty(obj["afFiles"]))
			{
				handleImgFileSelect(obj["afFiles"]);
			}
		}

        return false;
    }

	callapi('GET','goods','goodsgoodsdesc','<?=$apidata?>'); 	
</script>
