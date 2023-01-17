<?php

namespace App\View\Components\Webmin;

use Illuminate\View\Component;

class Textarea extends Component
{
    public $type;
    public $name;
    public $value;
    public $required;
    public $disabled;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(
        $name,
        $value,
        $required="",
        $disabled=""
    ){
        $this->name = $name;
        $this->value = $value;
        $this->required = $required;
        $this->disabled = $disabled;

    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.webmin.textarea');
    }
}
