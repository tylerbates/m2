<?php
namespace Oggetto\YandexKassa\Gateway\Http\Client;

use Magento\Payment\Gateway\Http\TransferInterface;
use Magento\Payment\Gateway\Http\ClientException;

class Authorize extends AbstractClient
{
    public function placeRequest(TransferInterface $transferObject): array
    {
        $logData = ['body' => $transferObject->getBody()];
        $paymentResponse = [];

        try {
            $this->setUpAuth($transferObject);
            $paymentResponse = $this->yandexClient
                ->createPayment($transferObject->getBody(), $this->idempotenceKey)
                ->jsonSerialize();
            $logData['response'] = $paymentResponse;
        } catch (\Exception $e) {
            throw new ClientException(__($e->getMessage()));
        } finally {
            $this->logger->debug($logData);
        }

        return $paymentResponse;
    }
}