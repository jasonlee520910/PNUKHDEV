<?php
	$root="../..";
	include_once $root."/_common.php";
?>


<div class="container">
    <div class="sub admin admin-cart">
        <div class="sub__title sub__title--left d-flex">
            <div class="wrap d-flex">
                장바구니
            </div>
        </div>
        <div class="sub__content">
            <div class="sub__section">
                <div class="wrap">
                    <div class="tableBox">
                        <div class="table__item">
                            <div class="table table--list">
                                <table id='tbl'>
                                    <colgroup>
                                        <col width="5%">
                                        <col width="8%">
                                        <col width="9%">
                                        <col width="*">
                                        <col width="5%">
                                        <col width="9%">
                                        <col width="9%">
                                        <col width="8%">
                                        <col width="9%">
                                        <col width="9%">
                                    </colgroup>
                                    <thead>
                                        <tr>
                                            <th>
                                                <div class="inp-checkBox">
                                                    <div class="inp inp-check">
                                                        <label for="chk_alld1" class="d-flex">
                                                            <input type="checkbox" name="chk_all" id="chk_alld1" class="blind" onclick="chkall(this);">
                                                            <span></span>
                                                        </label>
                                                    </div>
                                                </div>
                                            </th>
                                            <th>제형</th>
                                            <th>담당한의사</th>
                                            <th class="th-txtLeft">주문상품정보</th>
                                            <th>수량</th>
                                            <th class="th-txtRight">상품금액</th>
                                            <th class="th-txtRight">조제비용</th>
                                            <th class="th-txtRight">배송비</th>
                                            <th>환자명</th>
                                            <th>처방일자</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
							<div class='paging d-flex' id='paging'></div>

							<script>
								function cancelok(){
									if(!confirm("취소하시겠습니까?"))return;
									cartcancel();
								}

								function paymentok()
								{
									//if(!confirm("결제하시겠습니까?"))return;
									//cartpayment();

									var seq=buyItemnm="";
									var i=0;
									$("#tbl tbody tr").each(function()
									{
										var val=$(this).children("td").eq(0).find("input").prop("checked");
										if(val==true)
										{
											seq+=","+$(this).children("td").eq(0).find("input").data("seq");
											console.log(seq);
											if(buyItemnm==""){
												//상품명
												buyItemnm = $(this).children("td").eq(3).text();
											}
											i++;
										}
									});
									if(i<1)
									{
										alert("결제하실 상품이 없습니다.");
									}
									else
									{
										var payType=$("input[name='payType']:checked").val();
										//alert(payType);
										if(payType=="MEDI_CARD")//카드 
										{
											cartpayment();
										}
										else if(payType=="VIRTUALACCOUNT") //무통장 
										{
											var pmPayname=$("input[name=pmPayname]").val();
											if(isEmpty(pmPayname))
											{
												alert("입금자명을 입력해 주세요.");
												return; 
											}
											var depositBank=$("select[name=depositBank]").children("option:selected").val();

											cartpaymentBank();
										}
										//if(!confirm("결제하시겠습니까?"))return;
										//cartpaymentnone();
										//cartpayment();								
									}
								}

								function payTypeBank()
								{
									$("#virtualDiv").show();
								}
								function payTypeCard()
								{
									$("#virtualDiv").hide();
								}

							</script>
                            <div class="product-select d-flex">
                                <p>
                                    선택상품(<span id="chkcount">0</span> 개)
                                </p>
                                <div class="btnBox">
									<a href="javascript:paymentok();" class="d-flex btn border-rightGray color-gray bg-white" style="width:200px;">선택하신 상품 결재하기</a>
                                    <!-- <a href="javascript:cancelok();" class="d-flex btn border-rightGray color-gray bg-white">주문취소</a> -->
                                </div>
                            </div>
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
                                            <th>상품금액</th>
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
                                            <td id="totmedicine">0</td>
                                            <td>
                                                <img src="/assets/images/icon/img_total_plus.svg" alt="">
                                            </td>
                                            <td  id="totmaking">0</td>
                                            <td>
                                                <img src="/assets/images/icon/img_total_plus.svg" alt="">
                                            </td>
                                            <td  id="totdelivery">0</td>
                                            <td>
                                                <img src="/assets/images/icon/img_total_equal.svg" alt="">
                                            </td>
                                            <td class="total" id="totamount">0</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="table d-flex selective-order">
                                <table>
                                    <colgroup>
                                        <col width="15%">
                                        <col>
                                    </colgroup>
                                    <tbody>
                                        <tr>
                                            <th>결제수단</th>
                                            <td style='padding-left:20px;'>	
												<div class="inp-radioBox d-flex">
													<div class="inp inp-radio">
														<label for="payType1" class="d-flex">
															<input type="radio" name="payType" id="payType1" value="MEDI_CARD" checked onclick="payTypeCard();">
															<span></span>신용카드
														</label>
													</div>
													<div class="inp inp-radio">
														<label for="payType2" class="d-flex">
															<input type="radio" name="payType" id="payType2" value="VIRTUALACCOUNT" onclick="payTypeBank();">
															<span></span>무통장
														</label>
													</div>
												</div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                            <div class="table d-flex" id="virtualDiv" style='display:none;'>
								<table>
                                    <colgroup>
                                        <col width="15%">
                                        <col>
                                    </colgroup>
                                    </colgroup>
                                    <tbody>
                                        <tr>
                                            <th>입금계좌선택</th>
                                            <td style='padding-left:20px;'>	
												<div class="inp inp-select inp-radius" style="width:400px;">
													<select name="depositBank" id="depositBank" class="ajaxdata">
													<?php $barr=array("농협은행");?>
													<?php $aarr=array("301-0272-2747-71");?>
													<?php $narr=array("부산대학교한방병원 공용원외탕전실");?>
													<?php for($i=0;$i<count($aarr);$i++){?>
														<option value="<?=$barr[$i]?>,<?=$aarr[$i]?>" selected><?=$barr[$i]?> <?=$narr[$i]?></option>
													<?php }?>
													</select>
												</div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>입금자명</th>
                                            <td style='padding-left:20px;'>
												<!-- PM_PAYNAME, PM_CARDBANK, PM_ACCOUNT -->
												<div class="inp inp-input inp-radius" style="width:200px;">
													<input type="text" name="pmPayname" id="pmPayname" class="ajaxdata">
												</div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                            <div class="btnBox d-flex selective-order">
                                <a href="javascript:paymentok();" class="d-flex btn border-rightGray color-gray bg-white">결재하기</a>
                            </div>
							<?php  include_once ($root.'/Skin/Cart/paywork.php');?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
