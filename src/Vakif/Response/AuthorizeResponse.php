<?php

namespace Payconn\Vakif\Response;

use Payconn\Common\AbstractResponse;

class AuthorizeResponse extends AbstractResponse
{
    public function isSuccessful(): bool
    {
        return 'Y' === strval($this->getParameters()->get('Message')->VERes->Status);
    }

    public function getResponseMessage(): string
    {
        if ($this->isSuccessful()) {
            return 'Authorized';
        }

        return $this->getParameters()->get('ErrorMessage');
    }

    public function getResponseCode(): string
    {
        return $this->getParameters()->get('MessageErrorCode');
    }

    public function getResponseBody(): array
    {
        return $this->getParameters()->all();
    }

    public function isRedirection(): bool
    {
        return $this->isSuccessful();
    }

    public function getRedirectForm(): ?string
    {
        if (!$this->isSuccessful()) {
            return null;
        }

        return '<form action="'.strval($this->getParameters()->get('Message')->VERes->ACSUrl).'" method="post" name="vpos">
            <input type="hidden" name="PaReq" value="'.strval($this->getParameters()->get('Message')->VERes->PaReq).'">
            <input type="hidden" name="TermUrl" value="'.strval($this->getParameters()->get('Message')->VERes->TermUrl).'">
            <input type="hidden" name="MD" value="'.strval($this->getParameters()->get('Message')->VERes->MD).'">
        </form>
        <script type="text/javascript">
            document.vpos.submit();
        </script>';
    }
}
