<?php
namespace NetCents\PayGateway\Api;

interface PaymentInterface
{
    /**
     * @param string $token
     * @return bool
     */
    public function verifyPayment(
        $token
    );
}
