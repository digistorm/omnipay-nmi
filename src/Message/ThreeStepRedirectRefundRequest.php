<?php

declare(strict_types=1);

namespace Omnipay\NMI\Message;

/**
 * NMI Three Step Redirect Refund Request
 */
class ThreeStepRedirectRefundRequest extends ThreeStepRedirectCaptureRequest
{
    public string $type = 'refund';
}
