<?php
	$root = "..";
	include_once $root."/_common.php";

	$userId=!isEmpty($_COOKIE["ck_saveid"])?$_COOKIE["ck_saveid"]:"";
?>
<!-- modal 로그인-->
<div class="modal" id="modal-login">
    <div class="modal__bg"></div>
    <div class="modal__content">
		<button class="modal-closeBtn" onclick="hiddenModal('modal-login');"></button>
        <div class="auth">
            <div class="modal__head">로그인</div>
            <div class="modal__body">
                <form action="">
                    <div class="form">
                        <div class="form__row">
                            <div class="inp inp-input inp-radius">
                                <input type="text" placeholder="아이디" id="userID" name="userID" value="<?=$userId?>" class="ajaxdata">
                            </div>
                            <div class="inp inp-input inp-radius inp-warning">
                                <input type="password" placeholder="비밀번호" id="userPWD" name="userPWD" value="" class="ajaxdata" onkeydown="if(event.keyCode==13)login();">
                            </div>
                            <p class="warning-message"></p>
                        </div>
                        <div class="form__row">
                            <div class="inp inp-check">
                                <label for="c1" class="d-flex">
                                    <input type="checkbox" name="saveid" id="c1" class="ajaxdata blind" <?php if($_COOKIE["ck_saveid"]!="")echo "checked";?>>
                                    <span></span>아이디 저장
                                </label>
                            </div>
                        </div>
                        <div class="form__row">
                            <div class="btnBox d-flex">
                                <a href="javascript:;" class="d-flex btn bg-blue color-white btn--w100" onclick="login();">로그인</a>
                            </div>
                        </div>
                        <div class="form__row d-flex">
                            <a href="javascript:;" class="auth__link" onclick="location.href='/Signup/Join.php'" >회원가입</a>
                            <span class="bar">|</span>
                            <a href="javascript:;" class="auth__link" onclick="location.href='/Signup/FindID.php'" >아이디 찾기</a>
                            <span class="bar">|</span>
                            <a href="javascript:;" class="auth__link" onclick="location.href='/Signup/FindPW.php'" >비밀번호 찾기</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
