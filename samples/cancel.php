<?php

require_once __DIR__.'/../vendor/autoload.php';

$token = new \Payconn\Vakif\Token('000100000013506', 'VP000579', '123456');
$cancel = new \Payconn\Vakif\Model\Cancel();
$cancel->setTestMode(true);
$cancel->setOrderId('ORDER1560106112');
$response = (new \Payconn\Vakif($token))->cancel($cancel);
print_r([
    'isSuccessful' => (int) $response->isSuccessful(),
    'message' => $response->getResponseMessage(),
    'code' => $response->getResponseCode(),
]);
