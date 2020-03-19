<?php

namespace Modules\Entity\Services;

use Modules\Entity\Repositories\UserRepository;
use Illuminate\Support\Facades\Hash;


class UserService
{
    private $userRepository;

	public function __construct(UserRepository $repository)
	{
		$this->userRepository = $repository;
	}

    public function createUser($data)
    {
        return $this->userRepository->createUser(
            [
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => Hash::make($data['password'])
            ]
        ); 
    }

    public function update($request)
    {
        // validation code

        // business rule
        return null;
    }

    public function delete($request)
    {
        // validation code

        // business rule
        return null;
    }
}