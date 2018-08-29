<?php
require_once 'Rectangle.php';
require_once 'Renderable.php';
require_once 'Element.php';

class Grid implements Renderable
{

    private $m = 1;

    private $n = 1;

    private $grid;

    private $cells = [1];

    public function __construct(int $m, int $n)
    {
        $this->m = $m;
        $this->n = $n;
        $grid = $this->getDiv();
        $grid->setClass('grid');

        for ($i = 0; $i<$this->n; $i++) {
            $grid->add($this->getRow());
        }

        $this->grid = $grid;
    }

    public function parse(array $config)
    {
        foreach ($config as $rectangle) {
            $this->addRectangle($rectangle);
        }
    }

    public function render(): void
    {
        $this->grid->render();
    }

    private function addRectangle(array $data)
    {
        try{
        $rectangle = new Rectangle($data);
        } catch (Exception $e){
            echo $e->getMessage();
            var_dump($data);
            return;
        }
        $rectangle->setSize($this->calculateShape($rectangle));

        $this->cells[$rectangle->position]->add($rectangle);
    }


    private function calculateShape(Rectangle $rectangle)
    {
        $x = 1; $y = 1;
        $cells = $rectangle->getCells();
        $min = min($cells);
        while (in_array(++$min,$cells)){
            $x++;
        }
        $min = min($cells);
        $valueY = $min + $this->n;
        while (in_array($valueY, $cells)){
            $y++;
            $valueY = $valueY + $this->n;
        }

        return [
            "width" => $x,
            "height" => $y
        ];
    }

    private function getRow()
    {
        $row = $this->getDiv();
        $row->setClass('row');

        for ($i = 0; $i<$this->m; $i++) {
            $cell = $this->getCell();
            $this->cells[] = $cell;
            $row->add($cell);
        }

        return $row;
    }

    private function getCell()
    {
        $cell = $this->getDiv();
        $cell->setClass('cell');

        return $cell;
    }

    private function getDiv()
    {
        return new Element('div');
    }
}