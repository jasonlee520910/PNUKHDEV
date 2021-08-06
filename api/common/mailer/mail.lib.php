<?php
	//메일종류추출
	function getmailset($code){
		global $dbH;
		$sql=" select a.*, max(b.af_url) mailimg from ".$dbH."_mailcategory a left join ".$dbH."_file b on a.mc_code=b.af_fcode";
		$sql.=" where mc_code='".$code."'";
		$mailset=dbone($sql);
		return $mailset;
	}

	//메일서버 설정호출
	function getmailconfig(){
		global $dbH;
		$sql=" select * from ".$dbH."_config ";
		$mailarr=dbone($sql);
		return $mailarr;
	}

	//메일폼
	function getmailform($subject,$body){
		global $dbH;
		$mailarr=getmailconfig();
		$str.="<html language='KO'>";
		$str.="<head><title>".$subject ."</title>";
		$str.="<meta http-equiv='content-type' content='text/html; charset=euc-kr' />";
		$str.="</head>";
		$str.="<body style='width:99%;font-family:'Dodum';'>";
		$str.="<table width='600' cellpadding='0' cellspacing='0' border='0' align='center' class='mailtbl' style='border:none;'>";
		$str.="<tr><td style='padding:10px 0 5px 0;font-size:17px;font-weight:bold;'>".$mailarr["cf_mailhead"]."</td><td style='text-align:right;'>".$mailarr["cf_email"]."</td></tr>";
		$str.="<tr><td colspan='2' style='height:1px;background:#aaa;padding:0;'></td></tr>";
		$str.="<tr><td colspan='2' class='maintxt' style='font-size:12px;padding:5px 0 5px 0;'>".$body."</td></tr>";
		//$str.="<tr><td colspan='2' class='subtxt' style='font-size:11px;color:#888;padding:5px 5px 5px 0;font-family:\"Dotum\";'>".iconv("utf-8","euc-kr","*본 이메일은 정보통신 이용촉진 및 정보보호 등에 관한 법률 시행령 제 23조 별도에 의거 발송되었으며 발신전용 이메일로 회신이 불가능합니다")."</td></tr>";
		$str.="<tr><td colspan='2' class='subtxt' style='font-size:11px;color:#888;padding:5px 5px 5px 0;font-family:\"Dotum\";'>*본 이메일은 정보통신 이용촉진 및 정보보호 등에 관한 법률 시행령 제 23조 별도에 의거 발송되었으며 발신전용 이메일로 회신이 불가능합니다</td></tr>";
		$str.="<tr><td colspan='2' class='tailtxt' style='border-top:1px solid #aaa;padding:5px 0 5px 0;'>";

			$substr="<p style='font-size:11px;color:#666;height:10px;margin:0;font-family:\"Dotum\";'>".$mailarr["cf_company"]." | ".str_replace("/"," ",$mailarr["cf_address"])."<br>";
			$substr.="TEL : ".$mailarr["cf_phone"]." ㅣ FAX : ".$mailarr["cf_phone"]."<br>";
			$substr.="Copyright ".$mailarr["cf_companyeng"]." All Rights Reserved</p>";
		
		//$str.=iconv("utf-8","euc-kr",$substr);
		$str.=$substr;
		$str.="</td></tr>";
		$str.="</table></body></html>";
		return $str;
	}

	//메일보내기
	//보내는메일, 이름, 받는메일, 이름, 참조, 숨은참조, 제목, 내용
	function mailsend($autype,$mailcode,$userid,$mailfrom,$fromname,$mailto,$toname,$addcc,$addbcc,$mailsubject,$mailbody){
		global $dtdom;
		global $domain;
		global $company;
		global $mailname;
		global $mailproduct;
		global $serverip;
		global $serverpasswd;
		global $yearmonth;
		$mailval="N";
		if(!$mailname)$mailname=$toname;

		//메일종류호출 메일타입이 컨텐츠가 아닌경우
		if($autype=="board"){
			//메일종류가 컨텐츠일 경우 메일코드는 컨텐츠 seq
			if($mailcode)$mailval="Y";
		}else{
			$mailset=getmailset($mailcode);
			if($mailset)$mailval="Y";
		}

		//키생성
		$authbody="";
		if($mailset["mc_button"]){//메일종류중 버튼이 있는경우 키생성
			$authvalue="";
			//청구서 발행시 년월저장
			if($yearmonth)$authvalue=str_replace("년 ","-",str_replace("월","",$yearmonth));
			$authcode="";
			$authcode=randmix(30);
			insertauthcode("email",$autype,$mailcode,$userid,$mailto,$authvalue,$authcode);
			$authbody="<table><tr><td style='padding:7px;text-align:center;background:#00A0EA;cursor:pointer;'><a href='".$domain."authorization/?code=".$authcode."' target='_blank' style='color:white;font-weight:bold;font-size:12px;text-decoration:none;'>".$mailset[mc_button]."</a></td></tr></table>";
			$authbody.="<p>위의 링크가 작동하지 않을 경우 아래 주소를 복사하여 인터넷 주소창에 붙여넣기 하여 주세요<br>".$domain."authorization/?code=".$authcode."</p>";
		}
		if(!$mailsubject)$mailsubject=$mailset["mc_title"];//메일제목이 따로없는경우 메일종류제목대체

		if(!$mailbody){//메일내용이 없는경우 메일종류제목대체
			$mailsubject=str_replace("[company]","[".$company[cf_company]."] ",$mailsubject);
			$mailsubject=str_replace("[name]",$mailname,$mailsubject);
			$mailsubject=str_replace("[product]",$mailproduct,$mailsubject);
			$mailsubject=str_replace("[yearmonth]",$yearmonth,$mailsubject);
			$mailsubtitle=str_replace("[company]","[".$company[cf_company]."] ",$mailset[mc_subtitle]);
			$mailsubtitle=str_replace("[name]",$mailname,$mailsubtitle);
			$mailsubtitle=str_replace("[product]",$mailproduct,$mailsubtitle);
			$mailsubtitle=str_replace("[yearmonth]",$yearmonth,$mailsubtitle);

			$mailbody="<p style='font-size:11px;line-height:100%;color:#888;'>안녕하세요 ".$company[cf_company]."입니다!</p>";
			$mailbody.="<p style='font-size:15px;font-weight:bold;line-height:100%;padding:20px 0 20px 0;'>".nl2br($mailsubtitle)."</p>";
			//$body.="<p><img src='".$dtdom.$mailset[mailimg]."'></p>";
			$medetail=str_replace("[date]",date("Y.m.d"),$mailset[mc_detail]);
			$medetail=str_replace("[time]",date("H:i:s"),$medetail);
			$medetail=str_replace("[company]","[".$company[cf_company]."] ",$medetail);
			$medetail=str_replace("[name]",$mailname,$medetail);
			$medetail=str_replace("[product]",$mailproduct,$medetail);
			$medetail=str_replace("[serverip]",$serverip,$medetail);
			$medetail=str_replace("[serverpasswd]",$serverpasswd,$medetail);
			$medetail=str_replace("[yearmonth]",$yearmonth,$medetail);
			//$medetail=str_replace("[userid]",date("Y.m.d"),$medetail);
			$mailbody.="<p style='padding:10px 0 10px 0;color:#888;'>".nl2br($medetail)."</p>";
			$mailbody.=$authbody;
		}else{
			$mailsubject="[".$company[cf_company]."] ".$mailsubject;
			$mailbodytmp="<p style='font-size:11px;line-height:100%;color:#888;'>안녕하세요 ".$company[cf_company]."입니다!</p>";
			$mailbodytmp.="<p style='font-size:15px;font-weight:bold;line-height:100%;padding:20px 0 20px 0;'>".$mailsubject."</p>";
			$mailbody=$mailbodytmp.$mailbody;
		}


		$result=sendmail($mailfrom,$fromname,$mailto,$toname,$addcc,$addbcc,$mailsubject,$mailbody);

		//메일로그에기록
		if($result){$status="Y";}else{$status="F";}
		insertmaillog($autype,$mailcode,$userid,$mailto,$mailsubject,$mailbody,$status);

		return $result;
	}

	function insertmaillog($autype,$mailcode,$userid,$mailto,$mailsubject,$mailbody,$status){
		global $dbH;
		global $adminid;
		$mailbody=addslashes($mailbody);
		$sql="insert into ".$dbH."_maillog (ml_type, ml_code, ml_userid, ml_email, ml_title, ml_detail, ml_staff, ml_use, ml_date";
		$sql.=") values (";
		$sql.="'".$autype."', '".$mailcode."', '".$userid."', '".$mailto."', '".$mailsubject."', '".$mailbody."', '".$adminid."', '".$status."', now())";
		dbqry($sql);
	}


	//PHPMailer 발송
	//echo $result;
	//보내는메일, 이름, 받는메일, 이름, 참조, 숨은참조, 제목, 내용
	function sendmail($mailfrom,$fromname,$mailto,$toname,$addcc,$addbcc,$mailsubject,$mailbody){
		global $root;
		global $dbH;

		/*
		$sql=" select cf_mailserver, cf_mailport, cf_mailsender, cf_mailid, cf_mailpw from ".$dbH."_config";
		$dt=dbone($sql);
		date_default_timezone_set('Asia/Seoul');
		$mailsecure="";
		$mailhost=$dt["cf_mailserver"];
		$mailport=$dt["cf_mailport"];
		$mailid=$dt["cf_mailid"];
		$mailsender=$dt["cf_mailsender"];
		$mailpw=$dt["cf_mailpw"];
		$mailfrom=$mailsender;
		//$mailbody=getmailform($mailsubject,$mailbody);
		*/
		//GOOGLE 게정으로 세팅
		date_default_timezone_set('Asia/Seoul');
		$mailsecure="ssl";
		$mailhost="smtp.gmail.com";
		$mailport="465";
		$mailid="app.djmedi@gmail.com";
		$mailpw="xbaozqzsanyntfln"; //앱 비밀번호 

		$mail = new PHPMailer(true); // the true param means it will throw exceptions on errors, which we need to catch 
		$mail->CharSet				= "utf-8";
		//$mail->Encoding				= "base-64";
		$mail->IsSMTP();	// telling the class to use SMTP 
		$mail->SMTPDebug  = 1;	// enables SMTP debug information (for testing) // 2 = messages only

		try { 
				$mail->SMTPAuth   = true;	// enable SMTP authentication
				$mail->SMTPSecure = $mailsecure;	// sets the prefix to the servier
				$mail->Host       = $mailhost;	//  sets mail as the SMTP server
				$mail->Port       = $mailport;	// 465 set the SMTP port for the mail server
				$mail->Username   = $mailid;	// mail username
				$mail->Password   = $mailpw;	// mail password
			
				$mail->SetFrom($mailfrom, $fromname);// 보내는 사람 email 주소와 표시될 이름 (표시될 이름은 생략가능) 
				$mail->AddAddress($mailto, $toname); // 받을 사람 email 주소와 표시될 이름 (표시될 이름은 생략가능)
				if($addcc)$mail->AddCC($addcc);// 참조 email 주소
				if($addbcc)$mail->AddBCC($addbcc);// 숨은참조 email 주소

				$mail->Subject = $mailsubject; // 메일 제목
				$mail->IsHTML(true);
				$mail->Body = $mailbody; //HTML Body
				$mail->Send(); 
			
				//echo "Message Sent OK<p></p>\n";
				$str="OK";
		} 
		catch (phpmailerException $e) { 
				//echo $e->errorMessage(); //Pretty error messages from PHPMailer 
				$str="0";
		} catch (Exception $e) { 
				//echo $e->getMessage(); //Boring error messages from anything else! 
				$str="1";
		}
		return $str;
	}
?>