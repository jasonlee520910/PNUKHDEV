<?php
	$root=".";
	include_once $root."/_Inc/head.php";
?>
<style>
	#popupDiv{position:absolute;width:100%;height:0;z-index:1000;margin:0 auto;}
	#popup{position:relative;width:1200px;height:0;z-index:1000;margin:0 auto;}
	.pop{border:2px solid #ddd;background:white;position:absolute;z-index:1000;}
	.pop .close{height:36px;background:#f3f3f3;padding:5px 10px;line-height:130%;}
	#check input{background:white;border:1px solid #000;margin-right:5px;}
	#check label{font-size:14px;}
	.pop  .close .cls{float:right;padding:4px 7px;line-height:130%;font-size:12px;background:#333;color:#fff;border-radius:3px;}
</style>
<input type="hidden" name="myip" id="myip" value="<?=$_SERVER['REMOTE_ADDR']?>">


<script  type="text/javascript" src="<?=$root?>/_Js/jquery-ui.js"></script>


<div id="popupDiv"><div id="popup"></div></div>
<div class="container main">
    <div class="main">
        <div class="main__visual">
            <div class="wrap d-flex">
                <div class="visual__img"></div>
                <div class="visual__navi">
                    <div class="v-navi__item">
						<?php if($_COOKIE["ck_meStatus"]=="confirm" && $_COOKIE["ck_miStatus"]=="confirm"){?>
							<a href="<?=$root?>/Order/Potion.php" class="v-navi__item__link d-flex"  >
						<?php }else{?>
							<a href="<?=$root?>/Member/Info.php" class="v-navi__item__link d-flex"  >
						<?php }?>
                            <div class="v-navi__mark">
                                <img src="<?=$root?>/assets/images/icon/prescription.png" alt="">
                            </div>
                            <div class="v-navi__ico" >

                            </div>
                            <div class="v-navi__txt">처방하기</div>
                        </a>
                    </div>
                    <div class="v-navi__item">
                        <a href="" class="v-navi__item__link d-flex"  onclick="alert('준비중입니다.');">
                            <div class="v-navi__mark">
                                <img src="<?=$root?>/assets/images/icon/prescription.png" alt="">
                            </div>
                            <div class="v-navi__ico">

                            </div>
                            <div class="v-navi__txt">사전조제처방</div>
                        </a>
                    </div>
                    <div class="v-navi__item">
						<?php if(isEmpty($_COOKIE["ck_meUserId"])){?>
						 <a href="javascript:showModal('modal-login');" class="v-navi__item__link d-flex">						   
						<?php }else{?>					  
							<?php if($_COOKIE["ck_meStatus"]=="confirm" && $_COOKIE["ck_miStatus"]=="confirm"){?>
							<a href="<?=$root?>/Member/Record.php" class="v-navi__item__link d-flex">
							<?php } else {?>
							<a href="<?=$root?>/Member/Info.php" class="v-navi__item__link d-flex"  >
							<?php }?>					  
						<?php }?>
                          <div class="v-navi__ico">
                            </div>
								<div class="v-navi__txt">처방내역조회</div>
                        </a>
                    </div>
                    <div class="v-navi__item">
						<?php if(isEmpty($_COOKIE["ck_meUserId"])){?>						 
						     <a href="javascript:showModal('modal-login');" class="v-navi__item__link d-flex">
						<?php }else{?>
							<?php if($_COOKIE["ck_meStatus"]=="confirm" && $_COOKIE["ck_miStatus"]=="confirm"){?>
							<a href="<?=$root?>/Order/" class="v-navi__item__link d-flex">
							<?php } else {?>
							<a href="<?=$root?>/Member/Info.php" class="v-navi__item__link d-flex"  >
							<?php }?>					  
						<?php }?>
                            <div class="v-navi__ico">

                            </div>
                            <div class="v-navi__txt">결제내역</div>
                        </a>
                    </div>
                    <div class="v-navi__item">
                        <a href="" class="v-navi__item__link d-flex" onclick="alert('준비중입니다.');">
                            <div class="v-navi__ico">

                            </div>
                            <div class="v-navi__txt">원외탕전시스템</div>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="main__content">
            <div class="main__section sec1">
                <div class="wrap d-flex">
                    <div class="main__tab">
                        <div class="m-tab__head d-flex">
                            <button class="m-tab__link active" id="NOTICE" onclick="getlist('NOTICE')">공지사항</button>
                            <button class="m-tab__link" id="FAQ" onclick="getlist('FAQ')">FAQ</button>
							<p id="addpageDiv" class="m-tab__more" style="margin-right:1px;"></p>
                            
                        </div>
                        <div class="m-tab__body" style="height:180px;overflow:hidden;">
                            <div id="boarddiv" class="m-tab__item active">
                            </div>
                        </div>
                    </div>
                    <div class="main__cs d-flex">
                        <div class="cs__item cs__item--col1 d-flex" onclick="alert('준비중입니다.');">
                            <div class="cs__head" >견학신청</div>
                            <div class="cs__body d-flex">
                                <div class="cs__txt">
                                    원외탕전실을 체험 해보실 수 있습니다.
                                </div>
                            </div>
                            <div class="cs__row">
                                <div class="btnBox">
                                    <a href="" class="d-flex btn btn--medium btn--w100 bg-white color-blue">예약신청</a>
                                </div>
                            </div>
                        </div>
                        <div class="cs__item cs__item--col2 d-flex">
                            <div class="cs__head">고객센터</div>
                            <div class="cs__body d-flex">
                                <div class="cs__txt" style="width:180px;margin-left:-10px;line-height:100%;font-size:27px;">
                                    055-360-5520
                                </div>
                            </div>
                            <div class="cs__row d-flex">
                                <span>상담 : </span>
                                평일 8:30 ~ 17:30<br/>
                                공휴일, 토.일휴무
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php  include_once $root."/_Inc/tail.php"; ?>
<script>

	function getNowFull(yearcnt)
	{
		var date = new Date();
		var year = new String(date.getFullYear());
		year = (yearcnt==4) ? year : year.substring(2,4);
		var month = new String(date.getMonth()+1);
		var day = new String(date.getDate());
		var hours = new String(date.getHours());
		var minutes = new String(date.getMinutes());
		var seconds = new String(date.getSeconds());

		return nowDate = pad(year,yearcnt) + pad(month,2) + pad(day,2) + pad(hours,2) + pad(minutes,2) + pad(seconds,2);
	}
	//자릿수
	function pad(n, width)
	{
		n = n + '';
		return n.length >= width ? n : new Array(width - n.length + 1).join('0') + n;
	}

	function getpopList()
	{
		callapi("GET","/medical/cs/",getdata("indexboardlist")+"&btype=POPUP");
	}

	function getlist(type)
	{
		console.log("type   >>> "+type);

		if(type=="FAQ")
		{
			$("#addpageDiv").html('<a href="/CS/Faq.php" class="m-tab__more">+ 더보기</a>');
		}
		else
		{
			$("#addpageDiv").html('<a href="/CS/Notice.php" class="m-tab__more">+ 더보기</a>');
		}

		$(".m-tab__head button").removeClass("active");
		$("#"+type).addClass("active");
		//$(".m-tab__head .m-tab__more").attr("href","/CS/Notice.php");
		callapi("GET","/medical/cs/",getdata("indexboardlist")+"&btype="+type);
	}
	function popClose(seq)
	{
		console.log("popClose  = "+seq+", chk="+$("input[name='chkbox"+seq+"']").is(":checked"));
		if($("input[name='chkbox"+seq+"']").is(":checked") ==true)
		{
			setCookie("ck_pop"+seq, "Y", 1);
		}
		$("#pop"+seq).hide();
	}
	
	function popupviewdata(obj)  //내용이 10자 이상이면 이미지가 안보이고 내용이 보이고 내용이 10자이하이면 이미지가 나옴(이미지랑 내용은 같이 안나옴)
	{
		//console.log("popupviewdata");
		//console.log(JSON.stringify(obj));

		var popupdata="";

		popupdata+='<div class="pop" id="pop'+obj["seq"]+'" style="border:2px solid #333;top:'+obj["bbTop"]+'px;left:'+obj["bbLeft"]+'px;width:'+(parseInt(obj["bbWidth"])+4)+'px;height:'+(parseInt(obj["bbHeight"])+44)+'px;">';

		var dataheight=parseInt(obj["bbHeight"])+44-40;

		//popupdata+="<div style='border:2px solid red;height:30px;'>"+obj["bbTitle"]+"</div>";  //제목 (아래 길이 맞춰야함)
		popupdata+='<div style="height:'+dataheight+'px;">';

		if(obj["Linktype"]=="_blank") //새창으로 열기
		{
			var Linktype=obj["Linktype"];
		}
		else
		{
			var Linktype="";
		
		}

		if(!isEmpty(obj["bbLink"])) //링크
		{
			popupdata+='<a href="'+obj["bbLink"]+'" target="'+Linktype+'">';	
		}
		else
		{
			popupdata+='<a>';		
		}		

		if(obj["bbDesc"].length > 10)
		{
			popupdata+="<div style='height:300px;padding:50px;'>"+obj["bbDesc"]+"</div>";
		}
		else 
		{
			if(!isEmpty(obj["imgPop"]))
			{						
				popupdata+="<img src='"+getUrlData("FILE_DOMAIN")+obj["imgPop"]+"'>";
			}
			
		}
		popupdata+='</a></div>';
		popupdata+='<div class="close">';
		//popupdata+='<form method="post" action="" name="pop_form"> ';
		popupdata+='<span id="check" onclick="popClose(\''+obj["seq"]+'\');"><input type="checkbox" value="checkbox" name="chkbox'+obj["seq"]+'" id="chkday"><label for="chkday">오늘 하루동안 보지 않기</label></span>';
		popupdata+='<span id="close'+obj["seq"]+'" class="cls" onclick="popClose(\''+obj["seq"]+'\');">닫기</span>';
		//popupdata+='</form>';
		popupdata+='</div>';
		popupdata+='</div>';	
		$("#popup").prepend(popupdata);	

		setTimeout("$('#pop"+obj["seq"]+"').draggable()",500);  //팝업 드래그
	}

	function makepage(result)
	{
		var obj = JSON.parse(result);
		console.log(obj);

		//bbIp
		if(!isEmpty(obj["btype"])&&obj["btype"]=="POPUP")
		{
			$.each(obj["list"] ,function(index, val)
			{

				if(getCookie("ck_pop"+val["seq"])=="Y")
				{
				}
				else
				{
					if(val["bbUse"]=="M")  //나만보이는걸 처리
					{
						var myip=$("input[name=myip]").val(); 

						if(val["bbIp"]==myip)
						{
							//----------------------------------------------
							var sdate= val["bbSdate"];
							var edate= val["bbEdate"];

							console.log("팝업 노출 시작 시간>>>>>>>>"+sdate);  //2020-07-06 15:39:50
							console.log("팝업 노출 끝 시간 >>>>>>>>"+edate);	 //2020-07-23 16:09:00

							//오늘날짜를 기본값으로 함
							var thistime=getNowFull(4);
							var year = thistime.substr(0,4);
							var month = thistime.substr(4,2);
							var day = thistime.substr(6,2);
							var hour = thistime.substr(8,2);
							var minute = thistime.substr(10,2);

							var nowtime= year+"-"+month+"-"+day+" "+hour+":"+minute; 

							console.log("현재시각 >>>>>>>>>>>>>>>>"+nowtime);

							if(val["bbPopuplimit"]=="Y")
							{							
								if(nowtime >= sdate && nowtime <= edate)
								{
									popupviewdata(val);
								}
							}
							else
							{
								popupviewdata(val);
							}
							//----------------------------------------------
						}
					}
					else if(val["bbUse"]=="Y") //공개이면
					{

						//----------------------------------------------
						var sdate= val["bbSdate"];
						var edate= val["bbEdate"];

						//오늘날짜를 기본값으로 함
						var thistime=getNowFull(4);
						var year = thistime.substr(0,4);
						var month = thistime.substr(4,2);
						var day = thistime.substr(6,2);
						var hour = thistime.substr(8,2);
						var minute = thistime.substr(10,2);

						var nowtime= year+"-"+month+"-"+day+" "+hour+":"+minute; 

						console.log("현재시각 >>>>>>>>>>>>>>>>"+nowtime);

						if(val["bbPopuplimit"]=="Y")
						{							
							var popupdata="";
							if(nowtime >= sdate && nowtime <= edate)
							{
								popupviewdata(val);
							}
						}
						else
						{
							popupviewdata(val);
						}
						//----------------------------------------------
					}

				}
			});			
		}
		else
		{
			var marr=["bbTitle","bbModify"];	
			var data="<ul class='m-tab__list'>";
			$.each(obj["list"] ,function(index, val){
				data+="<li>";
				//data+="<a href='"+val["seq"]+"' class='d-flex'>";   // 페이지로 이동할지 정해서 링크수정
				data+="<a  class='d-flex'>";   // 페이지로 이동할지 정해서 링크수정
				data+="<div class='m-tab__txt text-ellipsis'>";
				data+=val["bbTitle"];
				data+="</div>";
				data+="<div class='m-tab__date'>"+val["bbModify"]+"</div>";
				data+="</a>";
				data+="</li>";
			});
			data+="</ul>";
			$("#boarddiv").html(data);
		}
	}
	getlist("NOTICE");
	getpopList();

	//console.log("index.php");


</script>
