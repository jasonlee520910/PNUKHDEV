<?php
	include_once($root."/_Inc/_define.php");
	include_once($root."/_Inc/_session.php");
	include_once($root."/_Lib/_lib.php");

	$https=$_SERVER["HTTPS"];
	$host = $_SERVER["HTTP_HOST"];
	$ip = $_SERVER["REMOTE_ADDR"];
	$furl = $_SERVER["REQUEST_URI"];

	$farr= explode("?",$furl);
	$pageurl= $farr[0];
	$darr=explode("/",$pageurl);
	$dir= $darr[1];
	$dirfile= $darr[2];
	$depart=$dir;

	$language=$_COOKIE["ck_language"];
	$languagetxt=$_COOKIE["ck_languageName"];

	if(!$language)
	{
		$language="kor";
		$languagetxt="한글";
	}
	if(!$languagetxt)	
	{
		switch($language)
		{
		case "chn":
			$language = "chn";
			$languagetxt = "中文";
			break;
		case "eng":
			$language = "eng";
			$languagetxt = "eng";
			break;
		default:
			$language = "kor";
			$languagetxt = "한글";
			break;
		}
	}

	$_COOKIE["ck_language"]=$language;
	$_COOKIE["ck_languageName"]=$languagetxt;

	//TBMS
	$fileName="/datatbms".$language.".json";
	$fileUrl=$NET_FILE_URL."textdata".$fileName;
	$response = (file_get_contents($fileUrl)); //Converting in json string
	$txtdt=json_decode(urldecode($response),true);
	//var_dump($txtdt);
	/*
	$result=curl_get($NET_URL_API_TBMS, "setting","textdbfront","type=front");
	$txtdt=json_decode($result,true);
	*/
	//품질보고서(document.report.php), 복약지도서(document.advice.php) 복약지도서(document.medicationreport.php)
	//document.delicnt
	if($pageurl=="/report/" || $pageurl=="/report/report.php" || $dirfile=="document.qareport.php" || $dirfile=="document.report.php" || $dirfile=="document.delicnt.php" || $dirfile=="document.deliprint.php" || $dirfile=="document.advice.php" || $dirfile=="document.medicationreport.php" ){
		//echo "<br>".$pageurl."<br>";
	}
	else
	{
		checkSession($NET_URL_MEMBER);
	}

	//공통으로 쓰이는 텍스트 js에서 쓰이기 위함 
	$ComTxtdt = array(
			"MEDIBOXNONE"=>$txtdt["mediboxnone"],//약재함이 존재하지 않거나 사용할수 없습니다.
			"MEDIDEDUCTFAIL"=>$txtdt["medideductfail"],//약재차감에 실패하였습니다.
			"MEDISHORTAGE"=>$txtdt["medishortage"],//약재가 부족합니다.
			"NODATA"=>$txtdt["nodata"],//데이터가 없습니다.

			"WORKDONE"=>$txtdt["workdone"],//작업완료
			"WORKDONETXT"=>$txtdt["workdonetxt"],//작업이 완료되었습니다

			"PROCCONFIRM"=>$txtdt["procconfirm"], //계속진행
			"PROCCANCEL"=>$txtdt["proccancel"], //다시시작 
			"PROCDONE"=>$txtdt["procdone"], //완료처리 
			"CLOSE"=>$txtdt["close"], //닫기

			"CONFIRM"=>$txtdt["confirm"], //확인
			"CANCEL"=>$txtdt["cancel"], //취소

			"9001"=>$txtdt["9001"],//정량을 확인 후 정상일 경우 작업지시서를 스캔해 주세요
			"9003"=>$txtdt["9003"],//재촬영

			"9007"=>$txtdt["9007"],//재촬영
			"9008"=>$txtdt["9008"],//재촬영


			"9014"=>$txtdt["9014"],//취소된 지시서 입니다.
			"9015"=>$txtdt["9015"],//중지된 지시서 입니다.
			"9016"=>$txtdt["9016"],//완료된 지시서 입니다.
			"9017"=>$txtdt["9017"],//다른 작업자가 진행중입니다.
			"9018"=>$txtdt["9018"],//다른 조제대에서 진행중입니다.

			"9022"=>$txtdt["9022"],//송장과 포장된 제품을 준비한 후 확인버튼을 터치해 주세요

			"9023"=>$txtdt["9023"],//송장과 포장된 제품을 준비한 후 확인버튼을 터치해 주세요
			"9024"=>$txtdt["9024"],//송장과 포장된 제품을 준비한 후 확인버튼을 터치해 주세요

			/*각 단계별 작업자 확인사항*/
			"9035"=>$txtdt["9035"],//작업이 정상적으로 완료되었으면 아래 사항을 확인후  확인서명(작업지시서 체크) 하세요
			"9037"=>$txtdt["9037"],//위사항이 이상이 없으면 확인서명하세요.

			"9043"=>$txtdt["9043"],//주문번호와 송장번호가 다릅니다. 다시 확인해 주세요.

			"MEMBER_DIFFERENT"=>$txtdt["memdifferent"],//다른기기에서 로그인되었습니다. 로그인화면으로 이동합니다.

			"SCDATE"=>$txtdt["scdate"],//처방일
			"SCNO"=>$txtdt["scno"],//처방번호
			"SCRIPTION"=>$txtdt["scription"],//처방명
			"TOTMEDICAPA"=>$txtdt["totmedicapa"],//약재총량
			"DANG"=>$txtdt["dang"],//첩당
			"PACKCNT"=>$txtdt["packcnt"],//팩수
			"PACKCAPA"=>$txtdt["packcapa"],//팩용량
			"PACKTYPE"=>$txtdt["packtype"],//팩종류
			"PATIENT"=>$txtdt["patient"],//복용자

			"FILE_UPLOAD_OK"=>$txtdt["fileupload_ok"],//파일업로드 되었습니다.
			"FILE_DB_FAIL"=>$txtdt["9000"],//파일업로드에 성공하였으나 DB 저장에 실패하였습니다.
			"FILE_UPLOAD_FAIL"=>$txtdt["fileupload_fail"],//파일업로드에 실패했습니다.
			"FILE_UPLOAD_ERR01"=>$txtdt["fileupload_err01"],//첨부파일 사이즈는 5MB 이내로 등록 가능합니다.
			"FILE_UPLOAD_ERR02"=>$txtdt["fileupload_err02"],//허용된 파일형식이 아닙니다.
			"FILE_UPLOAD_ERR03"=>$txtdt["fileupload_err03"],//파일 오류입니다.
			"FILE_UPLOAD_ERR04"=>$txtdt["fileupload_err04"]//도메인 관리자에게 문의 바랍니다.
			);


?>
