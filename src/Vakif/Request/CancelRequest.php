<?php

namespace Payconn\Vakif\Request;

use Payconn\Common\AbstractRequest;
use Payconn\Common\HttpClient;
use Payconn\Common\ResponseInterface;
use Payconn\Vakif\Model\Cancel;
use Payconn\Vakif\Response\CancelResponse;
use Payconn\Vakif\Token;

class CancelRequest extends AbstractRequest
{
    public function send(): ResponseInterface
    {
        /** @var Cancel $model */
        $model = $this->getModel();
        /** @var Token $token */
        $token = $this->getToken();

        $body = new \SimpleXMLElement('<?xml version="1.0" encoding="ISO-8859-9"?><VposRequest></VposRequest>');
        $body->addChild('TransactionType', 'Cancel');
        $body->addChild('MerchantId', $token->getMerchantId());
        $body->addChild('Password', $token->getPassword());
        $body->addChild('TerminalNo', $token->getTerminalId());
        $body->addChild('ReferenceTransactionId', $model->getOrderId());
        $body->addChild('ClientIp', $this->getIpAddress());

        /** @var HttpClient $httpClient */
        $httpClient = $this->getHttpClient();
        $response = $httpClient->request('POST', $model->getBaseUrl(), [
            'form_params' => [
                'prmstr' => $body->asXML(),
            ],
        ]);

        return new CancelResponse($model, (array) @simplexml_load_string($response->getBody()->getContents()));
    }
}
