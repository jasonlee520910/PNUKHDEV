<?php //한의원관리  > 포장재관리
$root = "../..";
include_once ($root.'/_common.php');
$apidata="seq=".$_GET["seq"];
//echo $apidata;
//echo "pbCode>>>".$_GET["pbCode"];
$upload=$root."/_module/upload";
include_once $upload."/upload.lib.php";
?>

<input type="hidden" name="modifyAuth" class="" value="<?=$modifyAuth?>">
<input type="hidden" name="userid" class="" value="">

<script>

	function useupload(fcode, seq, staffid, language, pbCode)
	{
		var img_txt="이미지첨부";
	
		if(language == "chn")
			img_txt="附加图片";
		else if(language == "eng")
			img_txt="image upload";
		else 
			img_txt="이미지첨부";	

			var	txt="";
				txt+="<div class='upload'>";
				txt+="	<div class='uploaddiv'>";
				txt+="		<form id='"+fcode+"form'  method='post' enctype='multipart/form-data' action=\"javascript:upload('"+fcode+"');\">";
				txt+='			<span class="fileNone">';
				txt+='				<input type="file" name="uploadFile" id="'+fcode+'input_imgs" onchange=fileup_join("'+fcode+'") />';
				txt+='				<input type="text" name="filecode" id="'+fcode+'filecode" value="packingbox|'+pbCode+'|'+seq+'">';
				txt+='				<input type="text" name="fileck" id="'+fcode+'fileck" value="'+staffid+'|'+language+'">';
				txt+='			</span>';		
				txt+='			<button type="button" class="sp-btn" onclick="uploadImage(\''+fcode+'\');">'+img_txt+'</button>';				
				txt+='		</form>';
				txt+="	</div>";
				txt+="	<div class='progress'>";
				txt+="		<div class='bar' id='bar'></div>";
				txt+="		<div class='percent' id='percent'>0%</div>";
				txt+="	</div>";
				txt+="	<div>";
				txt+='		<div class="imgs_wrap" id="imgs_wrap_id"></div>';
				txt+="	</div>";
				txt+="</div>";
				//console.log(txt);
			$("#"+fcode).html(txt);
	}

	function uploadImage(fcode)
	{
		console.log("uploadImage  fcode ====>  " + fcode);
		$("#"+fcode+"input_imgs").click();
	}

	function fileup_join(fcode)
	{
		console.log("fileup_join fcode ====> "+fcode );
		$("#"+fcode+"form").submit();
	}

	function upload(fcode)
	{
		console.log("upload fcode ===> " + fcode);

		var bar=$("#bar");
		var percent=$("#percent");
		var percentVal='';

        $("#"+fcode+"form").ajaxForm({
            url:getUrlData("FILE"),
            dataType : "json",
            error : function(){
                alert("에러입니다~~~~~") ;
            },
			beforeSubmit: function (data,form,option) {
				console.log("beforeSubmit  data = " + data + ", form = " + form + ", opotion = " + option);
				//status.empty();
				percentVal = '0%';
				bar.width(percentVal);
				percent.html(percentVal);
				//validation체크 
				//막기위해서는 return false를 잡아주면됨
				return true;
			},
			uploadProgress:function(event,position,total,percentComplete){
				percentVal = percentComplete + '%';
				percent.html(percentVal);
				bar.width(percentVal);
			},
			error: function(response, status, e){
				console.log(JSON.stringify(e));
				//console.log("error  response = " + response+", status = " + status+", e = " + e);
			}, 
			
            success : function(result){
				var obj = result;
				console.log(obj);
				if(obj["status"] == "SUCCESS" && obj["message"] == "FILE_UPLOAD_OK")
				{
					alertsign('success',getTxtData("FILE_UPLOAD_OK"),'top',1500);
					handleImgFileSelect(obj["data"]);  //이미지 보여주기		
					
					var apidatadesc= "userid="+$("input[name=userid]").val();
					console.log("apidatadesc   >>>>"+apidatadesc);	
					callapi('GET','inventory','mypackingdesc',apidatadesc);  //리스트 다시 보여줌					
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
        $("#"+fcode+"form").submit() ;
    }

</script>

<!--// page start -->
<div class="board-view-wrap">
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
				<th><span class="nec"><?=$txtdt["1132"]?><!-- 분류 --></span></th>
				<td colspan="3" id="selcatetdDiv"></td>
			</tr>
			<tr>
				<th><span class="nec"><?=$txtdt["1440"]?><!-- 포장재명 --></span></th>
				<td><input type="text" name="pbTitle"  class="w200 reqdata necdata" title="<?=$txtdt["1440"]?>" /></td>
				<th><span class="nec"><?=$txtdt["1392"]?></span></th>
				<td>
					<div class="whCodeLeft">
						<input type="text" name="pbCode" class="w200 reqdata necdata" title="<?=$txtdt["1392"]?>" readonly/>
					</div>
					<div id="bpDiv" class="whCodeRight"></div>
				</td>
			</tr>
			<tr>
				<th><span class="nec"><?=$txtdt["1588"]?><!-- 가격 --></span></th>
				<td><input type="text" class="reqdata necdata" title="<?=$txtdt["1588"]?>" id="pbPrice" name="pbPrice" value="" maxlength="6" onfocus="this.select();" onchange="changeNumber(event, false);"/></td>
				<th><span class="nec"><?=$txtdt["1386"]?><!-- 팩용량 --></span></th>
				<td><input type="text" class="reqdata necdata" title="<?=$txtdt["1386"]?>" id="pbCapa" name="pbCapa" value="" maxlength="6" onfocus="this.select();" onchange="changeNumber(event, false);"/></td>
			</tr>
			<tr>
				<th><span class=""><?=$txtdt["1054"]?><!-- 담당자 --></span></th>
				<td><input type="text" name="pbStaff" class="reqdata" value=""/></td>
			</tr>
			<tr>
				<th><span class=""><?=$txtdt["1248"]?><!-- 이미지첨부 --></span></th> 
				<td colspan="3">
					<span id="packingdiv"></span>
					<script>useupload("packingdiv",$("input[name=pbseq]").val(),"<?=$_COOKIE['ck_stStaffid']?>","<?=$_COOKIE['ck_language']?>","<?=$_GET['pbCode']?>");</script>
				</td>
			</tr>
			<tr>
				<th><span><?=$txtdt["1173"]?><!-- 설명 --></span></th>
				<td colspan="3">
					<textarea class="text-area reqdata" name="pbDesc"></textarea>
				</td>
			</tr>
		</tbody>
	</table>
	<div class="btn-box c" id="btnDiv"></div>
</div>

<!--// page end -->

<script>

	function packingupdate()
	{
		var pbtype=$("input:radio[name=pbType]:checked").val();
		console.log("pbtype   >>>"+pbtype);  //odPacktype

		if(pbtype=="reBoxmedi" || pbtype=="reBoxdeli")
		{
			//$("input[name=pbCapa]").val("0");
		}
		else
		{
			var pbcapa=$("input[name=pbCapa]").val();
			pbcapa=(!isEmpty(pbcapa)) ? parseInt(pbcapa) : 0;

			if(pbcapa <= 0)
			{
				alertsign("info", "<?=$txtdt['1833']?>", "", "2000");//팩용량을 입력해주세요.
				return false;
			}
		}			
		
		if(necdata()=="Y") //필수값체크
		{
			
			var key=data="";
			var jsondata={};

			$(".radiodata").each(function()
			{
				key=$(this).attr("name");
				data=$("input:radio[name="+key+"]:checked").val();
				jsondata[key] = data;
			});

			$(".reqdata").each(function()
			{
				key=$(this).attr("name");
				data=$(this).val();
				jsondata[key] = data;
			});
			console.log(JSON.stringify(jsondata));
			callapi("POST","inventory","packingupdate",jsondata);
		}
	}

	//상세페이지 닫기
	function closeDiv()
	{
		$("#packingDiv .board-view-wrap").animate({
			"height":0
		},200,"linear", function(){
			$("#packingDiv").html("");
		});
		//callapi('GET','inventory','mypackingdesc','<?=$apidata?>'); 
	}

	function viewmypackingdesc(obj)
	{
		//parseradiocodes("selcatetdDiv", obj["pbTypeList"], '<?=$txtdt["1132"]?>', "pbType", "pbtype-list", obj["pb_type"]);//분류
		
		var newpbDate = getNewDate();
		var newpbCode = getNowFull(2);
		var pbCode = (!isEmpty(obj["pbCode"])) ? obj["pbCode"] : "PCB"+newpbCode;
		var pbDate = (!isEmpty(obj["pbDate"])) ? obj["pbDate"] : newpbDate;

		//$("input[name=pbCode]").val(pbCode); //포장재코드

		var data = "";
		var afFile=afThumbUrl="NoIMG";

		$(".packingtbl tbody").html("");
		if(!isEmpty(obj["pklist"]))
		{
			$(obj["pklist"]).each(function( index, value )
			{

				afFile = "<img src='<?=$root?>/_Img/Content/noimg.png'>";
				if(value["afFile"]!="NoIMG")
				{
					afFile = "<img src='"+getUrlData("FILE_DOMAIN")+value["afFile"]+"' onerror=\"this.src='<?=$root?>/_Img/Content/noimg.png'\" >";
				}
				afThumbUrl = "<img src='<?=$root?>/_Img/Content/noimg.png'>";
				if(value["afThumbUrl"]!="NoIMG")
				{
					afThumbUrl = "<img src='"+getUrlData("FILE_DOMAIN")+value["afThumbUrl"]+"' onerror=\"this.src='<?=$root?>/_Img/Content/noimg.png'\" >";
				}

				data+="<tr class=\"modinput modinput_"+value["pb_seq"]+" \" style='cursor:pointer;' onclick=\"modinput2('_packing','"+value["pb_seq"]+"', '"+value["pb_seq"]+"')\" >";

				data+="<td class='thumb'>"+afThumbUrl+"</td>";//이미지
				data+="<td class='l'>"+value["pbTypeName"]+"</td>";//분류
				data+="<td class='l'>"+value["pb_code"]+"</td>"; //포장재코드
				data+="<td class='l'>"+value["pb_title"]+"</td>"; //포장재명
				data+="<td class='l'>"+value["pb_date"]+"</td>"; //등록일
				data+="</tr>";

				parseradiocodes("selcatetdDiv", obj["pbTypeList"], '<?=$txtdt["1132"]?>', "pbType", "pbtype-list",value["pb_type"]);//분류
			});
		}
		else
		{
			data+="<tr id='nodata'>";
			data+="<td colspan='5' ><?=$txtdt['1665']?></td>";   //데이터가 없습니다.
			data+="</tr>";
		}
		$(".packingtbl tbody").html(data);

		console.log("pbCode =>>> " + pbCode);
		setFileCode("packingbox", pbCode, $("input[name=pbseq]").val());
		//upload된 이미지가 있다면
		if(!isEmpty(obj["afFiles"]))
		{
			console.log(JSON.stringify(obj["afFiles"]))
			handleImgFileSelect(obj["afFiles"]);
		}
	}

	function makepage(json)
	{
		var obj = JSON.parse(json);
		console.log(obj);
		var data=miStatus="";
		if(obj["apiCode"]=="packingdesc")
		{
			$("input[name=userid]").val(obj["miUserid"]); //userid
			$("input[name=pbTitle]").val(obj["pbTitle"]); //포장재명
			$("input[name=pbCode]").val("<?=$_GET['pbCode']?>"); //포장재코드
			$("input[name=pbPrice]").val(obj["pbPrice"]); //가격
			$("input[name=pbCapa]").val(obj["pbCapa"]); //팩용량
			$("input[name=pbStaff]").val(obj["pbStaff"]); //담당자
			$("textarea[name=pbDesc]").val(obj["pbDesc"]); //설명

			parseradiocodes("selcatetdDiv", obj["pbTypeList"], '<?=$txtdt["1132"]?>', "pbType", "pbtype-list", obj["pbType"]);//분류
			
			//upload된 이미지가 있다면
			if(!isEmpty(obj["afFiles"]))
			{
				initImgDiv();//이미지 담아 놓은 배열 초기화 하자 
				handleImgFileSelect(obj["afFiles"]);
			}

			if(!isEmpty(obj["pbCode"]))
			{
				var barHtml = '';
				barHtml='<a href="javascript:;" onclick="printbarcode(\'label\',\''+obj["pbType"]+'|'+obj["seq"]+'\',500)" ><button class="sp-btn"><span>+ <?=$txtdt["1098"]?><!-- 바코드출력 --></span></button></a>';//<!-- 바코드출력 -->
				$("#bpDiv").html(barHtml);
			}

			var btnHtml='';
			var json = "seq="+obj["seq"];
			var Auth = $("input[name=modifyAuth]").val();

			if(Auth=="true")
			{		
				btnHtml='<a href="javascript:;" onclick="packingupdate();" class="bdp-btn"><span><?=$txtdt["1441"]?></span></a> ';//저장하기
				btnHtml+='<a href="javascript:;" onclick="closeDiv();" class="bw-btn"><span><?=$txtdt["1595"]?></span></a> ';//닫기

				if(!isEmpty(obj["seq"]))
					btnHtml+='<a href="javascript:;" onclick="callapidel(\'inventory\',\'packingdelete\',\''+json+'\')" class="bdp-btn"><span><?=$txtdt["1154"]?></span></a>';//삭제하기
			}
			else
			{
				btnHtml+='<a href="javascript:;" onclick="closeDiv();" class="bw-btn"><span><?=$txtdt["1087"]?></span></a> ';//닫기
			}
			$("#btnDiv").html(btnHtml);

/*
			if(isEmpty(obj["pbCode"]))  //포장재추가일때
			{
				var newpbCode = getNowFull(2);
				var pbCode = (!isEmpty(obj["pbCode"])) ? obj["pbCode"] : "PCB"+newpbCode;
				$("input[name=pbCode]").val(pbCode); //포장재코드
			}
			*/
		}
		else if(obj["apiCode"]=="filedelete")//파일을 삭제했을때 리스트 새로고침
		{
			if(obj["resultCode"]=="200")
			{
				var apidata="userid="+$("input[name=userid]").val();
				console.log("filedelete     apidata  >>>"+apidata);
				callapi('GET','inventory','mypackingdesc',apidata);

				console.log("삭제하고 리스트 새로고침");
				viewmypackingdesc(obj);
			}	
		}
		else if(obj["apiCode"]=="mypackingdesc")
		{
			viewmypackingdesc(obj);
			return false;
		}
	}

	callapi('GET','inventory','packingdesc','<?=$apidata?>'); 	//포장재등록 API 호출
	
	</script>