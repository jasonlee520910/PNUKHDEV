<?php //약속처방
$root = "../..";
include_once ($root.'/_common.php');
?>

<style>
.infotxt{overflow:hidden;text-overflow:ellipsis;white-space:nowrap;width:100px;height:20px;}
</style>
<div id="pagegroup" value="recipe"></div>
<div id="pagecode" value="recipegoodslist"></div>
<div class="board-view-wrap">
	<span class="bd-line"></span>
	<table>
		  <caption><span class="blind"></span></caption>
		  <colgroup>
			  <col width="180">
			  <col width="*">
		  </colgroup>
		  <tbody>
			<!-- <tr>
				<th><?=$txtdt["1449"]?><!-- 승인상태별 --><!--</th>
				<td><?//=selectstatus()?></td>
			</tr> -->
			<tr>
				<th><span><?=$txtdt["1020"]?><!-- 검색 --></span></th>
				<td><?=selectsearch()?></td>
			</tr>
		  </tbody>
	</table>
</div>
<div class="gap"></div>

<div class="board-list-wrap">
	<span class="bd-line"></span>
	<div class="list-select">
		<span id="pagecnt" class="tcnt"></span>
		<?if($modifyAuth == "true"){?>
			<p class="fr">
				<a href="javascript:;" onclick="viewdesc('add')"><button class="btn-blue"><span>+ <?=$txtdt["1332"]?><!-- 처방추가 --></span></button></a>
			</p>
		<?}?>
	</div>
	<table id="tbllist" class="tblcss">
		  <caption><span class="blind"></span></caption>
		  <colgroup>
			 <!-- <col scope="col" width="8%">
			 <col scope="col" width="8%">
			 <col scope="col" width="8%"> -->
			 <col scope="col" width="18%">
			 <col scope="col" width="15%">
			 <col scope="col" width="">
			 <col scope="col" width="5%">
			 <col scope="col" width="5%">
			 <col scope="col" width="5%">
			 <col scope="col" width="10%">
			 <col scope="col" width="10%">
			 <col scope="col" width="3%">
		  </colgroup>
		  <thead>
			 <tr>
				  <!-- <th class="lf"><?=$txtdt["1403"]?><!-- 한의원 --><!-- </th> -->
				  <!-- <th class="lf"><?=$txtdt["1591"]?><!-- 한의사 --><!-- </th>  --> 
				 <!--  <th><?=$txtdt["1324"]?><!-- 처방서적 --><!-- </th> --> 
				  <th><?=$txtdt["1323"]?><!-- 처방명 --></th>
				<th><?//=$txtdt["1323"]?>매칭정보<!-- 처방명 --></th>
				 <th><?=$txtdt["1450"]?><!-- 약재정보 --></th>
				  <th><?=$txtdt["1335"]?><!-- 첩수 --></th>
				  <th><?//=$txtdt["1335"]?>팩수<!-- 첩수 --></th>
				  <th><?//=$txtdt["1335"]?>팩용량<!-- 첩수 --></th>
				  <th><?//=$txtdt["1335"]?>파우치<!-- 첩수 --></th>
				  <th><?//=$txtdt["1335"]?>한약박스<!-- 첩수 --></th>
				  <th><?=$txtdt["1185"]?><!-- 승인 --></th>
			  </tr>
		  </thead>
		  <tbody>

		</tbody>
	</table>
</div>

<div class="gap"></div>

<!-- s : 게시판 페이징 -->
<div class='' id="recipegoodslistpage"></div>
<!-- e : 게시판 페이징 -->

<script>

	function repageload(){
	console.log("no  repageload ");
	}
	function delcyPK(seq, code, title)
	{
		if(!confirm('매칭된 정보\n처방명:'+title+'를\n 삭제하시겠습니까?')){return;}
		var url="seq="+seq+"&code="+code+"&title="+encodeURIComponent(title);
		callapi('GET','recipe','recipegoodscypkdelete',url);
	}

	function makepage(json)
	{
		var obj = JSON.parse(json);
		console.log(obj);
		if(obj["apiCode"]=="recipegoodslist")
		{
			var rcStatus=data="";
			$("#tbllist tbody").html("");

			if(!isEmpty(obj["list"]))
			{
				$(obj["list"]).each(function( index, value )
				{
					if(value["rcStatus"]=="F")
					{
						rcStatus="<span class='sbtn-blue'></span>";
					}
					else
					{
						rcStatus="<span class='sbtn-gray'></span>";
					}

					data+="<tr style='cursor:pointer;' >";
					//data+="<td>"+value["miName"]+"</td>"; //한의원명
					//data+="<td>"+value["meName"]+"</td>"; //한의사
					//data+="<td>"+value["rbSourcetxt"]+"</td>";//처방서적
					data+="<td class='l'><a href='javascript:;' onclick=\"viewdesc('"+value["seq"]+"')\">"+value["rcTitle"]+"</a></td>"; //처방명 
					var matching="";				
					$(value["matching"]).each(function( idx, val )
					{
						console.log("matching idx : " + idx + ", val["+val["title"]+"]");
						matching+=" <span style='padding:2px 5px;border-radius:2px;background:#1F629A;color:#fff;' onclick=\"delcyPK('"+value["seq"]+"','"+val["code"]+"', '"+val["title"]+"')\">"+val["title"]+"</span> ";
					});
						
					
					data+="<td class='l'>"+matching+"</td>"; //한의원명

					data+="<td class='l infotxt'>"+value["rcMedicineTxt"]+"</td>"; //약재정보

					var rcChub=isEmpty(value["rcChub"]) ? "1" : value["rcChub"];
					data+="<td>"+rcChub+"</td>"; //첩수 
					data+="<td>"+value["rcPackCnt"]+"</td>"; // 
					data+="<td>"+value["rcPackCapa"]+"</td>"; // 
					data+="<td>"+value["rcPackType"]+"</td>"; // 
					data+="<td>"+value["rcMediBox"]+"</td>"; // 
					data+="<td>"+rcStatus+"</td>"; //승인
					data+="</tr>";
				});
			}
			else
			{
				data+="<tr>";
				data+="	<td colspan='8'><?=$txtdt['1665']?></td>";
				data+="</tr>";
			}

			$("#tbllist tbody").html(data);
			$("#pagecnt").text(comma(obj["tcnt"])+" <?=$txtdt['1019']?>");
			//페이지
			getsubpage("recipegoodslistpage",obj["tpage"], obj["page"], obj["block"], obj["psize"]);
		}
		else if(obj["apiCode"]=="recipegoodscypkdelete")
		{
			var hashdata=location.hash;
			if(hashdata=="")hashdata="#1||";
			if(hashdata.indexOf("renew") < 0){
				location.hash=hashdata+"|renew";
			}else{
				location.hash=hashdata.replace("|renew","");
			}

			if(obj["resultCode"]=="200")
			{
				alertsign('success','삭제되었습니다.','','2000');
			}
			else
			{
				alertsign('success',obj["resultMessage"],'','2000');
			}
		}
		return false;
	}

	//처방서적>실속처방 리스트 API 호출
	var hdata=location.hash.replace("#","").split("|");
	var page=hdata[0];
	var apiOrderData="";
	var search=hdata[2];
	console.log("search    :"+search);
	if(page==undefined){
		page=1;
	}

	if(search==undefined || search==""){
		var searchTxt="";
	}else{
		var sarr=search.split("&");
		if(sarr[0]!=undefined)var sarr1=sarr[0].split("=");	
		if(sarr[1]!=undefined)var sarr2=sarr[1].split("=");	//검색단어	
		if(sarr2[2]!=undefined)var sarr3=sarr2[1].split("="); //승인상태별

		if(sarr1[1]!=undefined)var searchTxt=sarr1[1]; //검색단어	
		console.log("searchTxt    :"+searchTxt);
		if(sarr2[1]!=undefined)var searchStatus=sarr2[1]; //승인상태별	
		console.log("searchStatus    :"+searchStatus);
	
		$("input[name=searchTxt]").val(decodeURI(searchTxt));
		
		var starr=searchStatus.split(",");
		for(var i=0;i<starr.length;i++){
			if(starr[i]!=""){
				$(".searchStatus"+starr[i]).attr("checked",true);
			}
		}
		apiOrderData="&searchTxt="+searchTxt+"&searchStatus="+searchStatus;
	}

	var apidata="page="+page+apiOrderData;
	console.log("apidata     : "+apidata);

	callapi('GET','recipe','recipegoodslist',apidata);  
	$("#searchTxt").focus();
</script>
