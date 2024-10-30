<?php

declare(strict_types=1);

namespace Omnipay\NMI\Message;

/**
 * NMI Direct Post Update Card Request
 */
class DirectPostUpdateCardRequest extends DirectPostCreateCardRequest
{
    public string $customer_vault = 'update_customer';
}
