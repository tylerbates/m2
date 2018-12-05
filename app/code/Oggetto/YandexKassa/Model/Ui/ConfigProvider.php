<?php
namespace Oggetto\YandexKassa\Model\Ui;

use Magento\Catalog\Model\Product\Url;
use Magento\Checkout\Model\ConfigProviderInterface;
use Magento\Payment\Gateway\ConfigInterface;
use Magento\Framework\UrlInterface;

class ConfigProvider implements ConfigProviderInterface
{
    const CODE_CC = 'yandex_kassa_cc';
    const CODE_YM = 'yandex_kassa_ym';
    const PAYMENT_TOKEN_FIELD = 'payment_token';
    const CONFIRM_URL_FIELD = 'confirmation_url';
    const PAYMENT_ID_FIELD = 'payment_id';

    /** @var ConfigInterface */
    protected $config;

    /** @var string */
    protected $code;

    /** @var UrlInterface */
    private $urlBuilder;

    public function __construct(
        ConfigInterface $config,
        string $code,
        UrlInterface $urlBuilder
    ) {
        $this->config = $config;
        $this->code = $code;
        $this->urlBuilder = $urlBuilder;
    }

    /**
     * {@inheritdoc}
     */
    public function getConfig(): array
    {
        return [
            'payment' => [
                $this->code => [
                    'code' => $this->code,
                    'title' => $this->config->getValue('title'),
                    'isActive' => $this->config->getValue('active'),
                    'redirectUrl' => $this->urlBuilder->getUrl('ykassa/redirect'),
                    'uiEnabled' => (bool) $this->config->getValue('ui_active'),
                    'shopId' => $this->config->getValue('shop_id')
                ],
            ]
        ];
    }
}