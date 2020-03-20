<?php

namespace Modules\Auth\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Modules\Auth\Services\AuthService;


class AuthController extends Controller
{
    private $authService;

    public function __construct(AuthService $authService)
	{
		$this->authService = $authService;
	}

    public function loginUser(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|min:6',
            'remember_me' => 'boolean'
        ]);

        $response = $this->authService->loginUser($request);

        return response()->json($response);
    }

    public function registerUser(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|min:6|confirmed',
        ]);

        $this->authService->registerUser($request->all());

        return response()->json([
            'message' => 'Account successfully created!'
        ], 201);
    }
}
