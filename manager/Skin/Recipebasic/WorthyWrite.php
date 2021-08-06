<?php //실속처방 상세
	$root = "../..";
	include_once $root."/_common.php";
	$apidata="seq=".$_GET["seq"];
?>
<style>
	#medilist{border:0;}
	#medilist td{border:1;border-top:1px solid #ddd;}
	#sweetlist{border:0;border-right:1px solid #ddd;border-left:1px solid #ddd;}
	#sweetlist td{border:1;border-top:1px solid #ddd;border-left:1px solid #ddd;border-right:1px solid #ddd;}

	/* 약재목록 drag 선택 */
	.dragRow {background-color: #86E57F;}

	/* 파우치, 한약박스 리스트 */
	.poutch-list{overflow:hidden; margin:0 -1%;}
	.poutch-list li{ float:left;width:22%;height:150px; margin:0 1% 1% 1%;text-align:left;}
	.poutch-list li .check-box{display:block}
	.poutch-list li .check-box span{ display:block;text-align:center;}
	.poutch-list li .check-box .btxt{padding-top:7px;font-size:13px;}
	.poutch-list li .check-box .stxt{color:#949494}
	.poutch-list li .check-box label{display:block; padding:0;}
	.poutch-list li .check-box img{width:100%; height:80px;border:1px solid #d7d7d7;box-sizing:border-box}

	/* 승인미승인 리스트  */
	.rcstatus-list{overflow:hidden;}
	.rcstatus-list li {position:relative; width:15%;float:left;text-align:left;}
	
	/* 약재, 별전등 색상 보여주기 */
	span.mdtype{display:inline-block;width:15px;height:15px;border-radius:50%;margin-right:5px;line-height:100%;vertical-align:middle;}
	.mdsweet{background-color:#f2C2D6;}
	.mdmedi{background-color:#8BE0ED;}
	.sugar{background-color:#01DF74;}

</style>
<!--// page start -->
<input type="hidden" name="modifyAuth" class="" value="<?=$modifyAuth?>">
<input type="hidden" name="seq" class="reqdata" value=""/>
<input type="hidden" name="rcCode" class="reqdata" value=""/>
<input type="hidden" name="apiCode" class="reqdata" value="worthyupdate">
<input type="hidden" name="returnData" class="reqdata" value="<?=$root?>/Skin/Recipebasic/WorthyList.php">

<div class="board-view-wrap" id="boardviewDiv">
	<span class="bd-line"></span>
		<table>
			<caption><span class="blind"></span></caption>

			<colgroup>
				<col width="170">
				<col width="*"> 
				<col width="170">
				<col width="*"> 
			</colgroup>
			<tbody>
				<tr>
					<th><span class="nec"><?=$txtdt["1323"]?><!-- 처방명 --></span></th>
					<td><input type="text" class="w90p reqdata necdata" name="rcTitle" title="<?=$txtdt["1323"]?>" value=""/></td>
					<th rowspan="8" style="vertical-align:top;">
						<span class="nec"><?=$txtdt["1201"]?><!-- 약재구성 --></span>
						<br><br>
							<a href="javascript:;" class="cw-btn addmedi" onclick="javascript:viewlayerPopup(this);" data-bind="layer-medicine" data-value="750,600">
							<span><?=$txtdt["1220"]?><!-- 약재DB검색 --></span>
						</a>
						<span class="mg5 info-ex02"><?=$txtdt["1211"]?><!-- 약재추가 --></span>
					</th>
					<td rowspan="8" style="vertical-align:top;">
						<div id="medilist"></div>
					</td>
				</tr>
				
				<tr>
					<th><span class="nec"><?=$txtdt["1335"]?><!-- 첩수 --></span></th>
					<td>
						<input autocomplete="off" type="text" name="rcChub" class="w20p tc reqdata necdata" title="<?=$txtdt["1335"]?>" value="" maxlength="4" onfocus="this.select();" onchange="changeNumber(event, false);" /><span class="mg5"> ea</span>
					</td>
				</tr>
				<tr>
					<th><span class="nec"><?=$txtdt["1384"]?><!-- 팩수 --></span></th>
					<td>
						<input autocomplete="off" type="text" class="w20p tc reqdata necdata" title="<?=$txtdt["1384"]?>" id="rcPackcnt" name="rcPackcnt" value=""  maxlength="3" onfocus="this.select();" onchange="changeNumber(event, false);" /> <span class="mg5"> <?=$txtdt["1018"]?><!-- 개 --></span>
					</td>
				</tr>
				<tr>
					<th><span class="nec"><?=$txtdt["1386"]?><!-- 팩용량 --></span></th>
					<td>
						<input autocomplete="off" type="text" class="w20p tc reqdata necdata" title="<?=$txtdt["1386"]?>" id="rcPackcapa"name="rcPackcapa" value=""  maxlength="3" onfocus="this.select();" onchange="changeNumber(event, false);"  /> <span class="mg5"> ml</span>
					</td>
				</tr>
				<tr>
					<th><span class="nec"><?=$txtdt["1470"]?><!-- 파우치 --></span></th>
					<td id="odPacktypeDecocDiv">
					</td>
				</tr>
				<tr>
					<th><span class="nec"><?=$txtdt["1438"]?><!-- 한약박스 --></span></th>
					<td id="reBoxmediDiv">
					</td>
				</tr>
				<tr>
					<th><span><?=$txtdt["1185"]?><!-- 승인 --></span></th>
					<td id="rcStatusDiv">
						<ul class="water-list selstattd"  title="<?=$txtdt["1185"]?>"></ul>
					</td>
				</tr>
			</tbody>
		</table>

	<div class="btn-box c" id="btnDiv"></div>
</div>


<script>
	//20191014 : 약재검색 
	function viewlayerPopup(obj)
	{
		var url=obj.getAttribute("data-bind");
		var size=obj.getAttribute("data-value");
		var data = "";
		if(url == 'layer-recipebook')
			data = "&page=1&psize=8&block=10"; //page,psize,block 사이즈 초기화
		else
			data = "&page=1&psize=5&block=10"; //page,psize,block 사이즈 초기화
		console.log("=========>>>> viewlayerPopup url = " + url+", size = " + size);

		getlayer(url,size,data);
	}

	// 20191014 : 테이블 drag
	function initialize_table()
	{
		$("#medicinetbl").tableDnD({
			onDragClass: "dragRow",
			//드래그한 후 드롭이벤트가 일어날 경우의 이벤트 
			onDrop: function(table, row) {
				resetmedi();
			},
			onDragStart: function(table, row) { 
			}

		});
	}
	//------------------------------------------------------------------------------------
	// 20191014 : 파우치, 한약박스 
	//------------------------------------------------------------------------------------
	function parsepackcodes(pgid, list, name, data)
	{
		var allstr = opstr = imgstr = checked = path = "";
		var i=0;
		opstr = "";
		
		for(var key in list)
		{
			checked = "";
			if(!isEmpty(data))
			{
				if(data == list[key]["pbCode"])
				{
					checked = "checked";
				}
			}
			else if(i == 0)
			{
				checked = "checked";
			}


			if(list[key]["pbCode"]=="RBM200117151838" || list[key]["pbCode"]=="PCB190710182024" || list[key]["pbCode"]=="PCB200117151735" )
			{
				///안보이게 처리함
				/*						
					RBM200117151838
					reBoxmedi
					사전조제한약박스

					PCB190710182024
					odPacktype
					파우치없음

					PCB200117151735
					odPacktype
					사전조제파우치							
				*/
			}
			else
			{
				opstr += '<li>';
				opstr += '<p class="check-box" onchange="">';
				opstr += '<input type="radio" id="pack-'+name+'-'+i+'" name="'+name+'" value="'+list[key]["pbCode"]+'" class="radiodata"  data-capa="'+list[key]["pbCapa"]+'"  '+checked+' />';
				opstr += '<label for="pack-'+name+'-'+i+'">';


				/*
				if(!isEmpty(list[key]["afThumbUrl"]) && list[key]["afThumbUrl"]!="NoIMG")
				{
					opstr += '<img src="'+getUrlData("FILE_DOMAIN")+list[key]["afThumbUrl"]+'" onerror="this.src=\'<?=$root?>/_Img/Content/noimg.png\'" />';
				}
				else
				{
					opstr += '<img src="<?=$root?>/_Img/Content/noimg.png" alt=""/>';
				}
				*/

				if(!isEmpty(list[key]["afThumbUrl"]) && list[key]["afThumbUrl"]!="NoIMG")
				{
					if(list[key]["afThumbUrl"].substring(0,4)=="http")
					{
						opstr += '<img src="'+list[key]["afThumbUrl"]+'" onerror="this.src=\'<?=$root?>/_Img/Content/noimg.png\'" />';
					}
					else
					{
						opstr += '<img src="'+getUrlData("FILE_DOMAIN")+list[key]["afThumbUrl"]+'" onerror="this.src=\'<?=$root?>/_Img/Content/noimg.png\'" />';
					}
				}
				else
				{
					opstr += '<img src="<?=$root?>/_Img/Content/noimg.png" alt=""/>';
				}
				opstr += '<span class="btxt">'+list[key]["pbTitle"]+'</span>';
				opstr += '</label>';
				opstr += '</p>';
				opstr += '</li>';
				i++;
			}
		}

		allstr="";
		allstr = '<ul class="poutch-list">';
		allstr += opstr;
		allstr += '</ul>';

		$("#"+pgid).html(allstr);
	}
	//20191015 : 약재리스트에서 첩당약재에서 약재량 입력시
	function chubamt_keyup()
	{
		resetmedi();
	}
	//20191015 : 실속처방 저장 하기 
	function worthyupdate()
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

			callapi("POST","recipe","worthyupdate",jsondata);
		}
	}
    function makepage(json)
    {
    	var obj = JSON.parse(json);
		console.log(obj);

		if(obj["apiCode"] == 'worthydesc')
		{
			var seq = (!isEmpty(obj["seq"])) ? obj["seq"] : "";
			var date = getNowFull(4);
			var rcCode = (!isEmpty(obj["rcCode"])) ? obj["rcCode"] : "RC"+date;

			$("input[name=seq]").val(seq);
			$("input[name=rcCode]").val(rcCode);

			//처방명
			if(!isEmpty(seq))
			{
				$("input[name=rcTitle]").val(obj["rcTitle"]);
				$("input[name=rcTitle]").attr("readonly",true); 
			}
			else
			{
				$("input[name=rcTitle]").val(obj["rcTitle"]);
			}
			//첩수
			$("input[name=rcChub]").val(obj["rcChub"]);
			//팩수
			$("input[name=rcPackcnt]").val(obj["rcPackcnt"]);
			//팩용량 
			$("input[name=rcPackcapa]").val(obj["rcPackcapa"]);

			//파우치 
			parsepackcodes("odPacktypeDecocDiv", obj["odPacktypeList"], 'rePacktype', obj["rcPacktype"]);
			//한약박스종류선택
			parsepackcodes("reBoxmediDiv", obj["reBoxmediList"], 'reBoxmedi', obj["rcMedibox"]);
			//승인 
			parseradiocodes("rcStatusDiv", obj["rcStatusList"], '<?=$txtdt["1185"]?>', "rcStatus", "rcstatus-list", obj["rcStatus"]);

			//약재리스트
			var medicine=(!isEmpty(obj["rcMedicine"])) ? obj["rcMedicine"] : "";
			var data = "medicine="+medicine+"&sweet="+obj["rcSweet"];
			console.log("data = " + data);
			$("#medilist").load("<?=$root?>/Skin/Recipebasic/RecipeMedicine.php?" + data);

			//------------------------------------------
			// 버튼 
			//------------------------------------------
			var btnHtml='';
			var json = "seq="+obj["seq"];
			var Auth = $("input[name=modifyAuth]").val();

			if(!isEmpty(obj["seq"]) && (obj["rcStatus"]=="F"))
			{
				if(Auth=="true")
				{
					btnHtml='<a href="javascript:;" onclick="worthyupdate();" class="bdp-btn"><span><?=$txtdt["1070"]?></span></a> ';//저장하기 
					btnHtml+='<a href="javascript:;" onclick="viewlist();" class="bw-btn"><span><?=$txtdt["1087"]?></span></a> ';//목록 
					if(!isEmpty(obj["seq"]))
						btnHtml+='<a href="javascript:;" onclick="callapidel(\'recipe\',\'worthydelete\',\''+json+'\')" class="bdp-btn"><span><?=$txtdt["1154"]?></span></a>';//삭제하기 
				}
				else
				{
					btnHtml+='<a href="javascript:;" onclick="viewlist();" class="bw-btn"><span><?=$txtdt["1087"]?></span></a> ';//목록 
				}

				$("#btnDiv").html(btnHtml);
			}
			else
			{
				if(Auth=="true")
				{
					btnHtml='<a href="javascript:;" onclick="worthyupdate();" class="bdp-btn"><span><?=$txtdt["1070"]?></span></a> ';//저장하기 
					btnHtml+='<a href="javascript:;" onclick="viewlist();" class="bw-btn"><span><?=$txtdt["1087"]?></span></a> ';//목록 
					if(!isEmpty(obj["seq"]))
						btnHtml+='<a href="javascript:;" onclick="callapidel(\'recipe\',\'worthydelete\',\''+json+'\')" class="bdp-btn"><span><?=$txtdt["1154"]?></span></a>';//삭제하기 
				}
				else
				{
					btnHtml+='<a href="javascript:;" onclick="viewlist();" class="bw-btn"><span><?=$txtdt["1087"]?></span></a> ';//목록 
				}

				$("#btnDiv").html(btnHtml);						
			}

		}
		else if(obj["apiCode"] == "medicinelist") //약재리스트
		{
			var data = "";
			var miGrade="E";//20191014 : 일단은 기본인 E등급으로 가격을 보이게 하자 
			var capa = 0;
			$("#laymedicinetbl tbody").html("");

			if(!isEmpty(obj["list"]))
			{
				$(obj["list"]).each(function( index, value )
				{
					var mdprice=value["mdPriceE"];
					
					capa = (isNaN(value["mdProperty"])==false) ? value["mdProperty"] : 0;
					data+='<tr class="putpopdata" onclick="javascript:putpopdata(this);" data-code="'+value["mdCode"]+'" data-smu="'+value["mmCode"]+'" data-property="'+capa+'" data-type="'+value["mdType"]+'">';
					data+='<td class="td_text_overflow">'+value["mdTypeName"]+'</td>';
					data+='<td class="td_text_overflow">'+value["mhTitle"]+'</td>';

					if(value["mdType"]=="medicine")
					{
						spancls="mdmedi";
					}
					else
					{
						spancls="mdsweet";
					}
					data+='<td class="td_text_overflow l"><span class="mdtype '+spancls+'"></span>'+value["mmtitle"]+'</td>';  //medicine 테이블이 아니라 medicine_djmedi 테이블에 있는 약재명이 보임(190524수정함)
					data+='<td class="td_text_overflow l">'+value["mdOrigin"]+'/'+value["mdMaker"]+'</td>';
					data+='<td>'+mdprice+' <?=$txtdt["1235"]?> </td>';
					data+='</tr>';
				});
			}
			else
			{
				data+="<tr>";
				data+="	<td colspan='5'><?=$txtdt['1665']?></td>";
				data+="</tr>";
			}
			$("#laymedicinetbl tbody").html(data);

			//페이징
			getsubpage_pop("medicinelistpage",obj["tpage"], obj["page"], obj["block"], obj["psize"], obj["reData"]);
		}
		else if(obj["apiCode"]=="medicinetitle") //약재구성
		{
			var boardpage=$("#board-list-wrap").hasClass("board-list-wrap");//약재리스트 테이블
			var layerpage=$("#layer_medicine_wrap").hasClass("layer-wrap");//약재추가 팝업 테이블
			console.log("boardpage = "+boardpage+", layerpage = " + layerpage);

			var selDecoc = parsedecocodes(obj["decoctypeList"], '<?=$txtdt["1367"]?>', 'rcDecoctype', null);
			$("#board-list-wrap").prepend("<textarea name='selDecoctype' style='display:none;'>"+selDecoc+"</textarea>");

			var dismatch = "_"+obj["dismatch"]; //여기에 _를 붙여야지.. 밑에 dismatch.indexOf(rcmedicine) != -1 이 인식이됨..머지?
			var poison = "_"+obj["poison"]; //여기에 _를 붙여야지.. 밑에 poison.indexOf(rcmedicine) != -1 이 인식이됨..머지?
			var data=medilist=medicode=sweetcode=cls=clstitle="";
			var capa = 0;
			var decoc=[];


			$(obj["medicine"]).each(function( index, value )
			{
				var rcmedicine = value["rcMedicode"];

				if(dismatch.indexOf(rcmedicine) != -1) //
				{
					cls="dismatch";
					clstitle='<span style="color:red"><?=$txtdt["1158"]?></span>';//상극
				}
				else if(poison.indexOf(rcmedicine) != -1)
				{
					cls="poison";
					clstitle='<span style="color:#444"><?=$txtdt["1064"]?></span>';//독성
				}
				else
				{
					cls="";
					clstitle="-";
				}

				capa = parseFloat(value["rcCapa"]);
				capa = (isNaN(capa)==false) ? capa : 0;
				capa = !isEmpty(capa) ? capa : 0;
				capa = capa.toFixed(1);//소수점 1자리


				if(layerpage == false)
				{
					data+='<tr class="meditr" id="md'+value["rcMedicode"]+'">';
					data+='	<td><input type="hidden" name="rccode" class="rccode necdata" value="'+value["rcMedicode"]+'" />'+$("textarea[name=selDecoctype]").val()+'</td>';
					data+='	<td>'+value["rcMedititle"]+'</td>';  //청연 약재명
					data+='	<td>'+value["rcOrigin"]+'/'+value["rcMaker"]+'</td>';  //청연 원산지/제조사
					data+='	<td><input type="text" name="nchubamt" class="w60p tc chubamt necdata" value="'+capa+'" title="<?=$txtdt["1334"]?>" style="text-align:right;" maxlength="6" onfocus="this.select();" onkeyup="chubamt_keyup()"  onchange="changeNumber(event,true);" /> g</td>';  //g
					data+='	<td>'+clstitle+'</td>';  //상극 OR 독성
					data+='	<td><a style="text-decoration:none;font-weight:normal;" href="javascript:deletemedi(\''+value["rcMedicode"]+'\');">X</a></td>';
					data+='</tr>';

					decoc.push(value["rcDecoctype"]);
				}
				else if(layerpage == true)
				{
					medilist+="<dt class='"+cls+"'>";
					medilist+="	<span class='delspan'>";
					medilist+="		<span class='delbtn' value='"+value["rcMedicode"]+"'>X</span>";
					medilist+="	</span>";
					medilist+=" "+value["rcMedititle"]+","+capa;
					medilist+="</dt>";
					medilist+="<dd>";
					medilist+="	<input type='text' /> g";
					medilist+="</dd>";

					medicode+="|"+value["rcMedicode"]+","+value["rcCapa"]+","+value["rcDecoctype"]+",0";
				}

			});

			sweetcode="";
			$(obj["sweet"]).each(function( index, value )
			{
				var rcmedicine = value["rcMedicode"];

				if(dismatch.indexOf(rcmedicine) != -1) //
				{
					cls="dismatch";
					clstitle='<span style="color:red"><?=$txtdt["1158"]?></span>';//상극
				}
				else if(poison.indexOf(rcmedicine) != -1)
				{
					cls="poison";
					clstitle='<span style="color:#444"><?=$txtdt["1064"]?></span>';//독성
				}
				else
				{
					cls="";
					clstitle="-";
				}

				capa = parseFloat(value["rcCapa"]);
				capa = (isNaN(capa)==false) ? capa : 0;
				capa = !isEmpty(capa) ? capa : 0;
				capa = capa.toFixed(1);//소수점 1자리


				if(layerpage == false)
				{
					data+='<tr class="nodrag nodrop meditr" id="md'+value["rcMedicode"]+'">';
					data+='	<td><input type="hidden" name="srccode" class="srccode necdata" value="'+value["rcMedicode"]+'" /><input type="hidden" class="srcDecoctype" value="inlast">별전</td>';
					data+='	<td>'+value["rcMedititle"]+'</td>';  //청연 약재명
					data+='	<td>'+value["rcOrigin"]+'/'+value["rcMaker"]+'</td>';  //청연 원산지/제조사
					data+='	<td><input type="text" name="nchubamt" class="w60p tc schubamt necdata" value="'+capa+'" title="<?=$txtdt["1334"]?>" style="text-align:right;" maxlength="6" onfocus="this.select();" onkeyup="chubamt_keyup()"  onchange="changeNumber(event,true);" /> g</td>';  //g
					data+='	<td>'+clstitle+'</td>';  //상극 OR 독성
					data+='	<td><a style="text-decoration:none;font-weight:normal;" href="javascript:deletemedi(\''+value["rcMedicode"]+'\');">X</a></td>';
					data+='</tr>';

					decoc.push(value["rcDecoctype"]);
				}
				else if(layerpage == true)
				{
					medilist+="<dt class='"+cls+"'>";
					medilist+="	<span class='delspan'>";
					medilist+="		<span class='delbtn' value='"+value["rcMedicode"]+"'>X</span>";
					medilist+="	</span>";
					medilist+=" "+value["rcMedititle"]+","+capa;
					medilist+="</dt>";
					medilist+="<dd>";
					medilist+="	<input type='text' /> g";
					medilist+="</dd>";

					sweetcode+="|"+value["rcMedicode"]+","+value["rcCapa"]+","+value["rcDecoctype"]+",0";
				}

			});

			//약재추가 팝업
			if(layerpage == true)
			{
				var txt = datatxt = "";

				if(!isEmpty(obj["dismatchtxt"]))
				{
					datatxt = obj["dismatchtxt"].replace("[DISMATCH]", "<?=$txtdt['1159']?>");//상극알람 
					txt+="<dl class='dismatchtxt'><dt><dd>"+datatxt+"</dd></dl>";
				}
				if(!isEmpty(obj["poisontxt"]))
				{
					datatxt = obj["poisontxt"].replace("[POISON]", "<?=$txtdt['1066']?>"); //독성알람
					txt+="<dl class='poisontxt'><dt><dd>"+datatxt+"</dd></dl>";
				}

				$("#stuff-tab").html(txt);


				$("#popmedilist").html(medilist);
				$("input[name=rcMedicine_pop]").val(medicode);
				$("input[name=rcSweet_pop]").val(sweetcode);
			}
			else if(layerpage == false)//약재리스트
			{
				$("#totMedicineDiv").text(obj["totMedicine"]);//총약재
				$("#totPoisonDiv").text(obj["totPoison"]);//독성
				$("#totDismatchDiv").text(obj["totDismatch"]);//상극

				$("#medicinetbl tbody").html(data);


				$.each(decoc, function(key, value){
					$("#medicinetbl tbody tr").eq(key).find("select").val(value);
				});

				resetmedi();
			}

			
			initialize_table();
		}
        return false;
    }

	callapi('GET','recipe','worthydesc','<?=$apidata?>'); 	//실속처방  상세 API 호출

	$("input[name=rcTitle]").focus();
</script>
