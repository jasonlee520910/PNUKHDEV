<?php if($_SERVER["REMOTE_ADDR"]=="59.7.50.122"){$display="block";}else{$display="none";}?>

<form id="form_koces_payment" name="form_koces_payment" method="post">
	<input type="text" id="MID" name="MID" value="M20170713100003" style="display:<?=$display?>;" />
	<input type="text" id="PAY_METHOD" name="PAY_METHOD" value="CC" style="display:<?=$display?>;" />
	
	<input type="text" id="TID" name="TID" value="" style="display:<?=$display?>;" />

	<input type="text" id="CANCEL_AMT" name="CANCEL_AMT" value="" style="display:<?=$display?>;" />
	<input type="text" id="RESERVED01" name="RESERVED01" value="" style="display:<?=$display?>;" />
	<input type="text" id="RESERVED02" name="RESERVED02" value="" style="display:<?=$display?>;" />
	<input type="text" id="TAX_YN" name="TAX_YN" value="" style="display:<?=$display?>;" />
	<input type="text" id="TAX_AMT" name="TAX_AMT" value="" style="display:<?=$display?>;" />
	
</form>

