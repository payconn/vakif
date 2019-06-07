<?php

namespace Payconn\Vakif\Request;

use Payconn\Common\AbstractRequest;
use Payconn\Common\HttpClient;
use Payconn\Common\ResponseInterface;
use Payconn\Vakif\Model\Purchase;
use Payconn\Vakif\Response\PurchaseResponse;
use Payconn\Vakif\Token;

class PurchaseRequest extends AbstractRequest
{
    public function send(): ResponseInterface
    {
        /** @var Purchase $model */
        $model = $this->getModel();
        /** @var Token $token */
        $token = $this->getToken();

        $body = new \SimpleXMLElement('<?xml version="1.0" encoding="ISO-8859-9"?><VposRequest></VposRequest>');
        $body->addChild('TransactionType', 'Sale');
        $body->addChild('MerchantId', $token->getMerchantId());
        $body->addChild('Password', $token->getPassword());
        $body->addChild('TerminalNo', $token->getTerminalId());
        $body->addChild('CurrencyAmount', (string) $model->getAmount());
        $body->addChild('CurrencyCode', $model->getCurrency());
        $body->addChild('Pan', $model->getCreditCard()->getNumber());
        $body->addChild('Cvv', $model->getCreditCard()->getCvv());
        $body->addChild('Expiry', $model->getCreditCard()->getExpireYear().$model->getCreditCard()->getExpireMonth());
        $body->addChild('ClientIp', '127.0.0.1');
        $body->addChild('TransactionDeviceSource', '0');

        /** @var HttpClient $httpClient */
        $httpClient = $this->getHttpClient();
        $response = $httpClient->request('POST', $model->getBaseUrl(), [
            'form_params' => [
                'prmstr' => $body->asXML(),
            ],
        ]);

        return new PurchaseResponse($model, (array) @simplexml_load_string($response->getBody()->getContents()));
    }
}
