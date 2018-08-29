<?php

require_once 'Renderable.php';

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

    public function __construct(string $name)
    {
        $this->name = $name;
    }

    /**
     * Renders div content wrapped with opening and closing tags.
     */
    public function render(): void
    {
        $styles = $this->renderStyle();
        echo "<$this->name class=\"$this->class\" style=\"$styles\">";

        foreach ($this->content as $item) {
            $item->render();
        }
        echo $this->text;

        echo "</$this->name>";
    }

    /**
     * Set class name for element.
     * @param string $className
     */
    public function setClass(string $className)
    {
        $this->class = $className;
    }

    /**
     * Convert style for element to string from $this->styles.
     * @return string
     */
    protected function renderStyle()
    {
        $styles = '';
        foreach ($this->styles as $style=>$value){
            $styles .= " $style: $value; ";
        }
        return $styles;
    }

    /**
     * Adds renderable element to the current one.
     * @param Renderable $element
     */
    public function add(Renderable $element)
    {
        array_push($this->content, $element);
    }

    /**
     * Set text which be input inside element.
     * @param string $text
     */
    public function setText(string $text)
    {
        $this->text = $text;
    }

    /**
     * Add style to element.
     * @param string $property
     * @param string $value
     */
    public function setStyle(string $property, string $value)
    {
        $this->styles[$property] = $value;
    }
}