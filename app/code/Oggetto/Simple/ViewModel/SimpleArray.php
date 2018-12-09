
<?php
namespace Oggetto\Simple\ViewModel;

use Magento\Framework\View\Element\Block\ArgumentInterface;
use Magento\Framework\Serialize\Serializer\Json;

class SimpleArray implements ArgumentInterface
{
    private $json;

    public function __construct(Json $json)
    {
        $this->json = $json;
    }

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

    public function getJson()
    {
        $result = [];
        foreach ($this->getArray() as $key => $data) {
            $result[] = [
                'value' => $key,
                'label' => $data['label'],
                'color' => $data['color']
            ];
        }

        return $this->json->serialize($result);
    }
}