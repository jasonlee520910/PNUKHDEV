<?php //CodeManager
	$root = "../..";
	include_once ($root.'/_common.php');

	//echo $apidata;
	$pagegroup = "setting";
	$pagecode = "policylist";






















?>
<div id="pagegroup" value="<?=$pagegroup?>"></div>
<div id="pagecode" value="<?=$pagecode?>"></div>
<input type="hidden" name="apiCode" class="reqdata" value="codeupdate">
<input type="hidden" name="returnData" class="reqdata" value="<?=$root?>/Skin/Setting/Policy.php">

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
			<a href="javascript:;" onclick="viewdesc('add')";"><button class="btn-blue"><span>+ 개인정보처리방침추가</span></button></a>
		</p>
	</div>
	<table id="tbllist" class="tblcss">
		  <caption><span class="blind">번호,분류,내용,담당자,등록일,완료예정일,완료일,중요도,상태를 나타내는 이슈관리 테이블 입니다.</span></caption>
		  <colgroup>			
			 <col scope="col" width="10%">
			 <col scope="col" width="25%">
			 <col scope="col" width="*">
			  <col scope="col" width="10%">
		  </colgroup>
		  <thead>
			 <tr>
				  <th>타입</th>
				  <th>제목</th>
				  <th>내용</th>
				  <th>등록일</th>
			  </tr>
		  </thead>
		  <tbody>
			  
		</tbody>
	</table>
</div>
<div class="gap"></div>
<!-- s : 게시판 페이징 -->
<div class='' id="policylistpage"></div>
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
		if(obj["apiCode"]=="policylist")
		{			
			$("#tbllist tbody").html("");
			data="";
			if(!isEmpty(obj["list"]))
			{
				$(obj["list"]).each(function( index, value )
				{
					data+="<tr style='cursor:pointer;' onclick=\"viewdesc('"+value["poSeq"]+"')\">";
					data+="<td>"+value["poTypeName"]+"</td>"; //타입
					data+="<td>"+value["poTitle"]+"</td>";//제목
					data+="<td>"+value["poContents"]+"</td>"; //내용
					data+="<td>"+value["poDate"]+"</td>"; //등록일 
					data+="</tr>";				
				});
			}
			else
			{
				data+="<tr>";
				data+="<td colspan='4'><?=$txtdt['1665']?></td>";
				data+="</tr>";
			}
			$("#tbllist tbody").html(data);

			$("#pagecnt").text(comma(obj["tcnt"])+" <?=$txtdt['1019']?>");
			getsubpage("policylistpage",obj["tpage"], obj["page"], obj["block"], obj["psize"]);
		}
		return false;
	}

	var hdata=location.hash.replace("#","").split("|");
	var page=hdata[0];
	var apiOrderData="";
	var search=hdata[2];
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
	callapi('GET','<?=$pagegroup?>','<?=$pagecode?>',apidata); 	
</script>