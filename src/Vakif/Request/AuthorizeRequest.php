<?php

namespace Payconn\Vakif\Request;

use Payconn\Common\AbstractRequest;
use Payconn\Common\HttpClient;
use Payconn\Common\ResponseInterface;
use Payconn\Vakif\Model\Authorize;
use Payconn\Vakif\Response\AuthorizeResponse;
use Payconn\Vakif\Token;

class AuthorizeRequest extends AbstractRequest
{
    public function send(): ResponseInterface
    {
        /** @var Authorize $model */
        $model = $this->getModel();
        /** @var Token $token */
        $token = $this->getToken();

        /** @var HttpClient $httpClient */
        $httpClient = $this->getHttpClient();
        $response = $httpClient->request('POST', $model->getBaseUrl(), [
            'form_params' => [
                'MerchantId' => $token->getMerchantId(),
                'MerchantPassword' => $token->getPassword(),
                'VerifyEnrollmentRequestId' => $model->getOrderId(),
                'Pan' => $model->getCreditCard()->getNumber(),
                'ExpiryDate' => $model->getCreditCard()->getExpireYear()->format('y').$model->getCreditCard()->getExpireMonth()->format('m'),
                'PurchaseAmount' => $model->getAmount(),
                'Currency' => $model->getCurrency(),
                'BrandName' => $model->getCardBrand(),
                'SuccessUrl' => $model->getSuccessfulUrl(),
                'FailureUrl' => $model->getFailureUrl(),
                'InstallmentCount' => $model->getInstallment(),
                'SessionInfo' => $model->getAmount(),
            ],
        ]);

        return new AuthorizeResponse($model, (array) @simplexml_load_string($response->getBody()->getContents()));
    }
}
