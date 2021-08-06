<?php
	$root="..";
	include_once $root."/_Inc/head.php";
?>


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
                        <div class="table__tit">의료기관정보</div>
                        <div class="table table--details">
                            <table>
                                <colgroup>
                                    <col>
                                    <col>
                                </colgroup>
                                <tbody>
                                    <tr>
                                        <th>의료기관명</th>
                                        <td>튼튼한의원</td>
                                    </tr>
                                    <tr>
                                        <th>사업자번호</th>
                                        <td>123-45-6789</td>
                                    </tr>
                                    <tr>
                                        <th>대표자명</th>
                                        <td>김일월</td>
                                    </tr>
                                    <tr>
                                        <th>사업장소재지</th>
                                        <td>(11111) 서울시 강남구 논현로 000 대박빌라 1층</td>
                                    </tr>
                                    <tr>
                                        <th>팩스번호</th>
                                        <td>
                                            <div class="form__col">
                                                <div class="col-auto col-auto--fst d-flex">
                                                    <div class="inp inp-input phone-num license inp-radius">
                                                        <input type="text">
                                                    </div>
                                                    <span class="hyphen">-</span>
                                                    <div class="inp inp-input phone-num license inp-radius">
                                                        <input type="text">
                                                    </div>
                                                    <span class="hyphen">-</span>
                                                    <div class="inp inp-input phone-num license inp-radius">
                                                        <input type="text">
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>세금계산서</th>
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
                                </tbody>
                            </table>
                        </div>
                        <div class="bBox d-flex">
                            <div class="txt d-flex">
                                <span>*</span>
                                의료기관정보 변경을 원할 시에는 아래 팩스로 관련 서류를 보내주시길 바랍니다.<br/>
                                팩스 : 02-1234-4567
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
</div>

<?php
   include_once $root."/_Inc/tail.php"; ?>
