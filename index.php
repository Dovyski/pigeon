<?php

define('PIGEON_VERSION', '1.0.0');

@include(dirname(__FILE__) . '/config.local.php');
@include(dirname(__FILE__) . '/config.php');
include_once(dirname(__FILE__) . '/inc/functions.php');
@include_once(dirname(__FILE__) . '/vendor/autoload.php');

$aMethod   = isset($_REQUEST['method']) ? $_REQUEST['method'] : '';
$aToken    = isset($_REQUEST['token'])  ? $_REQUEST['token']  : '';
$aReturn   = array('success' => true, 'method' => $aMethod, 'timestamp' => time(), 'version' => PIGEON_VERSION);

try {
	if(!isUsingValidCredentials($aToken)) {
		throw new \Exception('Invalid auth token.');
	}

	switch ($aMethod) {
		case 'send':
			$aTo      = isset($_REQUEST['to'])      ? $_REQUEST['to'] : '';
			$aSubject = isset($_REQUEST['subject']) ? SUBJECT_PREFIX . $_REQUEST['subject'] : '';
			$aText    = isset($_REQUEST['text'])    ? TEXT_PREFIX . $_REQUEST['text'] . TEXT_SUFIX : '';

			if(empty($aTo)) {
			    throw new \Exception('Empty e-mail address is not allowed.');
			}

			if(empty($aSubject)) {
			    throw new \Exception('Empty subject is not allowed.');
			}

			// Add line breaks
			$aText = str_replace('\n', "\n", $aText);

			if(USE_CUSTOM_SMTP) {
				sendUsingSMTP($aTo, $aSubject, $aText);
			}

			if(USE_MAIL_FUNCTION) {
				sendUsingMailFunction($aTo, $aSubject, $aText);
			}
			break;

		default:
			throw new \Exception('Unknow method.');
			break;
	}
} catch(Exception $e) {
	$aReturn['success'] = false;
	$aReturn['error'] = $e->getMessage();
}

header('Content-Type: application/json');
echo json_encode($aReturn, JSON_NUMERIC_CHECK);

?>
