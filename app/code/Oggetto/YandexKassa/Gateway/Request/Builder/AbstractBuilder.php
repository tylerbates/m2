<?php
namespace Oggetto\YandexKassa\Gateway\Request\Builder;

use Magento\Payment\Gateway\Helper\SubjectReader;
use Magento\Payment\Gateway\Request\BuilderInterface;
use Magento\Framework\UrlInterface;
use Oggetto\YandexKassa\Gateway\Config\Config;
use Oggetto\YandexKassa\Model\Ui\ConfigProvider;

class AbstractBuilder implements BuilderInterface
{
    protected $config;
    protected $urlBuilder;

    public function __construct(
        UrlInterface $urlBuilder,
        Config $config
    ) {
        $this->urlBuilder = $urlBuilder;
        $this->config = $config;
    }

    public function build(array $buildSubject){}
}