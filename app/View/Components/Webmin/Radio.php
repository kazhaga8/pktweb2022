<?php

namespace App\View\Components\Webmin;

use Illuminate\View\Component;

class Radio extends Component
{
    public $name;
    public $value;
    public $required;
    public $items;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(
        $name,
        $value,
        $required="",
        $items
    ){
        $this->name = $name;
        $this->value = $value;
        $this->required = $required;
        $this->items = $items;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.webmin.radio');
    }
}
