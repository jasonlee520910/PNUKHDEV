<?php
$root = "../..";
include_once ($root.'/_common.php');
if($_GET["seq"]=="add")
{
	$apidata="poGroup=";
	$seq="";
}
else
{
	$apidata="poGroup=".$_GET["seq"];
	$seq=$_GET["seq"];
}
?>
<style>
	/* 약재목록 drag 선택 */
	#policyTbl .dragRow td{background-color: #E4E7E6;}
</style>
<script>
	$.datepicker.setDefaults({
			dateFormat: 'yy.mm.dd',
			prevText: '이전 달',
      nextText: '다음 달',
      monthNames: ['1월', '2월', '3월', '4월', '5월', '6월', '7월', '8월', '9월', '10월', '11월', '12월'],
      monthNamesShort: ['1월', '2월', '3월', '4월', '5월', '6월', '7월', '8월', '9월', '10월', '11월', '12월'],
      dayNames: ['일', '월', '화', '수', '목', '금', '토'],
      dayNamesShort: ['일', '월', '화', '수', '목', '금', '토'],
      dayNamesMin: ['일', '월', '화', '수', '목', '금', '토'],
      showMonthAfterYear: true,
      yearSuffix: '년'
		});

	$(function(){
		//달력
		$("#poGroup").datepicker();
	})
</script>

<input type="hidden" name="apiCode" class="reqdata" value="policyupdate">
<input type="hidden" name="returnData" class="reqdata" value="<?=$root?>/Skin/Board/PolicyWrite.php">
<textarea name="selstat" id="poTypeSel" rows="10" cols="70%" style="display:none;"></textarea>
<textarea name="selcols" id="poColsSel" rows="10" cols="70%" style="display:none;"></textarea>
<textarea name="selrows" id="poRowsSel" rows="10" cols="70%" style="display:none;"></textarea>
<div class="board-view-wrap">
	<span class="bd-line"></span>
	<table>
		<caption><span class="blind"></span></caption>
		<colgroup>
			<col width="13%">
			<col width="*">
		</colgroup>
		<tbody>
			<tr>
				<th>날짜</th>
				<td><input title='개인정보처리방침날짜' value='' class='reqdata searperiod necdata' type='text' id='poGroup' name='poGroup' readonly>
				<?php if(isEmpty($seq)==false){ ?>
					<a href="javascript:;" class="cw-btn">
					<span class="" onclick="policyrechange();">+ 개인정보처리방침변경</span>
					</a>
					<a href="javascript:;" class="cw-btn">
					<span class="" onclick="policyorderchange();">+ 순서변경</span>
					</a>
				<?php } ?>
				</td>
			</tr>

		</tbody>
	</table>

	<div class="gap"></div>

	<h3 class="u-tit02">내용추가</h3>
	<span class="bd-line"></span>
	<div class="addBtn">
	 	<a href="javascript:;" class="cw-btn">
			<span class="modinput_" onclick="modinputpolicy('add_policy','')">+ 추가</span>
		</a>
	</div>
	<div class="board-list-wrap">
		<table class="thetbl memlist">
			<caption><span class="blind"></span></caption>
				<col width="9%">
				<col width="12%">
				<col width="*">
				<col width="9%">
			<thead>
				<tr>
					<th>순서</th>
					<th>타입</th>
					<th>내용</th> 
					<th></th> 
				</tr>
			</thead>
			<tbody class="policylisttext" id="policyTbl">
			</tbody>
		</table>
	</div>

	<div class="btn-box c" id="btnDiv"></div>
</div>

<!--// page end -->
<script>
	var ordered_items;
	function policyorderchange()
	{
		var poGroup=$("input[name=poGroup]").val();
		if(confirm(poGroup+" 순서를 변경하시겠습니까?")==true)
		{
			var jsondata={};
			jsondata["poGroup"] = poGroup;
			jsondata["poOrderData"] = ordered_items;
			console.log(JSON.stringify(jsondata));

			callapi('POST','board','policyorderchange',jsondata);
		}
	}
	function policyrechange()
	{
		var poGroup=$("input[name=poGroup]").val();
		if(confirm(poGroup+" 개인정보처리방침을 변경하시겠습니까?")==true)
		{
			var data="poGroup="+poGroup;
			callapi('GET','board','policyrechange',data);
		}
	}
	function initialize_table()
	{
		console.log("initialize_table");
		$("#policyTbl").tableDnD({ onDragClass: "dragRow",onDrop: function(table, row) {ordered_items=$.tableDnD.serialize("id");} 	});
	}
	function policydelete(seq)
	{
		var poGroup=$("input[name=poGroup]").val();
		var data="seq="+seq+"&poGroup="+poGroup;
		callapidel('board','policydelete',data)
	}
	function modinputpolicy(type,seq,potype,pocontents)
	{
		var arr0=arr1=arr2=arr3=arr4=arr5=arr6=arr7=read=add=worker=stat="";
		type=type.split("_");
		console.log("modinputpolicy type : "+type);

		$(".modconfirm").remove(0);
		$(".modfadeinput").removeClass("modfadeinput").fadeIn(0);
		console.log("modinputpolicy  type[0] : "+type[0]);

		if(type[0]=="add")
		{
			var arrtxt="자동추가";
			var reqdata="";
			arr0=seq="add";
		}
		else
		{
			var reqdata="reqdata";
			var read="readonly";
			var arr=new Array();
			$(".modinput_"+seq).children("td").each(function(){
				console.log($.trim($(this).text()));
				arr.push($.trim($(this).text()));		
			});
			arr0=arr[0];arr1=arr[1];arr2=arr[2];

			console.log("arr0 : "+arr0+", arr1 : "+arr1+", arr2 : "+arr2);
		}

		var txt=contents=contstyle="";

		if(potype=="700")
		{
			contstyle="display:none;";
			contents=decodeURI(pocontents);
			contents=!isEmpty(contents)?contents:"";
		}
		else
		{
			contstyle="";
			contents=arr2;
		}
		console.log("type[1] : "+type[1]+", contents = " + contents);

		switch(type[1])
		{
		case "policy":
			stat=$("textarea[name=selstat]").val();
			cstat=$("textarea[name=selcols]").val();
			rstat=$("textarea[name=selrows]").val();

			txt="<tr class='modconfirm' id='"+seq+"'>";
			txt+="<td class='l'>"+arr0+"<input type='hidden' name='poSeq' class='reqdata' value='"+seq+"'></td>";
			txt+="<td class='l'>"+stat+" <div id='tblinfodiv'>칸수:"+cstat+"<br>줄수:"+rstat+"</div></td>";//타입 
			txt+="<td class='l'><div id='contentsDiv'></div><div id='pobtnDiv'>URL:<input type='text' name='poBtnUrl' class='reqdata' value='' title='버튼링크'>버튼명:</div><textarea name='poContents' id='poContents' class='reqdata necdata' rows='3' cols='110' title='내용' style='"+contstyle+"'>"+contents+"</textarea></td>";//내용
			txt+="<td>";
			txt+=" <button type='button' class='cdp-btn'><span class='cdp-btn' onclick='policyupdate()'>저장</span></button>";
			if(seq!="add")
			{
				txt+=" <button type='button' class='cdp-btn'><span onclick='policydelete("+seq+")'><?=$txtdt['1153']?></span></button>";
			}
			txt+="</td></tr>";
			break;
		}

		if(type[0]=="add")
		{
			$("#policyTbl").prepend(txt);
		}
		else
		{
			if(type ==',policy')
			{
				$(".modinput_"+seq).addClass("modfadeinput").fadeOut(0);
				$(".modinput_"+seq).before(txt);
			}
		}

		if(!isEmpty(potype))
		{
			$("select[name=poType]").val(potype).prop("selected", true);
		}

		$("#tblinfodiv").hide();
		$("#pobtnDiv").hide();
		if(potype=="600")
		{
			$("#pobtnDiv").show();
		}
		else if(potype=="700")
		{
			$("#tblinfodiv").show();
			$("textarea[name=poContents]").val(contents);
			var txt=$("textarea[name=poContents]").val();
			var pContents=JSON.parse(contents);
			var rows=cols=1;
			if(!isEmpty(pContents))
			{
				rows=pContents.length;
				cols=pContents[0].length;

				$("#poRows option[value="+rows+"]").attr("selected", "selected");
				$("#poCols option[value="+cols+"]").attr("selected", "selected");
			}

			console.log("txt = " + txt+", rows = " + rows+", cols = " + cols);
			poTableChange();
		}

		initialize_table();

	}
	function policyupdate()
	{
		if(necdata()=="Y") //필수조건 체크
		{
			var key=data="";
			var jsondata={};

			$(".reqdata").each(function(){
				key=$(this).attr("name");
				data=$(this).val();
				jsondata[key] = data;
			});
			console.log(JSON.stringify(jsondata));
			callapi("POST","board","policyupdate",jsondata);
		}
	}
	function poTypeChange()
	{
		var type=$("select[name=poType]").children("option:selected").val();//$("select[name=poType]").val();
		$("#tblinfodiv").hide();
		$("#pobtnDiv").hide();
		if(type=="700")//도표 
		{
			$("#tblinfodiv").show();
			$("textarea[name=poContents]").css("display", "none");
		}
		else if(type=="600")//버튼
		{
			$("#pobtnDiv").show();
		}
	}
	function ptblcontents()
	{
		var cols=$("select[name=poCols]").children("option:selected").val();//$("select[name=poCols]").val();
		var rows=$("select[name=poRows]").children("option:selected").val();//$("select[name=poRows]").val();
		var jsonrows=[];
		var txt="";
		var i=j=0;
		for(i=0;i<rows;i++)
		{
			var jsoncols=[];
			for(j=0;j<cols;j++)
			{				
				txt=$("textarea[name=potable"+((i*cols)+j)+"]").val();
				txt=!isEmpty(txt)?txt:"";
				console.log("j="+j+", i="+i+", (i*cols)+j="+((i*cols)+j), ", txt : "+txt);
				jsoncols.push(txt);
			}
			jsonrows.push(jsoncols);
		}


		console.log(JSON.stringify(jsonrows));


		$("textarea[name=poContents]").val(JSON.stringify(jsonrows));

	}
	function poTableChange()
	{
		var poContents=!isEmpty($("textarea[name=poContents]").val())?JSON.parse($("textarea[name=poContents]").val()):null;

		console.log("poTableChange  poContents  "+poContents);

		var cols=$("select[name=poCols]").children("option:selected").val();//$("select[name=poCols]").val();
		var widthcols=parseInt(100/cols)-2;
		var colwidthdata=parseInt(100/cols);
		var rows=$("select[name=poRows]").children("option:selected").val();//$("select[name=poRows]").val();

		console.log("poTableChange cols = " + cols+", rows = " +rows+", colwidthdata = "+colwidthdata);
		var i=j=0;
		var txt="";
		$("#contentsDiv").html("");
		for(i=0;i<rows;i++)
		{
			for(j=0;j<cols;j++)
			{
				var jsdata="";
				if(!isEmpty(poContents)&&!isEmpty(poContents[i]))
				{
					jsdata=poContents[i][j];
				}
				else
				{
					if(i==0)
					{
						jsdata=colwidthdata;
					}
				}
				console.log("poTableChange  j="+j+", i="+i+", (i*cols)+j="+((i*cols)+j) +", jsdata = " + jsdata)
				txt+=" <textarea style='width:"+widthcols+"%' name='potable"+((i*cols)+j)+"' id='potable"+((i*cols)+j)+"' data-rows='"+i+"'  data-cols='"+j+"' class='reqdata potable' onkeyup='ptblcontents();'>"+jsdata+"</textarea> ";
			}
		}
		console.log(txt);
		$("#contentsDiv").html(txt);

		ptblcontents();

	}
	function viewContents(type, contents, link)
	{
		if(type=="600")
		{
			var data="";
			data+="<button>"+contents+"</button>";
			return data;
		}
		else if(type=="700")
		{
			var jsContents=JSON.parse(contents);
			var data="";

			data+="<table style='border:1px solid #e3e3e4;'>";
			for(var rows in jsContents)
			{
				data+="<tr>";
				for(var cols in jsContents[rows])
				{
					data+="<td>"+jsContents[rows][cols]+"</td>";
				}
				data+="</tr>";
			}
			data+="</table>";

			return data;
		}
		return contents; 
	}
	function makepage(json)
	{
		var obj = JSON.parse(json);
		console.log(obj)
		if(obj["apiCode"]=="policydesc") 
		{
			var delidate = (isEmpty(obj["poGroup"])) ? getNewDate() : obj["poGroup"];
			$("input[name=poGroup]").val(delidate);//배송희망일

			//내용타입 
			$("#poTypeSel").html("");
			var txt="<select class='reqdata resetcode w70p' name='poType' id='poType' onchange='poTypeChange();'>";
			$.each(obj["inPolicyList"], function(idx, val){
				var code=val["cdCode"];
				var title=val["cdName"];
				txt+='<option value="'+code+'">'+title+'</option>';
			});
			txt+="</select>";
			$("#poTypeSel").html(txt);

			//칸수 
			$("#poColsSel").html("");
			txt="<select class='resetcode w70p' name='poCols' id='poCols' onchange='poTableChange();'>";
			for(i=1;i<=10;i++)
			{
				txt+='<option value="'+i+'">'+i+'</option>';
			}
			txt+="</select>";
			$("#poColsSel").html(txt);

			//줄수  
			$("#poRowsSel").html("");
			txt="<select class='resetcode w70p' name='poRows' id='poRows' onchange='poTableChange();'>";
			for(i=1;i<=20;i++)
			{
				txt+='<option value="'+i+'">'+i+'</option>';
			}
			txt+="</select>";
			$("#poRowsSel").html(txt);


			//저장된 데이터들 
			var data = "";
			$("#policyTbl").html("");
			if(!isEmpty(obj["policy"]))
			{
				$(obj["policy"]).each(function( index, value )
				{
					if(value["poType"]=="700")
					{
						data+="<tr class=\" modinput_"+value["poSeq"]+" \" style='cursor:pointer;' id='"+value["poSeq"]+"'>";
						data+="<td class='l'>"+value["poSort"]+"</td>"; //의사PK
						data+="<td class='l'>"+value["poTypeName"]+"<input type='hidden' name='poSort' class='reqdata' value='"+value["poSort"]+"'></td>"; //의사PK
						data+="<td class='l' onclick=\"modinputpolicy('_policy','"+value["poSeq"]+"','"+value["poType"]+"','"+encodeURI(value["poContents"])+"')\" >"+viewContents(value["poType"], value["poContents"], value["poLinks"])+"</td>"; //아이디
						data+="<td class='l'></td>"; //버튼
						data+="</tr>";
					}
					else
					{
						data+="<tr class=\" modinput_"+value["poSeq"]+" \" style='cursor:pointer;'  id='"+value["poSeq"]+"'>";
						data+="<td class='l'>"+value["poSort"]+"<input type='hidden' name='poSort' class='reqdata' value='"+value["poSort"]+"'></td>"; //의사PK
						data+="<td class='l'>"+value["poTypeName"]+"</td>"; //의사PK
						data+="<td class='l' onclick=\"modinputpolicy('_policy','"+value["poSeq"]+"','"+value["poType"]+"')\">"+viewContents(value["poType"], value["poContents"], value["poLinks"])+"</td>"; //아이디
						data+="<td class='l'></td>"; //버튼
						data+="</tr>";
					}
					

				});
			}
			else
			{
				data+="<tr id=''>";
				data+="<td colspan='4'><?=$txtdt['1665']?></td>";   //데이터가 없습니다.
				data+="</tr>";
			}
			$("#policyTbl").html(data);
			initialize_table();
			



			$("#btnDiv").html("");
			var btnHtml='';
			var seqdata = "seq="+obj["poSeq"];
			//btnHtml='<a href="javascript:;" onclick="policyupdate();" class="bdp-btn"><span><?=$txtdt["1441"]?></span></a> ';//저장하기
			btnHtml+='<a href="javascript:;" onclick="viewlist();" class="bw-btn"><span><?=$txtdt["1087"]?></span></a> ';//목록
			//btnHtml+='<a href="javascript:;" onclick="callapidel(\'board\',\'policydelete\',\''+seqdata+'\')" class="bdp-btn"><span><?=$txtdt["1154"]?></span></a>';//삭제하기

			$("#btnDiv").html(btnHtml);

		}
		else if(obj["apiCode"]=="policyrechange")
		{
			alertsign("success", "개인정보처리방침이 변경되었습니다.", "", "1000");
			golist(obj["returnData"]);
		}
	}

	callapi('GET','board','policydesc','<?=$apidata?>'); 	//약재출고등록 상세 API 호출
</script>