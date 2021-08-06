<?php //Config
	$root = "../..";
	include_once ($root.'/_common.php');

	//echo $apidata;
	$pagegroup = "setting";
	$pagecode = "textdblist";
?>
<div id="pagegroup" value="<?=$pagegroup?>"></div>
<div id="pagecode" value="<?=$pagecode?>"></div>
<input type="hidden" name="apiCode" class="reqdata" value="textdbupdate">
<input type="hidden" name="returnData" class="reqdata" value="<?=$root?>/Skin/Setting/TextDB.php">
<textarea name="selstat" rows="10" cols="100%" class="hidden" id="selstatDiv"></textarea>


<div class="board-view-wrap">
	<h3 class="u-tit02"><?=$txtdt["1840"]?><!--기본설정 --></h3>
	<span class="bd-line"></span>
	<table>
		<caption><span class="blind"></span></caption>
		<colgroup>
			<col width="180">
			<col width="*">
			<col width="180">
			<col width="*">
			<col width="180">
			<col width="*">
		</colgroup>
		<tbody>
			<tr>
				<!-- <th><span class="">기본코드<?=$txtdt[""]?><!--  --><!-- </span></th> 언어 등록하고 $txtdt함수로 수정할것--> 
				<th><span class="">1.기본코드<?=$txtdt[""]?><!--  --></span></th>
				<td><input type="text" name="cf_code"  class="w90p reqdata" title="<?=$txtdt[""]?>"/></td>
				<th><span class="">2.사이트/회사명<?=$txtdt[""]?><!--  --></span></th>
				<td><input type="text" name="cf_company"  class="w90p reqdata" title="<?=$txtdt[""]?>"/></td>
				<th><span class="">3.사이트/회사 영문명<?=$txtdt[""]?><!--  --></span></th>
				<td><input type="text" name="cf_companyeng"  class="w90p reqdata" title="<?=$txtdt[""]?>"/></td>
			</tr>

			<tr>
				<th><span class="">4.사이트소개타이틀<?=$txtdt[""]?><!--  --></span></th>
				<td><input type="text" name="cf_slogan"  class="w90p reqdata" title="<?=$txtdt[""]?>"/></td>
				<th><span class="">5.조제관련<?=$txtdt[""]?><!--  --></span></th>
				<td><input type="text" name="cf_making"  class="w90p reqdata" title="<?=$txtdt[""]?>"/></td>
				<th><span class="">6.조제관련<?=$txtdt[""]?><!--  --></span></th>
				<td><input type="text" name="cf_makingtable"  class="w90p reqdata" title="<?=$txtdt[""]?>"/></td>
			</tr>

			<tr>
				<th><span class="">7.인사말<?=$txtdt[""]?><!--  --></span></th>
				<td><input type="text" name="cf_greeting"  class="w90p reqdata" title="<?=$txtdt[""]?>"/></td>
				<th><span class="">8.설립일<?=$txtdt[""]?><!--  --></span></th>
				<td><input type="text" name="cf_establish"  class="w90p reqdata" title="<?=$txtdt[""]?>"/></td>
				<th><span class="">9.대표이메일<?=$txtdt[""]?><!--  --></span></th>
				<td><input type="text" name="cf_email"  class="w90p reqdata" title="<?=$txtdt[""]?>"/></td>
			</tr>
			<tr>
				<th><span class="">10.사업자 업태(사업자등록증)<?=$txtdt[""]?><!--  --></span></th>
				<td><input type="text" name="cf_business1"  class="w90p reqdata" title="<?=$txtdt[""]?>"/></td>
				<th><span class="">11.사업자 종목(사업자등록증)<?=$txtdt[""]?><!--  --></span></th>
				<td><input type="text" name="cf_business2"  class="w90p reqdata" title="<?=$txtdt[""]?>"/></td>
				<th><span class="">12.대표전화번호<?=$txtdt[""]?><!--  --></span></th>
				<td><input type="text" name="cf_phone"  class="w90p reqdata" title="<?=$txtdt[""]?>"/></td>
			</tr>
			<tr>
				<th><span class="">13.대표팩스번호<?=$txtdt[""]?><!--  --></span></th>
				<td><input type="text" name="cf_fax"  class="w90p reqdata" title="<?=$txtdt[""]?>"/></td>
				<th><span class="">14.대표자명<?=$txtdt[""]?><!--  --></span></th>
				<td><input type="text" name="cf_ceo"  class="w90p reqdata" title="<?=$txtdt[""]?>"/></td>
				<th><span class="">15.대표자전화번호<?=$txtdt[""]?><!--  --></span></th>
				<td><input type="text" name="cf_ceomobile"  class="w90p reqdata" title="<?=$txtdt[""]?>"/></td>
			</tr>
			<tr>
				<th><span class="">16.대표자이메일<?=$txtdt[""]?><!--  --></span></th>
				<td><input type="text" name="cf_ceoemail"  class="w90p reqdata" title="<?=$txtdt[""]?>"/></td>
				<th><span class="">17.정보보호책임자명<?=$txtdt[""]?><!--  --></span></th>
				<td><input type="text" name="cf_cio"  class="w90p reqdata" title="<?=$txtdt[""]?>"/></td>
				<th><span class="">18.정보보호책임자전화번호<?=$txtdt[""]?><!--  --></span></th>
				<td><input type="text" name="cf_ciomobile"  class="w90p reqdata" title="<?=$txtdt[""]?>"/></td>
			</tr>
			<tr>
				<th><span class="">19.정보보호책임자이메일<?=$txtdt[""]?><!--  --></span></th>
				<td><input type="text" name="cf_cioemail"  class="w90p reqdata" title="<?=$txtdt[""]?>"/></td>
				<th><span class="">20.담당자명<?=$txtdt[""]?><!--  --></span></th>
				<td><input type="text" name="cf_staff"  class="w90p reqdata" title="<?=$txtdt[""]?>"/></td>
				<th><span class="">21.담당자전화번호<?=$txtdt[""]?><!--  --></span></th>
				<td><input type="text" name="cf_staffmobile"  class="w90p reqdata" title="<?=$txtdt[""]?>"/></td>
			</tr>
			<tr>
				<th><span class="">22.담당자이메일<?=$txtdt[""]?><!--  --></span></th>
				<td><input type="text" name="cf_staffemail"  class="w90p reqdata" title="<?=$txtdt[""]?>"/></td>
				<th><span class="">23.사엄자등록번호<?=$txtdt[""]?><!--  --></span></th>
				<td><input type="text" name="cf_businessno"  class="w90p reqdata" title="<?=$txtdt[""]?>"/></td>
				<th><span class="">24.통신판매업번호<?=$txtdt[""]?><!--  --></span></th>
				<td><input type="text" name="cf_salesno"  class="w90p reqdata" title="<?=$txtdt[""]?>"/></td>
			</tr>
			<tr>
				<th><span class="">25.우편번호<?=$txtdt[""]?><!--  --></span></th>
				<td><input type="text" name="cf_zipcode"  class="w90p reqdata" title="<?=$txtdt[""]?>"/></td>
				<th><span class="">26.주소<?=$txtdt[""]?><!--  --></span></th>
				<td><input type="text" name="cf_address"  class="w90p reqdata" title="<?=$txtdt[""]?>"/></td>
				<th><span class="">27.영문주소<?=$txtdt[""]?><!--  --></span></th>
				<td><input type="text" name="cf_addresseng"  class="w90p reqdata" title="<?=$txtdt[""]?>"/></td>
			</tr>
			<tr>
				<th><span class="">28.조제비<?=$txtdt[""]?><!--  --></span></th>
				<td><input type="text" name="cf_makingprice"  class="w90p reqdata" onchange="changeNumber(event,false);" title="조제비"/></td>
				<th><span class="nec">28-A.조제비A<?=$txtdt[""]?><!--  --></span></th>
				<td><input type="text" name="cf_makingpriceA"  class="w90p reqdata necdata" onchange="changeNumber(event,false);" title="조제비A"/></td>
				<th><span class="nec">28-B.조제비B<?=$txtdt[""]?><!--  --></span></th>
				<td><input type="text" name="cf_makingpriceB"  class="w90p reqdata necdata" onchange="changeNumber(event,false);" title="조제비B"/></td>
			</tr>
			<tr>
				<th><span class="nec">28-C.조제비C<?=$txtdt[""]?><!--  --></span></th>
				<td><input type="text" name="cf_makingpriceC"  class="w90p reqdata necdata" onchange="changeNumber(event,false);" title="조제비C"/></td>
				<th><span class="nec">28-D.조제비D<?=$txtdt[""]?><!--  --></span></th>
				<td><input type="text" name="cf_makingpriceD"  class="w90p reqdata necdata" onchange="changeNumber(event,false);" title="조제비D"/></td>
				<th><span class="nec">28-E.조제비E<?=$txtdt[""]?><!--  --></span></th>
				<td><input type="text" name="cf_makingpriceE"  class="w90p reqdata necdata" onchange="changeNumber(event,false);" title="조제비E"/></td>
			</tr>
			<tr>
				<th><span class="">29.탕전비<?=$txtdt[""]?><!--  --></span></th>
				<td><input type="text" name="cf_decocprice"  class="w90p reqdata" onchange="changeNumber(event,false);" title="탕전비"/></td>
				<th><span class="nec">29-A.탕전비A<?=$txtdt[""]?><!--  --></span></th>
				<td><input type="text" name="cf_decocpriceA"  class="w90p reqdata necdata" onchange="changeNumber(event,false);" title="탕전비A"/></td>
				<th><span class="nec">29-B.탕전비B<?=$txtdt[""]?><!--  --></span></th>
				<td><input type="text" name="cf_decocpriceB"  class="w90p reqdata necdata" onchange="changeNumber(event,false);" title="탕전비B"/></td>
			</tr>
			<tr>
				<th><span class="nec">29-C.탕전비C<?=$txtdt[""]?><!--  --></span></th>
				<td><input type="text" name="cf_decocpriceC"  class="w90p reqdata necdata" onchange="changeNumber(event,false);" title="탕전비C"/></td>
				<th><span class="nec">29-D.탕전비D<?=$txtdt[""]?><!--  --></span></th>
				<td><input type="text" name="cf_decocpriceD"  class="w90p reqdata necdata" onchange="changeNumber(event,false);" title="탕전비D"/></td>
				<th><span class="nec">29-E.탕전비E<?=$txtdt[""]?><!--  --></span></th>
				<td><input type="text" name="cf_decocpriceE"  class="w90p reqdata necdata" onchange="changeNumber(event,false);" title="탕전비E"/></td>
			</tr>
			<tr>
				<th><span class="">30.배송비<?=$txtdt[""]?><!--  --></span></th>
				<td><input type="text" name="cf_releaseprice"  class="w90p reqdata" onchange="changeNumber(event,false);" title="배송비"/></td>
				<th><span class="nec">30-A.배송비A<?=$txtdt[""]?><!--  --></span></th>
				<td><input type="text" name="cf_releasepriceA"  class="w90p reqdata necdata" onchange="changeNumber(event,false);" title="배송비A"/></td>
				<th><span class="nec">30-B.배송비B<?=$txtdt[""]?><!--  --></span></th>
				<td><input type="text" name="cf_releasepriceB"  class="w90p reqdata necdata" onchange="changeNumber(event,false);" title="배송비B"/></td>
			</tr>
			<tr>
				<th><span class="nec">30-C.배송비C<?=$txtdt[""]?><!--  --></span></th>
				<td><input type="text" name="cf_releasepriceC"  class="w90p reqdata necdata" onchange="changeNumber(event,false);" title="배송비C"/></td>
				<th><span class="nec">30-D.배송비D<?=$txtdt[""]?><!--  --></span></th>
				<td><input type="text" name="cf_releasepriceD"  class="w90p reqdata necdata" onchange="changeNumber(event,false);" title="배송비D"/></td>
				<th><span class="nec">30-E.배송비E<?=$txtdt[""]?><!--  --></span></th>
				<td><input type="text" name="cf_releasepriceE"  class="w90p reqdata necdata" onchange="changeNumber(event,false);" title="배송비E"/></td>
			</tr>

			<tr>
				<th><span class="">31.포장비<?=$txtdt[""]?><!--  --></span></th>
				<td><input type="text" name="cf_packingprice"  class="w90p reqdata" onchange="changeNumber(event,false);" title="포장비"/></td>
				<th><span class="nec">31-A.포장비A<?=$txtdt[""]?><!--  --></span></th>
				<td><input type="text" name="cf_packingpriceA"  class="w90p reqdata necdata" onchange="changeNumber(event,false);" title="포장비A"/></td>
				<th><span class="nec">31-B.포장비B<?=$txtdt[""]?><!--  --></span></th>
				<td><input type="text" name="cf_packingpriceB"  class="w90p reqdata necdata" onchange="changeNumber(event,false);" title="포장비B"/></td>
			</tr>
			<tr>
				<th><span class="nec">31-C.포장비C<?=$txtdt[""]?><!--  --></span></th>
				<td><input type="text" name="cf_packingpriceC"  class="w90p reqdata necdata" onchange="changeNumber(event,false);" title="포장비C"/></td>
				<th><span class="nec">31-D.포장비D<?=$txtdt[""]?><!--  --></span></th>
				<td><input type="text" name="cf_packingpriceD"  class="w90p reqdata necdata" onchange="changeNumber(event,false);" title="포장비D"/></td>
				<th><span class="nec">31-E.포장비E<?=$txtdt[""]?><!--  --></span></th>
				<td><input type="text" name="cf_packingpriceE"  class="w90p reqdata necdata" onchange="changeNumber(event,false);" title="포장비E"/></td>
			</tr>

			<tr>
				<th><span class="">32.선전비<?=$txtdt[""]?><!--  --></span></th>
				<td><input type="text" name="cf_firstprice"  class="w90p reqdata" onchange="changeNumber(event,false);" title="선전비>"/></td>
				<th><span class="nec">32-A.선전비A<?=$txtdt[""]?><!--  --></span></th>
				<td><input type="text" name="cf_firstpriceA"  class="w90p reqdata necdata" onchange="changeNumber(event,false);" title="선전비A"/></td>
				<th><span class="nec">32-B.선전비B<?=$txtdt[""]?><!--  --></span></th>
				<td><input type="text" name="cf_firstpriceB"  class="w90p reqdata necdata" onchange="changeNumber(event,false);" title="선전비B"/></td>
			</tr>
			<tr>
				<th><span class="nec">32-C.선전비C<?=$txtdt[""]?><!--  --></span></th>
				<td><input type="text" name="cf_firstpriceC"  class="w90p reqdata necdata" onchange="changeNumber(event,false);" title="선전비C"/></td>
				<th><span class="nec">32-D.선전비D<?=$txtdt[""]?><!--  --></span></th>
				<td><input type="text" name="cf_firstpriceD"  class="w90p reqdata necdata" onchange="changeNumber(event,false);" title="선전비D"/></td>
				<th><span class="nec">32-E.선전비E<?=$txtdt[""]?><!--  --></span></th>
				<td><input type="text" name="cf_firstpriceE"  class="w90p reqdata necdata" onchange="changeNumber(event,false);" title="선전비E"/></td>
			</tr>

			<tr>
				<th><span class="">33.후하비<?=$txtdt[""]?><!--  --></span></th>
				<td><input type="text" name="cf_afterprice"  class="w90p reqdata" onchange="changeNumber(event,false);" title="후하비"/></td>
				<th><span class="nec">33-A.후하비A<?=$txtdt[""]?><!--  --></span></th>
				<td><input type="text" name="cf_afterpriceA"  class="w90p reqdata necdata" onchange="changeNumber(event,false);" title="후하비A"/></td>
				<th><span class="nec">33-B.후하비B<?=$txtdt[""]?><!--  --></span></th>
				<td><input type="text" name="cf_afterpriceB"  class="w90p reqdata necdata" onchange="changeNumber(event,false);" title="후하비B"/></td>
			</tr>
			<tr>
				<th><span class="nec">33-C.후하비C<?=$txtdt[""]?><!--  --></span></th>
				<td><input type="text" name="cf_afterpriceC"  class="w90p reqdata necdata" onchange="changeNumber(event,false);" title="후하비C"/></td>
				<th><span class="nec">33-D.후하비D<?=$txtdt[""]?><!--  --></span></th>
				<td><input type="text" name="cf_afterpriceD"  class="w90p reqdata necdata" onchange="changeNumber(event,false);" title="후하비D"/></td>
				<th><span class="nec">33-E.후하비E<?=$txtdt[""]?><!--  --></span></th>
				<td><input type="text" name="cf_afterpriceE"  class="w90p reqdata necdata" onchange="changeNumber(event,false);" title="후하비E"/></td>
			</tr>

			<tr>
				<th><span class="">34.첩약배송비<?=$txtdt[""]?><!--  --></span></th>
				<td><input type="text" name="cf_cheobprice"  class="w90p reqdata" onchange="changeNumber(event,false);" title="첩약배송비"/></td>
				<th><span class="nec">34-A.첩약배송비A<?=$txtdt[""]?><!--  --></span></th>
				<td><input type="text" name="cf_cheobpriceA"  class="w90p reqdata necdata" onchange="changeNumber(event,false);" title="첩약배송비A"/></td>
				<th><span class="nec">34-B.첩약배송비B<?=$txtdt[""]?><!--  --></span></th>
				<td><input type="text" name="cf_cheobpriceB"  class="w90p reqdata necdata" onchange="changeNumber(event,false);" title="첩약배송비B"/></td>
			</tr>
			<tr>
				<th><span class="nec">34-C.첩약배송비C<?=$txtdt[""]?><!--  --></span></th>
				<td><input type="text" name="cf_cheobpriceC"  class="w90p reqdata necdata" onchange="changeNumber(event,false);" title="첩약배송비C"/></td>
				<th><span class="nec">34-D.첩약배송비D<?=$txtdt[""]?><!--  --></span></th>
				<td><input type="text" name="cf_cheobpriceD"  class="w90p reqdata necdata" onchange="changeNumber(event,false);" title="첩약배송비D"/></td>
				<th><span class="nec">34-E.첩약배송비E<?=$txtdt[""]?><!--  --></span></th>
				<td><input type="text" name="cf_cheobpriceE"  class="w90p reqdata necdata" onchange="changeNumber(event,false);" title="첩약배송비E"/></td>
			</tr>

			<tr>
				<th><span class="">35.주수상반<?=$txtdt[""]?><!--  --></span></th>
				<td><input type="text" name="cf_alcoholprice"  class="w90p reqdata" onchange="changeNumber(event,false);" title="주수상반"/></td>
				<th><span class="nec">35-A.주수상반A<?=$txtdt[""]?><!--  --></span></th>
				<td><input type="text" name="cf_alcoholpriceA"  class="w90p reqdata necdata" onchange="changeNumber(event,false);" title="주수상반A"/></td>
				<th><span class="nec">35-B.주수상반B<?=$txtdt[""]?><!--  --></span></th>
				<td><input type="text" name="cf_alcoholpriceB"  class="w90p reqdata necdata" onchange="changeNumber(event,false);" title="주수상반B"/></td>
			</tr>
			<tr>
				<th><span class="nec">35-C.주수상반C<?=$txtdt[""]?><!--  --></span></th>
				<td><input type="text" name="cf_alcoholpriceC"  class="w90p reqdata necdata" onchange="changeNumber(event,false);" title="주수상반C"/></td>
				<th><span class="nec">35-D.주수상반D<?=$txtdt[""]?><!--  --></span></th>
				<td><input type="text" name="cf_alcoholpriceD"  class="w90p reqdata necdata" onchange="changeNumber(event,false);" title="주수상반D"/></td>
				<th><span class="nec">35-E.주수상반E<?=$txtdt[""]?><!--  --></span></th>
				<td><input type="text" name="cf_alcoholpriceE"  class="w90p reqdata necdata" onchange="changeNumber(event,false);" title="주수상반E"/></td>
			</tr>


			<tr>
				<th><span class="">36.증류탕전<?=$txtdt[""]?><!--  --></span></th>
				<td><input type="text" name="cf_distillationprice"  class="w90p reqdata" onchange="changeNumber(event,false);" title="증류탕전"/></td>
				<th><span class="nec">36-A.증류탕전A<?=$txtdt[""]?><!--  --></span></th>
				<td><input type="text" name="cf_distillationpriceA"  class="w90p reqdata necdata" onchange="changeNumber(event,false);" title="증류탕전A"/></td>
				<th><span class="nec">36-B.증류탕전B<?=$txtdt[""]?><!--  --></span></th>
				<td><input type="text" name="cf_distillationpriceB"  class="w90p reqdata necdata" onchange="changeNumber(event,false);" title="증류탕전B"/></td>
			</tr>
			<tr>
				<th><span class="nec">36-C.증류탕전C<?=$txtdt[""]?><!--  --></span></th>
				<td><input type="text" name="cf_distillationpriceC"  class="w90p reqdata necdata" onchange="changeNumber(event,false);" title="증류탕전C"/></td>
				<th><span class="nec">36-D.증류탕전D<?=$txtdt[""]?><!--  --></span></th>
				<td><input type="text" name="cf_distillationpriceD"  class="w90p reqdata necdata" onchange="changeNumber(event,false);" title="증류탕전D"/></td>
				<th><span class="nec">36-E.증류탕전E<?=$txtdt[""]?><!--  --></span></th>
				<td><input type="text" name="cf_distillationpriceE"  class="w90p reqdata necdata" onchange="changeNumber(event,false);" title="증류탕전E"/></td>
			</tr>

			<tr>
				<th><span class="">37.건조탕전<?=$txtdt[""]?><!--  --></span></th>
				<td><input type="text" name="cf_dryprice"  class="w90p reqdata" onchange="changeNumber(event,false);" title="건조탕전"/></td>
				<th><span class="nec">37-A.건조탕전A<?=$txtdt[""]?><!--  --></span></th>
				<td><input type="text" name="cf_drypriceA"  class="w90p reqdata necdata" onchange="changeNumber(event,false);" title="건조탕전A"/></td>
				<th><span class="nec">37-B.건조탕전B<?=$txtdt[""]?><!--  --></span></th>
				<td><input type="text" name="cf_drypriceB"  class="w90p reqdata necdata" onchange="changeNumber(event,false);" title="건조탕전B"/></td>
			</tr>
			<tr>
				<th><span class="nec">37-C.건조탕전C<?=$txtdt[""]?><!--  --></span></th>
				<td><input type="text" name="cf_drypriceC"  class="w90p reqdata necdata" onchange="changeNumber(event,false);" title="건조탕전C"/></td>
				<th><span class="nec">37-D.건조탕전D<?=$txtdt[""]?><!--  --></span></th>
				<td><input type="text" name="cf_drypriceD"  class="w90p reqdata necdata" onchange="changeNumber(event,false);" title="건조탕전D"/></td>
				<th><span class="nec">37-E.건조탕전E<?=$txtdt[""]?><!--  --></span></th>
				<td><input type="text" name="cf_drypriceE"  class="w90p reqdata necdata" onchange="changeNumber(event,false);" title="건조탕전E"/></td>
			</tr>



			<tr>
				<th><span class="">38.첩제기본비<?=$txtdt[""]?><!--  --></span></th>
				<td><input type="text" name="cf_cheobbaseprice"  class="w90p reqdata" onchange="changeNumber(event,false);" title="첩제기본비"/></td>
				<th><span class="nec">38-A.첩제기본비A<?=$txtdt[""]?><!--  --></span></th>
				<td><input type="text" name="cf_cheobbasepriceA"  class="w90p reqdata necdata" onchange="changeNumber(event,false);" title="첩제기본비A"/></td>
				<th><span class="nec">38-B.첩제기본비B<?=$txtdt[""]?><!--  --></span></th>
				<td><input type="text" name="cf_cheobbasepriceB"  class="w90p reqdata necdata" onchange="changeNumber(event,false);" title="첩제기본비B"/></td>
			</tr>
			<tr>
				<th><span class="nec">38-C.첩제기본비C<?=$txtdt[""]?><!--  --></span></th>
				<td><input type="text" name="cf_cheobbasepriceC"  class="w90p reqdata necdata" onchange="changeNumber(event,false);" title="첩제기본비C"/></td>
				<th><span class="nec">38-D.첩제기본비D<?=$txtdt[""]?><!--  --></span></th>
				<td><input type="text" name="cf_cheobbasepriceD"  class="w90p reqdata necdata" onchange="changeNumber(event,false);" title="첩제기본비D"/></td>
				<th><span class="nec">38-E.첩제기본비E<?=$txtdt[""]?><!--  --></span></th>
				<td><input type="text" name="cf_cheobbasepriceE"  class="w90p reqdata necdata" onchange="changeNumber(event,false);" title="첩제기본비E"/></td>
			</tr>

			<tr>
				<th><span class="">39.첩제조제비<?=$txtdt[""]?><!--  --></span></th>
				<td><input type="text" name="cf_cheobmakingprice"  class="w90p reqdata" onchange="changeNumber(event,false);" title="첩제조제비"/></td>
				<th><span class="nec">39-A.첩제조제비A<?=$txtdt[""]?><!--  --></span></th>
				<td><input type="text" name="cf_cheobmakingpriceA"  class="w90p reqdata necdata" onchange="changeNumber(event,false);" title="첩제조제비A"/></td>
				<th><span class="nec">39-B.첩제조제비B<?=$txtdt[""]?><!--  --></span></th>
				<td><input type="text" name="cf_cheobmakingpriceB"  class="w90p reqdata necdata" onchange="changeNumber(event,false);" title="첩제조제비B"/></td>
			</tr>
			<tr>
				<th><span class="nec">39-C.첩제조제비C<?=$txtdt[""]?><!--  --></span></th>
				<td><input type="text" name="cf_cheobmakingpriceC"  class="w90p reqdata necdata" onchange="changeNumber(event,false);" title="첩제조제비C"/></td>
				<th><span class="nec">39-D.첩제조제비D<?=$txtdt[""]?><!--  --></span></th>
				<td><input type="text" name="cf_cheobmakingpriceD"  class="w90p reqdata necdata" onchange="changeNumber(event,false);" title="첩제조제비D"/></td>
				<th><span class="nec">39-E.첩제조제비E<?=$txtdt[""]?><!--  --></span></th>
				<td><input type="text" name="cf_cheobmakingpriceE"  class="w90p reqdata necdata" onchange="changeNumber(event,false);" title="첩제조제비E"/></td>
			</tr>

			<tr>
				<th><span class="">40.산제기본비<?=$txtdt[""]?><!--  --></span></th>
				<td><input type="text" name="cf_sanbaseprice"  class="w90p reqdata" onchange="changeNumber(event,false);" title="산제기본비"/></td>
				<th><span class="nec">40-A.산제기본비A<?=$txtdt[""]?><!--  --></span></th>
				<td><input type="text" name="cf_sanbasepriceA"  class="w90p reqdata necdata" onchange="changeNumber(event,false);" title="산제기본비A"/></td>
				<th><span class="nec">40-B.산제기본비B<?=$txtdt[""]?><!--  --></span></th>
				<td><input type="text" name="cf_sanbasepriceB"  class="w90p reqdata necdata" onchange="changeNumber(event,false);" title="산제기본비B"/></td>
			</tr>
			<tr>
				<th><span class="nec">40-C.산제기본비C<?=$txtdt[""]?><!--  --></span></th>
				<td><input type="text" name="cf_sanbasepriceC"  class="w90p reqdata necdata" onchange="changeNumber(event,false);" title="산제기본비C"/></td>
				<th><span class="nec">40-D.산제기본비D<?=$txtdt[""]?><!--  --></span></th>
				<td><input type="text" name="cf_sanbasepriceD"  class="w90p reqdata necdata" onchange="changeNumber(event,false);" title="산제기본비D"/></td>
				<th><span class="nec">40-E.산제기본비E<?=$txtdt[""]?><!--  --></span></th>
				<td><input type="text" name="cf_sanbasepriceE"  class="w90p reqdata necdata" onchange="changeNumber(event,false);" title="산제기본비E"/></td>
			</tr>

			<tr>
				<th><span class="">41.산제제분비<?=$txtdt[""]?><!--  --></span></th>
				<td><input type="text" name="cf_sanmillingprice"  class="w90p reqdata" onchange="changeNumber(event,false);" title="산제제분비"/></td>
				<th><span class="nec">41-A.산제제분비A<?=$txtdt[""]?><!--  --></span></th>
				<td><input type="text" name="cf_sanmillingpriceA"  class="w90p reqdata necdata" onchange="changeNumber(event,false);" title="산제제분비A"/></td>
				<th><span class="nec">41-B.산제제분비B<?=$txtdt[""]?><!--  --></span></th>
				<td><input type="text" name="cf_sanmillingpriceB"  class="w90p reqdata necdata" onchange="changeNumber(event,false);" title="산제제분비B"/></td>
			</tr>
			<tr>
				<th><span class="nec">41-C.산제제분비C<?=$txtdt[""]?><!--  --></span></th>
				<td><input type="text" name="cf_sanmillingpriceC"  class="w90p reqdata necdata" onchange="changeNumber(event,false);" title="산제제분비C"/></td>
				<th><span class="nec">41-D.산제제분비D<?=$txtdt[""]?><!--  --></span></th>
				<td><input type="text" name="cf_sanmillingpriceD"  class="w90p reqdata necdata" onchange="changeNumber(event,false);" title="산제제분비D"/></td>
				<th><span class="nec">41-E.산제제분비E<?=$txtdt[""]?><!--  --></span></th>
				<td><input type="text" name="cf_sanmillingpriceE"  class="w90p reqdata necdata" onchange="changeNumber(event,false);" title="산제제분비E"/></td>
			</tr>

			<tr>
				<th><span class="">42.산제배송비<?=$txtdt[""]?><!--  --></span></th>
				<td><input type="text" name="cf_sanreleaseprice"  class="w90p reqdata" onchange="changeNumber(event,false);" title="산제배송비"/></td>
				<th><span class="nec">42-A.산제배송비A<?=$txtdt[""]?><!--  --></span></th>
				<td><input type="text" name="cf_sanreleasepriceA"  class="w90p reqdata necdata" onchange="changeNumber(event,false);" title="산제배송비A"/></td>
				<th><span class="nec">42-B.산제배송비B<?=$txtdt[""]?><!--  --></span></th>
				<td><input type="text" name="cf_sanreleasepriceB"  class="w90p reqdata necdata" onchange="changeNumber(event,false);" title="산제배송비B"/></td>
			</tr>
			<tr>
				<th><span class="nec">42-C.산제배송비C<?=$txtdt[""]?><!--  --></span></th>
				<td><input type="text" name="cf_sanreleasepriceC"  class="w90p reqdata necdata" onchange="changeNumber(event,false);" title="산제배송비C"/></td>
				<th><span class="nec">42-D.산제배송비D<?=$txtdt[""]?><!--  --></span></th>
				<td><input type="text" name="cf_sanreleasepriceD"  class="w90p reqdata necdata" onchange="changeNumber(event,false);" title="산제배송비D"/></td>
				<th><span class="nec">42-E.산제배송비E<?=$txtdt[""]?><!--  --></span></th>
				<td><input type="text" name="cf_sanreleasepriceE"  class="w90p reqdata necdata" onchange="changeNumber(event,false);" title="산제배송비E"/></td>
			</tr>


			<tr>
				<th><span class="">43.100팩당1박스<?=$txtdt[""]?><!--  --></span></th>
				<td><input type="text" name="cf_box"  class="w90p reqdata" onchange="changeNumber(event,false);" title="<?=$txtdt[""]?>"/></td>
				<th><span class="">44.한약박스50팩당1박스<?=$txtdt[""]?><!--  --></span></th>
				<td><input type="text" name="cf_boxmedi"  class="w90p reqdata" onchange="changeNumber(event,false);" title="<?=$txtdt[""]?>"/></td>
				<th><span class="">45.주소위도<?=$txtdt[""]?><!--  --></span></th>
				<td><input type="text" name="cf_latitude"  class="w90p reqdata" title="<?=$txtdt[""]?>"/></td>
			</tr>
			<tr>
				<th><span class="">46.주소경도<?=$txtdt[""]?><!--  --></span></th>
				<td><input type="text" name="cf_longitude"  class="w90p reqdata" title="<?=$txtdt[""]?>"/></td>
				<th><span class="">47.영업시간<?=$txtdt[""]?><!--  --></span></th>
				<td><input type="text" name="cf_busihour"  class="w90p reqdata" title="<?=$txtdt[""]?>"/></td>
				<th><span class="">48.인증키<?=$txtdt[""]?><!--  --></span></th>
				<td><input type="text" name="cf_authkey"  class="w90p reqdata" title="<?=$txtdt[""]?>"/></td>
			</tr>
			<tr>
				<th><span class="">49.은행목록<?=$txtdt[""]?><!--  --></span></th>
				<td><input type="text" name="cf_banklist"  class="w90p reqdata" title="<?=$txtdt[""]?>"/></td>
				<th><span class="">50.메일서버<?=$txtdt[""]?><!--  --></span></th>
				<td><input type="text" name="cf_mailserver"  class="w90p reqdata" title="<?=$txtdt[""]?>"/></td>
				<th><span class="">51메일서버포트<?=$txtdt[""]?><!--  --></span></th>
				<td><input type="text" name="cf_mailport"  class="w90p reqdata" title="<?=$txtdt[""]?>"/></td>
			</tr>
			<tr>
				<th><span class="">52.메일발송이메일<?=$txtdt[""]?><!--  --></span></th>
				<td><input type="text" name="cf_mailsender"  class="w90p reqdata" title="<?=$txtdt[""]?>"/></td>
				<th><span class="">53.메일서버아이디<?=$txtdt[""]?><!--  --></span></th>
				<td><input type="text" name="cf_mailid"  class="w90p reqdata" title="<?=$txtdt[""]?>"/></td>
				<th><span class="">54.메일서버비번<?=$txtdt[""]?><!--  --></span></th>
				<td><input type="text" name="cf_mailpw"  class="w90p reqdata" title="<?=$txtdt[""]?>"/></td>
			</tr>
			<tr>
				<th><span class="">55.메일상단폼<?=$txtdt[""]?><!--  --></span></th>
				<td><input type="text" name="cf_mailhead"  class="w90p reqdata" title="<?=$txtdt[""]?>"/></td>
				<th><span class="">56.메일하단폼<?=$txtdt[""]?><!--  --></span></th>
				<td><input type="text" name="cf_mailtail"  class="w90p reqdata" title="<?=$txtdt[""]?>"/></td>
				<th><span class="">57.1차네임서버도메인<?=$txtdt[""]?><!--  --></span></th>
				<td><input type="text" name="cf_nsdomain1"  class="w90p reqdata" title="<?=$txtdt[""]?>"/></td>
			</tr>
			<tr>
				<th><span class="">58.1차네임서버아이피<?=$txtdt[""]?><!--  --></span></th>
				<td><input type="text" name="cf_nsip1"  class="w90p reqdata" title="<?=$txtdt[""]?>"/></td>
				<th><span class="">59.2차네임서버도메인<?=$txtdt[""]?><!--  --></span></th>
				<td><input type="text" name="cf_nsdomain2"  class="w90p reqdata" title="<?=$txtdt[""]?>"/></td>
				<th><span class="">60.2차네임서버아이피<?=$txtdt[""]?><!--  --></span></th>
				<td><input type="text" name="cf_nsip2"  class="w90p reqdata" title="<?=$txtdt[""]?>"/></td>
			</tr>
			<tr>
				<th><span class="">61.3차네임서버도메인<?=$txtdt[""]?><!--  --></span></th>
				<td><input type="text" name="cf_nsdomain3"  class="w90p reqdata" title="<?=$txtdt[""]?>"/></td>
				<th><span class="">62.3차네임서버아이피<?=$txtdt[""]?><!--  --></span></th>
				<td><input type="text" name="cf_nsip3"  class="w90p reqdata" title="<?=$txtdt[""]?>"/></td>
				<th><span class="">63.4차네임서버도메인<?=$txtdt[""]?><!--  --></span></th>
				<td><input type="text" name="cf_nsdomain4"  class="w90p reqdata" title="<?=$txtdt[""]?>"/></td>
			</tr>

			<tr>
				<th><span class="">64.4차네임서버아이피<?=$txtdt[""]?><!--  --></span></th>
				<td><input type="text" name="cf_nsip4"  class="w90p reqdata" title="<?=$txtdt[""]?>"/></td>
				<th><span class="">65.이용약관<?=$txtdt[""]?><!--  --></span></th>
				<td><input type="text" name="cf_agreement"  class="w90p reqdata" title="<?=$txtdt[""]?>"/></td>
				<th><span class="">66.개인정보보호정책<?=$txtdt[""]?><!--  --></span></th>
				<td><input type="text" name="cf_privacy"  class="w90p reqdata" title="<?=$txtdt[""]?>"/></td>
			</tr>
			<tr>
				<th><span class="">67.쿠폰<?=$txtdt[""]?><!--  --></span></th>
				<td><input type="text" name="cf_coupon"  class="w90p reqdata" title="<?=$txtdt[""]?>"/></td>
				<th><span class="">68.대표도메인<?=$txtdt[""]?><!--  --></span></th>
				<td><input type="text" name="cf_domain"  class="w90p reqdata" title="<?=$txtdt[""]?>"/></td>
				<th><span class="">69.웹포트(80,443)<?=$txtdt[""]?><!--  --></span></th>
				<td><input type="text" name="cf_webport"  class="w90p reqdata" title="<?=$txtdt[""]?>"/></td>
			</tr>

				<tr>
				<th><span class="">70.ftp 호스트<?=$txtdt[""]?><!--  --></span></th>
				<td><input type="text" name="cf_ftphost"  class="w90p reqdata" title="<?=$txtdt[""]?>"/></td>
				<th><span class="">71.ftp 포트<?=$txtdt[""]?><!--  --></span></th>
				<td><input type="text" name="cf_ftpport"  class="w90p reqdata" title="<?=$txtdt[""]?>"/></td>
				<th><span class="">72.ftp 아이디<?=$txtdt[""]?><!--  --></span></th>
				<td><input type="text" name="cf_ftpuser"  class="w90p reqdata" title="<?=$txtdt[""]?>"/></td>
			</tr>	
				<tr>
				<th><span class="">73.ftp 비번<?=$txtdt[""]?><!--  --></span></th>
				<td><input type="text" name="cf_ftppass"  class="w90p reqdata" title="<?=$txtdt[""]?>"/></td>
				<th><span class="">74.ftp 디렉토리<?=$txtdt[""]?><!--  --></span></th>
				<td><input type="text" name="cf_ftpdir"  class="w90p reqdata" title="<?=$txtdt[""]?>"/></td>
				<th><span class="">75.db 호스트<?=$txtdt[""]?><!--  --></span></th>
				<td><input type="text" name="cf_dbhost"  class="w90p reqdata" title="<?=$txtdt[""]?>"/></td>
			</tr>
				<tr>
				<th><span class="">76.db 포트<?=$txtdt[""]?><!--  --></span></th>
				<td><input type="text" name="cf_dbport"  class="w90p reqdata" title="<?=$txtdt[""]?>"/></td>
				<th><span class="">77.db 명<?=$txtdt[""]?><!--  --></span></th>
				<td><input type="text" name="cf_dbname"  class="w90p reqdata" title="<?=$txtdt[""]?>"/></td>
				<th><span class="">78.db 아이디<?=$txtdt[""]?><!--  --></span></th>
				<td><input type="text" name="cf_dbuser"  class="w90p reqdata" title="<?=$txtdt[""]?>"/></td>
			</tr>
				<tr>
				<th><span class="">79.db 비번<?=$txtdt[""]?><!--  --></span></th>
				<td><input type="text" name="cf_dbpass"  class="w90p reqdata" title="<?=$txtdt[""]?>"/></td>
				<th><span class="">80.문자발송회사<?=$txtdt[""]?><!--  --></span></th>
				<td><input type="text" name="cf_smscompany"  class="w90p reqdata" title="<?=$txtdt[""]?>"/></td>
				<th><span class="">81.문자발송url<?=$txtdt[""]?><!--  --></span></th>
				<td><input type="text" name="cf_smsurl"  class="w90p reqdata" title="<?=$txtdt[""]?>"/></td>
			</tr>
				<tr>
				<th><span class="">82.문자발송아이디<?=$txtdt[""]?><!--  --></span></th>
				<td><input type="text" name="cf_smsid"  class="w90p reqdata" title="<?=$txtdt[""]?>"/></td>
				<th><span class="">83.문자발송비번<?=$txtdt[""]?><!--  --></span></th>
				<td><input type="text" name="cf_smspw"  class="w90p reqdata" title="<?=$txtdt[""]?>"/></td>
				<th><span class="">84.문자발송전화번호<?=$txtdt[""]?><!--  --></span></th>
				<td><input type="text" name="cf_smsmobile"  class="w90p reqdata" title="<?=$txtdt[""]?>"/></td>
			</tr>
				<tr>
				<th><span class="">85.문자발송남은횟수<?=$txtdt[""]?><!--  --></span></th>
				<td><input type="text" name="cf_smsremain"  class="w90p reqdata" title="<?=$txtdt[""]?>"/></td>
				<th><span class="">86.문자발송리턴url<?=$txtdt[""]?><!--  --></span></th>
				<td><input type="text" name="cf_smsreurl"  class="w90p reqdata" title="<?=$txtdt[""]?>"/></td>
				<th><span class="">87.사이트상태<?=$txtdt[""]?><!--  --></span></th>
				<td><input type="text" name="cf_status"  class="w90p reqdata" title="<?=$txtdt[""]?>"/></td>

		</tbody>
	</table>

    <div class="btn-box c">
			<?if($modifyAuth == "true"){?>
				<a href="javascript:configupdate();" class="bdp-btn"><span class=""><?=$txtdt["1070"]?><!-- 등록/수정 --></span></a>
			<?}?>
    </div>
</div>



<div class="gap"></div>
<!-- s : 게시판 페이징 -->
<div class='' id="textdblistpage"></div>
<!-- e : 게시판 페이징 -->

<!--// page end -->
<script>

	function repageload(){
		console.log("no  repageload ");
	}

	function configupdate()
	{
		var key=data="";
		var jsondata={};
		if(necdata()=="Y")
		{
			$(".reqdata").each(function(){
				key=$(this).attr("name");
				data=$(this).val();
				jsondata[key] = data;
			});

			console.log(JSON.stringify(jsondata));

			callapi("POST","setting","configupdate",jsondata);
			viewpage();
		}
	}

	function makepage(json)
	{
		var obj = JSON.parse(json);
		console.log(obj);

		if(obj["apiCode"]=="configdesc") //config 상세
		{
			$("input[name=cf_code]").val(obj["cf_code"]); 
			$("input[name=cf_company]").val(obj["cf_company"]);
			$("input[name=cf_companyeng]").val(obj["cf_companyeng"]);
			$("input[name=cf_slogan]").val(obj["cf_slogan"]);
			$("input[name=cf_making]").val(obj["cf_making"]);
			
			$("input[name=cf_makingtable]").val(obj["cf_makingtable"]);
			$("input[name=cf_greeting]").val(obj["cf_greeting"]);
			$("input[name=cf_establish]").val(obj["cf_establish"]);
			$("input[name=cf_email]").val(obj["cf_email"]);
			$("input[name=cf_business1]").val(obj["cf_business1"]);

			$("input[name=cf_business2]").val(obj["cf_business2"]);
			$("input[name=cf_phone]").val(obj["cf_phone"]);
			$("input[name=cf_fax]").val(obj["cf_fax"]);
			$("input[name=cf_ceo]").val(obj["cf_ceo"]);
			$("input[name=cf_ceomobile]").val(obj["cf_ceomobile"]);
			
			$("input[name=cf_ceoemail]").val(obj["cf_ceoemail"]);
			$("input[name=cf_cio]").val(obj["cf_cio"]);
			$("input[name=cf_ciomobile]").val(obj["cf_ciomobile"]);
			$("input[name=cf_cioemail]").val(obj["cf_cioemail"]);
			$("input[name=cf_staff]").val(obj["cf_staff"]);

			$("input[name=cf_staffmobile]").val(obj["cf_staffmobile"]);
			$("input[name=cf_staffemail]").val(obj["cf_staffemail"]);
			$("input[name=cf_businessno]").val(obj["cf_businessno"]);
			$("input[name=cf_salesno]").val(obj["cf_salesno"]);
			$("input[name=cf_zipcode]").val(obj["cf_zipcode"]);
			
			$("input[name=cf_address]").val(obj["cf_address"]);
			$("input[name=cf_addresseng]").val(obj["cf_addresseng"]);

			$("input[name=cf_makingprice]").val(obj["cf_makingprice"]);
			$("input[name=cf_makingpriceA]").val(obj["cf_makingpriceA"]);
			$("input[name=cf_makingpriceB]").val(obj["cf_makingpriceB"]);
			$("input[name=cf_makingpriceC]").val(obj["cf_makingpriceC"]);
			$("input[name=cf_makingpriceD]").val(obj["cf_makingpriceD"]);
			$("input[name=cf_makingpriceE]").val(obj["cf_makingpriceE"]);

			$("input[name=cf_decocprice").val(obj["cf_decocprice"]);
			$("input[name=cf_decocpriceA").val(obj["cf_decocpriceA"]);
			$("input[name=cf_decocpriceB").val(obj["cf_decocpriceB"]);
			$("input[name=cf_decocpriceC").val(obj["cf_decocpriceC"]);
			$("input[name=cf_decocpriceD").val(obj["cf_decocpriceD"]);
			$("input[name=cf_decocpriceE").val(obj["cf_decocpriceE"]);

			$("input[name=cf_releaseprice]").val(obj["cf_releaseprice"]);
			$("input[name=cf_releasepriceA]").val(obj["cf_releasepriceA"]);
			$("input[name=cf_releasepriceB]").val(obj["cf_releasepriceB"]);
			$("input[name=cf_releasepriceC]").val(obj["cf_releasepriceC"]);
			$("input[name=cf_releasepriceD]").val(obj["cf_releasepriceD"]);
			$("input[name=cf_releasepriceE]").val(obj["cf_releasepriceE"]);

			$("input[name=cf_packingprice]").val(obj["cf_packingprice"]);
			$("input[name=cf_packingpriceA]").val(obj["cf_packingpriceA"]);
			$("input[name=cf_packingpriceB]").val(obj["cf_packingpriceB"]);
			$("input[name=cf_packingpriceC]").val(obj["cf_packingpriceC"]);
			$("input[name=cf_packingpriceD]").val(obj["cf_packingpriceD"]);
			$("input[name=cf_packingpriceE]").val(obj["cf_packingpriceE"]);

			$("input[name=cf_afterprice]").val(obj["cf_afterprice"]);
			$("input[name=cf_afterpriceA]").val(obj["cf_afterpriceA"]);
			$("input[name=cf_afterpriceB]").val(obj["cf_afterpriceB"]);
			$("input[name=cf_afterpriceC]").val(obj["cf_afterpriceC"]);
			$("input[name=cf_afterpriceD]").val(obj["cf_afterpriceD"]);
			$("input[name=cf_afterpriceE]").val(obj["cf_afterpriceE"]);

			$("input[name=cf_firstprice]").val(obj["cf_firstprice"]);
			$("input[name=cf_firstpriceA]").val(obj["cf_firstpriceA"]);
			$("input[name=cf_firstpriceB]").val(obj["cf_firstpriceB"]);
			$("input[name=cf_firstpriceC]").val(obj["cf_firstpriceC"]);
			$("input[name=cf_firstpriceD]").val(obj["cf_firstpriceD"]);
			$("input[name=cf_firstpriceE]").val(obj["cf_firstpriceE"]);

			$("input[name=cf_cheobprice]").val(obj["cf_cheobprice"]);
			$("input[name=cf_cheobpriceA]").val(obj["cf_cheobpriceA"]);
			$("input[name=cf_cheobpriceB]").val(obj["cf_cheobpriceB"]);
			$("input[name=cf_cheobpriceC]").val(obj["cf_cheobpriceC"]);
			$("input[name=cf_cheobpriceD]").val(obj["cf_cheobpriceD"]);
			$("input[name=cf_cheobpriceE]").val(obj["cf_cheobpriceE"]);

			//주수상반
			$("input[name=cf_alcoholprice]").val(obj["cf_alcoholprice"]);
			$("input[name=cf_alcoholpriceA]").val(obj["cf_alcoholpriceA"]);
			$("input[name=cf_alcoholpriceB]").val(obj["cf_alcoholpriceB"]);
			$("input[name=cf_alcoholpriceC]").val(obj["cf_alcoholpriceC"]);
			$("input[name=cf_alcoholpriceD]").val(obj["cf_alcoholpriceD"]);
			$("input[name=cf_alcoholpriceE]").val(obj["cf_alcoholpriceE"]);

			//증류탕전
			$("input[name=cf_distillationprice]").val(obj["cf_distillationprice"]);
			$("input[name=cf_distillationpriceA]").val(obj["cf_distillationpriceA"]);
			$("input[name=cf_distillationpriceB]").val(obj["cf_distillationpriceB"]);
			$("input[name=cf_distillationpriceC]").val(obj["cf_distillationpriceC"]);
			$("input[name=cf_distillationpriceD]").val(obj["cf_distillationpriceD"]);
			$("input[name=cf_distillationpriceE]").val(obj["cf_distillationpriceE"]);

			//건조탕전
			$("input[name=cf_dryprice]").val(obj["cf_dryprice"]);
			$("input[name=cf_drypriceA]").val(obj["cf_drypriceA"]);
			$("input[name=cf_drypriceB]").val(obj["cf_drypriceB"]);
			$("input[name=cf_drypriceC]").val(obj["cf_drypriceC"]);
			$("input[name=cf_drypriceD]").val(obj["cf_drypriceD"]);
			$("input[name=cf_drypriceE]").val(obj["cf_drypriceE"]);

			//첩제기본비
			$("input[name=cf_cheobbaseprice]").val(obj["cf_cheobbaseprice"]);
			$("input[name=cf_cheobbasepriceA]").val(obj["cf_cheobbasepriceA"]);
			$("input[name=cf_cheobbasepriceB]").val(obj["cf_cheobbasepriceB"]);
			$("input[name=cf_cheobbasepriceC]").val(obj["cf_cheobbasepriceC"]);
			$("input[name=cf_cheobbasepriceD]").val(obj["cf_cheobbasepriceD"]);
			$("input[name=cf_cheobbasepriceE]").val(obj["cf_cheobbasepriceE"]);
			//첩제조제비
			$("input[name=cf_cheobmakingprice]").val(obj["cf_cheobmakingprice"]);
			$("input[name=cf_cheobmakingpriceA]").val(obj["cf_cheobmakingpriceA"]);
			$("input[name=cf_cheobmakingpriceB]").val(obj["cf_cheobmakingpriceB"]);
			$("input[name=cf_cheobmakingpriceC]").val(obj["cf_cheobmakingpriceC"]);
			$("input[name=cf_cheobmakingpriceD]").val(obj["cf_cheobmakingpriceD"]);
			$("input[name=cf_cheobmakingpriceE]").val(obj["cf_cheobmakingpriceE"]);

			//산제기본비
			$("input[name=cf_sanbaseprice]").val(obj["cf_sanbaseprice"]);
			$("input[name=cf_sanbasepriceA]").val(obj["cf_sanbasepriceA"]);
			$("input[name=cf_sanbasepriceB]").val(obj["cf_sanbasepriceB"]);
			$("input[name=cf_sanbasepriceC]").val(obj["cf_sanbasepriceC"]);
			$("input[name=cf_sanbasepriceD]").val(obj["cf_sanbasepriceD"]);
			$("input[name=cf_sanbasepriceE]").val(obj["cf_sanbasepriceE"]);
			//산제제분비
			$("input[name=cf_sanmillingprice]").val(obj["cf_sanmillingprice"]);
			$("input[name=cf_sanmillingpriceA]").val(obj["cf_sanmillingpriceA"]);
			$("input[name=cf_sanmillingpriceB]").val(obj["cf_sanmillingpriceB"]);
			$("input[name=cf_sanmillingpriceC]").val(obj["cf_sanmillingpriceC"]);
			$("input[name=cf_sanmillingpriceD]").val(obj["cf_sanmillingpriceD"]);
			$("input[name=cf_sanmillingpriceE]").val(obj["cf_sanmillingpriceE"]);
			//산제배송비 
			$("input[name=cf_sanreleaseprice]").val(obj["cf_sanreleaseprice"]);
			$("input[name=cf_sanreleasepriceA]").val(obj["cf_sanreleasepriceA"]);
			$("input[name=cf_sanreleasepriceB]").val(obj["cf_sanreleasepriceB"]);
			$("input[name=cf_sanreleasepriceC]").val(obj["cf_sanreleasepriceC"]);
			$("input[name=cf_sanreleasepriceD]").val(obj["cf_sanreleasepriceD"]);
			$("input[name=cf_sanreleasepriceE]").val(obj["cf_sanreleasepriceE"]);


			$("input[name=cf_box]").val(obj["cf_box"]);
			$("input[name=cf_boxmedi]").val(obj["cf_boxmedi"]);
			$("input[name=cf_latitude]").val(obj["cf_latitude"]);
			$("input[name=cf_longitude]").val(obj["cf_longitude"]);
			$("input[name=cf_busihour]").val(obj["cf_busihour"]);
			
			$("input[name=cf_authkey]").val(obj["cf_authkey"]);
			$("input[name=cf_banklist]").val(obj["cf_banklist"]);
			$("input[name=cf_mailserver]").val(obj["cf_mailserver"]);
			$("input[name=cf_mailport").val(obj["cf_mailport"]);
			$("input[name=cf_mailsender]").val(obj["cf_mailsender"]);

			$("input[name=cf_mailid]").val(obj["cf_mailid"]);
			$("input[name=cf_mailpw]").val(obj["cf_mailpw"]);
			$("input[name=cf_mailhead]").val(obj["cf_mailhead"]);
			$("input[name=cf_mailtail]").val(obj["cf_mailtail"]);
			$("input[name=cf_nsdomain1]").val(obj["cf_nsdomain1"]);
			
			$("input[name=cf_nsip1]").val(obj["cf_nsip1"]);
			$("input[name=cf_nsdomain2]").val(obj["cf_nsdomain2"]);
			$("input[name=cf_nsip2]").val(obj["cf_nsip2"]);
			$("input[name=cf_nsdomain3]").val(obj["cf_nsdomain3"]);
			$("input[name=cf_nsip3]").val(obj["cf_nsip3"]);

			$("input[name=cf_nsdomain4]").val(obj["cf_nsdomain4"]);
			$("input[name=cf_nsip4]").val(obj["cf_nsip4"]);
			$("input[name=cf_agreement]").val(obj["cf_agreement"]);
			$("input[name=cf_privacy]").val(obj["cf_privacy"]);
			$("input[name=cf_coupon]").val(obj["cf_coupon"]);
			
			$("input[name=cf_domain]").val(obj["cf_domain"]);
			$("input[name=cf_webport]").val(obj["cf_webport"]);
			$("input[name=cf_ftphost]").val(obj["cf_ftphost"]);
			$("input[name=cf_ftpport]").val(obj["cf_ftpport"]);
			$("input[name=cf_ftpuser]").val(obj["cf_ftpuser"]);

			$("input[name=cf_ftppass]").val(obj["cf_ftppass"]);
			$("input[name=cf_ftpdir]").val(obj["cf_ftpdir"]);
			$("input[name=cf_dbhost]").val(obj["cf_dbhost"]);
			$("input[name=cf_dbport]").val(obj["cf_dbport"]);
			$("input[name=cf_dbname]").val(obj["cf_dbname"]);
			
			$("input[name=cf_dbuser]").val(obj["cf_dbuser"]);
			$("input[name=cf_dbpass]").val(obj["cf_dbpass"]);
			$("input[name=cf_smscompany]").val(obj["cf_smscompany"]);
			$("input[name=cf_smsurl]").val(obj["cf_smsurl"]);
			$("input[name=cf_smsid]").val(obj["cf_smsid"]);

			$("input[name=cf_smspw]").val(obj["cf_smspw"]);
			$("input[name=cf_smsmobile]").val(obj["cf_smsmobile"]);
			$("input[name=cf_smsremain]").val(obj["cf_smsremain"]);
			$("input[name=cf_smsreurl]").val(obj["cf_smsreurl"]);
			$("input[name=cf_status]").val(obj["cf_status"]);
	   }
	}

	callapi('GET','setting','configdesc','<?=$apidata?>'); //config API 호출 
</script>