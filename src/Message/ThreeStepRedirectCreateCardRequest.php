<?php

declare(strict_types=1);

namespace Omnipay\NMI\Message;

use Omnipay\Common\Exception\InvalidRequestException;

/**
 * NMI Three Step Redirect Create Card Request
 */
class ThreeStepRedirectCreateCardRequest extends ThreeStepRedirectAbstractRequest
{
    public string $type = 'add-customer';

    /**
     * @throws InvalidRequestException
     */
    public function getData(): array
    {
        $this->validate('card');

        $data = ['api-key' => $this->getApiKey(), 'redirect-url' => $this->getRedirectUrl()];

        return array_merge(
            $data,
            $this->getBillingData(),
            $this->getShippingData()
        );
    }
}
