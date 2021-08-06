<?php
	$root="..";
	include_once $root."/_Inc/head.php";
?>
<div id="listdiv"></div>
<input type="hidden" name="medicalid" class="ajaxdata" value="<?=$_COOKIE["ck_miUserid"]?>">
<input type="hidden" name="meUserId" class="ajaxdata" value="<?=$_COOKIE["ck_meUserId"]?>">
<input type="hidden" name="meGrade" class="ajaxdata" value="<?=$_COOKIE["ck_meGrade"]?>">
<input type="hidden" id="nowchk" name="nowchk" value="0" >
<input type="hidden" id="passchk" name="passchk" value="0">

<input type="hidden" name="metype" class="" value=""> 
<script>
	function getlist()
	{
		callapi("GET","/medical/member/",getdata("mydesc"));  		
	}
	

	//해시값이 바뀌면 
	window.onhashchange = function(e) {
		viewpage();
	}
	
	viewpage();  //첫페이지

	function viewpage()
	{
		var hdata=location.hash.replace("#","").split("|");
		var seq=hdata[1];
		if(seq=="member")
		{
			$("#listdiv").load("<?=$root?>/Skin/Member/InfoMemberWrite.php");
		}
		else if(seq=="medical")
		{
			$("#listdiv").load("<?=$root?>/Skin/Member/InfoMedicalWrite.php");
		}
		else
		{
			$("#listdiv").load("<?=$root?>/Skin/Member/Info.php",function(){
				getlist();
			});
		}
	}

</script>

<?php include_once $root."/_Inc/tail.php"; ?>

<script>

	function ceochk()
	{
		//소속한의사가 없는지 체크하기
		callapi("GET","/medical/member/",getdata("ceochk"));
	}


	//팝업
	function viewlayermedical(id,metype)
	{
		console.log("viewlayermedical   id >>> "+id);
		console.log("viewlayermedical   metype >>> "+metype);

		if(!isEmpty(metype))
		{
			$("input[name=metype]").val(metype);
		}

		var txt="<div id='layerbox'></div>";
		$("body").prepend(txt);
		var url="/_LayerPop/"+id+".php?metype="+metype;
		//$("#layerbox").load(url)

		$("#layerbox").load(url,function(){callapi("GET","/medical/member/",getdata("medicallist"));  });
	}

/*
	//영문 혼합 체크와 아이디 중복확인
	function loginid_check()
	{
		
		$("#idsame").html('');
		$("input[name=idchk]").val(0);
		var id=$("input[name=stUserId]").val();
		var idReg = /^[A-za-z0-9]{5,20}/g;

		if(!isEmpty(id))
		{
			if(!idReg.test(id) && $("input[name=stUserId]").val())
			{
				alert('5~20자의 영문 소문자, 숫자만 사용해주세요.'); 
				return false;
			}
			else
			{			
				console.log("api call" +id);
				callapi("GET","/medical/member/",getdata("medicalidchk")+"&medicalid="+id);		
				return false;
			}
		}
	}
	*/


	//의료기관정보 수정하기
	function addmedicalinfo()
	{	
		//필수데이터 처리
		$(".ajaxnec").each(function(){
			var dt=$(this).val();
			if(dt==""){
				var title=$(this).attr("placeholder");
				alert("("+title+") 입력 해주세요.");
			}
		});

		callapi("POST","/medical/member/",getdata("addmedicalupdate"));
		
		location.reload();
	
	}


	//내정보 수정하기
	function addmyinfo()
	{		
		//if($("input[name=idchk]").val()==1) //중복확인이 1이어야 등록가능
		//{
			//필수데이터 처리
			$(".ajaxnec").each(function(){
				var dt=$(this).val();
				if(dt==""){
					var title=$(this).attr("placeholder");
					alert("("+title+") 입력 해주세요.");
				}
			});

			var meIsemail=$('input:radio[name="meIsemail"]:checked').val();
			console.log("meIsemail   >>> "+meIsemail);

			callapi("POST","/medical/member/",getdata("addmemberupdate")+"&meIsemail="+meIsemail);//내정보 수정하기
			
			location.reload();
		//}
		/*
		else
		{
			if(!$("input[name=stUserId]").val())
			{
				alert('아이디를 입력해주세요.');
				$("input[name=stUserId]").focus();
				return false;
			}
			else
			{
				alert('사용할수 없는 아이디입니다');
				$("input[name=stUserId]").focus();
				return false;
			}
		}	
		*/
	}

	//탈퇴
	function dowithdraw()
	{	
		if($("input:checkbox[name=d1]").is(":checked") == true) 
		{
			var metype=$("input[name=metype]").val();			

			if(metype=="member")
			{				
				var meuserid="<?=$_COOKIE['ck_meUserId']?>";
				callapi("GET","/medical/member/",getdata("dowithdraw")+"&metype=member&meuserid="+meuserid);
				moremove('modal-withdraw');
				removeSession(); 
			}
			else if(metype=="medical")
			{
				callapi("GET","/medical/member/",getdata("dowithdraw")+"&metype=medical");
				moremove('modal-withdraw');
				removeSession(); 			
			}		
		}
		else
		{
			alert("약관에 체크해주세요");
			return false;	
		}		
	}

	//내정보 수정시 비밀번호 한번더 확인
	function chkpwd()
	{
		var addpasswordDiv=$("input[name=addpasswordDiv]").val(); 
		console.log("addpasswordDiv      >>>> "+addpasswordDiv);

		if(!isEmpty(addpasswordDiv))
		{
			callapi("GET","/medical/member/",getdata("chkpwd")); 				
		}
		else
		{
			alert("비밀번호를 입력해주세요");
			return false;
		}	 
	}

	function passwdKeydown()
	{
		if(event.keyCode == 13)
		{
			callapi("GET","/medical/member/",getdata("chkpwd"));  
		}	
	}

	//기존 비번이 맞는지 체크
	function passchk()
	{
		$("input[name=nowchk]").val("0"); 
		callapi("GET","/medical/member/",getdata("chkpwd")+"&passtype=change"); 	
	}	

	function passupdate()
	{
		var nowchk=$("input[name=nowchk]").val(); 

		if(nowchk=="0")
		{
			alert("현재 비밀번호가 다릅니다. 다시 입력해주세요");
			$("#addpasswordDiv").focus();
		}
		else if(nowchk=="1")
		{
			if($("input[name=passchk]").val()==1) //중복확인이 1이어야 등록가능
			{

				var newpass=$("input[name=newpass]").val(); 
				var renewpass=$("input[name=renewpass]").val(); 

				if(newpass!=renewpass)
				{
					alert("새 비밀번호와 비밀번호 확인이 다릅니다. 다시 확인해주세요");	
					return false;
				}
				else
				{	
					
					callapi("POST","/medical/member/",getdata("passupdate"));	
					moremove('modal-changepass');
				}
			}
			else
			{
				alert("비밀번호를 다시 확인해주세요");	
				return false;
			
			
			}
		}
	}

	// 비밀번호 패턴 체크 (8자 이상, 문자, 숫자, 특수문자 포함여부 체크) 
	function checkPasswordPattern(str) { 
		var pattern1 = /[0-9]/; // 숫자 
		var pattern2 = /[a-zA-Z]/; // 문자
		var pattern3 = /[~!@#$%^&*()_+|<>?:{}]/; // 특수문자 

		if(!pattern1.test(str) || !pattern2.test(str) || !pattern3.test(str) || str.length < 9) { 
			$("#passwordchk").html('비밀번호는 9자리이상 문자,숫자,특수문자로 구성하세요');
			return false; 
		} else { 
			return true; 
		} 
	}

	function password_check()
	{
		//$("#passwordchk").html(' 비밀번호는 9자리 이상 문자, 숫자, 특수문자로 구성하여야 합니다.');
		var pwd=$("input[name=newpass]").val();

		if(checkPasswordPattern(pwd)==true)
		{
			$("#passwordchk").html('<span class="stxt" id="idsame" style="color:blue;">사용 가능합니다</span>'); //사용 가능합니다
			var pwd2=$("input[name=renewpass]").val();
			if(pwd==pwd2)
			{
				$("#passwordchk2").html('<span class="stxt" id="idsame" style="color:blue;">사용 가능합니다</span>'); //사용 가능합니다
					$("#passchk").val(1);
			}
			else if(!pwd2)
			{
				//$("#passwordchk2").html(' 비밀번호 확인란을 입력해 주세요.');
				$("#passchk").val(0);
			}
			else
			{
				$("#passwordchk2").html(' 비밀번호가 서로 맞지 않습니다.');
				$("#passchk").val(0);
			}
			return false;
		}
		else
		{
			//alert("비밀번호는 9자리이상 문자,숫자,특수문자로 구성하세요");
			$("#passchk").val(0);
			
		}
		var passchk=$("input[name=passchk]").val(); 
		console.log("passchk   >>>>>>>>>>>>>"+passchk);
	}


	function medicalsearcls()
	{
		var medicalsearchTxt=$("input[name=medicalsearchTxt]").val(); 
		callapi("GET","/medical/member/",getdata("medicallist")+"&medicalsearchTxt="+medicalsearchTxt);  
	}

	function gostandby(me_company)
	{
		if(confirm("이 한의원에 등록을 하시겠습니까?"))
		{
			//한의사의 me_userid랑 me_company값이랑 같이 넘기기
			console.log("me_company  >>>>>>>"+me_company);
			callapi("POST","/medical/member/",getdata("mydoctorupdate")+"&meCompany="+me_company);		
			
			moremove('modal-searchmedical');
			location.reload();

		}	
	}

	//팝업리스트뿌리기
	function thismakelist(result, marr)
	{
		var json = JSON.parse(result);
		console.log("-------------------------------------");
		console.log(JSON.stringify(json));
		
		var data="";
		
		$.each(json["list"] ,function(index, val){
			
			if(json["apiCode"]=="medicallist")
			{
				data+="<tr>";				
			}
			else
			{				
				data+="<tr  id='DescDiv"+val["seq"]+"' onclick='viewdesc("+val["seq"]+")'>";
			}
			
			for(i=0;i<marr.length;i++)
			{
				var txt=val[marr[i]];						
			
				data+="<td class='td-txtcenter'>"+txt+"</td>";								
			}
			data+="</tr>";
		});

		//리스트가 없으면
		if(isEmpty(json["list"]))
		{
			data+="<tr>";
			data+="<td colspan='5'>데이터가 없습니다</td>";
			data+="</tr>";
		}


		$("#popuptbl tbody").html(data);
		poppaging("poppaging", json["tpage"],  json["page"]);
	}	

	function goRequest(seq)  //대표한의사가 요청한것을 승인처리함
	{
		if(confirm("승인하시겠습니까?"))
		{
			console.log("seq  >>>>>>>"+seq);
			callapi("POST","/medical/member/",getdata("mymedicalupdate")+"&seq="+seq);
			location.reload();
		}
	}

	//팝업용페이지 따로뺌
	function poppaging(pgid, tpage, page)
	{
		var block=psize=10;
		var prev=next=0;
		var inloop = (parseInt((page - 1) / block) * block) + 1;
		prev = inloop - 1;
		next = inloop + block;
		var txt="<div class='paging__arrow d-flex'>";
		var link = "";
		if(prev<1){prev = 1;}	link = "popgopage("+prev+")";
		txt+="<a href='javascript:popgopage(1);'  class='paging__btn paging__fst'>처음</a></li>";
		txt+="<a href='javascript:"+link+";' class='paging__btn paging__prev'>이전</a></div>";
		if(tpage == 0)//데이터가 없을 경우
		{
			txt+="<a href='javascript:popgopage(1);'>1</a>";
		}
		else
		{
			for (var i=inloop;i < inloop + block;i++)
			{		
				if (i <= tpage)
				{
					if(i==page){var cls="active";}else{var cls="";}
					txt+="<a href='javascript:popgopage("+i+");'  class='paging__num "+cls+"'>"+i+"</a>";
				}
			}
		}
		txt+="</div><div class='paging__arrow d-flex'>";
		if(next>tpage){next=tpage;}	link = "popgopage("+next+")";
		txt+="<a href='javascript:"+link+";' class='paging__btn paging__next'>다음</a>";
		txt+="<a href='javascript:popgopage("+tpage+");' class='paging__btn paging__lst'>마지막</a>";
		txt+="</div>";
		$("#"+pgid).html(txt);
		return;
	}

	function popgopage(no)
	{	
		$("input[name=page]").remove();

		console.log("여기서 api 호출");
		callapi("GET","/medical/member/",getdata("medicallist")+"&page="+no);  
	}

	function makepage(result)
	{
		var obj = JSON.parse(result);
		console.log(obj);
		console.log("apiCode>>>>>>> "+obj["apiCode"]);

		if(obj["apiCode"]=="mydesc") 
		{
			if(!isEmpty(obj["returnData"])&&obj["returnData"]=="mod")  //정보관리를 수정하면 나오는 페이지
			{
				if(obj["metype"]=="member")
				{
					/* 내정보 */
					$("input[name=stName]").val(obj["me_name"]); //이름

					var mobile1=mobile2=mobile3="";
					if(!isEmpty(obj["me_mobile"]))
					{
						var mbarr=obj["me_mobile"].split("-");
						mobile1=mbarr[0];
						mobile2=mbarr[1];
						mobile3=mbarr[2];
					}

					$("input[name=stMobile0]").val(mobile1); //휴대전화
					$("input[name=stMobile1]").val(mobile2); //휴대전화
					$("input[name=stMobile2]").val(mobile3); //휴대전화

					var email1=email2="";
					if(!isEmpty(obj["me_mobile"]))
					{
						var emarr=obj["me_email"].split("@");
						email1=emarr[0];
						email2=emarr[1];
					}

					$("input[name=stEmail0]").val(email1); //이메일
					$("input[name=stEmail1]").val(email2); //이메일

					$("input[name=licenseno]").val(obj["me_registno"]); //면허번호

					$("input:radio[name='meIsemail']:radio[value="+obj["me_isemail"]+"]").prop('checked', true); // 값체크				
				}
				else if(obj["metype"]=="medical")
				{
					$("input[name=miName]").val(obj["mi_name"]); //의료기관명

					var business1=business2=business3="";
					if(!isEmpty(obj["mi_businessno"]))
					{
						var bsarr=obj["mi_businessno"].split("-");
							business1=bsarr[0];
							business2=bsarr[1];
							business3=bsarr[2];
					}

					$("input[name=miBusinessno0]").val(business1); //사업자번호
					//$("input[name=miBusinessno1]").val(business2); //사업자번호
					//$("input[name=miBusinessno2]").val(business3); //사업자번호

					$("input[name=miCeo]").val(obj["mi_ceo"]); //대표자명

					$("input[name=miZipcode]").val(obj["mi_zipcode"]); //우편번호
					$("input[name=miAddress]").val(obj["miAddress"]); //사업장소재지
					$("input[name=miAddress1]").val(obj["miAddress1"]); //사업장소재지

					$("input[name=miPhone0]").val(obj["miPhone0"]); //전화번호
					$("input[name=miPhone1]").val(obj["miPhone1"]); //전화번호
					$("input[name=miPhone2]").val(obj["miPhone2"]); //전화번호


					$("input[name=miFax0]").val(obj["miFax0"]); //팩스번호
					$("input[name=miFax1]").val(obj["miFax1"]); //팩스번호
					$("input[name=miFax2]").val(obj["miFax2"]); //팩스번호

					var email1=email2="";
					if(!isEmpty(obj["mi_email"]))
					{
						var emarr=obj["mi_email"].split("@");
							email1=emarr[0];
							email2=emarr[1];
					}

					$("input[name=miEmail0]").val(email1); //이메일
					$("input[name=miEmail1]").val(email2); //이메일
					
					
				}
			}
			else  // 정보관리 열면 나오는 페이지
			{
				/* 내정보 */
				$("#meName").text(obj["me_name"]); //이름
				$("#meLoginid").text(obj["me_loginid"]); //아이디
				$("#meBusinessmobile").text(obj["me_mobile"]); //휴대전화
				$("#meBusinessemail").text(obj["me_email"]); //이메일
				$("#meRegistno").text(obj["me_registno"]); //면허번호
				$("#meIsemail").text(obj["me_isemail"]); //이메일수신여부


				if(!isEmpty(obj["me_company"]))  //소속된 한의원이 있을경우
				{
					$("input[name=stUserId]").val(obj["me_loginid"]);//아이디
					/* 의료기관정보 */
					$("#miName").text(obj["mi_name"]); //의료기관명
					$("#miBusinessno").text(obj["mi_businessno"]); //사업자번호
					$("#miCeo").text(obj["mi_ceo"]); //대표자명
					$("#miAddress").text(obj["miAddress"]+"  "+obj["miAddress1"]); //사업장소재지

					$("#miPhone").text(obj["miPhone0"]+"-"+obj["miPhone1"]+"-"+obj["miPhone2"]); //전화번호

					$("#miFax").text(obj["miFax0"]+"-"+obj["miFax1"]+"-"+obj["miFax2"]); //팩스번호
					$("#miEmail").text(obj["mi_email"]); //세금계산서	

					if(!isEmpty(obj["meStatus"]))  //승인대기중일때만 상태값버튼 보임
					{
						var sdata='<a href="javascript:;" class="" style="">'+obj["meStatus"]+'</a>';
						$("#medicalBtn").html(sdata);
					}

					var data='<a href="javascript:ceochk();"  style="margin-right:900px;" class="d-flex btn btn--small border-rightGray color-gray">한의원 탈퇴</a>';

					//대표한의사인 경우만 한의원정보를 수정할수 있음
					<?php if($_COOKIE["ck_meGrade"]=="30"){?>
					data+='<a href="javascript:viewlayermedical(\'modal-member-info\',\'medical\');" class="d-flex btn btn--small border-rightGray color-gray" style="margin-right:1px;position:absolute;">수정하기</a>';
					
					<?php } ?>
					$("#btnBoxDiv").html(data);
					
				}
				else  //소속 한의원이 없는경우 
				{	
					var txt='<div class="btndiv"><a href="<?=$root?>/Signup/SingupMedical.php" class="minfobtn">한의원등록하기</a>';
						txt+='<a href=javascript:viewlayermedical(\'modal-searchmedical\',\'medical\'); class="minfobtn">한의원 검색</a></div>';
					$("#medicalinfoDiv .table--details").html(txt);
				}
			}

		}
		else if(obj["apiCode"]=="chkpwd")  
		{
			if(obj["passtype"]=="change")  //비밀번호 변경시 현재 비밀번호 확인
			{
				if(obj["resultCode"] == "200")  //현재 비밀번호 다름
				{								
					$("input[name=nowchk]").val("0"); 			
				}
				else
				{
					$("input[name=nowchk]").val("1"); 	
				}
			}
			else //한의원 내정보수정 비밀번호 체크
			{
				if(obj["resultCode"] == "200")
				{			
					moremove('modal-member-info');//창닫기
					alert("비밀번호가 다릅니다.");						
				}
				else
				{
					var metype=$("input[name=metype]").val();
					
					if(metype=="member")
					{	//내정보 수정화면으로 넘기기
						$("#myinfoDiv").load("<?=$root?>/Skin/Member/Inforevision.php", function(){
							callapi("GET","/medical/member/",getdata("mydesc")+"&returnData=mod&metype=member");  
						});
					
					}
					else if(metype=="medical")
					{	//내정보 수정화면으로 넘기기			
						$("#medicalinfoDiv").load("<?=$root?>/Skin/Member/Infomedical.php",function(){
							callapi("GET","/medical/member/",getdata("mydesc")+"&returnData=mod&metype=medical");  
						});
					}			
					moremove('modal-member-info');//창닫기
					
				}
				return false;		
			
			}
		}
		else if(obj["apiCode"]=="medicallist")    //한의원 검색시
		{
		
			//$marr=array("한의원이름","대표자이름","한의원주소","사업자번호","");
			var marr=["miName","meName","miAddress","miBusinessno","standbyBtn"];	
			thismakelist(result, marr);	
		}
		else if(obj["apiCode"]=="ceochk")    //대표가 한의원 탈퇴시 소속한의사가 있는지 체크
		{
			if(obj["resultCode"] == "204")
			{			
				alert("소속 한의사가 존재하여 대표한의사는 탈퇴할수없습니다.");			
			}
			else
			{
				viewlayermedical('modal-withdraw','medical'); 			
			}			
		}

		/*
		else if(obj["apiCode"]=="medicalidchk")  //한의원 아이디 중복체크
		{
			if(obj["resultCode"] == "204")
			{
				
				$("#idchktxt").html('<span class="stxt" id="idsame" style="color:red;">중복아이디</span>'); //중복아이디
				$("#idchk").val(0);
			}
			else
			{
				$("#idchktxt").html('<span class="stxt" id="idsame" style="color:blue;">사용가능합니다.</span>'); 
				$("#idchk").val(1);
			}
			return false;
		}
		*/
		
	}
	
</script>