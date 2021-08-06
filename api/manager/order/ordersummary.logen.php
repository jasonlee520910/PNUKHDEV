<?php
		include_once $root."/tbms/common.php";
		//20191031 : 로젠도착점코드
		//신규 도로명 주소가 로젠 데이터에 없는경우 구주소로 보내야함
		//로젠도착점코드
		if($dt["re_addresschk"]=="Y"){
			$readdresschk=1;
			$rezipchk=1;
			$resendzipchk=1;
			$rezip=$dt["re_zipcode"];
			$resendzip=$dt["re_sendzipcode"];
		}else{
			//re_address 데이터 참조해서 배송지코드 api 호출 curl 로 호출
			//여기서호출함
			//$addArry=explode("||",$dt["re_address"]);
			//$strAddr=$addArry[0];
			$strAddr = str_replace('||',' ',$dt["re_address"]);
			include $root."/tbms/marking/logenrcvdivcd.php";
			//echo $json["DestinationCode"];

			$re_addrdestination=$json["DestinationCode"];//도착점코드(3)
			$re_addrroadname=$json["RoadName"];//도로명
			$re_addrzipcode=$json["ZipCode"];//우편번호 
			$re_addrclassification=$json["ClassificationCode"];//분류코드(6)
			$re_addrjeju=$json["jejuCheck"];//제주지역여부(1)
			$re_addrsea=$json["seaCheck"];//해운지역여부(1)
			$re_addrmountain=$json["mountainCheck"];//산간지역여부(1)


			$logen["re_addrdestination"]=$re_addrdestination;
			$logen["re_addrroadname"]=$re_addrroadname;
			$logen["re_addrzipcode"]=$re_addrzipcode;
			$logen["re_addrclassification"]=$re_addrclassification;
			$logen["re_addrjeju"]=$re_addrjeju;
			$logen["re_addrsea"]=$re_addrsea;
			$logen["re_addrmountain"]=$re_addrmountain;

			if($re_addrdestination!="")
			{
				//도착점코드 업데이트 re_addrdestination
				$sql=" update ".$dbH."_release set re_zipcode= '".$re_addrzipcode."', re_addrdestination = '".$re_addrdestination."', re_addrroadname = '".$re_addrroadname."', re_addrclassification = '".$re_addrclassification."', re_addrjeju = '".$re_addrjeju."', re_addrsea = '".$re_addrsea."', re_addrmountain = '".$re_addrmountain."', re_addresschk='Y' where re_odcode='".$odCode."'";
				dbqry($sql);
				$logen["sql"]=$sql;
				$readdresschk=1;
			}
			else{
				$readdresschk=0;
			}
		
			//우편번호 seq
			if($dt["re_zipseq"])
			{
				$rezipchk=1;
				$rezip=$dt["re_zipcode"];
			}
			else
			{
				//로젠zipseq 
				$rezip=$re_addrzipcode;//받는사람우편번호 
				$sql2=" select zipseq from ".$dbH."_deliarea where zipcode = '".$re_addrzipcode."' limit 1 ";
				$zipdt=dbone($sql2);
				$re_zipseq=$zipdt["zipseq"];

				if($re_addrzipcode!="" && $re_addrzipcode!=null && $re_zipseq!="" && $re_zipseq!=null)
				{
					//받는사람우편번호변경(신-> 구)
					$sql=" update ".$dbH."_release set re_zipcode= '".$re_addrzipcode."' ,re_zipseq= '".$re_zipseq."'  where re_odcode='".$odCode."' ";
					dbqry($sql);
					$rezipchk=1;
				}
				else
				{
					//$sql=" update ".$dbH."_release set re_zipcode= '".$re_addrzipcode."' ,re_zipseq= '".$re_zipseq."'  where re_odcode='".$odCode."' ";
					//dbqry($sql);
					$rezipchk=0;
				}
			}

			//보내는사람우편번호변경확인(신-> 구)
			$sql=" select oldzip from ".$dbH."_zipcode where newzip = '".$dt["re_sendzipcode"]."' or oldzip = '".$dt["re_sendzipcode"]."'";
			$zipdt=dbone($sql);
			if($zipdt["oldzip"]){
				$logen["보내는사람1"]="검색됨";
				$resendzipchk=1;
				$resendzip=$zipdt["oldzip"];

				//로젠zipseq update
				$sql2=" select zipseq from ".$dbH."_deliarea where zipcode = '".$resendzip."' limit 1 ";
				$sendzipdt=dbone($sql2);
				$sendzipseq=$sendzipdt["zipseq"];


				if($resendzip!="" && $resendzip!=null && $sendzipseq!="" && $sendzipseq!=null)
				{				
					//보내는사람우편번호변경(신-> 구)
					$sql=" update ".$dbH."_release set re_sendzipcode= '".$resendzip."', re_sendzipseq= '".$sendzipseq."'  where re_odcode='".$odCode."' ";
					dbqry($sql);
					$resendzipchk=1;
				}
				else
				{
					//$sql=" update ".$dbH."_release set re_zipcode= '".$resendzip."' ,re_zipseq= '".$sendzipseq."'  where re_odcode='".$odCode."' ";
					//dbqry($sql);
					$resendzipchk=0;
					$resendzip=$dt["re_sendzipcode"];
				}
			}
			else
			{

				$strAddr = str_replace('||',' ',$dt["re_sendaddress"]);
				$logen["re_sendstrAddr"]=$strAddr;
				include $root."/tbms/marking/logenrcvdivcd.php";

				$re_sendaddrzipcode=$json["ZipCode"];//우편번호 
				$logen["re_sendaddrzipcode"]=$re_sendaddrzipcode;

				$resendzipchk=1;
				$resendzip=$re_sendaddrzipcode;//우편번호 
				$logen["보내는사람3"]=$resendzip;


				//로젠zipseq update
				$sql3=" select zipseq from ".$dbH."_deliarea where zipcode = '".$resendzip."' limit 1 ";
				$sendzipdt2=dbone($sql3);
				$sendzipseq=$sendzipdt2["zipseq"];

				if($resendzip!="" && $resendzip!=null && $sendzipseq!="" && $sendzipseq!=null)
				{				
					//보내는사람우편번호변경(신-> 구)
					$sql=" update ".$dbH."_release set re_sendzipcode= '".$resendzip."', re_sendzipseq= '".$sendzipseq."'  where re_odcode='".$odCode."' ";
					dbqry($sql);
					$resendzipchk=1;
				}
				else
				{
					//$sql=" update ".$dbH."_release set re_zipcode= '".$resendzip."' ,re_zipseq= '".$sendzipseq."'  where re_odcode='".$odCode."' ";
					//dbqry($sql);
					$resendzipchk=0;
					$resendzip=$dt["re_sendzipcode"];
					$logen["보내는사람2"]="검색안됨";
				}
			}
		}
?>