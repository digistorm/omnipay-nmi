<?php

declare(strict_types=1);

namespace Omnipay\NMI\Message;

use Omnipay\Common\Exception\InvalidRequestException;

/**
 * NMI Three Step Redirect Update Card Request
 */
class ThreeStepRedirectUpdateCardRequest extends ThreeStepRedirectCreateCardRequest
{
    public string $type = 'update-customer';

    /**
     * @throws InvalidRequestException
     */
    public function getData(): array
    {
        $data = parent::getData();

        $this->validate('cardReference');

        $data['customer-vault-id'] = $this->getCardReference();

        return $data;
    }
}
