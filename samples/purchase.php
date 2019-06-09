<?php

require_once __DIR__.'/../vendor/autoload.php';

$token = new \Payconn\Vakif\Token('000100000013506', 'VP000579', '123456');
$purchase = new \Payconn\Vakif\Model\Purchase();
$purchase->setTestMode(true);
$purchase->setCurrency(\Payconn\Vakif\Currency::TRY);
$purchase->setAmount(100);
$purchase->setInstallment(1);
$purchase->setCreditCard(new \Payconn\Common\CreditCard('4289450189088488', '2023', '04', '060'));
$response = (new \Payconn\Vakif($token))->purchase($purchase);
print_r([
    'isSuccessful' => (int) $response->isSuccessful(),
    'message' => $response->getResponseMessage(),
    'code' => $response->getResponseCode(),
    'orderId' => $response->getOrderId(),
]);
