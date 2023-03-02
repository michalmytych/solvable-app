<?php

namespace App\Http\Controllers\Web\Docs;

use Illuminate\View\View;
use App\Http\Controllers\Controller;

class ComponentsShowcaseController extends Controller
{
    public function showcase(): View
    {
        return view('docs.components-showcase');
    }
}
