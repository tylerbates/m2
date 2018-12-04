<?php
namespace Oggetto\YandexKassa\Controller\Redirect;

use Magento\Framework\App\Action\{
    Action,
    Context
};
use Magento\Checkout\Model\Session;
use Magento\Framework\Controller\Result\Redirect;
use Oggetto\YandexKassa\Model\Ui\ConfigProvider;

class Index extends Action
{
    /** @var Session */
    private $session;

    public function __construct(
        Context $context,
        Session $session
    )
    {
        $this->session = $session;
        parent::__construct($context);
    }

    public function execute() : Redirect
    {
        $redirect = $this->resultRedirectFactory->create();

        if (!$this->session->getLastSuccessQuoteId() ||
            !($order = $this->session->getLastRealOrder())
        ) {
            $redirect->setPath('checkout/cart');
        } else {
            $redirectUrl = $order->getPayment()->getAdditionalInformation(
                ConfigProvider::CONFIRM_URL_FIELD
            );
            if (!$redirectUrl) {
                $redirect->setPath('checkout/onepage/success');
            } else {
                $redirect->setUrl($redirectUrl);
            }
        }

        return $redirect;
    }
}