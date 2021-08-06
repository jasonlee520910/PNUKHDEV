<?php  //결제취소하는 창
	$root = "..";
	include_once $root."/_common.php";

	$userId=!isEmpty($_COOKIE["ck_saveid"])?$_COOKIE["ck_saveid"]:"";
?>
<!-- modal 로그인-->
<div class="modal" id="modal-paycancle">
    <div class="modal__bg"></div>
    <div class="modal__content">
		<button class="modal-closeBtn" onclick="moremove('modal-paycancle');"></button>
        <div class="auth">
            <div class="modal__head">이 주문은 <?=$_GET["seq"];?> 하셨습니다.<br>취소하시겠습니까?</div>
            <div class="modal__body">
                <form action="">
                    <div class="form">
                        <div class="form__row">
                            <div class="btnBox d-flex">
                                <a href="javascript:;" class="d-flex btn bg-blue color-white btn--w100" onclick="ordercancle();">결제취소</a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
