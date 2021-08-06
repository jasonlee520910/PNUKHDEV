<?php
	$root="..";
	include_once $root."/_Inc/head.php";
?>

<!-- modal 비밀번호 변경 -->
<div class="modal" id="modal-member-info-pw" style="display:none;">
    <div class="modal__bg"></div>
    <div class="modal__content pd0">
        <div class="m-member-info-2 m-file pd-modify">
            <div class="modal__head--type2 d-flex">비밀번호 변경</div>
            <div class="modal__body">
                <div class="form">
                    <div class="form__row">
                        <div class="inp inp-input">
                            <input type="password" placeholder="현재 비밀번호 입력">
                        </div>
                    </div>
                    <div class="form__rowBox">
                        <div class="form__row">
                            <div class="inp inp-input">
                                <input type="password" placeholder="새 비밀번호 입력">
                            </div>
                        </div>
                        <div class="form__row">
                            <div class="inp inp-input">
                                <input type="password" placeholder="새 비밀번호 확인 입력">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="btnBox d-flex">
                    <a href="" class="d-flex btn color-gray">취소</a>
                    <a href="" class="d-flex btn color-blue">확인</a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- modal 휴대전화 변경 -->
<div class="modal" id="modal-member-info-phone" style="display:none;">
    <div class="modal__bg"></div>
    <div class="modal__content pd0">
        <div class="m-member-info-2 m-member-info-2--phone m-file pd-modify">
            <div class="modal__head--type2 d-flex">휴대전화 번호 변경</div>
            <div class="modal__body">
                <div class="form">
                    <div class="form__col col-required">
                        <div class="col-group d-flex">
                            <div class="col-auto col-auto--phone d-flex">
                                <div class="inp inp-input phone-num inp-radius">
                                    <input type="text">
                                </div>
                                <span class="hyphen">-</span>
                                <div class="inp inp-input phone-num inp-radius">
                                    <input type="text">
                                </div>
                                <span class="hyphen">-</span>
                                <div class="inp inp-input phone-num inp-radius">
                                    <input type="text">
                                </div>
                            </div>
                            <div class="col-auto">
                                <div class="btnBox certification">
                                    <a href="" class="d-flex btn border-blue color-blue radius">인증번호 받기</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-group d-flex">
                            <div class="col-auto">
                                <div class="inp inp-input inp-radius">
                                    <input type="text" placeholder="인증번호 6자리 숫자 입력">
                                </div>
                            </div>
                            <div class="col-auto">
                                <div class="btnBox certification">
                                    <a href="" class="d-flex btn border-blue color-blue radius">인증하기</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                </div>

                <div class="btnBox d-flex">
                    <a href="" class="d-flex btn color-gray">취소</a>
                    <a href="" class="d-flex btn color-blue">확인</a>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="container">
    <div class="sub member-info">
        <div class="sub__title sub__title--left">
            <div class="wrap d-flex">
                정보관리
            </div>
        </div>
        <div class="sub__content">
            <div class="sub__section">
                <div class="wrap">
                    <div class="sub__item">
                        <div class="table__tit">내 정보</div>
                        <div class="table table--details">
                            <table>
                                <colgroup>
                                    <col>
                                    <col>
                                </colgroup>
                                <tbody>
                                    <tr>
                                        <th>이름</th>
                                        <td>김일월</td>
                                    </tr>
                                    <tr>
                                        <th>아이디</th>
                                        <td>aaa0001</td>
                                    </tr>
                                    <tr>
                                        <th>비밀번호</th>
                                        <td>
                                            <div class="btnBox">
                                                <a href="#//" class="d-flex btn btn--small border-rightGray color-gray" onclick="showModal('modal-member-info-pw'); return false;">변경하기</a>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th rowspan="2" class="vertical">휴대전화</th>
                                        <td>
                                            <div class="td-inner d-flex">
                                                010-1111-1111
                                                <div class="btnBox">
                                                    <a href="#//" class="d-flex btn btn--small border-rightGray color-gray" onclick="showModal('modal-member-info-phone'); return false;">변경하기</a>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="inp-checkBox d-flex">
                                                <div class="inp inp-check">
                                                    <label for="s1" class="d-flex">
                                                        <input type="checkbox" name="" id="s1" class="blind">
                                                        <span></span>사이트 이용관련 안내 SMS 수신
                                                    </label>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th rowspan="2" class="vertical">이메일</th>
                                        <td>
                                            <div class="form__col">
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
                                                                <option value="">naver.com</option>
                                                                <option value="">naver.com</option>
                                                                <option value="">naver.com</option>
                                                                <option value="">naver.com</option>
                                                                <option value="">naver.com</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="inp-checkBox d-flex">
                                                <div class="inp inp-check">
                                                    <label for="z1" class="d-flex">
                                                        <input type="checkbox" name="" id="z1" class="blind">
                                                        <span></span>사이트 이용관련 안내 이메일 수신
                                                    </label>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>면허번호</th>
                                        <td>12345</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="btnBox d-flex">
                            <a href="" class="d-flex btn btn--small border-rightGray color-gray">취소</a>
                            <a href="" class="d-flex btn btn--small border-rightGray color-gray">수정하기</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
   include_once $root."/_Inc/tail.php"; ?>
