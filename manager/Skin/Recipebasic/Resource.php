<?php //처방서적
$root = "../..";
include_once ($root.'/_common.php');

?>

<div id="pagegroup" value="recipe"></div>
<div id="pagecode" value="resourcebooklist"></div>

<div class="board-ov-wrap">
    <!--// left -->
    <div class="fl">
		<h3 class="u-tit02"><?=$txtdt["1326"]?><!-- 처방서적등록/수정 --></h3>
		<div class="board-view-wrap">
			<span class="bd-line"></span>
			
				<input type="hidden" name="apiCode" class="reqdata" value="resourcebookupdate"/>
				<input type="hidden" name="seq" class="reqdata" />
				<input type="hidden" name="rbCode" class="reqdata" value="add"/>
				<input type="hidden" name="returnData" class="reqdata" value="<?=$root?>/Skin/Recipebasic/Resource.php">

				<table>
					<caption><span class="blind"></span></caption>
					<colgroup>
						<col width="25%">
						<col width="25%">
						<col width="25%">
						<col width="25%">
					</colgroup>
					<tbody>
						<tr>
							<th class="l"><span class="nec"><?=$txtdt["1324"]?><!-- 처방서적 --></span></th>
							<td colspan="3">
								한글
								<input type="text" class="w98p reqdata necdata" title="<?=$txtdt["1324"]?>" name="rbTitleKor"/>
								中文
								<input type="text" class="w98p reqdata necdata" title="<?=$txtdt["1324"]?>" name="rbTitleChn" />
							</td>
						</tr>
						<tr>
							<th class="l"><span class="nec"><?=$txtdt["1387"]?><!-- 편수 --></span></th>
							<td id="rbIndexDiv"></td>
							<th class="l"><span class="nec"><?=$txtdt["1031"]?><!-- 권수 --></span></th>
							<td id="rbBooknoDiv"></td>
						</tr>
						 <tr>
							<th class="l"><span class="nec"><?=$txtdt["1320"]?><!-- 책설명 --></span></th>
							<td colspan="3">
								한글
								<textarea name="rbDescKor" rows="5" cols="" class="w98p reqdata necdata" title="<?=$txtdt["1320"]?>"></textarea>
								中文
								<textarea name="rbDescChn" rows="5" cols="" class="w98p reqdata necdata" title="<?=$txtdt["1320"]?>"></textarea>
							</td>
						</tr>
					</tbody>
				</table>

		</div>
		<div class="btn-box c">
			<?if($modifyAuth == "true"){?>
				<a href="javascript:resourcebookupdate();" class="cdp-btn"><span><?=$txtdt["1070"]?><!-- 등록/수정 --></span></a>
				<a href="javascript:godesc('');" class="cw-btn"><span><?=$txtdt["1189"]?><!-- 신규 --></span></a>
				<a href="javascript:resourcebook_del();" class="red-btn"><span><?=$txtdt["1154"]?></span></a>
			<?}?>
		</div>
    </div>

    <!--// right -->
    <div class="fr ov-cont">
	<span class="tcnt" style="float:right;"></span>
		<h3 class="u-tit02"><?=$txtdt["1464"]?><!-- 처방서적목록 --></h3>
		<div class="board-list-wrap">	
			<span class="bd-line"></span>
			<div class="list-select">
                <p class="fl">
				   <span id="pagecnt" class="tcnt"></span>
                </p>
                <p class="fr"><?=selectsearch()?></p>
            </div>
			<table id="tbllist" class="tblcss">
					<caption><span class="blind"></span></caption>
					<colgroup>
					 <col scope="col" width="18%">
					 <col scope="col" width="8%">
					 <col scope="col" width="8%">
					 <col scope="col" width="*">
					</colgroup>
					<thead>
					 <tr>
						<th><?=$txtdt["1104"]?><!-- 방제집명 --></th>
						<th><?=$txtdt["1387"]?><!-- 편수 --></th>
						<th><?=$txtdt["1031"]?><!-- 권수 --></th>
						<th><?=$txtdt["1320"]?><!-- 책설명 --></th>
					</tr>
					</thead>
					<tbody>
					</tbody>
			</table>
		</div>
		<div class="sgap"></div>
        <div class="sgap"></div>
        <!-- s : 게시판 페이징 -->
        <div class='' id="resourcebooklistpage"></div>
        <!-- e : 게시판 페이징 -->
    </div>
</div>

<script>
    function resourcebookupdate()//등록&수정
    {
        if(necdata()=="Y") //필수값체크
		{
			var key=data="";
			var jsondata={};
			$(".reqdata").each(function()
			{
				key=$(this).attr("name");
				data=$(this).val();
				jsondata[key] = data;
			});

			console.log(JSON.stringify(jsondata));

			callapi("POST","recipe","resourcebookupdate",jsondata); //본초분류관리 등록&수정

			//페이지초기화 1초후
			setTimeout("godesc('')",1000);
			repageload();
		}
    }

	function godesc(seq)//신규
    {
		$(".reqdata").each(function()
        {
			var name=$(this).attr("name");
			if(!isEmpty(name))
			{
				if(name=='rbDescKor' || name=='rbDescChn')
				{
					$("textarea[name="+name+"]").val("");
				}
				else
				{
					if(name=='rbCode')
						$("input[name=rbCode]").val("add");
					else
						$("input[name="+name+"]").val("");
				}				
			}
			console.log("name="+name);
        });
		makehash("",seq,"");

	}

    function resourcebook_del() //삭제
	{
		var data = "seq="+$("input[name=seq]").val();
		callapidel('recipe','resourcebookdelete',data);
		godesc('');
		return false;
	}
	//------------------------------------------------------------------------------------
	// 편수, 권수
	//------------------------------------------------------------------------------------
	function parserbcodes(pgid, max, title, name, data)
	{
		var selected = "";
		var str='<select name="'+name+'" title="'+title+'" class="w100p reqdata necdata">';

		for(var i=1;i<=max;i++)
		{
			selected = "";
			if(isEmpty(data) && i == 0)
			{
				selected = "selected";
			}
			else
			{
				if(data == i)
					selected = "selected";
			}

			str+='<option value='+i+' '+selected+'>'+i+'</option>';
		}


		str+='</select>';
		$("#"+pgid).html(str);
	}
	function makepage(json)
	{
		var obj = JSON.parse(json);
		console.log(obj);

        if(obj["apiCode"]=="resourcebookdesc") //처방서적 상세
        {
			var rbCode = isEmpty(obj["rbCode"]) ? "add":obj["rbCode"];
			$("input[name=seq]").val(obj["seq"]);
			$("input[name=rbCode]").val(rbCode);

			//$("input[name=rbIndex]").val(obj["rbIndex"]);//편수
			//$("input[name=rbBookno]").val(obj["rbBookno"]);//권수
            $("input[name=rbTitleKor]").val(obj["rbTitleKor"]); //처방서적(한글)
            $("input[name=rbTitleChn]").val(obj["rbTitleChn"]); //처방서적(중문)
			$("textarea[name=rbDescKor]").val(obj["rbDescKor"]);//책설명(한글)
			$("textarea[name=rbDescChn]").val(obj["rbDescChn"]);//책설명(중문)

			parserbcodes('rbIndexDiv', 30, '<?=$txtdt["1387"]?>',  'rbIndex',  obj["rbIndex"]);
			parserbcodes('rbBooknoDiv', 30, '<?=$txtdt["1031"]?>',  'rbBookno', obj["rbBookno"]);
        }
        else if(obj["apiCode"]=="resourcebooklist")//처방서적 리스트
        {
            $("#tbllist tbody").html("");
            var data = "";

			if(!isEmpty(obj["list"]))
			{
				$(obj["list"]).each(function( index, value )
				{
					data+="<tr style='cursor:pointer;' onclick=\"desc('"+value["seq"]+"')\">"; //누르면 상세 출력
					data+="<td>"+value["rbTitle"]+"</td>";//방제집명
					data+="<td>"+value["rbIndex"]+"</td>"; //편수
					data+="<td>"+value["rbBookno"]+"</td>"; //권수
					data+="<td class='l'>"+value["rbDesc"]+"</td>"; //책설명
					data+="</tr>";
				});
			}
			else
			{
				data+="<tr>";
				data+="	<td colspan='4'><?=$txtdt['1665']?></td>";
				data+="</tr>";
			}
            $("#tbllist tbody").html(data);

			parserbcodes('rbIndexDiv', 30, '<?=$txtdt["1387"]?>',  'rbIndex',  '');
			parserbcodes('rbBooknoDiv', 30, '<?=$txtdt["1031"]?>',  'rbBookno', '');

            //페이지
			$("#pagecnt").text(comma(obj["tcnt"])+" <?=$txtdt['1019']?>");
            getsubpage("resourcebooklistpage",obj["tpage"], obj["page"], obj["block"], obj["psize"]);
        }
		return false;
	}


	function repageload(){
		var hdata=location.hash.replace("#","").split("|");
		var page=hdata[0];
		var seq=hdata[1];
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
			$("input[name=searchTxt]").val(decodeURI(searchTxt));
		}

		$("input[name=searchTxt]").val(decodeURI(searchTxt));
		var apidata="page="+page+"&searchTxt="+searchTxt;
		callapi('GET','recipe','resourcebooklist',apidata);
		if(seq !="" && seq!=undefined){
			apidata="seq="+seq;
			callapi('GET','recipe','resourcebookdesc',apidata); //처방서적>처방서적 상세 API 호출
		}
	}

	var hdata=location.hash.replace("#","").split("|");
	console.log("hdata     :"+hdata);
	var page=hdata[0];
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

	//검색에 undefined들어가는 버그수정
	if(searchTxt==undefined){
		searchTxt="";
		$("input[name=searchTxt]").val("");
	}
	var apidata="page="+page+"&searchTxt="+searchTxt;
	callapi('GET','recipe','resourcebooklist',apidata); 	 

    //리스트 누르면 상세 출력
    function desc(seq)
	{
		viewdesc(seq);
		var apidata = "seq="+seq;
        callapi('GET','recipe','resourcebookdesc',apidata); //처방서적>처방서적 상세 API 호출
	}

	$("input[name=searchTxt]").focus();
</script>
