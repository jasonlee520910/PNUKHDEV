<?php //본초상세
$root = "../..";
$upload=$root."/_module/upload";
include_once $root.'/_common.php';
include_once $upload."/upload.lib.php";
if($_GET["seq"]=="add"){
	$apidata="seq=";
	$seq="";
}else{
	$apidata="seq=".$_GET["seq"];
	$seq=$_GET["seq"];
}

?>

<input type="hidden" name="seq" class="reqdata" value="<?=$_GET["seq"]?>">
<input type="hidden" name="returnData" class="reqdata" value="<?=$root?>/Skin/Medicine/HubList.php">

<!-- 본초이미지 -->
<script  type="text/javascript" src="<?=$root?>/cmmJs/jquery/jquery.form.min.js"></script>
<link rel="stylesheet" media="all" href="<?=$upload?>/upload.css?v=<?php echo time();?>" />
<script  type="text/javascript" src="<?=$upload?>/upload.js?v=<?=time()?>"></script>

<style>
	dl.chkdl dd{float:left;width:7%;font-size:13px;}
	#mhFeatureDiv .chkdl dd{float:left;width:10%;font-size:13px;}

	/* 중독 css*/
   .Poison-list  {overflow:hidden;}
   .Poison-list  li {position:relative; width:8%;float:left; }

     /* 사상 css*/
	.Feature-list {overflow:hidden;}
	.Feature-list li {position:relative; width:8%;float:left; }


</style>

<div class="board-view-wrap">
    <h3 class="u-tit02"><?=$txtdt["1130"]?><!-- 본초정보 --></h3>
	<div class="u-tab04"></div>
	<span class="bd-line"></span>
	<table>
		  <caption><span class="blind"></span></caption>
		  <colgroup>
			  <col width="180">
			  <col width="*">
			  <col width="180">
			  <col width="*">
		  </colgroup>
		 <tbody>	
				 <tr>
					 <th><span class=""><?=$txtdt["1131"]?><!-- 본초코드 --></span></th>
					 <td colspan="3">
					<?php if($seq){?>
						<div id="mhCode"></div>	
						<input type="hidden" name="mhCode" class="reqdata" title="<?=$txtdt["1131"]?>"/>	
						<!-- <input type="text" name="mhCode" onblur="codechk()" class="reqdata" title="<?=$txtdt["1131"]?>"  readonly/> -->
						<input type="hidden" id="chk_code" name="chk_code" value="1">
					<?php }else{?>
					 <span><?=$txtdt["1481"]?><!-- 자동추가 --></span>
					<?php }?>					 
					<div id="chkcodeText"></div>
					 </td>
				 </tr>
			<tr>
				<th><span class="nec"><?=$txtdt["1124"]?><!-- 본초명 --></span></th>
				<td>
					한글 :<input type="text" name="mhTitlekor" id="mhTitlekor" class="w90p reqdata necdata" title="<?=$txtdt["1124"]?>" />
					중문 :<input type="text" name="mhTitlechn" id="mhTitlechn" class="w90p reqdata necdata" title="<?=$txtdt["1124"]?>" />
				</td>
				<th><span class="nec"><?=$txtdt["1117"]?><!-- 별칭/이명 --></span></th>
				<td>
					한글 :<input type="text" name="mhDtitlekor" id="mhDtitlekor" class="w90p reqdata necdata" title="<?=$txtdt["1117"]?>" />
					중문 :<input type="text" name="mhDtitlechn" id="mhDtitlechn" class="w90p reqdata necdata" title="<?=$txtdt["1117"]?>" />
				</td>
			</tr>
			 <tr>
				<th><span><?=$txtdt["1400"]?><!-- 학명 --></span></th>
				<td colspan="3">
					한글 :<textarea name="mhStitlekor" class="text-area reqdata" title="<?=$txtdt["1400"]?>"></textarea>
					중문 :<textarea name="mhStitlechn" class="text-area reqdata" title="<?=$txtdt["1400"]?>"></textarea>
				</td>
			</tr> 
			<tr>
				<th><span><?=$txtdt["1028"]?><!-- 과명 --></span></th>
				<td colspan="3">
					한글 :<input type="text" name="mhCtitlekor" class="text-area reqdata" title="<?=$txtdt["1028"]?>"/>
					중문 :<input type="text" name="mhCtitlechn" class="text-area reqdata" title="<?=$txtdt["1028"]?>"/>
				</td>
			</tr> 
			<tr>
				<th><span class=""><?=$txtdt["1133"]?><!-- 분류1 --></span></th>
				<td><ul id="mhCategoryDiv1"></ul></td>
				<th><span class=""><?=$txtdt["1134"]?><!-- 분류2 --></span></th>
				<td><ul id="mhCategoryDiv2"><?=$txtdt["1733"]?><!-- 분류1을 먼저 선택해주세요 --></ul></td>
			</tr>
			<tr>
				<th><span class="nec"><?=$txtdt["1175"]?><!-- 성(性) --></span></th>
				<td colspan="3"><ul id="mhStateDiv"></ul></td>
			</tr>
			<tr>
				<th><span class="nec"><?=$txtdt["1090"]?><!-- 미(味) --></span></th>
				<td colspan="3"><ul id="mhTasteDiv"></ul></td>
			</tr>
			<tr>
				<th><span class="nec"><?=$txtdt["1032"]?><!-- 귀경(歸經) --></span></th>
				<td colspan="3"><ul id="mhObjectDiv"></ul></td>
			</tr>
			<tr>
				<th><span class=""><?=$txtdt["1062"]?><!-- 독/중독 --></span></th>
				<td colspan="3"><ul id="mhPoisonDiv"></ul></td>
			</tr>
			<!-- <tr>
				<th><span class=""><?=$txtdt["1142"]?><!-- 사상(四象) --></span></th>
				<!-- <td colspan="3"><ul id="mhFeatureDiv"></ul></td>
			</tr> --> 
			<tr>
				<th><span><?=$txtdt["1128"]?><!-- 본초설명 --></span></th>
				<td colspan="3">
					한글 :<textarea class="text-area reqdata" name="mhDesckor" title="<?=$txtdt["1128"]?>"></textarea>
					중문 :<textarea class="text-area reqdata" name="mhDescchn" title="<?=$txtdt["1128"]?>"></textarea>
				</td>
			</tr>
			<tr>
				<th><span><?=$txtdt["1309"]?><!-- 주의사항 --></span></th>
				<td colspan="3">
					한글 :<textarea class="text-area reqdata" name="mhCautionkor" title="<?=$txtdt["1309"]?>"></textarea>
					중문 :<textarea class="text-area reqdata" name="mhCautionchn" title="<?=$txtdt["1309"]?>"></textarea>
				</td>
			</tr>
			<tr>
				<th><span><?=$txtdt["1114"]?><!-- 법제 --></span></th>
				<td colspan="3">
					한글 :<textarea class="text-area reqdata" name="mhUsagekor" title="<?=$txtdt["1114"]?>"></textarea>
					중문 :<textarea class="text-area reqdata" name="mhUsagechn" title="<?=$txtdt["1114"]?>"></textarea>
				</td>
	    	</tr>
			<tr>
				<th><span class="nec"><?=$txtdt["1418"]?><!-- 효능/효과 --></span></th>
				<td colspan="3">
					한글 :<input type="text" name="mhEfficacykor" id="mhEfficacykor" class="w70p reqdata" title="<?=$txtdt["1009"]?>" />ex) <?=$txtdt["1418"]?><br>
					중문 :<input type="text" name="mhEfficacychn" id="mhEfficacychn" class="w70p reqdata" title="<?=$txtdt["1009"]?>" />ex) <?=$txtdt["1418"]?>
				</td>
				
				</td>
			</tr>
			<tr>
				<th><span><?=$txtdt["1129"]?><!-- 본초이미지 --></span></th>
				<td colspan="3"><?=upload("medihub",$_COOKIE["ck_stStaffid"],$_COOKIE["ck_language"])?></td>
			</tr>
		</tbody>
	</table>
	<div class="btn-box c">
			<?php if($modifyAuth == "true"){?>
				<a href="javascript:hub_update();" class="bdp-btn"><span><?=$txtdt["1070"]?><!-- 등록/수정 --></span></a>
				<a href="javascript:viewlist();" class="bw-btn"><span><?=$txtdt["1087"]?><!-- 목록 --></span></a>
				<a href="javascript:hub_del();" class="bdp-btn"><span><?=$txtdt["1154"]?><!-- 삭제 --></span></a>
			<?php }else{?>
				<a href="javascript:viewlist();" class="bw-btn"><span><?=$txtdt["1087"]?><!-- 목록 --></span></a>
			<?php }?>
	</div>
</div>
<!--// page end -->

<script>
	function textOut()
	{
		$("#chkcodeText").html('');  //중복입니다. 사용가능합니다 글자를 입력하면 안보이게 처리함 
	}


	//코드 중복확인
	function codechk()
	{
		console.log("본초코드를 입력해하면 0이 된다.")
		$("#chk_code").val(0);   //코드값을 누르면 일단 0으로 바뀐다.  
		

		if(!isEmpty($("input[name=mhCode]").val()))
		{
			var data = "mhCode="+$("input[name=mhCode]").val();
			console.log('중복체크하러 갑니다~'+data); 
			callapi('GET','medicine','chkhubcode',data); //코드 중복 체크 
		}
		else
		{
			alertsign("warning", "<?=$txtdt['1766']?>", "", "2000"); //본초코드를 입력해 주세요.
		}
	}

	function textput()///클릭한 체크박스의 값을 가져와서 input text=hidden의 값에 넣어준다
	{
		var str="";
		$("input[name=totalmhState]:checked").each(function() {

			var test = $(this).val();
			str+=","+test;
		});
		$("input[name=mhState]").val(str);

		var str="";
		$("input[name=totalmhTaste]:checked").each(function() {

			var test = $(this).val();
			str+=","+test;
		});
		$("input[name=mhTaste]").val(str);

		var str="";
		$("input[name=totalmhObject]:checked").each(function() {

			var test = $(this).val();
			str+=","+test;
		});
		$("input[name=mhObject]").val(str);
	}

	//checkbox 옵션 함수 (성,미,귀경)
	function checkOption(pgid, name, list, data, title)
	{
	    var option = checked = hiddenvalue = "";
	    option = '<dl class="chkdl">';

	    if(!isEmpty(data))
	    {
	        var arry = data.split(",");
			for(var key in list)
			{
				checked = '';
				for(var i=0;i<arry.length;i++)
				{
					if(arry[i] == list[key]["cdCode"])
					{
						checked = 'checked="checked"';
					}
				}
				option+='<dd><label for="'+list[key]["cdCode"]+name+'">';
				option+='<input type="checkbox"  onclick="textput()" name="'+"total"+name+'" title = "'+title+'" id="'+list[key]["cdCode"]+name+'" value="'+list[key]["cdCode"]+'" '+checked+'>'+list[key]["cdName"]+'</label></dd>';
	        }
	    }
	    else
	    {
			for(var key in list)
			{
				option+='<dd><label for="'+list[key]["cdCode"]+name+'">';
				option+='<input type="checkbox"  onclick="textput()" name="'+"total"+name+'" title = "'+title+'" id="'+list[key]["cdCode"]+name+'" value="'+list[key]["cdCode"]+'" '+checked+'>'+list[key]["cdName"]+'</label></dd>';
	        }
	    }

		if(!isEmpty(data)) //성미귀경 값이 null로 들어가서 값이 있다고 생각하여 등록/수정이 되는 버그 수정(0523)
		{
			hiddenvalue = data;		
		}
		else
		{
			hiddenvalue = "";	
		}
		option +='<input type="hidden" name="'+name+'" class="necdata reqdata"  title = "'+title+'"  value="'+hiddenvalue+'" />'; //성, 미, 귀경은 필수 입력

		
	    option += '</dl>';
		//console.log("귀경 체크 박스  " +option);
	    $("#"+pgid).html(option);
	}

	//분류 1.2 옵션
	function makeSelect(pgid, list, code, data, name,text)
	{
		var shtml=codeval=title=selected="";
			shtml+="<dl class='chkdl'>";
			shtml+="<dd>";

			if(code == 'mcCode01')
			{
				shtml+="<select title='"+name+"' id='"+name+"' name='"+name+"' class='reqdata' onchange='goHubcategory(this);'>";
			}
			else
			{
				shtml+="<select title='"+name+"' id='"+name+"' name='"+name+"' class='reqdata'>";

			}
				shtml+="<option value=''>"+text+"</option>";  //선택해주세요

			for(var key in list)
			{
				//console.log("code = " + code);
				if(code == 'mcCode02')
				{
					if(list[key]["mcTitle02"])
					{
						codeval = list[key]["mcCode02"];
						title = list[key]["mcTitle02"];
					}
					else
					{
						title = " - ";
					}
				}
				else
				{
					codeval = list[key]["mcCode01"];
					title = list[key]["mcTitle01"];
				}

				if(data==codeval){selected=" selected";}else{selected=" ";}
				shtml+="<option value='"+codeval+"' "+selected+">"+title+"</option>";
			}

			shtml+="</select>";
			shtml+="</dd>";
			shtml+="</dl>";
		// console.log(shtml);
		$("#"+pgid).html(shtml);
	}

	function hub_update()//등록&수정
	{
		//if($("input[name=chk_code]").val()==1) //중복확인이 1이어야 등록가능
		//{
			if(necdata()=="Y") //필수조건 체크
			{	
				var key=data="";
				var jsondata={};

				//radio data  //사상  //독/중독
				$(".radiodata").each(function()
				{
					key=$(this).attr("name");
					data=$(":input:radio[name="+key+"]:checked").val();

					jsondata[key] = data;
				});

				//data 저장하기
				$(".reqdata").each(function()
				{
					key=$(this).attr("name");
					data=$(this).val();

					jsondata[key] = data;
				});

				var txtkor=$("input[name=mhEfficacykor]").val().charAt(0);
				var txtchn=$("input[name=mhEfficacychn]").val().charAt(0);
				if(txtkor!="#" || txtchn!="#")
				{
					alertsign("error", "<?=$txtdt['1419']?>", "", "2000");
				}
				else
				{
					console.log("insert 합니다~~~~");
					console.log(JSON.stringify(jsondata));
					callapi("POST","medicine","hubupdate",jsondata); //본초분류관리 등록&수정
				}		
			}
		//}
		/*
		else
		{
			if(!$("input[name=mhCode]").val())
			{
				alertsign("warning", "<?=$txtdt['1766']?>", "", "2000"); //본초코드를 입력해 주세요.
				$("input[name=mhCode]").focus();
				return false;
			}
			else
			{
				alertsign("warning", "<?=$txtdt['1768']?>", "", "2000"); //중복본초코드입니다.
				$("input[name=mhCode]").focus();
				return false;
			}	
		}
		*/
	}

	function hub_del() //삭제
	{
		var data = "seq="+$("input[name=seq]").val();
		var url = encodeURI($("input[name=returnData]").val());
		$("input[name=returnData]").val(url);
		callapidel('medicine','hubdelete',data);
		return false;
	}

    function makepage(json)
    {
        var obj = JSON.parse(json);
		console.log(obj);
		if(obj["apiCode"]=="hubdesc")
		{
			$("input[name=seq]").val(obj["seq"]); //seq
			$("input[name=mhCode]").val(obj["mhCode"]); //본초코드
			$("input[name=mhTitlekor]").val(obj["mhTitlekor"]); //본초명
			$("input[name=mhTitlechn]").val(obj["mhTitlechn"]); //본초명
			$("input[name=mhDtitlekor]").val(obj["mhDtitlekor"]); //별칭/이명
			$("input[name=mhDtitlechn]").val(obj["mhDtitlechn"]); //별칭/이명
			$("textarea[name=mhStitlekor]").text(obj["mhStitlekor"]); //학명
			$("textarea[name=mhStitlechn]").text(obj["mhStitlechn"]); //학명
			$("input[name=mhCtitlekor]").val(obj["mhCtitlekor"]); //과명
			$("input[name=mhCtitlechn]").val(obj["mhCtitlechn"]); //과명

			$("textarea[name=mhDesckor]").text(obj["mhDesckor"]);//본초설명
			$("textarea[name=mhDescchn]").text(obj["mhDescchn"]);//본초설명
			$("textarea[name=mhCautionkor]").text(obj["mhCautionkor"]); //주의사항
			$("textarea[name=mhCautionchn]").text(obj["mhCautionchn"]); //주의사항
			$("textarea[name=mhUsagekor]").text(obj["mhUsagekor"]);//법제
			$("textarea[name=mhUsagechn]").text(obj["mhUsagechn"]);//법제
			$("input[name=mhEfficacykor]").val(obj["mhEfficacykor"]); //효능/효과
			$("input[name=mhEfficacychn]").val(obj["mhEfficacychn"]); //효능/효과

			$("#mhCode").text(obj["mhCode"]); //본초코드 seq 있을때
			$("#mhTasteImsi").text(obj["mhTasteImsi"]); //성(性)미(味)
			$("#mhGobyImsi").text(obj["mhGobyImsi"]); //귀경(歸經) - OLD
			$("#mhIndicateImsi").text(obj["mhIndicateImsi"]); //적응증(適應證) - OLD
			$("#mhTabooImsi").text(obj["mhTabooImsi"]); //금기(禁忌) - OLD
			$("#mhRepairImsi").text(obj["mhRepairImsi"]); //수치(修治) - OLD
			$("#mhCapaImsi").text(obj["mhCapaImsi"]); //용법용량(用量) - OLD

			checkOption("mhStateDiv", "mhState", obj["stateList"], obj["mhState"], "<?=$txtdt['1175']?>"); 	//성
			checkOption("mhTasteDiv", "mhTaste", obj["tasteList"], obj["mhTaste"], "<?=$txtdt['1090']?>"); 	//미
			checkOption("mhObjectDiv", "mhObject", obj["objectList"], obj["mhObject"], "<?=$txtdt['1032']?>"); //귀경

			//parseradiocodes("mhFeatureDiv", obj["featureList"], "<?=$txtdt['1142']?>", "mhFeature", "Feature-list", obj["mhFeature"]);//
			parseradiocodes("mhPoisonDiv", obj["poisonList"], "<?=$txtdt['1062']?>", "mhPoison", "Poison-list", obj["mhPoison"]);//


			makeSelect("mhCategoryDiv1", obj["mCateList"], "mcCode01",obj["mhCategory1"], "mhCategory1", "<?=$txtdt['1172']?>"); //선택해주세요 분류1
			if(obj["seq"] && obj["mhCategory1"])   //seq가 있을때 선택한 값을 보이게 함
			{
				makeSelect("mhCategoryDiv2", obj["mCate2List"], "mcCode02",obj["mhCategory2"], "mhCategory2", "<?=$txtdt['1172']?>");//선택해주세요 분류2
			}
			var mhcode = isEmpty(obj["mhCode"]) ? "0" : obj["mhCode"];
			var seq = isEmpty(obj["seq"]) ? "0" : obj["seq"];
			console.log("setFileCodesetFileCodesetFileCodesetFileCode");
			setFileCode("medihub", mhcode, seq);

			//upload된 이미지가 있다면
			if(!isEmpty(obj["afFiles"]))
			{
				handleImgFileSelect(obj["afFiles"]);
			}
		}

		else if(obj["apiCode"]=="hubcategory") 	//분류박스(분류1.2)
		{
			if(obj["mCate2List"].length=="20")
			{
				makeSelect("mhCategoryDiv2", "", "","", "mhCategory2", "<?=$txtdt['1733']?>"); //선택해주세요
			}
			else
			{
				makeSelect("mhCategoryDiv2", obj["mCate2List"], "mcCode02",obj["mhCategory2"], "mhCategory2", "<?=$txtdt['1172']?>"); //선택해주세요
			}
		}
		else if(obj["apiCode"]=="chkhubcode") //코드 중복체크
		{
			if(obj["resultCode"] == "200")
			{
				$("#chkcodeText").css("color", "blue");
				$("#chkcodeText").text("<?=$txtdt['1476']?>"); //사용 가능합니다.
				$("#chk_code").val(1);
				
			}
			else if(obj["resultCode"] == "999")
			{				
				$("#chkcodeText").css("color", "red");
				$("#chkcodeText").text("<?=$txtdt['1767']?>"); //이미 사용중인 본초코드입니다.
				$("#chk_code").val(0);	
			}
		}
		else if(obj["apiCode"]=="configinfo")
		{
			$("input[name=ftpHost]").val(obj["ftpHost"]);
			$("input[name=ftpPort]").val(obj["ftpPort"]);
			$("input[name=ftpUser]").val(obj["ftpUser"]);
			$("input[name=ftpPass]").val(obj["ftpPass"]);
			$("input[name=ftpDir]").val(obj["ftpDir"]);
		}
    }

	function goHubcategory(obj)
	{
		var name = obj.name;
		var txt = obj.options[obj.selectedIndex].text;
		var val = obj.options[obj.selectedIndex].value;
		var url = "mcCode="+val;

		callapi('GET','medicine','hubcategory',url); 	//본초 분류 API 호출
	}

	callapi('GET','medicine','hubdesc','<?=$apidata?>'); 	//본초 상세 API 호출 & 본초 상세 옵션(분류, 성미귀경사상 중독) API 호출
	$("input[name=mhCode]").focus();
</script>
