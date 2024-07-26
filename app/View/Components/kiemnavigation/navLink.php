<?php

namespace App\View\Components\kiemnavigation;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class navLink extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(public string $route, public string $label, public bool $active = false)
    {
    
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.kiemnavigation.nav-link');
    }
}
