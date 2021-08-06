<?php
	$root = "..";
	include_once $root."/_common.php";
?>

<!-- modal 수정하기 //내정보 수정하기  -->
<div class="modal" id="modal-member-info" data-type="">
    <div class="modal__bg"></div>
    <div class="modal__content pd0">
		<button class="modal-closeBtn" onclick="moremove('modal-member-info');"></button>
		<div class="m-member-info m-file pd-modify">
            <div class="modal__head--type2 d-flex">
                회원님의 정보를 안전하게 보호하기<br/>
                위해 비밀번호를 다시 한번 입력해주세요. 
            </div>
            <div class="modal__body">
                <div class="inp inp-input inp-radius">
                    <input type="password" name="addpasswordDiv" placeholder="비밀번호를 입력해주세요" class="ajaxdata" onkeydown="passwdKeydown(event,this);">
                </div>

                <div class="btnBox d-flex">
                    <a href="javascript:;" class="d-flex btn color-gray" onclick="moremove('modal-member-info');">취소</a>
                    <a href="javascript:;" class="d-flex btn color-blue" onclick="chkpwd();">확인</a>
                </div>
            </div>
        </div>
    </div>
</div>