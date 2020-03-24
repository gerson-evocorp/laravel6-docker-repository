<?php

namespace Modules\Entity\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Entity\Services\UserService;


class EntityController extends Controller
{
    private $userService;

    public function __construct(UserService $userService)
	{
		$this->userService = $userService;
	}

    public function registerUser(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|min:6|confirmed',
        ]);

        $this->userService->createUser($request->all());

        return response()->json([
            'message' => 'Account successfully created!'
        ], 201);
    }

    public function registerAdmin(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|min:6|confirmed',
        ]);

        $this->userService->createUser($request->all());

        return response()->json([
            'message' => 'Account successfully created!'
        ], 201);
    }
}
