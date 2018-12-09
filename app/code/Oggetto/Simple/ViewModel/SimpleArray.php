
<?php
namespace Oggetto\Simple\ViewModel;

use Magento\Framework\View\Element\Block\ArgumentInterface;

class SimpleArray implements ArgumentInterface
{
    public function getArray(): array
    {
        return [
            'foo' => 'Value 1',
            'bar' => 'Value 2',
            'baz' => 'Value 3'
        ];
    }
}