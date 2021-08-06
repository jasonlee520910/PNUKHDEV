<?php
	$root = "..";
	include_once $root."/_common.php";
?>

<!-- modal 조제지시 수정하기 -->
<div class="modal" id="modal-option-prepared-modify">
    <div class="modal__bg"></div>
    <div class="modal__content pd0 pd-modify">
        <div class="option-prepared m-file">
            <div class="modal__head--type2 d-flex">조제지시 수정</div>
            <div class="modal__body">
                <div class="tit">
                    <div class="inp inp-input inp-radius">
						<input type="hidden" name="mdSeq" class="ajaxdata">
                        <input type="text" name="mdTitle" maxlength="50" class="ajaxdata">
                    </div>
                </div>
                <div class="body">
                    <div class="inp inp-textarea">
                        <textarea name="mdContents" class="ajaxdata"></textarea>
                    </div>
                </div>
                <div class="btnBox d-flex">
                    <a href="javascript:moremove('modal-option-prepared-modify','');" class="d-flex btn color-gray">취소</a>
                    <a href="javascript:commentupdate();" class="d-flex btn color-blue">수정</a>
                </div>
            </div>
        </div>
    </div>
</div>