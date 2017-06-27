<?php
namespace NetCents\PayGateway\Model\Ui;

use Magento\Checkout\Model\ConfigProviderInterface;
use Magento\Payment\Helper\Data as PaymentHelper;
use Magento\Store\Model\Store as Store;

/**
 * Class ConfigProvider
 */
final class ConfigProvider implements ConfigProviderInterface
{
    const CODE = 'netcents_gateway';

    protected $method;

    public function __construct(
        PaymentHelper $paymentHelper,
        Store $store
    )
    {
        $this->method = $paymentHelper->getMethodInstance(self::CODE);
        $this->store = $store;
    }

    /**
     * Retrieve assoc array of checkout configuration
     *
     * @return array
     */
    public function getConfig()
    {
        $apiKey = $this->method->getConfigData('live_api_key');
	$secretKey = $this->method->getConfigData('live_secret_key');
        if ($this->method->getConfigData('test_mode')) {
            $apiKey = $this->method->getConfigData('test_api_key');
	    $secretKey = $this->method->getConfigData('test_secret_key');
        }

	$om = \Magento\Framework\App\ObjectManager::getInstance();
	$a = $om->get('Magento\Framework\HTTP\PhpEnvironment\RemoteAddress');
	$ip = $a->getRemoteAddress();
        return [
            'payment' => [
                self::CODE => [
                    'api_key' => $apiKey,
		    'secret_key' => $secretKey,
	            'client_ip' => $ip,
                    'image' => $this->method->getConfigData('image'),
                    'description' => $this->method->getConfigData('description'),
                    'api_url' => $this->store->getBaseUrl() . 'rest/'
                ]
            ]
        ];
    }
}
