<?php

namespace App\View\Components\kiemnavigation;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class navigation extends Component
{
    public function __construct()
    {
        //
    }

    /**
     * Geeft de view/inhoud weer van de navigation component.
     */
    public function render(): View|Closure|string
    {
        return view('components.kiemnavigation.navigation');
    }
}
