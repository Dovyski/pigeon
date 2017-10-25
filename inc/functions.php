<?php

function sendUsingSMTP($theTo, $theSubject, $theText) {
	if(!class_exists('PHPMailer\PHPMailer\PHPMailer')) {
	    throw new \Exception('SMTP is not ready (PHPMailer not installed). Run "composer install" in the root folder.');
	}

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
	$aHeaders[] = 'From: ' . SENDER_NAME . ' <' . SENDER_EMAIL . '>';
    $aHeaders[] = 'Reply-To: ' . SENDER_EMAIL;
    $aHeaders[] = 'X-Mailer: Pigeon/'.PIGEON_VERSION.' PHP/' . phpversion();

	if(!@mail($theTo, $theSubject, $theText, implode("\r\n", $aHeaders))) {
		throw new \Exception('Unable to send e-mail.');
	}
}

function isUsingValidCredentials($theToken) {
	if(empty(AUTH_TOKEN)) {
		// No config token specified for authentication. We assume no auth mechanism is
		// in place, so all credentials are valid
		return true;
	}

	$aWrongToken = $theToken != AUTH_TOKEN;
	return !$aWrongToken;
}

?>
