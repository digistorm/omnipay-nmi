<?php

declare(strict_types=1);

namespace Omnipay\NMI\Message;

/**
 * NMI Direct Post Credit Request
 */
class DirectPostCreditRequest extends DirectPostAuthRequest
{
    public string $type = 'credit';
}
