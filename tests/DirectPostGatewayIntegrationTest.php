<?php

declare(strict_types=1);

namespace Omnipay\NMI;

use Omnipay\Tests\TestCase;

/**
 * Class DirectPostGatewayIntegrationTest
 *
 * Tests the driver implementation by actually communicating with NMI using their demo account
 */
class DirectPostGatewayIntegrationTest extends TestCase
{
    /** @var DirectPostGateway */
    protected $gateway;

    /** @var array */
    protected $purchaseOptions;

    /**
     * Instantiate the gateway and the populate the purchaseOptions array
     */
    public function setUp(): void
    {
        $this->gateway = new DirectPostGateway();
        $this->gateway->setUsername('demo');
        $this->gateway->setPassword('password');

        $this->purchaseOptions = ['amount' => '10.00', 'card' => $this->getValidCard()];
    }

    /**
     * Test an authorize transaction followed by a capture
     */
    public function testAuthorizeCapture(): void
    {
        $response = $this->gateway->authorize($this->purchaseOptions)->send();

        $this->assertTrue($response->isSuccessful());
        $this->assertEquals('SUCCESS', $response->getMessage());

        $captureResponse = $this->gateway->capture(['amount' => '10.00', 'transactionReference' => $response->getTransactionReference()])->send();

        $this->assertTrue($captureResponse->isSuccessful());
        $this->assertEquals('SUCCESS', $captureResponse->getMessage());
    }

    /**
     * Test a purchase transaction followed by a refund
     */
    public function testPurchaseRefund(): void
    {
        $response = $this->gateway->purchase($this->purchaseOptions)->send();

        $this->assertTrue($response->isSuccessful());
        $this->assertEquals('SUCCESS', $response->getMessage());

        $refundResponse = $this->gateway->refund(['transactionReference' => $response->getTransactionReference()])->send();

        $this->assertTrue($refundResponse->isSuccessful());
        $this->assertEquals('SUCCESS', $refundResponse->getMessage());
    }

    /**
     * Test a purchase transaction followed by a void
     */
    public function testPurchaseVoid(): void
    {
        $response = $this->gateway->purchase($this->purchaseOptions)->send();

        $this->assertTrue($response->isSuccessful());
        $this->assertEquals('SUCCESS', $response->getMessage());

        $voidResponse = $this->gateway->void(['transactionReference' => $response->getTransactionReference()])->send();

        $this->assertTrue($voidResponse->isSuccessful());
        $this->assertEquals('Transaction Void Successful', $voidResponse->getMessage());
    }
}
