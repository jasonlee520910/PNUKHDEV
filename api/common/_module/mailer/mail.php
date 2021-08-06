<?php
	date_default_timezone_set('Asia/Seoul');

	$mailsecure="";
	//GMAIL
	$mailhost="smtp.gmail.com";
	$mailport=465;
	$mailid="zoomy00@gmail.com";
	$mailpw="dPdma!23";

	//BENICENET
	$mailhost="mail.benicenet.co.kr";
	$mailport=25;
	$mailid="green@benicenet.co.kr";
	$mailpw="dPdma123";

	$mailfrom="green@benicenet.co.kr";
	$mailfromname="green";

	$mailsubject=iconv("utf-8","euc-kr","제목입니다");
	$mailbody=iconv("utf-8","euc-kr","내용입니다.<br>감사");
	
	//메일러 로딩 
	//require_once("./class.smtp.php"); 
	require_once("./class.phpmailer.php"); 
	$mail = new PHPMailer(true); // the true param means it will throw exceptions on errors, which we need to catch 
	$mail->CharSet				= "euc-kr";
	//$mail->Encoding				= "base-64";
	$mail->IsSMTP();																		// telling the class to use SMTP 
	$mail->SMTPDebug  = 2;															// enables SMTP debug information (for testing)
																											// 1 = errors and messages
																											// 2 = messages only
	try { 
			$mail->SMTPAuth   = true;												// enable SMTP authentication
			$mail->SMTPSecure = $mailsecure;											// sets the prefix to the servier
			$mail->Host       = $mailhost;						//  sets mail as the SMTP server
			$mail->Port       = $mailport;												// 465 set the SMTP port for the mail server
			$mail->Username   = $mailid;				// mail username
			$mail->Password   = $mailpw;									// mail password
		
			//$mail->From('zoomy00@gmail.com');								// 보내는 사람 email 주소 
			//$mail->FromName('TESTER');											// 표시될 이름 (표시될 이름은 생략가능) 
			$mail->SetFrom($mailfrom, $mailfromname);// 보내는 사람 email 주소와 표시될 이름 (표시될 이름은 생략가능) 
			//$mail->AddReplyTo("green@joohan.com","green");// 회신 email 주소와 표시될 이름 (표시될 이름은 생략가능)
			$mail->AddCC("zoomy@nate.com");// 참조 email 주소
			$mail->AddBCC("green@joohan.com");// 숨은참조 email 주소

			$mail->AddAddress('zoomy@nate.com', 'YOU'); // 받을 사람 email 주소와 표시될 이름 (표시될 이름은 생략가능)
			
			$mail->Subject    = $mailsubject; // 메일 제목
			$mail->IsHTML(true);
			$mail->Body = $mailbody; //HTML Body
			//$mail->AltBody = "This is the body when user views in plain text format"; //Text Body
			//$mail->MsgHTML = $mailbody; //메일 내용 (HTML 형식도 되고 그냥 일반 텍스트도 사용 가능함) 
		
			$mail->AddAttachment('../img/phpmailer.gif');      // attachment
			$mail->AddAttachment('../img/phpmailer_mini.gif'); // attachment

			$mail->Send(); 
		
			echo "Message Sent OK<p></p>\n"; 
	} 
		
	catch (phpmailerException $e) { 
			echo $e->errorMessage(); //Pretty error messages from PHPMailer 
	} catch (Exception $e) { 
			echo $e->getMessage(); //Boring error messages from anything else! 
	}
?>
