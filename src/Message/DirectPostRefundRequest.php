<?php

declare(strict_types=1);

namespace Omnipay\NMI\Message;

/**
 * NMI Direct Post Refund Request
 */
class DirectPostRefundRequest extends DirectPostCaptureRequest
{
    public string $type = 'refund';
}
