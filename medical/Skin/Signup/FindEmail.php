<?php
	$root="..";
	include_once $root."/_common.php";
?>


<div class="container">
    <div class="sub find find-pw">
        <div class="sub__content">
            <div class="sub__section">
                <div class="wrap">
                    <div class="sub__title find__title">
                        <h2>비밀번호 찾기</h2>
                        <p>회원정보에 등록한 이름과 이메일 주소가 일치해야 임시비밀번호를 발급받으실 수 있습니다. </p>
                    </div>
                    <div class="sub__body">
                        <form action="">
                            <div class="form">
                                <div class="form__row tf__row d-flex baseline"">
                                    <div class="form__col form__title">이름</div>
                                    <div class="form__col col-required">
                                        <div class="inp inp-input inp-radius">
                                            <input type="text" placeholder="이름 입력">
                                        </div>
                                    </div>
                                </div>
                                <div class="form__row tf__row d-flex baseline">
                                    <div class="form__col form__title">이메일</div>
                                    <div class="form__col col-required">
                                        <div class="col-group d-flex">
                                            <div class="col-auto col-auto--fst d-flex">
                                                <div class="inp inp-input email inp-radius">
                                                    <input type="text">
                                                </div>
                                                <span class="hyphen">@</span>
                                                <div class="inp inp-input email inp-radius">
                                                    <input type="text">
                                                </div>
                                            </div>
                                            <div class="col-auto col-auto--lst">
                                                <div class="inp inp-select inp-radius">
                                                    <select name="" id="">
                                                        <option value="">직접입력</option>
                                                        <option value="">직접입력</option>
                                                        <option value="">직접입력</option>
                                                        <option value="">직접입력</option>
                                                        <option value="">직접입력</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="btnBox btnBox--modify d-flex">
                    <a href="" class="d-flex btn color-white bg-blue radius">완료</a>
                </div>
            </div>
        </div>
    </div>
</div>


