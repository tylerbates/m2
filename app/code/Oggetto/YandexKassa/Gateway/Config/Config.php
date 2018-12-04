<?php
namespace Oggetto\YandexKassa\Gateway\Config;

use Magento\Payment\Gateway\Config\Config as PaymentConfig;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Store\Model\ScopeInterface;

class Config extends PaymentConfig
{
    const XML_CONFIG_PATH = 'payment/yandex_kassa_section/yandex_kassa/';
    const COMMON_PAYMENT_CODE = 'yandex_kassa_';

    /**
     * @var ScopeConfigInterface
     */
    private $scopeConfig;

    /**
     * @var string|null
     */
    private $methodCode;

    /**
     * @var string|null
     */
    private $pathPattern;

    private $_pathPatternMap = [
        'specific' => [
            'active',
            'title',
            'sort_order',
            'ui_active'
        ],
        'general' => [
            'order_status'
        ],
        'api' => [
            'shop_id',
            'secret'
        ]
    ];

    private $types = [
        'cc' => 'bank_card'
    ];

    /**
     * @param ScopeConfigInterface $scopeConfig
     * @param string|null $methodCode
     * @param string $pathPattern
     */
    public function __construct(
        ScopeConfigInterface $scopeConfig,
        $methodCode = null,
        $pathPattern = self::DEFAULT_PATH_PATTERN
    ) {
        parent::__construct($scopeConfig, $methodCode, $pathPattern);
        $this->scopeConfig = $scopeConfig;
        $this->methodCode = $methodCode;
        $this->pathPattern = $pathPattern;
    }

    /**
     * Retrieve information from payment configuration
     *
     * @param string $field
     * @param int|null $storeId
     *
     * @return mixed
     */
    public function getValue($field, $storeId = null)
    {
        if ($this->methodCode === null || $this->pathPattern === null) {
            return null;
        }

        $path = sprintf($this->pathPattern, $this->methodCode, $field);
        foreach ($this->_pathPatternMap as $group => $keys) {
            if (in_array($field, $keys)) {
                $subPath = ($group === 'specific') ? $this->methodCode : $group;
                $path = self::XML_CONFIG_PATH . $subPath . '/' . $field;
                break;
            }
        }

        return $this->scopeConfig->getValue(
            $path,
            ScopeInterface::SCOPE_STORE,
            $storeId
        );
    }

    /**
     * Get payment type by code
     *
     * @return string
     */
    public function getPaymentType()
    {
        return $this->types[str_replace(self::COMMON_PAYMENT_CODE, '', $this->methodCode)];
    }
}