<?php //약재목록 리스트
$root = "../..";
include_once ($root.'/_common.php');
?>

<style>
	.td_text_overflow {overflow:hidden;white-space : nowrap;text-overflow: ellipsis;}
	span.mdtype{display:inline-block;width:15px;height:15px;border-radius:50%;margin-right:5px;line-height:100%;vertical-align:middle;}
	.mdsweet{background-color:#f2C2D6;}
	.mdmedi{background-color:#8BE0ED;}
	.sugar{background-color:#01DF74;}
	.alcohol{background-color:#D7BDE2;}
</style>
<!--// page start -->
<div id="pagegroup" value="medicine"></div>
<div id="pagecode" value="medicinelist"></div>

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
				<th><span><?=$txtdt["1020"]?><!-- 검색 --></span></th>
				<td><?=selectsearch()?></td>
			</tr>
		  </tbody>
	</table>
</div>

<div class="gap"></div>

<div class="board-list-wrap">
	<span class="bd-line"></span>
	<div class="list-select">
		<p class="fl">
			<span class="mdtype mdmedi"></span><?=$txtdt["1497"]?><!-- 약재 -->,&nbsp;&nbsp;&nbsp;&nbsp;
			<span class="mdtype mdsweet"></span><?=$txtdt["1115"]?><!-- 별전 -->&nbsp;&nbsp;&nbsp;&nbsp;
			<span class="mdtype sugar"></span><?=$txtdt["1703"]?><!-- 감미제(앰플) -->&nbsp;&nbsp;	
			<span class="mdtype alcohol"></span>청주&nbsp;&nbsp;	
			<span id="pagecnt" class="tcnt"></span>
		</p>
		<?php if($modifyAuth == "true"){?>
			<p class="fr">	
				<button class="btn-blue"><span onclick="viewdesc('add')">+ <?=$txtdt["1202"]?><!-- 약재등록 --></span></button>
			</p>
		<?php }?>
	</div>
	<table id="tbllist" class="tblcss" style="table-layout:fixed">
		  <caption><span class="blind"></span></caption>
		  <colgroup>
			<col scope="col" width="7%">
			<col scope="col" width="7%">
			<col scope="col" width="*%">
			<col scope="col" width="11%">
			<col scope="col" width="11%">
			<col scope="col" width="10%">
			<col scope="col" width="10%">
			<col scope="col" width="8%">
			<col scope="col" width="8%">
			<col scope="col" width="7%">
			<col scope="col" width="5%">
			<col scope="col" width="5%">
  		</colgroup>
		  <thead>
			 <tr>
				<th><?=$txtdt["1131"]?><!-- 본초코드 --></th>
				<th><?=$txtdt["1124"]?><!-- 본초명 --></th>
				<th><?=$txtdt["1213"]?><!-- 약재코드 --></th>
				<th><?=$txtdt["1204"]?>_djmedi</th>	
				<th><?=$txtdt["1204"]?>_client<!-- <?=$txtdt["1725"]?> --><!-- 약재명 --><!-- 디제이메디 --></th>			
				<th><?=$txtdt["1237"]?><!-- 원산지 --></th>
				<th><?=$txtdt["1288"]?><!-- 제조사 --></th>
				<th><?=$txtdt["1282"]?><!-- 재고수량 --></th>
				<th><?=$txtdt["1627"]?><!-- 약재흡수율예외처리 --></th>
				<th><?=$txtdt["1626"]?><!-- 약재흡수율코드 --></th>
				<th><?=$txtdt["1608"]?><!-- 흡수율 --></th>
				<th><?=$txtdt["1383"]?><!-- 판매가격 --></th>			
			  </tr>
		  </thead>
		  <tbody>
		</tbody>
	</table>
</div>

<div class="gap"></div>

<!-- s : 게시판 페이징 -->
<div class='paging-wrap' id="medicinelistpage"></div>
<!-- e : 게시판 페이징 -->


<script>
	function repageload(){
	console.log("no  repageload ");
	}

	function makepage(json)
	{
		var obj = JSON.parse(json);

		console.log(obj);

		if(obj["apiCode"]=="medicinelist")//본초분류관리 상세
		{
			var	data="";

			$("#tbllist tbody").html("");
			if(!isEmpty(obj["list"]))
			{
				$(obj["list"]).each(function( index, value )
				{				
					data+="<tr style='cursor:pointer;' onclick=\"viewdesc('"+value["seq"]+"')\" >";					
					data+="<td>"+value["mhCode"]+"</td>"; //본초코드
					data+="<td class='l'>"+value["mhTitle"]+"</td>"; //본초명
					data+="<td>"+value["mdCode"]+"</td>"; //약재코드
					var cls="";
					if(value["mdType"]=="sweet"){
						cls="mdsweet";
					}else if(value["mdType"]=="medicine"){
						cls="mdmedi";
					}
					else if(value["mdType"]=="sugar"){
						cls="sugar";
					}
					else if(value["mdType"]=="alcohol"){
						cls="alcohol";
					}
					

					var mmtitlename="";
					if(!isEmpty(value["mmtitle"]))
					{
						mmtitlename=value["mmtitle"];					
					}
					else
					{
						mmtitlename='-';					
					}
					data+="<td class='l'>"+"<span class=' mdtype "+cls+"'></span> "+value["mdTitle"]+"</td>"; //약재명_djmedi
					data+="<td class='l'>"+mmtitlename+"</td>"; //약재명_디제이메디
					data+="<td class='l'>"+value["mdOrigin"]+"</td>"; //원산지
					data+="<td class='l'>"+value["mdMaker"]+"</td>"; //제조사
					data+="<td class='r'>"+value["mdQty"]+"</td>"; //제조사
					data+="<td>"+value["mdWaterchk"]+"</td>"; //약재흡수율예외처리
					data+="<td>"+value["mdwatername"]+"</td>"; //약재흡수율코드
					data+="<td>"+value["mdWater"]+"</td>"; //흡수율	
					data+="<td class='r'>"+value["mdPrice"]+"</td>"; //판매가격				
					data+="</tr>";
				});
			}
			else
			{
				data+="<tr>";
				data+="<td colspan='12'><?=$txtdt['1665']?></td>";
				data+="</tr>";
			}
			$("#tbllist tbody").html(data);

			$("#pagecnt").text(comma(obj["tcnt"])+" <?=$txtdt['1019']?>");
			getsubpage("medicinelistpage",obj["tpage"], obj["page"], obj["block"], obj["psize"], obj["reData"]);
			return false;
		}
	}
	//약재목록  API 호출
	var hdata=location.hash.replace("#","").split("|");
	var page=hdata[0];
	//searchTxt=1&searchStatus=
	var search=hdata[2];
	if(page==undefined){
		page=1;
	}

	if(search==undefined || search==""){
		var searchTxt="";
	}else{
		var sarr=search.split("&");
		if(sarr[0]!=undefined)var sarr1=sarr[0].split("=");
		if(sarr[1]!=undefined)var sarr2=sarr[1].split("=");
		if(sarr1[1]!=undefined)var searchTxt=sarr1[1];
		//if(sarr2[1]!=undefined)var searchStatus=sarr2[1];
		$("input[name=searchTxt]").val(decodeURI(searchTxt));
	}
	var apidata="page="+page+"&searchTxt="+encodeURI(searchTxt);
	callapi('GET','medicine','medicinelist',apidata);
	$("#searchTxt").focus();
</script>
