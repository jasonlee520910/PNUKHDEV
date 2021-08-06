<!-- modal 약재/처방추가 -->
<div class="modal" id="modal-prescribe__medicine-add" style="display:none;">
    <div class="modal__bg"></div>
    <div class="modal__content pd0">
        <button class="modal-closeBtn" onclick="moremove('modal-prescribe__medicine-add');"></button>
        <div class="prescribe__medicine-add">
            <div class="modal__head--type2">
                약재/처방추가
            </div>
            <div class="modal__body">
                <div class="inp-searchBox">
                    <div class="inp inp-search d-flex">
                        <input type="text" placeholder="약재명, 처방명 입력">
                        <button class="inp-search__btn"></button>
                    </div>
                </div>
                <div class="tabBox">
                    <div class="tab__head d-flex">
                        <div class="tab__linkBox d-flex">
                            <a href="javascript:;" class="tab__link active" data-tab='1'>약재</a>
                            <a href="javascript:;" class="tab__link" data-tab='2'>처방</a>
                        </div>
                        <div class="tab__select">
                            <div class="inp inp-select inp-radius">
                                <select name="" id="">
                                    <option value="">주요상품</option>
                                    <option value="">가나다</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="tab__body">
                        <div class="tab__item" id="tab-item1">
                            <div class="tableBox">
                                <div class="table table--list">
                                    <table>
                                        <colgroup>
                                            <col width="170px">
                                            <col width="310px">
                                            <col>
                                            <col>
                                            <col>
                                        </colgroup>
                                        <thead>
                                            <tr>
                                                <th class="th-txtLeft">상품명</th>
                                                <th class="th-txtLeft">이명</th>
                                                <th>원산지</th>
                                                <th>단가</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
											<?php
												$tarr=array("가자(訶子)","갈근(葛根)","갈화(葛花)","감송향(甘松香)","감수(甘遂)","감실（芡實）","감인（芡仁）","감초(甘草)","강랑(蜣螂)","강매근(崗梅根)");
												$earr=array("가려륵, 가리륵","건갈, 감갈, 분갈","갈조화(葛條花); 칡; 칡꽃","감송, 향송","주전, 감택, 고택, 중택","감인(芡仁), 계두실(鷄頭實), 안훼실(雁喙實), 자연봉실(刺蓮蓬實), 수류황(水流黃), 수계두(水鷄頭)","감인(芡仁), 계두실(鷄頭實), 안훼실(雁喙實), 자연봉실(刺蓮蓬實), 수류황(水流黃), 수계두(水鷄頭)","미초(美草), 밀감(蜜甘), 국노(國老), 첨초(甛草), 밀초(蜜草), 영통(靈通), 영초(靈草), 분초(粉草）","야유장군(夜遊將軍), 흑우아(黑牛兒), 강랑(蜣蜋), 독각우(獨角牛), 추분충(推糞蟲)","매엽동청근(梅葉冬靑根)");
												$narr=array();
												$carr=array();
												for($i=0;$i<10;$i++){
											?>
												<tr>
													<td class="td-txtLeft">
														<a href="javascript:;"><?=$tarr[$i]?></a>
													</td>
													<td class="td-txtLeft">
														<p class="text-ellipsis"><?=$earr[$i]?></p>
													</td>
													<td>한국</td>
													<td>21</td>
													<td>
														<a href="javascript:;" class="d-flex btn btn--small border-rightGray color-gray">선택</a>
													</td>
												</tr>
											<?php }?>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="paging d-flex">
                                    <div class="paging__arrow d-flex">
                                        <a href="javascript:;" class="paging__btn paging__fst">처음</a>
                                        <a href="javascript:;" class="paging__btn paging__prev">이전</a>
                                    </div>
                                    <div class="paging__numBox d-flex">
                                        <a href="javascript:;" class="paging__num active">1</a>
                                        <a href="javascript:;" class="paging__num">2</a>
                                        <a href="javascript:;" class="paging__num">3</a>
                                        <a href="javascript:;" class="paging__num">4</a>
                                        <a href="javascript:;" class="paging__num">5</a>
                                        <a href="javascript:;" class="paging__num">6</a>
                                        <a href="javascript:;" class="paging__num">7</a>
                                        <a href="javascript:;" class="paging__num">8</a>
                                        <a href="javascript:;" class="paging__num">9</a>
                                    </div>
                                    <div class="paging__arrow d-flex">
                                        <a href="javascript:;" class="paging__btn paging__next">다음</a>
                                        <a href="javascript:;" class="paging__btn paging__lst">마지막</a>
                                    </div>
                                </div>
                            </div>

                            <div class="clearBox d-flex">
                                <div class="clear__list">
                                    <ul class="d-flex">
                                        <li class="d-flex">
                                            <span>감초</span>
                                            <button class="close"></button>
                                        </li>
                                        <li class="d-flex">
                                            <span>인삼</span>
                                            <button class="close"></button>
                                        </li>
                                    </ul>
                                </div>
                                <div class="clear__btn">
                                    <a href="javascript:moremove('modal-prescribe__medicine-add');" class="d-flex btn">적용</a>
                                </div>
                            </div>
                        </div>

                        <div class="tab__item" id="tab-item2" style="display:none;">
                            <div class="tableBox">
                                <div class="table table--list">
                                    <table>
                                        <colgroup>
                                            <col width="250px">
                                            <col width="310px">
                                            <col>
                                            <col>
                                        </colgroup>
                                        <thead>
                                            <tr>
                                                <th class="th-txtLeft">출전</th>
                                                <th class="th-txtLeft">방제명</th>
                                                <th>약재</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td class="td-txtLeft">
                                                    <p class="text-ellipsis">방약합편 上統, 동의보감 血방약합편 上統, 동의보감 血</p>
                                                </td>
                                                <td class="td-txtLeft">
                                                    <p class="text-ellipsis">
                                                        <a href="javascript:;">가감위령탕 加減胃笭湯</a>
                                                    </p>
                                                </td>
                                                <td>21</td>
                                                <td>
                                                    <a href="javascript:;" class="d-flex btn btn--small border-rightGray color-gray">선택</a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="td-txtLeft">
                                                    <p class="text-ellipsis">방약합편 上統, 동의보감 血방약합편 上統, 동의보감 血</p>
                                                </td>
                                                <td class="td-txtLeft">
                                                    <p class="text-ellipsis">
                                                        <a href="javascript:;">가감위령탕 加減胃笭湯</a>
                                                    </p>
                                                </td>
                                                <td>21</td>
                                                <td>
                                                    <a href="javascript:;" class="d-flex btn btn--small border-rightGray color-gray">선택</a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="td-txtLeft">
                                                    <p class="text-ellipsis">방약합편 上統, 동의보감 血방약합편 上統, 동의보감 血</p>
                                                </td>
                                                <td class="td-txtLeft">
                                                    <p class="text-ellipsis">
                                                        <a href="javascript:;">가감위령탕 加減胃笭湯</a>
                                                    </p>
                                                </td>
                                                <td>21</td>
                                                <td>
                                                    <a href="javascript:;" class="d-flex btn btn--small border-rightGray color-gray">선택</a>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="paging d-flex">
                                    <div class="paging__arrow d-flex">
                                        <a href="javascript:;" class="paging__btn paging__fst">처음</a>
                                        <a href="javascript:;" class="paging__btn paging__prev">이전</a>
                                    </div>
                                    <div class="paging__numBox d-flex">
                                        <a href="javascript:;" class="paging__num active">1</a>
                                        <a href="javascript:;" class="paging__num">2</a>
                                        <a href="javascript:;" class="paging__num">3</a>
                                        <a href="javascript:;" class="paging__num">4</a>
                                        <a href="javascript:;" class="paging__num">5</a>
                                        <a href="javascript:;" class="paging__num">6</a>
                                        <a href="javascript:;" class="paging__num">7</a>
                                        <a href="javascript:;" class="paging__num">8</a>
                                        <a href="javascript:;" class="paging__num">9</a>
                                    </div>
                                    <div class="paging__arrow d-flex">
                                        <a href="javascript:;" class="paging__btn paging__next">다음</a>
                                        <a href="javascript:;" class="paging__btn paging__lst">마지막</a>
                                    </div>
                                </div>
                            </div>

                            <div class="clearBox d-flex">
                                <div class="clear__list">
                                    <ul class="d-flex">
                                        <li class="d-flex">
                                            <span>감초</span>
                                            <button class="close"></button>
                                        </li>
                                        <li class="d-flex">
                                            <span>인삼</span>
                                            <button class="close"></button>
                                        </li>
                                    </ul>
                                </div>
                                <div class="clear__btn">
                                    <a href="javascript:;" class="d-flex btn">적용</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
