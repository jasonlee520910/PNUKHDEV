<?php
	$root="..";
	include_once $root."/_common.php";
	$arr=explode("=",$_COOKIE["findinfo"]);
	$findcode=$arr[0];
	$finddata=$arr[1];
	switch($findcode){
		case "findid":
			$txt="아이디를 찾았습니다.";
			$link="<a href='/Signup/FindPW.php' class='d-flex btn bg-blue color-white radius'>비밀번호찾기</a>";
			break;
		case "findpw":
			$txt="임시 비밀번호가 이메일로 전송되었습니다.";
			$link="<a href=\"javascript:showModal('modal-login');\" class='d-flex btn bg-blue color-white radius'>로그인하기</a>";
			break;
		default:
			//echo "<script>top.location.href='/'</script>";
	}
?>


<div class="container">
    <div class="sub join-complete">
        <div class="sub__content">
            <div class="sub__section">
                <div class="wrap">
                    <h2><?=$finddata?></h2>
                    <h3><?=$txt?></h3>

                    <div class="btnBox">
                       <?=$link?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
	var findinfo=getCookie("findinfo");
	if(findinfo==""){
		top.location.href="/";
	}else{
		deleteCookie("findinfo");
	}
</script>

