<?php

declare(strict_types=1);

namespace Omnipay\NMI\Message;

use Omnipay\Common\Message\AbstractResponse;
use Omnipay\Common\Message\RequestInterface;
use SimpleXMLElement;

/**
 * NMI Three Step Redirect Response
 */
class ThreeStepRedirectResponse extends AbstractResponse
{
    public function __construct(RequestInterface $request, SimpleXMLElement $data)
    {
        parent::__construct($request, $data);
    }

    public function isSuccessful(): bool
    {
        return $this->getCode() === '1';
    }

    public function getCode(): ?string
    {
        return trim((string) $this->data->{'result'});
    }

    public function getResponseCode(): ?string
    {
        return trim((string) $this->data->{'result-code'});
    }

    public function getMessage(): ?string
    {
        return trim((string) $this->data->{'result-text'});
    }

    public function getAuthorizationCode(): ?string
    {
        return trim((string) $this->data->{'authorization-code'});
    }

    public function getAVSResponse(): ?string
    {
        return trim((string) $this->data->{'avs-result'});
    }

    public function getCVVResponse(): ?string
    {
        return trim((string) $this->data->{'cvv-result'});
    }

    public function getOrderId(): ?string
    {
        return trim((string) $this->data->{'order-id'});
    }

    public function getTransactionReference(): ?string
    {
        return trim((string) $this->data->{'transaction-id'});
    }

    public function getCardReference(): ?string
    {
        if (isset($this->data->{'customer-vault-id'})) {
            return trim((string) $this->data->{'customer-vault-id'});
        }

        return null;
    }

    public function getFormUrl(): ?string
    {
        if (isset($this->data->{'form-url'})) {
            return trim((string) $this->data->{'form-url'});
        }

        return null;
    }
}
