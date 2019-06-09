<?php

require_once __DIR__.'/../vendor/autoload.php';

$token = new \Payconn\Vakif\Token('000100000013506', 'VP000579', '123456');
$complete = new \Payconn\Vakif\Model\Complete();
$complete->setTestMode(true);
$complete->setReturnParams([
    'MerchantId' => '000100000013506',
    'Pan' => '4289450189088488',
    'Expiry' => '2304',
    'PurchAmount' => '126',
    'PurchCurrency' => '949',
    'VerifyEnrollmentRequestId' => 'ORDER1560106112',
    'Xid' => 'vz6266srj9kdke7pcf84',
    'SessionInfo' => '1.26',
    'Status' => 'Y',
    'Cavv' => 'AAABAHdHEQAAAAAgYEcRAAAAAAA=',
    'Eci' => '05',
    'InstallmentCount' => '3',
    'ErrorCode' => '',
    'ErrorMessage' => '',
]);
$response = (new \Payconn\Vakif($token))->complete($complete);
print_r([
    'isSuccessful' => (int) $response->isSuccessful(),
    'message' => $response->getResponseMessage(),
    'code' => $response->getResponseCode(),
    'orderId' => $response->getOrderId(),
]);
