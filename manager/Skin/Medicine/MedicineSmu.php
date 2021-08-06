<?php //약재목록_세명대 
$root = "../..";
include_once ($root.'/_common.php');
?>
<style>
	dl.dismedi dd{min-width:19%;display:block;float:left;text-align:center;padding:5px;margin:0 3px 0 3px;border:1px solid #aaa;}
	dl.dismedi dd:hover{cursor:pointer;font-weight:bold;}
	div.smuleft {width:20%;height:30px;float:left;text-align: left;}
	div.smuright {width:80%;height:30px;float:left;text-align: left;font-size:15px;color:#111;font-weight:bold;}
	.sminput{line-height:200%;}
	.sminput span, .sminput input{float:left;margin-left:10px;margin-top:10px;}
	.sminput span{clear:left;line-height:200%;margin-left:0;}
	.mdsweet{background-color:#f2C2D6;}/*별전*/
	.mdmedi{background-color:#8BE0ED;}/*약재*/
	.sugar{background-color:#01DF74;} /*감미제*/
	.alcohol{background-color:#D7BDE2;} /*청주*/
	span.mdtype{display:inline-block;width:15px;height:15px;border-radius:50%;margin-right:5px;line-height:100%;vertical-align:middle;}
</style>
<!--// page start -->

<input type="hidden" name="seq" class="reqdata" value="<?=$_GET["seq"]?>">
<input type="hidden" class="reqdata" name="mdCode" title="<?=$txtdt["1213"]?>"/>
<input type="hidden" class="reqdata " name="smuCode" title="<?=$txtdt["1213"]?>_<?=$txtdt["1750"]?>" /> 
<input type="hidden" name="returnData" class="reqdata" value="<?=$root?>/03_Medicine/MedicineSmu.php">

<div id="pagegroup" value="medicine"></div>
<div id="pagecode" value="medicinesmulist"></div>

<div class="board-ov-wrap">

    <!--// left -->
    <div class="fl">
		<h3 class="u-tit02"><?=$txtdt["1200"]?><!-- 약재관리--></h3>
		<div class="board-view-wrap">
			<span class="bd-line"></span>
			<table>
				<caption><span class="blind"></span></caption>
				<colgroup>
					<col width="25%">
					<col width="25%">
					<col width="25%">
					<col width="25%">
				</colgroup>
				<tbody>
					<tr>
						<th class="l"><span class="nec"><?=$txtdt["1213"]?>_Base<!-- 약재코드 --></span></th>
						<td colspan="3">
							<div class="smuleft" title="<?=$txtdt["1213"]?>_Base">
								<input type="text" class="w200 reqdata necdata" id="djmediCode" name="djmediCode" title="<?=$txtdt["1213"]?>_Base"  disabled   style="border-width:0px;"/> 
							</div>							
							<div class="smuright">
								<a href="javascript:;" onclick="javascript:viewlayerPopup(this);" data-bind="layer-medicinesmu" data-value="700,600">
									<button type="button" class="cw-btn" style="float:left;margin-left:50px;"><span>+ <?=$txtdt["1199"]?><!-- 약재검색 --></span></button>
								</a>
							</div>
						</td>
					</tr>
					<tr>
						<th class="l"><span class=""><?=$txtdt["1204"]?>_Base<!-- 약재명 --></span></th>
						<td colspan="3">
							<div class="smuleft"><?=$txtdt["1718"]?> : </div><div id="djmediNameKor" class="smuright"></div>
							<div class="smuleft"><?=$txtdt["1735"]?> : </div><div id="djmediNameChn" class="smuright"></div>
						</td>
					</tr>
					<tr>
						<!-- <th class="l"><span class=""><?=$txtdt["1213"]?><!-- 약재코드--></span></th>
						<!-- <td colspan="3">  -->
							
							<!-- <div id="BtnCheckDiv" style="float:right;"> -->
								<!-- <a href="javascript:;" onclick="smuCodeOnKeyup()" >
									<button type="button" id="chksmuCode" class="cp-btn"><span><?=$txtdt["1314"]?><!--중복확인 --><!-- </span></button>
								</a> 							 -->
							<!-- </div> -->
							
						<!-- </td> -->
					</tr>
					<tr>
						<th class="l"><span class="nec"><?=$txtdt["1204"]?><!-- 약재명 --></span></th>
						<td colspan="3" class="sminput">
							<span class=""><?=$txtdt["1718"]?></span><input type="text" class="w80p reqdata necdata" name="smuNameKor" title="<?=$txtdt["1204"]?>"/>
							<span class=""><?=$txtdt["1735"]?></span><input type="text" class="w80p reqdata" name="smuNameChn" title="<?=$txtdt["1204"]?>" />
						</td>
					</tr>
					<tr>
						<th class="l"><span class="nec"><?=$txtdt["1213"]?><!-- 약재코드 --></span></th>
						<td colspan="3" >
							</span><input type="text" class="w80p reqdata necdata" name="mm_code" title="<?=$txtdt["1237"]?>" onblur="mmcode_check()"/>
							<div id="chksmuText"></div> 							
								<input type="hidden" id="idchk" name="idchk" value="0">				
						</td>
					</tr>
					<tr>
						<th class="l"><span class="nec"><?=$txtdt["1237"]?><!-- 원산지 --></span></th>
						<td colspan="3" >
							<input type="text" class="w80p reqdata necdata" name="md_origin" title="<?=$txtdt["1237"]?>" readonly/>
						</td>					
					</tr>
					<tr>
						<th class="l"><span class="nec"><?=$txtdt["1288"]?><!-- 제조사 --></span></th>
						<td colspan="3" >
							<input type="text" class="w80p reqdata necdata" name="md_maker" title="<?=$txtdt["1288"]?>" readonly/>
						</td>
					</tr>
					<tr>
						<th class="l"><span class="nec"><?=$txtdt["1549"]?><!-- 적정수량 --></span></th>
						<td colspan="3" >
							<input type="text" class="w80p reqdata necdata" name="md_stable" title="<?=$txtdt["1549"]?>" />
						</td>
					</tr>
					<tr>
						<th class="l"><span class="nec"><?=$txtdt["1037"]?><!-- 금액 --></span></th>
						<td colspan="1" >
							<input type="text" class="w80p reqdata necdata" name="md_price" title="<?=$txtdt["1037"]?>" maxlength="10" onfocus="this.select();" onchange="changeNumber(event,true);"/>
						</td>
						<th class="l"><span class="nec"><?=$txtdt["1037"]?>C<!-- 금액 --></span></th>
						<td colspan="1" >
							<input type="text" class="w80p reqdata necdata" name="md_priceC" title="<?=$txtdt["1037"]?>A" maxlength="10" onfocus="this.select();" onchange="changeNumber(event,true);"/>
						</td>
					</tr>
					<tr>
						<th class="l"><span class="nec"><?=$txtdt["1037"]?>A<!-- 금액 --></span></th>
						<td colspan="1" >
							<input type="text" class="w80p reqdata necdata" name="md_priceA" title="<?=$txtdt["1037"]?>B" maxlength="10" onfocus="this.select();" onchange="changeNumber(event,true);"/>
						</td>
						<th class="l"><span class="nec"><?=$txtdt["1037"]?>D<!-- 금액 --></span></th>
						<td colspan="1" >
							<input type="text" class="w80p reqdata necdata" name="md_priceD" title="<?=$txtdt["1037"]?>C" maxlength="10" onfocus="this.select();" onchange="changeNumber(event,true);"/>
						</td>
					</tr>
					<tr>
						<th class="l"><span class="nec"><?=$txtdt["1037"]?>B<!-- 금액 --></span></th>
						<td colspan="1" >
							<input type="text" class="w80p reqdata necdata" name="md_priceB" title="<?=$txtdt["1037"]?>D" maxlength="10" onfocus="this.select();" onchange="changeNumber(event,true);"/>
						</td>
						<th class="l"><span class="nec"><?=$txtdt["1037"]?>E<!-- 금액 --></span></th>
						<td colspan="1" >
							<input type="text" class="w80p reqdata necdata" name="md_priceE" title="<?=$txtdt["1037"]?>E" maxlength="10" onfocus="this.select();" onchange="changeNumber(event,true);"/>
						</td>
					</tr>
					<tr>
						<th class="l"><span class=""><?=$txtdt["1144"]?><!-- 사용 --></span></th>
						<td colspan="3">	
							<div id="mmUseDiv">						
								<input type='radio' class='radiodata' name='mm_use' name='Y' value='Y' checked style="border:1px solid red;margin-right:5px;margin-left:1px;"/>Yes<br>
								<input type='radio' class='radiodata' name='mm_use' name='N' value='N' style="margin-right:5px;margin-left:1px;" />No 						
							</div>
						</td>
					</tr>
				</tbody>
		   </table>
		</div>
		<div class="btn-box c" id="BtnDiv">
		</div>
    </div>

    <!--// right -->
	<div class="fr ov-cont">
		<h3 class="u-tit02"><?=$txtdt["1205"]?><!-- 약재목록_세명대 --></h3>
		<div class="board-list-wrap">
			<span class="bd-line"></span>
			<div class="list-select">
                <p class="fl" style="margin-top:5px;">					
					<span class="mdtype mdmedi"></span><?=$txtdt["1497"]?><!-- 약재 -->,&nbsp;&nbsp;&nbsp;&nbsp;
					<span class="mdtype mdsweet"></span><?=$txtdt["1115"]?><!-- 별전 -->,&nbsp;&nbsp;
					<span class="mdtype sugar"></span><?=$txtdt["1703"]?><!-- 감미제(앰플) -->&nbsp;&nbsp;
					<span class="mdtype alcohol"></span>청주&nbsp;&nbsp;					
					<span id="pagecnt" class="tcnt"></span>
                </p>
                <p class="fr"><?=selectsearch()?></p>
            </div>
			<table id="tbllist" class="tblcss">
				<caption><span class="blind"></span></caption>
				<colgroup>
					<col scope="col" width="16%">
					<col scope="col" width="15%">
					<col scope="col" width="20%">
					<col scope="col" width="17%">
					<col scope="col" width="12%">
					<col scope="col" width="12%">
					<col scope="col" width="*%">
				</colgroup>
				<thead>
					<tr>
						<th><?=$txtdt["1213"]?>_<?=$txtdt["1725"]?><!-- 약재코드_세명대 --></th>
						<th><?=$txtdt["1204"]?>_<?=$txtdt["1725"]?><!-- 약재명_세명대 --></th>
						<th><?=$txtdt["1213"]?>_<?=$txtdt["1750"]?><!-- 약재코드_한퓨어 원외탕전실 --></th>
						<th><?=$txtdt["1204"]?>_<?=$txtdt["1750"]?><!-- 약제명_한퓨어 원외탕전실 --></th>
						<th><?=$txtdt["1237"]?><!-- 원산지 --></th>
						<th><?=$txtdt["1288"]?><!-- 제조사 --></th>
						<th><?=$txtdt["1588"]?><!-- 가격 --></th>
					</tr>
				</thead>
				<tbody>
				</tbody>
			</table>
		</div>
		<div class="sgap"></div>

		<!-- s : 게시판 페이징 -->
		<div class='paging-wrap' id="medismulistpage"></div>
		<!-- e : 게시판 페이징 -->
	</div>
</div>

<script>

	//영문 혼합 체크와 아이디 중복확인
	function mmcode_check()
	{
		$(".chksmuText").html('');
		$("input[name=idchk]").val(0);
		var mmcode=$("input[name=mm_code]").val();
		var apidata = "smuCode="+mmcode;
		callapi('GET','medicine','chksmumedicinecode',apidata);
		return false;		
	}

/*
	function smuCodeOnKeyup()
	{
		if(!isEmpty($("input[name=smuCode]").val()))
		{
			$("#chksmuCode").addClass("smucheck");
			var data = "smuCode="+$("input[name=smuCode]").val();
			callapi('GET','medicine','chksmumedicinecode',data); //약재코드 중복 체크 
		}
		else
		{
			alertsign("warning", "<?=$txtdt['1755']?>", "", "2000"); //약재코드를 입력해 주세요.
		}
	}
*/
    function medismu_desc(seq)  //리스트 누르면 상세 출력
    {
		addMediSmu('');
		var hdata=location.hash.replace("#","").split("|");
		var page=hdata[0];
		if(page==undefined){page="";}
		var search=hdata[2];
		if(search ===undefined){search="";}
		$("#idchk").val(1);
		
		makehash(page,seq,search)  
    }

    function medismu_update()//등록&수정
    {	
		var idchk=$("input[name=idchk]").val();
		console.log("idchk >>>"+idchk);

		//if(isEmpty($("input[name=seq]").val())) //신규 
		//{
			if(necdata()=="Y") //필수조건 체크
			{

				if(idchk==1) //중복확인이 1이어야 등록가능
				{
					console.log("11111111111111111111");
					var key=data="";
					var jsondata={};

					//radio data
					$(".radiodata").each(function()
					{
						key=$(this).attr("name");
						data=$(":input:radio[name="+key+"]:checked").val();
						jsondata[key] = data;
					});

					$(".reqdata").each(function()
					{
						key=$(this).attr("name");
						data=$(this).val();
						jsondata[key] = data;
					});
					console.log(JSON.stringify(jsondata));
					callapi("POST","medicine","medicinesmuupdate",jsondata); //약재 세명대 등록&수정 

					//페이지초기화 1초후
					setTimeout("resetpage('')",1000);
				
				}
				else
				{
					console.log("222222222222222");
					alertsign("warning", "<?=$txtdt['1754']?>", "", "2000"); //중복약재코드입니다.
				}
			}
			/*
		}
		else
		{
			if(necdata()=="Y") //필수조건 체크
			{
				var key=data="";
				var jsondata={};

				//radio data
				$(".radiodata").each(function()
				{
					key=$(this).attr("name");
					data=$(":input:radio[name="+key+"]:checked").val();
					jsondata[key] = data;
				});

				$(".reqdata").each(function()
				{
					key=$(this).attr("name");
					data=$(this).val();
					jsondata[key] = data;
				});
				console.log(JSON.stringify(jsondata));
				callapi("POST","medicine","medicinesmuupdate",jsondata); //약재 세명대 등록&수정 

				//페이지초기화 1초후
				setTimeout("resetpage('')",1000);
			}
		}
		*/
    }

	//등록/수정되면 페이지가 다시 호출됨
	function resetpage(seq)
	{
		//console.log("resetpage*******************"+seq);
		makehash("",seq,"");
		$("#idchk").val(0);
		$("input[name=djmediCode]").val("");		
		$("input[name=mdCode]").val("");
		$("#djmediNameKor").text("");
		$("#djmediNameChn").text("");

		$("input[name=mm_code]").val("");  //청연 코드
		$("input[name=md_price]").val("");
		$("input[name=md_priceA]").val("");
		$("input[name=md_priceB]").val("");
		$("input[name=md_priceC]").val("");

		$("input[name=md_maker]").val("");
		$("input[name=md_origin]").val("");
		$("input[name=md_stable]").val(""); //적정수량

		$("input[name=seq]").val("");
		$("input[name=smuCode]").val("");
		$("input[name=smuNameKor]").val("");
		$("input[name=smuNameChn]").val("");
		$("#chksmuText").text(""); //중복확인 사용가능합니다. 문구 삭제
		$(".btnnew").remove();
		$(".btndel").remove();

		var hdata=location.hash.replace("#","").split("|");
		var page=hdata[0];
		var seq=hdata[1];
		var search=hdata[2];
		if(page==undefined){
			page=1;
		}
		if(search==undefined || search=="")
		{
			var searchTxt="";  
		}
		else
		{
			var sarr=search.split("&");
			if(sarr[0]!=undefined)var sarr1=sarr[0].split("=");
			if(sarr[1]!=undefined)var sarr2=sarr[1].split("=");
			if(sarr1[1]!=undefined)var searchTxt=sarr1[1];
			$("input[name=searchTxt]").val(decodeURI(searchTxt));
		}	
		var apidata="page="+page+"&searchTxt="+searchTxt;
		callapi('GET','medicine','medicinesmulist',apidata);//세명대 약재목록 리스트  API 호출 			
	}

    function addMediSmu(seq)//신규
    {
		
		makehash("",seq,"");
		$("#idchk").val(0);
		$("#chksmuText").text(""); //중복확인 사용가능합니다. 문구 삭제


		/*
		$("input[name=djmediCode]").val("");
		
		$("input[name=mdCode]").val("");
		$("#djmediNameKor").text("");
		$("#djmediNameChn").text("");

		$("input[name=md_price]").val("");
		$("input[name=md_maker]").val("");
		$("input[name=md_origin]").val("");

		$("input[name=seq]").val("");
		$("input[name=smuCode]").val("");
		$("input[name=smuNameKor]").val("");
		$("input[name=smuNameChn]").val("");
		//$("#listdiv").load("<?=$root?>/Skin/Medicine/MedicineSmu.php");
		//$("#chksmuCode").removeClass("smucheck");
		//$("#BtnCheckDiv").css("display", "block");//중복확인버튼
		*/
	}

    function medismu_del() //삭제
	{
		var data = "seq="+$("input[name=seq]").val();
		var url = encodeURI($("input[name=returnData]").val());
		$("input[name=returnData]").val(url);
		//console.log("del ::  data = " + data);

		callapidel('medicine','medicinesmudelete',data);
		//페이지초기화 1초후
		setTimeout("resetpage('')",1000);
		return false;
	}
	function viewlayerPopup(obj)
	{
		var url=obj.getAttribute("data-bind");
		var size=obj.getAttribute("data-value");
		var data = "&page=1&psize=5&block=10"; //page,psize,block 사이즈 초기화
		//console.log("=========>>>> viewlayerPopup url = " + url+", size = " + size);

		getlayer(url,size,data);
	}
	function makepage(json)
	{
		var obj = JSON.parse(json);
		console.log(obj);
        if(obj["apiCode"]=="medicinesmudesc") //세명대약재상세 
        {
			$("input[name=djmediCode]").val(obj["md_code"]);
			
			$("input[name=mdCode]").val(obj["md_code"]);
			$("#djmediNameKor").text(obj["md_title_kor"]);
			$("#djmediNameChn").text(obj["md_title_chn"]);
			$("input[name=mm_code]").val(obj["mm_code"]);

			$("input[name=md_price]").val(obj["md_price"]);
			$("input[name=md_priceA]").val(obj["md_priceA"]);
			$("input[name=md_priceB]").val(obj["md_priceB"]);
			$("input[name=md_priceC]").val(obj["md_priceC"]);
			$("input[name=md_priceD]").val(obj["md_priceD"]);
			$("input[name=md_priceE]").val(obj["md_priceE"]);

			$("input[name=md_maker]").val(obj["md_maker"]);
			$("input[name=md_origin]").val(obj["md_origin"]);

			$("input[name=md_stable]").val(obj["md_stable"]);  //적정수량	

			$("input[name=seq]").val(obj["mm_seq"]);
			$("input[name=smuCode]").val(obj["mm_code"]);
			$("input[name=smuNameKor]").val(obj["mm_title_kor"]);
			$("input[name=smuNameChn]").val(obj["mm_title_chn"]);

			CodeRadio("mmUseDiv", obj["UseList"], '<?=$txtdt["1144"]?>', "mm_use", "use-list", obj["mm_use"]);//사용 

			var data='';
			data=' <a href="javascript:medismu_update();" class="cdp-btn"><span><?=$txtdt["1070"]?><!-- 등록/수정 --></span></a> ';
			data+='<a href="javascript:addMediSmu(\'\');" class="cw-btn btnnew"><span><?=$txtdt["1189"]?><!-- 신규 --></span></a> ';
			data+='<a href="javascript:medismu_del();" class="red-btn btndel"><span><?=$txtdt["1154"]?></span></a>';
			$("#BtnDiv").html(data);

			//$("#BtnCheckDiv").css("display", "none");
        }
        else if(obj["apiCode"]=="medicinesmulist")//약재목록 세명대 
        {
            var data = langauge="";

			langauge=!isEmpty(getCookie("ck_language")) ? getCookie("ck_language") : "kor";

			$("#tbllist tbody").html("");
			if(!isEmpty(obj["list"]))
			{
				$(obj["list"]).each(function( index, value )
				{
					var cls="";
					if(value["md_type"]=="sweet"){
						cls="mdsweet";
					}else if(value["md_type"]=="medicine"){
						cls="mdmedi";
					}
					else if(value["md_type"]=="sugar"){
						cls="sugar";
					}
					else if(value["md_type"]=="alcohol"){
						cls="alcohol";
					}
					
					data+="<tr style='cursor:pointer;' onclick=\"medismu_desc('"+value["mm_seq"]+"')\">"; //누르면 상세 출력
					data+="<td >"+value["md_code"]+"</td>";//디제이메디약재코드
					data+="<td class='l'>"+"<span class=' mdtype "+cls+"'></span> "+value["md_title_"+langauge]+"</td>"; //디제이메디 약재명
					data+="<td>"+value["mm_code"]+"</td>";//한퓨어 약재코드				
					data+="<td >"+value["mm_title_"+langauge]+"</td>"; //한퓨어약재명
					data+="<td>"+value["md_origin"]+"</td>"; //원산지
					data+="<td>"+value["md_maker"]+"</td>"; //제조사
					data+="<td>"+value["md_price"]+"</td>"; //금액

					//data+="<td>"+value["mm_use"]+"</td>"; //사용가부
					data+="</tr>";
				});
			}
			else
			{
				data+="<tr>";
				data+="<td colspan='7'><?=$txtdt['1665']?></td>";
				data+="</tr>";
			}
            $("#tbllist tbody").html(data);

			var seq=$("input[name=seq]").val();
			data='';
			if(!isEmpty(seq))
			{
				data=' <a href="javascript:medismu_update();" class="cdp-btn"><span><?=$txtdt["1070"]?><!-- 등록/수정 --></span></a> ';
				data+='<a href="javascript:addMediSmu(\'\');" class="cw-btn btnnew"><span><?=$txtdt["1189"]?><!-- 신규 --></span></a> ';
				data+='<a href="javascript:medismu_del();" class="red-btn btndel"><span><?=$txtdt["1154"]?></span></a>';
			}
			else
			{
				data=' <a href="javascript:medismu_update();" class="cdp-btn"><span><?=$txtdt["1070"]?><!-- 등록/수정 --></span></a> ';
			}
			$("#BtnDiv").html(data);

            //페이지
			$("#pagecnt").text(comma(obj["tcnt"])+" <?=$txtdt['1019']?>");
            getsubpage("medismulistpage",obj["tpage"], obj["page"], obj["block"], obj["psize"]);
        }
        else if (obj["apiCode"]=="smumedicinelist") //디제이메디 약재리스트 
        {
			var data = "";
			var capa = 0;
			$("#laymedicinetbl tbody").html("");
			if(!isEmpty(obj["list"]))
			{
				$(obj["list"]).each(function( index, value )
				{
					capa = (isNaN(value["mdProperty"])==false) ? value["mdProperty"] : 0;
					data+='<tr class="putpopdata" onclick="javascript:putpopdata(this);" data-code="'+value["mdCode"]+'" data-property="'+capa+'" >';
					//data+='<td>'+value["mhCode"]+'</td>';		//본초코드
					data+='<td>'+value["mhTitle"]+'</td>';	  //본초명
					data+='<td>'+value["mdCode"]+'</td>'; //약재코드
					data+='<td>'+value["mdTitleKor"]+'</td>'; //약재명
					data+='<td>'+value["mdOriginKor"]+'</td>'; //원산지
					data+='<td>'+value["mdMakerKor"]+'</td>'; //제조사
					data+='</tr>';
				});
			}
			else
			{
				data+="<tr>";
				data+="	<td colspan='6'><?=$txtdt['1665']?></td>";
				data+="</tr>";
			}
			$("#laymedicinetbl tbody").html(data);

			//페이징
			getsubpage_pop("smumedicinelistpage",obj["tpage"], obj["page"], obj["block"], obj["psize"], obj["reData"]);
        }
		
		else if(obj["apiCode"]=="chksmumedicinecode")
		{
			if(obj["resultCode"] == "200")
			{
				$("#chksmuText").css("color", "blue");
				$("#chksmuText").text("<?=$txtdt['1476']?>"); //사용 가능합니다.
				$("#idchk").val(1);
			}
			else if(obj["resultCode"] == "999")
			{				
				$("#chksmuText").css("color", "red");
				$("#chksmuText").text("<?=$txtdt['1726']?>"); //이미 사용중인 약재코드입니다.
				$("#idchk").val(0);
			}
		}
		
	}

	function repageload(){
		var hdata=location.hash.replace("#","").split("|");
		//console.log(" hdata   :"+hdata);  //1,,searchTxt=%EC%95%84%EA%B5%90&searchStatus=&searchPeriodEtc=
		var page=hdata[0];
		var seq=hdata[1];
		var search=hdata[2];
		if(page==undefined){
			page=1;
		}
		if(search==undefined || search=="")
		{
			var searchTxt="";  
		}
		else
		{
			var sarr=search.split("&");
			if(sarr[0]!=undefined)var sarr1=sarr[0].split("=");
			if(sarr[1]!=undefined)var sarr2=sarr[1].split("=");
			if(sarr1[1]!=undefined)var searchTxt=sarr1[1];
			//if(sarr2[1]!=undefined)var searchStatus=sarr2[1];
			$("input[name=searchTxt]").val(decodeURI(searchTxt));
		}
		var apidata="page="+page+"&searchTxt="+searchTxt;
		callapi('GET','medicine','medicinesmulist',apidata);

		//if(!isEmpty(seq)){
			//setTimeout(function() {
				var apidescdata = "seq="+seq;
				callapi('GET','medicine','medicinesmudesc',apidescdata);
			//}, 100);
		//}
	}

	var hdata=location.hash.replace("#","").split("|");
	var page=hdata[0];
	var search=hdata[2];
	if(page==undefined){
		page=1;
	}

	if(search==undefined){
		var searchTxt="";
	}else{
		var sarr=search.split("&");
		if(sarr[0]!=undefined)var sarr1=sarr[0].split("=");
		if(sarr[1]!=undefined)var sarr2=sarr[1].split("=");
		if(sarr1[1]!=undefined)var searchTxt=sarr1[1];
		//if(sarr2[1]!=undefined)var searchStatus=sarr2[1];
		$("input[name=searchTxt]").val(decodeURI(searchTxt));
	}

	//검색에 undefined들어가는 버그수정
	if(searchTxt==undefined){
		searchTxt="";
		$("input[name=searchTxt]").val("");
	}
	var apidata="page="+page+"&searchTxt="+searchTxt;
	callapi('GET','medicine','medicinesmulist',apidata); 	 

	$("input[name=searchTxt]").focus();
</script>
