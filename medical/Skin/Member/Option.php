<?php
	$root="../..";
	include_once $root."/_common.php";
?>

<div class="container">
    <div class="sub member-info member-info-5">
        <div class="sub__title sub__title--tab d-flex">
            <div class="wrap d-flex">
                <h2>회원정보</h2>
                <div class="tab d-flex">
					<?=viewmembertab("option");?>
                </div>
            </div>
        </div>
        <div class="sub__content">
            <div class="sub__section">
                <div class="wrap">
                    <div class="sub__item">
                        <div class="table__box">
                            <div class="table__tit">복용지시</div>
                            <div class="table table--list">
                                <table id="advicetbl">
                                    <colgroup>
                                        <col>
                                    </colgroup>
                                    <thead>
                                        <!-- <tr>
                                            <td class="td-txtLeft">
                                                <a href="javascript:;">
                                                    <div class="td-inner d-flex">
                                                        복용시 주의사항
                                                        <a href="javascript:;" class="attached-file has-file" onclick="showModal('modal-option-dose-download'); return false;"></a>
                                                    </div>
                                                </a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="td-txtLeft">
                                                <a href="javascript:;">
                                                    <div class="td-inner d-flex">
                                                        복용 시 참고해야 할 사항
                                                        <a href="javascript:;" class="attached-file"></a>
                                                    </div>
                                                </a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="td-txtLeft">
                                                <a href="javascript:;">
                                                    <div class="td-inner d-flex">
                                                        열이 많은 사람들을 위한 주의사항
                                                        <a href="javascript:;" class="attached-file"></a>
                                                    </div>
                                                </a>
                                            </td>
                                        </tr>
                                        <td class="td-txtLeft">
                                            <a href="javascript:;">
                                                <div class="td-inner d-flex">
                                                    1일 3회 복용
                                                    <a href="javascript:;" class="attached-file has-file" onclick="showModal('modal-option-dose-download'); return false;"></a>
                                                </div>
                                            </a>
                                        </td>
                                        <tr>
                                            <td class="td-txtLeft">
                                                <a href="javascript:;">
                                                    <div class="td-inner d-flex">
                                                        복용 시 참고해야 할 사항
                                                        <a href="javascript:;" class="attached-file"></a>
                                                    </div>
                                                </a>
                                            </td>
                                        </tr> -->
                                    </thead>
									<tbody>
									</tbody>
                                </table>
                            </div>
                        </div>
                        <div class="btnBox d-flex">
                            <a href="javascript:goAdviceUpload();" class="d-flex btn btn--small border-rightGray color-gray radius">파일등록</a>
                        </div>
                    </div>
                <div class="sub__item">
                        <div class="table__box">
                            <div class="table__tit">조제지시</div>
                            <div class="table table--list">
                                <table id="commenttbl">
                                    <colgroup>
                                        <col>
                                    </colgroup>
                                    <thead>
                                    </thead>
									<tbody>
									</tbody>
                                </table>
                            </div>
                        </div>
                        <div class="btnBox d-flex">
                            <a href="javascript:goCommentUpload();" class="d-flex btn btn--small border-rightGray color-gray radius">등록하기</a>
                        </div>
                    </div>
<!--                     <div class="sub__item">
                        <div class="table table--list choice">
                            <table>
                                <colgroup>
                                    <col width="300px">
                                    <col>
                                </colgroup>
                                <tbody>
                                    <tr>
                                        <th class="th-txtLeft">한 돈의 용량</th>
                                        <td class="td-txtLeft">
                                            <div class="inp-radioBox d-flex">
                                                <div class="inp inp-radio">
                                                    <label for="r0" class="d-flex">
                                                        <input type="radio" name="r1" id="r0" class="blind">
                                                        <span></span>4g
                                                    </label>
                                                </div>
                                                <div class="inp inp-radio">
                                                    <label for="r2" class="d-flex">
                                                        <input type="radio" name="r1" id="r2" class="blind">
                                                        <span></span>3.75g
                                                    </label>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="th-txtLeft">약재 선택 기준</th>
                                        <td class="td-txtLeft">
                                            <div class="inp-radioBox d-flex">
                                                <div class="inp inp-radio">
                                                    <label for="c0" class="d-flex">
                                                        <input type="radio" name="d1" id="c0" class="blind">
                                                        <span></span>품질
                                                    </label>
                                                </div>
                                                <div class="inp inp-radio">
                                                    <label for="c2" class="d-flex">
                                                        <input type="radio" name="d1" id="c2" class="blind">
                                                        <span></span>가격
                                                    </label>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div> -->
<!--                     <div class="btnBox d-flex">
                        <a href="javascript:;" class="d-flex btn btn--small border-rightGray color-gray radius">확인</a>
                    </div> -->
                </div>
            </div>
        </div>
    </div>
</div>
<input type="hidden" name="mdType" id="mdType" placeholder="타입" maxlength="10" class="ajaxdata">