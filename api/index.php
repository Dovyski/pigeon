<?php

@include(dirname(__FILE__) . '/../config.local.php');
@include(dirname(__FILE__) . '/../config.php');
include(dirname(__FILE__) . '/inc/functions.php');

@include_once(dirname(__FILE__) . '/../vendor/autoload.php');

$aMethod   = isset($_REQUEST['method'])   ? $_REQUEST['method']   : '';
$aUser     = isset($_REQUEST['user'])     ? $_REQUEST['user']     : '';
$aPassword = isset($_REQUEST['password']) ? $_REQUEST['password'] : '';
$aReturn   = array('success' => true, 'method' => $aMethod, 'timestamp' => time());

try {
	if(!isUsingValidCredentials($aUser, $aPassword)) {
		throw new \Exception('Invalid auth credentials.');
	}

	switch ($aMethod) {
		case 'send':
			$aTo = isset($_REQUEST['to']) ? $_REQUEST['to'] : '';
			$aSubject = isset($_REQUEST['subject']) ? $_REQUEST['subject'] : '';
			$aText = isset($_REQUEST['text']) ? $_REQUEST['text'] : '';

			if(empty($aTo)) {
			    throw new \Exception('Empty e-mail address is not allowed');
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
			$aMailer->addAddress($aTo);

			$aMailer->Subject = SUBJECT_PREFIX . $aSubject;
			$aMailer->Body = TEXT_PREFIX . $aText . TEXT_SUFIX;

			if (!$aMailer->send()) {
			    throw new \Exception('Unable to send e-mail. ' . $aMailer->ErrorInfo);
			}
			break;

		default:
			throw new \Exception('Unknow method');
			break;
	}
} catch(Exception $e) {
	$aReturn['success'] = false;
	$aReturn['error'] = $e->getMessage();
}

header('Content-Type: application/json');
echo json_encode($aReturn, JSON_NUMERIC_CHECK);

?>
