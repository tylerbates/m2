<?php
namespace Oggetto\YandexKassa\Gateway\Response\Handler;

use Magento\Payment\Gateway\Response\HandlerInterface;
use Magento\Payment\Gateway\Helper\SubjectReader;
use Oggetto\YandexKassa\Model\Ui\ConfigProvider;
use Magento\Sales\Model\Order\Payment;

class Authorize implements HandlerInterface
{
    public function handle(array $handlingSubject, array $response)
    {
        $paymentDataObject = SubjectReader::readPayment($handlingSubject);
        if (isset($response['id'])) {
            /** @var Payment $payment */
            $payment = $paymentDataObject->getPayment();
            $payment->setTransactionId($response['id'])
                ->setIsTransactionPending(true);
        }
        if (
            isset($response['confirmation']) &&
            ($confirmUrl = $response['confirmation'][ConfigProvider::CONFIRM_URL_FIELD])
        ) {
            $paymentDataObject->getPayment()->setAdditionalInformation(
                ConfigProvider::CONFIRM_URL_FIELD,
                $confirmUrl
            );
        }
    }
}