<?php
	$root="..";
	include_once $root."/_Inc/head.php";
?>
<div id="listdiv"></div>

<script>
	function getlist()
	{
		callapi("GET","/medical/member/",getdata("memberdocxlist")+"&mdType=COMMENT"); 
		callapi("GET","/medical/member/",getdata("memberdocxlist")+"&mdType=ADVICE"); 
	}

	//해시값이 바뀌면 
	window.onhashchange = function(e) {
		viewpage();
	}
	
	viewpage();  //첫페이지

	function viewpage()
	{
		var hdata=location.hash.replace("#","").split("|");
		$("#listdiv").load("<?=$root?>/Skin/Member/Option.php", function(){getlist();});//복용지시 리스트 , 조제지시 리스트 		
	} 

</script>

<?php
   include_once $root."/_Inc/tail.php"; 
?>

<script>
	function goAdviceUpload()
	{
		var len=$("#advicetbl tr").length;

		if(len>=10)
		{
			alert("10개까지만 등록할수 있습니다.");
			return;
		}
		medicallayer('modal-option-dose','');
	}
	function goCommentUpload()
	{
		var len=$("#commenttbl tr").length;

		if(len>=10)
		{
			alert("10개까지만 등록할수 있습니다.");
			return;
		}
		medicallayer('modal-option-prepared-register','');
	}
	function commentdelete()
	{
		var mdSeq=$("input[name=mdSeq]").val();
		var mdTitle=$("#opTitle").text();
		console.log("mdSeq ="+mdSeq);

		if(confirm(mdTitle+'를 삭제하시겠습니까?'))
		{
			if(!isEmpty(mdSeq))
			{
				callapi("GET","/medical/member/",getdata("memberdocxdelete"));  
			}
		}
	}
	function commentreupdate()
	{
		var mdSeq=$("input[name=mdSeq]").val();
		console.log("mdSeq ="+mdSeq);
		medicallayer('modal-option-prepared-modify',mdSeq);
	}
	function commentupdate()
	{

		var mdTitle=encodeURI($("input[name=mdTitle]").val());
		var mdContents=encodeURI($("textarea[name=mdContents]").val());
		var medicalId=$("input[name=medicalId]").val();
		var doctorId=$("input[name=doctorId]").val();
		$("input[name=mdType]").val("COMMENT");
		var mdSeq=$("input[name=mdSeq]").val();
		console.log("mdSeq ="+mdSeq);

		console.log("mdTitle:"+mdTitle+", mdContents:"+mdContents+", medicalId:"+medicalId+", doctorId:"+doctorId);

		if(isEmpty(mdTitle))
		{
			alert("제목을 입력해 주세요.");
			return;
		}
		if(isEmpty(mdContents))
		{
			alert("내용을 입력해 주세요.");
			return;
		}

		callapi("POST","/medical/member/",getdata("memberdocxupdate"));
	}
	function advicedelete()
	{
		var mdSeq=$("input[name=mdSeq]").val();
		var mdTitle=$("#adTitle").text();
		console.log("mdSeq ="+mdSeq);

		if(confirm(mdTitle+'를 삭제하시겠습니까?'))
		{
			if(!isEmpty(mdSeq))
			{
				callapi("GET","/medical/member/",getdata("memberdocxdelete"));  
			}
		}
	}
	function adviceupdate()
	{
		var mdTitle=encodeURI($("input[name=mdTitle]").val());
		var mdFileIdx=encodeURI($("input[name=mdFileIdx]").val());
		var medicalId=$("input[name=medicalId]").val();
		var doctorId=$("input[name=doctorId]").val();
		$("input[name=mdType]").val("ADVICE");
		var mdSeq=$("input[name=mdSeq]").val();
		console.log("mdSeq ="+mdSeq);

		console.log("mdTitle:"+mdTitle+", mdFileIdx:"+mdFileIdx+", medicalId:"+medicalId+", doctorId:"+doctorId);

		if(isEmpty(mdTitle))
		{
			alert("제목을 입력해 주세요.");
			return;
		}
		if(isEmpty(mdFileIdx))
		{
			alert("파일을 첨부해 주세요.");
			return;
		}

		callapi("POST","/medical/member/",getdata("memberdocxupdate"));
	}
   	function makepage(result)
	{		
		var obj = JSON.parse(result);
		console.log(obj);
		console.log("apiCode>>>>> "+obj["apiCode"]);

		if(obj["apiCode"]=="memberdocxlist")
		{
			var data="";
			console.log("memberdocxlist");
			console.log(obj["clist"]);

			if(!isEmpty(obj["mdType"]&&obj["mdType"]=="COMMENT"))
			{
				//조제지시 
				$("#commnettbl tbody").html("");
				if(!isEmpty(obj["clist"]))
				{
					$(obj["clist"]).each(function( index, value )
					{
						console.log("value:title==>"+value["mdTitle"]);
						data+="<tr>";
						data+="	<td class='td-txtLeft'>";
						data+="		<a href=javascript:medicallayer('modal-option-prepared','"+value["mdSeq"]+"');>";
						data+=value['mdTitle'];
						data+="		</a>";
						data+="	</td>";
						data+="</tr>";
					});
				}
				else
				{
					data+="<tr>";
					data+="	<td></td>";
					data+="</tr>";
				}

				console.log("data="+data);

				$("#commenttbl tbody").html(data);
			}
			if(!isEmpty(obj["mdType"]&&obj["mdType"]=="ADVICE"))
			{
				//복용지시  
				$("#advicetbl tbody").html("");
				if(!isEmpty(obj["clist"]))
				{
					$(obj["clist"]).each(function( index, value )
					{
						data+="<tr>";
						data+="	<td class='td-txtLeft'>";
						data+="		<a href='javascript:;'>";
						data+="			<div class='td-inner d-flex'>";
						data+=value['mdTitle'];
						data+="				<a class='attached-file has-file' href=javascript:medicallayer('modal-option-dose-download','"+value["mdSeq"]+"') ></a>";
						data+="			</div>";
						data+="		</a>";
						data+="	</td>";
						data+="</tr>";
					});
				}
				else
				{
					data+="<tr>";
					data+="	<td></td>";
					data+="</tr>";
				}

				console.log("data="+data);

				$("#advicetbl tbody").html(data);
			}


			
		}
		else if(obj["apiCode"]=="memberdocxupdate")
		{
			if(!isEmpty(obj["mdSeq"]))
			{
				alert("수정하였습니다.");
				moremove('modal-option-prepared-modify');
			}
			else
			{
				alert("등록하였습니다.");
				moremove('modal-option-prepared-register');
				moremove('modal-option-dose');
			}
			
			getlist();
		}
		else if(obj["apiCode"]=="memberdocxdesc")
		{
			$("input[name=mdSeq]").val(obj["mdSeq"]);
			if(obj["mdType"]=="COMMENT")//조제지시 
			{
				$("#opTitle").text(obj["mdTitle"]);
				$("#opContens").text(obj["mdContents"]);
				$("input[name=mdTitle]").val(obj["mdTitle"]);
				$("textarea[name=mdContents]").text(obj["mdContents"]);
			}
			else
			{
				$("#adTitle").text(obj["mdTitle"]);
				$("#adFileName").text(obj["afName"]);
				$("#adFile").attr('href','/_module/download/fileDown.php?filename='+encodeURI(obj["afName"])+'&imgurl='+encodeURI(getUrlData("FILE_DOMAIN")+obj["afUrl"])+"&imgsize="+obj["afSize"]);
			}
		}
		else if(obj["apiCode"]=="memberdocxdelete")
		{
			alert("삭제하였습니다.");
			moremove('modal-option-prepared');
			moremove('modal-option-dose-download');
			getlist();
		}
	}
</script>