<?php 
	$root = "../..";
	include_once ($root.'/_common.php');
	function curl_post($url,$data)
	{
		global $lastHttps;
		global $severName;
		//$uploadFile = array("uploadFile"=>"@".$_FILES["tmp_name"]);
		//$data=array("uploadFile"=>realpath($_FILES["upload"]["tmp_name"]).";".$_FILES["upload"]["type"],$_FILES["upload"]["name"]);
		//$data=array("uploadFile"=>$uploadFile,"filecode"=>"policy|img|1","fileck"=>"admin|kor","fileapiurl"=>"url");

		//origin
		$fullseverName=$lastHttps.$severName;

		$filetmpname = $_FILES["upload"]['tmp_name']; 
		$filetype = $_FILES["upload"]['type']; 
		$filename = $_FILES["upload"]['name']; 
		$filesize=$_FILES["upload"]['size'];
		$file_name_with_full_path = realpath($filetmpname);
		//$handle = fopen($filetmpname, "r"); 
		//$data = base64_encode(fread($handle, $filesize)); 
		//$data='@'.$file_name_with_full_path.';type='.$filetype;

		if (function_exists('curl_file_create')) { // php 5.5+
		  $cFile = curl_file_create($file_name_with_full_path, $filetype, $filename);
		} else { // 
		  $cFile = '@' . realpath($file_name_with_full_path).";type=".$filetype;
		}

		// $data is file data 
		$post   = array('orgin'=>$fullseverName,'filecode'=>'policy|img|1','fileck'=>$_COOKIE["ck_stStaffid"].'|kor', 'uploadFile' => $cFile); 
		//var_dump($post);

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL,$url);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('ck_authkey:'.urlencode($_COOKIE["ck_authkey"]), 'ck_stStaffid:'.$_COOKIE["ck_stStaffid"]));
		$result = curl_exec($ch);
		curl_close ($ch);
		return $result;
	}
	$result=curl_post($NET_CURL_UPLOAD,"");

	//echo $result;
	//$jsondata= json_decode($result);
	//var_dump($result);
	$resultjson=json_decode($result, true);

	//var_dump($resultjson);

	echo '{"filename" : "'.$resultjson["filename"].'", "uploaded" : 1, "url":"'.$resultjson["fileurl"].'"}';

?>
