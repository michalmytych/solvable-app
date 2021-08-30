<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Repositories\ProblemRepository;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;

class ProblemController extends Controller
{
    public function allByUser(ProblemRepository $problemRepository): EloquentCollection
    {
        return $problemRepository->allByUserId(Auth::id());
    }
}
