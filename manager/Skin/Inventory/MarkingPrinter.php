<?php //마킹프린터관리 리스트
$root = "../..";
include_once ($root.'/_common.php');
$pagegroup = "inventory";
$pagecode = "markingprinterlist";
?>

<div id="pagegroup" value="<?=$pagegroup?>"></div>
<div id="pagecode" value="<?=$pagecode?>"></div>
<input type="hidden" name="modifyAuth" class="" value="<?=$modifyAuth?>">
<input type="hidden" name="apiCode" class="reqdata" value="markingprinterupdate">
<input type="hidden" name="returnData" class="reqdata" value="<?=$root?>/Skin/Inventory/MarkingPrinter.php">

<!--// page start -->
<div class="board-view-wrap" id="boardviewDiv">
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
	<span id="pagecnt" class="tcnt" style="float:left"></span>
		<p class="fr">
			<?php if($modifyAuth == "true" || $modifyAuth == "admin"){?>
				<button type="button" class="btn-blue">
					<span class="modinput_" onclick="modinput('add_markingprinter','', '<?=$txtdt["1070"]?>,<?=$txtdt["1153"]?>,<?=$txtdt["1481"]?>')">+ <?=$txtdt["1878"]?><!-- 마킹프린터추가 --></span>
				</button>
			<?php }?>
		</p>
	</div>
	<table id="tbllist" class="tblcss">
		<caption><span class="blind">번호,분류,내용,담당자,등록일,완료예정일,완료일,중요도,상태를 나타내는 이슈관리 테이블 입니다.</span></caption>
		<colgroup>
			<col scope="col" width="7%">
			<col scope="col" width="7%">
			<col scope="col" width="9%">
			<col scope="col" width="9%">
			<col scope="col" width="*">
			<col scope="col" width="13%">
			<col scope="col" width="13%">
			<col scope="col" width="9%">
			<col scope="col" width="7%">
			<col scope="col" width="5%">
			<col scope="col" width="7%">
		</colgroup>
		<thead>
			<tr>
				<th><?=$txtdt["1869"]?><!-- 프린터코드 --></th>
				<th><?=$txtdt["1870"]?><!-- 프린터이름 --></th>
				<th><?=$txtdt["1871"]?><!-- 프린터아이피 --></th>
				<th><?=$txtdt["1872"]?><!-- 프린터포트 --></th>
				<th><?=$txtdt["1873"]?><!-- 진행중주문코드 --></th>
				<th><?=$txtdt["1874"]?><!-- 프린터시작시간 --></th>
				<th><?=$txtdt["1875"]?><!-- 프린터종료시간 --></th>
				<th><?=$txtdt["1876"]?><!-- 사용스탭아이디 --></th>
				<th><?=$txtdt["1164"]?><!-- 상태 --></th>
				<th><?=$txtdt["1877"]?><!-- 사용여부 --></th>
				<th><?=$txtdt["1072"]?><!-- 등록일 --></th>
			</tr>
		</thead>
		<tbody>
		</tbody>
	</table>
</div>

<div class="gap"></div>

<!-- s : 게시판 페이징 -->
<div class='paging-wrap' id="markingprinterlistpage"></div>
<!-- e : 게시판 페이징 -->

<script>
	function repageload(){
	console.log("no  repageload ");
	}

	function markingprinterupdate()
	{
		var key=data="";
		var jsondata={};

		//radio data
		$(".radiodata").each(function()
		{
			key=$(this).attr("name");
			data=$(":input:radio[name="+key+"]:checked").val();
			jsondata[key] = data;
		});

		$(".reqdata").each(function(){
			key=$(this).attr("name");
			data=$(this).val();
			jsondata[key] = data;
		});

		console.log(JSON.stringify(jsondata));

		callapi("POST","inventory","markingprinterupdate",jsondata);
		$("#listdiv").load("<?=$root?>/Skin/Inventory/MarkingPrinter.php");

	}
	function makepage(json)
	{
		var obj = JSON.parse(json);
		console.log(obj);

		if(obj["apiCode"]=="markingprinterlist")
		{
			var data=btnName="";

			btnName = '<?=$txtdt["1070"]?>,<?=$txtdt["1153"]?>';//txt1199 약재검색,txt1070 등록/수정,txt1153 삭제,txt1098 바코드출력

			$("#tbllist tbody").html("");
			if(!isEmpty(obj["list"]))
			{
				$(obj["list"]).each(function( index, value )
				{
					data+="<tr class='modinput modinput_"+value["mpSeq"]+"' style='cursor:pointer;' onclick=\"modinput('_markingprinter','"+value["mpSeq"]+"', '"+btnName+"')\">";
					data+="<td>"+value["mpCode"]+"</td>"; //
					data+="<td>"+value["mpTitle"]+"</td>"; //
					data+="<td>"+value["mpIp"]+"</td>";//
					data+="<td>"+value["mpPort"]+"</td>"; //
					data+="<td>"+value["mpOdcode"]+"</td>"; //
					data+="<td>"+value["mpStarttime"]+"</td>"; //
					data+="<td>"+value["mpFinishtime"]+"</td>"; //
					data+="<td>"+value["mpStaff"]+"</td>"; //
					data+="<td>"+value["mpStatus"]+"</td>"; //
					data+="<td>"+value["mpUse"]+"</td>"; //
					data+="<td>"+value["mpDate"]+"</td>"; //
					data+="</tr>";
				});
			}
			else
			{
				data+="<tr>";
				data+="<td colspan='11'><?=$txtdt['1665']?></td>";
				data+="</tr>";
			}

			$("#tbllist tbody").html(data);

			$("#pagecnt").text(comma(obj["tcnt"])+" <?=$txtdt['1019']?>");
			getsubpage("markingprinterlistpage",obj["tpage"], obj["page"], obj["block"], obj["psize"]);
			return false;
		}
	}

	//조제대관리 리스트 API 호출
	var hdata=location.hash.replace("#","").split("|");
	var page=hdata[0];
	//console.log("hdata   :"+hdata);  //1,,searchTxt=123&searchStatus=&searchPeriodEtc=
	var search=hdata[2];
	if(page==undefined){
		page=1;
	}
	if(search==undefined){
		var searchTxt="";
	}else{
		var sarr=search.split("&");
		if(sarr[0]!=undefined)var sarr1=sarr[0].split("=");
		if(sarr[1]!=undefined)var sarr2=sarr[1].split("=");
		if(sarr1[1]!=undefined)var searchTxt=sarr1[1];
		$("input[name=searchTxt]").val(decodeURI(searchTxt));
	}
	if($("input[name=searchTxt]").val()=="undefined")
	{
		searchTxt="";
		$("input[name=searchTxt]").val("");
	}
	var apidata="page="+page+"&searchTxt="+searchTxt;
	console.log("apidata   >>>"+apidata);
	callapi('GET','<?=$pagegroup?>','<?=$pagecode?>',apidata);
	$("#searchTxt").focus();
</script>
