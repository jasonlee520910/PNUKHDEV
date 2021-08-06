<?php //고유처방 상세
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
</style>
<!--// page start -->
<input type="hidden" name="modifyAuth" class="" value="<?=$modifyAuth?>">
<input type="hidden" name="seq" class="reqdata" value=""/>
<input type="hidden" name="rcCode" class="reqdata" value=""/>
<input type="hidden" name="apiCode" class="reqdata" value="uniquescupdate">
<input type="hidden" name="returnData" class="reqdata" value="<?=$root?>/Skin/Recipebasic/UniquePrescriptionList.php">

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
					<th><span class="nec"><?=$txtdt["1355"]?><!-- 출처/처방서적 --></span></th>
					<td>
						<input type="hidden" name="rcSource" class="reqdata necdata" value="" title="<?=$txtdt["1355"]?>" /><span id="rbSource"></span>
						<a href="javascript:;" class="cw-btn viewlayer" onclick="javascript:viewlayerPopup(this);" data-bind="layer-recipebook" data-value="700,600">
						<span><?=$txtdt["1325"]?><!-- 처방서적검색 --></span></a>
					</td>
					<th rowspan="8" style="vertical-align:top;">
						<span class="nec"><?=$txtdt["1201"]?><!-- 약재구성 --></span>
						<br><br>
							<a href="javascript:;" class="cw-btn addmedi" onclick="javascript:viewlayerPopup(this);" data-bind="layer-medicine" data-value="700,600">
							<span><?=$txtdt["1220"]?><!-- 약재DB검색 --></span>
						</a>
						<span class="mg5 info-ex02"><?=$txtdt["1211"]?><!-- 약재추가 --></span>
					</th>
					<td rowspan="8" style="vertical-align:top;">
						<div id="medilist"></div>
					</td>
				</tr>
				<tr>
					<th><span class=""><?=$txtdt["1088"]?><!-- 목차/번호 --></span></th>
					<td id="rbIndex"></td>
				</tr>
				<tr>
					<th><span class="nec"><?=$txtdt["1323"]?><!-- 처방명 --></span></th>
					<td><input type="text" class="w90p reqdata necdata" name="rcTitle" title="<?=$txtdt["1323"]?>" value=""/></td>
				</tr>
				<tr>
					<th><span class="nec"><?=$txtdt["1335"]?><!-- 첩수 --></span></th>
					<td>
						<input type="text" name="rcChub" class="reqdata necdata" title="<?=$txtdt["1335"]?>" value=""/>
					</td>
				</tr>
				<tr>
					<th><span><?=$txtdt["1174"]?><!-- 설진단 --></span><!-- <span class="sw-btn viewchkpop"><?=$txtdt["1484"]?></span> --></th>
					<td>
						<!-- <div class="checkpop"></div> -->
						<input type="hidden" name="rcTingue" class="reqdata" title="<?=$txtdt["1174"]?>" value="">
						<p class="w100p" id="rcTingueDiv">
						</p>
						<!-- <div class="txtcls rcTinguetxt"></div> -->
					</td>
				</tr>
				<tr>
					<th><span><?=$txtdt["1083"]?><!-- 맥상 --></span><!-- <span class="sw-btn viewchkpop"><?=$txtdt["1484"]?></span> --></th>
					<td>
						<!-- <div class="checkpop"></div> -->
						<input type="hidden" name="rcPulse" class="reqdata" title="<?=$txtdt["1083"]?>" value="">
						<p class="w100p" id="rcPulseDiv">
						</p>
						<!-- <div class="txtcls rcPulsetxt"></div> -->
					</td>
				</tr>
				<tr>
					<th><span><?=$txtdt["1418"]?><!-- 효능 --></span></th>
					<td>
							<textarea class="text-area reqdata" name="rcEfficacy" title="<?=$txtdt["1418"]?>" style="height:50px;"></textarea>
					</td>
				</tr>
				<tr>
					<th><span><?=$txtdt["1311"]?><!-- 주치 --></span></th>
					<td>
							<textarea class="text-area reqdata" name="rcMaincure" title="<?=$txtdt["1311"]?>" style="height:50px;"></textarea>
					</td>
				</tr>
				<tr>
					<th><span><?=$txtdt["1120"]?><!-- 복용법 --></span></th>
					<td colspan="3">
						<textarea class="text-area reqdata" name="rcUsage" title="<?=$txtdt["1120"]?>"></textarea>
					</td>
				</tr>
				<tr>
					<th><span><?=$txtdt["1447"]?><!-- 상세 --></span></th>
					<td colspan="3">
						<textarea class="text-area reqdata" name="rcDetail" title="<?=$txtdt["1447"]?>"></textarea>
					</td>
				</tr>
				<tr>
					<th><span><?=$txtdt["1185"]?><!-- 승인 --></span></th>
					<td colspan="3" id="rcStatusDiv">
						<ul class="water-list selstattd"  title="<?=$txtdt["1185"]?>"></ul>
					</td>
				</tr>
			</tbody>
		</table>

	<div class="btn-box c" id="btnDiv"></div>
</div>


<script>
	function uniquescupdate()
	{
		var rcTingue=rcPulse="";
		//설진단
		rcTingue = "";
		$("input:checkbox[name=rcchkTingue]:checked").each(function() {
			rcTingue+=","+this.value;
		});		
		$("input[name=rcTingue]").val(rcTingue);
		//맥상 
		rcPulse = "";
		$("input:checkbox[name=rcchkPulse]:checked").each(function() {
			rcPulse+=","+this.value;
		});
		$("input[name=rcPulse]").val(rcPulse);

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

			callapi("POST","recipe","uniquescupdate",jsondata);
		}
	}
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
	function initialize_table()
	{
		$("#medicinetbl").tableDnD({
			onDragClass: "dragRow",
			//드래그한 후 드롭이벤트가 일어날 경우의 이벤트 
			onDrop: function(table, row) {
				//console.log("드롭!!"); 
				resetmedi();
			},
			onDragStart: function(table, row) { 
				//console.log("드래그 시작!"); 
			}

		});

		
	}

	//------------------------------------------------------------------------------------
	// 설진단, 맥상
	//------------------------------------------------------------------------------------
	function parsechkcodes(pgid, list, title, name, data)
	{
		var str = checked = idstr = idname="";
		var darr = "";
		var j=0;
		if(!isEmpty(data))
			darr = data.split(",");

		str = "<dl class='chkdl'>";

		for(var key in list)
		{
			checked = "";
			for(var i=1;i<darr.length;i++)
			{
				if(darr[i] == list[key]["cdCode"])
				{
					checked = "checked";
				}
			}
			idstr = "0" + j;
			idstr = idstr.slice(-2);
			idname = name + "-" +idstr;

			str+="<dd class='w30p'>";
			str+="<input type='checkbox' name='"+name+"' id='"+idname+"' title='"+title+"' value='"+list[key]["cdCode"]+"' "+checked+" >";
			str+="<label for='"+idname+"'>"+list[key]["cdName"]+"</label>";
			str+="</dd>";
			j++;
		}

		str+="</dl>";

		$("#"+pgid).html(str);
	}
	//약재리스트에서 첩당약재에서 약재량 입력시 
	function chubamt_keyup()
	{
		//resetamount();
		resetmedi();
	}
    function makepage(json)
    {
    	var obj = JSON.parse(json);
		console.log(obj);

		if(obj["apiCode"] == 'uniquescdesc')
		{
			var seq = (!isEmpty(obj["seq"])) ? obj["seq"] : "";
			var date = getNowFull(4);
			var rcCode = (!isEmpty(obj["rcCode"])) ? obj["rcCode"] : "RC"+date;

			console.log("date= "+date+", rccode = " +rcCode );
			$("input[name=seq]").val(seq);
			$("input[name=rcCode]").val(rcCode);
		
			//출처/처방서적 
			$("input[name=rcSource]").val(obj["rcSource"]);
			$("#rbSource").text(obj["rbSourcetxt"]);
			//목차/번호 
			var rbIndex = (isEmpty(obj["rbIndex"]) ? "-" : obj["rbIndex"]) + " / " + (isEmpty(obj["rbBookno"]) ? "-" : obj["rbBookno"]);
			$("#rbIndex").text(rbIndex);
			//처방명
			$("input[name=rcTitle]").val(obj["rcTitle"]);
			//첩수 
			var rcChub=isEmpty(obj["rcChub"]) ? "1" : obj["rcChub"];
			$("input[name=rcChub]").val(rcChub);
			//주치 
			$("textarea[name=rcMaincure]").val(obj["rcMaincure"]);
			//효능 
			$("textarea[name=rcEfficacy]").val(obj["rcEfficacy"]);
			//복용법 
			$("textarea[name=rcUsage]").val(obj["rcUsage"]);
			//상세 
			$("textarea[name=rcDetail]").val(obj["rcDetail"]);
			//구성약재 
			$("input[name=rcMedicine]").val(obj["rcMedicine"]);

			//설진단
			$("input[name=rcTingue]").val(obj["rcTingue"]);
			//맥상
			$("input[name=rcPulse]").val(obj["rcPulse"]);
			
			
			var selDecoc = parsedecocodes(obj["dcTypeList"], '<?=$txtdt["1649"]?>', 'rcDecoctype', null);
			$("#boardviewDiv").prepend("<textarea name='selDecoctype' style='display:none;'>"+selDecoc+"</textarea>");

			//설진단
			parsechkcodes("rcTingueDiv", obj["tingueList"], '<?=$txtdt["1174"]?>', "rcchkTingue", obj["rcTingue"]);
			//맥상 
			parsechkcodes("rcPulseDiv", obj["pulseList"], '<?=$txtdt["1083"]?>', "rcchkPulse", obj["rcPulse"]);
			//승인 
			parseradiocodes("rcStatusDiv", obj["rcStatusList"], '<?=$txtdt["1185"]?>', "rcStatus", "water-list", obj["rcStatus"]);

			//------------------------------------------
			// 약재리스트
			//------------------------------------------
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

			if(Auth=="true")
			{
				btnHtml='<a href="javascript:;" onclick="uniquescupdate();" class="bdp-btn"><span><?=$txtdt["1070"]?></span></a> ';//저장하기 
				btnHtml+='<a href="javascript:;" onclick="viewlist();" class="bw-btn"><span><?=$txtdt["1087"]?></span></a> ';//목록 
				if(!isEmpty(obj["seq"]))
					btnHtml+='<a href="javascript:;" onclick="callapidel(\'recipe\',\'uniquescdelete\',\''+json+'\')" class="bdp-btn"><span><?=$txtdt["1154"]?></span></a>';//삭제하기 
			}
			else
			{
				btnHtml+='<a href="javascript:;" onclick="viewlist();" class="bw-btn"><span><?=$txtdt["1087"]?></span></a> ';//목록 
			}

			$("#btnDiv").html(btnHtml);

		}
		else if(obj["apiCode"] == "medicinelist") //약재리스트
		{
			var data = "";
			var capa = 0;
			$("#laymedicinetbl tbody").html("");

			if(!isEmpty(obj["list"]))
			{
				$(obj["list"]).each(function( index, value )
				{
					capa = (isNaN(value["mdProperty"])==false) ? value["mdProperty"] : 0;
					data+='<tr class="putpopdata" onclick="javascript:putpopdata(this);" data-code="'+value["mdCode"]+'" data-property="'+capa+'">';
					data+='<td>'+value["mhTitle"]+'</td>';
					data+='<td>'+value["mdTitle"]+'</td>';
					data+='<td>'+value["mdOrigin"]+'/'+value["mdMaker"]+'</td>';
					data+='<td>'+capa+'</td>';
					data+='<td>'+value["mdPrice"]+' <?=$txtdt["1235"]?> </td>';
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
			var layerpage=$("#layer_medicine_wrap").hasClass("layer-wrap");//약재추가 팝업 테이블
			console.log("layerpage = " + layerpage);

			var selDecoc = parsedecocodes(obj["decoctypeList"], '<?=$txtdt["1367"]?>', 'rcDecoctype', null);
			$("#board-list-wrap").prepend("<textarea name='selDecoctype' style='display:none;'>"+selDecoc+"</textarea>");

			var dismatch = "_"+obj["dismatch"]; //여기에 _를 붙여야지.. 밑에 dismatch.indexOf(rcmedicine) != -1 이 인식이됨..머지?
			var poison = "_"+obj["poison"]; //여기에 _를 붙여야지.. 밑에 poison.indexOf(rcmedicine) != -1 이 인식이됨..머지?
			var data = medilist = medicode = cls = clstitle = "";
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

				//감미제, 녹용, 자하거 
				//parsesweets("sweetDiv", obj["sweet"], '<?=$txtdt["1146"]?>', '<?=$txtdt["1018"]?>');

				capa = (isNaN(value["rcCapa"])==false) ? value["rcCapa"] : 0;

				//"rcWaterchk","rcWatercode","rcWater"

				if(layerpage == false)
				{

					data+='<tr class="meditr" id="md'+value["rcMedicode"]+'">';
					//data+='	<td class="rccode">'+value["rcMedicode"]+'</td>';  //팀장님께서 약재코드 안보이게 처리하라고하심(20190516)
					data+='	<td><input type="hidden" name="rccode" class="rccode necdata" value="'+value["rcMedicode"]+'" />'+$("textarea[name=selDecoctype]").val()+'</td>';
					data+='	<td>'+value["mdtitle"]+'</td>';  //han_medicine 약재명
					data+='	<td><input type="text" name="nchubamt" class="w60p tc chubamt necdata" value="'+capa+'" title="<?=$txtdt["1334"]?>" style="text-align:right;" maxlength="6" onfocus="this.select();" onkeyup="chubamt_keyup()"  onchange="changeNumber(event,true);" /> g<input type="hidden" id="id_mprice" class="mgprice" value="'+value["rcPrice"]+'" /></td>';  //g
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

					medicode+="|"+value["rcMedicode"]+","+value["rcCapa"]+","+value["rcDecoctype"];
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


			}
						
			initialize_table();
		}
		else if(obj["apiCode"] == "forsclist") //처방서적검색 
		{
			var data=rbIndex=rbBookno='';
			

			$("#forsclisttbl tbody").html("");

			if(!isEmpty(obj["list"]))
			{
				$(obj["list"]).each(function( index, value )
				{
					rbIndex = isEmpty(value["rbIndex"]) ? "-" : value["rbIndex"];
					rbBookno = isEmpty(value["rbBookno"]) ? "-" : value["rbBookno"];
					data+='<tr style="cursor:pointer;" onclick="javascript:putpopdata(this);">';
					data+='<td>'+value["rbCode"]+'</td>';
					data+='<td>'+value["rbTitle"]+'</td>';
					data+='<td>'+rbIndex+'</td>';
					data+='<td>'+rbBookno+'</td>';
					data+='</tr>';
				});
			}
			else
			{
				data+="<tr>";
				data+="	<td colspan='4'><?=$txtdt['1665']?></td>";
				data+="</tr>";
			}
			$("#forsclisttbl tbody").html(data);

			//페이지
			getsubpage("recipebooklistpage",obj["tpage"], obj["page"], obj["block"], obj["psize"]);
		}

        return false;
    }

	callapi('GET','recipe','uniquescdesc','<?=$apidata?>'); 	//고유처방  상세 API 호출

	$("input[name=rcTitle]").focus();
</script>
