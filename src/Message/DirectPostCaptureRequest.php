<?php

declare(strict_types=1);

namespace Omnipay\NMI\Message;

use Omnipay\Common\Exception\InvalidRequestException;

/**
 * NMI Direct Post Capture Request
 */
class DirectPostCaptureRequest extends AbstractRequest
{
    public string $type = 'capture';

    /**
     * @throws InvalidRequestException
     */
    public function getData(): array
    {
        $this->validate('transactionReference');

        $data = $this->getBaseData();
        $data['transactionid'] = $this->getTransactionReference();

        if ($this->getAmount() > 0) {
            $data['amount'] = $this->getAmount();
        }

        return $data;
    }
}
