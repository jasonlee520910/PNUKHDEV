<?php
	/// 20200325:랜덤생성함수혼합(OK)
	function randmix($no)
	{
		$chars = "ABCDEFGHJKLMNPQRSTUVWXYZ0123456789";
		srand((double)microtime()*1000000);
		$i = 0;
		$str = '';
		while ($i < $no) {
			$num = rand() % strlen($chars);
			$tmp = substr($chars, $num, 1);
			$str .= $tmp;
			$i++;
		}
		return $str;
	}
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

?>