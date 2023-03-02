<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;

class RootController extends Controller
{
    public function index(): RedirectResponse
    {
        return redirect()->to(route('dashboard'));
    }
}
