<?php
	/// 상비,실속,이전처방,고유처방 클릭시 
	$apiCode=$_GET["apiCode"];
	$language=$_GET["language"];
	$type=$_GET["type"];
	$rc_seq=$_GET["seq"];

	if($apiCode!="medicinerecipe"){$json["resultMessage"]="API(apiCode) ERROR";$apiCode="medicinerecipe";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="API(language) ERROR";}
	else if($type==""){$json["resultMessage"]="API(type) ERROR";}
	else if($rc_seq==""){$json["resultMessage"]="API(seq) ERROR";}
	else
	{
		switch($type)
		{
			case "Unique":
			case "smu":
				$tbl="member";
				break;
			case "General":
				$tbl="user";
				break;
			case "worthy":  //실속처방
			case "commercial":  //상용처방
			case "goods":  //약속처방
			case "pill": //제환		
				$tbl="medical";
				break;
		}
		$ssql="";
		switch($type)
		{
		case "worthy":  //실속속처방
		case "commercial":  //상용처방
		case "goods":  //약속처방
			$ssql=" , a.rc_chub, a.rc_packcnt, a.rc_packtype, a.rc_packcapa, a.rc_medibox  ";
			break;
		case "pill":  //제환 
			$ssql=" , b.GD_PILLORDER ";
			break;
		}

		if($rc_seq)
		{
			$sql=" select a.rc_seq rcSeq ";
			$sql.=" ,a.rc_medicine as RCMEDICINE ";
			$sql.=" ,a.rc_sweet as RCSWEET ".$ssql." from ".$dbH."_recipe".$tbl;
			if($type==="pill")
			{
				$sql.=" a left join ".$dbH."_goods b on a.rc_code=b.GD_RECIPE ";
			}
			else
			{
				$sql.=" a left join ".$dbH."_recipebook b on a.rc_source=b.rb_code ";
			}
			$sql.=" where a.rc_seq='".$rc_seq."'";
			//echo $sql;
			$dt=dbone($sql);
		}

		switch($type){
			case "worthy":  //실속속처방
			case "commercial":  //상용처방
			case "goods":  //약속처방
				$hPackCodeList = getPackCodeTitle('', "odPacktype,reBoxmedi");
				$reBoxmediList = getCodeList($hPackCodeList, 'reBoxmedi');//한약박스
				$odPacktypeList = getCodeList($hPackCodeList, 'odPacktype');//파우치

				$json=array("seq"=>$dt["RCSEQ"], 
					"rcMedicine"=>getClob($dt["RCMEDICINE"]), 
					"rcSweet"=>getClob($dt["RCSWEET"]), 
					"rcChub"=>$dt["RC_CHUB"], 
					"rcPackcnt"=>$dt["RC_PACKCNT"], 
					"rcPacktype"=>$dt["RC_PACKTYPE"], 
					"rcPackcapa"=>$dt["RC_PACKCAPA"], 
					"rcMedibox"=>$dt["RC_MEDIBOX"],

					"reBoxmediList"=>$reBoxmediList,//한약박스
					"odPacktypeList"=>$odPacktypeList//파우치
					
				);
			break;
			case "pill":
				$gdPillorder=json_decode(getClob($dt["GD_PILLORDER"]), true);
				$pilllist=$gdPillorder["pillorder"];

			
				$carr=array("making","smash","decoction","concent","mixed","ferment","plasty","dry","packing","juice","warmup");
				$cdarr=array("making","dcFineness","dcSpecial","concent","dcBinders","dcRipen","dcShape","dry","packing","juice","dcJungtang");
				$tarr=array("조제","분쇄","탕전","농축","혼합","숙성","성형","건조","포장","착즙","중탕");
				$pillorder="";
				for($i=0;$i<count($carr);$i++)
				{
					for($j=0;$j<count($pilllist);$j++)
					{
						$ptype=$pilllist[$i]["type"];
						if($carr[$i]==$ptype)
						{
							$pillorder.="<dl id='".$carr[$i]."'>";
							$pillorder.="<dt>".$tarr[$i]."</dt>";
							$pillorder.="</dl>";
							break;
						}
					}
				}

				$json=array("seq"=>$dt["RCSEQ"], "pilllist"=>$pilllist,"pillorder"=>$pillorder, "total"=>$total,"rcMedicine"=>getClob($dt["RCMEDICINE"]), "rcSweet"=>getClob($dt["RCSWEET"]));
				break;
			default:
				$json=array("seq"=>$dt["RCSEQ"], "rcMedicine"=>getClob($dt["RCMEDICINE"]), "rcSweet"=>getClob($dt["RCSWEET"]));
				break;
		}
		$json["apiCode"]=$apiCode;
		$json["resultCode"]="200";
		$json["resultMessage"]="OK";
		$json["type"]=$type;
		$json["sql"]=$sql;
	}
?>
