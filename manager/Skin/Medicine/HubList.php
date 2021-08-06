<?php //본초리스트
$root = "../..";
include_once ($root.'/_common.php');
?>

<!--// page start -->
<style>
	td.thumb img{max-width:90%;max-height:50px;}
	.infotxt{overflow:hidden;text-overflow:ellipsis;white-space:nowrap;width:100px;height:20px;}
</style>

<div id="pagegroup" value="medicine"></div>
<div id="pagecode" value="hublist"></div>

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
	<span id="pagecnt" class="tcnt"></span>
		<?php if($modifyAuth == "true"){?>
			<p class="fr">
				<button class="btn-blue"><span onclick="viewdesc('add')">+ <?=$txtdt["1428"]?><!-- 본초등록 --></span></button>
			</p>
		<?php }?>
	</div>
	<table id="tbllist" class="tblcss">
		<caption><span class="blind"></span></caption>
		<colgroup>
			<col scope="col" width="7%">
			<col scope="col" width="7%">
			<col scope="col" width="7%">
			<col scope="col" width="7%">
			<col scope="col" width="7%">
			<col scope="col" width="10%">
			<col scope="col" width="15%">
			<col scope="col" width="7%">
			<col scope="col" width="">
		</colgroup>
		<thead>
			<tr>
				<th><?=$txtdt["1247"]?><!-- 이미지 --></th>
				<th><?=$txtdt["1131"]?><!-- 본초코드 --></th>
				<th><?=$txtdt["1124"]?><!-- 본초명 --></th>
				<th><?=$txtdt["1175"]?><!-- 성--></th>	
				<th><?=$txtdt["1090"]?><!-- 미 --></th>		
				<th><?=$txtdt["1032"]?><!-- 귀경 --></th>		
				<!-- <th><?=$txtdt["1400"]?><!-- 학명 --></th> 
				<!-- <th><?=$txtdt["1028"]?><!-- 과명 --></th> 
				<th><?=$txtdt["1116"]?><!-- 별칭 --></th>
				<th><?=$txtdt["1064"]?><!-- 독성 --></th>
				<th><?=$txtdt["1418"]?><!-- 효능/효과 --></th>
			</tr>
		</thead>
		<tbody>
		</tbody>
	</table>
</div>

<div class="gap"></div>

<!-- s : 게시판 페이징 -->
<div class='paging-wrap' id="hublistpage"></div>
<!-- e : 게시판 페이징 -->

<script>
	function repageload()
	{
		console.log("no  repageload  scrollTop");
		//페이지 넘어갈때 스크롤위로
		$('html, body').stop().animate( { scrollTop : '80' } ); //헤더메뉴만 안보이고 위로 올라가게 위치 조정
	}

	function makepage(json)
	{
		$("#tbllist tbody").html("");
		var obj = JSON.parse(json);
		console.log(obj);

		if(obj["apiCode"]=="hublist")//본초분류관리 상세
		{
			var	data="";
			var afFile=afThumbUrl="NoIMG";
			$("#tbllist tbody").html("");
			if(!isEmpty(obj["list"]))
			{
				$(obj["list"]).each(function( index, value )
				{
					afFile = "<img src='<?=$root?>/_Img/Content/noimg.png'>";
					if(value["afFile"]!="NoIMG")
					{
						afFile = "<img src='"+getUrlData("FILE_DOMAIN")+value["afFile"]+"' onerror=\"this.src='<?=$root?>/_Img/Content/noimg.png'\" >";
					}
					afThumbUrl = "<img src='<?=$root?>/_Img/Content/noimg.png'>";
					if(value["afThumbUrl"]!="NoIMG")
					{
						afThumbUrl = "<img src='"+getUrlData("FILE_DOMAIN")+value["afThumbUrl"]+"' onerror=\"this.src='<?=$root?>/_Img/Content/noimg.png'\" >";
					}
					
					data+="<tr style='cursor:pointer;' onclick=\"viewdesc('"+value["seq"]+"')\" >";					
					//data+="<td class='l'>"+value["mhCode"]+"</td>";							
					data+="<td class='thumb'>"+afThumbUrl+"</td>"; //이미지
					data+="<td>"+value["mhCode"]+"</td>";//본초코드
					data+="<td class='l infotxt'>"+value["mhTitle"]+"</td>";//본초명
					//data+="<td class='l'>"+value["mhStitle"]+"</td>"; //학명
					data+="<td class='l'>"+value["mhStatetext"]+"</td>"; //성
					data+="<td class='l'>"+value["mhTastetext"]+"</td>"; //미
					data+="<td class='l infotxt'>"+value["mhObjecttext"]+"</td>"; //귀경
					data+="<td class='l infotxt'>"+value["mhDtitle"]+"</td>"; //별칭
					data+="<td class='l'>"+value["mhPoisonText"]+"</td>"; //독성
					data+="<td class='l infotxt'>"+value["mhEfficacy"]+"</td>"; //효능/효과
					data+="</tr>";
				});
			}
			else
			{
				data+="<tr>";
				data+="<td colspan='9'><?=$txtdt['1665']?></td>";
				data+="</tr>";
			}

			$("#tbllist tbody").html(data);
			
			$("#pagecnt").text(comma(obj["tcnt"])+" <?=$txtdt['1019']?>");
			getsubpage("hublistpage",obj["tpage"], obj["page"], obj["block"], obj["psize"]);
		return false;
		}
	}

	//본초정보 API 호출

	var hdata=location.hash.replace("#","").split("|");
	var page=hdata[0];
	//searchTxt=1&searchStatus=
	var search=hdata[2];
	if(page==undefined){
		page=1;
	}

	if(search==undefined || search=="")
	{
		var searchTxt="";  
	}
	else
	{
		var sarr=search.split("&");
		if(sarr[0]!=undefined)var sarr1=sarr[0].split("=");
		if(sarr[1]!=undefined)var sarr2=sarr[1].split("=");
		if(sarr1[1]!=undefined)var searchTxt=sarr1[1];
		//if(sarr2[1]!=undefined)var searchStatus=sarr2[1];
		$("input[name=searchTxt]").val(decodeURI(searchTxt));
	}
	var apidata="page="+page+"&searchTxt="+(searchTxt);

	callapi('GET','medicine','hublist',apidata);
	$("#searchTxt").focus();

	//본초 상세 내용 출력
	/*
	$(".reqsearch").on("click",function()
	{
		var url=getseardata();
		gopage(url);
	});
*/
</script>
