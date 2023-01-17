<?php

namespace App\View\Components\Webmin;

use Illuminate\View\Component;

class InputFile extends Component
{
    public $dragndrop;
    public $name;
    public $value;
    public $required;
    public $disabled;
    public $multiple;
    public $allowext;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(
        $dragndrop=false,
        $name,
        $value,
        $required="",
        $disabled="false",
        $multiple=false,
        $allowext=[]
    ){
        $this->dragndrop = $dragndrop;
        $this->name = $name;
        $this->value = $value;
        $this->required = $required;
        $this->disabled = $disabled;
        $this->multiple = $multiple;
        $this->allowext = $allowext;

    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.webmin.input-file');
    }
}
