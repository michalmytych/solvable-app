<?php

namespace App\Repositories;

use App\Models\Problem;

class ProblemRepository
{
    public function allByUserId(string $id)
    {
        return Problem::where('user_id', $id);
    }
}
