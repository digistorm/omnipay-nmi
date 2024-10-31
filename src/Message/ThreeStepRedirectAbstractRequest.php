<?php

declare(strict_types=1);

namespace Omnipay\NMI\Message;

use Exception;
use InvalidArgumentException;
use Omnipay\Common\CreditCard;
use Omnipay\Common\Message\AbstractResponse;
use Psr\Http\Message\ResponseInterface;
use RuntimeException;
use SimpleXMLElement;

/**
 * NMI Three Step Redirect Abstract Request
 */
abstract class ThreeStepRedirectAbstractRequest extends AbstractRequest
{
    public string $type;

    protected string $endpoint = 'https://secure.nmi.com/api/v2/three-step';

    public function getApiKey(): ?string
    {
        return $this->getParameter('api_key');
    }

    public function setApiKey(string $value): self
    {
        return $this->setParameter('api_key', $value);
    }

    public function getRedirectUrl(): ?string
    {
        return $this->getParameter('redirect_url');
    }

    public function setRedirectUrl(string $value): self
    {
        return $this->setParameter('redirect_url', $value);
    }

    public function getTokenId(): ?string
    {
        return $this->getParameter('token_id');
    }

    public function setTokenId(string $value): self
    {
        return $this->setParameter('token_id', $value);
    }

    /**
     * Sets the card.
     */
    public function setCard(mixed $value): self
    {
        if (!$value instanceof CreditCard) {
            $value = new CreditCard($value);
        }

        return $this->setParameter('card', $value);
    }

    public function getSecCode(): ?string
    {
        return $this->getParameter('sec_code');
    }

    public function setSecCode(string $value): self
    {
        return $this->setParameter('sec_code', $value);
    }

    public function getMerchantDefinedField_1(): ?string
    {
        return $this->getParameter('merchant_defined_field_1');
    }

    /**
     * Sets the first merchant defined field.
     */
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

    protected function getOrderData(): array
    {
        $data = [];

        $data['order-id'] = $this->getOrderId();
        $data['order-description'] = $this->getOrderDescription();
        $data['tax-amount'] = $this->getTax();
        $data['shipping-amount'] = $this->getShipping();
        $data['po-number'] = $this->getPONumber();
        $data['ip-address'] = $this->getClientIp();

        if ($this->getCurrency()) {
            $data['currency'] = $this->getCurrency();
        }

        if ($this->getSecCode() !== '' && $this->getSecCode() !== '0') {
            $data['sec-code'] = $this->getSecCode();
        }

        return $data;
    }

    protected function getBillingData(): array
    {
        $data = [];

        $card = $this->getCard();

        $data['billing'] = [
            'first-name' => $card->getBillingFirstName(),
            'last-name' => $card->getBillingLastName(),
            'address1' => $card->getBillingAddress1(),
            'city' => $card->getBillingCity(),
            'state' => $card->getBillingState(),
            'postal' => $card->getBillingPostcode(),
            'country' => $card->getBillingCountry(),
            'phone' => $card->getBillingPhone(),
            'email' => $card->getEmail(),
            'company' => $card->getBillingCompany(),
            'address2' => $card->getBillingAddress2(),
            'fax' => $card->getBillingFax()
        ];

        return $data;
    }

    protected function getShippingData(): array
    {
        $data = [];

        $card = $this->getCard();
        $data['shipping'] = [
            'first-name' => $card->getShippingFirstName(),
            'last-name' => $card->getShippingLastName(),
            'address1' => $card->getShippingAddress1(),
            'city' => $card->getShippingCity(),
            'state' => $card->getShippingState(),
            'postal' => $card->getShippingPostcode(),
            'country' => $card->getShippingCountry(),
            'email' => $card->getEmail(),
            'company' => $card->getShippingCompany(),
            'address2' => $card->getShippingAddress2()
        ];

        return $data;
    }

    public function sendData(mixed $data): AbstractResponse
    {
        $document = new SimpleXMLElement('<?xml version="1.0" encoding="UTF-8"?><' . $this->type . '/>');
        $this->arrayToXml($document, $data);

        $httpResponse = $this->httpClient->request(
            'POST',
            $this->getEndpoint(),
            ['Content-Type' => 'text/xml', 'User-Agent' => 'Omnipay'],
            $document->asXML() ?: null,
        );

        $xml = static::xmlDecode($httpResponse);

        return $this->response = new ThreeStepRedirectResponse($this, $xml);
    }

    /**
     * Parse the XML response body and return a \SimpleXMLElement.
     *
     * In order to prevent XXE attacks, this method disables loading external
     * entities. If you rely on external entities, then you must parse the
     * XML response manually by accessing the response body directly.
     *
     * Copied from Response->xml() in Guzzle3 (copyright @mtdowling)
     * @link https://github.com/guzzle/guzzle3/blob/v3.9.3/src/Guzzle/Http/Message/Response.php
     * @throws RuntimeException if the response body is not in XML format
     * @link http://websec.io/2012/08/27/Preventing-XXE-in-PHP.html
     */
    public static function xmlDecode(string|ResponseInterface $response): SimpleXMLElement
    {
        $body = $response instanceof ResponseInterface ? $response->getBody()->__toString() : $response;

        $xml = null;
        $errorMessage = null;
        $internalErrors = libxml_use_internal_errors(true);
        libxml_clear_errors();

        try {
            $xml = new SimpleXMLElement((string) $body ?: '<root />', LIBXML_NONET);
        } catch (Exception $e) {
            $errorMessage = $e->getMessage();
        }

        libxml_clear_errors();
        libxml_use_internal_errors($internalErrors);

        if ($errorMessage !== null) {
            throw new InvalidArgumentException('SimpleXML error: ' . $errorMessage);
        }

        return $xml;
    }

    private function arrayToXml(SimpleXMLElement $parent, array $data): void
    {
        foreach ($data as $name => $value) {
            if (is_array($value)) {
                $child = $parent->addChild($name);
                $this->arrayToXml($child, $value);
            } else {
                $parent->addChild($name, htmlspecialchars((string) $value));
            }
        }
    }
}
