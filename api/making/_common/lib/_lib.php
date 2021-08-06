<?php	
	//clob data 가져오기 
	function getClob($clobdata)
	{
		if(is_object($clobdata))// protect against a NULL LOB
		{ 
			$data = $clobdata->load();
			$clobdata->free();
			return $data;
		}
		return "";
	}
	function insertClob($jsonstatus)
	{
		$CLOB_DAN=1000;
		$mt_logstaustext="";
		$tlen=mb_strlen($jsonstatus, "UTF-8");
		if($tlen>0)
		{
			$cnt=ceil($tlen/$CLOB_DAN);
			$num=0;
			$max=0;
			for($i=0;$i<$cnt;$i++)
			{
				//$max=($i+1)*$CLOB_DAN;
				$max=$CLOB_DAN;
				if($i>0)
				{
					$num=($i*$CLOB_DAN);
					$mt_logstaustext.=" || ";
					if($i==($cnt-1))
					{
						$max=$tlen;
					}
				}
				$mt_logstaustext.="TO_CLOB('".mb_substr($jsonstatus, $num, $max, 'utf-8')."')";
			}
		}
		else
		{
			$mt_logstaustext="TO_CLOB('')";
		}
		return $mt_logstaustext;
	}
?>