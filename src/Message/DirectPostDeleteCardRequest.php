<?php

declare(strict_types=1);

namespace Omnipay\NMI\Message;

use Omnipay\Common\Exception\InvalidRequestException;

/**
 * NMI Direct Post Delete Card Request
 */
class DirectPostDeleteCardRequest extends AbstractRequest
{
    public string $customer_vault = 'delete_customer';

    /**
     * @throws InvalidRequestException
     */
    public function getData(): array
    {
        $this->validate('cardReference');

        $data = $this->getBaseData();

        $data['customer_vault_id'] = $this->getCardReference();

        return $data;
    }
}
