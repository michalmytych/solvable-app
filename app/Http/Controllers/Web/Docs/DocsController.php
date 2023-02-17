<?php

namespace App\Http\Controllers\Web\Docs;

use Illuminate\View\View;
use App\Http\Controllers\Controller;

class DocsController extends Controller
{
    public function index(): View
    {
        return view('docs.index');
    }
}
