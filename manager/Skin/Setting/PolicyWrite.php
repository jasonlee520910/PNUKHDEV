<?php
$root = "../..";
include_once ($root.'/_common.php');
if($_GET["seq"]=="add")
{
	$apidata="seq=";
	$seq="";
}
else
{
	$apidata="seq=".$_GET["seq"];
	$seq=$_GET["seq"];
}
?>

<input type="hidden" name="apiCode" class="reqdata" value="policydelete">
<input type="hidden" name="poSeq" class="reqdata" value="<?=$_GET["seq"]?>">
<input type="hidden" name="returnData" class="reqdata" value="<?=$root?>/Skin/Setting/Policy.php">

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
				<th><span class="nec">타입</span></th>
				<td id="inPolicyDiv"></td>
			</tr>
			<tr>
				<th><span class="nec">제목</span></th>
				<td><input type="text" name="poTitle" class="w50p reqdata necdata" title="제목" value="" /></td>
			</tr>
			<tr>
				<th><span class="nec">내용</span></th>
				<td>
 					<textarea name="poContents" id="editor" class="reqdata necdata" title="내용"></textarea>
				</td>
			</tr>
		</tbody>
	</table>

	<div class="btn-box c" id="btnDiv"></div>
</div>

<!--// page end -->
<script>
	var poContentsEditor;


	ClassicEditor 

    .create( document.querySelector('#editor' ) ) 

    .then( editor => { 
		poContentsEditor=editor;
        console.log( editor ); 		
		//console.log("editorData = " + editorData);


    } ) 

    .catch( error => { 

        console.error( error ); 

    } );



	function policyupdate()
	{
		var editorData = poContentsEditor.getData();
		//console.log("editorData = " + editorData);
		$("#editor").text(editorData);

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
			callapi("POST","setting","policyupdate",jsondata);
		}
	}
	function makepage(json)
	{
		var obj = JSON.parse(json);
		console.log(obj)
		if(obj["apiCode"]=="policydesc") 
		{
			$("input[name=poSeq]").val(obj["poSeq"]);

			//약관종류
			$("#inPolicyDiv").html("");
			var txt="<select class='reqdata resetcode w20p' name='poType' id='poType'>";
			$.each(obj["inPolicyList"], function(idx, val){
				var code=val["cdCode"];
				var title=val["cdName"];
				txt+='<option value="'+code+'">'+title+'</option>';
			});
			txt+="</select>";
			$("#inPolicyDiv").html(txt);

			$("#btnDiv").html("");
			var btnHtml='';
			var seqdata = "seq="+obj["poSeq"];
			btnHtml='<a href="javascript:;" onclick="policyupdate();" class="bdp-btn"><span><?=$txtdt["1441"]?></span></a> ';//저장하기
			btnHtml+='<a href="javascript:;" onclick="golistload();" class="bw-btn"><span><?=$txtdt["1087"]?></span></a> ';//목록
			btnHtml+='<a href="javascript:;" onclick="callapidel(\'setting\',\'policydelete\',\''+seqdata+'\')" class="bdp-btn"><span><?=$txtdt["1154"]?></span></a>';//삭제하기

			$("#btnDiv").html(btnHtml);
			
		}
	}

	callapi('GET','setting','policydesc','<?=$apidata?>'); 	//약재출고등록 상세 API 호출
</script>