<?php

@include(dirname(__FILE__) . '/../config.local.php');
@include(dirname(__FILE__) . '/../config.php');
include(dirname(__FILE__) . '/inc/functions.php');

$aMethod = isset($_REQUEST['method']) ? $_REQUEST['method'] : '';
$aReturn = array('success' => true, 'method' => $aMethod, 'timestamp' => time());

try {
	switch ($aMethod) {
		case 'send':
			$aReturn['data'] = array();
			break;

		default:
			$aReturn = array('failure' => true, 'message' => 'Unknow method');
			break;
	}
} catch(Exception $e) {
	$aReturn = array('failure' => true, 'message' => $e->getMessage());
}

header('Content-Type: application/json');
echo json_encode($aReturn, JSON_NUMERIC_CHECK);

?>
