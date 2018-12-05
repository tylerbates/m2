<?php
namespace Oggetto\YandexKassa\Controller\Capture;

use Magento\Framework\App\Action\{
    Action,
    Context
};
use Magento\Sales\Model\OrderFactory;
use Magento\Framework\Webapi\Exception;
use Magento\Framework\Controller\Result\JsonFactory;
use Magento\Framework\Json\Helper\Data;
use Magento\Sales\Model\Order\Payment\Transaction;
use Magento\Sales\Model\OrderRepository;
use YandexCheckout\Model\NotificationEventType;
use YandexCheckout\Model\Notification\NotificationWaitingForCapture;
use Magento\Sales\Model\Order;

class Index extends Action
{
    protected $jsonResultFactory;
    protected $orderFactory;
    protected $orderRepository;
    protected $jsonHelper;

    public function __construct(
        Context $context,
        JsonFactory $jsonResultFactory,
        OrderFactory $orderFactory,
        OrderRepository $orderRepository,
        Data $jsonHelper
    )
    {
        $this->jsonHelper = $jsonHelper;
        $this->jsonResultFactory = $jsonResultFactory;
        $this->orderFactory = $orderFactory;
        $this->orderRepository = $orderRepository;
        parent::__construct($context);
    }

    public function execute()
    {
        $result = $this->jsonResultFactory->create();

        try {
            $notificationSource = $this->jsonHelper->jsonDecode($this->getRequest()->getContent());
            if (!$notificationSource) {
                throw new Exception(__('No content specified'));
            }
            if ($notificationSource['event'] === NotificationEventType::PAYMENT_WAITING_FOR_CAPTURE) {
                $notification = new NotificationWaitingForCapture($notificationSource);

                /** @var \YandexCheckout\Model\Payment $paymentObj */
                $paymentObj = $notification->getObject();
                $orderIncrementId = $paymentObj->getDescription();

                $order = $this->orderFactory->create()->loadByIncrementId($orderIncrementId);
                if (!$order->getId()) {
                    throw new Exception(__('Can not find order #' . $orderIncrementId));
                }

                if ($order->getState() !== Order::STATE_PAYMENT_REVIEW) {
                    return $result;
                }

                $order->getPayment()->capture();
                $this->orderRepository->save($order);
            }
        } catch(Exception $e) {
            $result->setData(['error' => $e->getMessage()]);
            $result->setHttpResponseCode(Exception::HTTP_BAD_REQUEST);
        }

        return $result;
    }
}