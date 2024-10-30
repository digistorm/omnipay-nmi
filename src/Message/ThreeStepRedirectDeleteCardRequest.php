<?php

declare(strict_types=1);

namespace Omnipay\NMI\Message;

use Omnipay\Common\Exception\InvalidRequestException;

/**
 * NMI Three Step Redirect Delete Card Request
 */
class ThreeStepRedirectDeleteCardRequest extends ThreeStepRedirectAbstractRequest
{
    public string $type = 'delete-customer';

    /**
     * @throws InvalidRequestException
     */
    public function getData(): array
    {
        $this->validate('cardReference');

        return [
            'api-key' => $this->getApiKey(),
            'redirect-url' => $this->getRedirectUrl(),
            'customer-vault-id' => $this->getCardReference()
        ];
    }
}
