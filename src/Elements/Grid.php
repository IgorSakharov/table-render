<?php

namespace Src\Elements;

/**
 * Class Grid
 * @package Src\Elements
 */
class Grid implements Renderable
{
    /**
     * Width of grid element.
     * @var int
     */
    private $width;

    /**
     * Height of grid element.
     * @var int
     */
    private $height;

    /**
     * Grid element.
     * @var Renderable
     */
    private $grid;

    /**
     * Array of input elements.
     * @var array
     */
    private $cells = [1];

    /**
     * Grid constructor.
     * @param int $width
     * @param int $height
     */
    public function __construct(int $width = 3, int $height = 3)
    {
        $this->width = $width;
        $this->height = $height;
        $grid = $this->getDiv();
        $grid = $this->generateStyle($grid);
        $grid->setClass('grid');

        for ($i = 0; $i<$this->height; $i++) {
            $grid->add($this->getRow());
        }

        $this->grid = $grid;
    }

    /**
     * @param array $config
     * @throws \Exception
     */
    public function parse(array $config)
    {
        foreach ($config as $rectangle) {
            $this->addRectangle($rectangle);
        }
    }

    /**
     * Render html of grid.
     */
    public function render(): string
    {
       return $this->grid->render();
    }

    /**
     * @param array $data
     * @return Grid
     * @throws \Exception
     */
    private function addRectangle(array $data): self
    {
        ($rectangle = new Rectangle($data))
                ->setSize($this->calculateShape($rectangle))
                ->add($this->getDiv());

        $this->cells[$rectangle->position]->add($rectangle);

        return $this;
    }

    /**
     * @param int $value
     * @return Grid
     */
    public function setWidth(int $value): self
    {
        $this->width = $value;

        return $this;
    }

    /**
     * @param int $value
     * @return Grid
     */
    public function setHeight(int $value): self
    {
        $this->height = $value;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getHeight(): ?int
    {
        return $this->height;
    }

    /**
     * @return int|null
     */
    public function getWidth(): ?int
    {
        return $this->width;
    }

    /**
     * Calculating  size shape for new rectangle.
     * @param Rectangle $rectangle
     * @return array
     */
    private function calculateShape(Rectangle $rectangle)
    {
        $x = 1; $y = 1;
        $cells = $rectangle->getCells();
        $min = min($cells);
        while (in_array(++$min,$cells)){
            $x++;
        }
        $min = min($cells);
        $valueY = $min + $this->height;
        while (in_array($valueY, $cells)){
            $y++;
            $valueY = $valueY + $this->height;
        }

        return [
            "width" => $x,
            "height" => $y
        ];
    }

    /**
     * Get new row element for grid.
     * @return Element
     */
    private function getRow()
    {
        $row = $this->getDiv();
        $row->setClass('row');
        $row->setStyle('background','#0000cc');
        $row->setStyle('width', '100%');

        for ($i = 0; $i<$this->width; $i++) {
            $cell = $this->getCell();
            $this->cells[] = $cell;
            $row->add($cell);
        }

        return $row;
    }

    /**
     * Get new cell elements for row element.
     * @return Element
     */
    private function getCell()
    {
        $cell = $this->getDiv();
        $cell->setClass('cell');
        $cell->setStyle('background', '#00AB85');
        $cell->setStyle('width', '100px');
        $cell->setStyle('height', '100px');
        $cell->setStyle('float', 'left');

        return $cell;
    }

    /**
     * Get new element with tag name div.
     * @return Element
     */
    private function getDiv()
    {
        return new Element('div');
    }

    /**
     * @param \Src\Elements\Renderable $element
     * @return \Src\Elements\Renderable
     */
    private function generateStyle(Renderable $element)
    {
        $element->setStyle('width', $this->width * 100 .'px');
        $element->setStyle('height', $this->height * 100 .'px');
        $element->setStyle('border', '2px solid black');
        return $element;
    }
}