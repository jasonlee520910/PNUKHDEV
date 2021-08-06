
<?php 
	$accepip=array("59.7.50.122","211.203.113.197","221.161.137.3","223.39.215.136","221.142.23.132","220.84.183.227","223.39.215.197","61.38.209.50");//,"61.38.209.50");
	$ip=$_SERVER["REMOTE_ADDR"];

	if(in_array($ip,$accepip))
	{
		/// 로그인 stafflogin
		$apiCode=$_POST["apiCode"];
		$language=$_POST["language"];
		$st_depart=$_POST["stDepart"];
		$st_userid=addslashes($_POST["stLoginId"]);
		$st_passwd=addslashes($_POST["stPasswd"]);
		$nopasschk=$_POST["nopasschk"];  ///비밀번호 확인우뮤 
		
		if($apiCode!="stafflogin"){$json["resultMessage"]="API(apiCode) ERROR";$apiCode="stafflogin";}
		else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="API(language) ERROR";}
		else
		{
			$severName=$_SERVER['SERVER_NAME'];
			$NetLive=$_POST["NetLive"];
			$returnData=$_POST["returnData"];
			$json=array("apiCode"=>$apiCode,"returnData"=>$returnData);

			if($nopasschk=="0")//아이디만 입력했을 경우 
			{
				$loginStaff="Y";
				$sql=" select st_seq,st_userid,st_name,st_staffid,st_auth,st_depart,st_login,st_use,st_failcnt from ".$dbH."_staff where st_staffid='".$st_userid."' ";
				$dt=dbone($sql);
			}
			else
			{
				$sql=" select st_seq,st_userid,st_name,st_staffid,st_auth,st_depart,st_login,st_use,st_failcnt  from ".$dbH."_staff where st_userid='".$st_userid."' and st_passwd='".mysql_new_password($st_passwd)."' ";
				$dt=dbone($sql);
				$loginStaff="Y";
				if($dt["ST_SEQ"]==""){
					$sql=" select st_seq,st_userid,st_name,st_staffid,st_auth,st_depart,st_login,st_use,st_failcnt from ".$dbH."_staff where st_staffid='".$st_userid."' and st_passwd='".mysql_new_password($st_passwd)."' ";
					$dt=dbone($sql);
					$loginStaff="N";
				}
			}

			if($dt["ST_SEQ"])
			{
				/// authkey 생성하기 
				$authkey = randmix(100);
				$data = $dt["ST_STAFFID"];
				$endata = djEncrypt($data, $authkey);
			
				//green 20.06.23 
				if(!$st_depart){
					$st_depart=$dt["ST_DEPART"];
				}
				/// han_staff 에 update 하기 
				$usql=" update ".$dbH."_staff set st_authkey='".$authkey."', st_depart='".$st_depart."', st_failcnt='0', ST_FAILDATE=null where st_seq='".$dt["ST_SEQ"]."' ";
				dbcommit($usql);
				
				$json = array(
							"apiCode"=>$apiCode, 
							"seq"=>$dt["ST_SEQ"], 
							"stUserid"=>$dt["ST_USERID"], 
							"stName"=>$dt["ST_NAME"], 
							"stStaffid"=>$dt["ST_STAFFID"], 
							"stAuth"=>$dt["ST_AUTH"], 
							"stDepart"=>$st_depart, //green 200623
							"stLogin"=>$dt["ST_LOGIN"], 
							"stUse"=>$dt["ST_USE"],
							"usql"=>$usql,
							"authkey"=>$authkey,
							"stAuthKey"=>$endata,
							"returnData"=>$returnData
					);


				//=================================================================================
				$json["locationURL"] = "/";
				switch($st_depart)
				{
				case "manager":case "admin":case "pharmacist":/// 20191104 : 약사 추가 
					$lastUrl = str_replace("api","manager",$severName);
					if($_SERVER['HTTPS'] != "on")
					{
						
						$json["locationURL"]="https://".$lastUrl;
					}
					else					
					{
						$json["locationURL"]="http://".$lastUrl;
					}

					$json["locationURL"]="https://".$lastUrl;
					break;
				case "making":case "decoction":case "marking":case "release": case "goods": case "pharmacy": case "delivery":case "pill": /// 20191022 goods 추가 20191016 pharmacy 추가 
					$lastUrl = str_replace("api","tbms",$severName);
					if($_SERVER['HTTPS'] != "on")
					{
						
						$json["locationURL"]="https://".$lastUrl."?depart=".$st_depart;
					}
					else					
					{
						$json["locationURL"]="http://".$lastUrl."?depart=".$st_depart;
					}
					break;
				case "sales":
					if($dt["ST_AUTH"]=="sales")
					{
						$json["locationURL"]='/_adm/82_Estimate/Estimate.php';
					}
					else
					{
						$json["locationURL"]='/_adm/83_SetSale/SetPrice.php';
					}
					break;
				case "marketing":
					if($dt["ST_AUTH"]=="tutadmin")
					{
						$json["locationURL"]='/_adm/61_Marketing/Tutorials.php';
					}
					else
					{
						$json["locationURL"]='/tutorial/';
					}
					break;
				}
				
				//=================================================================================

				$json["resultCode"]="200";
				$json["resultMessage"]="OK";
			}
			else
			{
				if($loginStaff=="Y")
				{
					$sql=" select st_failcnt, to_char(ST_FAILDATE, 'yyyy-mm-dd hh24:mi:ss') as STFAILDATE  from ".$dbH."_staff where st_staffid='".$st_userid."' ";
				}
				else
				{
					$sql=" select st_failcnt, to_char(ST_FAILDATE, 'yyyy-mm-dd hh24:mi:ss') as STFAILDATE from ".$dbH."_staff where st_userid='".$st_userid."' ";
				}
				$dt=dbone($sql);
				$st_failcnt=$dt["ST_FAILCNT"];
				$st_failcnt=intval($st_failcnt)+1;
				$faildchk=false;
				if(intval($st_failcnt)>=5)//5회 실패시 
				{
					$json["resultCode"]="899";
					$json["resultMessage"]="LOGINFAILD";/// 로그인 5회 실패 
					if(intval($st_failcnt)==5)
					{
						$faildchk=true;
					}
				}
				else
				{
					$faildchk=true;
					$json["resultCode"]="899";
					$json["resultMessage"]="CHECKIDPWD";/// 아이디와 비밀번호를 다시 확인해주세요.
				}

				if($faildchk==true)
				{
					if($loginStaff=="Y")
					{
						$usql=" update ".$dbH."_staff set ST_FAILCNT='".$st_failcnt."' ,st_depart='".$st_depart."' ";
						$usql.=" , ST_FAILDATE=sysdate ";
						$usql=" where st_staffid='".$st_userid."' ";
						dbcommit($usql);
					}
					else
					{
						$usql=" update ".$dbH."_staff set ST_FAILCNT='".$st_failcnt."' ,st_depart='".$st_depart."' ";
						$usql.=", ST_FAILDATE=sysdate ";
						$usql.=" where st_userid='".$st_userid."' ";
						dbcommit($usql);
					}
				}

			}

			$json["st_failcnt"]=$st_failcnt;
			

		}
	}
	else
	{
		$json["apiCode"]=$apiCode;
		$json["resultCode"]="401";
		$json["resultMessage"]="Unauthorized";//권한없음.
	}

	function mysql_new_password($pw) {
		return $pw;
			//return strlen($pw)>0?strtoupper('*'.sha1(sha1($pw,true))):($pw=== null?null:'');
	}
?>
