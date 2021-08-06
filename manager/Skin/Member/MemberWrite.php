<?php //한의원관리
$root = "../..";
include_once ($root.'/_common.php');
$apidata="userid=".$_GET["userid"];
//echo $apidata;

$upload=$root."/_module/upload";
include_once $upload."/upload.lib.php";
?>
<style>
	td.thumb img{max-width:30%;max-height:50px;}
	.whCodeLeft {width:210px;float:left;margin-right:10px;}
	.whCodeRight {width:200px;float:left;}

	td.thumbp img {max-width:40%;max-height:70px;}
</style>

<!-- 이미지 -->
<script  type="text/javascript" src="<?=$root?>/cmmJs/jquery/jquery.form.min.js"></script>
<link rel="stylesheet" media="all" href="<?=$upload?>/upload.css?v=<?php echo time();?>" />
<script  type="text/javascript" src="<?=$upload?>/upload.js?v=<?=time()?>"></script>

<input type="hidden" name="pbseq" class="reqdata" value="">
<input type="hidden" name="pbMember" class="reqdata" value="">
<input type="hidden" name="miUserid" class="reqdata" value="">
<input type="hidden" name="seq" class="reqdata" value="">
<input type="hidden" name="returnData" class="reqdata" value="<?=$root?>/Skin/Member/MemberList.php">

<div id="noShow">
	<textarea name="selstat" id="meGradeDiv" rows="10" cols="70%" ></textarea>
</div>

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
  				<th><span class="nec"><?=$txtdt["1408"]?><!-- 한의원이름 --></span></th>
  				<td colspan="3"><input type="text" name="miName" class="reqdata w50p necdata textbold" title="<?=$txtdt["1408"]?>" /></td>
  				<!-- <th><span><?=$txtdt["1143"]?><!-- 사업자등록번호 --></span></th>
  				<!-- <td><input type="text" name="miBusinessNo" class="reqdata" title="<?=$txtdt["1143"]?>"/></td> --> 
  			</tr>
  			<tr>
  				<th><span class="nec"><?=$txtdt["1307"]?><!-- 주소 --></span></th>
  				<td colspan="3">
  					<input type="text" name="miZipcode" class="reqdata necdata" title="<?=$txtdt["1233"]?>" readonly/>
  					<a href="javascript:getzip('miZipcode','miAddress');" class="cw-btn"><span><?=$txtdt["1232"]?></span></a>
  					<p class="mg5t"></p>
					<input type="text" name="miAddress" class="reqdata w40p necdata" title="<?=$txtdt["1308"]?>" readonly/>
					<input type="text" name="miAddress1" class="reqdata w40p necdata" title="<?=$txtdt["1308"]?>"/>
  				</td>
  			</tr>
  			<tr>
  				<th><span class="nec"><?=$txtdt["1286"]?><!-- 전화번호 --></span></th>
  				<td>
  					<input type="text" title="<?=$txtdt["1286"]?>" name="miPhone0"  id="miPhone0" class="w10p reqdata necdata" maxlength="4" onfocus="this.select();" onchange="changePhoneNumber(event);"/> -
					<input type="text" title="<?=$txtdt["1286"]?>" name="miPhone1"  id="miPhone1" class="w10p reqdata necdata" maxlength="4" onfocus="this.select();" onchange="changePhoneNumber(event);"/> -
					<input type="text" title="<?=$txtdt["1286"]?>" name="miPhone2"  id="miPhone2" class="w10p reqdata necdata" maxlength="4" onfocus="this.select();" onchange="changePhoneNumber(event);"/>
  				</td>
  				<th><span class=""><?=$txtdt["1891"]?><!-- 한의원등급 --></span></th>
  				<td><div id="miGradeDiv"></div></td>
  				<!-- <th><span><?=$txtdt["1385"]?><!-- 팩스번호 --></span></th> 
  				<!-- <td >
  					<input type="text" title="<?=$txtdt["1385"]?>" name="miFax0"  id="miFax0"  class="w10p reqdata" maxlength="4" onfocus="this.select();" onchange="changePhoneNumber(event);"/> -
					<input type="text" title="<?=$txtdt["1385"]?>" name="miFax1"  id="miFax1"  class="w10p reqdata" maxlength="4" onfocus="this.select();" onchange="changePhoneNumber(event);"/> -
					<input type="text" title="<?=$txtdt["1385"]?>" name="miFax2"  id="miFax2"  class="w10p reqdata" maxlength="4" onfocus="this.select();" onchange="changePhoneNumber(event);"/>
  				</td> -->
  			</tr>
  			<tr>
  				<th><span><?=$txtdt["1416"]?><!-- 회원상태 --></span></th>
  				<td colspan="">
					<div class="medi-list"  id="meStatusDiv"></div>
  				</td>
  				<th><span class=""><?=$txtdt["1632"]?><!-- 배송회사 --></span></th>
  				<td><div id="miDeliveryDiv"></div></td>
  			</tr>
		  </tbody>
	</table>
		<div class="btn-box c">
		<?php if($modifyAuth == "true" || $modifyAuth == "admin"){?>
			<a href="javascript:medical_update();" class="bdp-btn"><span><?=$txtdt["1070"]?><!-- 등록/수정 --></span></a>
			<a href="javascript:viewlist();" class="bw-btn"><span><?=$txtdt["1087"]?><!-- 목록 --></span></a>
			<a href="javascript:medical_del();" class="bdp-btn"><span><?=$txtdt["1153"]?><!-- 삭제 --></span></a>

			<!-- <a href="javascript:medicalconfirm();" id="mdok" class="bpc-btn" style="display:none;"><span>정회원승인</span></a> -->
		<?php }else{?>
			<a href="javascript:viewlist();" class="bw-btn"><span><?=$txtdt["1087"]?><!-- 목록 --></span></a>	
		<?php }?>
		</div>
</div>

<?php
if($_GET["userid"])
{
?>
	<h3 class="u-tit02"><?=$txtdt["1178"]?><!-- 소속한의사 --></h3>
	<span class="bd-line"></span>
	<div class="addBtn">
	 	<a href="javascript:;" class="cw-btn">
			<span class="modinput_" onclick="modinput2('add_member','')">+ <?=$txtdt["1402"]?><!--한의사추가 --></span>
		</a>
	</div>
	<div class="board-list-wrap">
		<table class="thetbl memlist">
			<caption><span class="blind"></span></caption>
				<col width="19%">
				<col width="10%">
				<col width="15%">
				<col width="11%">
				<col width="11%">
				<col width="10%">
				<col width="10%">
				<col width="*">
			<thead>
				<tr>
					<th><?=$txtdt["1644"]?><!-- 회원구분 --></th>
					<th>의사PK</th> 
					<th><span class="nec"><?=$txtdt["1193"]?><!-- 아이디 --></span></th>
					<th><span class="nec"><?=$txtdt["1140"]?><!-- 비밀번호 --></span></th>
					<th><span class="nec"><?=$txtdt["1141"]?><!-- 비밀번호확인 --></span></th>
					<th><span class="nec"><?=$txtdt["1244"]?><!-- 이름 --></span></th>					
					<th><?=$txtdt["1072"]?><!-- 등록일 --></th>
					<th></th>
				</tr>
			</thead>
			<tbody class="memlisttext">
			</tbody>
		</table>
	</div>
<?php
}
?>
<div class="gap"></div>

<!--  포장재관리 -->
	<h3 class="u-tit02"><?=$txtdt["1393"]?><!-- 포장재관리 --></h3>
	<div id="packingDiv"></div>
	<span class="bd-line"></span>
	<div class="addBtn">
		<a href="javascript:;" class="cp-btn" >
			<span onclick="getCommonPaking()">+ 공통 포장재 가져오기</span>
		</a>
	 	<a href="javascript:;" class="cw-btn">
			<span class="modinput_" onclick="modinput2('add_packing','')">+ <?=$txtdt["1395"]?><!-- 포장재추가 --></span>
		</a>
	</div>
	<div class="board-list-wrap">
		<table class="packingtbl packlist">
			<caption><span class="blind"></span></caption>
				<col width="20%">
				<col width="20%">
				<col width="20%">
				<col width="20%">		
				<col width="*">
			<thead>
				<tr>
					<th><?=$txtdt["1247"]?><!-- 이미지 --></th>
					<th><?=$txtdt["1132"]?><!-- 분류 --></th>			
					<th><span class="nec"><?=$txtdt["1392"]?><!-- 포장재코드 --></span></th>
					<th><span class="nec"><?=$txtdt["1440"]?><!-- 1440 --></span></th>				
					<th><?=$txtdt["1072"]?><!-- 등록일 --></th>
				</tr>
			</thead>
			<tbody>
			</tbody>
			<div id="packlisttext"></div>
		</table>
	</div>
</div>

<div class="gap"></div>

	<!-- medical 테이블에 컬럼이 정해져있지 않아 일단 주석처리 하기로 함. 추후에 정하면 insert, update에 추가해야함  -->
	<!-- <h3 class="u-tit02"><?=$txtdt["1041"]?><!-- 기타메모 --></h3>
	<!-- <table class="memolist">
		<caption><span class="blind"></span></caption>
		<colgroup>
			<col width="180">
			<col width="*">
		</colgroup>
		<tbody>
			<tr>
				<th><span><?=$txtdt["1029"]?><!-- 관리자 메모 --></span></th>
				<!-- <td colspan="3"><textarea class="text-area"></textarea></td>
			</tr>
			<tr>
				<th><span><?=$txtdt["1227"]?><!-- 열람 사유 --></span></th>
				<!-- <td colspan="3"><textarea class="text-area"></textarea></td> -->
			<!-- </tr> -->
		<!-- </tbody> -->
	<!-- </table> -->

<script>
	//검색버튼을 눌렀을때 처리
	function pop_search()
	{
		var data = url = pagedata = "";
		pagedata = $("#comPageData").val();
		data = "page=1&psize=5&block=10"+getsearpopdata();

		url="<?=$root?>/99_LayerPop/layer-commpacking.php?"+data;

		viewlayer(url,860, 750,"");

		console.log("pop_search  ========================================>>>>>>>>>>>>>  url = " + url);
	}

    // +공통 포장재 가져오기 버튼 
	function getCommonPaking()
	{
		var miUserid=$("input[name=miUserid]").val();
		var url="/99_LayerPop/layer-commpacking.php?page=1&psize=7&block=10&medicalId="+miUserid;
		//console.log("getlayer   url = " + url);
		viewlayer(url,"860","750","");
	}

	//영문 혼합 체크와 아이디 중복확인
	function loginid_check()
	{
		$(".checkLoginId").html(''); //아이디 중복 체크후에 다시 입력하면 사용가능합니다, 중복아이디 라는 문구 삭제
		$("input[name=idchk]").val(0);
		var id=$("input[name=meLoginid]").val();
		//console.log("loginid_check*********"+id);
		
		if(isEmpty(id))//아이디가 없을 경우
		{
			$(".checkLoginId").html('<span class="stxt" id="idsame" style="color:red;"> <?=$txtdt["1196"]?></span>'); //아이디를 입력해주세요
			$("#idchk").val(0);
			$("input[name=meLoginid]").focus();
			return false;
		}
		else
		{
			var idReg = /^[A-za-z0-9]{6,15}/g;
			if(!idReg.test( $("input[name=meLoginid]").val())) 
			{
				$("#idchktxt").html('<?=$txtdt["1477"]?>'); //아이디는 영문자로 시작하는 6~15자 영문자 또는 숫자이어야 합니다
				$("#idchk").val(0);
				return false;
			}
			else
			{
				var chk_num = id.search(/[0-9]/g); 
				var chk_eng = id.search(/[a-z]/g);

				if(chk_num < 0 || chk_eng < 0)
				{ 
					$("#idchktxt").html('<?=$txtdt["1832"]?>'); //비밀번호는 숫자와 영문자를 혼용하여야 합니다
					$("#idchk").val(0);
					return false;
				}
				else
				{
					var apidata = "meLoginid="+id;
					//console.log(apidata);
					callapi('GET','member','medicalidchk',apidata);
					return false;		
				}
			}		
		}
	}

	//한의사 등록 수정
	function member_update()
	{
		//비밀번호 재확인
		var pwd1 = $("input[name=mePasswd]").val();
		var pwd2 = $("input[name=mePasswd2]").val();

		if(pwd1 == pwd2)
		{
			if($("input[name=idchk]").val() == 1) //아이디가 중복일 경우 회원가입이 되지 않게 처리
			{
				if(necdata()=="Y") //필수값체크
				{
					//member 회원가입 API
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
				callapi("POST","member","memberupdate",jsondata); //사용자 등록&수정
				}
			}
			else
			{
				if(!$("input[name=meLoginid]").val())
				{
					alert('<?=$txtdt["1196"]?>');//아이디를 입력해주세요.
					$("input[name=meLoginid]").focus();
					return false;
				}
				else
				{
					alert('<?=$txtdt["1650"]?>');//사용할수 없는 아이디입니다
					$("input[name=meLoginid]").focus();
					return false;
				}
			}
		}
		else
		{
			alert('<?=$txtdt["1530"]?>'); //비밀번호가 서로 맞지 않습니다
			$("input[name=mePasswd]").focus();
			return false;
		}
	}

	function member_del() //멤버 삭제
	{
		var data = "seq="+$("input[name=meSeq]").val();
		var url = encodeURI($("input[name=returnData]").val());
		$("input[name=returnData]").val(url);
		callapidel('member','memberdelete',data);
		return false;
	}

	function medical_update()//한의원등록
	{
		if(necdata()=="Y") //필수값체크
		{
			//medical 회원가입 API
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

			console.log(JSON.stringify(jsondata));
			callapi("POST","member","medicalupdate",jsondata); //사용자 등록&수정
		}
	}

	function medical_del() //한의원 삭제
	{
		var data = "seq="+$("input[name=seq]").val();
		var url = encodeURI($("input[name=returnData]").val());
		$("input[name=returnData]").val(url);
		callapidel('member','medicaldelete',data);
		return false;
	}

	function modinput2(type,seq,grade)
	{
		$("#nodata").remove();  //한의사추가를 눌렀을경우 데이터가 없습니다. 라는 문구는 사라지게 함

		var arr0=arr1=arr2=arr3=arr4=arr5=arr6=arr7=read=add=worker=stat="";
		type=type.split("_");
		console.log("type : "+type);

		$(".modconfirm").remove(0);
		$(".modfadeinput").removeClass("modfadeinput").fadeIn(0);
		//console.log("type[0] : "+type[0]);

		if(type[0]=="add")
		{
			var arrtxt="<?=$txtdt['1481']?>";////$("input[name=txt1481]").val();
			var reqdata="";
			arr0=seq="add";
		}else{
			var reqdata="reqdata";
			var read="readonly";
			var arr=new Array();
			$(".modinput_"+seq).children("td").each(function(){
				arr.push($.trim($(this).text()));
			});
			arr0=arr[0];arr1=arr[1];arr2=arr[2];arr3=arr[3];arr4=arr[4];
			arr5=arr[5];arr6=arr[6];arr7=arr[7];arr8=arr[8];arr8=arr[8];arr9=arr[9];arr10=arr[10];arr11=arr[11];arr12=arr[12];
			
			var arrtxt=arr0;
		}
		//console.log("arr : "+arr);
		var txt="";
		console.log("type[1] : "+type[1]);
		switch(type[1])
		{
			case "member": //한의원 소속 사용자 추가
				stat=$("textarea[name=selstat]").val();
				stat=stat.replace("title='"+arr7+"'"," checked");
				txt="<tr class='modconfirm'>";
				txt+="<td>";
				txt+="<input type='hidden' name='meSeq' class='reqdata' value='"+seq+"'>";
				txt+="<input type='hidden' name='meUserid' class='reqdata' value='"+arr0+"' "+read+">"; //한의원 userid
				txt+="<input type='hidden' name='userid' class='reqdata' value='<?=$_GET["userid"]?>'>"; //miUserid
				txt+="<input type='hidden' name='meGradetxt' class='reqdata' value='"+arr7+"' "+read+">";
				txt+=""+stat+"</td>"; //회원구분 라디오 박스
				txt+="<td><input type='text' name='meAuth' class='reqdata' value='"+arr1+"' title='<?=$txtdt['1085']?>'></td>"; //의사PK
				txt+="<td><input type='text' name='meLoginid' class='reqdata necdata' onfocus='this.select();' onchange='changeID(event, false);'  onblur='loginid_check()' value='"+arr2+"' title='<?=$txtdt['1193']?>'>"; //아이디
	<?php
				if($_GET["userid"])
				{
	?>
				txt+="<input type='hidden' id='idchk' name='idchk' value='1' >";//아이디 중복여부 체크
	<?php
				}else{
	?>
				txt+="<input type='hidden' id='idchk' name='idchk' value='0' >";//아이디 중복여부 체크
	<?php
				}
	?>
				txt+="<p><span class='info-ex02 mg5' id='idchktxt'><?=$txtdt['1012']?></span></p>";  //1012  6~20자의 영문,숫자 혼합
				txt+="<div class='checkLoginId'><span class='stxt' id='idsame' style='color:red;'></span></div></td>";//아이디중복여부표시
				if(seq!="" && seq!="add")//한의사 추가일때는 비밀번호가 필수
				{
					txt+="<td><input type='password' name='mePasswd' class='reqdata' value='"+arr3+"' title='<?=$txtdt['1140']?>'></td>"; //비밀번호
				}
				else
				{
					txt+="<td><input type='password' name='mePasswd' class='reqdata necdata' value='"+arr3+"' title='<?=$txtdt['1140']?>'></td>"; //비밀번호
				}
				txt+="<td><input type='password' name='mePasswd2' class='reqdata' value='"+arr3+"'>"; //비밀번호확인
				txt+="<div class='checkPasswd'><span class='stxt' id='idsame' style='color:red;'></span></div></td>";//비번 일치여부 표시
				txt+="<td><input type='text' name='meName' class='reqdata necdata' value='"+arr5+"' title='<?=$txtdt['1244']?>'></td>"; //이름
				//txt+="<td><input type='text' name='meRegistno' class='reqdata' value='"+arr5+"' title='<?=$txtdt["1085"]?>'></td>"; //면허번호
				txt+="<td>"+arr6+"</td>"; //등록일
				txt+="<td>";
				txt+=" <button type='button' class='cdp-btn'><span class='cdp-btn' onclick='member_update()'><?=$txtdt['1070']?></span></button>";
				txt+=" <button type='button' class='cdp-btn'><span onclick='member_del()'><?=$txtdt['1153']?></span></button>";
				txt+="</td></tr>";
				break;

			case "packing": //포장재추가	
				$("#packingDiv").css("display","block");  //상세페이지 열림
				if(type[0]=="add")
				{
					var newpbCode = getNowFull(2);
					var pbCode = "PCB"+newpbCode;
					console.log("pbCode  >>>"+pbCode);
					$("#packingDiv").load("/Skin/Member/MemberWrite.packing.php?pbCode="+pbCode);  //포장재추가
				}
				else
				{
					$("#packingDiv").load("/Skin/Member/MemberWrite.packing.php?seq="+seq+"&pbCode="+arr2);  //상세페이지 열림
				}
				break;
		}

		if(type[0]=="add")
		{		
			if(type[1]!="packing")
			{
				$(".thetbl tbody").prepend(txt);
			}			
		}
		else
		{
			if(type ==',member')
			{
				$(".modinput_"+seq).addClass("modfadeinput").fadeOut(0);
				$(".modinput_"+seq).before(txt);
			}
			else  //포장재일때는 리스트는 그대로 둠
			{
				//$(".modinput_"+seq).addClass("modfadeinput").fadeOut(0);  //클릭한 tr 사라지게 
				$(".modinput_"+seq).append(txt);
				$("input[name=pbseq]").val(seq);  // 포장재 seq 넘기기
			}
		}
		$("input[name=meGrade]:radio[value="+grade+"]").prop("checked", true);
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
				/*afFile = "<img src='<?=$root?>/_Img/Content/noimg.png'>";
				if(value["afFile"]!="NoIMG")
				{
					afFile = "<img src='"+getUrlData("FILE_DOMAIN")+value["afFile"]+"' onerror=\"this.src='<?=$root?>/_Img/Content/noimg.png'\" >";
				}*/

				afThumbUrl = "<img src='<?=$root?>/_Img/Content/noimg.png'>";
				if(value["afThumbUrl"]!="NoIMG")
				{
					if(value["afThumbUrl"].substring(0,4)=="http")
					{
						afThumbUrl = "<img src='"+value["afThumbUrl"]+"' onerror=\"this.src='<?=$root?>/_Img/Content/noimg.png'\" >";
					}
					else
					{
						afThumbUrl = "<img src='"+getUrlData("FILE_DOMAIN")+value["afThumbUrl"]+"' onerror=\"this.src='<?=$root?>/_Img/Content/noimg.png'\" >";
					}
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
	/*
	function medicalconfirm()
	{
		alert("준비중입니다.");
	}
	*/

	function makepage(json)
	{
		var obj = JSON.parse(json);
		console.log(obj);
		if(obj["apiCode"]=="medicaldesc")
		{
			$("input[name=miUserid]").val(obj["miUserid"]);
			$("input[name=seq]").val(obj["seq"]);
			$("input[name=miName]").val(obj["miName"]); //한의원이름
			$("input[name=miBusinessNo]").val(obj["miBusinessNo"]); //사업자번호
			$("input[name=miZipcode]").val(obj["miZipcode"]); //우편번호
			$("input[name=miAddress]").val(obj["miAddress"]); //주소
			$("input[name=miAddress1]").val(obj["miAddress1"]); //주소

			$("input[name=miPhone0]").val(obj["miPhone0"]); //전화번호
			$("input[name=miPhone1]").val(obj["miPhone1"]); //전화번호
			$("input[name=miPhone2]").val(obj["miPhone2"]); //전화번호

			$("input[name=miFax0]").val(obj["miFax0"]); //팩스번호
			$("input[name=miFax1]").val(obj["miFax1"]); //팩스번호
			$("input[name=miFax2]").val(obj["miFax2"]); //팩스번호

			$("input[name=pbMember]").val(obj["miUserid"]);

			CodeRadio("miDeliveryDiv", obj["miDeliveryList"],'<?=$txtdt["1632"]?>',"miDelivery","miDelivery-list", obj["miDelivery"])  //배송회사
			CodeRadio("miGradeDiv", obj["miGradeList"],'<?=$txtdt["1894"]?>',"miGrade","miGrade-list", obj["miGrade"])  //한의원등급 
			CodeRadio("meStatusDiv", obj["meStatusList"],'<?=$txtdt["1416"]?>',"miStatus","miStatus-list", obj["miStatus"])  //회원상태 리스트
			parseradiocodes("meGradeDiv", obj["meGradeList"], '<?=$txtdt["1644"]?>', "meGrade", "meGrade-list",null);//회원구분 리스트

			$("#mdok").hide();
			if(obj["miStatus"]=="standby")
			{
				$("#mdok").show();
			}

			var data = "";

			$(".thetbl tbody").html("");
			if(!isEmpty(obj["member"]))
			{
				$(obj["member"]).each(function( index, value )
				{
					data+="<tr class=\"modinput modinput_"+value["meSeq"]+" \" style='cursor:pointer;' onclick=\"modinput2('_member','"+value["meSeq"]+"', '"+value["meGrade"]+"')\" >";
					data+="<td class='l'>"+value["meGradetxt"]+"</td>";//회원구분
					data+="<td class='l'>"+value["meAuth"]+"</td>"; //의사PK
					data+="<td class='l'>"+value["meLoginid"]+"</td>"; //아이디
					data+="<td class='l'></td>"; //비밀번호
					data+="<td class='l'></td>"; //비밀번호 확인
					data+="<td class='l'>"+value["meName"]+"</td>"; //이름
					//data+="<td class='l'>"+value["meRegistno"]+"</td>"; //면허번호
					data+="<td>"+value["meDate"]+"</td>"; //등록일
					data+="<td class='l'></td>"; //버튼
					data+="</tr>";
				});
			}
			else
			{
				data+="<tr id='nodata'>";
				data+="<td colspan='8' ><?=$txtdt['1665']?></td>";   //데이터가 없습니다.
				data+="</tr>";
			}
			$(".thetbl tbody").html(data);

		}
		else if (obj["apiCode"]=="medicalidchk")
		{
			if(obj["resultCode"] == "200")
			{
				$(".checkLoginId").html('<span class="stxt" id="idsame" style="color:red;"> <?=$txtdt["1524"]?></span>'); //중복아이디
				$("#idchk").val(0);
			}
			else
			{
				$(".checkLoginId").html('<span class="stxt" id="idsame" style="color:blue;"> <?=$txtdt["1476"]?></span>'); //사용 가능합니다
				$("#idchk").val(1);
			}
			return false;
		}
		else if(obj["apiCode"]=="mypackingdesc")
		{
			viewmypackingdesc(obj);
			return false;
		}
		else if(obj["apiCode"]=="commpacking")
		{
			var data = "";
			var afFile=afThumbUrl="NoIMG";

			$("#pop_cptbl tbody").html("");
			if(!isEmpty(obj["list"]))
			{
				$(obj["list"]).each(function( index, value )
				{
					/*afFile = "<img src='<?=$root?>/_Img/Content/noimg.png'>";
					if(value["afFile"]!="NoIMG")
					{
						afFile = "<img src='"+getUrlData("FILE_DOMAIN")+value["afFile"]+"' onerror=\"this.src='<?=$root?>/_Img/Content/noimg.png'\" >";
					}*/
					afThumbUrl = "<img src='<?=$root?>/_Img/Content/noimg.png'>";
					if(value["afThumbUrl"]!="NoIMG")
					{
						if(value["afThumbUrl"].substring(0,4)=="http")
						{
							afThumbUrl = "<img src='"+value["afThumbUrl"]+"' onerror=\"this.src='<?=$root?>/_Img/Content/noimg.png'\" >";
						}
						else
						{
							afThumbUrl = "<img src='"+getUrlData("FILE_DOMAIN")+value["afThumbUrl"]+"' onerror=\"this.src='<?=$root?>/_Img/Content/noimg.png'\" >";
						}						
					}

					data+="<tr style='cursor:pointer;' onclick='javascript:popcompackdata(this);' data-seq='"+value["seq"]+"' data-fseq='"+value["afSeq"]+"' data-code='"+value["pbCode"]+"'>";
					data+="<td class='thumbp'>"+afThumbUrl+"</td>";//이미지
					data+="<td class='l'>"+value["pbTypeName"]+"</td>";//분류
					data+="<td class='l'>"+value["pbCode"]+"</td>"; //포장재코드
					data+="<td class='l'>"+value["pbTitle"]+"</td>"; //포장재명
					data+="<td class='l'>"+value["pbDate"]+"</td>"; //등록일
					data+="</tr>";
				});
			}
			else
			{
				data+="<tr id='nodata'>";
				data+="<td colspan='5' ><?=$txtdt['1665']?></td>";   //데이터가 없습니다.
				data+="</tr>";
			}
			$("#pop_cptbl tbody").html(data);

			getsubpage_pop("commpacklistpage",obj["tpage"], obj["page"], obj["block"], obj["psize"]);
		}
		else if(obj["apiCode"]=="commpackingupdate")
		{
			callapi('GET','inventory','mypackingdesc','<?=$apidata?>'); 	//포장재 상세내용 API 호출
		}
	}

	callapi('GET','member','medicaldesc','<?=$apidata?>'); //한의원 상세내용 api 호출
	callapi('GET','inventory','mypackingdesc','<?=$apidata?>'); 	//포장재 상세내용 API 호출
	$("input[name=miName]").focus();
</script>
