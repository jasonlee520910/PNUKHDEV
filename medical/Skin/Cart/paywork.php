<?php if($_SERVER["REMOTE_ADDR"]=="59.7.50.122"){$display="block";}else{$display="none";}?>

<form id="form_koces_payment" name="form_koces_payment" method="post">
	<input type="text" id="mid" name="mid" value="M20170713100003" style="display:<?=$display?>;" />
	<input type="text" id="rUrl" name="rUrl" value="https://devehd.pnukh.or.kr/Cart/webpay_return.php" style="display:<?=$display?>;" />
	<input type="text" id="rMethod" name="rMethod" value="POST" style="display:<?=$display?>;" />
	<input type="text" id="payType" name="payType" value="CC" style="display:<?=$display?>;" />
	<input type="text" id="buyItemnm" name="buyItemnm" value="" style="display:<?=$display?>;" />
	<input type="text" id="buyReqamt" name="buyReqamt" value="" style="display:<?=$display?>;" />

	<input type="text" id="buyItemcd" name="buyItemcd" value="" style="display:<?=$display?>;" />
	<input type="text" id="buyerid" name="buyerid" value="gildonghong" style="display:<?=$display?>;" />
	<input type="text" id="buyernm" name="buyernm" value="" style="display:<?=$display?>;" />
	<input type="text" id="buyerEmail" name="buyerEmail" value="jdh@tnctec.co.kr" style="display:<?=$display?>;" />


	<input type="text" id="orderno" name="orderno" value="" style="display:<?=$display?>;" />
	<input type="text" id="orderdt" name="orderdt" value="" style="display:<?=$display?>;" />
	<input type="text" id="ordertm" name="ordertm" value="" style="display:<?=$display?>;" />
	<input type="text" id="apiKey" name="apiKey" value="cf4dae5bb7b7606aa35e05aaba23b6a6" style="display:<?=$display?>;" />


	<input type="text" id="reserved01" name="reserved01" value="" style="display:<?=$display?>;" />
	<input type="text" id="reserved02" name="reserved02" value="" style="display:<?=$display?>;" />
	<input type="text" id="cardCode" name="cardCode" value="" style="display:<?=$display?>;" />
	<input type="text" id="quota" name="quota" value="" style="display:<?=$display?>;" />
	<input type="text" id="noint_inf" name="noint_inf" value="" style="display:<?=$display?>;" />


	<input type="text" id="bankCode" name="bankCode" value="" style="display:<?=$display?>;" />
	<input type="text" id="trend" name="trend" value="" style="display:<?=$display?>;" />
	<input type="text" id="taxYn" name="taxYn" value="" style="display:<?=$display?>;" />
	<input type="text" id="taxAmt" name="taxAmt" value="" style="display:<?=$display?>;" />
	<input type="text" id="checkHash" name="checkHash" value="" style="display:<?=$display?>;" />
</form>

