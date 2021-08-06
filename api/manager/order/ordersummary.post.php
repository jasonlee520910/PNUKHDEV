<?php
		$rezip=trim($dt["RE_ZIPCODE"]);
		$resendzip=trim($dt["RE_SENDZIPCODE"]);
		$readd= explode("||",$dt["RE_ADDRESS"]);
		$resendadd= explode("||",$dt["RE_SENDADDRESS"]);


		if($dt["RE_ADDRESSCHK"]=="Y")
		{
			$readdresschk=1;
			$rezipchk=1;
			$resendzipchk=1;

			$rezip=$dt["RE_ZIPCODE"];
			$resendzip=$dt["RE_SENDZIPCODE"];
		}
		else
		{
			$dootest["doorezip"]=$rezip;
			$dootest["dooreziplen"]=strlen($rezip);
			//받는사람 구를 신규로 바꾸자 
			if(strlen($rezip)==5)
			{
				$sql=" update ".$dbH."_release set re_addresschk='Y' where re_odcode='".$odCode."' ";
				dbcommit($sql);
				$readdresschk=1;
				$rezipchk=1;
				$rezip=$rezip;
			}
			else
			{
				$rsql=" select newzip from ".$dbH."_zipcode where newzip = '".$rezip."' or oldzip = '".$rezip."'";
				$zipdt=dbone($rsql);
				if($zipdt["NEWZIP"])
				{
					$rezipchk=1;
					$rezip=$zipdt["NEWZIP"];

					if($rezip!="" && $rezip!=null)
					{
						//받는사람우편번호변경(신-> 구)
						if($readd[0]&&$readd[1])
						{
							$sql=" update ".$dbH."_release set re_zipcode= '".$rezip."', re_addresschk='Y' where re_odcode='".$odCode."' ";
							dbcommit($sql);
							$rezipchk=1;
						}
						else
						{
							$sql=" update ".$dbH."_release set re_zipcode= '".$rezip."', re_addresschk='N' where re_odcode='".$odCode."' ";
							dbcommit($sql);
							$rezipchk=1;
						}
					}
					else
					{
						$rezipchk=0;
						$rezip=$dt["RE_ZIPCODE"];
					}
				}else{
					$rezipchk=0;
					$rezip=$dt["RE_ZIPCODE"];
				}

				if($readd[0]&&$readd[1])
				{
					$readdresschk=1;
				}
				else
				{
					$readdresschk=0;
				}
			}

			//보내는사람 사람 구를 신규로 바꾸자 
			$dootest["dooresendzip"]=$resendzip;
			$dootest["dooresendziplen"]=strlen($resendzip);
			if(strlen($resendzip)==5)
			{
				$resendzipchk=1;
			}
			else
			{
				$ssql=" select newzip from ".$dbH."_zipcode where newzip = '".$resendzip."' or oldzip = '".$resendzip."'";
				$zipsenddt=dbone($ssql);
				if($zipsenddt["NEWZIP"])
				{
					$resendzipchk=1;
					$resendzip=$zipsenddt["NEWZIP"];

					if($resendzip!="" && $resendzip!=null)
					{
						//보내는사람우편번호변경(신-> 구)
						$sql=" update ".$dbH."_release set re_sendzipcode= '".$resendzip."' where re_odcode='".$odCode."' ";
						dbcommit($sql);
						$resendzipchk=1;
					}
					else
					{
						$resendzipchk=0;
						$resendzip=$dt["RE_SENDZIPCODE"];
					}
				}else{
					$resendzipchk=0;
					$resendzip=$dt["RE_SENDZIPCODE"];
				}
			}

		}

?>