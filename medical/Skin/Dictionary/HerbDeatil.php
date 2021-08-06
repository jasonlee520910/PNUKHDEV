<?php
	$root="../..";
	include_once $root."/_common.php";
?>

<input type="hidden" name="seq" class="ajaxdata" value="<?=$_GET["seq"]?>">
<div class="container">
    <div class="sub dictionary dictionary-2 dictionary-4">
        <div class="sub__title sub__title--left">
            <div class="wrap">본초사전</div>
        </div>
        <div class="sub__content">
            <div class="sub__section">
                <div class="wrap">
					<div class="btnBox btnBox--type2 d-flex" style="float:right;">
						<a href="javascript:viewlist();" class="d-flex btn border-blue color-blue radius modal-closeBtn--type2"><span>목록</span></a>	
					</div>
                    <div class="table__tit table__tit--type2 d-flex">
                        <div class="table__tit__txt">
                            <h3>본초명</h3>
                            <p><div id="mhTitle"></div></p>
                        </div>
                    </div>
                    <div class="definition">
                        <div class="definition__item">
                            <div class="definition__tit">
                                이명
                            </div>
                            <div class="definition__body" id="mhDtitleKor">
                               
                            </div>
                        </div>
                        <div class="definition__item d-flex">
                            <div class="definition__col">
                                <div class="definition__tit" >
                                    영문명
                                </div>
                                <div class="definition__body" id="mhTitleEng">
                                    
                                </div>
                            </div>
                            <div class="definition__col">
                                <div class="definition__tit">
                                    중문명
                                </div>
                                <div class="definition__body" id="mhTitleChn">
                                   
                                </div>
                            </div>
                        </div>
                        <div class="definition__item">
                            <div class="definition__tit">
                                설명
                            </div>
                            <div class="definition__body" id="mhRedefinition">
                              
                            </div>
                        </div>
                        <div class="definition__item">
                            <div class="definition__tit">
                                효능
                            </div>
                            <div class="definition__body" id="mhEfficacyKor">
                                이 약은 감초 Glycyrrhiza uralensis Fischer, 광과감초 (光果甘草) Glycyrrhiza glabra Linné 또는 창과감초 (脹果甘草) Glycyrrhiza inflata Batal. (콩과 Leguminosae)의 뿌리 및 뿌리줄기로서 그대로 또는 주피를 제거한 것이다.<br/>
                                이 약은 감초 Glycyrrhiza uralensis Fischer, 광과감초 (光果甘草) Glycyrrhiza glabra Linné 또는 창과감초 (脹果甘草) Glycyrrhiza inflata Batal. (콩과 Leguminosae)의 뿌리 및 뿌리줄기로서 그대로 또는 주피를 제거한 것이다.
                            </div>
                        </div>
                        <div class="definition__item">
                            <div class="definition__tit">
                                주치
                            </div>
                            <div class="definition__body" id="mhDescKor">
                  
                            </div>
                        </div>
                        <div class="definition__item">
                            <div class="definition__tit" >
                                금기 
                            </div>
                            <div class="definition__body" id="mhCautionKor">
                                
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
