<?php

namespace Payconn\Vakif\Model;

use Payconn\Common\AbstractModel;
use Payconn\Common\Model\CompleteInterface;
use Symfony\Component\HttpFoundation\ParameterBag;

class Complete extends AbstractModel implements CompleteInterface
{
    /**
     * @var ParameterBag
     */
    protected $returnParams;

    public function __construct()
    {
        $this->returnParams = new ParameterBag();
    }

    public function getReturnParams(): ParameterBag
    {
        return $this->returnParams;
    }

    public function setReturnParams(array $returnParams): void
    {
        $this->returnParams = new ParameterBag($returnParams);
    }

    public function getExpireDate(string $format = 'Ym'): string
    {
        $expire = \DateTime::createFromFormat('ym', $this->getReturnParams()->get('Expiry'));
        if (!$expire) {
            $expire = new \DateTime();
        }

        return $expire->format($format);
    }
}
