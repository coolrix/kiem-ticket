<?php

namespace App\View\Components\kiemnavigation;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class navLink extends Component
{
    public function __construct(public string $route, public string $label, public bool $active = false)
    {
    
    }

    /**
     * Geeft de view/inhoud weer van de navigatie link component.
     */
    public function render(): View|Closure|string
    {
        return view('components.kiemnavigation.nav-link');
    }
}
