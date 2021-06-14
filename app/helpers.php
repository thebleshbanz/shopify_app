<?php

function send_sms($data = null){
	// dd($data);
	// create curl resource
	$ch = curl_init();

	$url = 'http://login.bulksmsglobal.in/api/sendhttp.php?authkey=5446AeDFM1QxSR6062fffbP32&mobiles=8818883436&message=8865 is the OTP for mobile number verification. Thank you for using Agrostand App.&sender=AGRSTD&route=6&country=91&DLT_TE_ID=1007235242339693997';

	// $url = 'http://sms.indiawebsoft.in/api/sendhttp.php?authkey=15533AfOT51IKke5e6375d4P15&mobiles=8818883436&message=Hello There Test Message from Myagrostand&sender=INDWEB&route=4&country=91';

	// set url
	curl_setopt($ch, CURLOPT_URL, $url);

	//return the transfer as a string
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

	// $output contains the output string
	$output = curl_exec($ch);

	// close curl resource to free up system resources
	curl_close($ch);

	return $output;
}



?>