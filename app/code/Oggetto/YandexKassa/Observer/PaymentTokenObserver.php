<?php
namespace Oggetto\YandexKassa\Observer;

use Magento\Framework\Event\Observer;
use Magento\Payment\Observer\AbstractDataAssignObserver;
use Magento\Quote\Api\Data\PaymentInterface;
use Oggetto\YandexKassa\Model\Ui\ConfigProvider;

class PaymentTokenObserver extends AbstractDataAssignObserver
{
    /**
     * @param Observer $observer
     * @return void
     */
    public function execute(Observer $observer)
    {
        $data = $this->readDataArgument($observer);

        $additionalData = $data->getData(PaymentInterface::KEY_ADDITIONAL_DATA);
        if (!is_array($additionalData)) {
            return;
        }

        $paymentInfo = $this->readPaymentModelArgument($observer);

        if (isset($additionalData[ConfigProvider::PAYMENT_TOKEN_FIELD])) {
            $paymentInfo->setAdditionalInformation(
                ConfigProvider::PAYMENT_TOKEN_FIELD,
                $additionalData[ConfigProvider::PAYMENT_TOKEN_FIELD]
            );
        }
    }
}