
<?php
namespace Oggetto\Simple\ViewModel;

use Magento\Framework\View\Element\Block\ArgumentInterface;

class SimpleArray implements ArgumentInterface
{
    public function getArray(): array
    {
        return [
            'foo' => [
                'label' => 'Value 1',
                'color' => '#FF0000'
            ],
            'bar' => [
                'label' => 'Value 2',
                'color' => '#00FF00'
            ],
            'baz' => [
                'label' => 'Value 3',
                'color' => '#0000FF'
            ],
        ];
    }
}