<?php
	$root = "..";
	include_once $root."/_common.php";
?>

<!-- modal 탈퇴하기 -->
<div class="modal" id="modal-withdraw">
    <div class="modal__bg"></div>
    <div class="modal__content">
        <div class="withdraw">
		<button class="modal-closeBtn" onclick="moremove('modal-withdraw');"></button>
            <div class="modal__head">탈퇴안내</div>
            <div class="modal__body">
                <div class="txtBox">
                    <p>
                        회원탈퇴를 신청하기 전에 안내 사항을 꼭 확인해주세요.
                    </p>
                    <p>
                        · 사용하고 계신 아이디는 탈퇴할 경우 재사용이 및 복구가 불가능합니다.<br/>
                        탈퇴한 아이디는 본인과 타인 모두 재사용 및 복구가 불가능 하오니<br/>
                        신중하게 선택하시기 바랍니다.
                    </p>
                    <p>
                        · 탈퇴 후 회원정보 및 개인형 서비스 이용기록은 모두 삭제됩니다.<br/>
                        회원정보 및 주문내역, 처방내역, 환자관리 등 개인형 서비스 이용기록은 모두 삭제되며,<br/>
                        삭제된 데이터는 복구되지 않습니다.<br/>
                        삭제되는 내용을 확인하시고 필요한 데이터는 미리 백업을 해주세요. 
                    </p>
                    <p class="warning">
                        탈퇴 후에는 같은 아이디로 다시 가입할 수 없으며<br/>
                        아이디와 데이터는 복구할 수 없습니다.
                    </p>
                </div>
                <form action="">
                    <div class="form">
                        <div class="inp-checkBox d-flex">
                            <div class="inp inp-check">
                                <label for="d1" class="d-flex">
                                    <input type="checkbox" name="d1" id="d1" class="blind">
                                    <span></span>안내 사항을 모두 확인하였으며, 이에 동의합니다.
                                </label>
                            </div>
                        </div>
                        <div class="btnBox d-flex">
                            <a href="javascript:;" class="d-flex btn border-blue color-blue radius" onclick="moremove('modal-withdraw');">취소</a>
                            <a href="javascript:;" class="d-flex btn bg-blue color-white radius" onclick="dowithdraw();">확인</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>