<?php

require_once __DIR__.'/../vendor/autoload.php';

$token = new \Payconn\Vakif\Token('000100000013506', 'VP000579', '123456');
$authorize = new \Payconn\Vakif\Model\Authorize();
$authorize->setTestMode(true);
$authorize->setCurrency(\Payconn\Vakif\Currency::TRY);
$authorize->setAmount(1.26);
$authorize->setInstallment(3);
$authorize->setCreditCard(new \Payconn\Common\CreditCard('4289450189088488', '2023', '04', '060'));
$authorize->setSuccessfulUrl('http://127.0.0.1:8000/successful');
$authorize->setFailureUrl('http://127.0.0.1:8000/failure');
$authorize->setCardBrand('100');
$authorize->generateOrderId();
$response = (new \Payconn\Vakif($token))->authorize($authorize);
print_r([
    'isSuccessful' => (int) $response->isSuccessful(),
    'message' => $response->getResponseMessage(),
    'code' => $response->getResponseCode(),
    'form' => $response->getRedirectForm(),
]);
