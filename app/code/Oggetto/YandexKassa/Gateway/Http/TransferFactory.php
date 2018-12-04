<?php
namespace Oggetto\YandexKassa\Gateway\Http;

use Magento\Payment\Gateway\Http\TransferBuilder;
use Magento\Payment\Gateway\Http\TransferFactoryInterface;
use Magento\Payment\Gateway\Http\TransferInterface;
use Oggetto\YandexKassa\Gateway\Config\Config;

class TransferFactory implements TransferFactoryInterface
{
    protected $transferBuilder;
    private $config;

    public function __construct(
        TransferBuilder $transferBuilder,
        Config $config
    )
    {
        $this->transferBuilder = $transferBuilder;
        $this->config = $config;
    }

    /**
     * Builds gateway transfer object
     *
     * @param array $request
     * @return TransferInterface
     */
    public function create(array $request)
    {
        return $this->transferBuilder
            ->setBody($request)
            ->setAuthUsername($this->config->getValue('shop_id'))
            ->setAuthPassword($this->config->getValue('secret'))
            ->build();
    }
}