<?php

declare(strict_types=1);

namespace Omnipay\NMI\Message;

use Omnipay\Common\Exception\InvalidRequestException;

/**
 * NMI Three Step Redirect Void Request
 */
class ThreeStepRedirectVoidRequest extends ThreeStepRedirectAbstractRequest
{
    public string $type = 'void';

    /**
     * @throws InvalidRequestException
     */
    public function getData(): array
    {
        $this->validate('transactionReference');

        $data = ['api-key' => $this->getApiKey(), 'transaction-id' => $this->getTransactionReference()];

        if ($this->getMerchantDefinedField_1() !== '' && $this->getMerchantDefinedField_1() !== '0') {
            $data['merchant-defined-field-1'] = $this->getMerchantDefinedField_1();
        }

        if ($this->getMerchantDefinedField_2() !== '' && $this->getMerchantDefinedField_2() !== '0') {
            $data['merchant-defined-field-2'] = $this->getMerchantDefinedField_2();
        }

        if ($this->getMerchantDefinedField_3() !== '' && $this->getMerchantDefinedField_3() !== '0') {
            $data['merchant-defined-field-3'] = $this->getMerchantDefinedField_3();
        }

        if ($this->getMerchantDefinedField_4()) {
            $data['merchant-defined-field-4'] = $this->getMerchantDefinedField_4();
        }

        return $data;
    }
}
