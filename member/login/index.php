<?php
	$root="..";
	include_once $root."/_common.php";
	include_once $root."/_Inc/head.php";
?>
<style>
	.logindiv{width:50%;min-width:800px;margin:auto;overflow:hidden;}
	.logindiv dl, .logindiv div{width:50%;float:left;padding:0 10px;}
	.logindiv dl{margin-top:30px;text-align:left;}
	.logindiv dl dd{margin:5px 15px;text-align:center;}
	.logindiv div{float:right;}
	.tmpbtn{display:inline-block;background:#fff;border:2px solid #fff;border-radius:7%;width:85px;height:100px;color:#111;padding:10px;margin:5px;}
	.tmpbtn.on, .tmpbtn:hover{background:#DBE1F2;border:2px solid #fff;cursor:pointer;}
</style>
<input type="hidden" name="returnData" class="reqdata" value="<?=$returnData?>">
<input type="hidden" name="stDepart" class="reqdata" value="">
<div class="section_login">
	<section>
		<h2><?=$txtdt["companyname"]?> <?=$txtdt["title01"]?></h2><!-- 디제이메디한의원 --> <!-- 관리자 전용 사이트 입니다. -->
		<p class="info_txt" style="width:33%;margin:auto;"><?=$txtdt["title02"]?></p><!-- 한의원 고객께서는 서비스 가입 후 안내된 고객전용 한의원 사이트를 통하여 접속하실 수 있습니다 -->
		<!-- <a href="javascript:go_medical();" class="btn_go"><?=$txtdt["titlelink"]?></a> --><!-- 한의원 사이트 바로가기 -->

		<?php if($_SERVER["REMOTE_ADDR"]=="59.7.50.122"){?>
				<!-- <button type="button" class="tmpbtn" id="manager" onclick="javascript:departUpdate('manager');">관리자</button>
				<button type="button" class="tmpbtn" id="making" onclick="javascript:departUpdate('making');">조제작업자</button>
				<button type="button" class="tmpbtn" id="decoction" onclick="javascript:departUpdate('decoction');">탕전작업자</button>
				<button type="button" class="tmpbtn" id="marking" onclick="javascript:departUpdate('marking');">마킹작업자</button>
				<button type="button" class="tmpbtn" id="release" onclick="javascript:departUpdate('release');">포장작업자</button>
				<button type="button" class="tmpbtn" id="pill" onclick="javascript:departUpdate('pill');">제환작업자</button>
				<button type="button" class="tmpbtn" id="goods" onclick="javascript:departUpdate('goods');">약속작업자</button>
				<button type="button" class="tmpbtn" id="pharmacy" onclick="javascript:departUpdate('pharmacy');">수동조제자</button>
				<button type="button" class="tmpbtn" id="delivery" onclick="javascript:departUpdate('delivery');">배송담당자</button> -->
		<?php	}?>

		<div class="logindiv">
		<?php 
			//$carr=array("manager","making","decoction","marking","release","pill","goods","pharmacy","delivery");	
			//$tarr=array("관리자","조제작업자","탕전작업자","마킹작업자","포장작업자","제환작업자","약속작업자","수동조제자","출고담당자");	
			$carr=array("manager","making","decoction","marking","release","pill","delivery");	
			$tarr=array("관리자","조제작업자","탕전작업자","마킹작업자","포장작업자","제환작업자","출고관리");	
			echo "<dl>";
			for($i=0;$i<count($carr);$i++){
				echo "<dd  id='".$carr[$i]."' class='tmpbtn' onclick=\"javascript:departchange('".$carr[$i]."');\"><img src='".$root."/_Img/icon_".$carr[$i].".png'><br>".$tarr[$i]."</dd>";
			}
			echo "</dl>";
		 ?>
			<div class="login_box">
				<input type="text" name="stLoginId" id="stLoginId" class="reqdata" placeholder="Username" value="" onkeyup="keyup()" />
				<input type="password" name="stPasswd" id="stPasswd" class="reqdata input-pass" placeholder="Password" value=""/>
				<button type="button" class="btn" onclick="javascript:login();">Log in</button>
				<div class="etc">
					<span class="agree">
						<input type="checkbox" name="saveid" id="agree_autologin" checked="<?php if($_COOKIE["ck_saveid"]!=""){ ?>checked<?php }?>">
						<label for="agree_autologin"><?=$txtdt["saveid"]?></label>
					</span><!-- 아이디저장 -->
					<!-- <a href="javascript:go_idpwd();" class="lnk"><?=$txtdt["findidpw"]?></a> --><!-- 아이디/비밀번호찿기 -->
				</div>
			</div>
		</div>

	</section>
</div>
<?php include_once $root."/_Inc/tail.php"; ?>

<script>
	function departchange(depart)
	{
		var logDepart=depart;
		$("input[name=stDepart]").val(depart);

		var onID=$(".tmpbtn.on").attr("id");

		if(!isEmpty(onID))
		{
			$("#"+onID).removeClass("on");
		}
		$("#"+logDepart).addClass("on");
	}
/*
	function departUpdate(depart)
	{
		var loginID=$("input[name='stLoginId']").val();
		var logDepart=depart;

		var onID=$(".tmpbtn.on").attr("id");

		if(!isEmpty(onID))
		{
			$("#"+onID).removeClass("on");
		}
		$("#"+logDepart).addClass("on");

		if(isEmpty(loginID))
		{
			layersign('warning', '<?=$txtdt["loginid"]?>', '','2000'); //아이디를 입력해주세요.
			$("input[name='stLoginId']").focus();
			return false;
		}
		else
		{
			if(loginID.indexOf("djmedi") != -1)
			{
				var url="stLoginId="+loginID+"&stDepart="+logDepart;
				console.log("url = " + url);
				$("input[name='stPasswd']").val("123123");
				callapi('GET','member','staffdepartupdate',url);
			}
			else
			{
				layersign('warning', '다른작업자는 하실수 없습니다.', '','2000'); //아이디를 입력해주세요.
				$("input[name='stLoginId']").val("");
				$("input[name='stLoginId']").focus();
			}
		}

	}
*/
	//아이디 입력창에서 엔터키
	$("#stLoginId").keydown(function(e)
	{
		if(e.keyCode==13)
		{
			var logID=$("input[name='stLoginId']").val();
			var logLen=logID.length;
			if(logID.indexOf("MEM")!=-1 && logLen>=10)
			{
				console.log("stLoginId keydown login");
				login_nopass();
			}

		}
	});

	//패스워드 입력창에서 엔터키
	$(".input-pass").keydown(function(e)
	{
		if(e.keyCode==13)
		{
			console.log("input-pass keydown login");
			login();
		}
	});

	
	function id_check()
	{
		var id=$("input[name=stLoginId]").val();	
		var apidata = "stLoginId="+id;
		callapi('GET','member','loginidchk',apidata);
		return false;		
	}


	//로그인 아이디 값이 16자 이상이거나 MEI,MDB+5자 이상이면 clear, focus
	function keyup()
	{
		var logID=$("input[name='stLoginId']").val();
		var logLen=logID.length;
		if(logID.indexOf("MEM")!=-1 && logLen>=10)
		{
			id_check();
			setTimeout(play,100); 
		}
	}
	function play()
	{
		var MeiMdbchk = document.getElementById("stLoginId").value;
		var textchk1 = MeiMdbchk.indexOf("MEI");
		var textchk2 = MeiMdbchk.indexOf("MDB");
		var textchk3 = MeiMdbchk.indexOf("mei");
		var textchk4 = MeiMdbchk.indexOf("mdb");

		if(MeiMdbchk.length>=16)
		{
			document.getElementById("stLoginId").focus();
			document.getElementById("stLoginId").value = "";
			return false;
		}

		if((textchk1 > -1)||(textchk2 > -1)||(textchk3 > -1)||(textchk4 > -1))		
		{
			document.getElementById("stLoginId").focus();
			document.getElementById("stLoginId").value = "";
			return false;
		}
	}
	//한의원 사이트 가기 
	function go_medical()
	{
		alert("준비중입니다.");
	}
	//아이디/비밀번호 찾기 
	function go_idpwd()
	{
		alert("준비중입니다.");
	}
	//로그인 버튼 
	function login_nopass()
	{
		//staff_login
		if(!$("input[name='stLoginId']").val())
		{
			layersign('warning', getTxtData("INFONO"), '<?=$txtdt["loginid"]?>','2000'); //아이디를 입력해주세요.
			$("input[name='stLoginId']").focus();
			return false;
		}

		//로그인 API
		var key=data="";
		var jsondata={};
		$(".reqdata").each(function()
		{
			key=$(this).attr("name");
			data=$(this).val();
			jsondata[key] = data;
		});

		jsondata["NetLive"] = getUrlData("LIVE");
		jsondata["nopasschk"] = 0;
		
		console.log(JSON.stringify(jsondata));
		callapi('POST','member','stafflogin',jsondata);

	}

	//로그인 버튼 
	function login()
	{
		//staff_login
		if(!$("input[name='stLoginId']").val())
		{
			layersign('warning', getTxtData("INFONO"), '<?=$txtdt["loginid"]?>','2000'); //아이디를 입력해주세요.
			$("input[name='stLoginId']").focus();
			return false;
		}
		if(!$("input[name='stPasswd']").val())
		{
			layersign('warning', getTxtData("INFONO"), '<?=$txtdt["loginpwd"]?>','2000'); //비밀번호를 입력해주세요.
			$("input[name='stPasswd']").focus();
			return false;
		}

		//로그인 API
		var key=data="";
		var jsondata={};
		$(".reqdata").each(function()
		{
			key=$(this).attr("name");
			data=$(this).val();
			jsondata[key] = data;
		});

		jsondata["NetLive"] = getUrlData("LIVE");
		jsondata["nopasschk"] = 1;
		
		console.log(JSON.stringify(jsondata));
		callapi('POST','member','stafflogin',jsondata);

	}

	function makepage(json)
	{
		var obj = JSON.parse(json);
		console.log(obj);
		if (obj["apiCode"]=="loginidchk")
		{
			if(obj["resultCode"] == "200")   //비번 pass
			{
				//console.log("바코드로 찍으면 패스");
				//$("input[name=stPasswd]").val("123123"); 

				//아이디 입력창에서 엔터키
				$("#stLoginId").keydown(function(e)
				{
					if(e.keyCode==13)
					{
						console.log("makepage stLoginId keydown login");
						login_nopass();
					}
				});

			}
			else  //비번 받기
			{
				console.log("아이디로 로그인할때는 비번입력");
				$("input[name=stPasswd]").val(""); 
			}
			return false;
		}
	}

</script>