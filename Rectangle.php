<?php
require_once 'Element.php';


class Rectangle extends Element implements Renderable
{
    /**
     * @var string Name class HTML element.
     */
    private $class = 'rectangle';

    /**
     * @var string Text for show in element.
     */
    private $text = '';

    /**
     * @var int Position rectangle in grid.
     */
    public $position = 1;

    /**
     * @var array rectangle's cells
     */
    private
        $cells = [];
    /**
     * @var data attribute for rectangle element
     */
    private $data = '';

    public function __construct(array $data)
    {
        parent::__construct('div');
        if ($data['text']){
            $this->text = $data['text'];
            unset($data['text']);
        }
        if (!$data['cells']){
            throw new Exception('missing required parameter cells');
        }
        $this->setStyle('position', 'absolute', 'div');
        $this->setStyle('display', 'table', 'div');
        $this->setStyle('display', 'table-cell', 'text');
        $this->cells = explode(',', $data["cells"]);
        $this->position = min($this->cells);
        unset($data["cells"]);
        $this->setStyle('vertical-align', $data['vertical-align'], 'text');
        unset($data['vertical-align']);
        foreach ($data as $item => $value){
            $this->setStyle($item, $value, 'div');
        }
    }

    public function render(): void
    {
        $styleRectangle = $this->renderStyle('div');
        $styleText = $this->renderStyle('text');
     echo "<div class=\"$this->class\" style=\"$styleRectangle\">";
        echo "<div style='$styleText'>".$this->text."</div>";
     echo "</div>";
    }

    public function setSize(array $size)
    {
        foreach ($size as $item => $value){
            $this->setStyle($item , $value * 100 , 'div');
        }
    }

    private function renderStyle(string $element)
    {
        $styles = '';

        foreach ($this->styles[$element] as $style=>$value){
            $styles .= " $style: $value; ";
        }
        return $styles;
    }

    public function getClass()
    {
        return $this->class;
    }

    public function setDataSize($data)
    {
        $this->data = $data;
    }

    public function setText(string $text)
    {
        $this->text = $text;
    }

    public function setPosition(int $value)
    {
        $this->position = $value;
    }

    public function getCells()
    {
        return $this->cells;
    }

}
