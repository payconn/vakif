<?php

namespace Payconn\Vakif\Model;

use Payconn\Common\AbstractModel;
use Payconn\Common\Model\CompleteInterface;
use Symfony\Component\HttpFoundation\ParameterBag;

class Complete extends AbstractModel implements CompleteInterface
{
    protected $returnParams;

    public function getReturnParams(): ParameterBag
    {
        return $this->returnParams;
    }

    public function setReturnParams(array $returnParams): void
    {
        $this->returnParams = new ParameterBag($returnParams);
    }

    public function getExpireDate(): string
    {
        return (\DateTime::createFromFormat('ym', $this->getReturnParams()->get('Expiry', date('ym'))))
            ->format('Ym');
    }
}
