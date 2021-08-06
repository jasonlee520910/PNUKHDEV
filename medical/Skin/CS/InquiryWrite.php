<?php
	$root="..";
	include_once $root."/_Inc/head.php";
?>


<div class="container">
    <div class="sub customer-service inquiry-resister">
        <div class="sub__title sub__title--left d-flex">
		<input type="hidden" name="seq" class="ajaxdata" value="<?=$_GET["seq"]?>">
		<input type="hidden" name="medicalId" class="ajaxdata" value="<?=$_COOKIE["ck_miUserid"]?>">
            <div class="wrap d-flex">
                1:1 문의하기
            </div>
        </div>
        <div class="sub__content">
            <div class="sub__section">
                <div class="wrap">
                    <div class="table table--details">
                        <table>
                            <colgroup>
                                <col>
                                <col>
                            </colgroup>
                            <tbody>
                                <tr>
                                    <th>문의유형</th>
                                    <td>
                                        <div class="inp-radioBox d-flex">
                                            <div class="inp inp-radio">
                                                <label for="delivery" class="d-flex">
                                                    <input type="radio" name="bbtype" id="delivery" class="blind" value="delivery">
                                                    <span></span>배송관련
                                                </label>
                                            </div>
                                            <div class="inp inp-radio">
                                                <label for="cancel" class="d-flex">
                                                    <input type="radio" name="bbtype" id="cancel" class="blind" value="cancel">
                                                    <span></span>취소/교환/반품
                                                </label>
                                            </div>
                                            <div class="inp inp-radio">
                                                <label for="product" class="d-flex">
                                                    <input type="radio" name="bbtype" id="product" class="blind" value="product">
                                                    <span></span>상품관련
                                                </label>
                                            </div>
                                            <div class="inp inp-radio">
                                                <label for="etc" class="d-flex">
                                                    <input type="radio" name="bbtype" id="etc" class="blind" value="etc">
                                                    <span></span>기타
                                                </label>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <!-- <tr>
                                    <th>관심상품</th>
                                    <td>
                                        <div class="inp inp-select inp-radius">
                                            <select name="" id="">
                                                <option value="">주문한 내역을 선택해주세요.</option>
                                                <option value="">주문한 내역을 선택해주세요.</option>
                                                <option value="">주문한 내역을 선택해주세요.</option>
                                                <option value="">주문한 내역을 선택해주세요.</option>
                                                <option value="">주문한 내역을 선택해주세요.</option>
                                            </select>
                                        </div>
                                    </td>
                                </tr> -->
                                <tr>
                                    <th>제목</th>
                                    <td>
                                        <div class="inp inp-input">
                                            <input type="text" placeholder="제목입력" class="ajaxdata" name="cstitle">
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <th class="vertical">내용</th>
                                    <td>
                                        <div class="inp inp-textarea" >
                                            <textarea placeholder="내용입력" class="ajaxdata" name="cscontent"></textarea>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <th class="vertical">답변</th>
                                    <td>
                                        <div class="inp inp-textarea" >
                                            <textarea  class="ajaxdata" name="bb_answer" readonly></textarea>
                                        </div>
                                    </td>
                                </tr>
                                <!-- <tr>
                                    <th class="vertical">파일첨부</th>
                                    <td>
                                        <div class="fileBox d-flex">
                                            <div class="inp-file d-flex file-custom">
                                                <label for="fu1">
                                                    파일첨부
                                                    <input type="file" name="" id="fu1" class="blind upload-file">
                                                </label>
                                                <input type="text" value="선택된 파일 없음" class="upload-name" disabled="disabled">
                                                <button class="file-delete"></button>
                                            </div>
                                            <div class="inp-file-memory">
                                                최대용량 10MB (docx, doc, hwp, pdf) 첨부 가능합니다.
                                            </div>
                                        </div>
                                    </td>
                                </tr> -->
                            </tbody>
                        </table>
                    </div>

                    <div class="btnBox d-flex">
					  <a href="javascript:viewlist('');" class="d-flex btn btn--small border-rightGray color-gray">취소</a>
					  <a href="javascript:inquiry_update();" class="d-flex btn btn--small border-rightGray color-gray">등록</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>

	function viewlist(){
		var hdata=location.hash.replace("#","").split("|");
		var page=hdata[0];
		if(page==undefined){page="";}
		var seq="";
		var search=hdata[2];
		if(search ===undefined){search="";}
		makehash(page,seq,search)
	}

	function inquiry_update()
	{
		var bbtype=$('input:radio[name="bbtype"]:checked').val();
		console.log("bbtype   >>> "+bbtype);
		callapi("POST","/medical/cs/",getdata("inquiryupdate")+"&bbtype="+bbtype);
		//$("#listdiv").load("<?=$root?>/Skin/CS/InquiryList.php");//1:1문의리스트 
		location.reload();
		


	}

	function makepage(result)
	{		
		var obj = JSON.parse(result);
		console.log(obj);
		console.log("apiCode>>>>> "+obj["apiCode"]);

		if(obj["apiCode"]=="inquirydesc")  
		{
			$("input[name=seq]").val(obj["seq"]);
			$("input[name=cstitle]").val(obj["bb_title"]);
			$("textarea[name=cscontent]").text(obj["bb_desc"]); //내용
			$("textarea[name=bb_answer]").text(obj["bb_answer"]); //내용
			
			if(isEmpty(obj["seq"]))
			{
				$("input:radio[name='bbtype']:radio[value='delivery']").attr("checked",true);  //배송관련 기본값
			}
			else
			{
				$("input:radio[name='bbtype']:radio[value="+obj["bb_type"]+"]").prop('checked', true); // 
			
			}
		}
	}

	function getlist()
	{
		callapi("GET","/medical/cs/",getdata("inquirydesc"));
	}

	getlist();

</script>