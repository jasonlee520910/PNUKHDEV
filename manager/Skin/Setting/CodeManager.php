<?php //CodeManager
	$root = "../..";
	include_once ($root.'/_common.php');

	//echo $apidata;
	$pagegroup = "setting";
	$pagecode = "codelist";
?>
<div id="pagegroup" value="<?=$pagegroup?>"></div>
<div id="pagecode" value="<?=$pagecode?>"></div>
<input type="hidden" name="apiCode" class="reqdata" value="codeupdate">
<input type="hidden" name="returnData" class="reqdata" value="<?=$root?>/Skin/Setting/CodeManager.php">

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
		<p class="fl"></p>
		<p class="fr">
			<a href="javascript:;" onclick="viewdesc('add')";"><button class="btn-blue"><span>+ <?=$txtdt["1036"]?><!-- 그룹코드추가 --></span></button></a>
		</p>
	</div>
	<table id="tbllist" class="tblcss">
		  <caption><span class="blind">번호,분류,내용,담당자,등록일,완료예정일,완료일,중요도,상태를 나타내는 이슈관리 테이블 입니다.</span></caption>
		  <colgroup>
			 <col scope="col" width="20%">
			 <col scope="col" width="15%">
			 <col scope="col" width="15%">
			 <col scope="col" width="*">
			 <col scope="col" width="15%">
		  </colgroup>
		  <thead>
			 <tr>
				  <th><?=$txtdt["1035"]?><!-- 그룹코드명 --></th>
				  <th><?=$txtdt["1034"]?><!-- 그룹코드 --></th>
				  <th><?=$txtdt["1168"]?><!-- 서브코드갯수 --></th>
				  <th><?=$txtdt["1358"]?><!-- 코드설명 --></th>
				  <th><?=$txtdt["1072"]?><!-- 등록일 --></th>
			  </tr>
		  </thead>
		  <tbody>
			  
		</tbody>
	</table>
</div>
<div class="gap"></div>
<!-- s : 게시판 페이징 -->
<div class='' id="textdblistpage"></div>
<!-- e : 게시판 페이징 -->

<!--// page end -->

<script>
	function repageload(){
	console.log("no  repageload ");
	}

	function makepage(json)
	{
		var obj = JSON.parse(json);
		console.log(obj);
		var data="";
		if(obj["apiCode"]=="codelist")
		{			
			$("#tbllist tbody").html("");
			data="";
			if(!isEmpty(obj["list"]))
			{
				$(obj["list"]).each(function( index, value )
				{
					data+="<tr style='cursor:pointer;' onclick=\"viewdesc('"+value["cdType"]+"')\">";
					data+="<td><a href='javascript:;'>"+value["cdTypeTxt"]+"</a></td>"; //그룹코드명
					data+="<td>"+value["cdType"]+"</td>"; //그룹코드
					data+="<td>"+value["cdSubcnt"]+"</td>";//서브코드갯수
					data+="<td>"+value["cdDesc"]+"</td>"; //코드설명
					data+="<td>"+value["cdDate"]+"</td>"; //등록일 
					data+="</tr>";				
				});
			}
			else
			{
				data+="<tr>";
				data+="<td colspan='5'><?=$txtdt['1665']?></td>";
				data+="</tr>";
			}
			$("#tbllist tbody").html(data);

			$("#pagecnt").text(comma(obj["tcnt"])+" <?=$txtdt['1019']?>");
			getsubpage("textdblistpage",obj["tpage"], obj["page"], obj["block"], obj["psize"]);
		}
		return false;
	}

	//약재출고 리스트  API 호출
	var hdata=location.hash.replace("#","").split("|");
	var page=hdata[0];
	var apiOrderData="";
	var search=hdata[2];
	//console.log("search     :"+search);
	if(page==undefined){
		page=1;
	}

	if(search==undefined || search==""){
		var searchTxt="";
	}else{
		var sarr=search.split("&");
		if(sarr[0]!=undefined)var sarr1=sarr[0].split("=");	
		if(sarr[1]!=undefined)var sarr2=sarr[1].split("=");	//검색단어		
		if(sarr1[1]!=undefined)var searchTxt=sarr1[1]; //검색단어	
		$("input[name=searchTxt]").val(decodeURI(searchTxt));
		apiOrderData="&searchTxt="+searchTxt;
	}

	var apidata="page="+page+apiOrderData;
	//console.log("apidata     : "+apidata);
	callapi('GET','<?=$pagegroup?>','<?=$pagecode?>',apidata); 	
	
$("input[name=searchTxt]").focus();
</script>
