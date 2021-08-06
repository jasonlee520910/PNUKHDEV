<?php
	$apiCode=$_GET["apiCode"];
	$language=$_GET["language"];
	//$type=$_GET["type"]; //성별 female , male
	//$email=$_GET["email"];//년 

	$memberemail=$_GET["memberemail"];//가입한 사람 이메일 주소
	$me_loginid=$_GET["stUserId"];//가입한 사람 아이디 

	$stName=$_GET["stName"];//이름
	$agreetime=$_GET["agreetime"];//가입한 날짜
	
	if($apiCode!="sendemail"){$json["resultMessage"]="API(apiCode) ERROR";$apiCode="sendemail";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="API(language) ERROR";}
	else
	{
		include_once $root.$folder."/mailer/mail.lib.php";
		//메일러 로딩 
		//require_once("./class.smtp.php"); 
		require_once($root.$folder."/_module/mailer/class.phpmailer.php"); 

		//메일발송
		$mailfrom="djmedi@djmedi.net";  //보내는 사람 메일 주소
		$fromname="부산대학교한방병원 원외탕전실";
		$mailto=$memberemail; //받는사람	

		$toname=$stName; //받는사람 이름
		$addcc="";
		$addbcc="";
		$mailsubject="부산대학교한방병원 원외탕전실에서 보낸 인증메일입니다.";  //메일 제목
		//$root.$folder.'/mailform.html'

		$mailbody="";

		$joindate = date("Y-m-d", strtotime($agreetime));

		/// 암호화하기 
		$authkey = randmix(20);
		$endata = djEncrypt($authkey."_".$me_loginid, "chkemail");

	//------------------------------
	//메일 내용

		$mailbody.="<!doctype html>";
		$mailbody.="<html lang='en'>";
		$mailbody.="<head>";
		$mailbody.="<title>pnuh</title>";
		$mailbody.="</head>";
		$mailbody.="<body>";
		$mailbody.="<div class='mmain' style='padding:10px 0;border:5px solid #ddd;min-width:600px;'><img src='https://ehd.pnuh.djmedi.net/assets/images/icon/logo_pnuh.png'>";
		$mailbody.="<div class='mtop'  style='padding:10px 0;padding:20px 20px 30px 20px;border-bottom:5px solid #073E8C;'></div>";
		$mailbody.="<ul>";
		$mailbody.="<li style='list-style:none;'>";
		$mailbody.="<span><img src='https://www.pnuh.or.kr/pnuh/images/mail/mail_visual01.gif' style='vertical-align:top;'></span>";
		$mailbody.="<span class='mtopsp' style='display:inline-block;padding:67px 0 0 10px;width:auto;color:#666;'>안녕하세요. ".$stName." 회원님!<br>부산대학교한방병원원외탕전실의 회원이 되신 것을 진심으로 환영합니다.</span>";
		$mailbody.="</li>";
		$mailbody.="</ul>";
		$mailbody.="<div class='mcenter' style='padding:10px 0;width:80%;margin:50px auto;border:10px solid #ddd;padding:20px;'>";
		$mailbody.="<dl style='margin-left:30%;overflow:hidden;'>";
		$mailbody.=" <dt style='float:left;display:block;margin:10px;line-height:100%;clear:left;width:15%;border-right:1px solid #ddd;'>성명</dt>";
		$mailbody.=" <dd style='float:left;display:block;margin:10px;line-height:100%;width:60%;padding-left:20px;'>".$stName."</dd>";
		$mailbody.=" <dt style='float:left;display:block;margin:10px;line-height:100%;clear:left;width:15%;border-right:1px solid #ddd;'>아이디</dt>";
		$mailbody.=" <dd style='float:left;display:block;margin:10px;line-height:100%;width:60%;padding-left:20px;'>".$me_loginid."</dd>";
		$mailbody.=" <dt style='float:left;display:block;margin:10px;line-height:100%;clear:left;width:15%;border-right:1px solid #ddd;'>등록일</dt>";
		$mailbody.=" <dd style='float:left;display:block;margin:10px;line-height:100%;width:60%;padding-left:20px;'>".$joindate."</dd>";
		$mailbody.="</dl>";
		$mailbody.="</div>";
		$mailbody.="<div class='mbot'  style='padding:10px 0;width:100%;text-align:center;'>";
		$mailbody.="<span style='width:auto;margin:auto;background:#073E8C;color:#fff;padding:20px;'>";
		$mailbody.="<a href='https://manager.pnuh.djmedi.net/authemail/?key=".$endata."' style='color:#fff;'>부산대학교한방병원원외탕전실 인증하기 > </span></div>";
		$mailbody.="<div class='mnoti'  style='padding:10px 0;width:85%;margin:50px auto;font-size:12px;color:#aaa;'>회원님은 부산대학교한방병원원외탕전실에 2020년 06월 30일 이용약관에 동의하셨고 부산대학교한방병원원외탕전실은 온라인 상에서 귀하의 개인정보 보호문제를 아주 중요하게 생각합니다. [이용약관]과 [개인정보 보호정책]을 다시한번 참고해주세요.</div>";
		$mailbody.="<div class='mcopy'  style='padding:10px 0;background:#00324C;color:#aaa;font-size:12px;padding:3% 8%;line-height:150%;'>
		본 메일은 발신전용 메일입니다.<br>
		메일을 원하지 않을 경우 로그인 하신 후 <i style='color:#fff;padding:0 5px;'>회원정보 - 내 정보</i>에서 <i>메일수신여부</i>를 변경하세요.<br>
		Copyright 2020 Pusan National University Korean Medicine Hospital. All Rights Reserved.</div>";
		$mailbody.="</div>";
		$mailbody.="</body>";
		$mailbody.="</html>";
	//------------------------------

//echo $mailbody;

		//보내는메일, 이름, 받는메일, 이름, 참조, 숨은참조, 제목, 내용
		$result=sendmail($mailfrom,$fromname,$mailto,$toname,$addcc,$addbcc,$mailsubject,$mailbody);
		$json["result"] = $result;


		include_once $root.$folder."/mailer/oracleDB.php";

		$sql=" update han_member set me_confirm='".$authkey."' ";	
		$sql.=" where me_loginid='".$me_loginid."' ";  

		dbcommit($sql);	

		$json["apiCode"] = $apiCode;
		$json["endata"] = $endata;  //"UdpKGgIuQPmtQaFnepY%2B8j52hyk4Pn%2BvuvMnnskPtxc%3D"
		$json["me_loginid"] = $me_loginid;
		$json["sql"] = $sql;
		$json["memberemail"] = $memberemail;
		$json["agreetime"] = $agreetime;

	

		if($result){
			$json["resultCode"]="200";
			$json["resultMessage"]="OK";
		}else{
			$json["resultCode"]="204";
			$json["resultMessage"]="FAIL";
		}
	}

?>