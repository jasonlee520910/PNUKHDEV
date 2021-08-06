<?php //한의사관리 
$root = "../..";
include_once ($root.'/_common.php');
$upload=$root."/_module/upload";
include_once $upload."/upload.lib.php";

?>
<script  type="text/javascript" src="<?=$root?>/cmmJs/jquery/jquery.form.min.js"></script>
<link rel="stylesheet" media="all" href="<?=$upload?>/upload.css?v=<?php echo time();?>" />
<script  type="text/javascript" src="<?=$upload?>/upload.js?v=<?=time()?>"></script>
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
		$("#sdate").datepicker({
			maxDate :  $.datepicker.parseDate($.datepicker._defaults.dateFormat, $("#edate").val()),
			onSelect:function(selectedDate){
				$("#edate").datepicker('option', 'minDate', $.datepicker.parseDate($.datepicker._defaults.dateFormat, selectedDate));
			}
		});
		$("#edate").datepicker({
			minDate :  $.datepicker.parseDate($.datepicker._defaults.dateFormat, $("#sdate").val()),
			onSelect:function(selectedDate){
				$("#sdate").datepicker('option', 'maxDate', $.datepicker.parseDate($.datepicker._defaults.dateFormat, selectedDate));
			}
		});
	})
</script>
<input type="hidden" name="miUserid" class="reqdata" value="<?=$miUserid?>">
<input type="hidden" name="seq" class="reqdata" value="">
<input type="hidden" name="status" class="reqdata" value="">
<input type="hidden" name="me_company" class="reqdata" value="">
<input type="hidden" name="meSeq" class="reqdata" value="">

<div id="pagegroup" value="member"></div>
<div id="pagecode" value="doctorlist"></div>

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
				<th><span><?=$txtdt["1038"]?><!-- 기간선택 --></span></th>
				<td><?=selectperiod()?></td>
			<tr>
				<th><span><?=$txtdt["1455"]?><!-- 상태별 --></span></th>
				<td><?=statusType()?></td>
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
		<p class="fl"></p>
			<!-- <?if($modifyAuth == "true" || $modifyAuth == "admin"){?>
				<p class="fr">
					<button class="btn-blue"><span onclick="descview('add')">+ 한의사등록</span></button>
				</p>
			<?}?> -->
	</div>

	<table id="tbllist" class="tblcss">
		<caption><span class="blind">번호,분류,내용,담당자,등록일,완료예정일,완료일,중요도,상태를 나타내는 이슈관리 테이블 입니다.</span></caption>
		<colgroup>
			<col scope="col" width="7%">
			<col scope="col" width="10%">
			<col scope="col" width="10%">
			<col scope="col" width="10%">
			<col scope="col" width="11%">
			<col scope="col" width="*">			
			<col scope="col" width="10%">
			<col scope="col" width="10%">
			<col scope="col" width="12%">
			<col scope="col" width="10%">
		</colgroup>
		<thead>
			<tr>
				<th>한의사이름<?//=$txtdt["1061"]?><!-- 대표자명 --></th>
				<th>소속된 한의원명<?//=$txtdt["1061"]?><!-- 대표자명 --></th>
				<th>로그인ID<?//=$txtdt["1061"]?><!-- 대표자명 --></th>
				<th>면허번호<?//=$txtdt["1061"]?><!-- 대표자명 --></th>
				<th>전화번호<?//=$txtdt["1061"]?><!-- 대표자명 --></th>
				<th>이메일<?//=$txtdt["1061"]?><!-- 대표자명 --></th>
				<th><?=$txtdt["1014"]?><!-- 가입일 --></th>		
				<th>면허증</th>		
				<th><?=$txtdt["1164"]?><!-- 상태 --></th>
				<th><?//=$txtdt["1164"]?><!-- 상태 --></th>
			</tr>
		</thead>
		<tbody>
		</tbody>
	</table>
</div>

<div class="gap"></div>

<!-- s : 게시판 페이징 -->
<div class='paging-wrap' id="doctoristpage"></div>
<!-- e : 게시판 페이징 -->

<script>
	function repageload(){
	console.log("no  repageload ");
	}

	//한의원등록하기
	function joinMedical(meSeq,meStatus)
	{
		$("input[name=meSeq]").val(meSeq); 

		var url="layer-medical"
		var size="700,600"
		var data = "&page=1&psize=5&block=10"; //page,psize,block 사이즈 초기화
		console.log("=========>>>> viewlayerPopup url = " + url+", size = " + size);

		getlayer(url,size,data);
	}

	//한의원에 등록
	function gostandby(me_company)
	{
		$("input[name=me_company]").val(me_company); 

		if(confirm("이 한의원에 등록을 하시겠습니까?"))
		{
			var key=data="";
			var jsondata={};

			$(".reqdata").each(function(){
				key=$(this).attr("name");
				data=$(this).val();
				jsondata[key] = data;
			});

			console.log(JSON.stringify(jsondata));

			//한의사의 me_userid랑 me_company값이랑 같이 넘기기
			console.log("jsondata  >>>>>>>"+jsondata);
			callapi("POST","member","medicaldoctorupdate",jsondata);
			
			closediv('viewlayer')
			location.reload();
		}	
	}


	function openDoctorImg(url)
	{
		console.log("url    >>>>>"+url);
		var winWidth=500;
		var winHeight=700;
		window.open("/99_LayerPop/document.doctorimg.php?url="+url,"proc_doctorImg","width="+winWidth+",height="+winHeight);
	}

	function doimgdelete(seq,id)
	{
		if(confirm("면허증 이미지를 삭제하시겠습니까?"))
		{	
			//fileseq, 한의사userid
			var data = "seq="+seq+"&id="+id;
			console.log("data : "+data);
			callapiupload('GET','file','filedelete',data);
			location.reload();
		}
	}

	//면허증등록버튼
	function uploadbtn(id,meseq)
	{
		console.log("id  >>>>>>>>>"+id);
		useupload("license",id,"1",meseq);
	}

	function useupload(fcode,staffid, seq, meseq)
	{
		console.log("fcode   >>>"+fcode);
		console.log("staffid   >>>"+staffid);
		console.log("seq   >>>"+seq);

		$("#frm").remove();
		var	txt='<form id="frm"  method="post" enctype="multipart/form-data" action=javascript:upload(\"'+fcode+'\");>';
			txt+='	<span class="fileNone">';
			txt+='		<input type="file" name="uploadFile" id="input_imgs" onchange="fileup()" />';
			txt+='		<input type="text" name="filecode" id="filecode" value="license|'+meseq+'|'+seq+'">';
			txt+='		<input type="text" name="fileck" id="fileck" value="'+staffid+'|kor">';
			txt+='		<input type="text" name="fileapiurl" id="fileapiurl" value="url">';
			txt+='	</span>';		
			txt+='</form>';
console.log("txt   >>>"+txt);				
		$("#licenseDiv"+staffid).html(txt);
		uploadImg();	
	}

	function uploadImg()
	{
		$("#input_imgs").click();	
	}

	function upload(fcode){
		console.log("fcode    >>>  "+fcode);

			//이미지 업로드할때 기존 이미지가 있는경우는 삭제하고 이미지 업로드
			var af_seq=$("#img_id_"+fcode).attr("data-seq");

			if(af_seq && af_seq!=undefined)
			{
				$("#img_id_"+fcode).html(""); 
				var data = "seq="+af_seq;
				$("#img_id_"+fcode).remove(); 
				callapiupload('GET','file','filedelete',data);

			}

        $("#frm").ajaxForm({
            url:getUrlData("FILE"),
            //enctype : "multipart/form-data",
            dataType : "json",
            error : function(){
                alert("에러") ;
            },
            success : function(result){
				var obj = result;
				console.log(obj);
				if(obj["status"] == "SUCCESS" && obj["message"] == "FILE_UPLOAD_OK")
				{
					alertsign('success',getTxtData("FILE_UPLOAD_OK"),'top',1500);
					console.log(JSON.stringify(obj["data"]));
					var txt="<div class='viewimg' onclick=\"Imagedel('"+obj["data"][0]["afseq"]+"', '"+obj["data"][0]["afUserid"]+"')\" id=\"img_id_"+obj["data"][0]["afUserid"]+"\" data-seq='"+obj["data"][0]["afseq"]+"'> <img src='"+getUrlData("FILE_DOMAIN")+obj["data"][0]["afUrl"]+"'> </div>	";
					$("#img_"+fcode).after(txt);
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
		location.reload();
    }

	function goconfirm(seq,status,img)
	{
		console.log("seq    >>>>"+seq);
		console.log("status    >>>>"+status);
		console.log("img    >>>>"+img);

		$("input[name=seq]").val(seq); 
		$("input[name=status]").val(status); 

		var key=data="";
		var jsondata={};

		$(".reqdata").each(function(){
			key=$(this).attr("name");
			data=$(this).val();
			jsondata[key] = data;
		});


		//면허증이 있는지 체크
		if(img!="NoIMG")
		{
			if(status=="apply") 
			{
				if(confirm("이메일인증을 하시겠습니까??"))
				{	
					callapi("POST","member","mydoctorupdate",jsondata);
					location.reload();
				}
			}
			else if(status=="emailauth") 
			{
				if(confirm("면허증 확인을 하시겠습니까??"))
				{	
					callapi("POST","member","mydoctorupdate",jsondata);
					location.reload();
				}
			}
			else if(status=="request") //승인요청
			{
				if(confirm("요청을 취소 하시겠습니까?"))
				{	
					callapi("POST","member","mydoctorupdate",jsondata);
					location.reload();
				}
			}
			else if(status=="standby")
			{
				if(confirm("소속한의사로 승인하시겠습니까?"))
				{
					callapi("POST","member","mydoctorupdate",jsondata);
					location.reload();
				}	
			}
			else if(status=="confirm")
			{
				if(confirm("소속한의사를 삭제하시겠습니까?"))
				{
					callapi("POST","member","mydoctorupdate",jsondata);
					location.reload();
				}
			}	
		}
		else
		{
				alertsign("warning", "등록된 면허증이 없습니다. 면허증을 등록해주세요", "", "1500");				
		}
	}

	function makepage(json)
	{
		var obj = JSON.parse(json);
		console.log(obj);
		var data=miStatus=imgDoctor=imgdeleteBtn=insertImg="";
		if(obj["apiCode"]=="doctorlist")
		{
			$("#tbllist tbody").html("");
			if(!isEmpty(obj["list"]))
			{
				$(obj["list"]).each(function( index, value )
				{
					imgDoctor=imgdeleteBtn=insertImg="";
					data+='<tr style="cursor:pointer;" >';
					data+='<td>'+value["meName"]+'</td>'; //한의원이름
					data+='<td>'+value["miName"]+'</td>'; //한의원명
					data+='<td>'+value["meLoginid"]+'</td>'; //한의원등급
					data+='<td>'+value["meRegistno"]+'</td>'; //대표자명
					data+='<td>'+value["meMobile"]+'</td>'; //주소
					//data+="<td class='l'>"+value["meEmail"]+"</td>";   //이메일
					data+="<td>"+value["meEmail"]+'</td>';   //이메일
					data+="<td>"+value["meDate"]+'</td>'; //대표번호

					if(value["afFilel"]!="NoIMG")
					{
						imgDoctor='<span class="r-stat r-stat05" onclick="openDoctorImg(\''+value["afFilel"]+'\')">면허증보기</span>';
						imgdeleteBtn='<span class="r-stat r-stat06" onclick="doimgdelete(\''+value["afSeq"]+'\',\''+value["meUserid"]+'\')">삭제</span>';
						data+='<td>'+imgDoctor+'&nbsp;&nbsp;&nbsp;'+imgdeleteBtn+'</td>';   //면허증보기	
					}
					else
					{					
						insertImg='<span id="licenseDiv'+value["meUserid"]+'"></span><span class="r-stat r-stat08" onclick="uploadbtn(\''+value["meUserid"]+'\',\''+value["meSeq"]+'\')" >면허증등록</span>';
						data+='<td>'+insertImg+'</td>';   //면허증보기				
					}				
					
					//data+='<td><span class="r-stat r-stat12" onclick="">'+value["meStatusName"]+'</span></td>'; //상태
					data+='<td><span class="" onclick="">'+value["meStatusName"]+'</span></td>'; //상태
					 
					if(value["meStatus"]!="approve")
					{
						if(!isEmpty(value["Btn"]))
						{
							var colorBtn="";
							if(value["meStatus"]=="confirm")
							{
								colorBtn="r-stat12";
							}
							else if(value["meStatus"]=="apply")
							{
								colorBtn="r-stat13";						
							}
							else if(value["meStatus"]=="request")
							{
								colorBtn="r-stat14";							
							}
							else if(value["meStatus"]=="standby")
							{
								colorBtn="r-stat15";							
							}
							else 
							{
								colorBtn="r-stat16";							
							}
							data+='<td><span class="r-stat '+colorBtn+'" onclick="goconfirm(\''+value["meSeq"]+'\',\''+value["meStatus"]+'\',\''+value["afFilel"]+'\')">'+value["Btn"]+'</span></td>'; //상태
						}
						else
						{
							data+='<td><span></span></td>'; //상태
						}
					}
					else
					{
						if(!isEmpty(value["Btn"]))
						{
							data+='<td><span class="r-stat r-stat10" onclick="joinMedical(\''+value["meSeq"]+'\',\''+value["meStatus"]+'\',\''+value["afFilel"]+'\')">'+value["Btn"]+'</span></td>'; //상태
						}
						else
						{
							data+='<td><span></span></td>'; //상태
						}					
					}				
					data+='</tr>';
				});
			}
			else
			{
				data+='<tr>';
				data+='<td colspan="10"><?=$txtdt["1665"]?></td>';
				data+='</tr>';
			}

			//테이블에 넣기
			$("#tbllist tbody").html(data);
			$("#pagecnt").text(comma(obj["tcnt"])+" <?=$txtdt['1019']?>");
			//페이징
			getsubpage("doctoristpage",obj["tpage"], obj["page"], obj["block"], obj["psize"]);
		}
		else if(obj["apiCode"]=="medicallist") //한의원리스트
		{
			$("#pop_medicaltbl tbody").html("");
			var data = "";
			if(!isEmpty(obj["list"]))
			{
				$(obj["list"]).each(function( index, value )
				{
					data+='<tr class="putpopdata" data-id="'+value["miUserid"]+'" data-name="'+value["miName"]+'" data-etc="'+value["miDoctor"]+'">';
					data+='<td>'+value["miName"]+'&nbsp;&nbsp;&nbsp;'+'<button type="button" class="r-stat r-stat09"  onclick="gostandby(\''+value["miUserid"]+'\');">한의원등록하기</button>'+'</td>';
					data+='<td>'+value["miPersion"]+'</td>';
					data+='<td>'+value["miBusinessno"]+'</td>';				
					data+='</tr>';
				});
			}
			else
			{
				data+="<tr>";
				data+="<td colspan='3'><?=$txtdt['1665']?></td>";
				data+="</tr>";
			}
			//한의원리스트
			$("#pop_medicaltbl tbody").html(data);

			//페이징
			getsubpage_pop("medicallistpage",obj["tpage"], obj["page"], obj["block"], obj["psize"]);
		}
	}


	//한의원리스트 API 호출
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
		if(sarr[1]!=undefined)var sarr2=sarr[1].split("=");
		if(sarr[2]!=undefined)var sarr3=sarr[2].split("=");
		if(sarr[3]!=undefined)var sarr4=sarr[3].split("=");
		if(sarr[4]!=undefined)var sarr5=sarr[4].split("=");
		if(sarr1[1]!=undefined)var sdate=sarr1[1];
		if(sarr2[1]!=undefined)var edate=sarr2[1];
		if(sarr3[1]!=undefined)var searchTxt=sarr3[1];
		if(sarr4[1]!=undefined)var searchStatus=sarr4[1];
		if(sarr5[1]!=undefined)var searchPeriodEtc=sarr5[1];
		
		$("input[name=sdate]").val(sdate);
		$("input[name=edate]").val(edate);
		$("input[name=searchTxt]").val(decodeURI(searchTxt));
		//searPeriodEtc
		//------------------------------------------------------
		//상태 체크박스 
		//------------------------------------------------------
		var starr=searchStatus.split(",");
		for(var i=0;i<starr.length;i++){
			if(starr[i]!=""){
				$(".searchStatus"+starr[i]).attr("checked",true);
			}
		}
		//------------------------------------------------------
		
		//------------------------------------------------------
		//기간선택 라디오박스 
		//------------------------------------------------------
		var pearr=searchPeriodEtc.split(",");
		for(var i=0;i<pearr.length;i++){
			if(pearr[i]!=""){
				$(".searPeriodEtc"+pearr[i]).attr("checked",true);
			}
		}
		//------------------------------------------------------

		apiOrderData="&sdate="+sdate+"&edate="+edate+"&searchTxt="+searchTxt+"&searchStatus="+searchStatus;
	}

	var apidata="page="+page+apiOrderData;
	console.log("apidata     : "+apidata);
	callapi('GET','member','doctorlist',apidata);
	$("#searchTxt").focus();

</script>
