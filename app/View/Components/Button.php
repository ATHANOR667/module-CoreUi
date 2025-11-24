<?php

namespace Modules\CoreUI\View\Components;

use Illuminate\View\Component;

class Button extends Component
{
    public string $variant;
    public string $size;

    protected array $variants = [
        'primary'   => 'bg-primary text-white hover:bg-primary-hover shadow-sm',
        'secondary' => 'bg-white text-slate-700 border border-slate-300 hover:bg-slate-50 shadow-sm',
        'danger'    => 'bg-danger text-white hover:bg-red-600 shadow-sm',
        'ghost'     => 'text-slate-600 hover:bg-slate-100',
    ];

    protected array $sizes = [
        'sm' => 'px-3 py-1.5 text-xs',
        'md' => 'px-4 py-2 text-sm',
        'lg' => 'px-6 py-3 text-base',
    ];

    public function __construct($variant = 'primary', $size = 'md')
    {
        $this->variant = $variant;
        $this->size = $size;
    }

    public function render(): \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\Support\Htmlable|\Closure|string
    {
        return view('coreui::components.button');
    }

    public function classes(): string
    {
        $variantClass = $this->variants[$this->variant] ?? $this->variants['primary'];
        $sizeClass = $this->sizes[$this->size] ?? $this->sizes['md'];

        return "inline-flex items-center justify-center font-medium rounded-lg transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary {$variantClass} {$sizeClass}";
    }
}
