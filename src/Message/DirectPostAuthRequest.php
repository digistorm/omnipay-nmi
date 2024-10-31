<?php

declare(strict_types=1);

namespace Omnipay\NMI\Message;

use Omnipay\Common\Exception\InvalidCreditCardException;
use Omnipay\Common\Exception\InvalidRequestException;

/**
 * NMI Direct Post Authorize Request
 */
class DirectPostAuthRequest extends AbstractRequest
{
    public string $type = 'auth';

    public function getMerchantDefinedField_1(): ?string
    {
        return $this->getParameter('merchant_defined_field_1');
    }

    public function setMerchantDefinedField_1(string $value): self
    {
        return $this->setParameter('merchant_defined_field_1', $value);
    }

    public function getMerchantDefinedField_2(): ?string
    {
        return $this->getParameter('merchant_defined_field_2');
    }

    /**
     * Sets the second merchant defined field.
     */
    public function setMerchantDefinedField_2(string $value): self
    {
        return $this->setParameter('merchant_defined_field_2', $value);
    }

    public function getMerchantDefinedField_3(): ?string
    {
        return $this->getParameter('merchant_defined_field_3');
    }

    /**
     * Sets the third merchant defined field.
     */
    public function setMerchantDefinedField_3(string $value): self
    {
        return $this->setParameter('merchant_defined_field_3', $value);
    }

    public function getMerchantDefinedField_4(): ?string
    {
        return $this->getParameter('merchant_defined_field_4');
    }

    /**
     * Sets the fourth merchant defined field.
     */
    public function setMerchantDefinedField_4(string $value): self
    {
        return $this->setParameter('merchant_defined_field_4', $value);
    }

    /**
     * @throws InvalidCreditCardException
     * @throws InvalidRequestException
     */
    public function getData(): array
    {
        $this->validate('amount');

        $data = $this->getBaseData();
        $data['amount'] = $this->getAmount();

        if ($this->getMerchantDefinedField_1() !== '' && $this->getMerchantDefinedField_1() !== '0') {
            $data['merchant_defined_field_1'] = $this->getMerchantDefinedField_1();
        }

        if ($this->getMerchantDefinedField_2() !== '' && $this->getMerchantDefinedField_2() !== '0') {
            $data['merchant_defined_field_2'] = $this->getMerchantDefinedField_2();
        }

        if ($this->getMerchantDefinedField_3() !== '' && $this->getMerchantDefinedField_3() !== '0') {
            $data['merchant_defined_field_3'] = $this->getMerchantDefinedField_3();
        }

        if ($this->getMerchantDefinedField_4() !== '' && $this->getMerchantDefinedField_4() !== '0') {
            $data['merchant_defined_field_4'] = $this->getMerchantDefinedField_4();
        }

        if ($this->getCardReference()) {
            $data['customer_vault_id'] = $this->getCardReference();

            return $data;
        }
        $this->getCard()->validate();
        $data['ccnumber'] = $this->getCard()->getNumber();
        $data['ccexp'] = $this->getCard()->getExpiryDate('my');
        $data['cvv'] = $this->getCard()->getCvv();

        return array_merge(
            $data,
            $this->getOrderData(),
            $this->getBillingData(),
            $this->getShippingData()
        );
    }
}
