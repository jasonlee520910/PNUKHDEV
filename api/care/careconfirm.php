<?php
	//GET
	$apicode=$_GET["apiCode"];
	$language=$_GET["language"];
	$uc_seq=$_GET["seq"];
	$today=$_GET["today"];
	$hour=$_GET["hour"];
	$code=$_GET["code"];
	if($apicode!="careconfirm"){$json["resultMessage"]="API코드오류";$apicode="careconfirm";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="언어코드오류";}
	else if($uc_seq==""){$json["resultMessage"]="seq 없음";}
	else if($today==""){$json["resultMessage"]="today 없음";}
	else if($hour==""){$json["resultMessage"]="hour 없음";}
	else if($code==""){$json["resultMessage"]="code 없음";}
	else{
		$jsql=" a  ";
		$wsql=" where a.uc_use <>'D' and a.uc_seq = '".$uc_seq."' ";
		$sql=" select a.uc_schedule from ".$dbH."_usercare $jsql $wsql ";
		$dt=dbone($sql);
		$ucSchedule="";
		$uarr=explode("|",$dt["uc_schedule"]);
		foreach($uarr as $val){
			$varr=explode(",",$val);
			if($varr[0]==$today){
				$varstr="";
				for($i=0;$i<count($varr);$i++){
					if($varstr)$varstr.=",";
					if($i==3){//시간순서체크
						$varr2=explode("/",$varr[3]);
						$chkcnt=$varstr2="";
						for($k=0;$k<count($varr2);$k++){
							if($varr2[$k]==$hour){
								//해당시간순서
								$chkcnt=$k;
							}
							if($varstr2)$varstr2.="/";
							$varstr2.=$varr2[$k];
						}
						$varstr.=$varstr2;
					}else if($i==4){//시간순서상태변경
						for($k=0;$k<strlen($varr[4]);$k++){
							if($k==$chkcnt){
								switch($code){
									case "pass": $stat="P"; break;
									case "eat": $stat="E"; break;
									case "alram": $stat="A"; break;
									default: $stat="N";
								}
								$varstr.=$stat;
							}else{
								$varstr.=$varr[4][$k];
							}
						}
					}else if($i==5){//시간등록
						$varr2=explode("/",$varr[5]);
						$chkcnt=$varstr2="";
						for($k=0;$k<count($varr2);$k++){
							if($varstr2)$varstr2.="/";
							if($k==$chkcnt){
								//해당시간순서
								$varstr2.=date("H:i");
							}else{
								$varstr2.=$varr2[$k];
							}
						}
						$varstr.=$varstr2;
					}else{
						$varstr.=$varr[$i];
					}
				}
				$ucSchedule.="|".$varstr;
			}else{
				if($val)$ucSchedule.="|".$val;
			}
		}
		$sql=" update ".$dbH."_usercare set uc_schedule = '".$ucSchedule."' where uc_seq = '".$uc_seq."'";
		dbqry($sql);
		$json["sql"]=$sql;
		$json["apiCode"]=$apicode;
		$json["returnData"]=$returnData;
		$json["resultCode"]="200";
		$json["resultMessage"]="OK";
	}
?>
