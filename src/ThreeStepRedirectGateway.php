<?php

declare(strict_types=1);

namespace Omnipay\NMI;

use Omnipay\Common\Message\AbstractRequest;
use Omnipay\NMI\Message\ThreeStepRedirectAuthRequest;
use Omnipay\NMI\Message\ThreeStepRedirectCaptureRequest;
use Omnipay\NMI\Message\ThreeStepRedirectCompleteActionRequest;
use Omnipay\NMI\Message\ThreeStepRedirectCreateCardRequest;
use Omnipay\NMI\Message\ThreeStepRedirectCreditRequest;
use Omnipay\NMI\Message\ThreeStepRedirectDeleteCardRequest;
use Omnipay\NMI\Message\ThreeStepRedirectRefundRequest;
use Omnipay\NMI\Message\ThreeStepRedirectSaleRequest;
use Omnipay\NMI\Message\ThreeStepRedirectUpdateCardRequest;
use Omnipay\NMI\Message\ThreeStepRedirectVoidRequest;

/**
 * NMI Three Step Redirect Gateway
 *
 * @link https://www.nmi.com/
 * @link https://gateway.perpetualpayments.com/merchants/resources/integration/integration_portal.php
 */
class ThreeStepRedirectGateway extends DirectPostGateway
{
    public function getName(): string
    {
        return 'NMI Three Step Redirect';
    }

    public function getDefaultParameters(): array
    {
        return ['api_key' => '', 'redirect_url' => '', 'endpoint' => ''];
    }

    public function getApiKey(): string
    {
        return $this->getParameter('api_key');
    }

    public function setApiKey(string $value): self
    {
        return $this->setParameter('api_key', $value);
    }

    public function getRedirectUrl(): string
    {
        return $this->getParameter('redirect_url');
    }

    public function setRedirectUrl(string $value): self
    {
        return $this->setParameter('redirect_url', $value);
    }

    /**
     * Transaction sales are submitted and immediately flagged for settlement.
     */
    public function sale(array $options = []): AbstractRequest
    {
        return $this->createRequest(ThreeStepRedirectSaleRequest::class, $options);
    }

    /**
     * Transaction authorizations are authorized immediately but are not flagged
     * for settlement. These transactions must be flagged for settlement using
     * the capture transaction type. Authorizations typically remain active for
     * three to seven business days.
     */
    public function auth(array $options = []): AbstractRequest
    {
        return $this->createRequest(ThreeStepRedirectAuthRequest::class, $options);
    }

    /**
     * Transaction captures flag existing authorizations for settlement.
     * Only authorizations can be captured. Captures can be submitted for an
     * amount equal to or less than the original authorization.
     */
    public function capture(array $options = []): AbstractRequest
    {
        return $this->createRequest(ThreeStepRedirectCaptureRequest::class, $options);
    }

    /**
     * Transaction voids will cancel an existing sale or captured authorization.
     * In addition, non-captured authorizations can be voided to prevent any
     * future capture. Voids can only occur if the transaction has not been settled.
     */
    public function void(array $options = []): AbstractRequest
    {
        return $this->createRequest(ThreeStepRedirectVoidRequest::class, $options);
    }

    /**
     * Transaction refunds will reverse a previously settled transaction. If the
     * transaction has not been settled, it must be voided instead of refunded.
     */
    public function refund(array $options = []): AbstractRequest
    {
        return $this->createRequest(ThreeStepRedirectRefundRequest::class, $options);
    }

    /**
     * Transaction credits apply an amount to the cardholder's card that was not
     * originally processed through the Gateway. In most situations credits are
     * disabled as transaction refunds should be used instead.
     */
    public function credit(array $options = []): AbstractRequest
    {
        return $this->createRequest(ThreeStepRedirectCreditRequest::class, $options);
    }

    public function createCard(array $options = []): AbstractRequest
    {
        return $this->createRequest(ThreeStepRedirectCreateCardRequest::class, $options);
    }

    public function updateCard(array $options = []): AbstractRequest
    {
        return $this->createRequest(ThreeStepRedirectUpdateCardRequest::class, $options);
    }

    public function deleteCard(array $options = []): AbstractRequest
    {
        return $this->createRequest(ThreeStepRedirectDeleteCardRequest::class, $options);
    }

    public function completeAction(array $options = []): AbstractRequest
    {
        return $this->createRequest(ThreeStepRedirectCompleteActionRequest::class, $options);
    }
}
