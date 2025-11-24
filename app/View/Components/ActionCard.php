<?php

namespace Modules\CoreUI\View\Components;

use Illuminate\View\Component;

class ActionCard extends Component
{
    public string $url;
    public string $title;
    public ?string $description;

    public function __construct($url, $title, $description = null)
    {
        $this->url = $url;
        $this->title = $title;
        $this->description = $description;
    }

    public function render(): \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\Support\Htmlable|\Closure|string
    {
        return view('coreui::components.action-card');
    }
}
