<?php
$root = "../..";
include_once ($root.'/_common.php');
$upload=$root."/_module/upload";
include_once $upload."/upload.lib.php";
if($_GET["seq"]=="add"){
	$apidata="seq=";
	$seq="";
}else{
	$apidata="seq=".$_GET["seq"];
	$seq=$_GET["seq"];
}
?>

<input type="hidden" name="sdate" value="" class="reqdata">
<input type="hidden" name="edate" value="" class="reqdata">

<div id="popupDiv"></div>

<input type="hidden" name="seq" class="reqdata" value="<?=$_GET["seq"]?>">
<input type="hidden" name="returnData" class="reqdata" value="<?=$root?>/Skin/Board/Board.php">
<!-- 팝업이미지 -->
<script  type="text/javascript" src="<?=$root?>/cmmJs/jquery/jquery.form.min.js"></script>
<link rel="stylesheet" media="all" href="<?=$upload?>/upload.css?v=<?php echo time();?>" />
<style>
	.upload{overflow:hidden;margin:0;padding:0;}
	.uploaddiv{overflow:hidden;padding-bottom:10px;}
	.multiimg dd{width:48%;float:left;overflow:hidden;margin:0;padding:0;}
	.multiimg dd p{padding:0 10px;font-weight:bold;}
	#imgs_wrap, .imgs_wrap{clear:both;margin:10px 5px;padding:0;width:50px;}
	.imgs_wrap img{max-width:100px;}
	.viewimg{width:100px;height:80px;overflow:hidden;margin:5px;}
	.viewimg img{height:100%;}

	.linktype-list  {overflow:hidden;}
	.linktype-list  li {position:relative; width:25%;float:left;}
	.NYchk-list  {overflow:hidden;}
	.NYchk-list  li {position:relative; width:25%;float:left;}

</style>

<script  type="text/javascript" src="<?=$upload?>/upload.js?v=<?=time()?>"></script>

<style>
	.bbtype-list {overflow:hidden;}
	.bbtype-list li {position:relative; width:8%;float:left; }
</style>

<script>
    $(document).ready(function(){
        setDateBox();
    });  

    function setDateBox()
	{
		//오늘날짜를 기본값으로 함
		var data=getNowFull(4);
		var year = data.substr(0,4);
		var month = data.substr(4,2);
		var day = data.substr(6,2);
		var hour = data.substr(8,2);
		var minute = data.substr(10,2);

		var selected="";
        var dt = new Date();
        var com_year = dt.getFullYear();
		
        for(var i = com_year; i <= (com_year+10); i++)  //년도
		{
			if(i==year){selected=" selected";}else{selected=" ";}      
			$("#sdateyear").append("<option value='"+ i +"' "+selected+" >"+ i + " 년" +"</option>");
			$("#edateyear").append("<option value='"+ i +"' "+selected+" >"+ i + " 년" +"</option>");
        }
		
        for(var i = 1; i <= 12; i++)  //달
		{			
			if(i==month){selected=" selected";}else{selected=" ";}          
			$("#sdatemonth").append("<option value='"+ i +"' "+selected+" >"+ i + " 월" +"</option>");
			$("#edatemonth").append("<option value='"+ i +"' "+selected+" >"+ i + " 월" +"</option>");
        }
 
        for(var i = 1; i <= 31; i++) //일
		{			
			if(i==day){selected=" selected";}else{selected=" ";}
			$("#sdateday").append("<option value='"+ i +"' "+selected+" >"+ i + " 일" +"</option>");
			$("#edateday").append("<option value='"+ i +"' "+selected+" >"+ i + " 일" +"</option>");

        }
        for(var i = 1; i <= 24; i++)  //시간
		{			
			if(i==hour){selected=" selected";}else{selected=" ";}
			$("#sdatehour").append("<option value='"+ i +"' "+selected+" >"+ i + " 시" +"</option>");
			$("#edatehour").append("<option value='"+ i +"' "+selected+" >"+ i + " 시" +"</option>");

        }
        for(var i = 0; i <= 60; i++)  //분
		{			
			if(i==minute){selected=" selected";}else{selected=" ";}
			$("#sdateminute").append("<option value='"+ i +"' "+selected+" >"+ i + " 분" +"</option>");
			$("#edateminute").append("<option value='"+ i +"' "+selected+" >"+ i + " 분" +"</option>");

        }
    }
</script>

<div class="board-view-wrap">
	<div class="gap"></div>
	<!-- <h3 class="u-tit02">FAQ<?//=$txtdt["1450"]?><?//=$txtdt["1725"]?><!-- 약재정보 --></h3> 
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
				<th><span>제목<?//=$txtdt["1951"]?><!-- 제목 --></span></th>
				<td colspan="3"><input type="text" name="bbTitle" class="w60p reqdata necdata" title="제목"/></td>
			</tr>
			<tr>
				<th rowspan="2"><span>팝업 사용기간</span></th>
				<td colspan="3">				
				<span>노출기간 미지정 <input type="radio" name="termchk" id="termchkN" class="radiodata" value="N" checked="checked"> </span>
				</td>
			</tr>
			<tr>		
				<td colspan="3">
				 <span>노출기간 지정 <input type="radio" name="termchk" id="termchkY" class="radiodata" value="Y" > </span>
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				 	<select name="sdateyear" id="sdateyear"  onchange="periodnewlist();" ></select>    
					<select name="sdatemonth" id="sdatemonth"  onchange="periodnewlist();" ></select>
					<select name="sdateday" id="sdateday"  onchange="periodnewlist();"></select>
					<select name="sdatehour" id="sdatehour"  onchange="periodnewlist();"></select>
					<select name="sdateminute" id="sdateminute"  onchange="periodnewlist();"></select>
					 ~ 
					<select name="edateyear" id="edateyear"   onchange="periodnewlist();" ></select>    
					<select name="edatemonth" id="edatemonth"  onchange="periodnewlist();" ></select>
					<select name="edateday" id="edateday"  onchange="periodnewlist();"></select>	
					<select name="edatehour" id="edatehour"  onchange="periodnewlist();"></select>
					<select name="edateminute" id="edateminute"  onchange="periodnewlist();"></select>	
				</td>
			</tr>
			<tr>
				<th><span>위치및크기<?//=$txtdt["1951"]?><!-- 제목 --></span></th>
				<td colspan="3">
					<input type="hidden" name="bbFileSeq" class="w10p reqdata" title="파일seq"/>
					위치(TOP) : <input type="text" name="bbTop" class="w10p reqdata necdata" title="위치(TOP)"/>
					위치(LEFT) : <input type="text" name="bbLeft" class="w10p reqdata necdata" title="위치(LEFT)"/>
					크기(가로) : <input type="text" name="bbWidth" class="w10p reqdata necdata" title="크기(가로)"/>
					크기(세로) : <input type="text" name="bbHeight" class="w10p reqdata necdata" title="크기(세로)"/>

					<button type="button" class="sp-btn" style="background:#5E8E2E;border:1px solid #599704;" onclick="viewpopup();">팝업 크기 미리보기</button>
					

				</td>
			</tr>
			<tr>
				<th><span>팝업이미지<?//=$txtdt["1951"]?><!-- 제목 --></span></th>
				<td colspan="3">
					<dl class="multiimg">
					<dd><p><!-- 팝업이미지 --></p>
					<span id="popup"></span>
					<span id="img_popup">
						<button type="button" class="sp-btn" onclick="uploadbtn('popup');">이미지 첨부</button>
					</span>
					</dd>
				</td>
			</tr>
			<tr>
				<th><span>링크</span></th>
				<td><input type="text" name="bbLink" class="w90p reqdata" title="링크"/></td>
				<th><span>링크 종류</span></th>
				<td>
					<ul id="linktypeDiv">		
				</td>
			</tr>
			<tr>
				<th><span>팝업 사용여부</span></th>
				<td  colspan="3">
					<ul id="NYchkDiv">		
				</td>
			</tr>
			<tr>
				<th><span>나의 ip입력</span></th>
				<td  colspan="3">
					<input type="text" name="myip" class="w30p reqdata" title="나의ip" value=""/> * 팝업 사용여부에서 '나의 IP만 공개'를 선택했을경우 입력해주세요
				</td>
			</tr>		
			<tr>
				<th><span><?=$txtdt["1047"]?><!-- 내용 --></span></th>
				<td colspan="3"><textarea name="bbDesc" class="text-area reqdata necdata" title="<?=$txtdt["1047"]?>"/></textarea></td>
			</tr>

		</tbody>
	</table>

    <div class="btn-box c">			
		<a href="javascript:board_update();" class="bdp-btn"><span><?=$txtdt["1070"]?><!-- 등록/수정 --></span></a>
		<a href="javascript:viewlist();" class="bw-btn"><span><?=$txtdt["1087"]?><!-- 목록 --></span></a>
		<a href="javascript:board_del();" class="bdp-btn"><span><?=$txtdt["1154"]?><!-- 삭제 --></span></a>
    </div>
</div>

<script>

	function viewpopup()
	{
		var bbTop=$("input[name=bbTop]").val(); 
		var bbLeft=$("input[name=bbLeft]").val(); 
		var bbWidth=$("input[name=bbWidth]").val(); 
		var bbHeight=$("input[name=bbHeight]").val(); 

		var style="position:fixed;top:0;left:0;z-index:3000;background:#fff;overflow:hidden;";
			style+="border:2px solid #333;";
			style+="display:block;width:"+bbWidth+"px;height:"+bbHeight+"px;margin:"+bbTop+"px 0 0 "+bbHeight+"px;";
		$("body").prepend("<div id='viewlayer' style='"+style+"' onclick='closediv(\"viewlayer\")'><span style='font-size:20px;float:right;padding:10px;'>닫기</span></div>");
	}

	function periodnewlist()
	{
		
		var sdateyear= $("select[name=sdateyear]").val();
		var sdatemonth= $("select[name=sdatemonth]").val();
		var sdateday= $("select[name=sdateday]").val();
		var sdatehour= $("select[name=sdatehour]").val();
		var sdateminute= $("select[name=sdateminute]").val();

		var edateyear= $("select[name=edateyear]").val();
		var edatemonth= $("select[name=edatemonth]").val();
		var edateday= $("select[name=edateday]").val();
		var edatehour= $("select[name=edatehour]").val();
		var edateminute= $("select[name=edateminute]").val();

		if(sdatemonth.length=='1'){var newsdatemonth="0"+sdatemonth;}else{newsdatemonth=sdatemonth;}
		if(sdateday.length=='1'){var newsdateday="0"+sdateday;}else{newsdateday=sdateday;}
		if(sdatehour.length=='1'){var newsdatehour="0"+sdatehour;}else{newsdatehour=sdatehour;}
		if(sdateminute.length=='1'){var newsdateminute="0"+sdateminute;}else{newsdateminute=sdateminute;}

		if(edatemonth.length=='1'){var newedateyear="0"+edatemonth;}else{newedateyear=edatemonth;}
		if(edateday.length=='1'){var newedateday="0"+edateday;}else{newedateday=edateday;}
		if(edatehour.length=='1'){var newedatehour="0"+edatehour;}else{newedatehour=edatehour;}
		if(edateminute.length=='1'){var newedateminute="0"+edateminute;}else{newedateminute=edateminute;}

		$("input[name=sdate]").val(sdateyear+"-"+newsdatemonth+"-"+newsdateday+" "+newsdatehour+":"+newsdateminute); 
		$("input[name=edate]").val(edateyear+"-"+newedateyear+"-"+newedateday+" "+newedatehour+":"+newedateminute); 
	}




	function uploadbtn(type)
	{
		var id=getCookie("ck_stStaffid");		
		useupload(type,id,"1");
	}
	function uploadImg()
	{
		$("#input_imgs").click();	
	}
	function useupload(fcode,staffid, seq)
	{		
		var affcode=$("input[name=seq]").val();
		$("#frm").remove();
		var	txt='<form id="frm"  method="post" enctype="multipart/form-data" action=javascript:upload(\"'+fcode+'\");>';
				txt+='	<span class="fileNone">';
				txt+='		<input type="file" name="uploadFile" id="input_imgs" onchange="fileup()" />';
				txt+='		<input type="text" name="filecode" id="filecode" value="'+fcode+'|'+affcode+'|'+seq+'">';
				txt+='		<input type="text" name="fileck" id="fileck" value="'+staffid+'|kor">';
				txt+='		<input type="text" name="fileapiurl" id="fileapiurl" value="url">';
				txt+='	</span>';		
				txt+='</form>';
		$("#"+fcode).html(txt);
		uploadImg();	
	}
	function upload(fcode){
		//console.log("fcode    >>>  "+fcode);
		
		//var uptype="once";
		//if(uptype=="once"){

			//이미지 업로드할때 기존 이미지가 있는경우는 삭제하고 이미지 업로드
			var af_seq=$("#img_id_"+fcode).attr("data-seq");

			if(af_seq && af_seq!=undefined)
			{
				$("#img_id_"+fcode).html(""); 
				var data = "seq="+af_seq;
				$("#img_id_"+fcode).remove(); 
				callapiupload('GET','file','filedelete',data);

			}
		//}

        $("#frm").ajaxForm({
            url:getUrlData("FILE"),
            //enctype : "multipart/form-data",
            dataType : "json",
            error : function(){
                alert("에러") ;
            },
            success : function(result){
				var obj = result;
				//console.log(obj);
				//handleImgFileSelect(obj["data"]);
				//console.log("이미지를 보여주는 함수 호출 할 부분");  
				//imgShow("img1", "staff", obj["files"]);
				if(obj["status"] == "SUCCESS" && obj["message"] == "FILE_UPLOAD_OK")
				{
					alertsign('success',getTxtData("FILE_UPLOAD_OK"),'top',1500);
					console.log(JSON.stringify(obj["data"]));
					var txt="<div class='viewimg' onclick=\"Imagedel('"+obj["data"][0]["afseq"]+"', '"+obj["data"][0]["afUserid"]+"')\" id=\"img_id_"+obj["data"][0]["afUserid"]+"\" data-seq='"+obj["data"][0]["afseq"]+"'> <img src='"+getUrlData("FILE_DOMAIN")+obj["data"][0]["afUrl"]+"'> </div>	";
					$("#img_"+fcode).after(txt);

					$("input[name=bbFileSeq]").val(obj["data"][0]["afseq"]);
				}
				else
				{
					if(obj["message"] == "FILE_UPLOAD_FAIL")
						alertsign('warning',getTxtData("FILE_UPLOAD_FAIL"),'top',1500);//파일업로드에 실패했습니다.
					else if(obj["message"] == "FILE_UPLOAD_ERR01")
						alertsign('warning',getTxtData("FILE_UPLOAD_ERR01"),'top',1500);//첨부파일 사이즈는 5MB 이내로 등록 가능합니다.
					else if(obj["message"] == "FILE_UPLOAD_ERR02")
						alertsign('warning',getTxtData("FILE_UPLOAD_ERR02"),'top',1500);//허용된 파일형식이 아닙니다.
					else if(obj["message"] == "FILE_UPLOAD_ERR04")
						alertsign('warning',getTxtData("FILE_UPLOAD_ERR04"),'top',1500);//도메인 관리자에게 문의 바랍니다.
					else
						alertsign('warning',getTxtData("FILE_UPLOAD_ERR03"),'top',1500);//파일 오류입니다.				
				}
            }
        });
        $("#frm").submit() ;
		//location.reload();
    }

	//이미지 삭제 
	function Imagedel(seq,fcode) 
	{
		//console.log("seq   >>>   "+seq);
		//console.log("fcode   >>>   "+fcode);
		if(confirm("삭제하시겠습니까?"))
		{
			//fildelete api 호출 
			var data = "seq="+seq;
			//console.log("data : "+data);
			$("#img_id_"+fcode).remove(); 
			callapiupload('GET','file','filedelete',data);
			
			location.reload();
			
		}
	}

	function board_update()//등록&수정
	{
		var sdateperiod = $("input[name=sdate]").val();
		var edateperiod = $("input[name=edate]").val();

		//console.log("sdateperiod    >> "+sdateperiod);
		//console.log("edateperiod    >> "+edateperiod);

		var bb_type='<?=$_GET["bb_type"]?>'

		if(isEmpty(sdateperiod)&& bb_type=="POPUP")
		{
		
			periodnewlist();
		}

		if(sdateperiod<=edateperiod)
		{
			var exdata="sdate="+sdateperiod+"&edate="+edateperiod;
			//console.log(exdata);

			var termchk = $('input[name="termchk"]:checked').val();
         

			if(termchk=="N")  //노출기간을 미지정으로 하면
			{
				//BB_POPUPLIMIT
				var exdata="sdate="+""+"&edate="+"";
				//console.log("termchk >>>>>>>>>>>>"+exdata);
			}


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

				//radio data
				$(".radiodata").each(function()
				{
					key=$(this).attr("name");
					data=$(":input:radio[name="+key+"]:checked").val();
					jsondata[key] = data;
				});			

				if(key=="NYchk" && data=="M")
				{

					var myip=$("input[name=myip]").val();
					if(isEmpty(myip))
					{
						alert("나의 ip를 입력해주세요");
						$("input[name=myip]").focus();
						return false;
					}
				}

				console.log(JSON.stringify(jsondata));
				callapi("POST","board","boardupdate",jsondata); 
			}
		}
		else
		{
			alert("<?=$txtdt['1899']?>");  //시작일이 종료일보다 늦을수없습니다. 날짜를 다시 확인해주세요
		}
	}

	function board_del() //삭제
	{
		var data = "seq="+$("input[name=seq]").val();
		var url = encodeURI($("input[name=returnData]").val());
		$("input[name=returnData]").val(url);

		callapidel('board','boarddelete',data);
		return false;
	}

	function makepage(json)
	{
		var obj = JSON.parse(json);
		console.log(obj);
		if(obj["apiCode"]=="boarddesc") //
		{	
			$("input[name=bbTitle]").val(obj["bbTitle"]); 

			$("textarea[name=bbDesc]").text(obj["bbDesc"]); 
			$("textarea[name=bbAnswer]").text(obj["bbAnswer"]); 

			$("input[name=bbTop]").val(obj["bbTop"]); 
			$("input[name=bbLeft]").val(obj["bbLeft"]); 
			$("input[name=bbWidth]").val(obj["bbWidth"]); 
			$("input[name=bbHeight]").val(obj["bbHeight"]); 

			$("input[name=bbFileSeq]").val(obj["afSeq"]); 

			$("input[name=bbLink]").val(obj["bbLink"]); 

			$("input[name=myip]").val(obj["bb_userid"]); 

			
			if(!isEmpty(obj["seq"]))
			{			
				
				$("input:radio[name='termchk']:radio[value="+obj["bb_popuplimit"]+"]").prop('checked', true); // 값체크
			}


			//---------------------------------------------------------------

			if(!isEmpty(obj["seq"]) && obj["bb_popuplimit"]=="Y")		
			{
	
				//팝업사용기간 표시
				 //월
				var bbSdate1=obj["bbSdate1"].substring(0,1);			

				if(bbSdate1.indexOf(0)!=-1)//십의 자리수에서 0문자포함
				{
					var bbSdate1=obj["bbSdate1"].substring(1,2);				
				}
				else
				{
					var bbSdate1=obj["bbSdate1"];			
				}

				//일
				var bbSdate2=obj["bbSdate2"].substring(0,1);			

				if(bbSdate2.indexOf(0)!=-1)//십의 자리수에서 0문자포함
				{
					var bbSdate2=obj["bbSdate2"].substring(1,2);
				}
				else
				{
					var bbSdate2=obj["bbSdate2"];				
				}

				//시
				var bbSdate3=obj["bbSdate3"].substring(0,1);			

				if(bbSdate3.indexOf(0)!=-1)//십의 자리수에서 0문자포함
				{
					var bbSdate3=obj["bbSdate3"].substring(1,2);
				}
				else
				{
					var bbSdate3=obj["bbSdate3"];					
				}

				var bbSdate4=obj["bbSdate4"].substring(0,1);			

				if(bbSdate4.indexOf(0)!=-1)//0문자포함   //두번째자리에 0이 붙었으면  체크하기
				{
					var bbSdate4=obj["bbSdate4"].substring(1,2);
				}
				else
				{
					var bbSdate4=obj["bbSdate4"];			
				}

				$("#sdateyear").val(obj["bbSdate0"]).attr("selected", "selected");
				$("#sdatemonth").val(bbSdate1).attr("selected", "selected");
				$("#sdateday").val(bbSdate2).attr("selected", "selected");

				$("#sdatehour").val(bbSdate3).attr("selected", "selected");
				$("#sdateminute").val(bbSdate4).attr("selected", "selected");
			

				var bbEdate1=obj["bbEdate1"].substring(0,1);			

				if(bbEdate1.indexOf(0)!=-1)//0문자포함
				{
					var bbEdate1=obj["bbEdate1"].substring(1,2);
				}
				else
				{
					var bbEdate1=obj["bbEdate1"];			
				}

				var bbEdate2=obj["bbEdate2"].substring(0,1);			

				if(bbEdate2.indexOf(0)!=-1)//0문자포함
				{
					var bbEdate2=obj["bbEdate2"].substring(1,2);
				}
				else
				{
					var bbEdate2=obj["bbEdate2"];			
				}


				var bbEdate3=obj["bbEdate3"].substring(0,1);			

				if(bbEdate3.indexOf(0)!=-1)//0문자포함
				{
					var bbEdate3=obj["bbEdate3"].substring(1,2);
				}
				else
				{
					var bbEdate3=obj["bbEdate3"];			
				}

				var bbEdate4=obj["bbEdate4"].substring(0,1);			

				if(bbEdate4.indexOf(0)!=-1)//0문자포함
				{
					var bbEdate4=obj["bbEdate4"].substring(1,2);
				}
				else
				{
					var bbEdate4=obj["bbEdate4"];			
				}

				$("#edateyear").val(obj["bbEdate0"]).attr("selected", "selected");
				$("#edatemonth").val(bbEdate1).attr("selected", "selected");
				$("#edateday").val(bbEdate2).attr("selected", "selected");		

				$("#edatehour").val(bbEdate3).attr("selected", "selected");
				$("#edateminute").val(bbEdate4).attr("selected", "selected");

				//---------------------------------------------------------------				
			}


			if(!isEmpty(obj["imgPop"]))
			{
				$("#img_popup").hide();
				var txt="<div class='viewimg' onclick=\"Imagedel('"+obj["afSeq"]+"', '')\" id=\"img_id_"+obj["afseq"]+"\" data-seq='"+obj["afseq"]+"'> <img src='"+getUrlData("FILE_DOMAIN")+obj["imgPop"]+"'> </div>	";
				$("#img_popup").after(txt);
			}

			CodeRadio("NYchkDiv", obj["popupopenList"], "<?=$txtdt['1956']?>", "NYchk", "NYchk-list", obj["bbUse"],"");//게시판 사용여부

			CodeRadio("linktypeDiv", obj["linktypeList"], "<?=$txtdt['1956']?>", "linktype", "linktype-list", obj["Linktype"],"");//게시판 링크유형 리스트

			CodeRadio("bbTypeDiv", obj["bbtypeList"], "<?=$txtdt['1115']?>", "bbtype", "bbtype-list", obj["bbType"],"readonly");//별전 리스트
	   }
	}
   callapi('GET','board','boarddesc','<?=$apidata?>'); //약재 상세 API 호출 & 옵션 호출

</script>
