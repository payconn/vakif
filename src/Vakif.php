<?php

namespace Payconn;

use Payconn\Common\AbstractGateway;
use Payconn\Common\BaseUrl;
use Payconn\Common\Model\AuthorizeInterface;
use Payconn\Common\Model\CancelInterface;
use Payconn\Common\Model\CompleteInterface;
use Payconn\Common\Model\PurchaseInterface;
use Payconn\Common\Model\RefundInterface;
use Payconn\Common\ResponseInterface;
use Payconn\Vakif\Request\PurchaseRequest;

class Vakif extends AbstractGateway
{
    public function initialize(): void
    {
        $this->setBaseUrl((new BaseUrl())
            ->setProdUrls('', '')
            ->setTestUrls('https://onlineodemetest.vakifbank.com.tr:4443/VposService/v3/Vposreq.aspx', 'https://3dsecuretest.vakifbank.com.tr:4443/MPIAPI/MPI_Enrollment.aspx'));
    }

    public function authorize(AuthorizeInterface $model): ResponseInterface
    {
        // TODO: Implement authorize() method.
    }

    public function complete(CompleteInterface $model): ResponseInterface
    {
        // TODO: Implement complete() method.
    }

    public function purchase(PurchaseInterface $purchase): ResponseInterface
    {
        return $this->createRequest(PurchaseRequest::class, $purchase);
    }

    public function refund(RefundInterface $model): ResponseInterface
    {
        // TODO: Implement refund() method.
    }

    public function cancel(CancelInterface $model): ResponseInterface
    {
        // TODO: Implement cancel() method.
    }
}
