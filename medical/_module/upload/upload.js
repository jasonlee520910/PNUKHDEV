// 이미지 정보들을 담을 배열
var sel_files = [];

$(document).ready(function(){
	var bar=$("#bar");
	var percent=$("#percent");
	//var status=$("#status");
	var percentVal='';
	console.log("1111111111111111111111111111111 fileupdate ");

	$('#frm').ajaxForm({
		url:getUrlData("FILE"),
		processData : false,
		contentType : false,
		headers : {"HeaderKEY":"first value"},
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
		complete:function(xhr){
			var obj = JSON.parse(xhr.responseText);
			console.log(obj);
			handleImgFileSelect(obj["data"]);
			if(obj["status"] == "SUCCESS" && obj["message"] == "FILE_UPLOAD_OK")
			{
				$("input[name=mmFileSeq]").val(obj["data"][0]["afseq"]);

				//alert("업로드 되었습니다.");

				//alertsign('success',getTxtData("FILE_UPLOAD_OK"),'top',1500);

				
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
				else {
					console.log("여기서 오류나요");
					alertsign('warning',getTxtData("FILE_UPLOAD_ERR03"),'top',1500);//파일 오류입니다.
					}
					
				
			}
		}
	});
});
function uploadImage()
{
	$("#input_imgs").click();
}
function fileup()
{
	console.log("!!!!!!!!!!!!!!fileup");
	$("#frm").submit();
}
//이미지미리보기 
function handleImgFileSelect(filesArr)
{
	var index = 0;
	$(".imgs_wrap").empty();
	var imghtml="";

	for(var key in filesArr)
	{
		sel_files.push(filesArr[key]);
	}
	for(var key in sel_files)
	{
		var chk=sel_files[key]["afThumbUrl"].substring(0,4);//버키 이미지 URL인지 체크하기 위해서 
		
		if(chk=="http")
		{
			imghtml+="<img src=\"" + (sel_files[key]["afThumbUrl"]) + "\"  data-file='"+sel_files[key]["afName"]+"' class='selProductFile' title='Click to remove'>";
		}
		else
		{
			imghtml = "<a href=\"javascript:void(0);\" onclick=\"deleteImageAction("+index+")\" id=\"img_id_"+index+"\" data-seq='"+sel_files[key]["afseq"]+"' >";
			imghtml+="<img src=\"" + (getUrlData("FILE_DOMAIN")+sel_files[key]["afThumbUrl"]) + "\"  data-file='"+sel_files[key]["afName"]+"' class='selProductFile' title='Click to remove'>";
			imghtml+="</a>";
		}

		$(".imgs_wrap").append(imghtml);
		index++;
	}

}

//이미지가 있던 배열 비워주기
function initImgDiv()
{
	sel_files=[]; 
}

//이미지 삭제 
function deleteImageAction(index) 
{
	var language = getCookie("ck_language");
	var img_txt="삭제하시겠습니까?";
	
	if(language == "chn")
		img_txt="是否取消？";
	else if(language == "eng")
		img_txt="Are you sure you want to delete this image?";
	else 
		img_txt="삭제하시겠습니까?";


	console.log("index : "+index);
	var img_id = "#img_id_"+index;
	//fildelete api 호출 
	var af_seq=$("#img_id_"+index).attr("data-seq");
	if(confirm(img_txt))
	{
		var data = "seq="+af_seq;
		sel_files.splice(index, 1);		
		$(img_id).remove(); 
		callapiupload('GET','file','filedelete',data);
	}

}
function setFileCode(code, fcode, seq)
{
	var upType=$("input[name=filecode]").data("type");
	upType=(!isEmpty(upType)) ? upType : code;
	console.log("setFileCode  upType = " + upType);
	$("input[name=filecode]").val(upType+"|"+fcode+"|"+seq);
	//$("input[name=filecode]").val("medihub|"+mhcode+"|"+seq);
}
function callapiupload(type,group,code,data)
{

	var language=$("#gnb-wrap").attr("value");
	var timestamp = new Date().getTime();
	if(isEmpty(language)){language="kor";}

	var url=getUrlData("FILE");
	console.log("url    >>>   "+url);
	switch(type)
	{
	case "GET": case "DELETE":
		url+="?apiCode="+code+"&language="+language+"&v="+timestamp+"&"+data;
		data="";
		break;
	case "POST":
		data["apiCode"]=code;
		data["language"]=language;
		break;
	}
	$.ajax({
		type : type, //method
		url : url,
		data : data,
		success : function (result) {
			//console.log("result " + result);
			chkMember(type, result);
		},
		error:function(request,status,error){
			console.log("code:"+request.status+"\n"+"message:"+request.responseText+"\n"+"error:"+error);
		}
   });
}