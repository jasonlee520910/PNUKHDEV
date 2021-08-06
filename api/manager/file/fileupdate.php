<?php
	//파일 업데이트 
	$apicode=$_POST["apiCode"];
	$language=$_POST["language"];
	if($apicode!="fileupdate"){$json["resultMessage"]="API(apicode) ERROR";$apicode="fileupdate";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="API(language) ERROR";}
	else{
		//int형은 ''이 아닌 '0'으로 채우자 
		$seq=$_POST["seq"];
		$af_afseq=$_POST["afSeq"];
		if(!$af_afseq)$af_afseq='0';
		if($af_afseq=="add")$af_afseq='0';
		$af_no="0";
		$af_userid=$_POST["afUserid"];
		$af_code=$_POST["afCode"];
		$af_fcode=$_POST["afFcode"];
		$dtdom=$_POST["dtdom"];//데이터 저장한 server name 
		$af_url=$_POST["afUrl"];
		$af_thumbUrl=$_POST["afthumbUrl"];		
		$af_name=$_POST["afName"];
		$af_size=$_POST["afSize"];
		if($af_size=='')$af_size='0';
		$af_auth=$_POST["afAuth"];
		$returndata=$_POST["returnData"];

		if($seq)
		{
			$sql=" update ".$dbH."_file set af_afseq='".$af_afseq."', af_no='".$af_no."', af_userid='".$af_userid."', af_code='".$af_code."', af_fcode='".$af_fcode."', af_url='".$af_url."', af_name='".$af_name."', af_size='".$af_size."', af_auth='".$af_auth."', af_date=sysdate where af_seq='".$seq."'";
			dbcommit($sql);
		}
		else
		{
			//20191101 : release_medibox 일때만 재촬영은  기존을 D로 바꾸고 새로 등록하자 
			if($af_fcode=="release_medibox" || $af_fcode=="goods_component")
			{
				$rmsql="select af_seq from ".$dbH."_file where af_code='".$af_code."' and af_fcode='".$af_fcode."' and af_use='Y'";
				$rmdt=dbone($rmsql);
				$af_seq=$rmdt["AF_SEQ"];
				if($af_seq)
				{
					$rmusql="update ".$dbH."_file set af_use='D' where af_seq='".$af_seq."' and af_use='Y' ";
					dbcommit($rmusql);
				}
			}

			//신규등록할 파일 no
			$nosql=" select MAX(af_no) as AFNO from ".$dbH."_file where af_code='".$af_code."' and af_fcode='".$af_fcode."' order by af_no desc  ";
			$dt=dbone($nosql);

			if($dt["AFNO"])
			{
				$af_no=$dt["AFNO"] + 1;
			}
			else
			{
				$af_no=1;
			}

			if($af_code=="tutorial")
			{
				$sql=" update ".$dbH."_file set af_use='D' where af_code='tutorial' and af_afseq='".$af_afseq."' ";
				dbcommit($sql);
			}

			$sql= " insert into ".$dbH."_file (";
			$sql.= " af_seq, af_afseq, af_no, af_userid, af_code, af_fcode, af_url, af_name, af_size, af_auth, af_use, af_date ";
			$sql.= " ) values ( ";
			$sql.= " (SELECT NVL(MAX(af_seq),0)+1 FROM ".$dbH."_file), '".$af_afseq."','".$af_no."','".$af_userid."','".$af_code."','".$af_fcode."','".$af_url."','".$af_name."','".$af_size."','".$af_auth."','Y', sysdate ";
			$sql.= " ) ";
			dbcommit($sql);

			//신규등록된 파일 select 해서 데이터 넘기자 
			$newsql=" select AF_SEQ,AF_AFSEQ,AF_NO,AF_USERID,AF_CODE,AF_FCODE,AF_URL,AF_NAME,AF_SIZE,AF_USE,AF_AUTH,to_char(AF_DATE, 'yyyy-mm-dd hh24:mi:ss') as AFDATE from ".$dbH."_file where af_code = '".$af_code."' and af_url='".$af_url."' and af_name='".$af_name."' and af_use = 'Y' order by af_seq desc";	
			$dt=dbone($newsql);
			
			

			$seq=$dt["AF_SEQ"];
			$json["files"] = array();
			//여러개
			$addarray=array(
				"afseq"=>$dt["AF_SEQ"],
				"afAfseq"=>$dt["AF_AFSEQ"],
				"afNo"=>$dt["AF_NO"],
				"afUserid"=>$dt["AF_USERID"],
				"afCode"=>$dt["AF_CODE"],
				"afFcode"=>$dt["AF_FCODE"],
				"afThumbUrl"=>$dtdom.$af_thumbUrl,
				"afUrl"=>$dtdom.$dt["AF_URL"],
				"afName"=>$dt["AF_NAME"],
				"afSize"=>$dt["AF_SIZE"],
				"afUse"=>$dt["AF_USE"],
				"afAuth"=>$dt["AF_AUTH"],
				"afDate"=>$dt["AFDATE"]
			);
			array_push($json["files"], $addarray);
		}

		$json["sql"]=$sql;
		$json["seq"]=$seq;
		$json["no"]=$af_no;
		$json["apiCode"]=$apicode;
		$json["resultCode"]="200";
		$json["resultMessage"]="OK";
	}
?>
