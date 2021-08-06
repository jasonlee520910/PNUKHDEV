<?php //본초분류관리 리스트&상세
$root = "../..";
include_once ($root.'/_common.php');
?>
<!--// page start -->
<input type="hidden" name="seq" class="reqdata" value="<?=$_GET["seq"]?>">
<input type="hidden" name="returnData" class="reqdata" value="<?=$root?>/Skin/Medicine/HubCategory.php">
<div id="pagegroup" value="medicine"></div>
<div id="pagecode" value="hubcatelist"></div>

<div class="board-ov-wrap">
    <!--// left  -->
	<div class="fl">
		<h3 class="u-tit02"><?=$txtdt["1125"]?><!-- 본초분류등록/수정 --></h3>
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
							<input type="text" class="w98p reqdata necdata" title="<?=$txtdt["1136"]?>" name="mcCode"/>
						</td>
					</tr>
					<tr>
						<th class="l"><span class="nec"><?=$txtdt["1007"]?><!-- 1차분류코드 --></span></th>
						<td colspan="3">
							<input type="text" class="w98p reqdata necdata" title="<?=$txtdt["1007"]?>" name="mcCode01"/>
						</td>
					</tr>
					<tr>
						<th class="l"><span class=""><?=$txtdt["1005"]?><!-- 1차분류명 --></span></th>
						<td colspan="3">
							<?=$txtdt["1718"]?><input type="text" class="w98p reqdata" title="<?=$txtdt["1005"]?>" name="mcTitle01Kor" />
							<?=$txtdt["1719"]?><input type="text" class="w98p reqdata" title="<?=$txtdt["1005"]?>" name="mcTitle01Chn" />
						</td>
					</tr>
					<tr>
						<th class="l"><span class="nec"><?=$txtdt["1010"]?><!-- 2차분류코드 --></span></th>
						<td colspan="3">
							<input type="text" class="w98p reqdata necdata" title="<?=$txtdt["1010"]?>" name="mcCode02"/>
						</td>
					</tr>
					<tr>
						<th class="l"><span class=""><?=$txtdt["1009"]?><!-- 2차분류명 --></span></th>
						<td colspan="3">
							<?=$txtdt["1718"]?><input type="text" class="w98p reqdata" title="<?=$txtdt["1009"]?>" name="mcTitle02Kor" />
							<?=$txtdt["1719"]?><input type="text" class="w98p reqdata" title="<?=$txtdt["1009"]?>" name="mcTitle02Chn"/>
						</td>
					</tr>
				</tbody>
			</table>
		</div>
		<div class="btn-box c">
			<?php if($modifyAuth == "true"){?>
				<a href="javascript:hubcate_update();" class="cdp-btn"><span><?=$txtdt["1070"]?><!-- 등록/수정 --></span></a>
				<a href="javascript:godesc('');" class="cw-btn"><span><?=$txtdt["1189"]?><!-- 신규 --></span></a>
				<a href="javascript:hubcate_del();" class="red-btn"><span><?=$txtdt["1154"]?></span></a>
			<?php }?>
		</div>
	</div>

	<!--// right  -->
    <div class="fr ov-cont">
	<span id="pagecnt" class="tcnt" style="float:right"></span>
       <h3 class="u-tit02"><?=$txtdt["1127"]?><!-- 본초분류목록 --></h3>   	
        <div class="board-list-wrap">
            <span class="bd-line"></span>
            <table id="tbllist" class="tblcss">
                  <caption><span class="blind"></span></caption>
					<colgroup>
					 <col scope="col" width="20%">
					 <col scope="col" width="15%">
					 <col scope="col" width="25%">
					 <col scope="col" width="25%">
					 <col scope="col" width="15%">
					 <col scope="col" width="25%">
					 <col scope="col" width="25%">
					</colgroup>
					<thead>
					 <tr>
						<th><?=$txtdt["1136"]?><!-- 분류코드 --></th>
						<th><?=$txtdt["1007"]?><!-- 1차분류코드 --></th>
						<th><?=$txtdt["1005"]?><!-- 1차분류명 --></th>
						<th><?=$txtdt["1005"]?><!-- 1차분류명 --></th>
						<th><?=$txtdt["1010"]?><!-- 2차분류코드 --></th>
						<th><?=$txtdt["1009"]?><!-- 2차분류명 --></th>
						<th><?=$txtdt["1009"]?><!-- 2차분류명 --></th>
					</tr>
					</thead>
                  <tbody>
                  </tbody>
           </table>
        </div>
        <div class="sgap"></div>

        <!-- s : 게시판 페이징 -->
		<div class='' id="hubcatelistpage"></div>
        <!-- e : 게시판 페이징 -->
    </div>
</div>

<script>
    //리스트 누르면 상세 출력
    function desc(seq, page)
	{

		var hdata=location.hash.replace("#","").split("|");
		var page=hdata[0];
		if(page==undefined){page="";}
		var search=hdata[2];
		if(search ===undefined){search="";}
		
		makehash(page,seq,search)  

/*
		$("input[name=seq]").val(seq);
		var data = "seq="+seq+"&page="+page;
		console.log("data = " + data);
        callapi('GET','medicine','hubcatedesc',data); //본초분류관리  상세 API 호출
		return false;
*/
	}
    function hubcate_update(status)//등록&수정
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
			callapi("POST","medicine","hubcateupdate",jsondata); //본초분류관리 등록&수정
			//페이지초기화 1초후
			setTimeout("godesc()",1000);
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

    function hubcate_del() //삭제
	{
		var data = "seq="+$("input[name=seq]").val();
		callapidel('medicine','hubcatedelete',data);
		makehash("","","");
		return false;
	}

	function makepage(json)
	{
		var obj = JSON.parse(json);
		console.log(obj);

		if(obj["apiCode"]=="hubcatedesc")//본초분류관리 상세
		{
			$("input[name=seq]").val(obj["seq"]); //seq
			$("input[name=mcCode]").val(obj["mcCode"]); //분류코드
			$("input[name=mcCode01]").val(obj["mcCode01"]); //1차분류코드
			$("input[name=mcTitle01Kor]").val(obj["mcTitle01Kor"]);  //1차분류명(한글)
			$("input[name=mcTitle01Chn]").val(obj["mcTitle01Chn"]); //1차분류명(중문)
			$("input[name=mcCode02]").val(obj["mcCode02"]); //경고메시지
			$("input[name=mcTitle02Kor]").val(obj["mcTitle02Kor"]); //2차분류명(한글)
			$("input[name=mcTitle02Chn]").val(obj["mcTitle02Chn"]); //2차분류명(중문)
		}
		else if(obj["apiCode"]=="hubcatelist")//본초분류관리list
		{
			var data = "";

			$("#tbllist tbody").html("");
			if(!isEmpty(obj["list"]))
			{
				$(obj["list"]).each(function( index, value )
				{
					data+="<tr style='cursor:pointer;' onclick=\"desc('"+value["seq"]+"', '"+obj["page"]+"')\">";
					data+="<td class='l'>"+value["mcCode"]+"</td>";//분류코드
					data+="<td class='l'>"+value["mcCode01"]+"</td>"; //1차분류코드
					data+="<td class='l'>"+value["mcTitle01Kor"]+"</td>"; //1차분류명(한글)
					data+="<td class='l'>"+value["mcTitle01Chn"]+"</td>"; //1차분류명(중문)
					data+="<td class='l'>"+value["mcCode02"]+"</td>"; //2차분류코드
					data+="<td class='l'>"+value["mcTitle02Kor"]+"</td>"; //2차분류명(한글)
					data+="<td class='l'>"+value["mcTitle02Chn"]+"</td>"; //2차분류명(중문)
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
			getsubpage("hubcatelistpage",obj["tpage"], obj["page"], obj["block"], obj["psize"]);
		}
		return false;
	}

	function repageload(){
		var hdata=location.hash.replace("#","").split("|");
		var page=hdata[0];
		//searchTxt=1&searchStatus=
		var seq=hdata[1];
		var search=hdata[2];
		if(page==undefined){
			page=1;
		}
		var apidata="page="+page;
		callapi('GET','medicine','hubcatelist',apidata);
		if(!isEmpty(seq)){
			apidata="seq="+seq;
			callapi('GET','medicine','hubcatedesc',apidata); 
		}
	}
	console.log("페이지 새로고침 됨");
	repageload();


	//본초분류관리  리스트 API 호출
	var hdata=location.hash.replace("#","").split("|");
	var page=hdata[0];
	//searchTxt=1&searchStatus=
	var search=hdata[1];
	if(page==undefined){
		page=1;
	}
	var apidata="page="+page;

	//callapi('GET','medicine','hubcatelist',apidata); 

</script>
