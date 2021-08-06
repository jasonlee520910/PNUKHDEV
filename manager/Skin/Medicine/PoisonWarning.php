<?php //상극알람 리스트&상세
$root = "../..";
include_once ($root.'/_common.php');
?>
<style>
	dl.dismedi dd{min-width:19%;display:block;float:left;text-align:center;padding:5px;margin:0 3px 0 3px;border:1px solid #aaa;}
	dl.dismedi dd:hover{cursor:pointer;font-weight:bold;}
</style>
<!--// page start -->
<input type="hidden" name="seq" class="reqdata" value="<?=$_GET["seq"]?>">
<input type="hidden" name="returnData" class="reqdata" value="<?=$root?>/03_Medicine/PoisonWarning.php">
<div id="pagegroup" value="medicine"></div>
<div id="pagecode" value="posmedilist"></div>

<div class="board-ov-wrap">

    <!--// left -->
    <div class="fl">
		<h3 class="u-tit02"><?=$txtdt["1068"]?><!-- 독성알람 등록 --></h3>
		<div class="board-view-wrap">
			<span class="bd-line"></span>
			<table>
				<caption><span class="blind"></span></caption>
				<colgroup>
					<col width="130">
					<col width="*">
					<col width="130">
					<col width="*">
				</colgroup>
				<tbody>
					<tr>
						<th class="l"><span class="nec"><?=$txtdt["1024"]?><!-- 경고코드 --></span></th>
						<td><input type="text" name="poCode" class="w90p reqdata necdata" title="<?=$txtdt["1024"]?>"/></td>
						<!-- <th class="l"><span class="nec"><?=$txtdt["1033"]?><!-- 그룹 --></span></th>
						<!-- <td><input type="text" name="poGroup" class="w90p reqdata necdata" title="<?=$txtdt["1033"]?>"/></td> --> 
					</tr>
					<tr>  
						<th class="l"><span class="nec"><?=$txtdt["1069"]?><!-- 독성약재 --></span></th>
						<td colspan="3">
							<input type="hidden" class="w50p reqdata necdata" name="poMedicine" title="<?=$txtdt["1069"]?>" value=""/>
							<a href="javascript:;" onclick="javascript:viewlayerPopup(this);" data-bind="layer-medihub" data-value="700,600">
								<button type="button" class="cw-btn" style=""><span>+ <?=$txtdt["1122"]?><!-- 본초검색 --></span></button>
							</a>
							<dl id='matchmedi' class='dismedi' style='padding:10px 0 5px 0;'></dl>
						</td>
					</tr>
					<!-- <tr>
						<th class="l"><span><?=$txtdt["1310"]?><!-- 주의환자 --></span></th>
						<!-- <td colspan="3"><ul id="poPatientDiv" name="poPatient"></ul></td>
					</tr>  -->
					<tr>
						<th class="l"><span class=""><?=$txtdt["1145"]?><!-- 사용(포자)법 --></span></th>
						<td colspan="3">
							한글<input type="text" class="w98p reqdata " title="<?=$txtdt["1145"]?>" name="poUsageKor" />
							中文<input type="text" class="w98p reqdata " title="<?=$txtdt["1145"]?>" name="poUsageChn" />
						</td>
					</tr>
					<!-- <tr>
						<th class="l"><span><?=$txtdt["1148"]?><!-- 사용제한 --></span></th>
						<!-- <td colspan="3">
							<span class="ttxt"><?=$txtdt["1399"]?><!-- 하루 최대 복용량 --></span>
							<!-- <input type="text" name="poUselimit0" class="w10p reqdata" maxlength="9" onfocus="this.select();" onchange="changeNumber(event, false);"/> <span>g</span><br>
							<span class="ttxt"><?=$txtdt["1008"]?><!-- 1회 최대복용량 --></span>
							<!-- <input type="text" name="poUselimit1" class="w10p reqdata" maxlength="9" onfocus="this.select();" onchange="changeNumber(event, false);"/> <span>g</span><br>
							<span class="ttxt"><?=$txtdt["1343"]?><!-- 최대처방일수 --></span>
							<!-- <input type="text" name="poUselimit2" class="w10p reqdata" maxlength="9" onfocus="this.select();" onchange="changeNumber(event, false);"/> <span>일</span><br>
						</td>
					</tr> --> 
					<!-- <tr>
						<th class="l"><span class="nec"><?=$txtdt["1023"]?><!-- 경고메시지 --></span></th>
						<!-- <td colspan="3">
							한글<input type="text" class="w98p reqdata necdata" title="<?=$txtdt["1023"]?>" name="poNoticeKor" />
							中文<input type="text" class="w98p reqdata necdata" title="<?=$txtdt["1023"]?>" name="poNoticeChn" />
						</td> -->
					<!-- </tr> --> 
					<tr> 
						<th class="l"><span><?=$txtdt["1022"]?><!-- 경고내용 --></span></th>
						<td colspan="3">
							한글<textarea class="text-area reqdata" name="poDescKor"></textarea>
							中文<textarea class="text-area reqdata" name="poDescChn"></textarea>
						</td>
					</tr>
				</tbody>
		   </table>
		</div>
		<div class="btn-box c">
			<?php if($modifyAuth == "true"){?>
			<!-- <a href="javascript:posmedi_update();" class="cdp-btn"><span><?=$txtdt["1070"]?><!-- 등록/수정 --></span></a>
			<!-- <a href="javascript:godesc();" class="cw-btn"><span><?=$txtdt["1189"]?><!-- 신규 --></span></a>
			<!-- <a href="javascript:posmedi_del();" class="red-btn"><span><?=$txtdt["1154"]?></span></a> -->
			<?php }?>
		</div>
    </div>

    <!--// right -->
	<div class="fr ov-cont">
	  <h3 class="u-tit02"><?=$txtdt["1068"]?><!-- 독성알람 목록 --></h3>
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
				<col scope="col" width="25%">
				<col scope="col" width="25%">
				<col scope="col" width="25%">
				<col scope="col" width="*">
				</colgroup>
				<thead>
					<tr>
						<th><?=$txtdt["1131"]?><!-- 본코드 --></th>
						<th><?=$txtdt["1124"]?><!-- 본초명 --></th>
						<th><?=$txtdt["1024"]?><!-- 경고코드 --></th>
						<th><?=$txtdt["1064"]?><!-- 독성 --></th>
					</tr>
				</thead>
				<tbody>
				</tbody>
			</table>
		</div>
		<div class="sgap"></div>

		<!-- s : 게시판 페이징 -->
		<div class='paging-wrap' id="posmedilistpage"></div>
		<!-- e : 게시판 페이징 -->
	</div>
</div>
<script>
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
			//if(sarr2[1]!=undefined)var searchStatus=sarr2[1];
			$("input[name=searchTxt]").val(decodeURI(searchTxt));
		}

		var apidata="page="+page+"&searchTxt="+searchTxt;
		console.log("apidata     :"+apidata);
		callapi('GET','medicine','posmedilist',apidata);
		if(!isEmpty(seq)){
			apidata="seq="+seq;
			callapi('GET','medicine','posmedidesc',apidata);
		}
	}
	console.log("처음 페이지 새로고침 됨");
	repageload();

     function desc(seq, page) //리스트 누르면 상세 출력
     {
		var hdata=location.hash.replace("#","").split("|");

		var page=hdata[0];
		if(page==undefined){page="";}
		var search=hdata[2];
		if(search ===undefined){search="";}
		
		makehash(page,seq,search);
     }

	function posmedi_update(status)//등록&수정
	{
		if(necdata()=="Y") //필수값체크
		{
			var key=data="";
			var jsondata={};

			//checkbox
			/*
			var poPatienthtml="";
			$("input:checkbox[name=poPatient]:checked").each(function() {
				poPatienthtml+=","+this.value
			});
			jsondata["poPatient"] = poPatienthtml; //주의환자
			*/
			$(".reqdata").each(function()
			{
				key=$(this).attr("name");
				data=$(this).val();
				jsondata[key] = data;
			});
			callapi("POST","medicine","posmediupdate",jsondata); //독성 등록&수정

			//페이지초기화 1초후
			setTimeout("resetpage()",1000);
		}
	}

	//등록/수정되면 페이지가 다시 호출됨
	function resetpage()
	{
		/*
		$("input[name=dmCode]").val("");		
		$("input[name=dmGroup]").val("");
		$("input[name=dmMedicine]").val("");
		$("input[name=dmNoticeKor]").val("");
		$("input[name=dmNoticeChn]").val("");
		$("textarea[name=dmDescKor]").val("");
		$("textarea[name=dmDescChn]").val("");
		$("#matchmedi dd").remove();
		var page=$("#dismedilistpage ul li a.active").text();
		var apidata="page="+page;
		
		callapi('GET','medicine','posmedilist',apidata); 	//리스트  API 호출
		*/
	}

    function godesc(seq)//신규
     {
	 	//$("#listdiv").load("<?=$root?>/Skin/Medicine/PoisonWarning.php");
		/*
		$("input[name=dmCode]").val("");		
		$("input[name=dmGroup]").val("");
		$("input[name=dmMedicine]").val("");
		$("input[name=dmNoticeKor]").val("");
		$("input[name=dmNoticeChn]").val("");
		$("textarea[name=dmDescKor]").val("");
		$("textarea[name=dmDescChn]").val("");
		$("#matchmedi dd").remove();
		*/
	 }

	function posmedi_del() //삭제
	{
		var data = "seq="+$("input[name=seq]").val();
		var url = encodeURI($("input[name=returnData]").val());
		$("input[name=returnData]").val(url);
		callapidel('medicine','posmedidelete',data);
		return false;
	}

	//본초검색버튼 누르면 팝업 열림
	function viewlayerPopup(obj)
	{
		var url=obj.getAttribute("data-bind");
		var size=obj.getAttribute("data-value");
		var data = "&page=1&psize=5&block=10"; //page,psize,block 사이즈 초기화
		console.log("=========>>>> viewlayerPopup url = " + url+", size = " + size);

		getlayer(url,size,data);
	}

	//DEL버튼 약재삭제
	function removemedi(code,medi)
	{
		var str="";
		$("#matchmedi dd").each(function()
		{
			if(medi!=$(this).attr("data-code"))
			{
				if(str!=""){str+=",";}
				str+=$(this).attr("data-code");
			}
		});
		$("#"+medi).remove();
		$("input[name="+code+"]").val(str);
		return str;
	}

   //삭제버튼
	function viewdelicon(code,title,chk)
	{
		if(chk==1)
		{
			$("#"+code).css("background","#fff").text(title);
		}
		else
		{
			$("#"+code).css("background","#f4f4f4").text("DEL");
		}
	}

	//약재 버튼이 DEL로 바뀌는 함수
	function viewmeditxt(meditype,medicode,meditxt,pgid)
	{
		var mcarr=medicode.split(",");
		var mtarr=meditxt.split(",");
		var medititle="";

		medititle+="<dl id='matchmedi'>";
		for(var i=0;i<mcarr.length;i++)
		{
			if(mcarr[i]&&mtarr[i])
			{
			medititle+="<dd id='"+mcarr[i]+"' onmouseover=viewdelicon('"+mcarr[i]+"','"+mtarr[i]+"',0) onmouseout=viewdelicon('"+mcarr[i]+"','"+mtarr[i]+"',1) onclick=removemedi('"+meditype+"','"+mcarr[i]+"') data-code='"+mcarr[i]+"'>"+mtarr[i]+"</dd>";
			}
		}
		medititle+="</dl>";
		$("#"+pgid).html(medititle);
	}

	//옵션 함수
	function PoisonCheckOption(pgid, name, list, data, title)
	{
		var option = checked = "";

		option = '<dl class="chkdl">';
		if(!isEmpty(data))
		{
			var arry = data.split(",");
			for(var key in list)
			{
				checked = '';
				for(var i=0;i<arry.length;i++)
				{
					if(arry[i] == list[key]["cdValue"])
					{
						checked = 'checked="checked"';
					}
				}
				option+='<dd><label for="'+list[key]["cdName"]+'">';
				option+='<input type="checkbox"  name="'+name+'" title = "'+title+'" id="'+list[key]["cdName"]+'" value="'+list[key]["cdValue"]+'" '+checked+'>'+list[key]["cdName"]+'</label></dd>';
			}
		}
		else
		{
			$.each(list, function(val)
			{
				option += '<dd><label for="'+list[val]["cdName"]+'">';
				option += '<input type="checkbox"  name="'+name+'" title = "'+title+'" id="'+list[val]["cdName"]+'" value="'+list[val]["cdValue"]+'" '+checked+'>'+list[val]["cdName"]+'</label></dd>';
			});
		}
		option += '</dl>';
		//console.log("***********************  PoisonCheckOption  option = " + option);
		$("#"+pgid).html(option);
	}
	

	function makepage(json)
	{
		var obj = JSON.parse(json);
		console.log(obj);

        if(obj["apiCode"]=="posmedidesc") //독성 상세
        {
			$("input[name=poMedicine]").val(obj["poMedicine"]); //경고코드
			$("input[name=poCode]").val(obj["poCode"]); //경고코드
			//$("input[name=poGroup]").val(obj["poGroup"]); //그룹
			$("input[name=poUsageKor]").val(obj["poUsageKor"]);  //사용(포자)법(한글)
			$("input[name=poUsageChn]").val(obj["poUsageChn"]);  //사용(포자)법(중문)
			//$("input[name=poUselimit0]").val(obj["poUselimit0"]); //사용제한 하루 최대 복용량
			//$("input[name=poUselimit1]").val(obj["poUselimit1"]); //사용제한 1회 최대복용량
			//$("input[name=poUselimit2]").val(obj["poUselimit2"]); //사용제한 최대처방일수
			//$("input[name=poNoticeKor]").val(obj["poNoticeKor"]); //경고메시지(한글)
			//$("input[name=poNoticeChn]").val(obj["poNoticeChn"]); //경고메시지(중문)
			$("textarea[name=poDescKor]").text(obj["poDescKor"]); //경고내용(한글)
			$("textarea[name=poDescChn]").text(obj["poDescChn"]); //경고내용(중문)

			viewmeditxt("poMedicine",obj["poMedicine"],obj["mhTitle"],"matchmedi")//약재 버튼
			//PoisonCheckOption("poPatientDiv", "poPatient", obj["PatientList"], obj["poPatient"], '<?=$txtdt["1310"]?>'); //주의환자 리스트
        }
        else if(obj["apiCode"]=="posmedilist")//독성알람 리스트
        {
			var data = "";

			$("#tbllist tbody").html("");
			if(!isEmpty(obj["list"]))
			{
				$(obj["list"]).each(function( index, value )
				{
					data+="<tr style='cursor:pointer;' onclick=\"desc('"+value["seq"]+"', '"+obj["page"]+"')\">"; //누르면 상세 출력
					data+="<td>"+value["poMedicine"]+"</td>";//약재코드
					data+="<td>"+value["poMeditxt"]+"</td>"; //약재명
					data+="<td>"+value["poCode"]+"</td>"; //경고코드
					data+="<td>"+value["poisiontitle"]+"</td>"; //독성
					data+="</tr>";
				});
			}
			else
			{
				data+="<tr>";
				data+="<td colspan='4'><?=$txtdt['1665']?></td>";
				data+="</tr>";
			}

			$("#tbllist tbody").html(data);

			//PoisonCheckOption("poPatientDiv", "poPatient", obj["PatientList"], "",'<?=$txtdt["1310"]?>'); //주의환자 리스트
			$("#pagecnt").text(comma(obj["tcnt"])+" <?=$txtdt['1019']?>");
            //페이지
            getsubpage("posmedilistpage",obj["tpage"], obj["page"], obj["block"], obj["psize"]);
        }
		else if (obj["apiCode"]=="hublist") //본초리스트(팝업)
		{
			var data = "";
			$("#laymedicinetbl tbody").html("");

			if(!isEmpty(obj["list"]))
			{
				$(obj["list"]).each(function( index, value )
				{
					data+='<tr class="putpopdata" onclick="javascript:putpopdata(this);" data-code="'+value["mhCode"]+'">';
					data+='<td>'+value["mhCode"]+'</td>'; //본초코드
					data+='<td>'+value["mhTitle"]+'</td>'; //본초명
					data+='<td>'+value["mhStitle"]+'</td>'; //학명
					data+='<td>'+value["mhDtitle"]+'</td>'; //이명
					data+='<td>'+value["mhCtitle"]+'</td>'; //과명
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

			 //페이징
			getsubpage_pop("hublistpage",obj["tpage"], obj["page"], obj["block"], obj["psize"]);
		}
	}


	//독성알람 리스트 API & 옵션 호출
	var hdata=location.hash.replace("#","").split("|");
	var page=hdata[0];
	var search=hdata[1];
	if(page==undefined){
		page=1;
	}
	var apidata="page="+page;
	//callapi('GET','medicine','dismedilist',apidata); 	

	$("#searchTxt").focus();
</script>
