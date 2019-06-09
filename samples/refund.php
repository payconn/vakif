<?php

require_once __DIR__.'/../vendor/autoload.php';

$token = new \Payconn\Vakif\Token('000100000013506', 'VP000579', '123456');
$refund = new \Payconn\Vakif\Model\Refund();
$refund->setTestMode(true);
$refund->setOrderId('afc5611b89164f98aa08aa67016cfd95');
$refund->setAmount('1.25');
$response = (new \Payconn\Vakif($token))->refund($refund);
print_r([
    'isSuccessful' => (int) $response->isSuccessful(),
    'message' => $response->getResponseMessage(),
    'code' => $response->getResponseCode(),
]);
