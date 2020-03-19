<?php

namespace Modules\Entity\Repositories;

use Modules\Entity\Entities\User;


class UserRepository
{
    private $userModel;

	public function __construct(User $model)
	{
		$this->userModel = $model;
	}

    public function findUser($id)
    {
        $user = $this->userModel->find($id);
        
        return $this->convertFormat($user);
    }

    public function findAllUsers()
    {
        $users = $this->userModel->all();
        
        return $this->convertFormat($users);
    }

    public function createUser(array $data)
    {
        $newUser = $this->userModel->create($data);
        
        return $this->convertFormat($newUser);
    }

    public function firstOrCreateUser(array $data)
    {
        $user = $this->userModel->firstOrCreate($data);

        return $this->convertFormat($user);
    }

    public function updateUser(array $data, $id)
    {
        $user = $this->userModel->find($id);
        $user->update($data);
        
        return $this->convertFormat($user);
    }

    public function deleteUser($id)
    {
        return $this->userModel->find($id)->delete();
    }

    protected function convertFormat($data)
    {
        return $data ? (object) $data->toArray() : null;
    }
}