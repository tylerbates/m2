<?php
namespace Oggetto\YandexKassa\Gateway\Response\Handler;

use Magento\Payment\Gateway\Response\HandlerInterface;
use Magento\Payment\Gateway\Helper\SubjectReader;
use Oggetto\YandexKassa\Model\Ui\ConfigProvider;
use Magento\Sales\Model\Order\Payment;
use \Exception;
use YandexCheckout\Model\PaymentStatus;

class Authorize implements HandlerInterface
{
    public function handle(array $handlingSubject, array $response)
    {
        $paymentDataObject = SubjectReader::readPayment($handlingSubject);
        /** @var Payment $payment */
        $payment = $paymentDataObject->getPayment();
        if ($response['status'] === PaymentStatus::CANCELED) {
            throw new Exception(__($response['cancellation_details']['reason']));
        }
        if (isset($response['id'])) {
            $payment
                ->setAdditionalInformation(ConfigProvider::PAYMENT_ID_FIELD, $response['id'])
                ->setTransactionId($response['id'])
                ->setIsTransactionPending(true);
        }
        if (
            isset($response['confirmation']) &&
            ($confirmUrl = $response['confirmation'][ConfigProvider::CONFIRM_URL_FIELD])
        ) {
            $payment->setAdditionalInformation(
                ConfigProvider::CONFIRM_URL_FIELD,
                $confirmUrl
            );
        }
    }
}