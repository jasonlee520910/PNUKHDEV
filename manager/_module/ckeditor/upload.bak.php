<?php 
$root = "../..";
include_once ($root.'/_common.php');
echo "<script>upload();</script>";
?>
<form id="frm"  method="post" enctype="multipart/form-data" action="javascript:upload();">
<input type="file" name="uploadFile" id="input_imgs" value="<?=$_FILES?>"/>
<input type="text" name="filecode" id="filecode" value="policy|img|1">
<input type="text" name="fileck" id="fileck" value="admin|kor">
<input type="text" name="fileapiurl" id="fileapiurl" value="url">
</form>

<script language="javascript">
	
	function upload(){
			console.log("upload!!!!!!!!!!!!!!");
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
				//handleImgFileSelect(obj["data"]);
				console.log("이미지를 보여주는 함수 호출 할 부분");  
				//imgShow("img1", "staff", obj["files"]);
				if(obj["status"] == "SUCCESS" && obj["message"] == "FILE_UPLOAD_OK")
				{
					alert("업로드되었습니다."+obj);
					
					//console.log(JSON.stringify(obj["data"]));
					//var txt="<div class='viewimg' onclick=\"Imagedel('"+obj["data"][0]["afseq"]+"', '"+obj["data"][0]["afUserid"]+"')\" id=\"img_id_"+obj["data"][0]["afUserid"]+"\" //data-seq='"+obj["data"][0]["afseq"]+"'> <img src='"+getUrlData("FILE_DOMAIN")+obj["data"][0]["afUrl"]+"'> </div>	";
					//$("#img_"+fcode).after(txt);
				}
				else
				{
					if(obj["message"] == "FILE_UPLOAD_FAIL")
						alert("파일업로드에 실패했습니다.");
					else if(obj["message"] == "FILE_UPLOAD_ERR01")
						alert("첨부파일 사이즈는 5MB 이내로 등록 가능합니다.");
					else if(obj["message"] == "FILE_UPLOAD_ERR02")
						alert("허용된 파일형식이 아닙니다.");
					else if(obj["message"] == "FILE_UPLOAD_ERR04")
						alert("도메인 관리자에게 문의 바랍니다.");
					else
						alert("파일 오류입니다.");				
				}
            }
        });
        $("#frm").submit() ;
		//location.reload();
    }
	
</script>

<?php 
//echo '{"filename" : '.$uploadfileName.'", "uploaded" : 1, "url":"'.$uploadfile.'"}';
?>
