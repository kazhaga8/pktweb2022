<?php

namespace App\View\Components\Webmin;

use Illuminate\View\Component;

class Select2 extends Component
{
    public $name;
    public $value;
    public $label;
    public $placeholder;
    public $required;
    public $multiple;
    public $items;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(
        $name,
        $value,
        $label="",
        $placeholder="",
        $required="",
        $multiple="",
        $items
    ){
        $this->name = $name;
        $this->label = $label;
        $this->value = $value;
        $this->placeholder = $placeholder;
        $this->required = $required;
        $this->multiple = $multiple;
        $this->items = $items;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.webmin.select2');
    }
}
