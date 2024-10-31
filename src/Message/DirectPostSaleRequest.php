<?php

declare(strict_types=1);

namespace Omnipay\NMI\Message;

/**
 * NMI Direct Post Sale Request
 */
class DirectPostSaleRequest extends DirectPostAuthRequest
{
    public string $type = 'sale';
}
