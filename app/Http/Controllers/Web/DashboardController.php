<?php

namespace App\Http\Controllers\Web;

use Illuminate\View\View;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index(): View
    {
        return view('dashboard');
    }
}
