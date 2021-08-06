<?php
	$root="../..";
	include_once $root."/_common.php";
?>


<div class="container">
    <div class="sub admin admin-cart">
        <div class="sub__title sub__title--left d-flex">
            <div class="wrap d-flex">
                결제하기
            </div>
        </div>
        <div class="sub__content">
            <div class="sub__section">
                <div class="wrap">
                    <div class="tableBox">
                        <div class="table__item">
                            <div class="table table--list">
                                <table>
                                    <colgroup>
                                        <col width="80px">
                                        <col>
                                        <col width="200px">
                                        <col width="50px">
                                        <col>
                                        <col>
                                        <col>
                                        <col>
                                        <col>
                                    </colgroup>
                                    <thead>
                                        <tr>
                                            <th>제형</th>
                                            <th>담당한의사</th>
                                            <th class="th-txtLeft">주문상품정보</th>
                                            <th>수량</th>
                                            <th>상품금액</th>
                                            <th>조제비</th>
                                            <th>배송비</th>
                                            <th>환자명</th>
                                            <th>처방일자</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>실속</td>
                                            <td>이상건</td>
                                            <td class="td-txtLeft">
                                                <div class="cart-inner d-flex">
                                                    <p class="text-ellipsis">[자보베스트] 당귀수산[자보베스트] 당귀수산</p>
                                                    <span class="out-of-stock">품절</span>
                                                </div>
                                            </td>
                                            <td>1</td>
                                            <td class="blue">22,304</td>
                                            <td>7,400</td>
                                            <td>4,000</td>
                                            <td>
                                                <a href="" class="order-info">이영직</a>
                                            </td>
                                            <td>
                                                <div class="cart-data">
                                                    <p>2020-02-18 18:6</p>
                                                    <div class="btnBox cart-detail">
                                                        <a href="" class="d-flex btn btn--small bg-blue color-white cart-detail-btn">상세보기</a>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
							<script>
								function cancelok(){
									if(!confirm("취소하시겠습니까?"))return;
								}
								function paymentok(){
									if(!confirm("결제하시겠습니까?"))return;
								}

							</script>
                        </div>
                        <div class="table__item">
                            <div class="table amount">
                                <table>
                                    <colgroup>
                                        <col>
                                        <col width="80px">
                                        <col>
                                        <col width="80px">
                                        <col>
                                        <col width="80px">
                                    </colgroup>
                                    <thead>
                                        <tr>
                                            <th>주문금액</th>
                                            <th></th>
                                            <th>제조비용</th>
                                            <th></th>
                                            <th>배송비</th>
                                            <th></th>
                                            <th>결제예정금액</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>22,304</td>
                                            <td>
                                                <img src="./assets/images/icon/img_total_plus.svg" alt="">
                                            </td>
                                            <td>7,400</td>
                                            <td>
                                                <img src="./assets/images/icon/img_total_plus.svg" alt="">
                                            </td>
                                            <td>4,000</td>
                                            <td>
                                                <img src="./assets/images/icon/img_total_equal.svg" alt="">
                                            </td>
                                            <td class="total">33,704</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="btnBox d-flex selective-order">
                                <a href="javascript:paymentok();" class="d-flex btn border-rightGray color-gray bg-white">결제하기</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
