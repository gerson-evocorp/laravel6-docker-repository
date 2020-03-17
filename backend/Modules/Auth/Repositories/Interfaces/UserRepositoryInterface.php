<?php

namespace Modules\Auth\Repositories\Interfaces;

use Modules\Auth\Entities\User as UserModel;
use Modules\Auth\Models\User;


interface UserRepositoryInterface{

  public function __construct(UserModel $userModel);
  public function createNewUser(User $user);
  public function updateUserById(User $user, $id);
}