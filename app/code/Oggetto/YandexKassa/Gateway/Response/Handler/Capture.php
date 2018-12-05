<?php
namespace Oggetto\YandexKassa\Gateway\Response\Handler;

use Magento\Payment\Gateway\Response\HandlerInterface;
use Magento\Payment\Gateway\Helper\SubjectReader;
use Magento\Sales\Model\Order;
use YandexCheckout\Model\PaymentStatus;

class Capture implements HandlerInterface
{
    public function handle(array $handlingSubject, array $response)
    {
        $paymentObject = SubjectReader::readPayment($handlingSubject);
        /** @var Order\Payment $payment */
        $payment = $paymentObject->getPayment();

        if (isset($response['status']) && ($response['status'] === PaymentStatus::SUCCEEDED)) {
            $payment->setParentTransactionId($response['id']);
        }
    }
}