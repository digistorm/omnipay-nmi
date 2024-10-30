<?php

declare(strict_types=1);

namespace Omnipay\NMI\Message;

use Omnipay\Common\Exception\InvalidRequestException;

/**
 * NMI Three Step Redirect Authorize Request
 */
class ThreeStepRedirectAuthRequest extends ThreeStepRedirectAbstractRequest
{
    public string $type = 'auth';

    /**
     * Override Duplicate Transaction Detection checking (in seconds).
     */
    public function setDupSeconds(bool $value): self
    {
        return $this->setParameter('dup_seconds', $value);
    }

    public function getDupSeconds(): ?string
    {
        return $this->getParameter('dup_seconds');
    }

    /**
     * Sets the add customer.
     */
    public function setAddCustomer(bool $value): self
    {
        return $this->setParameter('add_customer', $value);
    }

    public function getAddCustomer(): bool
    {
        return $this->getParameter('add_customer');
    }

    /**
     * Sets the update customer.
     */
    public function setUpdateCustomer(bool $value): self
    {
        return $this->setParameter('update_customer', $value);
    }

    public function getUpdateCustomer(): bool
    {
        return $this->getParameter('update_customer');
    }

    /**
     * @throws InvalidRequestException
     */
    public function getData(): array
    {
        $this->validate('amount');

        $data = [
            'api-key' => $this->getApiKey(),
            'redirect-url' => $this->getRedirectUrl(),
            'amount' => $this->getAmount()
        ];

        if ($this->getCurrency()) {
            $data['currency'] = $this->getCurrency();
        }

        if ($this->getDupSeconds()) {
            $data['dup-seconds'] = $this->getDupSeconds();
        }

        if ($this->getMerchantDefinedField_1() !== '' && $this->getMerchantDefinedField_1() !== '0') {
            $data['merchant-defined-field-1'] = $this->getMerchantDefinedField_1();
        }

        if ($this->getMerchantDefinedField_2() !== '' && $this->getMerchantDefinedField_2() !== '0') {
            $data['merchant-defined-field-2'] = $this->getMerchantDefinedField_2();
        }

        if ($this->getMerchantDefinedField_3() !== '' && $this->getMerchantDefinedField_3() !== '0') {
            $data['merchant-defined-field-3'] = $this->getMerchantDefinedField_3();
        }

        if ($this->getMerchantDefinedField_4()) {
            $data['merchant-defined-field-4'] = $this->getMerchantDefinedField_4();
        }

        if ($this->getCardReference()) {
            $data['customer-vault-id'] = $this->getCardReference();

            // Customer Vault operations can be completed using a single Direct XML request to the gateway.
            // None of these operations submit sensitive payment information and theorefore do not require
            // any Three Step Redirect functionlity.
            unset($data['redirect-url']);
        } else {
            $data = array_merge(
                $data,
                $this->getOrderData(),
                $this->getBillingData(),
                $this->getShippingData()
            );

            if ($this->getAddCustomer()) {
                $data['add-customer'] = [];
            }

            if ($this->getUpdateCustomer()) {
                $data['update-customer'] = [
                    'customer-vault-id' => $this->getUpdateCustomer(),
                ];
            }
        }

        return $data;
    }
}
