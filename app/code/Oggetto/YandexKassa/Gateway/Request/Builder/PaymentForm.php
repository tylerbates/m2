<?php
namespace Oggetto\YandexKassa\Gateway\Request\Builder;

use Magento\Payment\Gateway\Helper\SubjectReader;
use Oggetto\YandexKassa\Model\Ui\ConfigProvider;

class PaymentForm extends AbstractBuilder
{
    public function build(array $buildSubject)
    {
        $payment = SubjectReader::readPayment($buildSubject);

        $order = $payment->getOrder();

        $result = [
            'amount' => [
                'value' => sprintf('%.2F', SubjectReader::readAmount($buildSubject)),
                'currency' => $order->getCurrencyCode()
            ],
            'payment_method_data' => [
                'type' => $this->config->getPaymentType()
            ],
            'confirmation' => [
                'type' => 'redirect',
                'return_url' => $this->urlBuilder->getUrl('checkout/onepage/success')
            ],
            'capture' => false,
            'description' => $order->getOrderIncrementId()
        ];

        if ($paymentToken = $payment->getPayment()->getAdditionalInformation(ConfigProvider::PAYMENT_TOKEN_FIELD)) {
            unset($result['payment_method_data']);
            $result[ConfigProvider::PAYMENT_TOKEN_FIELD] = $paymentToken;
        }

        return $result;
    }
}