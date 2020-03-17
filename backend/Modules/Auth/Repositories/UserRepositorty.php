<?php

namespace Modules\Auth\Repositories;

use Modules\Auth\Repositories\Interfaces\UserRepositoryInterface;
use Modules\Auth\Entities\User as UserModel;
use Modules\Auth\Models\User;


class UserRepository implements UserRepositoryInterface
{
    private $userEloquentModel = UserModel::class;

    public function createNewUser(User $user)
    {
        $newUser = $this->userEloquentModel;

        $newUser->name = $user->getName();
        $newUser->email = $user->getEmail();
        $newUser->password = $user->getPassword();

        return $newUser->save();
    }

    public function updateUserById(User $user, $id)
    {
        $newUser = $this->userEloquentModel->newQuery()->find($id);

        $newUser->name = $user->getName();
        $newUser->email = $user->getEmail();
        $newUser->password = bcrypt($user->getPassword());

        return $newUser->save();
    }
}
