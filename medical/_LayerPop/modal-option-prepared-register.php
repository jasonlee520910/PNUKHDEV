<?php
	$root = "..";
	include_once $root."/_common.php";
?>

<!-- modal 조제지시 등록하기 -->
<div class="modal" id="modal-option-prepared-register">
    <div class="modal__bg"></div>
    <div class="modal__content pd0 pd-modify">
		<button class="modal-closeBtn" onclick="moremove('modal-option-prepared-register');"></button>
        <div class="option-prepared m-file">
            <div class="modal__head--type2 d-flex">조제지시 등록</div>
            <div class="modal__body">
                <div class="tit">
                    <div class="inp inp-input inp-radius">
                        <input type="text" name="mdTitle" id="mdTitle" placeholder="제목을 입력해주세요." maxlength="50" class="ajaxdata">
                    </div>
                </div>
                <div class="body">
                    <div class="inp inp-textarea">
                        <textarea name="mdContents" id="mdContents" placeholder="내용을 입력해주세요." class="ajaxdata"></textarea>
                    </div>
                </div>
                <div class="btnBox d-flex">
                    <a href="javascript:moremove('modal-option-prepared-register','');" class="d-flex btn color-gray">취소</a>
                    <a href="javascript:commentupdate();" class="d-flex btn color-blue">등록</a>
                </div>
            </div>
        </div>
    </div>
</div>