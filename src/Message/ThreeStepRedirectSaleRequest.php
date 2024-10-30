<?php

declare(strict_types=1);

namespace Omnipay\NMI\Message;

/**
 * NMI Three Step Redirect Sale Request
 */
class ThreeStepRedirectSaleRequest extends ThreeStepRedirectAuthRequest
{
    public string $type = 'sale';
}
