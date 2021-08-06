<?php //스탭관리
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
<input type="hidden" name="returnData" class="reqdata" value="<?=$root?>/Skin/Member/StaffList.php">
<input type="hidden" name="seq" class="reqdata" value="<?=$_GET["seq"]?>">

<!-- 스텝이미지 -->
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
</style>

<script  type="text/javascript" src="<?=$upload?>/upload.js?v=<?=time()?>"></script>

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
				<th><span class="nec"><?=$txtdt["1193"]?><!-- 아이디 --></span></th>
				<td>
					<input type="text" name="stUserId" class="reqdata necdata" title="<?=$txtdt["1193"]?>" onblur="loginid_check()" onfocus="this.select();" onchange="changeID(event, false);" />
					<span id="idDiv"></span>
					<span class="info-ex02 mg5" id="idchktxt"><?=$txtdt["1012"]?><!-- 6~20자의 영문,숫자 혼합 --></span>
				<?php if($_GET["seq"]){?>
					<input type="hidden" id="idchk" name="idchk" value="1">
				<?php }else{?>
					<input type="hidden" id="idchk" name="idchk" value="0">
				<?php }?>
					<div class="checkStaffId"><span class="stxt" id="idsame" style="color:red;"></span></div><!--아이디중복여부표시-->
				</td>
				<th rowspan="3"><span><?=$txtdt["1248"]?><!-- 이미지첨부 --></span></th>
				<td rowspan="3" style="vertical-align:top;">
					<dl class="multiimg">
						<dd><p>대표이미지</p>
						<span id="staff"></span>
						<span id="img_staff">
							<button type="button" class="sp-btn" onclick="uploadbtn('staff');">이미지 첨부</button>
						</span>
						</dd>
						<dd>
							<p>싸인이미지</p>
							<span id="signature"></span>
							<span id="img_signature">
								<button type="button" class="sp-btn" onclick="uploadbtn('signature');">이미지 첨부</button>		
							</span>
						</dd>
					</dl>
					
				</td>
			</tr>
			<tr>
				<th><span class="nec"><?=$txtdt["1244"]?><!-- 이름 --></span></th>
				<td><input type="text" name="stName" class="reqdata necdata" title="<?=$txtdt["1244"]?>" value=""/></td>
			</tr>
			<tr>
				<th><span class="nec"><?=$txtdt["1150"]?><!-- 사원코드 --></span></th>
				<td>
					<input type="text" name="stStaffId" class="reqdata" title="<?=$txtdt["1150"]?>" value="" readonly/>
					<span id="staffDiv"></span>
				</td>
			</tr>
			<tr>
				<th><span class="nec"><?=$txtdt["1140"]?><!-- 비밀번호 --></span></th>
			<?php if($_GET["seq"]!="" && $_GET["seq"]!="add"){//스텝 등록일때는 비밀번호가 필수?>
   				<td><input type="password" name="stPasswd" class="reqdata" title="<?=$txtdt["1140"]?>"/></td>
			<?php }else{?>
   				<td><input type="password" name="stPasswd" class="reqdata necdata" title="<?=$txtdt["1140"]?>"/></td>
			<?php }?>
				<th><span class="nec"><?=$txtdt["1141"]?><!-- 비밀번호확인 --></span></th>
				<td><input type="password" name="stPasswd2" class="reqdata " />
					<div class='checkPasswd'><span class='stxt' id='idsame' style='color:red;'></span></div>
				</td>
			</tr>
			<tr>
				<th><span class="nec"><?=$txtdt["1415"]?><!-- 회원그룹 --></span></th>
				<td colspan="3"><div class="stAuth-list"  id="stAuthDiv"></div></td>
			</tr>
			<tr>
				<th><span class="nec"><?=$txtdt["1177"]?><!-- 소속 --></span></th>
				<td colspan="3"><div class="stDepart-list"  id="stDepartDiv"></div></td>
			</tr>
			<tr>
				<th><span><?=$txtdt["1416"]?><!-- 회원상태 --></span></th>
				<td colspan="3"><div class="medi-list"  id="staffStatusDiv"></div></td>
			</tr>
			<tr>
				<th><span><?=$txtdt["1307"]?><!-- 주소 --></span></th>
				<td colspan="3">
					<input type="text" name="stZipCode" class="reqdata" title="<?=$txtdt["1233"]?>" readonly/>
					<a href="javascript:getzip('stZipCode','stAddress');" class="cw-btn"><span><?=$txtdt["1232"]?></span></a>
					<p class="mg5t"></p>
					<input type="text" name="stAddress" class="reqdata w40p" title="<?=$txtdt["1308"]?>" readonly/>
					<input type="text" name="stAddress1" class="reqdata w40p" title="<?=$txtdt["1308"]?>"/>
				</td>
			</tr>
			<tr>
				<th><span class=""><?=$txtdt["1286"]?><!-- 전화번호 --></span></th>
				<td colspan="3">
					<input type="text" title="<?=$txtdt["1286"]?>" class="reqdata" name="stPhone0" maxlength="4" onfocus="this.select();" onchange="changePhoneNumber(event);"/> -
					<input type="text" title="<?=$txtdt["1286"]?>" class="reqdata" name="stPhone1" maxlength="4" onfocus="this.select();" onchange="changePhoneNumber(event);"/> -
					<input type="text" title="<?=$txtdt["1286"]?>" class="reqdata" name="stPhone2" maxlength="4" onfocus="this.select();" onchange="changePhoneNumber(event);"/>
				</td>
			</tr>
			<tr>
				<th><span><?=$txtdt["1422"]?><!-- 휴대폰번호 --></span></th>
				<td colspan="3">
					<input type="text" title="<?=$txtdt["1422"]?>" class="reqdata" name="stMobile0" maxlength="4" onfocus="this.select();" onchange="changePhoneNumber(event);"/> -
					<input type="text" title="<?=$txtdt["1422"]?>" class="reqdata" name="stMobile1" maxlength="4" onfocus="this.select();" onchange="changePhoneNumber(event);"/> -
					<input type="text" title="<?=$txtdt["1422"]?>" class="reqdata" name="stMobile2" maxlength="4" onfocus="this.select();" onchange="changePhoneNumber(event);"/>
				</td>
			</tr>
			<tr>
				<th><span><?=$txtdt["1246"]?><!-- 이메일 --></span></th>
				<td colspan="3">
					<input type="text" title="<?=$txtdt["1246"]?>" class="reqdata" name="stEmail0" id="stEmail0" onfocus="this.select();" onchange="changeID(event, false);"/> @
					<input type="text" title="<?=$txtdt["1246"]?>" class="reqdata" name="stEmail1" id="stEmail1" onfocus="this.select();" onchange="changeID(event, false);"/>
				</td>
			</tr>

		</tbody>
	</table>
	<div class="gap"></div>

<!-- 한의원관리처럼 일단 주석 처리  -->
	<!-- <h3 class="u-tit02"><?=$txtdt["1041"]?><!-- 기타메모 --></h3>
	<!-- <span class="bd-line"></span>
	<table class="thetbl">
		<caption><span class="blind"></span></caption>
		<colgroup>
			<col width="180">
			<col width="*">
		</colgroup>
		<tbody>
			<tr>
				<th><span><?=$txtdt["1029"]?><!-- 관리자메모 --></span></th>
				<!-- <td colspan="3"><textarea class="text-area reqdata" name="stMemo"></textarea></td>
			</tr>
		</tbody>
	</table> -->

	<div class="btn-box c">
		<a href="javascript:staff_update();" class="bdp-btn"><span><?=$txtdt["1070"]?><!-- 등록/수정 --></span></a>
        <a href="javascript:viewlist();" class="bw-btn"><span><?=$txtdt["1087"]?><!-- 목록 --></span></a>
        <a href="javascript:staff_del();" class="bdp-btn"><span><?=$txtdt["1154"]?><!-- 삭제 --></span></a>
	</div>
</div>

<!--// page end -->
<script>
	//영문 혼합 체크와 아이디 중복확인
	function loginid_check()
	{
		$(".checkStaffId").html('');
		$("input[name=idchk]").val(0);
		var id=$("input[name=stUserId]").val();
		var idReg = /^[A-za-z0-9]{6,20}/g;
		if(!isEmpty(id))
		{
			if(!idReg.test(id) && $("input[name=stUserId]").val())
			{
				alert('<?=$txtdt["1477"]?>'); //아이디는 영문자로 시작하는 6~20자 영문자 또는 숫자이어야 합니다
				return false;
			}
			else
			{
				var apidata = "stUserId="+id;
				callapi('GET','member','staffidchk',apidata);
				return false;
			}
		}
	}

	function staff_update()//스탭등록
	{
		//비밀번호 일치 하는지
		var pwd1 = $("input[name=stPasswd]").val();
		var pwd2 = $("input[name=stPasswd2]").val();

		if(pwd1 == pwd2)
		{
			if($("input[name=idchk]").val()==1) //중복확인이 1이어야 등록가능
			{
				if(necdata()=="Y") //필수값체크
				{
					//Staff 회원가입 API
					var key=data="";
					var jsondata={};

					//radio data
					$(".radiodata").each(function()
					{
						key=$(this).attr("name");
						data=$(":input:radio[name="+key+"]:checked").val();
						jsondata[key] = data;
					});

					$(".reqdata").each(function()
					{
						key=$(this).attr("name");
						data=$(this).val();
						jsondata[key] = data;
					});
					console.log(jsondata);
					callapi("POST","member","staffupdate",jsondata); //스텝 등록&수정
				}
			}
			else
			{
				if(!$("input[name=stUserId]").val())
				{
					alert('<?=$txtdt["1196"]?>');//아이디를 입력해주세요.
					$("input[name=stUserId]").focus();
					return false;
				}
				else
				{
					alert('<?=$txtdt["1650"]?>');//사용할수 없는 아이디입니다
					$("input[name=stUserId]").focus();
					return false;
				}
			}
		}
		else
		{
			alert('<?=$txtdt["1530"]?>'); //비밀번호가 서로 맞지 않습니다
			$("input[name=stPasswd]").focus();
			return false;
		}
	}

	function staff_del() //스텝 삭제
	{
		var data = "seq="+$("input[name=seq]").val();
		var url = encodeURI($("input[name=returnData]").val());
		$("input[name=returnData]").val(url);
		callapidel('member','staffdelete',data);
		return false;
	}

	function makepage(json)
	{
		var obj = JSON.parse(json);
		console.log(obj);
		if(obj["apiCode"]=="staffdesc")
		{
			$("input[name=stUserId]").val(obj["stUserId"]); //아이디
			$("input[name=stName]").val(obj["stName"]); //이름
			$("input[name=stStaffId]").val(obj["stStaffId"]); //사원코드
			$("input[name=stPasswd]").val(obj["stPasswd"]); //비밀번호
			$("input[name=stPasswd2]").val(obj["stPasswd2"]); //비밀번호 확인
			$("input[name=stZipCode]").val(obj["stZipCode"]); //우편번호

			$("input[name=stAddress]").val(obj["stAddress"]); //주소1
			$("input[name=stAddress1]").val(obj["stAddress1"]); //주소2

			$("input[name=stPhone0]").val(obj["stPhone0"]); //전화번호
			$("input[name=stPhone1]").val(obj["stPhone1"]); //전화번호
			$("input[name=stPhone2]").val(obj["stPhone2"]); //전화번호

			$("input[name=stMobile0]").val(obj["stMobile0"]); //휴대전화번호
			$("input[name=stMobile1]").val(obj["stMobile1"]); //휴대전화번호
			$("input[name=stMobile2]").val(obj["stMobile2"]); //휴대전화번호

			$("input[name=stEmail0]").val(obj["stEmail0"]); //이메일주소
			$("input[name=stEmail1]").val(obj["stEmail1"]); //이메일주소
			//$("textarea[name=stMemo]").text(obj["stMemo"]); //메모

			CodeRadio("staffStatusDiv", obj["meStatusList"], '<?=$txtdt["1416"]?>', "stStatus","meStatus-list", obj["stStatus"]);//회원상태 리스트
			CodeRadio("stAuthDiv", obj["stAuthList"], '<?=$txtdt["1415"]?>', "stAuth","stAuth-list", obj["stAuth"]);//회원그룹 리스트
			CodeRadio("stDepartDiv", obj["stDepartList"], '<?=$txtdt["1177"]?>', "stDepart","stDepart-list", obj["stDepart"]);//소속 리스트

			if(!isEmpty(obj["seq"])) // seq 있을때 스태프 바코드  출력
			{
				var staffHtml = '';
				staffHtml='<a href="javascript:;" onclick="printbarcode(\'label\',\'staff_code'+'|'+obj["seq"]+'\',500)" ><button class="sp-btn"><span>+ <?=$txtdt["1098"]?><!-- 바코드출력 --></span></button></a>';//<!-- 바코드출력 -->
				$("#staffDiv").html(staffHtml);

				var idHtml = '';  // seq 있을때 ID 바코드  출력
				idHtml='<a href="javascript:;" onclick="printbarcode(\'label\',\'staff_id'+'|'+obj["seq"]+'\',500)" ><button class="sp-btn"><span>+ <?=$txtdt["1098"]?><!-- 바코드출력 --></span></button></a>';//<!-- 바코드출력 -->
				//$("#idDiv").html(idHtml);
			}
			if(!isEmpty(obj["files"]))
			{
				//이미지 보여주기
				if(!isEmpty(obj["files"]["staff"]))
				{
					imgShow("img_staff", "staff", obj["files"]);
				}

				//이미지 보여주기
				if(!isEmpty(obj["files"]["signature"]))
				{
					imgShow("img_signature", "signature", obj["files"]);
				}
			}
		}		
		else if (obj["apiCode"]=="staffidchk")
		{
			if(obj["resultCode"] == "200")
			{
				$(".checkStaffId").html('<span class="stxt" id="idsame" style="color:red;"> <?=$txtdt["1524"]?></span>'); //중복아이디
				$("#idchk").val(0);
			}
			else
			{
				$(".checkStaffId").html('<span class="stxt" id="idsame" style="color:blue;"> <?=$txtdt["1476"]?></span>'); //사용 가능합니다
				$("#idchk").val(1);
			}
			return false;
		}				
	}
	callapi('GET','member','staffdesc','<?=$apidata?>'); //스텝 상세내용 api 호출

	//비밀번호 확인
	// function passwordCheck()
	// {
	// 	var pwd1 = $("input[name=stPasswd]").val();
	// 	var pwd2 = $("input[name=stPasswd2]").val();
	// 	if(pwd1 == pwd2)
	// 	{
	// 		$(".checkPasswd").html('<span class="stxt" id="idsame" style="color:blue;"><?=$txtdt["1654"]?></span>');
	// 	}
	// 	else
	// 	{
	// 		$(".checkPasswd").html('<span class="stxt" id="idsame" style="color:red;"><?=$txtdt["1530"]?></span>');
	// 	}
	// }

	//전화번호 하이픈 자동입력
	//num : 입력받은 값
	//type(0) : 중간전화번호 **** 표시 하기위함
	// function phoneFomatter(num,type)
	// {
	// 	var formatNum = '';
	//
	// 	if(num.length==11)//010 1234 2345
	// 	{
	// 		if(type==0)
	// 		{
	// 			formatNum = num.replace(/(\d{3})(\d{4})(\d{4})/, '$1-****-$3');
	// 		}
	// 		else
	// 		{
	// 			formatNum = num.replace(/(\d{3})(\d{4})(\d{4})/, '$1-$2-$3');
	// 		}
	// 	}
	// 	else if(num.length==8)//1588-7577
	// 	{
	// 		formatNum = num.replace(/(\d{4})(\d{4})/, '$1-$2');
	// 	}
	// 	else
	// 	{
	// 		if(num.indexOf('02')==0)//02-3455-6778
	// 		{
	// 			if(type==0)
	// 			{
	// 				formatNum = num.replace(/(\d{2})(\d{4})(\d{4})/, '$1-****-$3');
	// 			}
	// 			else
	// 			{
	// 				formatNum = num.replace(/(\d{2})(\d{4})(\d{4})/, '$1-$2-$3');
	// 			}
	// 		}
	// 		else
	// 		{
	// 			if(type==0)
	// 			{
	// 				formatNum = num.replace(/(\d{3})(\d{3})(\d{4})/, '$1-***-$3');
	// 			}
	// 			else
	// 			{
	// 				formatNum = num.replace(/(\d{3})(\d{3})(\d{4})/, '$1-$2-$3');
	// 			}
	// 		}
	// 	}
	// 	return formatNum;
	// }

	var seq = $("input[name=seq]").val();
	if(seq=='add')
	{//신규입력일때만 아이디란에 포커스
		$("input[name=stUserId]").focus();
	}	

	function uploadbtn(type)
	{
		var id=$("input[name=stStaffId]").val();
		useupload(type,id,"1");
	}

	function imgShow(div,fcode,obj)
	{
		//console.log(JSON.stringify(obj));
		var data="	<a href=\"javascript:void(0);\" >"
			data+=" <div class='viewimg' onclick=\"Imagedel('"+obj[fcode]["afseq"]+"' ,'"+fcode+"')\" id=\"img_id_"+fcode+"\" data-seq='"+obj[fcode]["afseq"]+"'>";
			data+=" <img src='"+getUrlData("FILE_DOMAIN")+obj[fcode]["afUrl"]+"'> ";
			data+="</div></a>";
		$("#"+div).append(data); 
	}

	function uploadImg()
	{
		$("#input_imgs").click();	
	}

	function useupload(fcode,staffid, seq)
	{
		$("#frm").remove();
		var	txt='<form id="frm"  method="post" enctype="multipart/form-data" action=javascript:upload(\"'+fcode+'\");>';
				txt+='	<span class="fileNone">';
				txt+='		<input type="file" name="uploadFile" id="input_imgs" onchange="fileup()" />';
				txt+='		<input type="text" name="filecode" id="filecode" value="staff|'+fcode+'|'+seq+'">';
				txt+='		<input type="text" name="fileck" id="fileck" value="'+staffid+'|kor">';
				txt+='		<input type="text" name="fileapiurl" id="fileapiurl" value="url">';
				txt+='	</span>';		
				txt+='</form>';
		$("#"+fcode).html(txt);
		uploadImg();	
	}

	function upload(fcode){
		console.log("fcode    >>>  "+fcode);
		
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
				console.log(obj);
				//handleImgFileSelect(obj["data"]);
				//console.log("이미지를 보여주는 함수 호출 할 부분");  
				//imgShow("img1", "staff", obj["files"]);
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
		//location.reload();
    }

	//이미지 삭제 
	function Imagedel(seq,fcode) 
	{
		console.log("seq   >>>   "+seq);
		console.log("fcode   >>>   "+fcode);
		if(confirm("삭제하시겠습니까?"))
		{
			//fildelete api 호출 
			var data = "seq="+seq;
			console.log("data : "+data);
			$("#img_id_"+fcode).remove(); 
			callapiupload('GET','file','filedelete',data);
		}
	}

</script>
