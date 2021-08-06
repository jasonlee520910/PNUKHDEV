<?php //제조사관리
$root = "../..";
include_once ($root.'/_common.php');
?>
<!--// page start -->
<input type="hidden" name="seq" class="reqdata" value="<?=$_GET["seq"]?>">
<input type="hidden" name="returnData" class="reqdata" value="<?=$root?>/Skin/Medicine/HubCategory.php">
<div id="pagegroup" value="medicine"></div>
<div id="pagecode" value="makerlist"></div>

<div class="board-ov-wrap">
    <!--// left  -->
	<div class="fl">
		<h3 class="u-tit02">제조사 등록/수정 <?//=$txtdt["1125"]?><!-- 본초분류등록/수정 --></h3>
		<div class="board-view-wrap">
			<span class="bd-line"></span>
			<table>
				<caption><span class="blind"></span></caption>
				<colgroup>
					<col width="30%">
					<col width="20%">
					<col width="30%">
					<col width="20%">
				</colgroup>
				<tbody>
					<tr>
						<th class="l"><span class="nec"><?=$txtdt["1136"]?><!-- 분류코드 --></span></th>
						<td colspan="3">
							자동추가
						</td>
					</tr>
					<tr>
						<th class="l"><span class="nec">제조사 이름<?//=$txtdt["1007"]?><!-- 1차분류코드 --></span></th>
						<td colspan="3">
							<input type="text" class="w98p reqdata necdata" title="<?=$txtdt["1007"]?>" name="makername"/>
						</td>
					</tr>
				</tbody>
			</table>
		</div>
		<div class="btn-box c">
			<?php if($modifyAuth == "true"){?>
				<a href="javascript:maker_update();" class="cdp-btn"><span><?=$txtdt["1070"]?><!-- 등록/수정 --></span></a>
				<!-- <a href="javascript:godesc('');" class="cw-btn"><span><?=$txtdt["1189"]?><!-- 신규 --></span></a> 
				<!-- <a href="javascript:maker_del();" class="red-btn"><span><?=$txtdt["1154"]?></span></a> -->
			<?php }?>
		</div>
	</div>

	<!--// right  -->
    <div class="fr ov-cont">
	<span id="pagecnt" class="tcnt" style="float:right"></span>
       <h3 class="u-tit02">제조사 리스트 <?//=$txtdt["1127"]?><!-- 본초분류목록 --></h3>   	
        <div class="board-list-wrap">
            <span class="bd-line"></span>
            <table id="tbllist" class="tblcss">
                  <caption><span class="blind"></span></caption>
					<colgroup>
					 <col scope="col" width="30%">
					 <col scope="col" width="30%">
					 <col scope="col" width="*%">
					</colgroup>
					<thead>
					 <tr>
						<th><?=$txtdt["1136"]?><!-- 분류코드 --></th>
						<th>제조사이름<?//=$txtdt["1007"]?><!-- 1차분류코드 --></th>
						<th>등록일<?//=$txtdt["1005"]?><!-- 1차분류명 --></th>
					</tr>
					</thead>
                  <tbody>
                  </tbody>
           </table>
        </div>
        <div class="sgap"></div>

        <!-- s : 게시판 페이징 -->
		<div class='' id="makerlistpage"></div>
        <!-- e : 게시판 페이징 -->
    </div>
</div>

<script>
/*
    //리스트 누르면 상세 출력
    function desc(seq, page)
	{

		var hdata=location.hash.replace("#","").split("|");
		var page=hdata[0];
		if(page==undefined){page="";}
		var search=hdata[2];
		if(search ===undefined){search="";}
		
		makehash(page,seq,search)  

	}
*/
    function maker_update()//등록&수정
    {
        if(necdata()=="Y") //필수값체크
        {
            var key=data="";
            var jsondata={};
            $(".reqdata").each(function()
            {
                key=$(this).attr("name");
                data=$(this).val();
                jsondata[key] = data;
            });

			console.log(jsondata);
			callapi("POST","medicine","makerupdate",jsondata); //본초분류관리 등록&수정
			//페이지초기화 1초후
			setTimeout("godesc('')",1000);
			repageload();
		}
    }

	function godesc(seq)//신규
    {
		$(".reqdata").each(function()
        {
			var name=$(this).attr("name");
			if(!isEmpty(name))
			{
				$("input[name="+name+"]").val("");
			}
			console.log("name="+name);
        });
		makehash("","","");
	}
/*
    function maker_del() //삭제
	{
		var data = "seq="+$("input[name=seq]").val();
		callapidel('member','makerdelete',data);
		makehash("","","");
		return false;
	}
*/
	function makepage(json)
	{
		var obj = JSON.parse(json);
		console.log(obj);

		if(obj["apiCode"]=="makerlist")
		{
			var data = "";

			$("#tbllist tbody").html("");
			if(!isEmpty(obj["list"]))
			{
				$(obj["list"]).each(function( index, value )
				{
					//data+="<tr style='cursor:pointer;' onclick=\"desc('"+value["seq"]+"', '"+obj["page"]+"')\">";	
					data+="<tr style='cursor:pointer;'>";	
					data+="<td class='l'>"+value["cd_type"]+"</td>"; 
					data+="<td class='l'>"+value["cd_name_kor"]+"</td>"; 
					data+="<td class='l'>"+value["cdDate"]+"</td>";
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

			$("#pagecnt").text(comma(obj["tcnt"])+" <?=$txtdt['1019']?>");
			//페이지
			getsubpage("makerlistpage",obj["tpage"], obj["page"], obj["block"], obj["psize"]);
		}
		return false;
	}

	function repageload(){
		var hdata=location.hash.replace("#","").split("|");
		var page=hdata[0];
		var seq=hdata[1];
		var search=hdata[2];
		if(page==undefined){
			page=1;
		}
		var apidata="page="+page;
		console.log("apidata   > >>  "+apidata);
		callapi('GET','medicine','makerlist',apidata);

		if(!isEmpty(seq))
		{
			apidata="seq="+seq;
			//callapi('GET','medicine','makerdesc',apidata); 
		}
	}
	console.log("페이지 새로고침 됨");
	repageload();


	//본초분류관리  리스트 API 호출
	var hdata=location.hash.replace("#","").split("|");
	var page=hdata[0];
	var search=hdata[1];
	if(page==undefined){
		page=1;
	}
	var apidata="page="+page;


</script>
