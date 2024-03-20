<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Advert extends Component
{
    public $advert;
    /**
     * Create a new component instance.
     */
    public function __construct($advert)
    {
        $this->advert = $advert;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.advert');
    }
}
