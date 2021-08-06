<?php
	$root="../..";
	include_once $root."/_common.php";
?>

<div class="container">
    <div class="sub dictionary dictionary-2">
        <div class="sub__title sub__title--left">
		<input type="hidden" name="seq" class="ajaxdata" value="<?=$_GET["seq"]?>">
            <div class="wrap">방제사전</div>
        </div>
        <div class="sub__content">
            <div class="sub__section">
                <div class="wrap" >					
					<div class="btnBox btnBox--type2 d-flex" style="float:right;">
						<a href="javascript:viewlist();" class="d-flex btn border-blue color-blue radius modal-closeBtn--type2"><span>목록</span></a>	
					</div>
                    <div class="table__tit table__tit--type2 d-flex">
                        <div class="table__tit__txt">
                            <h3>방제명</h3>
                            <p><div id="rcTitle"></div></p>
                        </div>
                        <!-- <div class="btnBox">
                            <a href="#//" class="d-flex btn bg-blue color-white radius" onclick="showModal('modal-dictionary'); return false;">처방하기</a>
                        </div> -->
                    </div>
                    <div class="table-box">
                        <div class="table__item table__item--fst">
                            <div class="table table--list">
                                <table>
                                    <colgroup>
                                        <col>
                                        <col>
                                    </colgroup>
                                    <thead>
                                        <tr>
                                            <th class="th-txtLeft">출전</th>
                                            <th class="th-txtLeft">제형</th>
                                        </tr>
                                        <tr>
                                            <td class="td-txtLeft"><div id="rcSource"></div></td>
                                            <td class="td-txtLeft"><div id="rcType"></div></td>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                        <div class="definition__tit" >
                            약재구성
                        </div>
                        <div class="table__item table__item--lst d-flex">
                            <div class="">
                                <div class="table table--list">
                                    <table>
                                        <colgroup>
                                            <col width="90px">
                                            <col width="220px">
                                            <col>
                                        </colgroup>
                                        <thead>
                                            <tr class="bgNone">
                                                <th>번호</th>
                                                <th>약재명</th>
                                                <th>약재량</th>
                                            </tr>
                                        </thead>
                                        <tbody id="rcMedicine">
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <!-- <div class="table__col" style="border:2px solid red;">
                                <div class="table table--list"> -->
                                    <!-- <table>
                                        <colgroup>
                                            <col width="90px">
                                            <col width="220px">
                                            <col>
                                        </colgroup> -->
                                        <!-- <thead>
                                            <tr class="bgNone">
                                                <th>번호</th>
                                                <th>약재명</th>
                                                <th>약재량</th>
                                            </tr>
                                            <tr>
                                                <td>5</td>
                                                <td class="td-txtLeft">인삼 人蔘</td>
                                                <td>1돈 /  4.0g</td>
                                            </tr>
                                            <tr>
                                                <td>6</td>
                                                <td class="td-txtLeft">인삼 人蔘</td>
                                                <td>1돈 /  4.0g</td>
                                            </tr>
                                            <tr>
                                                <td>7</td>
                                                <td class="td-txtLeft warning d-flex">
                                                    복령 白茯笭
                                                    <div class="warning-box">
                                                        <img src="<?=$root?>/assets/images/icon/warning-yellow.png" alt="">
                                                        <div class="warning-txt">
                                                            처방 관련 내용은 원전에 기반하여 편집자가 임의로 편집한 내용입니다.<br/>
                                                            확인 후 처방 진행하시길 바랍니다.
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>1돈 /  4.0g</td>
                                            </tr>
                                            <tr>
                                                <td>8</td>
                                                <td class="td-txtLeft warning d-flex">
                                                    복령 白茯笭
                                                    <div class="warning-box">
                                                        <img src="<?=$root?>/assets/images/icon/warning.png" alt="">
                                                        <div class="warning-txt">
                                                            처방 관련 내용은 원전에 기반하여 편집자가 임의로 편집한 내용입니다.<br/>
                                                            확인 후 처방 진행하시길 바랍니다.
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>1돈 /  4.0g</td>
                                            </tr>
                                        </thead> -->
                                        <!-- <tbody>
                                        </tbody>
                                    </table> -->
                                <!-- </div>
                            </div> -->
                        </div>
                    </div>
                    <div class="definition">
                        <div class="definition__item">
                            <div class="definition__tit">
                                효능
                            </div>
                            <div class="definition__body" id="rcEfficacy">
                               
                            </div>
                        </div>
                        <!-- <div class="definition__item">
                            <div class="definition__tit">
                                처방설명
                            </div>
                            <div class="definition__body">
                                <p class="blue">
                                    동의보감 잡병편 虛勞 陰陽俱虛用藥 加味十全大補湯
                                </p>
                                <p>
                                    ○治虛勞 氣血俱損 漸成勞瘵. 卽十全大補湯 加柴胡一錢 黃連五分. 服法同上(십전대보탕). [丹心]
                                </p>
                            </div>
                        </div> -->
                        <div class="definition__item">
                            <div class="definition__body definition__body--bgGray">
                                당 사이트에서 제공하는 처방 관련 내용은 원전에 기반하여 편집자가 임의로 편집한 내용입니다.<br/>
                                지속적인 업데이트를 통해 오탈자 등을 수정하고 있지만, 사용자 본인의 확인이 가장 중요합니다.
                                이와 같이 사용자가 판단하여 활용하는 결과에 대하여 당사가 법적인 책임을 지지 않음 을 알려드립니다.
                            </div>
                        </div>
                    </div>
						<div class="btnBox btnBox--type2 d-flex" style="padding-left:400px;padding-top:5px;">
							<a href="javascript:viewlist();" class="d-flex btn border-blue color-blue radius modal-closeBtn--type2"><span>목록</span></a>	
						</div>
                </div>
            </div>
        </div>
    </div>
</div>
