<?php

declare(strict_types=1);

namespace Omnipay\NMI\Message;

use Omnipay\Common\Exception\InvalidRequestException;

/**
 * NMI Direct Post Void Request
 */
class DirectPostVoidRequest extends AbstractRequest
{
    public string $type = 'void';

    /**
     * @throws InvalidRequestException
     */
    public function getData(): array
    {
        $this->validate('transactionReference');

        $data = $this->getBaseData();
        $data['transactionid'] = $this->getTransactionReference();

        return $data;
    }
}
