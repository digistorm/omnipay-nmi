<?php

declare(strict_types=1);

namespace Omnipay\NMI;

use Omnipay\Common\AbstractGateway;
use Omnipay\Common\Message\AbstractRequest;
use Omnipay\NMI\Message\DirectPostAuthRequest;
use Omnipay\NMI\Message\DirectPostCaptureRequest;
use Omnipay\NMI\Message\DirectPostCreateCardRequest;
use Omnipay\NMI\Message\DirectPostCreditRequest;
use Omnipay\NMI\Message\DirectPostDeleteCardRequest;
use Omnipay\NMI\Message\DirectPostRefundRequest;
use Omnipay\NMI\Message\DirectPostSaleRequest;
use Omnipay\NMI\Message\DirectPostUpdateCardRequest;
use Omnipay\NMI\Message\DirectPostVoidRequest;

/**
 * NMI Direct Post Gateway
 *
 * @link https://www.nmi.com/
 * @link https://gateway.perpetualpayments.com/merchants/resources/integration/integration_portal.php
 */
class DirectPostGateway extends AbstractGateway
{
    public function getName(): string
    {
        return 'NMI Direct Post';
    }

    public function getDefaultParameters(): array
    {
        return [];
    }

    public function getUsername(): string
    {
        return $this->getParameter('username');
    }

    public function setUsername(string $value): self
    {
        return $this->setParameter('username', $value);
    }

    public function getPassword(): string
    {
        return $this->getParameter('password');
    }

    public function setPassword(string $value): self
    {
        return $this->setParameter('password', $value);
    }

    public function getSecurityKey(): string
    {
        return $this->getParameter('security_key');
    }

    public function setSecurityKey(string $value): self
    {
        return $this->setParameter('security_key', $value);
    }

    public function getProcessorId(): string
    {
        return $this->getParameter('processor_id');
    }

    public function setProcessorId(string $value): self
    {
        return $this->setParameter('processor_id', $value);
    }

    public function getAuthorizationCode(): string
    {
        return $this->getParameter('authorization_code');
    }

    public function setAuthorizationCode(string $value): self
    {
        return $this->setParameter('authorization_code', $value);
    }

    public function getDescriptor(): string
    {
        return $this->getParameter('descriptor');
    }

    public function setDescriptor(string $value): self
    {
        return $this->setParameter('descriptor', $value);
    }

    public function getDescriptorPhone(): string
    {
        return $this->getParameter('descriptor_phone');
    }

    public function setDescriptorPhone(string $value): self
    {
        return $this->setParameter('descriptor_phone', $value);
    }

    public function getDescriptorAddress(): string
    {
        return $this->getParameter('descriptor_address');
    }

    public function setDescriptorAddress(string $value): self
    {
        return $this->setParameter('descriptor_address', $value);
    }

    public function getDescriptorCity(): string
    {
        return $this->getParameter('descriptor_city');
    }

    public function setDescriptorCity(string $value): self
    {
        return $this->setParameter('descriptor_city', $value);
    }

    public function getDescriptorState(): string
    {
        return $this->getParameter('descriptor_state');
    }

    public function setDescriptorState(string $value): self
    {
        return $this->setParameter('descriptor_state', $value);
    }

    public function getDescriptorPostal(): string
    {
        return $this->getParameter('descriptor_postal');
    }

    public function setDescriptorPostal(string $value): self
    {
        return $this->setParameter('descriptor_postal', $value);
    }

    public function getDescriptorCountry(): string
    {
        return $this->getParameter('descriptor_country');
    }

    public function setDescriptorCountry(string $value): self
    {
        return $this->setParameter('descriptor_country', $value);
    }

    public function getDescriptorMcc(): string
    {
        return $this->getParameter('descriptor_mcc');
    }

    public function setDescriptorMcc(string $value): self
    {
        return $this->setParameter('descriptor_mcc', $value);
    }

    public function getDescriptorMerchantId(): string
    {
        return $this->getParameter('descriptor_merchant_id');
    }

    public function setDescriptorMerchantId(string $value): self
    {
        return $this->setParameter('descriptor_merchant_id', $value);
    }

    public function getDescriptorUrl(): string
    {
        return $this->getParameter('descriptor_url');
    }

    public function setDescriptorUrl(string $value): self
    {
        return $this->setParameter('descriptor_url', $value);
    }

    public function getEndpoint(): string
    {
        return $this->getParameter('endpoint');
    }

    public function setEndpoint(string $value): self
    {
        return $this->setParameter('endpoint', $value);
    }

    public function purchase(array $options = []): AbstractRequest
    {
        return $this->sale($options);
    }

    public function authorize(array $options = []): AbstractRequest
    {
        return $this->auth($options);
    }

    /**
     * Transaction sales are submitted and immediately flagged for settlement.
     */
    public function sale(array $options = []): AbstractRequest
    {
        return $this->createRequest(DirectPostSaleRequest::class, $options);
    }

    /**
     * Transaction authorizations are authorized immediately but are not flagged
     * for settlement. These transactions must be flagged for settlement using
     * the capture transaction type. Authorizations typically remain active for
     * three to seven business days.
     */
    public function auth(array $options = []): AbstractRequest
    {
        return $this->createRequest(DirectPostAuthRequest::class, $options);
    }

    /**
     * Transaction captures flag existing authorizations for settlement.
     * Only authorizations can be captured. Captures can be submitted for an
     * amount equal to or less than the original authorization.
     */
    public function capture(array $options = []): AbstractRequest
    {
        return $this->createRequest(DirectPostCaptureRequest::class, $options);
    }

    /**
     * Transaction voids will cancel an existing sale or captured authorization.
     * In addition, non-captured authorizations can be voided to prevent any
     * future capture. Voids can only occur if the transaction has not been settled.
     */
    public function void(array $options = []): AbstractRequest
    {
        return $this->createRequest(DirectPostVoidRequest::class, $options);
    }

    /**
     * Transaction refunds will reverse a previously settled transaction. If the
     * transaction has not been settled, it must be voided instead of refunded.
     */
    public function refund(array $options = []): AbstractRequest
    {
        return $this->createRequest(DirectPostRefundRequest::class, $options);
    }

    /**
     * Transaction credits apply an amount to the cardholder's card that was not
     * originally processed through the Gateway. In most situations credits are
     * disabled as transaction refunds should be used instead.
     */
    public function credit(array $options = []): AbstractRequest
    {
        return $this->createRequest(DirectPostCreditRequest::class, $options);
    }

    public function createCard(array $options = []): AbstractRequest
    {
        return $this->createRequest(DirectPostCreateCardRequest::class, $options);
    }

    public function updateCard(array $options = []): AbstractRequest
    {
        return $this->createRequest(DirectPostUpdateCardRequest::class, $options);
    }

    public function deleteCard(array $options = []): AbstractRequest
    {
        return $this->createRequest(DirectPostDeleteCardRequest::class, $options);
    }
}
