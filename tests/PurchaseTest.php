<?php

namespace Payconn\Vakif\Tests;

use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use Payconn\Common\CreditCard;
use Payconn\Common\HttpClient;
use Payconn\Vakif\Currency;
use Payconn\Vakif\Model\Purchase;
use Payconn\Vakif\Token;
use PHPUnit\Framework\TestCase;

class PurchaseTest extends TestCase
{
    public function testFailure()
    {
        $response = new Response(200, [], '<?xml version="1.0" encoding="UTF-8"?>
        <VposResponse>
           <ResultCode>0001</ResultCode>
           <ResultDetail>İŞLEM BAŞARISIZ</ResultDetail>
        </VposResponse>');
        $mock = new MockHandler([
            $response,
        ]);
        $handler = HandlerStack::create($mock);
        $client = new HttpClient(['handler' => $handler]);

        // purchase
        $token = new Token('123', '345', '12345');
        $creditCard = new CreditCard('4355084355084358', '26', '12', '000');
        $purchase = new Purchase();
        $purchase->setTestMode(true);
        $purchase->setCreditCard($creditCard);
        $purchase->setCurrency(Currency::TRY);
        $purchase->setAmount(100);
        $purchase->setInstallment(1);
        $response = (new \Payconn\Vakif($token, $client))->purchase($purchase);
        $this->assertFalse($response->isSuccessful());
    }

    public function testSuccessful()
    {
        $response = new Response(200, [], '<?xml version="1.0" encoding="UTF-8"?>
        <VposResponse>
           <ResultCode>0000</ResultCode>
           <ResultDetail>İŞLEM BAŞARILI</ResultDetail>
        </VposResponse>');
        $mock = new MockHandler([
            $response,
        ]);
        $handler = HandlerStack::create($mock);
        $client = new HttpClient(['handler' => $handler]);

        // purchase
        $token = new Token('123', '345', '12345');
        $creditCard = new CreditCard('4355084355084358', '26', '12', '000');
        $purchase = new Purchase();
        $purchase->setTestMode(true);
        $purchase->setCreditCard($creditCard);
        $purchase->setCurrency(Currency::TRY);
        $purchase->setAmount(100);
        $purchase->setInstallment(1);
        $response = (new \Payconn\Vakif($token, $client))->purchase($purchase);
        $this->assertTrue($response->isSuccessful());
    }
}
