<?php //상극알람 리스트&상세  
$root = "../..";
include_once ($root.'/_common.php');
?>
<style>
	dl.dismedi dd{min-width:19%;display:block;float:left;text-align:center;padding:5px;margin:0 3px 0 3px;border:1px solid #aaa;}
	dl.dismedi dd:hover{cursor:pointer;font-weight:bold;}
</style>
<!--// page start -->
<input type="hidden" name="seq" class="reqdata" value="">
<input type="hidden" name="returnData" class="reqdata" value="<?=$root?>/03_Medicine/DismatchWarning.php">
<div id="pagegroup" value="medicine"></div>
<div id="pagecode" value="dismedilist"></div>

<div class="board-ov-wrap">

    <!--// left -->
    <div class="fl">
		<h3 class="u-tit02"><?=$txtdt["1160"]?><!-- 상극알림 등록 --></h3>
		<div class="board-view-wrap">
			<span class="bd-line"></span>
			<table>
				<caption><span class="blind"></span></caption>
				<colgroup>
					<col width="120">
					<col width="*">
					<col width="120">
					<col width="*">
				</colgroup>
				<tbody>
					<tr>
						<th class="l"><span class="nec"><?=$txtdt["1024"]?><!-- 경고코드 --></span></th>
						<td>
							<input type="text" name="dmCode" class="w90p reqdata necdata" onblur="code_check()" title="<?=$txtdt["1024"]?>"/>
							<div class="checkcode"><span class="stxt" id="codesame" style="color:red;"></span></div><!--아이디중복여부표시-->

							<input type="hidden" id="codechk" name="codechk" value="1">
			
						</td>
						<th class="l"><span class="nec"><?=$txtdt["1033"]?><!-- 그룹 --></span></th>
						<td>
							<input type="text" name="dmGroup" class="w90p reqdata necdata" title="<?=$txtdt["1033"]?>"/>
						</td>
					</tr>
					<tr>
						<th class="l"><span class="nec"><?=$txtdt["1162"]?><!-- 상극약재 --></span></th>
						<td colspan="3">
							<input type="hidden" class="w50p reqdata necdata" name="dmMedicine" title="<?=$txtdt["1162"]?>" value=""/>
							<a href="javascript:;" onclick="javascript:viewlayerPopup(this);" data-bind="layer-medihub" data-value="700,600">
								<button type="button" class="cw-btn" style=""><span>+ <?=$txtdt["1122"]?><!-- 본초검색 --></span></button>
							</a>
							<dl id='matchmedi' name='matchmedi' class='dismedi' style='padding:10px 0 5px 0;'></dl>
						</td>
					</tr>
					<tr>
						<th class="l"><span class=""><?=$txtdt["1023"]?><!-- 경고메시지 --></span></th>
						<td colspan="3">
							<?=$txtdt["1718"]?><input type="text" class="w98p reqdata" name="dmNoticeKor" title="<?=$txtdt["1023"]?>"/>
							<?=$txtdt["1719"]?><input type="text" class="w98p reqdata" name="dmNoticeChn" title="<?=$txtdt["1023"]?>" />
						</td>
					</tr>
					<tr>
						<th class="l"><span><?=$txtdt["1022"]?><!-- 경고내용 --></span></th>
						<td colspan="3">
							<?=$txtdt["1718"]?><textarea name="dmDescKor" class="text-area reqdata" title="<?=$txtdt["1022"]?>"></textarea>
							<?=$txtdt["1719"]?><textarea name="dmDescChn" class="text-area reqdata" title="<?=$txtdt["1022"]?>"></textarea>
						</td>
					</tr>
				</tbody>
		   </table>
		</div>
		<div class="btn-box c">
			<?php if($modifyAuth == "true"){?>
			<a href="javascript:dismedi_update();" class="cdp-btn"><span><?=$txtdt["1070"]?><!-- 등록/수정 --></span></a>
			<a href="javascript:godesc('');" class="cw-btn"><span><?=$txtdt["1189"]?><!-- 신규 --></span></a>
			<a href="javascript:dismedi_del();" class="red-btn"><span><?=$txtdt["1154"]?></span></a>
			<?php }?>
		</div>
    </div>

    <!--// right -->
	<div class="fr ov-cont">
		<h3 class="u-tit02"><?=$txtdt["1022"]?><!-- 경고내용 --></h3>
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
					<col scope="col" width="15%">
					<col scope="col" width="15%">
					<col scope="col" width="30%">
					<col scope="col" width="*">
				</colgroup>
				<thead>
					<tr>
						<th><?=$txtdt["1024"]?><!-- 경고코드 --></th>
						<th><?=$txtdt["1033"]?><!-- 그룹 --></th>
						<th><?=$txtdt["1204"]?><!-- 약재명 --></th>
						<th><?=$txtdt["1023"]?><!-- 경고메시지 --></th>
					</tr>
				</thead>
				<tbody>
				</tbody>
			</table>
		</div>
		<div class="sgap"></div>

		<!-- s : 게시판 페이징 -->
		<div class='paging-wrap' id="dismedilistpage"></div>
		<!-- e : 게시판 페이징 -->
	</div>
</div>

<script>

	//경고코드 중복확인
	function code_check()
	{
		$(".checkcode").html('');
		$("input[name=codechk]").val(0);
		var dmCode=$("input[name=dmCode]").val();
		var apidata = "dmCode="+dmCode;
		console.log("apidata    >>>>   "+apidata);
		callapi('GET','medicine','dismatchchk',apidata);
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
			//if(sarr2[1]!=undefined)var searchStatus=sarr2[1];
			$("input[name=searchTxt]").val(decodeURI(searchTxt));
		}

		var apidata="page="+page+"&searchTxt="+searchTxt;
		console.log("apidata     :"+apidata);
		callapi('GET','medicine','dismedilist',apidata);
		//if(!isEmpty(seq)){
			apidata="seq="+seq;
			callapi('GET','medicine','dismedidesc',apidata); 
		//}
	}
	repageload();

    function desc(seq, page)  //리스트 누르면 상세 출력
    {
		$("#codesame").html('');
		var hdata=location.hash.replace("#","").split("|");
		var page=hdata[0];
		if(page==undefined){page="";}
		var search=hdata[2];
		if(search ===undefined){search="";}
		
		makehash(page,seq,search);
	
    }

    function dismedi_update()//등록&수정
    {
		if($("input[name=codechk]").val()==1) //중복확인이 1이어야 등록가능
		{
			if(necdata()=="Y") //필수조건 체크
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
				console.log(jsondata);
				callapi("POST","medicine","dismediupdate",jsondata); //상극 등록&수정

				//페이지초기화 1초후
				setTimeout("resetpage()",1000);
			}
		}
		else
		{
			if(!$("input[name=dmCode]").val())
			{
				alert('<?=$txtdt["1882"]?>');//코드를 입력해주세요
				$("input[name=dmCode]").focus();
				return false;
			}
			else
			{
				alert('<?=$txtdt["1883"]?>');//사용할수 없는 코드입니다.
				$("input[name=dmCode]").focus();
				return false;
			}
		}
    }

	//등록/수정되면 페이지가 다시 호출됨
	function resetpage()
	{
		$("input[name=dmCode]").val("");		
		$("input[name=dmGroup]").val("");
		$("input[name=dmMedicine]").val("");
		$("input[name=dmNoticeKor]").val("");
		$("input[name=dmNoticeChn]").val("");
		$("textarea[name=dmDescKor]").val("");
		$("textarea[name=dmDescChn]").val("");
		$("#matchmedi dd").remove();
		$("#codesame").html('');  //사용가능합니다. 중복코드입니다 사라짐
		$("#codechk").val(0);
		var page=$("#dismedilistpage ul li a.active").text();
		var apidata="page="+page;
		callapi('GET','medicine','dismedilist',apidata); 	//리스트  API 호출
	}

    function godesc(seq)//신규
    {
		$("#matchmedi dd").remove();
		$("#codechk").val(0);
		$("#codesame").html('');  //사용가능합니다. 중복코드입니다 사라짐
		makehash("",seq,"");

		//$("#listdiv").load("<?=$root?>/Skin/Medicine/DismatchWarning.php");
		/*
		$("input[name=dmCode]").val("");		
		$("input[name=dmGroup]").val("");
		$("input[name=dmMedicine]").val("");
		$("input[name=dmNoticeKor]").val("");
		$("input[name=dmNoticeChn]").val("");
		$("textarea[name=dmDescKor]").val("");
		$("textarea[name=dmDescChn]").val("");
		$("#matchmedi dd").remove();
		$("input[name=seq]").val("");  //seq 도 없어져야 만들어지면서 새로 입력됨
		*/

	}

    function dismedi_del() //삭제
	{
		var data = "seq="+$("input[name=seq]").val();
		var url = encodeURI($("input[name=returnData]").val());
		$("input[name=returnData]").val(url);

		callapidel('medicine','dismedidelete',data);
		makehash("","","");
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
    	$("#matchmedi dd").each(function(){
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
		if(medicode)
		{
			var mcarr=medicode.split(",");
		}
		else
		{		
			var mcarr=1;
		}
		if(medicode)
		{
			var mtarr=meditxt.split(",");
		}		
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
		//console.log("medititle   >>>>"+medititle);
		$("#"+pgid).html(medititle);
	}

	function makepage(json)
	{
		var obj = JSON.parse(json);
		console.log(obj);

        if(obj["apiCode"]=="dismedidesc") //상극 상세
        {
			$("input[name=seq]").val(obj["seq"]); //seq
            $("input[name=dmCode]").val(obj["dmCode"]); //경고코드
            $("input[name=dmGroup]").val(obj["dmGroup"]); //그룹
            $("input[name=dmMedicine]").val(obj["dmMedicine"]); //상극 약재코드
            $("input[name=dmNoticeKor]").val(obj["dmNoticeKor"]); //경고메시지(한글)
            $("input[name=dmNoticeChn]").val(obj["dmNoticeChn"]); //경고메시지(중문)
            $("textarea[name=dmDescKor]").val(obj["dmDescKor"]); //경고내용(한글)
            $("textarea[name=dmDescChn]").val(obj["dmDescChn"]); //경고내용(중문)

			if($("input[name=seq]").val())
			{
				$("input[name=codechk]").val(1);
			}
			else
			{
				$("input[name=codechk]").val(0);
			}

			viewmeditxt("dmMedicine",obj["dmMedicine"],obj["dmMeditxt"],"matchmedi")//약재 버튼
        }
        else if(obj["apiCode"]=="dismedilist")//상극알람 리스트
        {
            var data = "";

			$("#tbllist tbody").html("");
			if(!isEmpty(obj["list"]))
			{
				$(obj["list"]).each(function( index, value )
				{
					data+="<tr style='cursor:pointer;' onclick=\"desc('"+value["seq"]+"', '"+obj["page"]+"')\">"; //누르면 상세 출력
					data+="<td>"+value["dmCode"]+"</td>";//경고코드
					data+="<td>"+value["dmGroup"]+"</td>"; //그룹
					data+="<td>"+value["dmMeditxt"]+"</td>"; //약재명
					data+="<td>"+value["dmNotice"]+"</td>"; //경고메시지
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
						
			$("#pagecnt").text(comma(obj["tcnt"])+" <?=$txtdt['1019']?>");
            //페이지
            getsubpage("dismedilistpage",obj["tpage"], obj["page"], obj["block"], obj["psize"]);
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
		else if (obj["apiCode"]=="dismatchchk")
		{
			if(obj["resultCode"] == "200")
			{
				$(".checkcode").html('<span class="stxt" id="codesame" style="color:red;"> <?=$txtdt["1754"]?></span>'); //중복약재코드입니다.
				$("#codechk").val(0);
			}
			else
			{
				$(".checkcode").html('<span class="stxt" id="codesame" style="color:blue;"> <?=$txtdt["1476"]?></span>'); //사용 가능합니다
				$("#codechk").val(1);
			}
			return false;
		}
	}

	//상극알람 리스트  API 호출
	var hdata=location.hash.replace("#","").split("|");
	var page=hdata[0];
	var search=hdata[1];
	if(page==undefined){
		page=1;
	}
	var apidata="page="+page;
	//callapi('GET','medicine','dismedilist',apidata); 	

</script>
