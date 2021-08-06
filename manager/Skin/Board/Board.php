<?php //공지사항 리스트
$root = "../..";
include_once ($root.'/_common.php');
?>

<style>
	.td_text_overflow {overflow:hidden;white-space : nowrap;text-overflow: ellipsis;}
	span.mdtype{display:inline-block;width:15px;height:15px;border-radius:50%;margin-right:5px;line-height:100%;vertical-align:middle;}
	.mdsweet{background-color:#f2C2D6;}
	.mdmedi{background-color:#8BE0ED;}
	.sugar{background-color:#01DF74;}
</style>
<!--// page start -->
<div id="pagegroup" value="content"></div>
<div id="pagecode" value="faqlist"></div>



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

	<?php
	if($_GET["bb_type"]!="QNA") 
	{
	?>		
		<p class="fr">	
			<button class="btn-blue"><span onclick="viewdesc('add')">+ 등록<?//=$txtdt["1202"]?><!-- 약재등록 --></span></button>
		</p>
	<?php
	}
	?>
	</div>
	<table id="tbllist" class="tblcss" style="table-layout:fixed">
		  <caption><span class="blind"></span></caption>
		  <colgroup>
	<?php  if($_GET["bb_type"]=="QNA") { ?>	
			<col scope="col" width="10%">
			<col scope="col" width="10%">
			<col scope="col" width="*">
			<col scope="col" width="10%">
	<?php }else { ?>
			<col scope="col" width="10%">
			<col scope="col" width="*">
			<col scope="col" width="10%">
	<?php } ?>
  		</colgroup>
		  <thead>
			 <tr>
	<?php  if($_GET["bb_type"]=="QNA") { ?>	
			<th>번호</th>
			<th>답변유무</th>
			<th class='l' style='padding-left:10px;'>제목</th>
			<th>날짜</th>
	<?php }else { ?>
			<th>번호</th>
			<th class='l' style='padding-left:10px;'>제목</th>
			<th>날짜</th>
	<?php } ?>
			  </tr>
		  </thead>
		  <tbody>
		</tbody>
	</table>
</div>

<div class="gap"></div>

<!-- s : 게시판 페이징 -->
<div class='paging-wrap' id="faqlistpage"></div>
<!-- e : 게시판 페이징 -->


<script>
	function repageload(){
	console.log("no  repageload ");
	}

	function makepage(json)
	{
		var obj = JSON.parse(json);

		console.log(obj);

		if(obj["apiCode"]=="boardlist")//공지사항 상세
		{
			var	data="";
			var page=1;

			$("#tbllist tbody").html("");
			if(!isEmpty(obj["list"]))
			{
				page=obj["list"].length;
				$(obj["list"]).each(function( index, value )
				{
					page=parseInt(obj["page"])*page;
					data+="<tr style='cursor:pointer;' onclick=\"viewdesc('"+value["seq"]+"')\" >";
					data+="<td>"+page+"</td>"; //번호
					if(value["bbCode"]=="QNA")
					{
						data+="<td>"+value["chkAnswer"]+"</td>"; //번호
					}
					data+="<td class='l'>"+value["bbTitle"]+"</td>"; //제목
					data+="<td>"+value["bbIndate"]+"</td>"; //날짜
					data+="</tr>";
					page--;
				});
			}
			else
			{
				data+="<tr>";
				data+="<td colspan='3'><?=$txtdt['1665']?></td>";
				data+="</tr>";
			}
			$("#tbllist tbody").html(data);

			$("#pagecnt").text(comma(obj["tcnt"])+" <?=$txtdt['1019']?>");
			getsubpage("faqlistpage",obj["tpage"], obj["page"], obj["block"], obj["psize"], obj["reData"]);
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

	var bb_type=$("input[name=bb_type]").val();
	var apidata="page="+page+"&searchTxt="+encodeURI(searchTxt)+"&bb_type="+bb_type;
	callapi('GET','board','boardlist',apidata);
	$("#searchTxt").focus();
</script>
