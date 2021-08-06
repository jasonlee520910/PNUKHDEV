<?php //탕전기관리 리스트
$root = "../..";
include_once ($root.'/_common.php');
$pagegroup = "inventory";
$pagecode = "potlist";
?>
<div id="pagegroup" value="<?=$pagegroup?>"></div>
<div id="pagecode" value="<?=$pagecode?>"></div>
<input type="hidden" name="modifyAuth" class="" value="<?=$modifyAuth?>">
<input type="hidden" name="apiCode" class="reqdata" value="potupdate">
<input type="hidden" name="returnData" class="reqdata" value="<?=$root?>/Skin/Inventory/PotCode.php">
<textarea name="selworker" rows="10" cols="100%" class="hidden" id="selworkerDiv"></textarea>

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
				<th><?=$txtdt["1364"]?><!-- 탕전기상태 --></th>
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
			   <button type="button" class="btn-blue">
				<span class="modinput_" onclick="modinput('add_pot','', '<?=$txtdt["1070"]?>,<?=$txtdt["1153"]?>,<?=$txtdt["1481"]?>')">+ <?=$txtdt["1365"]?><!--탕전기 추가 --></span>
				</button>
			<?php }?>
		</p>
	</div>
	<table id="tbllist" class="tblcss">
		<caption><span class="blind">번호,분류,내용,담당자,등록일,완료예정일,완료일,중요도,상태를 나타내는 이슈관리 테이블 입니다.</span></caption>

		<colgroup>
			<col scope="col" width="13%">
			<col scope="col" width="13%">
			<col scope="col" width="*">
			<col scope="col" width="5%">
			<col scope="col" width="5%">
			<col scope="col" width="5%">
			<col scope="col" width="10%">
			<col scope="col" width="10%">
			<col scope="col" width="13%">
		</colgroup>

		<thead>
			<tr>
				<th><?=$txtdt["1362"]?><!-- 탕전 바코드 --></th>
				<th><?=$txtdt["1548"]?><!-- 탕전기명 --></th>
				<th><?=$txtdt["1086"]?><!-- 모델명 --></th>
				<th colspan="3"><?=$txtdt["1240"]?><!-- 위치 --></th>
				<th><?=$txtdt["1164"]?><!-- 상태 --></th>
				<th><?=$txtdt["1368"]?><!-- 탕전사 --></th>
				<th><?=$txtdt["1289"]?><!-- 제조일 --></th>
			</tr>
		</thead>

		<tbody>
		</tbody>
	</table>
</div>

<div class="gap"></div>

<!-- s : 게시판 페이징 -->
<div class='paging-wrap' id="potcodelistpage"></div>
<!-- e : 게시판 페이징 -->

<script>
	function chnworker(code,depart)
	{
	}

	function repageload(){
	console.log("no  repageload ");
	}

	function potupdate()
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

		callapi("POST","inventory","potupdate",jsondata);
		$("#listdiv").load("<?=$root?>/Skin/Inventory/PotCode.php");
	}

	function makepage(json)
	{
		var obj = JSON.parse(json);
		console.log(obj);

		if(obj["apiCode"]=="potlist")
		{
			var data = "";
			
			var boStatus = parsedecocodes(obj["boStatusList"], '<?=$txtdt["1364"]?>', 'boStatus', null);
			$("#boardviewDiv").prepend("<textarea name='selstat' style='display:none;'>"+boStatus+"</textarea>");
			selworker("selworkerDiv", obj["decolist"], "boStaff", null, null, "<?=$txtdt['1256']?>"); //1256 : 임의지정 			
			var btnName = '<?=$txtdt["1070"]?>,<?=$txtdt["1153"]?>';//txt1199 약재검색,txt1070 등록/수정,txt1153 삭제,txt1098 바코드출력

			$("#tbllist tbody").html("");
			if(!isEmpty(obj["list"]))
			{
				$(obj["list"]).each(function( index, value )
				{
					data+="<tr class='modinput modinput_"+value["seq"]+"' style='cursor:pointer;' onclick=\"modinput('_pot','"+value["seq"]+"', '"+btnName+"')\">";
					data+="<td>"+value["boCode"]+"</td>"; //탕전바코드
					data+="<td>"+value["boTitle"]+"</td>"; //탕전기명
					data+="<td>"+value["boModel"]+"</td>";//모델명
					data+="<td>"+value["boLocate"]+"</td>"; //위치
					data+="<td>"+value["boTop"]+"</td>"; //위치
					data+="<td>"+value["boLeft"]+"</td>"; //위치
					data+="<td data-status='"+value["boStatus"]+"'>"+value["boStatusName"]+"</td>"; //상태
					data+="<td data-staff='"+value["boStaff"]+"'>"+value["stName"]+"</td>"; //탕전사
					data+="<td>"+value["boDate"]+"</td>"; //제조일
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
			getsubpage("potcodelistpage",obj["tpage"], obj["page"], obj["block"], obj["psize"]);
			return false;
		}
	}

	//탕전기관리  API 호출
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
