<?php

declare(strict_types=1);

namespace Omnipay\NMI\Message;

use Omnipay\Common\Exception\InvalidRequestException;
use Omnipay\Common\Message\AbstractRequest as CommonAbstractRequest;
use Omnipay\Common\Message\AbstractResponse;

/**
 * NMI Abstract Request
 */
abstract class AbstractRequest extends CommonAbstractRequest
{
    public string $type;

    public string $customer_vault;

    protected string $endpoint = 'https://secure.nmi.com/api/transact.php';

    public function getUsername(): ?string
    {
        return $this->getParameter('username');
    }

    public function setUsername(string $value): self
    {
        return $this->setParameter('username', $value);
    }

    public function getPassword(): ?string
    {
        return $this->getParameter('password');
    }

    public function setPassword(string $value): self
    {
        return $this->setParameter('password', $value);
    }

    public function getSecurityKey(): ?string
    {
        return $this->getParameter('security_key');
    }

    public function setSecurityKey(string $value): self
    {
        return $this->setParameter('security_key', $value);
    }

    public function getProcessorId(): ?string
    {
        return $this->getParameter('processor_id');
    }

    public function setProcessorId(string $value): self
    {
        return $this->setParameter('processor_id', $value);
    }

    public function getAuthorizationCode(): ?string
    {
        return $this->getParameter('authorization_code');
    }

    public function setAuthorizationCode(string $value): self
    {
        return $this->setParameter('authorization_code', $value);
    }

    public function getDescriptor(): ?string
    {
        return $this->getParameter('descriptor');
    }

    public function setDescriptor(string $value): self
    {
        return $this->setParameter('descriptor', $value);
    }

    public function getDescriptorPhone(): ?string
    {
        return $this->getParameter('descriptor_phone');
    }

    public function setDescriptorPhone(string $value): self
    {
        return $this->setParameter('descriptor_phone', $value);
    }

    public function getDescriptorAddress(): ?string
    {
        return $this->getParameter('descriptor_address');
    }

    public function setDescriptorAddress(string $value): self
    {
        return $this->setParameter('descriptor_address', $value);
    }

    public function getDescriptorCity(): ?string
    {
        return $this->getParameter('descriptor_city');
    }

    public function setDescriptorCity(string $value): self
    {
        return $this->setParameter('descriptor_city', $value);
    }

    public function getDescriptorState(): ?string
    {
        return $this->getParameter('descriptor_state');
    }

    public function setDescriptorState(string $value): self
    {
        return $this->setParameter('descriptor_state', $value);
    }

    public function getDescriptorPostal(): ?string
    {
        return $this->getParameter('descriptor_postal');
    }

    public function setDescriptorPostal(string $value): self
    {
        return $this->setParameter('descriptor_postal', $value);
    }

    public function getDescriptorCountry(): ?string
    {
        return $this->getParameter('descriptor_country');
    }

    public function setDescriptorCountry(string $value): self
    {
        return $this->setParameter('descriptor_country', $value);
    }

    public function getDescriptorMcc(): ?string
    {
        return $this->getParameter('descriptor_mcc');
    }

    public function setDescriptorMcc(string $value): self
    {
        return $this->setParameter('descriptor_mcc', $value);
    }

    public function getDescriptorMerchantId(): ?string
    {
        return $this->getParameter('descriptor_merchant_id');
    }

    public function setDescriptorMerchantId(string $value): self
    {
        return $this->setParameter('descriptor_merchant_id', $value);
    }

    public function getDescriptorUrl(): ?string
    {
        return $this->getParameter('descriptor_url');
    }

    public function setDescriptorUrl(string $value): self
    {
        return $this->setParameter('descriptor_url', $value);
    }

    public function getOrderId(): ?string
    {
        return $this->getParameter('orderid');
    }

    public function setOrderId(string $value): self
    {
        return $this->setParameter('orderid', $value);
    }

    public function getOrderDescription(): ?string
    {
        return $this->getParameter('orderdescription');
    }

    public function setOrderDescription(string $value): self
    {
        return $this->setParameter('orderdescription', $value);
    }

    public function getTax(): ?float
    {
        return $this->getParameter('tax');
    }

    /**
     * @throws InvalidRequestException
     */
    public function setTax(string|int|float $value): self
    {
        return $this->setToDecimal('tax', $value);
    }

    public function getShipping(): ?float
    {
        return $this->getParameter('shipping');
    }

    /**
     * @throws InvalidRequestException
     */
    public function setShipping(string|int|float $value): self
    {
        return $this->setToDecimal('tax', $value);
    }

    public function getPONumber(): ?string
    {
        return $this->getParameter('ponumber');
    }

    public function setPONumber(string $value): self
    {
        return $this->setParameter('ponumber', $value);
    }

    protected function getBaseData(): array
    {
        $data = [];

        if (($this->type ?? null) !== null) {
            $data['type'] = $this->type;
        }

        if (($this->customer_vault ?? null) !== null) {
            $data['customer_vault'] = $this->customer_vault;
        }

        if ($this->getSecurityKey() !== null) {
            $data['security_key'] = $this->getSecurityKey();
        } else {
            $data['username'] = $this->getUsername();
            $data['password'] = $this->getPassword();
        }

        if ($this->getProcessorId()) {
            $data['processor_id'] = $this->getProcessorId();
        }

        if ($this->getAuthorizationCode() !== '' && $this->getAuthorizationCode() !== '0') {
            $data['authorization_code'] = $this->getAuthorizationCode();
        }

        if ($this->getDescriptor() !== '' && $this->getDescriptor() !== '0') {
            $data['descriptor'] = $this->getDescriptor();
        }

        if ($this->getDescriptorPhone() !== '' && $this->getDescriptorPhone() !== '0') {
            $data['descriptor_phone'] = $this->getDescriptorPhone();
        }

        if ($this->getDescriptorAddress() !== '' && $this->getDescriptorAddress() !== '0') {
            $data['descriptor_address'] = $this->getDescriptorAddress();
        }

        if ($this->getDescriptorCity() !== '' && $this->getDescriptorCity() !== '0') {
            $data['descriptor_city'] = $this->getDescriptorCity();
        }

        if ($this->getDescriptorState() !== '' && $this->getDescriptorState() !== '0') {
            $data['descriptor_state'] = $this->getDescriptorState();
        }

        if ($this->getDescriptorPostal() !== '' && $this->getDescriptorPostal() !== '0') {
            $data['descriptor_postal'] = $this->getDescriptorPostal();
        }

        if ($this->getDescriptorCountry() !== '' && $this->getDescriptorCountry() !== '0') {
            $data['descriptor_country'] = $this->getDescriptorCountry();
        }

        if ($this->getDescriptorMcc() !== '' && $this->getDescriptorMcc() !== '0') {
            $data['descriptor_mcc'] = $this->getDescriptorMcc();
        }

        if ($this->getDescriptorMerchantId() !== '' && $this->getDescriptorMerchantId() !== '0') {
            $data['descriptor_merchant_id'] = $this->getDescriptorMerchantId();
        }

        if ($this->getDescriptorUrl() !== '' && $this->getDescriptorUrl() !== '0') {
            $data['descriptor_url'] = $this->getDescriptorUrl();
        }

        return $data;
    }

    protected function getOrderData(): array
    {
        $data = [];

        $data['orderid'] = $this->getOrderId();
        $data['orderdescription'] = $this->getOrderDescription();
        $data['tax'] = $this->getTax();
        $data['shipping'] = $this->getShipping();
        $data['ponumber'] = $this->getPONumber();
        $data['ipaddress'] = $this->getClientIp();
        if ($this->getCurrency()) {
            $data['currency'] = $this->getCurrency();
        }

        return $data;
    }

    protected function getBillingData(): array
    {
        $data = [];

        $card = $this->getCard();

        $data['firstname'] = $card->getBillingFirstName();
        $data['lastname'] = $card->getBillingLastName();
        $data['company'] = $card->getBillingCompany();
        $data['address1'] = $card->getBillingAddress1();
        $data['address2'] = $card->getBillingAddress2();
        $data['city'] = $card->getBillingCity();
        $data['state'] = $card->getBillingState();
        $data['zip'] = $card->getBillingPostcode();
        $data['country'] = $card->getBillingCountry();
        $data['phone'] = $card->getBillingPhone();
        $data['fax'] = $card->getBillingFax();
        $data['email'] = $card->getEmail();

        return $data;
    }

    protected function getShippingData(): array
    {
        $data = [];

        $card = $this->getCard();

        $data['shipping_firstname'] = $card->getShippingFirstName();
        $data['shipping_lastname'] = $card->getShippingLastName();
        $data['shipping_company'] = $card->getShippingCompany();
        $data['shipping_address1'] = $card->getShippingAddress1();
        $data['shipping_address2'] = $card->getShippingAddress2();
        $data['shipping_city'] = $card->getShippingCity();
        $data['shipping_state'] = $card->getShippingState();
        $data['shipping_zip'] = $card->getShippingPostcode();
        $data['shipping_country'] = $card->getShippingCountry();
        $data['shipping_email'] = $card->getEmail();

        return $data;
    }

    public function sendData($data): AbstractResponse
    {
        $httpResponse = $this->httpClient->request(
            'POST',
            $this->getEndpoint(),
            ['Content-Type' => 'application/x-www-form-urlencoded'],
            http_build_query($data, '', '&')
        );

        return $this->response = new DirectPostResponse($this, $httpResponse->getBody()->getContents());
    }

    public function setEndpoint(string $value): self
    {
        return $this->setParameter('endpoint', $value);
    }

    public function getEndpoint(): ?string
    {
        return $this->getParameter('endpoint') ?: $this->endpoint;
    }

    /**
     * @throws InvalidRequestException
     */
    private function setToDecimal(string $parameter, string|int|float $value): self
    {
        if (!is_numeric($value)) {
            throw new InvalidRequestException("The {$parameter} value must be numeric.");
        }

        // Convert to float and round to two decimal places
        $processedValue = round((float) $value, 2);

        if (bccomp((string) $value, (string) $processedValue, 2) !== 0) {
            throw new InvalidRequestException("The {$parameter} value is not equivalent after rounding.");
        }

        return $this->setParameter($parameter, $processedValue);
    }
}
