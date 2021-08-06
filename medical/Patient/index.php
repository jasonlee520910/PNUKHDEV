<?php
	$root="..";
	include_once $root."/_Inc/head.php";
?>
<input type="hidden" name="medicalid" class="ajaxdata" value="<?=$_COOKIE["ck_miUserid"]?>">
<input type="hidden" name="meGrade" class="ajaxdata" value="<?=$_COOKIE["ck_meGrade"]?>">
<input type="hidden" name="ck_meUserId" class="ajaxdata" value="<?=$_COOKIE["ck_meUserId"]?>">

<div id="listdiv"></div>

<script>

	//해시값이 바뀌면 
	window.onhashchange = function(e) {
		viewpage();
	}
	
	viewpage();  //첫페이지

	function viewpage()
	{
		var hdata=location.hash.replace("#","").split("|");
		var seq=hdata[1];
		var search=!isEmpty(hdata[3])?hdata[3]:"";

		if(isEmpty(seq))
		{
			var meGrade=$("input[name=meGrade]").val();

			if(meGrade=="30")//대표이면
			{
				//환자관리리스트
				$("#listdiv").load("<?=$root?>/Skin/Patient/PatientList.php?p=<?=$_GET['p']?>",function(){
					getlist(search,'all');
				});

			}
			else if(meGrade=="22") //소속한의사이면
			{
				//환자관리리스트
				$("#listdiv").load("<?=$root?>/Skin/Patient/PatientList.php?p=<?=$_GET['p']?>",function(){
					getlist(search,'mine');
				});
			}

		}
		else if(seq=="order")
		{
			$("#listdiv").load("<?=$root?>/Skin/Patient/PatientOrder.php");//환자관리상세에서 처방명 클릭시  
		}
		else
		{
			$("#listdiv").load("<?=$root?>/Skin/Patient/PatientWrite.php?seq="+seq);//환자관리상세 
		}
	}

	function getlist(search,listtype)
	{
		var sear=searchdata(search);
		console.log("listtype  >>>>>>>>"+listtype);
		callapi("GET","/medical/patient/",getdata("patientlist")+"&listtype="+listtype); 
	}

</script>

<?php
   include_once $root."/_Inc/tail.php"; ?>


<script>
	//---------------------------------------------------------
	//환자 팝업
	//환자삭제
	function patient_delete()
	{
		if(!confirm('정말로 삭제하시겠습니까?')){return;}
		var seq=$("input[name=seq]").val();
		callapi("GET","/medical/patient/",getdata("patientdelete")+"&seq="+seq);  
		moremove('modal-patient');
		location.reload();
	}

	//신규등록 버튼 
	function patient_update()
	{	
		//------------------------------------------
		//연락처 휴대전화 유효성 체크

		var regExpPhone = /^\d{2,3}-\d{3,4}-\d{4}$/;
		var regExpMobile = /^\d{3}-\d{3,4}-\d{4}$/;

		var receivemePhone0=$("input[name=mePhone0]").val();
		var receivemePhone1=$("input[name=mePhone1]").val();
		var receivemePhone2=$("input[name=mePhone2]").val();
		var receivemePhone=receivemePhone0+"-"+receivemePhone1+"-"+receivemePhone2;

		var receivemeMobile0=$("input[name=meMobile0]").val();
		var receivemeMobile1=$("input[name=meMobile1]").val();
		var receivemeMobile2=$("input[name=meMobile2]").val();
		var receivemeMobile=receivemeMobile0+"-"+receivemeMobile1+"-"+receivemeMobile2;

		if (!regExpPhone.test(receivemePhone)) 
		{
			alert("잘못된 수신인 전화번호입니다.");
			return false;
		}

		if (!regExpMobile.test(receivemeMobile)) 
		{
			alert("잘못된 수신인 휴대전화번호입니다.");
			return false;
		}

		//------------------------------------------

		var seq=$("input[name=seq]").val();
		console.log("seq>>> "+seq);
		if(!isEmpty(seq))  //수정일때는 동의 체크 패스
		{
			//라디오박스 값 가져오기
			if(ajaxnec()=="Y"){
				var seq=$("input[name=seq]").val();
				var meSex=$('input:radio[name="meSex"]:checked').val();
				callapi("POST","/medical/patient/",getdata("patientupdate")+"&meSex="+meSex+"&seq="+seq);  
				moremove('modal-patient');
				//$("#listdiv").load("/Skin/Patient/PatientList.php");//환자관리리스트
				location.reload();
			}		
		}
		else
		{		
			if($("input:checkbox[name=userchk]").is(":checked") == true) 
			{
				//라디오박스 값 가져오기
				if(ajaxnec()=="Y"){
					var seq=$("input[name=seq]").val();
					var meSex=$('input:radio[name="meSex"]:checked').val();
					callapi("POST","/medical/patient/",getdata("patientupdate")+"&meSex="+meSex+"&seq="+seq);  
					moremove('modal-patient');
					//$("#listdiv").load("/Skin/Patient/PatientList.php");//환자관리리스트
					location.reload();
				}
			}
			else
			{
				alert("정보동의 제공에 체크해주세요");
				return false;	
			}	
		}			
	}
	//---------------------------------------------------------


	function moremove(id){
		//$("#"+id).css("display","none");
		$("#"+id).remove();
	}

	function viewmodal(id)
	{
		console.log("id   >>> "+id);
		var h=$(window).scrollTop();
		$("#"+id).css({"margin-top":(h-100)+"px"});
		showModal(id);
	}

	function viewdesc(seq){
		medicallayer('modal-patient',seq);
	}


	function mypatientlist()
	{
		var mypatient=$('input:radio[name="mypatient"]:checked').val(); //값가져오기
		getlist('',mypatient);
	}

	//팝업리스트뿌리기
	function thismakelist(result, marr)
	{
		var json = JSON.parse(result);
		//console.log("-------------------------------------");
		//console.log(JSON.stringify(json));
		
		var data="";
		
		$.each(json["list"] ,function(index, val){
			
			if(json["apiCode"]=="medicalrecordlist")
			{
				data+="<tr>";				
			}
			else
			{				
				data+="<tr  id='DescDiv"+val["seq"]+"' onclick='viewdesc("+val["seq"]+")'>";
			}
			
			for(i=0;i<marr.length;i++)
			{
				var txt=val[marr[i]];						
			
				data+="<td class='td-txtcenter'>"+txt+"</td>";								
			}
			data+="</tr>";
		});

		//리스트가 없으면
		if(isEmpty(json["list"]))
		{
			data+="<tr>";
			data+="<td colspan='7'>데이터가 없습니다</td>";
			data+="</tr>";
		}


		$("#popuptbl tbody").html(data);
		poppaging("poppaging", json["tpage"],  json["page"]);  //팝업페이징
	}		

	//팝업용페이지 따로뺌
	function poppaging(pgid, tpage, page)
	{
		var block=psize=10;
		var prev=next=0;
		var inloop = (parseInt((page - 1) / block) * block) + 1;
		prev = inloop - 1;
		next = inloop + block;
		var txt="<div class='paging__arrow d-flex'>";
		var link = "";
		if(prev<1){prev = 1;}	link = "popgopage("+prev+")";
		txt+="<a href='javascript:popgopage(1);'  class='paging__btn paging__fst'>처음</a></li>";
		txt+="<a href='javascript:"+link+";' class='paging__btn paging__prev'>이전</a></div>";
		if(tpage == 0)//데이터가 없을 경우
		{
			txt+="<a href='javascript:popgopage(1);'>1</a>";
		}
		else
		{
			for (var i=inloop;i < inloop + block;i++)
			{		
				if (i <= tpage)
				{
					if(i==page){var cls="active";}else{var cls="";}
					txt+="<a href='javascript:popgopage("+i+");'  class='paging__num "+cls+"'>"+i+"</a>";
				}
			}
		}
		txt+="</div><div class='paging__arrow d-flex'>";
		if(next>tpage){next=tpage;}	link = "popgopage("+next+")";
		txt+="<a href='javascript:"+link+";' class='paging__btn paging__next'>다음</a>";
		txt+="<a href='javascript:popgopage("+tpage+");' class='paging__btn paging__lst'>마지막</a>";
		txt+="</div>";
		$("#"+pgid).html(txt);
		return;
	}

	function popgopage(no)
	{	
		$("input[name=page]").remove();

		console.log("여기서 api 호출");


		var userid=$("input[name=userid]").val(); 
		var patientname=$("input[name=patientname]").val(); 

		reorder(userid,patientname,no);

	}

	function makepage(result)
	{		
		var obj = JSON.parse(result);
		console.log(obj);
		console.log("apiCode>>>>> "+obj["apiCode"]);

		if(obj["apiCode"]=="patientlist")  //환자리스트
		{
			//등록일	차트번호	환자명	성별	생년월일	휴대전화	최근처방일
			var marr=["meDate","meChartno","meName","meSex","meBirth","meMobile","meDate","Btn"];	
			makelist(result, marr);
		}
		else if(obj["apiCode"]=="patientdesc")  //환자상세
		{
			$("input[name=meChartno]").val(obj["meChartno"]); ///차트번호
			$("input[name=meName]").val(obj["meName"]); ///환자명

			$("input:radio[name='meSex']:radio[value="+obj["meSex"]+"]").prop('checked', true); // 성별

			$("input[name=meBirth0]").val(obj["meBirth0"]); ///생년월일
			$("input[name=meBirth1]").val(obj["meBirth1"]); ///생년월일
			$("input[name=meBirth2]").val(obj["meBirth2"]); ///생년월일

			$("input[name=mePhone0]").val(obj["mePhone0"]); ///연락처
			$("input[name=mePhone1]").val(obj["mePhone1"]); ///연락처
			$("input[name=mePhone2]").val(obj["mePhone2"]); ///연락처

			$("input[name=meMobile0]").val(obj["meMobile0"]); ///휴대전화
			$("input[name=meMobile1]").val(obj["meMobile1"]); ///휴대전화
			$("input[name=meMobile2]").val(obj["meMobile2"]); ///휴대전화


			$("input[name=meZipcode]").val(obj["meZipcode"]); ///우편번호
			$("input[name=meAddress]").val(obj["meAddress0"]); ///주소
			$("input[name=meAddress1]").val(obj["meAddress1"]); ///주소1
			$("textarea[name=meRemark]").text(obj["meRemark"]);//본초설명 ///기타
		}
		else if(obj["apiCode"]=="medicalrecordlist")  //환자의 이전처방(popup)
		{
			//처방번호	처방일자	처방명	진행상황	합계금액	재처방하기
			var marr=["ordercode","orderdate","ordertitle","orderstatus","amounttotal","patientmemo","Btn"];	
			thismakelist(result, marr);	
		}
		else if(obj["apiCode"]=="againorder")  //재처방
		{
			var json=JSON.parse(obj["JSONDATA"]);

			/* 기존의 값 확인
			var ordercode=json["orderInfo"][0]["orderCode"];
			console.log("0000000000000            ordercode     >>>>>>>>>>>>>>>>>>>"+ordercode);	
			*/

			var ordercode=orderdate=deliveryDate=dir="";

			var d=new Date()
			var month=("0" + (d.getMonth() + 1)).slice(-2);
			var day=("0" + d.getDate()).slice(-2);
			var hour=("0" + d.getHours()).slice(-2);
			var minute=("0" + d.getMinutes()).slice(-2);
			var second=("0" + d.getSeconds()).slice(-2);

			ordercode="MDD"+d.getFullYear()+month+day+hour+minute+second;
			orderdate=d.getFullYear()+"-"+month+"-"+day+" "+hour+":"+minute+":"+second;
			deliveryDate=orderdate;

		console.log("new orderCode >>>> "+ordercode);
		console.log("new orderDate >>>> "+orderdate);
		console.log("new deliveryDate >>>> "+deliveryDate);

			//새로운 keycode,ordercode,orderdate,deliveryDate ,orderStatus 5가지 새로 생성하기
			json["orderInfo"][0]["keycode"]="";
			json["orderInfo"][0]["orderCode"]=ordercode;
			json["orderInfo"][0]["orderDate"]=orderdate;
			json["orderInfo"][0]["deliveryDate"]=deliveryDate;

			json["orderInfo"][0]["orderStatus"]="temp";

			var jsondata=JSON.stringify(json);
			console.log(jsondata);

			dir="reorder";
			console.log("dir >>>"+dir);
			callapi("POST","/medical/order/","data="+jsondata+"&dir="+dir);  //apicode=orderregist

			moremove('modal_medicalrecord');
			console.log("goorder**************************************************************");
		
		}
		else if(obj["apiCode"]=="orderregist")
		{
			/*
			var seq=json["seq"];
			var keycode=json["keyCode"];
			var type=json["type"];
			var jsonData=json["jsonData"];
			console.log("seq    >>>  "+seq+", keycode = "+keycode);
			console.log("jsonData = " + jsonData);
			
			$("input[name=medicalseq]").val(seq);
			$("input[name=medicalkeycode]").val(keycode);

			var obj=JSON.parse(jsonData);
			obj["orderInfo"][0]["keycode"]=keycode;

			$("textarea[name=join_jsondata]").val(JSON.stringify(obj));





			console.log("jsonData after =  " + $("textarea[name=join_jsondata]").val());

			var keycode2=$("input[name=medicalkeycode]").val();
			console.log("######################## type = " + type + ", keycode2 = " + keycode2);

			if(type=="cart")
			{
				alert("접수되었습니다.");
				location.href="/Cart/";
			}
			else
			{
				if(isEmpty(type))
				{
					alert("임시저장되었습니다.");
				}
				makeorderhash("",type,seq);
			}
			*/

			getorderregist(obj);

		}

	}



	
	var p="<?=$_GET['p']?>";
	if(p=="mod"){
		setTimeout("medicallayer('modal-patient','')",500);
	}
</script>
