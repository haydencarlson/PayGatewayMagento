<?php
namespace NetCents\PayGateway\Model;

use Magento\Payment\Helper\Data as PaymentHelper;

class Payment implements \NetCents\PayGateway\Api\PaymentInterface
{
    const CODE = 'netcents_gateway';

    protected $config;

    public function __construct(
        PaymentHelper $paymentHelper
    )
    {
        $this->config = $paymentHelper->getMethodInstance(self::CODE);
    }

    /**
     * @return bool
     */
    public function verifyPayment($token)
    {
        $apiKey = $this->config->getConfigData('live_api_key');
        $secretKey = $this->config->getConfigData('live_secret_key');
        if ($this->config->getConfigData('test_mode')) {
            $apiKey = $this->config->getConfigData('test_api_key');
	    $secretKey = $this->config->getConfigData('test_secret_key');
        } 

        
        $data = array(
            'token' => $token,
        );

        $dataString = json_encode($data);

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, 'https://merchant.net-cents.com/api/v1/magento/verify');
        curl_setopt($ch, CURLOPT_USERPWD, $apiKey . ':' . $secretKey);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $dataString);
        curl_setopt($ch, CURLOPT_HEADER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Content-Length: ' . strlen($dataString)
        ));

        $curlResponse = curl_exec($ch);
        $curlResponse = preg_split("/\r\n\r\n/", $curlResponse);
        $responseContent = $curlResponse[1];
        $jsonResponse = json_decode(chop($responseContent), true);
        $responseCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        curl_close($ch);

        if ($responseCode == '200') {
            return true;

        }
        
        return false;
    }
}
