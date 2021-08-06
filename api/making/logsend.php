<script src="../../_common/js/jquery-1.11.1.min.js"></script>
<script>
function jsonparser(msg,targetid){
	console.log(msg);
	//var data=JSON.parse(msg,true);
	var data=JSON.stringify(msg);
	$("#"+targetid).text(data);
}

	function goapi(apimethod,apiurl,targetid){
		$.ajax({
			type : apimethod,// 타입 전송
			url : apiurl,// 전송 url
			dataType : "json",
			data : {
				"apiCode":"logtest"
				,"language":"kor"
				,"command":"004"
				,"tableno":"00001"
				,"status":"end"
				,"text":""
			},
			success : function(data){// 콜백 성공 응답시 실행
				jsonparser(data,targetid);
			},
			error : function(){// Ajax 전송 에러 발생시 실행
				alert("error");
			},
			complete : function(data){//  success, error 실행 후 최종적으로 실행
			}
		});
	}
	goapi("POST","http://www.djmedi.kr/_adm/_api/making/","testid");
</script>
<div id="testid">aaa</div>