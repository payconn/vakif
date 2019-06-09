<?php

namespace Payconn\Vakif\Request;

use Payconn\Common\AbstractRequest;
use Payconn\Common\HttpClient;
use Payconn\Common\ResponseInterface;
use Payconn\Vakif\Model\Complete;
use Payconn\Vakif\Response\CompleteResponse;
use Payconn\Vakif\Token;

class CompleteRequest extends AbstractRequest
{
    public function send(): ResponseInterface
    {
        /** @var Complete $model */
        $model = $this->getModel();
        /** @var Token $token */
        $token = $this->getToken();

        $body = new \SimpleXMLElement('<?xml version="1.0" encoding="ISO-8859-9"?><VposRequest></VposRequest>');
        $body->addChild('TransactionType', 'Sale');
        $body->addChild('TransactionDeviceSource', '0');
        $body->addChild('MerchantId', $token->getMerchantId());
        $body->addChild('Password', $token->getPassword());
        $body->addChild('TerminalNo', $token->getTerminalId());
        $body->addChild('TransactionId', $model->getReturnParams()->get('VerifyEnrollmentRequestId'));
        $body->addChild('CurrencyAmount', $model->getReturnParams()->get('SessionInfo'));
        $body->addChild('CurrencyCode', $model->getReturnParams()->get('PurchCurrency'));
        $body->addChild('Pan', $model->getReturnParams()->get('Pan'));
        $body->addChild('Expiry', $model->getExpireDate()->format('Ym'));
        $body->addChild('ClientIp', (string) $this->getIpAddress());
        $body->addChild('ECI', $model->getReturnParams()->get('Eci'));
        $body->addChild('CAVV', $model->getReturnParams()->get('Cavv'));
        $body->addChild('MpiTransactionId', $model->getReturnParams()->get('VerifyEnrollmentRequestId'));
        if ((int) $model->getReturnParams()->get('InstallmentCount') > 1) {
            $body->addChild('NumberOfInstallments', $model->getReturnParams()->get('InstallmentCount'));
        }

        /** @var HttpClient $httpClient */
        $httpClient = $this->getHttpClient();
        $response = $httpClient->request('POST', $model->getBaseUrl(), [
            'form_params' => [
                'prmstr' => $body->asXML(),
            ],
        ]);

        return new CompleteResponse($model, (array) @simplexml_load_string($response->getBody()->getContents()));
    }
}
