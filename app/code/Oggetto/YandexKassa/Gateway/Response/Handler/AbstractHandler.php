<?php
namespace Oggetto\YandexKassa\Gateway\Response\Handler;

use Magento\Payment\Gateway\Response\HandlerInterface;
use Magento\Sales\Model\Order;
use Magento\Sales\Model\Service\InvoiceService;
use Magento\Framework\DB\Transaction;

class AbstractHandler implements HandlerInterface
{
    protected $invoiceService;
    protected $transaction;

    public function __construct(
        InvoiceService $invoiceService,
        Transaction $transaction
    )
    {
        $this->invoiceService = $invoiceService;
        $this->transaction = $transaction;
    }

    public function handle(array $handlingSubject, array $response) {}
}