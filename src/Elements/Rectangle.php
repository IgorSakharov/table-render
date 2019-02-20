<?php

namespace Src\Elements;

/**
 * Class Rectangle
 * @package Src\Elements
 */
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

    /**
     * Rectangle constructor.
     * @param array $data
     * @throws \Exception
     */
    public function __construct(array $data)
    {
        if (!$data['cells']) {
            throw new \Exception('missing required parameter cells');
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
    public function render(): string
    {
        $result = '';
        $style = $this->renderStyle();
        $result .= "<div class=\"$this->class\" style=\"$style\">";
        foreach ($this->content as $item) {
            $result .= $item->render();
        }

        $result .= "</div>";

        return $result;
    }

    /**
     * Generate styles for rectangle.
     * @param array $data
     */
    private function generateStyles(array $data): void
    {
        $this->setStyle('position', 'absolute');
        $this->setStyle('display', 'table');
        foreach ($data as $item => $value) {
            $this->setStyle($item, $value);
        }
    }

    /**
     * @param array $size
     * @return Rectangle
     */
    public function setSize(array $size): self
    {
        foreach ($size as $item => $value) {
            $this->setStyle($item, $value * 100, 'div');
        }

        return $this;
    }

    /**
     * @return array|null
     */
    public function getCells(): ?array
    {
        return $this->cells;
    }

    /**
     * @param string $text
     * @return Renderable
     */
    private function getTextElement(string $text): Renderable
    {
        return (new Element('div'))
            ->setClass('text')
            ->setText($text);
    }

    /**
     * @param string $cells
     * @return array
     */
    private function getCellsNumber(string $cells): array
    {
        return explode(',', $cells);
    }

    /**
     * @param Renderable $element
     * @param array $data
     * @return Renderable
     */
    private function setStyleForElement(Renderable $element, array $data): Renderable
    {
        return $element
            ->setStyle('display', 'table-cell')
            ->setStyle('vertical-align', $data['vertical-align']);
    }

    /**
     * Get number of cell where will by create rectangle element.
     * @param array $data
     * @return int
     */
    private function getPositionForRectangle(array $data): int
    {
        return min($data);
    }
}
