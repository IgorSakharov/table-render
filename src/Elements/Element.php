<?php

namespace Src\Elements;

/**
 * Class Element
 * @package Src\Elements
 */
class Element implements Renderable
{
    /**
     * Array of internal elements.
     * @var array
     */
    private $content = [];

    /**
     * HTML element name.
     * @var string
     */
    private $name = '';

    /**
     * Class attribute of the element.
     * @var string
     */
    private $class = '';

    /**
     * Style property for element.
     * @var array
     */
    protected $styles = [];

    /**
     * Text to show in element.
     * @var string
     */
    protected $text = '';

    /**
     * Element constructor.
     * @param string $name
     */
    public function __construct(string $name)
    {
        $this->name = $name;
    }

    /**
     * Renders div content wrapped with opening and closing tags.
     */
    public function render(): string
    {
        $result = '';
        $styles = $this->renderStyle();
        $result .= "<$this->name class=\"$this->class\" style=\"$styles\">";

        foreach ($this->content as $item) {
            $result .= $item->render();
        }
        $result .= $this->text;

        $result .= "</$this->name>";

        return $result;
    }

    /**
     * @param string $className
     * @return Element
     */
    public function setClass(string $className): self
    {
        $this->class = $className;

        return $this;
    }

    /**
     * @return string
     */
    protected function renderStyle(): string
    {
        $styles = '';
        foreach ($this->styles as $style=>$value){
            $styles .= " $style: $value; ";
        }

        return $styles;
    }

    /**
     * @param Renderable $element
     * @return Element
     */
    public function add(Renderable $element): self
    {
        array_push($this->content, $element);

        return $this;
    }

    /**
     * @param string $text
     * @return $this
     */
    public function setText(string $text): self
    {
        $this->text = $text;

        return $this;
    }

    /**
     * @param string $property
     * @param string $value
     * @return Element
     */
    public function setStyle(string $property, string $value)
    {
        $this->styles[$property] = $value;

        return $this;
    }
}