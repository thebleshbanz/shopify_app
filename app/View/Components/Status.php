<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Status extends Component
{
    /**
     * The status type.
     *
     * @var string
     */
    public $type;

    /**
     * The status number.
     *
     * @var string
     */
    public $number;

    /**
     * The status title.
     *
     * @var string
     */
    public $title;

    /**
     * The status growth.
     *
     * @var string
     */
    public $growth;

    /**
     * Create the component instance.
     *
     * @param  string  $type
     * @param  string  $number
     * @param  string  $title
     * @param  string  $growth
     * @return void
     */
    public function __construct($type, $number, $title, $growth)
    {
        $this->type     = $type;
        $this->number   = $number;
        $this->title    = $title;
        $this->growth   = $growth;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.status');
    }
}
