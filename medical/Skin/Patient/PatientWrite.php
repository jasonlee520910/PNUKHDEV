<?php
	$root="../..";
	include_once $root."/_common.php";
?>


<div class="container">
    <div class="sub patient-info">
        <div class="sub__content">
            <div class="sub__section sec1">
                <div class="wrap">
                    <div class="sub__body">
                        <div class="sub__item">
                            <div class="table__tit">환자정보</div>
                            <div class="table table--details">
                                <table>
                                    <colgroup>
                                        <col>
                                        <col>
                                        <col>
                                        <col>
                                    </colgroup>
                                    <tbody>
                                        <tr>
                                            <th>차트번호</th>
                                            <td>ABC-001</td>
                                            <th>환자명</th>
                                            <td>김일월</td>
                                        </tr>
                                        <tr>
                                            <th>성별</th>
                                            <td>여자</td>
                                            <th>생년월일</th>
                                            <td>만46세 / 1971년 02월 15일010-0000-1111</td>
                                        </tr>
                                        <tr>
                                            <th>연락처</th>
                                            <td>-</td>
                                            <th>휴대전화</th>
                                            <td>010-0000-1111</td>
                                        </tr>
                                        <tr>
                                            <th>주소</th>
                                            <td colspan="3">(11111) 서울시 강남구 논현로 000 대박빌라 1층</td>
                                        </tr>
                                        <tr>
                                            <th>최근처방정보</th>
                                            <td colspan="3">(2017-07-22) 팔보회춘탕손발이 차고 두통이 심함</td>
                                        </tr>
                                        <tr>
                                            <th>기타</th>
                                            <td colspan="3">손발이 차고 두통이 심함</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="btnBox">
                            <a href="javascript:;" class="d-flex btn border-rightGray color-gray">수정</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="sub__section sec2">
                <div class="wrap">
                    <div class="sub__body">
                        <div class="sub__item">
                            <div class="table__tit">처방내역</div>
                            <div class="table table--list">
                                <table>
                                    <colgroup>
                                        <col>
                                        <col>
                                        <col width="350px">
                                        <col>
                                        <col>
                                    </colgroup>
                                    <thead>
                                        <tr>
                                            <th>처방일시</th>
                                            <th>제형</th>
                                            <th>처방명</th>
                                            <th>팩수/팩용량</th>
                                            <th>금액</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>2017-02-18</td>
                                            <td>탕전</td>
                                            <td>
                                                <a href="javascript:;" class="chart__link" onclick="viewdesc('order');return false;">인삼황기탕</a>
                                            </td>
                                            <td>45팩/120ml</td>
                                            <td>250,000</td>
                                        </tr>
                                        <tr>
                                            <td>2017-02-18</td>
                                            <td>탕전</td>
                                            <td>
                                                <a href="javascript:;" class="chart__link" onclick="viewdesc('order');return false;">인삼황기탕</a>
                                            </td>
                                            <td>45팩/120ml</td>
                                            <td>250,000</td>
                                        </tr>
                                        <tr>
                                            <td>2017-02-18</td>
                                            <td>탕전</td>
                                            <td>
                                                <a href="javascript:;" class="chart__link" onclick="viewdesc('order');return false;">인삼황기탕</a>
                                            </td>
                                            <td>45팩/120ml</td>
                                            <td>250,000</td>
                                        </tr>
                                        <tr>
                                            <td>2017-02-18</td>
                                            <td>탕전</td>
                                            <td>
                                                <a href="javascript:;" class="chart__link" onclick="viewdesc('order');return false;">인삼황기탕</a>
                                            </td>
                                            <td>45팩/120ml</td>
                                            <td>250,000</td>
                                        </tr>
                                        <tr>
                                            <td>2017-02-18</td>
                                            <td>탕전</td>
                                            <td>
                                                <a href="javascript:;" class="chart__link" onclick="viewdesc('order');return false;">인삼황기탕</a>
                                            </td>
                                            <td>45팩/120ml</td>
                                            <td>250,000</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="paging d-flex">
                                <div class="paging__numBox d-flex">
                                    <a href="javascript:;" class="paging__num active">1</a>
                                    <a href="javascript:;" class="paging__num">2</a>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


