<?php

namespace Payconn\Vakif\Tests;

use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use Payconn\Common\CreditCard;
use Payconn\Common\HttpClient;
use Payconn\Vakif\Currency;
use Payconn\Vakif\Model\Authorize;
use Payconn\Vakif\Token;
use PHPUnit\Framework\TestCase;

class AuthorizeTest extends TestCase
{
    public function testSuccessful()
    {
        $response = new Response(200, [], '<?xml version="1.0" encoding="UTF-8"?>
        <IPaySecure>
           <Message ID="crrz1no5d6b951b06fa043379458dc835b71d0c8">
              <VERes>
                 <Version>1.0.2</Version>
                 <Status>Y</Status>
                 <PaReq>2b8dFf97Uf2YU1oU=</PaReq>
                 <ACSUrl>https://dropit.3dsecure.net:9443/PIT/ACS</ACSUrl>
                 <TermUrl>http://localhost:2514/VB_MPI_Pares.asp</TermUrl>
                 <MD>crrz1no5d6b951b06fa043379458dc835b71d0c8</MD>
                 <ACTUALBRAND>Master</ACTUALBRAND>
              </VERes>
           </Message>
           <MessageErrorCode>200</MessageErrorCode>
        </IPaySecure>');
        $mock = new MockHandler([
            $response,
        ]);
        $handler = HandlerStack::create($mock);
        $client = new HttpClient(['handler' => $handler]);

        // purchase
        $token = new Token('123', '345', '12345');
        $creditCard = new CreditCard('4355084355084358', '26', '12', '000');
        $authorize = new Authorize();
        $authorize->setTestMode(true);
        $authorize->setCreditCard($creditCard);
        $authorize->setCurrency(Currency::TRY);
        $authorize->setAmount(100);
        $authorize->setInstallment(1);
        $authorize->setOrderId('GVP'.time());
        $authorize->setSuccessfulUrl('http://127.0.0.1:8000/successful');
        $authorize->setFailureUrl('http://127.0.0.1:8000/failure');
        $authorize->setCardBrand('100');
        $response = (new \Payconn\Vakif($token, $client))->authorize($authorize);
        $this->assertTrue($response->isSuccessful());
        $this->assertContains('2b8dFf97Uf2YU1oU=', $response->getRedirectForm());
        $this->assertContains('https://dropit.3dsecure.net:9443/PIT/ACS', $response->getRedirectForm());
    }
}
