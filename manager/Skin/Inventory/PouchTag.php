<?php //조제태그 관리 리스트
$root = "../..";
include_once ($root.'/_common.php');
$pagegroup = "inventory";
$pagecode = "pouchtaglist";
?>

<div id="pagegroup" value="<?=$pagegroup?>"></div>
<div id="pagecode" value="<?=$pagecode?>"></div>
<input type="hidden" name="modifyAuth" class="" value="<?=$modifyAuth?>">
<input type="hidden" name="apiCode" class="reqdata" value="pouchtagupdate">
<input type="hidden" name="returnData" class="reqdata" value="<?=$root?>/Skin/Inventory/PouchTag.php">
<textarea name="selstat" rows="10" cols="100%" class="hidden" id="selstatDiv"></textarea>

<!--// page start -->
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
				<th><?=$txtdt["1296"]?><!--조제태그별 --></th>
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
<!-- <div class="u-tab04"></div> -->
<div class="board-list-wrap">
	<span class="bd-line"></span>
	<div class="list-select">
		<span id="pagecnt" class="tcnt" style="float:left"></span>
		<p class="fl"></p>
		<p class="fr">
			<button type="button" class="btn-blue" onclick="printallbarcode('infirst');">
				<span class="">선전 바코드 일괄 출력</span>
			</button>
			<button type="button" class="btn-blue" onclick="printallbarcode('inmain');">
				<span class="">일반 바코드 일괄 출력</span>
			</button>
			<button type="button" class="btn-blue" onclick="printallbarcode('inafter');">
				<span class="">후하 바코드 일괄 출력</span>
			</button>

			<?php if($modifyAuth == "true" || $modifyAuth == "admin"){?>
			<!-- <button type="button" class="btn-blue">
				<span class="modinput_" onclick="modinput('add_pouchtag','', '<?=$txtdt["1070"]?>,<?=$txtdt["1153"]?>,<?=$txtdt["1098"]?>,<?=$txtdt["1481"]?>')">+ <?=$txtdt["1297"]?></span>
			</button> -->
			<?php }?>
		</p>
	</div>

	<table id="tbllist" class="tblcss">
		  <caption><span class="blind">번호,분류,내용,담당자,등록일,완료예정일,완료일,중요도,상태를 나타내는 이슈관리 테이블 입니다.</span></caption>
		  <colgroup>
			 <col scope="col" width="15%">
			 <col scope="col" width="25%">
			 <col scope="col" width="10%">
			 <col scope="col" width="10%">
			 <col scope="col" width="10%">
			 <col scope="col" width="30%">
		  </colgroup>
		  <thead>
			  <tr>
 				  <th><?=$txtdt["1093"]?><!--바코드 --></th>
 				  <th><?=$txtdt["1293"]?><!--조제분류 --></th>
 				  <th><?=$txtdt["1374"]?><!--태그명1 --></th>
 				  <th><?=$txtdt["1375"]?><!--태그명2 --></th>
 				  <th><?=$txtdt["1376"]?><!--태그명3 --></th>
 				  <th><?=$txtdt["1072"]?><!--등록일 --></th>
 			  </tr>
		  </thead>
		  <tbody>

		</tbody>
	</table>
</div>

<div class="gap"></div>

<!-- s : 게시판 페이징 -->
<div class='paging-wrap' id="pouchtaglistpage"></div>
<!-- e : 게시판 페이징 -->

<script>

	function printallbarcode(type)
	{
		 window.open("/99_LayerPop/document.barcode.php?type="+type,"proc_barcode","width=800,height=900");
	}

	function repageload(){
	console.log("no  repageload ");
	}

	function pouchtagupdate()
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

		callapi("POST","inventory","pouchtagupdate",jsondata);
		$("#listdiv").load("<?=$root?>/Skin/Inventory/PouchTag.php");
	}

	function makepage(json)
	{
		var obj = JSON.parse(json);
		console.log(obj);
		if(obj["apiCode"]=="pouchtaglist")
		{
			var data = "";

			parseradiocodes("selstatDiv", obj["decoctypeList"], '<?=$txtdt["1293"]?>', "ptGroup", "ptgroup-list", null);//조제분류 
			var btnName = '<?=$txtdt["1070"]?>,<?=$txtdt["1153"]?>,<?=$txtdt["1098"]?>';//txt1199 약재검색,txt1070 등록/수정,txt1153 삭제,txt1098 바코드출력


			$("#tbllist tbody").html("");			
			if(!isEmpty(obj["list"]))
			{
				$(obj["list"]).each(function( index, value )
				{
					data+="<tr class='modinput modinput_"+value["seq"]+"' style='cursor:pointer;' onclick=\"modinput('_pouchtag','"+value["seq"]+"', '"+btnName+"')\">";
					data+="<td>"+value["ptCode"]+"</td>"; //바코드
					data+="<td data-group='"+value["ptGroup"]+"' >"+value["ptGroupName"]+"</td>"; //조제분류
					data+="<td>"+value["ptName1"]+"</td>";//태그명1
					data+="<td>"+value["ptName2"]+"</td>";
					data+="<td>"+value["ptName3"]+"</td>";
					data+="<td>"+value["ptDate"]+"</td>"; //생성일
					data+="</tr>";
				});
			}
			else
			{
				data+="<tr>";
				data+="<td colspan='6'><?=$txtdt['1665']?></td>";
				data+="</tr>";
			}
			$("#tbllist tbody").html(data);

			$("#pagecnt").text(comma(obj["tcnt"])+" <?=$txtdt['1019']?>");
			//페이징 
			getsubpage("pouchtaglistpage",obj["tpage"], obj["page"], obj["block"], obj["psize"]);

			
			return false;
		}
	}

	//약재함관리  API 호출
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
