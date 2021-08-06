<?php
$root = "../..";
include_once ($root.'/_common.php');
//$upload=$root."/_module/upload";
//include_once $upload."/upload.lib.php";
if($_GET["seq"]=="add"){
	$apidata="seq=";
	$seq="";
}else{
	$apidata="seq=".$_GET["seq"];
	$seq=$_GET["seq"];
}
?>

<input type="hidden" name="seq" class="reqdata" value="<?=$_GET["seq"]?>">
<input type="hidden" name="returnData" class="reqdata" value="<?=$root?>/Skin/Board/Board.php">
<!-- 팝업이미지 -->
<!-- <script  type="text/javascript" src="<?=$root?>/cmmJs/jquery/jquery.form.min.js"></script>
<link rel="stylesheet" media="all" href="<?=$upload?>/upload.css?v=<?php echo time();?>" /> -->
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
	.NYchk-list  li {position:relative; width:10%;float:left;}


</style>

<!-- <script  type="text/javascript" src="<?=$upload?>/upload.js?v=<?=time()?>"></script> -->

<style>
	.bbtype-list {overflow:hidden;}
	.bbtype-list li {position:relative; width:8%;float:left; }
</style>

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
	<?php if($_GET["bb_type"]=="QNA"){?>
			<tr>
				<th><span class="">문의유형<?//=$txtdt["1062"]?><!-- 독/중독 --></span></th>
				<td colspan="3"><ul id="bbTypeDiv"></ul></td>
			</tr>
	<?php }?>
			<tr>
				<th><span>제목<?//=$txtdt["1951"]?><!-- 제목 --></span></th>
				<td colspan="3"><input type="text" name="bbTitle" class="w60p reqdata necdata" title="제목"/></td>
			</tr>

	<?php if($_GET["bb_type"]=="QNA"){?>
			<tr>
				<th><span><?=$txtdt["1047"]?><!-- 내용 --></span></th>
				<td colspan="3"><textarea name="bbDesc" class="text-area reqdata necdata" title="<?=$txtdt["1047"]?>" readonly/></textarea></td>
			</tr>
			<tr>
				<th><span>답변<?//=$txtdt["1047"]?><!-- 내용 --></span></th>
				<td colspan="3"><textarea name="bbAnswer" class="text-area reqdata necdata" title="<?=$txtdt["1047"]?>"/></textarea></td>
			</tr>
	<?php }else{?>

			<?php if($_GET["bb_type"]=="NOTICE" || $_GET["bb_type"]=="FAQ") { ?>
					<tr>
						<th><span><?=$txtdt["1047"]?><!-- 내용 --></span></th>
						<td colspan="3">
							<div id="editor"></div>
							<script type="text/javascript">
								CKEDITOR.replace('editor');//textarea의 id명을 이용해서 ckeditor를 적용한다.
							</script>
						</td>
					</tr>
			<?php }else { ?>
					<tr>
						<th><span><?=$txtdt["1047"]?><!-- 내용 --></span></th>
						<td colspan="3"><textarea name="bbDesc" class="text-area reqdata necdata" title="<?=$txtdt["1047"]?>"/></textarea></td>
					</tr>
			<?php } ?>

	<?php }?>

	<?php if($_GET["bb_type"]=="NOTICE" || $_GET["bb_type"]=="FAQ") { ?>
			<tr>
				<th><span>공개여부</span></th>
				<td  colspan="3">
					<ul id="NYchkDiv">		
				</td>
			</tr>
<?php } ?>
		</tbody>
	</table>

    <div class="btn-box c">			
		<a href="javascript:board_update();" class="bdp-btn"><span><?=$txtdt["1070"]?><!-- 등록/수정 --></span></a>
		<a href="javascript:viewlist();" class="bw-btn"><span><?=$txtdt["1087"]?><!-- 목록 --></span></a>
		<a href="javascript:board_del();" class="bdp-btn"><span><?=$txtdt["1154"]?><!-- 삭제 --></span></a>
    </div>
</div>

<script>
function submitaftersetdata() {
		this.updateElement();
	}
	function board_update()//등록&수정
	{
		var bb_type='<?=$_GET["bb_type"]?>';

		if(bb_type=="NOTICE" ||bb_type=="FAQ")
		{
			var editorData=CKEDITOR.instances.editor.getData();
			console.log("editorData = " + editorData);
			if(isEmpty(editorData))
			{
				alert("내용을 입력해 주세요.");
				return;
			}
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

			if(bb_type=="NOTICE" || bb_type=="FAQ")
			{
				jsondata["bbDesc"] = editorData;
			}



			console.log(JSON.stringify(jsondata));
			callapi("POST","board","boardupdate",jsondata); 
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
		var bb_type='<?=$_GET["bb_type"]?>';
		var obj = JSON.parse(json);
		console.log(obj);
		if(obj["apiCode"]=="boarddesc") //
		{	
			console.log("bbUse = " + obj["bbUse"]);

			$("input[name=bbTitle]").val(obj["bbTitle"]); 
			$("textarea[name=bbAnswer]").text(obj["bbAnswer"]); 

			$("input[name=bbTop]").val(obj["bbTop"]); 
			$("input[name=bbLeft]").val(obj["bbLeft"]); 
			$("input[name=bbWidth]").val(obj["bbWidth"]); 
			$("input[name=bbHeight]").val(obj["bbHeight"]); 

			$("input[name=bbFileSeq]").val(obj["afSeq"]); 

			$("input[name=bbLink]").val(obj["bbLink"]); 


			CodeRadio("linktypeDiv", obj["linktypeList"], "<?=$txtdt['1956']?>", "linktype", "linktype-list", obj["Linktype"],"");//게시판 링크유형 리스트

			CodeRadio("bbTypeDiv", obj["bbtypeList"], "<?=$txtdt['1115']?>", "bbtype", "bbtype-list", obj["bbType"],"readonly");//별전 리스트


			if(!isEmpty(bb_type)&&bb_type=="NOTICE" ||!isEmpty(bb_type)&&bb_type=="FAQ")
			{
				parseradiocodes("NYchkDiv", obj["bbUseList"], "공개여부", "NYchk", "NYchk-list", obj["bbUse"],"");//게시판 사용여부
				CKEDITOR.instances.editor.setData(obj["bbDesc"],function(){CKEDITOR.instances.editor.setData(obj["bbDesc"]);});
			}
			else
			{				
				$("textarea[name=bbDesc]").text(obj["bbDesc"]); 
			}
	   }
	}
   callapi('GET','board','boarddesc','<?=$apidata?>'); //약재 상세 API 호출 & 옵션 호출

</script>
