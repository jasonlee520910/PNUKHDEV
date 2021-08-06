<?php
	$root="../..";
	include_once $root."/_common.php";
?>
<style>
	.table--details{min-height:70px;}
	.btndiv{text-align:center;margin:auto;}
	.btndiv .minfobtn{display:inline-block;font-size:17px;padding:10px 20px;border:1px solid #ddd;margin:20px 50px;color:#333;}
</style>


<div class="container">
    <div class="sub member-info">
        <div class="sub__title sub__title--tab d-flex">
            <div class="wrap d-flex">
                <h2>회원정보</h2>
                <div class="tab d-flex">
					<?=viewmembertab("info")?>
                </div>
            </div>
        </div>
        <div class="sub__content">
            <div class="sub__section">
                <div class="wrap">
                    <div class="sub__item" id="myinfoDiv">
                        <div class="table__tit">내 정보</div>
                        <div class="table table--details">
                            <table id="tbllist">
							  <colgroup>
								  <col width="15%">
								  <col width="35%">
								  <col width="15%">
								  <col width="35%">
							  </colgroup>
                                <tbody>
                                   <tr>
                                        <th>이름</th>
                                        <td colspan='3'><div id="meName"></div></td>
                                    </tr>
                                    <tr>
                                        <th>아이디</th>
                                        <td  colspan='3'><div id="meLoginid"></div></td>
                                    </tr>
                                    <tr>
                                        <th>휴대전화</th>
                                        <td  colspan='3'><div id="meBusinessmobile"></div></td>
                                    </tr>
                                    <tr>
                                        <th>이메일</th>
                                        <td><div id="meBusinessemail"></div></td>
                                        <th>메일수신여부</th>
                                        <td><div id="meIsemail"></div></td>									
                                    </tr>
                                    <tr>
                                        <th>면허번호</th>
                                        <td  colspan='3'><div id="meRegistno"></div></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
						<div class="btnBox d-flex">
							<a href="javascript:viewlayermedical('modal-withdraw','member');" style="margin-right:700px;" class="d-flex btn btn--small border-rightGray color-gray">한의사 탈퇴</a>
                            <a href="javascript:viewlayermedical('modal-member-info','member');" style="margin-right:10px" class="d-flex btn btn--small border-rightGray color-gray">수정하기</a>						
							<a href="javascript:viewlayermedical('modal-changepass','');" class="d-flex btn btn--small border-rightGray color-gray">비밀번호 변경</a>
						</div>
                    </div>
                    <div class="sub__item" id="medicalinfoDiv" >
                        <div class="table__tit">의료기관정보
						   <span class="" style="" id="medicalBtn">            
							 
						   </span>
							<!-- <?php if($_COOKIE["ck_meGrade"]=="30"){?>  
							<a href="<?=$root?>/Member/Mydoctor.php" class="d-flex btn btn--small border-rightGray color-gray" style="float:right;Width:150px;">소속 한의사 등록하기</a> 	
							<?php } ?> -->
						</div>					
                        <div class="table table--details">
                            <table>
							  <colgroup>
								  <col width="15%">
								  <col width="35%">
								  <col width="15%">
								  <col width="35%">
							  </colgroup>
                                <tbody>
                                    <tr>
                                        <th>의료기관명</th>
                                        <td  colspan='3'><div id="miName"></div></td>
                                    </tr>
                                    <tr>
                                        <th>사업자번호</th>
                                        <td  colspan='3'><div id="miBusinessno"></div></td>
                                    </tr>
                                    <tr>
                                        <th>대표자명</th>
                                        <td  colspan='3'><div id="miCeo"></div></td>
                                    </tr>
                                    <tr>
                                        <th>사업장소재지</th>
                                        <td  colspan='3'><div id="miAddress"></div></td>
                                    </tr>
                                    <tr>
                                        <th>전화번호</th>
                                        <td  colspan='3'><div id="miPhone"></div></td>
                                    </tr>
                                    <tr>
                                        <th>팩스번호</th>
                                        <td  colspan='3'><div id="miFax"></div></td>
                                    </tr>
                                    <tr>
                                        <th>세금계산서</th>
                                        <td colspan='3'><div id="miEmail"></div></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="btnBox d-flex" id="btnBoxDiv">
					
							<!-- <a href="javascript:viewlayermedical('modal-withdraw','medical');" class="d-flex btn btn--small border-rightGray color-gray">한의원 탈퇴</a>
                            <a href="javascript:viewlayermedical('modal-member-info','medical');" class="d-flex btn btn--small border-rightGray color-gray">수정하기</a> -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

