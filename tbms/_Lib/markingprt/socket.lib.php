<?php
$labelAuthkey="S5EK3SSNAR1J7908N5HV3C9QY77ND8YV4AD5SVSSAH9FHZE32MWVPWJK1PY4MUYPU1TBL91UQ0Z5Y36YNTS1M8KCM766ZUURKBS3";
/// 20200325:암호화(OK)
function djEncrypt($data, $authkey)
{
	$crypt_iv = "abcdefghij123456";//"#@$%^&*()_+=-";
	$endata = openssl_encrypt($data, 'aes-256-cbc', $authkey, true, $crypt_iv);
	$endata = base64_encode($endata);
	return $endata;
}
/// 20200325:복호화(OK)
function djDecrypt($endata, $authkey)
{
	$crypt_iv = "abcdefghij123456";//"#@$%^&*()_+=-";
	$data = base64_decode($endata);
	$endata = openssl_decrypt($data, "aes-256-cbc", $authkey, true, $crypt_iv);
	return $endata;
}
function strToHex($string){
    $hex = '';
    for ($i=0; $i<strlen($string); $i++){
        $ord = ord($string[$i]);
        $hexCode = dechex($ord);
        $hex .= substr('0'.$hexCode, -2);
    }
    return strToUpper($hex);
}
function Hex2String($hex){
    $string='';
    for ($i=0; $i < strlen($hex)-1; $i+=2){
        $string .= chr(hexdec($hex[$i].$hex[$i+1]));
    }
    return $string;
}
function gethex($txt){
	$str="";
	$len=strlen($txt);
	for($i=0;$i<$len;$i++){
		$m=$i*2;
		$str.=chr("0x".substr($txt,$m,2));
	}
	return $str;
}
//20190620 :: 원래소스에서 지금처럼 수정 (UTF-16로 컨버팅후 hex로 바구기 )
function str2Unicode($txt)
{
	$ucode = mb_convert_encoding($txt, "UTF-16");
	$ucode = strtoupper(bin2hex($ucode)); //유니코드
	return $ucode;
}
/*
//20190620 :: 원래소스 __ 위와 같이 바꿈 
function str2Unicode($txt)
{
	$ucode = iconv("UTF-8", "UTF-16", $txt);
	$ucode = substr($ucode, 2, 2);
	$ucode = strtoupper(bin2hex($ucode)); //유니코드
	return $ucode;
}
*/
//20190620 :: 원래소스에서 지금처럼 수정 (UTF-16로 컨버팅 후 hex로 바꾸고 2개씩 잘라서 앞뒤로 붙이자)
function setUnicode($name)
{	
	$str="";
	for($i=0;$i<mb_strlen($name);$i++)
	{
		$name1=mb_substr($name,$i,1);

		$name2=str2Unicode($name1);

		$name3=substr($name2,0,2);
		$name4=substr($name2,2,2);

		$name3=strToHex($name3);
		$name4=strToHex($name4);
	
		
		$str.="1B68".$name3."1B69".$name4;
	}

	return $str;
}
/*
20190620 :: 원래소스 __ 위와 같이 바꿈 
function setUnicode($name)
{	
	$str="";
	for($i=0;$i<strlen($name);$i++)
	{
		//"name 李
		$name1=substr($name,$i,1);
		//echo $name1;
		if (preg_match_all('!['.'\x{0030}-\x{0039}'.']+!u', $name1, $match))//숫자일경우 
		{
			$str.=strToHex($name1);
		}
		else if (preg_match_all('!['.'\x{0061}-\x{007a}|\x{0041}-\x{005a}'.']+!u', $name1, $match))//영문대소문자일경우
		{
			$str.=strToHex($name1);
		}
		else//숫자,영문이 아닐 경우  (숫자영문일때 아래와같이 처리하면 반이 짤림)
		{
			$name2=str2Unicode($name1);
			//"name D8
			$name3=substr($name2,0,2);
			//"name B2
			$name4=substr($name2,2,2);
			//"name E
			$name3=strToHex($name3);
			//"name F
			$name4=strToHex($name4);
			//echo $name1.":1B68".$name3."1B69".$name4."<br>";
			$str.="1B68".$name4."1B69".$name3;

		}
		//echo "<br>";
	}
	return $str;
}
*/
//주문번호 ODD 제거 
function getodCode($code)
{
	return str_replace("ODD","",$code);
}
//주문번호가 16자리가 아니면.. 에러를 내뿜자! 
function chkodCodelen($odcode)
{
	return (strlen($odcode) == 16) ? true : false;
}
//20190620 :: 원래소스에서 지금처럼 수정
function chkText($name)
{
	//총 8자리에 맞춰야 함.
	$max=8;
	$len=mb_strlen($name);
	if($len > $max)
	{
		$name=mb_strlen($name, 0, $max);
	}
	else if($len < $max)
	{
		$cnt=$max-$len;
		for($i=0;$i<$cnt;$i++)
		{
			$name.=' ';
		}
	}
	return $name;
}
/*
//20190620 :: 원래소스 __ 위와 같이 바꿈 
function chkText($name)
{
	//총 8자리에 맞춰야 함.
	$max=8;
	$len=strlen($name);
	if($len > $max)
	{
		$name=substr($name, 0, $max);
	}
	else if($len < $max)
	{
		$cnt=$max-$len;
		for($i=0;$i<$cnt;$i++)
		{
			$name.=' ';
		}
	}
	return $name;
}
*/
//==========================================================================
// 에러관련 데이터 
//==========================================================================
function errcase($ecode)
{
switch($ecode){
		case "1000": $str="SERIAL ERROR INVALID COMMAND"; break;
		case "1001": $str="SERIAL ERROR INVALID DATA"; break;
		case "1002": $str="SERIAL ERROR INVALID MESSAGE NAME"; break;
		case "1003": $str="SERIAL ERROR INVALID MESSAGE IS NOT"; break;
		case "1004": $str="SERIAL ERROR MESSAGE VARIABLE DATA"; break;
		case "1005": $str="SERIAL ERROR MESSAGE PRINT PARAMETER"; break;
		case "1006": $str="SERIAL ERROR MESSAGE PRINT DATA"; break;
		case "1007": $str="SERIAL ERROR MESSAGE SAVE"; break;
		case "1008": $str="SERIAL ERROR FIELD IS NOT"; break;

		case "5000": $str="SERIAL ERROR FILE INVALID COMMAND"; break;
		case "5001": $str="SERIAL ERROR FILE TYPE"; break;
		case "5002": $str="SERIAL ERROR FILE LENGTH"; break;
		case "5003": $str="SERIAL ERROR FILE X SIZE"; break;
		case "5004": $str="SERIAL ERROR FILE Y SIZE"; break;

		case "5205": $str="SERIAL ERROR FILE NAME"; break;
		case "5210": $str="SERIAL ERROR FILE INVALID FILE TYPE"; break;
		default: $str="OK";
		echo $str;
	}
	/*
	switch($ecode){
		case "000": $str="Software error (this error code should never occur)"; break;
		case "001": $str="Specified character set not present"; break;
		case "002": $str="Invalid command headercase  <ESC> expected"; break;
		case "003": $str="Unrecognised command code following <ESC>"; break;
		case "004": $str="Unexpected characters occurred before <EOT>"; break;
		case "005": $str="Invalid head selector"; break;
		case "006": $str="Out of range print acknowledgement character"; break;
		case "007": $str="Command parameter out of permitted range"; break;
		case "008": $str="Print label number out of range"; break;
		case "009": $str="Syntax error"; break;
		case "010": $str="Print label too long for label store"; break;
		case "011": $str="Print label too long for print buffer"; break;
		case "012": $str="Invalid embedded format command"; break;
		case "013": $str="Invalid character in print label"; break;
		case "014": $str="Invalid number of lines in print label"; break;
		case "015": $str="Invalid character size specified in print label"; break;
		case "016": $str="Cannot load label"; break;
		case "017": $str="Specified print label number is invalid"; break;
		case "018": $str="Label assigned to another product detector"; break;
		case "019": $str="Cannot assign logo to single line head"; break;
		case "020": $str="Command not implemented"; break;
		case "021": $str="Logo ID invalid for specified character set"; break;
		case "022": $str="Invalid character set specified"; break;
		case "023": $str="Invalid checksum field"; break;
		case "024": $str="Checksum error"; break;
		case "025": $str="No character set RAM available"; break;
		case "026": $str="Character set download error"; break;
		case "027": $str="Command rejected printing disabled"; break;
		case "028": $str="Clock ID out of range"; break;
		case "029": $str="Invalid clock field selector"; break;
		case "030": $str="Duplicate clock field specified"; break;
		case "031": $str="Time-conditional string has duplicate time field"; break;
		case "032": $str="Serial number out of range"; break;
		case "033": $str="Serial number increment value too big"; break;
		case "034": $str="Identifier out of range"; break;
		case "035": $str="Numeric field too long"; break;
		case "036": $str="Non-numeric character encountered"; break;
		case "037": $str="Both numeric and pre/suffix lengths are zero"; break;
		case "038": $str="Non-alpha character encountered"; break;
		case "039": $str="Invalid step order selected"; break;
		case "040": $str="Invalid product detector identity specified"; break;
		case "041": $str="Too many time-conditional strings specified"; break;
		case "042": $str="Time-conditional string identifier out of range"; break;
		case "043": $str="Time-conditional string time limit out of range"; break;
		case "044": $str="Time-conditional string too long"; break;
		case "045": $str="Invalid barcode type specified"; break;
		case "046": $str="Command invalid in barcode string"; break;
		case "047": $str="Maximum character size must be selected first"; break;
		case "048": $str="Invalid character for barcode type"; break;
		case "049": $str="Invalid character count for barcode"; break;
		case "050": $str="The printer is busy with Auto repeat de-assert photocell"; break;
		case "051": $str="An internal printer error caused the command not to be processed"; break;
		case "052": $str="The requested file could not be found"; break;
		case "301": $str="There are too many MRC"; break;
		case "401": $str="Wrong language ID out of range"; break;
		case "402": $str="Ignore send acknowledge"; break;
		case "403": $str="MRC exceed maximal width"; break;
		case "404": $str="Invalid 2D code type"; break;
		case "405": $str="Invalid 2D code format"; break;
		case "406": $str="Invalid 2D code ECC"; break;
		case "407": $str="Invalid 2D code rows number"; break;
		case "408": $str="Invalid 2D code columns number"; break;
		case "409": $str="Invalid 2D code magnification factor"; break;
		case "410": $str="Invalid 2D code alignment"; break;
		default: $str="OK";
	echo $str;
	}
	*/
	return $str;
}
//==========================================================================
//소켓 하나만 생성해서 데이터만 주고 받자 
//==========================================================================
//소켓 생성 및 접속 
function prt_connect()
{	
	//$address="59.7.50.122";//$_GET["ip"];//ip
	//$service_port="7010";//$_GET["port"];//port
	//$address="115.95.52.52";//$_GET["ip"];//ip
	//$service_port="8002";//$_GET["port"];//port
	$address=$_GET["ip"];//ip
	$service_port=$_GET["port"];//port

	//$address="106.245.241.106";//$_GET["ip"];//ip
	//$service_port="8002";//$_GET["port"];//port

	//$address="115.95.52.52";//$_GET["ip"];//ip
	//$service_port="8002";//$_GET["port"];//port
	echo "address :: ".$address.", service_port = ".$service_port."<br>";

	prt_close($socket);
	$socket = null;
	
	/* Create a TCP/IP socket. */
	$socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
	if ($socket === false) 
	{
		echo "ERROR : ".socket_strerror(socket_last_error())."<br>";
		return null;
	} 
	else
	{
		@socket_set_option($socket, SOL_SOCKET, SO_RCVTIMEO, array('sec' => 2, 'usec' => 0));
		@socket_set_option($socket, SOL_SOCKET, SO_SNDTIMEO, array('sec' => 2, 'usec' => 0));

		$connect = socket_connect($socket, $address, $service_port);

		if ($connect === false) 
		{
			echo "socket_connect() 실패.\nReason: ($connect) " . socket_strerror(socket_last_error($socket)) . "\n";

			return null;
		}
	}

	return $socket;
}
function prt_close($socket)
{
	socket_shutdown($socket, 2);
	socket_close($socket);
}
//데이터 주고 받기 
function prt_sendrecv($socket, $txt)
{
	$result=array('state'=>false, 'msg'=>'', 'code'=>'');

	//$in=gethex($txt);
	$in=Hex2String($txt);

	if(($res_write = socket_write($socket, $in, strlen($in))) === false) 
	{
		$result["state"]=false;
		$result["msg"]=socket_strerror(socket_last_error($socket));
		$result["code"]=$res_write;
	}
	else
	{
		if($txt == '026C04') //카운터 가져오기 (예외처리함-hex로 바꿀 필요없음 )
		{
			$res_read = socket_read($socket, 1024);
			$result["state"]=true;
			$first=substr($res_read,2, -2);//0D 제외 
			$result["msg"]=$first;
			$result["code"]="";
		}
		else
		{
			$res_read = "";
			while (socket_recv($socket, $out, 1024, 0) != 0)
			{
				$res_read.=$out;
			}

			$str = strToHex($res_read);
			$state = substr($str, 2, 2);
			$hex_code = substr($str, 4, -2);

			echo "prt_sendrecv  str : ".$str."<br>";
			echo "prt_sendrecv  state : ".$state."<br>";
			echo "prt_sendrecv  hex_code : ".$hex_code."<br>";

			if($state == '06')//성공
			{
				$result["state"]=true;
				$result["msg"]="";
				$result["code"]="";
			}
			else //15 : 에러 
			{
				$result["state"]=false;
				$code=Hex2String($hex_code);
				echo "prt_sendrecv  code : ".$code."<br>";
				$result["msg"]=errcase($code);
				$result["code"]=$code;
			}
		}
	}
	return $result;
}

?>