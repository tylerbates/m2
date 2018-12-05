<?php
namespace Oggetto\YandexKassa\Gateway\Request\Builder;

use Magento\Payment\Gateway\Helper\SubjectReader;
use Magento\Sales\Model\Order\Payment;
use Oggetto\YandexKassa\Model\Ui\ConfigProvider;

class CaptureRefund extends AbstractBuilder
{
    public function build(array $buildSubject)
    {
        $paymentObject = SubjectReader::readPayment($buildSubject);
        /** @var Payment $payment */
        $payment = $paymentObject->getPayment();

        $result = [
            'amount' => [
                'value' =>  sprintf('%.2F', SubjectReader::readAmount($buildSubject)),
                'currency' => $paymentObject->getOrder()->getCurrencyCode()
            ],
            'payment_id' => $payment->getAdditionalInformation(ConfigProvider::PAYMENT_ID_FIELD)
        ];

        return $result;
    }
}