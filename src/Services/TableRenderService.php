<?php

namespace Src\Services;

use Src\Elements\Grid;
use Vendor\Request\Request;

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
                'color' => 'FF0000',
                'background-color' => '0000FF'
            ],
            [
                'text' => 'Текст зеленого цвета',
                'cells' => '8,9',
                'text-align' => 'right',
                'vertical-align' => 'bottom',
                'color' => '00FF00',
                'background-color' => 'FFFFFF'
            ],
            [
                'text' => 'Текст зеленого цвета',
                'cells' => '3,6',
                'text-align' => 'center',
                'vertical-align' => 'middle',
                'color' => '00FF00',
                'background-color' => 'black'
            ]
        ];

        $grid = new Grid();
        $grid->parse($data);

        return $grid->render();
    }
}
