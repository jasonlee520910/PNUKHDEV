<?php //약재함관리
$root = "../..";
include_once ($root.'/_common.php');
$pagegroup = "inventory";
$pagecode = "mediboxlist";
?>

<!--// page start -->
<div id="pagegroup" value="<?=$pagegroup?>"></div>
<div id="pagecode" value="<?=$pagecode?>"></div>
<input type="hidden" name="modifyAuth" class="" value="<?=$modifyAuth?>">
<input type="hidden" name="apiCode" class="reqdata" value="mediboxupdate">
<input type="hidden" name="mbtable" class="reqdata" value="">
<input type="hidden" name="mdcodeDiv" class="reqdata" value="">
<input type="hidden" name="returnData" class="reqdata" value="<?=$root?>/Skin/Inventory/MedicineBox.php">
<textarea name="seltable" rows="10" cols="100%" class="hidden" id="seltableDiv"></textarea>


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
				<th><?=$txtdt["1717"]?><!-- 조제대별 --></th>
				<td id="statusDIV"></td>
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
				<button class="btn-blue">
					<span class="" onclick="printallbarcode('barcode_00000')">+ 공동바코드</span>
				</button>
				<button class="btn-blue">
					<span class="" onclick="printallbarcode('barcode_00001')">+ 1조제대바코드</span>
				</button>
				<button class="btn-blue">
					<span class="" onclick="printallbarcode('barcode_00002')">+ 2조제대바코드</span>
				</button>
				<button class="btn-blue" style="margin-right:20px;">
					<span class="" onclick="printallbarcode('barcode_00080')">+ 수동조제바코드</span>
				</button>
				<a onclick="modinput('add_medibox','', '<?=$txtdt["1199"]?>,<?=$txtdt["1070"]?>,<?=$txtdt["1153"]?>,<?=$txtdt["1098"]?>,<?=$txtdt["1481"]?>')">
					<button class="btn-blue">
						<span class="modinput_">+ <?=$txtdt["1219"]?><!-- 약재함코드추가 --></span>
					</button>
				</a>
			<?php }?>
		</p>
	</div>
	<table id="tbllist" class="tblcss">
		<caption><span class="blind">번호,분류,내용,담당자,등록일,완료예정일,완료일,중요도,상태를 나타내는 이슈관리 테이블 입니다.</span></caption>
		<colgroup>
			<col scope="col" width="10%">
			<col scope="col" width="">
			<col scope="col" width="10%">
			<col scope="col" width="7%">
			<col scope="col" width="7%">
			<col scope="col" width="7%">
			<col scope="col" width="11%">
			<col scope="col" width="11%">
			<col scope="col" width="6%">
			<col scope="col" width="8%">
		</colgroup>
		<thead>
			<tr>
				<th><?=$txtdt["1216"]?><!-- 약재함 바코드 --></th>
				<th><?=$txtdt["1713"]?><!-- 조제대 --></th>
				<th><?=$txtdt["1124"]?><!-- 본초명 --></th>
				<th><?=$txtdt["1204"]?>_pnuh<!-- 약재명 --></th>
				<th><?=$txtdt["1237"]?><!-- 원산지 --></th>
				<th><?=$txtdt["1288"]?><!-- 제조사 --></th>
				<th><?=$txtdt["1213"]?><!-- 약재코드 --></th>
				<th><?=$txtdt["1265"]?><!-- 입고코드 --></th>
				<th><?=$txtdt["1707"]?><!-- 약재함의 재고량 --></th>
				<th><?=$txtdt["1082"]?><!-- 매칭일 --></th>
			</tr>
		</thead>
		<tbody>
		</tbody>
	</table>
</div>

<div class="gap"></div>

<!-- s : 게시판 페이징 -->
<div class='paging-wrap' id="mediboxlistpage"></div>
<!-- e : 게시판 페이징 -->

<script>
	function printallbarcode(type)
	{
		 window.open("/99_LayerPop/document.barcode.medibox.php?type="+type,"proc_barcode","width=800,height=900");
	}	

	function repageload(){
	console.log("no  repageload ");
	}

	//조제대는 han_makingtable에 등록된 아이들만 가져오기 때문에 따로 함수를 만들어 뺌 
	function parseMediBoxStatus(list, status)
	{
		var str=cls="";
		var i=0;
		for(var key in list)
		{
			cls="";
			if(!isEmpty(status))
			{
				if(status.indexOf(list[key]["cdCode"]) != -1 )
				{
					cls="checked";
				}
				else
				{
					cls="";
				}
			}
			//if(status.indexOf(list[key]["cdCode"]) >= 0){cls="checked";}else{cls="";}
			console.log("status : " + status+", list[key][cdCode] : " + list[key]["cdCode"]+", cls : " + cls);
			str+="<span class='chkbox'> ";
			str+="<input type='checkbox' id='etc"+i+"' value='"+list[key]["cdCode"]+"' name='searchStatus' class='searcls searchStatus"+list[key]["cdCode"]+"' onclick='searcls()' "+cls+" /> ";
			str+="<label for='etc"+i+"'>"+list[key]["cdName"]+"</label> ";
			str+="</span> ";
			i++;
			
		}

		$("#statusDIV").html(str);
		
	}
	function mediboxupdate()
	{
		if(necdata()=="Y") //필수조건 체크
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

			callapi("POST","inventory","mediboxupdate",jsondata);
			$("#listdiv").load("<?=$root?>/Skin/Inventory/MedicineBox.php");
		}
	}
	function makepage(json)
	{
		var obj = JSON.parse(json);
		console.log(obj);

		var data="";

		if(obj["apiCode"]=="mediboxlist")
		{
			parseMediBoxStatus(obj["mbTableList"], obj["searchstatus"]);
			mediboxparseradiocodes("seltableDiv", obj["mbTableList"], '<?=$txtdt["1713"]?>', "mbTable", "mbTable-list", null);//조제대 
			$('input:radio[name="mbTable"]:checked').click();

			var btnName = '<?=$txtdt["1199"]?>,<?=$txtdt["1070"]?>,<?=$txtdt["1153"]?>,<?=$txtdt["1098"]?>';//txt1199 약재검색,txt1070 등록/수정,txt1153 삭제,txt1098 바코드출력
			data="";
			$("#tbllist tbody").html("");
			if(!isEmpty(obj["list"]))
			{
				$(obj["list"]).each(function( index, value )
				{
					data+="<tr class='modinput modinput_"+value["seq"]+"' style='cursor:pointer;' onclick=\"modinput('_medibox','"+value["seq"]+"', '"+btnName+"')\">";
					data+="<td>"+value["mbCode"]+"</td>";   //약재함 바코드
					data+="<td data-table='"+value["mbTable"]+"'>"+value["mbTableName"]+"</td>"; //조제대
					data+="<td>"+value["mhTitle"]+"</td>"; //본초명
					data+="<td>"+value["mdTitle"]+"</td>"; //약재명
					data+="<td>"+value["mdOrigin"]+"</td>"; //원산지
					data+="<td>"+value["mdMaker"]+"</td>"; //제조사
					data+="<td data-mdcode='"+value["mdCode"]+"'>"+value["mbMedicine"]+"</td>"; //약재코드
					data+="<td>"+value["mbStock"]+"</td>"; //입고코드
					data+="<td>"+comma(value["mbCapacity"])+"</td>"; //약재함의 재고량 
					data+="<td>"+value["mbDate"]+"</td>"; //매칭일
					data+="</tr>";
				});
			}
			else
			{
				data+="<tr>";
				data+="<td class='notext' colspan='10'><?=$txtdt['1665']?></td>";
				data+="</tr>";
			}

			$("#tbllist tbody").html(data);

			$("#pagecnt").text(comma(obj["tcnt"])+" <?=$txtdt['1019']?>");
			//페이징
			getsubpage("mediboxlistpage",obj["tpage"], obj["page"], obj["block"], obj["psize"]);
		}
		else if(obj["apiCode"] == "medicinelist") //약재리스트
		{
			var capa = 0;

			data="";
			$("#laymedicinetbl tbody").html("");

			if(!isEmpty(obj["list"]))
			{
				$(obj["list"]).each(function( index, value )
				{
					capa = (isNaN(value["mdProperty"])==false) ? value["mdProperty"] : 0;
					data+='<tr class="putpopdata" onclick="javascript:putpopdata(this);" data-code="'+value["mdCode"]+'" data-smu="'+value["mmCode"]+'" data-property="'+capa+'">';
					data+='<td>'+value["mdTypeName"]+'</td>';
					data+='<td>'+value["mhTitle"]+'</td>';
					data+='<td>'+value["mmtitle"]+'</td>';
					data+='<td>'+value["mdOrigin"]+'/'+value["mdMaker"]+'</td>';
					//data+='<td>'+capa+'</td>';
					data+='<td>'+value["mdPrice"]+'<?=$txtdt["1235"]?> </td>';
					data+='</tr>';
				});
			}
			else
			{
				data+="<tr>";
				data+="<td colspan='5'><?=$txtdt['1665']?></td>";
				data+="</tr>";
			}
			$("#laymedicinetbl tbody").html(data);
			$(".list-select input[name=searchTxt]").focus();

			//페이징
			getsubpage_pop("medicinelistpage",obj["tpage"], obj["page"], obj["block"], obj["psize"], obj["reData"]);
		}
		else if (obj["apiCode"]=="mediboxchk")
		{
			if(obj["resultCode"] == "200")
			{
				alert("<?=$txtdt['1668']?>"); //이 약재는 등록이 되어있습니다. 다시 확인해주세요
			}

			 return false;
		}
		else if (obj["apiCode"]=="mediboxupdate")  //
		{
			if(obj["resultMessage"] == "1714")
			{
				alert("<?=$txtdt['1668']?>"); //이 약재는 등록이 되어있습니다. 다시 확인해주세요
			}
		}
			 return false;	
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
	$(".board-view-wrap #searchTxt").focus();

	
	function mediboxparseradiocodes(pgid, list, title, name, classname, data, readonly)
	{
		var radiostr=checked=disable=raValue=selcatetd="";
		var i = 0;
		disable = (readonly == 'readonly') ? "disabled='disabled'" : "";

		radiostr='<ul class="'+classname+' ">';	
		selcatetd = "";

		$.each(list, function(val) {
			checked = datavalue="";

			raValue = list[val]["cdCode"];
			datavalue = list[val]["cdValue"];

			if(!isEmpty(data))
			{
				if(data == list[val]["cdCode"])
					checked = "checked";			
			}
			else if(i == 0)
			{
				checked = "checked";
			}

			idstr = "0" + i;
			idstr = idstr.slice(-2);

			radiostr += '<li class="w50p">';
			radiostr += '	<p>';
			//radiostr += '		<input type="radio"  name="'+name+'" class="radiodata '+selcatetd+'" title = "'+title+'" id="'+name+'-'+idstr+'" value="'+raValue+'"  '+checked+' '+disable+' onclick="mediboxClick(this);"  >';
			radiostr += '		<input type="radio"  name="'+name+'" class="radiodata '+selcatetd+'" title = "'+title+'" id="'+name+'-'+idstr+'" value="'+raValue+'"  '+checked+' '+disable+'  >';
			radiostr += '		<label for="'+name+'-'+idstr+'">'+list[val]["cdName"]+'</label>';		
			radiostr += '	</p>';
			radiostr += '</li>';
			i++;
		});
		radiostr+='</ul>';
	   // console.log("라디오박스   :"+radiostr);
		$("#"+pgid).html(radiostr);
	}

/*   0408 안쓰는것이라 일단 주석처리 
	function mediboxClick(obj)
	{
		var mdcode=$("input[name=mdcodeDiv]").val(); //mdcode
		var apidata="mb_medicine="+mdcode+"&mb_table="+obj.value;
		if(mdcode)
		{	
			console.log("약재함 중복 체크 apidata  >>>  "+apidata); 
			callapi('GET','<?=$pagegroup?>','mediboxchk',apidata); // 약재함이 등록되어있는지 체크		
		}
	}
	*/
</script>
