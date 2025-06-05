<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;

class MetronicLayout extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public bool $blank = false
    ) {
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View
    {
        return view('metronic.layout', [
            'blank' => $this->blank,
        ]);
    }
}
