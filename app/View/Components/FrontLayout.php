<?php

namespace App\View\Components;

use App\Models\Category;
use Illuminate\Support\Collection;
use Illuminate\View\Component;

class FrontLayout extends Component
{

    public $title;

    public $categories;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($title = null)
    {
        $this->title = $title ?? config('app.name');
        $this->categories = $this->loadCategories();
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('layouts.front');
    }

    protected function loadCategories(): Collection
    {
        try {
            return Category::query()->withCount('products')->get();
        } catch (\Throwable $e) {
            return collect();
        }
    }
}
