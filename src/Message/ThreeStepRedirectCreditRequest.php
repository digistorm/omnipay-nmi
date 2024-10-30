<?php

declare(strict_types=1);

namespace Omnipay\NMI\Message;

/**
 * NMI Three Step Redirect Credit Request
 */
class ThreeStepRedirectCreditRequest extends ThreeStepRedirectAuthRequest
{
    public string $type = 'credit';
}
