<?php
	$root = "..";
	include_once $root."/_common.php";
?>

<!-- modal 복용지시 -->
<div class="modal" id="modal-option-dose-download">
    <div class="modal__bg"></div>
    <div class="modal__content pd0 pd-modify">
        <div class="option-dose m-file">
            <div class="modal__head--type2 d-flex">복용지시</div>
            <div class="modal__body">
                <div class="d-flex dose-tit dose-tit--down">
                    제목
					<input type="hidden" name="mdSeq" class="ajaxdata">
                    <span class="bar">|</span>
                    <span id="adTitle"></span>
                </div>
                <div class="dose-file d-flex">
                    <span id="adFileName">환자복용지시파일.pdf</span>
                    <a href="" class="dose-file-down" id="adFile">
                        <img src="<?=$root?>/assets/images/icon/file-down.png" alt="">
                    </a>
                </div>

                <div class="btnBox d-flex">
                    <a href="javascript:moremove('modal-option-dose-download','');" class="d-flex btn color-gray">취소</a>
                    <a href="javascript:advicedelete();" class="d-flex btn color-gray">삭제</a>
                    <!-- <a href="javascript:advicereupdate();" class="d-flex btn color-blue">수정</a> -->
                </div>
            </div>
        </div>
    </div>
</div>