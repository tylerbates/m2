<?php
namespace Oggetto\YandexKassa\Gateway\Http\Client;

use Magento\Payment\Gateway\Http\ClientInterface;
use Magento\Payment\Gateway\Http\TransferInterface;
use Magento\Payment\Model\Method\Logger;
use YandexCheckout\Client as YMClient;

class AbstractClient implements ClientInterface
{
    protected $logger;
    protected $yandexClient;
    protected $idempotenceKey;

    public function __construct(
        Logger $logger
    ) {
        $this->logger = $logger;
        $this->yandexClient = new YMClient();
        $this->idempotenceKey = uniqid('', true);
    }

    public function placeRequest(TransferInterface $transferObject){}

    protected function setUpAuth(TransferInterface $transferObject)
    {
        $this->yandexClient->setAuth(
            $transferObject->getAuthUsername(),
            $transferObject->getAuthPassword()
        );
    }
}