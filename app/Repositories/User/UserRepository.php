<?php

namespace App\Repositories\User;

use App\Repositories\BaseRepository;
use App\Models\User;

class UserRepository extends BaseRepository implements UserRepositoryInterface
{
    public function getModel()
    {
        return User::class;
    }

    // public function getUser()
    // {
        
    // }

    // public function getUserByEmail($email)
    // {
    //     return $this->model->where('email', $email)->first();
    // }

}
