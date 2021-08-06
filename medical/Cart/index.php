<?php
	$root="..";
	include_once $root."/_Inc/head.php";
?>
<div id="listdiv"></div>
<input type="hidden" name="medicalid" class="ajaxdata" value="<?=$_COOKIE["ck_miUserid"]?>">
<script>
	function getlist()
	{
		callapi("GET","/medical/order/",getdata("orderlist")+"&pagetype=cart");
	}

	//해시값이 바뀌면 
	window.onhashchange = function(e) {
		viewpage();
	}
	
	viewpage();  //첫페이지

	function viewpage()
	{
		var hdata=location.hash.replace("#","").split("|");
		$("#listdiv").load("<?=$root?>/Skin/Cart/CartList.php",function(){
			getlist();
		});//장바구니리스트 
	}

</script>

<?php   include_once $root."/_Inc/tail.php"; ?>

<script>
	function makepage(result)
	{		
		var obj = JSON.parse(result);
		console.log(obj);
		console.log("carlist apiCode>>>>> "+obj["apiCode"]);

		if(obj["apiCode"]=="orderlist") //cartlist 
		{
			var marr=["cartchkbox","ordertype","doctorname","ordertitle","ordercount","totalmedicine","totalmaking","totaldelivery","patientname","orderdate","keycode","ordertypecode"];	
			makelist(result, marr);
			resetamount();
		}
		else if(obj["apiCode"]=="cartupdate")
		{
			if(obj["carttype"]=="bank")
			{
				var cartseq=obj["cartseq"];
				var carttype=obj["carttype"];
				callapi("POST","/medical/order/",getdata("orderpayment")+"&cartseq="+cartseq+"&carttype="+carttype);
			}
			else
			{
				//cartseq
				$("input[name=reserved01]").val(obj["seq"]);  //payment seq 
				setTimeout("goPc()",1000);	//결제창띄우기
			}
		}
		else if(obj["apiCode"]=="orderpayment")
		{
			if(obj["resultCode"]=="200")
			{
				alert("결재가 완료되었습니다.");
				location.href="/Order/";
			}
			else
			{
				alert(obj["resultMessage"]);
			}
		}
		
	}


	function chkall(box)
	{
		console.log("체크박스 전체 선택하자!!!");
		if(box.checked==true)
		{
			$(".cblind").prop("checked", true);
		}
		else
		{
			$(".cblind").prop("checked", false);
		}
		resetamount();
	}

	function resetamount()
	{
		var totmedi=totmaking=totdelivery=totamount=totcnt=0;
		$("#tbl tbody tr").each(function(){
			var val=$(this).children("td").eq(0).find("input").prop("checked");
			if(val==true)
			{
				totmedi=parseInt($(this).children("td").eq(5).text().replace(",",""));
				totmaking=parseInt($(this).children("td").eq(6).text().replace(",",""));
				totdelivery=parseInt($(this).children("td").eq(7).text().replace(",",""));
				

				totamount+=totmedi+totmaking+totdelivery;
				totcnt++;
			}
		});
		//주문금액
		$("#totmedicine").text(commasFixed(totmedi));
		//제조비용
		$("#totmaking").text(commasFixed(totmaking));
		//배송비
		$("#totdelivery").text(commasFixed(totdelivery));
		//결제예정금액
		$("#totamount").text(commasFixed(totamount));
		//선택된상품
		$("#chkcount").text(commasFixed(totcnt));
	}
	function cartcancel()
	{

		/*
		if(!isEmpty(ck_cart))
		{
			var ckarr = ck_cart.split(",");

			$("#tbl tbody tr").each(function(){
				var val=$(this).children("td").eq(0).find("input").prop("checked");
				if(val==true)
				{
					var seq=$(this).children("td").eq(0).find("input").data("seq");
					console.log(seq);
					for(i=1;i<ckarr.length-1;i++)
					{
						if(parseInt(ckarr[i])==parseInt(seq))
						{
							ckarr.splice(i,1);
						}
					}
				}
			});


			viewpage();
		}
		*/
	}

	function removeComma(str)
	{
		n = parseInt(str.replace(/,/g,""));
		return n;
	}
	//상품코드(MAX10자리)
	function getBuyItemcd()
	{
		var buyItemcd="";
		var d=new Date()
		var month=("0" + (d.getMonth() + 1)).slice(-2);
		var day=("0" + d.getDate()).slice(-2);
		var hour=("0" + d.getHours()).slice(-2);
		var minute=("0" + d.getMinutes()).slice(-2);
		var second=("0" + d.getSeconds()).slice(-2);
		buyItemcd=month+day+hour+minute+second;

		return buyItemcd;
	}
	//결제::무통장입금
	function cartpaymentBank()
	{
		console.log("결재하기API로 가기!");
		var cartseq=orderno=cartorderno=totalcartorderno=onemedi=onemaking=onedelivery=oneamount=totaloneamount="";
		var buyReqamt = removeComma($("#totamount").text());
		$("#tbl tbody tr").each(function(){
			var val=$(this).children("td").eq(0).find("input").prop("checked");
			if(val==true)
			{
				cartseq+=","+$(this).children("td").eq(0).find("input").data("seq");
				cartorderno= ","+$(this).children("td").eq(10).text();  //keycode
				totalcartorderno+=cartorderno;

				//각각의 가격
				onemedi=parseInt($(this).children("td").eq(5).text().replace(",",""));
				onemaking=parseInt($(this).children("td").eq(6).text().replace(",",""));
				onedelivery=parseInt($(this).children("td").eq(7).text().replace(",",""));

				oneamount=onemedi+onemaking+onedelivery;	
				totaloneamount+=","+oneamount;

			}
		});

		orderno=getBuyItemcd();

		console.log("orderno = "+orderno+", totalcartorderno = " + totalcartorderno+", totaloneamount = " + totaloneamount+", buyReqamt = " + buyReqamt+", cartseq = " + cartseq);
		cartpaymentupdate("bank",orderno, totalcartorderno, totaloneamount, buyReqamt, "", cartseq);


	}
	//결제::신용카드
	function cartpayment()
	{
		console.log("결재하기API로 가기!");
		var seq=buyItemnm="";
		var i=0;
		$("#tbl tbody tr").each(function(){
			var val=$(this).children("td").eq(0).find("input").prop("checked");
			if(val==true)
			{
				seq+=","+$(this).children("td").eq(0).find("input").data("seq");
				console.log(seq);
				if(buyItemnm==""){
					//상품명
					buyItemnm = $(this).children("td").eq(3).text();
				}
				i++;
			}
		});
		//if(i<1)
		//{
			//alert("결제하실 상품이 없습니다.");
	//	}
		//else
		//{
			if(i>2)i="외 "+(i-1)+"건";
			$("input[name=buyItemnm]").val(buyItemnm+i);  //상품이름
			var buyReqamt = removeComma($("#totamount").text());
			console.log("원래 상품가격 >>> "+buyReqamt);
			$("input[name=buyReqamt]").val(buyReqamt);  //상품가격
			//$("input[name=buyReqamt]").val('1004');  //상품가격//테스트용

				var buyItemcd=cartorderno=onemedi=onemaking=onedelivery=oneamount=totaloneamount=totalcartorderno="";
				var	onecnt=0;
				$("#tbl tbody tr").each(function(){
					var val=$(this).children("td").eq(0).find("input").prop("checked");
					if(val==true)
					{						
						//상품코드 (max 10자리)
						/*var d=new Date()
						var month=("0" + (d.getMonth() + 1)).slice(-2);
						var day=("0" + d.getDate()).slice(-2);
						var hour=("0" + d.getHours()).slice(-2);
						var minute=("0" + d.getMinutes()).slice(-2);
						var second=("0" + d.getSeconds()).slice(-2);
						    buyItemcd=month+day+hour+minute+second;*/

						buyItemcd=getBuyItemcd();
						
	
						$("input[name=buyItemcd]").val(buyItemcd); //상품코드 //max 10								
						$("input[name=orderno]").val(buyItemcd);

						cartorderno= ","+$(this).children("td").eq(10).text();  //keycode
								
						totalcartorderno+=cartorderno;


						//각각의 가격
						onemedi=parseInt($(this).children("td").eq(5).text().replace(",",""));
						onemaking=parseInt($(this).children("td").eq(6).text().replace(",",""));
						onedelivery=parseInt($(this).children("td").eq(7).text().replace(",",""));

						oneamount=onemedi+onemaking+onedelivery;	
						totaloneamount+=","+oneamount;

						onecnt++;
						
					}

					
				});

				//구매자 ID
				//buyerid
				var buyerid=$("input[name=doctorId]").val();
				$("input[name=buyerid]").val(buyerid);

				//구매자명
				var buyernm=$("input[name=doctorName]").val();
				$("input[name=buyernm]").val(buyernm);

				//구매자 E-mail
				//buyerEmail


				var d= new Date()
				var month=d.getMonth()+1;
				if(month<10)month="0"+month;
				var day=d.getDate();
				if(day<10)day="0"+day;
				var hour=d.getHours();
				if(hour<10)hour="0"+hour;
				var minute=d.getMinutes();
				if(minute<10)minute="0"+minute;
				var second=d.getSeconds();
				if(second<10)second="0"+second;

				var orderno = $("input[name=orderno]").val();
				console.log("주문번호 orderno    >> "+orderno);
				var orderdt = d.getFullYear()+month+day;
				var ordertm = hour+""+minute+""+second;


				//주문일자
				$("input[name=orderdt]").val(orderdt);
				
				//주문시간
				$("input[name=ordertm]").val(ordertm);

				console.log("주문일자 orderdt    >> "+orderdt);
				console.log("주문시간 ordertm    >> "+ordertm);

   
			if(!isEmpty(seq))
			{
				//alert(" orderpayment seq    "+seq);
				$("input[name=reserved01]").val(seq);   //reserved01 예약필드에 넣어서 넘김

				var txt="<input type='hidden' class='ajaxdata' name='cartseq' value='"+seq+"'>";
				$("body").prepend(txt);
				//callapi("POST","/medical/order/",getdata("orderpayment"));    //이부분을 pnuhdevehd@10.1.1.21:/home/pnuhdevehd/www/Cart/webpay_return.php 페이지로 이동
		
				goHash(); //hash key 생성
				//$("input[name=cartseq]").remove();
			}

			//goPc();
		//}
	}

	function cartpaymentupdate(type, orderno, totalcartorderno, totaloneamount, buyReqamt, resp, cartseq)
	{
		//------------------------------------------------------------------
		//cart와 paymnet insert
		var carttxt="<input type='hidden' class='ajaxdata' name='totalbuyItemcd' value='"+orderno+"'>";   //상품코드
				carttxt+="<input type='hidden' class='ajaxdata' name='totalcartorderno' value='"+totalcartorderno+"'>";  //각각의 keycode
				carttxt+="<input type='hidden' class='ajaxdata' name='totaloneamount' value='"+totaloneamount+"'>";  //각각의 주문가격
				
				carttxt+="<input type='hidden' class='ajaxdata' name='totalamount' value='"+buyReqamt+"'>";  //총 결제가격
				carttxt+="<input type='hidden' class='ajaxdata' name='hashkey' value='"+resp+"'>";  //	
				carttxt+="<input type='hidden' class='ajaxdata' name='carttype' value='"+type+"'>";  //
				carttxt+="<input type='hidden' class='ajaxdata' name='cartseq' value='"+cartseq+"'>";  //cartseq
				
		$("body").prepend(carttxt);
		callapi("POST","/medical/order/",getdata("cartupdate"));

		$("input[name=totalbuyItemcd]").remove();
		$("input[name=totalcartorderno]").remove();
		$("input[name=totaloneamount]").remove();
		$("input[name=totalamount]").remove();
		$("input[name=hashkey]").remove();
		$("input[name=carttype]").remove();
		$("input[name=cartseq]").remove();
	}
	
	function goHash(){
		var orderno = $("input[name=orderno]").val();
		var orderdt = $("input[name=orderdt]").val();
		var ordertm = $("input[name=ordertm]").val();
		var buyReqamt = $("input[name=buyReqamt]").val();
		var cartseq = $("input[name=cartseq]").val();
		var apiKey =  "cf4dae5bb7b7606aa35e05aaba23b6a6";  //넘어오는 값 확인해야함
		var hashkey =orderno + orderdt + ordertm + buyReqamt;

	
		//------------------------------------------------------------------

		$.ajax({
			url:'./checkHash.php',
			method:"POST",
			data : {"message" : hashkey,"apiKey" : apiKey},
			success:function(resp){
				//document.getElementById('hashtd').innerHTML = resp;
				console.log("resp    >>"+resp);
				$("#checkHash").val(resp);		

	
				//------------------------------------------------------------------
				cartpaymentupdate("card",orderno, totalcartorderno, totaloneamount, buyReqamt, resp, cartseq);
				//cart와 paymnet insert
				//var carttxt="<input type='hidden' class='ajaxdata' name='totalbuyItemcd' value='"+orderno+"'>";   //상품코드
				//		carttxt+="<input type='hidden' class='ajaxdata' name='totalcartorderno' value='"+totalcartorderno+"'>";  //각각의 keycode
				//		carttxt+="<input type='hidden' class='ajaxdata' name='totaloneamount' value='"+totaloneamount+"'>";  //각각의 주문가격
				//		
				//		carttxt+="<input type='hidden' class='ajaxdata' name='totalamount' value='"+buyReqamt+"'>";  //총 결제가격
				//		carttxt+="<input type='hidden' class='ajaxdata' name='hashkey' value='"+resp+"'>";  //	
						
				//$("body").prepend(carttxt);
				//callapi("POST","/medical/order/",getdata("cartupdate"));

				//$("input[name=totalbuyItemcd]").remove();
				//$("input[name=totalcartorderno]").remove();
				//$("input[name=totaloneamount]").remove();
				//$("input[name=totalamount]").remove();
				//$("input[name=hashkey]").remove();
			},fail:function(resp){
				alert("실패");
			}
		});
	} 

		
		function goPc(){
			//alert("goPc");
			//var PG_DOMAIN  = 'https://auth.kocespay.com';		// 운영
			//var PG_DOMAIN  = 'https://authtest.kocespay.com';		// 개발
			var PG_DOMAIN=getUrlData("PG_DOMAIN");
			console.log("goPc PG_DOMAIN = " + PG_DOMAIN);

			window.name = "myOpener";
			var win;
			var iLeft = (window.screen.width / 2) - (Number(550) / 2);
		  var iTop = (window.screen.height / 2) - (Number(653) / 2);
			var features = "menubar=no,toolbar=no,status=no,resizable=no,scrollbars=no,location=no";
			features += ",left=" + iLeft + ",top=" + iTop + ",width=" + 550 + ",height=" + 653;
			win = window.open("", "pcPop", features);//https://auth.kocespay.com/webpay/common/mainFrame.pay
			//win.focus();
			//alert($("form[name=form_koces_payment]").serialize())
			
			document.form_koces_payment.action = PG_DOMAIN+'/webpay/common/mainFrame.pay';
			document.form_koces_payment.target = "pcPop";
			document.form_koces_payment.submit();
		}


</script>
