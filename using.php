<?php
$address = "localhost";
$service_port = 8888;

$token = new Token($address, $service_port);
header("Content-type: application/json");

/**
TODO Update bank token. Send token update request to a bank
*/
echo json_encode($token->updateToken('014'));


/**
TODO Get last token saved on the database from previouse token update
*/
// Get last token for bank 002 and 014
//echo json_encode($token->getToken('002, 014'));
// Get last token for bank 002 and 014
//echo json_encode($token->getToken(array('002', '014')));
// Get last token for bank 002 and 014
//echo json_encode($token->getToken(array(array('code'=>'002'), array('code'=>'014'))));
// Get last token for all banks
//echo json_encode($token->getToken());
?>
