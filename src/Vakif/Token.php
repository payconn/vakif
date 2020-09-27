<?php

namespace Payconn\Vakif;

use Payconn\Common\TokenInterface;

class Token implements TokenInterface
{
    private $merchantId;

    private $terminalId;

    private $password;

    public function __construct(string $merchantId, string $terminalId, string $password)
    {
        $this->merchantId = $merchantId;
        $this->terminalId = $terminalId;
        $this->password = $password;
    }

    public function getMerchantId(): string
    {
        return $this->merchantId;
    }

    public function getTerminalId(): string
    {
        return $this->terminalId;
    }

    public function getPassword(): string
    {
        return $this->password;
    }
}
