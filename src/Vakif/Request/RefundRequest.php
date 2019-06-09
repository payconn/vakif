<?php

namespace Payconn\Vakif\Request;

use Payconn\Common\AbstractRequest;
use Payconn\Common\HttpClient;
use Payconn\Common\ResponseInterface;
use Payconn\Vakif\Model\Refund;
use Payconn\Vakif\Response\RefundResponse;
use Payconn\Vakif\Token;

class RefundRequest extends AbstractRequest
{
    public function send(): ResponseInterface
    {
        /** @var Refund $model */
        $model = $this->getModel();
        /** @var Token $token */
        $token = $this->getToken();

        $body = new \SimpleXMLElement('<?xml version="1.0" encoding="ISO-8859-9"?><VposRequest></VposRequest>');
        $body->addChild('TransactionType', 'Refund');
        $body->addChild('MerchantId', $token->getMerchantId());
        $body->addChild('Password', $token->getPassword());
        $body->addChild('TerminalNo', $token->getTerminalId());
        $body->addChild('ReferenceTransactionId', $model->getOrderId());
        $body->addChild('CurrencyAmount', $model->getAmount());
        $body->addChild('ClientIp', (string)$this->getIpAddress());

        /** @var HttpClient $httpClient */
        $httpClient = $this->getHttpClient();
        $response = $httpClient->request('POST', $model->getBaseUrl(), [
            'form_params' => [
                'prmstr' => $body->asXML(),
            ],
        ]);

        return new RefundResponse($model, (array) @simplexml_load_string($response->getBody()->getContents()));
    }
}
