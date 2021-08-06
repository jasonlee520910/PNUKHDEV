<?php
	$root = "..";
	include_once $root."/_common.php";
?>


<!-- modal 복용지시 수정-->
<div class="modal" id="modal-option-dose-modify">
    <div class="modal__bg"></div>
    <div class="modal__content pd0 pd-modify">
        <div class="option-dose m-file">
            <div class="modal__head--type2 d-flex">복용지시 수정</div>
            <div class="modal__body">
                <div class="item">
                    <div class="inp-inputBox d-flex">
                        <p class="d-flex dose-tit">
                            제목
							<input type="hidden" name="mdSeq" class="ajaxdata">
                            <span class="bar">|</span>
                        </p>
                        <div class="inp inp-input">
                            <input type="text" placeholder="">
                        </div>
                    </div>
                    <!-- <p class="warning-message">제목을 입력해주세요.</p> -->
                </div>
                <div class="item">
                    <div class="fileBox">
                        <div class="inp-file d-flex file-custom">
                            <label for="fu1">
                                파일첨부
                                <input type="file" name="" id="fu1" class="blind upload-file">
                            </label>
                            <input type="text" value="선택된 파일 없음" class="upload-name" disabled="disabled">
                            <button class="file-delete"></button>
                        </div>
                        <div class="inp-file-memory">
                            최대용량 10MB (docx, doc, hwp, pdf) 첨부 가능합니다.
                        </div>
                    </div>
                    <!-- <p class="warning-message">파일첨부를 해주세요.</p> -->
                </div>

                <div class="btnBox d-flex">
                    <a href="javascript:moremove('modal-option-dose-modify','');" class="d-flex btn color-gray">취소</a>
                    <!-- <a href="javascript:adviceupdate();" class="d-flex btn color-blue">수정</a> -->
                </div>
            </div>
        </div>
    </div>
</div>
