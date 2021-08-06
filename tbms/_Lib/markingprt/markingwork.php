<?php
	$root="../..";
	include_once $root."/_common.php";



	if($_POST["work"]!="")
	{
		@extract($_POST);
	}
	else
	{
		@extract($_GET);
	}

	echo "work:".$work."<br>";

	switch($work)
	{
//#######################################################
	case "markingcount":
		include $root."/_Lib/markingprt/socket.lib.php";
		$socket_cnt = prt_connect();
		if($socket_cnt)
		{
			//총 카운트 읽기 (l)
			$sendTxt="02 6C 04";
			$txt = str_replace(" ","",$sendTxt);
			$res=prt_sendrecv($socket_cnt, $txt);

			if($res["state"]==true)
			{
				prt_close($socket_cnt);
				$count=intval($res["msg"]);
				echo $res["msg"].'<br>'.$count;
				echo "<script>$('#pouchcnt').val('".$count."')</script>";
			}
			else
			{
				prt_close($socket_cnt);
				echo "<script>alert('".$txtdt['markingprt01']." [".$res["msg"]."(".$res["code"].")]');</script>"; //카운터 확인요망! 
				echo "<script>$('#layersign').fadeOut(1000)</script>";
			}
		}
		else
		{
			prt_close($socket_cnt);
			echo "<script>alert('".$txtdt['markingprt00']."');</script>";//프린터 접속 불가 
			echo "<script>$('#layersign').fadeOut(1000)</script>";
		}
		break;
//#######################################################
	case "markingsetting":
		/*
		include $root."/_Lib/markingprt/socket.lib.php";
		//--------------------------------------------------------------------------
		// 받아온 odcode 로 쿼리
		//--------------------------------------------------------------------------
		$godcode=$_GET["code"];//주문번호 
		$medical=$_GET["medical"];//한의원
		$patient=$_GET["patient"];//환자명
		$patientcode=$_GET["patientcode"];//환자코드 
		$prtype=$_GET["prtype"];//타입 
		$mobile=$_GET["mobile"];//타입
		

		echo 'godcode : '.$godcode.'<br>';
		echo 'medical : '.$medical.'<br>';
		echo 'patient : '.$patient.'<br>';
		echo 'patientcode : '.$patientcode.'<br>';
		echo 'prtype : '.$prtype.'<br>';

		$euc_patient = iconv('UTF-8', 'EUC-KR', $patient); //환자명
		$euc_medical = iconv('UTF-8', 'EUC-KR', $medical); //한의원

		$hex_patient=strToHex($euc_patient);
		$hex_medical=strToHex($euc_medical);
		$hex_patientcode=strToHex("(".$patientcode.")");//환자코드 

		//--------------------------------------------------------------------------
		$odcode=getodCode($godcode); //ODD제거
		$hex_odcode=strToHex($odcode);//ODD제거한 주문코드 hex코드로 변환 



		//20191021 : QR코드 url 주소로 변경 
		$qrurl="https://tbms.pnuh.djmedi.net/report/?key=".$godcode;
		$hex_qrcode=strToHex($qrurl);

		//echo 'odcode : '.$odcode.'<br>';
		//echo 'hex_odcode : '.$hex_odcode."<br>";
		
		//주문번호자리가 16자리일 경우에만 할수 있게 하자 
		//(예외처리:주문번호가 16자리로 고정이기때문에 거의 들어올일이 없다. 그전 주문번호(12자리) 데이터 일경우가 있다.)
		$noMarking = false;
		if($prtype=="marking04") {$noMarking=true;}
		//echo "chkodCodelen($odcode) = ".chkodCodelen($odcode);
		if(chkodCodelen($odcode))
		{
			//echo "<br>prtype : ".$prtype."<br>";

			$socket = prt_connect();

			if($socket)
			{
				//step 1. 문구설정 
				if($noMarking == true) //No Marking일때는 문구설정 패스 
				{
					$res1["state"] = true;
				}
				else
				{					
					$hex_name="";
					$noMarking = false;
					switch($prtype)
					{
					case "marking03"://QR코드, 주문번호, 의료기관명, 환자명
						$hex_name=$hex_patient;	
					break;
					case "marking05"://QR코드, 주문번호, 의료기관명
						$hex_name="";
					break;
					case "marking08"://QR코드, 주문번호, 의료기관명, 환자명(환자코드)
						$hex_name=$hex_patient.$hex_patientcode;
					break;
					}
					

					// 무조건 마킹은 이렇게 데이터가 들어가기! 
					if($noMarking==true)
					{
						$res1["state"] = true;
					}
					else
					{						
						$sendTxt="02 4A ";
						$sendTxt.="3030 2C ".$hex_qrcode." 0D ";//QR : URL코드 
						$sendTxt.="3031 2C ".$hex_odcode." 0D ";//주문번호 
						$sendTxt.="3032 2C ".$hex_medical." 0D ";//한의원
						$sendTxt.="3033 2C ".$hex_name." 0D ";//환자명 
						$sendTxt.="04 02 5A 04";
					

						$txt = str_replace(" ","",$sendTxt);
						echo '<br>보내는 데이터 1 txt : '.$txt.'<br>';
						$res1=prt_sendrecv($socket, $txt);
					}
				}

				if($res1["state"] == true)
				{
					//----------------------------------------
					//2. 총카운트 설정(L) - 0으로 셋팅 하자 
					$sendTxt="02 4C 303030303030303030 0D 04";
					$txt = str_replace(" ","",$sendTxt);
					echo '보내는 데이터 2 txt : '.$txt.'<br>';
					$res3=prt_sendrecv($socket,$txt);
					if($res3["state"]==true)
					{
						prt_close($socket);
						echo '마킹 프린터 설정 완료! <br>';
						echo "<script>$('#layersign').remove()</script>";
						echo "<script>$('#layersign').fadeOut(0)</script>";
						echo "<script>layersign('success','".$txtdt['markingprt05']."','".$txtdt['markingprt06']."','3000')</script>";//마킹 프린터 설정완료, 파우치를 마킹 프린터에 올려 마킹을 시작하세요
						echo "<script>nextstep();</script>";
						echo "<script>intrevalprint();</script>";
					}
					else
					{
						prt_close($socket);
						echo '카운터리셋 확인요망! ['.$res3["msg"].'('.$res3["code"].')] <br>';
						echo "<script>alert('".$txtdt['markingprt04']." [".$res3["msg"]."(".$res3["code"].")]');</script>";//카운터리셋 확인요망!
						echo "<script>$('#layersign').fadeOut(1000)</script>";
						echo "<script>$('#imgfront').data('value', '');</script>";
					}
					//----------------------------------------
				}
				else
				{
					prt_close($socket);
					//echo '문구 설정 확인요망! ['.$res1["msg"].'('.$res1["code"].')] <br>';
					echo "<script>alert('".$txtdt['markingprt02']." [".$res1["msg"]."(".$res1["code"].")]');</script>"; //문구 설정 확인요망!
					echo "<script>$('#layersign').fadeOut(1000)</script>";
					echo "<script>$('#imgfront').data('value', '');</script>";
				}
			}
			else
			{
				prt_close($socket);

				?>
					<script>
					if(confirm("프린터를 일시적으로 사용할수 없습니다\n\n마킹을 종료하시겠습니까?")){
						closelayer();
						gotostep(5);
						setDeliPrint();
					}else{
						$('#layersign').fadeOut(1000);
						$('#imgfront').data('value', '');
					}	
				</script>
				<?php
				//echo "<script>alert('".$txtdt['markingprt00']."');</script>";//프린터 접속 불가 
			}



		}
		else
		{
			echo "<script>alert('".$txtdt['markingprt00']." (".$godcode.")');</script>";//주문번호 확인요망!
			echo "<script>$('#layersign').fadeOut(1000)</script>";
			echo "<script>$('#imgfront').data('value', '');</script>";
		}
		*/

?>
					<script>
					if(confirm("프린터를 일시적으로 사용할수 없습니다\n\n마킹을 종료하시겠습니까?")){
						closelayer();
						gotostep(5);
						setDeliPrint();
					}else{
						$('#layersign').fadeOut(1000);
						$('#imgfront').data('value', '');
					}	
				</script>
				<?php
	break;
	}

?>