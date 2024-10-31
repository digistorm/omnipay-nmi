<?php

declare(strict_types=1);

namespace Omnipay\NMI\Message;

use Omnipay\Common\Exception\InvalidCreditCardException;
use Omnipay\Common\Exception\InvalidRequestException;

/**
 * NMI Direct Post Create Card Request
 */
class DirectPostCreateCardRequest extends AbstractRequest
{
    public string $customer_vault = 'add_customer';

    /**
     * @throws InvalidCreditCardException
     * @throws InvalidRequestException
     */
    public function getData(): array
    {
        $this->validate('card');
        $this->getCard()->validate();

        $data = $this->getBaseData();

        $data['ccnumber'] = $this->getCard()->getNumber();
        $data['ccexp'] = $this->getCard()->getExpiryDate('my');
        $data['payment'] = 'creditcard';

        if ($this->customer_vault === 'update_customer') {
            $data['customer_vault_id'] = $this->getCardReference();
        }

        return array_merge(
            $data,
            $this->getBillingData(),
            $this->getShippingData()
        );
    }
}
