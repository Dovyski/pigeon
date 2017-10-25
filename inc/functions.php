<?php

function sendUsingSMTP($theTo, $theSubject, $theText) {
	$aMailer = new PHPMailer\PHPMailer\PHPMailer();
	$aMailer->isSMTP();

	//Enable SMTP debugging
	// 0 = off (for production use)
	// 1 = client messages
	// 2 = client and server messages
	$aMailer->SMTPDebug = DEBUG ? 2 : 0;

	$aMailer->Host = gethostbyname(SMTP_HOST);
	$aMailer->Port = 587;
	$aMailer->SMTPSecure = 'tls';
	$aMailer->SMTPAuth = true;

	$aMailer->Username = SMTP_USER;
	$aMailer->Password = SMTP_PASSWORD;

	$aMailer->setFrom(SENDER_EMAIL, SENDER_NAME);
	$aMailer->addAddress($theTo);

	$aMailer->Subject = $theSubject;
	$aMailer->Body = $theText;

	if (!$aMailer->send()) {
		throw new \Exception('Unable to send e-mail. ' . $aMailer->ErrorInfo);
	}
}

function sendUsingMailFunction($theTo, $theSubject, $theText) {
	// TODO: implement this
}

function isUsingValidCredentials($theUser, $thePassword) {
	// TODO: implement this
	return true;
}

?>
