<?php

namespace Modules\Auth\Services;

use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Modules\Entity\Services\UserService;
// use Modules\Entity\Repositories\UserRepository;


class AuthService
{
    private $userService;

	public function __construct(UserService $userService)
	{
		$this->userService = $userService;
	}
	
	public function loginUser($request)
	{
		$credentials = request(['email', 'password']);
        // $user = $this->userService->findUserByEmailAndPassword();
        if (!Auth::attempt($credentials))
            return response()->json([
                'message' => 'invalid_credentials',
            ], 401);

        $user = $request->user();

        $tokenResult = $user->createToken('Web-Cliente');
        $token = $tokenResult->token;

        if ($request->remember_me)
            $token->expires_at = Carbon::now()->addWeeks(1);

		$token->save();
		
		return [
            'access_token' => $tokenResult->accessToken,
            'token_type' => 'Bearer',
            'expires_at' => Carbon::parse($tokenResult->token->expires_at)->toDateTimeString(),
            'user' => $user,
        ];
	}

	public function registerUser($data)
	{
		return $this->userService->createUser($data);
    }
    

}