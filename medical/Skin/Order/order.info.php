                                <div class="form__row d-flex">
                                    <div class="form__col d-flex">
                                        <span class="tf-title">처방명</span>
                                        <div class="inp inp-input inp-radius">
                                            <input type="text" name="odTitle" class="ajaxdata" placeholder="처방명을 입력해주세요.">
                                        </div>
                                    </div>
                                    <div class="form__col d-flex">
                                        <div class="col-group d-flex">
                                            <div class="inp inp-radio">
                                                <label for="r0" class="d-flex">
                                                    <input type="radio" name="r1" id="r0" class="blind" checked>
                                                    <span></span>첩 단위 
                                                </label>
                                            </div>
                                            <div class="inp inp-select inp-radius">
                                                <select name="chubCnt" id="chubCnt" onchange="resetCnt()">
													<?php for($i=1;$i<=50;$i++){?>
														<option value="<?=$i?>"><?=$i?>첩</option>
													<?php }?>
													<?php for($i=55;$i<=100;$i++){?>
													<?php if($i%5==0){ ?>
														<option value="<?=$i?>"><?=$i?>첩</option>
													<?php } ?>
													<?php }?>
                                                </select>
                                            </div>
                                        </div>
                                        <!-- <div class="col-group d-flex">
                                            <div class="inp inp-radio">
                                                <label for="z1" class="d-flex">
                                                    <input type="radio" name="r1" id="z1" class="blind">
                                                    <span></span>제 단위 
                                                </label>
                                            </div>
                                            <div class="inp inp-select inp-radius">
                                                <select name="" id="">
                                                    <option value="">1제</option>
                                                    <option value="">1제</option>
                                                    <option value="">1제</option>
                                                    <option value="">1제</option>
                                                    <option value="">1제</option>
                                                </select>
                                            </div>
                                        </div> -->
                                    </div>
                                </div>
<script>
	$("select[name=chubCnt]").val(20);
</script>
