<?php

namespace Payconn\Vakif\Response;

use Payconn\Common\AbstractResponse;

class CancelResponse extends AbstractResponse
{
    public function isSuccessful(): bool
    {
        return '0000' === $this->getParameters()->get('ResultCode');
    }

    public function getResponseMessage(): string
    {
        return $this->getParameters()->get('ResultDetail');
    }

    public function getResponseCode(): string
    {
        return $this->getParameters()->get('ResultCode');
    }

    public function getResponseBody(): array
    {
        return $this->getParameters()->all();
    }

    public function isRedirection(): bool
    {
        return false;
    }

    public function getRedirectForm(): ?string
    {
        return null;
    }
}
