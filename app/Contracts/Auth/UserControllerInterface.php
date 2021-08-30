<?php


namespace App\Contracts\Auth;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Requests\Api\Auth\LoginRequest;
use App\Http\Requests\Api\Auth\RegisterRequest;

interface UserControllerInterface
{
    public function register(RegisterRequest $request): Response;

    public function login(LoginRequest $request): Response;

    public function logout(Request $request): Response;
}
