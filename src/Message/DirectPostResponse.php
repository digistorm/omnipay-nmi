<?php

declare(strict_types=1);

namespace Omnipay\NMI\Message;

use Omnipay\Common\Message\AbstractResponse;
use Omnipay\Common\Message\RequestInterface;

/**
 * NMI Direct Post Response
 */
class DirectPostResponse extends AbstractResponse
{
    public function __construct(RequestInterface $request, $data)
    {
        parent::__construct($request, $data);
        $this->request = $request;
        parse_str((string) $data, $this->data);
    }

    public function isSuccessful(): bool
    {
        return $this->getCode() === '1';
    }

    public function getCode(): ?string
    {
        return trim((string) $this->data['response']);
    }

    public function getResponseCode(): ?string
    {
        return trim((string) $this->data['response_code']);
    }

    public function getMessage(): ?string
    {
        return trim((string) $this->data['responsetext']);
    }

    public function getAuthorizationCode(): ?string
    {
        return trim((string) $this->data['authcode']);
    }

    public function getAVSResponse(): ?string
    {
        return trim((string) $this->data['avsresponse']);
    }

    public function getCVVResponse(): ?string
    {
        return trim((string) $this->data['cvvresponse']);
    }

    public function getOrderId(): ?string
    {
        return trim((string) $this->data['orderid']);
    }

    public function getTransactionReference(): ?string
    {
        return trim((string) $this->data['transactionid']);
    }

    public function getCardReference(): ?string
    {
        if (isset($this->data['customer_vault_id'])) {
            return trim((string) $this->data['customer_vault_id']);
        }

        return null;
    }
}
