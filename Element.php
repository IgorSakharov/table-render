<?php

require_once 'Renderable.php';

class Element implements Renderable
{

    /**
     * @var array Array of internal elements.
     */
    private $content = [];

    /**
     * @var string HTML element name.
     */
    private $name = '';

    /**
     * @var string Class attribute of the element.
     */
    private $class = '';

    /**
     * @var array Style property for element
     */
    protected $styles = [];

    public function __construct(string $name)
    {
        $this->name = $name;
    }

    /**
     * Renders div content wrapped with opening and closing tags.
     */
    public function render(): void
    {
        echo "<$this->name class=\"$this->class\">";

        foreach ($this->content as $item) {
            $item->render();
        }

        echo "</$this->name>";
    }

    public function setClass(string $className)
    {
        $this->class = $className;
    }

    /**
     * @param Renderable $element Adds renderable element to the current one.
     */
    public function add(Renderable $element)
    {
        array_push($this->content, $element);
    }

    /**
     * @param string $property Set new style property for element
     * @param string $value
     */
    public function setStyle(string $property, string $value, string $element)
    {
        $this->styles[$element][$property] = $value;
    }
}