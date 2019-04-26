<?php

namespace Src\Services;

use Src\Elements\Grid;

/**
 * Class TableRenderService
 * @package Src\Services
 */
class TableRenderService extends BaseService
{
    /**
     * @var array
     */
    protected $rectangleConfig = [];

    /**
     * @return string
     * @throws \Exception
     */
    public function createNewTable()
    {
        $data = [
            [
                'text' => 'Текст зеленого цвета',
                'cells' => '1,2,4,5',
                'text-align' => 'center',
                'vertical-align' => 'middle',
                'color' => 'red',
                'background-color' => 'blue'
            ],
            [
                'text' => 'Текст зеленого цвета',
                'cells' => '8,9',
                'text-align' => 'right',
                'vertical-align' => 'bottom',
                'color' => 'green',
                'background-color' => 'yellow'
            ],
            [
                'text' => 'Текст зеленого цвета',
                'cells' => '3,6',
                'text-align' => 'center',
                'vertical-align' => 'middle',
                'color' => 'yellow',
                'background-color' => 'white'
            ]
        ];

        $grid = new Grid();
        $grid->parse($data);

        return $grid->render();
    }
}
