<?php
	$root = "..";
	include_once $root."/_common.php";

	$userId=!isEmpty($_COOKIE["ck_saveid"])?$_COOKIE["ck_saveid"]:"";
?>
<!-- modal 로그인-->
<div class="modal" id="modal-changepass">
    <div class="modal__bg"></div>
    <div class="modal__content">
		<button class="modal-closeBtn" onclick="moremove('modal-changepass');"></button>
        <div class="auth">
            <div class="modal__head">비밀번호 변경</div>
            <div class="modal__body">
                <form action="">
                    <div class="form">
                        <div class="form__row">
                            <div class="inp inp-input inp-radius">
                                <input type="password" placeholder="현재 비밀번호" id="addpasswordDiv" name="addpasswordDiv" value="" class="ajaxdata" onblur="passchk()">
                            </div>
                            <div class="inp inp-input inp-radius inp-warning">
                                <input type="password" placeholder="새 비밀번호" id="newpass" name="newpass" value="" class="ajaxdata" onkeyup="password_check()">
                            </div>
							<div class="inp-error" id="passwordchk" style="min-height:15px;">
								비밀번호는 9자리이상 문자,숫자,특수문자로 구성하세요
							</div>
							<div style="height:10px;clear:both;display:block;"> </div>
                            <div class="inp inp-input inp-radius inp-warning">
                                <input type="password" placeholder="새 비밀번호 확인" id="renewpass" name="renewpass" value="" class="ajaxdata" onkeyup="password_check()">
                            </div>
						   <div class="inp-error" id="passwordchk2" style="min-height:15px;">						
						   </div>                        
                        </div>
						<div style="height:40px;clear:both;display:block;"> </div>

                        <div class="form__row">
                            <div class="btnBox d-flex">
                                <a href="javascript:;" class="d-flex btn bg-blue color-white btn--w100" onclick="passupdate();">확인</a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
