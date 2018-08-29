<html>
<header>
</header>

<body>
<?php

include_once 'Grid.php';
$data = [
        [
            'text' => 'Текст красного цвета',
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
$grid = new Grid(3,3);
$grid->parse($data);
$grid->render();
?>
<style type="text/css"  >
    .grid{
        border: 2px solid black;
        width: 300px;
        height: 300px;
    }
    .row{
        background: #0000cc;
        width: 100%;
    }
    .cell{
        background: #00AB85;
        width: 100px;
        height: 100px;
        float: left;
    }
</style>
</body>
</html>
