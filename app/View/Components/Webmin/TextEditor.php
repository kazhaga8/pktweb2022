<?php

namespace App\View\Components\Webmin;

use Illuminate\View\Component;

class TextEditor extends Component
{
    public $name;
    public $value;
    public $label;
    public $required;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(
        $name,
        $value,
        $label="",
        $required=""
    ){
        $this->name = $name;
        $this->value = $value;
        $this->label = $label;
        $this->required = $required;

    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.webmin.texteditor');
    }
}
