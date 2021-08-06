<?php
	$root="../..";
	include_once $root."/_common.php";

	function postal_paging(){
		global $currentPage;
		global $totalPage;
		global $countPerPage;
		$page=$currentPage;
		$tpage=$totalPage;
		$block=10;//$countPerPage;
		$str="<div class='zippage'>";
		if($tpage){
			$inloop = (intval(($page-1) / $block)*$block)+1;
			if ($page>$block) {
				$str.="<a href='javascript:gopostalpage(1);'>&lt&lt</a>";
				$prev = $inloop-1;
				if($prev>1){$str.="<a href='javascript:gopostalpage(".$prev.");'>&lt</a>";}
			}
			for ($i=$inloop;$i<$inloop+$block;$i++) {
				if ($i<=$tpage){
					If ($i == $page){$cls = 'on';} else {$cls = '';}
					$str.="<a href='javascript:gopostalpage(".$i.");' class='".$cls."'>".$i."</a>";
				}
			}
			if ($page<$tpage && $tpage>$block ){
				$next = $inloop+$block;
				if($next>$tpage)$next=$tpage;
				$str.="<a href='javascript:gopostalpage(".$next.");'>"."&gt"/*다음*/."</a>";
				$str.="<a href='javascript:gopostalpage(".$tpage.");'>"."&gt&gt"/*끝*/."</a>";
			}
		}
		$str.="</div>";
		return $str;
	}

	function gotoapi_curl($apimethod,$apiurl,$apidata){
		global $apicode;

		$ch = curl_init();
		//basic
		curl_setopt($ch, CURLOPT_URL, $apiurl);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		//curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
		//curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

		//curl_setopt($ch, CURLOPT_SSLVERSION, 3);
		if($apimethod=="POST"){
			curl_setopt($ch, CURLOPT_POST, true);
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
			curl_setopt($ch, CURLOPT_POSTFIELDS, $apidata);
		}
		if($apimethod=="DELETE"){
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
			curl_setopt($ch, CURLOPT_POSTFIELDS, $apidata);
		}
		if($apimethod=="PUT"){
			curl_setopt($ch, CURLOPT_POST, true);
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
			curl_setopt($ch, CURLOPT_POSTFIELDS, $apidata);
		}

		//header
		curl_setopt($ch, CURLOPT_HEADER, false);
		//curl_setopt($ch, CURLOPT_HTTPHEADER, array(
		//	'Content-Type:application/json','Accept:application/json','AUTH-KEY:'.$authkey
		//));

		//curl_setopt($ch, CURLOPT_TIMEOUT, 10);
		$result = curl_exec($ch);							
//var_dump($result);
		curl_close($ch);  // Seems like good practice
		return $result;
	}



	$apiUrl=$_GET["apiUrl"];
	$confmKey=$_GET["confmKey"];
	$currentPage=$_GET["currentPage"];
	$countPerPage=$_GET["countPerPage"];
	$keyword=$_GET["keyword"];
	$apiurl=$apiUrl;
	$apiurl.="?currentPage=".$currentPage;
	$apiurl.="&countPerPage=".$countPerPage;
	//$apiurl.="&keyword=".iconv("utf-8","euc-kr",$_GET["keyword"]);
	$apiurl.="&confmKey=".$confmKey;
	$apiurl.="&keyword=".urlencode($_GET["keyword"]);
	$apidata="";
//echo $apiurl;
	//$apiurl=urlencode($apiurl);

	$myXMLData=gotoapi_curl("GET",$apiurl,$apidata);
	$myXMLData=simplexml_load_string($myXMLData);
//var_dump($myXMLData);
	$totalCount=intval($myXMLData->common->totalCount);
	$currentPage=intval($myXMLData->common->currentPage);
	$countPerPage=$myXMLData->common->countPerPage;
	$errorCode=$myXMLData->common->errorCode;
	$errorMessage=$myXMLData->common->errorMessage;
	$totalPage=intval($totalCount / $countPerPage) + 1;
	echo "<table cellpadding='0' cellspacing='0' border='0' class='ziplist'>";
	echo "<col width='25%'><col width='62%'><col width='13%'>";
	echo "<tr><th>".$txtdt["1502"]/*우편번호/행정구역코드*/."</th>";
	echo "<th>".$txtdt["1503"]/*도로명주소/지번주소/영문주소/건물명*/."</th>";
	echo "<th style='text-align:center;'>".number_format($totalCount)." ".$txtdt["1019"]/*건*/."</th>";
	echo "</tr>";
	$i=0;
	foreach ($myXMLData->juso as $list) {
		echo "<tr class='result_".$i."'><td class='zipno'>".$list->zipNo."<br>".$list->rnMgtSn."</td>";
		echo "<td class='addr'>".$list->roadAddr."<br>".$list->jibunAddr;
		//echo $list->"<br>".engAddr."<br>".$list->detBdNmList."</td>";
		echo "<td class='zinbtn'><span class='btn btn-xs btn-primary' onclick='contactzip(".$i.")'>선택</span></td></tr>";
		$i++;
	}
	echo "</table>";
	echo postal_paging();
?>
