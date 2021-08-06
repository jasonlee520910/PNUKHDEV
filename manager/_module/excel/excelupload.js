$(document).ready(function(){
	//var bar=$("#bar");
	//var percent=$("#percent");
	//var percentVal='';

	$('#excelfrm').ajaxForm({
		url:getUrlData("EXCEL"),
		processData : false,
		contentType : false,
		headers : {"HeaderExcelKEY":"excelvaluekey"},
		beforeSubmit: function (data,form,option) {
			console.log("beforeSubmit  data = " + data + ", form = " + form + ", opotion = " + option);
			//status.empty();
			//percentVal = '0%';
			//bar.width(percentVal);
			//percent.html(percentVal);
			//validation체크 
			//막기위해서는 return false를 잡아주면됨
			return true;
		},
		uploadProgress:function(event,position,total,percentComplete){
			//percentVal = percentComplete + '%';
			//percent.html(percentVal);
			//bar.width(percentVal);
		},
		error: function(response, status, e){
			console.log(JSON.stringify(e));
			//console.log("error  response = " + response+", status = " + status+", e = " + e);
		}, 
		complete:function(xhr){
			var obj = JSON.parse(xhr.responseText);
			console.log(obj);

			if(obj["status"] == "SUCCESS" && obj["message"] == "FILE_UPLOAD_OK")
			{
				alertsign('success',getTxtData("EXCEL_UPLOAD_OK"),'top',2000);
				$("input[name=exceluploadFile]").val("");
				viewpage();
			}
			else
			{
				if(obj["message"] == "FILE_UPLOAD_FAIL")
					alertsign('warning',getTxtData("FILE_UPLOAD_FAIL"),'top',2000);//파일업로드에 실패했습니다.
				else if(obj["message"] == "FILE_UPLOAD_ERR01")
					alertsign('warning',getTxtData("FILE_UPLOAD_ERR01"),'top',2000);//첨부파일 사이즈는 100MB 이내로 등록 가능합니다.
				else if(obj["message"] == "FILE_UPLOAD_ERR02")
					alertsign('warning',getTxtData("FILE_UPLOAD_ERR02"),'top',2000);//허용된 파일형식이 아닙니다.
				else if(obj["message"] == "FILE_UPLOAD_ERR04")
					alertsign('warning',getTxtData("FILE_UPLOAD_ERR04"),'top',2000);//도메인 관리자에게 문의 바랍니다.
				else 
					alertsign('warning',getTxtData("FILE_UPLOAD_ERR03"),'top',2000);//파일 오류입니다.
				
			}
		}

	});
});

function exceluploadfile()
{
	console.log("exceluploadfileexceluploadfileexceluploadfileexceluploadfile");
	$("#exceluploadFile").click();
}
function excelfileup()
{
	console.log("excelfileupexcelfileupexcelfileupexcelfileupexcelfileup");
	$("#excelfrm").submit();
}