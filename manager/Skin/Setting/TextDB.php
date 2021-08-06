<?php //TextDB
	$root = "../..";
	include_once ($root.'/_common.php');

	//echo $apidata;
	$pagegroup = "setting";
	$pagecode = "textdblist";
?>
<div id="pagegroup" value="<?=$pagegroup?>"></div>
<div id="pagecode" value="<?=$pagecode?>"></div>
<input type="hidden" name="apiCode" class="reqdata" value="textdbupdate">
<input type="hidden" name="returnData" class="reqdata" value="<?=$root?>/Skin/Setting/TextDB.php">
<textarea name="selstat" rows="10" cols="100%" class="hidden" id="selstatDiv"></textarea>


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
			<button type="button" class="btn-blue"><span class="modinput_" onclick="modinput('add_textdb','', '<?=$txtdt["1070"]?>,<?=$txtdt["1153"]?>,<?=$txtdt["1481"]?>')">+ <?=$txtdt["1222"]?><!-- 언어코드추가  --></span></button>
		</p>
	</div>
	<table id="tbllist" class="tblcss">
		  <caption><span class="blind">번호,분류,내용,담당자,등록일,완료예정일,완료일,중요도,상태를 나타내는 이슈관리 테이블 입니다.</span></caption>
		  <colgroup>
			 <col scope="col" width="8%">
			 <col scope="col" width="*">
			 <col scope="col" width="18%">
			 <col scope="col" width="18%">
			 <col scope="col" width="15%">
			 <col scope="col" width="10%">
		  </colgroup>
		  <thead>
			 <tr>
				  <th><?=$txtdt["1380"]?><!-- 텍스트코드 --></th>
				  <th><?=$txtdt["1359"]?><!-- 타입 --></th>
				  <th>한글</th>
				  <th>中文</th>
				  <th>English</th>
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

	function textdbupdate()
	{
		//if(necdata()=="Y") //필수조건 체크
		//{
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

			callapi("POST","setting","textdbupdate",jsondata);
			viewpage();
			console.log("리스트 호출합니다");
		//}
	}

	function makepage(json)
	{
		var obj = JSON.parse(json);
		console.log(obj);
		if(obj["apiCode"]=="textdblist")
		{
			var data = "";

			$("#tbllist tbody").html("");
			var btnName = '<?=$txtdt["1070"]?>,<?=$txtdt["1153"]?>';//txt1070 등록/수정,txt1153 삭제
			parseradiocodes("selstatDiv", obj["txtTypeList"], '<?=$txtdt["1359"]?>', "txtType", "ptgroup-list", null);//타입 분류  

			if(!isEmpty(obj["list"]))
			{
				$(obj["list"]).each(function( index, value )
				{
					data+="<tr class='modinput modinput_"+value["seq"]+"' style='cursor:pointer;' onclick=\"modinput('_textdb','"+value["seq"]+"', '"+btnName+"')\">";
					data+="<td>"+value["tdCode"]+"</td>"; //바코드
					data+="<td data-type='"+value["typeCode"]+"'>"+value["tdTypeName"]+"</td>"; //바코드
					data+="<td>"+value["tdNameKor"]+"</td>"; //조제분류
					data+="<td>"+value["tdNameChn"]+"</td>";//태그명1
					data+="<td>"+value["tdNameEng"]+"</td>";
					data+="<td>"+value["tdDate"]+"</td>"; //생성일
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
			getsubpage("textdblistpage",obj["tpage"], obj["page"], obj["block"], obj["psize"]);
			return false;
		}
		else if(obj["apiCode"]=="textdbdelete")
		{
			setTextData(obj);
		}
	}
	//언어TextDB API 호출
	var hdata=location.hash.replace("#","").split("|");
	//console.log("hdata        :"+hdata);  //1,,searchTxt=123&searchStatus=&searchPeriodEtc=
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
	console.log("apidata     : "+apidata);

	callapi('GET','<?=$pagegroup?>','<?=$pagecode?>',apidata);
	$("#searchTxt").focus();
</script>