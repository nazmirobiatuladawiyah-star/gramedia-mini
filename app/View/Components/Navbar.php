<?php

namespace App\View\Components;

use App\Models\BookCategory;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\Component;

class Navbar extends Component
{
    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        $isAdmin = Auth::check() && Auth::user()->role === 'admin';
        $categories = $isAdmin
            ? collect()
            : BookCategory::query()->orderBy('name')->get(['id', 'name']);

        return view('components.navbar', compact('categories'));
    }
}
