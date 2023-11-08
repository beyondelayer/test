<?php

namespace App\Repositories\User;

use App\Models\User;
use App\Repositories\Contracts\UserRepositoryInterface;

class UserRepository implements UserRepositoryInterface
{

    protected function __construct
    (protected User $user)
    {}

    public function getAll()
    {
        return $this->user->all();
    }

    public function findOrFail($id)
    {

    }

    public function create(array $data)
    {

    }

    public function updateOrFail($id, array $data)
    {

    }

    public function delete($id)
    {

    }
}
