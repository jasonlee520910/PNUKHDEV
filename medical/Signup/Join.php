<?php
	$root="..";
	include_once $root."/_Inc/head.php";
	if($_COOKIE["ck_meUserId"])header("location:/");
?>
<!-- 회원가입관련 json data -->
<?php if($_SERVER["REMOTE_ADDR"]=="59.7.50.122"){$display="block";}else{$display="none";}?>
<!-- <textarea name="join_jsondata" style="display:<?=$display?>;"></textarea>  -->
<textarea name="join_jsondata" style="display:none;"></textarea> 
<div id="listdiv"></div>

<script>
	//해시값이 바뀌면 
	window.onhashchange = function(e) {
		viewpage();
	}
	
	viewpage();  //첫페이지

	function viewpage()
	{
		var hdata=location.hash.replace("#","").split("|");
		var seq=hdata[1];
		console.log("seq>>>> "+seq);
	
		if(seq==undefined || seq=="")
		{
			$("#listdiv").load("<?=$root?>/Skin/Signup/TermsAgree.php");//약관동의
		}
		/*
		else if(seq=="join")
		{
			$("#listdiv").load("<?=$root?>/Skin/Signup/Join.php");//회원정보입력
		}
		/*
		else if(seq=="fill")
		{
			$("#listdiv").load("<?=$root?>/Skin/Signup/JoinFillIn.php");//계약서작성
		}
		else if(seq=="complete")
		{
			$("#listdiv").load("<?=$root?>/Skin/Signup/JoinComplete.php");//가입완료 
		}
		*/
	}

</script>

<?php
   include_once $root."/_Inc/tail.php"; ?>
<script>

	//이메일테스트용 버튼
	function test_update()
	{
		var stEmail0=$("input[name=stEmail0]").val(); 
		var stEmail1=$("input[name=stEmail1]").val(); 

		var memberemail=stEmail0+"@"+stEmail1; 		
		var stUserId=$("input[name=stUserId]").val(); 

		var stName=$("input[name=stName]").val(); 	
		var agreetime="2020-08-15"; //가입한 날짜

		setTimeout("callmailer('"+memberemail+"','"+stUserId+"','"+stName+"','"+agreetime+"')",500);
	}


	function goterms(){
		$("textarea[name=join_jsondata]").val("");
		$("#listdiv").load("<?=$root?>/Skin/Signup/TermsAgree.php");//회원정보입력
	}


	//인증번호받기 버튼
	function mobilechk()
	{
		//callapi();
		$("#mobilechk").text("재전송");
		//makepage
	}

	//인증하기 버튼
	function mobilere()
	{
		//callapi();
		//GET qwdqdqw
		$("#mobilechk").text("인증중").attr("onclick","");//onclick a 제거
		//makepage
		$("#mobilechk").text("인증완료").attr("disabled",true);
	}

	//영문 혼합 체크와 아이디 중복확인
	function loginid_check()
	{
		$("#idsame").html('');
		$("input[name=idchk]").val(0);
		var id=$("input[name=stUserId]").val();
		var idReg = /^[a-z0-9]{5,20}/g;
		if(!isEmpty(id))
		{
			if(!idReg.test(id) && $("input[name=stUserId]").val())
			{
				$("#idchktxt").text("5~20자의 영문 소문자, 숫자만 사용해주세요");
				//alert('5~20자의 영문 소문자, 숫자만 사용해주세요.'); 
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

	// 비밀번호 패턴 체크 (8자 이상, 문자, 숫자, 특수문자 포함여부 체크) 
	function checkPasswordPattern(str) { 
		var pattern1 = /[0-9]/; // 숫자 
		var pattern2 = /[a-zA-Z]/; // 문자
		var pattern3 = /[~!@#$%^&*()_+|<>?:{}]/; // 특수문자 

		if(!pattern1.test(str) || !pattern2.test(str) || !pattern3.test(str) || str.length < 9) { 
			$("#passwordchk").html(' 비밀번호는 9자리 이상 문자, 숫자, 특수문자로 구성하여야 합니다.');

			return false; 
		} else { 
			return true; 
		} 
	}

	function password_check()
	{
		$("#passwordchk").html(' 비밀번호는 9자리 이상 문자, 숫자, 특수문자로 구성하여야 합니다.');
		var pwd=$("input[name=passwordDiv]").val();
		if(checkPasswordPattern(pwd)==true)
		{
			$("#passwordchk").html('<span class="stxt" id="idsame" style="color:blue;">사용 가능합니다</span>'); //사용 가능합니다
			var pwd2=$("input[name=passwordDiv2]").val();
			if(pwd==pwd2){
				$("#passwordchk2").html('<span class="stxt" id="idsame" style="color:blue;">사용 가능합니다</span>'); //사용 가능합니다
					$("#passchk").val(1);
			}else if(!pwd2){
				$("#passwordchk2").html(' 비밀번호 확인란을 입력해 주세요.');
				$("#passchk").val(0);
			}else{
				$("#passwordchk2").html(' 비밀번호가 서로 맞지 않습니다.');
				$("#passchk").val(0);
			}
			return false;
		}
	}


	//다음 버튼
	function join_update()
	{		
		//alert($("input[name=passchk]").val());
		var pwd1 = $("input[name=passwordDiv]").val();
		var pwd2 = $("input[name=passwordDiv2]").val();

		//필수데이터 처리
		if(ajaxnec()=="Y")
		{
			if(pwd1 != pwd2) //비밀번호 일치 하는지
			{
				alert('비밀번호가 서로 맞지 않습니다'); 
				$("input[name=passwordDiv2]").focus();
				return false;
			}
			else if($("input[name=idchk]").val()!=1) //중복확인이 1이어야 등록가능
			{
				alert('사용할수 없는 아이디입니다');
				$("input[name=stUserId]").focus();
				return false;
			}
			else
			{
				if($("input[name=passchk]").val()==1) //중복확인이 1이어야 등록가능
				{

					var key=data="";
					var jsondata=JSON.parse($("textarea[name=join_jsondata]").val());
					$(".ajaxdata").each(function(){
						key=$(this).attr("name");
						data=$(this).val();
						jsondata[key] = data;
					});

					$("input[name=meIsemail]:checked").each(function() {
						key=$(this).attr("name");
						data=$(this).val();
						jsondata[key] = data;
					});
					console.log("-------------------");
					$("textarea[name=join_jsondata]").val(JSON.stringify(jsondata));					
					$("#listdiv").load("<?=$root?>/Skin/Signup/JoinFillIn.php");//계약서작성
				}
				else
				{
					alert('비밀번호를 확인해주세요');
				
				}
			}
		}

	}

	function makepage(result)
	{
		var obj = JSON.parse(result);
		console.log(obj);
		if(obj["resultCode"] == "200")
		{
			switch(obj["apiCode"]){
				case "medicalidchk":
					$("#idchktxt").html('<span class="stxt" id="idsame" style="color:blue;">사용가능합니다.</span>');
					$("#idchk").val(1);
					break;
				case "medicalupdate":
					$("#idchktxt").html('<span class="stxt" id="idsame" style="color:blue;">사용가능합니다.</span>');
					$("#idchk").val(1);
					break;
			}
		}
		else if(obj["resultCode"] == "204")
		{
			if(obj["apiCode"]=="medicalidchk"){  //한의원 아이디 중복체크
				$("#idchktxt").html('<span class="stxt" id="idsame" style="color:red;">중복아이디</span>'); //중복아이디	
			}else{
			}
		}
		else
		{

		}
		return false;
	}



	function changeBtn()
	{
		var checkbox1=checkbox2="";
		$("input[name=checkbox1]:checked").each(function() { 
			checkbox1=$(this).val();
		});

		$("input[name=checkbox2]:checked").each(function() { 
			checkbox2=$(this).val();
		});

		if(!isEmpty(checkbox1) && !isEmpty(checkbox2))//서비스 약관과 개인정보 둘다 동의했는지 체크
		{
			gojoin();
		}	
	}

	function gojoin()
	{
		var d=new Date()
		var month=("0" + (d.getMonth() + 1)).slice(-2);
		var day=("0" + d.getDate()).slice(-2);
		var hour=("0" + d.getHours()).slice(-2);
		var minute=("0" + d.getMinutes()).slice(-2);
		var second=("0" + d.getSeconds()).slice(-2);
		var agreetime=d.getFullYear()+"-"+month+"-"+day+" "+hour+":"+minute+":"+second;
		var jsondata={"agreetime":agreetime};
		console.log(JSON.stringify(jsondata));
		$("textarea[name=join_jsondata]").val(JSON.stringify(jsondata));
		$("#listdiv").load("<?=$root?>/Skin/Signup/Join.php");//회원정보입력
		
	}

	function join_pass(){
		$("#listdiv").load("<?=$root?>/Skin/Signup/JoinFillIn.php");//회원정보입력
	}

	//완료 버튼
	function joinfillin_update(type)
	{
		if(type=="hold")
		{
			if(ajaxnec()=="Y")
			{
				$("inpt[name=miName]").val("");
				$("textarea[name=join_jsondata]").addClass("ajaxdata");
				callapi("POST","/medical/member/",getdata("medicalupdate"));

				var data=$("textarea[name=join_jsondata]").val();			
				var obj = JSON.parse(data);
				console.log(obj);

				var memberemail=obj["stEmail0"]+"@"+obj["stEmail1"]; 
				var stUserId=obj["stUserId"]; 

				var stName=obj["stName"]; //이름
				var agreetime=obj["agreetime"]; //가입한 날짜

				setTimeout("callmailer('"+memberemail+"','"+stUserId+"','"+stName+"','"+agreetime+"')",500);

				$("textarea[name=join_jsondata]").val('');
				$("#listdiv").load("<?=$root?>/Skin/Signup/JoinComplete.php");//완료 
			}
		}
		else
		{	
			//if(ajaxnec()=="Y"){
				$("textarea[name=join_jsondata]").addClass("ajaxdata");
				callapi("POST","/medical/member/",getdata("medicalupdate"));  

				var data=$("textarea[name=join_jsondata]").val();
				var obj = JSON.parse(data);
				console.log(obj);

				var memberemail=obj["stEmail0"]+"@"+obj["stEmail1"]; 
				var stUserId=obj["stUserId"]; 

				var stName=obj["stName"]; //이름
				var agreetime=obj["agreetime"]; //가입한 날짜

				setTimeout("callmailer('"+memberemail+"','"+stUserId+"','"+stName+"','"+agreetime+"')",500);

				$("textarea[name=join_jsondata]").val('');
				$("#listdiv").load("<?=$root?>/Skin/Signup/JoinComplete.php");//완료 
				
			//}
		}
	}

	function callmailer(memberemail,stUserId,stName,agreetime)
	{

		console.log("memberemail    >>> "+memberemail);
		console.log("stUserId    >>> "+stUserId);
		console.log("stName    >>> "+stName);
		console.log("agreetime    >>> "+agreetime);

		callapi("GET","/common/mailer/",getdata("sendemail")+"&memberemail="+memberemail+"&stUserId="+stUserId+"&stName="+stName+"&agreetime="+agreetime);
	} 



</script>
