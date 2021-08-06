<?php
	$root = "..";
	include_once $root."/_common.php";
?>

<!-- modal 조제지시 등록하기 -->
<div class="modal" id="modal-option-prepared">
    <div class="modal__bg"></div>
    <div class="modal__content pd0 pd-modify">
        <div class="option-prepared m-file">
            <div class="modal__head--type2 d-flex">조제지시</div>
            <div class="modal__body">
                <div class="board">
					<input type="hidden" name="mdSeq" class="ajaxdata">
                    <div class="board__tit" id="opTitle"></div>
                    <div class="board__cont">						
                        <p id="opContens">
                            
                        </p>
                    </div>
                </div>
                <div class="btnBox d-flex">
                    <a href="javascript:moremove('modal-option-prepared','');" class="d-flex btn color-gray">취소</a>
                    <a href="javascript:commentdelete();" class="d-flex btn color-gray" >삭제</a>
                    <a href="javascript:commentreupdate();" class="d-flex btn color-blue">수정</a>
                </div>
            </div>
        </div>
    </div>
</div>