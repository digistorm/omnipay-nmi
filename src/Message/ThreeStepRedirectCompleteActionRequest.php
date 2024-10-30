<?php

declare(strict_types=1);

namespace Omnipay\NMI\Message;

use Omnipay\Common\Exception\InvalidRequestException;

/**
 * NMI Three Step Redirect Complete Request
 */
class ThreeStepRedirectCompleteActionRequest extends ThreeStepRedirectAbstractRequest
{
    public string $type = 'complete-action';

    /**
     * @throws InvalidRequestException
     */
    public function getData(): array
    {
        $this->validate('token_id');

        return [
            'api-key' => $this->getApiKey(),
            'token-id' => $this->getTokenId()
        ];
    }
}
