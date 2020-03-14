<?php

namespace Payconn\Vakif\Model;

use Payconn\Common\AbstractModel;
use Payconn\Common\Model\AuthorizeInterface;
use Payconn\Common\Traits\Amount;
use Payconn\Common\Traits\CreditCard;
use Payconn\Common\Traits\Currency;
use Payconn\Common\Traits\Installment;
use Payconn\Common\Traits\OrderId;
use Payconn\Common\Traits\ReturnUrl;

class Authorize extends AbstractModel implements AuthorizeInterface
{
    use CreditCard;
    use Amount;
    use Installment;
    use Currency;
    use ReturnUrl;
    use OrderId;

    /**
     * @var string|null
     */
    protected $cardBrand;

    public function getCardBrand(): ?string
    {
        return $this->cardBrand;
    }

    public function setCardBrand(?string $cardBrand): void
    {
        $this->cardBrand = $cardBrand;
    }
}
