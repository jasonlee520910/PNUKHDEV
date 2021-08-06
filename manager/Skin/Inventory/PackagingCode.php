<?php //포장재관리리스트
$root = "../..";
include_once ($root.'/_common.php');
$pagegroup = "inventory";
$pagecode = "packinglist";
?>
<div id="pagegroup" value="<?=$pagegroup?>"></div>
<div id="pagecode" value="<?=$pagecode?>"></div>
<input type="hidden" name="apiCode" class="reqdata" value="potupdate">
<input type="hidden" name="returnData" class="reqdata" value="<?=$root?>/Skin/Inventory/PackagingCode.php">
<!--// page start -->
<style>
	td.thumb img{max-width:90%;max-height:50px;}
</style>

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
				<th><?=$txtdt["1132"]?><!-- 분류 --></th>
				<td><?=selectstatus()?></td>
			</tr>
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
	<span id="pagecnt" class="tcnt" style="float:left"></span>
		<p class="fr">
			<?php if($modifyAuth == "true" || $modifyAuth == "admin"){?>
            <a onclick="viewdesc('add')">
				<button class="btn-blue"><span>+ <?=$txtdt["1395"]?><!-- 포장재추가 --></span>
				</button>
			</a>
			<?php }?>
		</p>
	</div>
	<table id="tbllist" class="tblcss">
		<caption><span class="blind">번호,분류,내용,담당자,등록일,완료예정일,완료일,중요도,상태를 나타내는 이슈관리 테이블 입니다.</span></caption>
		
		<colgroup>
			<col scope="col" width="10%">
			<col scope="col" width="15%">
			<col scope="col" width="17%">
			<col scope="col" width="*">
			<!-- <col scope="col" width="10%"> -->
			<col scope="col" width="10%">
		</colgroup>

		<thead>
			<tr>
			<th><?=$txtdt["1247"]?><!-- 이미지 --></th>
			<th><?=$txtdt["1132"]?><!-- 분류 --></th>
			<th><?=$txtdt["1392"]?><!-- 포장재 코드 --></th>
			<th><?=$txtdt["1440"]?><!-- 포장재명 --></th>
			<!-- <th><?=$txtdt["1403"]?> 한의원</th> -->
			<th><?=$txtdt["1072"]?><!-- 등록일 --></th>
			</tr>
		</thead>

		<tbody>
		</tbody>
	</table>
</div>

<div class="gap"></div>

<!-- s : 게시판 페이징 -->
<div class='' id="packagingcodelistpage"></div>
<!-- e : 게시판 페이징 -->

<script>
	function repageload()
	{
		console.log("no  repageload ");
	}

	function makepage(json)
	{
		var obj = JSON.parse(json);
		console.log(obj);
		var afFile = "NoIMG";
		var data="";

		if(obj["apiCode"]=="packinglist")
		{
			$("#tbllist tbody").html("");

			if(!isEmpty(obj["list"]))
			{
				$(obj["list"]).each(function( index, value )
				{
					var chk=value["afThumbUrl"].substring(0,4);
					console.log(value["afThumbUrl"]+", chk="+chk)
					if(chk=="http")
					{
						afFile = (value["afThumbUrl"] == 'NoIMG') ? "<img src='<?=$root?>/_Img/Content/noimg.png'>" : "<img src='"+value["afThumbUrl"]+"' onerror=\"this.src='<?=$root?>/_Img/Content/noimg.png'\">";
					}
					else
					{
						afFile = (value["afThumbUrl"] == 'NoIMG') ? "<img src='<?=$root?>/_Img/Content/noimg.png'>" : "<img src='"+getUrlData("FILE_DOMAIN")+value["afThumbUrl"]+"' onerror=\"this.src='<?=$root?>/_Img/Content/noimg.png'\">";
					}
					data+="<tr style='cursor:pointer;' onclick=\"viewdesc('"+value["seq"]+"')\">";
					data+="<td class='thumb'>"+afFile+"</td>"; //이미지
					data+="<td>"+value["pbTypeName"]+"</td>";//분류
					data+="<td><a href='javascript:;'>"+value["pbCode"]+"</a></td>"; //포장재코드
					data+="<td>"+value["pbTitle"]+"</td>"; //포장재명
					//data+="<td>"+value["miName"]+"</td>"; //한의원
					data+="<td>"+value["pbDate"]+"</td>"; //등록일
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
			getsubpage("packagingcodelistpage",obj["tpage"], obj["page"], obj["block"], obj["psize"]);

			return false;
		}
	}

	//포장재 관리  API 호출
	var hdata=location.hash.replace("#","").split("|");
	var page=hdata[0];
	var apiOrderData="";
	var search=hdata[2];
	//console.log("hdata        :"+hdata);   //1,,searchTxt=123&searchStatus=&searchPeriodEtc=
	if(page==undefined){
		page=1;
	}

	if(search==undefined || search==""){
		var searchTxt="";
	}else{
		var sarr=search.split("&");
		if(sarr[0]!=undefined)var sarr1=sarr[0].split("=");	
		if(sarr[1]!=undefined)var sarr2=sarr[1].split("=");	//검색단어	
		if(sarr2[2]!=undefined)var sarr3=sarr2[1].split("="); //승인상태별

		if(sarr1[1]!=undefined)var searchTxt=sarr1[1]; //검색단어	
		if(sarr2[1]!=undefined)var searchStatus=sarr2[1]; //승인상태별	
	
		$("input[name=searchTxt]").val(decodeURI(searchTxt));
		
		var starr=searchStatus.split(",");
		for(var i=0;i<starr.length;i++){
			if(starr[i]!=""){
				$(".searchStatus"+starr[i]).attr("checked",true);
			}
		}
		apiOrderData="&searchTxt="+searchTxt+"&searchStatus="+searchStatus;
	}

	var apidata="page="+page+apiOrderData;
	console.log("apidata     : "+apidata);

	callapi('GET','<?=$pagegroup?>','<?=$pagecode?>',apidata);
	$("#searchTxt").focus();
</script>
