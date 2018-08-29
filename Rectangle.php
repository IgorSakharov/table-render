<?php
require_once 'Element.php';


class Rectangle extends Element implements Renderable
{
    /**
     * Name class HTML element.
     * @var string
     */
    private $class = 'rectangle';

    /**
     * Position rectangle in grid.
     * @var int
     */
    public $position = 1;

    /**
     * Rectangle's cells.
     * @var array
     */
    private
        $cells = [];

    /**
     * Array of elements.
     * @var array
     */
    private $content = [];

    public function __construct(array $data)
    {
        if (!$data['cells']){
            throw new Exception('missing required parameter cells');
        }
        parent::__construct('div');
        $textNode = $this->getTextElement($data['text']);
        $this->content[] = $this->setStyleForElement($textNode, $data);
        $this->cells = $this->getCellsNumber($data['cells']);
        $this->position = $this->getPositionForRectangle($this->cells);
        unset($data['text']);
        unset($data['vertical-align']);
        unset($data["cells"]);
        $this->generateStyles($data);
    }

    /**
     * Function return a rectangle html.
     */
    public function render(): void
    {
        $style = $this->renderStyle();
     echo "<div class=\"$this->class\" style=\"$style\">";
        foreach ($this->content as $item){
            $item->render();
        }
     echo "</div>";
    }

    /**
     * Generate styles for rectangle.
     * @param array $data
     */
    private function generateStyles(array $data) : void
    {
        $this->setStyle('position', 'absolute');
        $this->setStyle('display', 'table');
        foreach ($data as $item => $value){
            $this->setStyle($item, $value);
        }
    }

    /**
     * Function create new style which defined size of rectangle.
     * @param array $size
     */
    public function setSize(array $size) : void
    {
        foreach ($size as $item => $value){
            $this->setStyle($item , $value * 100 , 'div');
        }
    }

    /**
     * Array with cells for rectangle.
     * @return array
     */
    public function getCells()
    {
        return $this->cells;
    }

    /**
     * Get new element with defined text and class name
     * @param string $text
     * @return Renderable
     */
    private function getTextElement(string $text) : Renderable
    {
        $element = new Element('div');
        $element->setClass('text');
        $element->setText($text);
        return $element;
    }

    /**
     * Method create array which will occupy by rectangle.
     * @param string $cells
     * @return array
     */
    private function getCellsNumber(string $cells) : array
    {
        return  explode(',', $cells);
    }

    /**
     * Set spatial style for element to correct show text.
     * @param Renderable $element
     * @param array $data
     * @return Renderable
     */
    private function setStyleForElement(Renderable $element, array $data) : Renderable
    {
        $element->setStyle('display', 'table-cell');
        $element->setStyle('vertical-align', $data['vertical-align']);
        return $element;
    }

    /**
     * Get number of cell where will by create rectangle element.
     * @param array $data
     * @return int
     */
    private function getPositionForRectangle(array $data) : int
    {
        return min($data);
    }
}
